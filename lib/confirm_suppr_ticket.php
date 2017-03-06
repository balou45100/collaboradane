<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas le ticket">

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
				$id_categ = $_GET['id_categ']; //pour pouvoir repartir vers la gestion des catégories
				$origine = $_SESSION['origine']; //permet de savoir quel script appelle le script actuel
				$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
				$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
				$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
				if(!isset($idpb) || $idpb == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Identifiant du ticket inexistant</B></FONT>";
					switch ($origine)
				  {
            case 'gestion_ticket':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
         
            case 'gestion_categories':
              echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
				    
				    case 'fouille':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
				    
				    case 'repertoire_consult_fiche':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
				    
				    case 'ecl_consult_fiche':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
          }
          exit;
				}
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				include("../biblio/fct.php");
				
				//Nettoyage des catégories par rapport au ticket supprimé
				nettoie_categ($idpb,sup_ticket);
				
				//Appel de la fonction pour supprimer un ticket
        suppr_t($idpb,sup_ticket);
				
				echo "<FONT COLOR = \"#808080\"><B>Le ticket, les r&eacute;ponses, les alertes et les intervenants associ&eacute;s on &eacute;t&eacute; supprim&eacute;s</B></FONT>";
				
				switch ($origine)
				  {
            case 'gestion_ticket':
              echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la gestion des tickets\" border = \"0\"></A>";
				    break;
         
            case 'gestion_categories':
              echo "<BR><BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la gestion des catégories\" border = \"0\"></A>";
				    break;
				    
				    case 'fouille':
              echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la liste des tickets trouvés\" border = \"0\"></A>";
				    break;
				    
				    case 'repertoire_consult_fiche':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
				    
				    case 'ecl_consult_fiche':
              echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    break;
          }
				//Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
				
