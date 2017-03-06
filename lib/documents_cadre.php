<?php
	session_start();
	include ("../biblio/fct.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("DOC");
	}
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');

?>

<!DOCTYPE HTML>

<?php
	include ("../biblio/config.php");
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
  		//echo "<meta charset=\"UTF-8\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	// Cette variable de session sert de compteur (ou de repère pour savoir où en est l'affichage formulaire).
	// Ex : si form vaut 2, on affichera le deuxième type de formulaire, dans la page dossier_index_head.php
	$_SESSION['form']=0;
?>
</head>

	<!--frameset rows="62,*,65" name="main" FRAMEBORDER="no">
		<frameset cols="55%,45%">
			<frame name="headLeft" src="dossier_index_head.php" scrolling="no">
			<frame name="headRight" src="dossier_index_infos.php" scrolling="no">
		</frameset>
		<frame name="body" src="dossier_accueil.php">
		<frame name="cadre_modules" src="modules.php" scrolling="no">
	</frameset-->

	<frameset rows="60,*,65">
		<frame name="head" src="documents_entete.php" FRAMEBORDER="0" scrolling="no">
		<frame name="body" src="documents_accueil.php?tri=Int&amp;sense_tri=ASC&amp;visibilite=O&amp;indice=0" FRAMEBORDER="0">
		<frame name="cadre_modules" src="documents_barre_modules.php" FRAMEBORDER="0" scrolling="no">
	</frameset>


</html>
