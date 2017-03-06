<?php
	$script_affectation = $_GET['script_affectation']; //Pour savoir si c'est le script de changement d'affectation qui appelle la procédure
	$script_modification = $_GET['script_modification']; //Pour savoir si c'est le script de modification qui appelle la procédure
	$denomination = $_GET['denomination'];
	$id_cat_princ = $_GET['id_cat_princ'];
	$no_serie = $_GET['no_serie'];
	$cle_install = $_GET['cle_install'];
	$prix = $_GET['prix'];
	$id_chapitre_credits = $_GET['id_chapitre_credits'];
	$annee_budgetaire = $_GET['annee_budgetaire'];
	$jour_livraison = $_GET['jour_livraison'];
	$mois_livraison = $_GET['mois_livraison'];
	$annee_livraison = $_GET['annee_livraison'];
	$id_origine = $_GET['id_origine'];
	$id_affectation = $_GET['id_affectation'];
	$id = $_GET['id'];
	$jour_affectation = $_GET['jour_affectation'];
	$mois_affectation = $_GET['mois_affectation'];
	$annee_affectation = $_GET['annee_affectation'];
	$jour_retour = $_GET['jour_retour'];
	$mois_retour = $_GET['mois_retour'];
	$annee_retour = $_GET['annee_retour'];
	$type_affectation = $_GET['type_affectation'];
	$details_article = $_GET['details_article'];
	$remarques = $_GET['remarques'];
	$a_editer = $_GET['a_editer'];
	$details_garantie = $_GET['details_garantie'];
	$jour_fin_garantie = $_GET['jour_fin_garantie'];
	$mois_fin_garantie = $_GET['mois_fin_garantie'];
	$annee_fin_garantie = $_GET['annee_fin_garantie'];
	$problemes_rencontres = $_GET['problemes_rencontres'];
	$id_cde = $_GET['id_cde'];
	$id_facture = $_GET['id_facture'];
	$id_etat = $_GET['id_etat'];
	$id_lieu_stockage = $_GET['id_lieu_stockage'];
	
	//echo "<br />id_lieu_stockage : $id_lieu_stockage - id_affectation : $id_affectation - id_etat : $id_etat";
	//echo "<br />script_affectation : $script_affestation";

	//On modifie l'état en fonction de l'affectation du matériel
	 	if ($script_affectation == "O")
 	{
		If ($id_affectation > 0)
		{
			//echo "<br />id_affectation > 0";
			//Il faut récupérer id_etat_affectation pour renseigner le champ id_etat
			$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id_affectation."';";
			$result_affectation = mysql_query($requete_affectation);
			$ligne_affectation = mysql_fetch_object($result_affectation);
			$intitule_affectation = $ligne_affectation->intitule_affectation;
			$id_etat = $ligne_affectation->id_etat_affectation;
		
			echo "<br />intitule_affectation : $intitule_affectation";
		
			if ($id_lieu_stockage == 0)
			{
				//echo "<br />id_affectation > 0 et id_lieu_stockage = 0";
				$id_etat = 7;
			}
		} //Fin If ($id_affectation > 0)
		else
		{
			if ($id_lieu_stockage == 0)
			{
				//echo "<br />id_affectation = 0 et id_lieu_stockage = 0";
				$id_etat = 11;
			}
			else
			{
				//echo "<br />id_affectation = 0 et id_lieu_stockage > 0";
				if ($id_lieu_stockage == "16") //sorti du stock
				{
					$id_etat = 10;
				}
				else
				{
					$id_etat = 5;
				}
			}
		} //Fin else If ($id_affectation > 0)
	} //Fin if script_affectation = "O"

	
