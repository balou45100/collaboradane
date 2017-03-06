<?php
	//on supprime la personne

	$requete_suppression = "DELETE FROM om_ordres_mission WHERE id_pers_ress = '".$id_pers_ress."' AND idreunion = '".$idreunion."'";
	$resultat_requete_suppression = mysql_query($requete_suppression);
	if (!$resultat_requete_suppression)
	{
		echo "<h2>Erreur lors de la suppression</h2>";
	}
	else
	{
		echo "<h2>La personne &agrave; &eacute;t&eacute; retir&eacute;e de la r&eacute;union</h2>";
	}
?>
