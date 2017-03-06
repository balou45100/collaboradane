<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des tâches">
<?php
	//include("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("CONF");
	}
// Au cas ou la variable de session lié au tableau de bord est toujours active, on l'efface pour que le lien de "retour" soit correct...
unset($_SESSION['origine']);
unset($_SESSION['origine1']);
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<frameset rows="*,65">
			<frame name="body" src="configuration_systeme_1.php?action=N " FRAMEBORDER="0">
			<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
		</frameset>
</html>
