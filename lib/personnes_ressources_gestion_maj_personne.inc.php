<?php
$rne = $_GET['rne'];
$civil = $_GET['civil'];
$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
$mel = $_GET['mel'];
$discipline = $_GET['discipline'];
$poste = $_GET['poste'];

//on formate les entrées
$nom = strtoupper($nom);
$mel = strtolower($mel);

/*
echo "<br>id : $id";
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

$requete_maj = "UPDATE personnes_ressources_tice SET 
	`civil` = '".$civil."',
	`nom` = '".$nom."',
	`prenom` = '".$prenom."',
	`codetab` = '".$rne."',
	`id_discipline` = '".$id_discipline."',
	`discipline` = '".$discipline."',
	`id_poste` = '".$id_poste."',
	`poste` = '".$poste."',
	`mel` = '".$mel."'	
WHERE id_pers_ress = '".$id."';";

$result_maj = mysql_query($requete_maj);
if (!$result_maj)
{
	echo "<h2>Erreur lors de l'enregistrement</h2>";
}
else
{
	echo "<h2>La personne ressource a bien &eacute;t&eacute; modifi&eacute;e</h2>";
}

?>
