<?php
	//Lancement de la session
	session_start();
	error_reporting(0);
	
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
			//include("../biblio/ticket.css");
			//include ("../biblio/config.php");
	echo "</head>
	<body>
		<div align = \"center\">";
		//echo "<br />Avant init.php dans consult_ticket.php"; 
		//Inclusion des fichiers n&eacute;cessaires
		include("../biblio/init.php");
		include ("../biblio/fct.php");
		include ("../biblio/config.php"); //pour r&eacute;cup&eacute;rer les couleurs pour le tableau

		//R&eacute;cup&eacute;ration des variables n&eacute;cessaires
		$CHGMT = $_GET['CHGMT']; //Indique si un changement est intervenu lors du formulaire en fin der fichier
		$idpb = $_GET['idpb']; //n&eacute;cessaire pour la consultation des tickets
		//$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
		$id_categ = $_GET['id_categ']; //pour pouvoir repartir vers la gestion des cat&eacute;gories
		$origine = $_SESSION['origine']; //permet de savoir quel script appelle le script actuel
		$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
		$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
		//$indice = $_GET['indice']; //recup&egrave;re l'indice de la page où se trouve lhttp://mission.tice.ac-orleans-tours.fr/collaboraticee ticket
		$id_societe = $_SESSION['id_societe']; //n&eacute;cessaire en arrivant du r&eacute;pertoire
		//$dans = $_GET['dans']; //n&eacute;cessaire en arrivant du r&eacute;pertoire
		//$rechercher = $_GET['rechercher']; //n&eacute;cessaire en arrivant du r&eacute;pertoire
		//$sense_tri = $_GET['sense_tri']; //n&eacute;cessaire en arrivant du r&eacute;pertoire
		$origine_gestion = $_SESSION['origine_gestion']; //n&eacute;cessaire en arrivant du r&eacute;pertoire
		$action = $_GET['action']; //pour savoir s'il faut faire quelque chose avant d'afficher le ticket
		$categorie_commune = $_GET['categorie_commune']; //permet de retourner &agrave; l'affichage des tickets dans des cat&eacute;gories communes
		$ajouter_alerte = $_GET['ajouter_alerte']; //si "O" on affiche le formulaire de saisie de l'alerte
		$bouton = $_GET['bouton'];
		//$action2 = $_POST['action'];

		/*
		echo "<br />1 - action : $action";
		echo "<br />1 - bouton : $bouton";
		//echo "<br />origine : $origine";
		*/

		if (!ISSET($action))
		{
			$action = $_POST['action'];
		}
		if ($action == "Valider les modifications")
		{
			$action = "confirmation_modif_alerte";
		}

		//echo "<br />2 - action : $action";
