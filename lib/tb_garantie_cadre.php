<?php
	//Lancement de la session
  session_start();
  header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module de gestion des écoles et EPLE">
<?php
	 //include("../biblio/ticket.css");
	 include ("../biblio/fct.php");
	 include ("../biblio/config.php");
	 if(!isset($_SESSION['nom']))
	 {
	   echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
	   echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
	   exit;
	 }
?>

<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
			<frameset rows="*,65">
	        <frame name="body" src="tb_garanties.php" FRAMEBORDER="0">
	        <frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
	      </frameset>
</html>
