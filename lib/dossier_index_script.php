<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		include ("../biblio/init_dossier.php");
		// include ("dossier_mysql.php");
		include ("dossier_collection.php");
		include ("dossier_passerelle.php");
		include ("dossier_fonction_affichage.php");
		
	?>
</head>
<body>

	<center>
		<br/>
		<br/>
	
<?php

	// $co = new Mysql ($host, $user, $pass, $base);
	// $co->connect($base);
	// On crée un nouvel objet de la classe Passerelle.
	$passerelle = new Passerelle ($co);
	
	$choix = $_POST['choix'];
	$choix2 = $_POST['choix2'];
	$id = $_POST['id'];
	
	//echo $choix.' '.$choix2.' '.$id;
	
	switch ($choix)
	{
		case "dossier" : 	
			$collectDossier = new Collection ();
				switch ($choix2)
				{
					case "document" :		$collectDossier = $passerelle->documentChargerDossier($id); 
											afficherDossier($collectDossier);
											break;
					case "utilisateur" : 	$collectDossier = $passerelle->utilisateurChargerDossier($id); 
											afficherDossier($collectDossier);
											break;
					case "etablissement" : 	$collectDossier = $passerelle->etablissementChargerDossier($id);
											afficherDossier($collectDossier);
											break;								
					case "evenement" : 		$collectDossier = $passerelle->evenementChargerDossier($id);
											afficherDossier($collectDossier);
											break;													
					case "societe" : 		$collectDossier = $passerelle->societeChargerDossier($id);
											afficherDossier($collectDossier);
											break;
				} 
				break;
				
		case "document" :
			$collectDocument = new Collection ();
				switch ($choix2)
				{
					case "dossier" :		$collectDocument = $passerelle->dossierChargerDocument($id);
											afficherDocument($collectDocument);
											break;
					case "utilisateur" :	$collectDocument = $passerelle->utilisateurChargerDocument($id);
											afficherDocument($collectDocument);
											break;								
					case "etablissement" :	$collectDocument = $passerelle->etablissementChargerDocument($id);
											afficherDocument($collectDocument);
											break;
					case "evenement" :		$collectDocument = $passerelle->evenementChargerDocument($id);
											afficherDocument($collectDocument);
											break;
					case "societe" :		$collectDocument = $passerelle->societeChargerDocument($id);
											afficherDocument($collectDocument);
											break;
				}
				break;

		case "utilisateur" :
			$collectUtil = new Collection ();													
				switch ($choix2)
				{
					case "dossier" :	$collectUtil = $passerelle->dossierChargerUtilisateur ($id);
										afficherUtilisateur($collectUtil);
										break;
					case "document" :	$collectUtil = $passerelle->documentChargerUtilisateur ($id);
										afficherUtilisateur($collectUtil);
										break;
					case "evenement" :	$collectUtil = $passerelle->evenementChargerUtilisateur ($id);
										afficherUtilisateur($collectUtil);
										break;
				}
				break;

		case "etablissement" :
			$collectEtab = new Collection ();													
				switch ($choix2)
				{
					case "dossier" :	$collectEtab = $passerelle->dossierChargerEtablissement ($id);
										afficherEtablissement($collectEtab);
										break;
					case "document" :	$collectEtab = $passerelle->documentChargerEtablissement ($id);
										afficherEtablissement($collectEtab);
										break;
				}
				break;
				
		case "evenement" :
			$collectEven = new Collection ();													
				switch ($choix2)
				{
					case "dossier" :	$collectEven = $passerelle->dossierChargerEvenement ($id);
										afficherEvenement($collectEven);
										break;
					case "document" :	$collectEven = $passerelle->documentChargerEvenement ($id);
										afficherEvenement($collectEven);
										break;
					case "utilisateur":	$collectEven = $passerelle->utilisateurChargerEvenement ($id);
										afficherEvenement($collectEven);
										break;								
				}
				break;
				
		case "societe" :
			$collectSociete = new Collection ();													
				switch ($choix2)
				{
					case "dossier" :	$collectSociete = $passerelle->dossierChargerSociete ($id);
										afficherSociete($collectSociete);
										break;
					case "document" :	$collectSociete = $passerelle->documentChargerSociete ($id);
										afficherSociete($collectSociete);
										break;
				}
				break;
	}
	
?>	

		<br/>
		<br/>
		<a href="dossier_index.php" title="Retour au module de gestion de dossier" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
	</center>
	
</body>
</html>	
	
