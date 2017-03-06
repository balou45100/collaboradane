<?php
//Fixer les couleurs des cellules
	$emetteur = $_SESSION['nom']; //pour pré-remplir le champ propriétaire

	//echo "<BR> Je suis dans la procédure de modification du contact id_contact";
	//echo "<BR>3. id_societe : $id_societe";
	//$id_societe = $_GET['id_societe'];

	$lar_etiquette = "15%"; //pour les lignes qui comportent 2 champs
	$lar_champ_donnees = "35%"; //pour les lignes qui comportent 2 champs
	$lar_etiquette_petit = "10%";
	$lar_champ_donnees_grand = "40%";     

	echo "<TABLE width = \"95%\">
		<TR>
			<TD width = \"15%\" class = \"etiquette\">Prénom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE = \"\" NAME = \"prenom\" SIZE=\"34\"></TD>
			<TD width = \"15%\" class = \"etiquette\">Nom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"nom\" SIZE=\"34\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"4\" align = \"center\">Renseignements professionnels</th>
		</TR>";
		if ($affiche_societe <> "N") //Le formulaire est apppelé du module Répertoire et la société est connue et ne doit pas être saisie
		{
			echo "<TR>
				<TD width = $lar_etiquette_petit class = \"etiquette\">Soci&eacute;t&eacute;&nbsp;:&nbsp;</TD>
				<TD colspan = \"3\">";
				//Requète pour selectionner tous les enregistrements de la table repertoire
				$query_societe = "SELECT * FROM repertoire ORDER BY 'societe'";
				$results_societe = mysql_query($query_societe);
				if(!$results_societe)
				{
					echo "<B>Problème de connexion à la base de données</B>";
					echo "<A HREF = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
					mysql_close();
					exit;
				}
				//Retourne le nombre de ligne rendu par la requète
				$num_results_societe = mysql_num_rows($results_societe);

				echo "<SELECT NAME = id_societe>";
					echo "<OPTION SELECTED = \"null\" VALUE = \"null\"></OPTION>";
						$res_societe = mysql_fetch_row($results_societe);
						for ($j = 0; $j < $num_results_societe; ++$j)
						{
							echo "<OPTION VALUE=".$res_societe[0].">".$res_societe[0]." -- ".str_replace("*", " ",$res_societe[1])." - ".str_replace("*", " ",$res_societe[4])."</OPTION>";
							//echo "<OPTION VALUE=".$res_societe[0].">".str_replace("*", " ",$res_societe[1])." - ".str_replace("*", " ",$res_societe[4])."</OPTION>";
							$res_societe = mysql_fetch_row($results_societe);
						}
					echo "</SELECT>
				</td>";

				echo "</TD>
			</TR>
			<TR>
				<TD width = $lar_etiquette_petit class = \"etiquette\">ECL&nbsp;:&nbsp;</TD>
				<TD colspan = \"3\">";
					//Requète pour selectionner tous les établissements
					$query_etab = "SELECT * FROM etablissements";
					$results_etab = mysql_query($query_etab);
					if(!$results_etab)
					{
						echo "<B>Problème de connexion à la base de données</B>";
						echo "<A HREF = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requète
					$num_results_etab = mysql_num_rows($results_etab);
					echo "<SELECT NAME = id_etab>";
						echo "<OPTION SELECTED = \"null\" VALUE = \"null\"></OPTION>";
						$res_etab = mysql_fetch_row($results_etab);
						for ($j = 0; $j < $num_results_etab; ++$j)
						{
							echo "<OPTION VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." -- ".$res_etab[5]."</OPTION>";
								$res_etab = mysql_fetch_row($results_etab);
						}
					echo "</SELECT>
				</td>
			</TR>";
		} //Fin if ($affiche_societe <> "N")
		echo "<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"adresse\" SIZE=\"60\"></TD>
		</TR>
			<TR>
				<TD width = $lar_etiquette_petit class = \"etiquette\">CP&nbsp;:&nbsp;</TD>
				<TD width = $lar_etiquette_petit><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"code_postal\" SIZE=\"10\"></TD>
				<TD width = $lar_etiquette_petit class = \"etiquette\">Ville&nbsp;:&nbsp;</TD>
				<TD><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"ville\" SIZE=\"60\"></TD>
			</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Fonction&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"fonction\" SIZE=\"34\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Service&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"service\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l.&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"tel_directe\" SIZE=\"34\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Fax&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"fax\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l. mobile&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"mobile\" SIZE=\"34\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"mel_pro\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"page_web_pro\" SIZE=\"60\"></a></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"4\" align = \"center\">Renseignements personnels</th>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"adresse_perso\" SIZE=\"60\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">CP&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"code_postal_perso\" SIZE=\"10\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Ville&nbsp;:&nbsp;</TD>
			<TD><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"ville_perso\" SIZE=\"60\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l.&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"tel_perso\" SIZE=\"34\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Fax&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"fax_perso\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l. mobile&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"mobile_perso\" SIZE=\"34\"></TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"mel_perso\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"\" NAME = \"page_web_perso\" SIZE=\"60\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"6\" align = \"center\">Autres renseignements</th>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Confidentialit&eacute;&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit class = \"td-1\"><select size=\"1\" name=\"statut\">
				<option selected value=\"public\">Public (visible pour tous)
					<option value=\"public\">Public (visible pour tous)</option>
					<option value=\"privé\">Privé</option>
				</select>
			</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</TD>
			<TD width = \"30%\" class = \"td-1\">";
				include("../biblio/init.php");
				$requeteliste_cat="SELECT DISTINCT INTITULE_CATEG FROM contacts_categories ORDER BY 'INTITULE_CATEG'";
				$result=mysql_query($requeteliste_cat);
				$num_rows = mysql_num_rows($result);
				echo "<select size=\"1\" name=\"categ\">";
					if (mysql_num_rows($result))
					{
						echo "<option selected value=\"PROFESSIONNEL\">PROFESSIONNEL</option>";
						while ($ligne=mysql_fetch_object($result))
						{
							$categ=$ligne->INTITULE_CATEG;
							echo "<option value=\"$categ\">$categ</option>";
						}
					}
				echo "</SELECT> 
			</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Propri&eacute;taire&nbsp;:&nbsp;</TD>
			<TD width = \"30%\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"".$emetteur."\" NAME = \"emetteur\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>
			<TD colspan = \"5\" class = \"td-1\"><textarea rows=\"3\" name=\"remarques\" cols=\"60\">".$contact_extrait[13]."</textarea></TD>
		</TR>
		<!--TR>
			<TD colspan=\"6\" class = \"td-1\" align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Enregistrer le contact\"></TD>
		</TR-->
	</TABLE>
	<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
	<INPUT TYPE = \"hidden\" VALUE = \"enreg_contact_ajoute\" NAME = \"action\">";
	if ($affiche_societe == "N") //Le formulaire est apppelé du module Répertoire et la société est connue et doit être transmise
	{
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">";
	}

	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
				echo "<td>";
					echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le contact\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";


?>
