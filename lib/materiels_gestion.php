<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_materiels.png\" ALT = \"Titre\">";
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			include("../biblio/javascripts.php");
				//Récupération des variables pour faire fonctionner ce script
				$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
				$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
				$tri = $_GET['tri']; //Tri sur quelle colonne ?
				$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
				$indice = $_GET['indice']; //à partir de quelle page
				$rechercher = $_GET['rechercher']; //détail à rechercher
				$dans = $_GET['dans']; //dans quel champ il faut rechercher
				$etat = $_GET['etat']; //quel genre de matériel : tout, affecté, non affecté, perdu
				$affectation_materiel = $_GET['affectation_materiel']; //où le matériel a été affecté
				$origine_materiel = $_GET['origine_materiel']; //à qui appartient le matériel
				$lettre = $_GET['lettre'];
				$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériuel, ...
				$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un m&triel existant (modifier, changer affectation, ...
				$actions_structurelles = $_GET['actions_structurelles']; //On doit faire une action générale comme créer un nouveau matériel, ...
				$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$actions_courantes = "N";
					$actions_structurelles = "N";
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

				if(!isset($origine_materiel) || $origine_materiel == "")
				{
					$origine_materiel = $_SESSION['origine_materiel'];
				}
				else
				{
					$_SESSION['origine_materiel'] = $origine_materiel;
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

				//echo "<br><b>***materiels_gestion.php***</b>";
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
				echo "<br>action : $action";
				echo "<br>actions_courantes : $actions_courantes";
				echo "<br>actions_structurelles : $actions_structurelles";
				echo "<br>a_editer : $a_editer";
				echo "<br>a_faire : $a_faire";
				echo "<br>filtre : $filtre";
				echo "<br>etat : $etat";
				echo "<br>affectation_materiel : $affectation_materiel";
				echo "<br>origine_materiel : $origine_materiel";
				echo "<br>rechercher : $rechercher";
				echo "<br>dans : $dans";
				echo "<br>tri : $tri";
				echo "<br>indice : $indice";
				echo "<br>sense_tri : $sense_tri<br>";
				echo "<br>origine_gestion : $origine_gestion";
*/				
////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début du traitement des actions sur un matériel ///////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions_courantes == "O")
				{
					$id = $_GET['id'];
					//echo "<br>id : $id";
					switch ($a_faire)
					{
						case "afficher_fiche_materiel" :
							include ("materiels_gestion_affiche_fiche_materiel.inc.php");
							//echo "<h1>Afficher la fiche du matériel $id</h1>";
							//echo "<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=N&amp;indice=$indice\" target = \"body\"><h2>Retour à la liste</h2></A>";
							$affichage ="N";
						break; //ajout_materiel

						case "ajout_materiel" :
							echo "<h1>Ajout d'un article</h1>";
							include ("materiels_gestion_ajout_materiel.inc.php");
							$affichage ="N";
						break; //ajout_materiel

						case "enreg_materiel" :
							include ("materiels_gestion_enreg_materiel.inc.php");
						break; //ajout_materiel

						case "modif_materiel" :
							echo "<h1>Modification d'un article</h1>";
							include ("materiels_gestion_modifier_materiel.inc.php");
							$affichage ="N";
						break; //modif_materiel

						case "maj_materiel" :
							include ("materiels_gestion_maj_materiel.inc.php");
						break; //modif_materiel

						case "changer_affectation" :
							echo "<h1>Changement d'affectation d'un mat&eacute;riel</h1>";
							include ("materiels_gestion_changer_affectation.inc.php");
							$affichage ="N";
						break; //changer_affectation

						case "supprimer_materiel" :
							include ("materiels_gestion_supprimer_materiel.inc.php");
							$affichage ="N";
						break; //supprimer_materiel

						case "confirme_supprimer_materiel" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM materiels WHERE id =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>Le mat&eacute;riel a &eacute;t&eacute; supprim&eacute;e.<h2>";
							}
						break; //supprimer_materiel

						case "editer_materiel" :
							$requete_maj = "UPDATE materiels SET `a_editer` = '1' WHERE id = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								//echo "<h2>Mise &agrave; jour r&eacute;ussie</h2>";
							}
						break; //marquer l'enregistrement 'à éditer'

						case "pas_editer_materiel" :
							$requete_maj = "UPDATE materiels SET `a_editer` = '0' WHERE id = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								//echo "<h2>Mise &agrave; jour r&eacute;ussie</h2>";
							}
						break; //démarquer l'enregistrement 'à éditer'

						case "fiche_pret" :
							include ("materiels_gestion_fiche_pret.inc.php");
							$affichage ="N";
						break; //démarquer l'enregistrement 'à éditer'

						case "ma0_edition" :
							echo "<h1>Mise &agrave; z&eacute;ro du champ a_editer</h1>";
							echo "<FORM ACTION = \"materiels_gestion.php\" METHOD = \"GET\">";
								//echo "<h1>Confirmer la mise &agrave; z&eacute;ro du champ a_editer</h1>";
								echo "<br><INPUT TYPE = \"submit\" VALUE = \"Confirmer la mise &agrave; z&eacute;ro\" NAME = \"bouton_envoyer_modif\">";
								echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								//echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce mat&eacute;riel\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_materiel\" NAME = \"actions_courantes\">";
								//echo "&nbsp;&nbsp;<INPUT src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_ma0_edition\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
							echo "</FORM>";
							$affichage ="N";
						break; //démarquer l'enregistrement 'à éditer'

						case "confirme_ma0_edition" :
							$requete_ma0 = "UPDATE materiels SET `a_editer` = '0'";
							$result_ma0 = mysql_query($requete_ma0);
							if (!$result_ma0)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								//echo "<h2>Mise &agrave; jour r&eacute;ussie</h2>";
							}

						case "changer_etat" :
							$id_etat = $_GET['id_etat'];
							/*
							echo "<br />id_etat : $id_etat";
							echo "<br />id : $id";
							*/
							$requete_ce = "UPDATE materiels SET `id_etat` = '".$id_etat."' WHERE id='".$id."'";
							$result_ce = mysql_query($requete_ce);
							if (!$result_ce)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
						break; //changement d'etat
					} //Fin switch $a_faire
				} //Fin if actions_courantes == O
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des actions sur un matériel /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements pour l'affichage des enregistrements sélectionnés ///////
////////////////////////////////////////////////////////////////////////////////////////////
				switch ($origine_gestion)
				{
					case "filtre" :
						//echo "<br>on batti la requete de base";
						$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine
							WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ
							AND materiels.origine = materiels_origine.id_origine";
						//il faut ajouter le filtre pour l'état : (non)affecté, perdu
						switch ($etat)
						{
							case "0" : //tous les enregistrements
								$query_etat = " AND id_etat IN (5, 6)";
								$intitule_ajout = "dans la base";
								$intitule_ajout2 = "";
							break;
							case "1" : //articles demandés
								$query_etat = " AND id_etat = 1";
								$intitule_ajout = "demand&eacute;";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;demand&eacute;";
							break;
							case "2" : //articles commandé
								$query_etat = " AND id_etat = 2";
								$intitule_ajout = "command&eacute;";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;command&eacute;";
							break;
							case "3" : //articles livrés
								$query_etat = " AND id_etat = 3";
								$intitule_ajout = "livré";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;non&nbsp;affect&eacute;";
							break;
							case "4" : //articles en préparation
								$query_etat = " AND id_etat = 4";
								$intitule_ajout = "en préparation";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;non&nbsp;affect&eacute;";
							break;
							case "5" : //articles disponibles
								$query_etat = " AND id_etat = 5";
								$intitule_ajout = "non affectés";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;non&nbsp;affect&eacute;";
							break;
							case "6" : //articles affectés en interne
								$query_etat = " AND id_etat = 6";
								$intitule_ajout = "affect&eacute;s en interne";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;affect&eacute; en interne";
							break;
							case "6" : //articles 'perdus'
								$query_etat = " AND id_etat = 6";
								$intitule_ajout = "en panne";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;en panne";
							break;
							case "7" : //articles 'affecté à l'extérieur'
								$query_etat = " AND id_etat = 7";
								$intitule_ajout = "remis&eacute;";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;remis&eacute;";
							break;
							case "8" : //articles 'en prêt'
								$query_etat = " AND (id_etat = 8 OR type_affectation = 'ponctuelle') ";
								$intitule_ajout = "en pr&ecirc;t";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;remis&eacute;";
							break;
							case "9" : //articles 'en panne'
								$query_etat = " AND id_etat = 9";
								$intitule_ajout = "en panne";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;remis&eacute;";
							break;
							case "10" : //articles 'remisé'
								$query_etat = " AND id_etat = 10";
								$intitule_ajout = "remis&eacute;";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;remis&eacute;";
							break;
							case "11" : //articles 'perdus'
								$query_etat = " AND id_etat = 11";
								$intitule_ajout = "perdus";
								$intitule_ajout2 = "etat&nbsp;:&nbsp;perdu";
							break;
							case "12" : //enregistrements marqués 'à éditer'
								$query_etat = " AND a_editer = 1";
								$intitule_ajout = "&agrave; &eacute;diter";
								$intitule_ajout2 = "enregistrements &agrave; &eacute;diter";
							break;
						} //Fin switch etat
						if ($filtre == "T")
						{
								$intitule_tableau = "Tous les mat&eacute;riels";
						}
						elseif ($filtre == "affectation")
						{
							//On fixe l'intitulé du tableau
							$intitule_tableau = "affectation&nbsp;:&nbsp;".$affectation_materiel."&nbsp;";
							//il faut récupérer l'identifiant de la catégorie principal à partir du filtre en clair
							$requete_affectation = "SELECT * FROM materiels_affectations WHERE materiels_affectations.intitule_affectation = '".$affectation_materiel."';";
							$resultat_affectation = mysql_query($requete_affectation);
							$ligne_affectation = mysql_fetch_object($resultat_affectation);
							$id_affectation = $ligne_affectation->id_affectation;
							//On construit la requete de base pour la sélection
							$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine, materiels_affectations WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.affectation_materiel = materiels_affectations.id_affectation AND materiels.affectation_materiel = '".$id_affectation."' AND materiels.origine = materiels_origine.id_origine";
						}
						elseif ($filtre == "origine")
						{
							//On fixe l'intitulé du tableau
							$intitule_tableau = "propri&eacute;taire&nbsp;:&nbsp;".$origine_materiel."&nbsp;";
							//il faut récupérer l'identifiant de la catégorie principal à partir du filtre en clair
							$requete_origine = "SELECT * FROM materiels_origine WHERE materiels_origine.intitule_origine = '".$origine_materiel."';";
							$resultat_origine = mysql_query($requete_origine);
							$ligne_origine = mysql_fetch_object($resultat_origine);
							$id_origine = $ligne_origine->id_origine;
							//On construit la requete de base pour la sélection
							$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine, materiels_affectations WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.affectation_materiel = materiels_affectations.id_affectation AND materiels.origine = '".$id_origine."' AND materiels.origine = materiels_origine.id_origine";
						}
						else
						{
							//On fixe l'intitulé du tableau
							$intitule_tableau = "Type mat&eacute;riel&nbsp;:&nbsp;".$filtre."&nbsp;";
							//il faut récupérer l'identifiant de la catégorie principal à partir du filtre en clair
							$requete_categorie = "SELECT * FROM materiels_categories_principales WHERE materiels_categories_principales.intitule_cat_princ = '".$filtre."';";
							$resultat_categorie = mysql_query($requete_categorie);
							$ligne_categorie = mysql_fetch_object($resultat_categorie);
							$id_cat = $ligne_categorie->id_cat_princ;
							//On construit la requete de base pour la sélection
							$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.categorie_principale = '".$id_cat."' AND materiels.origine = materiels_origine.id_origine";
						}
					break; //case "filtre"
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
					case "rechercher" :
						if ($rechercher <>"")
						{
							switch ($dans)
							{
								case "ID" : 
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.id = '".$rechercher."'";
								break;

                				case "INT" : //dans denommination
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.denomination LIKE '%".$rechercher."%'";
				                break;

                				case "IDCDE" :
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.id_cde = '".$rechercher."'";
				                break;

                				case "NS" : //numéro de série
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.no_serie LIKE '%".$rechercher."%'";
				                break;

                				case "IDFCT" :
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.id_facture = '".$rechercher."'";
				                break;

                				case "ELARGI" : //dans champs no_serie, details_article, denommination
									$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND (materiels.denomination LIKE '%".$rechercher."%' OR materiels.no_serie LIKE '%".$rechercher."%' OR materiels.cle_install LIKE '%".$rechercher."%' OR materiels.details_article LIKE '%".$rechercher."%')";
				                break;
							} //Fin switch dans
						} //Fin if rechercher <>""
					break;
				} //Fin switch origine_gestion
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// On affiche si nous venons d'une sélection
				if ($affichage <> "N")
				{
					//On affiche un tableau avec les différentes options d'actions
					echo "<table>";
						echo "<colgroup>";
							echo "<col width=\"20%\">";
							echo "<col width=\"10%\">";
							echo "<col width=\"10%\">";
							echo "<col width=\"10%\">";
							echo "<col width=\"20%\">";
							echo "<col width=\"30%\">";
						echo "</colgroup>";
						echo "<tr>";
								if ($autorisation_gestion_materiels == 1) //Seul les personnes ayant le droit peuvent insérer un nouveau matériel
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
										echo "<FORM ACTION = \"materiels_gestion_commandes.php\" target = \"body\" METHOD = \"GET\">";
										//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"gestion des commandes\">";
										echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"gestion des commandes\" src=\"$chemin_theme_images/gestion_commandes.png\" ALT = \"GESTCDES\" title = \"gestion des commandes\">";
										echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<!--INPUT TYPE = \"hidden\" VALUE = \"action\" NAME = \"filtre\"-->
										<!--INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\"-->
										<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">";
										echo "</FORM>";

/*										echo "<FORM ACTION = \"materiels_gestion_factures.php\" target = \"body\" METHOD = \"GET\">";
										echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"gestion des factures\">
										<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<!--INPUT TYPE = \"hidden\" VALUE = \"action\" NAME = \"filtre\"-->
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
										echo "</FORM>";
*/									echo "</td>";

									echo "<td align = \"center\">";
										echo "<FORM ACTION = \"materiels_gestion.php\" target = \"_blank\" METHOD = \"GET\">";
										//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\">";
										echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\" src=\"$chemin_theme_images/fiche_pret.png\" ALT = \"EDITFICHE\" title = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\">";
										echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
										<INPUT TYPE = \"hidden\" VALUE = \"fiche_pret\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
										echo "</FORM>";
									echo "</td>";

									echo "<td align = \"center\">";
										echo "<FORM ACTION = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
										//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"mettre &agrave; 0 les &eacute;ditions\">";
										echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"mettre &agrave; 0 les &eacute;ditions\" src=\"$chemin_theme_images/fiche_pret_raz.png\" ALT = \"MAZ\" title = \"mettre &agrave; 0 les &eacute;ditions\">";
										echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
										<INPUT TYPE = \"hidden\" VALUE = \"ma0_edition\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
										echo "</FORM>";
									echo "</td>";
							    	echo "<td align = \"center\">";
										echo "<FORM ACTION = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
											echo "ajouter&nbsp;<select size=\"1\" name=\"a_faire\">";
												echo "<option value=\"ajout_materiel\">article</option>";
												//echo "<option value=\"ajout_commande\">commande</option>";
												//echo "<option value=\"ajout_facture\">facture</option>";
											echo "</SELECT>";

										echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \">>\">
										<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
										<!--INPUT TYPE = \"hidden\" VALUE = \"action\" NAME = \"filtre\"-->
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
										<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
										echo "</FORM>";
									echo "</td>";
								}
								else
								{
							    	echo "<td colspan = \"4\">&nbsp;</td>";
								}
					    	echo "<td>";
								echo "<FORM ACTION = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
						    		echo "Rechercher&nbsp;:&nbsp;<input type=\"text\" size = \"20\" name=\"rechercher\" />";
									echo "&nbsp;dans&nbsp;:&nbsp;";
									echo "<select size=\"1\" name=\"dans\">";
										echo "<option value=\"ID\">ID</option>";
										echo "<option value=\"INT\">INT</option>";
										echo "<option value=\"ELARGI\">TOUS</option>";
										if ($autorisation_gestion_materiels == 1) //Seul les personnes ayant le droit peuvent insérer un nouveau matériel
										{
											echo "<option value=\"NS\">S/N</option>";
											echo "<option value=\"IDCDE\">IDCDE</option>";
											echo "<option value=\"IDFCT\">IDFCT</option>";
										}
									echo "</SELECT>";
									echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \">>\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"rechercher\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
								echo "</FORM>";
							echo "</td>";
					    echo "</tr>";
					echo "</table>";
					//On détermine le complément de la requte pour le tri
					switch ($tri)
					{
						case "ID" :
							$query_tri = " ORDER BY materiels.id $sense_tri;";
						break;
							case "DEN" :
							$query_tri = " ORDER BY materiels.denomination $sense_tri;";
						break;
							case "CAT" :
							$query_tri = " ORDER BY materiels_categories_principales.intitule_cat_princ $sense_tri;";
						break;

						case "ORI" :
							$query_tri = " ORDER BY materiels_origine.intitule_origine $sense_tri;";
						break;

						default :
							$query_tri = " ORDER BY materiels.id DESC;";
						break;
					}
					//On compose la requte globale
					$query = $query_base.$query_etat.$query_tri;
					//echo "<br>query : $query<br>";
					$results = mysql_query($query);
					if(!$results)
					{
						echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
						//echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
						mysql_close();
						exit;
					}

				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
					//Affichage de l'entête du tableau
					echo "<h3>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h3>";
					//echo "<br>intitule_tableau : $intitule_tableau<br>";
					if ($filtre == "T")
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout;
					}
					else
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout2;
					}
					echo "
						<TABLE >
						<CAPTION>$intitule_tableau</CAPTION>
						<TR>
							<th nowrap>";
							if ($sense_tri =="asc")
							{
								echo "ID<A href=\"materiels_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "ID<A href=\"materiels_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th nowrap>";
							if ($sense_tri =="asc")
							{
								echo "INTITUL&Eacute;<A href=\"materiels_gestion.php?tri=DEN&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par société, ordre decroissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "INTITUL&Eacute;<A href=\"materiels_gestion.php?tri=DEN&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par société, ordre croissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th nowrap>";
							if ($sense_tri =="asc")
							{
								echo "Cat&eacute;gorie<A href=\"materiels_gestion.php?tri=CAT&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Cat&eacute;gorie<A href=\"materiels_gestion.php?tri=CAT&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
							}

							echo "</th>";
							echo "<th nowrap>";
							if ($sense_tri =="asc")
							{
								echo "propri&eacute;taire<A href=\"materiels_gestion.php?tri=ORI&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "propri&eacute;taire<A href=\"materiels_gestion.php?tri=ORI&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\">&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
							}

							echo "</th>";
/*							if (($filtre == "SALON_INT") OR ($filtre == "SALON_PART"))
							{
								echo "<th nowrap>TS</th>";
								echo "<th nowrap>Empl.</th>";
							}
*/							echo "<th nowrap>
								affectation
							</th>";
							echo "<th nowrap>
								stockage
							</th>";
							echo "<th nowrap>
								&eacute;tat
							</th>";
								echo "<th nowrap>ACTIONS</th>";
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
								echo "<A HREF = \"materiels_gestion.php?indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"page_a_cliquer\">1&nbsp;</A>";
							}
							//echo "<BR>indice : $indice<br>";
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								$par_navig++;
								if($par_navig=="41")
								{
									echo "<BR>";
									$par_navig=0;
				            	}
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
                					echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
				              	}
              					else
				              	{
                					echo "<A HREF = \"materiels_gestion.php?indice=".$nb."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"page_a_cliquer\">".$page."&nbsp;</A>";
				              	}
						     }
	
