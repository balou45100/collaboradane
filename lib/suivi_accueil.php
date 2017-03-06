<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE html>

<?php
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
			//echo "<meta charset=\"utf-8\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">";
?>
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
<?php
	echo "</head>";
		echo "<body>";
			echo "<center>";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_suivis.png\" ALT = \"Titre\">";
			//echo "<h2>Suivi des suivis</h2>";

////////////////////////////////////////////////////////////////////////
// Initialisation des différentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////
			$tri = $_GET['tri'];
			$sense_tri = $_GET['sense_tri'];
			$action = $_GET['action'];
			$a_faire = $_GET['a_faire'];
			$id_suivi = $_GET['id_'];
			$visibilite = $_GET['visibilite'];
			$origine_appel = $_GET['origine_appel']; // entete

			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}

			if (!ISSET($visibilite))
			{
				$visibilite = $_POST['visibilite'];
			}

/*
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />visibilite : $visibilite";
			echo "<br />tri : $tri";
			echo "<br />sense_tri : $sense_tri";
			echo "<br />id_suivi : $id_suivi";
			echo "<br />visibilite : $visibilite";
*/
////////////////////////////////////////////////////////////////////////
// Début du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			if ($action == "O")
			{
				$id_suivi = $_GET['id_suivi'];
				switch ($a_faire)
				{
					case "ajout_suivi" :
						//echo "<h2>Ajout de suivi</h2>";
						include("suivi_ajout_suivi.inc.php");
						$affichage = "N";
					break;

					case "enreg_suivi" :
						echo "<h2>Enregistrement du suivi</h2>";
						include("suivi_enreg_suivi.inc.php");
						//$affichage = "N";
					break;

					case "info_suivi" :
						echo "<h2>Information sur le suivi No&nbsp;$id_suivi</h2>";
						//echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						include("suivi_consult_suivi.inc.php");
						$affichage = "N";
					break;

					case "modif_suivi" :
						echo "<h2>Modification du suivi $id_suivi</h2>";
						$origine = "suivi_accueil";
						include ("suivi_modif_suivi.inc.php");
						$affichage = "N";
					break;

					case "enreg_modif_suivi" :
						include ("suivi_maj_suivi.inc.php");
					break;

					case "suppression_suivi" :
						//echo "<h2>Suppression du suivi $id_suivi</h2>";
						include ("suivi_supprimer_suivi.inc.php");
						$affichage = "N";
					break;

					case "confirmer_supprimer_suivi" :
						$bouton_retour = $_GET['bouton_envoyer_modif'];

						//echo "<br />bouton_retour : $bouton_retour";

						if ($bouton_retour <> "Retourner sans enregistrer")
						{
							include ("suivi_confirmer_supprimer_suivi.inc.php");
						}
					break;
				}
			}

