<?php
	/*
	echo "<br />cardie_gestion_ajout_lien_inc.php";
	echo "<br />id_projet : $id_projet";
	*/
	echo "<form action = cardie_gestion_projets.php action=get>";
		echo "<table>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Nom du lien&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;<input name=intitule size=60 maxlength=60 required></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Adresse du lien&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;<input name=adresse size=120 maxlength=255 required></td>";
			echo "</tr>";
		echo "</table>";
		echo "<input type = \"hidden\" name = \"action\" value= \"O\">";
		echo "<input type = \"hidden\" name = \"a_faire\" value=\"enregistrer_lien\">";
		echo "<input type = \"hidden\" name = \"id_projet\" value = \"$id_projet\">";
		echo "<input type = \"hidden\" name = \"mes_projets\" value = \"$mes_projets\">";
		echo "<input type = \"hidden\" name = \"retour\" value= \"$retour\">";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le lien\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

	echo "</form>";
?>
