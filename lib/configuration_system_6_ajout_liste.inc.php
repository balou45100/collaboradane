<?php
	echo "<h2>Ajout d'une nouvelle liste</h2>";
	
	//On afiche le formulaire pour la saisie de l'intitule de la nouvelle liste
	echo "<form action=\"configuration_systeme_6.php\" method=\"get\">";
		
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Intitul&eacute; de la nouvelle liste&nbsp;:&nbsp;</td>";
				
				echo "<td><input type=\"text\" id=\"intitule\" name=\"intitule\" SIZE = \"40\" required />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Valider<br />le formulaire</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"$nom_table\" NAME = \"nom_table\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_liste\" NAME = \"a_faire\">";
	echo "</form>";

?>
