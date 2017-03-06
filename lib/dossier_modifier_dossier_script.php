<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		// include ("dossier_mysql.php");
		include ("dossier_fonction_base.php");

		// $co = new Mysql ($host, $user, $pass, $base);
		// $co->connect($base);	
	?>	

</head>
<body>

<?php
	
	
	$idDossier = $_POST['numDossier'];
	$libelleDossier = $_POST['libelleDossier'];
	$description = $_POST['description'];
	
	$ok = modifierDossier ($co, $idDossier, $libelleDossier, $description);

	if ($ok)
	{
	?>
		
		<div class="valider">Modification effectuée<br/>
			<a href="dossier_index.php" title="Retour à l\'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
		</div>';
		
	<?php
	} else 
	{
	?>
	
		
		<div class="important">Impossible de modifier le dossier<br/>
			<a href="dossier_index.php" title="Retour à l'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
		</div>
	
	<?php	
	}
?>

</body>
</html>
