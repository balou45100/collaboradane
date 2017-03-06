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
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		</head>
	<body>
	<?php
	$type=$_GET['type'];
	$num=$_GET['num'];
	$annee=$_GET['annee'];
	$i=0;
	$_SESSION['liste_destinataire'] = array();
	$requete = "select c.id_util, nom, prenom, sexe, mail
				from courrier_concerne c, util u
				where  c.id_util = u.id_util
				and type like '".$type."'
				and num_enr = ".$num."
				and annee_scolaire like '".$annee."'";
		$resultat = mysql_query($requete);
		while ($ligne=mysql_fetch_array($resultat))
		{
		$_SESSION['liste_destinataire'][$i]->mail = $ligne[4];
		$_SESSION['liste_destinataire'][$i]->nom = $ligne[1];
		$_SESSION['liste_destinataire'][$i]->prenom = $ligne[2];
		$_SESSION['liste_destinataire'][$i]->civilite = $ligne[3];
		$i++;
		}
		$_SESSION['objet'] = "Courrier";
		$_SESSION['message'] = "Un courrier concernant *civilite* *prenom* *nom* est arrivé, veuillez vous rendre au secrétatiat au 5ème étage";
		echo "Envoyer un courrier aux personnes concernées ?
	<br /><a href='pp_cadre_mailing.php' target='_blank'>Envoyer</a>";
		
	?>
	</body>
</html>
