<?php
	$requete_suppression = "DELETE FROM cardie_projet WHERE NUM_PROJET = '".$id_projet."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		echo "<h2>Le projet $id_projet a bien &eacute;t&eacute; supprim&eacute;</h2>";
	}
?>
