<?php
	session_start();
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
	$_SESSION['origine'] = "formations_gestion";
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
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_formations.png\" ALT = \"Titre\">";
			//include("../biblio/ticket.css");
			include("../biblio/fct.php");
			include("../biblio/config.php");
			include("../biblio/init.php");
			$autorisation_formation = verif_appartenance_groupe(5);
			$module = "FOR"; //nécessaire pour le script qui ajoute des documents à une formation
			$dossier = $dossier_docs_formation;
			//Pour filtrer les établissements
			$dep = $_GET['dep'];
			$intitule_formation = $_GET['intitule_formation'];
			$annee_scolaire = $_GET['annee_scolaire'];
			$indice = $_GET['indice'];
			//$secteur = $_GET['secteur'];
			$rne_a_rechercher = $_GET['rne_a_rechercher']; //le N° RNE
			//$dans = $_GET['dans'];
			$tri = $_GET['tri']; //Tri sur quelle colonne ?
			$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
			$indice = $_GET['indice']; //à partir de quelle page
			$lettre = $_GET['lettre'];
			$CHGMT = $_GET['CHGMT']; //Pour savoir s'il y a des changements à opérer
			$action = $_GET['action']; //Pour savoir ce qu'il faut faire
			$id_societe = $_GET['id_societe'];
			$origine = $_GET['origine'];
			//echo "<br>chgmt : $CHGMT - action : $action - rne : $id_societe<br>";
			if (isset($dep))
			{
				$_SESSION['departement_en_cours'] = $dep;
			}
			else
			{
				$dep = $_SESSION['departement_en_cours'];
			}

			if (isset($annee_scolaire))
			{
				$_SESSION['annee_scolaire'] = $annee_scolaire;
			}
			else
			{
				$annee_scolaire = $_SESSION['annee_scolaire'];
			}

			if (isset($intitule_formation))
			{
				$_SESSION['intitule_formation_en_cours'] = $intitule_formation;
			}
			else
			{
				$intitule_formation = $_SESSION['intitule_formation_en_cours'];
			}

			$dep_en_cours = $_SESSION['departement_en_cours'];
			//$sec_en_cours = $_SESSION['secteur_en_cours'];
			$intitule_formation_en_cours = $_SESSION['intitule_formation_en_cours'];

			if(!isset($tri))
			{
				$tri = "ID";
			}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////DEBUT DES CHANGEMENTS A EFFECTUER
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if ($CHGMT == "O")
			{
				//suivrons les différents procédures qui impliquent des modifications
				switch($action)
				{
					case "modif_formation" :
						include ("ecl_modif_formation.inc.php");
						$affichage = "N"; // Pour éviter que le reste du script soit exécuté
					break;

					case ('enreg_formation_modifie') : //enregistrement d'une formation modifiée
						include ("ecl_enreg_formation_modifie.inc.php");
					break;

					case ('ajout_document') : //enregistrement d'un document
						$script = "formations_gestion";
						$ticket= $_GET['ticket'];
						$module = $_GET['module'];
						$annee = $_GET['annee'];
						$type = $_GET['type'];
						$id_formation = $_GET['id_formation'];
						$rne = $_GET['rne'];
						$id_societe = $_GET['id_societe'];

						//echo "<h2>Dépôt de fichier sur le serveur pour le ticket $idpb</h2>";
						$affichage = "N"; // pour éviter que le ticket s'affiche
						include ("choix_fichier.inc.php");
					break;

					case ('suppression_formation') :
						$script = "formations_gestion";
						include ("ecl_suppression_formation.inc.php");
						$affichage = "N";
					break;

					case ('confirm_suppression_formation') :
						include ("ecl_confirm_suppression_formation.inc.php");
						//Dans le cas où aucun résultats n'est retourné
						if(!$result)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							mysql_close();
							//exit;
						}
						//il faut également supprimer les fichiers et les entrées dans la table documents concernant la formation supprimée
						efface_documents_joints($id_formation,$module,$dossier);  //Fonction qui supprime les fichiers du disue et qui efface les entrée dans la table documents
					break;

				}
			} //Fin du if CHGMT = "O"

			//Commence la partie affichage du script
			if ($affichage <>"N")
			{
				$nb_par_page = 12; //Fixe le nombre de ligne qu'il faut afficher à l'écran
				/*
				//Affectation des variables sessions pour contrôle et affichage
				$ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_intitule_formation = $_SESSION['intitule_formation'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
				echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  intitule_formation : $intitule_formation - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
				echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  intitule_formation : $ses_intitule_formation - à rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
				*/

				//Affectation du joker "%" s'il faut afficher tous les types de la table 
				if ($intitule_formation_en_cours == 'T')
				{
					$intitule_pour_requete = "%";
				}
				else
				{
					$intitule_pour_requete = $intitule_formation_en_cours;
				}        
				//La requete générale à exécuter
				//echo "<BR>tri : $tri - annee_scolaire : $annee_scolaire - intitule_formation : $intitule_formation - intitule_formation_en_cours : $intitule_formation_en_cours - intitule_pour_requete : $intitule_pour_requete - rne_a_rechercher : $rne_a_rechercher<br>";
				//echo "<br>à rechercher : $rechercher - dans : $dans<br>";
				if ($rne_a_rechercher <>"")
				{
					//echo "<br>boucle rne_a_rechercher oui<br>";
					//$query = "SELECT DISTINCT * FROM formations, etablissements WHERE etablissements.rne=formations.rne AND formations.rne='".$rne_a_rechercher."%' AND annee_en_cours = '".$annee_scolaire."' AND type_formation = '".$intitule_pour_requete."' ORDER BY id_formation DESC;";
					$query = "SELECT DISTINCT * FROM formations WHERE rne = '".$rne_a_rechercher."' AND annee_scolaire LIKE '".$annee_scolaire."' AND type_formation LIKE '".$intitule_pour_requete."' ORDER BY id_formation DESC;";
					/*
					switch ($dans)
					{
						case "T" :
							$query = "SELECT DISTINCT * FROM formations_tice, etablissements WHERE formations.rne=etablissements.rne AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND nom LIKE '%$rechercher%' OR personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND discipline LIKE '%$rechercher%' OR personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND poste LIKE '%$rechercher%' OR personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND codetab LIKE '%$rechercher%' ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;

						case "N" :
							$query = "SELECT DISTINCT * FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND nom LIKE '%$rechercher%' ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;

						case "D" :
							$query = "SELECT DISTINCT * FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND discipline LIKE '%$rechercher%' ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;

						case "P" :
							$query = "SELECT DISTINCT * FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND poste LIKE '%$rechercher%' ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;

						case "RNE" :
							$query = "SELECT DISTINCT * FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND codetab LIKE '".$rne_a_inclure."%' AND fonctions_des_personnes_ressources.fonction LIKE '".$intitule_pour_requete."' AND fonctions_des_personnes_ressources.annee = '".$annee."' AND codetab LIKE '%$rechercher%' ORDER BY personnes_ressources_tice.nom, personnes_ressources_tice.prenom ASC;";
						break;
					}
					*/
				} //Fin if $rne_a_rechercher <>""
				else
				{
					//echo "<br>boucle else<br>";
					switch ($dep)
					{
						case 'T' :
							$rne_a_inclure = "%";
							$affiche_departement = "de l'académie";
						break;

						case '18' :
							$rne_a_inclure = "018%";
							$affiche_departement = "du département du Cher";
						break;

						case '28' :
							$rne_a_inclure = "028%";
							$affiche_departement = "du département de l'Eure-et-Loire";
						break;

						case '36' :
							$rne_a_inclure = "036%";
							$affiche_departement = "du département de l'Indre";
						break;

						case '37' :
							$rne_a_inclure = "037%";
							$affiche_departement = "du département de l'Indre-et-Loire";
						break;

						case '41' :
							$rne_a_inclure = "041%";
							$affiche_departement = "du département du Loir-et-Cher";
						break;

						case '45' :
							$rne_a_inclure = "045%";
							$affiche_departement = "du département du Loiret";
						break;
					}   

					switch ($tri)
					{
						case "ID" :
							$query = "SELECT DISTINCT * FROM formations WHERE rne LIKE '".$rne_a_inclure."' AND annee_scolaire LIKE '".$annee_scolaire."' AND type_formation LIKE '".$intitule_pour_requete."' ORDER BY id_formation $sense_tri;";
						break;

						case "ANNEE" :
							$query = "SELECT DISTINCT * FROM formations WHERE rne LIKE '".$rne_a_inclure."' AND annee_scolaire LIKE '".$annee_scolaire."' AND type_formation LIKE '".$intitule_pour_requete."' ORDER BY annee_scolaire $sense_tri;";
						break;

						case "TYPE" :
							$query = "SELECT DISTINCT * FROM formations WHERE rne LIKE '".$rne_a_inclure."' AND annee_scolaire LIKE '".$annee_scolaire."' AND type_formation LIKE '".$intitule_pour_requete."' ORDER BY type_formation $sense_tri;";
						break;

						case "RNE" :
							$query = "SELECT DISTINCT * FROM formations WHERE rne LIKE '".$rne_a_inclure."' AND annee_scolaire LIKE '".$annee_scolaire."' AND type_formation LIKE '".$intitule_pour_requete."' ORDER BY rne $sense_tri;";
						break;

						default :
							$query = "SELECT DISTINCT * FROM formations WHERE rne = '".$rne_a_rechercher."' AND annee_scolaire = '".$annee_scolaire."' AND type_formation = '".$intitule_pour_requete."' ORDER BY id_formation DESC;";
						break;
					}
					//$query = "SELECT * FROM personnes_ressources_tice, fonctions_des_personnes_ressources WHERE personnes_ressources_tice.id_pers_ress=fonctions_des_personnes_ressources.id_pers_ress AND intitule_formation LIKE '".$intitule_pour_requete."' ORDER BY nom, prenom ASC;";
				} //Fin else $rne_a_rechercher <>""
				$results = mysql_query($query);
				if(!$results)
				{
					echo "<B>Problème lors de la connexion à la base de données</B>";
					echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
					mysql_close();
					exit;
				}
				/*
				//echo "<h3>".$liste_a_afficher." "." ".$secteur_a_afficher." ".$affiche_departement."</h3>";
				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);

				if(!$results)
				{
					echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
					echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
					mysql_close();
					exit;
				}
				*/
				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
					//Affichage de l'entête du tableau
					echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
					echo "<TABLE width = \"95%\">
						<TR>
							<th>";
								if ($sense_tri =="asc")
								{
									echo "ID&nbsp;<A href=\"formations_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "ID&nbsp;<A href=\"formations_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th>";
								/*
								if ($sense_tri =="asc")
								{
									echo "Ann&eacute;e scolaire<A href=\"formations_gestion.php?tri=ANNEE&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Ann&eacute;e scolaire<A href=\"formations_gestion.php?tri=ANNEE&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
								*/
								echo "Ann&eacute;e scolaire";
							echo "</th>
							<th>";
								if ($sense_tri =="asc")
								{
									echo "Type formation&nbsp;<A href=\"formations_gestion.php?tri=TYPE&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Type formation&nbsp;<A href=\"formations_gestion.php?tri=TYPE&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th>";
								if ($sense_tri =="asc")
								{
									echo "UAI&nbsp;<A href=\"formations_gestion.php?tri=RNE&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "UAI&nbsp;<A href=\"formations_gestion.php?tri=RNE&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th>
								EPLE
							</th>";

							echo "<th>
								Documents
							</th>";
							if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
							{
								echo "<th>
									ACTIONS
								</th>";
							}
							//Requète pour afficher les personnes ressources selon le filtre appliqué
							///////////////////////////////////
							//Partie sur la gestion des pages//
							///////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
							$par_navig = "0";
							/*
							echo "<br>Nombre de pages : $nombre_de_page";
							echo "<br>Nb_par_page : $nb_par_page<br>";
							*/	
							echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT>";
							If ($indice == 0)
							{
								echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
							}
							else
							{
								echo "<a href = \"formations_gestion.php?tri=$tri&amp;rne_a_rechercher=$rne_a_rechercher&amp;indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"formations_gestion.php?tri=$tri&amp;rne_a_rechercher=$rne_a_rechercher&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
									echo "&nbsp;<a href = \"formations_gestion.php?tri=$tri&amp;rechercher=$rechercher&amp;dans=$dans&amp;indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"formations_gestion.php?tri=$tri&amp;rechercher=$rechercher&amp;dans=$dans&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
							$res = mysql_fetch_row($results);
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($res[0] <>"")
								{
									echo "<TR>";
										echo "<TD align = \"center\">";
											echo $res[0];
										echo "</TD>";
										echo "<TD align = \"center\">";
											echo $res[1];
										echo "</TD>";
										echo "<TD>";
											echo $res[2];
										echo "</TD>";
										echo "<TD>";
											echo $res[3];
										echo "</TD>";

										//On rechercher l'EPLE à afficher
										$query = "SELECT * FROM etablissements WHERE RNE LIKE '".$res[3]."';";
										$res_eple = mysql_query($query);
										$eple = mysql_fetch_row($res_eple);
										echo "<TD>";
											echo "$eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
										echo "</TD>";
										echo "<TD>";
										//affichage des documents joints
										include ("affiche_documents_joints_formations.inc.php");
										echo "</TD>";

										//Les actions
										if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
										{
											echo "<TD class = \"fond-actions\">
												&nbsp;<A HREF = \"formations_gestion.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=modif_formation&amp;id_societe=".$res[3]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la formation\" border=\"0\"></A>
												&nbsp;<A HREF = \"formations_gestion.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;annee=".$res[1]."&amp;type=".$res[2]."&amp;rne=".$res[3]."&amp;module=$module&amp;id_societe=$id_societe&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"Ajouter un document\" title=\"Ajouter un document\" border=\"0\"></A>
												<!--A HREF = \"formations_gestion.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=copie_formation&amp;id_societe=".$res[3]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier la formation\" border=\"0\"></A-->
												&nbsp;<A HREF = \"formations_gestion.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=suppression_formation\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer la formation\" border=\"0\"></A>
											</TD>";	
										}
									echo "</TR>";
								} // Fin if res[0] <>""
								$res = mysql_fetch_row($results);
							} // Fin boucle for
							//Fermeture de la connexion à la BDD
							mysql_close();
				} //Fin if num_results >0
				else
				{
					if (!ISSET($origine))
					{
						echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
					}
					else
					{
						echo "<h2>Utiliser les filtres du bandeau du haut pour afficher les formations recherchées&nbsp;!</h2>";
					}
				}
			} //Fin du if du $affichage
 ?>
			</table>
		</div>
	</body>
</html>
