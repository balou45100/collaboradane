<?php
$intitule_chapitre = $_GET['intitule_chapitre'];
$id_gestionnaire = $_GET['id_gestionnaire'];
$utilise = $_GET['utilise'];

/*
echo "<br>intitule_chapitre : $intitule_chapitre";
echo "<br>id_gestionnaire : $id_gestionnaire";
echo "<br />utilise : $utilise";
echo "<br>";
*/

//enregistrement dans la base

$requete_enreg = "INSERT INTO credits_chapitres (
`intitule_chapitre` ,
`id_gestionnaire` ,
`utilise`
)
VALUES (
'".$intitule_chapitre."', '".$id_gestionnaire."', '".$utilise."'
);";
$result_enreg = mysql_query($requete_enreg);
if (!$result_enreg)
{
	echo "<h2>Erreur lors de l'enregistrement</h2>";
}
else
{
	echo "<h2>Le nouveau chapitre a bien &eacute;t&eacute; enregistr&eacute;</h2>";
}

?>
