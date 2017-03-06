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
	include ("../biblio/config.php");
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>
  		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_personnes_ressources.png\" ALT = \"Titre\">";
			//include ("../biblio/ticket.css");
			//include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
				$autorisation_hsa = verif_appartenance_groupe(4);
				//Pour filtrer les établissements
				$dep = $_GET['dep'];
				$intitule_fonction = $_GET['intitule_fonction'];
				$annee = $_GET['annee'];
				$indice = $_GET['indice'];
				$secteur = $_GET['secteur'];
				$rechercher = $_GET['rechercher'];
				$dans = $_GET['dans'];
				$en_liste = $_GET['en_liste'];
				$origine = $_GET['origine'];
				$tri = $_GET['tri']; //Tri sur quelle colonne ?
				$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
				$indice = $_GET['indice']; //� partir de quelle page
				$lettre = $_GET['lettre'];
				$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur une personnes ressource 
				$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$actions_courantes = "N";
					$actions_structurelles = "N";
				}
				
				//On vérifie les droits
				$autorisation_personnes_ressources = verif_appartenance_groupe(9);
				$niveau_droits = verif_droits("personnes_ressources");
				/*
				echo "<br>autorisation_personnes_ressources : $autorisation_personnes_ressources";
				echo "<br>niveau_droits : $niveau_droits";
				echo "<br />en_liste : $en_liste";
				*/
/*
				//Récupération des variables pour faire fonctionner ce script
				$FGMM = $_GET['FGMM']; //on arrive du fichier fgmm_cadre.php
				$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'ent�te ou recherche de l'ent�te

*/
				//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe o�
				if (isset($dans))
				{
					$_SESSION['dans'] = $dans;
				}
				else
				{
					$dans = $_SESSION['dans'];
				}

				if (isset($dep))
				{
					$_SESSION['departement_en_cours'] = $dep;
				}
				else
				{
					$dep = $_SESSION['departement_en_cours'];
				}

				if (isset($annee))
				{
					$_SESSION['annee'] = $annee;
				}
				else
				{
					$annee = $_SESSION['annee'];
				}

				if (isset($rechercher))
				{
					$_SESSION['rechercher'] = $rechercher;
				}
				else
				{
					$rechercher = $_SESSION['rechercher'];
				}

				if (isset($intitule_fonction))
				{
					$_SESSION['intitule_fonction_en_cours'] = $intitule_fonction;
				}
				else
				{
					$intitule_fonction = $_SESSION['intitule_fonction_en_cours'];
				}

				$dep_en_cours = $_SESSION['departement_en_cours'];
				//$sec_en_cours = $_SESSION['secteur_en_cours'];
				$intitule_fonction_en_cours = $_SESSION['intitule_fonction_en_cours'];

				if(!isset($lettre) || $lettre == "")
				{
					$lettre = $_SESSION['lettre'];
				}
				else
				{
					$_SESSION['lettre'] = $lettre;
				}
