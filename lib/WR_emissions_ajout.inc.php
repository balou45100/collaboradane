<?php
	echo "<FORM ACTION = \"WR_emissions.php\" METHOD = \"POST\">";
		echo "<h2>Les d&eacute;tails &agrave; renseigner pour cr&eacute;er une nouvelle &eacute;mission</h2>";
		echo "<TABLE width=\"95%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionTitre \" name=\"EmissionTitre\" size=\"78\">&nbsp;&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";

			echo "<td class = \"etiquette\">Date de l'&eacute;mission&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" id=\"EmissionDateDiffusion\"  name=\"EmissionDateDiffusion\" value=\"\">";
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=EmissionDateDiffusion&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
			echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Horaires&nbsp;:&nbsp;</td>";
				echo "<td>
					de&nbsp;<input type=\"text\" value = \"$EmissionHeureDiffusionDebut\" name = \"EmissionHeureDiffusionDebut\" size=\"10\" title = \"ex : 15h30\">
					&nbsp;&agrave;&nbsp;<input type=\"text\" value = \"$EmissionHeureDiffusionFin\" name = \"EmissionHeureDiffusionFin\" size=\"10\" title = \"ex : 18h45\">&nbsp;
				</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Lieu d'enregistrement&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionLieuEnregistrement\" name = \"EmissionLieuEnregistrement\" size=\"78\">&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Classification&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select size=\"5\" name=\"EmissionCategories[]\" multiple>";
						//Selection des utilisateurs qui ne sont PAS dans le groupe actuel
						$requete = "SELECT * FROM WR_EmissionsCategories ORDER BY EmissionsCategorieNom";
						
						echo "<br />$requete";
						
						$resultat = mysql_query($requete);
						$num_rows = mysql_num_rows($resultat);
						
						if (mysql_num_rows($resultat))
						{	
							while ($ligne=mysql_fetch_array($resultat))
							{
								echo"<option value=\"".$ligne[0]."\">".$ligne[1]."</option>";
							}
						}
					echo"</select>";
				echo "</td>";
			echo "</tr>";
/*
			echo "<tr>";
				echo "<td class = \"etiquette\">Lieu de stockage des ressources&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionDossierStockage\" name=\"EmissionDossierStockage\" size=\"78\">&nbsp;</td>";
			echo "</tr>";
*/
			echo "<tr>";
				echo "<TD class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>";
				echo "<TD><textarea rows=\"4\" name=\"EmissionRemarques\" cols=\"100\">$EmissionRemarques</textarea></TD>";
			echo "</tr>";
		echo "</table>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">
		<INPUT TYPE = \"hidden\" VALUE = \"enreg_emission\" NAME = \"a_faire\">";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"WR_emissions.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
					echo "</tr>";
			echo "</table>";
		echo "</div>";
	echo "</FORM>";
	$affichage = "N";
?>
