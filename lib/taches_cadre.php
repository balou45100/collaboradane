<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des tâches">
<?php
	//include("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("TAC");
	}
// Au cas ou la variable de session lié au tableau de bord est toujours active, on l'efface pour que le lien de "retour" soit correct...
unset($_SESSION['origine']);
unset($_SESSION['origine1']);
	include ("../biblio/config.php");
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>";
?>		
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<frameset rows="*,65">
			<!--frame name="head" src="taches_head.php" FRAMEBORDER="0" scrolling="no"-->
			<frame name="body" src="taches_gestion.php?origine_appel=cadre&amp;categorie_filtre=%&amp;etat_filtre=0&amp;visibilite_filtre=PU&amp;tri=DATECR&amp;sense_tri=ASC&amp;affiche_barrees=N&amp;rechercher=" FRAMEBORDER="0">
			<frame name="cadre_modules" src="modules.php" FRAMEBORDER="0" scrolling="no">
		</frameset>
</html>
