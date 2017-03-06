<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
$recup=isset($_POST["idREUN"]) ? $_POST["idREUN"] : $_POST["id"];

$requete_R_LIEU_SAL="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F from om_reunion where idreunion=$recup;";
$result1=mysql_query($requete_R_LIEU_SAL);
$ligne1=mysql_fetch_assoc($result1);
?>
<table border>
<TR>	
	<th> Libell&eacute;</th>
	<th> Description</th>
	<th> Date de d&eacute;but</th>
    <th> Heure de d&eacute;but</th>
	<th> Date de fin</th>
    <th> Heure de fin</th>
	<th> &Eacute;tat</th>
</TR>
<TR>
<?php
echo'<TD align=center>'.$ligne1["intitule_reunion"].'</TD>
<TD align=center>'.$ligne1["description"].'</TD>
<TD align=center>'.$ligne1["Date_D"].'</TD>
<TD align=center>'.$ligne1["Heure_D"].'</TD>
<TD align=center>'.$ligne1["Date_F"].'</TD>
<TD align=center>'.$ligne1["Heure_F"].'</TD>';
if($ligne1["etat_reunion"]==0){
	echo'<TD align=center> non traité</TD>';
}else{
	if($ligne1["etat_reunion"]==1){
		echo'<TD align=center> traité </TD>';
	}
}
echo'</TR></table><BR />'; 

echo'Voulez-vous modifier la réunion ?<form method="post">
<input type="hidden" name="id" value="'.$recup.'" />
<input type=submit name="modfiREUN" value="Valider" />
</form><BR />';
if(isset($_POST["modfiREUN"])){
@$recup=$_POST["id"];
?>
<!-- ---------------------------------------- -->
<FORM method="post">
<table border>
<TR>	
	<th> Libell&eacute;</th>
	<th> Description</th>
	<th> Date de d&eacute;but</th>
    <th> Heure de d&eacute;but</th>
	<th> Date de fin</th>
    <th> Heure de fin</th>
	<th> &Eacute;tat</th>
</TR>
<TR>
<?php 

echo'<TD align=center><input type="text" name="int" value="'.$ligne1["intitule_reunion"].'" /></TD>
<TD align=center><input type="text" name="descr" value="'.$ligne1["description"].'" /></TD>
<TD align=center><input type="text" name="dateD" value="'.$ligne1["Date_D"].'" /></TD>
<TD align=center><input type="text" name="HD" value="'.$ligne1["Heure_D"].'" /></TD>
<TD align=center><input type="text" name="dateF" value="'.$ligne1["Date_F"].'" /></TD>
<TD align=center><input type="text" name="HF" value="'.$ligne1["Heure_F"].'" /></TD>
<TD align=center><select name="etat"><option value="0">non traité</option><option value="1">traité</option></select></TD>
</TR></table><BR />'; 

echo'
<table><input type="hidden" name="id" value="'.$recup.'" />
<input type="submit" name="ok" value="Valider" />
</form>
</table><BR />';
}
// -------- traitement des données --------- //
if(isset($_POST["ok"])){
$int=$_POST["int"];
$descr=$_POST["descr"];
$dateD=$_POST["dateD"];
$HD=$_POST["HD"];
$date_Dangl=date("Y-m-d", strtotime($dateD)).' '.$HD;
$dateF=$_POST["dateF"];
$HF=$_POST["HF"];
$date_Fangl=date("Y-m-d", strtotime($dateF)).' '.$HF;
$etat=$_POST["etat"];
$recup=$_POST["id"];

$requete_REUN="UPDATE om_reunion SET intitule_reunion='$int', date_horaire_debut='$date_Dangl', date_horaire_fin='$date_Fangl', etat_reunion='$etat', description = '$descr' where idreunion='$recup';";
$result_REUN=mysql_query($requete_REUN);

if($result_REUN){
echo 'La table om_reunion a bien été mise à jour.<BR />';
}else{
echo'Erreur de Mise à jour.<BR />';
}
}

// -----------------------------------  -------------------------------- //
$requete_R_LIEU_SAL="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F from om_reunion, om_salle where om_reunion.idsalle=om_salle.idsalle and idreunion=$recup;";
$result1=mysql_query($requete_R_LIEU_SAL);
$ligne1=mysql_fetch_assoc($result1);
$code=0;
$code2=0;
echo'<BR /><table border>
<TR>
	<th>Lieu</th>
	<th>Adresse</th> 
	<th>Code Postal</th>
	<th>Ville</th>
	<th>Pays</th>
	<th>T&eacute;l&eacute;phone</th>
	<th>M&eacute;l</th>
	<th>Salle</th>
