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
		case "1" : //Elle retourne à l'état de création
			//include("cardie_gestion_reculer_visite_e1.inc.php");
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='0' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"0");
			echo "<h2>La visite a &eacute;t&eacute; recul&eacute;e &agrave; l'&eacute;tat de cr&eacute;ation</h2>";
		break;

		case "2" : //Elle reculé à l'état 1
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='1' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"1");
		break;

		case "3" : //Elle reculé à l'état 2
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='2' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"2");
		break;

		case "4" : //L'accompagnateur signale que l'EF a été envoyé
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='3' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"3");
		break;

		case "5" : //La DAFOP indique que l'EF a été traité
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='4' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"4");
		break;

		case "6" : //Elle reculé à l'état 5
			$requete_maj_etat = "UPDATE cardie_visite SET ETAT ='5' WHERE ID_VISITE = '".$id_visite."'";
			$resultat_maj = mysql_query($requete_maj_etat);
			//On enregistre le mouvement dans la table historique
			alimente_visite_historique($id_visite,"5");
		break;
	}
?>
