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
	
	//echo "<br />tb_garanties.php - vue : $vue<br />";
	
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
				echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
				exit;
			}
			else
			{
				enreg_utilisation_module("TBGA");
			}
?>
	</head>
		<body>
<?php
	echo "<div align = \"center\">";
		if ($vue <> "tb")
		{
			// On inclut le fichier pour afficher le tableau de s&eacute;lection des tickets, alertes etc...
			include ("tb_inc.php");
		}

		//on initialise le timestamp pour la date du jour
		$date_auj = mktime();

		//$nb_pb=0;
		
		//on r&eacute;cup&egrave;re tous les r&eacute;glages de l'utilisateur
		$req_mat="SELECT nb_j_ech FROM preference where ID_UTIL = $id";
		$exe_mat=mysql_query($req_mat);
		while($recup_mat = mysql_fetch_row ($exe_mat))
		{
			$nb_j_m = $recup_mat[0];
		}
		
		//echo "<br />nb_j_m : $nb_j_m - nb_j_m_av : $nb_j_m_av - date_auj : $date_auj";

		//On transforme le nombre de jours en nombre de secondes
		$apres = ($nb_j_m +1) * 86400;
		
		//on calcule le timestamp pour le filtre
		$apres = $date_auj + $apres;
		
		/*
		$apres_d = date("D d M Y",$apres);
		echo "<br />apr&egrave;s : $apres_d<br />";
		*/
				
		$query3="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, fin_garantie, materiels.id_etat, intitule_etat 
		FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats 
		WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ 
		AND materiels.affectation_materiel=materiels_affectations.id_affectation 
		AND materiels_etats.id_etat = materiels.id_etat
		AND fin_garantie <> 0000-00-00 
		AND materiels.id_etat IN ('3','4','5','6','7','8','9') 
		AND UNIX_TIMESTAMP(fin_garantie) >= $date_auj
		AND UNIX_TIMESTAMP(fin_garantie) < $apres
		ORDER BY fin_garantie ASC;";
		$execution3 = mysql_query($query3);
		$nb_enregs = mysql_num_rows($execution3);
		
		//echo "<br />nb_enregs : $nb_enregs<br />";

		if ($nb_enregs >= 1)
		{
			//echo "<table border = 1 bgcolor = #48D1CC align = center><tr><td><center>Id</center></td><td><center>D&eacute;nomination</center></td><td><center>Cat&eacute;gorie</center></td><td><center>Affect&eacute; &agrave;</center></td><td><center>&Eacute;tat</center></td><td><center>Fin garantie dans</center></td><td><center>Infos</center></td></tr>";
			echo "<table>";
				echo "<tr>";
					echo "<th>Id</th>";
					echo "<th>D&eacute;nomination</th>";
					echo "<th>Cat&eacute;gorie</th>";
					echo "<th>Affect&eacute; &agrave;</th>";
					echo "<th>&Eacute;tat</th>";
					echo "<th>Fin garantie dans</th>";
					echo "<th>Infos</center></th>";
				echo "</tr>";
			echo "<form method = get target = _top action = tb_garantie_cadre.php>";

			if ($vue == "tb")
			{
				// Affichage d'un message diff&eacute;rent s'il y a une ou plusieurs alertes...
				if ($nb_enregs == 1)
				{
					echo "Fin de garantie de votre mat&eacute; dans J+$nb_j_m&nbsp &nbsp";
				}
				else
				{
					echo "Fin de garantie de vos $nb_enregstre mat&eacute;riels dans J+$nb_j_m&nbsp &nbsp";
				}
				echo"<input type=submit value='Voir en plein &eacute;cran' a href= tb_garantie_cadre.php><br /><br />";
			}
			else
			{
				if ($nb_enregs == 1)
				{
					echo "<center><b>Fin de garantie de votre mat&eacute;riel dans J+$nb_j_m</b></center><br />";
				}
				else
				{
					echo "<b><center>Fin de garantie de vos $nb_enregstre mat&eacute;riels dans J+$nb_j_m</b></center><br />";
				}
				
			}

			echo "</form>";
			while($results3 = mysql_fetch_row($execution3))
			{	
				list($annee1, $mois1, $jour1)= explode ("-",$results3[4]);
				$date_enreg = mktime(0,0,0,$mois1,$jour1,$annee1);
			
				//Il faut calculer le nombre de jour avant ou apr&egrave;s la garantie
				$nb_jours_fin_garantie = floor(($date_enreg - $date_auj)/86400)+1;
				
				/*
				$date_clair = date("D d M Y",$date_enreg);
				echo "<br />annee : $annee1 - mois : $mois1 - jour : $jour1";
				echo "<br />date_extraite : $results2[3] - date_enreg : $date_enreg - date_clair : $date_clair - date_auj : $date_auj";
				*/
	
				if (strlen ($results3[1]) >= 20)
				{
					$results3[1] = substr("$results3[1]",0, 20)."...";
				}

				//On affiche l'enregistrement
				//echo "<tr bgcolor=$bg_color2><td><center>$results3[0]</center></td><td><center>$results3[1]</center></td><td><center>$results3[2]</center></td><td><center>$results3[3]</center></td><td><center>$results3[6]</center></td><td><center>$nb_jours_fin_garantie jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results3[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
				echo "<tr>";
					echo "<td align = \"center\">$results3[0]</td>";
					echo "<td align = \"center\">$results3[1]</td>";
					echo "<td align = \"center\">$results3[2]</td>";
					echo "<td align = \"center\">$results3[3]</td>";
					echo "<td align = \"center\">$results3[6]</td>";
					echo "<td align = \"center\">$nb_jours_fin_garantie jour(s)</td>";
					echo "<td class = \"fond-actions\" align = \"center\"><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results3[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></td>";
				echo "</tr>";
			}
				echo"</table>";
		} //Fin if ($nb_enregs >= 1)
		else
		{
		echo "<center><b>Vous n'avez pas de garanties qui correspondent aux crit&egrave;res</center></b>";
		}	
		$_SESSION[nb_enregs]=$nb_enregs;
?>
		</div>
	</body>
</html>
