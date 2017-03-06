<?php
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$origine="tb";
	$_SESSION['origine']=$origine;
	$_SESSION['origine1']=$origine;
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
			?>
		</head>
		<body>
		<CENTER>
<?php

		echo "<TABLE align=\"center\" width = \"50%\" height=\"13%\" BORDER = \"0\" BGCOLOR =\"#FFFF99\">
			<TR>
				<TD align = \"center\">
              		<h2>\"CollaboraTICE\"<br>Espace collaboratif de la Mission académique TICE</h2>
            	</TD>
            	<TD align = \"center\">
              		<img border=\"0\" src = \"$chemin_theme_images/logo_tice.png\" ALT = \"Logo\">
            	</TD>
          	</TR>
        </TABLE><br>";

		// On inclut le fichier pour afficher le tableau de sélection des tickets, alertes etc...
		include ("tb_inc.php");
		//on initialise le timestamp pour la date du jour
		$date_auj = mktime();

		//On récupère les réglages pour les alertes
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
		echo "<br />après : $apres_d<br />";
		*/

		// Selection des tickets de l'utilisateurs
		$query1="SELECT id_alerte, id_ticket, description, NOM, TEXTE, date_alerte 
			FROM alertes, probleme 
			WHERE alertes.id_ticket = probleme.ID_PB AND id_util = $id AND UNIX_TIMESTAMP(date_alerte) > $avant AND UNIX_TIMESTAMP(date_alerte) < $apres ORDER BY date_alerte";
		$execution1=mysql_query($query1);
		$num_results1 = mysql_num_rows($execution1);
		
		//echo "<br />nbr d'enregistrements : $num_results1";
		
		// S'il y en a 1 minimum
		if($num_results1 >= "1")
		{
			// Affichage d'un message différent s'il y a une ou plusieurs alertes...
			if($num_results1 == 1)
			{
				echo "Votre alerte qui correspond aux crit&egrave;res&nbsp &nbsp";
			}
			else
			{
				echo "Vos $num_results1 alertes qui correspondent aux crit&egrave;res&nbsp &nbsp";
			}
			
			//On affiche le bouton pour afficher la liste en plein écran
			//echo"<a href= tb_alerte_cadre.php target =_top><input type=submit value='Voir en plein écran'></a><br><br>";
			// On affiche le tableau...	
			echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Date alerte</center></td><td><center>Nom</center></td><td><center>Description</center></td><td><center>Infos</center></td></tr>";
			while($results1 = mysql_fetch_row($execution1))
			{
				list($annee1, $mois1, $jour1)= explode ("-",$results1[5]);
				$date_enreg = mktime(0,0,0,$mois1,$jour1,$annee1);
				/*
				$date_clair = date("D d M Y",$date_enreg);
				//echo "<br />annee : $annee1 - mois : $mois1 - jour : $jour1";
				//echo "<br />date_extraite : $results2[3] - date_enreg : $date_enreg - date_clair : $date_clair - date_auj : $date_auj";
				*/
				//On formate la date d'échéance pour l'affichage
				$date_echeance=$jour1."/".$mois1."/".$annee1;

			
				//On affiche les différentes enregistrements
				//On change de fond si la tâches est antérieure à la date du jour
				if ($date_enreg < $date_auj)
				{
					//echo "<br />avant";
					echo "<tr bgcolor=$bg_color3><td><center>$date_echeance</center></td><td><center>$results1[3]</center></td><td><center>$results1[2]</center></td><td><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
				}
				else
				{
					//echo "<br />après";
					echo "<tr bgcolor=$bg_color2><td><center>$date_echeance</center></td><td><center>$results1[3]</center></td><td><center>$results1[2]</center></td><td><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
				}
			}
			echo"</table>";
		} //Fin if($num_results1 >= "1")
		else
		{
			echo "Vous n'avez aucune alerte qui correspond aux crit&egrave;res<br>";
		}
			?>
		</body>
		</html>
