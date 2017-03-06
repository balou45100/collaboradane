<?php
	//echo "<br />renvoi : $renvoi";
	//echo "<h2>etat_visite : $etat_visite</h2>";
	//On compose le message qui sera envoyé à la DAFOP
	$entete="From: collaboratice\r\nX-Mailer: PHP/";
	$entete .='Content-Type: text/html; charset=\"UTF-8\"'."\n";
	$destinataire = $dafop_mel_fonctionnelle;
	$sujet = "[CARDIE->DAFOP] Demande d'OM";

	//On récupère l'intitulé du projet et le type d'accompagnement
	$requete_intitule = "SELECT CP.INTITULE, CP.TYPE_ACCOMPAGNEMENT, CP.NUM_PROJET FROM cardie_visite AS CV, cardie_projet AS CP
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CV.ID_VISITE = '".$id_visite."'";
	$resultat_requete_intitule = mysql_query($requete_intitule);
	$ligne_intitule = mysql_fetch_object($resultat_requete_intitule);
	$intitule = $ligne_intitule->INTITULE;
	$type_accompagnement = $ligne_intitule->TYPE_ACCOMPAGNEMENT;
	$num_projet = $ligne_intitule->NUM_PROJET;

	$message = "Fiche demande d'OM CARDIE pour l'accompagnement projets innovation (".$type_accompagnement.")\n\n
ANNEE SCOLAIRE : ".$annee_scolaire."\n\n
- DISPOSITIF ".$cardie_dispositif_formation."
- MODULE : ".$cardie_module_formation."\n\n";
			
	$message .= "PROJET : ".$intitule."\n\n";
	//Composition du message manuel
	$message_manuel = "Fiche demande d'OM CARDIE pour l'accompagnement projets innovation (".$type_accompagnement.")<br /><br />
- ANNEE SCOLAIRE : ".$annee_scolaire."<br /><br />
- DISPOSITIF ".$cardie_dispositif_formation."<br /><br />
- MODULE : ".$cardie_module_formation."<br /><br />
- PROJET : ".$intitule."<br /><br />";

	//On récupère les infos de la visite
	$date_visite = lecture_champ("cardie_visite","DATE_VISITE","ID_VISITE",$id_visite);
	$horaire_visite = lecture_champ("cardie_visite","HORAIRE_VISITE","ID_VISITE",$id_visite);
	$remarques = lecture_champ("cardie_visite","REMARQUES","ID_VISITE",$id_visite);
	
	//On calcul le numéro d'ordre de la visite
	$no_ordre = calcul_no_ordre_visite($id_visite, $num_projet);
	
	//echo "<br />no_ordre : $no_ordre";

	//On converti la date pour l'affichage
	$date_visite = affiche_date($date_visite);
	
	$message .= "QUAND : V".$no_ordre." - ".$date_visite." - ".$horaire_visite."\n";
	$message_manuel .= "QUAND : V".$no_ordre." - ".$date_visite." - ".$horaire_visite."<br />";
	
	//On récupère les infos de l'établissements
	$requete_etab = "SELECT E.RNE, E.TYPE, E.NOM, E.VILLE FROM cardie_visite AS CV, cardie_projet AS CP, etablissements AS E
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.RNE = E.RNE
			AND CV.ID_VISITE = '".$id_visite."'";
	
	$resultat_requete_etab = mysql_query($requete_etab);
	$ligne_etab = mysql_fetch_object($resultat_requete_etab);
	$rne = $ligne_etab->RNE;
	$type = $ligne_etab->TYPE;
	$nom_etab = $ligne_etab->NOM;
	$ville_etab = $ligne_etab->VILLE;

	$message .= "OU : ".$type." ".$nom_etab.", ".$ville_etab." (".$rne.")\n"; 
	$message_manuel .= "OU : ".$type." ".$nom_etab.", ".$ville_etab." (".$rne.")<br />"; 

	$requete_intitule = "SELECT CP.INTITULE FROM cardie_visite AS CV, cardie_projet AS CP
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CV.ID_VISITE = '".$id_visite."'";
	$resultat_requete_intitule = mysql_query($requete_intitule);
	$ligne_intitule = mysql_fetch_object($resultat_requete_intitule);
	$intitule = $ligne_intitule->INTITULE;

	//On récupère les accompagnateurs
	$requete_accompagnateurs = "SELECT PRT.civil, PRT.nom, PRT.prenom
		FROM cardie_visite AS CV, cardie_projet AS CP, cardie_projet_accompagnement AS CPA, personnes_ressources_tice AS PRT, etablissements AS E
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CPA.FK_ID_PERS_RESS = PRT.id_pers_ress
			AND PRT.codetab = E.RNE
			AND CV.ID_VISITE = '".$id_visite."'";
	
	$message .= "ACCOMPAGNATEURS/TRICES : ";
	$message_manuel .= "ACCOMPAGNATEURS/TRICES : ";
	
	$resultat_requete_accompagnateurs = mysql_query($requete_accompagnateurs);
	while ($ligne_accompagnateurs = mysql_fetch_object($resultat_requete_accompagnateurs))
	{
		$nom = $ligne_accompagnateurs->nom;
		$prenom = $ligne_accompagnateurs->prenom;

		$message .= $prenom." ".$nom." ; ";
		$message_manuel .= $prenom." ".$nom." ; ";
	}
	
	$message .= "\n\nDEMANDEUR : ".$expediteur_nom;
	$message .= "\n\nREMARQUES : ".$remarques;
	$message_manuel .= "<br /><br />DEMANDEUR : ".$expediteur_nom."<br />REMARQUES : ".$remarques;;
	//echo "<br />message : $message";

	$ok = mail($destinataire, $sujet, $message, $entete);
	if($ok)
	{
		echo "<h2>Le message a bien &eacute;t&eacute; envoy&eacute; &agrave; la DAFOP pour envoi de l'OM</h2>";
	}
	else
	{
		echo "<h2>Une erreur s'est produite. Le message n'a pas &eacute;t&eacute; envoy&eacute;</h2>";
		echo "<h2>Merci de transmettre ce message manuellement &agrave; $destinataire</h2>";
		echo "<br />&Agrave copier dans le sujet : $sujet";
		echo "<br /><br />&Agrave copier dans le corps du message : <br />$message_manuel";
		echo "<br /><br />";
	}
	//Je mets à jour l'état de la visite sauf si c'est une demande de renvoi du message
	if ($renvoi <> "O")
	{
		$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='2' WHERE ID_VISITE = '".$id_visite."'";
		$resultat_maj = mysql_query($requete_maj_etat);
		//On enregistre le mouvement dans la table historique
		alimente_visite_historique($id_visite,"2");	
	}
?>
