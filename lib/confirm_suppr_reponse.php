<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas la réponse">

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
				//test de récupération des données
				$idpb = $_GET['idpb'];
				$idrep = $_GET['idrep'];
				$tri = $_GET['tri'];
				
				if(!isset($idrep) || $idrep == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Identifiant de la réponse inexistant</B></FONT>";
					echo "<BR><BR><A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb."\" target = \"body\" class = \"bouton\">Retour au ticket</A>";
					exit;
				}
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				include("../biblio/fct.php");
				
				//Appel de la fonction pour supprimer une réponse
        suppr_t($idrep,sup_reponse);
				
				echo "<FONT COLOR = \"#808080\"><B>La réponse a été supprimée</B></FONT>";
				echo "<BR><BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb."\" target = \"body\" class = \"bouton\">Retour au ticket</A>";
				
				//Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
				
