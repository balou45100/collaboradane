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
		// Cette page affiche l'arborescence des dossiers.
		// A gauche, elle propose d'insérer un nouvel évenement, et à droite elle affiche les infos liées au dossier selectionné.
	
		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		include ("dossier_collection.php");
		include ("dossier_passerelle.php");
		// include ("dossier_mysql.php");
		include ("dossier_fonction_base.php");
		include ("dossier_fonction_affichage.php");
		
		// $co = new Mysql ($host, $user, $pass, $base);
		// $co->connect($base);
		
		$libDossier = obtenirNomDossierUtil ($co, $_SESSION['id_util']);
		$compt = 0;
		$listeCategorie = obtenirListeCategorie ($co);
		$listeEtab = obtenirRneEtabs($co);
		$listeSoc = obtenirNomsTousSocietes($co);
		
		$passerelle = new Passerelle ($co);		
		
		// La variable compteur permet de savoir où l'on se trouve dans l'affichage de l'arborescence
		// Ex: si on clique sur un dossier, compteur vaut 1, puis, si l'on clique sur "Ajouter un document", compteur vaut 2.
		// Ce sont les liens qui permettent de modifier la valeur de compteur. On récupère ces valeurs grâce à la variable GET.
		
		if (isset($_GET['compteur'])) 
		{
			$compteur = $_GET['compteur'];
		}
		if (isset($_GET['nom']))
		{
			$nom = $_GET['nom'];
		}
		if (isset($_GET['choix']))
		{
			$choix = $_GET['choix'];
		}

	?>
</head>

