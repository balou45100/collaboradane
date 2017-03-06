<?php
	$idreunion=$_POST["idreunion"];
	@$date1=$_POST["datedebut"];
	@$date_angl1=date("Y-m-d", strtotime($date1));
	@$heure1=$_POST["heuredebut"];
	@$FinalDate1=$date_angl1.' '.$heure1;
	@$date2=$_POST["datefin"];
	@$date_angl2=date("Y-m-d", strtotime($date2));
	@$heure2=$_POST["heurefin"];
	@$FinalDate2=$date_angl2.' '.$heure2;
	@$intitule=$_POST["intitule"];
	@$description=$_POST["description"];
	@$annee = $_POST['annee'];
	@$id_responsable = $_POST['id_responsable'];
	$ref_enveloppe_budgetaire = $_POST['RefEnvBudg'];
	$ref_centre_cout = $_POST['ref_centre_cout'];
	/*
	echo "<br />idreunion : $idreunion";
	echo "<br />date1 : $date1";
	echo "<br />date_angl1 : $date_angl1";
	echo "<br />heure1 : $heure1";
	echo "<br />FinalDate1 : $FinalDate1";
	echo "<br />date_angl2 : $date_angl2";
	echo "<br />FinalDate2 : $FinalDate2";
	echo "<br />intitule : $intitule";
	echo "<br />description : $description";
	echo "<br />annee : $annee";
	echo "<br />etat_reunion : $etat_reunion";
	echo "<br />id_responsable : $id_responsable";
	echo "<br />ref_enveloppe_budgetaire : $ref_enveloppe_budgetaire";
	echo "<br />ref_centre_cout : $ref_centre_cout";
	*/
	//Il faut tester si les champs sont tous renseignés

	//Tout est ok, on peut enregistrer la réunion
	
	$requete_maj_reunion = "UPDATE om_reunion SET 
		`intitule_reunion` = '".$intitule."',
		`date_horaire_debut` = '".$FinalDate1."',
		`date_horaire_fin` = '".$FinalDate2."',
		`description` = '".$description."',
		`annee` = '".$annee."',
		`id_responsable` = '".$id_responsable."',
		`ref_enveloppe_budgetaire` = '".$ref_enveloppe_budgetaire."',
		`ref_centre_cout` = '".$ref_centre_cout."'
	WHERE idreunion = '".$idreunion."';";
	
	//echo "<br />$requete_maj_reunion";

	$result_maj_reunion = mysql_query($requete_maj_reunion);

	if($result_maj_reunion)
	{
		echo "<h2>La r&eacute;union a &eacute;t&eacute; enregistr&eacute;e</h2>";
	}
?>
