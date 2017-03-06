<?php

	$id_element = $_GET['id_element'];
	$nom_table = $_GET['nom_table'];
	
	//echo "<br />id_visite : $id_visite";
	
	$requete_suppression = "DELETE FROM $nom_table
		WHERE ID = '".$id_element."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		echo "<h2>L'&eacute;l&eacute;ment a bien &eacute;t&eacute; supprim&eacute;</h2>";
	}

?>
