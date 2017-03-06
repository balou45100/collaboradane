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
	
	//echo "<br />tb_alertes.php - vue : $vue<br />";
	//echo "<br />chemin_theme_images : $chemin_theme_images<br />";
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
			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
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
		if ($vue <> "tb")
		{
			// On inclut le fichier pour afficher le tableau de s&eacute;lection des tickets, alertes etc...
			include ("tb_inc.php");
		}
		//on initialise le timestamp pour la date du jour
		$date_auj = mktime();

		//On r&eacute;cup&egrave;re les r&eacute;glages pour les alertes
		$req_reglages_alertes = "SELECT nb_j_alerte, nb_j_alerte_av FROM preference WHERE ID_UTIL = $id;";
		$resultat_req_alertes=mysql_query($req_reglages_alertes);
		while($reglage_alerte = mysql_fetch_row ($resultat_req_alertes))
		{
			$nb_j_alerte = $reglage_alerte[0];
			$nb_j_alerte_av= $reglage_alerte[1];
		}
		
		//echo "<br />nb_j_alerte : $nb_j_alerte - nb_j_alerte-av : $nb_j_alerte_av";

		//On transforme le nombre de jours en nombre de secondes
		$avant = ($nb_j_alerte_av + 1) * 86400;
		$apres = ($nb_j_alerte +1) * 86400;
		
		//on calcule les deux timestamp pour le filtre
		$avant = $date_auj - $avant;
		$apres = $date_auj + $apres;

		/*
		$avant_d = date("D d M Y",$avant);
		$apres_d = date("D d M Y",$apres);
		echo "<br />avant : $avant_d";
		echo "<br />apr&egrave;s : $apres_d<br />";
		*/

		// Selection des tickets de l'utilisateurs
		$query1="SELECT id_alerte, id_ticket, description, NOM, TEXTE, date_alerte 
			FROM alertes, probleme 
			WHERE alertes.id_ticket = probleme.ID_PB 
			AND id_util = $id 
			AND UNIX_TIMESTAMP(date_alerte) > $avant 
			AND UNIX_TIMESTAMP(date_alerte) < $apres 
			ORDER BY date_alerte";
		$execution1=mysql_query($query1);
		$num_results1 = mysql_num_rows($execution1);
		
		//echo "<br />nbr d'enregistrements : $num_results1";
		
		// S'il y en a 1 minimum
		if($num_results1 >= "1")
		{
			if ($vue == "tb")
			{
				// Affichage d'un message diff&eacute;rent s'il y a une ou plusieurs alertes...
				if($num_results1 == 1)
				{
					echo "Votre alerte de J-$nb_j_alerte_av &agrave; J+$nb_j_alerte&nbsp &nbsp";
				}
				else
				{
					echo "Vos $num_results1 alertes de J-$nb_j_alerte_av &agrave; J+$nb_j_alerte&nbsp &nbsp";
				}
			
				//On affiche le bouton pour afficher la liste en plein &eacute;cran
				echo"<a href= tb_alerte_cadre.php target =_top><input type=submit value='Voir en plein &eacute;cran'></a><br /><br />";
			}
			else
			{
				if($num_results1 == 1)
				{
					echo "<center><b>Votre alerte de J-$nb_j_alerte_av &agrave; J+$nb_j_alerte</b></center><br />";
				}
				else
				{
					echo "<b><center>Vos $num_results1 alertes de J-$nb_j_alerte_av &agrave; J+$nb_j_alerte</b></center><br />";
				}
				
			}
			
			// On affiche le tableau...	
			//echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Id</center></td><td><center>Date alerte</center></td><td><center>Nom</center></td><td><center>Description</center></td><td><center>Infos</center></td></tr>";
			echo "<div align = \"center\">";
			echo "<table>";
				echo "<tr>";
					echo "<th>Id</th>";
					echo "<th>Date alerte</th>";
					echo "<th>Sujet</th>";
					echo "<th>Description</th>";
					echo "<th>Infos</th>";
				echo "</tr>";
			while($results1 = mysql_fetch_row($execution1))
			{
				list($annee1, $mois1, $jour1)= explode ("-",$results1[5]);
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
					echo "<tr class = \"avant_date\">";
						echo "<td class = \"avant_date\" align = \"center\">$results1[0]</td>";
						echo "<td align = \"center\">$date_echeance</td>";
						echo "<td align = \"center\">$results1[3]</td>";
						echo "<td align = \"center\">$results1[2]</td>";
						echo "<td class = \"fond-actions\"><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td>";
					echo "</tr>";
				}
				else
				{
					//echo "<br />apr&egrave;s";
					echo "<tr>";
						echo "<td align = \"center\">$results1[0]</td>";
						echo "<td align = \"center\">$date_echeance</td>";
						echo "<td align = \"center\">$results1[3]</td>";
						echo "<td align = \"center\">$results1[2]</td>";
						echo "<td class = \"fond-actions\"><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td>";
					echo "</tr>";
				}
			}
			echo"</table>";
			echo "</div>";
		} //Fin if($num_results1 >= "1")
		else
		{
			echo "<center><b>Vous n'avez aucune alerte qui correspond aux crit&egrave;res</center></b>";
		}
		$_SESSION[nb_alertes]=$num_results1;
		?>
		</body>
		</html>
