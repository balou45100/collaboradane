<?php
	$id_evenement = $_GET['id_evenement'];
	$id_participant = $_GET['id_participant'];

	/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />id_participant : $id_participant";
	*/

	//On récupère l'id de l'enregistrement du participant pour pouvoir supproimer le suivi
	$req_champ="SELECT id FROM evenements_participants WHERE id_evenement = '".$id_evenement."' AND id_participant = '".$id_participant."'";
	//echo "req_champ : $req_champ";
	$execution= mysql_query($req_champ);
	$res = mysql_fetch_row($execution);
	$fk_id_evenement = $res[0];

	$requete_suppression = "DELETE FROM evenements_participants WHERE id_evenement =".$id_evenement." AND id_participant =".$id_participant.";";
	
	//echo "<br />$requete_suppression";
	
	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else //On supprime le suivi
	{
		supp_suivi_om($fk_id_evenement);
	}

?>
