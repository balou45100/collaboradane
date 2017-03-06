<?php
require_once('./odtphp/library/odf.php');
include ("../biblio/init.php");

$OM=$_POST["REFOM"];

$odf = new odf("./edition/om_edition.odt");

$requete_REUN="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_ordres_mission.refOM=$OM ;";
$result_REUN=mysql_query($requete_REUN);
$ligne_REUN=mysql_fetch_assoc($result_REUN);

$salle=$ligne_REUN["idsalle"];
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

$DATEL1='Du '.$ligne_REUN["Date_D"].' à '.$ligne_REUN["Heure_D"];
$DATEL2=' au '.$ligne_REUN["Date_F"].' à '.$ligne_REUN["Heure_F"];

$odf->setVars('Date_HeureL1', $DATEL1);
$odf->setVars('Date_HeureL2', $DATEL2);

$objet=$ligne_REUN["intitule_reunion"];

$odf->setVars('Objet', $objet);

$personne=$ligne_REUN["civil"].' '.$ligne_REUN["nom"].' '.$ligne_REUN["prenom"];

//$nom_fichier = $ligne_REUN['nom'].".odt";

$odf->setVars('personne', $personne);

$id_etab=$ligne_REUN["codetab"];
$requete_ETAB_PERS="SELECT * from etablissements where RNE='$id_etab';";
$result_ETAB_PERS=mysql_query($requete_ETAB_PERS);
$ligne_EP=mysql_fetch_assoc($result_ETAB_PERS);

$etabL1=$ligne_EP["NOM"];
$etabL2=$ligne_EP["ADRESSE"];
$etabL3=$ligne_EP["CODE_POSTAL"].' '.$ligne_EP["VILLE"];

$odf->setVars('etablissementL1', $etabL1);
$odf->setVars('etablissementL2', $etabL2);
$odf->setVars('etablissementL3', $etabL3);


$odf->exportAsAttachedFile("om.odt");
 
?> 
