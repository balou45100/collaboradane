<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	//unset($_SESSION['url']);
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		</head>
	<body>
	
<?php 
	//On vérifie quel formulaire à été envoyé
	//On suppose que le post existe car on n'atteint cette page que via le submit
	
	//On vérifie qui envoie
	$cree_par = $_SESSION['id_util'];
	
	//echo "<br />cree_par : $cree_par";
	
	if(isset($_POST['sortant'])) //Contenu du bouton envoyer du précédent formulaire
	{
		$type = "sortant";
	}
	else
	{
		$type = "entrant";
	}
	
	$date_arrive = strtotime($_POST['date_arrive']);
	$date_courrier = strtotime($_POST['date_courrier']);
	if ($date_arrive < $date_courrier)
	{
		echo "La date d'arriv&eacute;e est ant&eacute;rieure &agrave; la date de cr&eacute;ation du courrier, ajout impossible";
	}
	else
	{
	$requete = "INSERT INTO courrier
				VALUES ('".$type."',".$_POST['num_enr'].", '".$_POST['date_arrive']."', '".$_POST['date_courrier']."', '".$_POST['expediteur']."', '".$_POST['destinataire']."','".$_POST['description']."', '".$_POST['categorie']."', '".$_POST['annee_scolaire']."', '".$cree_par."', '".$_POST['confidentiel']."','')";
	
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);	

		foreach ($_POST['concerne'] as $valeur)
		{
		$requete = "INSERT INTO courrier_concerne
				VALUES ('".$type."',".$_POST['num_enr'].", '".$_POST['annee_scolaire']."', ".$valeur.")";
				
		$resultat = mysql_query($requete);
		}	
	if ($resultat)
	{	
		echo "Le courrier numéro ".$_POST['num_enr']." a été enregistré<br />";
		echo "Resume : <br />
			Date d'arrivée : ".$_POST['date_arrive']." <br />
			Date de création : ".$_POST['date_courrier']." <br />
			Expediteur : ".$_POST['expediteur']."<br />";
			echo "Destinataire : ".$_POST['destinataire']." <br />";
			echo "Description : ".$_POST['description']." <br />";
			echo "confidentiel : ".$_POST['confidentiel']." <br />";
			echo "cr&eacute;e par : ".$cree_par;
	}
	else
	{
		echo"L'enregistrement à echoué";
	}
	}
?>
	<br />
	<a href="gc_saisie.php">Retour à la saisie de courrier</a>
	</body>
</html>
