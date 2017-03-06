<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des contacts">
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
		enreg_utilisation_module("CON");
	}
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="60,*,65">
					<frame name="head" src="contacts_head.php" FRAMEBORDER="0" scrolling="no">
					<frame name="body" src="contacts_gestion.php?origine_gestion=filtre&amp;filtre=T&amp;tri=NOM&amp;sense_tri=ASC&amp;indice=0&amp;action=affichage" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
