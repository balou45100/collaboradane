<?php
	//On demande confirmation
	echo "<h1>Confirmer la suppression de l'&eacute;v&eacute;nement&nbsp;:&nbsp;</h1>";
	$requete = "SELECT * FROM evenements AS e, util AS u, categorie_commune AS cc
		WHERE e.fk_id_util = u.ID_UTIL
			AND e.fk_id_dossier = cc.id_categ
			AND e.id_evenement = '".$id_evenement."'";
	
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);
	if(!$resultat)
	{
		echo "<br>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
	}
	$ligne_extraite = mysql_fetch_object($resultat);
	$date_evenement = $ligne_extraite->date_evenement;
	$titre = $ligne_extraite->titre_evenement;
	$description = $ligne_extraite->detail_evenement;
	$emetteur = $ligne_extraite->NOM;
	$dossier = $ligne_extraite->intitule_categ;

/*
	echo "<br><b>***evenement_supprimer_evenement.inc.php***</b>";
	echo "<br>id_evenement : $id_evenement";
	//echo "<br>date_creation : $date_creation";
	echo "<br>date_evenement : $date_evenement";
	echo "<br>emetteur : $emetteur";
	echo "<br>titre : $titre";
	echo "<br>description : $description";
	echo "<br>dossier : $dossier";
*/
	echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
		echo "<h1>$id_evenement - $titre<br>du $date_evenement<br>responsable&nbsp;:&nbsp;$emetteur<br>$dossier<br />$description</h1>";
		echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cet &eacute;v&eacut;enement\" border = \"0\" TYPE = image>";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans supprimer\"/>";
		//echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
		//echo "&nbsp;&nbsp;<INPUT src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id_evenement."\" NAME = \"id_evenement\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$date_filtre."\" NAME = \"date_filtre\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmer_supprimer_evenement\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
	echo "</FORM>";
?>
