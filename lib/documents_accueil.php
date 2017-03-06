<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//On inclue les fichiers de configuration et de fonctions /////
	include ("../biblio/config.php");
	include ("../biblio/fct.php");

	// On vérifie le niveau des droits de la personne connectée /////
	$niveau_droits = verif_droits("documents_dossiers");

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
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_documents.png\" ALT = \"Titre\">";
			//echo "<h2>Suivi des documents</h2>";

////////////////////////////////////////////////////////////////////////
// Initialisation des différentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////
			$tri = $_GET['tri'];
			$sense_tri = $_GET['sense_tri'];
			$action = $_GET['action'];
			$a_faire = $_GET['a_faire'];
			$id_doc = $_GET['id_'];
			$visibilite = $_GET['visibilite'];
			$origine_appel = $_GET['origine_appel']; // entete
			$indice = $_GET['indice'];

			$nb_par_page = $nb_documents_par_page_documents;
			//echo "<br />nb_par_page : $nb_par_page";
	
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
			echo "<br />id_doc : $id_doc";
			echo "<br />visibilite : $visibilite";
			echo "<br />origine_appel : $origine_appel";
			echo "<br />indice : $indice";
*/
////////////////////////////////////////////////////////////////////////
// Début du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			if ($action == "O")
			{
				$id_doc = $_GET['id_doc'];
				switch ($a_faire)
				{
					case "ajout_document" :
						//echo "<h2>Ajout de suivi</h2>";
						include("documents_ajout_document.inc.php");
						$affichage = "N";
					break;

					case "enreg_document" :
						echo "<h2>Enregistrement du suivi</h2>";
						include("documents_enreg_document.inc.php");
						//$affichage = "N";
					break;

					case "info_document" :
						echo "<h2>Information sur le suivi No&nbsp;$id_doc</h2>";
						//echo "<h2>Proc&eacute;dure en pr&eacute;paration</h2>";
						include("documents_consult_document.inc.php");
						$affichage = "N";
					break;

					case "modif_document" :
						echo "<h2>Modification du suivi $id_doc</h2>";
						$origine = "documents_accueil";
						include ("documents_modif_document.inc.php");
						$affichage = "N";
					break;

					case "enreg_modif_document" :
						include ("documents_maj_document.inc.php");
					break;

					case "suppression_document" :
						//echo "<h2>Suppression du suivi $id_doc</h2>";
						include ("documents_supprimer_document.inc.php");
						$affichage = "N";
					break;

					case "confirmer_supprimer_document" :
						$bouton_retour = $_GET['bouton_envoyer_modif'];

						//echo "<br />bouton_retour : $bouton_retour";

						if ($bouton_retour <> "Retourner sans enregistrer")
						{
							include ("documents_confirmer_supprimer_document.inc.php");
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
				$module_filtre = $_GET['module_filtre'];
				$detail = $_GET['detail'];

				//On construit la requête
				$requete_base = "SELECT * FROM documents AS d";
				$requete_condition = "WHERE d.module <> 'COU' ";
/*
				echo "<br />module_filtre : $module_filtre";
				echo "<br />utilisateur_filtre : $utilisateur_filtre";
				echo "<br />dossier_filtre : $dossier_filtre";
				echo "<br />detail : $detail";
				echo "<br />visibilite : $visibilite";
*/
				if ($utilisateur_filtre <> '%')
				{
					$requete_condition = $requete_condition." AND u.ID_UTIL = '".$utilisateur_filtre."'";
				}

				if ($module_filtre <> '%')
				{
					$requete_condition = $requete_condition." AND d.module = '".$module_filtre."'";
				}

				if ($detail <> '')
				{
					$requete_condition = $requete_condition." AND (s.titre LIKE '%".$detail."%' OR s.description LIKE '%".$detail."%')";
				}

				if ($dossier_filtre <> '%')
				{
					$requete_base = "SELECT * FROM documents AS d, categorie_commune AS cc, documents_categories_communes AS dcc";
					$requete_condition = $requete_condition." AND cc.id_categ = '".$dossier_filtre."'";
				}
			}
			else
			{
				//$requete_base = "SELECT * FROM documents AS d, categorie_commune AS cc, documents_categories_communes AS dcc";
				$requete_base = "SELECT * FROM documents AS d";
				$requete_condition = "WHERE d.module <> 'COU'";
			}

			//$requete_condition_visibilite = " AND cc.actif LIKE '".$visibilite."'";
			$requete_tri = "ORDER BY date_document";

			//$requete_complete = $requete_base." ".$requete_condition." "." ".$requete_condition_visibilite." ".$requete_tri;
			$requete_complete = $requete_base." ".$requete_condition." ".$requete_tri;

			//echo "<br />$requete_complete<br />";

			// Menu de l'entête de liste ////////////////////////////////

/*
			if ($niveau_droits > 1)
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_document&amp;tri=$tri&amp;sense_tri=$sense_tri\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un suivi\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un suivi</span><br />";
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
				/*
				if ($visibilite == "O")
				{
					echo "<h2>Nombre de documents en cours&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}
				elseif ($visibilite == "N")
				{
					echo "<h2>Nombre de documents archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}
				else
				{
					echo "<h2>Nombre de tous les documents en cours et archiv&eacute;s&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";
				}
				*/
				echo "<h2>Nombre de documents&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong></h2>";

				///////////////////////////////////
				//Partie sur la gestion des pages//
				///////////////////////////////////
				$nombre_de_page = number_format($nbr_resultat/$nb_par_page,1);
				$par_navig = "0"; //initialisation du compteur pour compter les numéros de pages, et insérer un saut de ligne
				
				//echo "<br />nombre_de_page : $nombre_de_page";

				echo "<br />Page&nbsp;";
				If ($indice == 0)
				{
					echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
				}
				else
				{
					echo "<a href = \"documents_accueil.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
				}
				
				for($j = 1; $j<$nombre_de_page; ++$j)
				{
					$nb = $j * $nb_par_page;
					$page = $j + 1;
					$par_navig++;
					if($par_navig=="40")
					{
						echo "<br />";
						$par_navig=0;
					}
					if ($page * $nb_par_page == $indice + $nb_par_page)
					{
						echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
					}
					else
					{
						echo "&nbsp;<a href = \"documents_accueil.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=".$nb."&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
					}
				}
				$j = 0;
				while($j<$indice) //On se positionne dans la table au niveau de l'indice de la page
				{
					$ligne = mysql_fetch_object($resultat);
					++$j;
				}

				/////////////////////////
				//Fin gestion des pages//
				/////////////////////////


				// Affichage de l'entête du tableau ////
				echo "<table>
					<tr>
						<th>";
							if ($sense_tri =="asc")
							{
								echo "ID&nbsp;<a href=\"documents_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de document, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "ID&nbsp;<a href=\"documents_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de document, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						echo "</th>";
						echo "</th>";
						if ($tri <> "MeAa" AND $tri <> "Me")
						{
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "D&Eacute;POS&Eacute; PAR&nbsp;<a href=\"documents_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "D&Eacute;POS&Eacute; PAR&nbsp;<a href=\"documents_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						}
						echo "</th>";
						echo "<th>";
							echo "DATE D&Eacute;P&Ocirc;T";
						echo "</th>";
						echo "<th>";
							echo "DATE DU DOC";
						echo "</th>";
						echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "TITRE&nbsp;<a href=\"documents_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "TITRE&nbsp;<a href=\"documents_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						echo "</th>";
						echo "<th>";
							echo "DESCRIPTION";
						echo "<th>";
							echo "MODULE";
						echo "</th>";
						echo "<th>";
							echo "DOSSIER";
						echo "</th>";
						echo "<th>";
							echo "TICKET";
						echo "</th>";
						echo "<th>";
							echo "ECL";
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
	// Affichage des documents existants ////////////////////////////////////
	////////////////////////////////////////////////////////////////////////

					for($i = 0; $i < $nb_par_page; ++$i) //On affiche les enregistrements de la page sélectionnée
					{
						$ligne = mysql_fetch_object($resultat);
//					while ($ligne = mysql_fetch_object($resultat))
//					{
	/*
						$id_doc = $ligne->idsuivi;
						$intitule_document = $ligne->libellesuivi;
						$description_document = $ligne->description;
						$id_responsable = $ligne->ID_UTIL;
						$nom_responsable = $ligne->NOM;
						$date_creation = $ligne->DateCreation;
						$visibilite  = $ligne->visibilite;
	*/
						$id_doc = $ligne->id_doc;
						$id_ticket = $ligne->id_ticket;
						$id_util_deposant = $ligne->id_util_deposant;
						$nom_doc = $ligne->nom_doc;
						$nom_fichier = $ligne->nom_fichier;
						$module  = $ligne->module;
						$description_doc = $ligne->description_doc;
						$date_depot  = $ligne->date_depot;
						$date_document  = $ligne->date_document;

						// On récupère le nom du responsable
						$nom_responsable = lecture_utilisateur("NOM",$id_util_deposant);

						// On affiche l'enregistrement
						echo "<tr>";
							echo "<td align = \"center\">";
								echo "&nbsp;$id_doc&nbsp;";
							echo "</td>";
							echo "<td>";
								echo "$nom_responsable";
							echo "</td>";
							echo "<td>";
								if ($date_depot == "0000-00-00")
								{
									echo "&nbsp;";
								}
								else
								{
									$date_a_afficher = affiche_date($date_depot);
									echo "$date_a_afficher";
								}
							echo "</td>";
							echo "<td>";
								if ($date_document == "0000-00-00")
								{
									echo "&nbsp;";
								}
								else
								{
									$date_a_afficher = affiche_date($date_document);
									echo "$date_a_afficher";
								}
							echo "</td>";
							echo "<td>";
								echo "&nbsp;$nom_doc&nbsp;";
							echo "</td>";
							echo "<td>";
								$description_tronquee = tronquer_chaine($description_doc, 0, 50);
								echo "$description_tronquee";
							echo "</td>";
							echo "<td align = \"center\">";
								//On récupère l'intitulé à partir de l'abbréviation enregistrée
								$intitule_module = lecture_champ("modules_collaboratice","intitule_module","abbreviation",$module);
								echo "$intitule_module";
							echo "</td>";
							echo "<td>";
								echo "$intitule_categ";
							echo "</td>";
							echo "<td>";
								echo "$id_ticket";
							echo "</td>";
							echo "<td>";
							 	affiche_info_bulle($ecl,"RESS",0);
								//echo "$ecl";
							echo "</td>";
	//////// Colonne des actions ////////////////////////////////////////////////
								echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=info_document&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter le suivi\"></a>";
								if ($id_responsable == $_SESSION['id_util'] OR $niveau_droits == 3)
								{
									echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=modif_document&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le suivi\"></a>";
									echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=suppression_document&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer le suivi\"></a>";
								}
/*								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_documents_evenement&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout.png\" border = \"0\" ALT = \"Ajout &eacute;v&eacute;nement\" title=\"Ajouter un &eacute;v&eacute;nement\"></a>";
								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_documents_document&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout document\" title=\"Ajouter un document\"></a>";
								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_documents_document&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/documents_ajout.png\" border = \"0\" ALT = \"Ajout suivi\" title=\"Ajouter un suivi\"></a>";
								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_documents_ticket&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" border = \"0\" ALT = \"Ajout ticket\" title=\"Ajouter un ticket\"></a>";
								echo "&nbsp;<a href = \"documents_accueil.php?action=O&amp;a_faire=ajout_documents_tache&amp;id_doc=".$id_doc."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tache_ajout.png\" border = \"0\" ALT = \"Ajout t&acirc;che\" title=\"Ajouter une t&acirc;che\"></a>";
	*/
							echo "</td>";

	//////// Fin colonne des actions ////////////////////////////////////////////
						echo "</tr>";
					} //Fin while
				} // Fin if num
				else
				{
					echo "<h2>Pas de documents pour l'instant</h2>";
				}
			} //Fin $affichage <> "N"

////////////////////////////////////////////////////////////////////////
// Fin du script ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
