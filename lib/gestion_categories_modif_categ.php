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
				
				//Récupération de la variable
				$id_categ = $_GET['id_categ'];
				
				//Test du champ récupéré
				if(!isset($id_categ) || $id_categ == "")
				{
					echo "Erreur de passage d'argument";
					echo "<A HREF = \"gestion_categories.php?id_categ=-1\" TARGET = \"body\"><BR>Retour à la gestion des catégories</A>";
					exit;
				}
				echo "<h2>Modification de la cat&eacute;gorie $id_categ</h2>";

				$query = "SELECT * FROM categorie WHERE ID_CATEG = '".$id_categ."';";
				$results = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results)
				{
					echo "<h2>erreur de requète</h2>";
					echo "<A HREF = \"gestion_categories.php?id_categ=-1\" TARGET = \"body\" class = \"bouton\"><BR>Retour à la gestion des catégories</A>";
					mysql_close();
					exit;
				}
				
				$res = mysql_fetch_row ($results);
				
				echo "<FORM ACTION = \"gestion_categories_verif_categ.php\" METHOD = \"POST\">";
					echo "<TABLE BORDER = \"0\">";
						echo "<TR>";
							echo "<TD class = \"etiquette\">";
								echo "Nom de la cat&eacute;gorie&nbsp;:&nbsp;";
							echo "</TD>";
							echo "<TD class = \"td-1\">";
								echo "<INPUT TYPE = \"text\" NAME = \"nom\" VALUE = \"".$res[1]."\" SIZE = \"40\">";
								echo "<INPUT TYPE = \"hidden\" NAME = \"stat\" VALUE = \"M\">";
								echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ\" VALUE = \"".$res[0]."\">";
								echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ_pere\" VALUE = \"".$res[6]."\">";
							echo "</TD>";
						echo "</TR>";
						echo "<TR>";
							echo "<TD class = \"etiquette\">";
								echo "Info compl&eacute;mentaire&nbsp;:&nbsp;";
							echo "</TD>";
							echo "<TD class = \"td-1\">";
								echo "<TEXTAREA ROWS = \"15\" COLS = \"120\" NAME = \"contenu\">".$res[4]."</TEXTAREA>";
							echo "</TD>";
						echo "</TR>";
/*
						echo "<TR>";
							echo "<TD class = \"etiquette\">";
								echo "<INPUT TYPE = \"submit\" VALUE = \"Ok\">";
							echo "</TD>";
						echo "</TR>";
*/
					echo "</TABLE>";

					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"gestion_categories.php?id_categ=$res[6]\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
							echo "</td>";
								echo "<td>";
								echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
							echo "</TD>";
						echo "</tr>";
					echo "</table>";
				echo "</FORM>";
				
				//Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