/*
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
									echo "<FONT COLOR = \"#000000\"><B><big>".$page."&nbsp;</big></B></FONT>";
								}
								else
								{
									echo "<A HREF = \"materiels_gestion.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
								}
							}
*/							$j = 0;
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
							$id = $ligne->id;
							$denomination = $ligne->denomination;
							$categorie = $ligne->intitule_cat_princ;
							$origine = $ligne->intitule_origine;
							$affectation_materiel = $ligne->affectation_materiel;
							$a_editer = $ligne->a_editer;
							$lieu_stockage = $ligne->lieu_stockage;
							$id_etat = $ligne->id_etat;
							$intitule_etat = $ligne->intitule_etat;
							//echo "<br>1 : id : $id - N° stand : $no_stand";
							
							//on recherche l'affectation
							$requete_affectation = "SELECT * FROM materiels_affectations WHERE materiels_affectations.id_affectation = '".$affectation_materiel."';";
							$resultat_affectation = mysql_query($requete_affectation);
							$ligne_affectation = mysql_fetch_object($resultat_affectation);
							$affectation = $ligne_affectation->intitule_affectation;
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($id <>"")
								{
									//echo "<br>2 : id : $id - N° stand : $no_stand";
									//on recherche l'affectation
									$requete_affectation = "SELECT * FROM materiels_affectations WHERE materiels_affectations.id_affectation = '".$affectation_materiel."';";
									$resultat_affectation = mysql_query($requete_affectation);
									$ligne_affectation = mysql_fetch_object($resultat_affectation);
									$affectation = $ligne_affectation->intitule_affectation;

									//on recherche l'intitulé du lieu de stockage
									$requete_stockage = "SELECT * FROM materiels_lieux_stockage WHERE id_lieu_stockage = '".$lieu_stockage."';";
									$result_stockage = mysql_query($requete_stockage);
									$ligne_stockage = mysql_fetch_object($result_stockage);
									$intitule_stockage = $ligne_stockage->intitule_lieu_stockage;
									
									//Traducion de l'id_etat en intitulé
									echo "<tr>";
									echo "<TD align = \"center\">";
									echo $id;
									echo "</TD>";
									echo "<TD>";
									echo $denomination;
									echo "</TD>";
									echo "<TD align=\"center\">";
									echo $categorie;
									echo "</TD>";
									echo "<TD align=\"center\">";
									echo $origine;
									echo "</TD>";
									echo "<TD align = \"center\">";
									if ($affectation == "aucune")
										{
											echo "&nbsp;";
										}
										else
										{
											echo $affectation;
										}
									
									echo "</TD>";
									echo "<TD align = \"center\">";
										if ($intitule_stockage <> "aucun")
										{
											echo $intitule_stockage;
										}
										else
										{
											echo "&nbsp;";
										}
									
									echo "</TD>";
									echo "<TD align = \"center\">";
									//il faut afficher les 11 états et permettre de les changer

									// on cherche d'abord l'intitulé
									$requete_intitule = "SELECT intitule_etat FROM materiels_etats WHERE id_etat = '".$id_etat."'";
									$resultat_intitule = mysql_query($requete_intitule);
									$ligne_intitule = mysql_fetch_object($resultat_intitule);
									$intitule_etat = $ligne_intitule->intitule_etat;
									
									if ($autorisation_gestion_materiels == 1)
									{
										//echo "$id_etat&nbsp;$intitule_etat<br>";
										if ($id_etat <> "1")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=1&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"demand&eacute;\">1&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"demand&eacute;\"><FONT COLOR = \"#000000\"><B><big>1&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "2")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=2&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"command&eacute;\">2&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"command&eacute;\"><FONT COLOR = \"#000000\"><B><big>2&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "3")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=3&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"livr&eacute;\">3&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"livr&eacute;\"><FONT COLOR = \"#000000\"><B><big>3&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "4")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=4&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"en pr&eacute;ration\">4&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"en pr&eacute;paration\"><FONT COLOR = \"#000000\"><B><big>4&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "5")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=5&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"disponible\">5&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"disponible\"><FONT COLOR = \"#000000\"><B><big>5&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "6")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=6&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"affect&eacute; en interne\">6&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"affect&eacute; en interne\"><FONT COLOR = \"#000000\"><B><big>6&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "7")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=7&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"affect&eacute; &agrave; l'ext&eacute;rieur\">7&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"affect&eacute; &agrave; l'ext&eacute;rieur\"><FONT COLOR = \"#000000\"><B><big>7&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "8")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=8&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"en pr&ecirc;t\">8&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"en pr&ecirc;t\"><FONT COLOR = \"#000000\"><B><big>8&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "9")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=9&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"en panne\">9&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"en panne\"><FONT COLOR = \"#000000\"><B><big>9&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "10")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=10&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"remis&eacute;\">10&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"remis&eacute;\"><FONT COLOR = \"#000000\"><B><big>10&nbsp;</big></B></FONT></a>";
										}
										if ($id_etat <> "11")
										{
											echo "<A href=\"materiels_gestion.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=11&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"perdu\">11&nbsp;</A>";
										}
										else
										{
											echo "<a title = \"perdu\"><FONT COLOR = \"#000000\"><B><big>11&nbsp;</big></B></FONT></a>";
										}
										echo "</TD>";
									}
									else
									{
										echo $intitule_etat;
									}
									echo "</TD>";
									//Les actions
									echo "<TD class = \"fond-actions\" nowrap>";
									echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=afficher_fiche_materiel&amp;id=$id&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"consulter\" border = \"0\"></A>";
									if ($autorisation_gestion_materiels == 1)
									{
										echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=modif_materiel&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"modifier\" border = \"0\"></A>";
										echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=changer_affectation&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiel_affectation.png\" ALT = \"changer d'affectation\" title=\"affecter\" border = \"0\"></A>";
										
										//On attente de la réalisation du script pour gérer les prêts de matériels
										/*
										if ($id_etat <> 8)
										{
											echo "<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=preter&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/pretable.png\" ALT = \"pr&ecirc;ter\" height=\"18px\" width=\"18px\" title=\"pr&ecirc;ter\"></A>";
										}
										else
										{
											echo "<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=preter&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/priorite_haute.png\" ALT = \"retourner\" height=\"18px\" width=\"18px\" title=\"retourner\"></A>";
										}
										*/
										if ($a_editer == "0")
										{
											echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=editer_materiel&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/pasimprimer.png\" ALT = \"d&eacute;marquer pour &eacute;dition\" title=\"marquer pour impression\" border = \"0\"></A>";
										}
										else
										{
											echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=pas_editer_materiel&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/imprimer.png\" ALT = \"&eacute;diter l'article\" title=\"d&eacute;marquer pour impression\" border = \"0\"></A>";
										}
										echo "&nbsp;<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=supprimer_materiel&amp;id=$id&amp;tri=$tri&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;origine_gestion=".$origine_gestion."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";
									}

/*
									//echo "<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></A>";
									//
									//echo "<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></A>";
						
									if (($_SESSION['droit'] == "Super Administrateur") OR ($res[21] == $_SESSION['nom']))
									{
										echo "<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></A>";	
									}
*/
									echo "</TD>";
									echo "</TR>";
								} //Fin id <> ""

								$ligne = mysql_fetch_object($results);
								$id = $ligne->id;
								$denomination = $ligne->denomination;
								$categorie = $ligne->intitule_cat_princ;
								$origine = $ligne->intitule_origine;
								$affectation_materiel = $ligne->affectation_materiel;
								$a_editer = $ligne->a_editer;
								$id_etat = $ligne->id_etat;
								$lieu_stockage = $ligne->lieu_stockage;
								$intitule_etat = $ligne->intitule_etat;
							}
							//Fermeture de la connexion à la BDD
							mysql_close();
					}
					else
					{
						echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"
?>
			</TABLE>
		</div>
	</body>
</html>