////////////////////////////////////////////////////////////////////////
// Affichage du menu de l'entête de liste et de l'entête du tableau ////
////////////////////////////////////////////////////////////////////////
		if ($affichage <> "N")
		{
			// Composition de la requête pour l'affichage de la liste en fonction des critères de filtrage
/*
			$requete_base = "SELECT * FROM suivi AS sd, util AS U";
			$requete_condition = "WHERE DD.responsable = U.ID_UTIL";
			$requete_tri = "ORDER BY libelleDossier";
*/

			if ($origine_appel == "entete")
			{
				//On récupère les variables pour le filtrage
				$utilisateur_filtre = $_GET['utilisateur_filtre'];
				$dossier_filtre = $_GET['dossier_filtre'];
				$detail = $_GET['detail'];

				//On construit la requête
				$requete_base = "SELECT * FROM suivis AS s, categorie_commune AS cc, suivis_categories_communes AS scc, util AS u";
				$requete_condition = "WHERE s.id = scc.id_suivi AND scc.id_categorie_commune = cc.id_categ AND s.emetteur = u.ID_UTIL";

				/*
				echo "<br />utilisateur_filtre : $utilisateur_filtre";
				echo "<br />dossier_filtre : $dossier_filtre";
				echo "<br />detail : $detail";
				echo "<br />visibilite : $visibilite";
				*/
				if ($utilisateur_filtre <> '%')
				{
					$requete_condition = $requete_condition." AND u.ID_UTIL = '".$utilisateur_filtre."'";
				}

				if ($dossier_filtre <> '%')
				{
					$requete_condition = $requete_condition." AND cc.id_categ = '".$dossier_filtre."'";
				}

				if ($detail <> '')
				{
					$requete_condition = $requete_condition." AND (s.titre LIKE '%".$detail."%' OR s.description LIKE '%".$detail."%')";
				}
			}
			else
			{
				$requete_base = "SELECT * FROM suivis AS s, categorie_commune AS cc, suivis_categories_communes AS scc";
				$requete_condition = "WHERE s.id = scc.id_suivi AND scc.id_categorie_commune = cc.id_categ";
			}

			$requete_condition_visibilite = " AND cc.actif LIKE '".$visibilite."'";
			$requete_tri = "ORDER BY date_suivi";

			$requete_complete = $requete_base." ".$requete_condition." "." ".$requete_condition_visibilite." ".$requete_tri;

			//echo "<br />$requete_complete<br />";

			// Menu de l'entête de liste ////////////////////////////////

/*
			if ($niveau_droits > 1)
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi&amp;tri=$tri&amp;sense_tri=$sense_tri\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un suivi\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un suivi</span><br />";
								echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			}
*/
			// Exécution de la requête et comptage des enregistrements ////

			$resultat = mysql_query($requete_complete);
			if(!$resultat)
			{
				echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
				echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
				mysql_close();
				exit;
			}
			//Retourne le nombre de ligne rendu par la requ&egrave;te
			$nbr_resultat = mysql_num_rows($resultat);

			//echo "<br />nbr_resultat : $nbr_resultat";

			if ($nbr_resultat >0)
			{
				if ($visibilite == "O")
				{
					echo "<h2>Nombre de suivis en cours&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}
				elseif ($visibilite == "N")
				{
					echo "<h2>Nombre de suivis archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}
				else
				{
					echo "<h2>Nombre de tous les suivis en cours et archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}

				// Affichage de l'entête du tableau ////

				echo "<table>
					<tr>
						<th>";
							if ($sense_tri =="asc")
							{
								echo "ID&nbsp;<a href=\"suivi_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "ID&nbsp;<a href=\"suivi_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						echo "</th>";
						echo "<th>";
							echo "ECL";
						echo "</th>";
						echo "</th>";
						if ($tri <> "MeAa" AND $tri <> "Me")
						{
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "EMETTEUR&nbsp;<a href=\"suivi_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "EMETTEUR&nbsp;<a href=\"suivi_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						}
						echo "</th>";
						echo "<th>";
							echo "DATE SUIVI";
						echo "</th>";
						echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "INTITUL&Eacute;&nbsp;<a href=\"suivi_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "INTITUL&Eacute;&nbsp;<a href=\"suivi_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						echo "</th>";
						echo "<th>";
							echo "DESCRIPTION";
						echo "<th>";
							echo "DOSSIER";
						echo "</th>";
			/*
						//echo "<th>STRUCTURES</th>";
						echo "<th>&Eacute;V&Eacute;NEMENTS</th>";
						echo "<th>DOCUMENTS</th>";
						echo "<th>SUIVIS</th>";
						echo "<th>TICKETS</th>";
						echo "<th>T&Acirc;CHES</th>";
	*/
						//echo "<th><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\"></th>";
						echo "<th>";
							echo "ACTIONS";
						echo "</th>";
					echo "</tr>";

	////////////////////////////////////////////////////////////////////////
	// Affichage des suivis existants ////////////////////////////////////
	////////////////////////////////////////////////////////////////////////
					while ($ligne = mysql_fetch_object($resultat))
					{
	/*
						$id_suivi = $ligne->idsuivi;
						$intitule_suivi = $ligne->libellesuivi;
						$description_suivi = $ligne->description;
						$id_responsable = $ligne->ID_UTIL;
						$nom_responsable = $ligne->NOM;
						$date_creation = $ligne->DateCreation;
						$visibilite  = $ligne->visibilite;
	*/
						$id_suivi = $ligne->id_suivi;
						$intitule_suivi = $ligne->titre;
						$description_suivi = $ligne->description;
						$id_responsable = $ligne->emetteur;
						$date_creation = $ligne->date_crea;
						$date_suivi = $ligne->date_suivi;
						$contact_type  = $ligne->contact_type;
						$intitule_categ = $ligne->intitule_categ;
						$ecl  = $ligne->ecl;

						// On récupère le nom du responsable
						$nom_responsable = lecture_utilisateur("NOM",$id_responsable);

						//On recupère le nombre de tâches associées à ce suivi
						$nbr_taches_actives = comptage_nbr_enregistrements_d_une_table("taches_categories AS tc, taches AS t","tc.id_tache = t.id_tache AND t.etat <> \"3\" AND tc.id_categorie = '".$id_suivi."'");
						$nbr_taches_achevees = comptage_nbr_enregistrements_d_une_table("taches_categories AS tc, taches AS t","tc.id_tache = t.id_tache AND t.etat = \"3\" AND tc.id_categorie = '".$id_suivi."'");

						//On recupère le nombre de tickets associés à ce suivi
						$nbr_tickets_actifs = comptage_nbr_enregistrements_d_une_table("categorie_commune_ticket AS cct, probleme AS p","cct.id_ticket = p.ID_PB AND p.STATUT <> \"A\" AND cct.id_categ = '".$id_suivi."'");
						$nbr_tickets_archives = comptage_nbr_enregistrements_d_une_table("categorie_commune_ticket AS cct, probleme AS p","cct.id_ticket = p.ID_PB AND p.STATUT = \"A\" AND cct.id_categ = '".$id_suivi."'");

						// On affiche l'enregistrement
						echo "<tr>";
							echo "<td align = \"center\">";
								echo "&nbsp;$id_suivi&nbsp;";
							echo "</td>";
							echo "<td>";
							 	affiche_info_bulle($ecl,"RESS",0);
								//echo "$ecl";
							echo "</td>";
							echo "<td>";
								echo "$nom_responsable";
							echo "</td>";
							echo "<td>";
								$date_a_afficher = affiche_date($date_suivi);
								echo "$date_a_afficher";
							echo "</td>";
							echo "<td>";
								echo "&nbsp;$intitule_suivi&nbsp;";
							echo "</td>";
							echo "<td>";
								$description_tronquee = tronquer_chaine($description_suivi, 0, 50);
								echo "$description_tronquee";
							echo "</td>";
							echo "<td>";
								echo "$intitule_categ";
							echo "</td>";
	//////// Colonne des actions ////////////////////////////////////////////////
								echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=info_suivi&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter le suivi\"></a>";
								if ($id_responsable == $_SESSION['id_util'] OR $niveau_droits == 3)
								{
									echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=modif_suivi&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le suivi\"></a>";
									echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=suppression_suivi&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer le suivi\"></a>";
								}
/*								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi_evenement&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>";
								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi_document&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi_suivi&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";
								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi_ticket&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
								echo "&nbsp;<a href = \"suivi_accueil.php?action=O&amp;a_faire=ajout_suivi_tache&amp;id_suivi=".$id_suivi."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
	*/
							echo "</td>";

	//////// Fin colonne des actions ////////////////////////////////////////////
						echo "</tr>";
					} //Fin while
				} // Fin if num
				else
				{
					echo "<h2>Pas de suivis pour l'instant</h2>";
				}
			} //Fin $affichage <> "N"

////////////////////////////////////////////////////////////////////////
// Fin du script ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
