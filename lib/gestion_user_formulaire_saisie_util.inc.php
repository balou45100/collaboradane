<?php
	echo" <div align = \"center\">";
		echo "<h2>Saisie d'un-e nouvel-le utilisateur/trice</h2>";
		echo "<form action = \"gestion_user.php?action=O&amp;a_faire=verif_formulaire\" METHOD = \"POST\">";
			echo "<table>";
				echo "<tr>";
					echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations obligatoires</td>";
				echo "</tr>";
				echo "<tr>
					<td class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$prenom\" NAME = \"prenom\"></td>
				</tr>

				<tr>
					<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE = \"$nom\" NAME = \"nom\" SIZE=\"40\"></td>
				</tr>

				<tr>
					<td class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE = \"$mail\" NAME = \"mail\" SIZE=\"40\"></td>
				</tr>";

				echo "<tr>
					<td class = \"etiquette\">Mot de passe&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"password\" VALUE = \"\" NAME = \"password1\" SIZE=\"34\">&nbsp;</td>
				</tr>
				<tr>
					<td class = \"etiquette\">V&eacute;rification du mot de passe&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"password\" VALUE = \"\" NAME = \"password2\" SIZE=\"34\">&nbsp;</td>
				</tr>";

					echo "<td class = \"etiquette\">Appartenance structure&nbsp;:&nbsp;</td>";
					//On récupère les intitulés des structures
					$requete_structures = "SELECT * FROM util_structures";
					$resultat_requete_structures = mysql_query($requete_structures);
					if(!$resultat_requete_structures)
					{
						echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
						mysql_close();
						exit;
					}

					echo "<td>";
						echo "<select  size=\"1\" name = \"structure\">";
							while ($ligne_structure = mysql_fetch_object($resultat_requete_structures))
							{
								$id_structure = $ligne_structure->id_structure;
								$intitule_structure = $ligne_structure->intitule_structure;
								echo "<option value=\"$id_structure\" class = \"bleu\">$intitule_structure</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "<tr>";
					echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations facultatives</td>";
				echo "</tr>";
				
				echo "<!--tr>
					<td class = \"etiquette\">Identifiant&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"\" NAME = \"identifiant\" SIZE=\"34\">&nbsp;</td>
				</tr-->

				<tr>
					<td class = \"etiquette\">T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE = \"$num_tel\" NAME = \"num_tel\" SIZE=\"34\">&nbsp;</td>
				</tr>

				<tr>
					<td class = \"etiquette\">Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$poste_tel\" NAME = \"poste_tel\" SIZE=\"34\">&nbsp;</td>
				</tr>

				<tr>
					<td class = \"etiquette\">Mobile professionnel&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$num_tel_port\" NAME = \"num_tel_port\" SIZE=\"34\">&nbsp;</td>
				</tr>

				<tr>
					<td class = \"etiquette\">T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$num_tel_perso\" NAME = \"num_tel_perso\" SIZE=\"34\">&nbsp;</td>
				</tr>

				<tr>
					<td class = \"etiquette\">Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$tel_autre\" NAME = \"tel_autre\" SIZE=\"34\">&nbsp;</td>
				</tr>

				<tr>
					<td class = \"etiquette\">Mobile personnel&nbsp;:&nbsp;</td>
					<td>&nbsp;<input type=\"text\" VALUE =\"$num_tel_port_perso\" NAME = \"num_tel_port_perso\" SIZE=\"34\">&nbsp;</td>
				</tr>";

			echo "</table>";
			//echo "<INPUT TYPE = \"hidden\" VALUE = \"inscription\" NAME = \"type\">";

			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
				echo "<td>";
					echo "<a href = \"gestion_user.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";

		echo "</FORM>";
	echo "</div>";
?>
