<?php
session_start();
header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

	//include ("../biblio/dossier.css");
	include("../biblio/init_dossier.php");
	// include("dossier_mysql.php");
	include("dossier_collection.php");
	include("dossier_passerelle.php");
	include("dossier_fonction_affichage.php");

	// $co= new Mysql ($host, $user, $pass, $base);
	// $co->connect($base);
	$passerelle = new Passerelle ($co);
	$collectionUtil = new Collection ();
	
?>
</head>
<body>
	<div class="gauche">
		<form method="post" action="dossier_ajout_dossier_reussi.php" target="body" name="formAjoutDossier">
			<h2>Gestion des droits des utilisateurs sur le dossier créé</h2>
			<?php
				//récupération des données de la page "dossier_ajoute_dossier.php"
				$libelleDossier=$_POST['libelleDossier'];
				$description=$_POST['description'];
				
				echo '<input type="hidden" name="libelleDossier" value="'.addslashes($libelleDossier).'">';
				echo '<input type="hidden" name="description" value="'.addslashes($description).'">';
				
				$collectionUtil = $passerelle->chargerUtilisateur(); 
				afficherUtilisateurDroit($collectionUtil, $_SESSION['id_util']);	
				
			?>
		</form>
	</div>
	<div class="droite">
			<br/><br/><br/><br/>
			<table>
				<tr>
					<td>
						(*) La case "Droit" permet de définir quel utilisateur aura accès au dossier.<br/><br/>
						(**) La case "Créateur" permet de définir quel utilisateur peut modifier les droits de ce dossier. 
						Il possède également les droits de lecture.<br/><br/>
						Il faut au minimum un créateur pour créer un dossier.<br/>

						<br/><br/>
						Pour ajouter ou ôter un rôle de créateur sur un utilisateur, contacter l'administrateur.
					</td>
				<tr/>
			</table>
	</div>
</body>
</html>
