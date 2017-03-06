<?php
	$id_evenement = $_GET['id_evenement'];

	//On récupère les id des participants pour pouvoir supprimer les suivis
	
	$req_id_participants="SELECT id FROM evenements_participants WHERE id_evenement = '".$id_evenement."'";
	
	//echo "req_id_participants : $req_id_participants";
	
	$resultat= mysql_query($req_id_participants);

	while ($ligne = mysql_fetch_object($resultat))
	{
		$id_evenement_participant = $ligne->id;
		$requete_suppression_suivi = "DELETE FROM evenements_participants_suivis WHERE fk_id_evenement =".$id_evenement_participant.";";

		//echo "<br />requete_suppression_suivi : $requete_suppression_suivi";
		
		$resultat_suppression_suivi = mysql_query($requete_suppression_suivi);
		if(!$resultat_suppression_suivi)
		{
			echo "<h2>Erreur</h2>";
		}
	}

	//Et pour finir on supprime les participants de la table evenements_participants
	$requete_suppression = "DELETE FROM evenements_participants WHERE id_evenement =".$id_evenement.";";
	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
?>
