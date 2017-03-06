<?php
	//On récupère les informations concernant le destinataire
	$mel_destinataire = lecture_champ("personnes_ressources_tice","mel","id_pers_ress",$id_participant).$serveurmel;
	$civilite_destinataire = lecture_champ("personnes_ressources_tice","civil","id_pers_ress",$id_participant);
	$titre_evenement = lecture_champ("evenements","titre_evenement","id_evenement",$id_evenement);
	$date_evenement_debut = lecture_champ("evenements","date_evenement_debut","id_evenement",$id_evenement);
	$date_evenement_debut = affiche_date($date_evenement_debut);
	$heure_debut_evenement = lecture_champ("evenements","heure_debut_evenement","id_evenement",$id_evenement);
	$heure_fin_evenement = lecture_champ("evenements","heure_fin_evenement","id_evenement",$id_evenement);
	$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
	$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);
	
	$sujet = "Rappel pour déclaration de frais de déplacement";
	
	/* Construction du message */
	$msg  = "Bonjour,";
	$msg .= "<br /><br />Ce mail est généré automatiquement et concerne la gestion des frais de déplacements pour des missions effectuées pour la $intitule_service.";
	$msg .= "<br /><br />****************************************<br /><br />";
	
	switch ($type_rappel)
	{
		case 4 : //OM validé pas d'OM dans Chorus
			$type_suivi = 51;

			if ($civilite_destinataire <> "MME")
			{
				$msg  .= "Vous avez été présent à la réunion"."&laquo;&nbsp;".$titre_evenement."&nbsp;&raquo;&nbsp;du"." ".$date_evenement_debut.", ".$heure_debut_evenement." - ".$heure_fin_evenement.", mais vous n'avez pas encore créé l'OM pour ce déplacement dans Chorus DT. Il faudra indiquer 'OM régularisation classique' dans le champ 'Type de mission' dans l'onglet 'Général'. L'enveloppe budgétaire est 0141RECT-FDDANE  et le centre de coût Chorus est RECEPLE045. N'oubliez pas de le transmettre au validateur !";
			}
			else
			{
				$msg  .= "Vous avez été présente à la réunion"."&laquo;&nbsp;".$titre_evenement."&nbsp;&raquo;&nbsp;du"." ".$date_evenement_debut.", ".$heure_debut_evenement." - ".$heure_fin_evenement.", mais vous n'avez pas encore créé l'OM pour ce déplacement dans Chorus DT. Il faudra indiquer 'OM régularisation classique' dans le champ 'Type de mission' dans l'onglet 'Général'. L'enveloppe budgétaire est 0141RECT-FDDANE  et le centre de coût Chorus est RECEPLE045. N'oubliez pas de le transmettre au validateur !";
			}
		break;

		case 6 : //OM validé, pas d'EF
			$type_suivi = 52;
			//On récupère les informations concernant l'événement
			$reference_om_chorus = lecture_champ("evenements_participants"," reference_om_chorus","id",$id_enregistrement);
			$msg  .= "Votre OM $reference_om_chorus concernant la réunion "."&laquo;&nbsp;".$titre_evenement."&nbsp;&raquo;&nbsp;du"." ".$date_evenement_debut.", a été validé. Merci de créer l'état de frais correspondant dans Chorus DT et le transmettre au validateur.";
		break;

		case 7 : //OM retourné en révision
			$type_suivi = 53;
			//On récupère les informations concernant l'événement
			$reference_om_chorus = lecture_champ("evenements_participants"," reference_om_chorus","id",$id_enregistrement);
			$msg .= "Votre OM $reference_om_chorus  concernant la réunion "."&laquo;&nbsp;".$titre_evenement."&nbsp;&raquo;&nbsp;du"." ".$date_evenement_debut.", vous a été retourné pour révision. Merci de le corriger et de le transmettre à nouveau à votre validateur.";
		break;

		case 11 : //EF retourné pour révision
			$type_suivi = 54;
			//On récupère les informations concernant l'événement
			$reference_ef_chorus = lecture_champ("evenements_participants"," reference_ef_chorus","id",$id_enregistrement);
			$msg  .= "Votre EF $reference_ef_chorus  concernant la réunion "."&laquo;&nbsp;".$titre_evenement."&nbsp;&raquo;&nbsp;du"." ".$date_evenement_debut.", vous a été retourné pour révision. Merci de le corriger et de le transmettre à nouveau à votre validateur.";
		break;
	} //Fin switch ($type_rappel)
	$msg .= "<br /><br />Voici le lien vers le guide qui est dans le PIA :";
	$msg .= "<br />https://pia.ac-orleans-tours.fr/fileadmin/user_upload/protege/rh/frais_de_deplacements/reunions/DTChorus-procedure-reunion-Dane.pdf";
	$msg .= "<br /><br />Cordialement";
	$msg .= "<br /><br />$suivi_om_par";
	$msg .= "<br />$fonction_contact_om";
	$msg .= "<br />$intitule_service";
	$msg .= "<br />$intitule_structure_support";
	 
	/* En-têtes de l'e-mail */
	$melcontact_om .= $serveurmel;
	$headers = 'Mime-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\n";
	$headers .= 'From: '.$suivi_om_par.' <'.$melcontact_om.'>'."\n";
	$headers .= 'Cc: '.$melcontact_om."\n";
	
	/* Envoi de l'e-mail */
	$ok = mail($mel_destinataire, $sujet, $msg, $headers);
	
	if ($ok)
	{
		echo "<h2>Le message de rappel a &eacute;t&eacute; envoy&eacute;</h2>";
		//On enregistre le rappel pour le suivi
		enreg_suivi_om($id_enregistrement,"$type_suivi","");
	}
	else
	{
		echo "<h2>Erreur, le message de rappel n'a pas pu &ecirc;tre envoy&eacute;</h2>";
	}
?>