/*
        if ($actions == "depot_fichier")
        {
          $action = $actions;
        }
*/
		//$filtre = $_GET['filtre'];
		//$affiche_tickets = $_GET['affiche_tickets'];

		//echo "<br />origine_gestion : $origine_gestion - origine : $origine";
		//echo "<br />changment : $CHGMT";
		//echo "<br />action : $action";
		//echo "<br />indice : $indice";
		//R&eacute;cup&eacute;ration de l'id de la cat&eacute;gorie quand celui-ci est selectionn&eacute;
		//La pr&eacute;sence du @ permet de ne pas faire afficher l'erreur dont &agrave; la consultation
		//En effet lors de la consultation aucune variable n'est envoy&eacute;
		//C'est juste lors de la selection dans la consultation d'une categorie que cette variable devient
		//Effective par r&eacute;currence
		@$categorie = $_GET['categorie'];
		@$categorie_commune = $_GET['categorie_commune'];
		//echo "<br />categorie : $categorie";
		//echo "<br />categorie_commune : $categorie_commune<br />";
		if (ISSET($idpb)) //Cela permet de retrouver la bonne fiche quand on revient d'un autre script
		{
			$_SESSION['idpb'] = $idpb;
		}
		else
		{
			$idpb = $_SESSION['idpb'];
		}

		//echo "<br />idpb : $idpb";
		
		switch($action)
		{
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////Script pour le dépôt de fichier sur le serveur
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
			case 'ajout_document' :
				$script = "consult_ticket";
				$ticket= $_GET['ticket'];
				$creepar = $_GET['creepar'];
				$creele = $_GET['creele'];
				$intervenants = $_GET['intervenants'];
				$sujet = $_GET['sujet'];
				$etab = $_GET['etab'];
				$contact = $_GET['contact'];
				$typecontact = $_GET['typecontact'];
				$module = $_GET['module'];

				//echo "<h2>D&eacute;pôt de fichier sur le serveur pour le ticket $idpb</h2>";
				$affichage = "N"; // pour &eacute;viter que le ticket s'affiche
				include ("choix_fichier.inc.php");
				//echo "<br />upload : $upload - nom_fichier : $nom_fichier<br />";
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
			case 'depot_fichier' : //ne fonctionne pas pour l'instant
/*
				$nom_fichier = $_POST["nom_fichier"]; //r&eacute;cup&eacute;ration du nom du fichier
				$idpb = $_POST['idpb'];
				$nom_doc = $_POST['nom_doc'];
				$fichier = $_POST['fichier'];
				$dossier="../data/gt/"; // on fix le dossier pour le d&eacute;pôt
*/
				echo "<br />je d&eacute;pose le fichier";
				$affichage = "N"; // pour &eacute;viter que le ticket s'affiche
				include ("uploader.inc.php");
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////Fin du script pour le dépôt de fichier sur le serveur
////////////////////////////////////////////////////////////////////////////////////////////////////////				  

////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////Début du script pour la gestion des alertes
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
			case 'ajout_alerte' : 
				enreg_utilisation_module("ALE");
				include ("consult_ticket_ajout_alerte.inc.php");
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
			case 'modif_alerte' :
				include ("consult_ticket_modif_alerte.inc.php");
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
			case 'confirmation_modif_alerte' : 
				include ("consult_ticket_confirmation_modif_alerte.inc.php");
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////
			case 'supprimer_alerte' : 
				include ("consult_ticket_supprimer_alerte.inc.php");
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////
			case 'confirmation_supprimer_alerte' : 
				$id_util = $_SESSION['id_util'];
				//On demande confirmation
				$requete_suppression = "DELETE FROM `alertes` WHERE `alertes`.`id_ticket` =".$idpb." AND `alertes`.`id_util` = ".$id_util.";";
				
				//echo "<br />requete_suppression : $requete_suppression";
				
				$resultat_suppression = mysql_query($requete_suppression);
				if(!$resultat_suppression)
				{
					echo "<br />Erreur";
				}
				else
				{
					echo "<br />L'alerte a &eacute;t&eacute; supprim&eacute;e.";
				}
			break;
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////Fin du script pour la gestion des alertes
////////////////////////////////////////////////////////////////////////////////////////////////////////				  
		} //fin du switch action

		//enregistrement du changement du statut du traitement, de l'intervenant et / ou de la priorité
		if($CHGMT=="O")
        {
			$STATUT_TRAITEMENT = $_GET['STATUT_TRAITEMENT'];
			$PRIORITE_SELECTION = $_GET['PRIORITE_SELECTION'];
			$A_FAIRE = $_GET['A_FAIRE'];
			$TRAITE_PAR = $_GET['TRAITE_PAR'];
			$STATUT = $_GET['STATUT'];
			$priorite_dans_base = $_GET['priorite_dans_base'];
			$statut_traitement_dans_base = $_GET['statut_traitement_dans_base'];
			$statut_dans_base = $_GET['statut_dans_base'];
			$relance = $_GET['relance'];
			$upload = $_GET['upload'];  //pour savoir si on d&eacute;pose un fichier sur le serveur
			$nom_fichier = $_GET['nom_fichier']; // le nom du fichier &agrave; d&eacute;poser sur le serveur
			$dossier = $_GET['dossier']; // le dossier où il faut d&eacute;poser le fichier sur le serveur

			//r&eacute;cup&eacute;ration des donn&eacute;es concernant le ticket pour les renseignements n&eacute;cessaires &agrave; l'envoi des messages
			//---------------------------------------------------------------------------------------------------------
			$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
			$result_consult = mysql_query($query);

			//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
			if(!$result_consult)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
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
			$nom_individu_emetteur = $res_ticket[3];
			//echo "<br />mail_emetteur : $mail_emetteur";
			//---------------------------------------------------------------------------------------------------------
			//echo "<br />relance : $relance";

			//traduction des champs statut_traitement et Statut de la version verbeux en abbr&eacute;viations
			switch ($STATUT_TRAITEMENT)
			{
				case "nouveau ticket":
					$STATUT_TRAITEMENT = "N";
					$classe_fond2 = "nouveau";
				break;

				case "traitement en cours":
					$STATUT_TRAITEMENT = "C";
					$classe_fond2 = "en_cours";
				break;

				case "ticket transf&eacute;r&eacute;":
					$STATUT_TRAITEMENT = "T";
					$classe_fond2 = "transfere";
				break;

				case "ticket en attente":
					$STATUT_TRAITEMENT = "A";
					$classe_fond2 = "attente";
				break;

				case "ticket &agrave; archiver":
					$STATUT_TRAITEMENT = "F";
					$classe_fond2 = "acheve";
				break;
			}

			switch ($STATUT) 
			{
				case "en cours":
					$STATUT = "N";
				break;

				case "modifi&eacute;":
					$STATUT = "M";
				break;
            
				case "archiv&eacute;":
					$STATUT = "A";
				break;
			}

			switch ($PRIORITE_SELECTION) 
			{
				case "Normal":
					$PRIORITE_SELECTION = "2";
					$fond_priorite = "priorite_normale";
				break;

				case "Basse":
					$PRIORITE_SELECTION = "3";
					$fond_priorite = "priorite_basse";
				break;

				case "Haute":
					$PRIORITE_SELECTION = "1";
					$fond_priorite = "priorite_haute";
				break;

			}

          
			//Test si les variables ont &eacute;t&eacute; modifi&eacute;es dans le formulaire
          
			/*
			echo "<br />priorit&eacute; dans base : $priorite_dans_base";
			echo "<br />priorit&eacute; reçu du formulaire : $PRIORITE_SELECTION";
			echo "<br />statut traitement dans base : $statut_traitement_dans_base";
			echo "<br />statut traitement reçu du formulaire : $STATUT_TRAITEMENT";
			echo "<br />statut dans base : $statut_dans_base";
			echo "<br />statut reçu du formulaire : $STATUT";
			echo "<br />sujet : $sujet";
			echo "<br />Contenu : $contenu";
			echo "<br />intervenant(s) : $intervenant";
			echo "<br />date de cr&eacute;ation : $date_creation";
			*/
///////////////////////////////////////////////////////////////////////////////////////////
///////////// La priorit&eacute; du ticket est pass&eacute;e &agrave; heute, il faut envoyer un message aux intervenants
///////////////////////////////////////////////////////////////////////////////////////////
			if ($PRIORITE_SELECTION <> $priorite_dans_base)
			{
				//la priorit&eacute; a chang&eacute;
				if ($PRIORITE_SELECTION == "1")
				{
					//On r&eacute;cup&egrave;re la liste des intervenants
					$intervenants = extraction_intervenants_ticket($idpb);
					//Changement vers une priorit&eacute; haute, il faut envoyer un message aux intervenants
					$sujet = "[GT - Priorit&eacute; HAUTE -"." N° ".$idpb." du ".$date_creation."] ".$sujet;
					$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

					//Composition du message &agrave; envoyer
					$contenu_a_envoyer="LA PRIORITE DU TICKET EST PASSEE A 'HAUTE'
              
- Intervenant(s) : $intervenants
- Contenu : ".$contenu;
					$contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$idpb."
(il faut être connect&eacute;-e, les cookies de session ne sont pas g&eacute;r&eacute;s)";
              
            
					//envoi d'un message aux intervenants
					$pb_array = explode(';', $intervenants);
					$taille = count($pb_array);
					//echo "<br />nombre d'intervenants : $taille";
					for($j = 0; $j<$taille; ++$j)
					{
						//echo "<br />intervenant $j : $pb_array[$j]";
						$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
						$results_util = mysql_query($query_util);
						$ligne=mysql_fetch_object($results_util);
						$destinataire=$ligne->MAIL;

						//On regarde si le destinataire est diff&eacute;rent de la personne qui &agrave; passer la priorit&eacute; &agrave; haute
						//$mail_personne_connectee = $_SESSION['mail'];
						//echo "<br />consult_ticket.php : mail_personne_connectee = $mail_personne_connectee - destinataire =-: $destinataire";
						if ($_SESSION['mail'] <> $destinataire)
						{
							$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
							echo "<br />envoi du message &agrave; $destinataire";
						} 
					}
					//on envoie un message au propri&eacute;taire du ticket s'il n'est pas celui qui passe le ticket en priorit&eacute; haute
					if ($_SESSION['mail'] <> $mail_emetteur)
					{
						echo "<br />envoi du message &agrave; $mail_emetteur";
						$ok=mail($mail_emetteur, $sujet, $contenu_a_envoyer, $entete);
						echo "<h2>Un message &agrave; &eacute;t&eacute; envoy&eacute; aux intervenants</h2>";
					}
				}
			}
///////////////////////////////////////////////////////////////////////////////////////////
///////////Si le statut de traitement du ticket passe à "transféré", il faut envoyer un message aux intervenants
///////////////////////////////////////////////////////////////////////////////////////////
			if ($STATUT_TRAITEMENT <> $statut_traitement_dans_base)
			{
				//Changement du statut de traitement du ticket
				if ($STATUT_TRAITEMENT == "T")
				{
					//On r&eacute;cup&egrave;re la liste des intervenants
					$intervenants = extraction_intervenants_ticket($idpb);

					//Le statut de traitement est "transf&eacute;r&eacute;" et n&eacute;cessite un envoi de message aux intervenants
					$sujet = "[GT - TRANSFERT -"." N° ".$idpb." du ".$date_creation."] ".$sujet;
					$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

					//Composition du message &agrave; envoyer
					$contenu_a_envoyer="LE TICKET A BESOIN D'ETRE PRIS EN CHARGE
              
- Intervenant(s) : $intervenants
- Contenu : ".$contenu;
					$contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$idpb."
(il faut être connect&eacute;-e, les cookies de session ne sont pas g&eacute;r&eacute;s)";


					//envoi d'un message aux intervenants
					$pb_array = explode(';', $intervenants);
					$taille = count($pb_array);
					//echo "<br />nombre d'intervenants : $taille";
					for($j = 0; $j<$taille; ++$j)
					{
						//echo "<br />intervenant $j : $pb_array[$j]";
						$query_util = "SELECT * FROM util WHERE NOM = '".$pb_array[$j]."';";
						$results_util = mysql_query($query_util);
						$ligne=mysql_fetch_object($results_util);
						$destinataire=$ligne->MAIL;

						//On regarde si le destinataire est diff&eacute;rent de la personne qui &agrave; passer la priorit&eacute; &agrave; haute
						if ($_SESSION['mail'] <> $destinataire)
						{
							echo "<br />envoi du message &agrave; $destinataire";
							$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
						}
					}
					//on envoie un message au propri&eacute;taire du ticket s'il n'est pas celui qui passe le ticket en priorit&eacute; haute
					if ($_SESSION['mail'] <> $mail_emetteur)
					{
						echo "<br />envoi du message &agrave; $mail_emetteur";
						$ok=mail($mail_emetteur, $sujet, $contenu_a_envoyer, $entete);
						echo "<h2>Un message &agrave; &eacute;t&eacute; envoy&eacute; aux intervenants</h2>";
					}
				}
			}
///////////////////////////////////////////////////////////////////////////////////////////
////////////Si un ticket archivé est réactivé, il faut envoyer un message aux intervenants
///////////////////////////////////////////////////////////////////////////////////////////
			if ($STATUT <> $statut_dans_base)
			{
				//Changement du statut du ticket constat&eacute;
				if ($STATUT == "N" AND $statut_dans_base <> "M")
				{
					//On r&eacute;cup&egrave;re la liste des intervenants
					$intervenants = extraction_intervenants_ticket($idpb);

					//Le ticket est r&eacute;activ&eacute; et n&eacute;cessite un envoi de message aux intervenants
					$STATUT_TRAITEMENT = 'T'; //changement du stade de traitement
					$sujet = "[GT - REACTIVE -"." N° ".$idpb." du ".$date_creation."] ".$sujet;
					$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

					//Composition du message &agrave; envoyer
					$contenu_a_envoyer="LE TICKET EST REACTIVE ET DOIT ETRE PRIS EN CHARGE
              
- Intervenant(s) : $intervenants
- Contenu : ".$contenu;
					$contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$idpb."
(il faut être connect&eacute;-e, les cookies de session ne sont pas g&eacute;r&eacute;s)";


					//envoi d'un message aux intervenants
					$pb_array = explode(';', $intervenants);
					$taille = count($pb_array);
					//echo "<br />nombre d'intervenants : $taille";
					for($j = 0; $j<$taille; ++$j)
					{
						//echo "<br />intervenant $j : $pb_array[$j]";
						$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
						$results_util = mysql_query($query_util);
						$ligne=mysql_fetch_object($results_util);
						$destinataire=$ligne->MAIL;
						//On regarde si le destinataire est diff&eacute;rent de la personne qui &agrave; passer la priorit&eacute; &agrave; haute
						if ($_SESSION['mail'] <> $destinataire)
						{
							echo "<br />envoi du message &agrave; $destinataire";
							$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
						}
					}
					//on envoie un message au propri&eacute;taire du ticket s'il n'est pas celui qui passe le ticket en priorit&eacute; haute
					if ($_SESSION['mail'] <> $mail_emetteur)
					{
						echo "<br />envoi du message &agrave; $mail_emetteur";
						$ok=mail($mail_emetteur, $sujet, $contenu_a_envoyer, $entete);
						echo "<h2>Un message &agrave; &eacute;t&eacute; envoy&eacute; aux intervenants</h2>";
					}
				}
				else
				{ 
					if ($STATUT == "A")
					{ //Le ticket doit être archivé

						//On r&eacute;cup&egrave;re la liste des intervenants
						$intervenants = extraction_intervenants_ticket($idpb);

						//On envoie un message aux intervenants
						$sujet = "[GT - ARCHIVAGE DU TICKET N° ".$idpb." du ".$date_creation."] ".$sujet;
						$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

						//Composition du message &agrave; envoyer
						$contenu_a_envoyer="Le ticket a &eacute;t&eacute; trait&eacute; et archiv&eacute;
- contenu : ".$contenu;

						//envoi d'un message aux intervenants
						$pb_array = explode(';', $intervenants);
						$taille = count($pb_array);
						//echo "<br />nombre d'intervenants : $taille";
						for($j = 0; $j<$taille; ++$j)
						{
							//echo "<br />intervenant $j : $pb_array[$j]";
							$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
							$results_util = mysql_query($query_util);
							$ligne=mysql_fetch_object($results_util);
							$destinataire=$ligne->MAIL;

							//On regarde si le destinataire est diff&eacute;rent de la personne qui &agrave; passer la priorit&eacute; &agrave; haute
							if ($_SESSION['mail'] <> $destinataire)
							{
								echo "<br />envoi du message &agrave; $destinataire";
								$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
							}
						}

						//on envoie un message au propriétaire du ticket s'il n'est pas celui qui passe le ticket en priorité haute
						if ($_SESSION['mail'] <> $mail_emetteur)
						{
							echo "<br />envoi du message &agrave; $mail_emetteur";
							$ok=mail($mail_emetteur, $sujet, $contenu_a_envoyer, $entete);
							echo "<h2>Un message &agrave; &eacute;t&eacute; envoy&eacute; aux intervenants</h2>";
						}

						//il faut mettre à jour les champs priorite et statut_traitement
						$STATUT_TRAITEMENT = 'F';
						$PRIORITE_SELECTION = '2';
						//$TRAITE_PAR = '';
						$query_archi = "UPDATE probleme SET
							DATE_ARCHI = '".date('j/m/Y')."',
							STATUT_TRAITEMENT = 'F',
							PRIORITE = '2',
							STATUT = 'A'
							WHERE ID_PB = '".$idpb."';";
						$results_archi = mysql_query($query_archi);

/////////////// Suppression des alertes concernant le ticket archivé
						suppression_alertes($idpb);
///////////////////////////////////////////////////////////////////////////////////////////
					}
				}
			}
			//---------------------------------------------------------------------------------------------------------
			/*
			echo "<br />Variables juste avant l'enregistrement :";
			echo "<br />Statut traitement : $STATUT_TRAITEMENT";
			echo "<br />Priorit&eacute; : $PRIORITE_SELECTION";
			echo "<br />Statut : $STATUT";
			*/

			//Mise &agrave; jour des champs modifiés
			//---------------------------------------------------------------------------------------------------------
			$query_changement_statut_traitement = "UPDATE probleme SET STATUT_TRAITEMENT = '".$STATUT_TRAITEMENT."', PRIORITE = '".$PRIORITE_SELECTION."', TRAITE_PAR = '".$TRAITE_PAR."', A_FAIRE='".$A_FAIRE."', STATUT = '".$STATUT."' WHERE ID_PB = '".$idpb."';";
			$results_changement_statut_traitement = mysql_query($query_changement_statut_traitement);
			if(!$results_changement_statut_traitement)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;	
				}
				mysql_close();
				exit;
			}
			//---------------------------------------------------------------------------------------------------------

			//Il faut envoyer une relance aux intevenants
			//---------------------------------------------------------------------------------------------------------
			if ($relance <>"")
			{
				//On recup&egrave;re la liste des intervenant-e-s
				$intervenants = extraction_intervenants_ticket ($idpb);
				//r&eacute;cup&eacute;ration des infos de l'emetteur
				$query_emetteur = "SELECT * FROM util where MAIL = '".$mail_emetteur."';";
				$results_emetteur = mysql_query($query_emetteur);
				$ligne=mysql_fetch_object($results_emetteur);

				$nom=$ligne->NOM;
				$prenom=$ligne->PRENOM;

				//Il faut envoyer une relance aux intevenants
				$sujet = "[GT - RELANCE - "." N° ".$idpb." du ".$date_creation."] ".$sujet;
				$entete="From: gestion_ticket\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

				//Composition du message &agrave; envoyer
				$contenu_a_envoyer="- RAPPEL POUR LE TICKET CREE PAR ".$prenom." ".$nom."
              
- Intervenant(s) : $intervenants
- Contenu :
".$contenu;
						  $contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$idpb."
(il faut être connect&eacute;-e, les cookies de session ne sont pas g&eacute;r&eacute;s)";

				//envoi d'un message aux intervenants
				$pb_array = explode(';', $intervenants);
				$taille = count($pb_array);
				//echo "<br />nombre d'intervenants : $taille";
				for($j = 0; $j<$taille; ++$j)
				{
					//echo "<br />intervenant $j : $pb_array[$j]";
					$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
					$results_util = mysql_query($query_util);
					$ligne=mysql_fetch_object($results_util);
					$destinataire=$ligne->MAIL;

					//On regarde si le destinataire est différent de la personne qui a passé la priorité à haute
					if ($_SESSION['mail'] <> $destinataire)
					{
						echo "<br />envoi du message &agrave; $destinataire";
						$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
					}

				}
				//on envoie un message au propri&eacute;taire du ticket s'il n'est pas celui qui passe le ticket en priorit&eacute; haute
				if ($_SESSION['mail'] <> $mail_emetteur)
				{
					echo "<br />envoi du message &agrave; $mail_emetteur";
					$ok=mail($mail_emetteur, $sujet, $contenu_a_envoyer, $entete);
					echo "<h2>Un message &agrave; &eacute;t&eacute; envoy&eacute; aux intervenants</h2>";
				}
			}
			//---------------------------------------------------------------------------------------------------------
		} //Fin de la condition chgt = O et reprise du traitement normal

		//Je regarde s'il faut afficher le reste du script, se produit quand on fait un traitement dans le début du script
		if ($affichage <> "N")
		{
			//récupération de l'identifiant du problème, la consultation se fait par accès avec cette clé
			//---------------------------------------------------------------------------------------------------------
			//$idpb = $_GET['idpb'];
			if(!isset($idpb) || $idpb == "")
			{
				echo "<b>Erreur de r&eacute;cup&eacute;ration des donn&eacute;es</b>";
   				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;
				}
				exit;
			}

			//récupération des données concernant le ticket
			$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
			$result_consult = mysql_query($query);

			//Dans le cas où aucun résultat n'est retourné
			if(!$result_consult)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;
				}
				mysql_close();
				exit;
			}

			$res = mysql_fetch_row($result_consult);

			//stockage des variables qui pourraient être modifiées en sortant et nécessiter un envoi de message :
			$priorite_dans_base = $res[13];
			$statut_traitement_dans_base = $res[14];
			$statut_dans_base = $res[11];
			
			//On vérifie si le ticket a déjà des contributions, si oui on récupère le dernier contact
			$requete_contributions = "SELECT * FROM probleme WHERE ID_PB_PERE = '".$idpb."' ORDER BY ID_PB DESC";
			/*
			echo "<br />$requete_contributions";
			echo "<br />idpb : $idpb";
			*/
			$res_req_contr = mysql_query($requete_contributions);
			$nb_contributions = mysql_num_rows($res_req_contr);
			
			//echo "<br />nb_contributions : $nb_contributions";
			
			if ($nb_contributions > 0)
			{
				//echo "<br />Je regarde ....";
				$ligne_contribution = mysql_fetch_object($res_req_contr);
				$id_pb_extrait = $ligne_contribution->ID_PB;
				$contact_titre_extrait = $ligne_contribution->CONTACT_TITRE;
				$contact_prenom_extrait = $ligne_contribution->CONTACT_PRENOM;
				$contact_nom_extrait = $ligne_contribution->CONTACT_NOM;
				$contact_mail_extrait = $ligne_contribution->CONTACT_MAIL;
				$contact_fonction_extrait = $ligne_contribution->CONTACT_FONCTION;
			}
			else
			{
				$contact_titre_extrait = $res[17];
				$contact_prenom_extrait = $res[19];
				$contact_nom_extrait = $res[18];
				$contact_mail_extrait = $res[20];
				$contact_fonction_extrait = $res[21];
			}
