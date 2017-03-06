<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Ce fichier a pour but de consulter les données (problématique + réponses) concernant un ticket">

<HTML>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");

			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
			<?php
				//Inclusion des fichiers nécessaires

				//include ("../biblio/fct.php");
				//include ("../biblio/config.php");
				//include ("../biblio/init.php");

				$nb_par_page = 12; //variable qui fixe le nombre de lignes affichées
				
				$_SESSION['origine'] = "repertoire_consult_fiche";
				
				//Récupération des variables nécessaires au fonctionnement du script
				$origine_gestion = $_SESSION['origine_gestion']; //permet de récupérer l'origine dans le fichier repertoire_gestion pour afficher la même chose en y retournat
				$autorisation_genies = verif_appartenance_groupe(2);
				
				//echo "<br />repertoire_consult_fiche.php - autorisation_genies : $autorisation_genies";
				
				$autorisation_salon = verif_appartenance_groupe(7);
				$id_societe = $_GET['id_societe']; //nécessaire pour la consultation des tickets
				$action = $_GET['action'];
				$CHGMT = $_GET['CHGMT']; //Indique si un changement est intervenu lors des formulaires en fin der fichier
				$affiche_FGMM = $_GET['affiche_FGMM']; //pour savoir s'il faut afficher les détails pour le festival
				$affiche_salon = $_GET['affiche_salon']; //pour savoir s'il faut afficher les détails pour les rencontres TICE
				$affiche_tickets = $_GET['affiche_tickets']; //pour savoir s'il faut afficher les tickets de la société choisie
				$affiche_tickets_archives = $_GET['affiche_tickets_archives']; //pour savoir s'il faut afficher les tickets de la société choisie
				$affiche_contacts = $_GET['affiche_contacts'];
				//echo "<br>action : $action - chgmt : $CHGMT";
				if (!ISSET($id_societe))
				{
					$id_societe = $_SESSION['id_societe'];
				}
				else
				{
					$_SESSION['id_societe'] = $id_societe;
				}
				if (!ISSET($action))
				{
					$action = $_SESSION['action'];
				}
				else
				{
					$_SESSION['action'] = $action;
				}
				if (!ISSET($affiche_FGMM))
				{
					$affiche_FGMM = $_SESSION['affiche_FGMM'];
				}
				else
				{
					$_SESSION['affiche_FGMM'] = $affiche_FGMM;
				}
				if (!ISSET($affiche_salon))
				{
					$affiche_salon = $_SESSION['affiche_salon'];
				}
				else
				{
					$_SESSION['affiche_salon'] = $affiche_salon;
				}
				if (!ISSET($affiche_tickets))
				{
					$affiche_tickets = $_SESSION['affiche_tickets'];
				}
				else
				{
					$_SESSION['affiche_tickets'] = $affiche_tickets;
				}
				if (!ISSET($affiche_contacts))
				{
					$affiche_contacts = $_SESSION['affiche_contacts'];
				}
				else
				{
					$_SESSION['affiche_contacts'] = $affiche_contacts;
				}
				
				if (!ISSET($affiche_tickets_archives))
				{
					$affiche_tickets_archives = $_SESSION['affiche_tickets_archives'];
				}
				else
				{
					$_SESSION['affiche_tickets_archives'] = $affiche_tickets_archives;
				}
				/*
				$ses_id_societe = $_SESSION['id_societe'];
				$ses_action = $_SESSION['action'];
				$ses_affiche_tickets = $_SESSION['affiche_tickets'];
				$ses_affiche_FGMM = $_SESSION['affiche_FGMM'];
				echo "<BR>variables ordinaires : No société : $id_societe - changement : $CHGMT - action : $action - affiche_tickets : $affiche_tickets - affiche_FGMM : $affiche_FGMM";
				echo "<BR>variables sessions : No société : $ses_id_societe - action : $ses_action - affiche_tickets : $ses_affiche_tickets - affiche_FGMM : $ses_affiche_FGMM";
				*/
				//enregistrement s'il y a des changements dans le formulaire
				if($CHGMT=="O") // Des modifications ont été apportées
				{
					//Récupération des variables communes
					$a_traiter = $_GET['a_traiter'];
					$contacte = $_GET['contacte'];
					$a_faire_quand_date = $_GET['a_faire_quand_date'];
					$urgent = $_GET['urgent'];
					$editeur = $_GET['editeur'];
					$fabricants = $_GET['fabricants'];
					$entreprise_de_service = $_GET['entreprise_de_service'];
					$presse_specialisee = $_GET['presse_specialisee'];
					$part_fgmm = $_GET['part_fgmm'];
					$part_salon = $_GET['part_salon'];
					$a_faire = $_GET['a_faire'];
					$statut = $_GET['statut'];
					//echo "<BR>statut : $statut";
					//echo "<br>part_fgmm : $part_fgmm - part_salon : $part_salon";
					//Vérifier si la variable part_fgmm = 1 pour éventuellement créer les fiches de suivi
					if ($part_fgmm == "1")
					{
						//echo "<BR>id_societe : $id_societe";
						include("../biblio/init.php");
						//Vérification que la fiche existe dans la table suivi_partenaires
						$query = "SELECT DISTINCT * FROM fgmm_suivi_partenaires WHERE id_societe = '".$id_societe."';";
						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							mysql_close();
							//exit;
						}
						else
						{
							$num_results = mysql_num_rows($results);
							if ($num_results == 0) //la fiche n'existe pas
							{
								$query = "INSERT INTO fgmm_suivi_partenaires (id_societe) 
								VALUES ('".$id_societe."');";
								$results = mysql_query($query);
								//Dans le cas où aucun résultats n'est retourné
								if(!$results)
								{
									echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
									//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
									mysql_close();
									//exit;
								}
								else
								{
									echo "<h2>La fiche de suivi a été créée.</h2>";
								}
							}
						}
						//Vérification que la fiche existe dans la table hist_particip_partenaires
						$query = "SELECT DISTINCT * FROM fgmm_hist_particip_partenaires WHERE id_societe = '".$id_societe."';";
						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							mysql_close();
							//exit;
						}
						else
						{
							$num_results = mysql_num_rows($results);
							if ($num_results == 0) //la fiche n'existe pas
							{
								$query = "INSERT INTO fgmm_hist_particip_partenaires (id_societe) 
								VALUES ('".$id_societe."');";
								$results = mysql_query($query);
								//Dans le cas où aucun résultats n'est retourné
								if(!$results)
								{
									echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
									//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
									mysql_close();
									//exit;
								}
								else
								{
									echo "<h2>La fiche de suivi historique a été créée.</h2>";
								}
							}
						}
						//Vérification que la fiche existe dans la table part_financiere_partenaires_fgmm
						$query = "SELECT DISTINCT * FROM fgmm_part_financiere_partenaires WHERE id_societe = '".$id_societe."';";
						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							mysql_close();
							//exit;
						}
						else
						{
							$num_results = mysql_num_rows($results);
							if ($num_results == 0) //la fiche n'existe pas
							{
								$query = "INSERT INTO fgmm_part_financiere_partenaires (id_societe) 
								VALUES ('".$id_societe."');";
								$results = mysql_query($query);
								//Dans le cas où aucun résultats n'est retourné
								if(!$results)
								{
									echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
									//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
									mysql_close();
									//exit;
								}
								else
								{
									echo "<h2>La fiche de suivi de la participation financière a été créée.</h2>";
								}
							}
						}
					} // Fin if part_fgmm = 1
					//echo "<br>part_salon : $part_salon";
					//Vérifier si la variable part_salon = 1 pour éventuellement créer la fiche de suivi
					if ($part_salon == "1")
					{
						//echo "<BR>id_societe : $id_societe";
						include("../biblio/init.php");
						//Vérification que la fiche existe dans la table salon_suivi_partenaires
						$query_recherche = "SELECT * FROM salon_suivi_partenaires WHERE id_societe = '".$id_societe."';";
						$results_recherche = mysql_query($query_recherche);
						$num_results = mysql_num_rows($results_recherche);
						//echo "<br>num_results : $num_results";
						//Dans le cas où aucun résultats n'est retourné
						if(!$results_recherche)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							//mysql_close();
							//exit;
						}
						else
						{
							//echo "<br>Je suis dans la création de la fiche";
							$num_results = mysql_num_rows($results_recherche);
							if ($num_results == 0) //la fiche n'existe pas
							{
								$query_ajout = "INSERT INTO salon_suivi_partenaires (id_societe) 
								VALUES ('".$id_societe."');";
								$results_ajout = mysql_query($query_ajout);
								//Dans le cas où aucun résultats n'est retourné
								if(!$results_ajout)
								{
									echo "<FONT COLOR = \"#808080\"><B>Création : Erreur de connexion à la base de données ou erreur de requète</B></FONT>";
									//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
									//mysql_close();
									//exit;
								}
								else
								{
									echo "<h2>La fiche de suivi a été créée.</h2>";
								}
							}
						}
					} // Fin if part_salon = 1
					elseif ($part_salon == "0") //Je dois supprimer la fiche de suivi
					{
						echo "<br>Je dois supprimer la fiche";
						include("../biblio/init.php");
						$query_suppression = "DELETE FROM salon_suivi_partenaires WHERE id_societe = '".$id_societe."';";
						$results_suppression = mysql_query($query_suppression);
						if(!$results_suppression)
						{
							echo "<FONT COLOR = \"#808080\"><B>Suppression : Erreur de connexion à la base de données ou erreur de requète</B></FONT>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							//mysql_close();
							//exit;
						}
						else
						{
							echo "<h2>La fiche de suivi a été supprimée.</h2>";
						}
					} // Fin else $part_salon == "1"
