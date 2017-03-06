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

	$id_util = $_SESSION['id_util'];
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	//$chemin_images_theme = $_SESSION['chemin_images_theme'];
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//echo "<br />chemin_images_theme : $chemin_images_theme";

	include ("../biblio/config.php");
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../biblio/view.js\"></script>
		<script type=\"text/javascript\" src=\"../biblio/calendar.js\"></script>
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";


	echo "</head>";
	echo "<body>
		<div align =\"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_gestion_taches.png\" ALT = \"Titre\">";
			//include("../biblio/ticket.css");
			//include ("../biblio/config.php");
			include ("../biblio/init.php");

			echo "<h2>Suivi des t&acirc;ches</h2>";

				//On ins&egrave;re la barre de filtrage directement dans la page
				include("taches_head.php");
				echo "<br />";
				//R&eacute;cup&eacute;ration des variables pour faire fonctionner ce script
				$id_util = $_SESSION['id_util'];
				$id_util_filtre = $_GET['id_util_filtre']; //transmis ) partir du bandeau pour afficher les t�ches des autres utilisateurs
				$origine_appel = $_GET['origine_appel']; //du cadre, filtre de l'ent�te ou recherche de l'ent�te
				$categorie_filtre = $_GET['categorie_filtre']; //filtrage sur les cat&eacute;gories
				$tri = $_GET['tri']; //Tri sur quelle colonne ?
				$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
				$indice = $_GET['indice']; //&agrave; partir de quelle page
				$rechercher = $_GET['rechercher']; //d&eacute;tail &agrave; rechercher
				$controle_entete =$_GET['controle_entete']; //Pour savoir si on arrive r&eacute;ellement du bandeau
				$type_affichage = $_GET['type_affichage']; //Soit sous forme de liste, soit par c&eacute;t&eacute;gories
				$etat_filtre = $_GET['etat_filtre']; //quel genre de t�che : toutes, nouvelles, en cours, achev&eacute;es
				$visibilite_filtre = $_GET['visibilite_filtre']; //PU ou PR
				$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un m&triel existant (modifier, changer affectation, ...
				$affiche_barrees = $_GET['affiche_barrees']; //Pour savoir si on affiche les t�ches achev&eacute;es et non encore supprim&eacute;es

				if (($etat_filtre == "3") OR ($etat_filtre == "%"))
				{
					$affiche_barrees = 'O';
				}

/*				echo "<br />affiche_barrees_transmis : $affiche_barrees";
				echo "<br />&Eacute;tape 1 :</BR>";
				echo "<br />a_faire : $a_faire";
				echo "<br />actions_courantes : $actions_courantes";
				echo "<br />categorie_filtre : $categorie_filtre";
				echo "<br />etat_filtre : $etat_filtre";
				echo "<br />visibilite_filtre : $visibilite_filtre";
				echo "<br />rechercher : $rechercher";
				echo "<br /></BR>";
*/
				if ($affiche_barrees =="")
				{
					$affiche_barrees = 'O';
				}
				$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$actions_courantes = "N";
					$actions_structurelles = "N";
				}

				//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe o�
				if(!isset($origine_appel) || $origine_appel == "")
				{
					$origine_appel = $_SESSION['origine_appel'];
				}
				else
				{
					$_SESSION['origine_appel'] = $origine_appel;
				}

				if(!isset($type_affichage) || $type_affichage == "")
				{
					$type_affichage = $_SESSION['type_affichage'];
				}
				else
				{
					$_SESSION['type_affichage'] = $type_affichage;
				}

				if(!isset($categorie_filtre) || $categorie_filtre == "")
				{
					$categorie_filtre = $_SESSION['categorie_filtre'];
				}
				else
				{
					$_SESSION['categorie_filtre'] = $categorie_filtre;
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

				if ((($origine_appel == "entete") AND ($controle_entete == "O")) OR ($origine_appel == "entete_util"))//Si l'appel se fait &agrave; partir du bandeau, il faut pouvoir vider la variable rechercher
				{
					$_SESSION['rechercher'] = $rechercher;
				}
				else
				{
					$rechercher = $_SESSION['rechercher'];
				}

				if(!isset($etat_filtre) || $etat_filtre == "")
				{
					$etat_filtre = $_SESSION['etat_filtre'];
				}
				else
				{
					$_SESSION['etat_filtre'] = $etat_filtre;
				}


				if(!isset($visibilite_filtre) || $visibilite_filtre == "")
				{
					$visibilite_filtre = $_SESSION['visibilite_filtre'];
				}
				else
				{
					$_SESSION['visibilite_filtre'] = $visibilite_filtre;
				}

				$_SESSION['origine'] = "taches_gestion";

				//Inclusion des fichiers n&eacute;cessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");


				$nb_par_page = $nb_taches_par_page_taches; //Fixe le nombre de ligne qu'il faut afficher &agrave; l'&eacute;cran

				//echo "<br /><b>***materiels_gestion.php***</b>";
				//echo "<br />bouton_envoyer_modif : $bouton_envoyer_modif";
				/*
				//Affectation des variables sessions pour contr�le et affichage
				$ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_filtre = $_SESSION['filtre'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
				echo "<br />variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - &agrave; rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
				echo "<br />variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - &agrave; rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
				*/

////////////////////////////////////////////////////////////////////////////////////////////
//////////// D�but du traitement des actions sur une t�che /////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions_courantes == "O")
				{
					$id = $_GET['id'];
					//echo "<br />id : $id";
					switch ($a_faire)
					{
						case "afficher_tache" :
							echo "<h1>Fiche d'information pour la t&acirc;che $id</h1>";
							include ("taches_gestion_affiche_tache.inc.php");
							//echo "<h2>Disponible sous peu ...</h2>";
							//echo "<a href = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=N&amp;indice=$indice\" target = \"body\"><h2>Retour &agrave; la liste</h2></a>";
							$affichage ="N";
						break; //afficher_tache

						case "ajout_tache" :
							echo "<h1>Ajouter une t&acirc;che $id</h1>";
							include ("taches_gestion_ajout_tache.inc.php");
							$affichage ="N";
						break; //ajout_tache

						case "enreg_tache" :
							//echo "<h1>Enregistrer la t&acirc;che $id</h1>";
							include ("taches_gestion_enreg_tache.inc.php");
							//$affichage ="N";
						break; //ajout_tache

						case "modif_tache" :
							//echo "<h1>Modifier la t&acirc;che $id</h1>";
							//echo "<h2>Disponible sous peu ...</h2>";
							include ("taches_gestion_modif_tache.inc.php");
							$affichage ="N";
						break; //modif_tache

						case "maj_tache" :
							//echo "<h1>Mise &agrave; jour de la t&acirc;che $id</h1>";
							include ("taches_gestion_maj_tache.inc.php");
						break; //modif_tache

						case "partager_tache" :
							echo "<h1>Partager la t&acirc;che $id</h1>";
							echo "<h2>Disponible sous peu ...</h2>";
							//include ("taches_gestion_partager_tache.inc.php");
							//$affichage ="N";
						break; //changer_affectation

						case "achever_tache" :
							$requete_maj = "UPDATE taches SET `etat` = '3', priorite ='S' WHERE id_tache = '".$id."';";
							$result_maj = mysql_query($requete_maj);
						break; //achever_tache

						case "activer_tache" :
							//echo "<h1>Marquer la t&acirc;che $id comme achev&eacute;e</h1>";
							$requete_maj = "UPDATE taches SET `etat` = '1', priorite ='N' WHERE id_tache = '".$id."';";
							$result_maj = mysql_query($requete_maj);
						break; //supprimer_tache

						case "changer_priorite" :
							$priorite_a_changer = $_GET['priorite_a_changer'];
							$requete_maj = "UPDATE taches SET `priorite` = '".$priorite_a_changer."' WHERE id_tache = '".$id."';";
							$result_maj = mysql_query($requete_maj);
						break; //achever_tache

						case "supprimer_tache" :
							include ("taches_gestion_supprimer_tache.inc.php");
							$affichage ="N";
						break; //supprimer_tache

						case "confirme_supprimer_tache" :
							include ("taches_gestion_confirmer_supprimer_tache.inc.php");
						break; //supprimer_tache
					} //Fin switch $a_faire
				} //Fin if actions_courantes == O
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des actions sur un mat&eacute;riel /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////
//////////// Etablissement des requ�tes pour le filtrage des enregisrements ////////////////
////////////////////////////////////////////////////////////////////////////////////////////
/*				echo "<br />&Eacute;tape 2 :</BR>";
				echo "<br />id_util_filtre : $id_util_filtre";
				echo "<br />origine_appel : $origine_appel";
				echo "<br />type_affichage : $type_affichage";
				//echo "<br />action : $action";
				//echo "<br />actions_courantes : $actions_courantes";
				//echo "<br />a_faire : $a_faire";
				echo "<br />categorie_filtre : $categorie_filtre";
				echo "<br />etat_filtre : $etat_filtre";
				echo "<br />visibilite_filtre : $visibilite_filtre";
				echo "<br />rechercher : $rechercher";
				echo "<br />tri : $tri";
				echo "<br />sense_tri : $sense_tri";
				echo "<br />affiche_barrees : $affiche_barrees";
				echo "<br />";
*/
///////////////////////////////////////////////////////////////////////////////////////////////
////////////////// on r&eacute;cup&egrave;re le nombre de t�ches priv&eacute;es et partag&eacute;es ///////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
				//On r&eacute;cup&egrave;re les pr&eacute;f&eacute;rences des t�ches

				//echo "<br />id_util : $id_util";

				$util="SELECT * FROM preference WHERE ID_UTIL = $id_util;";
				$execution= mysql_query($util);
				$ligne = mysql_fetch_object($execution);
				$choix_type_tache_defaut = $ligne->choix_type_tache_defaut;

				//echo "<br />choix_type_tache_defaut : $choix_type_tache_defaut";


				$requete_nbr_taches_privees = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = $id_util AND visibilite = 'PR' AND etat <> '3'";
				$resultat_nbr_taches_privees = mysql_query($requete_nbr_taches_privees);
				$nbr_taches_privees = mysql_num_rows ($resultat_nbr_taches_privees);
				if (($nbr_taches_privees == "0") OR ($visibilite_filtre == 'PR'))
				{
					$message_taches_privees = "";
					$affiche_message_taches_privees = "N";
				}
				elseif ($nbr_taches_privees == "1")
				{
					$message_taches_privees = "une t&acirc;che priv&eacute;e";
					$affiche_message_taches_privees = "O";
				}
				else
				{
					$message_taches_privees = "$nbr_taches_privees t&acirc;ches priv&eacute;es";
					$affiche_message_taches_privees = "O";
				}
				//Composition du message complet
				if ($affiche_message_taches_privees == "N")
				{
					//$message_taches_complet = "Vous n'avez ni de t&acirc;ches priv&eacute;es, ni de t&acirc;ches partag&eacute;es";
					$message_taches_complet = "";
				}
				else
				{
					$message_taches_complet = "Vous avez &eacute;galement $message_taches_privees";
				}

///////////////////////////////////////////////////////////////////////////////////////////////
///////////////// on fixe l'intitul&eacute; du tableau ///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
				//echo "<br />recherche intitul&eacute;s des cat&eacute;gories";
				if (($categorie_filtre <> "%") AND ($categorie_filtre <> "S")) //% = tous ; S = sans
				{
					$requete_intitule = "SELECT intitule_categ FROM categorie_commune WHERE id_categ = '".$categorie_filtre."'";
					$resultat_intitule = mysql_query($requete_intitule);
					$ligne_intitule = mysql_fetch_object($resultat_intitule);
					$intitule_categorie = $ligne_intitule->intitule_categ;
				}
				elseif ($categorie_filtre == "%")
				{
					$intitule_categorie = "toutes";
				} //Fin else categorie_filtre <> %
				else
				{
					$intitule_categorie = "sans";
				}
				switch ($etat_filtre)
				{
					case "0" :
						$etat_a_afficher = "non achev&eacute;";
					break;
					case "1" :
						$etat_a_afficher = "nouveau";
					break;
					case "2" :
						$etat_a_afficher = "en cours";
					break;
					case "3" :
						$etat_a_afficher = "achev&eacute;";
					break;
					case "%" :
						$etat_a_afficher = "tout";
					break;
				} //Fin switch etat_filtre
				switch ($visibilite_filtre)
				{
					case "PU" :
						$visibilite_a_afficher = "public";
					break;
					case "PR" :
						$visibilite_a_afficher = "priv&eacute;";
					break;
					case "%" :
						$visibilite_a_afficher = "tout";
					break;
				} //Fin switch etat_filtre
				$intitule_tableau = "cat&eacute;gorie&nbsp;:&nbsp;<b>".$intitule_categorie."</b>&nbsp;-&nbsp;etat&nbsp;:&nbsp;<b>".$etat_a_afficher."</b>&nbsp;-&nbsp;visibilit&eacute;&nbsp;:&nbsp;<b>".$visibilite_a_afficher."</b>";

				// on construit la requete de base suivant si on arrive du cadre, de l'enqu�te et du corps de la page affich&eacute;e
				//echo "<br />origine_appel = $origine_appel";

				switch ($origine_appel)
				{
					case "cadre" :
						//on batti la requete de base
						//echo "<br />id_util : $id_util";
						if ($affiche_barrees == "O")
						{
							//$query_base = "SELECT * FROM taches WHERE (taches.id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite = 'PU'";
							$query_base = "
								SELECT DISINCT *

								FROM taches, taches_util

								WHERE taches.id_tache = taches_util.id_tache
									AND taches_util.id_util = '".$id_util."'
									AND visibilite = '".$choix_type_tache_defaut."'";

							// requ�te pour afficher aussi les t�ches partag&eacute;es (ne fonctionne pas en l'&eacute;tat
							//$query_base = "SELECT DISTINCT util.id_util, taches.id_tache FROM `taches`, taches_util,util WHERE ((taches.id_util_creation=1 OR taches.id_util_traitant = '".$id_util."') OR (taches_util.id_tache = '".$id_util."' AND taches_util.id_tache = taches.id_tache)) AND util.id_util = '".$id_util."' AND visibilite = 'PU'";
						}
						else
						{
							//echo "<br />switch origine_appel else";
							//$query_base = "SELECT * FROM taches WHERE (taches.id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite = 'PU' AND taches.etat <>'3'";
							//champ n&eacute;cessaires : taches_util.id_tache, date_creation, date_echeance, date_rappel, description, etat, visibilite, priorite, observation, id_util, statut
							$query_base = "
								SELECT DISTINCT *

								FROM taches, taches_util

								WHERE taches.id_tache = taches_util.id_tache
									AND id_util = '".$id_util."'
									AND visibilite = '".$choix_type_tache_defaut."'
									AND etat <>'3'";
						}

						//$intitule_tableau = "Toutes les t&acirc;ches";
					break; //case "cadre"

					case "entete" :
						if ($rechercher <> "") //Il faut ajouter les filtrer sur les champs sujet et observation
						{
							$query_recherche = " AND (description LIKE '%".$rechercher."%' OR observation LIKE '%".$rechercher."%')";
						}
						else
						{
							$query_recherche = "";
						}
						if ($etat_filtre == "0") //Il faut afficher les t�ches nouvelles et en cours
						{
							$query_etat = "AND (etat = '1' OR etat = '2') ";
						}
						else
						{
							$query_etat = "AND  etat LIKE '".$etat_filtre."'";
						}
						if (($categorie_filtre <> "%") AND ($categorie_filtre <> "S"))//il faut changer de requ�te car bas&eacute;e sur 2 tables (taches et taches_categories)
						{
							//$query_base = "SELECT * FROM taches, taches_categories, categorie_commune WHERE taches.id_tache = taches_categories.id_tache AND taches_categories.id_categorie = categorie_commune.id_categ AND categorie_commune.id_categ = '".$categorie_filtre."' AND (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite LIKE '".$visibilite_filtre."'";
							$query_base = "SELECT * FROM taches, taches_util, taches_categories, categorie_commune WHERE taches.id_tache = taches_categories.id_tache AND taches_categories.id_categorie = categorie_commune.id_categ AND taches.id_tache = taches_util.id_tache AND categorie_commune.id_categ = '".$categorie_filtre."' AND taches_util.id_util = '".$id_util."' AND visibilite LIKE '".$visibilite_filtre."'";
						} // Fin if categorie_filtre <> "%"
						elseif ($categorie_filtre == "%")
						{
							if ($affiche_barrees == "O")
							{
								//$query_base = "SELECT * FROM taches WHERE (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite LIKE '".$visibilite_filtre."'";
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND visibilite LIKE '".$visibilite_filtre."'";
							}
							else
							{
								//$query_base = "SELECT * FROM taches WHERE (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite LIKE '".$visibilite_filtre."' AND etat <>'3'";
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND visibilite LIKE '".$visibilite_filtre."' AND etat <>'3'";
							}
							//$query_base = $query_base.$query_etat;
						} //Fin else categorie_filtre <> "%"
						elseif ($categorie_filtre == "S")
						{
							if ($affiche_barrees == "O")
							{

								/*
								date_creation;
							$date_echeance = $ligne->;
							$etat_tache = $ligne->;
							$visibilite = $ligne->;
							$priorite = $ligne->;
							$description = $ligne->;
							$id_util_creation = $ligne->;
							$id_util_traitant = $ligne->;
								*/
								/*
								$query_base = "SELECT taches.id_tache, taches.date_creation, taches.date_echeance, taches.etat, taches.visibilite, taches.priorite, taches.description, taches.id_util_creation, taches.id_util_traitant
									FROM `taches` LEFT JOIN `taches_categories` ON `taches`.`id_tache` = `taches_categories`.`id_tache`
									WHERE `taches_categories`.`id_tache` IS NULL
									AND (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."')
									AND visibilite LIKE '".$visibilite_filtre."'";
								*/
								$query_base = "SELECT taches.id_tache, taches.date_creation, taches.date_echeance, taches.etat, taches.visibilite, taches.priorite, taches.description, taches_util.id_util
									FROM `taches_util`, taches LEFT JOIN `taches_categories` ON `taches`.`id_tache` = `taches_categories`.`id_tache`
									WHERE `taches`.`id_tache` = `taches_util`.`id_tache`
									AND `taches_categories`.`id_tache` IS NULL
									AND taches_util.id_util = '".$id_util."'
									AND visibilite LIKE '".$visibilite_filtre."'";



								//$query_base = "SELECT * FROM taches WHERE (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite LIKE '".$visibilite_filtre."'";
							}
							else
							{
								/*
								$query_base = "SELECT taches.id_tache, taches.date_creation, taches.date_echeance, taches.etat, taches.visibilite, taches.priorite, taches.description, taches.id_util_creation, taches.id_util_traitant
									FROM `taches` LEFT JOIN `taches_categories` ON `taches`.`id_tache` = `taches_categories`.`id_tache`
									WHERE `taches_categories`.`id_tache` IS NULL
									AND (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."')
									AND visibilite LIKE '".$visibilite_filtre."'";
								*/
								$query_base = "SELECT taches.id_tache, taches.date_creation, taches.date_echeance, taches.etat, taches.visibilite, taches.priorite, taches.description, taches_util.id_util
									FROM `taches_util`, taches LEFT JOIN `taches_categories` ON `taches`.`id_tache` = `taches_categories`.`id_tache`
									WHERE `taches`.`id_tache` = `taches_util`.`id_tache`
									AND `taches_categories`.`id_tache` IS NULL
									AND taches_util.id_util = '".$id_util."'
									AND visibilite LIKE '".$visibilite_filtre."'";


								//$query_base = "SELECT * FROM taches WHERE (id_util_creation = '".$id_util."' OR taches.id_util_traitant = '".$id_util."') AND visibilite LIKE '".$visibilite_filtre."' AND etat <>'3'";
							}
						} //Fin if categorie_filtre == "S"

					break; //case "entete"

					case "entete_util" :
						//echo "<br />case entete_util : affiche_barrees : $affiche_barrees<br />";
						//on batti la requete de base
						if ($id_util_filtre == 0)
						{
							//echo "<br />id_util_filtre = 0";
							if ($affiche_barrees == "O")
							{
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND visibilite = 'PU'";
							}
							else
							{
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND visibilite = 'PU' AND taches.etat <>'3'";
							}
						}
						else
						{
							//echo "<br />id_util_filtre <> 0";
							if ($affiche_barrees == "O")
							{
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND visibilite = 'PU' AND taches.etat <>'3' AND taches.id_util_creation = '".$id_util_filtre."'";
							}
							else
							{
								$query_base = "SELECT * FROM taches, taches_util WHERE taches.id_tache = taches_util.id_tache AND taches_util.id_util = '".$id_util."' AND taches.id_util_creation = '".$id_util_filtre."' AND visibilite = 'PU'";
							}
						}
					break; //case "cadre"
				} // Fin switch origine_appel
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// D&eacute;but du script principal avec l'ex&eacute;cution des requetes et l'affichage du tableau avec la s&eacute;lection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////// Deux possibilit&eacute;s d'affichage : ////////////////////////////////////////////////////////////
//////////////// - par liste g&eacute;n&eacute;rale ///////////////////////////////////////////////////////////////////////
//////////////// - par cat&eacute;gorie ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*				switch ($type_affichage)
				{
					case "vue_generale" :
				// On affiche si nous venons d'une s&eacute;lection
*/				if ($affichage <> "N")
				{
					//echo "<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=ajout_tache&amp;affiche_barrees=$affiche_barrees\" class = \"bouton\">Ins&eacute;rer une nouvelle t&acirc;che</a>";
					echo "<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=ajout_tache&amp;affiche_barrees=$affiche_barrees&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/tache_ajout.png\" ALT = \"ins&eacute;rer\" border = \"0\" title=\"Ins&eacute;rer une nouvelle t&acirc;che\"></a>";
					if ($origine_appel == "entete_util")
					{
						if ($affiche_barrees == "O")
						{
							echo " - <a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;affiche_barrees=N\" class = \"bouton\">Cacher les t&acirc;ches achev&eacute;es</a>";
						}
						else
						{
							echo " - <a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;affiche_barrees=O\" class = \"bouton\">Afficher les t&acirc;ches achev&eacute;es</a>";
						}
					}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// On d&eacute;termine le compl&eacute;ment de la requ�te pour le tri ////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
					switch ($tri)
					{
						case "ID" :
							//echo "<br />tri case ID";
							$query_tri = " ORDER BY taches.id_tache $sense_tri;";
						break;

						case "DESCR" :
							//echo "<br />tri case ID";
							$query_tri = " ORDER BY taches.description $sense_tri;";
						break;

						case "DATECR" : //Date de cr&eacute;ation
							$query_tri = " ORDER BY priorite, etat, date_creation $sense_tri;";
						break;

						case "DATEEC" : //Date d'&eacute;ch&eacute;ance
							$query_tri = " ORDER BY priorite, etat, date_echeance $sense_tri;";
						break;

						case "UTIL" :
							$query_tri = " ORDER BY id_util_creation $sense_tri, priorite, etat, date_creation DESC;";
						break;

						default :
							//echo "<br />tri case defaut";
							$query_tri = " ORDER BY priorite, etat, date_echeance DESC;";
						break;
					}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// On compose la requte globale ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
					$query = $query_base.$query_etat.$query_recherche.$query_tri;
					//echo "<br />query : $query<br />";
					$results = mysql_query($query);
					if(!$results)
					{
						echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
						echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
						mysql_close();
						exit;
					}

				//Retourne le nombre de ligne rendu par la requ&egrave;te
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// Affichage de l'ent�te du tableau ////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
					if ($origine_appel == "entete_util")
					{
						echo "<h3>Nombre de t&acirc;ches partag&eacute;es s&eacute;lectionn&eacute;es : $num_results<br />";
					}
					else
					{
						echo "<h3>Nombre de t&acirc;ches s&eacute;lectionn&eacute;es : $num_results<br />";
					}
					echo "<small>$message_taches_complet</small></h3>";
					if ($filtre == "T")
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout;
					}
					else
					{
						$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout2;
					}
					echo "
						<table width = \"95%\">
						<!--caption>$intitule_tableau</caption-->";
						//echo "<br />origine_appel : $origine_appel";
						if ($origine_appel <> "entete_util")
						{
							echo "<colgroup>";
								echo "<col width=\"4%\">";
								echo "<col width=\"4%\">";
								echo "<col width=\"37%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"5%\">";
								echo "<col width=\"2%\">";
								echo "<col width=\"2%\">";
								echo "<col width=\"6%\">";
							echo "</colgroup>";
						}
						else
						{
							echo "<colgroup>";
								echo "<col width=\"4%\">";
								echo "<col width=\"4%\">";
								echo "<col width=\"43%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"8%\">";
								echo "<col width=\"5%\">";
								echo "<col width=\"2%\">";
								echo "<col width=\"2%\">";
								echo "<col width=\"8%\">";
							echo "</colgroup>";
						}

						echo "<tr>
							<th>";
							if ($sense_tri =="asc")
							{
								echo "ID&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=ID&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
							}
							else
							{
								echo "ID&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=ID&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
							}
							echo "</th>";

							echo "<th>&Eacute;tat</td>";
							echo "</th>";
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "Sujet&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DESCR&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par Sujet, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
							}
							else
							{
								echo "Sujet&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DESCR&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par Sujet, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
							}
							echo "</th>";

							//echo "<td align=\"center\">Sujet</td>";
							echo "<th>";


							if ($sense_tri =="asc")
							{
								echo "Cr&eacute;e le&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DATECR&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
							}
							else
							{
								echo "Cr&eacute;e le&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DATECR&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
							}
							echo "</th>";

//							if ($origine_appel == "entete_util") //Au cas o� l'on cherche les t�ches partag&eacute;es
//							{
								echo "<th>";
								if ($sense_tri =="asc")
								{
									echo "Cr&eacute;e par&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=UTIL&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
								}
								else
								{
									echo "Cr&eacute;e par&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=UTIL&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
								}
								echo "</th>";
//							}

							//echo "<td align=\"center\">Trait&eacute;e par</td>";

							echo "<th>";
								if ($sense_tri =="asc")
								{
									echo "Trait&eacute;e par&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=UTIL_TRAITANT&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
								}
								else
								{
									echo "Trait&eacute;e par&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=UTIL_TRAITANT&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
								}
								echo "</th>";



							echo "<th>Personne(s) associ&eacute;e(s)</th>";
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "Ech&eacute;ance&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DATEEC&amp;sense_tri=desc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
							}
							else
							{
								echo "Ech&eacute;ance&nbsp;<a href=\"taches_gestion.php?origine_appel=$origine_appel&amp;tri=DATEEC&amp;sense_tri=asc&amp;indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\"  title=\"Trier par N� de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
							}
							echo "</th>";

							echo "<th>Priorit&eacute;</th>";
							echo "<th>Cat</th>";
							if ($origine_appel <> "entete_util") //Au cas o� l'on cherche les t�ches partag&eacute;es
							{
								echo "<th>Vis</th>";
							}
							echo "<th>ACTIONS</th>";
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Partie sur la gestion des pages /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
							echo "<b>Page&nbsp;</b>";
							If ($indice == 0)
							{
								echo "<b><big>1</big>&nbsp;</b>";
							}
							else
							{
								echo "<a href = \"taches_gestion.php?indice=0&amp;affiche_barrees=$affiche_barrees\" target=\"body\" class=\"bouton\">1&nbsp;</a>";
							}
							//echo "<br />indice : $indice<br />";
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
									echo "<b><big>".$page."&nbsp;</big></b>";
								}
								else
								{
									echo "<a href = \"taches_gestion.php?indice=".$nb."&amp;affiche_barrees=$affiche_barrees\" target=\"body\" class=\"bouton\">".$page."&nbsp;</a>";
								}
							}
							$j = 0;
							while($j<$indice) //on se potionne sur la bonne page suivant la valeur de l'index
							{
								$res = mysql_fetch_row($results);
								++$j;
							}
							echo "<br >$intitule_tableau";
