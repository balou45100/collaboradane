<?php

	$id_liste = $_GET['id_liste'];
	
	//echo "<br />id_liste : $id_liste";
	
	$requete_suppression = "DELETE FROM  configuration_systeme_listes_deroulantes
		WHERE ID = '".$id_liste."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		echo "<h2>La liste a bien &eacute;t&eacute; supprim&eacute;e</h2>";
	}

?>