<body>
	<!-- Affichage de l'arborescence -->
	<div class="gauche">
		<h3>Liste des dossiers (Ajout)</h3>
		<?php
			// Selon le compteur, l'affichage change.
			switch ($compteur)
			{
				case 0 : 	// Affichage simple des dossiers.
							echo '<ul>';
							if ($libDossier)
							{
								foreach ($libDossier as $val)
								{
									echo '<li>';
									echo '<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=1" target="body">'.$val.'</a><br/>';
									echo '</li>';
								}
								echo '</ul>';
							} else {
								echo 'Il n\'existe aucun dossier';
							}
							break;
				case 1 : 	// Affichage des dossiers, (seul celui choisi apparait sous forme de lien pour un retour en arrière).
							// Affichage de ce que l'on peut faire (ajouter un document ou un evenement lié au dossier).
							echo '<ul>';
							if ($libDossier)
							{
								foreach ($libDossier as $val)
								{
									if ($val != $nom)
									{
										echo '<li>';
										echo $val.'</br>';
										echo '</li>';
									} else {
										echo '<li>';
										echo '<a href="dossier_ajout_element.php" target="body">'.$val.'</a></br>';
										echo '</li>';
										echo '<br/>
											<ul>
												<li>
													<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=2&choix=even" target="body">
													Ajouter un événement lié à ce dossier
													</a>
												</li>
												<li>
													<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=2&choix=doc" target="body">
													Ajouter un nouveau document lié à ce dossier
													</a>
												</li>
												<li>
													<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=2&choix=remp" target="body">
													Remplacer un document existant lié à ce dossier
													</a>
												</li>
												<li>
													<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=2&choix=etab" target="body">
													Lier un établissement à ce dossier
													</a>
												</li>
												<li>
													<a href="dossier_ajout_element.php?&nom='.$val.'&compteur=2&choix=soc" target="body">
													Lier une société à ce dossier
													</a>
												</li>
												<br/>
											</ul>';
									}
								}
								echo '</ul>';
							} else {
								echo 'Il n\'existe aucun dossier';
							}
							break;
				case 2 :	// Affichage des dossiers, et de ce que l'on peut faire 
							// (seuls ceux choisis apparaissent sous forme de lien pour un retour en arrière).
							// Affichage du formulaire lié au choix de l'utilisateur. 
							echo '<ul>';
							if ($libDossier)
							{
								foreach ($libDossier as $val)
								{
									if ($val != $nom)
									{
										echo '<li>';
										echo $val.'</br>';
										echo '</li>';
									} else {
										echo '<li>';
										echo '<a href="dossier_ajout_element.php" target="body">'.$val.'</a></br>';
										echo '</li>';
										echo '<br/>
											<ul>';
											if ($choix == "even")
											{
												echo '
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Ajouter un événement lié à ce dossier
														</a>';
															afficherFormulaireEven ($nom);
													echo '</li>
														<br/>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=doc" target="body">
														Ajouter un nouveau document lié à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=remp" target="body">
														Remplacer un document existant lié à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=etab" target="body">
														Lier un établissement à ce dossier
														</a>
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=soc" target="body">
														Lier une société à ce dossier
														</a>											
													</li>
													<br/>
											</ul>';
											} else if ($choix == "doc"){
												echo '
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=even" target="body">
														Ajouter un événement lié à ce dossier
														</a>											
													</li>											
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Ajouter un nouveau document lié à ce dossier
														</a>
													</li>
														<ul>';
															afficherFormulaireDoc ($nom);
												echo'	</ul>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=remp" target="body">
														Remplacer un document existant lié à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=etab" target="body">
														Lier un établissement à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=soc" target="body">
														Lier une société à ce dossier
														</a>											
													</li>
													<br/>
											</ul>';									
											}else if ($choix == "remp")
											{
												echo '
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=even" target="body">
														Ajouter un événement lié à ce dossier
														</a>											
													</li>											
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=doc" target="body">
														Ajouter un nouveau document lié à ce dossier
														</a>											
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Remplacer un document existant lié à ce dossier
														</a>
													</li>
														<ul>';
															afficherFormulaireDocRemplacement ($nom);
												echo'	</ul>
													<li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=etab" target="body">
														Lier un établissement à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=soc" target="body">
														Lier une société à ce dossier
														</a>											
													</li>
													<br/>
											</ul>';	
											}else if ($choix == "etab")
											{
												echo '
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=even" target="body">
														Ajouter un événement lié à ce dossier
														</a>											
													</li>											
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=doc" target="body">
														Ajouter un nouveau document lié à ce dossier
														</a>
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=remp" target="body">
														Remplacer un document existant lié à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Lier un établissement à ce dossier
														</a>
													</li>';
													afficherFormulaireEtab ($nom, $listeEtab);
											echo '	<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=soc" target="body">
														Lier une société à ce dossier
														</a>											
													</li>
													<br/>
											</ul>';
											} else if ($choix == "soc")
											{
												echo '
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=even" target="body">
														Ajouter un événement lié à ce dossier
														</a>											
													</li>											
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Ajouter un nouveau document lié à ce dossier
														</a>
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=remp" target="body">
														Remplacer un document existant lié à ce dossier
														</a>											
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=2&nom='.$val.'&choix=etab" target="body">
														Lier un établissement à ce dossier
														</a>
													</li>
													<li>
														<a href="dossier_ajout_element.php?&compteur=1&nom='.$val.'" target="body">
														Lier une société à ce dossier
														</a>
													</li>';
													afficherFormulaireSociete ($nom, $listeSoc);										
									echo '	</ul>';
											}
									}
								}
							} else {	
								echo 'Il n\'existe aucun dossier';
							}			
							break;
			}
		?>
	</div>
	
	<!-- Affichage des valeurs correspondantes -->
	<div class="droite">
		<?php
			if ($compteur != 0)
			{
				// On récupère le numéro de dossier lié au nom
				$leNum = obtenirUnNumDossier ($co, $nom);
				$collectDoc = new Collection();
				$collectDoc = $passerelle->dossierChargerDocument ($leNum);
				$collectEven = new Collection();
				$collectEven = $passerelle->dossierChargerEvenement ($leNum);				
				$collectEtab = new Collection();
				$collectEtab = $passerelle->dossierChargerEtablissement ($leNum);				
				$collectSoc = new Collection();
				$collectSoc = $passerelle->dossierChargerSociete ($leNum);
				echo '<h2>'.$nom.'</h2>';
				afficherEvenement($collectEven);
				echo '<br/>';
				afficherDocument($collectDoc);
				echo '<br/>';
				afficherEtablissement($collectEtab);				
				echo '<br/>';
				afficherSociete($collectSoc);
			}
		?>
	</div>
	
</body>
</html>
