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
		$extension = strrchr($nomFichier, ".");

		
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
					$ok=false;
					
					while (($fichierLu = readdir ($repertoire)) && !($ok))
					{
						if ($fichierLu == $nomFichier)
						{
							$ok = true;
						} else
						{
							$ok = false;
						}	
					} // On sort quand tous les fichiers ont été lus OU quand $ok devient vrai.
					
					if ($ok)
					{
						// Ensuite, on copie le fichier uploadé ou bon nous semble.
						$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$nomFichier);
					} else
					{
						echo ' <div class="important">
									Le document n\'existe pas sur le serveur.<br/>
									Vous pouvez l\'insérer en utilisant la fonction "Ajouter un nouveau document"</br/>
									<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
								</div>';
					}
					if($uploadOk)
					{
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
