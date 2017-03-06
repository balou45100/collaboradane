<?php
$id_formation = $_GET['id_formation'];
//Récupération des variables de la table formations
include("../biblio/init.php");
$query_suppression = "DELETE FROM formations WHERE id_formation = '".$id_formation."';";
$result = mysql_query($query_suppression);
				      
?>
