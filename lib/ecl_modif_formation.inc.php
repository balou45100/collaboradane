<?php
	//echo "<BR> Je suis dans la procédure de modification de formation $id_formation";
	$id_formation = $_GET['id_formation'];
	$origine = $_SESSION['origine'];

	//Récupération des variables de la table formations 
	include("../biblio/init.php");
	$query_formation = "SELECT DISTINCT * FROM formations WHERE id_formation = $id_formation;";
	$results_formation = mysql_query($query_formation);
	$num_results_formation = mysql_num_rows($results_formation);
	$formation_extrait = mysql_fetch_row($results_formation);
	//echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";
	//echo "<br>id_formation : $formation_extrait[0] - annee_scolaire : $formation_extrait[1] - type_formation : $formation_extrait[2] - rne : $id_societe";
	echo "<FORM ACTION = \"$origine.php\" METHOD = \"GET\">";
	echo "<h2>Formations</h2>";
	echo "<TABLE width = \"50%\">";
		echo "<tr>";
			echo "<td class = \"etiquette\" width=\"25%\">Id&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;".$formation_extrait[0]."</td>";
		echo "</tr>";
		echo "</tr>";
			echo "<td class = \"etiquette\">Année scolaire&nbsp;:&nbsp;</td>";
			$annee_scolaire = $formation_extrait[1];    
			echo "<td>&nbsp;
				<select size=\"1\" name=\"annee_scolaire_formulaire\">
					<option selected value=\"$annee_scolaire\">$annee_scolaire</option>";
					if ($annee_scolaire<>"2006-2007")
					{
						echo "<option value=\"2006-2007\">2006-2007</option>";
					}
					if ($annee_scolaire<>"2007-2008")
					{
						echo "<option value=\"2007-2008\">2007-2008</option>";
					}
					if ($annee_scolaire<>"2008-2009")
					{
						echo "<option value=\"2008-2009\">2008-2009</option>";
					}
					if ($annee_scolaire<>"2009-2010")
					{
						echo "<option value=\"2009-2010\">2009-2010</option>";
					}
					if ($annee_scolaire<>"2010-2011")
					{
						echo "<option value=\"2010-2011\">2010-2011</option>";
					}
					if ($annee_scolaire<>"2011-2012")
					{
						echo "<option value=\"2011-2012\">2011-2012</option>";
					}
					if ($annee_scolaire<>"2012-2013")
					{
						echo "<option value=\"2012-2013\">2012-2013</option>";
					}
					if ($annee_scolaire<>"2013-2014")
					{
						echo "<option value=\"2013-2014\">2013-2014</option>";
					}
					if ($annee_scolaire<>"2014-2015")
					{
						echo "<option value=\"2014-2015\">2014-2015</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Type&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;
				<select size=\"1\" name=\"type_formation\">
					<option selected value=\"".$formation_extrait[2]."\">".$formation_extrait[2]."</option>
					<option value=\"transversale\">transversale</option>
					<option value=\"disciplinaire\">disciplinaire</option>
					<option value=\"autre\">autre</option>
				</select>";
			echo "</TD>";
		echo "</tr>";
	echo "</TABLE>";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
	<INPUT TYPE = \"hidden\" VALUE = \"enreg_formation_modifie\" NAME = \"action\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
	<INPUT TYPE = \"hidden\" VALUE = \"".$formation_extrait[0]."\" NAME = \"id_formation\">";


	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"$origine.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

	echo "</FORM>";
	//echo "<BR><A HREF = \"$origine.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
?>
