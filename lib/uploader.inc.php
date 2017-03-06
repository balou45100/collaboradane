<?php
  //Mise en place de la durée de la session
	session_start();
	$origine = $_SESSION['origine'];

	include ("../biblio/fct.php");
	// Récupération des variables
	include ("../biblio/config.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	$DESTINATION_FOLDER = $_POST["folder"];	
	$script = $_POST['script']; //pour savoir où il faut retourner
	$ticket = $_POST['ticket']; //N° du ticket à enregistrer
	//$nom_doc = $_POST['nom_doc']; //Titre du document
	$nom_doc = $_POST['RessourceIntitule']; //Titre du document
	$module = $_POST['module']; //Module dans lequel le ticket est inséré
	//$file = $_POST['file']; //Fichier joint
	$description_doc = $_POST['RessourceDescription']; //Description du documents joints

	switch($script)
	{
		case 'consult_ticket' :
			$idpb = $_POST['idpb'];
		break;

		case 'ecl_consult_fiche' :
			$id_societe = $_POST['id_societe'];
		break;

		case 'formations_gestion' :
			$id_societe = $_POST['id_societe'];
		break;

		case 'gc_recherche' :
			$id_societe = $_POST['id_courrier'];
		break;

		case 'cardie_visites' :
			$id_societe = $_POST['id_visite'];
		break;

		case 'evenements_accueil' :
			$id_societe = $_POST['id_evenement'];
		break;
	} //fin switch $script

	/*
	echo "<CENTER><h2>uploader :</h2>"; 
	//echo "<br />id_visite : ".$id_visite."";
	echo "<br />id_evenement : ".$id_evenement."";
	//echo "<br />id_courrier : ".$id_courrier."";
	echo "<br />id_societe : ".$idsociete."";
	//echo "<br />idpb : ".$idpb."";
	echo "<br />ticket : ".$ticket."";
	echo "<br>dossier : $DESTINATION_FOLDER";
	echo "<br>nom_fichier_original : $file";
	echo "<br>module : $module";
	echo "<br>nom_doc : $nom_doc";
	echo "<br>description_doc : $description_doc";
	echo "<br>script : $script";
	*/
	
	$fichier_a_placer = creation_nom_doc_a_enregistrer($ticket,$nom_doc,$module,$id_societe);

	//echo "<br>nom_fichier_a_enregistrer : $fichier_a_placer";
	
	//echo "<br><br></CENTER>";

	//$idpb = $idpb+1;
  
	// Taille maximale de fichier, valeur en bytes					//
	$MAX_SIZE = 100000000;											//

	// Récupération de l'url de retour								//
	$RETURN_LINK = $_SERVER['HTTP_REFERER'];						//

	// Définition des extensions de fichier autorisées (avec le ".")//
	$AUTH_EXT = array(".doc", ".DOC", ".docx", ".DOCX", ".pdf", ".PDF", ".jpg", ".JPG",
		".png", ".PNG", ".eps", ".EPS", ".ppt", ".PPT", ".xls", ".XLS", ".mm", ".MM",
		".gif", ".GIF", ".odt", ".ODT", ".ods", ".ODS", ".odg", ".ODG",
		".psd", ".PSD", ".txt", ".TXT", ".gz", ".GZ", ".tar", ".TAR",  ".zip",  ".ZIP",
		".rtf", ".RTF");//
	// ############################################################ //

	// Fonction permettant de créer un lien de retour automatique

	function createReturnLink()
	{
		global $RETURN_LINK;
		echo "<a href='".$RETURN_LINK."'>Retour</a><br>";
	}

	// Fonction permettant de vérifier si l'extension du fichier est
	// autorisée.

	function isExtAuthorized($ext)
	{
		global $AUTH_EXT;
		if(in_array($ext, $AUTH_EXT)){
			return true;
		}
		else
		{
			return false;
		}
	}

	// On vérifie que le champs contenant le chemin du fichier soit
	// bien rempli.

	if(!empty($_FILES["file"]["name"]))
	{
		// Nom du fichier choisi:
		$nomFichier = $_FILES["file"]["name"] ;
		
		//echo "<br />nomFichier : $nomFichier";
		
		// Nom temporaire sur le serveur:
		$nomTemporaire = $_FILES["file"]["tmp_name"] ;
		// Type du fichier choisi:
		$typeFichier = $_FILES["file"]["type"] ;
		// Poids en octets du fichier choisit:
		$poidsFichier = $_FILES["file"]["size"] ;
		// Code de l'erreur si jamais il y en a une:
		$codeErreur = $_FILES["file"]["error"] ;
		// Extension du fichier
		$extension = strrchr($nomFichier, ".");

		//echo "<br />extension : $extension";

		if(file_exists($DESTINATION_FOLDER.$fichier_a_placer.$extension))
		{
			//echo "<CENTER>eh oui, $fichier_a_placer existe...</CENTER><br>";
			$fichier_a_placer = renomme_fichier_a_placer($fichier_a_placer,$extension,$DESTINATION_FOLDER);
			$suite = "O"; //on procède avec le reste des tests pour le dépôt
			
			//echo "<br>de retour du renommage : fichier renommé : $fichier_a_placer<br>";
			
			//unlink($DESTINATION_FOLDER.$nom_fichier.$extension);
		}
		else
		{
			//echo "<CENTER>eh non, il n'existe pas...<br></CENTER><br>";
			$suite = "O"; //on procède avec le reste des tests pour le dépôt
		}
		if ($suite == "O")
		{
			//echo "<br />suite : $suite";
			
			if($poidsFichier <> 0)
			{
				// Si la taille du fichier est supérieure à la taille
				// maximum spécifiée => message d'erreur
				if($poidsFichier < $MAX_SIZE)
				{
					//echo "<br />poidsFichier : $poidsFichier";
					
					// On teste ensuite si le fichier a une extension autorisée
					if(isExtAuthorized($extension))
					{
						//echo "<br />extension autorisée";
						
						// Ensuite, on copie le fichier uploadé ou bon nous semble.
						/*
						echo "<br />nomTemporaire : $nomTemporaire";
						echo "<br />DESTINATION_FOLDER : $DESTINATION_FOLDER";
						echo "<br />fichier_a_placer : $fichier_a_placer";
						echo "<br />extension : $extension";
						*/
						$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$fichier_a_placer.$extension);
						if($uploadOk)
						{
							echo("<h2 align = \"center\">Le fichier a bien &eacute;t&eacute; d&eacute;pos&eacute; sur le serveur !</h2>");
							/*
							echo "<br />juste avant l'inscription dans la base";
							echo "<br>ticket : $ticket";
							echo "<br>nom_doc : $nom_doc";
							echo "<br>nom_fichier : $nom_fichier";
							echo "<br>module : $module";
							echo "<br>description : $description_doc";
							*/
							$fichier_a_placer = $fichier_a_placer.$extension; 
							
							//echo "<br />fichier_a_placer : $fichier_a_placer";
							
							//Il faut renseigner la table documents
							include("../biblio/init.php");
							$query_insert = "INSERT INTO documents (id_ticket, id_util_deposant, nom_doc, nom_fichier, module, description_doc)
								VALUES ('".$ticket."', '".$_SESSION['id_util']."', '".$nom_doc."', '".$fichier_a_placer."', '".$module."', '".$description_doc."');";
							//exit;
							
							//echo "<br />query_insert : $query_insert";
							
							$results_insert = mysql_query($query_insert);
							if(!$results_insert)
							{
								echo "<br /><B>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</B>";
								echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour à la gestion des tickets</A>";
								mysql_close();
								exit;
							}
							//echo(createReturnLink());
							//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						}
						else
						{
							echo("<h2 align = \"center\">Le fichier n'a pas pu &ecirc;tre d&eacute;pos&eacute; sur le serveur !<br /></h2>");
							//echo(createReturnLink());
							//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						}
					}
					else
					{
						echo ("<h2 align = \"center\">Les fichiers avec l'extension $extension ne peuvent pas &ecirc;tre d&eacute;pos&eacute;s !</h2>");
						//echo (createReturnLink()."<br>");
						//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					}
				}
				else
				{
					$tailleKo = $MAX_SIZE / 1000;
					echo("<h2 align = \"center\">Vous ne pouvez pas d&eacute;poser de fichiers dont la taille est sup&eacute;rieure à : $tailleKo Ko.</h2>");
					//echo (createReturnLink()."<br>");
					//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				}
			}
			else
			{
				echo("<h2 align = \"center\">Le fichier choisi est invalide !</h2>");
				//echo (createReturnLink()."<br>");
			}
		} 
		// Si le poids du fichier est de 0 bytes, le fichier est
		// invalide (ou le chemin incorrect) => message d'erreur
		// sinon, le script continue.
	}
	else
	{
		echo("<h2 align = \"center\">Vous n'avez pas choisi de fichier !</h2>");
		//echo (createReturnLink()."<br>");
	}
	switch($script)
	{
		case 'consult_ticket' :
			echo "<CENTER><A HREF = \"$script.php?idpb=$idpb&amp;chgt=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;

		case 'ecl_consult_fiche' :
			echo "<CENTER><A HREF = \"$script.php?id_societe=$id_societe&amp;chgt=N&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;

		case 'formations_gestion' :
			echo "<CENTER><A HREF = \"$script.php?id_societe=$id_societe&amp;chgt=N&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;

		case 'gc_recherche' :
			echo "<CENTER><A HREF = \"$script.php?id_societe=$id_societe&amp;chgt=N&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;

		case 'cardie_visites' :
			echo "<CENTER><A HREF = \"$script.php?id_visite=$id_societe&amp;chgt=N&amp;action=affichage\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;

		case 'evenements_accueil' :
			echo "<CENTER><A HREF = \"$script.php?tri=date_evenement_debut asc, heure_debut_evenement&amp;sense_tri=ASC&amp;visibilite=O&amp;date_filtre=1\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
		break;
	} //fin switch $script
?>
