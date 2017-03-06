<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	include("om_select2.php");
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
?>
<SCRIPT language="JavaScript">
   var i=0;
var nblist=<?php echo $nblist;?>; // Nombre de listes dépendantes
// Mise à jour des listes via XMLHttpRequest
function liste(f,q) {
   
   chp=""; // concatener les options
   for(i=0;i<q;i++){
      sel=f.elements["list"+i];
      ind=sel.selectedIndex;
      chp=chp+sel.options[ind].value+"/";
   }
   var l1 = f.elements["list"+(q-1)]; // La liste père
   var l2 = f.elements["list"+q]; // La liste à mettre à jour
   var index = l1.selectedIndex; // Index de la liste
// Remise à zéro des listes suivantes
   for(i=q;i<=nblist;i++) f.elements["list"+i].options.length = 0;
// Si une option est sélectionnée, alors, il faut y aller ;)
   if(index > 0) { 
   var xhr_object = null;

   if(window.XMLHttpRequest) // Si Firefox
      xhr_object = new XMLHttpRequest();
   else if(window.ActiveXObject) // Si Internet Explorer
      xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
   else { // XMLHttpRequest non supporté par le navigateur
      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
      return;
   }
// On passe en GET le numéro du select à mettre à jour
   xhr_object.open("POST", "om_select2.php?q="+q, true);

   xhr_object.onreadystatechange = function() {
   if(xhr_object.readyState == 4)
      eval(xhr_object.responseText);
   }
   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// Les données sont préparées dans data avec :
// - champ  : contient la value de l'option sélectionnée
// - form   : contient le nom du formulaire
// - select : contient le nom du select (les appeler tous listX où x va de 0 à n)
   var data = "champ="+chp+"&form="+f.name+"&select=list"+q;
   xhr_object.send(data);
   }
}
</SCRIPT>
<?php
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";

$requete1="SELECT DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F , idreunion, intitule_reunion FROM om_reunion where etat_reunion='0'";
$result1=mysql_query($requete1);

$requete_SuiviOM="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion ;";
$result2=mysql_query($requete_SuiviOM);

// ajout d'un tableau contenant le nom, prenom des personnes participant 
// déjà à la réunion avec un form contenant juste la réunion sélectionnée pour 
// permettre de voir les pers.
$list0 = "";
$list1 = "";


$reunion=isset($_POST["idR"]) ? $_POST["idR"] : '';

echo "<br />reunion : $reunion";

$requete_REUN_OM_personne="SELECT distinct om_ordres_mission.idreunion, civil,nom,prenom, intitule_reunion, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F from om_reunion, personnes_ressources_tice, om_ordres_mission where om_ordres_mission.id_pers_ress=personnes_ressources_tice.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion=$reunion ;";
$result3=mysql_query($requete_REUN_OM_personne);

echo'<table border><TR>
<TD> Réunion :</TD>

<TD> Personnes convoquées :</TD>
</TR>';
while($ligne3=mysql_fetch_assoc($result3)){
echo'<TR>
<TD>'.$ligne3["idreunion"].' - '.$ligne3["intitule_reunion"].' du '.$ligne3["Date_D"].' a '.$ligne3["Heure_D"].' au '.$ligne3["Date_F"].' a '.$ligne3["Heure_F"].'</TD>

<TD>'.$ligne3["civil"].' '.$ligne3["nom"].' '.$ligne3["prenom"].'</TD>
</TR>';
}
echo'</table>';


?>

<form name="frm" id="frm" method="POST">
<!-- ########### Listes déroulantes ########### -->
<BR />
<BR />
<table><tr><td><fieldset>
<legend>Personnes à sélectionner&nbsp;:</legend>
<table>
<tr>
   <td align="right">Poste &nbsp;:</td>
   <td><select style="width:200px" name="list0" id="list0" onchange="liste(this.form,1)">
   <option value="">== Choisir ==</option>
   <option value="*">== Tout ==</option>
   <?php echo $liste_dpt;?>
   </select></td>
