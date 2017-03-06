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

$valeur=$_POST["REFOM_recup1"];

$requete_SuiviEF="SELECT * FROM personnes_ressources_tice, om_ordres_mission, om_etat_frais, om_suivi_ef where om_etat_frais.RefEF=om_suivi_ef.RefEF and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.RefOM=om_etat_frais.RefOM and om_ordres_mission.RefOM=$valeur;";
$result4=mysql_query($requete_SuiviEF);


?>
<!-- ---------------------------------------- -->
<table border>
<TR> 
	<TD align=center>Personnes :</TD>
	<TD align=center>Référence Ulysse de l'EF :</TD>
	<TD align=center>Date de l'EF :</TD>
	<TD align=center>Etat de l'EF :</TD>
	<TD align=center>Motif de l'EF :</TD>
	<TD align=center>Action :</TD>

</TR>
<?php
	while($ligne4=mysql_fetch_assoc($result4)){
	echo'<TR>';
	$RefEF=$ligne4["RefEF"];
	echo'	<TD align=center>'.$ligne4["civil"].' '.$ligne4["nom"].' '.$ligne4["prenom"].'</TD>
			<TD align=center>'.$ligne4["RefUlysse_ef"].'</TD>';	
	$DateV=date("d-m-Y", strtotime($ligne4["date_ef"]));
	echo'	<TD align=center>'.$DateV.'</TD>';
	if($ligne4["etat_ef"]=="V"){
	echo '	<TD id=valide align=center>validé</TD>';
	}else{
		if($ligne4["etat_ef"]=="R"){
		echo '<TD id=refuse align=center>refusé</TD>';
		}
	}
	echo '<TD align=center>'.$ligne4["motif_ef"].'</TD>';
	echo'<TD align=center>
	<FORM method="post" action=om_maj_ef.php>
	<input type=hidden name="choix" value="'.$RefEF.'"/>
	<input type=submit name="ok" value="Mise à jour de l EF" />
	</FORM>
	<FORM method=post action="om_affichages_om_suivantinvite.php">
	<input type="hidden" name="idP" value="'.$ligne4["id_pers_ress"].'" />
	<input type=submit name="Retour3" value="Retour en arrière" />
	</FORM>
	</TD>
	<TR>';
}
?>
</TABLE>
<?php


?>
</div>
</body>
</HTML>
