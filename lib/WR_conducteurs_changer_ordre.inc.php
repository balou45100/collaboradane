<?php
	$sense = $_GET['sense'];
	$idConducteur = $_GET['idConducteur'];
	
	//echo "<br />Je dois changer l'ordre de l'entr&eacute;e $idConducteur ; $sense";
	
	//On récupère le No d'ordre de l'enregistrement à changer
	$no_ordre_origine = lecture_champ("WR_Conducteurs","ConducteurNoOrdre","idConducteur",$idConducteur);
	$idEmission = lecture_champ("WR_Conducteurs","idEmission","idConducteur",$idConducteur);
	/*
	echo "<br />No ordre &agrave; l'origine : $no_ordre_origine";
	echo "<br />idEmission : $idEmission";
	echo "<br />idConducteur_initial : $idConducteur";
	*/
	//On calcul le nouvel no d'ordre
	if ($sense == "m")
	{
		$no_ordre_nouveau = $no_ordre_origine-1;
	}
	else
	{
		$no_ordre_nouveau = $no_ordre_origine+1;
	}
	
	//echo "<br />Nouveau No ordre : $no_ordre_nouveau";
	//on récupère le conducteur qui est concerné par le changement
	
	$requete2 ="SELECT * FROM WR_Conducteurs WHERE idEmission = '".$idEmission."' AND ConducteurNoOrdre = '".$no_ordre_nouveau."'";
	$execution= mysql_query($requete2);
	$res = mysql_fetch_row($execution);
	$idConducteur_extrait = $res[0];
	
	//echo "<br />idConducteur_extrait : $idConducteur_extrait";
	
	//Il faut mettre à jour les deux enregistrement
	changer_ordre_conducteur($idConducteur,$no_ordre_nouveau);
	changer_ordre_conducteur($idConducteur_extrait,$no_ordre_origine);
?>
