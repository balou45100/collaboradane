<?php
	//Il faut écupérer les champs de l'enregistrement courant
	$requete_personne="SELECT * FROM personnes_ressources_tice WHERE id_pers_ress = '".$id."'";
	$result_personne=mysql_query($requete_personne);
	$num_rows = mysql_num_rows($result_personne);
	$ligne_personne = mysql_fetch_object($result_personne);
	$id_pers_ress = $ligne_personne->id_pers_ress;
	$civil = $ligne_personne->civil;
	$nom = $ligne_personne->nom;
	$prenom = $ligne_personne->prenom;
	$codetab = $ligne_personne->codetab;
	$discipline = $ligne_personne->discipline;
	$poste = $ligne_personne->poste;
	$mel = $ligne_personne->mel;

	echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Modification de la fiche de la personne ressource</legend>
			<p>
				<label for=\"form_civil\">Civilit&eacute;&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_civil\" name=\"civil\">";
					if ($civil == "MME")
					{
						echo "<option selected value=\"MME\">MME</option>";
						echo "<option value=\"M.\">M.</option>";
					}
					else
					{
						echo "<option selected value=\"M.\">M.</option>";
						echo "<option value=\"MME\">MME</option>";
					}
					
				echo "</select>
			</p>
			<p>
				<label for=\"form_nom\">Nom&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_nom\" value = \"$nom\" name=\"nom\" />
			</p>
			<p>
				<label for=\"form_prenom\">Pr&eacute;nom&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_prenom\" value = \"$prenom\" name=\"prenom\" />
			</p>
			<p>";
				//on sélectionne l'étab de la personne
				$requete_etab_personne="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements WHERE rne = '".$codetab."'";
				$result_etab_personne=mysql_query($requete_etab_personne);
				$ligne_etab_personne=mysql_fetch_object($result_etab_personne);
				$rne_etab_personne = $ligne_etab_personne->RNE;
				$type_etab_personne = $ligne_etab_personne->TYPE;
				$nom_etab_personne = $ligne_etab_personne->NOM;
				$ville_etab_personne = $ligne_etab_personne->VILLE;
						
				$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements ORDER BY RNE";
				$result_etabs=mysql_query($requete_etabs);
				$num_rows = mysql_num_rows($result_etabs);
				echo "<label for=\"form_rne\">RNE&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_rne\" name=\"rne\">";
				if (mysql_num_rows($result_etabs))
				{
					echo "<OPTION selected VALUE = \"".$rne_etab_personne."\">".$rne_etab_personne." - ".str_replace("*", " ",$type_etab_personne)." ".str_replace("*", " ",$nom_etab_personne). " - ".$ville_etab_personne."</OPTION>";
					//echo "<option value=\"\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result_etabs))
					{
						$rne = $ligne->RNE;
						$type = $ligne->TYPE;
						$nom = $ligne->NOM;
						$ville = $ligne->VILLE;
						echo "<OPTION VALUE = \"".$rne."\">".$rne." - ".str_replace("*", " ",$type)." ".str_replace("*", " ",$nom). " - ".$ville."</OPTION>";
						//echo "<option value=\"$intitule_materiels\">$intitule_materiels</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>
			<p>";
				$requete_discipline="SELECT DISTINCT discipline FROM discipline ORDER BY discipline";
				$result_discipline=mysql_query($requete_discipline);
				$num_rows = mysql_num_rows($result_discipline);
				echo "<label for=\"form_discipline\">Discipline&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_discipline\" name=\"discipline\">";
				if (mysql_num_rows($result_discipline))
				{
					if ($discipline <> "")
					{
						echo "<option selected value=\"$discipline\">$discipline</option>";
						echo "<option value=\"\">pas de discipline</option>";
					}
					else
					{
						echo "<option selected value=\"\">Faire un choix</option>";
					}
					while ($ligne_discipline=mysql_fetch_object($result_discipline))
					{
						$discipline=$ligne_discipline->discipline;
						echo "<option value=\"$discipline\">$discipline</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>
			<p>";
				$requete_poste="SELECT DISTINCT poste FROM postes ORDER BY poste";
				$result_poste=mysql_query($requete_poste);
				$num_rows = mysql_num_rows($result_poste);
				echo "<label for=\"form_discipline\">Poste&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_poste\" name=\"poste\">";
				if (mysql_num_rows($result_poste))
				{
					if ($poste <>"")
					{
						echo "<option selected value=\"$poste\">$poste</option>";
						echo "<option value=\"\">pas de poste</option>";
					}
					else
					{
						echo "<option selected value=\"\">Faire un choix</option>";
					}
					while ($ligne_poste=mysql_fetch_object($result_poste))
					{
						$poste=$ligne_poste->poste;
						echo "<option value=\"$poste\">$poste</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>
			<p>
				<label for=\"form_mel\">Adresse acad&eacute;mique&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_mel\" value = \"$mel\" name=\"mel\" />
			</p>
		</fieldset>
		<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_personne\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		</p>
	</form>";
?>
