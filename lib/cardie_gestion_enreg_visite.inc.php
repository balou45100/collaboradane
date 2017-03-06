<?php
	//echo "<h2>Enregistrement de la visite</h2>";
	
	//On récupère les variables
	$id_projet = $_POST['id_projet'];
	$date_visite=$_POST['date_visite'];
	$horaire_debut=$_POST['horaire_debut'];
	$horaire_fin=$_POST['horaire_fin'];
	$remarques = $_POST['remarques'];
	/*
	echo "<br />id_projet : $id_projet";
	echo "<br />date_visite : $date_visite";
	echo "<br />horaire_debut : $horaire_debut";
	echo "<br />horaire_fin : $horaire_fin";
	echo "<br />remarques : $remarques";
	*/
	$horaire_a_enregistrer = $horaire_debut."-".$horaire_fin;
	
	$requete_enreg_visite = "INSERT INTO cardie_visite
	(
		`DATE_VISITE`,
		`HORAIRE_VISITE`,
		`FK_NUM_PROJET`,
		`ETAT`,
		`REMARQUES`
	)
	VALUES
	(
		'".$date_visite."', 
		'".$horaire_a_enregistrer."', 
		'".$id_projet."',
		'0',
		'".$remarques."'
	);";
	
	//echo "<br />$requete_enreg_visite";

	$resultat_enreg_visite = mysql_query($requete_enreg_visite);
	if (!$resultat_enreg_visite)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		//On enregistre le mouvement dans la table historique
		//On récupère le dernier identifiant généré
		$id_visite = mysql_insert_id();
		
		//echo "<br />id_visite : $id_visite";
		
		alimente_visite_historique($id_visite,"0");
		//echo "<h2>Le projet a bien &eacute;t&eacute; ajout&eacute;</h2>";
	}
?>
