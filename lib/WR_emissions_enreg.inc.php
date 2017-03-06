<?php
	//echo "<br />J'enregistre ...";

	$EmissionTitre = $_POST['EmissionTitre'];
	$EmissionDateDiffusion = $_POST['EmissionDateDiffusion'];
	$EmissionHeureDiffusionDebut = $_POST['EmissionHeureDiffusionDebut'];
	$EmissionHeureDiffusionFin = $_POST['EmissionHeureDiffusionFin'];
	$EmissionLieuEnregistrement = $_POST['EmissionLieuEnregistrement'];
	$EmissionRemarques = $_POST['EmissionRemarques'];
	$EmissionCategories = $_POST['EmissionCategories'];

	//echo "<br />PartenaireAdresse1 : $PartenaireAdresse1";
	//echo "<br />PartenaireAdresse2 : $PartenaireAdresse2";

	//Formatage de la date et de l'heure

	//Enregistrement de l'émission

	include("../biblio/init.php");

	$query = "INSERT INTO WR_Emissions (EmissionTitre, EmissionDateDiffusion, EmissionHeureDiffusionDebut, EmissionHeureDiffusionFin, EmissionLieuEnregistrement, EmissionRemarques)
		VALUES ('".$EmissionTitre."', '".$EmissionDateDiffusion."', '".$EmissionHeureDiffusionDebut."', '".$EmissionHeureDiffusionFin."', '".$EmissionLieuEnregistrement."', '".$EmissionRemarques."');";

	//echo "<br />$query";

	$results = mysql_query($query);
	//Dans le cas où aucun résultats n'est retourné
	if(!$results)
	{
		echo "<B>Erreur de connexion à la base de données ou erreur de requète</B>";
		mysql_close();
		//exit;
	}
	else
	{
		//Il faut récupérer l'id de l'émission enregistré
		$id_emission_genere = mysql_insert_id();
		
		//echo "<br />id_emission_genere : $id_emission_genere";
		//Il faut enregistrer les catégories dans la table WR_EmissionsCategories
		$test = enreg_categories_webradio($EmissionCategories,$id_emission_genere);
		
		//echo "<br />test : $test";
		
		//Il faut créer le dossier qui contiendra les ressources de l'emission
		/*
		echo "<br />dossier_webradio_ressources : $dossier_webradio_ressources";
		echo "<br />EmissionDateDiffusion : $EmissionDateDiffusion";
		*/
		//$nom_dossier = str_replace("/","",$EmissionDateDiffusion)."_".$id_emission_genere;
		$dossier_webradio_ressources = $dossier_webradio_ressources.$id_emission_genere;
		
		//echo "<br />dossier_webradio_ressources : $dossier_webradio_ressources";
		
		$test_cre_dossier = mkdir($dossier_webradio_ressources);
		
		//echo "<br />test_cre_dossier : $test_cre_dossier";
		
		echo "<h2>L'&eacute;mission a &eacute;t&eacute; enregistr&eacute;e.</h2>";
	}
?>
