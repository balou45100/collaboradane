<?php
	//echo "<h2>Enregistrement du projet</h2>";
	
	//On récupère les variables
	$rne = $_POST['rne'];
	$intitule_projet=$_POST['intitule_projet'];
	$annee = $_POST['annee'];
	$description = $_POST['description'];
	$decision_commission = $_POST['decision_commission'];
	$type_accompagnement = $_POST['type_accompagnement'];
	$type_groupe_developpement = $_POST['type_groupe_developpement'];
	
	//echo "<br />id_projet : $id_projet";
	//echo "<br />type_groupe_developpement : $type_groupe_developpement";
	
	
	$requete_enreg = "INSERT INTO cardie_projet
	(
		`RNE`,
		`INTITULE`,
		`ANNEE`,
		`DECISION_COMMISSION`,
		`TYPE_ACCOMPAGNEMENT`, 
		`DESCRIPTION`,
		`TYPE_GROUPE_DEVELOPPEMENT`
	)
	VALUES
	(
		'".$rne."', 
		'".$intitule_projet."',
		'".$annee."',
		'".$decision_commission."',
		'".$type_accompagnement."',
		'".$description."',
		'".$type_groupe_developpement."'

	);";
	$result_enreg = mysql_query($requete_enreg);
	if (!$result_enreg)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>Le projet a bien &eacute;t&eacute; ajout&eacute;</h2>";
	}
	
?>
