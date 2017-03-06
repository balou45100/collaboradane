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
	$page_appelant = "renouv";
	echo "<div align = \"center\">";
	include("abo_menu_principal.inc.php");
?>
<H2>Liste des renouvellements</H2>
<table border>
	<TR>
		<th>Abonnement concern&eacute;</th>
		<th>Nom du magazine</th>
		<th>Date saisie</th>
		<th>Date de d&eacute;but</th>
		<th>Date de fin</th>
		<th>Prix</th>
		<th>Nombre de Mag.</th>
		<th>Action</th>
	</TR>
<?php
$requete_abo="SELECT * , DATE_FORMAT(date_saisie_renouv, '%d-%m-%Y') AS date_saisie_renouv2, DATE_FORMAT(date_renouv, '%d-%m-%Y') AS date_renouv2, DATE_FORMAT(date_fin_renouv, '%d-%m-%Y') AS date_fin_renouv2 FROM abo_abonnement, abo_renouvellement WHERE abo_abonnement.NoAbo=abo_renouvellement.NoAbo ;";
$result_abo=mysql_query($requete_abo);
while($ligne_abo=mysql_fetch_assoc($result_abo)){
$id_renouv=$ligne_abo["idrenouv"];
echo'<TR>
<TD align=center>'.$ligne_abo["NoAbo"].'</TD>
<TD align=center>'.$ligne_abo["Nom_mag"].'</TD>
<TD align=center>'.$ligne_abo["date_saisie_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["date_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["date_fin_renouv2"].'</TD>
<TD align=center>'.$ligne_abo["prix_renouv"].'</TD>
<TD align=center>'.$ligne_abo["nb_renouv"].'</TD>
<TD align=center><form method="post" action="abo_maj_renouv.php"><input type="hidden" name="id" value="'.$id_renouv.'" />
<input type="submit" value="Modification Renouv."/></form></TD>
</TR>';
}
?>
</table>
</BODY>
</HTML>
