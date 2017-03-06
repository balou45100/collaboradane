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
		
		$co = new Mysql ($host, $user, $pass, $base);
		$co->connect($base);
	?>
</head>
<body>

	<?php

		if ($_GET['verif'] == 1)
		{
			// Confirmation : on veut être sûr que la personne cherche à supprimer le dossier (pour éviter les accidents).
			$num = $_GET['num'];
			$nom = $_GET['libelle'];
			echo '	<div class="important">
						Vous vous appretez à supprimer le dossier '.$nom.' ainsi que l\'ensemble de son contenu.
						<br/>
						<a href="dossier_suppression.php?&verif=2&num='.$num.'&libelle='.$nom.'" title="Continuer"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierValider.png" ></a>
						&nbsp;
						&nbsp;
						<a href="dossier_personnel.php" title="Retour au menu de suppression"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierRefuser.png"></a>
					</div>';
		} else if ($_GET['verif'] == 2)
		{
			//echo $_GET['num'].' '.$_GET['libelle'];
			// Suppression. (D'abord l'ensemle des tables ou il apparaît, puis le dossier en lui même).
			$suppression = suppressionDossier($co, $_GET['num']);
			if ($suppression)
			{
				echo '	<div class="valider">Le dossier a été supprimé
							<br/>
							<a href="dossier_index.php" title="Retour à l\'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
						</div>';
				
			} else
			{
				echo '	<div class="important">Suite à un problème, le dossier n\'a pu être supprimé
							<br/>
							<a href="dossier_index.php" title="Retour à l\'accueil" target="_top"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
						</div>';
			}
		}

	?>

</body>
</html>