</TR>
<TR>';
if($ligne1["idRNE"]==0){
	$code=$ligne1["idNo_societe"];
	$requete_inter="SELECT * from repertoire where No_societe='$code';";
	$result_inter=mysql_query($requete_inter);
	$ligne2=mysql_fetch_assoc($result_inter);
	echo'<TD align=center>'.$ligne2["societe"].'</TD> 
		<TD align=center>'.$ligne2["adresse"].'</TD> 
		<TD align=center>'.$ligne2["cp"].'</TD> 
		<TD align=center>'.$ligne2["ville"].'</TD> 
		<TD align=center>'.$ligne2["pays"].'</TD> 
		<TD align=center>'.$ligne2["tel_standard"].'</TD> 
		<TD align=center>'.$ligne2["email"].'</TD>
		<TD align=center>'.$ligne1["intitule_salle"].'</TD>';
	}else{
	if($ligne1["idNo_societe"]==0){
	$code2=$ligne1["idRNE"];
	$requete_inter2="SELECT * from etablissements where RNE='$code2';";
	$result_inter2=mysql_query($requete_inter2);
	$ligne3=mysql_fetch_assoc($result_inter2);
	echo'<TD align=center>'.$ligne3["NOM"].'</TD> 
		<TD align=center>'.$ligne3["ADRESSE"].'</TD> 
		<TD align=center>'.$ligne3["CODE_POSTAL"].'</TD> 
		<TD align=center>'.$ligne3["VILLE"].'</TD> 
		<TD align=center> France </TD> 
		<TD align=center>'.$ligne3["TEL"].'</TD> 
		<TD align=center>'.$ligne3["MAIL"].'</TD>
		<TD align=center>'.$ligne1["intitule_salle"].'</TD>';
	}
	}
echo'</TR>
</table><BR /><BR />';

