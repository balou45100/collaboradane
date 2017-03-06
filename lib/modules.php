<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<?php
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");

	$util = $_SESSION['id_util'];
	$identifiant = $_SESSION['identifiant'];
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	$theme = $_SESSION['chemin_theme']."collaboratice_barre_modules.css";

	//echo "<br />theme : $theme";

	//On vérifie les droits de l'utilisateur connecté
	$autorisation_genies = verif_appartenance_groupe(2);
	$autorisation_formation = verif_appartenance_groupe(5);
	$autorisation_salon = verif_appartenance_groupe(7);
	$autorisation_gestion_materiels = verif_appartenance_groupe(8);
	$autorisation_personnes_ressource = verif_appartenance_groupe(9);
	$autorisation_gestion_credits = verif_appartenance_groupe(11);
	$autorisation_courrier = verif_appartenance_groupe(15);
	$autorisation_gestion_groupes = verif_appartenance_groupe(13);
	$droit_administrateur = verif_appartenance_groupe(14);
	$autorisation_gestion_om = verif_appartenance_groupe(16);
	$autorisation_gestion_abos = verif_appartenance_groupe(17);
	$autorisation_gestion_tickets = verif_appartenance_groupe(18);
	$autorisation_statistiques = verif_appartenance_groupe(19);
	$autorisation_repertoire = verif_appartenance_groupe(20);
	$autorisation_contacts = verif_appartenance_groupe(21);
	$autorisation_taches = verif_appartenance_groupe(22);
	$autorisation_favoris = verif_appartenance_groupe(23);
	$autorisation_suivi_collaboratice = verif_appartenance_groupe(24);
	$autorisation_suivi_dossiers = verif_appartenance_groupe(25);
	$autorisation_contacts_prives = verif_appartenance_groupe(26);
	$autorisation_ecl = verif_appartenance_groupe(27);
	$autorisation_membres = verif_appartenance_groupe(28);
	$autorisation_webradio = verif_appartenance_groupe(29);
	$autorisation_config_systeme = verif_appartenance_groupe(30);
	$autorisation_cardie = verif_appartenance_groupe(31);
	$autorisation_evenements = verif_appartenance_groupe(33);
	$autorisation_documents = verif_appartenance_groupe(34);

	//réglages des tailles des cellule suivant que c'est un utilisateur ou l'administrateur qui se connecte
	if($_SESSION['droit'] == "Super Administrateur")
	{
		$cellule1="6%"; //marge gauche
		$cellule2="52%"; //pour l'affichage des icônes des modules principales
		$cellule3="30%"; //pour les icônes des fonctionnalit&eacute;s commune et de gestion
		$cellule4="6%";  //pour le bouton e d&eacute;connexion
		$cellule5="6%"; //pour le copyright
	}
	else
	{
		$cellule1="6%"; //marge gauche
		$cellule2="58%"; //pour l'affichage des icônes des modules principales
		$cellule3="25%"; //pour les icônes des fonctionnalit&eacute;s commune et de gestion
		$cellule4="6%";  //pour le bouton de d&eacute;connexion
		$cellule5="5%"; //pour le copyright
	}

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"600 url=modules.php\">
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
	</head>
	<body class = \"menu-boutons\">
	<div>";
	if($_SESSION['droit'] == "Super Administrateur")
	{
		//echo "<table class=\"MenuModules\">";
		echo "<table>";
	}
	else
	{
		//echo "<table align=\"center\" BORDER = \"0\" BGCOLOR =\"#FFFF99\" class=\"MenuModules\">";
		//echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" BGCOLOR =\"#FFFF99\" class=\"MenuModules\">";
		echo "<table class = \"MenuModules\">";
		//echo "<table>";
	}
	$util_connecte = $_SESSION['nom'];
	//$util_connecte = $_SESSION['identifiant'];
		echo "<tr>";
			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"accueil_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Accueil\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/accueil.png\" ALT = \"Tableau de bord\" border=\"0\"></a></td>";

			if ($autorisation_ecl == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"ecl_cadre_gestion.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;coles, coll&egrave;ges, lyc&eacute;es\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ecl.png\" ALT = \"ECL\" border=\"0\"></a></td>";
			}

			if ($autorisation_gestion_tickets == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_gestion_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Gestion tickets\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/tickets.png\" ALT = \"Gestion tickets\" border=\"0\"></a></td>";
			}

			if ($autorisation_personnes_ressource == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"personnes_ressources_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Personnes ressources DANE\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Personnes ressources\" border=\"0\"></a></td>";
			}

			if ($autorisation_formation == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"formations_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Formations\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/formations.png\" ALT = \"Formations\" border=\"0\"></a></td>";
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
			echo "<!--td><img src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td-->";

			if ($autorisation_gestion_materiels == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"materiels_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion mat&eacute;riels\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></a></td>";
			}
			if ($autorisation_gestion_abos == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"abo_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion abonnements\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/abonnements.png\" ALT = \"GESTABOS\" border=\"0\"></a></td>";
			}

			if ($autorisation_taches == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des t&acirc;ches\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/taches.png\" ALT = \"GESTTACHE\" border=\"0\"></a></td>";
			}

			if ($autorisation_favoris == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"favoris_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Favoris\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/favoris.png\" ALT = \"Favoris\" border=\"0\"></a></td>";
			}

			if ($autorisation_courrier == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"gc_cadre_gestion_courrier.php\" target = \"_top\" class=\"bouton\" title=\"Gestion courrier\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/courrier.png\" ALT = \"GC\" border=\"0\"></a></td>";
			}
/*
			if ($autorisation_gestion_om == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"om_cadre.php\" target = \"_top\" class=\"bouton\" title=\"OM\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/om.png\" ALT = \"OM\" border=\"0\"></a></td>";
			}
*/
			if ($autorisation_evenements == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"evenements_cadre.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;v&eacute;nements\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/evenement.png\" ALT = \"&Eacute;v&eacute;nements\" border=\"0\"></a></td>";
			}

			if ($autorisation_documents == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"documents_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Documents\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/documents.png\" ALT = \"Documents\" border=\"0\"></a></td>";
			}

			if ($autorisation_suivi_dossiers == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"dossier_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Dossiers\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dossiers.png\" ALT = \"Dossier\" border=\"0\"></a></td>";
			}

			if ($autorisation_webradio == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"WR_accueil.php\" target = \"_top\" class=\"bouton\" title=\"Webradio\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/webradio.png\" ALT = \"WR\" border=\"0\"></a></td>";
			}

			if ($autorisation_gestion_credits == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"credits_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Cr&eacute;dits\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/credits.png\" ALT = \"Gestion cr&eacute;dits\" border=\"0\"></a></td>";
			}

			if ($autorisation_suivi_collaboratice == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"dev_taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Suivi CollaboraDANE\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/dev_taches.png\" ALT = \"SUIVIColDANE\" border=\"0\"></a></td>";
			}

			if ($autorisation_gestion_tickets == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_recherche_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Rechercher un ticket\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/rechercher.png\" ALT = \"Recherche de ticket\" border=\"0\"></a></td>";
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"gestion_categories_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des cat&eacute;gories\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categories.png\" ALT = \"Gestion cat&eacute;gories\" border=\"0\"></a></td>";
			}

			if ($autorisation_cardie == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cardie_cadre_projets.php\" target = \"_top\" class=\"bouton\" title=\"Cardie\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie.png\" ALT = \"Cardie\" border=\"0\"></a></td>";
			}

			if ($autorisation_statistiques == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_statistiques.php\" target = \"_top\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></a></td>";
			}

			echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_reglages.php\" target = \"_top\" class=\"bouton\" title=\"Informations personnelles\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Infos persos\" border=\"0\"></a></td>";

			if ($autorisation_membres == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"gestion_users_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></a></td>";
			}

			if ($autorisation_gestion_groupes == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"gg_cadre_gestion_groupes_droits.php\" target = \"_top\" class=\"bouton\" title=\"droits\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/droits.png\" ALT = \"Gestion droits\" border=\"0\"></a></td>";
			}

			if ($autorisation_config_systeme == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"configuration_systeme_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Configuration du syst&egrave;me\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_1
				.png\" ALT = \"ConfSysteme\" border=\"0\"></a></td>";
			}

			if ($autorisation_genies == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"fgmm_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Festival des G&eacute;nies du Multim&eacute;dia\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/genie.png\" ALT = \"FT\" border=\"0\"></a></td>";
			}

			if ($autorisation_salon == "1")
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"salon_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Rencontres TICE 2008\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/salon.png\" ALT = \"salon\" border=\"0\"></a></td>";
			}

			if($droit_administrateur == 1)
			{
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;<a href = \"cadre_verif_coherence_base.php\" target = \"_top\" class=\"bouton\" title=\"V&eacute;rification de la base de donn&eacute;es\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Coh&eacute;rence BDD\" border=\"0\"></a></td>";
			}
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;&nbsp;<a href = \"deconnexion.php\" target = \"_top\" class=\"bouton\" title=\"D&eacute;connexion\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/sortir.png\" ALT = \"D&eacute;connexion\" border=\"0\"></a></td>";
				//echo "<td nowrap>$nom_espace_collaboratif<br />$version<br />$version_date</td>";
				echo "<td>&nbsp;</td>";
				echo "<td class = \"format-util-connecte\">$util_connecte<br />$date_aujourdhui</td>";
				echo "<td align=\"center\" valign=\"top\" nowrap>&nbsp;&nbsp;<a href = \"informations_collaboratice_cadre.php\" target = \"_top\" class=\"bouton\" title=\"$version du $version_date\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"Infos collaboraDANE\" border=\"0\"></a></td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
	echo "</body>";
echo "</html>";
?>
