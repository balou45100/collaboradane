<?php
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	error_reporting(0);
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$origine="tb";
	$_SESSION['origine']=$origine;
	$_SESSION['origine1']=$origine;
	$vue = $_GET['vue'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_images_theme = $_SESSION['chemin_images_theme'];
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	//echo "<br />tb_prets.php - vue : $vue<br />";
?>

<!DOCTYPE HTML>
  
<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
				echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
				exit;
			}
			else
			{
				enreg_utilisation_module("TBPR");
			}
		?>
		</head>
		<body>
		<?php
		if ($vue <> "tb")
		{
			// On inclut le fichier pour afficher le tableau de s&eacute;lection des tickets, alertes etc...
			include ("tb_inc.php");
		}
		//on initialise le timestamp pour la date du jour
		$date_auj = mktime();

		//$nb_pb=0;
		
		//On r&eacute;cup&egrave;re les r&eacute;glages pour les prêts
		$req_pret="SELECT nb_j_pret, nb_j_pret_av FROM preference where id_util = $id";
		$exe_pret=mysql_query($req_pret);
		while($recup_pret = mysql_fetch_row ($exe_pret))
		{
			$nb_j_p = $recup_pret[0];
			$nb_j_p_av= $recup_pret[1];
		}
		
		//echo "<br />nb_j_p : $nb_j_p - nb_j_p_av : $nb_j_p_av";

		//On transforme le nombre de jours en nombre de secondes
		$avant = ($nb_j_p_av + 1) * 86400;
		$apres = ($nb_j_p +1) * 86400;
		
		//on calcule les deux timestamp pour le filtre
		$avant = $date_auj - $avant;
		$apres = $date_auj + $apres;

		/*
		$avant_d = date("D d M Y",$avant);
		$apres_d = date("D d M Y",$apres);
		echo "<br />avant : $avant_d";
		echo "<br />apr&egrave;s : $apres_d<br />";
		*/

		$query4="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, date_affectation, date_retour, materiels.id_etat, intitule_etat 
		FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats 
		WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ 
		AND materiels.affectation_materiel=materiels_affectations.id_affectation 
		AND materiels_etats.id_etat = materiels.id_etat 
		AND date_retour IS NOT NULL
		AND UNIX_TIMESTAMP(date_retour) > $avant 
		AND UNIX_TIMESTAMP(date_retour) < $apres 
		AND materiels.id_etat IN ('6','7','8')
		AND type_affectation = 'ponctuelle'
		ORDER BY date_retour;";
		$execution4=mysql_query($query4);
		$nb_prets = mysql_num_rows($execution4);
		
		//echo "<br />nbr d'enregistrements : $nb_prets";
		
		// S'il y en a 1 minimum
		if($nb_prets >= "1")
		{
			if ($vue == "tb")
			{
				// Affichage d'un message diff&eacute;rent s'il y a une ou plusieurs alertes...
				if($nb_prets == 1)
				{
					echo "Votre pr&ecirc;t de J-$nb_j_p_av &agrave; J+$nb_j_p&nbsp &nbsp";
				}
				else
				{
					echo "Vos $nb_prets pr&ecirc;ts de J-$nb_j_p_av &agrave; J+$nb_j_p&nbsp &nbsp";
				}
			
				//On affiche le bouton pour afficher la liste en plein &eacute;cran
				echo"<a href= tb_pret_cadre.php target =_top><input type=submit value='Voir en plein &eacute;cran'></a><br /><br />";
			}
			else
			{
				if ($nb_prets == 1)
				{
					echo "<center><b>Votre pr&ecirc;t de J-$nb_j_p_av &agrave; J+$nb_j_p</b></center><br />";
				}
				else
				{
					echo "<b><center>Vos $nb_prets pr&ecirc;ts de J-$nb_j_p_av &agrave; J+$nb_j_p</b></center><br />";
				}
				
			}
			echo "<div align = \"center\">";
			//On affiche le tableau
			//echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Id</center></td><td><center>Nom</center></td><td><center>Cat&eacute;gorie</center></td><td><center>Affect&eacute;</center></td><td><center>&Agrave; rendre (depuis) le</center></td><td><center>Infos</center></td></tr>";
			echo "<table>";
				echo "<tr>";
					echo "<th>Id</th>";
					echo "<th>Nom</th>";
					echo "<th>Cat&eacute;gorie</th>";
					echo "<th>Affect&eacute;</th>";
					echo "<th>&Agrave; rendre (depuis) le</th>";
					echo "<th>Infos</th>";
				echo "</tr>";
			while($results4 = mysql_fetch_row($execution4))
			{	
				list($annee1, $mois1, $jour1)= explode ("-",$results4[5]);
				$date_enreg = mktime(0,0,0,$mois1,$jour1,$annee1);
				/*
				$date_clair = date("D d M Y",$date_enreg);
				//echo "<br />annee : $annee1 - mois : $mois1 - jour : $jour1";
				//echo "<br />date_extraite : $results2[3] - date_enreg : $date_enreg - date_clair : $date_clair - date_auj : $date_auj";
				*/
				//On formate la date d'&eacute;ch&eacute;ance pour l'affichage
				$date_echeance=$jour1."/".$mois1."/".$annee1;

			
				//On affiche les diff&eacute;rentes enregistrements
				//On change de fond si la tâches est ant&eacute;rieure &agrave; la date du jour
				if ($date_enreg < $date_auj)
				{
					//echo "<br />avant";
					//echo "<tr bgcolor=$bg_color3><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
					//echo "<tr bgcolor=$bg_color3><td><center>$results4[0]</center></td><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$date_echeance</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
					echo "<tr class = \"avant_date\">";
						echo "<td align = \"center\">$results4[0]</td>";
						echo "<td align = \"center\">$results4[1]</td>";
						echo "<td align = \"center\">$results4[2]</td>";
						echo "<td align = \"center\">$results4[3]</td>";
						echo "<td align = \"center\">$date_echeance</td>";
						echo "<td class = \"fond-actions\" align = \"center\"><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></td>";
					echo "</tr>";
				}
				else
				{
					//echo "<br />apr&egrave;s";
					//echo "<tr bgcolor=$bg_color2><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
					//echo "<tr bgcolor=$bg_color2><td><center>$results4[0]</center></td><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$date_echeance</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
					echo "<tr>";
						echo "<td align = \"center\">$results4[0]</td>";
						echo "<td align = \"center\">$results4[1]</td>";
						echo "<td align = \"center\">$results4[2]</td>";
						echo "<td align = \"center\">$results4[3]</td>";
						echo "<td align = \"center\">$date_echeance</td>";
						echo "<td class = \"fond-actions\" align = \"center\"><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></td>";
					echo "</tr>";
				}
			
			/*
				list($annee3, $mois3, $jour3) = explode("-", $results4[5]);
				$auj=time();
				$date3=mktime(0,0,0,$mois3,$jour3,$annee3);
				$inter1=$date3-$auj;
				if ($echeance1 == "moins" and $inter1 <= (86400*$nb_j_p) and $inter1 >= 0)
				{
				$nb_pb ++;
				}
				else
				{
					if ($echeance1 == "retard" and $inter1 >= (-86400*$nb_j_p) and $inter1 <= 0)
					{
						$nb_pb ++ ;
					}
				}
			*/}
			
		}

