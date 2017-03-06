<?php
$id_chapitre = $_GET['id_chapitre'];
$intitule_chapitre = $_GET['intitule_chapitre'];
$id_gestionnaire = $_GET['id_gestionnaire'];
$utilise = $_GET['utilise'];

//on formate les entrées
//$intitule_chapitre = strtoupper($intitule_chapitre);

/*
echo "<br>id_chapitre : $id_chapitre";
echo "<br>intitule_chapitre : $intitule_chapitre";
echo "<br>id_gestionnaire : $id_gestionnaire";
echo "<br />utilise : $utilise";
echo "<br>";
*/
//enregistrement dans la table 

$requete_maj = "UPDATE credits_chapitres SET 
	`intitule_chapitre` = '".$intitule_chapitre."',
	`id_gestionnaire` = '".$id_gestionnaire."',
	`utilise` = '".$utilise."'
WHERE id_chapitre = '".$id_chapitre."';";

$result_maj = mysql_query($requete_maj);
if (!$result_maj)
{
	echo "<h2>Erreur lors de l'enregistrement</h2>";
}
else
{
	echo "<h2>Le chapitre a bien &eacute;t&eacute; modifi&eacute;</h2>";
}

?>
