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
		enreg_utilisation_module("EVE");
	}
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE html>

<?php
	include ("../biblio/config.php");
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
  		//echo "<meta charset=\"UTF-8\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

?>
	<frameset rows="60,*,65">
		<frame name="head" src="evenements_entete.php" FRAMEBORDER="0" scrolling="no">
		<frame name="body" src="evenements_accueil.php?tri=date_evenement_debut asc, heure_debut_evenement&amp;sense_tri=ASC&amp;visibilite=O&amp;date_filtre=1" FRAMEBORDER="0">
		<frame name="cadre_modules" src="dossier_barre_modules.php" FRAMEBORDER="0" scrolling="no">
	</frameset>
</html>