/*	if (!ISSET($id_etat))
	{
		If ($id_affectation > 0)
		{
			echo "<br />id_etat vide et id_affectation > 0";
			//Il faut récupérer id_etat_affectation pour renseigner le champ id_etat
			$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id_affectation."';";
			$result_affectation = mysql_query($requete_affectation);
			$ligne_affectation = mysql_fetch_object($result_affectation);
			$intitule_affectation = $ligne_affectation->intitule_affectation;
			$id_etat = $ligne_affectation->id_etat_affectation;
		}
		else
		{
			echo "<br />id_etat vide et id_affectation = 0";
		}

	}
	else
	{
		echo "<br />id_etat renseigné ($id_etat)";
	}
*/	
	//echo "<br />id_chapitre_credits : $id_chapitre_credits";
	
	//Préparation des dates à enregistrer
	$date_affectation_a_enregistrer = crevardate($jour_affectation,$mois_affectation,$annee_affectation);
	$date_retour_a_enregistrer = crevardate($jour_retour,$mois_retour,$annee_retour);
	$date_fin_garantie_a_enregistrer = crevardate($jour_fin_garantie,$mois_fin_garantie,$annee_fin_garantie);
	$date_livraison_a_enregistrer = crevardate($jour_livraison,$mois_livraison,$annee_livraison);
	
	//Il faut vérifier la saisie du prix et remplacer la virgule par un point
	$prix = ereg_replace(',','.', $prix);
	
	/*
	echo "<br><b>***materiels_gestion_maj_materiel.inc.php***</b>";
	echo "<br>script_modification : $script_modification";
	echo "<br>script_affectation : $script_affectation";
	echo "<br>id : $id";
	echo "<br>denomination : $denomination";
	echo "<br>id_cat_princ : $id_cat_princ";
	echo "<br>id_origine : $id_origine";
	echo "<br>id_affectation_transmis : $id_affectation";
	echo "<br>date_affectation : $date_affectation_a_enregistrer";
	echo "<br>date_retour : $date_retour_a_enregistrer";
	echo "<br>details_article : $details_article";
	echo "<br>type_affectation : $type_affectation";
	echo "<br>prix : $prix";
	echo "<br>fin_garantie : $date_fin_garantie_a_enregistrer";
	echo "<br>details_garantie : $details_garantie";
	echo "<br>problemes_rencontres : $problemes_rencontres";
	echo "<br>id_cde : $id_cde";
	echo "<br>id_facture : $id_facture";
	echo "<br>id_etat : $id_etat";
	echo "<br>id_etat_affectation : $id_etat_affectation";
	echo "<br>a_editer : $a_editer";
	*/
	//mise à jour de l'enregistrement

 	if ($script_affectation == "O")
 	{
		$requete_maj = "UPDATE materiels SET 
			`affectation_materiel` = '".$id_affectation."',
			`date_affectation` = '".$date_affectation_a_enregistrer."',
			`date_retour` = '".$date_retour_a_enregistrer."',
			`type_affectation` = '".$type_affectation."',
			`id_etat` = '".$id_etat."',
			`lieu_stockage` = '".$id_lieu_stockage."',
			`a_editer` = '".$a_editer."'
		WHERE id = '".$id."';";
 	}
 	else
 	{
		$requete_maj = "UPDATE materiels SET 
			`denomination` = '".$denomination."',
			`categorie_principale` = '".$id_cat_princ."',
			`no_serie` = '".$no_serie."',
			`cle_install` = '".$cle_install."',
			`prix` = '".$prix."',
			`credits` = '".$id_chapitre_credits."',
			`annee_budgetaire` = '".$annee_budgetaire."',
			`date_livraison` = '".$date_livraison_a_enregistrer."',
			`origine` = '".$id_origine."',
			`affectation_materiel` = '".$id_affectation."',
			`date_affectation` = '".$date_affectation_a_enregistrer."',
			`date_retour` = '".$date_retour_a_enregistrer."',
			`type_affectation` = '".$type_affectation."',
			`details_article` = '".$details_article."',
			`remarques` = '".$remarques."',
			`a_editer` = '".$a_editer."',
			`details_garantie` = '".$details_garantie."',
			`fin_garantie` = '".$date_fin_garantie_a_enregistrer."',
			`problemes_rencontres` = '".$problemes_rencontres."',
			`id_cde` = '".$id_cde."',
			`id_facture` = '".$id_facture."',
			`lieu_stockage` = '".$id_lieu_stockage."',
			`id_etat` = '".$id_etat."'
		WHERE id = '".$id."';";
 	}

	$result_maj = mysql_query($requete_maj);
	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>Le mat&eacute;riel a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}
?>
