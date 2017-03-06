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
@$valeur=isset($_POST["REFOM_recup"]) ? $_POST["REFOM_recup"] : $_POST["REF_om"];
$requete1="SELECT * FROM om_suivi_om where RefOM=$valeur ;";
$result1=mysql_query($requete1);
$ligne1=mysql_fetch_assoc($result1);

?>

<FORM method="post">
<TABLE border>
<TR>
	<TD align=center>Référence Ulysse de l'OM :</TD>
	<TD align=center>Référence Ulysse de l'EF :</TD>
	<TD align=center>Etat de l'EF :</TD>
	<TD align=center>Motif de l'EF :</TD>
	<TD align=center>Validation :</TD>
</TR>
<TR>
<?php
	echo'<TD align=center>'.$ligne1["RefUlysse_om"].'</TD>';
$valeurEF=$ligne1["RefUlysse_om"].'01';
echo' <TD align=center><INPUT type="text" name="Ref2" value="'.$valeurEF.'" /></TD>';
?>
	<TD align=center><SELECT name="etatS">
					<OPTION value="1">Validé</OPTION>
					<OPTION value="2">Refusé</OPTION></SELECT></TD>
	<TD align=center><textarea name="motif"cols=30 rows=2 wrap="physical"> </textarea></TD>
	<TD align=center><INPUT type="submit" name="ok" /></TD>
</TR>
</TABLE>
<BR />
<?php

echo'<input type="hidden" name="REF_om" value="'.$valeur.'" />';
?>
</FORM>

<?php
if(isset($_POST["ok"])){
@$REFOM=$_POST["REF_om"];
$requete2="INSERT INTO om_etat_frais VALUES ('', $REFOM);";
$result2=mysql_query($requete2);
	if($result2){
	echo'L ajout dans la table om_etat_frais a bien été effectué <BR />';
	$requete3="SELECT MAX(RefEF)as REF from om_etat_frais;";
	$result3=mysql_query($requete3);
	$ligne3=mysql_fetch_assoc($result3);
	$REF=$ligne3["REF"];
	$RefU=$_POST["Ref2"];
	$etat=isset($_POST['etatS']) ? $_POST['etatS'] : '';

	$motif=$_POST["motif"];
	$dateEF=date("Y-m-d");
	
	$requete4="INSERT INTO om_suivi_ef VALUES ('', '$REF', '$RefU', '$etat', '$dateEF', '$motif');";
	$result4=mysql_query($requete4);
		if($result4){
		echo 'L ajout dans la table om_suivi_ef a bien été effectué <BR />';
		}else{
		echo 'erreur d ajout dans la table om_suivi_ef <BR />';
		}
	}
}

echo '<BR /><table>';
echo '<FORM method=post action="om_affichage_om.php"><input type=submit name="ok2" value="Afficher les OM" /></FORM><BR /></table>';
?>
</BODY>
</HTML>
