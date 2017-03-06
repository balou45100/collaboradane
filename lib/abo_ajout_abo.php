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
$requete_soc="SELECT distinct ville from repertoire order by ville;";
$result_soc=mysql_query($requete_soc);
?>
<H2>Ajout d'un abonnement</H2>
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
?>
</select>
<input type=submit name="validville" value=">>" />
</form>
<?php
// --------------------------------------------------- //
if(isset($_POST["validville"])){

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
	echo'<input type="submit" name="validsoc" value="Valider" />
	</form></table><BR />';
}
// --------------------------------------------------- //
if(isset($_POST["validsoc"])){
@$soc=$_POST["soc"];
echo'<BR /><BR /><table> Catégorie :
	<form method="post">	
	<select name="categ" />';
	$requete_categ="SELECT * FROM abo_categorie order by intitule_categ;";
	$result_categ=mysql_query($requete_categ);
	while($ligne_categ=mysql_fetch_assoc($result_categ)){
		$id=$ligne_categ["idcateg"];
		$categ=$ligne_categ["intitule_categ"];
		echo'<option value="'.$id.'">'.$categ.'</option>';
	}
echo'
</select>
<input type="hidden" name="soc" value="'.$soc.'" />
<input type="submit" name="validCat" value="Valider" />
</form>
</table><BR />';
echo'<table>Voulez-vous ajouter une nouvelle catégorie ? 
<input type="hidden" name="soc" value="'.$soc.'" />
<input type="submit" name="new" value="Oui" /></table>';
}
// --------------------------------------------------- //
if(isset($_POST["new"])){
	@$soc=$_POST["soc"];
	echo'
	<BR /><BR /><form method="post">
	<input type="hidden" name="soc" value="'.$soc.'" />
	Intitulé de la nouvelle catégorie :
	<input type="text" name="intitule" />
	<input type="submit" name="valid_categ" value="Envoyer"/>
	</form>
	';
}
if(isset($_POST["valid_categ"])){
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
		echo'<form method="post">';
		@$soc=$_POST["soc"];
		$categ=$ligne_Rcat["maxcat"];
		echo'<BR /><input type="hidden" name="categ" value="'.$categ.'" />
		<input type="hidden" name="soc" value="'.$soc.'" />
		Validez-vous ce choix pour l\'abonnement ? 
		<input type="submit" name="validCat" value="Oui" />';
		}else{
		echo'<BR /> Erreur dans l\'ajout de la table abo_categorie.<BR />';
		}
	}else{
	echo'<BR />Cette intitulé existe déjà.';
	}
}

// --------------------------------------------------- //
if(isset($_POST["validCat"])){
	?>
	<BR /><form method="post">
	<table>
	<TR><TD>Nom magazine : </TD><TD><input type="text" name="nom_mag"/></TD></TR>
	<TR><TD>Date début d'abonnement (JJ-MM-AAAA) : </TD><TD><input type="text" name="datedeb"/></TD></TR>
	<TR><TD>Date fin d'abonnement (JJ-MM-AAAA) : </TD><TD><input type="text" name="datefin"/></TD></TR>
	<TR><TD>périodicité : </TD><TD>
		<select name="period">
			<option value="quotidien">quotidien (tous les jours)</option>
			<option value="hebdomadaire">hebdomadaire (toutes les semaines)</option>
			<option value="bimensuel">bimensuel (2 fois par mois)</option>
			<option value="mensuel">mensuel (tous les mois)</option>
			<option value="bimestriel">bimestriel (tous les 2 mois)</option>
			<option value="trimestriel">trimestriel (tous les 3 mois)</option>
			<option value="semestriel">semestriel (tous les 6 mois)</option>
			<option value="annuel">annuel (tous les ans)</option>
		</select></TD></TR>

	<TR><TD>prix : </TD><TD><input type="text" name="prix"/> </TD></TR>
	<TR><TD>Nb Magazine : </TD><TD><input type="text" name="nb"/> </TD></TR>

	<?php
	@$soc=$_POST["soc"];
	echo'<input type="hidden" name="soc" value="'.$soc.'" />';
	@$categ=$_POST["categ"];
	echo'<input type="hidden" name="categ" value="'.$categ.'" />';
	?>	
	<TR><TD></TD><TD><input type="submit" name="validabo" value="valider" /></TD></TR>
	</table>
	</form>
	<?php
}
// --------------------------------------------------- //
if(isset($_POST["validabo"])){
	$nom=$_POST["nom_mag"];
	$requete_verifabo="SELECT * FROM abo_abonnement where Nom_mag like '$nom';";
	$result_verifabo=mysql_query($requete_verifabo);
	$ligne_verifabo=mysql_fetch_assoc($result_verifabo);
	$date=date("Y-m-d");

	if($ligne_verifabo["Nom_mag"]==''){
	$datedebut=$_POST["datedeb"];
	$datedebut_angl=date("Y-m-d", strtotime($datedebut));
	$datefin=$_POST["datefin"];
	$datefin_angl=date("Y-m-d", strtotime($datefin));
	$period=$_POST["period"];
	$prix=$_POST["prix"];
	$nb=$_POST["nb"];
	$categ=$_POST["categ"];
	$soc=$_POST["soc"];

	$requete_ajoutabo="INSERT INTO abo_abonnement values ('','$nom','$date','$datedebut_angl','$datefin_angl','$period','$prix','$nb','$soc','$categ');";
	$result_ajoutabo=mysql_query($requete_ajoutabo);
		if($result_ajoutabo){
		echo '<BR /><BR />L\'ajout dans la table abo_abonnement a bien été effectué.<BR />';
		$requete_maxabo="SELECT MAX(NoAbo) as maxabo FROM abo_abonnement ;";
		$result_maxabo=mysql_query($requete_maxabo);
		$ligne_maxabo=mysql_fetch_assoc($result_maxabo);

		$max=$ligne_maxabo["maxabo"];
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
		echo'<BR /><BR />Erreur dans l\'ajout de la table abo_abonnement.<BR />';
		}
	}else{
	echo' <BR /><BR />Un abonnement pour le nom de ce magazine existe déjà.';
	}
}

echo'<BR /><form method="post" action="abo_affichage_abo.php">
<input type="submit" name="retour" value="Retour" />
</form>';
?>
</BODY>
</HTML>
