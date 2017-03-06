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

	$theme = $_SESSION['chemin_theme']."WR_principal.css";

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Webradio</title>
		<!--META http-EQUIV="Refresh" CONTENT="0; url=lib/connexion.php"-->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>

	</head>
	<body>
<?php
	$script = "accueil";
	include ("WR_menu_barre.php");
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	enreg_utilisation_module("WRA");
	$droit = "O";
	/*
	echo "<br />largeur_icone_action : $largeur_icone_action";
	echo "<br />hauteur_icone_action : $hauteur_icone_action";
	*/
	//echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_webradio.png\" ALT = \"Titre\">";
	echo "<img class = \"logo\" src = \"$chemin_theme_images/logo_webradio.png\" ALT = \"Logo\">";

		echo "<h1>Gestion Webradio</h1>";
		echo "<h2>Menu</h2>";

		echo "<table class=\"menu_table\">";
			echo "<tr>";
				echo "<td>";
					echo "<div id=\"menu_11\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_emissions.php\"><img src = \"$chemin_theme_images/WR_menu_option_11.jpg\" title = \"Les &eacute;missions\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_11.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";
					
					echo "<div id=\"menu_12\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_conducteurs.php\"><img src = \"$chemin_theme_images/WR_menu_option_12.jpg\" title = \"Les conducteurs\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_12.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";


					echo "<div id=\"menu_13\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_ressources.php\"><img src = \"$chemin_theme_images/WR_menu_option_13.jpg\" title = \"Les ressources\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_13.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";

					
					echo"<div id=\"menu_14\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_emissions_categories.php\"><img src = \"$chemin_theme_images/WR_menu_option_14.jpg\" title = \"Cat&eacute;gories d'&eacute;mission\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_14.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";

					echo"<div id=\"menu_21\">";

						if ($droit <> "N")
						{
							echo "<a href = \"WR_ressources_categories.php\"><img src = \"$chemin_theme_images/WR_menu_option_21.jpg\" title = \"Cat&eacute;gories des ressources\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_21.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";

					echo "<div id=\"menu_22\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_intervenants.php\"><img src = \"$chemin_theme_images/WR_menu_option_22.jpg\" title = \"Les intervenants\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_22.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";

					
					echo "<div id=\"menu_23\">";
						if ($droit <> "N")
						{
							echo "<a href = \"WR_partenaires.php\"><img src = \"$chemin_theme_images/WR_menu_option_23.jpg\" title = \"Les partenaires\" /></a>";
						}
						else
						{
							echo "<img src = \"$chemin_theme_images/WR_menu_option_23.jpg\" title = \"Vous n'avez pas acc&egrave;s &agrave; cette fonction !\" />";
						}
					echo "</div>";
					
					echo "<div id=\"menu_24\">
						<img src = \"$chemin_theme_images/WR_menu_option_00.jpg\" title = \"Enregistrer une &eacute;mission\" />
						<!--img src = \"$chemin_theme_images/WR_menu_option_24.jpg\" title = \"Enregistrer une &eacute;mission\" /-->
					</div>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

?>
	</body>
</html>
