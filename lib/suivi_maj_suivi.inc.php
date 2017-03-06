<?php
	$id_suivi = $_POST['id_suivi'];
	$date_suivi = $_POST['date_suivi'];
	$ecl = $_POST['ecl'];
	$titre = $_POST['titre'];
	$contact_type = $_POST['contact_type'];
	$description = $_POST['description'];
	$visibilite = $_POST['visibilite'];
	$categorie_commune = $_POST['categorie_commune'];
	$id_categorie_commune_original = $_POST['id_categorie_commune_original']; //Permet de voir si le dossier a été changé

/*
	echo "<br>id_categorie_commune_original : $id_categorie_commune_original";
	echo "<br>categorie_commune : $categorie_commune";
	echo "<br>id_suivi : $id_suivi";
	echo "<br>date_suivi : $date_suivi";
	echo "<br>ecl : $ecl";
	echo "<br>titre : $titre";
	echo "<br>contact_type : $contact_type";
	echo "<br>categorie_commune : $categorie_commune";
	echo "<br>description : $description";
 	echo "<br>";
*/

	//////////////////////////////////////////////////////////
	// Enregistrement dans la base ///////////////////////////
	//////////////////////////////////////////////////////////

	$requete_maj = "UPDATE suivis SET
		`date_suivi` = '".$date_suivi."',
		`ecl` = '".$ecl."',
		`contact_type` = '".$contact_type."',
		`description` = '".$description."',
		`titre` = '".$titre."'
	WHERE id = '".$id_suivi."';";

	//echo "<br />$requete_maj";

	$result_maj = mysql_query($requete_maj);

	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		// On mettra à jour le dossier s'il y a un changement
		if ($id_categorie_commune_original <> $categorie_commune)
		{
			$requete_maj_cc = "UPDATE suivis_categories_communes SET
				`id_categorie_commune` = '".$categorie_commune."'
			WHERE id_suivi = '".$id_suivi."';";

			//echo "$requete_maj_cc";

			$result_maj_cc = mysql_query($requete_maj_cc);
		}
		echo "<h2>Le suivi a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}

?>
