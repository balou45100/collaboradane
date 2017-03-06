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
<H2>Ajouter un nouvel emprunt</H2>
<form method="post">
Selectionner la personne qui effectue cette emprunt :<BR />
<select name="pers">
<?php
$requete_pers="SELECT * FROM personnes_ressources_tice Order by nom;";
$result_pers=mysql_query($requete_pers);
while($ligne_pers=mysql_fetch_assoc($result_pers)){
$id=$ligne_pers["id_pers_ress"];
$nom=$ligne_pers["nom"];
$prenom=$ligne_pers["prenom"];
echo'<option value="'.$id.'">'.$nom.' '.$prenom.'</option>';
}
?>
</select>
<input type="submit" name="valid_pers" value="Valider"/><BR />
</form>
<?php
if(isset($_POST["valid_pers"])){
$pers=$_POST["pers"];
echo'<BR /><form method="post">';
$requete_abo="SELECT * FROM abo_abonnement Order by Nom_mag;";
$result_abo=mysql_query($requete_abo);
echo'Selectionnez le nom du magazine associé à l\'emprunt : <BR /><select name="abo">';
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$id=$ligne_abo["NoAbo"];
$nom=$ligne_abo["Nom_mag"];
echo'<option value="'.$id.'">'.$nom.'</option>';
}
echo'</select>
<input type="hidden" name="pers" value="'.$pers.'" />
<input type="submit" name="valid_nommag" value="Valider"/>
</form>';
}

if(isset($_POST["valid_nommag"])){
echo'<BR />Selectionner le magazine concerné par l\'emprunt : ';
$id=$_POST["abo"];
$pers=$_POST["pers"];
$requete_mag="SELECT * FROM abo_magazine, abo_abonnement where abo_magazine.NoAbo=abo_abonnement.NoAbo and abo_magazine.NoAbo='$id' order by NoMag ;";
$result_mag=mysql_query($requete_mag);
$cpte=1;
echo'<form method="post"><select name="mag">';
while($ligne_mag=mysql_fetch_assoc($result_mag)){
$idmag=$ligne_mag["NoMag"];
$nom_abo=$ligne_mag["Nom_mag"];
$ref=$ligne_mag["ref_mag"];
echo'<option value="'.$idmag.'">'.$nom_abo.' -- No'.$cpte.' -- '.$ref.'</option>';
$cpte++;
}
echo'</select>&nbsp;&nbsp;
<input type="hidden" name="pers" value="'.$pers.'" />
<input type="hidden" name="abo" value="'.$id.'" />
<input type="submit" name="valid_mag" value="Valider" />
</form></table>';
}

if(isset($_POST["valid_mag"])){
echo'<BR />Entrer ses informations concernant l\'emprunt : <BR />';
echo'<form method="post">
<table>
<TR><TD>Date de l\'emprunt (JJ-MM-AAAA) : </TD><TD><input type="text" name="dateE" /></TD>
<TR><TD>Date de fin de l\'emprunt (JJ-MM-AAAA) : </TD><TD><input type="text" name="datefinE" /></TD>
</table>';
$id=$_POST["abo"];
$pers=$_POST["pers"];
$mag=$_POST["mag"];
echo'<input type="hidden" name="pers" value="'.$pers.'" />
<input type="hidden" name="abo" value="'.$id.'" />
<input type="hidden" name="mag" value="'.$mag.'" />
<input type="submit" name="valid_E" value="Valider" />
</form>';
}

if(isset($_POST["valid_E"])){
$id=$_POST["abo"];
$pers=$_POST["pers"];
$mag=$_POST["mag"];
$dateE=$_POST["dateE"];
$dateE_angl=date("Y-m-d", strtotime($dateE));
$datefinE=$_POST["datefinE"];
$datefinE_angl=date("Y-m-d", strtotime($datefinE));
$requete_ajoutE="INSERT INTO abo_emprunt values ('','$mag','$dateE_angl','0','$datefinE_angl','$pers') ;";
$result_ajoutE=mysql_query($requete_ajoutE);
if($result_ajoutE){
echo'<BR /> L\'emprunt a bien été enregistré.<BR />';
}else{
echo'<BR /> Erreur dans l\'ajout de l\'emprunt.<BR />';
}
}
?>
</BODY>
</HTML>
