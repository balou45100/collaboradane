<?php
	//echo "<h2>Enregistrement de l'&eacute;v&eacute;nement<h2>";
	$id_fonction = $_GET['id_fonction'];
	/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />id_fonction : $id_fonction";
	*/
	
	//On récupére toutes les personnes exerçant la fonction
	$requete = "SELECT * FROM fonctions_des_personnes_ressources WHERE id_fonction = '".$id_fonction."'";
	
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);
	if(!$resultat)
	{
		echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
		mysql_close();
		exit;
	}
	while ($ligne = mysql_fetch_object($resultat))
	{
		$id_pers_ress = $ligne->id_pers_ress;
		
		//On vérifie si la personne est déjà inscrite
		$test_doublon = verif_doublon_participation_evenement($id_evenement, $id_pers_ress);
		if ($test_doublon == 0)
		{
			$query_insert = "INSERT INTO evenements_participants (id_evenement, id_participant, annee_imputation)
			VALUES ('".$id_evenement."','".$id_pers_ress."','".$om_annee_budget."');";

			//echo "<br />query_insert : $query_insert";

			$results_insert = mysql_query($query_insert);
			if(!$results_insert)
			{
				echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
				mysql_close();
				exit;
			}
			else
			{
				//On récupère l'id de l'enregistrement du participant
				$id_genere = mysql_insert_id();
				enreg_suivi_om($id_genere,0,"");
			}
			echo "&nbsp;*&nbsp;";
		}
	} //Fin while

/*


*/
?>
