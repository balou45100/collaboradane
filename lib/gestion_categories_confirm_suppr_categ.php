<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><h2>$message_non_connecte1</h2></center>";
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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
				$id_categ = $_GET['id_categ'];
				$id_categ_pere = $_GET['id_categ_pere'];
				if(!isset($id_categ) || $id_categ == "")
				{
					echo "<h2>Identifiant de la cat&eacute;gorie inexistant</h2>";
					echo "<BR><BR><A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class = \"bouton\">Retour &agrave; la gestion des cat&eacute;gories</A>";
					exit;
				}
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				include("../biblio/fct.php");
				
				//Appel de la fonction pour supprimer une catégorie
				suppr_r($id_categ);
				
				echo "<h2>La cat&eacute;gorie et ses sous-cat&eacute;gorie ont &eacute;t&eacute; supprim&eacute;s</h2>";
				echo "<BR><BR> <A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class = \"bouton\">Retour &agrave; la gestion des cat&eacute;gories</A>";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_categories.php?id_categ=-1\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				
				//Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
				
