<?php
	$id_evenement = $_POST['id_evenement'];
	$fk_id_util = $_POST['fk_id_util'];
	$fk_rne = $_POST['fk_rne'];
	$date_evenement_debut = $_POST['date_evenement_debut'];
	$date_evenement_fin = $_POST['date_evenement_fin'];
	$heure_debut_evenement = $_POST['heure_debut_evenement'];
	$heure_fin_evenement = $_POST['heure_fin_evenement'];
	$titre_evenement = $_POST['titre_evenement'];
	$fk_id_dossier = $_POST['fk_id_dossier'];
	$detail_evenement = $_POST['detail_evenement'];
	$fk_repertoire = $_POST['fk_repertoire'];
	$autre_lieu = $_POST['autre_lieu'];
	
	//Il faut retenir que le premier lieu renseigné dans l'ordre ECL, société, autre
	if ($fk_rne <> "")
	{
		$fk_repertoire = 0;
		$autre_lieu = "";
	}
	elseif ($fk_repertoire <> "")
	{
		$autre_lieu = "";
	}

/*
	echo "<br>id_evenement : $id_evenement";
	echo "<br>fk_id_util : $fk_id_util";
	echo "<br>fk_rne : $fk_rne";
	echo "<br>date_evenement_debut : $date_evenement_debut";
	echo "<br>date_evenement_fin : $date_evenement_fin";
	echo "<br>heure_debut_evenement : $heure_debut_evenement";
	echo "<br>heure_fin_evenement : $heure_fin_evenement";
	echo "<br>titre_evenement : $titre_evenement";
	echo "<br>fk_id_dossier : $fk_id_dossier";
	echo "<br>detail_evenement : $detail_evenement";
	echo "<br>fk_repertoire : $fk_repertoire";
	echo "<br>autre_lieu : $autre_lieu";
	echo "<br>";
*/
	//////////////////////////////////////////////////////////
	// Enregistrement dans la base ///////////////////////////
	//////////////////////////////////////////////////////////
	//On remplace les "'" par le code html
	$titre_evenement = str_replace("'", "&#39;", $titre_evenement);
	$requete_maj = "UPDATE evenements SET
		`fk_id_util` = '".$fk_id_util."',
		`fk_rne` = '".$fk_rne."',
		`date_evenement_debut` = '".$date_evenement_debut."',
		`date_evenement_fin` = '".$date_evenement_fin."',
		`heure_debut_evenement` = '".$heure_debut_evenement."',
		`heure_fin_evenement` = '".$heure_fin_evenement."',
		`titre_evenement` = '".$titre_evenement."',
		`fk_id_dossier` = '".$fk_id_dossier."',
		`fk_repertoire` = '".$fk_repertoire."',
		`autre_lieu` = '".$autre_lieu."',
		`detail_evenement` = '".$detail_evenement."'
	WHERE id_evenement = '".$id_evenement."';";

	//echo "<br />$requete_maj";

	$result_maj = mysql_query($requete_maj);

	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		echo "<h2>L'&eacute;v&eacute;nement a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}

?>
