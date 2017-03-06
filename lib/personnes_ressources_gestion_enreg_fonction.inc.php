<?php
	$id_pers_ress_exercice = $_GET['id_pers_ress_exercice'];
	$id_fonction_exercice = $_GET['id_fonction_exercice'];
	$annee_exercice = $_GET['annee_exercice'];
	$rne_exercice = $_GET['rne_exercice'];
	if ($annee_exercice <2015)
	{
		$nbr_heures_exercice = $_GET['nbr_heures_exercice'];
		$hse_exercice = $_GET['hse_exercice'];
	}
	else
	{
		$taux_imp_exercice = $_GET['taux_imp_exercice'];
		//On récupère le montant correspondant
		$montant_imp = lecture_champ('imp','montant','taux',$taux_imp_exercice);
	}
	$observation = $_GET['observation'];

	
	
	/*
	echo "<br>id_pers_ress_exercice : $id_pers_ress_exercice";
	echo "<br>id_fonction_exercice : $id_fonction_exercice";
	echo "<br>annee_exercice : $annee_exercice";
	echo "<br>rne_exercice : $rne_exercice";
	echo "<br>nbr_heures_exercice : $nbr_heures_exercice";
	echo "<br>hse_exercice : $hse_exercice";
	echo "<br>montant_imp : $montant_imp";
	*/
	if ($hse_exercice == "Oui")
	{
		$nbr_heures_exercice = number_format($nbr_heures_exercice/36,2);
	}
	//echo "<br>nbr_heures_a_enregistrer : $nbr_heures_exercice";
/*
	echo "<br>civil : $civil";
	echo "<br>nom : $nom";
	echo "<br>prenom : $prenom";
	echo "<br>rne : $rne";
	echo "<br>mel : $mel";
	echo "<br>discipline : $discipline";
	echo "<br>poste : $poste";
	echo "<br>";
*/
	//Il faut récupérer le domaine budgétaire de la fonction saisie
	$requete_domaine_budget="SELECT domaine_budget, intitule_fonction FROM fonctions_personnes_ressources WHERE id_fonction = '$id_fonction_exercice'";
	
	//echo "<br />$requete_domaine_budget";
	
	$result_domaine_budget=mysql_query($requete_domaine_budget);
	$ligne_domaine_budget=mysql_fetch_object($result_domaine_budget);
	$id_domaine_budget=$ligne_domaine_budget->domaine_budget;
	$intitule_fonction_exercice=$ligne_domaine_budget->intitule_fonction;
	
	//echo "<br>id_domaine_budget : $id_domaine_budget";
	//echo "<br>intitule_fonction_exercice : $intitule_fonction_exercice";

	//enregistrement dans la base
	if ($annee_exercice <2015)
	{
		$requete_enreg = "INSERT INTO fonctions_des_personnes_ressources (
			`id_pers_ress` ,
			`fonction` ,
			`annee` ,
			`rne` ,
			`nbr_hsa`,
			`domaine_budget`,
			`observation`,
			`id_fonction`
		)
		VALUES (
			'".$id_pers_ress_exercice."', '".$intitule_fonction_exercice."', '".$annee_exercice."', '".$rne_exercice."', '".$nbr_heures_exercice."', '".$id_domaine_budget."', '".$observation."', '".$id_fonction_exercice."'
		);";
	}
	else
	{
		$requete_enreg = "INSERT INTO fonctions_des_personnes_ressources (
			`id_pers_ress` ,
			`fonction` ,
			`annee` ,
			`rne` ,
			`domaine_budget`,
			`observation`,
			`somme_imp`,
			`id_fonction`
		)
		VALUES (
			'".$id_pers_ress_exercice."', '".$intitule_fonction_exercice."', '".$annee_exercice."', '".$rne_exercice."', '".$id_domaine_budget."', '".$observation."', '".$montant_imp."', '".$id_fonction_exercice."'
		);";
	}

	$result_enreg = mysql_query($requete_enreg);
	if (!$result_enreg)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>La fonction a bien &eacute;t&eacute; enregistr&eacute;e</h2>";
	}
?>
