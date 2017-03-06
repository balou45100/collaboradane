<!DOCTYPE HTML>
<?php

	/********************************************************************************************
	*	Fichier contenant les fonctions liées à l'affichage du module de gestion de dossiers	*
	********************************************************************************************/
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			//include ("../biblio/dossier.css");
		?>
		<script language="JavaScript">
			
			<!-- pour cocher/décocher toutes les cases de droit -->
			var checkflagDroit = "false";
			
			function checkDroit(field) {
			if (checkflagDroit == "false") {
			  for (i = 0; i < field.length; i++) {
			  field[i].checked = true;}
			  checkflagDroit = "true";
			  return "Tout décocher"; }
			else {
			  for (i = 0; i < field.length; i++) {
			  field[i].checked = false; }
			  checkflagDroit = "false";
			  return "Tout cocher"; }
			}			
			
			<!-- Pour cocher/décocher toutes les cases de createur -->
			
			var checkflagCreateur = "false";
			
			function checkCreateur(field) {
			if (checkflagCreateur == "false") {
			  for (i = 0; i < field.length; i++) {
			  field[i].checked = true;}
			  checkflagCreateur = "true";
			  return "Tout décocher"; }
			else {
			  for (i = 0; i < field.length; i++) {
			  field[i].checked = false; }
			  checkflagCreateur = "false";
			  return "Tout cocher"; }
			}
			
		</script>
	</head>
</html>

