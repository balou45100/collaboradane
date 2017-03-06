<?php
	/* Destinataire (votre adresse e-mail) */
	echo "<h2>Envoi du rappel</h2>";
	//On récupère les informations concernant le destinataire
	$mel_destinataire = lecture_champ("personnes_ressources_tice","mel","id_pers_ress",$id_participant);
	//$mel_destinataire .= $serveurmel;
	$civilite_destinataire = lecture_champ("personnes_ressources_tice","civil","id_pers_ress",$id_participant);
	$titre_evenement = lecture_champ("evenements","titre_evenement","id_evenement",$id_evenement);
	$date_evenement_debut = lecture_champ("evenements","date_evenement_debut","id_evenement",$id_evenement);
	$date_evenement_debut = affiche_date($date_evenement_debut);
	$heure_debut_evenement = lecture_champ("evenements","heure_debut_evenement","id_evenement",$id_evenement);
	$heure_fin_evenement = lecture_champ("evenements","heure_fin_evenement","id_evenement",$id_evenement);
	$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
	$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);
	
	//Pour les tests
	
	echo "<br />mel_destinataire : $mel_destinataire";
	
	$mel_destinataire = "jurgen.mendel@ac-orleans-tours.fr";
	/*
	$civilite = "Monsieur";
	$prenom = "Jürgen";
	$nom = "Mendel";
	$expediteur = "jurgen.mendel@ac-orleans-tours.fr";
	*/
	$sujet = "Rappel pour déclaration frais de déplacement";

	echo "<br />melcontact_om : $melcontact_om";
	
	/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />titre_evenement : $titre_evenement";
	echo "<br />date_evenement_debut : $date_evenement_debut";
	echo "<br />lieu_reunion : $lieu_reunion";
	
	echo "<br />id_enregistrement : $id_enregistrement";
	echo "<br />id_participant : $id_participant";
	echo "<br />mel_destinataire : $mel_destinataire";
	echo "<br />suivi_om_par : $suivi_om_par";
	echo "<br />fonction_contact_om : $fonction_contact_om";
	*/
	/* Construction du message */
	$msg  = "Bonjour,";
	$msg .= "<br /><br />Ce mail est généré automatiquement et concerne la gestion des frais de déplacements pour des missions effectuées pour $organisation.";
	
	switch ($type_rappel)
	{
		case 3 :
			if ($civilite_destinataire <> "MME")
			{
				$msg  .= "Vous avez été présent à la réunion"."&laquo;&nbsp;".$titre_evenement."&raquo;&nbsp;du"." ".$date_evenement_debut.", ".$heure_debut_evenement." - ".$heure_fin_evenement.", mais vous n'avez pas encore créé l'OM pour ce déplacement dans Chorus DT.";
			}
			else
			{
				$msg  .= "Vous avez été présente à la réunion"."&laquo;&nbsp;".$titre_evenement."&raquo;&nbsp;du"." ".$date_evenement_debut.", ".$heure_debut_evenement." - ".$heure_fin_evenement.", mais vous n'avez pas encore créé l'OM pour ce déplacement dans Chorus DT.";
			}
		break;

		case 5 :
			$msg  .= "Votre OM $reference_om_chorus a été validé, merci de créer l'état de frais correspondant dans Chorus DT.";
		break;

		case 6 :
			$msg  .= "Votre OM $reference_om_chorus vous a été retourné pour révision. Merci de le corriger et de le transmettre à nouveau à votre validateur.";
		break;

		case 11 :
			$msg  .= "Votre EF $reference_ef_chorus vous a été retourné pour révision. Merci de le corriger et de le transmettre à nouveau à votre validateur.";
		break;
	} //Fin switch ($type_rappel)

	$msg .= "<br /><br />Cordialement";
	$msg .= "<br /><br />$suivi_om_par";
	$msg .= "<br />$fonction_contact_om";
	$msg .= "<br />$intitule_service";
	 
	/* En-têtes de l'e-mail */
	$headers = 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: '.$suivi_om_par.' <'.$melcontact_om.$serveurmel'>'."\r\n\r\n";
	$headers .= "\r\n";
	
	/*
	echo "<br />headers : $headers";
	echo "<br />to : $to";
	echo "<br />sujet : $sujet";
	echo "<br />msg : $msg";
	*/
	/* Envoi de l'e-mail */
	$ok = mail($mel_destinataire, $sujet, $msg, $headers);
	
	//echo "<br />ok : $ok";
	
	if ($ok)
	{
		echo "<h2>Le message a &eacute;t&eacute; envoy&eacute;</h2>";
		//On enregistre le rappel pour le suivi
	}
	else
	{
		echo "<h2>Erreur, le message n'a pas pu &ecirc;tre envoy&eacute;</h2>";
	}
?>
