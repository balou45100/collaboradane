<?php
	//On demande confirmation
	echo "<h1>Confirmer la suppression de la liste des participants de l'&eacute;v&eacute;nement&nbsp;:&nbsp;</h1>";
	echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
		//echo "<h1>$id_evenement - $titre<br>du $date_evenement<br>responsable&nbsp;:&nbsp;$emetteur<br>$dossier<br />$description</h1>";
		echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Effacer la liste de cet &eacute;v&eacut;enement\" border = \"0\" TYPE = image>";
		//echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans supprimer\"/>";
		//echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
		//echo "&nbsp;&nbsp;<INPUT src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id_evenement."\" NAME = \"id_evenement\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"".$date_filtre."\" NAME = \"date_filtre\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmer_supprimer_liste_participants\" NAME = \"a_faire2\">";
	echo "</FORM>";
?>
