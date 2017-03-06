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
$recup=$_POST["REFOM"];

$requete_Relance="SELECT * FROM om_relance, om_ordres_mission, om_suivi_om, personnes_ressources_tice WHERE om_ordres_mission.RefOM=om_relance.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.RefOM=om_suivi_om.RefOM and om_ordres_mission.RefOM='$recup';";
$result5=mysql_query($requete_Relance);


?>
<!-- ---------------------------------------- -->
<table border>
<TR> 
	<TD align=center>Personnes :</TD>
	<TD align=center> Référence de l'OM :</TD>
	<TD align=center> Date de la Relance :</TD>
</TR>

<?php
	while($ligne5=mysql_fetch_assoc($result5)){
echo'<TR><TD align=center>'.$ligne5["civil"].' '.$ligne5["nom"].' '.$ligne5["prenom"].'</TD>
	<TD align=center>'.$ligne5["RefUlysse_om"].'</TD>
	<TD align=center>'.$ligne5["date_relance"].'</TD></TR>';
	}
?>

</TABLE>
<?php


?>
</div>
</body>
</HTML>
