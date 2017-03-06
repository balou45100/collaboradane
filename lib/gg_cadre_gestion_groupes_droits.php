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
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	include("../biblio/config.php");
	include("../biblio/fct.php");
	include("../biblio/init.php");

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
					<frame name="body" src="gg_gestion_groupes_droits.php" FRAMEBORDER="0">
					<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
				</frameset>

	<body>
	</body>
</html>
