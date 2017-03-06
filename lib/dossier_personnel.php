<?php
	session_start();
	/*
	$_SESSION['nom']
	$_SESSION['mail']
	$_SESSION['droit']
	$_SESSION['sexe']
	$_SESSION['id_util']
	*/	
	header('Content-Type: text/html;charset=UTF-8');
?>
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
		
		$passerelle = new Passerelle ($co);
		$dossierUtil = new Collection ();
		$dossierUtilCreateur = new Collection ();
		// On charge une collection de dossiers où l'utilisateur a un accès.
		$dossierUtil = $passerelle->utilisateurChargerDossier($_SESSION['id_util'],1);
		$dossierMendel = $passerelle->utilisateurChargerDossier(1,2);
		// On charge une collection de dossiers où l'utilisateur est créateur.
		$dossierUtilCreateur = $passerelle->utilisateurChargerDossier($_SESSION['id_util'],2);
		
	?>
</head>
<body>

	<div class="gauche">
	
		<h2>Modifier les droits</h2>
		<!-- Lien vers les dossiers où l'utilisateur peut modifier les droits -->
			<p>
			<?php
				afficherDossierModifDroit($dossierUtilCreateur);
			?>
			</p>
			
		<h2>Renommer et/ou modifier la description d'un dossier</h2>
		<!-- Lien vers les dossiers où l'utilisateur peut modifier le libellé et la description d'un dossier -->
		<p>
		<?php
			afficherDossierModifDossier($dossierUtilCreateur);
		?>
		</p>
		
	<?php
		if ($_SESSION['id_util'] == 1)
		{
			// Seul l'utilisateur Mendel a le pouvoir de supprimer un dossier.
			echo '<h2>Supprimer un dossier</h2>
					<p>';
					afficherDossierSuppression($dossierMendel);
			echo '	</p>';
		}
	?>
	</div>
	
	<div class="droite">
		<h2>Dossiers créés</h2>
		<!-- Affichage de la liste des dossiers où l'utilisateur est présent -->
		<?php
			afficherDossier($dossierUtilCreateur);
		?>
		<h2>Dossiers où j'interviens</h2>
		<!-- Affichage de la liste des dossiers où l'utilisateur est présent -->
		<?php
			afficherDossier($dossierUtil);
		?>	
	</div>

</body>
</html>
