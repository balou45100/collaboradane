<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}

	$idR=$_GET["idreunion"];
	
	//echo "<br />idR : $idR";
	
	$t = include ("../biblio/init.php");
	
	require_once('./odtphp/library/odf.php');

$odf = new odf("./edition/liste_emargement.odt");

//$requete_REUN="SELECT *, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion='$idR';";
$requete_REUN="SELECT *, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D FROM om_reunion AS omr, om_salle AS oms, om_responsables AS omresp WHERE omr.idsalle = oms.idsalle AND omr.id_responsable = omresp.id_responsable AND omr.idreunion = '".$idR."'";
$result_REUN=mysql_query($requete_REUN);
$ligne_R=mysql_fetch_assoc($result_REUN);

//On récupère les infos du responsable
$responsable = $ligne_R["prenom_responsable"].' '.$ligne_R["nom_responsable"];
$tel_responsable = $ligne_R["tel"];
$mel_responsable = $ligne_R["mel"];

$reunion='du '.$ligne_R["Date_D"].' à '.$ligne_R["Heure_D"].' au '.$ligne_R["Date_F"].' à '.$ligne_R["Heure_F"].'.';
$odf->setVars('responsable', "$responsable");
$odf->setVars('tel_responsable', "$tel_responsable");
$odf->setVars('mel_responsable', "$mel_responsable");
$odf->setVars('reunion', "$reunion");

/*
$salle=$ligne_R["idsalle"];
$requete_S="SELECT * FROM om_salle WHERE idsalle='$salle';";
$result_S=mysql_query($requete_S);
$ligne_S=mysql_fetch_assoc($result_S);
*/
if($ligne_R['table'] == "societes")
{
	$id=$ligne_R['idStructure'];
	$requete_REP="SELECT * FROM repertoire where No_societe='$id';";
	$result_REP=mysql_query($requete_REP);
	$ligne_REP=mysql_fetch_assoc($result_REP);

	$lieuL1=$ligne_REP["societe"].' - '.$ligne_R["intitule_salle"];
	$lieuL2=$ligne_REP["adresse"];
	$lieuL3=$ligne_REP["cp"].' '.$ligne_REP["ville"];
}
else
{
	//if($ligne_S["table"]=='0'){
	$id_E=$ligne_R["idStructure"];
	$requete_ETAB="SELECT * FROM etablissements WHERE RNE='$id_E';";
	$result_ETAB=mysql_query($requete_ETAB);
	$ligne_ETAB=mysql_fetch_assoc($result_ETAB);

	$lieuL1=$ligne_ETAB["TYPE"].' '.$ligne_ETAB["NOM"].' - '.$ligne_R["intitule_salle"];
	$lieuL2=$ligne_ETAB["ADRESSE"];
	$lieuL3=$ligne_ETAB["CODE_POSTAL"].' '.$ligne_ETAB["VILLE"];
	//}
}

$odf->setVars('lieuL1', "$lieuL1");
$odf->setVars('lieuL2', "$lieuL2");
$odf->setVars('lieuL3', "$lieuL3");

$listeArticles = array();

//$requete="SELECT *, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion='$idR';";
$requete="SELECT * FROM personnes_ressources_tice AS prt, om_reunion AS omr, om_ordres_mission AS omom WHERE omr.idreunion = omom.idreunion AND prt.id_pers_ress=omom.id_pers_ress AND omr.idreunion='$idR';";
$result=mysql_query($requete);

while($ligne= mysql_fetch_array($result)){
$personne=$ligne["civil"].' '.$ligne["nom"].' '.$ligne["prenom"];

$listeArticles[]=array('personnetable' => "$personne");
}


$article = $odf->setSegment('articles');

foreach($listeArticles AS $element) {
    $article->personnetable($element['personnetable']);
    $article->merge();
}
$odf->mergeSegment($article);

$odf->exportAsAttachedFile('liste_emargement.odt');
 
?> 
