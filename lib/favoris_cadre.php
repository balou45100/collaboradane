<?php
	//Lancement de la session
	session_start();
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	else
	{
		enreg_utilisation_module("FAV");
	}
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<?php
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";?>
	</head>
		<frameset rows="*,65">
			<frame name="body" src="favoris.php?type_favoris=publiques" FRAMEBORDER="0">
			<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
		</frameset>
</html>
