<?php
	//Lancement de la session
	session_start();
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE html>
<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";

	echo "<body>";
	
	//include("../biblio/ticket.css");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");
	//Affichage des icônes pour la saisie des courriers et la gestion des cat&eacute;gories

	//echo "<br />avant v&eacute;rification droits";
	
	$niveau_droits = verif_droits("courrier");
	
	//echo "<br />niveau_droits : $niveau_droits";
	
	if ($niveau_droits == 3) //Il faut avoir les droits de cr&eacute;ation pour avoir acc&egrave;s aux boutons
	{
		include ('gc_boutons_gestion.inc.php');
	}

	//include ('gc_boutons_gestion.inc.php');
	echo "<h2>Utiliser les options du bandeau du haut pour la gestion du courrier</h2>";
	echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_courrier.png\" ALT = \"Titre\">";
?>
</body>

</html>
