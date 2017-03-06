<?php
	ERROR_REPORTING(0);
	//Fichier pour fixer quelques variables
	//On se connecte à la base 
	//echo "<br />config.php";
	include("../biblio/init.php");

	//On se connecte à la table configuration_systeme pour récupérer les différentes variables
	$req_conf_systeme = "SELECT * FROM configuration_systeme";
	$res_req_conf_systeme = mysql_query($req_conf_systeme);
	$ligne = mysql_fetch_object($res_req_conf_systeme);

	//Variables générales
	$version = $ligne->version;
	$version_date = $ligne->version_date;
/*
	$logo = "logo_tice.png";
	$logo2 = "logo_collaboratice.png";
	$nom_logo = "logo_tice.png";
	$nom_logo2 = "logo_collaboratice.png";
*/
	$logo = $ligne->logo1;
	$logo2 = $ligne->logo2;
	$nom_logo = $ligne->logo1;
	$nom_logo2 = $ligne->logo2;

	//Information sur la structure support
	$intitule_structure_support = $ligne->intitule_structure_support;
	$intitule_service = $ligne->intitule_service;
	$adresse_service_rue = $ligne->adresse_service_rue;
	$adresse_service_cp = $ligne->adresse_service_cp;
	$adresse_service_ville = $ligne->adresse_service_ville;
	$adresse_service_cedex = $ligne->adresse_service_cedex;
	$dan = $ligne->dan;

	$nom_espace_collaboratif = $ligne->nom_espace;
	$description_espace_collaboratif = $ligne->description_espace;
	$image_connexion = $ligne->image_connexion;
	$date_aujourdhui = date('d/m/Y');
	$chemin_images = $ligne->chemin_images;
	$monnaie_utilise = $ligne->monnaie_utilisee;
	$annee_budgetaire_en_cours = $ligne->annee_budgetaire_en_cours;
	$annee_en_cours = $ligne->annee_en_cours;
	$annee_scolaire = $ligne->annee_scolaire;
	$annee_en_cours_FT = $ligne->annee_en_cours_FT;
	$nbr_jours_decallage_pour_rappel = $ligne->nbr_jours_decallage_pour_rappel;

	//Initialisation des dossiers de stockage pour les documents suivant les modules

	$dossier_docs_formation = $ligne->dossier_docs_formation;
	$dossier_docs_gestion_tickets = $ligne->dossier_docs_gestion_tickets;
	$dossier_docs_courriers = $ligne->dossier_docs_courriers;
	$dossier_documents = $ligne->dossier_documents;
	$dossier_webradio_ressources = $ligne->dossier_webradio_ressources;
	$dossier_docs_cardie = $ligne->dossier_docs_cardie;
	$dossier_pour_logos = $ligne->dossier_pour_logos;
	$dossier_lib_adresse_absolu = $ligne->dossier_lib_adresse_absolu;
	$dossier_pieces_frais_deplacement = $ligne->dossier_pieces_frais_deplacement;
	$adresse_collaboratice = $ligne->adresse_collaboratice;

	//Variables pour les pr&eacute;f&eacute;rences du tableau de bord
	$tb_valeur_par_defaut = $ligne->tb_valeur_par_defaut;

	//variables pour fixer des intitul&eacute;s de boutons, messages d'aide, ....
	//script lib/repertoire_consult_fiche.php :
	$bt_salon = $ligne->bt_salon;
	$bt_manifestation = $ligne->bt_manifestation;
	$bt_partenaire = $ligne->bt_partenaire;
	$bt_participant = $ligne->bt_participant;

	//Variables pour module Gestion cr&eacute;dits
	//$annee_budgetaire = "2010";
	$compteur_debut = $ligne->compteur_debut; //pour la liste d&eacute;roulante pour choisir les ann&eacute;es
	$compteur_fin = $compteur_debut + $ligne->compteur_fin;

	//Variables pour module suivi Collaboratice
	$nb_taches_par_page_suivi_collaboratice = $ligne->nb_taches_par_page_suivi_collaboratice;

	//Variables pour module Gestion tickets
	$nb_tickets_par_page_tickets = $ligne->nb_tickets_par_page_tickets;

	//Variables pour module Gestion tâches
	$nb_taches_par_page_taches = $ligne->nb_taches_par_page_taches;

	//Variables pour module Gestion utilisateurs
	$nb_utilisateurs_a_afficher = $ligne->nb_utilisateurs_a_afficher;
	
	//Variables pour module Gestion documents
	$nb_documents_par_page_documents = $ligne->nb_documents_par_page_documents;

	//Variables pour module OM
	$suivi_om_par = $ligne->suivi_om_par;
	$fonction_contact_om = $ligne->fonction_contact_om;
	$tel_service_om = $ligne->tel_service_om;
	$melcontact_om = $ligne->melcontact_om;
	$serveurmel = $ligne->serveurmel; 
	$om_annee_budget = $ligne->om_annee_budget; 

	//Variable pour le module de la CARDIE
	$cardie_dispositif_formation = $ligne->cardie_dispositif_formation;
	$cardie_module_formation = $ligne->cardie_module_formation;
	$cardie_mel_fonctionnelle = $ligne->cardie_mel_fonctionnelle;
	$dafop_mel_fonctionnelle = $ligne->dafop_mel_fonctionnelle;
	
	//Taille icônes
	$largeur_icone_menu = $ligne->largeur_icone_menu;
	$hauteur_icone_menu = $ligne->hauteur_icone_menu;
	$largeur_icone_action = $ligne->largeur_icone_action;
	$hauteur_icone_action = $ligne->hauteur_icone_action;
	$largeur_icone_tri = $ligne->largeur_icone_tri;
	$hauteur_icone_tri = $ligne->hauteur_icone_tri;
	$largeur_icone_favoris = $ligne->largeur_icone_favoris;
	$hauteur_icone_favoris = $ligne->hauteur_icone_favoris;

	//Initialisation des variables pour les couleurs du panneau de connexion
	//==========================================
