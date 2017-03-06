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
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des contacts">
<?php
	//include("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	//enreg_utilisation_module("GOM");
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="70,*,65">
					<frame name="head" src="abo_entete_magazine.php" FRAMEBORDER="0" scrolling="no">
					<frame name="body" src="abo_affichage_magazine.php" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
