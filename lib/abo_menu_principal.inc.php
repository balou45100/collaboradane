<?php
		echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";

				echo "<td align = \"center\">";
					echo "&nbsp;<a href=\"abo_cadre_abo.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements.png\" title = \"Liste des abonnements\" align=\"top\" border=\"0\"></a>";
					//echo "<br />&nbsp;Liste des abonnements&nbsp;";
				echo "&nbsp;</td>";

				echo "<td align = \"center\">";
					echo "&nbsp;<a href=\"abo_cadre_magazine.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements_numeros.png\" id=\"Image1\" title = \"Liste des magazines\" align=\"top\" border=\"0\"></a>";
					//echo "<br />&nbsp;Liste des magazines&nbsp;";
				echo "&nbsp;</td>";

				echo "<td align = \"center\">";
					echo "&nbsp;<a href=\"abo_cadre_emprunt.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements_emprunteurs.png\" id=\"Image2\" title = \"Liste des emprunts\" align=\"top\" border=\"0\"></a>";
					//echo "<br />&nbsp;Liste des emprunts&nbsp;";
				echo "&nbsp;</td>";

				echo "<td align = \"center\">";
					echo "&nbsp;<a href=\"abo_cadre_renouv.php\" target=\"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements_renouvellements.png\" id=\"Image2\" title = \"Liste des renouvellements\" align=\"top\" border=\"0\"></a>";
					//echo "<br />&nbsp;Liste des renouvellements&nbsp;";
				echo "&nbsp;</td>";

				echo "<td align = \"center\">";
					echo "&nbsp;<a href=\"abo_gestion_categories.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categories.png\" id=\"Image2\" title = \"Gestion des cat&eacute;gories\" align=\"top\" border=\"0\"></a>";
					//echo "<br />&nbsp;Gestion des cat&eacute;gories&nbsp;";
				echo "&nbsp;</td>";

		if ($page_appelant == "gestion_categories")
		{
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "<a href=\"abo_gestion_categories.php?origine_gestion=filtre&amp;actions=O&amp;a_faire=ajout_categorie&amp;traitement=$traitement\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categorie_ajout.png\" id=\"Image2\" title = \"Ajouter cat&eacute;gorie\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Ajouter une cat&eacute;gorie&nbsp;";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		}

		if ($page_appelant == "abo")
		{
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
					echo "<td align = \"center\">";
						echo "<a href=\"abo_affichage_abo.php?action=O&amp;a_faire=ajout_abonnement\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnement_ajout.png\" title = \"Ajouter un abonnement\" align=\"top\" border=\"0\"></a>";
						echo "<br />&nbsp;Ajouter un abonnement&nbsp;";
					echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		}

		if ($page_appelant == "renouv")
		{
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
					echo "<td align = \"center\">";
						echo "<a href=\"abo_ajout_renouv.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements_renouvellements_ajout.png\" title = \"Ajouter un renouvellement\" align=\"top\" border=\"0\"></a>";
						echo "<br />&nbsp;Ajouter un renouvellement&nbsp;";
					echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		}
?>
