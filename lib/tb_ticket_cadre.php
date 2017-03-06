<?php
	//Lancement de la session
  session_start();
  header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module de gestion des &eacute;coles et EPLE">
<?php
	 //include("../biblio/ticket.css");
	 include ("../biblio/fct.php");
	 include ("../biblio/config.php");
	 if(!isset($_SESSION['nom']))
	 {
	   echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
	   echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
	   exit;
	 }
?>

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
			<frameset rows="*,65">
	        <frame name="body" src="tb_tickets.php" FRAMEBORDER="0">
	        <frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
	      </frameset>
</html>
