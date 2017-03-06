<?php
	echo "<h2>Enregistrement des modifications de la visite $id_visite</h2>";
	
	//On récupère les variables
	$id_visite = $_POST['id_visite'];
	$date_visite=$_POST['date_visite'];
	$horaire_debut = $_POST['horaire_debut'];
	$horaire_fin = $_POST['horaire_fin'];
	$remarques = $_POST['remarques'];
	
	$horaire_visite = $horaire_debut."-".$horaire_fin;
	
	//echo "<br />id_visite : $id_visite";
	
	$requete_maj = "UPDATE cardie_visite SET 
		`DATE_VISITE` = '".$date_visite."',
		`HORAIRE_VISITE` = '".$horaire_visite."',
		`REMARQUES` = '".$remarques."'
	WHERE ID_VISITE = '".$id_visite."';";
	
	//echo "<br />$requete_maj";
	
	$resultat_requete_maj = mysql_query($requete_maj);
	
	if (!$resultat_requete_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>Le projet a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}
	/*
	echo "<br />enreg_viste";
	echo "<br />tri : $tri";
	echo "<br />sense_tri : $sense_tri";
	*/
?>
