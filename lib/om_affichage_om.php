<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE html>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//On inclue les fichiers de configuration et de fonctions /////
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	$de = $_GET['de']; //On récupère la demande EF ou OM
	
	//echo "<br />de : $de";

	// On vÃ©rifie le niveau des droits de la personne connectÃ©e /////
	$niveau_droits = verif_droits("evenements");
	
	//echo "<br />niveau_droits : $niveau_droits";

	//on initialise le timestamp pour la date du jour
	$date_auj = date("Y-m-d");

	//echo "<br />niveau_droits : $niveau_droits";
	//echo "<br />date_auj : $date_auj";

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		//echo "<meta charset=\"UTF-8\>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">";
?>
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
<?php
	echo "</head>";
		echo "<body>";
			echo "<center>";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_frais_deplacements.png\" ALT = \"Titre\">";
				//echo "<br />niveau_droits : $niveau_droits";
				//echo "<br />id_evenement : $id_evenement";
////////////////////////////////////////////////////////////////////////
// Initialisation des diffÃ©rentes variables ////////////////////////////
////////////////////////////////////////////////////////////////////////

// On rÃ©cupÃ¨re les variables envoyÃ©es par l'entÃªte ou envoyÃ©es par les diffÃ©rentes actions
				$origine_appel = $_GET['origine_appel']; // entete
				
				//echo "<br />origine_appel : $origine_appel";
				
				if (!ISSET($origine_appel))
				{
					$origine_appel = $_POST['origine_appel']; // entete
				}

				$action = $_GET['action'];
				if (!ISSET($action))
				{
					$action = $_POST['action'];
				}

				$a_faire = $_GET['a_faire'];
				if (!ISSET($a_faire))
				{
					$a_faire = $_POST['a_faire'];
				}

				$id_evenement = $_GET['id_evenement'];
				if (!ISSET($id_evenement))
				{
					$id_evenement = $_POST['id_evenement'];
				}

				/*
				echo "<br />origine_appel : $origine_appel";
				echo "<br />action : $action";
				echo "<br />a_faire : $a_faire";
				*/
