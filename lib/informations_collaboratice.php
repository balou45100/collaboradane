<?php	//Lancement de la session
	session_start();
	error_reporting(0);
	
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>";
		echo "<head>
			<title>CollaboraTICE</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
			<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "</head>";
		echo "<body>";
			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			
			$version_date_a_afficher = strtotime($version_date);
			$version_date_a_afficher = date('d/m/Y',$version_date_a_afficher);

			//echo "<div id = \"entete-collaboratice\" align = \"center\">";
			echo "<div id = \"entete-collaboratice\">";
			
				echo "<h2>$nom_espace_collaboratif<br />$description_espace_collaboratif</h2>
				<img class = \"logo\" src=\"$chemin_theme_images/$nom_logo\" ALT = \"Logo Mission Tice\">
				<img class = \"logo2\" src=\"$chemin_theme_images/$nom_logo2\" ALT = \"Logo Collaboratice\">";
				//echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_accueil.png\" ALT = \"Titre\">
			echo "</div>";
			echo "<div class = \"infos-collaboratice-version\">";
				echo "Version actuelle : $version<br />Date de derni&egrave;re mise &agrave; jour&nbsp;:&nbsp;$version_date_a_afficher";
			echo "</div>";

			echo "<div>";
				echo "<table class = \"infos-collaboratice\">";
					echo "<tr class = \"infos-collaboratice\">";
						echo "<td colspan = \"2\" class = \"infos-collaboratice\"><h1>Ont particip&eacute; &agrave; la mise en place de collaboratice&nbsp;:&nbsp;</h1></td>";
					echo "</tr>";
					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>J&uuml;rgen Mendel&nbsp;:&nbsp;concept, analyse et programmation de 80% du code</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>Thierry Biancolli&nbsp;:&nbsp;conception et r&eacute;alisation des ic&ocirc;nes de l'interface, mis en place en mai 2012</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>Les autres membres de la mission Tice pour leurs encouragements et leur aide au d&eacute;bogage du code</h2></td>";
					echo "</tr>";

				echo "</table>";
				
				echo "<table class = \"infos-collaboratice\">";
					echo "<tr class = \"infos-collaboratice\">";
						echo "<td colspan = \"4\" class = \"infos-collaboratice\"><h1>Les stagiaires, encadr&eacute;-e-s par J&uuml;rgen Mendel pour la mise en place de modules&nbsp;:&nbsp;</h1></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2007&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Gestion tickets\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par Fabien Volpi</h2></td>";
					echo "</tr>";


					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2009&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Tableau de bord\" et \"Favoris\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par Nicolas Gu&eacute;rin</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2010&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Dossiers\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par R&eacute;mi Krepper et Thibaud Tallon</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2010&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Gestion du courrier\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par Gr&eacute;gory Lapeyre</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2011&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Gestion des ordres de mission\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par &Eacute;lisabeth Recul&eacute; et Simon Pinoteau</h2></td>";
					echo "</tr>";

					echo "<tr class = \"infos-collaboratice\">";
						echo "<td class = \"infos-collaboratice\">&nbsp;<img src=\"$chemin_theme_images/puces/puce1.png\">&nbsp;</td>";
						echo "<td class = \"infos-collaboratice\"><h2>&nbsp;2013&nbsp;:&nbsp;</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>\"Gestion des ordres de mission de la CARDIE\"</h2></td>";
						echo "<td class = \"infos-collaboratice\"><h2>par Mehdi Derafa</h2></td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		echo "</body>";
	echo "</html>";
?>
