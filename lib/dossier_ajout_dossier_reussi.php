<!DOCTYPE HTML>
<html>
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
	
	//echo $_POST['libelleDossier'];
	//echo $_POST['description'];
	
	$libelleDossier = $_POST['libelleDossier'];
	$description = $_POST['description'];
	//echo'</br>';
		
	$num=obtenirNumsUtils($co);
	
	$verif=insertionDossier($co, $libelleDossier, $description);
	$idDernierDossier = obtenirDernierIdDossierCree($co);
	
	if ($verif)
	{
		/*
			Algorithme de gestion des droits :
			Si un utilisateur a la case "créateur" cochée, son droit vaut 2.
			Si un utilisateur a la case "droit" cochée, son droit vaut 1.
			Si un utilisateur n'a rien de coché, on affecte rien et on insère rien dans la base.
			
			Si un créateur est coché, on affecte la variable verifDroit.
			Si l'utilisateur ne coche aucune case, la table utilisateurmesdossier n'est pas remplie, mais
			la table dossier est remplie. Il faut donc, enlever les champs ajoutés dans cette dernière.
		*/
		
		$verifDroit = false;
		foreach ($num as $val)
		{		
			$droit = $_POST['check'.$val.''];
			$createur = $_POST['createur'.$val.''];
			if ($createur == 2)
			{
				$droit = 2;
				$verifDroit = true;
			}
			if ($droit >= 1)
			{
				$ok = insertionDroit($co, $val, $idDernierDossier, $droit);
			}
		}
	}
	if ($ok)
	{
	?>
		
		<div class="valider">Enregistrement effectué<br/>
			<a href="dossier_index.php" title="Retour à l'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
		</div>
		
	<?php
	} else 
	{
	?>
	
		
		<div class="important">Impossible de créer un dossier sans créateur
			<a href="dossier_index.php" title="Retour à l'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
		</div>
		
	<?php	
	}
	if (!$verifDroit)
	{
		// On supprime le dossier créé dans dossier (car aucun créateur n'est selectionné).
		suppressionDossier ($co, $idDernierDossier);
	}
?>

</body>
</html>
