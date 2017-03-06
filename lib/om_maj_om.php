<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
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

	echo "<body>";
	
	//echo "<br />om_maj_om.php";
	
		echo "<div align = \"center\">";

if(isset($_POST["ok"]))
{
	$etat=$_POST["etat"];
	$DateV=date("Y-m-d");
	$motif=$_POST["motif"];
	$etat_util=$_POST["etat_util"];
	$REF=$_POST["Ref"];
	$REFULYSS=$_POST["refUlyss"];

	$requete_maj_om="UPDATE om_ordres_mission SET etat_traite='$etat_util' where RefOM='$REF' ;";
	$result_maj_om=mysql_query($requete_maj_om);

	$requete_maj="UPDATE om_suivi_om SET etat_om='$etat', RefUlysse_om='$REFULYSS', date_om='$DateV', motif_om='$motif' where RefOM='$REF' ;";
	$result_maj=mysql_query($requete_maj);

	if($result_maj_om && $result_maj){
	echo '<h2>Les tables om_ordres_mission et om_suivi_om ont bien été mises à jour pour l\'OM n°'.$REF.'.</h2>';
	}
	else
	{
		echo 'Les tables n ont pas été mises à jour pour l OM n°'.$REF.'.';
	}
}

			@$recup2=$_POST["Ref"];
			$recup= isset($_POST["REFOM_recup1"]) ? $_POST["REFOM_recup1"] : $recup2;

			$requete_SuiviOM="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F 
				FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om 
				WHERE om_ordres_mission.RefOM=om_suivi_om.RefOM 
					AND personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress 
					AND om_ordres_mission.idreunion=om_reunion.idreunion 
					AND om_ordres_mission.RefOM='$recup';";

			$result4=mysql_query($requete_SuiviOM);

?>
<!-- ---------------------------------------- -->
<br>
<table border>
<TR> 
	<TD align=center>Personnes :</TD>
	<TD align=center>Réunion :</TD>
	<TD align=center>Référence Ulysse de l'OM :</TD>
	<TD align=center>Etat d'utilisation de l'OM :</TD>
	<TD align=center>Etat de l'OM :</TD>
	<TD align=center>Date de l'OM :</TD>
	<TD align=center>Motif de l'OM :</TD>
	<TD align=center>Action :</TD>
</TR>
<?php
echo'<FORM method=post>';
	if($ligne4=mysql_fetch_assoc($result4)){
	
	//echo '<br />etat_om : '.$ligne4["etat_om"].'';
	
	echo'<TR>';
	echo'<TD align=center>'.$ligne4["civil"].' '.$ligne4["nom"].' '.$ligne4["prenom"].'</TD>
		<TD align=center>'.$ligne4["intitule_reunion"].' débute le '.$ligne4["Date_D"].' à '.$ligne4["Heure_D"].'</TD>
		<TD align=center><input type="text" name="refUlyss" value="'.$ligne4["RefUlysse_om"].'" /></TD>';
		
		echo '<TD align=center><select name="etat_util">';
		if ($ligne4["etat_traite"] == "0")
		{
			echo '<option selected value=0>non trait&eacute;</option>
			<option value=1>trait&eacute;</option></select>';
		}
		else
		{
			echo '<option selected value=1>trait&eacute;</option>
			<option value=0>non trait&eacute;</option></select>';
		}	
	echo'<TD align=center><select name="etat">';
	if ($ligne4["etat_om"] == "AC")
	{
		echo '<option selected value=AC>&agrave; convoquer</option>
			<option value=C>convoqu&eacute</option>
			<option value=A>absent</option>
			<option value=P>pr&eacute;sent</option>
			<option value=V>valid&eacute;</option>
			<option value=R>refus&eacute;</option>';
	}
	elseif ($ligne4["etat_om"] == "C")
	{
		echo '<option selected value=C>convoqu&eacute;</option>
			<option value=AC>&agrave; convoquer</option>
			<option value=P>pr&eacute;sent</option>
			<option value=A>absent</option>
			<option value=V>valid&eacute;</option>
			<option value=R>refus&eacute;</option>';
	}
	elseif ($ligne4["etat_om"] == "A")
	{
		echo '<option selected value=A>absent</option>
			<option value=AC>&agrave; convoquer</option>
			<option value=C>convoqu&eacute</option>
			<option value=P>pr&eacute;sent</option>
			<option value=V>valid&eacute;</option>
			<option value=R>refus&eacute;</option>';
	}
	elseif ($ligne4["etat_om"] == "P")
	{
		echo '<option selected value=P>pr&eacute;sent</option>
			<option value=AC>&agrave; convoquer</option>
			<option value=C>convoqu&eacute</option>
			<option value=A>absent</option>
			<option value=V>valid&eacute;</option>
			<option value=R>refus&eacute;</option>';
	}
	elseif ($ligne4["etat_om"] == "V")
	{
		echo '<option selected value=V>valid&eacute;</option>
			<option value=AC>&agrave; convoquer</option>
			<option value=C>convoqu&eacute;</option>
			<option value=P>pr&eacute;sent</option>
			<option value=A>absent</option>
			<option value=R>refus&eacute;</option>';
	}
	elseif ($ligne4["etat_om"] == "R")
	{
		echo '<option selected value=R>refus&eacute</option>
			<option value=AC>&agrave; convoquer</option>
			<option value=C>convoqu&eacute;</option>
			<option value=P>pr&eacute;sent</option>
			<option value=A>absent</option>
			<option value=V>valid&eacute;</option>';
	}

	$DateV=date("d-m-Y");
	echo'<TD align=center>'.$DateV.'</TD>';
	
	echo '<TD align=center><textarea name="motif" cols=12 rows=1 wrap=physical></textarea></TD>
	<input type=hidden name="Ref" value="'.$recup.'"/>
	<TD align=center><input type="submit" name="ok" value="valider"/></FORM>
	<FORM method=post action="om_affichage_om.php"><input type=submit name="Retour" value="Retour"/></FORM>
	</TD>
	
	</TR>';
	}
echo'</TABLE>';

?>
</body>
</HTML>
