<?php
	//Lancement de la session
	session_start();

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
	$_SESSION['origine'] = "ecl_consult_fiche";
	$origine = $_SESSION['origine']; 

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_ecl.png\" ALT = \"Titre\">";
			//Inclusion des fichiers n&eacute;cessaires

			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			$nb_par_page = 12; //variable qui fixe le nombre de lignes affich&eacute;es

			//R&eacute;cup&eacute;ration des variables n&eacute;cessaires au fonctionnement du script
			$origine_gestion = $_SESSION['origine_gestion']; //permet de r&eacute;cup&eacute;rer l'origine dans le fichier repertoire_gestion pour afficher la même chose en y retournat
			$id_societe = $_GET['id_societe']; //n&eacute;cessaire pour la consultation des tickets
			$action = $_GET['action'];
			$CHGMT = $_GET['CHGMT']; //Indique si un changement est intervenu lors des formulaires en fin der fichier
			$affiche_suivis_dossier = $_GET['affiche_suivis_dossier']; //pour savoir s'il faut afficher les suivis 
			$affiche_suivis_dossier_archives = $_GET['affiche_suivis_dossier_archives']; //pour savoir s'il faut afficher les suivis archivés
			$affiche_personnes_ressources = $_GET['affiche_personnes_ressources']; //pour savoir s'il faut afficher les personnes ressources
			$affiche_formations = $_GET['affiche_formations']; //pour savoir s'il faut afficher les formations				
			$affiche_tbi = $_GET['affiche_tbi']; //pour savoir s'il faut afficher les tickets de la soci&eacute;t&eacute; choisie
			$affiche_tickets = $_GET['affiche_tickets']; //pour savoir s'il faut afficher les tickets de la soci&eacute;t&eacute; choisie
			$affiche_tickets_archives = $_GET['affiche_tickets_archives']; //pour savoir s'il faut afficher les tickets de la soci&eacute;t&eacute; choisie
			$affiche_contacts = $_GET['affiche_contacts']; //pour savoir si on affiche les contacts ou non
			$module = "FOR";
			$dossier = $dossier_docs_formation;
			$deverrouiller = $_GET['deverrouiller']; //Pour savoir si quelqu'un foce le d&eacute;verrouillage d'un ticket
			$idpb = $_GET['idpb'];

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

			if (!ISSET($affiche_suivis_dossier))
			{
				$affiche_suivis_dossier = $_SESSION['affiche_suivis_dossier'];
			}
			else
			{
				$_SESSION['affiche_suivis_dossier'] = $affiche_suivis_dossier;
			}

			if (!ISSET($affiche_suivis_dossier_archives))
			{
				$affiche_suivis_dossier_archives = $_SESSION['affiche_suivis_dossier_archives'];
			}
			else
			{
				$_SESSION['affiche_suivis_dossier_archives'] = $affiche_suivis_dossier_archives;
			}

			if (!ISSET($affiche_personnes_ressources))
			{
				$affiche_personnes_ressources = $_SESSION['affiche_personnes_ressources'];
			}
			else
			{
				$_SESSION['affiche_personnes_ressources'] = $affiche_personnes_ressources;
			}

			if (!ISSET($affiche_formations))
			{
				$affiche_formations = $_SESSION['affiche_formations'];
			}
			else
			{
				$_SESSION['affiche_formations'] = $affiche_formations;
			}

			if (!ISSET($affiche_tbi))
			{
				$affiche_tbi = $_SESSION['affiche_tbi'];
			}
			else
			{
				$_SESSION['affiche_tbi'] = $affiche_tbi;
			}

			if (!ISSET($affiche_tickets))
			{
				$affiche_tickets = $_SESSION['affiche_tickets'];
			}
			else
			{
				$_SESSION['affiche_tickets'] = $affiche_tickets;
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
			$ses_affiche_personnes_ressources = $_SESSION['affiche_personnes_ressources'];
			$ses_affiche_formations = $_SESSION['affiche_formations'];
			$ses_affiche_tickets = $_SESSION['affiche_tickets'];

			echo "<br />variables ordinaires : id_societe : $id_societe - changement : $CHGMT - action : $action - affiche_tickets : $affiche_tickets - affiche_personnes_ressources : $affiche_personnes_ressources - affiche_formations : $affiche_formations";
			echo "<br />variables sessions : id_societe : $ses_id_societe - action : $ses_action - affiche_tickets : $ses_affiche_tickets - affiche_personnes_ressources : $ses_affiche_personnes_ressources - affiche_formations : $ses_affiche_formations";
			*/
			//enregistrement s'il y a des changements dans le formulaire

			if($CHGMT=="O") // Des modifications ont &eacute;t&eacute; apport&eacute;es
			{
				//R&eacute;cup&eacute;ration des variables communes
				$a_traiter = $_GET['a_traiter'];
				$a_faire_quand_date = $_GET['a_faire_quand_date'];
				$urgent = $_GET['urgent'];
				$editeur = $_GET['editeur'];
				$fabricants = $_GET['fabricants'];
				$entreprise_de_service = $_GET['entreprise_de_service'];
				$presse_specialisee = $_GET['presse_specialisee'];
				$part_fgmm = $_GET['part_fgmm'];
				$a_faire = $_GET['a_faire'];
				$statut = $_GET['statut'];
				//echo "<br />id_societe : $id_societe";

				switch ($action)
				{
					case ('affiche_contact') :
						echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_affiche_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"ecl_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('modif_contact') :
						echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_modif_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"ecl_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_contact_modifie') : //enregistrement d'un lot modifi&eacute;
						include ("contacts_enreg_fiche_modifie.inc.php");
						$affiche_message_contact = "O";
						$message_a_afficher = "Le contact ".$id_contact." a &eacute;t&eacute; modifi&eacute;.";
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_contact') :
						include ("../biblio/init.php");
						echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							$affiche_societe = "N"; //il n'est pas n&eacute;cessaire d'afficher la liste des &eacute;tablissements dans le formulaire suivant
							include ("contacts_ajout_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"ecl_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_contact_ajoute') : //enregistrement d'un lot modifi&eacute;
						include ("contacts_enreg_fiche.inc.php");
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('suppression_contact') :
						echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							include ("contacts_suppression_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"ecl_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('confirm_suppression_contact') :
						include ("contacts_confirmation_suppression_fiche.inc.php");
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_formation') :
						//R&eacute;cup&eacute;ration de l'identifiant de l'&eacute;tablissement
						$id_societe = $_GET['id_societe'];
						//Affichage du formulaire pour la saisie d'une formation
						echo "<h2>Formation &agrave; ajouter</h2>";
						echo "<table width = \"95%\">
							<caption><b></caption>
							<tr>
								<td width=\"10%\" align=\"center\">Ann&eacute;e scolaire</td>
								<td width=\"10%\" align=\"center\">Type</td>";
								/*
								<td width=\"15%\" align=\"center\">niveau</td>
								<td width=\"5%\" align=\"center\">promis</td>
								<td width=\"5%\" align=\"center\">reçu</td>
								<td width=\"5%\" align=\"center\">mat&eacute;riel</td>
								*/
								echo "<td width=\"10%\" align=\"center\">Valider</td>";
							echo "</tr>";

						echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
							echo "<tr>
								<!--td width=\"10%\" align = \"center\"><input type=\"text\" value = \"".$annee_scolaire." \" name=\"annee_scolaire_formulaire\" size = \"10\"></td-->";
								echo "<td width=\"10%\" align=\"center\">
									<select size=\"1\" name=\"annee_scolaire_formulaire\">
										<option selected value=\"$annee_scolaire\">$annee_scolaire</option>";
										if ($annee_scolaire<>"2006-2007")
										{
											echo "<option value=\"2006-2007\">2006-2007</option>";
										}
										if ($annee_scolaire<>"2007-2008")
										{
											echo "<option value=\"2007-2008\">2007-2008</option>";
										}
										if ($annee_scolaire<>"2008-2009")
										{
											echo "<option value=\"2008-2009\">2008-2009</option>";
										}
										if ($annee_scolaire<>"2009-2010")
										{
											echo "<option value=\"2009-2010\">2009-2010</option>";
										}
										if ($annee_scolaire<>"2010-2011")
										{
											echo "<option value=\"2010-2011\">2010-2011</option>";
										}
										if ($annee_scolaire<>"2011-2012")
										{
											echo "<option value=\"2011-2012\">2011-2012</option>";
										}
										if ($annee_scolaire<>"2012-2013")
										{
											echo "<option value=\"2012-2013\">2012-2013</option>";
										}
										if ($annee_scolaire<>"2013-2014")
										{
											echo "<option value=\"2013-2014\">2013-2014</option>";
										}
										if ($annee_scolaire<>"2014-2015")
										{
											echo "<option value=\"2014-2015\">2014-2015</option>";
										}
									echo "</select>";
								echo "<td width=\"10%\" align=\"center\">
									<select size=\"1\" name=\"type_formation\">
										<option selected value=\"transversale\">transversale</option>
										<option value=\"disciplinaire\">disciplinaire</option>
										<option value=\"autre\">autre</option>
									</select>";
								/*
								echo "</td>";
								echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"promis\" value=\"1\" checked></td>";
								echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"recu\" value=\"1\"</td>";
								echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"materiel\" value=\"1\"</td>";
								*/
								echo "<td width=\"10%\" BGCOLOR = \"#48D1CC\" align = \"center\">
									<input border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
								</td>
							</tr>
						</table>
						<input type = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
						<input type = \"hidden\" VALUE = \"enreg_formation_ajoute\" NAME = \"action\">
						<input type = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
						</form>";
						echo "<br /><a href = \"ecl_consult_fiche.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_formation_ajoute') : //enregistrement d'une formation
						//R&eacute;cup&eacute;ration des variables de la formation &agrave; enregistrer
						$id_societe = $_GET['id_societe'];
						$type_formation = $_GET['type_formation'];
						$annee_scolaire_formulaire = $_GET['annee_scolaire_formulaire'];
						//$promis = $_GET['promis'];
						//$recu = $_GET['recu'];
						//$materiel = $_GET['materiel'];
						//$niveau = $_GET['niveau'];
              
						//Mise &agrave; jour de la fiche
						include("../biblio/init.php");
						$query = "INSERT INTO formations (annee_scolaire, type_formation, rne) 
							VALUES ('".$annee_scolaire_formulaire."', '".$type_formation."', '".$id_societe."');";
						$results = mysql_query($query);
						//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
						if(!$results)
						{
							echo "<B>Erreur de connexion &agrave; la base de donn&eacute;es ou erreur de requ&egrave;te</B>";
							//echo "<br /> <a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</a>";
							mysql_close();
							//exit;
						}
						else
						{
							$affiche_message_formation = "O";
							$message_a_afficher = "La formation $id_lot a &eacute;t&eacute; ajout&eacute;e.";
						}
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('suppression_formation') :
						$script = "ecl_consult_fiche";
						include ("ecl_suppression_formation.inc.php");
					break;

					case ('confirm_suppression_formation') :
						include ("ecl_confirm_suppression_formation.inc.php");
						//Dans le cas où aucun r&eacute;sultat n'est retourn&eacute;
						if(!$result)
						{
							echo "<B>Erreur de connexion &agrave; la base de donn&eacute;es ou erreur de requ&egrave;te</B>";
							//echo "<br /> <a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</a>";
							mysql_close();
							//exit;
						}
						else
						{
							$affiche_message_formation = "O";
							$message_a_afficher = "La formation $id_formation a &eacute;t&eacute; supprim&eacute;e.";
						}
						$action = "affichage";
						$_SESSION['action'] = $action;
						//echo "<br />id_formation : $id_formation";
						//il faut &eacute;galement supprimer les entr&eacute;es dans la table documents concernant la formation supprim&eacute;e
						efface_documents_joints($id_formation,$module,$dossier); //Fonction qui supprime les fichiers du disue et qui efface les entr&eacute;e dans la table documents
					break;

					case ('modif_formation') :
						include ("ecl_modif_formation.inc.php");
					break;

					case ('enreg_formation_modifie') : //enregistrement d'une formation modifi&eacute;e
						include ("ecl_enreg_formation_modifie.inc.php");
						$affiche_message_formation = "O";
						$message_a_afficher = "La formation ".$id_formation." a &eacute;t&eacute; modifi&eacute;.";
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_document') : //enregistrement d'un document
						$script = "ecl_consult_fiche";
						$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						$annee = $_GET['annee'];
						$type = $_GET['type'];
						$id_formation = $_GET['id_formation'];
						$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];
						//echo "<h2>D&eacute;pôt de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour &eacute;viter que le ticket s'affiche
						include ("choix_fichier.inc.php");
					break;

					case ('ajout_enquete_tbi') :
						$script = "ecl_consult_fiche";
						//$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						//$annee = $_GET['annee'];
						//$type = $_GET['type'];
						//$id_formation = $_GET['id_formation'];
						//$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];
						//echo "<h2>D&eacute;pôt de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour &eacute;viter que le ticket s'affiche
						include("../biblio/init.php");
						include ("choix_fichier.inc.php");
					break;

					case ('enreg_enquete_tbi_ajoute') : //enregistrement d'une enquête TBI
					break;

				} //fin switch action
			}
			//D&eacute;but de la partie centrale du script : Requête pour extraire l'enregistrement souhait&eacute;
			include ("../biblio/init.php");
			//Si jamais il faut d&eacute;verrouiller manuellement un ticket
			if ($deverrouiller == 'Oui')
			{
				deverouiller($idpb);
			}
			$query = "SELECT * FROM etablissements WHERE RNE = '".$id_societe."';";
			$result_consult = mysql_query($query);
			$num_rows = mysql_num_rows($result_consult);
			if (mysql_num_rows($result_consult))
			{
				$ligne=mysql_fetch_object($result_consult);
				$rne=$ligne->RNE;
				$type=$ligne->TYPE;
				$secteur=$ligne->PUBPRI;
				$nom=$ligne->NOM;
				$adresse=$ligne->ADRESSE;
				$cp=$ligne->CODE_POSTAL;
				$ville=$ligne->VILLE;
				$tel=$ligne->TEL;
				$fax=$ligne->FAX;
				$internet=$ligne->INTERNET;
				$email=$ligne->MAIL;
				$type_etab_gen=$ligne->TYPE_ETAB_GEN;
				$nb_pb=$ligne->NB_PB;
				$circonscription=$ligne->CIRCONSCRIPTION;
			}
			else
			{
				//Dans le cas où aucun r&eacute;sultat n'est retourn&eacute;
				echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</B>";
				switch ($origine)
				{
					case ('filtre') :
						echo "<br /><a href = \"ecl_gestion_ecl.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('recherche') :
						echo "<br /><a href = \"ecl_gestion_ecl.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;
				}
				mysql_close();
				exit;
			}

			switch ($action)
			{
				case ('affichage') :
					echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
					echo "<h2>D&eacute;tails de l'enregistrement</h2>";
					echo "<table width=\"95%\">
						<caption></caption>
						<tr>
							<td class = \"etiquette\">RNE&nbsp;:&nbsp;</td>
							<td>&nbsp;$rne</td>
							<td class = \"etiquette\">Type&nbsp;:&nbsp;</td>
							<td>&nbsp;$type</td>
							<td class = \"etiquette\">D&eacute;nommination&nbsp;:&nbsp;</td>
							<td>&nbsp;$nom</td>
							<td class = \"etiquette\">Secteur&nbsp;:&nbsp;</td>
							<td>&nbsp;$secteur</td>
						</tr>

						<tr>
							<td class = \"etiquette\">Adresse&nbsp;:&nbsp;</td>
							<td>&nbsp;$adresse&nbsp;</td>
							<td class = \"etiquette\">CP&nbsp;:&nbsp;</td>
							<td>&nbsp;$cp</td>
							<td class = \"etiquette\">Ville&nbsp;:&nbsp;</td>
							<td colspan = \"3\">&nbsp;$ville</td>
						</tr>
					<!--/table>
					<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\"-->
						<tr>
							<td class = \"etiquette\">t&eacute;l Standard&nbsp;:&nbsp;</td>
							<td>&nbsp;$tel</td>
							<td class = \"etiquette\">fax&nbsp;:&nbsp;</td>
							<td>&nbsp;$fax</td>
							<td class = \"etiquette\">m&eacute;l&nbsp;:&nbsp;</td>
							<td colspan = \"3\">&nbsp;$email</td>
						</tr>
						<tr>
							<td class = \"etiquette\">Site Web&nbsp;:&nbsp;</td>
							<td colspan = \"7\"><a href=\"$internet\" target=\"_blank\">&nbsp;$internet</a></td>
						</tr>";
						
						//On affiche les PerDirs
						$responsable1 = recupPerDir(1,$rne,$annee_scolaire);
						$responsable2 = recupPerDir(2,$rne,$annee_scolaire);
						//On fait de même pour les années antérieures, sachant que la première année scoalire et 2012-2013
						$intervalle = $annee_en_cours-2012;

						//if ($responsable1[0] <> "" OR $responsable2[0] <> "")
						//{
							echo "<tr>";
									//On détermine l'étiquette à afficher
									switch ($responsable1[3])
									{
										case "DIR" :
											if ($responsable1[4] == "MME")
											{
												$etiquette_resp1 = "Directrice";
											}
											else
											{
												$etiquette_resp1 = "Directeur";
											}
											break;
										case "PRINC" :
											if ($responsable1[4] == "MME")
											{
												$etiquette_resp1 = "Principale";
											}
											else
											{
												$etiquette_resp1 = "Principal";
											}
											break;
										case "PROV" :
											if ($responsable1[4] == "MME")
											{
												$etiquette_resp1 = "Proviseure";
											}
											else
											{
												$etiquette_resp1 = "Proviseur";
											}
											break;
									}
									//echo "<td class = \"etiquette\">$etiquette_resp1&nbsp;:&nbsp;</td>";
									echo "<td class = \"etiquette\">PROV / PRINC / DIR &nbsp;:&nbsp;</td>";
									echo "<td>";
										if ($responsable1[0] <>"")
										{
												echo "&nbsp;$responsable1[0], $responsable1[1] ($responsable1[2])";
										}
										//On ajoute les personnes des autres années
										for ($i = $annee_en_cours-1; $i >= $annee_en_cours-$intervalle; $i--)
										{
											//On recompose l'année scolaire
											$annee_suivante = $i+1;
											$annee_scolaire_a_recuperer = $i."-".$annee_suivante;
											$responsable1 = recupPerDir(1,$rne,$annee_scolaire_a_recuperer);
											if ($responsable1[0] <>"")
											{
												echo "<br />&nbsp;$responsable1[0], $responsable1[1] ($responsable1[2])";
											}
										}
									echo "</td>";
/*
									else
									{
										echo "<td>&nbsp;</td>";
									}
*/
									//On détermine l'étiquette à afficher
									if ($responsable2[4] == "MME")
									{
										$etiquette_resp2 = "Adjointe";
									}
									else
									{
										$etiquette_resp2 = "Adjoint";
									}
									//echo "<td class = \"etiquette\">$etiquette_resp2&nbsp;:&nbsp;</td>";
									echo "<td class = \"etiquette\">ADJOINT-E&nbsp;:&nbsp;</td>";

									echo "<td colspan = \"5\">";
									if ($responsable2[0] <>"")
									{
										echo "&nbsp;$responsable2[0], $responsable2[1] ($responsable2[2])";
									}
										for ($i = $annee_en_cours-1; $i >= $annee_en_cours-$intervalle; $i--)
										{
											//On recompose l'année scolaire
											$annee_suivante = $i+1;
											$annee_scolaire_a_recuperer = $i."-".$annee_suivante;
											$responsable2 = recupPerDir(2,$rne,$annee_scolaire_a_recuperer);
											if ($responsable2[0] <>"")
											{
												echo "<br />&nbsp;$responsable2[0], $responsable2[1] ($responsable2[2])";
											}
										}
									echo "</td>";
									/*
									}
									else
									{
										echo "<td>&nbsp;</td>";
									}
									*/
								echo "</tr>";
						//}
						//On regarde si l'ECL dispose de l'ENT
						$test_ent = test_ent($rne);
						if ($test_ent <> "O")
						{
							//On recupère les champs à afficher
							$date_entree = lecture_table_ent(date_entree,$rne);
							$vague  = lecture_table_ent(vague,$rne);
							$nom_ent  = lecture_table_ent(nom_ent,$rne);
							echo "<tr>";
								echo "<td class = \"etiquette\">ENT&nbsp;:&nbsp;</td>";
								echo "<td>&nbsp;$nom_ent</td>";
								echo "<td class = \"etiquette\">Date entr&eacute;e ENT&nbsp;:&nbsp;</td>";
								echo "<td>&nbsp;$date_entree</td>";
								echo "<td class = \"etiquette\">Vague&nbsp;:&nbsp;</td>";
								echo "<td colspan = \"3\">&nbsp;$vague</td>";
							echo "</tr>";
						}

						//Champs &agrave; afficher quand le fichier des personnels d'encadrement est en place
						/*
						echo "<tr CLASS = \"new\">";
						if ($type_etab_gen == 'ECOLE' OR $type_etab_gen == 'CRDP' OR $type_etab_gen == 'CDDP')
						{
							echo "<td class = \"etiquette\">directeur/trice&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'LYCEE' OR $type_etab_gen == 'LP')
						{
							echo "<td class = \"etiquette\">proviseur-e&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'COLLEGE')
						{
							echo "<td class = \"etiquette\">principal-e&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'CIRC')
						{
							echo "<td class = \"etiquette\">IEN de circonscription&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'IA')
						{
							echo "<td class = \"etiquette\">IA-DSDEN&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'RECTORAT')
						{
							echo "<td class = \"etiquette\">chef-fe de division&nbsp;:&nbsp;</td>";
						}
						elseif ($type_etab_gen == 'UNIVERSITE')
						{
							echo "<td class = \"etiquette\">pr&eacute;sident-e&nbsp;:&nbsp;</td>";
						}
						else
						{
							echo "<td class = \"etiquette\">directeur/trice / responsable&nbsp;:&nbsp;</td>";
						}
						echo "<td align = \"center\" colspan = \"5\">&nbsp;</td>
					</tr>
					<tr CLASS = \"new\">
						<td class = \"etiquette\">adjoint-e&nbsp;:&nbsp;</td>
						<td align = \"center\" colspan = \"5\">&nbsp;</td>
					</tr>
					<tr CLASS = \"new\">
						<td class = \"etiquette\">gestionnaire&nbsp;:&nbsp;</td>
						<td align = \"center\" colspan = \"5\">&nbsp;</td>
					</tr>";
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					*/
					echo "<!--tr CLASS = \"new\">
						<td class = \"etiquette\">Renseignements r&eacute;seau&nbsp;:&nbsp;</td>
						<td align = \"center\" colspan = \"5\">Eole / Eole+ ; Date de mise en oeuvre (&agrave; renseigner)</td>
					</tr>
					<tr>
						<td class = \"etiquette\">DMZ&nbsp;:&nbsp;</td>
						<td align = \"center\" colspan = \"5\">Oui / Non ; quelles applications ; Date de mise en oeuvre (&agrave; renseigner)</td>
					</tr-->
					</table>";

					echo "<table width=\"95%\">";
						//Affichage des contacts par rapport &agrave; l'enregistrement affich&eacute;
						$page_retour = "ecl_consult_fiche.php";
						if (!ISSET($affiche_contacts))
						{
							$affiche_contacts = "non";
						}
						include ("affiche_contacts.inc.php");
						//$colonne1 = "16%";
						//$colonne2 = "14%";
						echo "</table>";
						echo "<table width=\"95%\" class = \"menu-boutons\">";
						echo "<tr>";

							if (verif_appartenance_groupe(25)) //Suivi dossiers
							{
								if ($affiche_suivis_dossier <> "O")
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=O&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier.png\" ALT = \"Afficher les suivis\" title=\"Afficher les suivis\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les suivis</span><br /></td>";
								}
								else
								{
									echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_cacher.png\" ALT = \"Cacher suivis\" title=\"Cacher les suivis\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les suivis</span><br /></td>";
								}

								if ($affiche_suivis_dossier_archives <> "O")
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=O&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_archives.png\" ALT = \"Afficher les suivis\" title=\"Afficher les suivis archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les suivis archiv&eacute;s</span><br /></td>";
								}
								else
								{
									echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_archives_cacher.png\" ALT = \"Cacher suivis\" title=\"Cacher les suivis archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les suivis archiv&eacute;s</span><br /></td>";
								}
							}

							if (verif_appartenance_groupe(9)) //personnes ressources
							{
								if ($affiche_personnes_ressources <> "O")
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=O&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Afficher pers. ressources\" title=\"Afficher les personnes ressources\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les personnes ressources</span><br /></td>";
									//echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_personnes_ressources=O&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\"><FONT COLOR = \"#000000\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Afficher pers. ressources\" title=\"Afficher les personnes ressources\" border = \"0\"></FONT></a></td>";
								}
								else
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources_cacher.png\" ALT = \"Cacher pers. ressources\" title=\"Cacher les personnes ressources\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les personnes ressources</span><br /></td>";
									//echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_personnes_ressources=N&amp;affiche_formations=$affiche_formations&amp;affiche_tickets=$affiche_tickets&amp;affiche_tickets=$affiche_tickets_archives&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources_cacher.png\" ALT = \"Cacher pers. ressources\" title=\"Cacher les personnes ressources\" border = \"0\"></FONT></a></td>";
								}
							}
							else
							{
								echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Afficher pers. ressources, acc&egrave;s non autoris&eacute;\" title=\"Afficher les personnes ressources, acc&egrave;s non autoris&eacute;\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les personnes ressources, acc&egrave;s<br />non autoris&eacute;</span><br /></td>";
								//echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Afficher pers. ressources, acc&egrave;s  non autoris&eacute;\" title=\"Afficher les personnes ressources, acc&egrave;s non autoris&eacute;\" border = \"0\"></td>";
							}
							//echo "<td class = \"etiquette\" >Personnes ressources&nbsp;:&nbsp;</td>";

							if (verif_appartenance_groupe(5)) //formation
							{
								if ($affiche_formations <> "O") //on affiche ou on cache les formùations concernant cet enregistrement
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=O&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations\" title=\"Afficher les formations\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les formations</span><br /></td>";
									//echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_formations=O&amp;affiche_personnes_ressources=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\" class = \"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations\" title=\"Afficher les formations\" border = \"0\"></a></td>";
								}
								else
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations_cacher.png\" ALT = \"Cacher formations\" title=\"Cacher les formations\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les formations</span><br /></td>";
									//echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_formations=N&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_tickets=$affiche_tickets&amp;affiche_tickets=$affiche_tickets_archives&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations_cacher.png\" ALT = \"Cacher formations\" title=\"Cacher les formations\" border = \"0\"></a></td>";
								}
							}
							else
							{
								echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations, acc&egrave;s non autoris&eacute;\" title=\"Afficher les formations, acc&egrave;s non autoris&eacute;\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les formations, acc&egrave;s<br />non autoris&eacute;</span><br /></td>";
								//echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations, acc&egrave;s non autoris&eacute;\" title=\"Afficher les formations, acc&egrave;s non autoris&eacute;\" border = \"0\"></td>";
							}

							if ($affiche_tbi <> "O") //on affiche ou on cache les informations concernant les TBI
							{
								echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=O&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tbi.png\" ALT = \"Afficher Enqu&ecirc;tes TBI\" title=\"Afficher les Enqu&ecirc;tes TBI\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les enqu&ecirc;tes TBI</span><br /></td>";
								//echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_tbi=O&amp;affiche_tickets_archives=N&amp;affiche_tickets=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Enqu&ecirc;tes TBI</b></FONT></a></td>";
							}
							else
							{
								echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tbi_cacher.png\" ALT = \"Cacher enqu&ecirc;tes TBI\" title=\"Cacher les enqu&ecirc;tes TBI\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les enqu&ecirc;tes TBI</span><br /></td>";
								//echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_tbi=N&amp;affiche_tickets_archives=$affiche_tickets_archives&amp;affiche_tickets=$affiche_tickets&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Enqu&ecirc;tes TBI</b></FONT></a></td>";
							}

							if (verif_appartenance_groupe(18)) //gestion tickets
							{
								if ($affiche_tickets <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=O&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets.png\" ALT = \"Afficher tickets en cours\" title=\"Afficher les tickets en cours\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les tickets en cours</span><br /></td>";
									//echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_tickets=O&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Tickets en cours</b></FONT></a></td>";
								}
								else
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_cacher.png\" ALT = \"Cacher tickets\" title=\"Cacher les tickets en cours\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les tickets en cours</span><br /></td>";
									//echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_tickets=N&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations&amp;affiche_tickets=$affiche_tickets_archives&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Tickets en cours</FONT></a></td>";
								}

								if ($affiche_tickets_archives <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=O&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_archives.png\" ALT = \"Afficher tickets archiv&eacute;s\" title=\"Afficher les tickets archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les tickets archiv&eacute;s</span><br /></td>";
									//echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_tickets_archives=O&amp;affiche_tickets=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Tickets archiv&eacute;s</b></FONT></a></td>";
								}
								else
								{
									echo "<td align = \"center\"><a href=\"ecl_consult_fiche.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_archives_cacher.png\" ALT = \"Cacher tickets archiv&eacute;s\" title=\"Cacher les tickets archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les tickets archiv&eacute;s</span><br /></td>";
									//echo "<td align = \"center\" CLASS = \"new\"><a href=\"ecl_consult_fiche.php?affiche_tickets_archives=N&amp;affiche_tickets=$affiche_tickets&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Tickets archiv&eacute;s</b></FONT></a></td>";
								}
							}
							else
							{
								echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets.png\" ALT = \"Tickets en cours et archiv&eacute;s, acc&egrave;s non autoris&eacute;\" title=\"Afficher les tickets en cours et archiv&eacute;s, acc&egrave;s non autoris&eacute;\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les tickets en cours et archiv&eacute;s, acc&egrave;s<br />non autoris&eacute;</span><br /></td>";
								//echo "<td align = \"center\"><b>Tickets en cours et archiv&eacute;s, acc&egrave;s non autoris&eacute;</td>";
							}
						echo "</tr>";
					echo "</table>";

					//echo "<br />affiche_tickets : $affiche_tickets";
					////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////

					//Affichage de la partie des suivis
					if ($affiche_suivis_dossier == "O")
					{
						//echo "<h2>Les suivis - proc&eacute;dure en pr&eacute;paration</h2>";
						$origine = "ECL";
						include ("suivi_affiche_suivis_dossiers.inc.php");
					}
					///////////////////////////////////////////////////////////////////////
					//Fin de l'affichage de la partie des suivis


					//Affichage de la partie des suivis archivés
					if ($affiche_suivis_dossier_archives == "O")
					{
						echo "<h2>Les suivis archiv&eacute;s - proc&eacute;dure en pr&eacute;paration</h2>";
						$origine = "ECL";
						//include ("suivi_affiche_suivis_dossiers_archives.inc.php");
					}
					///////////////////////////////////////////////////////////////////////
					//Fin de l'affichage de la partie des suivis archives

					//Affichage de la partie Personnes ressources	
					if ($affiche_personnes_ressources == "O")
					{
						include ("ecl_affiche_personnes_ressources.inc.php");
					}
					///////////////////////////////////////////////////////////////////////
					//Fin de l'affichage de la partie Personnes ressources

					//Affichage de la partie formations
					if ($affiche_formations == "O")
					{
						include ("ecl_affiche_formations.inc.php");
					}
					//Fin de l'affichage de la partie Gestion tickets
					//////////////////////////////////////////////////////////////

					//Affichage des enquêtes TBI
					if ($affiche_tbi == "O")
					{
						include ("ecl_affiche_tbi.inc.php");
					}
					//Fin de l'affichage des enquêtes TBI
					//////////////////////////////////////////////////////////////
 
					//Affichage de la partie gestion tickets
					if ($affiche_tickets == "O")
					{
						$origine_tickets = "GT"; //permet de s&eacute;lectionner le bon filtre dans la requête MySQL dans le fichier inclus
						include ("affiche_tickets.inc.php");
						//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=ecl_consult_fiche&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
					}
					//Fin de l'affichage de la partie Gestion tickets
					//////////////////////////////////////////////////////////////

					//Affichage de la partie gestion des tickets archiv&eacute;s
					if ($affiche_tickets_archives == "O")
					{
						$origine_tickets = "GT"; //permet de s&eacute;lectionner le bon filtre dans la requête MySQL dans le fichier inclus
						include ("ecl_affiche_tickets_archives.inc.php");
						//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=ecl_consult_fiche&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
					}
					//Fin de l'affichage de la partie Gestion tickets
					//////////////////////////////////////////////////////////////
				break;
			}

			if (($action == "modif") OR ($action == "affichage"))
			{

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"ecl_gestion_ecl.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
							echo "</td>";
							if ($affiche_tickets == "O" OR $affiche_tickets_archives == "O")
							{
								echo "<td>";
								echo "<a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=ecl_consult_fiche&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacuterer un nouveau ticket\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouveau ticket</span><br />";
								echo "</td>";
							}
						echo "</tr>";
					echo "</table>";
				echo "</div>";

				//echo "<br /><a href = \"ecl_gestion_ecl.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
			} 
?>
		</div>
	</body>
</html>
