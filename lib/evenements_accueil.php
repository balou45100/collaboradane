<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE html>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//On inclue les fichiers de configuration et de fonctions /////
	include ("../biblio/config.php");
	include ("../biblio/fct.php");

	// On vérifie le niveau des droits de la personne connectée /////
	$niveau_droits = verif_droits("evenements");
	$module = "EVE"; //nécessaire pour le script qui ajoute les liste d'émargement à un évènment
	$dossier_om = $dossier_pieces_frais_deplacement;
	/*
	echo "<br />evenements_accueil.php";
	echo "<br />niveau_droits : $niveau_droits";
	echo "<br />module : $module";
	*/
	//on initialise le timestamp pour la date du jour
	$date_auj = date("Y-m-d");

	//echo "<br />evenement_accueil.php - niveau_droits : $niveau_droits";
	//echo "<br />date_auj : $date_auj";

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta charset=\"UTF-8\>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html\" />";
		//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
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
			//On récupère la variable afaire2 pour savoir s'il faut supprimer l'affichage du titre du module
			$a_faire2 = $_GET['a_faire2'];
			if ($a_faire2 <> "liste_emargement" AND $a_faire2 <> "affiche_om")
			{
				echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_evenements.png\" ALT = \"Titre\">";
			}

////////////////////////////////////////////////////////////////////////
// Initialisation des différentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////
			$tri = $_GET['tri'];
			if (!ISSET($tri))
			{
				$tri = $_POST['tri'];
			}

			$sense_tri = $_GET['sense_tri'];
			if (!ISSET($sense_tri))
			{
				$sense_tri = $_POST['sense_tri'];
			}

			$action = $_GET['action'];
			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			$a_faire = $_GET['a_faire'];
			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}
			
			$id_evenement = $_GET['id_evenement'];
			if (!ISSET($id_evenement))
			{
				$id_evenement = $_POST['id_evenement'];
			}
			
			$visibilite = $_GET['visibilite'];
			if (!ISSET($visibilite))
			{
				$visibilite = $_POST['visibilite'];
			}
			
			$origine_appel = $_GET['origine_appel']; // entete
			if (!ISSET($origine_appel))
			{
				$origine_appel = $_POST['origine_appel']; // entete
			}
			
			$date_filtre = $_GET['date_filtre'];
			if (!ISSET($date_filtre))
			{
				$date_filtre = $_POST['date_filtre'];
			}

/*
			echo "<br />evenements_accueil.php";
			echo "<br />date_filtre : $date_filtre";
			echo "<br />tri : $tri";
			echo "<br />sense_tri : $sense_tri";
			echo "<br />origine_appel : $origine_appel";
			echo "<br />visibilite : $visibilite";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />id_evenement : $id_evenement";
*/

