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
$id=$_POST["id"];
?>
<H2> Mise à jour des Abonnements </H2>

<table border>
<TR>
<TD align=center>Nom du magazine : </TD>
<TD align=center>Catégorie : </TD>
<TD align=center>Fournisseur : </TD>
<TD align=center>Date saisie : </TD>
<TD align=center>Date de début : </TD>
<TD align=center>Date de fin : </TD>
<TD align=center>Prix : </TD>
<TD align=center>Périodicité : </TD>
<TD align=center>Nb Magazine : </TD>
</TR>
<?php
$requete_abo="SELECT * , DATE_FORMAT(date_saisie, '%d-%m-%Y') AS date_saisie2, DATE_FORMAT(date_debut, '%d-%m-%Y') AS date_debut2, DATE_FORMAT(date_fin, '%d-%m-%Y') AS date_fin2 FROM abo_abonnement, abo_categorie, repertoire WHERE repertoire.No_societe=abo_abonnement.No_societe and abo_categorie.idcateg=abo_abonnement.idcateg and abo_abonnement.NoAbo='$id' ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
echo'<TR>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center>'.$ligne_abo["intitule_categ"].'</TD>
<TD align=center>'.$ligne_abo["societe"].' (No '.$ligne_abo["No_societe"].' ) </TD>
<TD align=center>'.$ligne_abo["date_saisie2"].'</TD>
<TD align=center>'.$ligne_abo["date_debut2"].'</TD>
<TD align=center>'.$ligne_abo["date_fin2"].'</TD>
<TD align=center>'.$ligne_abo["prix"].'</TD>
<TD align=center>'.$ligne_abo["périodicité"].'</TD>
<TD align=center>'.$ligne_abo["NbMagazine"].'</TD>
</TR>';
}
?>
</table><BR />

<form method="post">
Voulez-vous modifier les informations générales de l'abonnement ?
<?php
echo'<input type="hidden" name="id" value="'.$id.'" />';
?>
<input type="submit" name="oui" value="Oui" />
</form>
<BR />
<?php
if(isset($_POST["oui"])){
?>
<table border>
<TR>
<TD align=center>Nom du magazine : </TD>
<TD align=center>Catégorie : </TD>
<TD align=center>Fournisseur : </TD>
<TD align=center>Date saisie : </TD>
<TD align=center>Date de début : </TD>
<TD align=center>Date de fin : </TD>
<TD align=center>Prix : </TD>
<TD align=center>Périodicité : </TD>
<TD align=center>Nb Magazine : </TD>
<TD align=center>Action : </TD>
</TR>
<?php
$id=$_POST["id"];
$requete_abo="SELECT * , DATE_FORMAT(date_saisie, '%d-%m-%Y') AS date_saisie2, DATE_FORMAT(date_debut, '%d-%m-%Y') AS date_debut2, DATE_FORMAT(date_fin, '%d-%m-%Y') AS date_fin2 FROM abo_abonnement, abo_categorie, repertoire WHERE repertoire.No_societe=abo_abonnement.No_societe and abo_categorie.idcateg=abo_abonnement.idcateg  and abo_abonnement.NoAbo='$id';";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
echo'
<form method="post">
<TR>
<TD align=center><input type="text" name="nom" value="'.$ligne_abo["Nom_mag"].'" /></TD>
<TD align=center>'.$ligne_abo["intitule_categ"].'</TD>
<TD align=center>'.$ligne_abo["societe"].' (No '.$ligne_abo["No_societe"].' )</TD>
<TD align=center><input type="text" size="8" name="date_s" value="'.$ligne_abo["date_saisie2"].'" /></TD>
<TD align=center><input type="text" size="8" name="dated" value="'.$ligne_abo["date_debut2"].'" /></TD>
<TD align=center><input type="text" size="8" name="datef" value="'.$ligne_abo["date_fin2"].'" /></TD>
<TD align=center><input type="text" size="8" name="prix" value="'.$ligne_abo["prix"].'" /></TD>
<TD align=center><input type="text" name="period" value="'.$ligne_abo["périodicité"].'" /></TD>
<TD align=center><input type="text" size="8" name="nb" value="'.$ligne_abo["NbMagazine"].'" /></TD>
<TD align=center>
<input type="hidden" name="nborigine" value="'.$ligne_abo["NbMagazine"].'" />
<input type="hidden" name="id" value="'.$ligne_abo["NoAbo"].'" />
<input type="submit" name="valid_modif" value="Valdier" /></TD>';
echo'</TR>
</form></table>';
}
}

