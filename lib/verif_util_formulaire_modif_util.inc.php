<?php
	echo "<FORM ACTION = \"verif_util.php\" METHOD = \"POST\">
		<TABLE BORDER = \"0\">
			<TR>
				<td class = \"etiquette\">
					Pr&eacute;nom&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$prenom."\" NAME = \"prenom\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					Nom&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$nom."\" NAME = \"nom\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					M&eacute;l&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$mail."\" NAME = \"mail\" SIZE = \"40\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					Identifiant&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$identifiant."\" NAME = \"identifiant\" SIZE = \"40\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$num_tel."\" NAME = \"num_tel\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$poste_tel."\" NAME = \"poste_tel\">
				</TD>
			</TR>

			<TR>
				<td class = \"etiquette\">
					Mobile professionnel&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$num_tel_port."\" NAME = \"num_tel_port\">
				</TD>
			</TR>
			<TR>
				<td class = \"etiquette\">
					T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$num_tel_perso."\" NAME = \"num_tel_perso\">
				</TD>
			</TR>
			<TR>
				<td class = \"etiquette\">
					Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$tel_autre."\" NAME = \"tel_autre\">
				</TD>
			</TR>
			<TR>
				<td class = \"etiquette\">
					Mobile personnel&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"text\" VALUE = \"".$num_tel_port_perso."\" NAME = \"num_tel_port_perso\">
				</TD>
			</TR>";

			echo "<tr>";
				$requete_themes="SELECT * FROM themes_interface ORDER BY id";
				$resultat_themes=mysql_query($requete_themes);
				$num_rows = mysql_num_rows($resultat_themes);
					echo "<td class = \"etiquette\">th&egrave;me choisi&nbsp;:&nbsp;</td>";
					echo "<td>&nbsp;";
						echo "<select size=\"1\" name=\"choix_theme\">";
						//On extrait les thèmes de la table themes_interface
						while ($ligne_theme_extrait=mysql_fetch_object($resultat_themes))
						{
							$intitule_theme_extrait=$ligne_theme_extrait->intitule;
							$id_theme_extrait = $ligne_theme_extrait->id;
							$remarques_theme_extrait = $ligne_theme_extrait->remarques;
							if ($id_theme_extrait == $choix_theme)
							{
								echo "<option selected value=\"$id_theme_extrait\">$intitule_theme_extrait ($remarques_theme_extrait)</option>";
							}
							else
							{
								echo "<option value=\"$id_theme_extrait\">$intitule_theme_extrait ($remarques_theme_extrait)</option>";
							}
						}
				echo "</tr>";

			if($type == "inscription")
			{
				echo"<TR>
					<td class = \"etiquette\">
						Droit&nbsp;:&nbsp;
					</TD>
					<td>
						<SELECT NAME = \"droit\">
							<OPTION SELECTED = ".$selected." VALUE = ".$selected.">".$selected."</OPTION>
							<OPTION VALUE = ".$other.">".$other."</OPTION>
						</SELECT>
					</TD>
				</TR>";
			}

			echo "<TR>
				<td class = \"etiquette\">
					Mot de passe&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"password\" VALUE = \"$password1_a_afficher\" NAME = \"password1\">
				</TD>
			</TR>
			<TR>
				<td class = \"etiquette\">
					R&eacute;p&eacute;tez le mot de passe&nbsp;:&nbsp;
				</TD>
				<td>
					<INPUT TYPE = \"password\" VALUE = \"$password2_a_afficher\" NAME = \"password2\">
				</TD>
			</TR>";

			echo"<TR>
				<td class = \"etiquette\">
					<INPUT TYPE = \"hidden\" VALUE = \"".$type."\" NAME = \"type\">
				</TD>
				<td>
					<INPUT TYPE = \"submit\" VALUE = \"Enregistrer les modifications\">
				</TD>
			</TR>
		</TABLE>";

		//on fixe le script du retour
		switch ($type)
		{
			case 'modification_perso':
				$retour = "reglages.php";
			break;

			case 'modification':
				$retour = "gestion_user.php?indice=0";
			break;
		}
	
		//echo "<br />retour : $retour";
	
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer les modifications</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
	echo "</FORM>";

?>
