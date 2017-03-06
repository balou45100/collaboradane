<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
	
	//include ("../biblio/dossier.css");
	include ("../biblio/init_dossier.php");
	include ("dossier_collection.php");
	include ("dossier_passerelle.php");
	// include ("dossier_mysql.php");
	include ("dossier_fonction_base.php");
	include ("dossier_fonction_affichage.php");
	
	// $co = new Mysql ($host, $user, $pass, $base);
	// $co->connect($base);

	?>
	
</head>
<body>

<?php
	// On appelle les fonctions de suppression selon les cas.
	if (isset ($_GET['suppr']))
	{
		switch ($_GET['suppr'])
		{
		
			case "even" : 	$ok = supprimerEven ($co, $nom, $_GET['numEven']);
							if ($ok)
							{
								echo '	<div class="valider">
											Cet événement a correctement été supprimé.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
										</div>';
							} else 
							{
								echo '	<div class="important">Erreur dans la suppression.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
										</div>';
							}
							break;
			
			case "etab" :	$ok = supprimerEtab ($co, $nom, $_GET['rne']);
							if ($ok)
							{
								echo '	<div class="valider">Cet établissement a correctement été supprimé.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
										</div>';
							} else 
							{
								echo '	<div class="important">Erreur dans la suppression.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>										
										</div>';
							}
							break;
			
			case "soc" : 	$ok = supprimerSoc ($co, $nom, $_GET['numSoc']);
							if ($ok)
							{
								echo '	<div class="valider">Cette société a correctement été supprimée.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>										
										</div>';
							} else 
							{
								echo '	<div class="important">Erreur dans la suppression.<br/>
											<a href="dossier_supprimer_element.php?&compteur=1&nom='.$nomDossier.'" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>										
										</div>';
							}
							break;
			
		
		}
	}
	
?>

</body>
</html>
