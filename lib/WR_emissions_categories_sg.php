<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
/*
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><h2>$message_non_connecte1</h2></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
*/
?>
<!DOCTYPE html>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."WR_principal.css";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
				//Récupération des variables pour faire fonctionner ce script
				$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
				$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
				$tri = $_GET['tri']; //Tri sur quelle colonne ?
				$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
				$indice = $_GET['indice']; //à partir de quelle page
				//$rechercher = $_GET['rechercher']; //détail à rechercher
				//$etat = $_GET['etat']; //quel genre de matériel : tout, affecté, non affecté, perdu
				//$affectation_materiel = $_GET['affectation_materiel']; //où le matériel a été affecté
				//$lettre = $_GET['lettre'];
				//$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériuel, ...
				//$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un m&triel existant (modifier, changer affectation, ...
				$traitement = $_GET['traitement']; //Concerne les traitements globaux sur catégories, affectations, propriétaires
				$actions_structurelles = $_GET['actions_structurelles']; //On doit faire une action générale comme créer un nouveau matériel, ...
				$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$actions_courantes = "N";
				}

				$autorisation_gestion_materiels = verif_appartenance_groupe(8);
				//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où
				if(!isset($origine_gestion) || $origine_gestion == "")
				{
					$origine_gestion = $_SESSION['origine_gestion'];
				}
				else
				{
					$_SESSION['origine_gestion'] = $origine_gestion;
				}

				if(!isset($filtre) || $filtre == "")
				{
					$filtre = $_SESSION['filtre'];
				}
				else
				{
					$_SESSION['filtre'] = $filtre;
				}

				if(!isset($tri) || $tri == "")
				{
					$tri = $_SESSION['tri'];
				}
				else
				{
					$_SESSION['tri'] = $tri;
				}

				if(!isset($sense_tri) || $sense_tri == "")
				{
					$sense_tri = $_SESSION['sense_tri'];
				}
				else
				{
					$_SESSION['sense_tri'] = $sense_tri;
				}

				if(!isset($indice) || $indice == "")
				{
					$indice = $_SESSION['indice'];
				}
				else
				{
					$_SESSION['indice'] = $indice;
				}

				if(!isset($rechercher) || $rechercher == "")
				{
					$rechercher = $_SESSION['rechercher'];
				}
				else
				{
					$_SESSION['rechercher'] = $rechercher;
				}

				if(!isset($etat) || $etat == "")
				{
					$etat = $_SESSION['etat'];
				}
				else
				{
					$_SESSION['etat'] = $etat;
				}

				if(!isset($affectation_materiel) || $affectation_materiel == "")
				{
					$affectation_materiel = $_SESSION['affectation_materiel'];
				}
				else
				{
					$_SESSION['affectation_materiel'] = $affectation_materiel;
				}

				if(!isset($lettre) || $lettre == "")
				{
					$lettre = $_SESSION['lettre'];
				}
				else
				{
					$_SESSION['lettre'] = $lettre;
				}
				
				$_SESSION['origine'] = "materiels_gestion";
				
				
				$nb_par_page = 14; //Fixe le nombre de ligne qu'il faut afficher à l'écran

				//echo "<br><b>***materiels_gestion_structure.php***</b>";
				//echo "<br>bouton_envoyer_modif : $bouton_envoyer_modif";
				/*
				//Affectation des variables sessions pour contrôle et affichage
				$ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_filtre = $_SESSION['filtre'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
				echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
				echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - à rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
				echo "<br>origine_gestion : $origine_gestion";
				echo "<br>action : $action";
				echo "<br>actions_courantes : $actions_courantes";
				echo "<br>actions_structurelles : $actions_structurelles";
				echo "<br>a_faire : $a_faire";
				echo "<br>traitement : $traitement";
				echo "<br>filtre : $filtre";
				echo "<br>etat : $etat";
				echo "<br>affectation_materiel : $affectation_materiel";
				echo "<br>tri : $tri";
				echo "<br>sense_tri : $sense_tri<br>";
				*/
