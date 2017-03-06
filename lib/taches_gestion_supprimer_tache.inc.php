<?php
	//On demande confirmation
	echo "<h1>Confirmer la suppression de la tache</h1>";
	$requete = "SELECT * FROM taches WHERE id_tache = '".$id."';";
	$resultat = mysql_query($requete);
	if(!$resultat)
	{
		echo "<br>Problème lors de la connexion à la base de données";
	}
	$ligne_extraite = mysql_fetch_object($resultat);
	$description = $ligne_extraite->description;
	$id_tache = $ligne_extraite->id_tache;
	$date_creation = $ligne_extraite->date_creation;
	$date_echeance = $ligne_extraite->date_echeance;
	$id_util_creation = $ligne_extraite->id_util_creation;
/*
	echo "<br><b>***tache_gestion_supprimer_tache.inc.php***</b>";
	echo "<br>id : $id";
	echo "<br>id_tache : $id_tache";
	echo "<br>date_creation : $date_creation";
	echo "<br>date_echeance : $date_echeance";
	echo "<br>id_util_creation : $id_util_creation";
*/
	//on récupère le nom de la personne qui a créée la tâche
	$requete_util = "SELECT * FROM util WHERE id_util = '".$id_util_creation."';";
	$result_util = mysql_query($requete_util);
	$ligne_util = mysql_fetch_object($result_util);
	$nom_util = $ligne_util->NOM;
	//echo "<br>nom_util : $nom_util";

	echo "<FORM ACTION = \"taches_gestion.php\" METHOD = \"GET\">";
		echo "<h1>$id_tache - $description<br>du $date_creation<br>ech&eacute;ance le $date_echeance<br>cr&eacute;&eacute;e par $nom_util</h1>";
		echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette t&acirc;che\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_cat_princ\" NAME = \"actions_structurelles\">";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		//echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
		//echo "&nbsp;&nbsp;<INPUT src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_tache\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
	echo "</FORM>";
?>
