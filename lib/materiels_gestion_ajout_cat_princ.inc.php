<?php
	echo "<form id=\"monForm\" action=\"materiels_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Saisie d'une nouvelle cat&eacute;gorie principale</legend>
			<p>
				<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
				<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
			</p>
			<p>";
		echo "<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la catégorie\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_cat_princ\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
			<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
		</p>
	</form>";
?>
