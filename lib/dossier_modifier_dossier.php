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
		include ("dossier_fonction_affichage.php");
		
		// $co = new Mysql ($host, $user, $pass, $base);
		// $co->connect($base);
		
		$libDossier = obtenirNomTousDossiers ($co);
	?>
	</head>
	<body>
	
	<?php
		$libelleDossier = $_GET['libelle'];
		$description = $_GET['description'];
		$num = $_GET['num'];
		
	?>
	
		<div class="gauche">
			<form method="post" action="dossier_modifier_dossier_script.php" name="fromAjoutDossier">
			<?php
				echo '<input type="hidden" name="numDossier" value='.$num.'>'
			?>
				<center>
				<table border="1">
					<tr>
						<th COLSPAN="2">
							<h2>Modifier un dossier</h2>
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
						<?php
							echo'<input type="text" name="libelleDossier" size="40" value='.$libelleDossier.'>'
						?>
						</td>
					</tr>
					<tr>
						<td>
							Description du dossier: 
						</td>
						<td>
						<?php
							echo'<textarea name="description" cols=\'50\' rows=\'5\'>'.$description.'</textarea>'
						?>
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
				<a href="dossier_index.php" target="_top" title="Retour au module de gestion de dossier"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
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
