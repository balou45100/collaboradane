<?php
	$id = $_GET['id'];
	$date_creation_jour = $_GET['date_creation_jour'];
	$date_creation_mois = $_GET['date_creation_mois'];
	$date_creation_annee = $_GET['date_creation_annee'];
	$date_echeance_jour = $_GET['date_echeance_jour'];
	$date_echeance_mois = $_GET['date_echeance_mois'];
	$date_echeance_annee = $_GET['date_echeance_annee'];
	$date_rappel_jour = $_GET['date_rappel_jour'];
	$date_rappel_mois = $_GET['date_rappel_mois'];
	$date_rappel_annee = $_GET['date_rappel_annee'];
	$description = $_GET['description'];
	$observation = $_GET['observation'];
	$etat = $_GET['etat'];
	$priorite = $_GET['priorite'];
	$visibilite = $_GET['visibilite'];
	$id_util_traitant = $_GET['id_util_traitant'];
	$id_createur = $_GET['id_createur'];
	
	//echo "<br>id_util_traitant : $id_util_traitant - id_createur : $id_createur";

/*
	echo "<br>id : $id";
	echo "<br>date_creation_jour : $date_creation_jour";
	echo "<br>date_creation_mois : $date_creation_mois";
	echo "<br>date_creation_annee : $date_creation_annee";
	echo "<br>date_echeance_jour : $date_echeance_jour";
	echo "<br>date_echeance_mois : $date_echeance_mois";
	echo "<br>date_echeance_annee : $date_echeance_annee";
	echo "<br>date_rappel_jour : $date_rappel_jour";
	echo "<br>date_rappel_mois : $date_rappel_mois";
	echo "<br>date_rappel_annee : $date_rappel_annee";
	echo "<br>description : $description";
	echo "<br>etat : $etat";
	echo "<br>priorite : $priorite";
	echo "<br>visibilite : $visibilite";
	echo "<br>id_util : $id_util";
	echo "<br>observation : $observation";
	* echo "<br>";
*/

	//Il faut formater les différentes dates pour l'enregistrement
	$date_creation_a_enregistrer = crevardate($date_creation_jour,$date_creation_mois,$date_creation_annee);
	$date_echeance_a_enregistrer = crevardate($date_echeance_jour,$date_echeance_mois,$date_echeance_annee);

	if ($date_rappel_jour <>"")
	{
		$date_rappel_a_enregistrer = crevardate($date_rappel_jour,$date_rappel_mois,$date_rappel_annee);
		//echo "<br>date_rappel_a_enregistrer : $date_rappel_a_enregistrer";
	}


	//enregistrement dans la base 

	$requete_maj = "UPDATE taches SET 
		`date_creation` = '".$date_creation_a_enregistrer."',
		`date_echeance` = '".$date_echeance_a_enregistrer."',
		`date_rappel` = '".$date_rappel_a_enregistrer."',
		`description` = '".$description."',
		`etat` = '".$etat."',
		`priorite` = '".$priorite."',
		`visibilite` = '".$visibilite."',
		`observation` = '".$observation."'
	WHERE id_tache = '".$id."';";

	//echo "<br />$requete_maj";
	
	$result_maj = mysql_query($requete_maj);
	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
/*	else
	{
		echo "<h2>La t&acirc;che a bien &eacute;t&eacute; modifi&eacute;e</h2>";
	}
*/	
	//On déplace le traitant statut_cta = 010 vers les personnes associés statut_cta = 001
	//echo "<br />id : $id - id_util_traitant : $id_util_traitant";
	$requete_maj2 = "UPDATE taches_util SET 
		`statut_cta` = '001'
	WHERE id_tache = '".$id."' AND statut_cta = '010';";
	$result_maj2 = mysql_query($requete_maj2);
	if(!$result_maj2)
	{
		echo "<h2>Erreur de basculement</h2>";
	}
/*	else
	{
		echo "<h2>Le traitant a &eacute;t&eacute; bascul&eacute;.</h2>";
	}
*/
	//On regarde si le traitant est la même personne que le créateur
	if ($id_util_traitant == $id_createur)
	{
		//echo "<br />on supprime les enregistrements avec statut_cta = 100, 110 ou 010";
		$requete_suppression = "DELETE FROM taches_util WHERE id_tache = '".$id."' AND (statut_cta = '100' OR statut_cta = '110' OR statut_cta = '010')";
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
/*		else
		{
			echo "<h2>La t&acirc;che a &eacute;t&eacute; supprim&eacute;e.</h2>";
		}
		echo "<br /> ensuite on ajoute le créateur / traitant avec statut_cta = 110";
*/		$requete_ajout_traitant = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
			VALUES ('".$id."','".$id_util_traitant."','110')";
		$result_ajout_traitant = mysql_query($requete_ajout_traitant);
		if (!$result_ajout_traitant)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
/*		else
		{
			echo "<h2>Le traitant a bien &eacute;t&eacute; ajout&eacute;</h2>";
		}
*/	}
	else
	{
		//echo "<br />On supprime le créateur et le traitant";
		$requete_suppression = "DELETE FROM taches_util WHERE id_tache = '".$id."' AND (statut_cta = '100' OR statut_cta = '110' OR statut_cta = '010')";
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
/*		else
		{
			echo "<h2>La t&acirc;che a &eacute;t&eacute; supprim&eacute;e.</h2>";
		}
*/
		//echo "<br />ensuite on ajoute le créateur avec statut_cta = 100 et le traitant avec statut_cta = 010"; 
		$requete_ajout_traitant = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
			VALUES
				('".$id."','".$id_createur."','100'),
				('".$id."','".$id_util_traitant."','010')";
		$result_ajout_traitant = mysql_query($requete_ajout_traitant);
		if (!$result_ajout_traitant)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
/*		else
		{
			echo "<h2>Le traitant et le créateur ont bien &eacute;t&eacute; ajout&eacute;s</h2>";
		}
*/
	}
	//echo "<br />Pour finir on supprime le traitant des personnes associées, statut_cta = 001";
	$requete_suppression = "DELETE FROM taches_util WHERE id_tache = '".$id."' AND id_util = '".$id_util_traitant."' AND statut_cta = '001'";
	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
/*	else
	{
		echo "<h2>Le traitant a &eacute;t&eacute; supprim&eacute; des personnes associ&eacute;es.</h2>";
	}
*/
?>
