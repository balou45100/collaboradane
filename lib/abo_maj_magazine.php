<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html" />
<style type="text/css">
body{
background-color : #FFCC66;
}
</style>
</HEAD>
<BODY>
<?php
include ("../biblio/init.php");
?>
<H2>Mise a Jour des magazines</H2>
Selectionnez un abonnement dans la liste vous aurez ainsi une liste des magazines a mettre a jour.
<BR /><BR />
<?php
$requete_abo="SELECT * FROM abo_abonnement order by Nom_mag;";
$result_abo=mysql_query($requete_abo);
echo'<table><form method="post"><select name="abo">';
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$Mag=$ligne_abo["Nom_mag"];
$idAbo=$ligne_abo["NoAbo"];
echo'<option value="'.$idAbo.'">'.$Mag.'</option>';
}
echo'</select>
&nbsp;&nbsp;<input type="submit" name="validAbo" value=">>" /></form>&nbsp;&nbsp;&nbsp;';

if(isset($_POST["validAbo"])){
$id=$_POST["abo"];
$requete_mag="SELECT * FROM abo_magazine, abo_abonnement where abo_magazine.NoAbo=abo_abonnement.NoAbo and abo_magazine.NoAbo='$id' order by NoMag ;";
$result_mag=mysql_query($requete_mag);
$cpte=1;
echo'<form method="post"><select name="mag">';
while($ligne_mag=mysql_fetch_assoc($result_mag)){
$idmag=$ligne_mag["NoMag"];
$nom_abo=$ligne_mag["Nom_mag"];
$ref=$ligne_mag["ref_mag"];
echo'<option value="'.$idmag.'">Magazine "'.$nom_abo.'" -- No'.$cpte.' -- '.$ref.'</option>';
$cpte++;
}
echo'</select>&nbsp;&nbsp;
<input type="hidden" name="abo" value="'.$id.'" />
<input type="submit" name="validmag" value="Valider" />
</form></table>';
}
if(isset($_POST["validmag"])){
$id=$_POST["abo"];
$id_mag=$_POST["mag"];
$requete_mag2="SELECT * FROM abo_magazine where NoMag='$id_mag';";
$result_mag2=mysql_query($requete_mag2);
$ligne_mag2=mysql_fetch_assoc($result_mag2);
$ref=$ligne_mag2["ref_mag"];
$dater=$ligne_mag2["date_reception"];
$datep=$ligne_mag2["date_parution"];
$refcourrier=$ligne_mag2["ref_courrier_entrant"];
echo'<BR /><BR />
<form method="post"><table>
<TR><TD>Réference du magazine :</TD><TD><input type="text" name="ref" value"'.$ref.'" /></TD></TR>
<TR><TD>Date de réception (JJ-MM-AAAA) :</TD><TD><input type="text" name="dater" value"'.$dater.'" /></TD></TR>
<TR><TD>Date de parution :</TD><TD><input type="text" name="datep" value"'.$datep.'" /></TD></TR>
<TR><TD>Référence du courrier entrant :</TD><TD><input type="text" name="refcourrier" value"'.$refcourrier.'" /></TD></TR>
</table>
<input type="hidden" name="mag" value="'.$id_mag.'" />
<input type="hidden" name="abo" value="'.$id.'" /><BR />
<input type="submit" name="validmodif" value="Valider" /></form>';
}
if(isset($_POST["validmodif"])){
$ref=$_POST["ref"];
$dater=$_POST["dater"];
$dater_angl=date("Y-m-d", strtotime($dater));
$datep=$_POST["datep"];
$datep_angl=date("Y-m-d", strtotime($datep));
$refcourrier=$_POST["refcourrier"];
$id=$_POST["abo"];
$id_mag=$_POST["mag"];
$requete_maj="UPDATE abo_magazine SET date_reception='$dater_angl', date_parution='$datep_angl', ref_courrier_entrant='$refcourrier', ref_mag='$ref' where NoMag='$id_mag' ;";
$result_maj=mysql_query($requete_maj);
if($result_maj){
echo'<BR /><BR />Mise a jour de la table abo_magazine effectuée.<BR />';
}else{
echo'<BR /><BR />Erreur dans la mise a jour de la table abo_magazine.<BR />';
}
}
echo'<BR /><form method="post" action="abo_affichage_magazine.php">
<input type="submit" name="retour" value="Retour"/></form>';
?>
</BODY>
</HTML>
