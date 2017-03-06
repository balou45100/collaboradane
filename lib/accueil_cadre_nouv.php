<?php
	//Lancement de la session
  session_start();
  header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module de gestion des écoles et EPLE">
<?php
	 include("../biblio/ticket.css");
	 include ("../biblio/fct.php");
	 include ("../biblio/config.php");
	 if(!isset($_SESSION['nom']))
	 {
	   echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
	   echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
	   exit;
	 }
	 else
	 {
      //echo "id_util : $_SESSION[id_util]";
      enreg_utilisation_module("TBO");
	 }
?>

<html>
	<head>
		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<!--frameset cols = "100,*">
			<frame name = "cadre_menu" src="modules_verticales.php" BORDER="0" FRAMEBORDER="0" Framespacing="0" scrolling="no">
			<frameset rows="90,*,65">
				<frame name="body" src="entete_tb.php" BORDER="0" FRAMEBORDER="0" Framespacing="0" scrolling="no">
				<frame name="body" src="tb.php?vue=tb" BORDER="0" FRAMEBORDER="0" Framespacing="0">
				<frame name="cadre_modules" src="modules_horizontales.php" BORDER="0" FRAMEBORDER="0" scrolling="no" Framespacing="0">
			</frameset>
		</frameset-->
		
<?php
				echo "<frameset rows=\"90,*\">";
					echo "<frame name=\"body\" src=\"entete_tb.php\" FRAMEBORDER=\"0\"scrolling=\"no\">";
					echo "<frameset cols = \"100,*,200\">";
						echo "<frame name = \"cadre_menu\" src=\"modules_verticales.php\" FRAMEBORDER=\"0\">";
						echo "<frameset rows=\"*,65\">";
							echo "<frame name=\"body\" src=\"tb.php?vue=tb\" FRAMEBORDER=\"0\">";
							echo "<frame name=\"cadre_modules\" src=\"modules_horizontales.php\" FRAMEBORDER=\"0\" scrolling=\"no\">";
						echo "</frameset>";
						echo "<frame name = \"cadre_menu_droite\" src=\"bloc_informations.php\" FRAMEBORDER=\"0\">";
					echo "</frameset>";
				echo "</frameset>";

?>
		<!--frameset rows="*,65">
	        <frame name="body" src="tb.php?vue=tb" FRAMEBORDER="0">
	        <frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
	      </frameset-->
</html>
