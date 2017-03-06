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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			//include("../biblio/entete_et_menu.css");
	
			$autorisation_gestion_groupes = verif_appartenance_groupe(13); 

			if($autorisation_gestion_groupes <> "1")
			{
				echo "<h1>Vous n'avez pas le droit d'accéder à ce module</h1>";
				/*
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				*/
				exit;
			}
		echo "<table class = \"menu-boutons\">
			<tr>
				<td align = \"center\">
					<a href=\"gg_cadre_gestion_groupes_droits.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"retourner\" title=\"Retourner au menu de la gestion des droits\" border = \"0\"></a>
					<br /><small>&nbsp;Retour&nbsp;</small>
				</td>
				<td align = \"center\">
					<a href=\"gg_gestion_groupe.php\" target=\"zone_travail\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le groupe\" border = \"0\"></a>
					<br /><small>&nbsp;Modifier&nbsp;</small>
				</td>
				<td align = \"center\">
					<a href=\"gg_gestion_personnes.php\" target=\"zone_travail\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/groupes.png\" ALT = \"g&acute;rer\" title=\"G&eacute;rer les groupes\" border = \"0\"></a>
					<br /><small>&nbsp;G&eacute;rer&nbsp;</small>
				</td>
			</tr>
		</table>
		</center>
		<br />
		</body>";
?>
</html>
