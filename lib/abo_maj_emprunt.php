<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html" />
<style type="text/css">
body{
background-color : #FFCC66;
}
TD{
background-color : #FEDD99;
}
</style>
</HEAD>
<BODY>
<?php
include ("../biblio/init.php");
?>
<H2> Affichage des Emprunts</H2>
<table border>
<TR>
<TD align=center>Nom du magazine : </TD>
<TD align=center>Personnes ayant emprunté le livre : </TD>
<TD align=center>Date de l'emprunt : </TD>
<TD align=center>Date de fin de l'emprunt : </TD>
<TD align=center>Rendu : </TD>
<TD align=center>Action : </TD>
</TR>
<?php
$requete_mag="SELECT * , DATE_FORMAT(Date_emprunt, '%d-%m-%Y') AS Date_emprunt2, DATE_FORMAT(Date_fin_emprunt, '%d-%m-%Y') AS Date_fin_emprunt2 FROM abo_abonnement, abo_magazine, abo_emprunt, personnes_ressources_tice WHERE abo_emprunt.NoMag=abo_magazine.NoMag and abo_magazine.NoAbo=abo_abonnement.NoAbo and personnes_ressources_tice.id_pers_ress=abo_emprunt.id_pers_ress ;";
$result_mag=mysql_query($requete_mag);
echo'<form method="post">';
while($ligne_mag=mysql_fetch_assoc($result_mag)){
echo'<TR>
<TD align=center>'.$ligne_mag["Nom_mag"].'</TD>
<TD align=center>'.$ligne_mag["nom"].' '.$ligne_mag["prenom"].'</TD>
<TD align=center><input type="text" name="dateE" value="'.$ligne_mag["Date_emprunt2"].'" /></TD>
<TD align=center><input type="text" name="dateFE" value="'.$ligne_mag["Date_fin_emprunt2"].'" /></TD>';
if($ligne_mag["Rendu"]=='1'){
echo'<TD align=center><select name="rendu">
<option value="1">Oui</option>
<option value="2">Non</option>
</select></TD>';
}else{
echo'<TD align=center><select name="rendu">
<option value="1">Non</option>
<option value="2">Oui</option>
</select></TD>';
}
echo'<TD align=center>
<input type="hidden" name="idE" value="'.$ligne_mag["id_emprunt"].'" />
<input type="submit" name="valid" value="Valider" /></TD>
</TR>
</form></table>';
}

if(isset($_POST["valid"])){
$rendu=$_POST["rendu"];
$dateE=$_POST["dateE"];
$dateE_angl=date("Y-m-d", strtotime($dateE));
$dateFE=$_POST["dateFE"];
$dateFE_angl=date("Y-m-d", strtotime($dateFE));
$idE=$_POST["idE"];
$requete_majE="UPDATE abo_emprunt SET Date_emprunt='$dateE_angl', Date_fin_emprunt='$dateFE_angl', Rendu='$rendu' where id_emprunt='$idE' ;";
$result_majE=mysql_query($requete_majE);
if($result_majE){
echo'<BR />La mise à jour de l\'emprunt a bien été effectuée.<BR />';
}else{
echo'<BR />Erreur dans la mise à jour de l\'emprunt.<BR />';
}
}
echo'<BR /><form method="post" action="abo_affichage_emprunt.php">
<input type="submit" name="retour" value="Retour"/></form>';
?>
</BODY>
</HTML>
