<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des personnes ressources TICE">
<?php
	include("../biblio/cardie_config.php");
	include ("../biblio/fct.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("CARDIEPROJ");
	}
	echo "

<html>
	<head>
		<title>Cardie - projets</title>
	</head>
				<frameset rows=\"60,*,65\">
	        <frame name=\"head\" src=\"cardie_entete_projets.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
	        <frame name=\"body\" src=\"cardie_gestion_projets.php?\" FRAMEBORDER=\"0\">
	        <frame name=\"cadre_modules\" src=\"cardie_barre_modules.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
	      </frameset>
</html>";
// Au cas ou la variable de session lié au tableau de bord est toujours active, on l'efface pour que le lien de "retour" soit correct...
unset($_SESSION['origine']);
unset($_SESSION['origine1']);
?>
