<?php
	$id_lien = $_GET['id_lien'];
	//echo "<h2>Suppression d&eacute;finitive du lien $id_lien</h2>";
	$requete_suppression = "DELETE FROM cardie_projets_liens
		WHERE id_lien = '".$id_lien."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		echo "<h2>Le lien $id_lien a bien &eacute;t&eacute; supprim&eacute;</h2>";
	}

?>
