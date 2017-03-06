<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		include ("../biblio/config.php");
		include ("../biblio/fct.php");
		// include ("dossier_mysql.php");
		include ("dossier_fonction_base.php");
		include ("dossier_upload.php");
		
		// $co = new Mysql ($host, $user, $pass, $base);
		// $co->connect($base);
		$nomDossier = $_POST['nom'];
		$idDossier = obtenirUnNumDossier ($co, $nomDossier);
	?>
</head>
<body>

<?php	

	if (isset($_POST['libelleDoc'])){ $libDoc = $_POST['libelleDoc']; } else { $libDoc = ""; }
	if (isset($_POST['moduleDoc'])){ $moduleDoc = $_POST['moduleDoc']; } else { $moduleDoc = ""; }
	if (isset($_POST['descriptionDoc'])){ $descriptionDoc = $_POST['descriptionDoc']; } else { $descriptionDoc = ""; }

	// Récupération des données de dossier_upload.php
	// On vérifie que le champs contenant le chemin du fichier soit
	// bien rempli.

	if(!empty($_FILES["file"]["name"]))
	{
		// Nom du fichier choisi: (on ajoute par défaut 10 avant l'extension).
		$nomFichier = $_FILES["file"]["name"];
		// Nom temporaire sur le serveur:
		$nomTemporaire = $_FILES["file"]["tmp_name"] ;
		// Type du fichier choisi:
		$typeFichier = $_FILES["file"]["type"] ;
		// Poids en octets du fichier choisit:
		$poidsFichier = $_FILES["file"]["size"] ;
		// Code de l'erreur si jamais il y en a une:
		$codeErreur = $_FILES["file"]["error"] ;
		// Extension du fichier
		$extension = strtolower(strrchr($nomFichier, "."));

		
		if($poidsFichier <> 0)
		{
			// Si la taille du fichier est supérieure à la taille
			// maximum spécifiée => message d'erreur
			if($poidsFichier < $MAX_SIZE)
			{
				// On teste ensuite si le fichier a une extension autorisée
				if(isExtAuthorized($extension))
				{
					// On vérifie que le document n'existe pas
					$repertoire = opendir($dossierDoc);
					$ok=true;
					
					while (($fichierLu = readdir ($repertoire)) && ($ok))
					{
						if ($fichierLu == $nomFichier)
						{
							// echo '<p>'.$fichierLu.' '.$nomFichier.'</p>';
							$ok = false;
						} else
						{
							$ok = true;
						}	
					} // On sort quand tous les fichiers ont été lus OU quand $ok devient faux.
					
					if ($ok)
					{
						// Ensuite, on copie le fichier uploadé ou bon nous semble.
						$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$nomFichier);
					} else
					{
						echo ' <div class="important">
									Ce document existe déjà sur le serveur.<br/>
									Pour le remplacer, utilisez la fonction "Remplacer un document existant"<br/>
									<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
								</div>';
					}
					if($uploadOk)
					{
					
						// On récupère la catégorie en fonction de l'extension
						if ($extension == ".doc" || $extension == ".txt" || $extension == ".odt")
						{
							$categorie = "Texte";
						} else if ($extension == ".bmp" || $extension == ".jpg" || $extension == ".jpeg" || $extension == ".png" || $extension == ".gif")
						{
							$categorie = "Image";
						} else if ($extension == ".pdf" || $extension == ".ppt" || $extension == ".odp")
						{
							$categorie = "Présentation";
						} else if ($extension == ".xls" || $extension == ".ods")
						{
							$categorie = "Tableur";
						} else if ($extension == ".gz" || $extension == ".zip" || $extension == ".tar" || $extension == ".rar" || $extension == ".tgz" || $extension == ".7z")
						{
							$categorie = "Archives compressées";
						}
						
						// Requete d'insertion dans la base : ajout dans document puis dans documentmesdossier
						insertionDocument ($co, $idDossier, $libDoc, $nomFichier, $moduleDoc, $descriptionDoc, $categorie);
						
						echo '
							<div class="valider">
								Le document a été déplacé vers le serveur.<br/>
								<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
							</div>';
					}
				}else{
					echo'
							<div class="important">
								Les fichiers avec l\'extension '.$extension.' ne peuvent pas être déplacés vers le serveur.<br>
								Pour ajouter cette extension dans la liste des extensions possibles, contactez l\'administrateur.<br/>
								<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
							</div>';
				}
			}else{
				$tailleKo = $MAX_SIZE / 1000;
				echo'
						<div class="important">
							Les fichiers dont la taille est supérieure à '.$tailleKo.' Ko ne peuvent être déplacés vers le serveur.<br>
							Pour augmenter la taille maximale, contactez l\'administrateur.<br/>
							<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
						</div>';
			}		
		}else{
			echo'
					<div class="important">
						Le fichier est invalide (vide ou nul).<br/>
						<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
					</div>';
		}
	}else{
		echo'
			<div class="important">
				Veuillez sélectionner un document.<br/>
				<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
			</div>';
	}
	

	
?>

</body>
</html>
