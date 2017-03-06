<?php
	$id_formation = $_GET['id_formation'];
	//echo "<BR> Je suis dans la procédure de suppression de la formation $id_formation";

	//Récupération des variables de la table formations 
	include("../biblio/init.php");
	$query_formation = "SELECT DISTINCT * FROM formations WHERE id_formation = $id_formation;";
	$results_formation = mysql_query($query_formation);
	$num_results_formation = mysql_num_rows($results_formation);
	$formation_extrait = mysql_fetch_row($results_formation);

	//echo "<BR>formation : $id_forùation";
	echo "<FORM ACTION = \"$script.php\" METHOD = \"GET\">";
	echo "<h2 class = \"champ_obligatoire\"><b>Supprimer cette formation&nbsp;?<br />
	Tous les documents joints seront également supprimés&nbsp!</h2>";
	echo "<BR>
	<TABLE width = \"50%\">
		<tr>
			<td class = \"etiquette\" width=\"40%\">Id&nbsp;:&nbsp;</th>
			<td>&nbsp;".$formation_extrait[0]."</td>
		</tr>";
		echo "<tr>
			<td class = \"etiquette\">Année scolaire</td>
			<td>&nbsp;".$formation_extrait[1]."</td>";
		echo "</tr>";
		echo "<tr>
			<td class = \"etiquette\">Type</td>";
			echo "<td>&nbsp;".$formation_extrait[2]."</TD>";
		echo "</tr>";

/*		echo "<tr>";
			echo "<td class = \"etiquette\">Valider la suppression</td>";
		echo "<Td class = \"fond-actions\">
				<INPUT border=0 src = \"$chemin_theme_images/supprimer.png\" ALT = \"Valider\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=submit align=\"middle\"> 
			</TD>";
		echo "</tr>";
*/	echo "</TABLE>
	<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
	<INPUT TYPE = \"hidden\" VALUE = \"confirm_suppression_formation\" NAME = \"action\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$formation_extrait[0]."\" NAME = \"id_formation\">";

	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"$script.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<Td>";
					echo "<INPUT border=0 src = \"$chemin_theme_images/supprimer.png\" ALT = \"Valider\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
	echo "</FORM>";

	//echo "<BR><A HREF = \"$script.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
?>
