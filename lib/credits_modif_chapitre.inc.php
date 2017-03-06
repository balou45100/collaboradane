<?php
	session_start ();
	//Il faut récupérer les informations concernant la fiche
	$requete_chapitre = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire AND credits_chapitres.id_chapitre = '".$id_credits_chapitre ."'";
	$result_chapitre = mysql_query($requete_chapitre);
	$num_rows = mysql_num_rows($result_chapitre);
	//echo "<br>Nombre d'enregistrements retourné : $num_rows";
	$ligne_chapitre = mysql_fetch_object($result_chapitre);
	$id_chapitre = $ligne_chapitre->id_chapitre;
	$intitule_chapitre = $ligne_chapitre->intitule_chapitre;
	$utilise = $ligne_chapitre->utilise;
	$id_gestionnaire = $ligne_chapitre->id_gestionnaire;
	$intitule_gestionnaire = $ligne_chapitre->intitule_gestionnaire;
	echo "<form id=\"monForm\" action=\"credits_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Modification du chapitre de cr&eacute;dits</legend>";
		echo "<p>
			<label for=\"form_id\">ID&nbsp;:&nbsp;</label>
			<a for = \"form_id_valeur\">&nbsp;$id_chapitre</a>
		</p>";
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
					if ($utilise == "O")
					{
						echo "<option selected value=\"O\">Oui</option>";
						echo "<option value=\"N\">Non</option>";
					}
					else
					{
						echo "<option selected value=\"N\">Non</option>";
						echo "<option value=\"O\">Oui</option>";
					}
					
				echo "</select>
			</p>";
		echo "</fieldset>
		<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id_chapitre\" NAME = \"id_chapitre\">
			<INPUT TYPE = \"hidden\" VALUE = \"$annee\" NAME = \"annee\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_chapitre\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
		</p>
	</form>";
?>
