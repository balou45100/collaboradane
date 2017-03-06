<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
?>

<!DOCTYPE HTML>
  
<!"Ce fichier supprime l'utilisateur quand on a selectionné oui dans le fichier delete_util.php">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
				<?php
										
					//Récupération des données de l'util à supprimer
					//La suppression d'un utilisateur se fait avec son nom et son mail
					$nom = $_GET['nom'];
					$mail = $_GET['mail'];
					if(!isset($nom) || !isset($mail) || $nom == "" || $mail == "")
					{
						echo "<FONT COLOR = \"#808080\"><B>Erreur de récupération des données</B></FONT><BR>";
						echo "<BR><BR><A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
						exit;
					}
					
					//Inclusion des fichiers nécessaires
					include ("../biblio/init.php");
					//Requète de suppression des catégories appartenant à l'utilisateur
					$query = "DELETE FROM categorie WHERE NOM_UTIL = '".$nom."' AND MAIL_UTIL = '".$mail."';";
					$results = mysql_query($query);
					//Dans le cas où aucun résultats n'est retourné
					if(!$results)
					{
						echo "<FONT COLOR = \"#808080\"><B>Problème de connection à la base de donnée ou problème avec la requète</B></FONT><BR>";
						echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
						mysql_close();
						exit;
					}
					else
					{
						$query1 = "DELETE FROM util WHERE NOM = '".$nom."' AND MAIL = '".$mail."';";
						$results1 = mysql_query($query1);
						if(!$results1)
						{
							echo "<FONT COLOR = \"#808080\"><B>Problème de connection à la base de donnée ou problème avec la requète</B></FONT><BR>";
							echo "<FONT COLOR = \"#808080\"><B>A ce stade les categories appartenant à l'utilisateur ".$nom." ont été supprimés, mais pas l'utilisateur!!</B></FONT><BR>";
							echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
							mysql_close();
							exit;
						}
						else
						{
							echo "<FONT COLOR = \"#808080\"><B>Utilisateur correctement supprimé</B></FONT><BR>";
							echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
						}
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
				?>
		</CENTER>
	</body>
</html>
