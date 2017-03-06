<?php
	$intitule = $_GET['intitule'];
	
	$requete_enreg_liste = "INSERT INTO configuration_systeme_listes_deroulantes
	(
		`INTITULE`
	)
	VALUES
	(
		'".$intitule."'
	);";
	
	$resultat_enreg_liste = mysql_query($requete_enreg_liste);
	if (!$resultat_enreg_liste)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>La liste a bien &eacute;t&eacute; ajout&eacute;e</h2>";
	}
?>
