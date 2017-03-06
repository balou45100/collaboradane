<?php
	//enregistrement dans la base

	//On vérifie si la personne est déjà enregistrée
	$verif = "SELECT * FROM om_ordres_mission WHERE id_pers_ress = '".$id_pers_ress."' AND idreunion = '".$idreunion."'";
	$resultat_verif = mysql_query($verif);
	$resultat = mysql_num_rows($resultat_verif);
	
	if ($resultat)
	{
		echo "<h2>La personne est d&eacute;j&agrave; inscrite &agrave; cette r&eacute;union</h2>";
	}
	else
	{
		$requete_enreg = "INSERT INTO om_ordres_mission
		(
			`id_pers_ress`,
			`idreunion`
		)
		VALUES
		(
			'".$id_pers_ress."', 
			'".$idreunion."'
		);";
		$result_enreg = mysql_query($requete_enreg);
		if (!$result_enreg)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
	}
?>
