<?php
	//echo "<BR> Je suis dans la procédure de suppression du lot $id_lot";
	$id_contact = $_GET['id_contact'];
	//echo "<BR>id_contact : $id_contact";
	//Récupération des variables de la table lot 
	include("../biblio/init.php");
	$query_contact = "SELECT DISTINCT * FROM contacts WHERE ID_CONTACT = $id_contact;";
	$results_contact = mysql_query($query_contact);
	$num_results_contact = mysql_num_rows($results_contact);
	$contact_extrait = mysql_fetch_row($results_contact);
              
	//echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";

	echo "<TABLE>
		<TR>
			
			<TD class = \"etiquette\" width = \"50%\">Id&nbsp;:&nbsp;</TD>
			<TD width = \"50%\">&nbsp;$contact_extrait[0]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">Prénom&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[3]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">Nom&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[2]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">Fonction&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[4]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[11]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\" nowrap>Num&eacute;ro de t&eacute;l&eacute;phone directe&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[8]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\"nowrap>Numéro t&eacute;l&eacute;phone mobile&nbsp;:&nbsp;</TD>
			<TD>$contact_extrait[10]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">Fax&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[9]</TD>
		</TR>
		<TR>
			<TD class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>
			<TD>&nbsp;$contact_extrait[13]</TD>
		</TR>
	</TABLE>
	<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
	<INPUT TYPE = \"hidden\" VALUE = \"confirm_suppression_contact\" NAME = \"action\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$contact_extrait[0]."\" NAME = \"id_contact\">";

	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
				echo "</td>";
				echo "<td>";
					echo "<INPUT VALUE = \"Confirmer la suppression de ce contact\" type = image height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\">";
					echo "<br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
?>
