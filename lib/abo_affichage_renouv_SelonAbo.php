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
<H2> Affichage des Renouvellement</H2>
<table border>
<TR>
<TD align=center>Nom du magazine : </TD>
<TD align=center>Date saisie : </TD>
<TD align=center>Date de début : </TD>
<TD align=center>Date de fin : </TD>
<TD align=center>Prix  : </TD>
<TD align=center>Nombre de Mag. : </TD>
<TD align=center>Action : </TD>
</TR>
<?php
$id=$_POST["id"];
$requete_abo="SELECT * , DATE_FORMAT(date_saisie_renouv, '%d-%m-%Y') AS date_saisie_renouv2, DATE_FORMAT(date_renouv, '%d-%m-%Y') AS date_renouv2, DATE_FORMAT(date_fin_renouv, '%d-%m-%Y') AS date_fin_renouv2 FROM abo_abonnement, abo_renouvellement WHERE abo_abonnement.NoAbo=abo_renouvellement.NoAbo and abo_abonnement.NoAbo='$id' ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$id_renouv=$ligne_abo["idrenouv"];
echo'<TR>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center>'.$ligne_abo["date_saisie_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["date_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["date_fin_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["prix_renouv"].'</TD>
<TD align=center>'.$ligne_abo["nb_renouv"].'</TD>
<TD align=center><form method="post" action="abo_maj_renouv.php"><input type="hidden" name="id" value="'.$id_renouv.'" />
<input type="submit" value="Modification Renouv."/></form>
</TD>
</TR>';
}
?>
</table>
</BODY>
</HTML>
