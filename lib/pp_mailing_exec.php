<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	
	include ("../biblio/fct.php");
	include ("../biblio/config.php");	
	include ("../biblio/init.php");
	include_once("../fckeditor/fckeditor.php");
//ini_set('sendmail_from', 'gregory.lapeyre@laposte.net');
?>
<html>
  <head>
    <title>FCKeditor - Sample</title>
  </head>
  <body>
<?php
if (isset($_SESSION['code_etab']))
{
echo"<a href='#bas'>Allez directement en bas de page</a>";
}
/*foreach( $_SESSION['liste_destinataire'] as $valeur)
{
echo "/////////////////////////////////////////////////////////////////";
$message = $_SESSION['message'];
$message = str_replace("*civil*", $valeur->civilite, $message);
$message = str_replace("*nom*", $valeur->nom, $message);
$message = str_replace("*prenom*", $valeur->prenom, $message);
echo $message;
}*/
$_SESSION['Derniere_ligne2'] = 0;
foreach( $_SESSION['liste_destinataire'] as $valeur)
{
if (isset($_SESSION['code_etab']))
{
//Si le code etablissement est mis, on génère une deuxieme liste de contact avec les codes etablissement
$requete = "select distinct TYPE_ETAB_GEN, NOM, RNE, mail
										from etablissements
										where RNE like '".$valeur->codetab."'";
				$resultat = mysql_query($requete);
				while($ligne=mysql_fetch_array($resultat))
				{
				$_SESSION['liste_destinataire2'][$_SESSION['Derniere_ligne2']]->mail = $ligne[3];
				$_SESSION['liste_destinataire2'][$_SESSION['Derniere_ligne2']]->nom = $ligne[0]." ".$ligne[1];
				$_SESSION['liste_destinataire2'][$_SESSION['Derniere_ligne2']]->prenom = "";
				$_SESSION['liste_destinataire2'][$_SESSION['Derniere_ligne2']]->civilite = "";				
				$_SESSION['liste_destinataire2'][$_SESSION['Derniere_ligne2']]->codetab = $ligne[2];
				$_SESSION['Derniere_ligne2']++;
				}
}
//On récupère le destinataire actuel
$destinataire = $valeur->mail;
//On récupère l'objet du mail
$objet = $_SESSION['objet'];
//Le message
$message = $_SESSION['message'];
//On remplace les "champs" par la valeur associée au mail
$message = str_replace("*civil*", $valeur->civilite, $message);
$message = str_replace("*nom*", $valeur->nom, $message);
$message = str_replace("*prenom*", $valeur->prenom, $message);
//On précise que c'est du html et on ajoute l'adresse de réponse
if ($_POST['adr_reponse'] =="")
{
$adresse_rep = $_SESSION['mail'];
}
else
{
$adresse_rep = $_POST['adr_reponse'];
}

$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: Mission TICE <$adresse_rep>" . "\r\n";


//$headers = "Content-type:text/html; charset=utf-8; Reply-To: ".$adresse_rep;
//$headers="Content-type:text/html; charset=utf-8; From: collaboratice; Reply-To: $adresse_rep; X-Mailer: PHP/";

if(mail($destinataire,$objet,$message,$headers))
{
	echo "Le mail pour $destinataire à bien été envoyé <br />";
}
else
{
	echo "<b><font color='red'>Le mail pour $destinataire n'a pas été envoyé, une erreur est survenue</font></b><br />";
}
}
echo"<a name='bas'></a>";
echo"<a href='pp_mailing.php?etab=1'>Envoyer un mail aux établissement</a><br />";
echo"<a href='pp_mailing.php'>Retour à l'envois de mail</a>";

?>
      <br>
    </form>
  </body>
</html>
