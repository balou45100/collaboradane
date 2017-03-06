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
	<table border = "1"  width = "80%">
		<tr>
			<td>ID</td>
			<td>ST</td>
			<td>Créé le</td>
			<td>Sujet</td>
			<td>Description</td>
		</tr>
		<?php
		$mail_utilisateur = $_GET['mail'];
		if(isset($_GET['archive']) and $_GET['archive'] == 1)
		{
			$and = " and statut_traitement like 'A'";
		}
		else
		{
			$and = " and statut_traitement not like 'A'";
		}
		$requete = "select * from probleme where mail_individu_emetteur like '".$mail_utilisateur."' and ID_PB_PERE = 0".$and." order by id_pb desc";
		//echo $requete;
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						$i = 1;
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo "	<tr>
										<td>".$ligne[0]."</td>
										<td>".$ligne['STATUT_TRAITEMENT']."</td>
										<td>".$ligne[7]."</td>
										<td>".$ligne[5]."</td>
										<td>".$ligne[6]."</td>";
										if (isset($_GET['archive']) and $_GET['archive'] == 1)
										{
										echo "<td>
										<a href='operation.php?desupr=1&num=".$ligne[0]."'>Désarchiver</a>
										</td>
										</tr>";
										}
										else
										{
									echo"
										<td>
										<a href='repondre.php?num_pere=".$ligne[0]."'>Répondre</a>
										</td>
										<td>
										<a href='Modif_reponse.php?num=".$ligne[0]."&mail=".$mail_utilisateur."'>Modifier dernière réponse</a>
										</td>
										<td>
										<a href='operation.php?supr=1&num=".$ligne[0]."'>Cloturer demande</a>
										</td>
										<td>
										<a href='voir_historique.php?num=".$ligne[0]."'>Historique demande</a>
										</td>										
									</tr>";
										}
						}
					}
		?>
		
		</table>
		<a href='Accueil_pers_ext.php'>Retour</a>
		