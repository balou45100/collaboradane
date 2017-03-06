<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<?php
	include ("../biblio/cardie_config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");

	$util = $_SESSION['id_util'];
	$identifiant = $_SESSION['identifiant'];
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	$theme = $_SESSION['chemin_theme']."collaboratice_barre_modules.css";

	//echo "<br />theme : $theme";

	//On v�rifie les droits de l'utilisateur connect�
/*
	$autorisation_genies = verif_appartenance_groupe(2);
	$autorisation_salon = verif_appartenance_groupe(7);
	$autorisation_gestion_materiels = verif_appartenance_groupe(8);
	$autorisation_personnes_ressource = verif_appartenance_groupe(9);
	$autorisation_gestion_credits = verif_appartenance_groupe(11);
	$autorisation_courrier = verif_appartenance_groupe(15);
	$autorisation_gestion_groupes = verif_appartenance_groupe(13);
	$droit_administrateur = verif_appartenance_groupe(14);
	$autorisation_gestion_om = verif_appartenance_groupe(16);
	$autorisation_gestion_abos = verif_appartenance_groupe(17);
	$autorisation_statistiques = verif_appartenance_groupe(19);
	$autorisation_repertoire = verif_appartenance_groupe(20);
	$autorisation_contacts = verif_appartenance_groupe(21);
	$autorisation_taches = verif_appartenance_groupe(22);
	$autorisation_favoris = verif_appartenance_groupe(23);
	$autorisation_suivi_collaboratice = verif_appartenance_groupe(24);
	$autorisation_suivi_dossiers = verif_appartenance_groupe(25);
	$autorisation_contacts_prives = verif_appartenance_groupe(26);
	$autorisation_webradio = verif_appartenance_groupe(29);
	$autorisation_config_systeme = verif_appartenance_groupe(30);
	$autorisation_membres = verif_appartenance_groupe(28);
	$autorisation_cardie = verif_appartenance_groupe(31);
	$autorisation_configuration_cardie = verif_appartenance_groupe(32);

*/
	$autorisation_ecl = verif_appartenance_groupe(27);
	$autorisation_gestion_tickets = verif_appartenance_groupe(18);
	//$autorisation_formation = verif_appartenance_groupe(5);

	$niveau_droits_suivi_dossier = verif_droits("suivi_dossiers");

	//r�glages des tailles des cellule suivant que c'est un utilisateur ou l'administrateur qui se connecte
/*
	{
		$cellule1="6%"; //marge gauche
		$cellule2="52%"; //pour l'affichage des ic�nes des modules principales
		$cellule3="30%"; //pour les ic�nes des fonctionnalit&eacute;s commune et de gestion
		$cellule4="6%";  //pour le bouton e d&eacute;connexion
		$cellule5="6%"; //pour le copyright
	}
	else
	{
*/
		$cellule1="6%"; //marge gauche
		$cellule2="58%"; //pour l'affichage des ic�nes des modules principales
		$cellule3="25%"; //pour les ic�nes des fonctionnalit&eacute;s commune et de gestion
		$cellule4="6%";  //pour le bouton de d&eacute;connexion
		$cellule5="5%"; //pour le copyright
	//}

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		//echo "<meta charset=\"UTF-8\">";
		echo "<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"600 url=suivi_barre_modules.php\">";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body class = \"menu-boutons\">";
	echo "<div>";
	echo "<table class = \"MenuModules\">";
	$util_connecte = $_SESSION['nom'];
	//$util_connecte = $_SESSION['identifiant'];
		echo "<tr>";
			//echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"accueil_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Accueil\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/accueil.png\" ALT = \"Tableau de bord\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"modules.php\" class=\"bouton\" title=\"Afficher la barre de modules compl&egrave;te\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Barre compl&egrave;te\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"suivi_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion suivis\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/suivi_dossier.png\" ALT = \"Suivis\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"dossier_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Accueil dossiers\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dossiers.png\" ALT = \"Dossiers\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"evenements_cadre.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;v&eacute;nements\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/evenement.png\" ALT = \"&Eacute;v&eacute;nements\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"documents_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Documents\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/documents.png\" ALT = \"Documents\" border=\"0\"></a></td>";

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"ecl_cadre_gestion.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;coles, coll&egrave;ges, lyc&eacute;es\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ecl.png\" ALT = \"ECL\" border=\"0\"></a></td>";

/*
			if ($autorisation_gestion_tickets == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_gestion_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Gestion tickets\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/tickets.png\" ALT = \"Gestion tickets\" border=\"0\"></a></td>";
			}

			if ($autorisation_repertoire == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"repertoire_cadre.php\" target = \"_top\" class=\"bouton\" title=\"R&eacute;pertoires  des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/repertoire.png\" ALT = \"R&eacute;pertoire\" border=\"0\"></a></td>";
			}

			if ($autorisation_contacts == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"contacts_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/contacts.png\" ALT = \"Contacts\" border=\"0\"></a></td>";
			}

			if ($autorisation_contacts_prives == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"contacts_prives_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts priv&eacute;s\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/contacts_prives.png\" ALT = \"Contacts priv&eacute;s\" border=\"0\"></a></td>";
			}

			if ($autorisation_taches == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des t�ches\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/taches.png\" ALT = \"GESTTACHE\" border=\"0\"></a></td>";
			}

			if ($autorisation_favoris == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"favoris_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Favoris\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/favoris.png\" ALT = \"Favoris\" border=\"0\"></a></td>";
			}

			if ($autorisation_suivi_dossiers == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"dossier_index.php\" target = \"_top\" class=\"bouton\" title=\"Dossiers\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dossiers.png\" ALT = \"Dossier\" border=\"0\"></a></td>";
			}

			if ($autorisation_gestion_tickets == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_recherche_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Rechercher un ticket\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/rechercher.png\" ALT = \"Recherche de ticket\" border=\"0\"></a></td>";
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"gestion_categories_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des cat&eacute;gories\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categories.png\" ALT = \"Gestion cat&eacute;gories\" border=\"0\"></a></td>";
			}
*/
			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;&nbsp;<a href = \"deconnexion.php\" target = \"_top\" class=\"bouton\" title=\"D&eacute;connexion\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/sortir.png\" ALT = \"D&eacute;connexion\" border=\"0\"></a></td>";
			echo "<td>&nbsp;</td>";
			echo "<td class = \"format-util-connecte\">$util_connecte<br />$date_aujourdhui</td>";
			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;&nbsp;<a href = \"informations_collaboratice_cadre.php\" target = \"_top\" class=\"bouton\" title=\"$version du $version_date\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"Infos collaboratice\" border=\"0\"></a></td>";
		echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "</body>";
echo "</html>";
?>
