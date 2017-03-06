<?php
	session_start();
	include("../biblio/init.php");
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
	//include ("../biblio/init.php");

	echo "<body>";
	$page_appelant = "magazine";
	echo "<div align = \"center\">";
	include("abo_menu_principal.inc.php");
?>
<H2>Liste des magazines</H2>
<table border>
<TR>
<th>Titre</th>
<th>R&eacute;f&eacute;rence</th>
<th>Date de reception</th>
<th>Date de parution</th>
<th>R&eacute;f&eacute;rence du courrier entrant</th>
<th>Action</th>
</TR>
<?php
$requete_abo="SELECT * , DATE_FORMAT(date_reception, '%d-%m-%Y') AS date_reception2, DATE_FORMAT(date_parution, '%d-%m-%Y') AS date_parution2 FROM abo_abonnement, abo_magazine WHERE abo_abonnement.NoAbo=abo_magazine.NoAbo ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
echo'<TR>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center>'.$ligne_abo["ref_mag"].'</TD>
<TD align=center>'.$ligne_abo["date_reception2"].'</TD>
<TD align=center>'.$ligne_abo["date_parution2"].'</TD>
<TD align=center>'.$ligne_abo["ref_courrier_entrant"].'</TD>
<TD align=center>
<form method="post" action="abo_maj_magazine_SelonMag.php">
<input type="hidden" name="mag" value="'.$ligne_abo["NoMag"].'" />
<input type="submit" name="valid" value="Modification" />
</form>';
$mag=$ligne_abo["NoMag"];
$requete_mag="SELECT * , DATE_FORMAT(Date_emprunt, '%d-%m-%Y') AS Date_emprunt2, DATE_FORMAT(Date_fin_emprunt, '%d-%m-%Y') AS Date_fin_emprunt2 FROM abo_abonnement, abo_magazine, abo_emprunt, personnes_ressources_tice WHERE abo_emprunt.NoMag=abo_magazine.NoMag and abo_magazine.NoAbo=abo_abonnement.NoAbo and personnes_ressources_tice.id_pers_ress=abo_emprunt.id_pers_ress and abo_magazine.NoMag='$mag' ;";
$result_mag=mysql_query($requete_mag);
$ligne_mag=mysql_fetch_assoc($result_mag);
if($ligne_mag["id_emprunt"]==''){
echo'Aucun emprunt';
}else{
echo'<form method="post" action="abo_affichage_emprunt_SelonMag.php">
<input type="hidden" name="mag" value="'.$ligne_abo["NoMag"].'" />
<input type="submit" name="valid" value="Affichage Emprunt" />
</form>';
}
echo'</TD>
</TR>';
}
?>
</table>
</div>
</BODY>
</HTML>
