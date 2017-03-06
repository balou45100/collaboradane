<?php
	//On demande confirmation
	echo "<h1>Confirmer la suppression du matériel</h1>";
	$requete = "SELECT * FROM materiels WHERE id = '".$id."';";
	$resultat = mysql_query($requete);
	if(!$resultat)
	{
		echo "<br>Problème lors de la connexion à la base de données";
	}
	$ligne_extraite = mysql_fetch_object($resultat);
	$denomination = $ligne_extraite->denomination;
	$id_cat_princ = $ligne_extraite->categorie_principale;
	$id_origine = $ligne_extraite->origine;
	$id_affectation = $ligne_extraite->affectation_materiel;
/*
	echo "<br><b>***materiels_gestion_supprimer_materiel.inc.php***</b>";
	echo "<br>id : $id";
	echo "<br>denomination : $denomination";
	echo "<br>id_cat_princ : $id_cat_princ";
	echo "<br>id_origine : $id_origine";
	echo "<br>id_affectation : $id_affectation";
*/
	//on récupère les différents intitulés
	//D'abord le type
	$requete_type = "SELECT * FROM materiels_categories_principales WHERE id_cat_princ = '".$id_cat_princ."';";
	$result_type = mysql_query($requete_type);
	$ligne_type = mysql_fetch_object($result_type);
	$intitule_materiel = $ligne_type->intitule_cat_princ;
	//$id_materiel= $ligne_type->id_cat_princ;

	//echo "<br>intitule_materiel_extrait : $intitule_materiel - id_materiel_extrait : $id_materiel";

	//Ensuite l'origine
	$requete_origine = "SELECT * FROM materiels_origine WHERE id_origine = '".$id_origine."';";
	$result_origine = mysql_query($requete_origine);
	$ligne_origine = mysql_fetch_object($result_origine);
	$intitule_origine = $ligne_origine->intitule_origine;
	//$id_origine = $ligne_origine->id_origine;

	//echo "<br>intitule_origine_extrait : $intitule_origine - id_origine_extrait : $id_origine";
	//Pour finir l'affectation
	$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id_affectation."';";
	$result_affectation = mysql_query($requete_affectation);
	$ligne_affectation = mysql_fetch_object($result_affectation);
	$intitule_affectation = $ligne_affectation->intitule_affectation;
	//$id_affectation = $ligne_affectation->id_affectation;
	
	echo "<FORM ACTION = \"materiels_gestion.php\" METHOD = \"GET\">";
		echo "<h1>$id - $denomination - $intitule_materiel - $intitule_origine - $intitule_affectation</h1>";
		echo "<br><INPUT SRC = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_cat_princ\" NAME = \"actions_structurelles\">";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		//echo "<br><INPUT SRC = \"\"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
		//echo "&nbsp;&nbsp;<INPUT SRC = \"\"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";

	echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_gestion\" NAME = \"origine_gestion\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_materiel\" NAME = \"a_faire\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</FORM>";
?>