</tr><tr>
   <td align="right">Personne&nbsp;:</td>
   <td><select style="width:200px" name="list1" id="list1" >
   </select></td><tr>
</tr></table>
</fieldset></td></tr></table><BR />
<td >
<?php
@$envoi=$_POST["idR"];
echo'<input type="hidden" name="idR" value="'.$envoi.'" />';
?>
<td>
Référence Ulysse de l'OM : <input type="text" name="Ulyss" />
</td><BR /><BR />
<input type="submit" name="Ajouter" value="Ajouter" /></td><td><input type="button" value="Retour" onclick="history.go(-1)"/></td></tr>
</form><BR />

<?php
	if(isset($_POST["Ajouter"])){
		$PERS = isset($_POST['list1']) ? $_POST['list1'] : '';
		$REUN = isset($_POST['idR']) ? $_POST['idR'] : '';
		// ----------- On vérifie que ces infos ne sont pas déjà dans la table ---- //
		$requete_verif="SELECT * from om_ordres_mission where id_pers_ress='$PERS' and idreunion='$REUN' ;";
		$result_verif=mysql_query($requete_verif);
		
		if($ligne_verif=mysql_fetch_assoc($result_verif)){
			echo'L ajout dans la table om_ordres_mission est impossible, 
			ces informations sont déjà enregistrées dans la table.';
		}else{		
			$requete4="INSERT INTO om_ordres_mission VALUES ('','$PERS','$REUN','');";
			$result4=mysql_query($requete4);
			
			$requete_inter="SELECT MAX(RefOM) AS REF FROM om_ordres_mission;";
			$result_inter=mysql_query($requete_inter);
			$ligne_inter=mysql_fetch_assoc($result_inter);
			
			$REF=$ligne_inter["REF"];
			$date=date("d-m-Y");
			$REFulysse=$_POST["Ulyss"];
			
			$requete41="INSERT INTO om_suivi_om VALUES ('', '$REF','$REFulysse','C','$date','');";
			$result41=mysql_query($requete41);
			
			if($result4 && $result41){
			echo 'L ajout dans la table om_ordres_mission et om_suivi_om de la réunion n°'.$REUN.' et la personne n°'.$PERS.' s est bien effectué';
			echo'<BR />';
			}else{
			echo 'erreur dans l ajout de la table om_ordres_mission et om_suivi_om avec la réunion n°'.$REUN.' et la personne n°'.$PERS.'.';
			echo '<BR />';
			}
			echo'<BR />';
			// ----------------- Réaffichage du tableau récap ---------------- //
			$requete5="SELECT distinct om_ordres_mission.idreunion, civil,nom,prenom, intitule_reunion, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F from om_reunion, personnes_ressources_tice, om_ordres_mission where om_ordres_mission.id_pers_ress=personnes_ressources_tice.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion='$REUN' ;";
			$result5=mysql_query($requete5);

			echo'<table border><TR>
			<TD> Réunion :</TD>

			<TD> Personnes convoquées :</TD>
			</TR>';
			while($ligne5=mysql_fetch_assoc($result5)){
			echo'<TR>
			<TD>'.$ligne5["idreunion"].' - '.$ligne5["intitule_reunion"].' du '.$ligne5["Date_D"].' a '.$ligne5["Heure_D"].' au '.$ligne5["Date_F"].' a '.$ligne5["Heure_F"].'</TD>

			<TD>'.$ligne5["civil"].' '.$ligne5["nom"].' '.$ligne5["prenom"].'</TD>
			</TR>';
			}
			echo'</table>';
		}
	}

echo'<BR /><FORM method="post" action="om_affichage_reunion.php">
<input type=submit name="Affich_Invit" value="Retour Fiche Réunion"/>
</FORM>';
?>
</div>
</BODY>

</HTML>