/*
		if ($nb_pb > 0)
		{
		$query4="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, date_affectation, date_retour, materiels.id_etat, intitule_etat
		FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats
		WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ
		AND materiels.affectation_materiel=materiels_affectations.id_affectation
		AND materiels_etats.id_etat = materiels.id_etat
		AND date_retour IS NOT NULL
		AND materiels.id_etat IN ('6','7','8')
		ORDER BY date_retour ;";
		$execution4=mysql_query($query4);
		if ($echeance1 == "moins")
		{
		echo "<form method = get target = _top action = tb_pret_cadre.php>";
		if ($nb_pb == 1)
		{
		echo "Vous avez $nb_pb prêt de mat&eacute;riel bientôt termin&eacute; &nbsp &nbsp";
		}
		else
		{
		echo "Vous avez $nb_pb prêts de mat&eacute;riels bientôt termin&eacute;s &nbsp &nbsp";
		}
		echo"<input type=submit value='Voir en plein &eacute;cran' a href= tb_pret_cadre.php><br /><br />";
		echo "</form>";
		echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Nom</center></td><td><center>Cat&eacute;gorie</center></td><td><center>Affect&eacute;</center></td><td><center>&Agrave; rendre dans</center></td><td><center>Infos</center></td></tr>";
		}
		else
		{
		if ($echeance1 == "retard")
		{
		echo "<form method = get target = _top action = tb_pret_cadre.php>";
		if ($nb_pb == 1)
		{
		echo "Vous avez $nb_pb prêt de mat&eacute;riels non encore rendu &nbsp &nbsp";
		}
		else
		{
		echo "Vous avez $nb_pb prêts de mat&eacute;riels non encore rendus &nbsp &nbsp";
		}
		echo"<input type=submit value='Voir en plein &eacute;cran' a href= tb_pret_cadre.php><br /><br />";
		echo "</form>";
		echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Nom</center></td><td><center>Cat&eacute;gorie</center></td><td><center>Affect&eacute;</center></td><td><center>A rendre depuis</center></td><td><center>Infos</center></td></tr>";
		}
		}
		
				while($results4 = mysql_fetch_row($execution4))
			{
			if ($results4[7] == "disponible" or $results4[7] == "en panne")
			{
			$results4[3] = $results4[3].' ('.$results4[7].')';
			}
				if ($results4[4] <> "")
				{
				list($annee, $mois, $jour)= explode ("-",$results4[4]);
				$results4[4] = $jour."/".$mois."/".$annee;
				}
				if ($results4[5] <> "")
				{
				list($annee3, $mois3, $jour3) = explode("-", $results4[5]);
				$auj=time();
				$date3=mktime(0,0,0,$mois3,$jour3,$annee3);
				$inter1=$date3-$auj;
				list($annee, $mois, $jour)= explode ("-",$results4[5]);
				$results4[5] = $jour."/".$mois."/".$annee;
				}
				if ($echeance1 == "moins" and $inter1 <= (86400*$nb_j_p) and $inter1 >= 0)
				{
								if (strlen ($results4[1]) >= 20)
				{
				$results4[1] = substr("$results4[1]",0, 20)."...";
				}
					if (strlen ($results4[2]) >= 20)
				{
				$results4[2] = substr("$results4[2]",0, 20)."...";
				}
				$nb_jour1=floor($inter1/(60*60*24))+1;
				echo "<tr bgcolor=$bg_color2><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
				}
				else
				{
				if ($echeance1 == "retard" and $inter1 >= (-86400*$nb_j_p) and $inter1 <= 0)
				{
								if (strlen ($results4[1]) >= 20)
				{
				$results4[1] = substr("$results4[1]",0, 20)."...";
				}
					if (strlen ($results4[2]) >= 20)
				{
				$results4[2] = substr("$results4[2]",0, 20)."...";
				}
				$nb_jour1=floor(($inter1/(60*60*24))*-1);
				echo "<tr bgcolor=$bg_color2><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
				}
				}
				}
				echo"</table>";
		} //Fin if ($nb_pb > 0)
*/
		else
		{
		echo "<center><b>Vous n'avez pas de pr&ecirc;t de mat&eacute;riels qui correspondent aux crit&egrave;res</center></b>";
		}

		$_SESSION[nb_prets]=$nb_prets;
		
		
		
		
		
?>
		</div>
	</body>
</html>
