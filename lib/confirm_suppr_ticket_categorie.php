<?php
	session_start();
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas la catégorie d'un ticket">

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
				$id_categ = $_GET['id_categ'];
				$nom_categ = $_GET['nom_categ'];
				$tri = $_GET['tri'];
				$origine = $_GET['origine'];
				
				/*
				echo "<BR>confirme_suppr_ticket_categ : N° ticket : $idpb";
				echo "<BR>Catégorie : $id_categ";
				echo "<BR>Nom catégorie : $nom_categ";
				*/
					if(!isset($idpb) || $idpb == "" ||!isset($id_categ) || $id_categ == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Identifiant du ticket inexistant</B></FONT>";
					echo "<BR><BR><A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class = \"bouton\">Retour à la Gestion des catégories</A>";
					exit;
				}
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				include("../biblio/fct.php");
				
				//Suppression d'une catégorie d'un ticket
				sup_ticket_categ($idpb,$id_categ);
				
				echo "<FONT COLOR = \"#808080\"><B>Le ticket N° ".$idpb." a été enlevé de la catégorie ".$nom_categ."</B></FONT>";
				
				switch ($origine)
				{
          case 'gestion_ticket':
            echo "<BR><A HREF = ".$origine.".php?tri=$tri&amp;indice=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				  break;
         
          case 'gestion_categories':
            echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				  break;
        }
        
        //Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
				
