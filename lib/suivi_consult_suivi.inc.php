<?php
////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_suivi="SELECT * FROM suivis AS s, util AS u, categorie_commune AS cc, suivis_categories_communes AS scc
		WHERE s.emetteur = u.ID_UTIL
			AND s.id = scc.id_suivi
			AND scc.id_categorie_commune = cc.id_categ
			AND s.id = '".$id_suivi."'";

	//echo "<br />$requete_suivi";

	$result_suivi=mysql_query($requete_suivi);
	$num_rows = mysql_num_rows($result_suivi);
	$ligne_suivi = mysql_fetch_object($result_suivi);
	$date_creation = $ligne_suivi->date_crea;
	$date_suivi = $ligne_suivi->date_suivi;
	$contact_type = $ligne_suivi->contact_type;
	$titre = $ligne_suivi->titre;
	$description = $ligne_suivi->description;
	$emetteur = $ligne_suivi->NOM;
	$dossier = $ligne_suivi->intitule_categ;

	//$id_util_creation = $ligne_suivi->id_util_creation;
	//$id_util_traitant = $ligne_suivi->id_util_traitant;

/*
	//On regarde qui est le créateur de la tâche
	$requete_createur="SELECT * FROM suivi_util WHERE id_suivi = '".$id_suivi."' AND (statut_cta = '100' OR statut_cta = '110')";
	$result_createur=mysql_query($requete_createur);
	$num_rows = mysql_num_rows($result_createur);
	$ligne_createur = mysql_fetch_object($result_createur);
	$id_createur = $ligne_createur->id_util;

	//On regarde qui traite la tâche
	$requete_traitant="SELECT * FROM suivi_util WHERE id_suivi = '".$id_suivi."' AND (statut_cta = '110' OR statut_cta = '010')";
	$result_traitant=mysql_query($requete_traitant);
	$num_rows = mysql_num_rows($result_traitant);
	$ligne_traitant = mysql_fetch_object($result_traitant);
	$id_traitant = $ligne_traitant->id_util;
*/
	//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections
	$date_creation_a_traiter = strtotime($date_creation);
	$date_creation_jour = date('d',$date_creation_a_traiter);
	$date_creation_mois = date('m',$date_creation_a_traiter);
	$date_creation_annee = date('Y',$date_creation_a_traiter);

	$date_suivi_a_traiter = strtotime($date_suivi);
	$date_suivi_jour = date('d',$date_suivi_a_traiter);
	$date_suivi_mois = date('m',$date_suivi_a_traiter);
	$date_suivi_annee = date('Y',$date_suivi_a_traiter);

	//On initialise la date d'aujourd'hui au cas que la date de rappel n'est pas fixée
	$aujourdhui_jour = date('d');
	$aujourdhui_jour = $aujourdhui_jour+7;
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');

	//$date_rappel_a_traiter = strtotime($date_rappel);
	//$date_rappel_annee = date('Y',$date_rappel_a_traiter);

	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la Suivi</caption>";
		echo "<colgroup>";
			echo "<col width=\"40%\">";
			echo "<col width=\"60%\">";
		echo "</colgroup>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Identifiant du suivi&nbsp;:&nbsp;</th>";
			echo "<td>$id_suivi</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Desription du suivi&nbsp;:&nbsp;</td>";
			echo "<td>$titre</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de cr&eacute;ation&nbsp;:&nbsp;</td>";
			echo "<td>$date_creation_jour/$date_creation_mois/$date_creation_annee</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date du suivi&nbsp;:&nbsp;</td>";
			echo "<td>$date_suivi_jour/$date_suivi_mois/$date_suivi_annee</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Suivi cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
			echo "<td>";
					echo "$emetteur";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Type de suivi&nbsp;:&nbsp;</td>";
			echo "<td>";
					echo "$contact_type<br>";
			echo "</td>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Dossier concern&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>";
					echo "$dossier<br>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">D&eacute;tail&nbsp;:&nbsp;</td>";
			echo "<td>$description</td>";
		echo "</tr>";
	echo "</table>";

	//////////////////////////////////
	// Affichage du bouton retour ////
	//////////////////////////////////
	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"suivi_accueil.php?tri=Int&amp;sense_tri=ASC&amp;visibilite=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

?>
