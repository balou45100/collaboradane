<?php
	$bouton_envoyer_modif = $_GET['bouton_envoyer_modif'];
	$id_evenement = $_GET['id_evenement'];

	if (!ISSET($bouton_envoyer_modif))
	{
		$requete_suppression = "DELETE FROM evenements WHERE id_evenement =".$id_evenement.";";
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
		else
		{
			//On supprime les participants à cet événement de la table evenement-participants
			$requete_suppression_participants = "DELETE FROM evenements_participants WHERE id_evenement =".$id_evenement.";";
			$resultat_suppression_participants = mysql_query($requete_suppression_participants);
			if(!$resultat_suppression_participants)
			{
				echo "<h2>Erreur 2</h2>";
			}
		}
	}
?>
