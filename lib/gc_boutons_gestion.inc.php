<?php
	//Affichage des icônes pour la saisie des courriers et la gestion des cat&eacute;gories
	echo "<div align = \"center\">";
	echo "<table class = \"menu-boutons\">";
		echo "<tr>";
			//echo "<td align = \"center\">";
			echo "<td>";
				echo "<a href=\"gc_saisie.php?type_courrier=entrant\" target=\"zone_travail\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_entrant.png\" id=\"Image2\" title = \"Saisie courrier entrant\" align=\"top\" border=\"0\"></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp<a href=\"gc_saisie.php?type_courrier=sortant\" target=\"zone_travail\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_sortant.png\" id=\"Image2\" title = \"Saisie courrier sortant\" align=\"top\" border=\"0\"></a>";
				echo "<br />Saisie courrier";
			echo "</td>";

			//echo "<td align = \"center\">";
			echo "<td>";
				echo "<a href=\"gc_gestion_categorie.php\" target=\"zone_travail\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_categories.png\" title = \"G&eacute;rer les cat&eacute;gories\" align=\"top\" border=\"0\"></a>";
				echo "<br />Gestion cat&eacute;gories";
			echo "</td>";

			//echo "<td align = \"center\">";
			echo "<td>";
				echo "<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_entrant_imprimer.png\" id=\"Image4\" title = \"Imprimer liste courriers entrants\" align=\"top\" border=\"0\"></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_sortant_imprimer.png\" id=\"Image3\" title = \"Imprimer liste courriers sortants\" align=\"top\" border=\"0\"></a>";
				echo "<br />Listes courriers <i>(inactif)</i>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "</div>";
?>
