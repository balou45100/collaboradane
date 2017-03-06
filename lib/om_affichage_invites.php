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
$requete_OM_EF_R_PERS="SELECT RefUlysse_om, etat_om, date_om, motif_om, intitule_reunion, date_horaire_debut, date_horaire_fin, civil, nom, prenom, etat_traite, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_ordres_mission, om_reunion, personnes_ressources_tice, om_suivi_om WHERE om_suivi_om.RefOM=om_ordres_mission.RefOM and om_reunion.idreunion=om_ordres_mission.idreunion and personnes_ressources_tice.`id_pers_ress`=om_ordres_mission.id_pers_ress;";
$result2=mysql_query($requete_OM_EF_R_PERS);


?>
<!-- ---------------------------------------- -->
<table border>
<TR> 
	<TD align=center> Libellé Réunion:</TD>	
	<TD align=center> Date de Début Réunion: </TD>
    <TD align=center> Heure de Début Réunion: </TD>
	<TD align=center> Date de Fin Réunion: </TD>
    <TD align=center> Heure de Fin Réunion: </TD>	
	<TD align=center> Personnes convoqués : </TD>
	<TD align=center> Etat de l'OM : </TD>
	<TD align=center> Référence de l'OM : </TD>
	<TD align=center> Etat de suivi de l'OM :</TD>
	<TD align=center> Date de Validation de l'OM :</TD>
	<TD align=center> Motif de l'OM :</TD>
</TR>
<?php
	while($ligne2=mysql_fetch_assoc($result2)){
	echo'<TR>
		<TD align=center>'.$ligne2["intitule_reunion"].'</TD>
		<TD align=center>'.$ligne2["Date_D"].'</TD>
		<TD align=center>'.$ligne2["Heure_D"].'</TD>
		<TD align=center>'.$ligne2["Date_F"].'</TD>
		<TD align=center>'.$ligne2["Heure_F"].'</TD>
		<TD align=center>'.$ligne2["civil"].' '.$ligne2["nom"].' '.$ligne2["prenom"].'</TD>';
		if($ligne2["etat_traite"]==1){
		$traite='traité';
		echo'<TD id=traite align=center>'.$traite.'</TD>';
		}else{
		$traite='non traité';
		echo'<TD id=non_traite align=center>'.$traite.'</TD>';
		}
	echo'<TD align=center>'.$ligne2["RefUlysse_om"].'</TD>';
		if($ligne2["etat_om"]=="C"){
		echo '<TD id=convoque align=center>convoqué</TD>';
		}else{
			if($ligne2["etat_om"]=="V"){
			echo '<TD id=valide align=center>validé</TD>';
			}else{
				if($ligne2["etat_om"]=="R"){
				echo '<TD id=rejete align=center>refusé</TD>';
				}else{
					if($ligne2["etat_om"]=="A"){
					echo '<TD id=absent align=center>absent</TD>';
					}else{	
						if($ligne2["etat_om"]=="P"){
						echo '<TD id=present align=center>présent</TD>';
						}
					}
				}
			}
		}
		$DateV=date("d-m-Y", strtotime($ligne2["date_om"]));
	echo'<TD align=center>'.$DateV.'</TD>
		<TD align=center>'.$ligne2["motif_om"].'</TD>';
	
	echo'</TR>';
	}
	
?>
</TABLE>
<?php


?>
</div>
</body>
</HTML>
