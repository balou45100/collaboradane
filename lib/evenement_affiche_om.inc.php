<?php
	$id_participant = $_GET['id_participant'];
/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />id_participant : $id_participant";
*/
	//Largeur du tableau
	$largeur_tableau = "95%";
	
	//Il faut récupérer les informations concernant l'événement
	$requete_evenement="SELECT * FROM evenements WHERE id_evenement= '$id_evenement'";

	//echo "<br />$requete_evenement";
	
	$resultat_evenement=mysql_query($requete_evenement);
	$num_rows = mysql_num_rows($resultat_evenement);
	
	$ligne_evenement = mysql_fetch_object($resultat_evenement);
	
	$id_evenement = $ligne_evenement->id_evenement;
	$titre_evenement = $ligne_evenement->titre_evenement;
	$date_evenement_debut = $ligne_evenement->date_evenement_debut;
	$date_evenement_fin = $ligne_evenement->date_evenement_fin;
	$heure_debut_evenement = $ligne_evenement->heure_debut_evenement;
	$heure_fin_evenement = $ligne_evenement->heure_fin_evenement;
	$fk_id_util = $ligne_evenement->fk_id_util;
	$fk_rne = $ligne_evenement->fk_rne;
	$fk_id_dossier = $ligne_evenement->fk_id_dossier;
	$fk_repertoire = $ligne_evenement->fk_repertoire;
	$autre_lieu = $ligne_evenement->autre_lieu;
	$detail_evenement = $ligne_evenement->detail_evenement;
	
	//On retire les secondes pour l'affichage
	$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
	$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);

/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />titre_evenement : $titre_evenement";
	echo "<br />date_evenement_debut : $date_evenement_debut";
	echo "<br />date_evenement_fin : $date_evenement_fin";
	echo "<br />heure_debut_evenement : $heure_debut_evenement";
	echo "<br />heure_fin_evenement : $heure_fin_evenement";
	echo "<br />fk_id_util : $fk_id_util";
	echo "<br />fk_rne : $fk_rne";
	echo "<br />fk_repertoire : $fk_repertoire";
	echo "<br />fk_id_dossier : $fk_id_dossier";
	echo "<br />autre_lieu : $autre_lieu";
	echo "<br />detail_evenement : $detail_evenement";
*/
	//Transformation des dates extraites pour l'affichage
	$date_debut_a_afficher = strtotime($date_evenement_debut);
	//echo "<br />date_debut_a_afficher : $date_debut_a_afficher";
	$date_debut_a_afficher = date('d-m-Y',$date_debut_a_afficher);
	//echo "<br />date_debut_a_afficher : $date_debut_a_afficher";

	if ($date_evenement_fin <> "0000-00-00")
	{
		$date_fin_a_afficher = strtotime($date_evenement_fin);
		//echo "<br />date_evenement_a_afficher : $date_evenement_a_afficher";
		$date_fin_a_afficher = date('d-m-Y',$date_fin_a_afficher);
		//echo "<br />date_evenement_a_afficher : $date_evenement_a_afficher";
	}
	
	//On récupère les informations sur le participant à convoquer
	$requete_participant = "SELECT * FROM evenements_participants as ep, personnes_ressources_tice as prt
	WHERE ep.id_participant = prt.id_pers_ress
		AND ep.id_participant = $id_participant
		AND ep.id_evenement = $id_evenement";
	
	//echo "<br />$requete_participant";
	
	$resultat_requete_participant = mysql_query($requete_participant);
	$ligne_participant=mysql_fetch_object($resultat_requete_participant);
	$civil_participant = $ligne_participant->civil;
	$nom_participant = $ligne_participant->nom;
	$prenom_participant = $ligne_participant->prenom;
	$etab_participant = $ligne_participant->codetab;
	$frais = $ligne_participant->frais;
	$id_ep = $ligne_participant->id;

	//echo "<br />frais : $frais";
	//echo "<br />id_ep : $id_ep";
	
	//On récupère les informations de l'établissement
	$type_ecl = lecture_champ("etablissements","TYPE","RNE",$etab_participant);
	$nom_ecl = lecture_champ("etablissements","NOM","RNE",$etab_participant);
	$ville_ecl = lecture_champ("etablissements","VILLE","RNE",$etab_participant);

	$chemin_images = "../image/OM";
	
	//On récupère les dates et on les convertit pour pouvoir les comparer
	$aujourdhui = mktime();
	
	list($annee1, $mois1, $jour1)= explode ("-",$date_evenement_debut);
	$date_evenement_debut_convertie = mktime(0,0,0,$mois1,$jour1,$annee1);
	/*
	echo "<br />date_evenement_debut_convertie : $date_evenement_debut_convertie";
	echo "<br />aujourdhui : $aujourdhui";
	*/
	if ($date_evenement_debut_convertie < $aujourdhui)
	{
		$regularisation="O";
	}

