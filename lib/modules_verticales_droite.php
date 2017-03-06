<?php
	//Lancement de la session
	session_start();
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");

	$util = $_SESSION['id_util'];
	
	//$autorisation_genies = $_SESSION['autorisation_genies'];
	$autorisation_genies = verif_appartenance_groupe(2);
	
	//echo "<br />modules.php - id_util : $util - autorisation_genies : $autorisation_genies";
	
	$autorisation_salon = verif_appartenance_groupe(7);
	$autorisation_gestion_materiels = verif_appartenance_groupe(8);
	$autorisation_gestion_credits = verif_appartenance_groupe(11);
	//réglages des tailles des cellule suivant que c'est un utilisateur ou l'administrateur qui se connecte
	if($_SESSION['droit'] == "Super Administrateur")
	{
		$cellule1="6%"; //marge gauche
		$cellule2="52%"; //pour l'affichage des icônes des modules principales
		$cellule3="30%"; //pour les icônes des fonctionnalités commune et de gestion
		$cellule4="6%";  //pour le bouton e déconnexion
		$cellule5="6%"; //pour le copyright 
	}
	else
	{
		$cellule1="6%"; //marge gauche
		$cellule2="58%"; //pour l'affichage des icônes des modules principales
		$cellule3="25%"; //pour les icônes des fonctionnalités commune et de gestion
		$cellule4="6%";  //pour le bouton de déconnexion
		$cellule5="5%"; //pour le copyright
	}
	
?>
<!DOCTYPE HTML>
<html>
	<head>
  		<title>CollaboraTICE2</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<!--meta HTTP-EQUIV="Refresh" CONTENT="600 url=modules.php"-->
		<LINK HREF="../biblio/entete_et_menu.css" REL="stylesheet" TYPE="text/css">
	</head>
	<BODY class = "fond_entete">
    
<?php
	if($_SESSION['droit'] == "Super Administrateur")
	{
		echo "<TABLE align=\"center\" BORDER = \"0\" BGCOLOR =\"#FF0000\" class=\"MenuModules\">";
	}
	else
	{
		//echo "<TABLE align=\"center\" BORDER = \"0\" BGCOLOR =\"#FFFF99\" class=\"MenuModules\">";
		//echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" BGCOLOR =\"#FFFF99\" class=\"MenuModules\">";
		echo "<table class=\"MenuModules\">";
	}
	$util_connecte = $_SESSION['nom'];
		echo "<TR>
			<!--td align = \"left\"><small>$util_connecte<br>$date_aujourdhui</small></td-->
			<td class=\"IconesAvecTexte\" align=\"center\" valign=\"top\" nowrap>
				<A HREF = \"accueil_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Accueil\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/accueil.png\" ALT = \"Tableau de bord\" border=\"0\"></A><small><br />Accueil</small>
				<!--br /><A HREF = \"cadre_gestion_ecl.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;coles, coll&egrave;ges, lyc&eacute;es\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"ECL\" border=\"0\"></A><small><br />R&eacute;p. ECL</small>
				<br /><A HREF = \"cadre_gestion_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Gestion tickets\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket.png\" ALT = \"Gestion tickets\" border=\"0\"></A><small><br />Tickets</small>
				<br /><A HREF = \"personnes_ressources_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Personnes ressources TICE\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Personnes ressources\" border=\"0\"></A><small><br />Pers. ress.</small>
				<br /><A HREF = \"formations_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Formations\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Formations\" border=\"0\"></A><small><br />Formations
				<br /><A HREF = \"repertoire_cadre.php\" target = \"_top\" class=\"bouton\" title=\"R&eacute;pertoires  des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/repertoire.png\" ALT = \"R&eacute;pertoire\" border=\"0\"></A><small><br />Rép. soci&eacute;t&eacute;</small>
				<br /><A HREF = \"contacts_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts.png\" ALT = \"Contacts\" border=\"0\"></A><small><br />Contacts</small-->
				<br /><A HREF = \"contacts_prives_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts privés\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts_prives.png\" ALT = \"Contacts privés\" border=\"0\"></A><small><br />C. priv&eacute;s</small-->";

				echo "<br /><A HREF = \"materiels_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion matériels\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></A><small><br />Mat&eacute;riels</small>";
				echo "<br /><A HREF = \"taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des tâches\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/taches.png\" ALT = \"GESTTACHE\" border=\"0\"></A><small><br />T&acirc;ches</small>";
				echo "<br /><A HREF = \"favoris_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Favoris\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris.png\" ALT = \"Favoris\" border=\"0\"></A><small><br />Favoris</small>";

