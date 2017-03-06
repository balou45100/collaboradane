<?php

	$id_visite = $_GET['id_visite'];
	if (!ISSET($id_visite))
	{
		$id_visite = $_POST['id_visite'];
	}
	$etat_visite = $_GET['etat'];
	if (!ISSET($etat_visite))
	{
		$etat_visite = $_POST['etat'];
	}
	/*
	echo "<br />id_visite : $id_visite";
	echo "<br />etat_visite : $etat_visite";
	echo "<br />mode_affichage : $mode_affichage";
	*/
	//Les variables disponibles
	/*
	$cardie_dispositif_formation
	$cardie_module_formation
	$cardie_mel_fonctionnelle
	$dafop_mel_fonctionnelle
	*/
	//On récupère les informations de la personne connectée
	$expediteur_mel = $_SESSION['mail'];
	$expediteur_nom = $_SESSION['nom'];
	
	switch ($etat_visite)
	{
		case "0" : //L'accompagnateur la transmets pour validation par les gestionnaires
			//echo "<br />case etat_visite = 1";
			include("cardie_gestion_avancer_visite_e0.inc.php");
		break;

		case "1" : //Elle est validée du côté des gestionnaires et transmise à la DAFOP
			//echo "<br />case etat_visite = 1";
			include("cardie_gestion_avancer_visite_e1.inc.php");
		break;

		case "2" : //la DAFOP a établi l'OM
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='3' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"3");
		break;

		case "3" : //L'accompagnateur indique que la visite a été effectuée
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='4' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"4");
		break;

		case "4" : //L'accompagnateur signale que l'EF a été envoyé
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='5' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"5");
		break;

		case "5" : //La DAFOP indique que l'EF a été traité
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='6' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"6");
		break;
	}
?>
