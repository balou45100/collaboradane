<?php
$id_lot = $_GET['id_lot'];
$lot = $_GET['lot'];
$valeur_lot = $_GET['valeur_lot'];
$valeur_lot = DeFormatage_Nombre($valeur_lot,$monnaie_utilise);
$attribue_a = $_GET['attribue_a'];
$promis = $_GET['promis'];
$recu = $_GET['recu'];
$materiel = $_GET['materiel'];
$niveau = $_GET['niveau'];
$ps_fid = $_GET['ps_fid'];
$ps_3p = $_GET['ps_3p'];
$p_part = $_GET['p_part'];
$afficher_pour_selection = $_GET['afficher_pour_selection'];
$illustration_lot = $_GET['illustration_lot'];

//echo "<br />afficher_pour_selection : $afficher_pour_selection";
//echo "<br />illustration_lot : $illustration_lot";
              
//Mise à jour de la fiche
include("../biblio/init_fgmm.php");
$query_maj = "UPDATE fgmm_lot SET
  lot = '".$lot."',
  valeur_lot = '".$valeur_lot."',
  attribue_a = '".$attribue_a."',
  promis = '".$promis."',
  recu = '".$recu."',
  materiel = '".$materiel."',
  niveau = '".$niveau."',
  ps_fid = '".$ps_fid."',
  ps_3p = '".$ps_3p."',
  p_part = '".$p_part."',
  afficher_pour_selection = '".$afficher_pour_selection."',
  illustration_lot = '".$illustration_lot."'
WHERE id_lot = '".$id_lot."';";
$results_maj = mysql_query($query_maj); 
              
?>
