<?php
$id_formation = $_GET['id_formation'];
$annee_scolaire_formulaire = $_GET['annee_scolaire_formulaire'];
$type_formation = $_GET['type_formation'];
$id_societe = $_GET['id_societe'];

echo "<br>id_formation : $id_formation - annee_scolaire : $annee_scolaire_formulaire - type_formation : $type_formation - rne : $id_societe";              
//Mise à jour de la fiche
include("../biblio/init.php");
$query_maj = "UPDATE formations SET
  type_formation = '".$type_formation."',
  annee_scolaire = '".$annee_scolaire_formulaire."',
  rne = '".$id_societe."'
WHERE id_formation = '".$id_formation."';";
$results_maj = mysql_query($query_maj); 
if(!$results_maj)
{
  echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
  //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
  mysql_close();
  //exit;
}             
?>
