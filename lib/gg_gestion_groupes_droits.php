<?php
	//Lancement de la session
	session_start();

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
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_gestion_droits_groupes.png\" ALT = \"Titre\">";
	
	$autorisation_gestion_groupes = verif_appartenance_groupe(13); 

	if($autorisation_gestion_groupes <> "1")
	{
		echo "<h1>Vous n'avez pas le droit d'accéder à ce module</h1>";
		/*
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></center>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		*/
		exit;
	}
	echo "<div align = \"center\">";
		echo "<h1>Gestion des droits et des groupes</h1>";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";

				echo "<td align = \"center\">";
					echo "<a href=\"gg_gestion_droits_gr.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/droits.png\" title = \"G&eacute;rer les cat&eacute;gories\" align=\"top\" border=\"0\"></a>";
					echo "<br />&nbsp;Gestion des droits&nbsp;";
				echo "</td>";

				echo "<td align = \"center\">";
					echo "<a href=\"gg_gestion_groupe_gr.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/groupes.png\" id=\"Image1\" title = \"G&eacute;rer les groupes\" align=\"top\" border=\"0\"></a>";
					echo "<br />&nbsp;Gestion des groupes&nbsp;";
				echo "</td>";

/*
				echo "<td align = \"center\">";
					echo "<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_entrant_imprimer.png\" id=\"Image4\" title = \"Imprimer liste courriers entrants\" align=\"top\" border=\"0\"></a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_sortant_imprimer.png\" id=\"Image3\" title = \"Imprimer liste courriers sortants\" align=\"top\" border=\"0\"></a>";
					echo "<br />Listes courriers <i>(inactif)</i>";
				echo "</td>";
*/
			echo "</tr>";
		echo "</table>";
	echo "</div>";
?>
	</body>
<html>
