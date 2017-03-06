<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		echo "<body>";
			echo "<h2>Suivi des dossiers - Ent&ecirc;te en d&eacute;veloppement ; accueillera des possibilit&eacute;es de filtrer les enregistrements</h2>";
		echo "</body>";
	echo "</html>";
?>
