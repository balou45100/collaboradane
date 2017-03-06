<?php
	session_start();
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
	//echo "<br />tb_taches.php - vue : $vue<br />";
	header('Content-Type: text/html;charset=UTF-8');
	
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
		
		$num_results2=0;
		//on r&eacute;cup&egrave;re tous les r&eacute;glages de l'utilisateur
		$req_tick="SELECT tri_tac, nb_j_tache, nb_j_tache_av FROM preference WHERE ID_UTIL = $id";
		$exe_tick=mysql_query($req_tick);
		while($recup_tick = mysql_fetch_row ($exe_tick))
		{
			$tri_tac = $recup_tick[0];
			$nb_j_t= $recup_tick [1];
			$nb_j_t_av= $recup_tick [2];
		}
		
		//echo "<br />nb_j_t : $nb_j_t - nb_j_t_av : $nb_j_t_av - date_auj :$date_auj";

		//On transforme le nombre de jours en nombre de secondes
		$avant = ($nb_j_t_av + 1) * 86400;
		$apres = ($nb_j_t +1) * 86400;
		
		//on calcule les deux timestamp pour le filtre
		$avant = $date_auj - $avant;
		$apres = $date_auj + $apres;
		/*
		$avant_d = date("D d M Y",$avant);
		$apres_d = date("D d M Y",$apres);
		echo "<br />avant : $avant_d";
		echo "<br />apr&egrave;s : $apres_d<br />";
		*/
