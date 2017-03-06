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
<H2> Affichage des Magazines</H2>
<table border>
<TR>
<TD align=center>Nom du magazine : </TD>
<TD align=center>Référence du magazine : </TD>
<TD align=center>Date de reception : </TD>
<TD align=center>Date de parution : </TD>
<TD align=center>Référence du courrier entrant : </TD>
<TD align=center>Action : </TD>
</TR>
<?php
$id=$_POST["id"];
$requete_abo="SELECT * , DATE_FORMAT(date_reception, '%d-%m-%Y') AS date_reception2, DATE_FORMAT(date_parution, '%d-%m-%Y') AS date_parution2 FROM abo_abonnement, abo_magazine WHERE abo_abonnement.NoAbo=abo_magazine.NoAbo and abo_abonnement.NoAbo='$id' ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
echo'<TR>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center>'.$ligne_abo["ref_mag"].'</TD>
<TD align=center>'.$ligne_abo["date_reception2"].'</TD>
<TD align=center>'.$ligne_abo["date_parution2"].'</TD>
<TD align=center>'.$ligne_abo["ref_courrier_entrant"].'</TD>
<TD align=center>
<form method="post" action="abo_maj_magazine_SelonMag.php">
<input type="hidden" name="mag" value="'.$ligne_abo["NoMag"].'" />
<input type="submit" name="valid" value="Modification Magazine" />
</form>';
$mag=$ligne_abo["NoMag"];
$requete_mag="SELECT * , DATE_FORMAT(Date_emprunt, '%d-%m-%Y') AS Date_emprunt2, DATE_FORMAT(Date_fin_emprunt, '%d-%m-%Y') AS Date_fin_emprunt2 FROM abo_abonnement, abo_magazine, abo_emprunt, personnes_ressources_tice WHERE abo_emprunt.NoMag=abo_magazine.NoMag and abo_magazine.NoAbo=abo_abonnement.NoAbo and personnes_ressources_tice.id_pers_ress=abo_emprunt.id_pers_ress and abo_magazine.NoMag='$mag' ;";
$result_mag=mysql_query($requete_mag);
$ligne_mag=mysql_fetch_assoc($result_mag);
if($ligne_mag["id_emprunt"]==''){
echo'Aucun emprunt';
}else{
echo'<form method="post" action="abo_affichage_emprunt_SelonMag.php">
<input type="hidden" name="mag" value="'.$ligne_abo["NoMag"].'" />
<input type="submit" name="valid" value="Affichage Emprunt" />
</form>';
}
echo'</TD>
</TR>';
}
?>
</table>
</BODY>
</HTML>
