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
	$id_gestionnaire = $ligne_chapitre->id_gestionnaire;
	$intitule_gestionnaire = $ligne_chapitre->intitule_gestionnaire;
	//echo "<br />intitule_gestionnaire : $intitule_gestionnaire"; 
	echo "<form id=\"monForm\" action=\"credits_gestion.php\" method=\"get\">";
	echo "<center>";
	echo "<fieldset>
	<legend>Renseignements sur le chapitre des cr&eacute;dits</legend>
		<p>
			<label for=\"form_id\">ID&nbsp;:&nbsp;</label>
			<a for = \"form_id_valeur\">&nbsp;$id_chapitre</a>
		</p>
		<p>
			<label for=\"form_intitule_chapitre\">Intitul&eacute;&nbsp;:&nbsp;</label>
			<a for = \"form_intitule_chapitre_valeur\">&nbsp;$intitule_chapitre</a>
		</p>
		<p>
			<label for=\"form_gestionnaire\">Gestionnaire&nbsp;:&nbsp;</label>
			<a for = \"form_gestionnaire_valeur\">&nbsp;$intitule_gestionnaire</a>
		</p>";
	echo "</fieldset>";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner à la liste\"/>";
		echo"<INPUT TYPE = \"hidden\" VALUE = \"$annee\" NAME = \"annee\">
		<!--INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
		<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\"-->";
	//echo "</p>";
	echo "</center>";

	echo "</form>";
?>
