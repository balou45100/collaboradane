<?php
	//echo "<br />avancer_e0 - id_visite : $id_visite";
	
	//Il faut envoyer un message confirmant la date de la visite
	//On récupère le mel de la personne connectée
	
	//$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
	$entete="From: collaboratice\r\nX-Mailer: PHP/";
	//$entete ='From: \'".$expediteur_nom."\'<\'".$expediteur_mel."\'>'."\n'X-Mailer: PHP'";
	//$entete .='Reply-To: adresse_de_reponse@fai.fr'."\n";
	$entete .='Content-Type: text/html; charset=\"UTF-8\"'."\n";
	//$entete .='Content-Transfer-Encoding: 8bit'; 
	$destinataire = $cardie_mel_fonctionnelle;
	$sujet = "[ACCOMPAGNATEUR/TRICE->CARDIE] Demande d'OM";
	$message = "Bonjour,
Merci d'etablir les ordres de mission pour la visite No ".$id_visite."
- Demandeur : ".$expediteur_nom;

	//On compose le message un peu différemment s'il faut l'envoyer manuellement
	$message_manuel = "Bonjour,<br />Merci d'etablir les ordres de mission pour la visite No ".$id_visite."<br />- Demandeur : ".$expediteur_nom;
	//echo "<br />message : $message";
	
	$ok = mail($destinataire, $sujet, $message, $entete);
	if($ok)
	{
		echo "<h2>Le message a bien &eacute;t&eacute; envoy&eacute; aux gestionnaires pour &eacute;tablissement de l'OM</h2>";
	}
	else
	{
	echo "<h2>Une erreur s'est produite. Le message n'a pas &eacute;t&eacute; envoy&eacute;</h2>";
	echo "<h2>Merci de transmettre ce message manuellement &agrave; $destinataire</h2>";
	echo "<br />&Agrave copier dans le sujet : $sujet";
	echo "<br /><br />&Agrave copier dans le corps du message : <br />$message_manuel";
	echo "<br /><br />";
}
		//Je mets à jour l'état de la visite
	$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='1' WHERE ID_VISITE = '".$id_visite."'";
	
	//echo "<br />$requete_maj_etat";
	
	$resultat_maj = mysql_query($requete_maj_etat);
	//On enregistre le mouvement dans la table historique
	alimente_visite_historique($id_visite,"1");
?>
