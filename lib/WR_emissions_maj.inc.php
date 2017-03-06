<?php
	$EmissionTitre = $_POST['EmissionTitre'];
	$EmissionDateDiffusion = $_POST['EmissionDateDiffusion'];
	$EmissionHeureDiffusionDebut = $_POST['EmissionHeureDiffusionDebut'];
	$EmissionHeureDiffusionFin = $_POST['EmissionHeureDiffusionFin'];
	$EmissionLieuEnregistrement = $_POST['EmissionLieuEnregistrement'];
	$EmissionRemarques = $_POST['EmissionRemarques'];
	$EmissionCategories = $_POST['EmissionCategories'];

	/*
	echo "<br />idEmission : $idEmission";
	echo "<br />EmissionTitre : $EmissionTitre";
	echo "<br />EmissionDateDiffusion : $EmissionDateDiffusion";
	echo "<br />EmissionHeureDiffusionDebut : $EmissionHeureDiffusionDebut";
	echo "<br />EmissionHeureDiffusionFin : $EmissionHeureDiffusionFin";
	echo "<br />EmissionLieuEnregistrement : $EmissionLieuEnregistrement";
	echo "<br />EmissionRemarques : $EmissionRemarques";
	*/

	//enregistrement dans la base 
	$requete_maj = "UPDATE WR_Emissions SET 
		`EmissionTitre` = '".$EmissionTitre."',
		`EmissionDateDiffusion` = '".$EmissionDateDiffusion."',
		`EmissionHeureDiffusionDebut` = '".$EmissionHeureDiffusionDebut."',
		`EmissionHeureDiffusionFin` = '".$EmissionHeureDiffusionFin."',
		`EmissionLieuEnregistrement` = '".$EmissionLieuEnregistrement."',
		`EmissionRemarques` = '".$EmissionRemarques."'
	WHERE idEmission = '".$choixEmission."';";

	//echo "<br />$requete_maj";
	
	$result_maj = mysql_query($requete_maj);
	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		//Il faut enregistrer les catégories
		enreg_categories_webradio($EmissionCategories,$choixEmission);
		echo "<h2>L'&eacute;mission a bien &eacute;t&eacute; modifi&eacute;e</h2>";
	}
?>
