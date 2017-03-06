<?php
	echo "<form method=\"post\" action=\"om_affichage_reunion.php\">";
		echo "<h2>Saisie d'une r&eacute;union</h2>";
		echo "<!--p><center>Veuillez compl&eacute;ter le formulaire suivant en remplissant tout les champs: </center></p-->";
		
		echo "<table>
			<tr>
				<!--td colspan=3><h3>Informations g&eacute;n&eacute;rales</h3></td>
			</tr-->
				<td class = \"etiquette\">Intitul&eacute;&nbsp;:</td>
				<td><input type=\"text\" id=\"intitule\"  name=\"intitule\" value=\"\" size = \"50\"></td>
			</tr>
			<tr>
				<td class = \"etiquette\">Description&nbsp;:</td>
				<td><TEXTAREA NAME=\"description\" ROWS=\"4\" COLS=\"50\"></TEXTAREA></td>
			</tr>
			<tr>
				<td class = \"etiquette\">Date du d&eacute;but&nbsp;:&nbsp;<!--p><br />(format: JJ-MM-AAAA)</p--></td>
				<td>
					<input type=\"text\" id=\"datedebut\"  name=\"datedebut\" value=\"\">
					<!--input type=\"text\" name=\"datedebut\" size=\"50\"-->";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datedebut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
				echo "</td>
			</tr>
			<tr>
				<td class = \"etiquette\">Heure du d&eacute;but&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
				<td><input type=\"text\" name=\"heuredebut\" size=\"10\"></td>
			</tr>
			<tr>
				<td class = \"etiquette\">Date de fin&nbsp;:&nbsp;<!--p><br>(format: JJ-MM-AAAA)</p--></td>
				<td>
					<!--input type=\"text\" name=\"datefin\" size=\"50\"-->
					<input type=\"text\" id=\"datefin\"  name=\"datefin\" value=\"\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datefin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
				echo "</td>
			</tr>
			<tr>
				<td class = \"etiquette\">Heure de fin&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
				<td><input type=\"text\" name=\"heurefin\" size=\"10\"></td>
			</tr>
			<!--tr>
				<td class = \"etiquette\">Intitul&eacute; de la mission&nbsp;:</td>
				<td><TEXTAREA NAME=\"description\" ROWS=\"5\" COLS=\"38\"></TEXTAREA></td>
			</tr-->
			<!--tr>
				<td align = center colspan=3><input type=submit name=\"Suivant\" value=\"&Eacute;tape suivante&nbsp;>>>\"/></td>
			</tr-->";

			echo "<tr>";
				//Choix de l'ann&eacute;e
				//echo "<br />annee_en_cours : $annee_en_cours";
				
				$anne_scolaire_a_afficher_par_defaut = $annee_en_cours+1;
				echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
				echo "<td><select size=\"1\" name=\"annee\">";
				echo "<option selected value=\"$annee_en_cours\">$annee_en_cours</option>";
					for($annee = $annee_en_cours-1; $annee >1999; $annee-- )
					{
						echo "<option value=\"$annee\">$annee</option>";
					}
				echo "</select></td>";
			echo "</tr>";

			echo "<tr>";
				//Choix du responsable
				$requeteliste_responsable="SELECT * FROM om_responsables ORDER BY nom_responsable ASC";
				$result=mysql_query($requeteliste_responsable);
				$num_rows = mysql_num_rows($result);

				echo "<td class = \"etiquette\">Responsable&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"id_responsable\">";

				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"-1\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result))
					{
						$id_responsable=$ligne->id_responsable;
						$nom_responsable=$ligne->nom_responsable;
						$prenom_responsable=$ligne->prenom_responsable;
						echo "<option value=\"$id_responsable\">$nom_responsable, $prenom_responsable</option>";
					}
				}
				echo "</select></td>";
			echo "</tr>";
			
			echo "<tr>";
				//Choix de l'enveloppe budgétaire
				$requeteliste_enveloppe="SELECT * FROM om_enveloppe_budgetaire ORDER BY ref_enveloppe_budgetaire ASC";
				$result=mysql_query($requeteliste_enveloppe);
				$num_rows = mysql_num_rows($result);

				echo "<td class = \"etiquette\">Enveloppe budg&eacute;taire&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"ref_enveloppe_budgetaire\">";

				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"-1\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result))
					{
						$ref_enveloppe_budgetaire=$ligne->ref_enveloppe_budgetaire;
						$intitule_enveloppe_budgetaire=$ligne->intitule_enveloppe_budgetaire;
						echo "<option value=\"$ref_enveloppe_budgetaire\">$ref_enveloppe_budgetaire - $intitule_enveloppe_budgetaire</option>";
					}
				}
				echo "</select></td>"; 
			echo "</tr>";

			echo "<tr>";
				//Choix du centre de coût
				$requeteliste_centre_cout="SELECT * FROM om_centre_couts ORDER BY ref_centre_cout ASC";
				$result=mysql_query($requeteliste_centre_cout);
				$num_rows = mysql_num_rows($result);

				echo "<td class = \"etiquette\">Centre co&ucirc;t Chorus&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"ref_centre_cout\">";

				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"-1\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result))
					{
						$ref_centre_cout=$ligne->ref_centre_cout;
						$intitule_centre_cout=$ligne->intitule_centre_cout;
						echo "<option value=\"$ref_centre_cout\">$ref_centre_cout - $intitule_centre_cout</option>";
					}
				}
				echo "</select></td>"; 
			echo "</tr>";
		echo "</table>";

		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer la r&eacute;union</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
		//echo "<input type=hidden name=\"Suivant\" value=\"XX\"/>";
		echo "<input type=hidden name=\"a_faire\" value=\"enregistrer_reunion\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
	echo "</form>";
?>
