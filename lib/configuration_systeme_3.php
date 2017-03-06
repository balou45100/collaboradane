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

			echo "<h2>Configuration des modules</h2>";

			//Vérification des droits pour pouvoir intervenir sur la configuration
			$droit_configuration_systeme = verif_droits("configuration_systeme");

			if ($droit_configuration_systeme == 3)
			{
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_1.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_1.png\" title = \"Configuration de base\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration de base&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_2.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_2.png\" title = \"Configuration dossiers de stockage\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Dossiers stockage&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_32.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_3.png\" title = \"Configuration module OM\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration module OM&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_4.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_4.png\" title = \"Configuration boutons fichier repertoire_consult_fiche\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Boutons fichier repertoire_consult_fiche&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_5.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_5.png\" title = \"Configuration taille des ic&ocirc;nes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Taille ic&ocirc;nes&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_6.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_6.png\" title = \"Configuration listes d&eacute;roulantes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Listes d&eacute;roulantes&nbsp;";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

				$action = $_POST['action'];

				if ($action == "O")
				{
					$nbr_jours_decallage_pour_rappel = $_POST['nbr_jours_decallage_pour_rappel'];
					$nb_taches_par_page_taches = $_POST['nb_taches_par_page_taches'];
					$tb_valeur_par_defaut = $_POST['tb_valeur_par_defaut'];
					$nb_tickets_par_page_tickets = $_POST['nb_tickets_par_page_tickets'];
					$nb_taches_par_page_suivi_collaboratice = $_POST['nb_taches_par_page_suivi_collaboratice'];
					$nb_documents_par_page_documents = $_POST['nb_documents_par_page_documents'];
					$nb_utilisateurs_a_afficher = $_POST['nb_utilisateurs_a_afficher'];
					$annee_budgetaire = $_POST['annee_budgetaire'];
					$monnaie_utilisee = $_POST['monnaie_utilisee'];
					$compteur_debut = $_POST['compteur_debut'];
					$compteur_fin = $_POST['compteur_fin'];
/*
					$cardie_dispositif_formation = $_POST['cardie_dispositif_formation'];
					$cardie_module_formation = $_POST['cardie_module_formation'];
					$cardie_mel_fonctionnelle = $_POST['cardie_mel_fonctionnelle'];
					$dafop_mel_fonctionnelle = $_POST['dafop_mel_fonctionnelle'];
*/
					//On enregistre les modifications
					$req_maj = "UPDATE configuration_systeme SET
						`nbr_jours_decallage_pour_rappel` = '".$nbr_jours_decallage_pour_rappel."',
						`nb_taches_par_page_taches` = '".$nb_taches_par_page_taches."',
						`tb_valeur_par_defaut` = '".$tb_valeur_par_defaut."',
						`nb_tickets_par_page_tickets` = '".$nb_tickets_par_page_tickets."',
						`nb_taches_par_page_suivi_collaboratice` = '".$nb_taches_par_page_suivi_collaboratice."',
						`nb_utilisateurs_a_afficher` = '".$nb_utilisateurs_a_afficher."',
						`nb_documents_par_page_documents` = '".$nb_documents_par_page_documents."',
						`annee_budgetaire` = '".$annee_budgetaire."',
						`monnaie_utilisee` = '".$monnaie_utilisee."',
						`compteur_debut` = '".$compteur_debut."',
						`compteur_fin` = '".$compteur_fin."'
						";

/* retiré de la requête ci-dessus :
						`cardie_dispositif_formation` = '".$cardie_dispositif_formation."',
						`cardie_module_formation` = '".$cardie_module_formation."',
						`cardie_mel_fonctionnelle` = '".$cardie_mel_fonctionnelle."',
						`dafop_mel_fonctionnelle` = '".$dafop_mel_fonctionnelle."',
*/

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

				echo "<form action = \"configuration_systeme_3.php\" METHOD = \"POST\">";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations gestion t&acirc;ches</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre de jours de d&eacute;callage pour rappel&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nbr_jours_decallage_pour_rappel\" NAME = \"nbr_jours_decallage_pour_rappel\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Nombre de t&acirc;ches par page&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->nb_taches_par_page_taches\" NAME = \"nb_taches_par_page_taches\" SIZE=\"10\"></td>
						</tr>";
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Tableau de bord</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre de jours par d&eacute;faut&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->tb_valeur_par_defaut\" NAME = \"tb_valeur_par_defaut\" SIZE=\"10\"></td>
						</tr>";

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Gestion des tickets</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre de tickets par page&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_tickets_par_page_tickets\" NAME = \"nb_tickets_par_page_tickets\" SIZE=\"10\"></td>
						</tr>";

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Gestion des utilisateurs</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre d'utilisateurs par page&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_utilisateurs_a_afficher\" NAME = \"nb_utilisateurs_a_afficher\" SIZE=\"10\"></td>
						</tr>";

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Suivi du d&eacute;veloppement de collaboradane</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre de tickets par page&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_taches_par_page_suivi_collaboratice\" NAME = \"nb_taches_par_page_suivi_collaboratice\" SIZE=\"10\"></td>
						</tr>";

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Gestion des cr&eacute;dits</td>";
						echo "</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_budgetaire\" NAME = \"annee_budgetaire\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Monnaie utilis&eacute;e&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->monnaie_utilisee\" NAME = \"monnaie_utilisee\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e de d&eacute;but&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->compteur_debut\" NAME = \"compteur_debut\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Nombre d'ann&eacute;es &agrave; partir de l'ann&eacute;e de d&eacute;but&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->compteur_fin\" NAME = \"compteur_fin\" SIZE=\"10\"></td>
						</tr>";

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Suivi des documents</td>";
						echo "</tr>";


						echo "<tr>
							<td class = \"etiquette\">Nombre de documents par page&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->nb_documents_par_page_documents\" NAME = \"nb_documents_par_page_documents\" SIZE=\"10\"></td>
						</tr>";

/*
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Module CARDIE</td>";
						echo "</tr>";

						echo "<tr>
							<td class = \"etiquette\">Dispositif de formation&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_dispositif_formation\" NAME = \"cardie_dispositif_formation\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Module de formation&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_module_formation\" NAME = \"cardie_module_formation\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse(s) &eacute;lectronique(s) de la CARDIE&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_mel_fonctionnelle\" NAME = \"cardie_mel_fonctionnelle\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse(s) &eacute;lectronique(s) de la DAFOP&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dafop_mel_fonctionnelle\" NAME = \"dafop_mel_fonctionnelle\" SIZE=\"50\"></td>
						</tr>";
*/
					echo "</table>";

					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
							echo "</TD>";
						echo "</tr>";
					echo "</table>";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"1\" NAME = \"domaine\">";

				echo "</FORM>";
			} //Fin vérif droits
			else
			{
				echo "<h1>Vous n'avez pas les droits pour intervenir sur la configuration de l'espace</h1>";
			}
	echo "</div>";
?>
