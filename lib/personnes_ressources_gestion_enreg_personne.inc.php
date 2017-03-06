<?php
	$rne = $_GET['rne'];
	$civil = $_GET['civil'];
	$nom = $_GET['nom'];
	$prenom = $_GET['prenom'];
	$mel = $_GET['mel'];
	$discipline = $_GET['discipline'];
	$poste = $_GET['poste'];
	//on formate les entrées
	if ($mel == "")
	{
		$mel = $prenom.".".$nom;
		$mel = supprime_accents($mel);
	}
	$nom = strtoupper($nom);
	$mel = strtolower($mel);

	//on fixe la date de création de l'enregistrement
	$date_creation = date("y.m.d");

	//echo "<br>date_creation : $date_creation";
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
	//Il faut récupérer les id à la place des intitulés de la discipline et du poste
	//D'abord la discipline
	if ($discipline<>"")
	{
		$requete_discipline = "SELECT * FROM discipline WHERE discipline = '".$discipline."';";
		$result_discipline = mysql_query($requete_discipline);
		$ligne_discipline = mysql_fetch_object($result_discipline);
		$id_discipline = $ligne_discipline->id_discipline;
		//echo "<br>La discipline \"$discipline\" a été transmise. Elle à $id_discipline comme identifiant.";
		
	} //Fin if $discipline <>""

	if ($poste <>"")
	{
		$requete_poste = "SELECT * FROM postes WHERE poste = '".$poste."';";
		$result_poste = mysql_query($requete_poste);
		$ligne_poste = mysql_fetch_object($result_poste);
		$id_poste = $ligne_poste->id_poste;
		//echo "<br>Le poste \"$poste\" a été transmis. Il à $id_poste comme identifiant.";
	} //Fin if $poste <>""

	//enregistrement dans la base

	$requete_enreg = "INSERT INTO personnes_ressources_tice (
	`civil` ,
	`nom` ,
	`prenom` ,
	`codetab` ,
	`id_discipline` ,
	`discipline` ,
	`id_poste` ,
	`poste`,
	`mel`,
	`date_creation`
	)
	VALUES (
	'".$civil."', '".$nom."', '".$prenom."', '".$rne."', '".$id_discipline."', '".$discipline."', '".$id_poste."', '".$poste."', '".$mel."', '".$date_creation."'
	);";
	$result_enreg = mysql_query($requete_enreg);
	if (!$result_enreg)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>La nouvelle personnes ressource a bien &eacute;t&eacute; enregistr&eacute;e</h2>";
	}
?>
