<?php
		echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				if ($page_appelant == "reunion")
				{
					echo "<td align = \"center\">";
						//echo "<a href=\"om_saisie_reunion_etape1.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" title = \"Saisir une r&eacute;union\" align=\"top\" border=\"0\"></a>";
						echo "<a href=\"om_affichage_reunion.php?action=O&amp;a_faire=saisie_reunion\" target=\"_SELF\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/reunion_ajout.png\" title = \"Saisir une r&eacute;union\" align=\"top\" border=\"0\"></a>";
						echo "<br />&nbsp;Saisir une r&eacute;union&nbsp;";
					echo "</td>";
				}

				echo "<td align = \"center\">";
					echo "<a href=\"om_cadre_reunions.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/reunion.png\" id=\"Image1\" title = \"G&eacute;rer les r&eacute;unions\" align=\"top\" border=\"0\"></a>";
					echo "<br />&nbsp;Gestion des r&eacute;unions&nbsp;";
				echo "</td>";

				echo "<td align = \"center\">";
					echo "<a href=\"om_cadre_om.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/om.png\" id=\"Image1\" title = \"G&eacute;rer les ordres de mission\" align=\"top\" border=\"0\"></a>";
					//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier_sortant_imprimer.png\" id=\"Image3\" title = \"Imprimer liste courriers sortants\" align=\"top\" border=\"0\"></a>";
					echo "<br />Gestion des ordres de mission";
				echo "</td>";

			echo "</tr>";
		echo "</table>";
		echo "</div>";
?>
