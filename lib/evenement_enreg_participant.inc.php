<?php
	//echo "<h2>Enregistrement de l'&eacute;v&eacute;nement<h2>";
	$id_participant = $_GET['id_participant'];
	/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />id_participant : $id_participant";
	*/

	//On vérifie si la personne est déjà inscrite
	$test_doublon = verif_doublon_participation_evenement($id_evenement, $id_participant);

	if ($test_doublon == 0)
	{
		$query_insert = "INSERT INTO evenements_participants (id_evenement, id_participant, annee_imputation)
		VALUES ('".$id_evenement."','".$id_participant."','".$om_annee_budget."');";

		//echo "<br />query_insert : $query_insert";

		$results_insert = mysql_query($query_insert);
		if(!$results_insert)
		{
			echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
			mysql_close();
			exit;
		}
		else //On enregistre le suivi
		{
			//On récupère l'id de l'enregistrement du participant
			$id_genere = mysql_insert_id();
 			enreg_suivi_om($id_genere,0,"");
		}
	}
	else
	{
		echo "<h2>Cette personne participe d&eacute;j&agrave; &agrave; l'&eacute;v&eacute;nement</h2>";
	}
?>
