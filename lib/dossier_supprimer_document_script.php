<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		include ("../biblio/config.php");
		include ("dossier_fonction_base.php");
		
		$compteur = $_GET['compteur'];
		$numDoc = $_GET['numDoc'];
		$nomDoc = $_GET['nomDoc'];
		$nomFichier = $_GET['nomFichier'];
		$nomDossier = $_GET['nomDossier'];
	?>
</head>
<body>

	<?php
	
	if ($compteur == 0)
	{
		// On affiche le message de confirmation.
		echo '	<div class="important">
					Vous vous appretez à supprimer le document '.$nomDoc.'.<br/>
					Souhaitez vous continuer ?<br/>
					<a href="dossier_supprimer_document_script.php?&nomDossier='.$nomDossier.'&compteur=1&numDoc='.$numDoc.'&nomDoc='.$nomDoc.'&nomFichier='.$nomFichier.'" title="Continuer"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierValider.png" ></a>
						&nbsp;
						&nbsp;
					<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au menu de suppression"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierRefuser.png"></a>
				</div>';
	} else if ($compteur == 1)
	{
		// On supprime le fichier de la base et du serveur.
		$repertoire = opendir($dossierDoc);
		while ($fichierLu = readdir($repertoire))
		{
			// Lecture du répertoire
			if ($nomFichier == $fichierLu)
			{
				// Ecriture de l'emplacement du fichier (emplacement + nom du fichier)
				$fichierSuppr = $dossierDoc.$fichierLu;
			
				// Suppression dans le repertoire
				unlink ($fichierSuppr);
				
				// Suppression dans la base
				$ok = supprimeDoc ($co, $numDoc);
			}
		}
		if ($ok)
		{
			echo '	<div class="valider">
						Le document '.$nomFichier.' a correctement été supprimé du serveur.<br/>
						<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
					</div>';
		} else
		{
			echo '	<div class="important">
						Le document '.$nomFichier.' n\'a pas été supprimé du serveur.<br/>
						<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
					</div>';
		}
	}
	
	?>

</body>
</html>
