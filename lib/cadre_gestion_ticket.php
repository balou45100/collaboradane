<?php
	//Lancement de la session
  session_start();
  header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des tickets">
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
	else
	{
		enreg_utilisation_module("GTI");
	}
	include ("../biblio/config.php");
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="60,*,65">
					<frame name="head" src="head_gt.php" FRAMEBORDER="0" scrolling="no">
					<frame name="body" src="gestion_ticket.php?tri=G&amp;sense_tri=DESC&amp;tri2=ID&amp;indice=0&amp;categorie_commune=Non&amp;etat&amp;deverrouiller=&amp;idpb=" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
<?php
// Au cas ou la variable de session lié au tableau de bord est toujours active, on l'efface pour que le lien de "retour" soit correct...
unset($_SESSION['origine']);
unset($_SESSION['origine1']);
?>
