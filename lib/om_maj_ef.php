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
	echo "<body>
		<div align = \"center\">";
$choix=isset($_POST["choix"]) ? $_POST["choix"] : $_POST["ref"];

$requete1="SELECT * FROM personnes_ressources_tice, om_ordres_mission, om_etat_frais, om_suivi_ef where om_etat_frais.RefEF=om_suivi_ef.RefEF and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.RefOM=om_etat_frais.RefOM and om_etat_frais.RefEF=$choix ;";
$result1=mysql_query($requete1);
?>

<FORM method="post">
<TABLE border>
<TR><TD align=center>Personne associé :</TD>
	<TD align=center>Référence Ulysse de l'EF :</TD>
	<TD align=center>Date de l'EF (JJ-MM-AAAA) :</TD>
	<TD align=center>Etat de l'EF :</TD>
	<TD align=center>Motif de l'EF :</TD>
	<TD align=center>Validation :</TD>

</TR>
<TR>
<?php
	while($ligne1=mysql_fetch_assoc($result1)){
	echo'	<TD align=center>'.$ligne1["civil"].' '.$ligne1["nom"].' '.$ligne1["prenom"].'</TD>
			<TD align=center><input type="text" name="refUlyss" value="'.$ligne1["RefUlysse_ef"].'" /></TD>';	
	$DateV=date("d-m-Y", strtotime($ligne1["date_ef"]));
	echo'	<TD align=center>'.$DateV.'</TD>';
	$choix=$ligne1["RefEF"];
	echo'<input type=hidden name="ref" value="'.$choix.'" />';

	echo'<TD align=center><SELECT name="suivi"><OPTION value="1">Validé</OPTION><OPTION value="2">Refusé</OPTION></SELECT></TD>
	<TD align=center><INPUT type="text" name="motif" value="'.$ligne1["motif_ef"].'"/></TD>
	<TD align=center><INPUT type="submit" name="valide" value="envoyer" /></TD>
	</FORM>';
	
	}


// echo'<TD align=center><FORM method=post action="om_affichage_etatdefrais_suivantom.php">
	// <input type="hidden" name="REFOM_recup1" value="'.$valeur.'" />
	// <input type=submit name="Retour3" value="Retour en arrière" />
	// </FORM></TD>';
?>
</TR>
</TABLE>
<?php

if(isset($_POST["valide"])){
@$ref=$_POST["ref"];
$etat=$_POST["suivi"];
$motif=$_POST["motif"];

$requete2="UPDATE om_suivi_ef SET etat_ef='$etat', motif_ef='$motif' WHERE RefEF='$ref' ;";
$result2=mysql_query($requete2);
	if($result2){
	echo 'La table om_suivi_ef a été mise à jour';
	}else{
	echo 'La table om_suivi_ef n a pas été mise à jour';
	}
	
echo '<BR /><table>';
echo '<FORM method=post action="om_affichage_om.php"><input type=submit name="ok2" value="Afficher les OM" /></FORM><BR /></table>';
}
?>
</BODY>
</HTML>
