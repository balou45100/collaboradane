<?php
	//On récupère l'id du projet
	$id_projet = $_GET['id_projet'];
	$etat = $_GET['etat'];
	
	//echo "<br />id_projet : $id_projet";

	//On récupère l'état du projet
	$requete_select = "SELECT ACTIF FROM cardie_projet WHERE NUM_PROJET = '".$id_projet."'";
	
	//echo "<br />$requete_select";
	
	$resultat_requete_select = mysql_query($requete_select);
	
	$ligne = mysql_fetch_object($resultat_requete_select);
	$etat_recupere = $ligne->ACTIF;
	/*
	echo "<br />etat_recupere : $etat_recupere";
	echo "<br />etat : $etat";
	*/
	if ($etat == "O")
	{
		$requete_maj = "UPDATE cardie_projet SET 
		`ACTIF` = 'N'
		WHERE NUM_PROJET = '".$id_projet."';";
		
		//echo "<br />$requete_maj";
	}
	else
		$requete_maj = "UPDATE cardie_projet SET 
		`ACTIF` = 'O'
		WHERE NUM_PROJET = '".$id_projet."';";
	
	//echo "<br />$requete_maj";
	
	$resultat_requete_maj = mysql_query($requete_maj);
	
	if (!$resultat_requete_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>Le projet a bien &eacute;t&eacute; mis &agrave; jour</h2>";
	}
?>
