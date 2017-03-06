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
$requete_abo="SELECT * , DATE_FORMAT(date_saisie_renouv, '%d-%m-%Y') AS date_saisie_renouv2, DATE_FORMAT(date_renouv, '%d-%m-%Y') AS date_renouv2, DATE_FORMAT(date_fin_renouv, '%d-%m-%Y') AS date_fin_renouv2 FROM abo_abonnement, abo_renouvellement WHERE abo_abonnement.NoAbo=abo_renouvellement.NoAbo and abo_renouvellement.idrenouv='$id' ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$nb=$ligne_abo["nb_renouv"];
$id_abo=$ligne_abo["NoAbo"];
echo'
<FORM method="post">
<TR>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center><input type="text" size="10" name="date_s" value="'.$ligne_abo["date_saisie_renouv2"].'"/></TD>
<TD align=center><input type="text" size="10" name="dater" value="'.$ligne_abo["date_renouv2"].'"/></TD>
<TD align=center><input type="text" size="10" name="datef" value="'.$ligne_abo["date_fin_renouv2"].'"/></TD>
<TD align=center><input type="text" size="8" name="prix" value="'.$ligne_abo["prix_renouv"].'"/></TD>
<TD align=center><input type="text" size="8" name="nb" value="'.$ligne_abo["nb_renouv"].'"/></TD>
<TD align=center>
<input type="hidden" name="id_abo" value="'.$id_abo.'" />
<input type="hidden" name="nborig" value="'.$nb.'" />
<input type="hidden" name="id" value="'.$id.'" />
<input type="submit" name="majrenouv" value="Valider" /></TD>
</TR>
</form></table>';
}

if(isset($_POST["majrenouv"])){
$id_abo=$_POST["id_abo"];
$nborig=$_POST["nborig"];
$nb=$_POST["nb"];
$id=$_POST["id"];
$date_s=$_POST["date_s"];
$date_s_angl=date("Y-m-d", strtotime($date_s));
$dater=$_POST["dater"];
$dater_angl=date("Y-m-d", strtotime($dater));
$datef=$_POST["datef"];
$datef_angl=date("Y-m-d", strtotime($datef));
$prix=$_POST["prix"];
$requete_majR="UPDATE abo_renouvellement SET date_saisie_renouv='$date_s_angl', date_renouv='$dater_angl', date_fin_renouv='$datef_angl', prix_renouv='$prix', nb_renouv='$nb' where idrenouv='$id' ;";
$result_majR=mysql_query($requete_majR);
if($result_majR){
echo'<BR />La Mise à jour de la table abo_renouvellement a bien été effectuée.<BR />';
if($nb > $nborig){
$cpte=$nborig;
$valid=false;
	while($cpte!=$nb){
	$requete_ajoutmag="INSERT INTO abo_magazine values ('','$id_abo','','','','') ;";
	$result_ajoutmag=mysql_query($requete_ajoutmag);
	if($result_ajoutmag){
	$valid=true;
	}
	$cpte++;
	}
if($valid==true){
echo 'Les magazines ont été ajoutés à abo_magazine.<BR />';
}else{
echo 'Problème dans l\'ajout des magazines à abo_magazine.<BR />';
}

}
}else{
echo'<BR />Erreur dans la mise à jour de la table abo_renouvellement.<BR />';
}
}
echo'<BR /><form method="post" action="abo_affichage_renouv.php">
<input type="submit" name="retour" value="Retour"/></form>';
?>
</BODY>
</HTML>
