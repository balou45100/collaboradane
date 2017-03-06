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
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_configuration_systeme.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");

			$action = $_POST['action'];
			
			echo "<br />action : $action";
			
			if ($action == "O")
			{
				echo "<br />J'applique les modifications";
				$version = $_POST['version'];
				
				echo "<br />version : $version";
				
				//On enregistre les modifications
				$req_maj = "UPDATE configuration_systeme SET
					`version` = '".$version."'
					";
					
				echo "<br />requete : $req_maj";
					
				$result_maj = mysql_query($req_maj);
				if (!$result_maj)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					echo "<h2>La fiche a bien &eacute;t&eacute; modifi&eacute;e</h2>";
				}
			} // Fin action

			//On se connecte à la table configuration_systeme pour récupérer les différentes variables
			$req_conf_systeme = "SELECT * FROM configuration_systeme";
			$res_req_conf_systeme = mysql_query($req_conf_systeme);
			$ligne = mysql_fetch_object($res_req_conf_systeme);
			$id = $ligne->id;

		echo" <div align = \"center\">";
			echo "<h2>Configuration du syst&egrave;me</h2>";



			echo "<form action = \"configuration_systeme.php\" METHOD = \"POST\">";
				echo "<table>";
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations g&eacute;n&eacute;rales</td>";
					echo "</tr>";
					echo "<tr>
						<td class = \"etiquette\">Nom de l'espace&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->nom_espace\" NAME = \"nom_espace\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Description de l'espace&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->description_espace\" NAME = \"description_espace\" SIZE=\"30\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Version&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->version\" NAME = \"version\" SIZE=\"10\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Date derni&egrave;re mise &agrave; jour&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->date_version\" NAME = \"date_version\" SIZE=\"10\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Logo 1&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->logo1\" NAME = \"logo1\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Logo 2&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->logo2\" NAME = \"logo2\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Image de connexion&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->image_connexion\" NAME = \"image_connexion\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Chemin des images&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->chemin_images\" NAME = \"chemin_images\" SIZE=\"20\"></td>
					</tr>";
					
					echo "<tr>
						<td class = \"etiquette\">Ann&eacute;e en cours&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_en_cours\" NAME = \"annee_en_cours\" SIZE=\"10\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Ann&eacute;e scolaire&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_scolaire\" NAME = \"annee_scolaire\" SIZE=\"10\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Ann&eacute;e Rencontres&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_RT\" NAME = \"annee_RT\" SIZE=\"10\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Adresse espace&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->adresse_collaboratice\" NAME = \"adresse_collaboratice\" SIZE=\"40\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Adresse absolu dossier /lib/&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_lib_adresse_absolu\" NAME = \"dossier_lib_adresse_absolu\" SIZE=\"40\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Message 1 non connect&eacute;&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->message_non_connecte1\" NAME = \"message_non_connecte1\" SIZE=\"40\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Message 2 non connect&eacute;&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->message_non_connecte2\" NAME = \"message_non_connecte2\" SIZE=\"40\"></td>
					</tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Dossiers de stockage des fichiers des modules</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">Gestion des tickets&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_docs_gestion_tickets\" NAME = \"dossier_docs_gestion_tickets\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Gestion du courrier&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_docs_courriers\" NAME = \"dossier_docs_courriers\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Gestion Webradio&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_webradio_ressources\" NAME = \"dossier_webradio_ressources\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Documents vari&eacute;s&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_documents\" NAME = \"dossier_documents\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Gestion des formations&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_docs_formation\" NAME = \"dossier_docs_formation\" SIZE=\"20\"></td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Dossier des logos&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_pour_logos\" NAME = \"dossier_pour_logos\" SIZE=\"20\"></td>
					</tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations gestion t&acirc;ches</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">Nombre de jours de d&eacute;callage pour rappel&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nbr_jours_decallage_pour_rappel\" NAME = \"nbr_jours_decallage_pour_rappel\" SIZE=\"10\">$ligne->nbr_jours_decallage_pour_rappel</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Nombre de t&acirc;ches par page&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->nb_taches_par_page_taches\" NAME = \"nb_taches_par_page_taches\" SIZE=\"10\">$ligne->nb_taches_par_page_taches</td>
					</tr>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Tableau de bord</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">Nombre de jours par d&eacute;faut&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->tb_valeur_par_defaut\" NAME = \"tb_valeur_par_defaut\" SIZE=\"10\">$ligne->tb_valeur_par_defaut</td>
					</tr>";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Gestion des tickets</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">Nombre de tickets par page&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_tickets_par_page_tickets\" NAME = \"nb_tickets_par_page_tickets\" SIZE=\"10\">$ligne->nb_tickets_par_page_tickets</td>
					</tr>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Suivi du d&eacute;veloppement de collaboratice</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">Nombre de tickets par page&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_taches_par_page_suivi_collaboratice\" NAME = \"nb_taches_par_page_suivi_collaboratice\" SIZE=\"10\">$ligne->nb_taches_par_page_suivi_collaboratice</td>
					</tr>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Gestion des cr&eacute;dits</td>";
					echo "</tr>";

					echo "<tr>
						<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_budgetaire\" NAME = \"annee_budgetaire\" SIZE=\"10\">$ligne->annee_budgetaire</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Ann&eacute;e de d&eacute;but&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->compteur_debut\" NAME = \"compteur_debut\" SIZE=\"10\">$ligne->compteur_debut</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Nombre d'ann&eacute;es &agrave; partir de l'ann&eacute;e de d&eacute;but&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->compteur_fin\" NAME = \"compteur_fin\" SIZE=\"10\">$ligne->compteur_fin</td>
					</tr>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations fichier repertoire_consult_fiche.php</td>";
					echo "</tr>";

					echo "<tr>
						<td class = \"etiquette\">Bouton <<&nbsp;salon&nbsp;>>&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_salon\" NAME = \"bt_salon\" SIZE=\"10\">$ligne->bt_salon</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Bouton <<&nbsp;manifestation&nbsp;>>&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_manifestation\" NAME = \"bt_manifestation\" SIZE=\"10\">$ligne->bt_manifestation</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Bouton <<&nbsp;partenaires&nbsp;>>&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_partenaire\" NAME = \"bt_partenaire\" SIZE=\"10\">$ligne->bt_partenaire</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Bouton <<&nbsp;participants&nbsp;>>&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_participant\" NAME = \"bt_participant\" SIZE=\"10\">$ligne->bt_participant</td>
					</tr>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Tailles des ic&ocirc;nes</td>";
					echo "</tr>";

					echo "<tr>
						<td class = \"etiquette\">Menu, largeur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->largeur_icone_menu\" NAME = \"largeur_icone_menu\" SIZE=\"10\">$ligne->largeur_icone_menu</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Menu, hauteur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->hauteur_icone_menu\" NAME = \"hauteur_icone_menu\" SIZE=\"10\">$ligne->hauteur_icone_menu</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Action, largeur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->largeur_icone_action\" NAME = \"largeur_icone_action\" SIZE=\"10\">$ligne->largeur_icone_action</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Action, hauteur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->hauteur_icone_action\" NAME = \"hauteur_icone_action\" SIZE=\"10\">$ligne->hauteur_icone_action</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Tri, largeur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->largeur_icone_tri\" NAME = \"largeur_icone_tri\" SIZE=\"10\">$ligne->largeur_icone_tri</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Tri, hauteur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->hauteur_icone_tri\" NAME = \"hauteur_icone_tri\" SIZE=\"10\">$ligne->hauteur_icone_tri</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Favoris, largeur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->largeur_icone_favoris\" NAME = \"largeur_icone_favoris\" SIZE=\"10\">$ligne->largeur_icone_favoris</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Favoris, hauteur&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->hauteur_icone_favoris\" NAME = \"hauteur_icone_favoris\" SIZE=\"10\">$ligne->hauteur_icone_favoris</td>
					</tr>";

				echo "</table>";

				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_user.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
/*
						echo "<td>";
							echo "<a href = \"gestion_user.php?action=O&amp;a_faire=modification_confirmee&amp;id_util=$res[3]\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/oui.png\" ALT = \"Enregistrer\" title=\"Enregistrer les modifications\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
						echo "</td>";
*/
						echo "<td>";
							echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
						echo "</TD>";
					echo "</tr>";
				echo "</table>";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";

			echo "</FORM>";
		echo "</div>";


?>