if(isset($_POST["valid_modif"])){
$nom=$_POST["nom"];
$date_s=$_POST["date_s"];
$date_s_angl=date("Y-m-d", strtotime($date_s));
$dated=$_POST["dated"];
$dated_angl=date("Y-m-d", strtotime($dated));
$datef=$_POST["datef"];
$datef_angl=date("Y-m-d", strtotime($datef));
$prix=$_POST["prix"];
$period=$_POST["period"];
$nb=$_POST["nb"];
$nborig=$_POST["nborigine"];
$id=$_POST["id"];
$requete_maj="UPDATE abo_abonnement SET Nom_mag='$nom', date_saisie='$date_s_angl', date_debut='$dated_angl', date_fin='$datef_angl', périodicité='$period', prix='$prix', NbMagazine='$nb' where NoAbo='$id' ;";
$result_maj=mysql_query($requete_maj);
if($requete_maj){
echo'<BR />La Mise à jour de la table abo_abonnement a bien été effectuée.<BR />';
if($nb > $nborig){
$cpte=$nborig;
$valid=false;
	while($cpte!=$nb){
	$requete_ajoutmag="INSERT INTO abo_magazine values ('','$id','','','','') ;";
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
echo'<BR />Erreur dans la mise à jour de la table abo_abonnement.<BR />';
}
}

echo'<BR /><form method="post">Voulez-vous modifier le fournisseur ?
<input type="hidden" name="id" value="'.$id.'" />
<input type="submit" name="fournisseur" value="Oui" />
</form><BR />';

if(isset($_POST["fournisseur"])){
$id=$_POST["id"];
$requete_soc="SELECT distinct ville from repertoire order by ville;";
$result_soc=mysql_query($requete_soc);
?>
<form method="post">
Société : <BR />
<table>
<select name="ville">
<option value="">---- toutes les villes -----</option>
<?php
while($ligne_soc=mysql_fetch_assoc($result_soc)){
$ville=$ligne_soc["ville"];
echo'<option value="'.$ville.'">'.$ville.'</option>';
}
echo'
</select>
<input type="hidden" name="id" value="'.$id.'" />
<input type=submit name="validville" value=">>" />
</form><BR />';

}
// --------------------------------------------------- //
if(isset($_POST["validville"])){
	$id=$_POST["id"];
	$ville=$_POST["ville"];
	echo'<form method="post">';
	if($ville==''){
		$requete_recup="SELECT * FROM repertoire order by societe ;";
		$result_recup=mysql_query($requete_recup);

		echo'<select name="soc">';
			while($ligne_recup=mysql_fetch_assoc($result_recup)){
			$soc=$ligne_recup["societe"];
			$idsoc=$ligne_recup["No_societe"];
			$ville=$ligne_recup["ville"];

			echo'<option value="'.$idsoc.'">'.$soc.' ('.$idsoc.') ------> '.$ville.'</option>';
			}
		echo'</select>';
	}else{
		$requete_recup="SELECT * FROM repertoire where ville='$ville' order by societe;";
		$result_recup=mysql_query($requete_recup);

		echo'<select name="soc">';
			while($ligne_recup=mysql_fetch_assoc($result_recup)){
			$soc=$ligne_recup["societe"];
			$idsoc=$ligne_recup["No_societe"];
			echo'<option value="'.$idsoc.'">'.$soc.' ('.$idsoc.')</option>';
			}
		echo'</select>';
	}
	echo'<input type="hidden" name="id" value="'.$id.'" />
	<input type="submit" name="validsoc" value="Valider" />
	</form></table><BR />';
}
// --------------------------------------------------- //
if(isset($_POST["validsoc"])){
$id=$_POST["id"];
$soc=$_POST["soc"];
$requete_majsoc="UPDATE abo_abonnement SET No_societe='$soc' where NoAbo='$id' ;";
$result_majsoc=mysql_query($requete_majsoc);
if($result_majsoc){
echo'La mise à jour du fournisseur a bien été effectuée.<BR />';
}else{
echo'Erreur dans la mise à jour du fournisseur.<BR />';
}
}

echo'
<form method="post">
Voulez-vous modifier la catégorie ?
<input type="hidden" name="id" value="'.$id.'" />
<input type="submit" name="categ" value="Oui" />
</form>
';

if(isset($_POST["categ"])){
$id=$_POST["id"];
echo'<BR /><table> Catégorie :
	<form method="post">	
	<select name="categ" />';
	$requete_categ="SELECT * FROM abo_categorie order by intitule_categ;";
	$result_categ=mysql_query($requete_categ);
	while($ligne_categ=mysql_fetch_assoc($result_categ)){
		$id_cat=$ligne_categ["idcateg"];
		$categ=$ligne_categ["intitule_categ"];
		echo'<option value="'.$id_cat.'">'.$categ.'</option>';
	}
echo'
</select>
<input type="hidden" name="id" value="'.$id.'" />
<input type="submit" name="validCat" value="Valider" />
</form>
</table><BR />';
echo'<table><form method="post" >Voulez-vous ajouter une nouvelle catégorie ? 
<input type="hidden" name="id" value="'.$id.'" />
<input type="submit" name="new" value="Oui" /></table>
</form>';
}
// --------------------------------------------------- //
if(isset($_POST["new"])){
	$id=$_POST["id"];
	echo'
	<BR /><BR /><form method="post">
	<input type="hidden" name="id" value="'.$id.'" />
	Intitulé de la nouvelle catégorie :
	<input type="text" name="intitule" />
	<input type="submit" name="valid_categ" value="Envoyer"/>
	</form>
	';
}

if(isset($_POST["valid_categ"])){
	$id=$_POST["id"];
	$nom=$_POST["intitule"];
	$requete_verif="SELECT * FROM abo_categorie where intitule_categ='$nom' ;";
	$result_verif=mysql_query($requete_verif);
	$ligne_verif=mysql_fetch_assoc($result_verif);

	if($ligne_verif["nom"]==''){
	$requete_ajout="INSERT INTO abo_categorie values ('','$nom') ;";
	$result_ajout=mysql_query($requete_ajout);
		if($result_ajout){
		echo'<BR /><BR /> Ajout dans la table abo_categorie.<BR />';
		$requete_recupcat="Select MAX(idcateg) AS maxcat FROM abo_categorie;";
		$result_Rcat=mysql_query($requete_recupcat);
		$ligne_Rcat=mysql_fetch_assoc($result_Rcat);
		$id=$_POST["id"];
		$categ=$ligne_Rcat["maxcat"];
		echo'
		<form method="post">
		Validez-vous ce choix pour l\'abonnement ?
		<input type="hidden" name="categ" value="'.$categ.'" />
		<input type="hidden" name="id" value="'.$id.'" />
		<input type="submit" name="validCat" value="Oui" /></form>';
		}else{
		echo'<BR /> Erreur dans l\'ajout de la table abo_categorie.<BR />';
		}
	}else{
	echo'<BR />Cette intitulé existe déjà.';
	}
}

if(isset($_POST["validCat"])){
$id=$_POST["id"];
$categ=$_POST["categ"];
$requete_majcateg="UPDATE abo_abonnement SET idcateg='$categ' where NoAbo='$id';";
$result_majcateg=mysql_query($requete_majcateg);
if($result_majcateg){
echo'La mise à jour de la catégorie a bien été effectuée.<BR />';
}else{
echo'Erreur dans la mise à jour de la catégorie.<BR />';
}
}

echo'<BR /><form method="post" action="abo_affichage_abo.php">
<input type="submit" name="retour" value="Retour" />
</form>';
?>
</BODY>
</HTML>
