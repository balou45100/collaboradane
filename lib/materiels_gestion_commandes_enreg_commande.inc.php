<?php
	$annee_budgetaire = $_GET['annee_budgetaire'];
	$credits = $_GET['credits'];
	$fournisseur = $_GET['fournisseur'];
	$total_commande = $_GET['total_commande'];
	$frais_de_port = $_GET['frais_de_port'];
	$devis = $_GET['devis'];
	$ref_commande = $_GET['ref_commande'];
	$jour_commande = $_GET['jour_commande'];
	$mois_commande = $_GET['mois_commande'];
	$annee_commande = $_GET['annee_commande'];
	$bon_livraison = $_GET['bon_livraison'];
	$jour_livraison = $_GET['jour_livraison'];
	$mois_livraison = $_GET['mois_livraison'];
	$annee_livraison = $_GET['annee_livraison'];
	$id_facture = $_GET['id_facture'];
	$jour_facture = $_GET['jour_facture'];
	$mois_facture = $_GET['mois_facture'];
	$annee_facture = $_GET['annee_facture'];
	$remarques = $_GET['remarques'];

	//Préparation des dates à enregistrer
	$date_commande_a_enregistrer = crevardate($jour_commande,$mois_commande,$annee_commande);

	if ($jour_livraison <>"")
	{
		$date_livraison_a_enregistrer = crevardate($jour_livraison,$mois_livraison,$annee_livraison);
	}
	else
	{
		$date_livraison_a_enregistrer = "";
	}

	if ($jour_facture <>"")
	{
		$date_facture_a_enregistrer = crevardate($jour_facture,$mois_facture,$annee_facture);
	}
	else
	{
		$date_facture_a_enregistrer = "";
	}
	
	
	//Il faut vérifier la saisie du prix et remplacer la virgule par un point
	$total_commande = ereg_replace(',','.', $total_commande);

/*
	echo "<br>annee_budgetaire : $annee_budgetaire";
	echo "<br>credits : $credits";
	echo "<br>fournisseur : $fournisseur";
	echo "<br>total_commande : $total_commande";
	echo "<br>frais_de_port : $frais_de_port";
	echo "<br>devis : $devis";
	echo "<br>ref_commande : $ref_commande";
	echo "<br>date_commande : $date_commande";
	echo "<br>bon_livraison : $bon_livraison";
	echo "<br>date_livraison : $date_livraison";
	echo "<br>id_facture : $id_facture";
	echo "<br>date_facture : $date_facture";
	echo "<br>remarques : $remarques";
*/	

	//enregistrement dans la base
	$requete_enreg = "INSERT INTO materiels_commandes
	(
		`annee_budgetaire` ,
		`credits` ,
		`fournisseur` ,
		`total_commande` ,
		`frais_de_port` ,
		`devis` ,
		`ref_commande` ,
		`date_commande` ,
		`bon_livraison` ,
		`date_livraison_complete` ,
		`id_facture` ,
		`date_facture` ,
		`remarques`
	)
	VALUES
	(
		'".$annee_budgetaire."',
		'".$credits."',
		'".$fournisseur."',
		'".$total_commande."',
		'".$frais_de_port."',
		'".$devis."',
		'".$ref_commande."',
		'".$date_commande_a_enregistrer."',
		'".$bon_livraison."',
		'".$date_livraison_a_enregistrer."',
		'".$id_facture."',
		'".$date_facture_a_enregistrer."',
		'".$remarques."'
	);";
	$result_enreg = mysql_query($requete_enreg);
	if (!$result_enreg)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>Commande enregistr&eacute;e</h2>";
	}
?>
