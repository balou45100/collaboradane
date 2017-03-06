<?php
	//Lancement de la session
	session_start();
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	else
	{
		enreg_utilisation_module("FAV");
	}
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	//include ("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
?>
				<frameset rows="*,65">
					<frame name="body" src="favoris_publics.php" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
