<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module pour afficher et gérer les utilisateurs inscrits">
<?php
	//include ("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("GUS");
	}
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="*,65">
					<frame name="body" src="gestion_user.php?indice=0" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