/*
			echo "<br />id_pb_extrait : $id_pb_extrait";
			echo "<br />contact_nom_extrait : $contact_nom_extrait";
			echo "<br />contact_prenom_extrait : $contact_prenom_extrait";
			echo "<br />contact_mail_extrait : $contact_mail_extrait";
			echo "<br />contact_fonction_extrait : $contact_fonction_extrait";
*/
			/*
			echo "<br />1 : priorit&eacute; dans base : $priorite_dans_base";
			echo "<br />1 : statut traitement dans base : $statut_traitement_dans_base";
			echo "<br />1 : statut dans base : $statut_dans_base";
			*/

			switch ($res[13]) 
			{
				case "2":
					$priorite_selection = "Normal";
					$priorite_non_selection_ref_1 = "1";
					$priorite_non_selection_ref_2 = "3";
					$priorite_non_selection_nom_1 = "Haute";
					$priorite_non_selection_nom_2 = "Basse";
				break;

				case "1":
					$priorite_selection = "Haute";
					$priorite_non_selection_ref_1 = "2";
					$priorite_non_selection_ref_2 = "3";
					$priorite_non_selection_nom_1 = "Normal";
					$priorite_non_selection_nom_2 = "Basse";
				break;

				case "3":
					$priorite_selection = "Basse";
					$priorite_non_selection_ref_1 = "1";
					$priorite_non_selection_ref_2 = "2";
					$priorite_non_selection_nom_1 = "Haute";
					$priorite_non_selection_nom_2 = "Normal";
				break;

				default:
					$res[13] = "2";
					$priorite_selection = "Normal";
					$priorite_non_selection_ref_1 = "1";
					$priorite_non_selection_ref_2 = "3";
					$priorite_non_selection_nom_1 = "Haute";
					$priorite_non_selection_nom_2 = "Basse";
				break;
			}

			//Requête pour selectionner toutes les catégories dont la personne connectée est possesseur
			//Afin de pouvoir affecter un ticket à une catégorie
			$query_categ = "SELECT * FROM categorie WHERE NOM_UTIL = '".$_SESSION['nom']."' AND MAIL_UTIL = '".$_SESSION['mail']."' ORDER BY NOM;";
			$results_categ = mysql_query($query_categ);
			//Dans le cas où aucun résultat n'est retourné
			if(!$results_categ)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;	
				}
				mysql_close();
				exit;
			}
			$res_categ = mysql_fetch_row($results_categ);
			$num_categ = mysql_num_rows($results_categ);

			//Il faut v&eacute;rifier si le ticket concerne un &eacute;tablissement ou une soci&eacute;t&eacute;

			switch ($res[23])
			{
				case 'GT' :
					//Requête pour sélectionner l'établissement dont il est le sujet
					$query_etab = "SELECT * FROM etablissements WHERE RNE = '".$res[4]."';";
					$results_etab = mysql_query($query_etab);
					//Dans le cas où aucun résultat n'est retourné
					if(!$results_etab)
					{
						echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
						switch ($origine)
						{
							case 'gestion_ticket':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'gestion_categories':
								echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'fouille':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'repertoire_consult_fiche':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'ecl_consult_fiche':
								echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'tb':
								echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;	
						}
						mysql_close();
						exit;
					}
					$res_etab = mysql_fetch_row($results_etab);
				break;

				case 'REP' :
					//Requête pour sélectionner la société dont il est le sujet
					$query_etab = "SELECT * FROM repertoire WHERE No_societe = '".$res[4]."';";
					$results_etab = mysql_query($query_etab);
					//Dans le cas où aucun résultat n'est retourné
					if(!$results_etab)
					{
						echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
						switch ($origine)
						{
							case 'gestion_ticket':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'gestion_categories':
								echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'fouille':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'repertoire_consult_fiche':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'ecl_consult_fiche':
								echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'tb':
								echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;	
						}
						mysql_close();
						exit;
					}
					$res_etab = mysql_fetch_row($results_etab);
				break;
			}
			//Requête pour sélectionner les messages réponses à ce problème
			$query_rep = "SELECT * FROM probleme WHERE ID_PB_PERE = '".$idpb."' ORDER BY ID_PB DESC;";
			
			//echo "<br />$query_rep";
			
			$results_rep = mysql_query($query_rep);
			//Dans le cas où aucun résultat n'est retourné
			if(!$results_rep)
			{
				echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'gestion_categories':
						echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'fouille':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'repertoire_consult_fiche':
						echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'ecl_consult_fiche':
						echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case 'tb':
						echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;	
				}
				mysql_close();
				exit;
			}
			$res_rep = mysql_fetch_row($results_rep);
			
			$num_rep = mysql_num_rows($results_rep);

