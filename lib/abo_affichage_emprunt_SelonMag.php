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
$mag=$_POST["mag"];
$requete_mag="SELECT * , DATE_FORMAT(Date_emprunt, '%d-%m-%Y') AS Date_emprunt2, DATE_FORMAT(Date_fin_emprunt, '%d-%m-%Y') AS Date_fin_emprunt2 FROM abo_abonnement, abo_magazine, abo_emprunt, personnes_ressources_tice WHERE abo_emprunt.NoMag=abo_magazine.NoMag and abo_magazine.NoAbo=abo_abonnement.NoAbo and personnes_ressources_tice.id_pers_ress=abo_emprunt.id_pers_ress and abo_magazine.NoMag='$mag' ;";
$result_mag=mysql_query($requete_mag);
while($ligne_mag=mysql_fetch_assoc($result_mag)){
echo'<TR>
<TD align=center>'.$ligne_mag["Nom_mag"].'</TD>
<TD align=center>'.$ligne_mag["nom"].' '.$ligne_mag["prenom"].'</TD>
<TD align=center>'.$ligne_mag["Date_emprunt2"].'</TD>
<TD align=center>'.$ligne_mag["Date_fin_emprunt2"].'</TD>';
if($ligne_mag["Rendu"]=='1'){
echo'<TD align=center>Oui</TD>';
}else{
echo'<TD align=center>Non</TD>';
}
echo'<TD align=center>
<form method="post" action="abo_maj_emprunt.php">
<input type="hidden" name="emprunt" value="'.$ligne_mag["id_emprunt"].'" />
<input type="submit" name="majE" value="Modifier" />
</form>
</TD>
</TR>';
}
?>
</table>
</BODY>
</HTML>
