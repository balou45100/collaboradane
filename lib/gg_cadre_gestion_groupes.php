<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	//include("../biblio/ticket.css");
	include("../biblio/init.php");
	include("../biblio/fct.php");
	include("../biblio/config.php");

	$autorisation_gestion_groupes = verif_appartenance_groupe(13); 

	//echo "<br />gg_cadre_gestion_groupe.php - autorisation_gestion_groupes : $autorisation_gestion_groupes";

	if($autorisation_gestion_groupes <> "1")
	{
		echo "<h1>Vous n'avez pas le droit d'acc&eacute;der &agrave; ce module</h1>";
		/*
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		*/

		exit;
	}
	else
	{
		enreg_utilisation_module("GRO");
	}

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="*,60">
					<frame name="body" src="gg_gestion_groupe_gr.php" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>
</html>
