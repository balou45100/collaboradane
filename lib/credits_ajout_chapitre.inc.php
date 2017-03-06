<?php
	echo "<form id=\"monForm\" action=\"credits_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Saisie d'un nouveau chapitre</legend>";
		echo "<p>
			<label for=\"form_intitule_chapitre\">Intitul&eacute;&nbsp;:&nbsp;</label>
			<input type=\"text\" id=\"form_intitule_chapitre\" value = \"$intitule_chapitre\" name=\"intitule_chapitre\" />
		</p>";

		echo "<p>";
			$requete_gestionnaire = "SELECT * FROM credits_gestionnaires ORDER BY intitule_gestionnaire";
			$result_gestionnaire = mysql_query($requete_gestionnaire);
			$num_rows = mysql_num_rows($result_gestionnaire);
			echo "<label for=\"form_gestionnaire\">Gestionnaire&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_gestionnaire\" name=\"id_gestionnaire\">";
				if (mysql_num_rows($result_gestionnaire))
				{
					echo "<option selected value=\"$id_gestionnaire\">$intitule_gestionnaire</option>";
					while ($ligne_gestionnaire=mysql_fetch_object($result_gestionnaire))
					{
						$id_gestionnaire_extrait=$ligne_gestionnaire->id_gestionnaire;
						$intitule_gestionnaire_extrait=$ligne_gestionnaire->intitule_gestionnaire;
						if ($id_gestionnaire <> $id_gestionnaire_extrait)
						{
							echo "<option value=\"$id_gestionnaire_extrait\">$intitule_gestionnaire_extrait</option>";
						}
					}
				}
				echo "</SELECT>"; 
			echo "</p>";
			echo "<p>
				<label for=\"form_utilise\">Utilis&eacute;&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_utilise\" name=\"utilise\">";
					echo "<option selected value=\"O\">Oui</option>";
					echo "<option value=\"N\">Non</option>";
				echo "</select>
			</p>";
		echo "</fieldset>
		<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer le chapitre\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id_chapitre\" NAME = \"id_chapitre\">
			<INPUT TYPE = \"hidden\" VALUE = \"$annee\" NAME = \"annee\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_chapitre\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
		</p>
	</form>";
?>