///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Fin gestion des pages /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////

							//Traitement de chaque ligne
							$ligne = mysql_fetch_object($results);
							$id = $ligne->id_tache;
							$date_creation = $ligne->date_creation;
							$date_echeance = $ligne->date_echeance;
							$etat_tache = $ligne->etat;
							$visibilite = $ligne->visibilite;
							$priorite = $ligne->priorite;
							$description = $ligne->description;
							//$id_util_creation = $ligne->id_util_creation;
							//$id_util_traitant = $ligne->id_util_traitant;
							//echo "<br />1 : id : $id - N� stand : $no_stand";

							//on recherche le nom de l'utilisateur qui a cr&eacute;&eacute; la t�che
							$requete_util = "SELECT taches_util.id_util, nom FROM util, taches_util WHERE taches_util.id_util = util.id_util AND id_tache = '".$id."' AND statut_cta LIKE '1%';";
							$resultat_util = mysql_query($requete_util);
							$ligne_util = mysql_fetch_object($resultat_util);
							$nom_util = $ligne_util->nom;
							$id_util_creation = $ligne_util->id_util;

							//on recherche le nom de l'utilisateur qui traite la t�che
							$requete_util_traitant = "SELECT taches_util.id_util, nom FROM util, taches_util WHERE taches_util.id_util = util.id_util AND id_tache = '".$id."' AND statut_cta LIKE '%10';";
							$resultat_util_traitant = mysql_query($requete_util_traitant);
							$ligne_util_traitant = mysql_fetch_object($resultat_util_traitant);
							$nom_util_traitant = $ligne_util_traitant->nom;
							$id_util_traitant = $ligne_util_traitant->id_util;

							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($id <>"")
								{
									//echo "<br />2 : id : $id - N� stand : $no_stand";
									/*
									//on recherche l'affectation
									$requete_affectation = "SELECT * FROM materiels_affectations WHERE materiels_affectations.id_affectation = '".$affectation_materiel."';";
									$resultat_affectation = mysql_query($requete_affectation);
									$ligne_affectation = mysql_fetch_object($resultat_affectation);
									$affectation = $ligne_affectation->intitule_affectation;
									*/

									switch ($etat_tache)
									{
										case "1":
											$couleur_fond = "#ffffff";
											$classe_fond = "nouveau";
										break;

										case "2":
											$couleur_fond = "#00cc33";
											$classe_fond = "en_cours";
                  						break;

										case "3":
											$couleur_fond = "#FF9FA3";
											$classe_fond = "acheve";
										break;

									}

									//echo "<br />classe_fond : $classe_fond";

									switch ($priorite)
									{
                    					case "H":
                    						$fond = "#ff0000";
                    						$classe_fond2 = "priorite_haute";
                    					break;

                    					case "N":
                    						$fond = "#A4EFCA";
                    						$classe_fond2 = "priorite_normale";
                    					break;

                    					case "B":
                    						$fond = "#ffff66";
                    						$classe_fond2 = "priorite_basse";
                    					break;

                    					case "S":
                    						$fond = "#ffffff";
                    						$classe_fond2 = "priorite_sans";
                    					break;
                  					}
									echo "<tr>";
                  					if ($etat_tache == '3') //La t�che est achev&eacute;e et il faut l'afficher barr&eacute;e
                  					{
										echo "<td align = \"center\">";
										echo "<strike>$id</strike>";
										echo "</td>";
										echo "<td class = \"$classe_fond\">";
										echo "&nbsp";
										echo "</td>";
										echo "<td>";
										echo "<strike>$description</strike>";
										echo "</td>";
										echo "<td align = \"center\">";
										echo "<strike>$date_creation</strike>";
										echo "</td>";
//										if ($origine_appel == "entete_util") //Au cas o� l'on cherche les t�ches partag&eacute;es
//										{
											echo "<td align=\"center\">";
											echo "<strike>$nom_util</strike>";
											echo "</td>";
//										}
										echo "<td align = \"center\">";
										//if (($id_util_traitant <> $id_util_creation) AND ($id_util_traitant <> $id_util))
										//{
											echo "<strike>$nom_util_traitant</strike>";
										//}
										//else
										//{
										//	echo "&nbsp;";
										//}
										echo "</td>";
										//echo "<td align = \"center\">&nbsp;</td>";

										echo "<td align = \"center\">";
											$requete_partage = "SELECT * FROM taches_util, util WHERE taches_util.id_util = util.ID_UTIL AND id_tache = '".$id."' AND statut_cta LIKE '%1' ORDER BY nom";
											$resultat_partage = mysql_query($requete_partage);
											$num_rows = mysql_num_rows($resultat_partage);

											if (mysql_num_rows($resultat_partage))
											{
												while ($ligne_partage=mysql_fetch_object($resultat_partage))
												{
													$id_util_partage = $ligne_partage->ID_UTIL;
													$nom = $ligne_partage->NOM;
													$prenom = $ligne_partage->PRENOM;
													echo "<strike>$nom</strike><br />";
												}
											}
										echo "</td>";



										echo "<td align=\"center\">";
										//verif_alerte($res[0],$id_util,$date_aujourdhui,"tache");
										echo "<strike>$date_echeance</strike>";
										echo "</td>";
										echo "<td class = \"$classe_fond2\">";
										echo "&nbsp;";
										echo "</td>";
										//on v&eacute;rifie si la t�ches est associ&eacute;e &agrave; au moins une cat&eacute;gorie
										//$req_verif_categ = "SELECT * FROM taches_categories WHERE id_tache = '".$id."'";
										//$res_verif_categ = mysql_query("SELECT * FROM taches_categories WHERE id_tache = '".$id."'");
										//$nbr_categ = mysql_num_rows($res_verif_categ);
										//$num_results = mysql_num_rows($results);
										$nbr_categ = mysql_num_rows(mysql_query("SELECT * FROM taches_categories WHERE id_tache = '".$id."'"));
										if ($nbr_categ > 0)
										{
											echo "<td align=\"center\"><strike>X</strike></td>";
										}
										else
										{
											echo "<td align=\"center\">&nbsp;</td>";
										}
										if ($origine_appel <> "entete_util")
										{
											echo "<td align = \"center\">";
											if ($visibilite == "PR")
											{
												echo "<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\">";
											}
											else
											{
												echo "&nbsp;";
											}
											echo "</td>";
										} //Fin if origine_appel <> entete_util

                  					} //Fin if etat_tache = 3
                  					else
                  					{
										echo "<td align = \"center\">$id</td>";
										echo "<td class = \"$classe_fond\">&nbsp</td>";
										echo "<td>$description</td>";
										echo "<td align = \"center\">$date_creation</td>";
										echo "<td align=\"center\">$nom_util</td>";

										echo "<td align = \"center\">";
										/*if (($id_util_traitant <> $id_util_creation) AND ($id_util_traitant <> $id_util))
										{
										*/	echo $nom_util_traitant;
										/*}
										else
										{
											echo "&nbsp;";
										}
										*/

										echo "</td>";

										//on affiche les personnes associ&eacute;es &agrave; la t�che

										echo "<td align = \"center\">";
											$requete_partage = "SELECT * FROM taches_util, util WHERE taches_util.id_util = util.ID_UTIL AND id_tache = '".$id."' AND statut_cta LIKE '%1' ORDER BY nom";
											$resultat_partage = mysql_query($requete_partage);
											$num_rows = mysql_num_rows($resultat_partage);

											if (mysql_num_rows($resultat_partage))
											{
												while ($ligne_partage=mysql_fetch_object($resultat_partage))
												{
													$id_util_partage = $ligne_partage->ID_UTIL;
													$nom = $ligne_partage->NOM;
													$prenom = $ligne_partage->PRENOM;
													echo "$nom<br />";
												}
											}
										echo "</td>";

										echo "<td align=\"center\">";
											//verif_alerte($res[0],$id_util,$date_aujourdhui,"tache");
											echo $date_echeance;
										echo "</td>";

										echo "<td class = \"$classe_fond2\">";
											if ($priorite == "H")
											{
												$image_h = $chemin_images_theme."priorite_haute.png";
												echo "<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_haute.png\" ALT = \"PH\">";
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=N&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_normale.png\" ALT = \"PN\" title=\"Basculer en priorit&eacute; normale\"></a>";
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=B&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_basse.png\" ALT = \"PB\" title=\"Basculer en priorit&eacute; basse\"></a>";
											}
											elseif ($priorite == "N")
											{
												$image_n = $chemin_images_theme."priorite_normale.png";
												echo "<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=H&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_haute.png\" ALT = \"PH\" title=\"Basculer en priorit&eacute; haute\"></a>";
												echo "&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_normale.png\" ALT = \"PN\">";
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=B&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_basse.png\" ALT = \"PB\" title=\"Basculer en priorit&eacute; basse\"></a>";
											}
											elseif ($priorite == "B")
											{
												$image_b = $chemin_images_theme."priorite_basse.png";
												echo "<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=H&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_haute.png\" ALT = \"PH\" title=\"Basculer en priorit&eacute; haute\"></a>";
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=changer_priorite&amp;priorite_a_changer=N&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_normale.png\" ALT = \"PN\" title=\"Basculer en priorit&eacute; normale\"></a>";
												echo "&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/priorite_basse.png\" ALT = \"PB\">";
											}
										echo "</td>";
										//on regarde si la t�che est inscrit pour au moins une cat&eacute;gorie
										$nbr_categ = mysql_num_rows(mysql_query("SELECT * FROM taches_categories WHERE id_tache = '".$id."'"));
										if ($nbr_categ > 0)
										{
											echo "<td align=\"center\">X</td>";
										}
										else
										{
											echo "<td align=\"center\">&nbsp;</td>";
										}

										if ($origine_appel <> "entete_util") //Au cas o� l'on cherche les t�ches partag&eacute;es
										{
											echo "<td align = \"center\">";
											if ($visibilite == "PR")
											{
												//echo "<td align = \"center\">";
												echo "<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\">";
												//echo "</td>";
											}
											else
											{
												echo "&nbsp;";
											}
											echo "</td>";
										}
									} //Fin else etat_tache = 3

									//Les actions
										echo "<td nowrap class = \"fond-actions\">";
										echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=afficher_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter la t&acirc;che\"></a>";
										//if (($id_util_creation == $_SESSION['id_util']) OR ($id_util_traitant == $_SESSION['id_util']))
										//{
											echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la t&acirc;che\"></a>";
											//echo "<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=partager_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"partager\" height=\"24px\" width=\"24px\" title=\"Partager la t&acirc;che\"></a>";
											if ($etat_tache == "3")
											{
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=activer_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ecran_lcd.png\" border = \"0\" ALT = \"activer\" height=\"24px\" width=\"24px\" title=\"Activer la t&acirc;che\"></a>";
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=supprimer_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer la t&acirc;che\"></a>";
											}
											else
											{
												echo "&nbsp;<a href = \"taches_gestion.php?origine_appel=$origine_appel&amp;actions_courantes=O&amp;a_faire=achever_tache&amp;id=$id&amp;id_util_filtre=$id_util_filtre&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ecran_lcd_croix.png\" border = \"0\" ALT = \"achev&eacute;e\" height=\"24px\" width=\"24px\" title=\"Marquer la t&acirc;che comme achev&eacute;e\"></a>";
											}
										//}
										echo "&nbsp;</td>";
									echo "</tr>";
								} //Fin id <> ""

								$ligne = mysql_fetch_object($results);
								$id = $ligne->id_tache;
								$date_creation = $ligne->date_creation;
								$date_echeance = $ligne->date_echeance;
								$etat_tache = $ligne->etat;
								$visibilite = $ligne->visibilite;
								$priorite = $ligne->priorite;
								$description = $ligne->description;
								//$id_util_creation = $ligne->id_util_creation;
								//$id_util_traitant = $ligne->id_util_traitant;
								//echo "<br />1 : id : $id - N� stand : $no_stand";
								//on recherche le nom de l'utilisateur qui a cr&eacute;&eacute; la t�che
								$requete_util = "SELECT taches_util.id_util, nom FROM util, taches_util WHERE taches_util.id_util = util.id_util AND id_tache = '".$id."' AND statut_cta LIKE '1%';";
								$resultat_util = mysql_query($requete_util);
								$ligne_util = mysql_fetch_object($resultat_util);
								$nom_util = $ligne_util->nom;
								$id_util_creation = $ligne_util->id_util;

								//on recherche le nom de l'utilisateur qui traite la t�che
								$requete_util_traitant = "SELECT taches_util.id_util, nom FROM util, taches_util WHERE taches_util.id_util = util.id_util AND id_tache = '".$id."' AND statut_cta LIKE '%10';";
								$resultat_util_traitant = mysql_query($requete_util_traitant);
								$ligne_util_traitant = mysql_fetch_object($resultat_util_traitant);
								$nom_util_traitant = $ligne_util_traitant->nom;
								$id_util_traitant = $ligne_util_traitant->id_util;

							}
							//Fermeture de la connexion &agrave; la BDD
							mysql_close();
					}
					else
					{
						echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"

/*					break;

					case "vue_categorie" :

					break;
				} //Fin switch type_affichage
*/
?>
			</table>
		</div>
	</body>
</html>