////////////////////////////////////////////////////////////////////////
// DÃ©but du traitement des actions /////////////////////////////////////
////////////////////////////////////////////////////////////////////////
				if ($action == "O")
				{
					$id_participant = $_GET['id_participant'];
					$modif_reference_om = $_GET['modif_reference_om'];
					$modif_montant_om = $_GET['modif_montant_om'];
					$modif_reference_ef = $_GET['modif_reference_ef'];
					$modif_montant_ef = $_GET['modif_montant_ef'];
					$modif_montant_paye = $_GET['modif_montant_paye']; 
					$id_enreg_a_modifier = $_GET['id_enreg_a_modifier'];
					
					/*
					echo "<br />modif_reference_om :$modif_reference_om";
					echo "<br />modif_montant_om :$modif_montant_om";
					echo "<br />modif_reference_ef :$modif_reference_ef";
					echo "<br />modif_montant_ef :$modif_montant_ef";
					echo "<br />modif_montant_paye :$modif_montant_paye";
					echo "<br />id_enreg_a_modifier :$id_enreg_a_modifier";
					*/
					switch ($a_faire)
					{
						case "liste_emargement_valider_presences" :
							include("evenement_liste_emargement_valider_presence.inc.php");
						break;

						case "changer_etat_om" :
							$etat_om = $_GET['etat_om'];
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", $etat_om);
							// On enregistre le suivi
							// On rÃ©cupÃ¨re l'identifiant unique
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							
							//echo "<br />id_ep : $id_ep";
							
							//Et on enregistre le suivi
							enreg_suivi_om($id_ep,$etat_om,"");

						break;

						case "marquer_present" :
							$requete = "UPDATE evenements_participants SET `etat_om` = '4' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = 1 OR etat_om = 3 OR etat_om = 5)";
							$resultat = mysql_query($requete);
							if (!$resultat)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
						break;

						case "marquer_absent" :
							$requete = "UPDATE evenements_participants SET `etat_om` = '5' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND etat_om < 5";
							$resultat = mysql_query($requete);
							if (!$resultat)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
						break;

						case "changer_frais" :
							$frais = $_GET['frais'];
							maj_evenement_participant($id_evenement, $id_participant, "frais", $frais);
						break;

						case "enreg_reference_om_chorus" :
							$reference_om_chorus = $_GET['f_reference_om_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "reference_om_chorus", $reference_om_chorus);
						break;
						
						case "enreg_reference_ef_chorus" :
							$reference_ef_chorus = $_GET['f_reference_ef_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "reference_ef_chorus", $reference_ef_chorus);
							//maj_evenement_participant($id_evenement, $id_participant, "etat_om", 9);
						break;

						case "enreg_montant_om_chorus" :
							$montant_om_chorus = $_GET['f_montant_om_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "montant_om_chorus", $montant_om_chorus);
						break;

						case "enreg_montant_ef_chorus" :
							$montant_ef_chorus = $_GET['f_montant_ef_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "montant_ef_chorus", $montant_ef_chorus);
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", 9);
							//On enregistre le suivi
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							enreg_suivi_om($id_ep,"9","");
						break;

						case "enreg_montant_paye_chorus" :
							$montant_paye_chorus = $_GET['f_montant_paye_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "montant_paye_chorus", $montant_paye_chorus);
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", "14");
							//On enregistre le suivi
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							enreg_suivi_om($id_ep,"14","");
						break;

						case "valider_om_chorus" :
							$montant_paye_chorus = $_GET['f_montant_paye_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", "6");
							//On enregistre le suivi
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							enreg_suivi_om($id_ep,"5","");
						break;

						case "reviser_om_chorus" :
							$montant_paye_chorus = $_GET['f_montant_paye_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", "7");
							//On enregistre le suivi
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							enreg_suivi_om($id_ep,"6","");
						break;

						case "refuser_om_chorus" :
							$montant_paye_chorus = $_GET['f_montant_paye_chorus'];
							maj_evenement_participant($id_evenement, $id_participant, "etat_om", "8");
							//Et on enregistre le suivi
							$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
							enreg_suivi_om($id_ep,"7","");
						break;

						case "info_enregistrement" :
							echo "<h2>Infos d&eacute;taill&eacute;es</h2>";
						break;

						case "changer_annee_imputation" :
							$id_participant = $_GET['id_participant'];
							$annee_imputation = $_GET['annee_imputation'];
							$requete = "UPDATE evenements_participants SET `annee_imputation` = '".$annee_imputation."' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."'";
							$resultat = mysql_query($requete);
							if (!$resultat)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
						break;

						case "envoi_rappel" :
							$id_enregistrement = $_GET['id_enregistrement'];
							$id_participant = $_GET['id_participant'];
							$id_evenement = $_GET['id_evenement'];
							$type_rappel = $_GET['type_rappel'];
							/*
							echo "<h2>Envoi de rappel</h2>";
							echo "<br />id_enregistrement : $id_enregistrement";
							echo "<br />id_participant : $id_participant";
							echo "<br />id_evenement : $id_evenement";
							echo "<br />type_rappel : $type_rappel";
							*/
							include("om_envoi_rappel.inc.php");
						break;
					}
				}

	////////////////////////////////////////////////////////////////////////
	// Affichage de l'entÃªte du tableau ////
	////////////////////////////////////////////////////////////////////////
				if ($affichage <> "N")
				{
					if ($origine_appel == "entete")
					{
						//On récupère les variables pour le filtrage
						$statut_om = $_GET['statut_om'];
						$filtre_personne = $_GET['filtre_personne'];
						$filtre_annee = $_GET['filtre_annee'];
						$date_filtre = $_GET['date_filtre'];
						$frais = $_GET['frais'];

						/*
						echo "<br />statut_om : $statut_om";
						echo "<br />filtre_personne : $filtre_personne";
						echo "<br />filtre_annee : $filtre_annee";
						echo "<br />date_filtre : $date_filtre";
						echo "<br />frais : $frais";
						*/
						//On construit la requête
						$requete_base = "SELECT * FROM personnes_ressources_tice AS prt, evenements_participants AS ep, evenements AS e";
						$requete_condition = " WHERE prt.id_pers_ress = ep.id_participant AND e.id_evenement = ep.id_evenement";
						$requete_tri = "ORDER BY prt.nom, prt.prenom, e.date_evenement_debut DESC";

						//On construit le filtre en fonction des choix de l'utilisateur
						if ($filtre_personne <> '%')
						{
							$requete_condition = $requete_condition." AND prt.id_pers_ress = '".$filtre_personne."'";
						}

						if ($filtre_annee <> '%')
						{
							$requete_condition = $requete_condition." AND ep.annee_imputation = '".$filtre_annee."'";
						}

						if ($statut_om <> '%')
						{
							$requete_condition = $requete_condition." AND ep.etat_om = '".$statut_om."'";
						}
						else
						{
							if ($de == "om")
							{
								//$requete_condition = " WHERE prt.id_pers_ress = ep.id_participant AND e.id_evenement = ep.id_evenement AND ep.etat_om >1 AND ep.etat_om <9";
								$requete_condition .= " AND ep.etat_om >1 AND ep.etat_om <9";
							}
							else
							{
								$requete_condition .= " AND ep.etat_om >8";
							}
						}

						if ($frais <> '%')
						{
							if ($frais == 'A')
							{
								$requete_condition = $requete_condition." AND (ep.frais = 'A' OR ep.frais = 'C')";
							}
							else
							{
								$requete_condition = $requete_condition." AND ep.frais = '".$frais."'";
							}
						}

						if ($date_filtre <> '%')
						{
							if ($date_filtre == 1)
							{
								$requete_condition = $requete_condition." AND e.date_evenement_debut >= '".$date_auj."'";
							}
							elseif ($date_filtre == 2)
							{
								$requete_condition = $requete_condition." AND e.date_evenement_debut <= '".$date_auj."'";
							}
							else
							{
								$requete_condition = $requete_condition." AND e.date_evenement_debut = '".$date_filtre."'";
							}
						}

					}
					else
					{
						//On construit la requête
						$requete_base = "SELECT * FROM personnes_ressources_tice AS prt, evenements_participants AS ep, evenements AS e";
						if ($de == "om")
						{
							$requete_condition = " WHERE prt.id_pers_ress = ep.id_participant AND e.id_evenement = ep.id_evenement AND (ep.frais='A' OR ep.frais='C') AND ep.etat_om >2 AND ep.etat_om <>5 AND ep.etat_om <9";
						}
						else
						{
							$requete_condition = " WHERE prt.id_pers_ress = ep.id_participant AND e.id_evenement = ep.id_evenement AND ep.etat_om >8 AND ep.etat_om <14";
						}

						
						$requete_tri = "ORDER BY prt.nom, prt.prenom, e.date_evenement_debut DESC";
					}

					$requete_complete = $requete_base." ".$requete_condition." ".$requete_tri;
					
					//echo "<br />$requete_complete";

					
					$resultat = mysql_query($requete_complete);
					if(!$resultat)
					{
						echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
						echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
						mysql_close();
						exit;
					}

					$nbr_enregistrements = mysql_num_rows($resultat);
					
					// On affiche les totaux des sommes engagÃ©es dans les OM, EF et remboursÃ©es
					include ("om_totaux_sommes_engagees.inc.php");
					
					//On rÃ©cupÃ¨re l'id du propriÃ©taire de l'Ã©vÃ©nement
					$id_proprio = lecture_champ("evenements","fk_id_util","id_evenement",$id_evenement);
					
					//echo "<br />id_pers_ress : $id_pers_ress";
					
					if ($nbr_enregistrements == 0)
					{
						echo "<h2>Pas d'enregistrements</h2>";
					}
					else
					{
						echo "<h2>Nombre d'enregistrements : $nbr_enregistrements</h2>";
						//On affiche le tableau
						echo "<table>";
							include ("om_entete_tableau_affichage_om.inc.php");
								//On rÃ©cupÃ¨re les enregistrements
								while ($ligne = mysql_fetch_object($resultat))
								{
									$id_pers_ress = $ligne->id_pers_ress;
									$civil = $ligne->civil;
									$nom = $ligne->nom;
									$prenom = $ligne->prenom;
									$codetab = $ligne->codetab;
									$discipline = $ligne->discipline;
									$poste = $ligne->poste;
									$fonction = $ligne->fonction;
									$mel_extrait = $ligne->mel;
									$frais = $ligne->frais;
									$etat_om = $ligne->etat_om;
									$id_evenement = $ligne->id_evenement;
									$reference_om_chorus = $ligne->reference_om_chorus;
									$reference_ef_chorus = $ligne->reference_ef_chorus;
									$montant_om_chorus = $ligne->montant_om_chorus;
									$montant_ef_chorus = $ligne->montant_ef_chorus;
									$montant_paye_chorus = $ligne->montant_paye_chorus;
									$annee_imputation = $ligne->annee_imputation;
									$id_enregistrement = $ligne->id;
									$date_evenement_debut = $ligne->date_evenement_debut;
									$titre_evenement = $ligne->titre_evenement;
									
									/*
									echo "<br />date_evenement_debut : $date_evenement_debut";
									echo "<br />titre_evenement : $titre_evenement";
									echo "<br />date_evenement_debut : $date_evenement_debut";
									echo "<br />montant_om_chorus : $montant_om_chorus";
									echo "<br />montant_ef_chorus : $montant_ef_chorus";
									echo "<br />montant_paye_chorus : $montant_paye_chorus";
									*/
									//On fixe le fond de la cellule pour les frais
									switch ($frais)
									{
										case "A":
											$classe_fond = "avec";
										break;

										case "S":
											$classe_fond = "sans";
										break;

										case "C":
											$classe_fond = "sans";
										break;
									}

									//On rÃ©cupÃ¨re les infos concernant l'Ã©tablissements
									$query_etab = "SELECT TYPE, NOM, VILLE, MAIL FROM etablissements WHERE rne = '".$codetab."'";
									$resultat_etab = mysql_query($query_etab);
									$ligne_etab = mysql_fetch_object($resultat_etab);
									$type_etab = $ligne_etab->TYPE;
									$nom_etab = $ligne_etab->NOM;
									$ville_etab = $ligne_etab->VILLE;
									$mel_etab = $ligne_etab->MAIL;
									if ($id_pers_ress <> "")
									{
										$mel = $mel_extrait."@ac-orleans-tours.fr";
										echo "<tr>";
/*
											echo "<td align = \"center\">";
												echo $id_pers_ress;
											echo "</td>";
*/
											$classe_etat_om = etat_om($etat_om);
											//$om_image = "om_".$classe_etat_om.".png";
											$om_image = $classe_etat_om.".png";
											$titre_icone = etat_om_en_clair($etat_om);
											if ($etat_om < 9)
											{
												//echo "<td class = \"$classe_etat_om\" align=\"center\">";
												echo "<td class = \"fond_om\" align=\"center\">";
											}
											else
											{
												echo "<td class = \"fond_ef\" align=\"center\">";
											}
												echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/$om_image\" border=\"0\" title=\"$titre_icone\">";
												//echo "$classe_etat_om";
											echo "</td>";

											if ($_SESSION['id_util'] == 1) //C'est l'administrateur
											{
												echo "<td align = \"center\">";
													echo $id_evenement;
												echo "</td>";
											}

											echo "<td>";
												echo "&nbsp;$nom, $prenom";
											echo "</td>";

											echo "<td nowrap>";
												affiche_info_bulle($codetab,"RESS",0); //rne, module, id_ticket
											echo "</td>";

											echo "<td>";
												//On rÃ©cupÃ¨re les Ã©lÃ©ments de l'Ã©venement
												$date_debut_a_afficher = affiche_date(lecture_champ("evenements","date_evenement_debut","id_evenement",$id_evenement));
												//$date_debut_a_afficher = lecture_champ("evenements","date_evenement_debut","id_evenement",$id_evenement);
												$date_fin_a_afficher = lecture_champ("evenements","date_evenement_fin","id_evenement",$id_evenement);
												$heure_debut_a_afficher = lecture_champ("evenements","heure_debut_evenement","id_evenement",$id_evenement);
												$heure_fin_a_afficher = lecture_champ("evenements","heure_fin_evenement","id_evenement",$id_evenement);
												$titre_evenement = lecture_champ("evenements","titre_evenement","id_evenement",$id_evenement);
												if ($date_fin_a_afficher <> "0000-00-00")
												{
													$date_fin_a_afficher = affiche_date($date_fin_a_afficher);
													//echo "$date_debut_a_afficher - $date_fin_a_afficher<br />$heure_debut_a_afficher-$heure_fin_a_afficher";
													echo "$date_debut_a_afficher - $date_fin_a_afficher";
												}
												else
												{
													//echo "$date_debut_a_afficher<br />$heure_debut_a_afficher-$heure_fin_a_afficher";
													echo "$date_debut_a_afficher";
												}
											echo "</td>";
											echo "<td>";
												echo "$titre_evenement";
											echo "</td>";

											//echo "<td class = \"$classe_fond\" align=\"center\" nowrap>";
											echo "<td align=\"center\" nowrap>";
												if ($niveau_droits == 3)
												{
													if ($frais == "A")
													{
														echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\">";
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=S&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\"></a>";
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=C&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"co-voiturage\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\"></a>";
													}
													elseif ($frais == "S")
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=A&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\"></a>";
														echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\">";
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=C&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"co-voiturage\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\"></a>";
													}
													elseif ($frais == "C")
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=A&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\"></a>";
														echo "&nbsp;<a href = \"om_affichage_om.php?de=".$de."&amp;action=O&amp;a_faire=changer_frais&amp;frais=S&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\"></a>";
														echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\">";
													}
												}
											echo "</td>";

											echo "<td align = \"center\" nowrap>";
												if (($reference_om_chorus == "" AND $etat_om > 2 AND ($frais == "A" OR $frais == "C")) OR ($modif_reference_om == "O"))
												{
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";
													if ($modif_reference_om == "O")
													{
														echo "<input type = \"text\" VALUE = \"$reference_om_chorus\" NAME = \"f_reference_om_chorus\" SIZE = \"2\" required placeholder=\"R&eacute;f. OM Chorus\">";
													}
													else
													{
														echo "<input type = \"text\" VALUE = \"\" NAME = \"f_reference_om_chorus\" SIZE = \"2\" required placeholder=\"R&eacute;f. OM Chorus\">";
													}
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_reference_om_chorus\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$de\" NAME = \"de\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												elseif ($reference_om_chorus <> "")
												{
													echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;modif_reference_om=O&amp;id_enreg_a_modifier=".$id_enregistrement."&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\">$reference_om_chorus</a>";
												}
												else
												{
													echo "N/A";
												}
 											//echo "</td>";

											//echo "<td align = \"center\" nowrap>";
											echo "<br />";
												if (($reference_om_chorus <> "" AND $montant_om_chorus == "0.00") OR ($modif_montant_om == "O" AND $id_enregistrement == $id_enreg_a_modifier))
												{
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";
													if ($modif_montant_om == "O")
													{
														echo "<input type = \"text\" VALUE = \"$montant_om_chorus\" NAME = \"f_montant_om_chorus\" SIZE = \"2\" required placeholder=\"Frais OM\">";
													}
													else
													{
														echo "<input type = \"text\" VALUE = \"\" NAME = \"f_montant_om_chorus\" SIZE = \"2\" required placeholder=\"Frais OM\">";
													}
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_montant_om_chorus\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$de\" NAME = \"de\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												elseif ($montant_om_chorus <> "0.00")
												{
													//On transforme le montant en lien pour pouvoir le modifier facilemenent
													$montant_om_a_afficher = number_format($montant_om_chorus, 2, ',', ' ')."&nbsp;&euro;";
													echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;modif_montant_om=O&amp;id_enreg_a_modifier=".$id_enregistrement."&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\">$montant_om_a_afficher</a>";
												}
											echo "</td>";

											echo "<td align = \"center\" nowrap>";
												if (($reference_ef_chorus == "" AND $reference_om_chorus <> "" AND $etat_om == 6 AND $montant_om_chorus <> "0.00") OR ($modif_reference_ef == "O"))
												{
													$reference_ef_chorus_pour_affichage = $reference_om_chorus."01";
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";

													if ($modif_reference_ef == "O")
													{
														echo "<input type = \"text\" VALUE = \"$reference_ef_chorus\" NAME = \"f_reference_ef_chorus\" SIZE = \"2\" required placeholder=\"R&eacute;f. EF Chorus\">";
													}
													else
													{
														echo "<input type = \"text\" VALUE = \"$reference_ef_chorus_pour_affichage\" NAME = \"f_reference_ef_chorus\" SIZE = \"2\" required placeholder=\"R&eacute;f. OM Chorus\">";
													}
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_reference_ef_chorus\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												else
												{
													echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;modif_reference_ef=O&amp;id_enreg_a_modifier=".$id_enregistrement."&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\">$reference_ef_chorus</a>";
													//echo "$reference_ef_chorus";
												}
											//echo "</td>";

											//echo "<td align = \"center\" nowrap>";
											echo "<br />";
												if (($reference_ef_chorus <> "" AND $montant_ef_chorus == "0.00") OR ($modif_montant_ef == "O" AND $id_enregistrement == $id_enreg_a_modifier))
												{
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";
													if ($modif_montant_ef == "O" OR $montant_ef_chorus <> "0.00")
													{
														echo "<input type = \"text\" VALUE = \"$montant_ef_chorus\" NAME = \"f_montant_ef_chorus\" SIZE = \"2\" required placeholder=\"Frais EF\">";
													}
													else
													{
														echo "<input type = \"text\" VALUE = \"$montant_om_chorus\" NAME = \"f_montant_ef_chorus\" SIZE = \"2\" required placeholder=\"Frais EF\">";
													}
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_montant_ef_chorus\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												elseif ($montant_ef_chorus <> "0.00")
												{
													//On transforme le montant en lien pour pouvoir le modifier facilemenent
													$montant_ef_a_afficher = number_format($montant_ef_chorus, 2, ',', ' ')."&nbsp;&euro;";
													echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;modif_montant_ef=O&amp;id_enreg_a_modifier=".$id_enregistrement."&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\">$montant_ef_a_afficher</a>";
												}
											echo "</td>";

											echo "<td align = \"center\" nowrap>";
												if (($reference_ef_chorus <> "" AND $montant_ef_chorus <> "0.00" AND $montant_paye_chorus == "0.00" AND $etat_om == 10)  OR ($modif_montant_paye == "O" AND $id_enregistrement == $id_enreg_a_modifier))
												{
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";
													if ($modif_montant_paye == "O" OR $montant_paye_chorus <> "0.00")
													{
														echo "<input type = \"text\" VALUE = \"$montant_paye_chorus\" NAME = \"f_montant_paye_chorus\" SIZE = \"2\" required placeholder=\"Frais EF\">";
													}
													else
													{
														echo "<input type = \"text\" VALUE = \"$montant_ef_chorus\" NAME = \"f_montant_paye_chorus\" SIZE = \"2\" required placeholder=\"Frais EF\">";
													}
													
													//echo "<input type = \"text\" VALUE = \"$montant_ef_chorus\" NAME = \"f_montant_paye_chorus\" SIZE = \"2\" required placeholder=\"Frais pay&eacute;s\">";
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_montant_paye_chorus\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												elseif ($montant_paye_chorus <> "0.00")
												{
													//On transforme le montant en lien pour pouvoir le modifier facilemenent
													$montant_paye_a_afficher = number_format($montant_paye_chorus, 2, ',', ' ')."&nbsp;&euro;";
													echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;modif_montant_paye=O&amp;id_enreg_a_modifier=".$id_enregistrement."&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\">$montant_paye_a_afficher</a>";
													//echo number_format($montant_paye_chorus, 2, ',', ' ')."&nbsp;&euro;";
												}
											echo "</td>";

											echo "<td align = \"center\">";
												if ($montant_paye_chorus == "0.00")
												{
													echo "<FORM ACTION = \"om_affichage_om.php\" METHOD = \"GET\">";
													echo "<input type = \"text\" VALUE = \"$annee_imputation\" NAME = \"annee_imputation\" SIZE = \"2\" required placeholder=\"Frais pay&eacute;s\">";
													echo "<input type = \"submit\" VALUE = \">\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"changer_annee_imputation\" NAME = \"a_faire\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$statut_om\" NAME = \"statut_om\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_personne\" NAME = \"filtre_personne\">";
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$filtre_annee\" NAME = \"filtre_annee\">";
													if ($frais == "C") //pour afficher au retour tous les enregistrements pour lesquels il peut y avoir des frais
													{
														$frais = "A";
													}
													echo "<INPUT TYPE = \"hidden\" VALUE = \"$frais\" NAME = \"frais\">";
													echo "</FORM>";
												}
												else
												{
													echo $annee_imputation;
												}
											echo "</td>";
											//On recupÃ¨re le nombre de rappels associÃ©s Ã  cet enregistrement
											//$nbr_rappel51 = comptage_nbr_enregistrements_d_une_table("evenements AS e, categorie_commune AS cc","e.fk_id_dossier = cc.id_categ AND e.id_evenement = '".$id_dossier."'");
											$nbr_rappel51 = comptage_nbr_enregistrements_d_une_table("evenements_participants_suivis","fk_id_evenement = '".$id_enregistrement."' AND type_suivi = '51'");
											$nbr_rappel52 = comptage_nbr_enregistrements_d_une_table("evenements_participants_suivis","fk_id_evenement = '".$id_enregistrement."' AND type_suivi = '52'");
											$nbr_rappel53 = comptage_nbr_enregistrements_d_une_table("evenements_participants_suivis","fk_id_evenement = '".$id_enregistrement."' AND type_suivi = '53'");
											$nbr_rappel54 = comptage_nbr_enregistrements_d_une_table("evenements_participants_suivis","fk_id_evenement = '".$id_enregistrement."' AND type_suivi = '54'");
											$affichage_compteurs_rappel = "<a title = \"Cr&eacute;ation OM\">$nbr_rappel51</a>&nbsp;";
											$affichage_compteurs_rappel .= "/&nbsp;<a title = \"Cr&eacute;ation EF\">$nbr_rappel52</a>&nbsp;";
											$affichage_compteurs_rappel .= "/&nbsp;<a title = \"OM en r&eacute;vision\">$nbr_rappel53</a>&nbsp;";
											$affichage_compteurs_rappel .= "/&nbsp;<a title = \"EF en r&eacute;vision\">$nbr_rappel54</a>&nbsp;";
											echo "<td>";
												echo $affichage_compteurs_rappel;  
												//echo "$nbr_rappel51&nbsp;$nbr_rappel52&nbsp;$nbr_rappel53&nbsp;$nbr_rappel54";
											echo "</td>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// LES ACTIONS ///////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

											echo "<td class = \"fond-actions\" nowrap>";
												echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=info_enregistrement&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"Info\" title=\"Informations d&eacute;taill&eacute;es\"></a>";
												if ($niveau_droits == "3")
												{
													// on ajoute l'icone pour envoyer une relance pour les OM avec frais
													// 4 cas de figures :
													//	- etat_om = 4 (prÃ©sent-e) et Ã©venÃ¨ment passÃ©
													//	- etat_om = 6 (OM validÃ©)
													//	- etat_om = 7 (OM rÃ©visÃ©)
													//	- etat_OM = 11 (EF rÃ©visÃ©)
													
													if ($frais == "A" AND ($etat_om == 4 AND $date_evenement_debut >= '".$date_auj."') OR $etat_om == 6 OR $etat_om == 7 OR $etat_om == 11)
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=envoi_rappel&amp;type_rappel=$etat_om&amp;id_evenement=".$id_evenement."&amp;id_enregistrement=".$id_enregistrement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png\" border = \"0\" ALT = \"Rappel\" title=\"Envoyer un rappel\"></a>";
													}
													if ($etat_om == 1 OR $etat_om == 3 OR $etat_om == 5)
													{
														if ($civil <> "MME")
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=marquer_present&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/present.png\" border = \"0\" ALT = \"PRESENT\" title=\"Marquer pr&eacute;sent\"></a>";
														}
														else
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=marquer_present&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/present.png\" border = \"0\" ALT = \"PRESENTE\" title=\"Marquer pr&eacute;sente\"></a>";
														}
													}
													if ($etat_om < 5)
													{
														if ($civil <> "MME")
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=marquer_absent&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/absent.png\" border = \"0\" ALT = \"ABSENT\" title=\"Marquer absent\"></a>";
														}
														else
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=marquer_absent&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/absent.png\" border = \"0\" ALT = \"ABSENTE\" title=\"Marquer absente\"></a>";
														}
													}
											//echo "</td>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// LES ACTIONS par rapport Ã  Chorus //////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
											// Les icÃ´nes pour traiter les OM Chorus
											//echo "<td class = \"fond-actions\" nowrap>";
													if (($etat_om == 4 OR $etat_om == 7) AND $reference_ef_chorus =="" AND $reference_om_chorus <>"")
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=valider_om_chorus&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_valide.png\" border = \"0\" ALT = \"Valider OM\" title=\"Valider l'OM Chorus DT\"></a>";
													}
													if (($etat_om == 4 OR $etat_om == 6) AND $reference_ef_chorus =="" AND $reference_om_chorus <>"")
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=reviser_om_chorus&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_revise.png\" border = \"0\" ALT = \"Marquer OM r&eacute;vis&acute;\" title=\"Marquer l'OM Chorus DT r&eacute;vis&eacute;\"></a>";
													}
													if (($etat_om == 4 OR $etat_om == 6 OR $etat_om == 7) AND $reference_ef_chorus =="" AND $reference_om_chorus <>"")
													{
														echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=refuser_om_chorus&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."&amp;de=".$de."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_refuse.png\" border = \"0\" ALT = \"Refuser OM\" title=\"Refuser l'OM Chorus DT\"></a>";
													}
												}
											//echo "</td>";
											
											// Les icÃ´nes pour traiter les EF Chorus
											//echo "<td class = \"fond-actions\" nowrap>";
													if ($reference_ef_chorus <>"")
													{
														if ($etat_om == 9 OR $etat_om == 6)
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=10&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_valide.png\" border = \"0\" ALT = \"Valider EF\" title=\"Valider l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=11&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_revise.png\" border = \"0\" ALT = \"R&eacute;viser EF\" title=\"R&eacute;viser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=12&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_refuse.png\" border = \"0\" ALT = \"Refuser EF\" title=\"Refuser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=13&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_annule.png\" border = \"0\" ALT = \"Annuler EF\" title=\"Annuler l'EF Chorus DT\"></a>";
														}
														if ($etat_om == 10)
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=11&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_revise.png\" border = \"0\" ALT = \"R&eacute;viser EF\" title=\"R&eacute;viser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=12&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_refuse.png\" border = \"0\" ALT = \"Refuser EF\" title=\"Refuser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=13&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_annule.png\" border = \"0\" ALT = \"Annuler EF\" title=\"Annuler l'EF Chorus DT\"></a>";
															//echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=14&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_paye.png\" border = \"0\" ALT = \"EF rembours&eacute;\" title=\"EF rembours&eacute;\"></a>";
														}
														if ($etat_om == 11)
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=10&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_valide.png\" border = \"0\" ALT = \"Valider EF\" title=\"Valider l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=12&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_refuse.png\" border = \"0\" ALT = \"Refuser EF\" title=\"Refuser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=13&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_annule.png\" border = \"0\" ALT = \"Annuler EF\" title=\"Annuler l'EF Chorus DT\"></a>";
														}
														if ($etat_om == 12)
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=10&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_valide.png\" border = \"0\" ALT = \"Valider EF\" title=\"Valider l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=11&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_revise.png\" border = \"0\" ALT = \"R&eacute;viser EF\" title=\"R&eacute;viser l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=13&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_annule.png\" border = \"0\" ALT = \"Annuler EF\" title=\"Annuler l'EF Chorus DT\"></a>";
														}
														if ($etat_om == 13)
														{
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=10&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_valide.png\" border = \"0\" ALT = \"Valider EF\" title=\"Valider l'EF Chorus DT\"></a>";
															echo "&nbsp;<a href = \"om_affichage_om.php?action=O&amp;a_faire=changer_etat_om&amp;etat_om=11&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;origine_appel=".$origine_appel."&amp;statut_om=".$statut_om."&amp;filtre_personne=".$filtre_personne."&amp;filtre_annee=".$filtre_annee."&amp;frais=".$frais."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ef_revise.png\" border = \"0\" ALT = \"R&eacute;viser EF\" title=\"R&eacute;viser l'EF Chorus DT\"></a>";
														}
													}
											echo "</td>";
									}
								}
							echo "</tr>";
							if($nbr_enregistrements > 10)
							{
								include ("om_entete_tableau_affichage_om.inc.php");
							}
						echo "</table>";
						//On affiche la lÃ©gende
						$debut_compteur=1;
						//include ("om_legende_statut.inc.php");
					}
				}
			echo "</center>";
		echo "</body>";
	echo "</html>";
?>
