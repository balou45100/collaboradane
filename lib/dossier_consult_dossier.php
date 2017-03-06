<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	$_SESSION['origine'] = "dossier_consult_dossier";
	$origine = $_SESSION['origine'];

	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	echo "<body>
		<div align = \"center\">";

			//Inclusion des fichiers n�cessaires
			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			$nb_par_page = 12; //variable qui fixe le nombre de lignes affich�es

			//R�cup�ration des variables n�cessaires au fonctionnement du script
			$origine_gestion = $_SESSION['origine_gestion']; //permet de r�cup�rer l'origine dans le fichier repertoire_gestion pour afficher la m�me chose en y retournat
			$id_societe = $_GET['id_societe']; //n�cessaire pour la consultation des tickets
			$action = $_GET['action'];
			$a_faire = $_GET['a_faire'];
			$CHGMT = $_GET['CHGMT']; //Indique si un changement est intervenu lors des formulaires en fin der fichier
			$module = "FOR";
			$dossier = $dossier_docs_formation;
			$deverrouiller = $_GET['deverrouiller']; //Pour savoir si quelqu'un foce le d�verrouillage d'un ticket
			$id_dossier = $_GET['id_dossier'];

			// Les �l�ments � aficher ou � cacher
			$affiche_suivis_dossier = $_GET['affiche_suivis_dossier']; //pour savoir s'il faut afficher les suivis du dossier
			$affiche_suivis_dossier_archives = $_GET['affiche_suivis_dossier_archives']; //pour savoir s'il faut afficher les suivis du dossier archiv�s
			$affiche_evenements = $_GET['affiche_evenements']; //pour savoir si on affiche les �v�nements ou non
			$affiche_documents = $_GET['affiche_documents']; //pour savoir si on affiche les documents ou non
			$affiche_tbi = $_GET['affiche_tbi']; //pour savoir s'il faut afficher les informations sur les TBI
			$affiche_taches_dossier = $_GET['affiche_taches_dossier']; //pour savoir s'il faut afficher les t�ches du dossier
			$affiche_tickets = $_GET['affiche_tickets']; //pour savoir s'il faut afficher les tickets de la soci�t� choisie
			$affiche_tickets_archives = $_GET['affiche_tickets_archives']; //pour savoir s'il faut afficher les tickets de la soci�t� choisie
			$affiche_formations = $_GET['affiche_formations']; //pour savoir s'il faut afficher les formations
			//$affiche_contacts = $_GET['affiche_contacts']; //pour savoir si on affiche les contacts ou non
			//$affiche_personnes_ressources = $_GET['affiche_personnes_ressources']; //pour savoir s'il faut afficher les personnes ressources

			if (!ISSET($action))
			{
				$action = $_SESSION['action'];
			}
			else
			{
				$_SESSION['action'] = $action;
			}

			if (!ISSET($a_faire))
			{
				$a_faire = $_SESSION['a_faire'];
			}
			else
			{
				$_SESSION['a_faire'] = $a_faire;
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

			if (!ISSET($affiche_taches_dossier))
			{
				$affiche_taches_dossier = $_SESSION['affiche_taches_dossier'];
			}
			else
			{
				$_SESSION['affiche_taches_dossier'] = $affiche_taches_dossier;
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

			//////////////////////////////////////////////////////////////
			// Affichage des variables pour contr�le /////////////////////
			//////////////////////////////////////////////////////////////
/*
			echo "<br />id_dossier : $id_dossier";
			echo "<br />affiche_personnes_ressources : $affiche_personnes_ressources";
			echo "<br />affiche_suivis_dossier : $affiche_suivis_dossier";
			echo "<br />affiche_suivis_dossier_archives : $affiche_suivis_dossier_archives";
			echo "<br />affiche_taches_dossier : $affiche_taches_dossier";
			echo "<br />affiche_tickets : $affiche_tickets";
			echo "<br />affiche_tbi : $affiche_tbi";
			echo "<br />affiche_tickets_archives : $affiche_tickets_archives";
			echo "<br />affiche_evenements : $affiche_evenements";
			echo "<br />affiche_documents : $affiche_documents";
			echo "<br />affiche_formations : $affiche_formations";
			//echo "<br />origine_gestion : $origine_gestion";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />affiche_contacts : $affiche_contacts";
*/
			////////////////////////////////////////////////////////////////////////////////////////////////
			// D�but des actions � faire sur le dossier ////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////

			if($action=="O") // Des modifications ont �t� apport�es
			{
				switch ($a_faire)
				{
					case ('affiche_contact') :
						echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
							include ("contacts_affiche_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"dossier_consult_dossier.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('modif_contact') :
						echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
							include ("contacts_modif_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"dossier_consult_dossier.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_contact_modifie') : //enregistrement d'un lot modifi�
						include ("contacts_enreg_fiche_modifie.inc.php");
						$affiche_message_contact = "O";
						$message_a_afficher = "Le contact ".$id_contact." a &eacute;t&eacute; modifi&eacute;.";
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_contact') :
						include ("../biblio/init.php");
						echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
							$affiche_societe = "N"; //il n'est pas n�cessaire d'afficher la liste des �tablissements dans le formulaire suivant
							include ("contacts_ajout_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"dossier_consult_dossier.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_contact_ajoute') : //enregistrement d'un lot modifi�
						include ("contacts_enreg_fiche.inc.php");
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('suppression_contact') :
						echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
							include ("contacts_suppression_fiche.inc.php");
						echo "</form>";
						echo "<br /><a href = \"dossier_consult_dossier.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('confirm_suppression_contact') :
						include ("contacts_confirmation_suppression_fiche.inc.php");
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_formation') :
						//Récupération de l'identifiant de l'établissement
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
								<td width=\"5%\" align=\"center\">re�u</td>
								<td width=\"5%\" align=\"center\">mat&eacute;riel</td>
								*/
								echo "<td width=\"10%\" align=\"center\">Valider</td>";
							echo "</tr>";

						echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
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
						echo "<br /><a href = \"dossier_consult_dossier.php?id_societe=$id_societe&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('enreg_formation_ajoute') : //enregistrement d'une formation
						//R�cup�ration des variables de la formation � enregistrer
						$id_societe = $_GET['id_societe'];
						$type_formation = $_GET['type_formation'];
						$annee_scolaire_formulaire = $_GET['annee_scolaire_formulaire'];
						//$promis = $_GET['promis'];
						//$recu = $_GET['recu'];
						//$materiel = $_GET['materiel'];
						//$niveau = $_GET['niveau'];

						//Mise � jour de la fiche
						include("../biblio/init.php");
						$query = "INSERT INTO formations (annee_scolaire, type_formation, rne)
							VALUES ('".$annee_scolaire_formulaire."', '".$type_formation."', '".$id_societe."');";
						$results = mysql_query($query);
						//Dans le cas o� aucun r�sultats n'est retourn�
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
						$script = "dossier_consult_dossier";
						include ("ecl_suppression_formation.inc.php");
					break;

					case ('confirm_suppression_formation') :
						include ("ecl_confirm_suppression_formation.inc.php");
						//Dans le cas o� aucun r�sultat n'est retourn�
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
						//il faut �galement supprimer les entr�es dans la table documents concernant la formation supprim�e
						efface_documents_joints($id_formation,$module,$dossier); //Fonction qui supprime les fichiers du disue et qui efface les entr�e dans la table documents
					break;

					case ('modif_formation') :
						include ("ecl_modif_formation.inc.php");
					break;

					case ('enreg_formation_modifie') : //enregistrement d'une formation modifi�e
						include ("ecl_enreg_formation_modifie.inc.php");
						$affiche_message_formation = "O";
						$message_a_afficher = "La formation ".$id_formation." a &eacute;t&eacute; modifi&eacute;.";
						$action = "affichage";
						$_SESSION['action'] = $action;
					break;

					case ('ajout_document') : //enregistrement d'un document
						$script = "dossier_consult_dossier";
						$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						$annee = $_GET['annee'];
						$type = $_GET['type'];
						$id_formation = $_GET['id_formation'];
						$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];
						//echo "<h2>D&eacute;p�t de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour �viter que le ticket s'affiche
						include ("choix_fichier.inc.php");
					break;

					case ('ajout_enquete_tbi') :
						$script = "dossier_consult_dossier";
						//$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						//$annee = $_GET['annee'];
						//$type = $_GET['type'];
						//$id_formation = $_GET['id_formation'];
						//$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];
						//echo "<h2>D&eacute;p�t de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour �viter que le ticket s'affiche
						include("../biblio/init.php");
						include ("choix_fichier.inc.php");
					break;

					case ('enreg_enquete_tbi_ajoute') : //enregistrement d'une enqu�te TBI
					break;

				} //fin switch action
			}
			////////////////////////////////////////////////////////////////////////////////////////////////
			//D�but de la partie centrale du script : Requ�te pour extraire l'enregistrement souhait� //////
			////////////////////////////////////////////////////////////////////////////////////////////////
			include ("../biblio/init.php");
/*
			//Si jamais il faut d�verrouiller manuellement un ticket

			if ($deverrouiller == 'Oui')
			{
				deverouiller($idpb);
			}
*/
			// Formulation de la requête de base //
			$query = "SELECT * FROM categorie_commune AS cc, dos_dossier AS dd, util AS u
				WHERE cc.id_categ = dd.idDossier
					AND idDossier = '".$id_dossier."'
					AND dd.responsable = u.ID_UTIL;";

			//echo "<br />$query";

			$result_consult = mysql_query($query);
			$num_rows = mysql_num_rows($result_consult);
			if (mysql_num_rows($result_consult))
			{
				$ligne=mysql_fetch_object($result_consult);
				$intitule_dossier=$ligne->intitule_categ;
				$description_categ=$ligne->description_categ;
				$nom_responsable = $ligne->NOM;
			}
			else
			{
				//Dans le cas o� aucun r�sultat n'est retourn�;
				echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</B>";

				switch ($origine)
				{
					case ('filtre') :
						echo "<br /><a href = \"dossier_consult_dossier.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;

					case ('recherche') :
						echo "<br /><a href = \"dossier_consult_dossier.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
					break;
				}
				mysql_close();
				exit;
			}

			////////////////////////////////////////////////////////////
			// Affichage de l'enregistrement extrait ///////////////////
			////////////////////////////////////////////////////////////
			//echo "<br />affichage : $affichage";

			if ($affichage <> "N")
			{
				echo "<form action = \"dossier_consult_dossier.php\" METHOD = \"GET\">";
				echo "<h2>D&eacute;tails du dossier &laquo;&nbsp;$intitule_dossier&nbsp;&raquo;</h2>";
				echo "<table width=\"95%\">";
				echo "<caption></caption>";
					echo "<tr>";
					echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
						echo "<td>&nbsp;$intitule_dossier</td>";
						echo "<td class = \"etiquette\">Responsable&nbsp;:&nbsp;</td>";
						echo "<td>&nbsp;$nom_responsable</td>";
						echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
						echo "<td>&nbsp;$id_dossier</td>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Description&nbsp;:&nbsp;</td>";
							echo "<td colspan = \"3\">&nbsp;$description_categ</td>";
						echo "</tr>";
					echo "</tr>";
						echo "<tr>";
						echo "<td class = \"etiquette\">Collaborateurs/trices associ&eacute;-e-s&nbsp;:&nbsp;</td>";
						echo "<td>";
							include ("dossier_accueil_affiche_collaborateurs.inc.php");
						echo "</td>";
						echo "</tr>";
			echo "</table>";


				/////////////////////////////////////////////////////////////
				// Table pour l'affichage des contacts //////////////////////
				/////////////////////////////////////////////////////////////
/*
				echo "<table width=\"95%\">";
					//Affichage des contacts par rapport &agrave; l'enregistrement affich�
					$page_retour = "dossier_consult_dossier.php";
					if (!ISSET($affiche_contacts))
					{
						$affiche_contacts = "non";
					}
					include ("affiche_contacts.inc.php");
					//$colonne1 = "16%";
					//$colonne2 = "14%";
					echo "</table>";
*/
				/////////////////////////////////////////////////////////////
				// Table pour les différents éléments composant le dossier //
				/////////////////////////////////////////////////////////////
					echo "<table width=\"95%\" class = \"menu-boutons\">";
					echo "<caption></caption>";
					echo "<tr>";
						if (verif_appartenance_groupe(25)) //Suivi dossiers
						{
							if ($affiche_suivis_dossier <> "O")
							{
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=O&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier.png\" ALT = \"Afficher les suivis\" title=\"Afficher les suivis\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les suivis</span><br /></td>";
							}
							else
							{
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_cacher.png\" ALT = \"Cacher suivis\" title=\"Cacher les suivis\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les suivis</span><br /></td>";
							}

							if ($affiche_suivis_dossier_archives <> "O")
							{
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=O&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_archives.png\" ALT = \"Afficher les suivis\" title=\"Afficher les suivis archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les suivis archiv&eacute;s</span><br /></td>";
							}
							else
							{
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_dossier_archives_cacher.png\" ALT = \"Cacher suivis\" title=\"Cacher les suivis archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les suivis archiv&eacute;s</span><br /></td>";
							}

							if ($affiche_evenements <> "O")
							{
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=O&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement.png\" ALT = \"Afficher les &eacute;v&eacute;nements\" title=\"Afficher les &eacute;v&eacute;nements\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les &eacute;v&eacute;nements</span><br /></td>";
							}
							else
							{
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_cacher.png\" ALT = \"Cacher les &eacute;v&eacute;nements\" title=\"Cacher les &eacute;v&eacute;nements\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les &eacute;v&eacute;nements</span><br /></td>";
							}
						}
						else
						{
							echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Afficher pers. ressources, acc&egrave;s  non autoris&eacute;\" title=\"Afficher les suivis, acc&egrave;s non autoris&eacute;\" border = \"0\"></td>";
						}

						if (verif_appartenance_groupe(5)) //formation
						{
							if ($affiche_formations <> "O") //on affiche ou on cache les formations concernant cet enregistrement
							{
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=O&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations\" title=\"Afficher les formations\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les formations</span><br /></td>";
							}
							else
							{
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations_cacher.png\" ALT = \"Cacher formations\" title=\"Cacher les formations\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les formations</span><br /></td>";
							}
						}
						else
						{
							echo "<td align = \"center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Afficher formations, acc&egrave;s non autoris&eacute;\" title=\"Afficher les formations, acc&egrave;s non autoris&eacute;\" border = \"0\"></td>";
						}
/*
						if ($affiche_tbi <> "O") //on affiche ou on cache les informations concernant les TBI
						{
							//echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_tbi=O&amp;affiche_tickets_archives=N&amp;affiche_tickets=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Enqu&ecirc;tes TBI</b></FONT></a></td>";
							echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=O&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tbi.png\" ALT = \"Afficher TBI\" title=\"Afficher les informations TBI\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les informations TBI</span><br /></td>";
						}
						else
						{
							//echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_tbi=N&amp;affiche_tickets_archives=$affiche_tickets_archives&amp;affiche_tickets=$affiche_tickets&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Enqu&ecirc;tes TBI</b></FONT></a></td>";
							echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tbi_cacher.png\" ALT = \"Afficher TBI\" title=\"Cacher les informations TBI\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les informations TBI</span><br /></td>";
						}
*/
						if (verif_appartenance_groupe(18)) //gestion tickets
						{
							if ($affiche_tickets <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
							{
								//echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_tickets=O&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Tickets en cours</b></FONT></a></td>";
								echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=O&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets.png\" ALT = \"Tickets en cours\" title=\"Afficher les tickets en cours\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les tickets en cours</span><br /></td>";
							}
							else
							{
								//echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_tickets=N&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations&amp;affiche_tickets=$affiche_tickets_archives&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Tickets en cours</FONT></a></td>";
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_cacher.png\" ALT = \"Cacher les tickets en cours\" title=\"Cacher les tickets en cours\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les tickets en cours</span><br /></td>";
							}

							if ($affiche_tickets_archives <> "O") //on affiche ou on cache les tickets concernant cet enregistrement
							{
								//echo "<td align = \"center\"><a href=\"dossier_consult_dossier.php?affiche_tickets_archives=O&amp;affiche_tickets=N&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tbi=N\" target=\"body\" class = \"bouton\"><FONT COLOR = \"#000000\" title = \"Afficher\"><b>Tickets archiv&eacute;s</b></FONT></a></td>";
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=O&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Afficher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_archives.png\" ALT = \"Afficher les tickets archiv&eacute;s\" title=\"Afficher les tickets  archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Afficher les tickets archiv&eacute;s</span><br /></td>";
							}
							else
							{
								//echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_tickets_archives=N&amp;affiche_tickets=$affiche_tickets&amp;affiche_personnes_ressources=$affiche_personnes_ressources&amp;affiche_formations=$affiche_formations&amp;affiche_tbi=$affiche_tbi\" target=\"body\" class = \"bouton\" title = \"Cacher\"><FONT COLOR = \"#000000\"><b>Tickets archiv&eacute;s</b></FONT></a></td>";
								echo "<td align = \"center\" CLASS = \"new\"><a href=\"dossier_consult_dossier.php?affiche_suivis_dossier=N&amp;affiche_suivis_dossier_archives=N&amp;affiche_evenements=N&amp;affiche_formations=N&amp;affiche_tickets=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N&amp;id_dossier=$id_dossier\" target=\"body\" class = \"bouton\" title = \"Cacher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tickets_archives_cacher.png\" ALT = \"Afficher les tickets archiv&eacute;s\" title=\"Cacher les tickets  archiv&eacute;s\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Cacher les tickets archiv&eacute;s</span><br /></td>";
							}
						}
						else
						{
							echo "<td align = \"center\"><b>Tickets en cours et archiv&eacute;s, acc&egrave;s non autoris&eacute;</td>";
						}
					echo "</tr>";
				echo "</table>";

				//echo "<br />affiche_tickets : $affiche_tickets";

				////////////////////////////////////////////////////////////
				// Affichage de la partie des suivis ///////////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_suivis_dossier == "O")
				{
					$origine = "SUIVI";
					$visibilite = "O";
					include ("suivi_affiche_suivis_dossiers.inc.php");
					//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
				}
				////////////////////////////////////////////////////////////
				// Fin de l'affichage des suivis ///////////////////////////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage des suivis archiv�s ///////////////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_suivis_dossier_archives == "O")
				{
					$origine = "SUIVI";
					$visibilite = "N";
					echo "<h2>Les suivis archiv&eacute;s - proc&eacute;dure en pr&eacute;paration</h2>";
					//include ("suivi_affiche_suivis_dossiers_archives.inc.php");
					//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
				}
				////////////////////////////////////////////////////////////
				// Fin de l'affichage des suivis archiv�s //////////////////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage des �v�nements ////////////////////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_evenements == "O")
				{
					$origine = "SUIVI";
					$visibilite = "O";
					echo "<h2>Les &eacute;v&eacute;nements - proc&eacute;dure en pr&eacute;paration</h2>";
					//include ("suivi_affiche_suivis_dossiers.inc.php");
					//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
				}
				////////////////////////////////////////////////////////////
				// Fin des �v�nements //////////////////////////////////////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage de la partie Personnes ressources /////////////
				////////////////////////////////////////////////////////////
				if ($affiche_personnes_ressources == "O")
				{
					//include ("ecl_affiche_personnes_ressources.inc.php");
				}
				////////////////////////////////////////////////////////////
				// Fin de l'affichage de la partie Personnes ressources ////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage de la partie formations ///////////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_formations == "O")
				{
					echo "<h2>Les formations - proc&eacute;dure en pr&eacute;paration</h2>";
					//include ("ecl_affiche_formations.inc.php");
				}
				////////////////////////////////////////////////////////////
				//Fin de l'affichage de la partie formations ///////////////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage des enqu�tes TBI //////////////////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_tbi == "O")
				{
					//include ("ecl_affiche_tbi.inc.php");
				}
				////////////////////////////////////////////////////////////
				// Fin de l'affichage des enqu�tes TBI /////////////////////
				////////////////////////////////////////////////////////////

				////////////////////////////////////////////////////////////
				// Affichage de la partie gestion tickets //////////////////
				////////////////////////////////////////////////////////////
				if ($affiche_tickets == "O")
				{
					echo "<h2>Les tickets en cours - proc&eacute;dure en pr&eacute;paration</h2>";
					//$origine_tickets = "GT"; //permet de s�lectionner le bon filtre dans la requ�te MySQL dans le fichier inclus
					//include ("affiche_tickets.inc.php");
					//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
				}
				////////////////////////////////////////////////////////////
				//Fin de l'affichage de la partie Gestion tickets //////////
				////////////////////////////////////////////////////////////

				///////////////////////////////////////////////////////////////
				// Affichage de la partie gestion des tickets archiv�s /
				///////////////////////////////////////////////////////////////
				if ($affiche_tickets_archives == "O")
				{
					echo "<h2>Les tickets archiv&eacute;s - proc&eacute;dure en pr&eacute;paration</h2>";
					//$origine_tickets = "GT"; //permet de s�lectionner le bon filtre dans la requ�te MySQL dans le fichier inclus
					//include ("ecl_affiche_tickets_archives.inc.php");
					//echo "<br /><a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\"></a>";
				}
				////////////////////////////////////////////////////////////
				// Fin de l'affichage de la partie Gestion tickets /////////
				////////////////////////////////////////////////////////////
			} //Fin if affichage

			////////////////////////////////////////////////////////////
			// Boutons Retour et validation ////////////////////////////
			////////////////////////////////////////////////////////////

			//if (($action == "modif") OR ($action == "affichage"))
			//{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"dossier_accueil.php?tri=Int&amp;sense_tri=ASC&amp;visibilite=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
							echo "</td>";
/*
							if ($affiche_tickets == "O" OR $affiche_tickets_archives == "O")
							{
								echo "<td>";
								echo "<a href = \"verif_ticket.php?etab=".$id_societe."&amp;origine=dossier_consult_dossier&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacuterer un nouveau ticket\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouveau ticket</span><br />";
								echo "</td>";
							}
*/
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			//}
?>
		</div>
	</body>
</html>
