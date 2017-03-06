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
	$mail_utilisateur = $_GET['mail'];
	$requete = "select * from probleme where mail_individu_emetteur like '".$mail_utilisateur."' and ID_PB_PERE = ".$_GET['num']." and statut_traitement not like 'A' order by id_pb desc";
		//echo $requete;
		$resultat = mysql_query($requete);
		if (mysql_num_rows($resultat)>0)
					{
						$ligne = mysql_fetch_array($resultat);
						echo "<form method='POST' action='operation.php'>
							Description : <br /><textarea name='description' cols='50' rows='4'>".$ligne['texte']."</textarea>
							<input type='hidden' name='id_pb' value='".$ligne[0]."'";
						echo "<br /><input type='submit' name='modif_rep' value='Modifier'></form>";
					}
					else
					{
						Echo "La dernière réponse n'est pas de vous, ou il n'y a pas de réponse.<br /> <a href='Accueil_pers_ext.php'>Retour</a>";
					}
					?>
	</body>
	</html>