// -----------------------------------   -------------------------------- //
@$recup_salle=$ligne1["idsalle"];
echo 'Voulez-vous faire des modifications sur le lieu de la réunion ?
<table><form method=post>
<input type="hidden" name="id_s" value="'.$recup_salle.'" />
<input type="hidden" name="id" value="'.$recup.'" />
<input type="submit" name="oui" value="Oui" />
</form>
</table>';
// ----------- ------------ //
if(isset($_POST["oui"])){
@$recup_salle=$_POST["id_s"];
@$recup=$_POST["id"];
echo'<form method="post">
<select name="type">
<option value="1">établissements</option>
<option value="2">autres lieux de réunion</option>
</select>
<input type="hidden" name="id_s" value="'.$recup_salle.'" />
<input type="hidden" name="id" value="'.$recup.'" />
<input type="submit" name="validlieu" value="Valider"/>
</form><BR />
';


}
//-------------------   ----------------- //
if(isset($_POST["validlieu"])){
@$recup_salle=$_POST["id_s"];
@$recup=$_POST["id"];
// $requete_S="SELECT * FROM om_salle where idsalle='$recup_salle' ;";
// $result_S=mysql_query($requete_S);
// $ligne_S=mysql_fetch_assoc($result_S);

// $code=$ligne_S["idRNE"];
// $code2=$ligne_S["idNo_societe"];

@$type=$_POST["type"];

echo'<form method="post">';
echo'Selectionné un nouveau lieu pour la réunion :';
if($type=='2'){
// ---------------- choisir un lieu parmis répertoire ------------- //
$requete_REP="SELECT * FROM repertoire order by societe;";
$result_REP=mysql_query($requete_REP);
echo'<select name=lieu>';
while($ligne_REP=mysql_fetch_assoc($result_REP)){
$SOC=$ligne_REP["No_societe"];
echo'<option value="'.$SOC.'">'.$ligne_REP["societe"].'----> '.$ligne_REP["ville"].' ( '.$ligne_REP["cp"].' ) </option>';
}
echo'</select>
<input type="hidden" name="code_nonnull" value="idNo_societe" />
<input type="hidden" name="code_null" value="idRNE" />';
}else{
	if($type=='1'){
	// ---------- choisir un lieu parmis les établissements --------- //
	$requete_ETAB="SELECT * FROM etablissements order by NOM;";
	$result_ETAB=mysql_query($requete_ETAB);
	echo'<select name=lieu>';
	while($ligne_ETAB=mysql_fetch_assoc($result_ETAB)){
	$RNE=$ligne_ETAB["RNE"];
	echo'<option value="'.$RNE.'">'.$ligne_ETAB["RNE"].' '.$ligne_ETAB["TYPE_ETAB_GEN"].' '.$ligne_ETAB["NOM"].' ----> '.$ligne_ETAB["VILLE"].'</option>';
	}
	echo'</select>
	<input type="hidden" name="code_nonnull" value="idRNE" />
	<input type="hidden" name="code_null" value="idNo_societe" />';
	}
}

echo'
<input type="hidden" name="id" value="'.$recup.'" />
<input type="submit" name="ValidLieu2" value="Valider" />
</form>';
}
// -----------  ------------ //
if(isset($_POST["ValidLieu2"])){
	$Codelieu=$_POST["lieu"];
	$code_nonnull=$_POST["code_nonnull"];
	$code_null=$_POST["code_null"];
	
	echo'<form method="post">';
		// ---------- selectionner une salle ------- //
		$requete_S="SELECT intitule_salle FROM om_salle WHERE $code_nonnull='$Codelieu' and $code_null='0' ORDER BY intitule_salle;";
		//echo "<br />$requete_S<br />";
		$result_S=mysql_query($requete_S);
		$ligne_S=mysql_fetch_assoc($result_S);
		
		@$recup=$_POST["id"];
		if($ligne_S!=''){
		echo'<form method="post">';
		echo'Choissisez une salle dans la liste :';
		echo'<select name="salle">';
		while($ligne_S=mysql_fetch_assoc($result_S)){
		$idsalle=$ligne_S["idsalle"];
		echo'<option value="'.$idsalle.'">'.$ligne_S["intitule_salle"].'</option>';
		}
		echo'</select>';
		echo'<input type="hidden" name="id" value="'.$recup.'" />
		<input type="hidden" name="lieu" value="'.$Codelieu.'" />
		<input type="submit" name="Salle" value="Valider" />
		</form>';
		}else{
		echo'Il n\'existe pas de salle pour ce lieu. Vous pouvez en créée une.<BR /><BR />
		<form method="post">
		Intitulé de la salle :
		<input type="text" name="Ajoutsalle" />
		<input type="hidden" name="id" value="'.$recup.'" />
		<input type="hidden" name="lieu" value="'.$Codelieu.'" />
		<input type="hidden" name="code_nonnull" value="'.$code_nonnull.'" />
		<input type="submit" name="nouvelle_salle" value="Valider" />
		</form>';
		}
	echo'<BR />';
}
// -----------  ------------ //
if(isset($_POST["Salle"])){
	$recup_salle=$_POST["salle"];
	$Codelieu=$_POST["lieu"];
	$recup=$_POST["id"];

	$requete_NewLieu="UPDATE om_reunion SET idsalle='$recup_salle' where idreunion='$recup' ;";
	$result_NewLieu=mysql_query($requete_NewLieu);

	if($result_NewLieu){
	echo'La table des Réunions a bien été mise à jour.<BR />';
	}else{
	echo'Erreur dans la mise à jour de la table des Réunions.<BR />';
	}
}