/*
		$base="SELECT taches.id_tache, description, priorite, date_echeance FROM taches
			WHERE (id_util_creation = $id OR id_util_traitant = $id) 
			AND etat !='3' 
			AND UNIX_TIMESTAMP(date_echeance) > $avant 
			AND UNIX_TIMESTAMP(date_echeance) < $apres ";
*/
		$base="SELECT taches.id_tache, description, priorite, date_echeance FROM taches, taches_util
			WHERE taches.id_tache = taches_util.id_tache
			AND taches_util.id_util = $id 
			AND etat !='3' 
			AND UNIX_TIMESTAMP(date_echeance) > $avant 
			AND UNIX_TIMESTAMP(date_echeance) < $apres ";
		switch ($tri_tac)
		{
			case "0" :
				$req_tri= "";
			break;
			case "1" :
				$req_tri= " AND visibilite = 'PR'";
			break;
			case "2" :
				$req_tri= " AND visibilite = 'PU'";
			break;
		}
		//Ordre d'affichage
		$ordre_affichage = " ORDER BY date_echeance ASC";
		$query2=$base.$req_tri.$ordre_affichage;
		//echo "<br />requete : $query2<br />";	
		$execution2=mysql_query($query2);
		if ($execution2)
		{
			$num_results2 = mysql_num_rows($execution2);
			//echo "<br />nbr d'enregistrements : $num_results2<br />"; 
	
			if($num_results2 >= "1")
			{
				echo "<form method = get target = _top action = tb_tache_cadre.php>";

				if ($vue == "tb")
				{
					// Affichage d'un message diff&eacute;rent s'il y a une ou plusieurs alertes...
					if($num_results2 == 1)
					{
						echo "Votre t&acirc;che de J-$nb_j_t_av &agrave; J+$nb_j_t&nbsp &nbsp";
					}
					else
					{
						echo "Vos $num_results2 t&acirc;ches de J-$nb_j_t_av &agrave; J+$nb_j_t&nbsp &nbsp";
					}
					
					echo"<input type=submit value='Voir en plein &eacute;cran' a href= tb_tache_cadre.php><br /><br />";
				}
			else
			{
				if ($num_results2 == 1)
				{
					echo "<center><b>Votre t&acirc;che de J-$nb_j_t_av &agrave; J+$nb_j_t</b></center><br />";
				}
				else
				{
					echo "<b><center>Vos $num_results2 t&acirc;ches de J-$nb_j_t_av &agrave; J+$nb_j_t</b></center><br />";
				}
				
			}

				echo "</form>";
				//echo "<table border = 1 align = center BGCOLOR = #48D1CC><tr><td><center>Id</center></td><td><center>&Eacute;ch&eacute;ance</center></td><td><center>Priorit&eacute;</center></td><td><center>Description</center></td><td><center>Cat&eacute;gorie</center></td><td><center>Infos</center></td></tr>";
				echo "<table>";
					echo "<tr>";
						echo "<th>Id</th>";
						echo "<th>&Eacute;ch&eacute;ance</th>";
						echo "<th>Priorit&eacute;</th>";
						echo "<th>Description</th>";
						echo "<th>Cat&eacute;gorie</th>";
						echo "<th>Infos</th>";
					echo "</tr>";
				while($results2 = mysql_fetch_row($execution2))
				{	
					if ($results2[2] == "N")
					{
						$priorite = "Normale";
					}
					else
					{
						if ($results2[2] == "H")
						{
							$priorite = "Haute";
						}
						else
						{
							$priorite = "Basse";
						}
					}
					list($annee1, $mois1, $jour1)= explode ("-",$results2[3]);
					$date_enreg = mktime(0,0,0,$mois1,$jour1,$annee1);
					$date_clair = date("D d M Y",$date_enreg);
					//echo "<br />annee : $annee1 - mois : $mois1 - jour : $jour1";
					//echo "<br />date_extraite : $results2[3] - date_enreg : $date_enreg - date_clair : $date_clair - date_auj : $date_auj";
					
					//On recherche les cat&eacute;gories des tâches &agrave; afficher
					$req_catf = "SELECT id_categ, intitule_categ FROM taches_categories, categorie_commune WHERE taches_categories.id_categorie = categorie_commune.id_categ AND id_tache =$results2[0];";
					$exe_cat = mysql_query ($req_catf);
					$categ = mysql_num_rows($exe_cat);
					if ($categ == 0)
					{
						$categorie = "";
					}
					else
					{
						while($results_categ = mysql_fetch_row($exe_cat))	
						{
							$categorie = $results_categ[1];
						}
					}
					
					//On formate la date d'&eacute;ch&eacute;ance pour l'affichage
					$date_echeance=$jour1."/".$mois1."/".$annee1;
					
					//On formate la description pour l'affichage
					if (strlen ($results2[1]) >= 50)
					{
						$results2[1] = substr("$results2[1]",0, 50)."...";
					}
					
					//On change de fond si la tâches est ant&eacute;rieure &agrave; la date du jour
					if ($date_enreg < $date_auj)
					{
						//echo "<tr bgcolor= $bg_color3><td><center>$results2[0]</center></td><td><center>$date_echeance</center></td><td><center>$priorite</center></td><td><center>$results2[1]</center></td><td><center>$categorie</center></td><td><center><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
						echo "<tr class = \"avant_date\">";
							echo "<td align = \"center\">$results2[0]</td>";
							echo "<td align = \"center\">$date_echeance</td>";
							echo "<td align = \"center\">$priorite</td>";
							echo "<td align = \"center\">$results2[1]</td>";
							echo "<td align = \"center\">$categorie</td>";
							echo "<td class = \"fond-actions\" align = \"center\"><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></td>";
						echo "</tr>";
					}
					else
					{
						//echo "<tr bgcolor= $bg_color2><td><center>$results2[0]</center></td><td><center>$date_echeance</center></td><td><center>$priorite</center></td><td><center>$results2[1]</center></td><td><center>$categorie</center></td><td><center><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
						echo "<tr>";
							echo "<td align = \"center\">$results2[0]</td>";
							echo "<td align = \"center\">$date_echeance</td>";
							echo "<td align = \"center\">$priorite</td>";
							echo "<td align = \"center\">$results2[1]</td>";
							echo "<td align = \"center\">$categorie</td>";
							echo "<td class = \"fond-actions\" align = \"center\"><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td>";
						echo "</tr>";
					}
								
				}
				echo"</table>";
			} //Fin if($num_results2 >= "1")
			else
			{
				echo "<center><b>Vous n'avez aucune t&acirc;che qui correspond aux crit&egrave;res</center></b>";
			}
		} //Fin if ($execution2)
		else
		{
			echo "<center><b>Vous n'avez aucune t&acirc;che qui correspond aux crit&egrave;res</center></b>";
		}
		$_SESSION[nb_taches]=$num_results2;
?>
		</div>
	</body>
</html>
