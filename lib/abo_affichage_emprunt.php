<?php
	session_start();
	include("../biblio/config.php");
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
	$page_appelant = "emprunt";
	echo "<div align = \"center\">";
	include("../biblio/init.php");
	include("abo_menu_principal.inc.php");
?>
<H2>Liste des emprunts en cours</H2>
<table border>
<TR>
<th>Titre</th>
<th>Personnes ayant emprunt&eacute; le titre</th>
<th>Date de l'emprunt</th>
<th>Date de fin de l'emprunt</th>
<th>Rendu</th>
<th>Action</th>
</TR>
<?php
$requete_mag="SELECT * , DATE_FORMAT(Date_emprunt, '%d-%m-%Y') AS Date_emprunt2, DATE_FORMAT(Date_fin_emprunt, '%d-%m-%Y') AS Date_fin_emprunt2 FROM abo_abonnement, abo_magazine, abo_emprunt, personnes_ressources_tice WHERE abo_emprunt.NoMag=abo_magazine.NoMag and abo_magazine.NoAbo=abo_abonnement.NoAbo and personnes_ressources_tice.id_pers_ress=abo_emprunt.id_pers_ress ;";
$result_mag=mysql_query($requete_mag);
while($ligne_mag=mysql_fetch_assoc($result_mag)){
echo'<TR>
<TD align=center>'.$ligne_mag["Nom_mag"].'</TD>
<TD align=center>'.$ligne_mag["nom"].' '.$ligne_mag["prenom"].'</TD>
<TD align=center>'.$ligne_mag["Date_emprunt2"].'</TD>
<TD align=center>'.$ligne_mag["Date_fin_emprunt2"].'</TD>';
if($ligne_mag["Rendu"]=='1'){
echo'<TD align=center>Oui</TD>';
}else{
echo'<TD align=center>Non</TD>';
}
echo'<TD align=center>
<form method="post" action="abo_maj_emprunt.php">
<input type="hidden" name="emprunt" value="'.$ligne_mag["id_emprunt"].'" />
<input type="submit" name="majE" value="Modifier" />
</form>
</TD>
</TR>';
}
?>
</table>
</div>
</BODY>
</HTML>
