<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html" />
<style type="text/css">
body{

}
</style>
</HEAD>
<BODY>
<?php
include ("../biblio/init.php");
?>
<H2> Ajout de renouvellement </H2>
<form method="post">
<?php
$requete_abo="SELECT * FROM abo_abonnement Order by Nom_mag;";
$result_abo=mysql_query($requete_abo);
echo'Selectionnez un abonnement à renouveller : <BR /><select name="abo">';
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$id=$ligne_abo["NoAbo"];
$nom=$ligne_abo["Nom_mag"];
echo'<option value="'.$id.'">'.$nom.'</option>';
}
echo'</select>&nbsp;&nbsp;';
?>
<input type="submit" name="valid_abo" value="Envoyer"/>
</form>
<?php
if(isset($_POST["valid_abo"])){
$id=$_POST["abo"];
echo'<BR /><BR /><table><form method="post">
<TR><TD>Date de début du renouvellement : </TD><TD><input type="text" name="datedeb" /></TD></TR>
<TR><TD>Date de fin du renouvellement : </TD><TD><input type="text" name="datefin" /></TD></TR>
<TR><TD>Prix de l\'abonnement : </TD><TD><input type="text" name="prix" /></TD></TR>
<TR><TD>Nombre de magazine : </TD><TD><input type="text" name="nb" /></TD></TR>
<input type="hidden" name="abo" value="'.$id.'" />
<TR><TD></TD><TD><input type="submit" name="valid_renouv" /></TD></TR>
</form></table><BR />
';
}

if(isset($_POST["valid_renouv"])){
$date=date("Y-m-d");
$id=$_POST["abo"];
$datedeb=$_POST["datedeb"];
$datedeb_angl=date("Y-m-d", strtotime($datedeb));
$datefin=$_POST["datefin"];
$datefin_angl=date("Y-m-d", strtotime($datefin));
$prix=$_POST["prix"];
$nb=$_POST["nb"];
$requete_ajout="INSERT INTO abo_renouvellement values ('','$id','$date','$datedeb_angl','$datefin_angl','$prix','$nb') ;";
$result_ajout=mysql_query($requete_ajout);
if($result_ajout){
echo'L\ajout du renouvellement dans abo_renouvellement a bien été effectuée.<BR />';
$requete_maxR="SELECT MAX(idrenouv) as maxR FROM abo_renouvellement ;";
$result_maxR=mysql_query($requete_maxR);
$ligne_maxR=mysql_fetch_assoc($result_maxR);

$max=$ligne_maxR["maxR"];
$cpte=0;
$valid=false;
	while($cpte!=$nb){
		$requete_ajoutmag="INSERT INTO abo_magazine values ('','$max','','','','') ;";
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
}else{
echo'Erreur dans l\'ajout du renouvellement.<BR />';
}
}
echo'<BR /><form method="post" action="abo_affichage_abo.php">
<input type="submit" name="retour" value="Retour Abo."/></form>';
echo'<BR /><form method="post" action="abo_affichage_renouv.php">
<input type="submit" name="retour" value="Retour Renouv."/></form>';
?>
</BODY>
</HTML>
