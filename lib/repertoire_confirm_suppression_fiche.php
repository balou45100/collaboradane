<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas la fiche du repertoire">

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
				$id_societe = $_GET['id_societe'];
				$origine = $_SESSION['origine'];
				
				if(!isset($id_societe) || $id_societe == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Identifiant du ticket inexistant</B></FONT>";
					echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				  exit;
				}
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				include("../biblio/fct.php");
				
				//Suppression de la fiche
				$query_suppression = "DELETE FROM repertoire WHERE No_societe = '".$id_societe."';";
			  $result = mysql_query($query_suppression);
				
				//Dans le cas où aucun résultats n'est retourné
				if(!$result)
			 	{
				  echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
				  mysql_close();
				  //exit;
				}
				
        //"Nettoyage des contacts en supprimant les référence d'appartenance à la fiche supprimée
        $query_contact = "SELECT DISTINCT * FROM contacts WHERE ID_SOCIETE = $id_societe;";
		    $results_contact = mysql_query($query_contact);
		    $num_results_contact = mysql_num_rows($results_contact);
        $contact_extrait = mysql_fetch_row($results_contact);
        
        //echo "<BR>nombre de contacts : $num_results_contact<BR>";
        
        if(!$results_contact)
			 	{
				  echo "<FONT COLOR = \"#808080\"><B>Erreur de connexion à la base de données ou erreur de requète pour accéder aux contacts de la fiche $id_societe</B></FONT>";
				  mysql_close();
				  //exit;
				}
				else
				{
          
          for ($i = 0; $i < $num_results_contact; ++$i)
				  {
            //echo "<BR>contact_extrait : $contact_extrait[0]<BR>";
            //On met à jour le champ id_societe
            $query_maj = "UPDATE contacts SET
                ID_SOCIETE = '0'
              WHERE ID_CONTACT = '".$contact_extrait[0]."';";
				
            $results_maj = mysql_query($query_maj); 
            $contact_extrait = mysql_fetch_row($results_contact);
          }
          
				}
				echo "<FONT COLOR = \"#808080\"><B>La fiche a été supprimée, les contacts rattachés à cette fiche ont été réinitialisés</B></FONT>";
				
				echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la gestion des tickets\" border = \"0\"></A>";
				
        //Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
				
				
