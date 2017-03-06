<?php
//echo "<BR> Je suis dans la procédure de suppression du lot $id_lot";
$id_lot = $_GET['id_lot'];
//Récupération des variables de la table lot 
include("../biblio/init.php");
$query_suppression = "DELETE FROM fgmm_lot WHERE id_lot = '".$id_lot."';";
$result = mysql_query($query_suppression);
				      
?>
