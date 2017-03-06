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
echo"
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
echo"
</head>
<body class = \"menu-boutons\">";

/*
	echo'
	&nbsp;&nbsp;<form action="om_affichage_om.php" target="body" method="post">';
	echo'&nbsp;Personnes : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="searchpers"/>&nbsp;
	&nbsp;&nbsp;Etat :
	<select name="etat">
	<option value="">Tout</option>
	<option value="0">non traité</option>
	<option value="1">traité</option>
	</select>&nbsp;&nbsp;&nbsp;

	<select name="etat_om">
	<option value="">Tout</option>
	<option value="C">Convoqué</option>
	<option value="P">Présent</option>
	<option value="A">Absent</option>
	<option value="V">Validé</option>
	<option value="R">Refusé</option>
	</select>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="validRecherche_om" value="Rechercher" />
	</form>';
*/
?>
</body>
</html>

