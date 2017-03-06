<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
require_once('./odtphp/library/odf.php');
include ("../biblio/init.php");

$idR=$_POST["idREUN"];

$odf = new odf("./edition/recapitulatif.odt");

$requete_REUN="SELECT *, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion='$idR';";
$result_REUN=mysql_query($requete_REUN);
$ligne_R=mysql_fetch_assoc($result_REUN);

$reunion1=$ligne_R["intitule_reunion"];
$odf->setVars('reunion',$reunion1);

$date='Du '.$ligne_R["Date_D"].' à '.$ligne_R["Heure_D"].' au '.$ligne_R["Date_F"].' à '.$ligne_R["Heure_F"].'.';
$odf->setVars('date', $date);

$salle=$ligne_R["idsalle"];
$requete_S="SELECT * FROM om_salle WHERE idsalle='$salle';";
$result_S=mysql_query($requete_S);
$ligne_S=mysql_fetch_assoc($result_S);

if($ligne_S["idRNE"]=='0'){
	$id=$ligne_S["idNo_societe"];
	$requete_REP="SELECT * FROM repertoire where No_societe='$id';";
	$result_REP=mysql_query($requete_REP);
	$ligne_REP=mysql_fetch_assoc($result_REP);

	$lieuL1=$ligne_REP["societe"].' - '.$ligne_S["intitule_salle"];
	$lieuL2=$ligne_REP["adresse"];
	$lieuL3=$ligne_REP["cp"].' '.$ligne_REP["ville"];
}else{
	if($ligne_S["idNo_societe"]=='0'){
		$id_E=$ligne_S["idRNE"];
		$requete_ETAB="SELECT * FROM etablissements WHERE RNE='$id_E';";
		$result_ETAB=mysql_query($requete_ETAB);
		$ligne_ETAB=mysql_fetch_assoc($result_ETAB);

		$lieuL1=$ligne_ETAB["NOM"].' - '.$ligne_S["intitule_salle"];
		$lieuL2=$ligne_ETAB["ADRESSE"];
		$lieuL3=$ligne_ETAB["CODE_POSTAL"].' '.$ligne_ETAB["VILLE"];
	}
}

$odf->setVars('lieuL1', $lieuL1);
$odf->setVars('lieuL2', $lieuL2);
$odf->setVars('lieuL3', $lieuL3);

$listeArticles = array();

$requete_pers="SELECT *, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om, etablissements where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and personnes_ressources_tice.codetab=etablissements.RNE and om_reunion.idreunion='$idR';";
$result_pers=mysql_query($requete_pers);

while($ligne_pers=mysql_fetch_assoc($result_pers)){
$personne=$ligne_pers["civil"].' '.$ligne_pers["nom"].' '.$ligne_pers["prenom"];

$L1=$ligne_pers["RNE"].' - '.$ligne_pers["TYPE_ETAB_GEN"].' - '.$ligne_pers["NOM"];
$L2=$ligne_pers["ADRESSE"];
$L3=$ligne_pers["CODE_POSTAL"].' '.$ligne_pers["VILLE"];

$listeArticles[]=array('personne' => "$personne",'L1' => "$L1",'L2' => "$L2",'L3' => "$L3");
}

$article = $odf->setSegment('articles');
foreach($listeArticles AS $element) {
    $article->personne($element['personne']);
    $article->etabL1($element['L1']);
	$article->etabL2($element['L2']);
	$article->etabL3($element['L3']);
    $article->merge();
}
$odf->mergeSegment($article);

$odf->exportAsAttachedFile('recapitulatif.odf');
 
?> 
