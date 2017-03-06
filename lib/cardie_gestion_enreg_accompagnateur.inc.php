<?php
	//echo "<h2>Enregistrement d'accompagnateur/trice</h2>";
	
	//On récupère les variables
	$id_projet = $_GET['id_projet'];
	$id_pers_ress = $_GET['id_pers_ress'];
	
	/*
	echo "<br />id_projet : $id_projet";
	echo "<br />id_pers_ress : $id_pers_ress";
	*/
	$requete_enreg = "INSERT INTO cardie_projet_accompagnement
	(
		`FK_NUM_PROJET`,
		`FK_ID_PERS_RESS`
	)
	VALUES
	(
		'".$id_projet."', 
		'".$id_pers_ress."'
	);";
	$result_enreg = mysql_query($requete_enreg);
	if (!$result_enreg)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		//echo "<h2>L'accompagnateur/trice a bien &eacute;t&eacute; ajout&eacute;-e</h2>";
	}

?>
