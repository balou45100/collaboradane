<?php

	$id_visite = $_GET['id_visite'];
	
	//echo "<br />id_visite : $id_visite";
	
	$requete_suppression = "DELETE FROM cardie_visite
		WHERE ID_VISITE = '".$id_visite."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		//On supprime toutes les entrées dans l'historique
		$requete_suppression_historique = "DELETE FROM cardie_visites_historique WHERE FK_ID_VISITE = '".$id_visite."'";
		$resultat_requete_suppression_historique = mysql_query($requete_suppression_historique);
	}

?>
