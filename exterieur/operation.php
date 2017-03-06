<?php
	//Lancement de la session
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");?>
	<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="feuille.css" rel="stylesheet" type="text/css">
		</head>
	<body>
	
	<?php
	if(isset($_GET['supr']))
	{
	$requete = "update probleme
				set statut_traitement = 'A'
				where id_pb = ".$_GET['num'];
		echo $requete;
		$resultat = mysql_query($requete);
					if ($resultat)
					{	
						echo"La demande numéro ".$_GET['num']." à bien été archivée.";
					}
	}
	if(isset($_GET['desupr']))
	{
	$requete = "update probleme
				set statut_traitement = 'N'
				where id_pb = ".$_GET['num'];
		echo $requete;
		$resultat = mysql_query($requete);
					if ($resultat)
					{	
						echo"La demande numéro ".$_GET['num']." à bien été desarchivée.";
					}
	}
	if(isset($_POST['modif_rep']))
	{
	$requete = "update probleme
				set texte = '".$_POST['description']."'
				where id_pb = ".$_POST['id_pb'];
		echo $requete;
		$resultat = mysql_query($requete);
					if ($resultat)
					{	
						echo"La réponse ".$_GET['num']." à bien été modifiée.";
					}
	}
	
if(isset($_POST['repondre']))
	{	
	$requete = "select max(id_pb)
			from probleme";
$resultat = mysql_query($requete);
$ligne = mysql_fetch_array($resultat);
$id_pb=$ligne[0]+1;
$id_pb_pere = $_POST['id_pb_pere'];
$mail=$_POST['mail'];
$nom=$_POST['nom'];
$rne=$_POST['rne'];
$niv1=$_POST['niv1'];
$desc=$_POST['description'];
$date=$_POST['date'];
//Recuperation du titre
	$requete = "select nom
			from probleme
			where id_pb = $id_pb_pere";
			$resultat = mysql_query($requete);
			$ligne = mysql_fetch_array($resultat);
$titre = $ligne[0];
	
$requete = "insert into probleme (id_pb, mail_individu_emetteur, nom_individu_emetteur, num_etablissement, nom, texte, date_creation, module, statut_traitement, statut, id_pb_pere)
			values ($id_pb, '$mail','$nom','$rne','$titre','$desc','$date','EXT', 'N', 'R', $id_pb_pere)";
$resultat = mysql_query($requete);
//echo $requete;
if ($resultat)
{
	echo"La réponse a été enregistrée sous le numéro $id_pb <br />";
}
else
{
	echo"Erreur lors de l'ajout";
}
}
	?>
	
		<a href='Accueil_pers_ext.php'>Retour</a>
	
	</body>
	</html>