<?php
	echo "<div align = \"center\">";
		echo "<h1>Ajout d'un-e intervenant-e</h1>";
		echo "<form action=\"WR_intervenants.php\" method=\"post\">";
		echo "<table border = \"1\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Titre&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"\" name=\"IntervenantTitre\" size=\"78\">&nbsp;&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Sexe&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select name='IntervenantSexe'>";
						echo "<option value='F'>F</option>";
						echo "<option value='M'>M</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantNom\" size = \"30\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantPrenom\" size = \"30\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Adresse&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantAdresse1\" size = \"60\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Compl&eacute;ment d'adresse&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantAdresse2\" size = \"60\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Code postal&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantCodePostal\" size = \"10\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Ville&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantVille\" size = \"60\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Pays&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantPays\" size = \"60\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">T&eacute;l fixe&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantTelFixe\" size = \"10\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">T&eacute;l mobile&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantTelMobile\" size = \"10\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Courriel&nbsp;:&nbsp;</td>";
				echo "<td ><input type = \"text\" name=\"IntervenantCourriel\" size = \"60\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
				echo "<td><TEXTAREA ROWS = \"4\" COLS = \"60\" NAME = \"IntervenantRemarques\"></TEXTAREA>";
					echo "<script type=\"text/javascript\">
					CKEDITOR.replace( 'IntervenantRemarques' );
				</script></td>";

			echo "</tr>";
		echo "</table>";
			//echo "<br><input type=\"submit\" name=\"bouton_envoyer\" Value = \"Enregistrer l'intervenant-e\"/>";
			//echo "<input type=\"submit\" name=\"bouton_envoyer\" Value = \"Retourner sans enregistrer\"/>";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_intervenant\" NAME = \"a_faire\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"WR_intervenants.php?bouton_envoyer=Retourner sans enregistrer\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
						//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
						echo "<td>";
							echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
						echo "</TD>";
						echo "</tr>";
				echo "</table>";
			echo "</div>";
		echo "</form>";
	echo "</div>";
?>
