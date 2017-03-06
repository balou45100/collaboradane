<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
$recup=isset($_POST["id"]) ? $_POST["id"] : $_POST["idR"];

//echo "<br />recup : $recup";

$requete_OM="SELECT * FROM personnes_ressources_tice, om_reunion, om_ordres_mission where personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion and om_reunion.idreunion='$recup';";
$result_OM=mysql_query($requete_OM);

$requete_simple="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%Hh%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%Hh%i') AS Heure_F from om_reunion where idreunion='$recup' ;";
$result_simple=mysql_query($requete_simple);
$ligne_s=mysql_fetch_assoc($result_simple);

echo'<h2>Participant-e-s de la Réunion << '.$ligne_s["intitule_reunion"].' >><br />'.$ligne_s["Date_D"].' &agrave; '.$ligne_s["Heure_D"].' au '.$ligne_s["Date_F"].' à '.$ligne_s["Heure_F"].'</h2>';

?>
<BR />
<!-- ---------------------------------------- -->
<BR />
<TABLE border>
<TR> 
<TD align=center>Personnes convoquées :</TD>
<TD align=center> Action :</TD>
</TR>
<?php
while($ligne=mysql_fetch_assoc($result_OM)){
echo'<TR>
<TD align=center>'.$ligne["civil"].' '.$ligne["nom"].' '.$ligne["prenom"].'</TD>
<TD align=center>
<form method=post>
	<input type="hidden" name="idP" value="'.$ligne["id_pers_ress"].'" />
	<input type="hidden" name="idR" value="'.$recup.'" />
	<input type=submit name="DEL" value="Supprimer" />
</form>
<form method=post action="om_affichages_om_suivantinvite.php">
	<input type="hidden" name="idP" value="'.$ligne["id_pers_ress"].'" />
	<input type="hidden" name="idR" value="'.$recup.'" />
	<input type=submit name="voir" value="Voir son OM" />
</FORM>
</TD>
</TR>';
}
echo'</TABLE>';
// ----------------- traitement de DEL --------------- //
if(isset($_POST["DEL"])){
$id=$_POST["idR"];
$idP=$_POST["idP"];
$requete_DEL1="DELETE FROM om_ordres_mission where idreunion='$id' and id_pers_ress='$idP';";
$result1=mysql_query($requete_DEL1);

$requete_inter="SELECT * from om_ordres_mission where idreunion='$id' and id_pers_ress='$idP' ;";
$result_inter=mysql_query($requete_inter);
$ligne_inter=mysql_fetch_assoc($result_inter);

$REF=$ligne_inter["RefOM"];

$requete_DEL2="DELETE FROM om_suivi_om where REFOM='$REF';";
$result2=mysql_query($requete_DEL2);

if($result1 && $result2){
echo'<BR />La personne convoquées a bien été supprimées (suppression dans la table om_ordres_mission et om_suivi_om).';
}
}
// ----------------- fin traitement de DEL ------------ // 

echo'
<BR /><table>
<FORM method=post action="om_invitation_pers_SelonReunion.php">
	<input type="hidden" name="idR" value="'.$ligne_s["idreunion"].'" />
	<input type=submit name="Ajout" value="Ajout Personne" />
</FORM>
<FORM method="post" action="om_affichage_reunion.php">
	<input type="submit" name="Retour" value="Retour"/>
</FORM>
</table>';



?>
</div>
</body>
</HTML>