/////////////////////////////////////////////////////////////////////////////////////////////
//////// Traitement des categories personnelles /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
			include("consult_ticket_traitement_cat_perso.inc.php");
/////////////////////////////////////////////////////////////////////////////////////////////
//////// Fin du traitement des categories personnelles /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////
//////// Traitement des categories communes /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
			include("consult_ticket_traitement_cat_commune.inc.php");
/////////////////////////////////////////////////////////////////////////////////////////////
//////// Fin du traitement des categories personnelles /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

			//Résumé des infos concernant le problème
			echo "<form action = \"consult_ticket.php\" METHOD = \"GET\">";
				//1ère ligne
				//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
				echo "<table width=\"95%\">";
					//echo "<tr class = \"".statut($res[11])."\">";
					echo "<tr>";
						echo "<td class = \"etiquette\" width=\"10%\">N°&nbsp;:&nbsp;</td>";
						echo "<td width=\"10%\">&nbsp;<b>$res[0]</b></td>";
						echo "<td class = \"etiquette\" width=\"10%\">cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
						echo "<td align = \"left\" width=\"20%\">&nbsp;$res[3]</td>";

						echo "<td class = \"etiquette\" width=\"10%\">demande du&nbsp;:&nbsp;</td>";
						//Transformation de la date de cr&eacute;ation extraite pour l'affichage
						$date_de_demande_a_afficher = strtotime($res['28']);
						$date_de_demande_a_afficher = date('d/m/Y',$date_de_demande_a_afficher);
						echo "<td align = \"left\" width=\"10%\">&nbsp;$date_de_demande_a_afficher</td>";

						echo "<td class = \"etiquette\" width=\"10%\">saisie le&nbsp;:&nbsp;</td>";
						//Transformation de la date de cr&eacute;ation extraite pour l'affichage
						$date_de_creation_a_afficher = strtotime($res['27']);
						$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
						echo "<td align = \"left\" width=\"10%\">&nbsp;$date_de_creation_a_afficher</td>";
						//echo "<td align = \"center\" width=\"10%\">$res[7]</td>";
						echo "<td class = \"etiquette\" width=\"10%\">trait&eacute; par&nbsp;:&nbsp;</td>";
						echo "<td align = \"left\" width=\"10%\">&nbsp;$res[15]</td>";
					echo "</tr>";
				//echo "</table>";

				//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
				//echo "<table width=\"95%\">";
					//echo "<tr class = \"".statut($res[11])."\">";
					echo "<tr>";
						//On récupère les intervenants de la table intervenant_ticket
						$intervenants = extraction_intervenants_ticket ($res[0]);
						echo "<td class = \"etiquette\">Intervenants&nbsp;:&nbsp;</td>";
						echo "<td colspan = \"9\">&nbsp;$intervenants";
						if ($_SESSION['nom'] == $res[3])
						{
							//On affiche le bouton de relance si la liste des intervenants n'est pas vide
							if ($intervenants <> '')
							{
								echo "&nbsp;<input type = \"submit\" VALUE = \"Message de relance aux intervenants\" NAME = \"relance\">";
							}
				
						}
						echo "</td>";
							//}
					echo "</tr>";
					//echo "</table>";
					
					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
						//echo "<tr class = \"".statut($res[11])."\">";
						echo "<tr>";
							echo "<td class = \"etiquette\">Sujet&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"9\">&nbsp;$res[5]</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td class = \"etiquette\">Ouvert pour&nbsp;:&nbsp;</th>";
							echo "<td colspan = \"9\">";
							switch ($res[23])
							{
								case 'GT' :
									echo "".str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5])." ".str_replace("*", " ",$res_etab[7])." "."<a href = \"mailto:".str_replace(" ", "*",$res_etab[8])."?cc=".$_SESSION['mail']."&amp;body=\"coucou\"><FONT COLOR=\"#696969\">".$res_etab[8]."</FONT></a>";
								break;

								case 'REP' :
									echo "".str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[4])."";
								break;
							}  
							echo "</td>";
						echo "</tr>";
						
					//echo "</table>";  

					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
						echo "<tr>";
							echo "<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"6\">&nbsp;$res[17]&nbsp;$res[19]&nbsp;$res[18]&nbsp;<a href = \"mailto:".str_replace(" ", "*",$res[20])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\"><FONT COLOR=\"#696969\">".$res[20]."</FONT></a>&nbsp;-&nbsp;$res[21]</td>";
							echo "<td class = \"etiquette\">Type de contact&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"2\">&nbsp;$res[22]</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">Contenu&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"9\">$res[6]</td>";
						echo "</tr>";
						
					//echo "</table>";
						//on ajoute une ligne suppl&eacute;mentaire
						echo "<tr>";
							echo "<td class = \"etiquette\"</td>";
							echo "<td colspan = \8\"></td>";
						echo "</tr>";


