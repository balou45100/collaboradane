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
	include ("dossier_fonction_base.php");
	// include("dossier_mysql.php");
	include("dossier_collection.php");
	include("dossier_passerelle.php");
	include("dossier_fonction_affichage.php");

	// $co= new mysql ($host, $user, $pass, $base);
	// $co->connect($base);
	$passerelle = new Passerelle ($co);
	$collectionUtil = new Collection ();
	$collectionUtilDroit = new Collection ();
	
?>
</head>
<body>
	<div class="gauche">
	
		<form method="post" action="dossier_modification_droit_script.php" target="body">
			<h2>Modification des droits des utilisateurs</h2>
			<?php
			
				//récupération des données de la page "dossier_personnel.php"
				$numDossier=$_GET['num'];
				$libelleDossier=$_GET['libelle'];
		
				$tabUtilDroit = obtenirUtilDroit ($co, $numDossier);
				/* 	On récupère le nombre d'élements du tableau (il faut enlever 2 car on enlève 0 et 1)
					Explication :
						$food = array(	'fruits' => array('orange', 'banana', 'apple'),
										'veggie' => array('carrot', 'collard', 'pea'));

						// count récursif
						echo count($food, COUNT_RECURSIVE); affiche 8 (or ici on veut enlever 'fruit' et 'veggie' (0 et 1)
						
						SOURCE : php.net / fonction count()
						http://www.php.net/manual/fr/function.count.php
						
						$nombreElement comprend le nombre d'idUtil + le nombre de droit
						On divise donc par 2 pour obtenir le nombre de lignes.
				*/
				$nombreElement = (count($tabUtilDroit, COUNT_RECURSIVE) - 2) / 2;
		
				echo '<input type="hidden" name="numDossier" value="'.$numDossier.'">';	
				echo '<input type="hidden" name="libelleDossier" value="'.$libelleDossier.'">';				
		
				// On charge la collection des utilisateurs liés au dossier
				$collectionUtilDroit = $passerelle->dossierChargerUtilisateur($numDossier);
				$collectionUtil = $passerelle->chargerUtilisateur();
				// On charge la collection de tous les utilisateurs
				afficherModifierUtilisateurDroit ($collectionUtilDroit, $collectionUtil, $tabUtilDroit, $nombreElement);	
				
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
						Il faut au minimum un créateur pour créer un dossier.
						<br/><br/>
						Pour ajouter ou ôter un rôle de créateur sur un utilisateur, contacter l'administrateur.
					</td>
				<tr/>
			</table>
	</div>