/*
				echo "<br>annee : $annee";
				echo "<br>dep : $dep";
				echo "<br>rechercher : $rechercher";
				echo "<br>dans : $dans";
				echo "<br>en_liste : $en_liste";
				echo "<br>intitule_fonction : $intitule_fonction";
 				echo "<br>tri : $tri";
				echo "<br>sense_tri : $sense_tri";
				echo "<br>";
*/
				//$_SESSION['origine'] = "repertoire_gestion";
				$nb_par_page = 15; //Fixe le nombre de ligne qu'il faut afficher � l'�cran
				/*
				//Affectation des variables sessions pour contr�le et affichage
				$ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_intitule_fonction = $_SESSION['intitule_fonction'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
				echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  intitule_fonction : $intitule_fonction - � rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
				echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  intitule_fonction : $ses_intitule_fonction - � rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
*/
////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début du traitement des actions sur les personnes ressources //////////////////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions_courantes == "O")
				{
					$id = $_GET['id'];
					//echo "<br>id : $id";
					switch ($a_faire)
					{
						case "consulter_personne" :
							include ("personnes_ressources_gestion_affiche_fiche_personne.inc.php");
							//echo "<h1>Afficher la fiche de la personne $id</h1>";
							//echo "<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=N&amp;indice=$indice\" target = \"body\"><h2>Retour à la liste</h2></A>";
							$affichage ="N";
						break; //consulter_fiche_personne
						
						case "ajout_personne" :
							include ("personnes_ressources_gestion_ajout_personne.inc.php");
							//echo "<h1>Ajout d'une personne ressource</h1>";							
							$affichage ="N";
						break; //ajout_personne

						case "enreg_personne" :
							include ("personnes_ressources_gestion_enreg_personne.inc.php");
							//echo "<h1>Enregistrement d'une personne ressource</h1>";							
						break; //enreg_personne

						case "modif_personne" :
							include ("personnes_ressources_gestion_modif_personne.inc.php");
							//echo "<h1>Modification d'une personne ressource</h1>";							
							//echo "<h1>Bient&ocirc;t sur cet &eacute;cran :-;</h1>";							
							$affichage ="N";
						break; //modif_personne

						case "maj_personne" :
							include ("personnes_ressources_gestion_maj_personne.inc.php");
							//echo "<h1>MAJ d'une personne ressource</h1>";							
							//echo "<h1>Bient&ocirc;t sur cet &eacute;cran :-;</h1>";							
						break; //maj_personne

						case "saisir_fonction" :
							include ("personnes_ressources_gestion_saisie_fonction.inc.php");
							$affichage ="N";
						break; //saisir_fonction
						
						case "enreg_fonction" :
							echo "<h1>Enregistrement des heures</h1>";
							include ("personnes_ressources_gestion_enreg_fonction.inc.php");
						break; //enreg_fonction

						case "supprimer_personne" :
							//include ("materiels_gestion_supprimer_materiel.inc.php");
							echo "<h1>Suppression d'une personne ressource</h1>";
							echo "<h1>Bient&ocirc;t sur cet &eacute;cran :-;</h1>";
							$affichage ="N";
						break; //supprimer_personne

						case "confirme_supprimer_personne" :
							echo "<h1>Confirmation de suppression d'une personne ressource</h1>";
							/*
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
							*/
						break; //supprimer_personne

						case "tableau_bord_heures" :
							//echo "<h1>Ici bient&ocirc;t le tableau de bord des heures</h1>";
							include ("personnes_ressources_gestion_tableau_bord_heures.inc.php");
							$affichage ="N";
						break; //tableau_bord_heures

					} //Fin switch $a_faire
				} //Fin if actions_courantes == O
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des actions sur les personnes ressources ////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////// Début du script principal pour l'affichage des enregistrepments ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if ($affichage <> "N")
				{
					if (($autorisation_personnes_ressources == "1") AND ($en_liste <>"Oui") AND ($niveau_droits == "3")) //Seul les personnes ayant le droit peuvent insérer une nouvelle personnes ressource
					{
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"personnes_ressources_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=ajout_personne\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/personne_ressources_ajout.png\" ALT = \"Ajouter personne\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter une personne ressource</span><br />";
									echo "</td>";
									echo "<td>";
										echo "<a href = \"personnes_ressources_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=tableau_bord_heures\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/heures.png\" ALT = \"Tableau bord heures\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Tableau de bord des heures</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
	

						//echo "<A HREF = \"personnes_ressources_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=ajout_personne\" class = \"bouton\">Ins&eacute;rer une nouvelle personne ressource</A>&nbsp;-&nbsp;";
						//echo "<A HREF = \"personnes_ressources_gestion.php?origine_gestion=filtre&amp;actions_courantes=O&amp;a_faire=tableau_bord_heures\" class = \"bouton\">Tableau de bord des heures</A>";
					}
					switch ($dep)
					{
						case 'T' :
							$rne_a_inclure = "%";
							$affiche_departement = "de l'acad&eacute;mie";
						break;
	
						case '18' :
							$rne_a_inclure = "018";
							$affiche_departement = "du d&eacute;partement du Cher";
						break;

						case '28' :
							$rne_a_inclure = "028";
							$affiche_departement = "du d&eacute;partement de l'Eure-et-Loire";
						break;

						case '36' :
							$rne_a_inclure = "036";
							$affiche_departement = "du d&eacute;partement de l'Indre";
						break;

						case '37' :
							$rne_a_inclure = "037";
							$affiche_departement = "du d&eacute;partement de l'Indre-et-Loire";
						break;

						case '41' :
							$rne_a_inclure = "041";
							$affiche_departement = "du d&eacute;partement du Loir-et-Cher";
						break;

						case '45' :
							$rne_a_inclure = "045";
							$affiche_departement = "du d&eacute;partement du Loiret";
						break;
					} //Fin switch ($dep)
					
					//Affectation du joker "%" s'il faut afficher tous les types de la table
					if ($intitule_fonction_en_cours == 'T')
					{
						$intitule_pour_requete = "%";
					}
					else
					{
						$intitule_pour_requete = $intitule_fonction_en_cours;
					}
					//Affectation du joker "%" s'il faut afficher tous les secteurs de la table 
/*
					if ($secteur == 'T')
					{
						$secteur_pour_requete = "%";
					}
					else
					{
						$secteur_pour_requete = $secteur;
					}
*/
					//echo "<BR>annee : $annee - intitule_fonction : $intitule_fonction - intitule_fonction_en_cours : $intitule_fonction_en_cours - intitule_pour_requete : $intitule_pour_requete - rne_a_inclure : $rne_a_inclure<br>";
					//echo "<br>� rechercher : $rechercher - dans : $dans<br>";
					//Il faut regarder comment trier les enregistrements
					if ($tri == "")
					{
						$tri = "NOM";
					}
					switch ($tri)
					{
						case "ID" :
							$query_tri = " ORDER BY personnes_ressources_tice.id_pers_ress $sense_tri;";
						break;

						case "NOM" :
							$query_tri = " ORDER BY personnes_ressources_tice.nom $sense_tri, prenom ASC;";
						break;

						case "RNE" :
							$query_tri = " ORDER BY personnes_ressources_tice.codetab $sense_tri;";
						break;
	
						case "DISC" :
							$query_tri = " ORDER BY personnes_ressources_tice.discipline $sense_tri;";
						break;

						case "POSTE" :
							$query_tri = " ORDER BY personnes_ressources_tice.poste $sense_tri;";
						break;

						case "FONCTION" :
							$query_tri = " ORDER BY fonctions_des_personnes_ressources.fonction $sense_tri;";
						break;

						default :
							$query_tri = " ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;
					} // Fin switch tri

					//Il y a deux cas de figure pour l'affichage
					//1 si l'affichage pour une année donnée
					//2 si l'affichage pour toutes les années

					if ($annee == "%")
					{
						if ($rechercher <>"")
						{
							switch ($dans)
							{
								case "T" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE nom LIKE '%$rechercher%' OR prenom LIKE '%$rechercher%' OR discipline LIKE '%$rechercher%' OR poste LIKE '%$rechercher%'";
								break;
	
								case "N" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE nom LIKE '%$rechercher%'";
								break;
	
								case "P" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE prenom LIKE '%$rechercher%'";
								break;

								case "NP" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE nom LIKE '%$rechercher%' OR prenom LIKE '%$rechercher%'";
								break;

								case "V" :
									echo "<br>coucou dans V";
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, personnes_ressources_tice.nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, etablissements WHERE codetab=rne AND ville LIKE '%$rechercher%'";
								break;

								case "M" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE mel LIKE '%$rechercher%'";
								break;

								case "RNE" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice WHERE codetab LIKE '%$rechercher%'";
								break;
							} //Fin switch dans
						} //Fin if $rechercher <>""
						else
						{
							$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel, fonction FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."'";
						} //Fin else rechercher <>""
					} // Fin if annee == "%"
					else
					{
						if ($rechercher <>"")
						{
							switch ($dans)
							{
								case "T" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND fonctions_des_personnes_ressources.annee = '".$annee."' AND (nom LIKE '%$rechercher%' OR prenom LIKE '%$rechercher%' OR discipline LIKE '%$rechercher%' OR poste LIKE '%$rechercher%')";
								break;
	
								case "N" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND fonctions_des_personnes_ressources.annee = '".$annee."' AND nom LIKE '%$rechercher%'";
								break;
	
								case "P" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND fonctions_des_personnes_ressources.annee = '".$annee."' AND prenom LIKE '%$rechercher%'";
								break;

								case "NP" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND fonctions_des_personnes_ressources.annee = '".$annee."' AND (nom LIKE '%$rechercher%' OR prenom LIKE '%$rechercher%')";
								break;

								case "V" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, personnes_ressources_tice.nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, etablissements, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab=rne AND ville LIKE '%$rechercher%' AND fonctions_des_personnes_ressources.annee = '".$annee."'";
								break;

								case "M" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND fonctions_des_personnes_ressources.annee = '".$annee."' AND mel LIKE '%$rechercher%'";
								break;

								case "RNE" :
									$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '%$rechercher%' AND fonctions_des_personnes_ressources.annee = '".$annee."'";
								break;
							} //Fin switch dans
						} //Fin if $rechercher <>""
						else
						{
							$query_base = "SELECT DISTINCT personnes_ressources_tice.id_pers_ress, civil, nom, prenom, codetab, id_discipline, discipline, id_poste, poste, mel, fonction FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."'";
						} //Fin else rechercher <>""
					} //Fin else annee == "%"
					//echo "<br>query : $query";
					$query = $query_base.$query_tri;
					$results = mysql_query($query);
					if(!$results)
					{
						echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
						echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
						mysql_close();
						exit;
					}

					//echo "<h3>".$liste_a_afficher." "." ".$secteur_a_afficher." ".$affiche_departement."</h3>";
					//Retourne le nombre de ligne rendu par la requ�te
					$num_results = mysql_num_rows($results);

					if(!$results)
					{
						echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
						echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requ�te
					$num_results = mysql_num_rows($results);
					if ($num_results >0)
					{	
///////////////////////Affichage de l'entête du tableau //////////////////////////////////////////////
						echo "<h2>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h2>";
						echo "
						<TABLE>
							<TR>
								<th>";
								if ($sense_tri =="asc")
								{
									echo "ID<A href=\"personnes_ressources_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par N&ordm; de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "ID<A href=\"personnes_ressources_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par N&ordm; de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>
								<th>
									CIVIL
								</th>
								<th>";
								if ($sense_tri =="asc")
								{
									echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>
								<th>
										PRENOM
								</th>
								<th>";
								if ($sense_tri =="asc")
								{
									echo "DISCIPLINE<A href=\"personnes_ressources_gestion.php?tri=DISC&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "DISCIPLINE<A href=\"personnes_ressources_gestion.php?tri=DISC&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>
								<th>";
								if ($sense_tri =="asc")
								{
									echo "POSTE<A href=\"personnes_ressources_gestion.php?tri=POSTE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "POSTE<A href=\"personnes_ressources_gestion.php?tri=POSTE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>";
								echo "<th>";
								if ($sense_tri =="asc")
								{
									echo "FONCTION<A href=\"personnes_ressources_gestion.php?tri=FONCTION&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "FONCTION<A href=\"personnes_ressources_gestion.php?tri=FONCTION&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>";
								echo "<th>
										MEL
								</th>";
								echo "<th>";
								if ($sense_tri =="asc")
								{
									echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								echo "</th>";
								if ($en_liste <> "Oui")
								{
									if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_hsa == "1"))
									{
										echo "<th>
											ACTIONS
										</th>";
									}
								}else
								{
									echo "<th>Type</th>";
									echo "<th>Nom_etab</th>";
									echo "<th>Ville_etab</th>";
									echo "<th>courriel</th>";
								}

//////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Partie sur la gestion des pages ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
								if ($en_liste <> "Oui")
								{
									$nombre_de_page = number_format($num_results/$nb_par_page,1);
									$par_navig = "0";
/*
									echo "<br>Nombre de pages : $nombre_de_page";
									echo "<br>Nb_par_page : $nb_par_page<br>";
*/	
									echo "Page&nbsp;";
									If ($indice == 0)
									{
										echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
									}
									else
									{
										echo "<a href = \"personnes_ressources_gestion.php?tri=$tri&amp;rechercher=$rechercher&amp;dans=$dans&amp;indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
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
											echo "&nbsp;<a href = \"personnes_ressources_gestion.php?tri=$tri&amp;rechercher=$rechercher&amp;dans=$dans&amp;indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
											//echo "<A HREF = \"personnes_ressources_gestion.php?tri=$tri&amp;rechercher=$rechercher&amp;dans=$dans&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
										}
									}
									$j = 0;
									while($j<$indice) //on se potionne sur la bonne page suivant la valeur de l'index
									{
										$res = mysql_fetch_row($results);
										++$j;
									}
								} //Fin if liste <>"Oui"
								else
								{
									$nb_par_page = "1000";
								}
//////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Fin gestion des pages /////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
							//echo "<br>nbr_par_page : $nb_par_page";
							//echo "<br>nombre_de_page : $nombre_de_page";
							//Traitement de chaque ligne
							//$res = mysql_fetch_row($results);
							$ligne = mysql_fetch_object($results);
							$id = $ligne->id_pers_ress;
							$civil = $ligne->civil;
							$nom = $ligne->nom;
							$prenom = $ligne->prenom;
							$codetab = $ligne->codetab;
							$discipline = $ligne->discipline;
							$poste = $ligne->poste;
							$fonction = $ligne->fonction;
							$mel_extrait = $ligne->mel;
							
							//On récupère les infos concernant l'établissements
							$query_etab = "SELECT TYPE, NOM, VILLE, MAIL FROM etablissements WHERE rne = '".$codetab."'";
							$resultat_etab = mysql_query($query_etab);
							$ligne_etab = mysql_fetch_object($resultat_etab);
							$type_etab = $ligne_etab->TYPE;
							$nom_etab = $ligne_etab->NOM;
							$ville_etab = $ligne_etab->VILLE;
							$mel_etab = $ligne_etab->MAIL;
							//if ($nombre_de_page) //retiré le 2/11/08 sans savoir à quoi servait cette ligne
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								//echo "C$i $nom - ";
								if (($res[0] <>"") OR ($id <> ""))
								{
									//$mel = $res[9]."@ac-orleans-tours.fr";
									$mel = $mel_extrait."@ac-orleans-tours.fr";
									echo "<TR>";
										echo "<TD align = \"center\">";
											//echo $res[0];
											echo $id;
										echo "</TD>";
										echo "<TD align = \"center\">";
											//echo $res[1];
											echo $civil;
										echo "</TD>";
										echo "<TD>";
											//echo $res[2];
											echo $nom;
										echo "</TD>";
										echo "<TD>";
											//echo $res[3];
											echo $prenom;
										echo "</TD>";
										echo "<TD align=\"center\">";
											//echo "$res[6]";
											echo $discipline;
										echo "</TD>";
										echo "<TD align=\"center\">";
											//echo "$res[8]";
											echo $poste;
										echo "</TD>";
										echo "<TD align=\"center\">$fonction</TD>";
										
										echo "<TD>";
											echo "<a href=\"mailto:".$mel."?cc=".$_SESSION['mail']."\">$mel</a>";
										echo "</TD>";
										echo "<TD>";
											//echo "$res[4]";
											if ($en_liste <> "Oui")
											{
												affiche_info_bulle($codetab,"RESS",0); //rne, module, id_ticket
											}
											else
											{
												echo $codetab;
											}
										echo "</TD>";
										if ($en_liste == "Oui")
										{
											echo "<TD align=\"center\">";
												echo $type_etab;
											echo "</TD>";
											echo "<TD align=\"center\">";
												echo $nom_etab;
											echo "</TD>";
											echo "<TD align=\"center\">";
												echo $ville_etab;
											echo "</TD>";
											echo "<TD align=\"center\">";
												echo $mel_etab;
											echo "</TD>";
										}
										/*
										echo "<TD>";
											echo $res[13];
											//echo $fonction;
										echo "</TD>";
										*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// Les actions ///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
										if ($en_liste <> "Oui")
										{
											echo "<TD nowrap class = \"fond-actions\">";
												echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=consulter_personne&amp;id=".$id."&amp;indice=".$indice."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"Consulter la fiche de la personne\" border = \"0\"></A>";
											if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
											{
												echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=modif_personne&amp;id=".$id."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la fiche de la personne\" border = \"0\"></A>";
												echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=saisir_fonction&amp;id=".$id."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/heures_ajout.png\" ALT = \"saisie fonction\" title=\"Saisir une fonction pour la personne\" border = \"0\"></A>";
												//echo "<A HREF = \"personnes_ressources_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></A>";
												echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=supprimer_personne&amp;id=".$id."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer la personne\" border = \"0\"></A>&nbsp;";
											}
											echo "</TD>";
										echo "</TR>";
										}
								} //Fin if res[0]<>""
								//$res = mysql_fetch_row($results);
								$ligne = mysql_fetch_object($results);
								$id = $ligne->id_pers_ress;
								$civil = $ligne->civil;
								$nom = $ligne->nom;
								$prenom = $ligne->prenom;
								$codetab = $ligne->codetab;
								$discipline = $ligne->discipline;
								$poste = $ligne->poste;
								$fonction = $ligne->fonction;
								$mel_extrait = $ligne->mel;
	
								//On récupère les infos concernant l'établissements
								$query_etab = "SELECT TYPE, NOM, VILLE, MAIL FROM etablissements WHERE rne = '".$codetab."'";
								$resultat_etab = mysql_query($query_etab);
								$ligne_etab = mysql_fetch_object($resultat_etab);
								$type_etab = $ligne_etab->TYPE;
								$nom_etab = $ligne_etab->NOM;
								$ville_etab = $ligne_etab->VILLE;
								$mel_etab = $ligne_etab->MAIL;
							} //Fin boucle for
							//Fermeture de la connexion � la BDD
							mysql_close();
					} //Fin num-results >0
					else
					{
						echo "<h2>Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"
	?>
			</TABLE>
		</div>
	</body>
</html>
