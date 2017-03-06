<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
?>

<!DOCTYPE HTML>
  
<!"Ce fichier supprime l'établissement quand on a selectionné oui dans le fichier delete_etab.php">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
				<?php
					
					//Récupération des données de l'établissement à supprimer
					//La suppression d'un établissement se fait avec son nunméro RNE
					$rne = $_GET['rne'];
					if(!isset($rne) || $rne == "")
					{
						echo "<FONT COLOR = \"#808080\"><B>Erreur de récupération des données</B></FONT>";
						echo "<BR><BR><A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
						exit;
					}
					
					//Inclusion des fichiers nécessaires
					include ("../biblio/init.php");
					//Requète de suppression de l'utilisateur
					$query = "delete from etablissements where RNE = '".$rne."';";
					$results = mysql_query($query);
					//Dans le cas où aucun résultats n'est retourné
					if(!$results)
					{
						echo "<FONT COLOR = \"#808080\"><B>Problème de connection à la base de donnée ou problème avec la requète</B></FONT>";
						echo "<BR><BR><A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
					}
					else
					{
						echo "<FONT COLOR = \"#808080\"><B>Etablissement correctement supprimé<BR></B></FONT>";
						echo "<BR><BR><A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
				?>
		</CENTER>
	</body>
</html>
