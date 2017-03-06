<?php
	//echo "<h2>Enregistrement des modifications de la liste $id_liste</h2>";
	
	//On récupère les variables
	$id_liste = $_GET['id_liste'];
	$intitule = $_GET['intitule'];
	
	$requete_maj = "UPDATE configuration_systeme_listes_deroulantes SET
		`INTITULE` = '".$intitule."'
	WHERE ID = '".$id_liste."';";
	
	//echo "<br />$requete_maj";
	
	$resultat_requete_maj = mysql_query($requete_maj);
	
	if (!$resultat_requete_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>La liste a bien &eacute;t&eacute; modifi&eacute;e</h2>";
	}
?>