///////////////////////////////////////////////////////////////////////////////////////////////
/////Affichage des documents joints
///////////////////////////////////////////////////////////////////////////////////////////////				
					//echo "<br />On affiche les documents joints et le lien pour en ajouter d'autres";
					$ticket=$res[0];
					$dossier ="../data/gt/";
					$module = "GT";
					$creepar = $res[3];
					$creele = $res[7];
					$inervenants = $res[10];
					$sujet = $res[5];
					$etab = str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5]);
					$contact = $res[17]." ".$res[19]." ".$res[18];
					$typecontact = $res[22];
					include ("affiche_documents_joints.inc.php");
///////////////////////////////////////////////////////////////////////////////////////////////
///// Fin affichage des documents joints
///////////////////////////////////////////////////////////////////////////////////////////////				
        
					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";	
						//on ajoute une ligne supplémentaire
						echo "<tr>";
							echo "<td class = \"etiquette\"</td>";
							echo "<td colspan = \8\"></td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">&Agrave; faire&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"5\" align=\"left\"><textarea rows=\"4\" name=\"A_FAIRE\" cols=\"90\">$res[16]</textarea></td>";

							switch ($priorite_selection) 
							{
								case "Normal":
									switch ($res[11])
									{
										case "M":
											$fond = "#B3CEEF";
										break;

										case "N":
											$fond = "#A4EFCA";
										break;

										case "A":
											$fond = "#FF9FA3";
										break;
									}
									$classe_fond2 = "priorite_normale";
								break;

								case "Basse":
									switch ($res[11])
									{
										case "M":
											$fond = "#B3CEEF";
										break;

										case "N":
											$fond = "#A4EFCA";
										break;

										case "A":
											$fond = "#FF9FA3";
										break;
									}
									$classe_fond2 = "priorite_basse";
								break;

								case "Haute":
									$fond_p = "#ff0000";
									$classe_fond2 = "priorite_haute";
								break;

							}

							echo "<td class = \"$classe_fond2\" align=\"center\"><b>Priorit&eacute;&nbsp;:</b><br /><select size=\"1\" name=\"PRIORITE_SELECTION\">
								<option selected>$priorite_selection</option>
									<option value=\"2\">Normal</option>
									<option value=\"1\">Haute</option>
									<option value=\"3\">Basse</option>
								</select>";
							echo "</td>";

							//echo "<td align=\"center\">&nbsp;";

								/*
								$requeteliste_util="SELECT * FROM util ORDER BY 'NOM'";
								$result=mysql_query($requeteliste_util);
								$num_rows = mysql_num_rows($result);

								echo "<td align=\"center\">Trait&eacute; par&nbsp;:&nbsp;<br /><select size=\"1\" name=\"TRAITE_PAR\">";
								if (mysql_num_rows($result))
								{
									echo "<option selected>$res[15]</option>";
										while ($ligne=mysql_fetch_object($result))
										{
											$utilisateur=$ligne->NOM;
											echo "<option value=\"$utilisateur\">$utilisateur</option>";
										}
								}
								else
								{
									echo "<br /><b> pas de statuts</b>";
								}
								echo "</select>"; 
							echo "</td>";
							*/

							switch ($res[14]) 
							{
								case "N":
									$stat = "nouveau ticket";
									$fond_st = "#ffffff";
									$classe_fond = "nouveau";
								break;

								case "C":
									$stat = "traitement en cours";
									$fond_st = "#00cc33";
									$classe_fond = "en_cours";
								break;

								case "T":
									$stat = "ticket transf&eacute;r&eacute;";
									$fond_st = "#ff0000";
									$classe_fond = "transfere";
								break;

								case "A":
									$stat = "ticket en attente";
									$fond_st = "#ffff66";
									$classe_fond = "attente";
								break;

								case "F":
									$stat = "ticket &agrave; archiver";
									$fond_st = "#ff9fa3";
									$classe_fond = "acheve";
								break;
							}

							echo "<td class = \"$classe_fond\" align=\"center\">";
								echo "<b>Stade du traitement&nbsp;:</b><br /><select size=\"1\" name=\"STATUT_TRAITEMENT\">
									<option selected>$stat</option>
										<option value=\"N\">nouveau ticket</option>
										<option value=\"C\">traitement en cours</option>
										<option value=\"T\">ticket transf&eacute;r&eacute;</option>
										<option value=\"A\">ticket en attente</option>
										<option value=\"F\">ticket &agrave; archiver</option>
									</select>";
							echo "</td>";

							switch ($res[11])
							{
								case "N":
									$statut_affiche = "en cours";
									//$fond_s = "#ffffff";
									$classe_fond3 = "nouveau";
								break;

								case "A":
									$statut_affiche = "archiv&eacute;";
									$fond_s = "#ff9fa3";
									$classe_fond3 = "acheve";
								break;

								case "M":
									$statut_affiche = "modifi&eacute;";
									//$fond_s = "#ff9fa3";
									$classe_fond3 = "nouveau";
								break;
							}

            
							echo "<td class = \"$classe_fond3\" align=\"center\">";
								echo "<b>&Eacute;tat du ticket&nbsp;:</b><br /><select size=\"1\" name=\"STATUT\">
									<option selected>$statut_affiche</option>
										<option value=\"N\">en cours</option>
										<!--option value=\"M\">modifi&eacute;</option-->
										<option value=\"A\">archiv&eacute;</option>
									</select>";

							echo "</td>";
						//echo "</tr>";
						//echo "<tr>";
							//echo "<td colspan=\"6\" align=\"center\">";
							if ($res[25] == 1) // le ticket est verrouill&eacute;, il ne faut pas afficher le bouton d'enregistrement
							{
								echo "<td class = \"verrou\" align=\"center\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/verrouille.png\" ALT = \"verrouill&eacute; par $res[26]\" title=\"verrouill&eacute; par $res[26], retournez pour pouvoir le lib&eacute;rer\" border = \"0\">";
							}
							else
							{
								echo "<td align=\"center\">";
								echo "<input type = \"submit\" VALUE = \"Valider les modifications\">";
							}
							echo "</td>";
						echo "</tr>";
					//echo "</table>";
					echo "<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
					echo "<input type = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[7]."\" NAME = \"date_creation\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[5]."\" NAME = \"sujet\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[3]."\" NAME = \"emetteur\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[2]."\" NAME = \"mail_emetteur\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[10]."\" NAME = \"intervenant\">";
					echo "<input type = \"hidden\" VALUE = \"".$res[15]."\" NAME = \"TRAITE_PAR\">";
					echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">";
					echo "<input type = \"hidden\" VALUE = \"$priorite_dans_base\" NAME = \"priorite_dans_base\">";
					echo "<input type = \"hidden\" VALUE = \"$statut_traitement_dans_base\" NAME = \"statut_traitement_dans_base\">";
					echo "<input type = \"hidden\" VALUE = \"$statut_dans_base\" NAME = \"statut_dans_base\">";
					echo "<input type = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
					echo "<input type = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
					echo "<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">";
					//echo "<input type = \"hidden\" VALUE = \"".$res[6]."\" NAME = \"contenu\">";
				echo "</form>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Script pour le traitement des alertes
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//echo "<br />origine : $origine";
				$id_util = $_SESSION['id_util'];
				//On regarde s'il existe une alerte pour ce ticket pour l'utilisateur connect&eacute;
				$verif = verif_alerte($res[0],$id_util,$date_aujourdhui,"ticket");
				//echo "<br />1 - idpb : $idpb - id_util : $id_util - verif : $verif";
				echo "<form action = \"consult_ticket.php\" METHOD = \"POST\">";

				if ($verif == 0)
				{
					if ($ajouter_alerte<>"O")
					{
						//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
						
						echo "<tr>";
							echo "<td class = \"etiquette\">Alerte&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"8\"><a href = \"consult_ticket.php?idpb=".$idpb."&amp;ticket=$ticket&amp;creepar=$creepar&amp;creele=$creele&amp;intervenants=$intervenants&amp;sujet=$sujet&amp;etab=$etab&amp;contact=$contact&amp;typecontact=$typecontact&amp;module=$module&amp;ajouter_alerte=O\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/alerte_ajout.png\" ALT = \"Ajout alerte\" title=\"Ajouter une alerte\" border = \"0\"</a>";
						echo "</tr>";
					}
					else
					{
					//On fait le tableau pour afficher ou saisir une alerte
					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";

						echo "<tr>";
							echo "<td class = \"etiquette\">Saisir la desription de l'alerte&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"5\" align=\"left\"><textarea rows=\"3\" name=\"description_alerte\" cols=\"50\"></textarea>";
								echo "<script type=\"text/javascript\">
									CKEDITOR.replace( 'description_alerte',
									{
										toolbar : 'Basic'
									});
								</script>";
							echo "</td>";
							/*
							echo "<td>Alerte dans&nbsp;<select size=\"1\" name=\"nbr_jours\">
								<option value=\"0\"></option>
								<option value=\"1\">01</option>
								<option value=\"2\">02</option>
								<option value=\"3\">03</option>
								<option value=\"4\">04</option>
								<option value=\"5\">05</option>
								<option value=\"6\">06</option>
								<option value=\"7\">07</option>
								<option value=\"8\">08</option>
								<option value=\"9\">09</option>
								<option value=\"10\">10</option>
								<option value=\"11\">11</option>
								<option value=\"12\">12</option>
								<option value=\"13\">13</option>
								<option value=\"14\">14</option>
								<option value=\"15\">15</option>
								<option value=\"16\">16</option>
								<option value=\"17\">17</option>
								<option value=\"18\">18</option>
								<option value=\"19\">19</option>
								<option value=\"20\">20</option>
								<option value=\"21\">21</option>
								<option value=\"22\">22</option>
								<option value=\"23\">23</option>
								<option value=\"24\">24</option>
								<option value=\"25\">25</option>
								<option value=\"26\">26</option>
								<option value=\"27\">27</option>
								<option value=\"28\">28</option>
								<option value=\"29\">29</option>
								<option value=\"30\">30</option>
								<option value=\"31\">31</option>
							</select> jour(s)";
							*/
							//On regarde que la date &agrave; afficher pour le rappel a le bon format
							$date_rappel = verif_date_rappel ($nbr_jours_decallage_pour_rappel);
							//echo "<br />date_rappel : $date_rappel";

							//Transformation de la date de cr&eacute;ation extraite pour l'affichage
							$date_rappel_a_afficher = strtotime($date_rappel);
							$aujourdhui_jour = date('d',$date_rappel_a_afficher);
							$aujourdhui_mois = date('m',$date_rappel_a_afficher);
							$aujourdhui_annee = date('Y',$date_rappel_a_afficher);

							echo "<td colspan = \"2\">&Eacute;ch&eacute;ance&nbsp;:&nbsp;<select size=\"1\" name=\"jour\">
								<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>
									<option value=\"1\">01</option>
									<option value=\"2\">02</option>
									<option value=\"3\">03</option>
									<option value=\"4\">04</option>
									<option value=\"5\">05</option>
									<option value=\"6\">06</option>
									<option value=\"7\">07</option>
									<option value=\"8\">08</option>
									<option value=\"9\">09</option>
									<option value=\"10\">10</option>
									<option value=\"11\">11</option>
									<option value=\"12\">12</option>
									<option value=\"13\">13</option>
									<option value=\"14\">14</option>
									<option value=\"15\">15</option>
									<option value=\"16\">16</option>
									<option value=\"17\">17</option>
									<option value=\"18\">18</option>
									<option value=\"19\">19</option>
									<option value=\"20\">20</option>
									<option value=\"21\">21</option>
									<option value=\"22\">22</option>
									<option value=\"23\">23</option>
									<option value=\"24\">24</option>
									<option value=\"25\">25</option>
									<option value=\"26\">26</option>
									<option value=\"27\">27</option>
									<option value=\"28\">28</option>
									<option value=\"29\">29</option>
									<option value=\"30\">30</option>
									<option value=\"31\">31</option>
								</select>";
								echo "&nbsp;<select size=\"1\" name=\"mois\">
								<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>
									<option value=\"1\">01</option>
									<option value=\"2\">02</option>
									<option value=\"3\">03</option>
									<option value=\"4\">04</option>
									<option value=\"5\">05</option>
									<option value=\"6\">06</option>
									<option value=\"7\">07</option>
									<option value=\"8\">08</option>
									<option value=\"9\">09</option>
									<option value=\"10\">10</option>
									<option value=\"11\">11</option>
									<option value=\"12\">12</option>
								</select>";
								echo "&nbsp;<select size=\"1\" name=\"annee\">
								<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
									<option value=\"2008\">2008</option>
									<option value=\"2009\">2009</option>
									<option value=\"2010\">2010</option>
									<option value=\"2011\">2011</option>
									<option value=\"2012\">2012</option>
									<option value=\"2013\">2013</option>
									<option value=\"2014\">2014</option>
									<option value=\"2015\">2015</option>
								</select>";
							echo "</td";
							echo "<td><input type = \"submit\" VALUE = \"Enregistrer cette alerte\">";
								echo "<input type = \"hidden\" VALUE = \"ajout_alerte\" NAME = \"action\"></td>";
					} //Fin else ajout_alerte
				} //Fin if $verif
				else //Il faut afficher l'alerte existante et donner la possibilit&eacute; de la modifier et de la supprimer
				{
					$query_alerte = "SELECT * FROM alertes WHERE id_util = '".$id_util."' AND id_ticket = '".$idpb."';";
					$result_alerte = mysql_query($query_alerte);
					if(!$result_alerte)
					{
						echo "<br />Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
						//echo "<br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
					}
					//$num_results_count = mysql_num_rows($result); //on regarde s'il y a une alerte pour ce ticket
					$res_alerte = mysql_fetch_row($result_alerte);
					//echo "<br />num_results_count : $num_results_count - res_alerte[0] : $res_alerte[0] - res_alerte[1] : $res_alerte[1] - res_alerte[2] : $res_alerte[2] - res_alerte[3] : $res_alerte[3] - res_alerte[4] : $res_alerte[4]";
					$description_alerte = $res_alerte[4];
					//echo "<br />2 - idpb : $idpb - id_util : $id_util - id_ticket : $id_ticket - description_alerte : $description_alerte";
					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
						//echo "<tr class = \"".statut($res[11])."\">";
						//on ajoute une ligne suppl&eacute;mentaire
						echo "<tr>";
							echo "<td class = \"etiquette\"</td>";
							echo "<td colspan = \"9\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Alerte&nbsp;:&nbsp;</td>";
								echo "<td colspan = \"3\">&nbsp;$res_alerte[4]</td>";
							echo "<td class = \"etiquette\">date fix&eacute;e&nbsp;:&nbsp;</td>";
							echo "<td>";
								$date = strtotime($res_alerte[3]);
								$date_a_afficher = date('d/m/Y',$date);
							echo "$date_a_afficher</td>";
							echo "<td class = \"fond-actions\">";
								//echo "&nbsp;&nbsp;<input TYPE = \"image\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier l'alerte\" border = \"0\" VALUE = \"modif_alerte\" NAME = \"action\">";
								//echo "&nbsp;&nbsp;<input src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"supprimer_alerte\" NAME = \"action\">";
								echo "&nbsp;&nbsp;<a href = \"consult_ticket.php?idpb=".$idpb."&amp;action=modif_alerte\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier cette alerte\" border = \"0\"></a>";
								echo "&nbsp;&nbsp;<a href = \"consult_ticket.php?idpb=".$idpb."&amp;action=supprimer_alerte\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette alerte\" border = \"0\"></a>";
							echo "</td>";
							echo "<td colspan = \"3\">&nbsp;</td>";
							echo "<input type = \"hidden\" VALUE = \"".$description_alerte."\" NAME = \"description_alerte\">";
							echo "<input type = \"hidden\" VALUE = \"".$res_alerte[3]."\" NAME = \"date_alerte\">";
				}
							echo "<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
							echo "<input type = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[7]."\" NAME = \"date_creation\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[5]."\" NAME = \"sujet\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[3]."\" NAME = \"emetteur\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[2]."\" NAME = \"mail_emetteur\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[10]."\" NAME = \"intervenant\">";
							echo "<input type = \"hidden\" VALUE = \"".$res[15]."\" NAME = \"TRAITE_PAR\">";
							echo "<input type = \"hidden\" VALUE = \"N\" NAME = \"CHGMT\">";
							echo "<input type = \"hidden\" VALUE = \"$priorite_dans_base\" NAME = \"priorite_dans_base\">";
							echo "<input type = \"hidden\" VALUE = \"$statut_traitement_dans_base\" NAME = \"statut_traitement_dans_base\">";
							echo "<input type = \"hidden\" VALUE = \"$statut_dans_base\" NAME = \"statut_dans_base\">";
							echo "<input type = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
							echo "<input type = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
							echo "<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">";
						echo "</tr>";
				//on ajoute une ligne suppl&eacute;mentaire
						echo "<tr>";
							echo "<td class = \"etiquette\"</td>";
							echo "<td colspan = \8\"></td>";
						echo "</tr>";

					echo "</table>";
			echo "</form>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// Fin alerte
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//echo "<br />origine : $origine";
			
			//Dans le cas où le fichier n'est pas archivé l'utilisateur à le droit de répondre au sujet
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							switch ($origine)
							{
								case 'gestion_ticket':
									echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
	
								case 'gestion_categories':
									echo "<a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'fouille':
									echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'repertoire_consult_fiche':
									echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'ecl_consult_fiche':
									echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'tb':
									echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
							}
							echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
						echo "</td>";
							if($res[11] != "A" AND $res[25] != 1)
							{
								echo "<td>";
									//echo "<a href = \"ajout_reponse_ticket.php?tri=$tri&amp;idpb=".$idpb."&amp;id_categ=$id_categ&amp;contact_titre=".$res[17]."&amp;contact_prenom=".$res[19]."&amp;contact_nom=".$res[18]."&amp;contact_mail=".$res[20]."&amp;contact_fonction=".$res[21]."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouvelle contribution\" title=\"Ins&eacute;rer une nouvelle contribution\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle contribution</span><br />";
									echo "<a href = \"ajout_reponse_ticket.php?tri=$tri&amp;idpb=".$idpb."&amp;id_categ=$id_categ&amp;contact_titre=".$contact_titre_extrait."&amp;contact_prenom=".$contact_prenom_extrait."&amp;contact_nom=".$contact_nom_extrait."&amp;contact_mail=".$contact_mail_extrait."&amp;contact_fonction=".$contact_fonction_extrait."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouvelle contribution\" title=\"Ins&eacute;rer une nouvelle contribution\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle contribution</span><br />";
								echo "</td>";
							}
					echo "</tr>";
				echo "</table>";
			echo "</div>";

				
				//echo "<br /><a href = \"ajout_reponse_ticket.php?tri=$tri&amp;idpb=".$idpb."&amp;id_categ=$id_categ&amp;contact_titre=".$res[17]."&amp;contact_prenom=".$res[19]."&amp;contact_nom=".$res[18]."&amp;contact_mail=".$res[20]."&amp;contact_fonction=".$res[21]."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout_reponse.png\" ALT = \"ajouter une reponse\" title=\"Ajouter une r&eacute;ponse\"></a>";
				//echo "<button><a href = \"ajout_reponse_ticket.php?tri=$tri&amp;idpb=".$idpb."&amp;id_categ=$id_categ&amp;contact_titre=".$res[17]."&amp;contact_prenom=".$res[19]."&amp;contact_nom=".$res[18]."&amp;contact_mail=".$res[20]."&amp;contact_fonction=".$res[21]."\">Ajouter une contribution</a></button>";
			

