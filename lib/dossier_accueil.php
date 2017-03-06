<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//On inclue les fichiers de configuration et de fonctions /////
	include ("../biblio/config.php");
	include ("../biblio/fct.php");

	// On vérifie le niveau des droits de la personne connectée /////
	$niveau_droits = verif_droits("suivi_dossiers");

	//echo "<br />niveau_droits : $niveau_droits";

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		//echo "<meta charset=\"UTF-8\>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		echo "<body>";
			echo "<center>";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_dossiers.png\" ALT = \"Titre\">";
			//echo "<h2>Suivi des dossiers</h2>";

////////////////////////////////////////////////////////////////////////
// Initialisation des différentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////
			$tri = $_GET['tri'];
			$sense_tri = $_GET['sense_tri'];
			$action = $_GET['action'];
			$a_faire = $_GET['a_faire'];
			$id_dossier = $_GET['id_dossier'];
			$visibilite = $_GET['visibilite'];
/*
			echo "<br />visibilite : $visibilite";
			echo "<br />tri : $tri";
			echo "<br />sense_tri : $sense_tri";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />id_dossier : $id_dossier";
			echo "<br />modif_associes : $modif_associes";
*/
////////////////////////////////////////////////////////////////////////
// Début du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			if ($action == "O")
			{
				$id_dossier = $_GET['id_dossier'];
				switch ($a_faire)
				{
					case "ajout_dossier" :
						//echo "<h2>Ajout de dossier</h2>";
						include("dossier_ajout_dossier.inc.php");
						$affichage = "N";
					break;

					case "enreg_dossier" :
						echo "<h2>Enregistrement du dossier</h2>";
						include("dossier_enreg_dossier.inc.php");
						//$affichage = "N";
					break;

					case "info_dossier" :
						echo "<h2>Information sur le dossier $id_dossier</h2>";
						include("dossier_consult_dossier.inc.php");
						$affichage = "N";
					break;

					case "modif_dossier" :
						echo "<h2>Modification du dossier $id_dossier</h2>";
						include ("dossier_modif_dossier.inc.php");
						$affichage = "N";
					break;

					case "maj_dossier" :
						include ("dossier_maj_dossier.inc.php");
					break;

					case "suppression_dossier" :
						include ("dossier_suppression_dossier.inc.php");
						$affichage = "N";
					break;

					case "confirm_suppression_dossier" :
						include ("dossier_confirm_suppression_dossier.inc.php");
					break;

					case "ajout_evenement" :
						echo "<h2>Ajout d'un &eacute;v&eacute;nement au dossier $id_dossier</h2>";
						echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						affiche_bouton_retour("dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite",$chemin_theme_images."/retour.png");
						$affichage = "N";
					break;

					case "ajout_document" :
						echo "<h2>Ajout d'un document au dossier $id_dossier</h2>";
						echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						affiche_bouton_retour("dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite",$chemin_theme_images."/retour.png");
						$affichage = "N";
					break;

					case "ajout_suivi" :
						echo "<h2>Ajout d'un suivi au dossier $id_dossier</h2>";
						echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						affiche_bouton_retour("dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite",$chemin_theme_images."/retour.png");
						$affichage = "N";
					break;

					case "ajout_ticket" :
						echo "<h2>Ajout d'un ticket au dossier $id_dossier</h2>";
						echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						affiche_bouton_retour("dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite",$chemin_theme_images."/retour.png");
						$affichage = "N";
					break;

					case "ajout_tache" :
						echo "<h2>Ajout d'une t&acirc;che au dossier $id_dossier</h2>";
						echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						affiche_bouton_retour("dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite",$chemin_theme_images."/retour.png");
						$affichage = "N";
				break;
				}
			}

	////////////////////////////////////////////////////////////////////////
	// Affichage du menu de l'entête de liste et de l'entête du tableau ////
	////////////////////////////////////////////////////////////////////////
		if ($affichage <> "N")
		{
			// Composition de la requête pour l'affichage de la liste ///
			$requete_base = "SELECT * FROM categorie_commune AS cc, dos_dossier AS dd, util AS u";
			$requete_condition = "WHERE cc.id_categ = dd.idDossier AND dd.responsable = u.ID_UTIL";
			$requete_condition_visibilite = "AND cc.actif = '".$visibilite."'";
			$requete_tri = "ORDER BY $tri $sense_tri";

			$requete_complete = $requete_base." ".$requete_condition." "." ".$requete_condition_visibilite." ".$requete_tri;

			//echo "<br />requete_complete : $requete_complete<br />";

			// Menu de l'entête de liste ////////////////////////////////
			if ($niveau_droits > 1)
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_dossier&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un dossier\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un dossier</span><br />";
								echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			}

			// Exécution de la requête et comptage des enregistrements ////

			$resultat = mysql_query($requete_complete);
			if(!$resultat)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
				echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
				mysql_close();
				exit;
			}
			//Retourne le nombre de ligne rendu par la requ&egrave;te
			$nbr_resultat = mysql_num_rows($resultat);

			if ($visibilite == "O")
			{
				echo "<h2>Nombre de dossiers en cours&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
			}
			else
			{
				echo "<h2>Nombre de dossiers archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
			}

			// Affichage de l'entête du tableau ////

			echo "<table>
				<tr>
					<th>";
						if ($sense_tri =="asc")
						{
							echo "ID&nbsp;<a href=\"dossier_accueil.php?tri=id_categ&amp;indice=0&amp;sense_tri=desc&amp;visibilite=$visibilite\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "ID&nbsp;<a href=\"dossier_accueil.php?tri=id_categ&amp;indice=0&amp;sense_tri=asc&amp;visibilite=$visibilite\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					echo "</th>";
					echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "INTITUL&Eacute;&nbsp;<a href=\"dossier_accueil.php?tri=intitule_categ&amp;indice=0&amp;sense_tri=desc&amp;visibilite=$visibilite\" target=\"body\" title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "INTITUL&Eacute;&nbsp;<a href=\"dossier_accueil.php?tri=intitule_categ&amp;indice=0&amp;sense_tri=asc&amp;visibilite=$visibilite\" target=\"body\" title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					echo "</th>";
					echo "<th>";
						echo "DESCRIPTION";
					echo "</th>";
					if ($tri <> "MeAa" AND $tri <> "Me")
					{
						echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "RESPONSABLE&nbsp;<a href=\"dossier_accueil.php?tri=NOM&amp;indice=0&amp;sense_tri=desc&amp;visibilite=$visibilite\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "RESPONSABLE&nbsp;<a href=\"dossier_accueil.php?tri=NOM&amp;indice=0&amp;sense_tri=asc&amp;visibilite=$visibilite\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					}
					echo "</th>";
/*
					echo "<th>";
						echo "OUVERT LE";
					echo "</th>";
*/
					echo "<th>";
						echo "COLLABORATEUR-TRICE-S";
					echo "</th>";
					//echo "<th>STRUCTURES</th>";
					echo "<th>&Eacute;V&Eacute;NEMENTS</th>";
					echo "<th>DOCUMENTS</th>";
					echo "<th>SUIVIS</th>";
					echo "<th>TICKETS</th>";
					echo "<th>T&Acirc;CHES</th>";
					//echo "<th><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\"></th>";
					echo "<th>";
						echo "ACTIONS";
					echo "</th>";
				echo "</tr>";

////////////////////////////////////////////////////////////////////////
// Affichage des dossiers existants ////////////////////////////////////
////////////////////////////////////////////////////////////////////////
				while ($ligne = mysql_fetch_object($resultat))
				{
/*
					$id_dossier = $ligne->idDossier;
					$intitule_dossier = $ligne->libelleDossier;
					$description_dossier = $ligne->description;
					$id_responsable = $ligne->ID_UTIL;
					$nom_responsable = $ligne->NOM;
					$date_creation = $ligne->DateCreation;
					$visibilite  = $ligne->visibilite;
*/
					$id_dossier = $ligne->idDossier;
					$intitule_dossier = $ligne->intitule_categ;
					$description_dossier = $ligne->description_categ;
					$id_responsable = $ligne->responsable;
					//$nom_responsable = $ligne->NOM;
					$date_creation = $ligne->DateCreation;
					$confidentialite  = $ligne->confidentialite;

					// On récupère le nom du responsable
					$nom_responsable = lecture_utilisateur("NOM",$id_responsable);

					//On recupère le nombre de tâches associées à ce dossier
					$nbr_taches_actives = comptage_nbr_enregistrements_d_une_table("taches_categories AS tc, taches AS t","tc.id_tache = t.id_tache AND t.etat <> \"3\" AND tc.id_categorie = '".$id_dossier."'");
					$nbr_taches_achevees = comptage_nbr_enregistrements_d_une_table("taches_categories AS tc, taches AS t","tc.id_tache = t.id_tache AND t.etat = \"3\" AND tc.id_categorie = '".$id_dossier."'");

					//On recupère le nombre de tickets associés à ce dossier
					$nbr_tickets_actifs = comptage_nbr_enregistrements_d_une_table("categorie_commune_ticket AS cct, probleme AS p","cct.id_ticket = p.ID_PB AND p.STATUT <> \"A\" AND cct.id_categ = '".$id_dossier."'");
					$nbr_tickets_archives = comptage_nbr_enregistrements_d_une_table("categorie_commune_ticket AS cct, probleme AS p","cct.id_ticket = p.ID_PB AND p.STATUT = \"A\" AND cct.id_categ = '".$id_dossier."'");

					//On recupère le nombre de suivis associés à ce dossier
					$nbr_suivis = comptage_nbr_enregistrements_d_une_table("suivis AS s, suivis_categories_communes AS scc","s.id = scc.id_suivi AND scc.id_categorie_commune = '".$id_dossier."'");

					//On recupère le nombre d'événements associés à ce dossier
					$nbr_evenements = comptage_nbr_enregistrements_d_une_table("evenements AS e, categorie_commune AS cc","e.fk_id_dossier = cc.id_categ AND e.id_evenement = '".$id_dossier."'");

					//On recupère le nombre de documents associés à ce dossier
					$nbr_documents = comptage_nbr_enregistrements_d_une_table("documents AS d, documents_categories_communes AS dcc","d.id_doc = dcc.id_document AND dcc.id_categorie_commune = '".$id_dossier."'");
					

					// On affiche l'enregistrement

					echo "<tr>";
						echo "<td align = \"center\">";
							echo "&nbsp;$id_dossier&nbsp;";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;$intitule_dossier&nbsp;";
						echo "</td>";
						echo "<td>";
							$description_tronquee = tronquer_chaine($description_dossier, 0, 50);
							echo "&nbsp;$description_tronquee&nbsp;";
						echo "</td>";
						echo "<td>";
							echo "$nom_responsable";
						echo "</td>";
/*
						echo "<td>";
							$date_a_afficher = affiche_date($date_creation);
							echo "$date_a_afficher";
						echo "</td>";
*/
						echo "<td>";
							include ("dossier_accueil_affiche_collaborateurs.inc.php");
						echo "</td>";
/*						echo "<td>";
							echo "&nbsp;"; // structures
						echo "</td>";
*/						echo "<td align = \"center\">";
							echo "$nbr_evenements";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_evenement&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>"; // événements
						echo "</td>";
						echo "<td align = \"center\">";
							echo "$nbr_documents"; // documents
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_document&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
						echo "</td>";
						echo "<td align = \"center\">";
							if ($nbr_suivis > 0)
							{
								echo "<strong>$nbr_suivis</strong>"; // suivis
							}
							else
							{
								echo "$nbr_suivis";
							}
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/suivi_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";

						echo "</td>";
						echo "<td align = \"center\">";
							echo "&nbsp;<strong>$nbr_tickets_actifs</strong>&nbsp;/&nbsp;$nbr_tickets_archives"; // tickets
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_ticket&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "&nbsp;<strong>$nbr_taches_actives</strong>&nbsp;/&nbsp;$nbr_taches_achevees&nbsp;"; // tâches
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_tache&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
						echo "</td>";
/*
						if ($confidentialite == "PR")
						{
							echo "<td><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"privé\"></td>";
						}
						else
						{
							echo "<td>&nbsp;</TD>";
						}
*/
//////// Colonne des actions ////////////////////////////////////////////////
						echo "<td class = \"fond-actions\" nowrap>";
							echo "&nbsp;<a href = \"dossier_consult_dossier.php?action=O&amp;a_faire=info_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter le dossier\"></a>";
							if ($niveau_droits == 3)
							{
								echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=modif_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le dossier\"></a>";
								//echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=archiver_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archiver.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le dossier\"></a>";
								if ($nbr_taches_actives == 0
									AND $nbr_taches_achevees == 0
									AND $nbr_tickets_actifs == 0
									AND $nbr_tickets_archives == 0
									AND $nbr_suivis == 0
									AND $nbr_evenements == 0
									AND $nbr_documents == 0)
								{
									echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=suppression_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer le dossier\"></a>";
								}
							}
/*						echo "</td>";
						echo "<td class = \"fond-actions\" nowrap>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi_evenement&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi_document&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi_ticket&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=ajout_suivi_tache&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
*/
						echo "</td>";
//////// Fin colonne des actions ////////////////////////////////////////////
					echo "</tr>";
				}


		} //Fin $affichage <> "N"
////////////////////////////////////////////////////////////////////////
// Fin du script ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
