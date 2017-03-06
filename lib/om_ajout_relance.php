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
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8859-1\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
$recupOM=$_POST["REFOM"];

$requete="SELECT * FROM om_ordres_mission, personnes_ressources_tice, om_suivi_om where om_ordres_mission.id_pers_ress=personnes_ressources_tice.id_pers_ress and om_suivi_om.RefOM=om_ordres_mission.RefOM and om_ordres_mission.RefOM='$recupOM' ;";
$result=mysql_query($requete);
$ligne=mysql_fetch_assoc($result);

$recup=$ligne["mel"];
$destinataire = $recup;
$expediteur = 'jurgen.mendel@ac-orleans-tours.fr';
$reponse = $expediteur;
$C=$ligne['civil'];
$nom=$ligne['nom'];
$pren=$ligne['prenom'];
$OM=$ligne['RefUlysse_om'];
$REF=$ligne['RefOM'];

echo "<center>Envoi d'un mail à $C $nom $pren<BR /><BR />
Concernant l'OM n° $OM</center><BR />";

echo'<center><FORM method=post>
Objet du message :<BR />
<textarea name="objet" cols=50 rows=1 wrap=physical>OM n° '.$OM.'</textarea><BR />
<BR />
Contenu du message :<BR />
<textarea name="message" cols=50 rows=7 wrap=physical></textarea>
<BR /><BR />
<input type="hidden" name="REFOM" value="'.$REF.'" />
<input type="submit" name="Envoi" value="Envoi" />
</FORM></center>';

if(isset($_POST["Envoi"])){
$message=$_POST["message"];
$objet=$_POST["objet"];
$DATE=date("Y/m/d");

mail($destinataire, $objet , $message , "From : $expediteur\r\nReply-To : $reponse");


$requete_R="INSERT INTO om_relance VALUES ('',$recupOM,$DATE) ;";
$result_R=mysql_query($requete_R);

if($result_R){
echo'La relance a bien été enregistré dans la table om_relance.';
}else{
echo"erreur de l'ajout de la relance dans la table om_relance.";
}
}

echo'<center><FORM method=post action="om_affichage_om.php">
<input type=submit name="Retour" value="Retour Liste OM" />
</FORM></center>';



?>
</body>
</HTML>
