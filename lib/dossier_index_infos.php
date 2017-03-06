<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	//$theme = $_SESSION['chemin_theme']."dossier.css";
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	
		//include ("../biblio/dossier.css");

echo "
	<body class = \"menu-boutons\">
	<div align=\"center\">
		<a href=\"dossier_ajout_dossier.php\" title=\"Créer un nouveau dossier\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierNouveau.png\"></a>
		&nbsp;
		&nbsp;
		&nbsp;
		<a href=\"dossier_ajout_element.php\" title=\"Ajouter des éléments liés à un dossier\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierAjoutElement.png\"></a>
		&nbsp;
		&nbsp;
		&nbsp;
		<a href=\"dossier_supprimer_element.php\" title=\"Supprimer des éléments liés à un dossier\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierSupElement.png\"></a>
		&nbsp;
		&nbsp;
		&nbsp;
		<a href=\"dossier_personnel.php\" title=\"Mes dossiers\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierGerer.png\"></a>
	</div>";
?>
</body>
</html>
