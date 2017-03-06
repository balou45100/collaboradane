<?php
	$intitule = $_GET['intitule']; //récupération du nom du dossier
	$description = $_GET['description']; //récupération de la descreiption du dossier
	$confidentialite = $_GET['confidentialite'];
	$id_responsable = $_GET['id_responsable'];
	//$id_util_associes = $_GET['id_util_associes'];
	//$id_util = $_SESSION['id_util'];
/*
	$jour = $_GET['jour'];
	$mois = $_GET['mois'];
	$annee = $_GET['annee'];
	$jour_rappel = $_GET['jour_rappel'];
	$mois_rappel = $_GET['mois_rappel'];
	$annee_rappel = $_GET['annee_rappel'];
	$nbr_jours = $_GET['nbr_jours'];
	$priorite = $_GET['priorite'];
	$id_categorie = $_GET['id_categorie'];
	$etat = "PU";
*/
/*
	echo "<br>intitule : $intitule";
	echo "<br>description : $description";
	echo "<br>confidentialite : $confidentialite";
	echo "<br>id_responsable : $id_responsable";
	echo "<br>id_util : $id_util";
	echo "<br>id_util_associes : $id_util_associes";
	echo "<br>aujourd'hui : $date_aujourdhui";
	echo "<br>jour : $jour";
	echo "<br>mois : $mois";
	echo "<br>annee : $annee";
	echo "<br>nbr_jours : $nbr_jours";
	echo "<br>jour_rappel : $jour_rappel";
	echo "<br>mois_rappel : $mois_rappel";
	echo "<br>annee_rappel : $annee_rappel";
	echo "<br>etat : $etat";
	echo "<br>priorite : $priorite";
	echo "<br>id_categorie : $id_categorie";

//	echo "<br>1 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";

*/


//Début des différents traitements


//////////////////////////////////////////////////////////////////////////
/////// Génération des différentes dates /////////////////////////////////
//////////////////////////////////////////////////////////////////////////
	$aujourdhui = date('Y/m/d');
	//$date_creation = date('Y/m/d',$aujourdhui);
	$date_creation = date('Y/m/d');
	$aujourdhui = strtotime($aujourdhui); //transforme la date en entier

	//echo "<br>date_creation : $date_creation";
	
	// On enregistre le dossier
	
	$requete_ajout = "INSERT INTO `categorie_commune` (`intitule_categ`,`description_categ`,`actif`)
		VALUES ('".$intitule."','".$description."','O')";

	//echo "<br />$requete_ajout";
	
	$resultat_ajout = mysql_query($requete_ajout);

	if(!$resultat_ajout)
	{
		echo "<h2>Le dossier n'a pas pu &ecirc;tre enregistr&eacute;</h2>";
	}
	else
	{
		// On récupère l'id du dossier
		$id_dossier_insere = mysql_insert_id();
		
		//echo "<br />Voici le dernier identifiant enregistré : $id_dossier_insere";
		
		//On renseigne la table dos_dossier 
		$requete_ajout_dos_dossier = "INSERT INTO `dos_dossier` (`idDossier`,`responsable`,`confidentialite`,`statut`,`DateCreation`)
			VALUES ('".$id_dossier_insere."','".$id_responsable."','".$confidentialite."','OUVERT','".$date_creation."')";
			
		//echo "<br />$requete_ajout_dos_dossier";
		
		$resultat_ajout = mysql_query($requete_ajout_dos_dossier);

		echo "<h2>Le dossier a &eacute;t&eacute; enregistr&eacute;</h2>";
	}


?>