// -----------  ------------ //
if(isset($_POST["nouvelle_salle"])){
$ajout=$_POST["Ajoutsalle"];
$code_nonnull=$_POST["code_nonnull"];
$recup=$_POST["id"];
$Codelieu=$_POST["lieu"];

if($code_nonnull=='idRNE'){
	$requete_AjoutSalle1="INSERT INTO om_salle values ('','$Codelieu','0','$ajout');";
	$result_AjoutSalle1=mysql_query($requete_AjoutSalle1);
	if($result_AjoutSalle1){
	echo 'Ajout de la salle effectuée.<BR />';
		$requete_maxid="SELECT max(idsalle) AS MAX FROM om_salle;";
		$result_maxid=mysql_query($requete_maxid);
		$ligne_maxid=mysql_fetch_assoc($result_maxid);
		$recup_salle=$ligne_maxid["MAX"];
		$requete_NewLieu="UPDATE om_reunion SET idsalle='$recup_salle' where idreunion='$recup' ;";
		$result_NewLieu=mysql_query($requete_NewLieu);
		if($result_NewLieu){
		echo'Mise à jour de om_reunion effectuée.';
		}else{
		echo'Erreur de mise à jour de om_reunion.';
		}
	}else{
	echo'Erreur dans l\' ajout de la salle.<BR />';
	}
}else{
	if($code_nonnull='idNo_societe'){
	$requete_AjoutSalle2="INSERT INTO om_salle values ('','0','$Codelieu','$ajout');";
	$result_AjoutSalle2=mysql_query($requete_AjoutSalle2);
	if($result_AjoutSalle2){
	echo 'Ajout de la salle effectuée.<BR />';
		$requete_maxid="SELECT max(idsalle) AS MAX FROM om_salle;";
		$result_maxid=mysql_query($requete_maxid);
		$ligne_maxid=mysql_fetch_assoc($result_maxid);
		$recup_salle=$ligne_maxid["MAX"];
		$requete_NewLieu="UPDATE om_reunion SET idsalle='$recup_salle' where idreunion='$recup' ;";
		$result_NewLieu=mysql_query($requete_NewLieu);
		if($result_NewLieu){
		echo'Mise à jour de om_reunion effectuée.';
		}else{
		echo'Erreur de mise à jour de om_reunion.';
		}
	}else{
	echo'Erreur dans l\' ajout de la salle.<BR />';
	}
	}
}
}
// -----------  ------------ //

echo'<BR /><BR />Voulez-vous choisir une autre salle ?
<table><form method="post">
<input type="hidden" name="id_s" value="'.$recup_salle.'" />
<input type="hidden" name="id" value="'.$recup.'" />

<input type="submit" name="oui_2" value="Oui" />
</form></table><BR />';
// -----------  ------------ //
if(isset($_POST["oui_2"])){
@$recup=$_POST["id"];
$requete_S="SELECT * FROM om_salle WHERE (idRNE='$code2' AND idNo_Societe='$code') ORDER BY intitule_salle;";
$result_S=mysql_query($requete_S);
echo'<form method="post">';
echo'<select name="salle">';
while($ligne_S=mysql_fetch_assoc($result_S)){
$idsalle=$ligne_S["idsalle"];
echo'<option value="'.$idsalle.'">'.$ligne_S["intitule_salle"].'</option>';
}
echo'</select>';
echo'<input type="hidden" name="id" value="'.$recup.'" />

<input type="submit" name="Modification" value="Valider" />
</form><BR />';
}
// -----------  ------------ //
if(isset($_POST["Modification"])){
$salle =$_POST["salle"];
$recup=$_POST["id"];
$requete_MAJ="UPDATE om_reunion SET idsalle='$salle' where idreunion='$recup' ;";
$result_MAJ=mysql_query($requete_MAJ);
if($result_MAJ){
echo'Modification de la salle réussi.<BR /><BR />';
}else{
echo'Erreur modification de la salle.<BR /><BR />';
}

}
// -----------  ------------ //
echo'Ou ajouter une nouvelle salle à cette établissement ?
<form method="post">
<input type="hidden" name="code" value="'.$code.'" />
<input type="hidden" name="code2" value="'.$code2.'" />
<input type="hidden" name="id" value="'.$recup.'" />
<input type="submit" name="oui_3" value="Oui" />
</form><BR />';
// -----------  ------------ //
if(isset($_POST["oui_3"])){
echo'<form method="post">
Intitulé de la salle :
<input type="text" name="Ajoutsalle" />
<input type="hidden" name="code" value="'.$code.'" />
<input type="hidden" name="code2" value="'.$code2.'" />
<input type="hidden" name="id" value="'.$recup.'" />

<input type="submit" name="nouvelle" value="Valider" />
</form>';
}
// -----------  ------------ //
if(isset($_POST["nouvelle"])){
$ajout=$_POST["Ajoutsalle"];
$code=$_POST["code"];
$code2=$_POST["code2"];
$requete_AjoutSalle="INSERT INTO om_salle values ('','$code2','$code','$ajout');";
$result_AjoutSalle=mysql_query($requete_AjoutSalle);
if($result_AjoutSalle){
echo 'Ajout de la salle effectuée.<BR />';
}else{
echo'Erreur dans l\' ajout de la salle.<BR />';
}
}
// ----------------------  ---------------------------- //
echo'<BR /><form method="post" action="om_affichage_reunion.php">
<input type="submit" name="Retour" value="Retour"/>
</form>';

?>
</body>
</HTML>