/*
	echo "<br />nom_participant : $nom_participant";
	echo "<br />prenom_participant : $prenom_participant";
	echo "<br />etab_participant : $etab_participant";
	echo "<br />chemin_images : $chemin_images";
*/
	//On charge la variable avec_sans_frais avec la bonne valeur
	if ($frais == "A")
	{
		$avec_sans_frais = "AVEC";
	}
	else
	{
		$avec_sans_frais = "SANS";
	}
	$jour = date('d');
	$mois = traduction_mois(date('F'));
	$annee = date('Y');
	
	$date_affichage_om = $jour." ".$mois." ".$annee;
	
	//On formate le numéro de téléphone pour l'affichage
	$tel_service_om = affiche_tel($tel_service_om);
	
	echo "<table id= \"tableom\" width = \"$largeur_tableau\">";
		echo "<colgroup>";
			echo "<col width=\"30%\">";
			echo "<col width=\"30%\">";
			echo "<col width=\"40%\">";
		echo "</colgroup>";

		echo "<tr>";
			echo "<td align=\"left\" nowrap>";
				echo "<img src = \"$chemin_images/marianne.png\"></img>";
				echo "<br /><img src = \"$chemin_images/logo_acad.png\"></img>";
				echo "<br /><br />$intitule_structure_support";
				echo "<br /><br />D&eacute;l&eacute;gation acad&eacute;mique au";
				echo "<br />num&eacute;rique pour l'&Eacute;ducation";
				echo "<br /><br />$adresse_service_rue";
				echo "<br />$adresse_service_cp $adresse_service_ville $adresse_service_cedex";
			echo "</td>";
			echo "<td>";
				echo "&nbsp;";
			echo "</td>";
			echo "<td align=\"left\">";
				echo "<br /><br />LE D&Eacute;L&Eacute;GU&Eacute; ACAD&Eacute;MIQUE AU NUM&Eacute;RIQUE";
				echo "<br /><br />&agrave;";
				echo "<br /><br />MADAME le recteur de l'Acad&eacute;mie d'Orl&eacute;ans-Tours";
				echo "<br /><br />Convocation valant autorisation de d&eacute;livrer un ordre de mission en vue de se rendre à une r&eacute;union organis&eacute;e &agrave; l'initiative de la DANE";
				echo "<br /><br /><strong>$avec_sans_frais FRAIS</strong>";
				if ($regularisation == "O")
				{
					echo "<br /><br /><br />";
					echo "<strong>Pour r&eacute;gularisation</strong>";
				}
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td nowrap align =\"top\">";
				echo "<br /><br />Affaire suivi par";
				echo "<br />$suivi_om_par";
				echo "<br /><br />$tel_service_om";
				echo "<br /><br />$melcontact_om";
				echo "<br />$serveurmel";
			echo "</td>";

			echo "<td colspan = \"2\">";
				if ($regularisation == "O")
				{
					echo "<br /><br />";
				}
				else
				{
					echo "<br /><br /><br /><br /><br />";
				}
				echo "<strong>Lieu de la réunion : </strong>";
				echo "<br />";
				affiche_lieu_evenement($fk_rne, $fk_repertoire, $autre_lieu);
				echo "<br /><br /><strong>Date et heures : </strong>";
				if ($date_evenement_fin <> "0000-00-00")
				{
					echo "<br />$date_debut_a_afficher &agrave; $heure_debut_evenement";
					echo "au $date_fin_a_afficher &agrave; $heure_debut_evenement";
				}
				else
				{
					echo "<br />$date_debut_a_afficher de $heure_debut_evenement &agrave; $heure_fin_evenement";
				}
				echo "<br /><br /><strong>Objet de la réunion : </strong>";
				echo "<br />$titre_evenement";
				if ($avec_sans_frais == "AVEC")
				{
					echo "<br /><br /><strong>Mode de transport autoris&eacute; : </strong>";
					echo "<br />Remboursement tarif SNCF 2&egrave;me classe";
				}
				echo "<br /><br /><strong>Personne convoqu&eacute;e : </strong>";
				echo "<br />";
				if ($civil_participant == "MME")
				{
					echo "Madame ";
				}
				else
				{
					echo "Monsieur ";
				}
				echo "$nom_participant, $prenom_participant";
				echo "<br />$etab_participant - $type_ecl $nom_ecl, $ville_ecl";
				if ($frais == "A")
				{
					echo "<br /><br /><br /><br /><strong>Aide pour d&eacute;clarer dans Chorus DT : </strong>";
					echo "<br />- enveloppe budg&eacute;taire : 0141RECT-FDDANE (Frais de d&eacute;pl de la Cellule DANE)";
					echo "<br />- centre de co&ucirc;t Chorus : RECEPLE045 (Div de l'organisation scolaire)";
					echo "<br />- tutoriel : https://pia.ac-orleans-tours.fr/protege/ma_carriere_ma_vie_professionnelle/frais_de_deplacement/les_differentes_procedures/";
				}
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td colspan = \"3\" height = \"100\"";
				echo "&nbsp;";
			echo "</td>";

		echo "</tr>";

		echo "<tr>";
			echo "<td nowrap>";
				echo "&nbsp;";
			echo "</td>";
			echo "<td align=\"center\">";
				echo "Pour valoir ordre de mission";
				echo "<br />Le recteur";
			echo "</td>";
			echo "<td align=\"center\">";
				echo "&Agrave; Orl&eacute;ans, le $date_affichage_om";
				//echo "<br /><img src = \"$chemin_images/signature_om.png\"></img>";
				echo "<br />$dan";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	//On met à jour le champ etat_om de la table evenements_participants
	$requete_maj_etat_om = "UPDATE evenements_participants SET
		`etat_om` = '1'
		WHERE id_evenement = '".$id_evenement."' AND id_participant = '".$id_participant."' AND etat_om < 3";

	//echo "<br />$requete_maj_etat_om";

	$result_maj_etat_om = mysql_query($requete_maj_etat_om);
	//on ajoute un suivi
	enreg_suivi_om($id_ep,1,"");

/*
	if (!$result_maj_etat_om)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>L'&eacute;tat a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}
*/
?>
