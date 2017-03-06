<!DOCTYPE HTML>
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
	
	//include ("../biblio/dossier.css");
	include ("../biblio/init_dossier.php");
	include ("../biblio/fct.php");
	// include ("dossier_mysql.php");
	include ("dossier_fonction_base.php");
	
	// $co = new Mysql ($host, $user, $pass, $base);
	// $co->connect($base);
	$nomDossier = $_POST['nom'];
	$idDossier = obtenirUnNumDossier ($co, $nomDossier);
		
	?>
</head>
<body>

<?php

	switch ($_POST['choix'])
	{
		case "even" : 	// Récupération des valeurs des minis formulaires (evenement)
						if (isset($_POST['libelleEven'])){ $libEven = $_POST['libelleEven']; } else { $libEven=""; }
						$dateEven = crevardate ($_POST['jour'], $_POST['mois'], $_POST['annee']);
						$horaireEven = $_POST['horaireEven'];
						$lieuEven = $_POST['lieuEven'];
						if (isset($_POST['remarquesEven'])){ $remarquesEven = $_POST['remarquesEven']; } else { $remarquesEven=""; }
						// Requête d'insertion dans la base : ajout dans evenement, puis dans evenementmesdossiers
						$ok = insertionEvenement ($co, $idDossier, $libEven, $dateEven, $horaireEven, $lieuEven, $remarquesEven);
						if ($ok)
						{
							// Si l'insertion a réussie, on affiche ce que l'utilisateur vient d'insérer
							$nomDossier = obtenirNomDossier ($co, $idDossier);
							echo '	<div class="valider">
										L\'evenement '.$libEven.' a correctement été ajouté dans le dossier '.$nomDossier.'.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png"></a>
									</div>';
						} else 
						{
							echo '	<div class="important">
										L\'evenement '.$libEven.' n\'a pas été ajouté dans le dossier '.$nomDossier.'.<br/>
										Verifiez que cet événement ne soit pas déja lié à ce dossier.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png" border="0"></a>										
									</div>';
						}
						break;
		
		case "etab" :	// Récupération des valeurs des minis formulaires (etablissement)
						$rne = $_POST['rne'];
						$ok = insertionEtablissement ($co, $idDossier, $rne);
						if ($ok)
						{
							echo ' <div class="valider">
										L\'établissement a correctement été ajouté dans le dossier '.$nomDossier.'.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png" border="0"></a>
									</div>';
						} else
						{
							echo '	<div class="important">
										L\'établissement n\'a pas été ajouté dans le dossier '.$nomDossier.'.<br/>
										Verifiez que cet établissement ne soit pas déja lié à ce dossier.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png" border="0"></a>										
									</div>';
						}
						break;		
						
		case "soc" :	// Récupération des valeurs des minis formulaires (etablissement)
						$nomSociete= $_POST['nomSoc'];
						$numSociete = obtenirUnNumSociete ($co, $nomSociete);
						$ok = insertionSociete ($co, $idDossier, $numSociete);
						if ($ok)
						{
							echo ' <div class="valider">
										La société '.$nomSociete.' a correctement été ajouté dans le dossier '.$nomDossier.'.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png" border="0"></a>
									</div>';
						} else
						{
							echo '	<div class="important">
										La société '.$nomSociete.' n\'a pas été ajouté dans le dossier '.$nomDossier.'.<br/>
										Verifiez que cette société ne soit pas déja liée à ce dossier.
										<br/>
										<a href="dossier_ajout_element.php?&compteur=1&nom='.$nomDossier.'" title="Retour au module de gestion de dossier" target="body"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fleche-retour.png" border="0"></a>>										
									</div>';
						}
						break;
	}

?>

</body>
</html>
