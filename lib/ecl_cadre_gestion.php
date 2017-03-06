<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module de gestion des &eacute;coles et EPLE">
<?php
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><FONT COLOR = \"#808080\"><b>vous n'&egrave;tes pas logu&eacute;</b></FONT></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">Retour &agrave; la mire de connexion</a></center>";
		exit;
	}
	else
	{
		enreg_utilisation_module("ECL");
	}
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	</head>";
?>
				<frameset rows="60,*,65">
					<frame name="head" src="ecl_head.php" FRAMEBORDER="0" scrolling="no">
					<frame name="body" src="ecl_gestion_ecl.php?dep=T&amp;secteur=T&amp;filtre=T&amp;origine=cadre_gestion&amp;indice=0&amp;dans=T" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