////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements des actions structurelles ///////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions_structurelles == "O")
				{
					//echo "<br>Je dois agir sur la structure...<br>";
					$id = $_GET['id'];
					//echo "<br>id : $id";
					switch ($a_faire)
					{
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Catégories //////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						case "ajout_cat_princ" :
							//echo "<br>ajouter_cat_princ";
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
								<fieldset>
								<legend>Saisie d'une nouvelle cat&eacute;gorie principale</legend>
									<p>
										<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
										<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
									</p>
									<p>";
									echo "<p>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la catégorie\"/>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"enreg_cat_princ\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
									</p>
								</fieldset>
							</form>";
							$affichage ="N";
						break; //ajout_cat_princ

						case "enreg_cat_princ" :
							$intitule = $_GET['intitule'];
							//echo "<br>enreg_cat_princ - intitule : $intitule";
							$requete_enreg = "INSERT INTO materiels_categories_principales (
							`intitule_cat_princ`
							)
							VALUES ('".$intitule."');";
							$result_enreg = mysql_query($requete_enreg);
							if (!$result_enreg)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>La nouvelle cat&eacute;gorie a bien &eacute;t&eacute; enregistr&eacute;e
								<br>pour la rendre disponible dans le menu, pensez &agrave; cliquer sur l'ic&ocirc;ne de la gestion mat&eacute;riel
								<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></h2>";
							}
						break; //enreg_cat_princ

						case "modifier_cat_princ" :
							//Il faut écupérer les champs de l'enregistrement courant
							$requete_cat_princ = "SELECT * FROM materiels_categories_principales WHERE id_cat_princ = '".$id."'";
							$result_cat_princ=mysql_query($requete_cat_princ);
							$num_rows = mysql_num_rows($result_cat_princ);
							$ligne_cat_princ = mysql_fetch_object($result_cat_princ);
							$id_cat_princ = $ligne_cat_princ->id_cat_princ;
							$intitule_cat_princ_a_modifier = $ligne_cat_princ->intitule_cat_princ;
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
							<fieldset>
							<legend>MODIFICATION</legend>
								<p>
									<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" VALUE = \"$intitule_cat_princ_a_modifier\"name=\"intitule\" />
								</p>
							</fieldset>
								<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"maj_cat_princ\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</form>";
							$affichage ="N";
						break; //modif_cat_princ

						case "maj_cat_princ" :
							$intitule = $_GET['intitule'];
							//echo "<br>id : $id - intitule : $intitule";
							$requete_maj = "UPDATE materiels_categories_principales SET intitule_cat_princ = '".$intitule."' WHERE id_cat_princ = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>La cat&eacute;gorie a bien &eacute;t&eacute; modifi&eacute;e</h2>";
							}
						break; //modif_cat_princ

						case "supprimer_cat_princ" :
							//On demande confirmation
							echo "<h1>Confirmer la suppression de la catégorie</h1>";
							$requete = "SELECT * FROM materiels_categories_principales WHERE id_cat_princ = '".$id."';";
							$resultat = mysql_query($requete);
							if(!$resultat)
							{
								echo "<br>Problème lors de la connexion à la base de données";
							}
							$ligne_extraite = mysql_fetch_object($resultat);
							$intitule = $ligne_extraite->intitule_cat_princ;
							$id_cat_princ = $ligne_extraite->id_cat_princ;
							echo "<FORM ACTION = \"materiels_gestion_structure.php\" METHOD = \"GET\">";
								echo "<h1>$id - $intitule</h1>";
								echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_cat_princ\" NAME = \"actions_structurelles\">";
								echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_cat_princ\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
							echo "</FORM>";
							$affichage ="N";
						break; //supprimer_cat_princ

						case "confirme_supprimer_cat_princ" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM materiels_categories_principales WHERE id_cat_princ =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e.<h2>";
							}
						break; //supprimer_cat_princ

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Affectations ////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						case "ajout_affectation" :
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
								<fieldset>
								<legend>Saisie d'une nouvelle affectation</legend>
									<p>
										<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
										<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
									</p>
									<p>";
										$requete_etat="SELECT DISTINCT intitule_etat,id_etat FROM materiels_etats ORDER BY intitule_etat";
										$result_etat=mysql_query($requete_etat);
										$num_rows = mysql_num_rows($result_etat);
										echo "<td class = \"etiquette\">";
										echo "<label for=\"form_intitule\">&Eacute;tat&nbsp;:&nbsp;</label>";
										echo "<select size=\"1\" name=\"id_etat\">";
										if (mysql_num_rows($result_etat))
										{
											echo "<option selected value=\"$id_etat\">$intitule_etat</option>";
											while ($ligne_etat_extrait=mysql_fetch_object($result_etat))
											{
												$intitule_etat_extrait=$ligne_etat_extrait->intitule_etat;
												$id_etat_extrait = $ligne_etat_extrait->id_etat;
												if ($intitule_etat_extrait <> $intitule_etat)
												{
													echo "<option value=\"$id_etat_extrait\">$intitule_etat_extrait</option>";
												}
											}
										}
										echo "</SELECT>
									</p>";
									echo "<p>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la catégorie\"/>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"enreg_affectation\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
										<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
									</p>
								</fieldset>
							</form>";
							$affichage ="N";
						break; //ajouter_affectation

						case "enreg_affectation" :
							$intitule = $_GET['intitule'];
							$id_etat = $_GET['id_etat'];
							//echo "<br>enreg_cat_princ - intitule : $intitule";
							$requete_enreg = "INSERT INTO materiels_affectations (
							`intitule_affectation`,`id_etat_affectation`
							)
							VALUES ('".$intitule."', '".$id_etat."');";
							$result_enreg = mysql_query($requete_enreg);
							if (!$result_enreg)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>La nouvelle affectation a bien &eacute;t&eacute; enregistr&eacute;e
								<br>pour la rendre disponible dans le menu, pensez &agrave; cliquer sur l'ic&ocirc;ne de la gestion mat&eacute;riel
								<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></h2>";
							}
						break; //enreg_affectation

						case "modifier_affectation" :
							//Il faut écupérer les champs de l'enregistrement courant
							$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id."'";
							$result_affectation=mysql_query($requete_affectation);
							$num_rows = mysql_num_rows($result_affectation);
							$ligne_affectation = mysql_fetch_object($result_affectation);
							$id_affectation = $ligne_affectation->id_affectation;
							$intitule_affectation_a_modifier = $ligne_affectation->intitule_affectation;
							$id_etat_affectation = $ligne_affectation->id_etat_affectation;
							
							//Il faut récupérer l'intitulé de l'état
							$requete_intitule_etat = "SELECT * FROM materiels_etats WHERE id_etat = '".$id_etat_affectation."'";
							$result_intitule_etat = mysql_query($requete_intitule_etat);
							$num_rows = mysql_num_rows($result_intitule_etat);
							$ligne_intitule_etat = mysql_fetch_object($result_intitule_etat);
							$intitule_etat = $ligne_intitule_etat->intitule_etat;
							
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
							<fieldset>
							<legend>MODIFICATION</legend>
								<p>
									<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" VALUE = \"$intitule_affectation_a_modifier\"name=\"intitule\" />
								</p>
								<p>";
									$requete_etat="SELECT DISTINCT intitule_etat,id_etat FROM materiels_etats ORDER BY intitule_etat";
									$result_etat=mysql_query($requete_etat);
									$num_rows = mysql_num_rows($result_etat);
									echo "<td class = \"etiquette\">";
									echo "<label for=\"form_intitule\">&Eacute;tat&nbsp;:&nbsp;</label>";
									echo "<select size=\"1\" name=\"id_etat\">";
									if (mysql_num_rows($result_etat))
									{
										echo "<option selected value=\"$id_etat_affectation\">$intitule_etat</option>";
										while ($ligne_etat_extrait=mysql_fetch_object($result_etat))
										{
											$intitule_etat_extrait=$ligne_etat_extrait->intitule_etat;
											$id_etat_extrait = $ligne_etat_extrait->id_etat;
											if ($intitule_etat_extrait <> $intitule_etat)
											{
												echo "<option value=\"$id_etat_extrait\">$intitule_etat_extrait</option>";
											}
										}
									}
									echo "</SELECT>
								</p>
							</fieldset>
								<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"maj_affectation\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</form>";
							$affichage ="N";
						break; //ajouter_affectation

						case "maj_affectation" :
							$intitule = $_GET['intitule'];
							$id_etat = $_GET['id_etat'];
							//echo "<br>id : $id - intitule : $intitule";
							$requete_maj = "UPDATE materiels_affectations SET intitule_affectation = '".$intitule."', id_etat_affectation = '".$id_etat."' WHERE id_affectation = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>L'affectation a bien &eacute;t&eacute; modifi&eacute;e</h2>";
							}
						break; //maj_affectation

						case "supprimer_affectation" :
							//On demande confirmation
							echo "<h1>Confirmer la suppression de l'affectation</h1>";
							$requete = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id."';";
							$resultat = mysql_query($requete);
							if(!$resultat)
							{
								echo "<br>Problème lors de la connexion à la base de données";
							}
							$ligne_extraite = mysql_fetch_object($resultat);
							$intitule = $ligne_extraite->intitule_affectation;
							$id_affectation = $ligne_extraite->id_affectation;
							echo "<FORM ACTION = \"materiels_gestion_structure.php\" METHOD = \"GET\">";
								echo "<h1>$id - $intitule</h1>";
								echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_cat_princ\" NAME = \"actions_structurelles\">";
								echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_affectation\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
							echo "</FORM>";
							$affichage ="N";
						break; //supprimer_affectation

						case "confirme_supprimer_affectation" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM materiels_affectations WHERE id_affectation =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>L'affectation a &eacute;t&eacute; supprim&eacute;e.<h2>";
							}
						break; //supprimer_affectation

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Propriétaires ///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						case "ajout_origine" :
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
								<fieldset>
								<legend>Saisie d'un nouveau propri&eacute;taire</legend>
									<p>
										<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
										<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
									</p>
									<p>";
									echo "<p>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la catégorie\"/>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"enreg_origine\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
										<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
									</p>
								</fieldset>
							</form>";
							$affichage ="N";
						break; //ajouter_origine

						case "enreg_origine" :
							$intitule = $_GET['intitule'];
							//echo "<br>enreg_cat_princ - intitule : $intitule";
							$requete_enreg = "INSERT INTO materiels_origine (
							`intitule_origine`
							)
							VALUES ('".$intitule."');";
							$result_enreg = mysql_query($requete_enreg);
							if (!$result_enreg)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>Le nouveau propri&eacute;taire a bien &eacute;t&eacute; enregistr&eacute;
								<br>pour la rendre disponible dans le menu, pensez &agrave; cliquer sur l'ic&ocirc;ne de la gestion mat&eacute;riel
								<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></h2>";
							}
						break; //enreg_origine

						case "modifier_origine" :
							//Il faut écupérer les champs de l'enregistrement courant
							$requete_origine = "SELECT * FROM materiels_origine WHERE id_origine = '".$id."'";
							$result_origine=mysql_query($requete_origine);
							$num_rows = mysql_num_rows($result_origine);
							$ligne_origine = mysql_fetch_object($result_origine);
							$id_origine = $ligne_origine->id_origine;
							$intitule_origine_a_modifier = $ligne_origine->intitule_origine;
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
							<fieldset>
							<legend>MODIFICATION</legend>
								<p>
									<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" VALUE = \"$intitule_origine_a_modifier\"name=\"intitule\" />
								</p>
							</fieldset>
								<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"maj_origine\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</form>";
							$affichage ="N";
						break; //ajouter_origine

						case "maj_origine" :
							$intitule = $_GET['intitule'];
							//echo "<br>id : $id - intitule : $intitule";
							$requete_maj = "UPDATE materiels_origine SET intitule_origine = '".$intitule."' WHERE id_origine = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>Le propri&eacute;taire a bien &eacute;t&eacute; modifi&eacute;</h2>";
							}
						break; //maj_origine

						case "supprimer_origine" :
							//On demande confirmation
							echo "<h1>Confirmer la suppression du propri&eacute;taire</h1>";
							$requete = "SELECT * FROM materiels_origine WHERE id_origine = '".$id."';";
							$resultat = mysql_query($requete);
							if(!$resultat)
							{
								echo "<br>Problème lors de la connexion à la base de données";
							}
							$ligne_extraite = mysql_fetch_object($resultat);
							$intitule = $ligne_extraite->intitule_origine;
							$id_origine = $ligne_extraite->id_origine;
							echo "<FORM ACTION = \"materiels_gestion_structure.php\" METHOD = \"GET\">";
								echo "<h1>$id - $intitule</h1>";
								echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_cat_princ\" NAME = \"actions_structurelles\">";
								echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_origine\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
							echo "</FORM>";
							$affichage ="N";
						break; //supprimer_origine

						case "confirme_supprimer_origine" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM materiels_origine WHERE id_origine =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>Le propri&eacute;taire a &eacute;t&eacute; supprim&eacute;.<h2>";
							}
						break; //supprimer_origine

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Lieux de stockage ///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						case "ajout_stockage" :
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
								<fieldset>
								<legend>Saisie d'un nouveau lieu de stockage</legend>
									<p>
										<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
										<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
									</p>
									<p>";
									echo "<p>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer le lieu de stockage\"/>
										<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"enreg_stockage\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
										<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
									</p>
								</fieldset>
							</form>";
							$affichage ="N";
						break; //ajouter_stockage

						case "enreg_stockage" :
							$intitule = $_GET['intitule'];
							//echo "<br>enreg_cat_princ - intitule : $intitule";
							$requete_enreg = "INSERT INTO materiels_lieux_stockage (
							`intitule_lieu_stockage`
							)
							VALUES ('".$intitule."');";
							$result_enreg = mysql_query($requete_enreg);
							if (!$result_enreg)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>Le nouveau lieu de stockage a bien &eacute;t&eacute; enregistr&eacute;
								<br>pour la rendre disponible dans le menu, pensez &agrave; cliquer sur l'ic&ocirc;ne de la gestion mat&eacute;riel
								<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></h2>";
							}
						break; //enreg_stockage

						case "modifier_stockage" :
							//echo "<br />id : $id";
							//Il faut écupérer les champs de l'enregistrement courant
							$requete_stockage = "SELECT * FROM materiels_lieux_stockage WHERE id_lieu_stockage = '".$id."'";
							$result_stockage=mysql_query($requete_stockage);
							$num_rows = mysql_num_rows($result_stockage);
							$ligne_stockage = mysql_fetch_object($result_stockage);
							$id_lieu_stockage = $ligne_origine->id_lieu_stockage;
							$intitule_lieu_stockage_a_modifier = $ligne_stockage->intitule_lieu_stockage;
							echo "<form id=\"monForm\" action=\"materiels_gestion_structure.php\" method=\"get\">
							<fieldset>
							<legend>MODIFICATION</legend>
								<p>
									<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" VALUE = \"$intitule_lieu_stockage_a_modifier\"name=\"intitule\" />
								</p>
							</fieldset>
								<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"maj_stockage\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</form>";
							$affichage ="N";
						break; //modifier_stockage

						case "maj_stockage" :
							$intitule = $_GET['intitule'];
							//echo "<br>id : $id - intitule : $intitule";
							$requete_maj = "UPDATE materiels_lieux_stockage SET intitule_lieu_stockage = '".$intitule."' WHERE id_lieu_stockage = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>Le lieu de stockage a bien &eacute;t&eacute; modifi&eacute;</h2>";
							}
						break; //maj_stockage

						case "supprimer_stockage" :
							//On demande confirmation
							echo "<h1>Confirmer la suppression du lieu de stockage</h1>";
							$requete = "SELECT * FROM materiels_lieux_stockage WHERE id_lieu_stockage = '".$id."';";
							$resultat = mysql_query($requete);
							if(!$resultat)
							{
								echo "<br>Problème lors de la connexion à la base de données";
							}
							$ligne_extraite = mysql_fetch_object($resultat);
							$intitule = $ligne_extraite->intitule_lieu_stockage;
							$id_lieu_stockage = $ligne_extraite->id_lieu_stockage;
							echo "<FORM ACTION = \"materiels_gestion_structure.php\" METHOD = \"GET\">";
								echo "<h1>$id - $intitule</h1>";
								echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce lieu de stockaget\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_stockage\" NAME = \"actions_structurelles\">";
								echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_stockage\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
							echo "</FORM>";
							$affichage ="N";
						break; //supprimer_origine

						case "confirme_supprimer_stockage" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM materiels_lieux_stockage WHERE id_lieu_stockage =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>Le lieu de stockage a &eacute;t&eacute; supprim&eacute;.<h2>";
							}
						break; //supprimer_stockage
					} //Fin switch $a_faire
					//$affichage ="N";
				}

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des actions des actions structurelles ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements pour l'affichage des enregistrements sélectionnés ///////
////////////////////////////////////////////////////////////////////////////////////////////
						if ($traitement == "traitement_cat_princ")
						{
							$query = "SELECT * FROM materiels_categories_principales ORDER BY intitule_cat_princ";
						}
						elseif ($traitement == "traitement_affectation")
						{
							$query = "SELECT * FROM materiels_affectations ORDER BY intitule_affectation";
						}
						elseif ($traitement == "traitement_origine")
						{
							$query = "SELECT * FROM materiels_origine ORDER BY intitule_origine";
						}
						elseif ($traitement == "traitement_stockage")
						{
							$query = "SELECT * FROM materiels_lieux_stockage ORDER BY intitule_lieu_stockage";
						}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// On affiche si nous venons d'une sélection
				// Il y a 4 possibilités catégories, affectations, propriétaires, lieux de stockage
				if ($affichage <> "N")
				{
					echo "<table>";
						echo "<colgroup>";
							echo "<col width=\"20%\">";
							echo "<col width=\"20%\">";
							echo "<col width=\"15%\">";
							echo "<col width=\"15%\">";
							echo "<col width=\"35%\">";
						echo "</colgroup>";
						echo "<tr>";
								if ($autorisation_gestion_materiels == 1) //Seul les personnes ayant le droit peuvent insérer un nouveau mùatériel
								{
									echo "<td align = \"center\">";
										echo "<FORM ACTION = \"materiels_gestion_structure.php\" target = \"body\" METHOD = \"GET\">";
											echo "g&eacute;rer les&nbsp;<select size=\"1\" name=\"traitement\">";
												echo "<option value=\"traitement_cat_princ\">cat&eacute;gories</option>";
												echo "<option value=\"traitement_affectation\">affectations</option>";
												echo "<option value=\"traitement_origine\">propri&eacute;taires</option>";
												echo "<option value=\"traitement_stockage\">lieux de stockage</option>";
											echo "</SELECT>";

										echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \">>\">
										<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<!--INPUT TYPE = \"hidden\" VALUE = \"action\" NAME = \"filtre\"-->
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
										echo "</FORM>";
									echo "</td>";
							    	echo "<td align = \"center\">";
							    	if ($traitement == "traitement_cat_princ")
									{
										echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=ajout_cat_princ&amp;traitement=$traitement\">Ajout cat&eacute;gorie</A>";
									}
									elseif ($traitement == "traitement_affectation")
									{
										echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=ajout_affectation&amp;traitement=$traitement\">Ajout affectation</A>";
									}
									elseif ($traitement == "traitement_origine")
									{
										echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=ajout_origine&amp;traitement=$traitement\">Ajout propri&eacute;taire</A>";
									}
									elseif ($traitement == "traitement_stockage")
									{
										echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=ajout_stockage&amp;traitement=$traitement\">Ajout lieu de stockage</A>";
									}
									echo "</td>";
								}
								else
								{
							    	echo "<td>&nbsp;</td>";
							    	echo "<td>&nbsp;</td>";
								}
					    	echo "<td>&nbsp;</td>";
					    	echo "<td>&nbsp;</td>";
					    	echo "<td>";
/*								echo "<FORM ACTION = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
						    		echo "Rechercher&nbsp;<input type=\"text\" size = \"20\" name=\"rechercher\" />";
									echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
									echo "<select size=\"1\" name=\"dans\">";
										echo "<option value=\"ID\">ID</option>";
										echo "<option value=\"INT\">INT</option>";
									echo "</SELECT>";
									echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \">>\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"rechercher\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
								echo "</FORM>";
*/								echo "&nbsp;";
							echo "</td>";
					    echo "</tr>";
					echo "</table>";
					//On compose la requte globale
					//$query = $query_base.$query_etat.$query_tri;
					$results = mysql_query($query);
					if(!$results)
					{
						echo "<h2>Problème lors de la connexion à la base de données</h2>";
						echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
						mysql_close();
						exit;
					}

				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
					//Affichage de l'entête du tableau
					echo "<h3>Nombre d'enregistrements sélectionnés : $num_results</h3>";
					//echo "<br>intitule_tableau : $intitule_tableau<br>";
					if ($filtre == "T")
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout;
					}
					else
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout2;
					}
					echo "<TABLE>
						<CAPTION>$intitule_tableau</CAPTION>";
						echo "<TR>";
							echo "<Th>ID</th>";
							echo "<Th>INTITUL&Eacute;</th>";
							echo "<Th>ACTIONS</th>";
							//Requète pour afficher les établissements selon le filtre appliqué
							///////////////////////////////////
							//Partie sur la gestion des pages//
							///////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
							echo "Page&nbsp;";
							If ($indice == 0)
							{
								echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
							}
							else
							{
								echo "<A HREF = \"materiels_gestion_structure.php?indice=0&amp;traitement=$traitement\" target=\"body\" class=\"page_a_cliquer\">1&nbsp;</A>";
							}
							//echo "<BR>indice : $indice<br>";
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
									echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
								}
								else
								{
									echo "<A HREF = \"materiels_gestion_structure.php?indice=".$nb."&amp;traitement=$traitement\" target=\"body\" class=\"page_a_cliquer\">".$page."&nbsp;</A>";
								}
							}
							$j = 0;
							while($j<$indice) //on se potionne sur la bonne page suivant la valeur de l'index
							{
								$res = mysql_fetch_row($results);
								++$j;
							}
							/////////////////////////
							//Fin gestion des pages//
							/////////////////////////
						
							//Traitement de chaque ligne
							$ligne = mysql_fetch_object($results);
							if ($traitement == "traitement_cat_princ")
							{
								$id = $ligne->id_cat_princ;
								$intitule = $ligne->intitule_cat_princ;
							}
							elseif ($traitement == "traitement_affectation")
							{
								$id = $ligne->id_affectation;
								$intitule = $ligne->intitule_affectation;
							}
							elseif ($traitement == "traitement_origine")
							{
								$id = $ligne->id_origine;
								$intitule = $ligne->intitule_origine;
							}
							elseif ($traitement == "traitement_stockage")
							{
								$id = $ligne->id_lieu_stockage;
								$intitule = $ligne->intitule_lieu_stockage;
							}
							//echo "<br>1 : id_cat_princ : $id_cat_princ - intitule_cat_princ : $intitule_cat_princ";
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($id <>"")
								{
									//echo "<br>2 : id : $id - N° stand : $no_stand";
									//on recherche l'affectation
									echo "<tr>";
										echo "<TD align = \"center\">$id</TD>";
										echo "<TD>$intitule</TD>";
									//Les actions
									echo "<td nowrap class = \"fond-actions\">";
									if ($autorisation_gestion_materiels == 1)
									{
										if ($traitement == "traitement_cat_princ")
										{
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=modifier_cat_princ&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=supprimer_cat_princ&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le mat&eacute;riel\"></A>";
										}
										elseif ($traitement == "traitement_affectation")
										{
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=modifier_affectation&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=supprimer_affectation&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le mat&eacute;riel\"></A>";
										}
										elseif ($traitement == "traitement_origine")
										{
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=modifier_origine&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=supprimer_origine&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le mat&eacute;riel\"></A>";
										}
										elseif ($traitement == "traitement_stockage")
										{
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=modifier_stockage&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
											echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=supprimer_stockage&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le lieu de stockage\"></A>";
										}
									}

									echo "</TD>";
									echo "</TR>";
								} //Fin id <> ""

								$ligne = mysql_fetch_object($results);
								if ($traitement == "traitement_cat_princ")
								{
									$id = $ligne->id_cat_princ;
									$intitule = $ligne->intitule_cat_princ;
								}
								elseif ($traitement == "traitement_affectation")
								{
									$id = $ligne->id_affectation;
									$intitule = $ligne->intitule_affectation;
								}
								elseif ($traitement == "traitement_origine")
								{
									$id = $ligne->id_origine;
									$intitule = $ligne->intitule_origine;
								}
								elseif ($traitement == "traitement_stockage")
								{
									$id = $ligne->id_lieu_stockage;
									$intitule = $ligne->intitule_lieu_stockage;
								}
							}
							//Fermeture de la connexion à la BDD
							mysql_close();
					}
					else
					{
						echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"
?>
			</TABLE>
		</CENTER>
	</body>
</html>