//////////////////////////////////////////////////////////////////////////////////////////////////
////////////// Traitement de chaque ligne de r&eacute;ponse /////////////////////////////////////////////
////////////// Pour lister chaque r&eacute;ponse publi&eacute;e; ///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
			for($i = 0; $i < $num_rep; ++$i)
			{
				//echo "<table width=\"95%\" BORDER = \"0\" BGCOLOR = \"#48D1CC\">";
				echo "<table width=\"95%\">";
					echo "<tr class = \"reponse\">";
						echo "<td class = \"etiquette\" width=\"10%\">N°&nbsp;:&nbsp;</td>";
						echo "<td width = \"10%\">&nbsp;<b>$res_rep[0]</b></td>";
						echo "<td class = \"etiquette\" width=\"10%\">";
							echo "cr&eacute;&eacute; par&nbsp;:&nbsp;";
						echo "</td>";
						echo "<td width=\"10%\">";
							echo "&nbsp;$res_rep[3]";
						echo "</td>";
						echo "<td class = \"etiquette\" width=\"10%\">Type de contact&nbsp;:&nbsp;</td>";
						echo "<td width = \"10%\">&nbsp;$res_rep[22]</td>";
						echo "<td class = \"etiquette\" width=\"10%\">";
							echo "contribution du&nbsp;:&nbsp;</td>";
							//Transformation de la date de cr&eacute;ation extraite pour l'affichage
							$date_de_demande_a_afficher = strtotime($res_rep['28']);
							$date_de_demande_a_afficher = date('d/m/Y',$date_de_demande_a_afficher);
							//echo $res_rep[7]; issu du champ DATE_CREATION
							echo "<td width = \"10%\">&nbsp;$date_de_demande_a_afficher"; //issu du champ date_crea
						echo "</td>";

						echo "<td class = \"etiquette\" width=\"10%\">";
							echo "saisie le&nbsp;:&nbsp;</td>";
							//Transformation de la date de cr&eacute;ation extraite pour l'affichage
							$date_de_creation_a_afficher = strtotime($res_rep['27']);
							$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
							//echo $res_rep[7]; issu du champ DATE_CREATION
							echo "<td width = \"10%\">&nbsp;$date_de_creation_a_afficher"; //issu du champ date_crea
						echo "</td>";

					echo "</tr>";
				//echo "</table>";
				if ($res_rep[18] <>"") //Contact
				{
					//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
						echo "<tr class = \"reponse\">";
							echo "<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"11\">&nbsp;$res_rep[17]&nbsp;$res_rep[19]&nbsp;$res_rep[18]&nbsp;<a href = \"mailto:".str_replace(" ", "*",$res_rep[20])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\">".$res_rep[20]."</a>&nbsp;-&nbsp;$res_rep[21]</td>";
						echo "</tr>";
					//echo "</table>";
				}
///////////////////////////////////////////////////////////////////////////////////////////////
/////Affichage des documents joints
///////////////////////////////////////////////////////////////////////////////////////////////						
				//On affiche un champ de saisie pour ajouter des fichiers
				$ticket=$res_rep[0];
				$dossier ="../data/gt/";
				$module = "GT";
				$creepar = $res_rep[3];
				$creele = $res_rep[7];
				$inervenants = $res_rep[10];
				$sujet = $res_rep[5];
				$etab = str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5]);
				$contact = $res_rep[17]." ".$res_rep[19]." ".$res_rep[18];
				$typecontact = $res_rep[22];
				$type_enregistrement = "reponse"; //pour povoir changer le fond de cellule
				include ("affiche_documents_joints.inc.php");
///////////////////////////////////////////////////////////////////////////////////////////////
/////Fin affichage des documents joints
///////////////////////////////////////////////////////////////////////////////////////////////

				//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
				//echo "<table>";
					//echo "<tr class = \"".statut($res_rep[11])."\">";
					echo "<tr>";
						echo "<td class = \"etiquette\">";
							echo "Contenu&nbsp;:&nbsp;";
						echo "</td>";

					if ($_SESSION['nom'] == $res_rep[3] OR $_SESSION['droit'] == "Super Administrateur")
					{
						echo "<td class = \"reponse\" colspan = \"8\">";
							echo "&nbsp;$res_rep[6]";
						echo "</td>";
						echo "<td class = \"fond-actions\" align =\"center\">";
							echo "<a href = \"delete_reponse.php?tri=$tri&amp;idpb=".$idpb."&amp;idrep=".$res_rep[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette r&eacute;ponse\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
					}
					else
					{
						echo "<td class = \"reponse\" colspan = \"9\">";
							echo "&nbsp;$res_rep[6]";
					}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				echo "<br />";
				$res_rep = mysql_fetch_row($results_rep);
			}
		} //Fin de la condition if $affichage <> "N"
		mysql_close();
?>
		</center>
	</body>
</html>
