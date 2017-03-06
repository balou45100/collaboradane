<?php
	//echo "<BR> Je suis dans la procédure de modification du contact id_contact";
	$id_contact = $_GET['id_contact'];

	include("../biblio/init.php");
	$query_contact = "SELECT DISTINCT * FROM contacts WHERE id_contact = $id_contact;";
	$results_contact = mysql_query($query_contact);
	$num_results_contact = mysql_num_rows($results_contact);
	$contact_extrait = mysql_fetch_row($results_contact);

	$lar_etiquette = "15%"; //pour les lignes qui comportent 2 champs
	$lar_champ_donnees = "35%"; //pour les lignes qui comportent 2 champs
	$lar_etiquette_petit = "10%";
	$lar_champ_donnees_grand = "40%";     

	echo "<TABLE width = \"95%\">
		<TR>
			<TD class = \"etiquette\" width = \"5%\">Id&nbsp;:&nbsp;</TD>
			<TD width = \"5%\">".$contact_extrait[0]."</TD>
			<TD class = \"etiquette\" width = \"10%\">Prénom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE = \"$contact_extrait[3]\" NAME = \"prenom\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = \"10%\">Nom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[2]\" NAME = \"nom\" SIZE=\"34\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan = \"4\">Renseignements professionnels</th>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[5]\" NAME = \"adresse\" SIZE=\"60\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>CP&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[6]\" NAME = \"code_postal\" SIZE=\"10\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Ville&nbsp;:&nbsp;</TD>
			<TD><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[7]\" NAME = \"ville\" SIZE=\"60\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>Fonction&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[4]\" NAME = \"fonction\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Service&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[17]\" NAME = \"service\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>T&eacute;l.&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[8]\" NAME = \"tel_directe\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Fax&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"".$contact_extrait[9]."\" NAME = \"fax\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>T&eacute;l. mobile&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"".$contact_extrait[10]."\" NAME = \"mobile\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[11]\" NAME = \"mel_pro\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[25]\" NAME = \"page_web_pro\" SIZE=\"60\"></a></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan = \"4\">Renseignements personnels</th>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[20]\" NAME = \"adresse_perso\" SIZE=\"60\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>CP&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[21]\" NAME = \"code_postal_perso\" SIZE=\"10\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Ville&nbsp;:&nbsp;</TD>
			<TD><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[22]\" NAME = \"ville_perso\" SIZE=\"60\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>T&eacute;l.&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[18]\" NAME = \"tel_perso\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Fax&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[24]\" NAME = \"fax_perso\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>T&eacute;l. mobile&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[23]\" NAME = \"mobile_perso\" SIZE=\"34\"></TD>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[12]\" NAME = \"mel_perso\" SIZE=\"34\"></TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" width = $lar_etiquette>Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"$contact_extrait[19]\" NAME = \"page_web_perso\" SIZE=\"60\"></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan = \"6\">Autres renseignements</th>
		</TR>";
		if ($contact_extrait[14] == $_SESSION['nom'])
		{
			$proprietaire = "O"; //permet de dire que la fiche modifié appartient à la personne connectée
			echo "<TR>
				<TD class = \"etiquette\" width = $lar_etiquette_petit>Confidentialit&eacute;&nbsp;:&nbsp;</TD>
				<td width = $lar_etiquette_petit class = \"td-1\">
					<select size=\"1\" name=\"statut\">
						<option selected value=\"".$contact_extrait[15]."\">".$contact_extrait[15]."
						<option value=\"public\">Public (visible pour tous)</option>
						<option value=\"privé\">Privé</option>
					</select>
				</TD>
				<TD class = \"etiquette\" width = $lar_etiquette_petit>Cat&eacute;gorie&nbsp;:&nbsp;</TD>
				<TD width = \"30%\" class = \"td-1\">";
					include("../biblio/init.php");
					$requeteliste_cat="SELECT DISTINCT INTITULE_CATEG FROM contacts_categories ORDER BY 'INTITULE_CATEG'";
					$result=mysql_query($requeteliste_cat);
					$num_rows = mysql_num_rows($result);
                       echo "<select size=\"1\" name=\"categ\">";
					if (mysql_num_rows($result))
					{
						echo "<option selected value=\"".$contact_extrait[16]."\">".$contact_extrait[16]."</option>";
						while ($ligne=mysql_fetch_object($result))
						{
							$categ=$ligne->INTITULE_CATEG;
							echo "<option value=\"$categ\">$categ</option>";
						}
					}
					echo "</SELECT> 
				</TD>
				<TD class = \"etiquette\" width = $lar_etiquette_petit>Propri&eacute;taire&nbsp;:&nbsp;</TD>
				<TD width = \"30%\" class = \"td-1\"><INPUT TYPE=\"text\" VALUE =\"".$contact_extrait[14]."\" NAME = \"emetteur\" SIZE=\"34\"></TD>
			</TR>";
		}
		echo "<TR>
			<TD class = \"etiquette\" width = $lar_etiquette_petit>Remarques&nbsp;:&nbsp;</TD>
			<TD colspan = \"5\" class = \"td-1\"><textarea rows=\"3\" name=\"remarques\" cols=\"60\">".$contact_extrait[13]."</textarea></TD>
		</TR>
		<!--TR>
			<TD colspan=\"6\" class = \"td-1\" align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>
		</TR-->
	</TABLE>
	<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
	<INPUT TYPE = \"hidden\" VALUE = \"enreg_contact_modifie\" NAME = \"action\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$contact_extrait[0]."\" NAME = \"id_contact\">
	<INPUT TYPE = \"hidden\" VALUE = \"$proprietaire\" NAME = \"proprietaire\">";
	
	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
				echo "<td>";
					echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

?>