///////////////////////////////////////////////////////////////////////////////
//////////    Début des traitements    ////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
					switch ($action)
					{
						case ('modif') :
							//$ = $_GET[''];
							$societe = $_GET['societe'];
							$adresse = $_GET['adresse'];
							$cp = $_GET['cp'];
							$ville = $_GET['ville'];
							$internet = $_GET['internet'];
							$tel_standard = $_GET['tel_standard'];
							$fax = $_GET['fax'];
							$email = $_GET['email'];
							$remarques = $_GET['remarques'];
							$pays = $_GET['pays'];

						//Formatage des N°s de téléphone
							$tel_standard = format_no_tel($tel_standard);
							$fax = format_no_tel($fax);
							//echo "<br> : $";
							/*
							echo "<br>societe : $societe";
							echo "<br>adresse : $adresse";
							echo "<br>cp : $cp";
							echo "<br>ville : $ville";
							echo "<br>internet : $internet";
							echo "<br>tel_standard : $tel_standard";
							echo "<br>fax : $fax";
							echo "<br>remarques : $remarques";
							echo "<br>part_fgmm : $part_fgmm";
							echo "<br>statut : $statut";
							*/
							//Mise à jour de la fiche
							include ("../biblio/init.php");
							$query_maj = "UPDATE repertoire SET
								societe = '".$societe."',
								adresse = '".$adresse."',
								cp = '".$cp."',
								ville = '".$ville."',
								internet = '".$internet."',
								tel_standard = '".$tel_standard."',
								fax = '".$fax."',
								email = '".$email."',
								remarques = '".$remarques."',
								a_traiter = '".$a_traiter."',
								contacte = '".$contacte."',
								a_faire_quand_date = '".$a_faire_quand_date."',
								urgent = '".$urgent."',
								editeur = '".$editeur."',
								fabricants = '".$fabricants."',
								entreprise_de_service = '".$entreprise_de_service."',
								presse_specialisee = '".$presse_specialisee."',
								part_fgmm = '".$part_fgmm."',
								part_salon = '".$part_salon."',
								a_faire = '".$a_faire."',
								statut = '".$statut."',
								pays = '".$pays."'
							WHERE No_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							mysql_close();
							echo "<h2>La fiche a été mise à jour&nbsp;!</h2>"; 
						break;

						case ('affichage') :
							/*
							echo "<br>a_traiter : $a_traiter";
							echo "<br>a_faire_quand_date : $a_faire_quand_date";
							echo "<br>urgent : $urgent"; 
							echo "<br>editeur : $editeur";
							echo "<br>fabricants : $fabricants";
							echo "<br>entreprise_de_service : $entreprise_de_service";
							echo "<br>presse_specialisee : $presse_specialisee";
							echo "<br>part_fgmm : $part_fgmm";
							echo "<br>a_faire : $a_faire";
							echo "<BR>id_societe : $id_societe";
							*/
							//Mise à jour de la fiche
							include ("../biblio/init.php");
							$query_maj = "UPDATE repertoire SET
								a_traiter = '".$a_traiter."',
								contacte = '".$contacte."',
								a_faire_quand_date = '".$a_faire_quand_date."',
								urgent = '".$urgent."',
								editeur = '".$editeur."',
								fabricants = '".$fabricants."',
								entreprise_de_service = '".$entreprise_de_service."',
								presse_specialisee = '".$presse_specialisee."',
								part_fgmm = '".$part_fgmm."',
								part_salon = '".$part_salon."',
								a_faire = '".$a_faire."',
								statut = '".$statut."'
							WHERE No_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							mysql_close(); 
							echo "<h2>La fiche a été mise à jour&nbsp;!</h2>";  
						break;

						case ('enreg_suivi') : //il y a eu des changements dans le formulaire de suivi du Festival des Génies du Multimédia
							//echo "<BR>Je suis dans l'enreg_suivi";
							//Récupération des variables de la table suivi_partenaires
							$dossier_salon_envoye = $_GET['dossier_salon_envoye'];
							$dossier_concours_envoye = $_GET['dossier_concours_envoye'];
							$participation_concours = $_GET['participation_concours'];
							$participation_salon = $_GET['participation_salon'];
							$interesse_pour_concours = $_GET['interesse_pour_concours'];
							$interesse_pour_salon = $_GET['interesse_pour_salon'];
							$refus_concours = $_GET['refus_concours'];
							$refus_salon = $_GET['refus_salon'];
							$concours_suivant = $_GET['concours_suivant'];
							$logo_sur_affiche = $_GET['logo_sur_affiche'];
							$lien_logo = $_GET['lien_logo'];
							$a_traiter_fgmm = $_GET['a_traiter_fgmm'];
							$affiche_page_partenaires_fgmm = $_GET['affiche_page_partenaires_fgmm'];
							//Récupération des variables de la table fgmm_hist_particip_partenaires 
							$participation_1995 = $_GET['participation_1995'];
							$participation_1996 = $_GET['participation_1996'];
							$participation_1997 = $_GET['participation_1997'];
							$participation_1998 = $_GET['participation_1998'];
							$participation_1999 = $_GET['participation_1999'];
							$participation_2000 = $_GET['participation_2000'];
							$participation_2001 = $_GET['participation_2001'];
							$participation_2002 = $_GET['participation_2002'];
							$participation_2003 = $_GET['participation_2003'];
							$participation_2004 = $_GET['participation_2004'];
							$participation_2005 = $_GET['participation_2005'];
							$participation_2006 = $_GET['participation_2006'];
							$participation_2007 = $_GET['participation_2007'];
							$participation_2008 = $_GET['participation_2008'];
							$participation_2009 = $_GET['participation_2009'];
							$participation_2010 = $_GET['participation_2010'];
							$participation_2011 = $_GET['participation_2011'];
							$participation_2012 = $_GET['participation_2012'];
							$participation_2013 = $_GET['participation_2013'];
							$participation_2014 = $_GET['participation_2014'];
							//Récupération des variables de la table part_financiere_partenaires_fgmm 
							$montant95 = $_GET['montant95'];
							$montant95 = DeFormatage_Nombre($montant95,$monnaie_utilise);
							$montant96 = $_GET['montant96'];
							$montant96 = DeFormatage_Nombre($montant96,$monnaie_utilise);
							$montant97 = $_GET['montant97'];
							$montant97 = DeFormatage_Nombre($montant97,$monnaie_utilise);
							$montant98 = $_GET['montant98'];
							$montant98 = DeFormatage_Nombre($montant98,$monnaie_utilise);
							$montant99 = $_GET['montant99'];
							$montant99 = DeFormatage_Nombre($montant99,$monnaie_utilise);
							$montant00 = $_GET['montant00'];
							$montant00 = DeFormatage_Nombre($montant00,$monnaie_utilise);
							$montant01 = $_GET['montant01'];
							$montant01 = DeFormatage_Nombre($montant01,$monnaie_utilise);
							$montant02 = $_GET['montant02'];
							$montant02 = DeFormatage_Nombre($montant02,$monnaie_utilise);
							$montant03 = $_GET['montant03'];
							$montant03 = DeFormatage_Nombre($montant03,$monnaie_utilise);
							$montant04 = $_GET['montant04'];
							$montant04 = DeFormatage_Nombre($montant04,$monnaie_utilise);
							$montant05 = $_GET['montant05'];
							$montant05 = DeFormatage_Nombre($montant05,$monnaie_utilise);
							$montant06 = $_GET['montant06'];
							$montant06 = DeFormatage_Nombre($montant06,$monnaie_utilise);
							$montant07 = $_GET['montant07'];
							$montant07 = DeFormatage_Nombre($montant07,$monnaie_utilise);
							$montant08 = $_GET['montant08'];
							$montant08 = DeFormatage_Nombre($montant08,$monnaie_utilise);
							$montant09 = $_GET['montant09'];
							$montant09 = DeFormatage_Nombre($montant09,$monnaie_utilise);
							$montant10 = $_GET['montant10'];
							$montant10 = DeFormatage_Nombre($montant10,$monnaie_utilise);
							$montant11 = $_GET['montant11'];
							$montant11 = DeFormatage_Nombre($montant11,$monnaie_utilise);
							$montant12 = $_GET['montant12'];
							$montant12 = DeFormatage_Nombre($montant12,$monnaie_utilise);
							$montant13 = $_GET['montant13'];
							$montant13 = DeFormatage_Nombre($montant13,$monnaie_utilise);
							$montant14 = $_GET['montant14'];
							$montant14 = DeFormatage_Nombre($montant14,$monnaie_utilise);
							//Mise à jour de la fiche
							include("../biblio/init.php");
							/*
							echo "<BR>dossier_salon_envoye : $dossier_salon_envoye, dossier_concours_envoye : $dossier_concours_envoye, participation_concours :$participation_concours,
							participation_salon : $participation_salon, interesse_pour_concours : $interesse_pour_concours,
							interesse_pour_salon : $interesse_pour_salon, refus_concours : $refus_concours,
							refus_salon : $refus_salon, concours_suivant : $concours_suivant, logo_sur_affiche :$logo_sur_affiche,
							lien_logo : $lien_logo - a_traiter_fgmm : $a_traiter_fgmm";
							*/
							//echo "<BR>montant95 : $montant95 - montant96 : $montant96 - montant97 : $montant97";
							//Tables concernées : part_financiere_partenaires_fgmm,fgmm_hist_particip_partenaires,suivi_partenaires
							$query_maj = "UPDATE fgmm_suivi_partenaires SET
								dossier_salon_envoye = '".$dossier_salon_envoye."',
								dossier_concours_envoye = '".$dossier_concours_envoye."',
								participation_concours = '".$participation_concours."',
								participation_salon = '".$participation_salon."',
								interesse_pour_concours = '".$interesse_pour_concours."',
								interesse_pour_salon = '".$interesse_pour_salon."',
								refus_concours = '".$refus_concours."',
								refus_salon = '".$refus_salon."',
								concours_suivant = '".$concours_suivant."',
								logo_sur_affiche = '".$logo_sur_affiche."',
								lien_logo = '".$lien_logo."',
								a_traiter = '".$a_traiter_fgmm."',
								affiche_page_partenaires_fgmm = '".$affiche_page_partenaires_fgmm."'
							WHERE id_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							$query_maj = "UPDATE fgmm_hist_particip_partenaires SET
								participation_1995 = '".$participation_1995."',
								participation_1996 = '".$participation_1996."',
								participation_1997 = '".$participation_1997."',
								participation_1998 = '".$participation_1998."',
								participation_1999 = '".$participation_1999."',
								participation_2000 = '".$participation_2000."',
								participation_2001 = '".$participation_2001."',
								participation_2002 = '".$participation_2002."',
								participation_2003 = '".$participation_2003."',
								participation_2004 = '".$participation_2004."',
								participation_2005 = '".$participation_2005."',
								participation_2006 = '".$participation_2006."',
								participation_2007 = '".$participation_2007."',
								participation_2008 = '".$participation_2008."',
								participation_2009 = '".$participation_2009."',
								participation_2010 = '".$participation_2010."',
								participation_2011 = '".$participation_2011."',
								participation_2012 = '".$participation_2012."',
								participation_2013 = '".$participation_2013."',
								participation_2014 = '".$participation_2014."'
							WHERE id_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							$query_maj = "UPDATE fgmm_part_financiere_partenaires SET
								montant95 = '".$montant95."',
								montant96 = '".$montant96."',
								montant97 = '".$montant97."',
								montant98 = '".$montant98."',
								montant99 = '".$montant99."',
								montant00 = '".$montant00."',
								montant01 = '".$montant01."',
								montant02 = '".$montant02."',
								montant03 = '".$montant03."',
								montant04 = '".$montant04."',
								montant05 = '".$montant05."',
								montant06 = '".$montant06."',
								montant07 = '".$montant07."',
								montant08 = '".$montant08."',
								montant09 = '".$montant09."',
								montant10 = '".$montant10."',
								montant11 = '".$montant11."',
								montant12 = '".$montant12."',
								montant13 = '".$montant13."',
								montant14 = '".$montant14."'
							WHERE id_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							mysql_close(); 
							echo "<h2>La fiche a été mise à jour&nbsp;!</h2>";
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('enreg_modif_lot') :
							//echo "<BR> J'enregistre le lot $id_lot qui a été modifié";
							//Récupération des variables de la table lot 
							$promis = $_GET['promis'];
							$recu = $_GET['recu'];
							$materiel = $_GET['materiel'];
							$id_lot = $_GET['id_lot'];
							//echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";
							//Mise à jour de la fiche
							include("../biblio/init.php");
							$query_maj = "UPDATE fgmm_lot SET
                promis = '".$promis."',
                recu = '".$recu."',
                materiel = '".$materiel."'
							WHERE id_lot = '".$id_lot."';";
							$results_maj = mysql_query($query_maj); 
							$affiche_message_lot = "O";
							$message_a_afficher = "Le lot ".$id_lot." a été mis à jour.";
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('modif_lot') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							include ("fgmm_modif_lot.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('enreg_lot_modifie') : //enregistrement d'un lot modifié
							include ("fgmm_enreg_lot_modifie.inc.php");
							$affiche_message_lot = "O";
							$message_a_afficher = "Le lot ".$id_lot." a été modifié.";
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('copie_lot') :
							//echo "<BR> Je suis dans la procédure de copie du lot $id_lot";
							$id_lot = $_GET['id_lot'];
							$id_societe = $_GET['id_societe'];
							//Récupération des variables de la table lot 
							include("../biblio/init.php");
							$query_lots = "SELECT DISTINCT * FROM fgmm_lot WHERE id_lot = $id_lot;";
							$results_lots = mysql_query($query_lots);
							$num_results_lots = mysql_num_rows($results_lots);
							$lot_extrait = mysql_fetch_row($results_lots);
							//echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";
							echo "<BR>
                <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
                  <CAPTION><b>Copier ce lot&nbsp;?</b></CAPTION>
                  <tr>
                    <td width=\"7%\" align=\"center\">Id</td>
                    <td width=\"20%\" align=\"center\">Lot</td>
                    <td width=\"10%\" align=\"center\">Valeur</td>
                    <td width=\"15%\" align=\"center\">niveau</td>
                    <td width=\"5%\" align=\"center\">Valider</td>
                  </tr>";
                  
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							echo "<tr CLASS = \"new\">
                      <td width=\"7%\" align = \"center\">".$lot_extrait[0]."</td>
                      <td width=\"20%\">".$lot_extrait[2]."</td>";
                        $nombre_a_afficher = Formatage_Nombre($lot_extrait[4],$monnaie_utilise);
                      echo "<td width=\"10%\" align=\"center\">$nombre_a_afficher</td>";
                      echo "<td width=\"15%\" align=\"center\">".$lot_extrait[9]."</TD>";
                      echo "<TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                        <INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
                      </TD>
                    </tr>
                  </TABLE>
                  <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
                  <INPUT TYPE = \"hidden\" VALUE = \"enreg_lot_copie\" NAME = \"action\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[0]."\" NAME = \"id_lot\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[2]."\" NAME = \"lot\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[4]."\" NAME = \"valeur_lot\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[8]."\" NAME = \"materiel\">
                  <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[9]."\" NAME = \"niveau\">
                </FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('enreg_lot_copie') : //enregistrement d'un lot copié
							//Récupération des variables du lot à enregistrer de la procédure copie_lot
							$id_societe = $_GET['id_societe'];
							$id_lot = $_GET['id_lot'];
							$lot = $_GET['lot'];
							$valeur_lot = $_GET['valeur_lot'];
							$materiel = $_GET['materiel'];
							$niveau = $_GET['niveau'];
							//Mise à jour de la fiche
							include("../biblio/init.php");
							$query = "INSERT INTO fgmm_lot (annee, lot, donnateur, valeur_lot, promis, recu, materiel, niveau) 
                        VALUES ('".$annee_en_cours."', '".$lot."', '".$id_societe."', '".$valeur_lot."', '1', '0', '".$materiel."', '".$niveau."');";
							$results = mysql_query($query);
							//Dans le cas où aucun résultats n'est retourné
							if(!$results)
							{
					       echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					       //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					       mysql_close();
					       //exit;
							}
							else
							{
                				$affiche_message_lot = "O";
                				$message_a_afficher = "Le lot $id_lot a été copié.";
							}
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('ajout_lot') :
							//Récupération de l'identifiant de la société
							$id_societe = $_GET['id_societe'];
							//Affichage du formulaire pour la saisie du lot
							echo "<BR>
                <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
                  <CAPTION><b>Lots</b></CAPTION>
                  <tr>
                    <td width=\"20%\" align=\"center\">Lot</td>
                    <td width=\"10%\" align=\"center\">Valeur</td>
                    <td width=\"15%\" align=\"center\">niveau</td>
                    <td width=\"5%\" align=\"center\">promis</td>
                    <td width=\"5%\" align=\"center\">reçu</td>
                    <td width=\"5%\" align=\"center\">matériel</td>
                    <td width=\"5%\" align=\"center\">Valider</td>
                  </tr>";
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							echo "<tr CLASS = \"new\">
                      <td width=\"20%\"><input type=\"text\" value = \"\" name=\"lot\" size = \"50\"></td>";
                      echo "<td width=\"10%\" align=\"center\"><input type=\"text\" value = \"\" name=\"valeur_lot\"></td>";
                      echo "<td width=\"15%\" align=\"center\">
                        <select size=\"1\" name=\"niveau\">
		                      <option selected value=\"\"></option>
			                    <option value=\"Tous\">Tous</option>
			                    <option value=\"Ecole\">Ecole</option>
			                    <option value=\"Ecole/Collège\">Ecole/Collège</option>
			                    <option value=\"Collège\">Collège</option>
			                    <option value=\"Collège/Lycée\">Collège/Lycée</option>
                          <option value=\"Lycée\">Lycée</option>
                        </select>";
                      echo "</TD>";
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"promis\" value=\"1\" checked></td>";
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"recu\" value=\"1\"</td>";
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"materiel\" value=\"1\"</td>";
                      echo "<TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                        <INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
                      </TD>
                    </tr>
                  </TABLE>
                  <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
                  <INPUT TYPE = \"hidden\" VALUE = \"enreg_lot_ajoute\" NAME = \"action\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
		            </FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('enreg_lot_ajoute') : //enregistrement d'un lot modifié
							//Récupération des variables du lot à enregistrer
							$id_societe = $_GET['id_societe'];
							$lot = $_GET['lot'];
							$valeur_lot = $_GET['valeur_lot'];
							$promis = $_GET['promis'];
							$recu = $_GET['recu'];
							$materiel = $_GET['materiel'];
							$niveau = $_GET['niveau'];
							//Mise à jour de la fiche
							include("../biblio/init.php");
							$query = "INSERT INTO fgmm_lot (annee, lot, donnateur, valeur_lot, promis, recu, materiel, niveau) 
                        VALUES ('".$annee_en_cours."', '".$lot."', '".$id_societe."', '".$valeur_lot."', '".$promis."', '".$recu."', '".$materiel."', '".$niveau."');";
							$results = mysql_query($query);
							//Dans le cas où aucun résultats n'est retourné
							if(!$results)
							{
					       echo "<FONT COLOR = \"#808080\"><B>EEErreur de connexion à la base de données ou erreur de requète</B></FONT>";
					       //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					       //mysql_close();
					       //exit;
							}
							else
							{
                				$affiche_message_lot = "O";
                				$message_a_afficher = "Le lot $id_lot a été ajouté.";
							}
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('suppression_lot') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							include ("fgmm_suppression_lot.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('confirm_suppression_lot') :
							include ("fgmm_confirm_suppression_lot.inc.php");
							//Dans le cas où aucun résultats n'est retourné
							if(!$result)
							{
					       echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					       //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					       mysql_close();
					       //exit;
							}
							else
							{
                				$affiche_message_lot = "O";
                				$message_a_afficher = "Le lot $id_lot a été supprimé.";
							}
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('affiche_contact') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_affiche_fiche.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('modif_contact') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_modif_fiche.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('enreg_contact_modifie') : //enregistrement d'un lot modifié
							include ("contacts_enreg_fiche_modifie.inc.php");
							$affiche_message_contact = "O";
							$message_a_afficher = "Le contact ".$id_contact." a été modifié.";
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('ajout_contact') :
							include ("../biblio/init.php");
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							$affiche_societe = "N";
							include ("contacts_ajout_fiche.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('enreg_contact_ajoute') : //enregistrement d'un lot modifié
							include ("contacts_enreg_fiche.inc.php");
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('suppression_contact') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_suppression_fiche.inc.php");
							echo "</FORM>";
							echo "<BR><A HREF = \"repertoire_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						break;

						case ('confirm_suppression_contact') :
							include ("contacts_confirmation_suppression_fiche.inc.php");
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;

						case ('enreg_suivi_salon') : //il y a eu des changements dans le formulaire de suivi du Festival des Génies du Multimédia
							//echo "<BR>Je suis dans l'enreg_suivi_salon";
							//Récupération des variables de la table suivi_partenaires
							//echo "<br>id_societe : $id_societe";
							$dossier_envoye = $_GET['dossier_envoye'];
							$participation_exposition = $_GET['participation_exposition'];
							$participation_agora = $_GET['participation_agora'];
							$interesse_pour_exposition = $_GET['interesse_pour_exposition'];
							//$interesse_pour_agora = $_GET['interesse_pour_agora'];
							$refus_exposition = $_GET['refus_exposition'];
							//$refus_agora = $_GET['refus_agora'];
							$logo_sur_affiche = $_GET['logo_sur_affiche'];
							$lien_logo = $_GET['lien_logo'];
							$taille_stand = $_GET['taille_stand'];
							$emplacement_exposition = $_GET['emplacement_exposition'];
							//$intervention_agora = $_GET['intervention_agora'];
							$participation_financiere = $_GET['participation_financiere'];
							$a_traiter_salon = $_GET['a_traiter_salon'];
							$contacte_salon = $_GET['contacte_salon'],
							$handicap_salon = $_GET['handicap_salon'],
							$detail_handicap_salon = $_GET['detail_handicap_salon'],
							$affiche_page_partenaire = $_GET['affiche_page_partenaire'];
							$description_pour_salon = $_GET['description_pour_salon'];
							$afficher_description_salon = $_GET['afficher_description_salon'];
							$participation_financiere = DeFormatage_Nombre($participation_financiere,$monnaie_utilise);
							//Mise à jour de la fiche
							include("../biblio/init.php");
							
							/*
							echo "<br />id_societe : $id_societe
							<BR>dossier_envoye : $dossier_envoye,<BR>participation_exposition :$participation_exposition,
							<BR>participation_agora : $participation_agora,<BR>interesse_pour_exposition : $interesse_pour_exposition,
							<BR>interesse_pour_agora : $interesse_pour_agora,<BR>refus_exposition : $refus_concours,
							<BR>refus_agora : $refus_agora,<BR>logo_sur_affiche :$logo_sur_affiche,
							<BR>lien_logo : $lien_logo,<BR>a_traiter_salon : $a_traiter_salon
							<BR>taille_stand : $taille_stand,<BR>description_pour_salon : $description_pour_salon
							<BR>afficher_description_salon : $afficher_description_salon";
							*/
							
							//echo "<BR>montant95 : $montant95 - montant96 : $montant96 - montant97 : $montant97";
							//Tables concernées : part_financiere_partenaires_fgmm,fgmm_hist_particip_partenaires,suivi_partenaires
							$query_maj = "UPDATE salon_suivi_partenaires SET
								dossier_envoye = '".$dossier_envoye."',
								participation_exposition = '".$participation_exposition."',
								participation_agora = '".$participation_agora."',
								interesse_pour_exposition = '".$interesse_pour_exposition."',
								refus_exposition = '".$refus_exposition."',
								logo_sur_affiche = '".$logo_sur_affiche."',
								lien_logo = '".$lien_logo."',
								taille_stand = '".$taille_stand."',
								emplacement_exposition = '".$emplacement_exposition."',
								participation_financiere = '".$participation_financiere."',
								a_traiter = '".$a_traiter_salon."',
								contacte = '".$contacte_salon."',
								handicap = '".$handicap_salon."',
								detail_handicap = '".$detail_handicap_salon."',
								affiche_page_partenaire = '".$affiche_page_partenaire."',
								description_pour_salon = '".$description_pour_salon."',
								afficher_description_salon = '".$afficher_description_salon."'
							WHERE id_societe = '".$id_societe."';";
							$results_maj = mysql_query($query_maj); 
							mysql_close(); 
							echo "<h2>La fiche a été mise à jour&nbsp;!</h2>";
							$action = "affichage";
							$_SESSION['action'] = $action;
						break;
					}
				}
				//Requête pour extraire l'enregistrement souhaité
				 
					include ("../biblio/init.php");
					$query = "SELECT * FROM repertoire WHERE No_societe = '".$id_societe."';";
					$result_consult = mysql_query($query);
					$num_rows = mysql_num_rows($result_consult);
					if (mysql_num_rows($result_consult))
					{
						$ligne=mysql_fetch_object($result_consult);
						$id_societe=$ligne->No_societe;
						$societe=$ligne->societe;
						$adresse=$ligne->adresse;
						$cp=$ligne->cp;
						$ville=$ligne->ville;
						$tel_standard=$ligne->tel_standard;
						$fax=$ligne->fax;
						$internet=$ligne->internet;
						$email=$ligne->email;
						$remarques=$ligne->remarques;
						$editeur=$ligne->editeur;
						$fabricants=$ligne->fabricants;
						$entreprise_de_service=$ligne->entreprise_de_service;
						$presse_specialisee=$ligne->presse_specialisee;
						$a_traiter=$ligne->a_traiter;
						$contacte=$ligne->contacte;
						$a_faire_quand_date=$ligne->a_faire_quand_date;
						$a_faire=$ligne->a_faire;
						$urgent=$ligne->urgent;
						$part_fgmm=$ligne->part_fgmm;
						$part_salon=$ligne->part_salon;
						$nb_pb=$ligne->nb_pb;
						$emetteur=$ligne->emetteur;
						$statut=$ligne->statut;
						$pays = $ligne->pays;
					}
					else
					{
						//Dans le cas où aucun résultats n'est retourné
						echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée ou problème inexistant</B></FONT>";
						switch ($origine)
						{
							case ('filtre') :
								echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
							break;
          
							case ('recherche') :
								echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
							break;
						}
						mysql_close();
						exit;
					}
					switch ($action)
					{
						case ('modif') :
							echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
							echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
								<CAPTION><b>Détails de l'enregistrement à modifier</b></CAPTION>
								<tr CLASS = \"new\">
									<td width = \"40%\">
										Id&nbsp;:&nbsp;$id_societe&nbsp;&nbsp;
										Soci&eacute;t&eacute;&nbsp;:&nbsp;<input type=\"text\" value = \"$societe\" name=\"societe\" size=\"50\">&nbsp;&nbsp;
									</td>
									<td width = \"30%\">";  
										$checked=Testpourcocher($a_traiter);
										echo "à traiter&nbsp;<input type=\"checkbox\" name=\"a_traiter\" value=\"1\" $checked>&nbsp;&nbsp;";
										$checked=Testpourcocher($contacte);
										echo "contact&eacute;&nbsp;<input type=\"checkbox\" name=\"contacte\" value=\"1\" $checked>&nbsp;&nbsp; 
										date&nbsp;(aaaa-mm-jj)&nbsp;:&nbsp;<input type=\"text\" name=\"a_faire_quand_date\" value=\"$a_faire_quand_date\" size=\"19\">&nbsp;&nbsp;";
										$checked=Testpourcocher($urgent); 
										echo "urgent&nbsp;:&nbsp;<input type=\"checkbox\" name=\"urgent\" value=\"1\" $checked>&nbsp;&nbsp; 
									</td>
									<td width = \"30%\">";  
										$checked=Testpourcocher($editeur);
										echo "&eacute;diteur&nbsp;<input type=\"checkbox\" name=\"editeur\" value=\"1\" $checked>&nbsp;&nbsp;";
										$checked=Testpourcocher($fabricants);
										echo "fabricant&nbsp;<input type=\"checkbox\" name=\"fabricants\" value=\"1\" $checked>&nbsp;&nbsp;";
										$checked=Testpourcocher($entreprise_de_service);
										echo "service&nbsp;<input type=\"checkbox\" name=\"entreprise_de_service\" value=\"1\" $checked>&nbsp;&nbsp;";
										$checked=Testpourcocher($presse_specialisee);
										echo "presse&nbsp;<input type=\"checkbox\" name=\"presse_specialisee\" value=\"1\" $checked>
									</td>
								</tr>
								<tr CLASS = \"new\">
									<td colspan=\"3\">
										Adresse&nbsp;:&nbsp;<input type=\"text\" value = \"$adresse\" name=\"adresse\" size=\"78\">&nbsp;
										CP&nbsp;:&nbsp;<input type=\"text\" value = \"$cp\" name=\"cp\" size=\"6\">&nbsp;
										Ville&nbsp;:&nbsp;<input type=\"text\" value = \"$ville\" name=\"ville\" size=\"68\">
										Pays&nbsp;:&nbsp;<input type=\"text\" value = \"$pays\" name=\"pays\" size=\"20\">
									</td>
								</tr>
								<tr CLASS = \"new\">
									<td colspan=\"3\">      
										Site Web&nbsp;:&nbsp;<input type=\"text\" value = \"$internet\" name=\"internet\" size=\"50\">&nbsp;
										t&eacute;l Standard&nbsp;:&nbsp;<input type=\"text\" value = \"$tel_standard\" name=\"tel_standard\" size=\"19\">&nbsp;
										fax&nbsp;:&nbsp;<input type=\"text\" value = \"$fax\" name=\"fax\" size=\"19\">&nbsp;
										m&eacute;l&nbsp;:&nbsp;<input type=\"text\" value = \"$email\" name=\"email\" size=\"30\">
									</td>
								</tr>
							</TABLE>
							<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
								<tr CLASS = \"new\">
									<TD width = \"10%\">Remarques&nbsp;:&nbsp;</TD>
									<TD width = \"90%\"><textarea rows=\"4\" name=\"remarques\" cols=\"100\">$remarques</textarea></TD>
								</tr>";
							$ses_emetteur = $_SESSION['nom'];
							$query_contacts = "SELECT * FROM contacts WHERE id_societe = '".$id_societe."' AND emetteur = '".$ses_emetteur."' OR id_societe = '".$id_societe."' AND emetteur <> '".$ses_emetteur."' AND statut = 'public' ORDER BY NOM ASC;";
							$result_contacts = mysql_query($query_contacts);
							$num_results_contacts = mysql_num_rows($result_contacts);
							if ($num_results_contacts == 0)
							{
								echo "<TR>
									<TD colspan = \"2\"><FONT COLOR = \"#000000\"><B>Pas de contact pour cette société&nbsp;-&nbsp;</B></FONT>
										<A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><FONT COLOR = \"#000000\"><b>Cliquez ici pour ajouter un contact</b></FONT></A>
									</TD>
								</TR>";
							}
							else
							{
								echo "<tr CLASS = \"new\">
									<td colspan=\"2\">
										Contacts &nbsp;:&nbsp;(<A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><FONT COLOR = \"#000000\"><b>Cliquez ici pour ajouter un contact</b></FONT></A>)
										<TABLE align = \"center\" width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
											<tr>
												<td width=\"5%\" align = \"center\"><b>Id</b></td>
												<td width=\"10%\" align = \"center\"><b>Nom</b></td>
												<td width=\"10%\" align = \"center\"><b>Pr&eacute;nom</b></td>
												<td width=\"10%\" align = \"center\"><b>fonction</b></td>
												<td width=\"10%\" align = \"center\"><b>t&eacute;l directe</b></td>
												<td width=\"10%\" align = \"center\"><b>fax</b></td>
												<td width=\"10%\" align = \"center\"><b>mobile</b></td>
												<td width=\"10%\" align = \"center\"><b>m&eacute;l</b></td>
												<td width=\"18%\" align = \"center\"><b>remarques</b></td>
												<td width=\"2%\" align = \"center\"></td>
												<td width=\"5%\" align = \"center\"><b>Actions</b></td>
											</tr>";
										//Affichage des contacts
										$res_contacts = mysql_fetch_row($result_contacts);
										for($i = 0; $i < $num_results_contacts; ++$i)
										{
											echo "<tr CLASS = \"new\">
												<td width=\"5%\" align = \"center\">".$res_contacts[0]."</td>
												<td width=\"10%\">".$res_contacts[2]."</td>
												<td width=\"10%\">".$res_contacts[3]."</td>
												<td width=\"10%\">".$res_contacts[4]."</td>
												<td width=\"10%\" align = \"center\">".$res_contacts[8]."</td>
												<td width=\"10%\" align = \"center\">".$res_contacts[9]."</td>
												<td width=\"10%\" align = \"center\">".$res_contacts[10]."</td>
												<td width=\"10%\">".$res_contacts[11]."</td>
												<td width=\"18%\">".$res_contacts[13]."</td>";
											if ($res_contacts[15] == "privé")
											{
												echo "<td width=\"2%\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"privé\"></td>";
											}
											else
											{
												echo "<td width=\"2%\">&nbsp;</TD>";
											}
						
												echo "<td width=\"5%\" BGCOLOR = \"#48D1CC\">
													<A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_contact=".$res_contacts[0]."&amp;id_societe=".$res_contacts[1]."&amp;action=modif_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le lot\" border=\"0\"></A>";
													if ($res_contacts[14] == $_SESSION['nom'])
													{
														echo "<A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_contact=".$res_contacts[0]."&amp;action=suppression_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer le contact\" border=\"0\"></A>";
													}
												echo "</td>
											</tr>";
											$res_contacts = mysql_fetch_row($result_contacts);
										}
									echo "</table>";
								echo "</td>
							</tr>";
							}
						if ($emetteur == $_SESSION['nom'])
						{
							echo "<tr CLASS = \"new\">
								<TD  colspan=\"2\">Confidentialit&eacute;&nbsp;:&nbsp;
									<select size=\"1\" name=\"statut\">
										<option selected value=\"$statut\">$statut</option>
										<option value=\"public\">Public (visible pour tous)</option>
										<option value=\"privé\">Privé (visible uniquement au propriétaire)</option>
									</select>
								</TD>
							</TR>";
						}
						else
						{
							//il faut charger la variable statut à transmettre pour la mise à jour
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut\" NAME = \"statut\">";
						}
						echo "</table>";
						echo "<TABLE align = \"center\" width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
							echo "<tr CLASS = \"new\">";
							if ($autorisation_genies == "1")
							{
								$checked=Testpourcocher($part_fgmm);
								echo "<td width = \"50%\">$bt_partenaire&nbsp;<input type=\"checkbox\" name=\"part_fgmm\" value=\"1\" $checked></td>";
								$checked=Testpourcocher($part_salon);
								echo "<td width = \"50%\">$bt_participant&nbsp;<input type=\"checkbox\" name=\"part_salon\" value=\"1\" $checked></td>";
							}
							else
							{
								echo "<td width = \"50%\">&nbsp;</td>";
								$checked=Testpourcocher($part_salon);
								echo "<td width = \"50%\">$bt_participant&nbsp;<input type=\"checkbox\" name=\"part_salon\" value=\"1\" $checked></td>";
							}
							echo "</tr>";
						echo "</table>";
						echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
							<TR CLASS = \"new\">
								<TD>A faire&nbsp;:&nbsp;</TD>
								<TD align=\"left\"><textarea rows=\"4\" name=\"a_faire\" cols=\"100\">$a_faire</textarea></TD>
								<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>
							</TR>
						</TABLE>
						<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
					<INPUT TYPE = \"hidden\" VALUE = \"$part_salon\" NAME = \"part_salon\">
					<INPUT TYPE = \"hidden\" VALUE = \"modif\" NAME = \"action\">
						<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
					</FORM>";
					break;

					case ('affichage') :
						echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
						echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
							<CAPTION><b>Détails de l'enregistrement</b></CAPTION>
							<tr CLASS = \"new\">
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Id&nbsp;:&nbsp;</td>
								<td align = \"center\">$id_societe</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Soci&eacute;t&eacute;&nbsp;:&nbsp;</td>
								<td align = \"center\">$societe</td>
								<td align = \"center\">";  
									$checked=Testpourcocher($a_traiter);
									echo "à traiter&nbsp;<input type=\"checkbox\" name=\"a_traiter\" value=\"1\" $checked>
								</td>
								<td align = \"center\">date&nbsp;(aaaa-mm-jj)&nbsp;:&nbsp;<input type=\"text\" name=\"a_faire_quand_date\" value=\"$a_faire_quand_date\" size=\"19\"></td>";
									$checked=Testpourcocher($urgent); 
								echo "<td align = \"center\">urgent&nbsp;:&nbsp;<input type=\"checkbox\" name=\"urgent\" value=\"1\" $checked>&nbsp;&nbsp; 
								</td>
								<td align = \"center\">";
									$checked=Testpourcocher($editeur);
									echo "&eacute;diteur&nbsp;<input type=\"checkbox\" name=\"editeur\" value=\"1\" $checked></td>";
									$checked=Testpourcocher($fabricants);
								echo "<td align = \"center\">fabricant&nbsp;<input type=\"checkbox\" name=\"fabricants\" value=\"1\" $checked></td>";
									$checked=Testpourcocher($entreprise_de_service);
								echo "<td align = \"center\">service&nbsp;<input type=\"checkbox\" name=\"entreprise_de_service\" value=\"1\" $checked></td>";
									$checked=Testpourcocher($presse_specialisee);
								echo "<td align = \"center\">presse&nbsp;<input type=\"checkbox\" name=\"presse_specialisee\" value=\"1\" $checked>
								</td>
							</tr>
						</TABLE>
						<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
							<tr CLASS = \"new\">
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Adresse&nbsp;:&nbsp;</td>
								<td align = \"center\">$adresse&nbsp;</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">CP&nbsp;:&nbsp;</td>
								<td align = \"center\">$cp</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Ville&nbsp;:&nbsp;</td>
								<td align = \"center\">$ville</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Pays&nbsp;:&nbsp;</td>
								<td align = \"center\">$pays</td>
							</tr>
						</TABLE>
						<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
							<tr CLASS = \"new\">
								<td BGCOLOR = \"#48D1CC\" align = \"right\">Site Web&nbsp;:&nbsp;</td>
								<td align = \"center\"><a href=\"$internet\" target=\"_blank\">$internet</a></td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">t&eacute;l Standard&nbsp;:&nbsp;</td>";
								$tel_standard = affiche_tel($tel_standard);
								echo "<td align = \"center\">$tel_standard</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">fax&nbsp;:&nbsp;</td>
								<td align = \"center\">$fax</td>
								<td BGCOLOR = \"#48D1CC\" align = \"right\">m&eacute;l&nbsp;:&nbsp;</td>
								<td align = \"center\">$email</td>
							</tr>
						</TABLE>";
            if ($remarques <> "")
            {
              echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
                <tr CLASS = \"new\">
                  <TD BGCOLOR = \"#48D1CC\" align = \"right\" width = \"10%\">Remarques&nbsp;:&nbsp;</TD>
                  <TD width = \"90%\">$remarques</TD>
		            </tr>
              </TABLE>";
            }
            
            echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
            //Affichage des contacts par rapport à l'enregistrement affiché
            $page_retour = "repertoire_consult_fiche.php";
            if (!ISSET($affiche_contacts))
            {
              $affiche_contacts = "oui";
            }
            include ("affiche_contacts.inc.php");
            
            
              if ($emetteur == $_SESSION['nom'])
              {
                echo "<tr CLASS = \"new\">
                  <TD  colspan=\"2\">Confidentialit&eacute;&nbsp;:&nbsp;
                  <select size=\"1\" name=\"statut\">
		                      <option selected value=\"$statut\">$statut</option>
			                    <option value=\"public\">Public (visible pour tous)</option>
			                    <option value=\"privé\">Privé (visible uniquement au propriétaire)</option>
			                  </select>
                  </TD>
                </TR>";
							}
							echo "<tr CLASS = \"new\">";
							if ($autorisation_genies == "1")
							{
								$checked=Testpourcocher($part_fgmm);
								echo "<td width = \"50%\">$bt_partenaire&nbsp;<input type=\"checkbox\" name=\"part_fgmm\" value=\"1\" $checked></td>";
								$checked=Testpourcocher($part_salon);
								echo "<td width = \"50%\">$bt_participant&nbsp;<input type=\"checkbox\" name=\"part_salon\" value=\"1\" $checked></td>";
							}
							else
							{
								echo "<td width = \"50%\">&nbsp;</td>";
								$checked=Testpourcocher($part_salon);
								echo "<td width = \"50%\">$bt_participant&nbsp;<input type=\"checkbox\" name=\"part_salon\" value=\"1\" $checked></td>";
							}
							echo "</tr>";
						echo "</table>";
						echo "
						<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
              <TR CLASS = \"new\">
                <TD>A faire&nbsp;:&nbsp;</TD>
                <TD align=\"left\"><textarea rows=\"4\" name=\"a_faire\" cols=\"100\">$a_faire</textarea></TD>
				        <TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>
			       </TR>
						</TABLE>";
						if ($emetteur <> $_SESSION['nom'])
						{
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut\" NAME = \"statut\">";
						}
						echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
					<INPUT TYPE = \"hidden\" VALUE = \"affichage\" NAME = \"action\">
					<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
					</FORM>";
            
            		echo "
    <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
      <TR>";
        if ($part_fgmm == "1") //on regarde si cet enregistrement est marqué être partenaire du festival des Génies du Multimédia
        {
          if ($affiche_FGMM <> "O")
          {
            echo "<TD width = \"25%\" align = \"center\"><A HREF=\"repertoire_consult_fiche.php?affiche_FGMM=O&amp;affiche_salon=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N\" target=\"body\"><FONT COLOR = \"#000000\"><b>Afficher les détails pour $bt_manifestation</b></FONT></A></TD>";
          }
          else
          {
            echo "<TD width = \"25%\" align = \"center\" CLASS = \"new\"><A HREF=\"repertoire_consult_fiche.php?affiche_FGMM=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Cacher les détails pour $bt_manifestation</b></FONT></A></TD>";
          }
        }
        else
        {
          echo "<TD width = \"25%\" align = \"center\">&nbsp;";
        }

        if ($part_salon == "1") //on regarde si cet enregistrement est marqué être exposant des différentes manifestations
        {
          if ($affiche_salon <> "O")
          {
            echo "<TD width = \"25%\" align = \"center\"><A HREF=\"repertoire_consult_fiche.php?affiche_salon=O&amp;affiche_FGMM=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N\" target=\"body\"><FONT COLOR = \"#000000\"><b>Afficher les détails pour $bt_salon</b></FONT></A></TD>";
          }
          else
          {
            echo "<TD width = \"25%\" align = \"center\" CLASS = \"new\"><A HREF=\"repertoire_consult_fiche.php?affiche_salon=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Cacher les détails pour $bt_salon</b></FONT></A></TD>";
          }
        }
        else
        {
          echo "<TD width = \"25%\" align = \"center\">&nbsp;";
        }

        if ($affiche_tickets <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
        {
          echo "<TD width = \"25%\" align = \"center\"><A HREF=\"repertoire_consult_fiche.php?affiche_tickets=O&amp;affiche_FGMM=N&amp;affiche_salon=N&amp;affiche_tickets_archives=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Afficher les tickets en cours</b></FONT></A></TD>";
        }
        else
        {
          echo "<TD width = \"25%\" align = \"center\" CLASS = \"new\"><A HREF=\"repertoire_consult_fiche.php?affiche_tickets=N&amp;affiche_FGMM=$affiche_FGMM\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Cacher les tickets en cours</b></FONT></A></TD>";
        }
        
        if ($affiche_tickets_archives <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
        {
          echo "<TD width = \"25%\" align = \"center\"><A HREF=\"repertoire_consult_fiche.php?affiche_tickets_archives=O&amp;affiche_tickets=N&amp;affiche_FGMM&amp;affiche_salon=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Afficher les tickets archiv&eacute;s</b></FONT></A></TD>";
        }
        else
        {
          echo "<TD width = \"25%\" align = \"center\" CLASS = \"new\"><A HREF=\"repertoire_consult_fiche.php?affiche_tickets_archives=N&amp;affiche_tickets=$affiche_tickets&amp;affiche_FGMM\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\"><b>Cacher les tickets archiv&eacute;s</b></FONT></A></TD>";
        }
        echo "</TR>
		</TABLE>";
		//echo "<BR>affiche_tickets : $affiche_tickets";
	////////////////////////////////////////////////////////////
	//Affichage de la partie gestion tickets
	if ($affiche_tickets == "O")
	{
    $origine_tickets = "REP"; //permet de sélectionner le bon filtre dans la requête MySQL dans le fichier inclus
    include ("affiche_tickets.inc.php");
  }
//Fin de l'affichage de la partie Gestion tickets
	//////////////////////////////////////////////////////////////
	
//////////////////////////////////////////////////////////
//Affichage de la partie Festival des Génies du Multimédia	
	if ($affiche_FGMM == "O")
	{
		include ("repertoire_affiche_details_fgmm.inc.php");
	}
///////////////////////////////////////////////////////////////////////
//Fin de l'affichage de la partie Festival des Génies du Multimédia

//////////////////////////////////////////////////////////
//Affichage de la partie Rencontres TICE 2008
	if ($affiche_salon == "O")
	{
		include ("repertoire_affiche_details_salon.inc.php");
	}
///////////////////////////////////////////////////////////////////////
//Fin de l'affichage de la partie Festival des Génies du Multimédia

	//Affichage de la partie gestion des tickets archivés
	if ($affiche_tickets_archives == "O")
	{
    $origine_tickets = "REP"; //permet de sélectionner le bon filtre dans la requête MySQL dans le fichier inclus
    include ("ecl_affiche_tickets_archives.inc.php");
  }
	         //Fin de l'affichage de la partie Gestion tickets
	         //////////////////////////////////////////////////////////////
	        
  
  //Les variables à passer pour les modifications				  
            /*
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[7]."\" NAME = \"date_creation\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[5]."\" NAME = \"sujet\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[3]."\" NAME = \"emetteur\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[2]."\" NAME = \"mail_emetteur\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[10]."\" NAME = \"intervenant\">";
            echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[15]."\" NAME = \"TRAITE_PAR\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"$priorite_dans_base\" NAME = \"priorite_dans_base\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_traitement_dans_base\" NAME = \"statut_traitement_dans_base\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_dans_base\" NAME = \"statut_dans_base\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
			      echo "<INPUT TYPE = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
			      
			      //echo "<INPUT TYPE = \"hidden\" VALUE = \"".$res[6]."\" NAME = \"contenu\">";
            */ 
					break;
        }
        //Le bouton retour
        //echo "<BR>Coucou";
        /*
        switch ($origine_gestion)
				{
          case ('filtre') :
            echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
          break;
          
          case ('recherche') :
            echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
          break;
        }
        */
        if (($action == "modif") OR ($action == "affichage"))
        {
          echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
        } 
        					
			?>
		</CENTER>
	</BODY>
</HTML>