<?php

	
	// Affiche la collection d'Utilisateur passée en paramètre
	function afficherUtilisateur ($collectionUtil)
	{
		if ($collectionUtil->count() != 0)
		{
			// On place le curseur de la collection au début
			$collectionUtil->rewind();
			
			echo '<table border="1">
					<span class="titreTableau">Liste des Utilisateurs</span>
					<tr>
						<th>Prenom</th><th>Nom</th><th>Mail</th><th>Tel Bureau</th><th>Date Derniere Connexion</th>
					</tr>';		
					
			// On fait une boucle tant que l'objet suivant est un valide
			while ($collectionUtil->valid()) {

				// Récupération des données de chaque élément de la collection	
				$nom = $collectionUtil->current()->getNomUtil();
				$prenom = $collectionUtil->current()->getPrenomUtil();
				$mail = $collectionUtil->current()->getMailUtil ();
				$telBureauUtil = $collectionUtil->current()->getTelBureauUtil ();
				$dateDerniereCo = $collectionUtil->current()->getDateDerniereConnexionUtil ();
				
				//$pass = $collectionUtil->current()->getPassewordUtil ();
				//$num = $collectionUtil->current()->getNumeroUtil();
				echo '<tr>
						<td>'.$nom.'</td><td>'.$prenom.'</td>
						<td>'.$mail.'</td><td>'.$telBureauUtil.'</td><td>'.$dateDerniereCo.'</td>
					</tr>';			
				// On passe à l'objet suivant
				$collectionUtil->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'existe aucun utilisateur lié.<br/>';
		}
	}
	
	// Affiche la collection d'Utilisateur passée en paramètre ainsi que les boutons permettant de donner le droit d'accés aux dossier
	function afficherUtilisateurDroit ($collectionUtil, $numUtil)
	{
		if ($collectionUtil->count() != 0)
		{
			// On place le curseur de la collection au début
			$collectionUtil->rewind();
			
			echo '<table border="1">
					<span class="titreTableau">Liste des Utilisateurs</span>
					<tr>
						<th>Prenom</th><th>Nom</th><th>Mail</th>
						<th><font color="red">Droit*</font></th><th><font color="red">Créateur**</font></th>
					</tr>';		
					
			// On fait une boucle tant que l'objet suivant est un valide
			while ($collectionUtil->valid()) {

				// Récupération des données de chaque élément de la collection	
				$nom = $collectionUtil->current()->getNomUtil();
				$prenom = $collectionUtil->current()->getPrenomUtil();
				$mail = $collectionUtil->current()->getMailUtil ();
				$telBureauUtil = $collectionUtil->current()->getTelBureauUtil ();
				$dateDerniereCo = $collectionUtil->current()->getDateDerniereConnexionUtil ();
				
				//$pass = $collectionUtil->current()->getPassewordUtil ();
				$num = $collectionUtil->current()->getNumeroUtil();
				
				echo '	<tr>
							<td align="center">'.$nom.'</td><td align="center">'.$prenom.'</td>
							<td align="center">'.$mail.'</td>';
							if ($numUtil == $num)
							{
								echo '<td align="right"><input checked="checked" id="droit" type="checkbox" name="check'.$num.'" value=1></td>';
								echo '<td align="right"><input checked="checked" id="createur" type="checkbox" name="createur'.$num.'" value=2></td>';
							} else 
							{
								echo '<td align="right"><input id="droit" type="checkbox" name="check'.$num.'" value=1></td>';
								echo '<td align="right"><input id="createur" type="checkbox" name="createur'.$num.'" value=2></td>';
							}
				echo'	</tr>';			
				// On passe à l'objet suivant
				$collectionUtil->next();
			}
			echo'	<tr>
						<td colspan="2">
						</td>
						<td align="right">
							Tout cocher\Tout décocher 
						</td>
						<td align="right">
							<input name="tout" type="checkbox" onClick="this.value=checkDroit(this.form.droit)";"/>
						</td>
						<td align="right">
							<input name="tout" type="checkbox" onClick="this.value=checkCreateur(this.form.createur)";"/>
						</td>
					</tr>
					<tr>
						<td align="right" colspan="5">
							<input type="submit" value="OK">
						</td>
						</td>
					</tr>';
			echo '</table>';
		} else
		{
			echo 'Il n\'existe aucun utilisateur lié.<br/>';
		}
	}	
	
	// Même fonction qu'au dessus, pour modifier cette fois.
	function afficherModifierUtilisateurDroit ($collectionUtilDroit, $collectionUtil, $tabUtilDroit, $nombreElement)
	{
		if ($collectionUtil->count() != 0)
		{
			// On place le curseur de la collection au début
			$collectionUtil->rewind();
			
			echo '<table border="1">
					<span class="titreTableau">Liste des Utilisateurs</span>
					<tr>
						<th>Prenom</th><th>Nom</th><th>Mail</th>
						<th><font color="red">Droit*</font></th><th><font color="red">Créateur**</font></th>
					</tr>';		
					
			// On fait une boucle tant que l'objet suivant est un valide
			while ($collectionUtil->valid()) 
			{

				// Récupération des données de chaque élément de la collection	
				$nom = $collectionUtil->current()->getNomUtil();
				$prenom = $collectionUtil->current()->getPrenomUtil();
				$mail = $collectionUtil->current()->getMailUtil ();
				$telBureauUtil = $collectionUtil->current()->getTelBureauUtil ();
				$dateDerniereCo = $collectionUtil->current()->getDateDerniereConnexionUtil ();
				$num = $collectionUtil->current()->getNumeroUtil();
				
				// On charge le numéro des utilisateurs possédants les droits pour vérifier si le numéro correspond
				$collectionUtilDroit->rewind();
				while ($collectionUtilDroit->valid()) 
				{
					$numDroit = $collectionUtilDroit->current()->getNumeroUtil();
					
					if ($numDroit == $num) 
					{
						// Utilisateur commun aux deux collections.
						for ($i = 0; $i < $nombreElement; $i++)
						{
							if ($tabUtilDroit[0][$i] == $num)
							{
								// Si l'idUtil du tableau est le même que l'identifiant commun,
								// On insère le droit dans une variable.
								$droitUtil = $tabUtilDroit[1][$i];
							}
						}
					}
					$collectionUtilDroit->next();
				}

				echo '	<tr>
							<td align="center">'.$nom.'</td><td align="center">'.$prenom.'</td>
							<td align="center">'.$mail.'</td>';
				
				if ($droitUtil == 1)
				{
					echo '	<td align="right"><input id="droit" checked="checked" type="checkbox" name="check'.$num.'" value=1></td>';
					echo '	<td align="right"><input id="createur" type="checkbox" name="createur'.$num.'" value=2></td>';
				}
				else if ($droitUtil == 2)
				{
					echo '	<td align="right"><input id="droit" type="checkbox" name="check'.$num.'" value=1></td>';
					echo '	<td align="right"><input id="createur" checked="checked" type="checkbox" name="createur'.$num.'" value=2></td>';
				} else
				{
					echo '	<td align="right"><input id="droit" type="checkbox" name="check'.$num.'" value=1></td>';
					echo '	<td align="right"><input id="createur" type="checkbox" name="createur'.$num.'" value=2></td>';
				}
				echo'	</tr>';	
				
				// On passe à l'objet suivant
				// On supprime la variable droitUtil
				unset ($droitUtil);
				$collectionUtil->next();
			}
			echo '	<tr>
					<td colspan="2">
					</td>
					<td align="right">
						Tout cocher\Tout décocher 
					</td>
					<td align="right">
						<input name="tout" type="checkbox" onClick="this.value=checkDroit(this.form.droit)";"/>
					</td>
					<td align="right">
						<input name="tout" type="checkbox" onClick="this.value=checkCreateur(this.form.createur)";"/>
					</td>
					</tr>
					<tr>
						<td align="right" colspan="5">
							<input type="submit" value="OK">
						</td>
						</td>
					</tr>';
			echo '</table>';
		} else
		{
			echo 'Il n\'existe aucun utilisateur lié.<br/>';
		}
	}
	
	// Affiche la collection de société passée en paramètre
	function afficherSociete ($collectionSociete)
	{
		if ($collectionSociete->count() != 0)
		{
			echo '<table border="1">
					<span class="titreTableau">Liste des Societes</span>
					<tr>
						<th>Nom</th><th>Adresse</th><th>Ville</th>
						<th>Code Postal</th><th>Mail</th><th>Pays</th>
					</tr>';	
			$collectionSociete->rewind();
			while ($collectionSociete->valid()) 
			{	
				$nom = $collectionSociete->current()->getNomSociete();
				$adresse = $collectionSociete->current()->getAdresseSociete();
				$ville = $collectionSociete->current()->getVilleSociete();
				$CP = $collectionSociete->current()->getCodePostalSociete();
				$mail = $collectionSociete->current()->getMailSociete();
				$pays = $collectionSociete->current()->getPays();
				
				//$num = $collectionSociete->current()->getNumeroSociete();
				
				echo '<tr>
						<td>'.$nom.'</td><td>'.$adresse.'</td><td>'.$ville.'</td><td>'.$CP.'</td><td>'.$mail.'</td><td>'.$pays.'</td>
					</tr>';				
				
				$collectionSociete->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'y a aucune société liée.<br/>';
		}
	}
	
// Affiche la collection de document passée en paramètre
	function afficherDocument ($collectionDocument) 
	{
		if ($collectionDocument->count() != 0)
		{
			$collectionDocument->rewind();
			
			echo '<table border="1">
					<span class="titreTableau">Liste des Documents</span>
					<tr>
						<th>Identifiant</th><th>Nom</th><th>Nom du fichier</th><th>Module</th><th>Description</th><th>Type</th><th>Action</th>
					</tr>';
			while ($collectionDocument->valid())
			{
				$num = $collectionDocument->current()->getNumeroDocument();
				$nom = $collectionDocument->current()->getNomDocument();
				$nomfichier = $collectionDocument->current()->getNomFichier();
				$module = $collectionDocument->current()->getModuleDocument();
				$description = $collectionDocument->current()->getDescriptionDocument();
				$type = $collectionDocument->current()->getCategorieDocument();
				echo '<tr>
						<td>'.$num.'</td><td>'.$nom.'</td><td>'.$nomfichier.'</td>
						<td>'.$module.'</td><td>'.$description.'</td><td>'.$type.'</td><td align="center"><a href="dossier_ouverture_document.php?&nomFichier='.$nomfichier.'" target="body" title="Ouvrir le document"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/dossierLoupe2.png"></a></td>
					</tr>';
				
				$collectionDocument->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'y a aucun document lié.<br/>';
		}
	}
	
// Affiche la collection de dossier passée en paramètre
	function afficherDossier($collectionDossier)
	{
		if ($collectionDossier->count() != 0)
		{
			$collectionDossier->rewind();
			echo '<table border="1">
					<span class="titreTableau">Liste des Dossiers</span>
					<tr>
						<th>&nbsp;Id&nbsp;</th><th>&nbsp;Libell&eacute;&nbsp;</th><th>&nbsp;Description&nbsp;</th>
					</tr>';
			while ($collectionDossier->valid())
			{
				$num = $collectionDossier->current()->getNumeroDossier();
				$libelle = $collectionDossier->current()->getLibelleDossier();	
				$description = $collectionDossier->current()->getDescriptionDossier();	
				echo '<tr>
						<td align = \"left\">&nbsp;'.$num.'&nbsp;</td><td>&nbsp;'.$libelle.'&nbsp;</td><td>&nbsp;'.$description.'&nbsp;</td>
					</tr>';		
				$collectionDossier->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'y a aucun dossier lié.<br/>';
		}
	}	
	
	// Afficher les dossiers à supprimer
	function afficherDossierSuppression($collectionDossier)
	{
		if ($collectionDossier->count() != 0)
		{
			$collectionDossier->rewind();
			echo '<ul>';
			while ($collectionDossier->valid())
			{
				$num = $collectionDossier->current()->getNumeroDossier();
				$libelle = $collectionDossier->current()->getLibelleDossier();

				echo '	<li>
							<a href="dossier_suppression.php?&verif=1&num='.$num.'&libelle='.$libelle.'" title="Cliquez pour supprimer">
							'.$libelle.'
							</a>
						</li>';
				
				$collectionDossier->next();
			}
			echo '</ul>';
		} else
		{
			echo 'Il n\'y a aucun dossier que vous pouvez supprimer.<br/>';
		}
	}	
	
	// Afficher les dossiers à supprimer
	function afficherDossierModifDroit($collectionDossier)
	{
		if ($collectionDossier->count() != 0)
		{
			$collectionDossier->rewind();
			echo '<ul>';
			while ($collectionDossier->valid())
			{
				$num = $collectionDossier->current()->getNumeroDossier();
				$libelle = $collectionDossier->current()->getLibelleDossier();
				
				echo '	<li>
							<a href="dossier_modification_droit.php?&num='.$num.'&libelle='.$libelle.'" title="Cliquez pour modifier">
							'.$libelle.'
							</a>
						</li>';
				
				$collectionDossier->next();
			}
			echo '</ul>';
		} else
		{
			echo 'Il n\'y a aucun dossier à modifier.<br/>';
		}
	}
	
	// Afficher les dossiers à supprimer
	function afficherDossierModifDossier($collectionDossier)
	{
		if ($collectionDossier->count() != 0)
		{
			$collectionDossier->rewind();
			echo '<ul>';
			while ($collectionDossier->valid())
			{
				$num = $collectionDossier->current()->getNumeroDossier();
				$libelle = $collectionDossier->current()->getLibelleDossier();
				$description = $collectionDossier->current()->getDescriptionDossier();
				
				echo '	<li>
							<a href="dossier_modifier_dossier.php?&num='.$num.'&libelle='.$libelle.'&description='.$description.'" title="Cliquez pour modifier">
							'.$libelle.'
							</a>
						</li>';
				
				$collectionDossier->next();
			}
			echo '</ul>';
		} else
		{
			echo 'Il n\'y a aucun dossier à modifier.<br/>';
		}
	}
	
	
	// Affiche la collection de etablissement passée en paramètre
	function afficherEtablissement ($collectionEtablissement)
	{
		if ($collectionEtablissement->count() != 0)
		{
			$collectionEtablissement->rewind();
			echo '<table border="1">
					<span class="titreTableau">Liste des Etablissements</span>
					<tr>
						<th>Nom</th><th>Type</th><th>Public Prive</th>
						<th>Adresse</th><th>Ville</th><th>CP</th><th>Tel</th>
						<th>Mail</th><th>Fax</th><th>Type Etablissement</th>
					</tr>';
			while ($collectionEtablissement->valid())
			{
				$nomEtab = $collectionEtablissement->current()->getNomEtab();
				$typeEtab = $collectionEtablissement->current()->getTypeEtab();
				$pubPriEtab = $collectionEtablissement->current()->getPubPriEtab();
				$adresseEtab = $collectionEtablissement->current()->getAdresseEtab();
				$villeEtab = $collectionEtablissement->current()->getVilleEtab();
				$codePostalEtab = $collectionEtablissement->current()->getCodePostalEtab();
				$telEtab = $collectionEtablissement->current()->getTelEtab();
				$mailEtab = $collectionEtablissement->current()->getMailEtab();
				$faxEtab = $collectionEtablissement->current()->getFaxEtab();
				$typeEtabGen = $collectionEtablissement->current()->getTypeEtabGen();
				
				//$rne = $collectionEtablissement->current()->getRNE();
				
				echo '<tr>
						<td>'.$nomEtab.'</td><td>'.$typeEtab.'</td><td>'.$pubPriEtab.'</td>
						<td>'.$adresseEtab.'</td><td>'.$villeEtab.'</td>
						<td>'.$codePostalEtab.'</td><td>'.$telEtab.'</td><td>'.$mailEtab.'</td>
						<td>'.$faxEtab.'</td><td>'.$typeEtabGen.'</td>
					</tr>';		
				$collectionEtablissement->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'y a aucun etablissement lié.<br/>';
		}
	}

	// Affiche la collection de evenement passée en paramètre
	function afficherEvenement ($collectionEvenement)
	{
		if ($collectionEvenement->count() != 0)
		{
			$collectionEvenement->rewind();
			echo '<table border="1">
					<span class="titreTableau">Liste des Evenements</span>
					<tr>
						<th>&nbsp;Id&nbsp;</th><th>&nbsp;Libelle&nbsp;</th><th>&nbsp;Date&nbsp;</th>
						<th>&nbsp;horaire&nbsp;</th><th>&nbsp;Lieu&nbsp;</th><th>&nbsp;Remarques&nbsp;</th>
					</tr>';
			while ($collectionEvenement->valid())
			{
				$numeroEven = $collectionEvenement->current()->getNumeroEvenement();
				$libelle = $collectionEvenement->current()->getLibelleEvenement();
				$date = $collectionEvenement->current()->getDateEvenement();
				$horaire = $collectionEvenement->current()->getHoraireEvenement();
				$lieu = $collectionEvenement->current()->getLieuEvenement();
				$remarques = $collectionEvenement->current()->getRemarquesEvenement();
				
				
				echo '<tr>
						<td>&nbsp;'.$numeroEven.'&nbsp;</td><td>&nbsp;'.$libelle.'&nbsp;</td><td>&nbsp;'.$date.'&nbsp;</td>
						<td>&nbsp;'.$horaire.'&nbsp;</td><td>&nbsp;'.$lieu.'&nbsp;</td><td>&nbsp;'.$remarques.'&nbsp;</td>
					</tr>';		
				$collectionEvenement->next();
			}
			echo '</table>';
		} else
		{
			echo 'Il n\'y a aucun événement lié.<br/>';
		}
	}
	
	// Afficher le formulaire d'ajout d'un évenement lié à un dossier
	function afficherFormulaireEven ($nom)
	{
		$aujourdhui_jour = date('d');
		$aujourdhui_mois = date('m');
		$aujourdhui_annee = date('Y');
		
		$annee0 = $aujourdhui_annee-1;
		$nbr_annee_a_traiter = 6;
		$annee = $aujourdhui_annee;
		
		echo '<form method="post" action="dossier_ajout_element_script.php">
				<br/>
					<table border="1">
						<tr><td>Libelle : </td>	<td><input type="text" size = "35" name="libelleEven"></td></tr>
						<tr><td>Date : </td>
							<td>
							<select size="1" name="jour">
								<option selected value="'.$aujourdhui_jour.'">'.$aujourdhui_jour.'</option>';
								for ($i = 1; $i <= 31; $i++)
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
		echo '				</select>
							<select size="1" name="mois">
								<option selected value="'.$aujourdhui_mois.'">'.$aujourdhui_mois.'</option>';
								for ($j = 1; $j <= 12; $j++)
								{
									echo '<option value="'.$j.'">'.$j.'</option>';
								}
		echo '				</select>
							<select size="1" name="annee">';
								echo '<option selected value="'.$annee.'">'.$annee.'</option>';
								echo '<option value="'.$annee0 .'">'.$annee0.'</option>';
								for ($i = 1; $i <= $nbr_annee_a_traiter; $i++)
								{
									$annee_a_afficher = $annee+$i;
									echo '<option value="'.$annee_a_afficher.'">'.$annee_a_afficher.'</option>';
								}
		echo'					</select>
							</td>
						<tr><td>Horaire : </td>	<td><input type="text" name="horaireEven"></td></tr>
						<tr><td>Lieu : </td>	<td><input type="text" size = "35" name="lieuEven"></td></tr>
						<tr><td>Remarques : </td>	<td><textarea name="remarquesEven" cols = 40 rows = 5></textarea></td></tr>
					</table>
				<br/>
				<input type="hidden" name="choix" value="even">
				<input type="hidden" name="nom" value="'.$nom.'">
				<input type="submit" value="Continuer">
			</form>';
	}
	
	// Afficher le formulaire d'ajout d'un document lié à un dossier
	function afficherFormulaireDoc ($nom)
	{
		echo '	<form method="post" enctype="multipart/form-data" action="dossier_ajout_document_script.php">
					<br/>
					<table border="1">
						<tr><td>Libellé : </td>				<td><input type="text" name="libelleDoc"></td></tr>
						<tr><td>Module : </td>				<td><input type="text" name="moduleDoc"></td></tr>
						<tr><td>Description : </td>			<td><input type="text" name="descriptionDoc"></td></tr>
					</table>
					</li>
					<br/>
						<input type="file" name="file">
					<br/>
					<br/>
					<input type="hidden" name="choix" value="doc">
					<input type="hidden" name="nom" value="'.$nom.'">													
					<input type="submit" value="Continuer">
				</form>';
	}	
	
	// Afficher le formulaire de remplacement d'un document lié à un dossier
	function afficherFormulaireDocRemplacement ($nom)
	{
		echo '	<form method="post" enctype="multipart/form-data" action="dossier_remplacement_document_script.php">
					<br/>
						<input type="file" name="file">
					<br/>
					<br/>
					<input type="hidden" name="choix" value="doc">
					<input type="hidden" name="nom" value="'.$nom.'">													
					<input type="submit" value="Continuer">
				</form>';
	}

	// Afficher le formulaire d'ajout d'un établissement lié à un dossier
	function afficherFormulaireEtab ($nom, $listeEtab)
	{
		echo '	<form method="post" action="dossier_ajout_element_script.php">
					<br/>
					<table border="1">
						<tr><td>RNE de l\'établissement : </td>
						<td>
							<select name="rne">';
							foreach ($listeEtab as $val)
							{
								echo '<option value="'.$val.'">'.$val.'</option>';
							}
		echo'				</select>
						</td></tr>
					</table>
					<br/>
					<input type="hidden" name="choix" value="etab">
					<input type="hidden" name="nom" value="'.$nom.'">													
					<input type="submit" value="Continuer">					
				</form>';
	}	
	
	// Afficher le formulaire d'ajout d'une société liée à un dossier
	function afficherFormulaireSociete ($nom, $listeSoc)
	{
		echo '	<form method="post" action="dossier_ajout_element_script.php">
					<br/>
					<table border="1">
						<tr><td>
						Nom : <br/>
						<select name="nomSoc">';
							foreach ($listeSoc as $val)
							{
								echo '<option value="'.$val.'">'.$val.'</option>';
							}
		echo'			</select>
						</td></tr>
					</table>
					<br/>
					<input type="hidden" name="choix" value="soc">
					<input type="hidden" name="nom" value="'.$nom.'">													
					<input type="submit" value="Continuer">					
				</form>';
	}
	
	// Fonction pour afficher une liste de libellés d'evenements liés à un dossier
	function afficherNomSuppressionEven ($nom, $collectEven)
	{
		if ($collectEven->count() != 0)
		{
			$collectEven->rewind();
			echo '</br>';
			while ($collectEven->valid())
			{
				$numEven = $collectEven->current()->getNumeroEvenement();
				$libelle = $collectEven->current()->getLibelleEvenement();
				echo'	<li><a href="dossier_supprimer_element_script.php?&nom='.$nom.'&suppr=even&numEven='.$numEven.'" target="body">
							'.$libelle.'
							</a>
						</li>';	
				$collectEven->next();
			}
		} else
		{
			echo 'Il n\'y a aucun événement lié à ce dossier.';
		}
	}
	
	// Fonction pour afficher une liste de libellés d'établissements liés à un dossier
	function afficherNomSuppressionDoc ($nom, $collectDoc)
	{
		if ($collectDoc->count() != 0)
		{
			$collectDoc->rewind();
			echo '</br>';
			while ($collectDoc->valid())
			{
				$numDoc = $collectDoc->current()->getNumeroDocument ();
				$nomDoc = $collectDoc->current()->getNomDocument ();
				$nomFichier = $collectDoc->current()->getNomFichier ();
				echo'	<li>
							<a href="dossier_supprimer_document_script.php?&nomDossier='.$nom.'&compteur=0&nomDoc='.$nomDoc.'&numDoc='.$numDoc.'&nomFichier='.$nomFichier.'" target="body">
							'.$nomDoc.'
							</a>
						</li>';	
				$collectDoc->next();
			}
		} else
		{
			echo 'Il n\'y a aucun document lié à ce dossier.';
		}
		echo '<br/>';
	}	
	
	// Fonction pour afficher une liste de libelle de documents liés à un dossier
	function afficherNomSuppressionEtab ($nom, $collectEtab)
	{
		if ($collectEtab->count() != 0)
		{
			$collectEtab->rewind();
			echo '</br>';
			while ($collectEtab->valid())
			{
				$rne = $collectEtab->current()->getRNE();
				$nomEtab = $collectEtab->current()->getNomEtab();
				echo'	<li>
							<a href="dossier_supprimer_element_script.php?&nom='.$nom.'&suppr=etab&rne='.$rne.'" target="body">
							'.$rne.' - '.$nomEtab.'
							</a>
						</li>';	
				$collectEtab->next();
			}
		} else
		{
			echo 'Il n\'y a aucun établissement lié à ce dossier.';
		}
		echo '<br/>';
	}
	
	function afficherNomSuppressionSoc ($nom, $collectSoc)
	{
		if ($collectSoc->count() != 0)
		{
			$collectSoc->rewind();
			echo '</br>';
			while ($collectSoc->valid())
			{
				$numSoc = $collectSoc->current()->getNumeroSociete();
				$nomSoc = $collectSoc->current()->getNomSociete();
				echo'	<li>
							<a href="dossier_supprimer_element_script.php?&nom='.$nomSoc.'&suppr=soc&numSoc='.$numSoc.'" target="body">
							'.$nomSoc.'
							</a>
						</li>';	
				$collectSoc->next();
			}
		} else
		{
			echo 'Il n\'y a aucune société liée à ce dossier.';
		}
		echo '<br/>';	
	}
	
?>
