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
			<TD width = \"5%\" class = \"etiquette\">Id&nbsp;:&nbsp;</TD>
			<TD width = \"5%\" class = \"td-1\" align = \"center\">".$contact_extrait[0]."</TD>
			<TD width = \"10%\" class = \"etiquette\">Prénom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\" class = \"td-1\">$contact_extrait[3]</TD>
			<TD width = \"10%\" class = \"etiquette\">Nom&nbsp;:&nbsp;</TD>
			<TD width = \"35%\">$contact_extrait[2]</TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"4\" align = \"center\">Renseignements professionnels</th>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\">$contact_extrait[5]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">CP&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit>$contact_extrait[6]</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Ville&nbsp;:&nbsp;</TD>
			<TD>$contact_extrait[7]</TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Fonction&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees>$contact_extrait[4]</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Service&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand>$contact_extrait[17]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l.&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[8]);
			echo "<TD width = $lar_champ_donnees class = \"td-1\">$tel</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Fax&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[9]);
			echo "<TD width = $lar_champ_donnees_grand class = \"td-1\">$tel</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l. mobile&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[10]);
			echo "<TD width = $lar_champ_donnees class = \"td-1\">$tel</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand>$contact_extrait[11]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><a href=\"$contact_extrait[25]\" target=\"_blank\">$contact_extrait[25]</a></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"4\" align = \"center\">Renseignements personnels</th>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>
			<TD colspan = \"3\">$contact_extrait[20]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">CP&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit>$contact_extrait[21]</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Ville&nbsp;:&nbsp;</TD>
			<TD>$contact_extrait[22]</TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l.&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[18]);
			echo "<TD width = $lar_champ_donnees class = \"td-1\">$tel</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Fax&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[24]);
			echo "<TD width = $lar_champ_donnees_grand class = \"td-1\">$tel</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">T&eacute;l. mobile&nbsp;:&nbsp;</TD>";
				$tel = affiche_tel($contact_extrait[23]);
			echo "<TD width = $lar_champ_donnees class = \"td-1\">$tel</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
			<TD width = $lar_champ_donnees_grand>$contact_extrait[12]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette class = \"etiquette\">Page WEB&nbsp;:&nbsp;</TD>
			<TD colspan =\"3\" class = \"td-1\"><a href=\"$contact_extrait[19]\" target=\"_blank\">$contact_extrait[19]</a></TD>
		</TR>
	</TABLE>
	<TABLE width = \"95%\">
		<TR>
			<th colspan=\"6\" align = \"center\">Autres renseignements</th>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Confidentialit&eacute;&nbsp;:&nbsp;</TD>
			<TD width = $lar_etiquette_petit class = \"td-1\">$contact_extrait[15]</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</TD>
			<TD width = \"30%\" class = \"td-1\">$contact_extrait[16]</TD>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Propri&eacute;taire&nbsp;:&nbsp;</TD>
			<TD width = \"30%\" class = \"td-1\">$contact_extrait[14]</TD>
		</TR>
		<TR>
			<TD width = $lar_etiquette_petit class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>
			<TD colspan = \"5\" class = \"td-1\">$contact_extrait[13]</TD>
		</TR>
	</TABLE>";

	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";


?>