////////////////////////////////////////////////////////////////////////
// Début du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			if ($action == "O")
			{
				$id_evenement = $_GET['id_evenement'];
				switch ($a_faire)
				{
					case "ajout_evenement" :
						//echo "<h2>Ajout d'&eacute;v&eacute;nement</h2>";
						//include("evenement_ajout_evenement.inc.php");
						include("evenement_ajout.php");
						$affichage = "N";
					break;

					case "enreg_evenement" :
						echo "<h2>Enregistrement de l'&eacute;v&eacute;nement</h2>";
						include("evenement_enreg_evenement.inc.php");
						//$affichage = "N";
					break;

					case "info_evenement" :
						//echo "<h2>Information sur l'&eacute;v&eacute;nement $id_evenement</h2>";
						include("evenements_consult_evenement.inc.php");
						$affichage = "N";
					break;

					case "modif_evenement" :
						echo "<h2>Modification de l'&eacute;v&eacute;nement $id_evenement</h2>";
						//echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						$origine = $_GET['origine'];
						include ("evenement_modif_evenement.inc.php");
						$affichage = "N";
					break;

					case "maj_evenement" :
						include ("evenement_maj_evenement.inc.php");
					break;

					case "ajout_participants" :
						echo "<h2>Ajout de participants &agrave; l'&eacute;v&eacute;nement $id_evenement</h2>";
						include ("evenement_ajout_participant.inc.php");
					break;

					case "suppression_evenement" :
						include ("evenement_supprimer_evenement.inc.php");
						$affichage = "N";
					break;

					case "confirmer_supprimer_evenement" :
						include ("evenement_confirmer_supprimer_evenement.inc.php");
					break;

					case ('depot_liste_emargement') : //enregistrement d'un document
						$script = "evenements_accueil";
						$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						$annee = $_GET['annee'];
						$type = $_GET['type'];
						$id_formation = $_GET['id_formation'];
						$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];

						//echo "<h2>Dépôt de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour éviter que le ticket s'affiche
						include ("choix_fichier.inc.php");
					break;

				}
			}

	////////////////////////////////////////////////////////////////////////
	// Affichage du menu de l'entête de liste et de l'entête du tableau ////
	////////////////////////////////////////////////////////////////////////
		if ($affichage <> "N")
		{
			if ($origine_appel == "entete")
			{
				//On récupère les variables pour le filtrage
				$utilisateur_filtre = $_GET['utilisateur_filtre'];
				$dossier_filtre = $_GET['dossier_filtre'];
				$detail = $_GET['detail'];
				$date_filtre = $_GET['date_filtre'];
				
				//On remplace les caractères spéciaux par les codes html
				//$detail = remplace_caracteres_vers_code_html($detail);
/*
				$chaine_convertie = str_replace("é", "&eacute;", $detail);
				
				echo "<br />chaine_convertie : $chaine_convertie";
				$detail = $chaine_convertie;
				echo "<br />detail : $detail";
*/
/*
				echo "<br />utilisateur_filtre : $utilisateur_filtre";
				echo "<br />dossier_filtre : $dossier_filtre";
				echo "<br />detail : $detail";
				echo "<br />date_filtre : $date_filtre";
*/
				//On construit la requête
				$requete_base = "SELECT * FROM evenements AS e, categorie_commune AS cc, util AS u";
				$requete_condition = "WHERE e.fk_id_dossier = cc.id_categ AND e.fk_id_util = u.ID_UTIL AND e.omp = 'N'";

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

				if ($date_filtre <> '%')
				{
					if ($date_filtre == 1)
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut >= '".$date_auj."'";
					}
					elseif ($date_filtre == 2)
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut <= '".$date_auj."'";
					}
					else
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut = '".$date_filtre."'";
					}
				}


				if ($detail <> '')
				{
					$requete_condition = $requete_condition." AND (e.titre_evenement LIKE '%".$detail."%' OR e.detail_evenement LIKE '%".$detail."%')";
				}
			}
			else
			{
				$requete_base = "SELECT * FROM evenements AS e, categorie_commune AS cc, util AS u";
				$requete_condition = "WHERE cc.id_categ = e.fk_id_dossier AND e.fk_id_util = u.ID_UTIL AND e.omp = 'N'";
				if ($date_filtre <> '%')
				{
					if ($date_filtre == 1)
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut >= '".$date_auj."'";
					}
					elseif ($date_filtre == 2)
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut <= '".$date_auj."'";
					}
					else
					{
						$requete_condition = $requete_condition." AND e.date_evenement_debut = '".$date_filtre."'";
					}
				}
			}


			// Composition de la requête pour l'affichage de la liste ///
				$requete_condition_visibilite = "AND cc.actif = '".$visibilite."'";
			//$requete_tri = "ORDER BY $tri $sense_tri";
			$requete_tri = "ORDER BY $tri";

			$requete_complete = $requete_base." ".$requete_condition." "." ".$requete_condition_visibilite." ".$requete_tri;

			//echo "<br />requete_complete : $requete_complete<br />";

			// Menu de l'entête de liste ////////////////////////////////
			//if ($niveau_droits > 1)
			//{

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"evenements_accueil.php?origine=evenements_accueil&amp;action=O&amp;a_faire=ajout_evenement&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un dossier\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un &eacute;v&eacute;nement</span><br />";
								echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			//}

			// Exécution de la requête et comptage des enregistrements ////

			$resultat = mysql_query($requete_complete);
			if(!$resultat)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
				echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
				mysql_close();
				exit;
			}
			//Retourne le nombre de ligne rendu par la requête
			$nbr_resultat = mysql_num_rows($resultat);

				switch ($date_filtre)
				{
					case "%" :
						echo "<h2>Nombre total d'&eacute;v&eacute;nements&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
					break;
					case "1" :
						echo "<h2>Nombre d'&eacute;v&eacute;nements &agrave; venir&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
					break;
					case "2" :
						echo "<h2>Nombre d'&eacute;v&eacute;nements pass&eacute;es&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
					break;
				}
			