/*
			if ($autorisation_genies == "1")
			{
				echo "<br /><A HREF = \"fgmm_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Festival des Génies du Multimédia\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie.png\" ALT = \"FT\" border=\"0\"></A><small><br />Festival</small>";
			}
			if ($autorisation_salon == "1")
			{
				echo "<br /><A HREF = \"salon_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Rencontres TICE 2008\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/salon.png\" ALT = \"salon\" border=\"0\"></A><small><br />Rencontres</small>";
			}

			if ($autorisation_gestion_credits == 1)
			{
				echo "<br /><A HREF = \"credits_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Cr&eacute;dits\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/credits.png\" ALT = \"Gestion cr&eacute;dits\" border=\"0\"></A><small><br />Cr&eacute;dits</small>";
				//echo "<td class=\"IconesAvecTexte\" align=\"center\" valign=\"top\" nowrap><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
			}
*/

				echo "<br /><A HREF = \"dev_taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Suivi Collaboratice\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dev_taches.png\" ALT = \"SUIVIColTICE\" border=\"0\"></A><small><br />Suivi c.tice</small>";
				echo "<br /><A HREF = \"dossier_index.php\" target = \"_top\" class=\"bouton\" title=\"Dossiers\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierRempli.png\" ALT = \"Dossier\" border=\"0\"></A><small><br />Dossier</small>";
				echo "<br /><A HREF = \"cadre_recherche_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Rechercher un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Recherche de ticket\" border=\"0\"></A><small><br />Recherche</small>";
/*
				echo "<br /><A HREF = \"cadre_gestion_categories.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des catégories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Gestion catégories\" border=\"0\"></A><small><br />Cat&eacute;gories</small>";
				echo "<br /><A HREF = \"cadre_statistiques.php\" target = \"_top\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A><small><br />Stats</small>";
				echo "<br /><A HREF = \"cadre_reglages.php\" target = \"_top\" class=\"bouton\" title=\"Informations personnelles\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Infos persos\" border=\"0\"></A><small><br />R&eacute;glages</small>";
				echo "<br /><A HREF = \"cadre_gestion_users.php\" target = \"_top\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></A><small><br />Membres</small>";
*/
				//Affichage des liens supplémentaires pour le Super administrateur
			if($_SESSION['droit'] == "Super Administrateur")
			{
				echo "<br /><A HREF = \"cadre_verif_coherence_base.php\" target = \"_top\" class=\"bouton\" title=\"Vérification de la base de données\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Cohérence BDD\" border=\"0\"></A><small><br />V&eacute;rif BDD</small>";
			}
				//echo "<br /><A HREF = \"deconnexion.php\" target = \"_top\" class=\"bouton\" title=\"Déconnexion\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/sortir.png\" ALT = \"Déconnexion\" border=\"0\"></A><small><br />Quitter</small>";
				echo "<br /><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur5.png\" border=\"0\">";
				echo "<br /><small>$util_connecte<br>$date_aujourdhui</small>";
				echo "<br /><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur5.png\" border=\"0\">";
				echo "<br /><small><small>$nom_espace_collaboratif<br />$version<br />$version_date</small></small>
			</td>
		</TR>
	</TABLE>
</body>
</html>";
?>
