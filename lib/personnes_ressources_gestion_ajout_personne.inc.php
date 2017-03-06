<?php
	echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Saisie d'une nouvelle personne ressource</legend>
			<p>
				<label for=\"form_civil\">Civilit&eacute;&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_civil\" name=\"civil\">
					<option value=\"M.\">M.</option>
					<option value=\"MME\">MME</option>
				</select>
			</p>
			<p>
				<label for=\"form_nom\">Nom&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_nom\" name=\"nom\" />
			</p>
			<p>
				<label for=\"form_prenom\">Pr&eacute;nom&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_prenom\" name=\"prenom\" />
			</p>
			<p>";
				$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements ORDER BY RNE";
				$result_etabs=mysql_query($requete_etabs);
				$num_rows = mysql_num_rows($result_etabs);
				echo "<label for=\"form_rne\">RNE&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_rne\" name=\"rne\">";
				if (mysql_num_rows($result_etabs))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result_etabs))
					{
						$rne = $ligne->RNE;
						$type = $ligne->TYPE;
						$nom = $ligne->NOM;
						$ville = $ligne->VILLE;
						echo "<option value = \"".$rne."\">".$rne." - ".str_replace("*", " ",$type)." ".str_replace("*", " ",$nom). " - ".$ville."</option>";
						//echo "<option value=\"$intitule_materiels\">$intitule_materiels</option>";
					}
				}
				echo "</select>"; 
			echo "</p>
			<p>";
				$requete_discipline="SELECT DISTINCT discipline FROM discipline ORDER BY discipline";
				$result_discipline=mysql_query($requete_discipline);
				$num_rows = mysql_num_rows($result_discipline);
				echo "<label for=\"form_discipline\">Discipline&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_discipline\" name=\"discipline\">";
				if (mysql_num_rows($result_discipline))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne_discipline=mysql_fetch_object($result_discipline))
					{
						$discipline=$ligne_discipline->discipline;
						echo "<option value=\"$discipline\">$discipline</option>";
					}
				}
				echo "</select>"; 
			echo "</p>
			<p>";
				$requete_poste="SELECT DISTINCT poste FROM postes ORDER BY poste";
				$result_poste=mysql_query($requete_poste);
				$num_rows = mysql_num_rows($result_poste);
				echo "<label for=\"form_discipline\">Poste&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_poste\" name=\"poste\">";
				if (mysql_num_rows($result_poste))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne_poste=mysql_fetch_object($result_poste))
					{
						$poste=$ligne_poste->poste;
						echo "<option value=\"$poste\">$poste</option>";
					}
				}
				echo "</select>"; 
			echo "</p>
			<p>
				<label for=\"form_mel\">Adresse acad&eacute;mique&nbsp;:&nbsp;<br /><i><small>laisser vide si prenom.nom</small></i></label>
				<input type=\"text\" id=\"form_mel\" name=\"mel\" />
			</p>
		</fieldset>
		<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la personne\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<input type = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<input type = \"hidden\" VALUE = \"enreg_personne\" NAME = \"a_faire\">
			<input type = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<input type = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<input type = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<input type = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		</p>
	</form>";
?>