/*
			if ($visibilite == "O")
			{
				echo "<h2>Nombre d'&eacute;v&eacute;nements en cours&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
			}
			else
			{
				echo "<h2>Nombre d'&eacute;v&eacute;nements archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2><br />";
			}
*/
			if ($nbr_resultat > 0)
			{
				// Affichage de l'entête du tableau ////

				echo "<table>
					<tr>";
						echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "D&Eacute;BUT&nbsp;<a href=\"evenements_accueil.php?tri=date_evenement_debut desc, heure_debut_evenement desc&amp;sense_tri=desc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "D&Eacute;BUT&nbsp;<a href=\"evenements_accueil.php?tri=date_evenement_debut, heure_debut_evenement&amp;sense_tri=asc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
						echo "</th>";
						echo "<th>";
							echo "FIN";
						echo "</th>";
						echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "TITRE&nbsp;<a href=\"evenements_accueil.php?tri=titre_evenement desc&amp;sense_tri=desc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "TITRE&nbsp;<a href=\"evenements_accueil.php?tri=titre_evenement&amp;sense_tri=asc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						echo "</th>";
/*
						echo "<th>";
							echo "DESCRIPTION";
						echo "</th>";
*/
						echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "CR&Eacute;E PAR&nbsp;<a href=\"evenements_accueil.php?tri=NOM desc&amp;sense_tri=desc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "CR&Eacute;E PAR&nbsp;<a href=\"evenements_accueil.php?tri=NOM&amp;sense_tri=asc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
						echo "</th>";

						echo "<th>";
							echo "DOSSIER";
						echo "</th>";

						echo "<th>";
							echo "LIEU";
						echo "</th>";

						echo "<th nowrap>";
							echo "NB PART.";
						echo "</th>";
						echo "<th>";
							echo "OM";
						echo "</th>";
						echo "<th>";
							echo "DOC";
						echo "</th>";

						// On affiche l'id de l'événement pour l'utilisateur Mendel pour des raisons de débogage
						if ($_SESSION['id_util']==1)
						{
							echo "<th>";
								if ($sense_tri =="asc")
								{
									echo "ID&nbsp;<a href=\"evenements_accueil.php?tri=id_evenement desc&amp;sense_tri=desc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
								}
								else
								{
									echo "ID&nbsp;<a href=\"evenements_accueil.php?tri=id_evenement&amp;sense_tri=asc&amp;indice=0&amp;visibilite=$visibilite&amp;date_filtre=$date_filtre\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
								}
							echo "</th>";
						}

	/*
						//echo "<th>STRUCTURES</th>";
						echo "<th>&Eacute;V&Eacute;NEMENTS</th>";
						echo "<th>DOCUMENTS</th>";
						echo "<th>SUIVIS</th>";
						echo "<th>TICKETS</th>";
						echo "<th>T&Acirc;CHES</th>";
						//echo "<th><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\"></th>";
	*/
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
						$id_evenement = $ligne->id_evenement;
						$intitule_evenement = $ligne->libelleDossier;
						$description_evenement = $ligne->description;
						$id_responsable = $ligne->ID_UTIL;
						$nom_responsable = $ligne->NOM;
						$date_evenement = $ligne->date_evenement;
						$visibilite  = $ligne->visibilite;
	*/
						$id_evenement = $ligne->id_evenement;
						$titre_evenement = $ligne->titre_evenement;
						$detail_evenement = $ligne->detail_evenement;
						$id_responsable = $ligne->ID_UTIL;
						$nom_responsable = $ligne->NOM;
						$date_evenement_debut = $ligne->date_evenement_debut;
						$date_evenement_fin = $ligne->date_evenement_fin;
						$heure_debut_evenement = $ligne->heure_debut_evenement;
						$heure_fin_evenement = $ligne->heure_fin_evenement;
						$priorite  = $ligne->priorite;
						$dossier  = $ligne->intitule_categ;
						$fk_rne  = $ligne->fk_rne;
						$fk_repertoire  = $ligne->fk_repertoire;
						$autre_lieu  = $ligne->autre_lieu;
						
						echo "<br />fk_rne : $fk_rne";
						echo "<br />fk_repertoire : $fk_repertoire";
						echo "<br />autre_lieu : $autre_lieu";
						
						//On retire les secondes pour l'affichage
						$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
						$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);

						// On affiche l'enregistrement
						// On change de fond si la tâches est ant&eacute;rieure &agrave; la date du jour
						if ($date_evenement_debut < $date_auj)
						{
							//echo "<br />avant";
							echo "<tr class = \"avant_date\">";
						}
						else
						{
							//echo "<br />apr&egrave;s";
							echo "<tr>";
						}
							echo "<td>";
							$date_debut_a_afficher = affiche_date($date_evenement_debut);
							echo "$date_debut_a_afficher - $heure_debut_evenement";
							echo "</td>";
							echo "<td>";
							If ($date_evenement_fin <> "0000-00-00")
							{
								$date_fin_a_afficher = affiche_date($date_evenement_fin);
								echo "$date_fin_a_afficher - $heure_fin_evenement";
							}
							else
							{
								echo "$date_debut_a_afficher - $heure_fin_evenement";
							}
								//echo "$heure_debut_evenement - $heure_fin_evenement";
							echo "</td>";
							//echo "<td class = \"avant_date\" align = \"center\">";
							echo "<td>";
								echo "&nbsp;$titre_evenement&nbsp;";
							echo "</td>";
