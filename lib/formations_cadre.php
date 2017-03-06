<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des formations">
<?php
	//include("../biblio/ticket.css");
	include("../biblio/config.php");
	include ("../biblio/fct.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("FORM");
	}
		

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="60,*,65">
					<frame name="head" src="formations_head.php" FRAMEBORDER="0" scrolling="no">
					<frame name="body" src="formations_gestion.php?dep=T&amp;secteur=T&amp;intitule_fonction=T&amp;annee=$annee_en_cours&amp;origine=cadre_gestion" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>

