<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
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
			include ("../biblio/fct.php");
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
						echo "<FONT COLOR = \"#808080\"><B>Problème non référencé dans la base de donnée</B></FONT>";
						switch ($origine)
				    {
             case 'gestion_ticket':
              echo "<BR><A HREF = ".$origine.".php?tri=$tri&amp;indice=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
         
             case 'gestion_categories':
              echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
				      
				     case 'fouille':
              echo "<BR><A HREF = ".$origine.".php?a_chercher=$a_chercher&amp;ou=$ou><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
            }
          exit;
					}
					
					//Inclusion des fichiers nécessaires
					include ("../biblio/init.php");
					
					//récupération des données concernant le ticket pour les renseignements nécessaires à l'envoi des messages
				  //---------------------------------------------------------------------------------------------------------
				  $query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
				  $result_consult = mysql_query($query);
				
				  //Dans le cas où aucun résultats n'est retourné
				  if(!$result_consult)
				  {
					 echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée ou problème inexistant</B></FONT>";
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
                echo "<BR><A HREF = ".$origine.".php<img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				      break;
           }
           mysql_close();
					 exit;
				  }
				
				  $res_ticket = mysql_fetch_row($result_consult);
				  $sujet = $res_ticket[5];
				  $contenu = $res_ticket[6];
				  $intervenant = $res_ticket[10];
				  $date_creation = $res_ticket[7];
				  $mail_emetteur = $res_ticket[2];
				  //---------------------------------------------------------------------------------------------------------
				  
					
					//Requète pour l'archivage d'un dossier
					$query_archi = "UPDATE probleme SET
					DATE_ARCHI = '".date('j/m/Y')."',
					STATUT_TRAITEMENT = 'F',
					PRIORITE = '2',
					STATUT = 'A'
					WHERE ID_PB = '".$idpb."';";
					
					$results_archi = mysql_query($query_archi);
					//Dans le cas où aucun résultats n'est retourné
					if(!$results_archi)
					{
						echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
						switch ($origine)
				    {
             case 'gestion_ticket':
              echo "<BR><A HREF = ".$origine.".php?tri=$tri&amp;indice=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
         
             case 'gestion_categories':
              echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
				      
				     case 'fouille':
              echo "<BR><A HREF = ".$origine.".php?a_chercher=$a_chercher&amp;ou=$ou><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
            }
          }
					else
					{
						echo "<FONT COLOR = \"#808080\"><B>Les données du ticket ont bien été archivés</B></FONT>";
						
						//On envoie un message aux intervenants
                $sujet = "[GT - ARCHIVAGE DU TICKET N° ".$idpb." du ".$date_creation."] ".$sujet;
		            $entete="From: gestion_ticket\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
		        
              //Composition du message à envoyer
              $contenu_a_envoyer="Le ticket a été traité et archivé
- contenu : ".$contenu;
            
              //envoi d'un message aux intervenants
              $pb_array = explode(';', $intervenant);
				      $taille = count($pb_array);
				      //echo "<BR>nombre d'intervenants : $taille";
							for($j = 0; $j<$taille; ++$j) {
                //echo "<BR>intervenant $j : $pb_array[$j]";
                $query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
                $results_util = mysql_query($query_util);
                $ligne=mysql_fetch_object($results_util);
		            $destinataire=$ligne->MAIL;
		          
                $ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
              }
              echo "<h2>Un message à été envoyé aux intervenants</h2>";
            
//////////// Suppression des alertes concernant le ticket archivé
							suppression_alertes($idpb);
///////////////////////////////////////////////////////////////////////////////////////////
            switch ($origine)
				    {
             case 'gestion_ticket':
              echo "<BR><A HREF = ".$origine.".php?tri=$tri&amp;indice=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
         
             case 'gestion_categories':
              echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
				      
				     case 'fouille':
              echo "<BR><A HREF = ".$origine.".php?a_chercher=$a_chercher&amp;ou=$ou><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				     break;
            }
          }
					//Fermeture de la connexion à la BDD
					mysql_close();
				?>
		</CENTER>
	</body>
</html>
