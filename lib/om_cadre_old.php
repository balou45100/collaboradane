<?php
	//Lancement de la session
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des contacts">
<?php
	//include("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	enreg_utilisation_module("GOM");
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="*,65">
					<frame name="body" src="om_accueil.php" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
