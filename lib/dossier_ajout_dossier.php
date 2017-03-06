<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboraticedossier.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		// include ("dossier_mysql.php");
		include ("dossier_fonction_base.php");
		include ("dossier_fonction_affichage.php");
		
		// $co = new Mysql ($host, $user, $pass, $base);
		// $co->connect($base);
		
		$libDossier = obtenirNomTousDossiers ($co);
	?>
	</head>
	<body>
		<div class="gauche">
			<form method="post" action="dossier_ajout_dossier_droit.php" name="fromAjoutDossier">
				<center>
				<table border="1">
					<tr>
						<th COLSPAN="2">
							<h2>Création d'un nouveau dossier</h2>
						</th>
					</tr>
					<tr>
						<td>
						</td>
					</tr>
					<tr>
						<td>
							Libellé du Dossier:
						</td>
						<td>
							<input type="text" name="libelleDossier" size="40">
						</td>
					</tr>
					<tr>
						<td>
							Description du dossier: 
						</td>
						<td>
							<textarea name="description" cols='50' rows='5'></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input  type="submit" value="Suivant" >
						</td>
					</tr>
				</table>
				</center>
				<center>
				<a href="dossier_index.php" target="_top" title="Retour au module de gestion de dossier"><?php echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/retour.png\"";?>></a>
				</center>
			</form>
		</div>
		<div class="droite">
			<center>
			<table border="1">
				<tr>
					<th COLSPAN="2">
						<h2>Liste des dossiers existants</h2>
					</th>
				</tr>				
				<?php
					if ($libDossier)
					{
						foreach ($libDossier as $val) { echo '<tr><td>'.$val.'</td></tr>'; }
					}
				?>
			</table>
			</center>
		</div>
	</body>
</html>