/*
	$bg_color1 = "#FFFF99";
	$bg_color2 = "#A4EFCA";
	$bg_color3 = "#F8F605"; //pour le tableau de bord pour les enregistrements qui sont ant&eacute;rieur &agrave; la date du jour
	$color_text_titre = "#99CBFF";
	$color_text = "#330000";
	$color_text_version = "#808080";
	//==========================================
*/
	//Initialisation des variables pour les couleurs des tableaux pour la saisie de donn&eacute;es
	//==========================================
	$fd_cel_etiq="#7FFFD4";
	$fd_cel_donnee="#FFFFFF";
	$fd_tab="#48D1CC";

	//Initialisation des message de non connexion
	$message_non_connecte1 = "Vous n'&ecirc;tes pas connect&eacute;-e";
	$message_non_connecte2 = "Retour &agrave; la mire de connexion";


///Ancienne version
/*
//Variables générales
$version = "V1.99.88";
$version_date = "8.07.2012";
$logo = "logo_tice.png";
$logo2 = "logo_collaboratice.png";
$nom_espace_collaboratif = "CollaboraTICE";
$description_espace_collaboratif = "Espace collaboratif de la Mission acad&eacute;mique TICE";
$nom_logo = "logo_tice.png";
$nom_logo2 = "logo_collaboratice.png";
$image_connexion = "connexion.png";
//$date_aujourdhui = date('d/m/Y');
$chemin_images = __DIR__ . "/image/";
$monnaie_utilise = "�";
$annee_budgetaire_en_cours = "2012";
$annee_en_cours = "2013";
$annee_scolaire = "2012-2013";
$annee_en_cours_FT = "2011";
$nbr_jours_decallage_pour_rappel = 7;

//Initialisation des variables pour les couleurs du panneau de connexion
//==========================================
$bg_color1 = "#FFFF99";
$bg_color2 = "#A4EFCA";
$bg_color3 = "#F8F605"; //pour le tableau de bord pour les enregistrements qui sont ant&eacute;rieur &agrave; la date du jour
$color_text_titre = "#99CBFF";
$color_text = "#330000";
$color_text_version = "#808080";
//==========================================

//Initialisation des variables pour les couleurs des tableaux pour la saisie de donn&eacute;es
//==========================================
$fd_cel_etiq="#7FFFD4";
$fd_cel_donnee="#FFFFFF";
$fd_tab="#48D1CC";

//Initialisation des message de non connexion
$message_non_connecte1 = "Vous n'&ecirc;tes pas connect&eacute;-e";
$message_non_connecte2 = "Retour &agrave; la mire de connexion";

//Initialisation des dossiers de stockage pour les documents suivant les modules
$dossier_docs_formation = "../data/for/";
$dossier_docs_gestion_tickets = "../data/gt/";
$dossier_docs_courriers = "../data/courriers/";
$dossier_documents = "../data/docs/";
$dossier_webradio_ressources = "../data/webradio/";
$dossier_pour_logos = "../image/logos/";
$dossier_lib_adresse_absolu = "http://mission.tice.ac-orleans-tours.fr/collaboratice/lib/";
$adresse_collaboratice = "mission.tice.ac-orleans-tours.fr/collaboratice/";

//Variables pour les pr&eacute;f&eacute;rences du tableau de bord
$tb_valeur_par_defaut = 7;

//variables pour fixer des intitul&eacute;s de boutons, messages d'aide, ....
//script lib/repertoire_consult_fiche.php :
$bt_salon = "le salon";
$bt_manifestation = "le CG, FGMM, FT";
$bt_partenaire = "Partenaire du Concours GANTASE, du Festival des G&eacute;nies du Multim&eacute;dia, du Festival TICE";
$bt_participant = "Participant aux salons (Rencontres TICE 2008, FGMM, FT)";

//Variables pour module Gestion cr&eacute;dits
//$annee_budgetaire = "2010";
$compteur_debut = "2003"; //pour la liste d&eacute;roulante pour choisir les ann&eacute;es
$compteur_fin = $compteur_debut + 12;

//Variables pour module suivi Collaboratice
$nb_taches_par_page_suivi_collaboratice = 10;

//Variables pour module Gestion t�ches
$nb_taches_par_page_taches = 10;

//Variables pour module Gestion tickets
$nb_tickets_par_page_tickets = 12;

//Taille ic�nes
$largeur_icone_menu = "48px";
$hauteur_icone_menu = "48px";
$largeur_icone_action = "32px";
$hauteur_icone_action = "32px";
$largeur_icone_tri = "18px";
$hauteur_icone_tri = "18px";
$largeur_icone_favoris = "24px";
$hauteur_icone_favoris = "24px";
//Variables pour module Gestion t�ches
$nb_taches_par_page_taches = 10;

*/
mysql_free_result ($res_req_conf_systeme);
?>
