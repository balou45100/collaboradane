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
				$dans = $_GET['dans'];
				//$etat = $_GET['etat']; //quel genre de matériel : tout, affecté, non affecté, perdu
				//$affectation_materiel = $_GET['affectation_materiel']; //où le matériel a été affecté
				//$lettre = $_GET['lettre'];
				//$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériuel, ...
				//$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un m&triel existant (modifier, changer affectation, ...
				//$traitement = $_GET['traitement']; //Commandes ou factures
				$actions = $_GET['actions']; //On doit faire quelque chose si "O"
				$a_faire = $_GET['a_faire']; //ce qu'il faut faire comme créer une commande, modifier, supprimer, ...
				$bouton_enreg_article = $_GET['bouton_enreg_article']; //Pour savoir s'il faut ajouter l'article saisie à partir d'une commande
				$changer_etat = $_GET['changer_etat']; //Pour savoir s'il faut changer l'état d'un article
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //Pour savoir s'il faut enregistrer les modifications
				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$actions = "N";
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

/*				if(!isset($rechercher) || $rechercher == "")
				{
					$rechercher = $_SESSION['rechercher'];
				}
				else
				{
					$_SESSION['rechercher'] = $rechercher;
				}
*/
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

/*				echo "<br><b>***materiels_gestion_commandes.php***</b>";
				echo "<br>bouton_envoyer_modif : $bouton_envoyer_modif";
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
				echo "<br>actions : $actions";
				echo "<br>a_faire : $a_faire";
				echo "<br>changer_etat : $changer_etat";
				echo "<br>filtre : $filtre";
				echo "<br>rechercher : $rechercher";
				echo "<br>dans : $dans";
				echo "<br>indice : $indice";
				echo "<br>tri : $tri";
				echo "<br>sense_tri : $sense_tri<br>";
*/
////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements des actions /////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions == "O")
				{
					$id_cde = $_GET['id_cde'];
					$affiche_formulaire_ajout_article = $_GET['affiche_formulaire_ajout_article'];
					//echo "<br>id_cde : $id_cde";
					switch ($a_faire)
					{
						case "afficher_commande" :
							//echo "<h2>Je dois afficher la commande</h2>";
							include ("materiels_gestion_commandes_affiche_commande.inc.php");
							$affichage ="N";
						break; //afficher commande

						case "ajouter_commande" :
							//echo "<h2>Ajouter une commande</h2>";
							include ("materiels_gestion_commandes_ajout_commande.inc.php");
							$affichage ="N";
						break; //ajouter commande

						case "enreg_commande" :
							include ("materiels_gestion_commandes_enreg_commande.inc.php");
						break; //enreg commande

						case "modifier_commande" :
							include ("materiels_gestion_commandes_modif_commande.inc.php");
							$affichage ="N";
						break; //modifier commande

						case "maj_commande" :
							include ("materiels_gestion_commandes_maj_commande.inc.php");
							//$affichage ="N";
						break; //maj commande

						case "rechercher_commande" :
							//echo "<br>Recherche ....";
							$rechercher = $_GET['rechercher'];
							switch ($dans)
							{
								case "ID" : 
									//$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.id = '".$rechercher."'";
									$query = "SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe AND materiels_commandes.id_commande = '".$rechercher."'";
								break;

                				case "REF" : //dans référence
									//$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.denomination LIKE '%".$rechercher."%'";
									$query = "SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe AND materiels_commandes.ref_commande LIKE '%".$rechercher."%'";
				                break;

                				case "FOUR" : //dans fournisseur
									//$query_base = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.id_cde = '".$rechercher."'";
									$query = "SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe AND repertoire.societe LIKE '%".$rechercher."%'";
				                break;

							} //Fin switch dans
						break; //Fin rechercher_commande

						case "rechercher_commandes_non_livrees" :
							//echo "<br>Recherche commandes non livr&eacute;es ....";
							$query = "SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe AND materiels_commandes.date_livraison_complete = ''";
						break; //maj commande
					} //Fin switch $a_faire
				}
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des traitements des actions  ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
//////////// Compositions de la requête en fonction des différents critères0//////// ///////
////////////////////////////////////////////////////////////////////////////////////////////
				if ($actions <> "O")
				{
					$query = "SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe ";
				}
						switch ($tri)
						{
							case "ID" :
								$query_tri = " ORDER BY id_commande $sense_tri;";
							break;
					
							case "FOURNISSEUR" :
								$query_tri = " ORDER BY repertoire.societe $sense_tri;";
							break;
					
							case "DATECDE" :
								$query_tri = " ORDER BY date_commande $sense_tri;";
							break;
	
							case "CREDITS" :
								$query_tri = " ORDER BY credits $sense_tri;";
							break;
	
							case "AB" : //année budgétaire
								$query_tri = " ORDER BY anne_budgetaire $sense_tri;";
							break;

							default :
							//echo "<br>tri poar défaut";
								$query_tri = " ORDER BY annee_budgetaire DESC, id_commande DESC;";
							break;
						}
		
						$query_complete = $query.$query_tri;
						//echo "<br>query_complete : $query_complete";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// On affiche si nous venons d'une sélection
				if ($affichage <> "N")
				{
					echo "<table width = \"100%\" border = \"0\" cellpadding = \5\">";
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
										echo "<FORM ACTION = \"materiels_gestion_commandes.php\" target = \"body\" METHOD = \"GET\">";
										echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"ajouter commande\">
										<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
										<INPUT TYPE = \"hidden\" VALUE = \"ajouter_commande\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
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
									echo "</td>";
							    	echo "<td>";
/*	   									echo "<FORM ACTION = \"materiels_gestion_commandes.php\" target = \"body\" METHOD = \"GET\">";
							    			echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"commandes non livr&eacute;es compl&egrave;tement\">";
											echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
												<INPUT TYPE = \"hidden\" VALUE = \"rechercher_commandes_non_livrees\" NAME = \"a_faire\">
												<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
												<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
												<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
*/										echo "</FORM>";
							    	echo "</td>";
								}
								else
								{
							    	echo "<td>&nbsp;</td>";
							    	echo "<td>&nbsp;</td>";
								}
					    	echo "<td>&nbsp;</td>";
					    	echo "<td>";
								echo "<FORM ACTION = \"materiels_gestion_commandes.php\" target = \"body\" METHOD = \"GET\">";
						    		echo "Rechercher&nbsp;<input type=\"text\" size = \"20\" name=\"rechercher\" />";
									echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
									echo "<select size=\"1\" name=\"dans\">";
										echo "<option value=\"ID\">ID</option>";
										echo "<option value=\"REF\">REF</option>";
										echo "<option value=\"FOUR\">FOUR</option>";
									echo "</SELECT>";
									echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \">>\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
										<INPUT TYPE = \"hidden\" VALUE = \"rechercher_commande\" NAME = \"a_faire\">
										<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
										<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
										<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
								echo "</FORM>";
							echo "</td>";
					    echo "</tr>";
					echo "</table>";
					$results = mysql_query($query_complete);
					if(!$results)
					{
						echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
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
					echo "<TABLE BORDER=\"0\" ALIGN=\"CENTER\">
						<CAPTION>$intitule_tableau</CAPTION>";
						echo "<TR>";
							echo "<th align=\"center\">";
							if ($sense_tri =="asc")
							{
								echo "Id<A href=\"materiels_gestion_commandes.php?tri=ID&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par No de commande, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Id<A href=\"materiels_gestion_commandes.php?tri=ID&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par No de commande, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";
							echo "<th align=\"center\">R&eacute;f&eacute;rence</th>";

							echo "<th align=\"center\">";
							if ($sense_tri =="asc")
							{
								echo "Fournisseur<A href=\"materiels_gestion_commandes.php?tri=FOURNISSEUR&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par fournisseur, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Fournisseur<A href=\"materiels_gestion_commandes.php?tri=FOURNISSEUR&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par fournisseur, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";

							echo "<th align=\"center\">";
							if ($sense_tri =="asc")
							{
								echo "Commande du<A href=\"materiels_gestion_commandes.php?tri=DATECDE&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par Date de commande, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Commande du<A href=\"materiels_gestion_commandes.php?tri=DATECDE&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par Date de commande, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";

							echo "<th align=\"center\">livr&eacute;e le</th>";

							echo "<th align=\"center\">";
							if ($sense_tri =="asc")
							{
								echo "Cr&eacute;dits<A href=\"materiels_gestion_commandes.php?tri=CREDITS&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par cr&eacute;dits, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Cr&eacute;dits<A href=\"materiels_gestion_commandes.php?tri=CREDITS&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par cr&eacute;dits, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";

							echo "<th align=\"center\">";
							if ($sense_tri =="asc")
							{
								echo "Budget<A href=\"materiels_gestion_commandes.php?tri=ABS&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par ann&eacute;e budg&eacute;taire, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Budget<A href=\"materiels_gestion_commandes.php?tri=ABS&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par ann&eacute;e budg&eacute;taire, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";

							echo "<th align=\"center\">total</th>";
							echo "<th align=\"center\">Actions</th>";
							//Requète pour afficher les établissements selon le filtre appliqué
							///////////////////////////////////
							//Partie sur la gestion des pages//
							///////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
							echo "<B>Page&nbsp;</B>";
							If ($indice == 0)
							{
								echo "<B><big>1</big>&nbsp;</B>";
							}
							else
							{
								echo "<A HREF = \"materiels_gestion_commandes.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
							}
							//echo "<BR>indice : $indice<br>";
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
									echo "<B><big>".$page."&nbsp;</big></B>";
								}
								else
								{
									echo "<A HREF = \"materiels_gestion_commandes.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
							$id_cde = $ligne->id_commande;
							$ref_commande = $ligne->ref_commande;
							$date_commande = $ligne->date_commande;
							$date_livraison_complete = $ligne->date_livraison_complete;
							$fournisseur = $ligne->fournisseur;
							$credits = $ligne->credits;
							$annee_budgetaire = $ligne->annee_budgetaire;
							$total_commande = $ligne->total_commande;

							//echo "<br>1 : id_cat_princ : $id_cat_princ - intitule_cat_princ : $intitule_cat_princ";
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($id_cde <>"")
								{
									//Transformation des dates extraites pour l'affichage
									if (ISSET ($date_commande))
									{
										$date_commande = strtotime($date_commande);
										$date_commande = date('d/m/Y',$date_commande);
									}
									else
									{
										$date_commande = "";
									}

									if (ISSET ($date_livraison_complete))
									{
										$date_livraison_complete = strtotime($date_livraison_complete);
										$date_livraison_complete = date('d/m/Y',$date_livraison_complete);
									}
									else
									{
										$date_livraison_complete = "";
									}
									
									
									//On récupère l'intitulé du fournisseur
									$query_fournisseur = "SELECT societe FROM repertoire WHERE No_societe = '".$fournisseur."'";
									$resultat_fournisseur = mysql_query($query_fournisseur);
									$ligne_fournisseur = mysql_fetch_object($resultat_fournisseur);
									$societe = $ligne_fournisseur->societe;

									//On récupère l'intitulé des crédits
									$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire AND credits_chapitres.id_chapitre = '".$credits."'";
									$resultat_credits = mysql_query($query_credits);
									$ligne_credits = mysql_fetch_object($resultat_credits);
									$intitule_chapitre = $ligne_credits->intitule_chapitre;
									$intitule_gestionnaire = $ligne_credits->intitule_gestionnaire;
									
									//echo "<br>2 : id : $id - N° stand : $no_stand";
									//on recherche l'affectation
									echo "<TR class = \"new\">";
									echo "<TD align = \"center\">";
									echo $id_cde;
									echo "</TD>";
									echo "<TD align = \"center\">";
									echo $ref_commande;
									echo "</TD>";
									echo "<TD>";
									echo $societe;
									echo "</TD>";
									echo "<TD align = \"center\">";
									echo $date_commande;
									echo "</TD>";
									echo "<TD align = \"center\">";
									echo $date_livraison_complete;
									echo "</TD>";
									echo "<TD align = \"center\">";
										if ($intitule_chapitre <>"")
										{
											echo "$intitule_chapitre ($intitule_gestionnaire)";
										}
										else
										{
											echo "&nbsp;";
										}
									echo "</TD>";
									echo "<TD align = \"center\">";
									echo $annee_budgetaire;
									echo "</TD>";
									echo "<TD align = \"right\">";
										if ($total_commande >0)
										{
											$nombre_a_afficher = Formatage_Nombre($total_commande,$monnaie_utilise);
											echo $nombre_a_afficher;
										}
										else
										{
											echo "&nbsp;";
										}
									echo "</TD>";
									//Les actions
									echo "<TD nowrap class = \"fond-actions\">";
									if ($autorisation_gestion_materiels == 1)
									{
										echo "<A HREF = \"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;id_cde=$id_cde&amp;indice=$indice&amp;traitement=$traitement&amp;rechercher=$rechercher&amp;dans=$dans\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"Consulter la commande\"></A>";
										echo "<A HREF = \"materiels_gestion_commandes.php?actions=O&amp;a_faire=modifier_commande&amp;id_cde=$id_cde&amp;indice=$indice&amp;rechercher=$rechercher&amp;dans=$dans\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la commande\"></A>";
										//echo "<A HREF = \"materiels_gestion_structure.php?origine_gestion=filtre&amp;actions_structurelles=O&amp;a_faire=supprimer_cat_princ&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le mat&eacute;riel\"></A>";
									}

									echo "</TD>";
									echo "</TR>";
								} //Fin id <> ""

								$ligne = mysql_fetch_object($results);
								$id_cde = $ligne->id_commande;
								$ref_commande = $ligne->ref_commande;
								$date_commande = $ligne->date_commande;
								$date_livraison_complete = $ligne->date_livraison_complete;
								$fournisseur = $ligne->fournisseur;
								$credits = $ligne->credits;
								$annee_budgetaire = $ligne->annee_budgetaire;
								$total_commande = $ligne->total_commande;
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
