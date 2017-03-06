<?php
	ERROR_REPORTING(0);
	//Fichier pour fixer quelques variables
	//On se connecte à la base 
	//echo "<br />cardie_config.php";
	include("../biblio/init.php");

	//On se connecte à la table configuration_systeme pour récupérer les différentes variables
	$req_cardie_configuration = "SELECT * FROM cardie_configuration";
	$res_req_cardie_configuration = mysql_query($req_cardie_configuration);
	$ligne = mysql_fetch_object($res_req_cardie_configuration);

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

	$nom_espace_collaboratif = $ligne->nom_espace;
	$description_espace_collaboratif = $ligne->description_espace;
	$image_connexion = $ligne->image_connexion;
	//$date_aujourdhui = date('d/m/Y');
	$chemin_images = $ligne->chemin_images;
	$monnaie_utilise = $ligne->monnaie_utilisee;
	$annee_budgetaire_en_cours = $ligne->annee_budgetaire_en_cours;
	$annee_en_cours = $ligne->annee_en_cours;
	$annee_scolaire = $ligne->annee_scolaire;
	$nbr_jours_decallage_pour_rappel = $ligne->nbr_jours_decallage_pour_rappel;

	//Initialisation des dossiers de stockage pour les documents suivant les modules

	$dossier_documents = $ligne->dossier_documents;
	$dossier_pour_logos = $ligne->dossier_pour_logos;
	$dossier_lib_adresse_absolu = $ligne->dossier_lib_adresse_absolu;
	$adresse_collaboratice = $ligne->adresse_collaboratice;

	//Variables pour les pr&eacute;f&eacute;rences du tableau de bord
	$tb_valeur_par_defaut = $ligne->tb_valeur_par_defaut;

	//Variable pour le module de la CARDIE
	$cardie_dispositif_formation = $ligne->cardie_dispositif_formation;
	$cardie_module_formation = $ligne->cardie_module_formation;
	$cardie_mel_fonctionnelle = $ligne->cardie_mel_fonctionnelle;
	$dafop_mel_fonctionnelle = $ligne->dafop_mel_fonctionnelle;
	$dossier_docs_cardie = $ligne->dossier_docs_cardie;
	$url_experitheque = $ligne->url_experitheque;
	
	//Taille icônes
	$largeur_icone_menu = $ligne->largeur_icone_menu;
	$hauteur_icone_menu = $ligne->hauteur_icone_menu;
	$largeur_icone_action = $ligne->largeur_icone_action;
	$hauteur_icone_action = $ligne->hauteur_icone_action;
	$largeur_icone_tri = $ligne->largeur_icone_tri;
	$hauteur_icone_tri = $ligne->hauteur_icone_tri;
	$largeur_icone_favoris = $ligne->largeur_icone_favoris;
	$hauteur_icone_favoris = $ligne->hauteur_icone_favoris;

	//Initialisation des message de non connexion
	$message_non_connecte1 = "Vous n'&ecirc;tes pas connect&eacute;-e";
	$message_non_connecte2 = "Retour &agrave; la mire de connexion";

mysql_free_result ($res_req_cardie_configuration);
?>