/*
							echo "<td>";
								$description_tronquee = tronquer_chaine($detail_evenement, 0, 50);
								echo "&nbsp;$description_tronquee&nbsp;";
							echo "</td>";
*/
							echo "<td>";
								echo "$nom_responsable";
							echo "</td>";

							echo "<td>";
								echo "$dossier";
							echo "</td>";
							echo "<td>";
								affiche_lieu_evenement($fk_rne, $fk_repertoire, $autre_lieu);
							echo "</td>";

							//On compte le nombre de participants à cet événement
							$nbr_participants = comptage_nbr_enregistrements_d_une_table("evenements_participants","id_evenement = $id_evenement");
							
							if ($nbr_participants == 0)
							{
								$affichage_participant = "";
							}
							else
							{
								//On compte le nombre d'OM en fonction de leur état
								$nbr_participants_sans_om = comptage_nbr_enregistrements_d_une_table("evenements_participants","id_evenement = $id_evenement AND etat_om =-1");
								$nbr_om_a_la_signature = comptage_nbr_enregistrements_d_une_table("evenements_participants","id_evenement = $id_evenement AND etat_om =2");
								$nbr_participants_convoques = comptage_nbr_enregistrements_d_une_table("evenements_participants","id_evenement = $id_evenement AND etat_om >2");
								$nbr_om_a_envoyer = $nbr_participants - $nbr_participants_sans_om;
								$affichage_participant = "<a title = \"Nombre participant-e-s\">$nbr_participants</a>&nbsp;";
								$affichage_om = "<a title = \"Nombre OM &agrave; envoyer\">$nbr_om_a_envoyer</a>&nbsp;";
								$affichage_om .= "/&nbsp;<a title = \"Nombre OM &agrave; la signature\">$nbr_om_a_la_signature</a>&nbsp;";
								$affichage_om .= "/&nbsp;<a title = \"Nombre participant-e-s convoqu&eacute;-e-s\">$nbr_participants_convoques</a>";
								//$affichage_participant = "$nbr_participants / $nbr_om_a_la_signature / $nbr_participants_convoques";
							}
							
							echo "<td align = \"center\">";
								echo "$affichage_participant";
							echo "</td>";

							echo "<td align = \"center\">";
								echo "$affichage_om";
							echo "</td>";

							echo "<td align = \"center\">";
								//On compte le nombre de documents déposés pour cet événement
								$nbr_docs_deposes = comptage_nbr_enregistrements_d_une_table("documents","id_ticket = $id_evenement AND module = 'EVE'");
								if ($nbr_docs_deposes > 0)
								{
									echo "$nbr_docs_deposes";
								}
								else
								{
									echo "&nbsp;";
								}
								//test_depot_liste_emargement($id_evenement);
							echo "</td>";

							if ($_SESSION['id_util']==1)
							{
								echo "<td align = \"center\">";
									echo "&nbsp;$id_evenement&nbsp;";
								echo "</td>";
							}
	/*
							echo "<td>";
								include ("evenements_accueil_affiche_collaborateurs.inc.php");
							echo "</td>";
							echo "<td>";
								echo "&nbsp;"; // structures
							echo "</td>";

							echo "<td align = \"center\">";
								echo "&nbsp;";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>"; // événements
							echo "</td>";
							echo "<td align = \"center\">";
								echo "&nbsp;"; // documents
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_document&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
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
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/suivi_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";

							echo "</td>";
							echo "<td align = \"center\">";
								echo "&nbsp;<strong>$nbr_tickets_actifs</strong>&nbsp;/&nbsp;$nbr_tickets_archives"; // tickets
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_ticket&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
							echo "</td>";
							echo "<td align = \"center\">";
								echo "&nbsp;<strong>$nbr_taches_actives</strong>&nbsp;/&nbsp;$nbr_taches_achevees&nbsp;"; // tâches
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_tache&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
							echo "</td>";

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
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;date_filtre=".$date_filtre."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter l'&eacute;v&eacute;nement\"></a>";
								if (($_SESSION['id_util'] == $id_responsable) OR ($niveau_droits == 3))
								{
									echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=modif_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;origine=evenements_accueil&amp;date_filtre=".$date_filtre."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier l'&eacute;v&eacute;nement\"></a>";
									echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;date_filtre=".$date_filtre."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout_participants.png\" border = \"0\" ALT = \"AjoutParticipant-e-s\" title=\"Ajouter des participant-e-s\"></a>";
									if ($nbr_participants > 0)
									{
										//&nbsp;<A HREF = \"formations_gestion.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;annee=".$res[1]."&amp;type=".$res[2]."&amp;rne=".$res[3]."&amp;module=$module&amp;id_societe=$id_societe&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"Ajouter un document\" title=\"Ajouter un document\" border=\"0\"></A>
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=depot_liste_emargement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&&amp;origine=evenements_accueil&amp;date_filtre=".$date_filtre."&amp;module=$module\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"d&eacute;p&ocirc;t document\" title=\"d&eacute;p&ocirc;t document\"></a>";
									}
									if ($nbr_taches_actives == 0
										AND $nbr_taches_achevees == 0
										AND $nbr_tickets_actifs == 0
										AND $nbr_tickets_archives == 0
										AND $nbr_suivis == 0
										AND $nbr_evenements == 0
										AND $nbr_documents == 0)
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=suppression_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer l'&eacute;v&eacute;nement\"></a>";
									}
								}
	/*						echo "</td>";
							echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi_document&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi_evenement&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi_ticket&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
								echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=ajout_suivi_tache&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
	*/
							echo "</td>";
	//////// Fin colonne des actions ////////////////////////////////////////////
						echo "</tr>";
					}
			}

		} //Fin $affichage <> "N"
////////////////////////////////////////////////////////////////////////
// Fin du script ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
