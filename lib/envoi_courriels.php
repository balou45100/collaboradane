<?php
	session_start();
	$mail_emetteur = $_SESSION['mail'];
	$no_ticket = $_GET['no_ticket'];
	$origine = $_GET['origine'];

	/*
	echo "<br />envoi courriels - no_ticket : $no_ticket";
	echo "<br />envoi courriels - mail_emetteur : $mail_emetteur";
	echo "<br />envoi courriels - origine : $origine";
	*/
	
	include ("../biblio/config.php"); 
	include ("../biblio/init.php");
	include ("../biblio/fct.php");
	header('Content-Type: text/html;charset=UTF-8');

?>

<!DOCTYPE HTML>

<!"Ce fichier permet d'envoyer un mail a un établissement AUCUNE gestion des pièces jointes n'est faites">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
<CENTER>
<?php			
	//echo "<br />Envoi des courriels ...";
			
	//récupération des infos de l'emetteur
	$query_emetteur = "SELECT * FROM util WHERE MAIL = '".$mail_emetteur."';";
    $results_emetteur = mysql_query($query_emetteur);
    $ligne=mysql_fetch_object($results_emetteur);
	$nom=$ligne->NOM;
	$prenom=$ligne->PRENOM;
	$sexe=$ligne->SEXE;
	
	/*
	echo "<BR>Nom : $nom";
	echo "<BR>Prénom : $prenom";
	echo "<BR>Sexe : $sexe";
	echo "<BR>no_ticket : $no_ticket";
	*/
	
	//récupération des infos du ticket
	$query_ticket = "SELECT * FROM probleme WHERE ID_PB = '".$no_ticket."';";
    $results_ticket = mysql_query($query_ticket);
    $ligne_ticket=mysql_fetch_object($results_ticket);
	$date_crea=$ligne_ticket->date_crea;
	$contenu=$ligne_ticket->NOM;

	/*
	echo "<BR>date_crea : $date_crea";
	echo "<BR>contenu : $contenu";
	*/        	
	//Transformation de la date de création extraite pour l'affichage
	$date_de_creation_converti = strtotime($date_crea);
	$date_de_creation_converti = date('d/m/Y',$date_de_creation_converti);

	//echo "<BR>date_de_creation_converti : $date_de_creation_converti";

					
	//On récupère les intervenants de la table intervenant_ticket
	$intervenants = extraction_intervenants_ticket($no_ticket);

  	//Composition du message à envoyer
    $sujet = "[GT"." N° ".$no_ticket." du ".$date_de_creation_converti."] ".$sujet;
   	$entete = 'Mime-Version: 1.0'."\r\n";
	$entete .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$entete .= 'From: collaboradane\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/';
	$entete .= "\r\n";

   	//$entete="From: collaboradane\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
		        
   	$contenu_a_envoyer="- Ticket créé par ".$prenom." ".$nom;
   	$contenu_a_envoyer=$contenu_a_envoyer."
- Intervenant(s) : $intervenants
- Description : ".$contenu;
						  $contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$no_ticket."
(il faut être connecté-e, les cookies de session ne sont pas gérés)";
              
            
 	//envoi d'un message aux intervenants
   	$pb_array = explode(';', $intervenants);
	$taille = count($pb_array);
	//echo "<BR>nombre d'intervenants : $taille";
	for($j = 0; $j<$taille; ++$j)
	{
		//echo "<br />intervenant $j : $pb_array[$j]";
		$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
		$results_util = mysql_query($query_util);
		$ligne=mysql_fetch_object($results_util);
		$destinataire=$ligne->MAIL;

		$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
		echo "<br />Message envoy&eacute; &agrave; $destinataire";
	}
	//echo "<br />intervenants : $intervenants";
						
					echo "<FONT COLOR = \"#808080\"><B><br />Les intervenants ont été ajouté et les courriels envoyé</B></FONT>";
					if ($origine == "gest_ticket")
					{
						echo "<FORM ACTION = \"gestion_ticket.php\" METHOD = \"GET\">";
							echo "<INPUT TYPE = \"submit\" VALUE = \"Retour à la gestion des tickets\">";
						echo "</FORM>";
            		}
            		elseif ($origine == "ecl_consult_fiche")
	            	{
						echo "<FORM ACTION = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							echo "<INPUT TYPE = \"submit\" VALUE = \"Retour à la fiche\">";
						echo "</FORM>";
        	    	}
            		else
            		{
 						echo "<FORM ACTION = \"gestion_ecl.php\" METHOD = \"GET\">";
							echo "<INPUT TYPE = \"submit\" VALUE = \"Retour\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
						echo "</FORM>";
            		}

/*

					if ($origine == "gest_ticket")
					{
        	      		echo "<BR><BR> <A HREF = \"gestion_ticket.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
            		}
            		elseif ($origine == "ecl_consult_fiche")
	            	{
    	          		echo "<BR><BR> <A HREF = \"ecl_consult_fiche.php\" class = \"bouton\">Retour à la fiche</A>";
        	    	} //test pour vérifeier l'envoi de message
            		else
            		{
              			echo "<BR><BR> <A HREF = \"gestion_ecl.php?origine=verif_ticket&amp;rechercher=$rechercher&amp;indice=$indice\" class = \"bouton\">Retour</A>";
            		}
*/
			?>
		</CENTER>
	</body>
</html>
