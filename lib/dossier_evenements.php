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
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		echo "<body>";
			echo "<center>";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_dossiers.png\" ALT = \"Titre\">";
			echo "<h2>Suivi des &eacute;v&eacute;nements</h2>";
			
			echo "<h2>Scripts en pr&eacute;paration</h2>";

////////////// Menu de l'entête de liste ////////////////////////////////
			if ($niveau_droits > 1)
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"dossier_accueil.php?tri=Int&amp;sense_tri=ASC&amp;statut=OUVERT \"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dossiers.png\" ALT = \"Dossiers\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Accueil Dossiers</span><br />";
								echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			}
/////////////////////////////////////////////////////////////////////////
/*
////////////////////////////////////////////////////////////////////////
// Initialisation des différentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////
			$tri = $_GET['tri'];
			$sense_tri = $_GET['sense_tri'];
			$action = $_GET['action'];
			$a_faire = $_GET['a_faire'];
			$id_dossier = $_GET['id_dossier'];
			
			echo "<br />tri : $tri";
			echo "<br />sense_tri : $sense_tri";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />id_dossier : $id_dossier";

////////////////////////////////////////////////////////////////////////
// Début du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			if ($action == "O")
			{
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
					break;
					
					case "modif_dossier" :
						echo "<h2>Modification du dossier $id_dossier</h2>";
					break;
					
					case "suppression_dossier" :
						echo "<h2>Suppression du dossier $id_dossier</h2>";
					break;
				}
			}

////////////////////////////////////////////////////////////////////////
// Affichage du menu de l'entête de liste et de l'entête du tableau ////
////////////////////////////////////////////////////////////////////////
		if ($affichage <> "N")
		{
			// Composition de la requête pour l'affichage de la liste ///
			$requete_base = "SELECT * FROM dos_dossier AS DD, util AS U";
			$requete_condition = "WHERE DD.responsable = U.ID_UTIL";
			$requete_tri = "ORDER BY libelleDossier";
			$requete_complete = $requete_base." ".$requete_condition." ".$requete_tri;
			//
			//echo "<br />requete_complete : $requete_complete<br />";

			// Menu de l'entête de liste ////////////////////////////////
			if ($niveau_droits > 1)
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"dossier_evenements.php?action=O&amp;a_faire=ajout_evenement&amp;tri=$tri&amp;sense_tri=$sense_tri\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un evenement\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un evenement</span><br />";
								echo "</td>";
								echo "<td>";
									echo "<a href = \"dossier_accueil.php?tri=Int&amp;sense_tri=ASC&amp;statut=OUVERT \"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dossiers.png\" ALT = \"Dossiers\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Accueil Dossiers</span><br />";
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
			echo "Nombre de evenements&nbsp;:&nbsp;<strong>&nbsp;$nbr_resultat&nbsp;</strong><br />";

			// Affichage de l'entête du tableau ////

			echo "<table>
				<tr>
					<th>";
						if ($sense_tri =="asc")
						{
							echo "ID&nbsp;<a href=\"dossier_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "ID&nbsp;<a href=\"dossier_accueil.php?tri=ID&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					echo "</th>";
					echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "INTITUL&Eacute;&nbsp;<a href=\"dossier_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "INTITUL&Eacute;&nbsp;<a href=\"dossier_accueil.php?tri=Int&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
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
							echo "RESPONSABLE&nbsp;<a href=\"dossier_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "RESPONSABLE&nbsp;<a href=\"dossier_accueil.php?tri=Res&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					}
					echo "</th>";
					echo "<th>";
						echo "OUVERT LE";
					echo "</th>";
					echo "<th>STRUCTURES</th>";
					echo "<th>&Eacute;V&Eacute;NEMENTS</th>";
					echo "<th>DOCUMENTS</th>";
					echo "<th>SUIVIS</th>";
					echo "<th><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\"></th>";
					echo "<th>";
						echo "ACTIONS";
					echo "</th>";
				echo "</tr>";

////////////////////////////////////////////////////////////////////////
// Affichage des dossiers existants ////////////////////////////////////
////////////////////////////////////////////////////////////////////////
				while ($ligne = mysql_fetch_object($resultat))
				{
					$id_dossier = $ligne->idDossier;
					$intitule_dossier = $ligne->libelleDossier;
					$description_dossier = $ligne->description;
					$id_responsable = $ligne->ID_UTIL;
					$nom_responsable = $ligne->NOM;
					$date_creation = $ligne->DateCreation;
					$visibilite  = $ligne->visibilite;

					echo "<tr>";
						echo "<td align = \"center\">";
							echo "&nbsp;$id_dossier&nbsp;";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;$intitule_dossier&nbsp;";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;$description_dossier&nbsp;";
						echo "</td>";
						echo "<td>";
							echo "$nom_responsable";
						echo "</td>";
						echo "<td>";
							echo "$date_creation";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;"; // structures
						echo "</td>";
						echo "<td>";
							echo "&nbsp;"; // événements
						echo "</td>";
						echo "<td>";
							echo "&nbsp;"; // documents
						echo "</td>";
						echo "<td>";
							echo "&nbsp;"; // suivis
						echo "</td>";
						if ($visibilite == "PR")
						{
							echo "<td><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"privé\"></td>";
						}
						else
						{
							echo "<td>&nbsp;</TD>";
						}

//////// Colonne des actions ////////////////////////////////////////////////
						echo "<td class = \"fond-actions\" nowrap>";
							echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=info_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter le projet\"></a>";
							if ($niveau_droits == 3)
							{
								echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=modif_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le dossier\"></a>";
								echo "&nbsp;<a href = \"dossier_accueil.php?action=O&amp;a_faire=suppression_dossier&amp;id_dossier=".$id_dossier."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"32px\" width=\"32px\"></a>";
							}
						
						echo "</td>";
//////// Fin colonne des actions ////////////////////////////////////////////
					echo "</tr>";
				}
		} //Fin $affichage <> "N"
*/
////////////////////////////////////////////////////////////////////////
// Fin du script ///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
