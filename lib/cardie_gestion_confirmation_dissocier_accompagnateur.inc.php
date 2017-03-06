<?php

	$id_pers_ress = $_GET['id_pers_ress'];
	$requete_suppression = "DELETE FROM cardie_projet_accompagnement
		WHERE FK_NUM_PROJET = '".$id_projet."'
			AND FK_ID_PERS_RESS = '".$id_pers_ress."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		//echo "<h2>Le projet $id_projet a bien &eacute;t&eacute; supprim&eacute;</h2>";
	}

?>
