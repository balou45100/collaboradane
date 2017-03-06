<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	//include("../biblio/entete_et_menu.css");
	include("../biblio/fct.php");
	include("../biblio/config.php");
	include("../biblio/init.php");

	$autorisation_gestion_groupes = verif_appartenance_groupe(13); 

	if($autorisation_gestion_groupes <> "1")
	{
		echo "<h1>Vous n'avez pas le droit d'accéder à ce module</h1>";
		/*
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		*/
		exit;
	}
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
				<frameset rows="100,*">
					<frame name="gg_menu" src="gg_menu_groupes.php" FRAMEBORDER="0" scrolling="no">
					<frame name="zone_travail" src="gg_gestion_groupe.php" FRAMEBORDER="0" scrolling="auto">
				</frameset>
</html>
