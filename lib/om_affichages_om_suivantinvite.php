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

$idP=$_POST["idP"];
$idR=$_POST["idR"];

/*
echo "<br />idP : $idP";
echo "<br />idR : $idR";
*/

$requete_SuiviOM="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F 
	FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om 
	WHERE om_ordres_mission.RefOM=om_suivi_om.RefOM 
		AND personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress 
		AND om_ordres_mission.idreunion=om_reunion.idreunion 
		AND om_ordres_mission.idreunion = '$idR'
		AND personnes_ressources_tice.id_pers_ress='$idP' ;";

//echo "<br />$requete_SuiviOM";

$result4=mysql_query($requete_SuiviOM);


?>
<!-- ---------------------------------------- -->
<table border>
<TR> 
	<TD align=center>Personnes :</TD>
	<TD align=center>Réunion :</TD>
	<TD align=center>Référence Ulysse de l'OM :</TD>
	<TD align=center>Etat d'utilisation de l'OM :</TD>
	<TD align=center>Date de l'OM :</TD>
	<TD align=center>Etat de l'OM :</TD>
	<TD align=center>Motif de l'OM :</TD>
	<TD align=center>Action :</TD>
</TR>
<?php
	if($ligne4=mysql_fetch_assoc($result4)){
	echo'<TR>';
	echo'	<TD align=center>'.$ligne4["civil"].' '.$ligne4["nom"].' '.$ligne4["prenom"].'</TD>
			<TD align=center>'.$ligne4["intitule_reunion"].' débute le '.$ligne4["Date_D"].' à '.$ligne4["Heure_D"].'</TD>
			<TD align=center>'.$ligne4["RefUlysse_om"].'</TD>';
	if($ligne4["etat_traite"]==0){
	echo'	<TD id=non_traite align=center>Non traité</TD>';
	}else{
		if($ligne4["etat_traite"]==1){
		echo'	<TD id=traite align=center>Traité</TD>';
		}
	}
	$DateV=date("d-m-Y", strtotime($ligne4["date_om"]));
	echo'	<TD align=center>'.$DateV.'</TD>';
	if($ligne4["etat_om"]=="C"){
	echo '	<TD id=convoque align=center>Convoqué</TD>';
	}else{
		if($ligne4["etat_om"]=="P"){
		echo '<TD id=present align=center>Présent</TD>';
		}else{
			if($ligne4["etat_om"]=="A"){
			echo '<TD id=absent align=center>Absent</TD>';
			}else{
				if($ligne4["etat_om"]=="V"){
				echo '<TD id=valide align=center>Validé</TD>';
				}else{
					if($ligne4["etat_om"]=="R"){
					echo '<TD id=refuse align=center>Refusé</TD>';
					}
				}
			}
		}
	}
	echo '<TD align=center>'.$ligne4["motif_om"].'</TD>
	<TD align=center>
	<FORM method="post" action="om_ajout_ef.php">
	<input type="hidden" name="REFOM_recup" value="'.$ligne4["RefOM"].'" />
	<input type="submit" name="ok" value="Ajout EF" />
	</FORM>';
	
	$valeur_om=$ligne4["RefOM"];
	$requete_trouve="SELECT RefOM, RefEF FROM om_etat_frais where RefOM=$valeur_om ;";
	$result5=mysql_query($requete_trouve);
	$ligne5=mysql_fetch_assoc($result5);
	
	if(!$ligne5["RefEF"]==''){
	echo'<FORM method="post" action="om_affichage_etatdefrais_suivantom.php">
	<input type="hidden" name="REFOM_recup1" value="'.$valeur_om.'" />
	<input type="submit" name="ok1" value="Affichage EF" />
	</FORM>';
	}else{
	echo'Aucun etat de frais enregistré';
	}
	echo'<FORM method=post action="om_maj_om.php"><input type="hidden" name="REFOM_recup1" value="'.$valeur_om.'" />
	<input type="submit" name="ok2" value="Mise à Jour OM" /></FORM>';
	echo'
	<FORM method=post action="om_affichage_reunion.php">
	<input type=submit name="Retour" value="Retour Fiche Réunion" />
	</FORM>
	<FORM method=post action="om_affichage_om.php">
	<input type=submit name="Retour1" value="Retour Liste OM" />
	</FORM>';
	}
	echo'
	<FORM method=post action="om_edition_1er.php">
	<input type="hidden" name="REFOM" value="'.$valeur_om.'" />
	<input type="submit" name="Envoi Relance" value="Edition" />
	</FORM>
	</TR>';
echo'</TABLE>';



?>
</div>
</body>
</HTML>
