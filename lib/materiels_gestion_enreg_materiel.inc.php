<?php
	$denomination = $_GET['denomination'];
	$id_typemateriel = $_GET['id_typemateriel'];
	$id_origine = $_GET['id_origine'];
	$id_affectation = $_GET['id_affectation'];
	$no_serie = $_GET['no_serie'];
	$jour_livraison = $_GET['jour_livraison'];
	$mois_livraison = $_GET['mois_livraison'];
	$annee_livraison = $_GET['annee_livraison'];
	$jour_fin_garantie = $_GET['jour_fin_garantie'];
	$mois_fin_garantie = $_GET['mois_fin_garantie'];
	$annee_fin_garantie = $_GET['annee_fin_garantie'];
	$id_chapitre_credits = $_GET['id_chapitre_credits'];
	$prix_achat = $_GET['prix_achat'];
	$annee_budgetaire = $_GET['annee_budgetaire'];
	$nombre_articles = $_GET['nombre_articles'];
	$details_article = $_GET['details_article'];
	$remarques = $_GET['remarques'];
	$id_cde = $_GET['id_cde'];
	$id_etat = $_GET['id_etat'];
	$lieux_stockage = $_GET['lieux_stockage'];
	$id_lieu_stockage = $_GET['id_lieu_stockage'];
	

	$aujourdhui_jour = date('d');
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
 
	//Préparation des dates à enregistrer
	$date_livraison_a_enregistrer = crevardate($jour_livraison,$mois_livraison,$annee_livraison);
	$date_fin_garantie_a_enregistrer = crevardate($jour_fin_garantie,$mois_fin_garantie,$annee_fin_garantie);
	
	//Il faut vérifier la saisie du prix et remplacer la virgule par un point
	$prix_achat = ereg_replace(',','.', $prix_achat);
	
	//On initialise le type_affecation et les dates
	$type_affectation = "permanente";
	$date_affectation_a_enregistrer = crevardate($aujourdhui_jour,$aujourdhui_mois,$aujourdhui_annee);
	$date_retour_a_enregistrer = crevardate($aujourdhui_jour,$aujourdhui_mois,$aujourdhui_annee);
	if ($date_livraison_a_enregistrer == "1970-01-01")
	{
		$date_livraison_a_enregistrer = $date_retour_a_enregistrer; 
	}
/*
	echo "<br>*** materiels_gestion_enreg_materiel.inc.php ***";
	echo "<br />jour : $aujourdhui_jour";
	echo "<br />mois : $aujourdhui_mois";
	echo "<br />annee : $aujourdhui_annee";
	echo "<br />date_livraison_a_enregistrer : $date_livraison_a_enregistrer";
	echo "<br />date_affectation_a_enregistrer : $date_affectation_a_enregistrer";
	echo "<br />date_retour_a_enregistrer : $date_retour_a_enregistrer<br />";
	echo "<br>denomination : $denomination";
	echo "<br>id_typemateriel : $id_typemateriel";
	echo "<br>id_origine : $id_origine";
	echo "<br>id_affectation : $id_affectation";
	echo "<br>id_chapitre_credits : $id_chapitre_credits";
	echo "<br>annee_budgetaire : $annee_budgetaire";
	echo "<br>prix_achat : $prix_achat";
	echo "<br />id_lieu_stockage :$id_lieu_stockage";
*/


	//enregistrement dans la base
	for ($nbr_articles = 1; $nbr_articles <= $nombre_articles; $nbr_articles++)
	{
 		$requete_enreg = "INSERT INTO materiels
		(
			`denomination`,
			`categorie_principale`,
			`no_serie`,
			`date_livraison`,
			`date_affectation`,
			`date_retour`,
			`fin_garantie`,
			`origine`,
			`credits`,
			`affectation_materiel`,
			`type_affectation`,
			`annee_budgetaire`,
			`details_article`,
			`remarques`,
			`prix`,
			`id_cde`,
			`lieu_stockage`,
			`id_etat`
		)
		VALUES
		(
			'".$denomination."', 
			'".$id_typemateriel."',
			'".$no_serie."',
			'".$date_livraison_a_enregistrer."', 
			'".$date_affectation_a_enregistrer."', 
			'".$date_retour_a_enregistrer."', 
			'".$date_fin_garantie_a_enregistrer."', 
			'".$id_origine."', 
			'".$id_chapitre_credits."', 
			'".$id_affectation."', 
			'".$type_affectation."', 
			'".$annee_budgetaire."', 
			'".$details_article."',
			'".$remarques."',
			'".$prix_achat."', 
			'".$id_cde."', 
			'".$id_lieu_stockage."', 
			'".$id_etat."'
		);";
		$result_enreg = mysql_query($requete_enreg);
		if (!$result_enreg)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
		else
		{
			echo " * ";
		}
	}
	echo "<br></br>";
?>
