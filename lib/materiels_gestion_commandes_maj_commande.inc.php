<?php
	$id_cde = $_GET['id_cde'];
	$devis = $_GET['devis'];
	$ref_commande = $_GET['ref_commande'];
	$date_commande_jour = $_GET['date_commande_jour'];
	$date_commande_mois = $_GET['date_commande_mois'];
	$date_commande_annee = $_GET['date_commande_annee'];
	$bon_livraison = $_GET['bon_livraison'];
	$date_livraison_complete_jour = $_GET['date_livraison_complete_jour'];
	$date_livraison_complete_mois = $_GET['date_livraison_complete_mois'];
	$date_livraison_complete_annee = $_GET['date_livraison_complete_annee'];
	$id_facture = $_GET['id_facture'];
	$date_facture_jour = $_GET['date_facture_jour'];
	$date_facture_mois = $_GET['date_facture_mois'];
	$date_facture_annee = $_GET['date_facture_annee'];
	$fournisseur = $_GET['fournisseur'];
	$credits = $_GET['credits'];
	$annee_budgetaire = $_GET['annee_budgetaire'];
	$frais_de_port = $_GET['frais_de_port'];
	$total_commande = $_GET['total_commande'];
	$remarques = $_GET['remarques'];

	//Préparation des dates à enregistrer
	$date_commande_a_enregistrer = crevardate($date_commande_jour,$date_commande_mois,$date_commande_annee);
	$date_livraison_complete_a_enregistrer = crevardate($date_livraison_complete_jour,$date_livraison_complete_mois,$date_livraison_complete_annee);
	$date_facture_a_enregistrer = crevardate($date_facture_jour,$date_facture_mois,$date_facture_annee);
	
	//Il faut vérifier la saisie du prix et remplacer la virgule par un point
	$total_commande = ereg_replace(',','.', $total_commande);
	
/*
	echo "<br><b>***materiels_gestion_commandes_maj_materiel.inc.php***</b>";
	echo "<br>id_cde : $id_cde";
	echo "<br>date_commande_jour : $date_commande_jour";
	echo "<br>date_commande_mois : $date_commande_mois";
	echo "<br>date_commande_annee : $date_commande_annee";
	echo "<br>date_commande_a_enregistrer : $date_commande_a_enregistrer";
*/
	//mise à jour de l'enregistrement

	$requete_maj = "UPDATE materiels_commandes SET
		`devis` = '".$devis."',
		`ref_commande` = '".$ref_commande."',
		`date_commande` = '".$date_commande_a_enregistrer."',
		`bon_livraison` = '".$bon_livraison."',
		`date_livraison_complete` = '".$date_livraison_complete_a_enregistrer."',
		`id_facture` = '".$id_facture."',
		`date_facture` = '".$date_facture_a_enregistrer."',
		`fournisseur` = '".$fournisseur."',
		`credits` = '".$credits."',
		`annee_budgetaire` = '".$annee_budgetaire."',
		`frais_de_port` = '".$frais_de_port."',
		`total_commande` = '".$total_commande."',
		`remarques` = '".$remarques."'
	WHERE id_commande = '".$id_cde."';";

	$result_maj = mysql_query($requete_maj);
	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>La commande a bien &eacute;t&eacute; modifi&eacute;e</h2>";
	}
?>
