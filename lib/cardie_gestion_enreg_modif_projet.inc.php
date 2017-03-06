<?php
	echo "<h2>Enregistrement des modifications du projet $id_projet</h2>";
	
	//On récupère les variables
	$id_projet = $_POST['id_projet'];
	//$intitule_projet=addslashes($_POST['intitule_projet']);
	$intitule_projet=$_POST['intitule_projet'];
	$annee = $_POST['annee'];
	$description = $_POST['description'];
	$objectifs = $_POST['objectifs'];
	$indicateurs = $_POST['indicateurs'];
	$initiateur = $_POST['initiateur'];
	$modes_action = $_POST['modes_action'];
	$phases_du_projet = $_POST['phases_du_projet'];
	$changements = $_POST['changements'];
	$resume = $_POST['resume'];
	$mots_clef = $_POST['mots_clef'];
	$rmq_cardie_A1 = $_POST['rmq_cardie_A1'];
	$rmq_cardie_A2 = $_POST['rmq_cardie_A2'];
	$decision_commission = $_POST['decision_commission'];
	$type_accompagnement = $_POST['type_accompagnement'];
	$reponse_ppe = $_POST['reponse_ppe'];
	$nbr_eleves = $_POST['nbr_eleves'];
	$nbr_enseignants = $_POST['nbr_enseignants'];
	$propose_dans_ppe = $_POST['propose_dans_ppe'];
	$type_groupe_developpement = $_POST['type_groupe_developpement'];

	//echo "<br />id_projet : $id_projet";
	
	$requete_maj = "UPDATE cardie_projet SET 
		`INTITULE` = '".$intitule_projet."',
		`ANNEE` = '".$annee."',
		`DESCRIPTION` = '".$description."',
		`OBJECTIFS` = '".$objectifs."',
		`INDICATEURS` = '".$indicateurs."',
		`INITIATEUR` = '".$initiateur."',
		`MODES_ACTION` = '".$modes_action."',
		`PHASES_DU_PROJET` = '".$phases_du_projet."',
		`CHANGEMENTS` = '".$changements."',
		`RESUME` = '".$resume."',
		`MOTS_CLEF` = '".$mots_clef."',
		`RMQ_CARDIE_A1` = '".$rmq_cardie_A1."',
		`RMQ_CARDIE_A2` = '".$rmq_cardie_A2."',
		`DECISION_COMMISSION` = '".$decision_commission."',
		`TYPE_ACCOMPAGNEMENT` = '".$type_accompagnement."',
		`REPONSE_PPE` = '".$reponse_ppe."',
		`NBR_ELEVES` = '".$nbr_eleves."',
		`NBR_ENSEIGNANTS` = '".$nbr_enseignants."',
		`TYPE_GROUPE_DEVELOPPEMENT` = '".$type_groupe_developpement."',
		`PROPOSE_DANS_PPE` = '".$propose_dans_ppe."'
	WHERE NUM_PROJET = '".$id_projet."';";
	
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
?>
