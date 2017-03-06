<?php
	//echo "<FORM ACTION = \"verif_categ.php\" METHOD = \"POST\">";
	echo "<FORM ACTION = \"gestion_categories.php\" METHOD = \"POST\">";
		echo "<TABLE BORDER = \"0\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Nom de la catégorie&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<INPUT TYPE = \"text\" NAME = \"nom\" VALUE = \"".$nom."\" SIZE = \"40\">";
					
					//echo "<INPUT TYPE = \"hidden\" NAME = \"stat\" VALUE = \"I\">";
					echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ_pere\" VALUE = \"".$id_categ."\">";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Info compl&eacute;mentaire&nbsp;:&nbsp;</td>";
				echo "<td><TEXTAREA ROWS = \"10\" COLS = \"90\" NAME = \"contenu\">$contenu</TEXTAREA>";
				echo "</td>";
			echo "</tr>";
		echo "</TABLE>";

		//echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"gestion_categories.php?id_categ=$id_categ\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
						echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer la cat&eacute;gorie\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />la cat&eacute;gorie</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";
			echo "<INPUT TYPE = \"hidden\" NAME = \"action\"VALUE = \"O\">";
			echo "<INPUT TYPE = \"hidden\" NAME = \"a_faire\"VALUE = \"enreg_categorie\">";
			echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ\"VALUE = \"$id_categ\">";
		//echo "</div>";
	echo "</FORM>";
?>
