<?php
	//On demande confirmation
	echo "<h1>Confirmer la suppression du suivi&nbsp;:&nbsp;</h1>";
	$requete = "SELECT * FROM suivis WHERE id = '".$id_suivi."';";
	$resultat = mysql_query($requete);
	if(!$resultat)
	{
		echo "<br>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
	}
	$ligne_extraite = mysql_fetch_object($resultat);
	$id_suivi = $ligne_extraite->id;
	$date_creation = $ligne_extraite->date_crea;
	$date_suivi = $ligne_extraite->date_suivi;
	$titre = $ligne_extraite->titre;
	$description = $ligne_extraite->description;
	$id_util_creation = $ligne_extraite->emetteur;
/*
	echo "<br><b>***suivi_supprimer_suivi.inc.php***</b>";
	echo "<br>id_suivi : $id_suivi";
	echo "<br>date_creation : $date_creation";
	echo "<br>date_echeance : $date_echeance";
	echo "<br>id_util_creation : $id_util_creation";
	echo "<br>titre : $titre";
	echo "<br>description : $description";
*/
	//on récupère le nom de la personne qui a créée le suivi
	$requete_util = "SELECT * FROM util WHERE id_util = '".$id_util_creation."';";
	$result_util = mysql_query($requete_util);
	$ligne_util = mysql_fetch_object($result_util);
	$nom_util = $ligne_util->NOM;

	//echo "<br>nom_util : $nom_util";

	echo "<FORM ACTION = \"suivi_accueil.php\" METHOD = \"GET\">";
		echo "<h1>$id_suivi - $titre<br>du $date_creation<br>cr&eacute;&eacute;e par $nom_util<br />$description</h1>";
		echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette t&acirc;che\" border = \"0\" TYPE = image>";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		//echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
		//echo "&nbsp;&nbsp;<INPUT src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id_suivi."\" NAME = \"id_suivi\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmer_supprimer_suivi\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
	echo "</FORM>";
?>
