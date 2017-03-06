<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	/*if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}*/
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
					<frameset rows="100,*">
					<frame name="gc_menu" src="gc_menu.php" FRAMEBORDER="0">
					<frame name="zone_travail" src="gc_demarrage.php" FRAMEBORDER="0" scrolling="auto">
					<!--frame name="zone_travail" src="gc_recherche.php" FRAMEBORDER="0" scrolling="auto"-->
				</frameset>

</html>
