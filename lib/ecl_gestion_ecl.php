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
	<head>";
 		include ("../biblio/config.php");
 		echo "<title>$nom_espace_collaboratif</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
			include("../biblio/javascripts.php");
			//include('../biblio/init.php');
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_ecl.png\" ALT = \"Titre\">";
		//Pour filtrer les &eacute;tablissements
		$dep = $_GET['dep'];
		$filtre = $_GET['filtre'];
		$indice = $_GET['indice'];
		$secteur = $_GET['secteur'];
		$rechercher = $_GET['rechercher'];
		$dans = $_GET['dans'];
		$origine = $_GET['origine'];
		$tbi = $_GET['tbi'];
		$etat_ouvert_ferme = $_GET['etat_ouvert_ferme'];
		$entete = $_GET['entete']; //pour v&eacute;rifier si on arrive de l'entete

		/*
		echo "<br />tbi : $tbi";
		echo "<br />dep : $dep";
		echo "<br />type : $filtre";
		echo "<br />l48 etat_ouvert_ferme : $etat_ouvert_ferme";
		*/

		if (isset($indice))
		{
			$_SESSION['indice'] = $indice;
		}
		else
		{
			$indice = $_SESSION['indice'];
		}

		if (isset($rechercher))
		{
			$_SESSION['rechercher'] = $rechercher;
		}
		else
		{
			$rechercher = $_SESSION['rechercher'];
		}

		if (isset($dans))
		{
			$_SESSION['dans'] = $dans;
		}
		else
		{
			$dans = $_SESSION['dans'];
		}
		/*
		if ($dans == "")
		{
			$dans = "T";
		}
		*/

		if (isset($tbi))
		{
			$_SESSION['tbi'] = $tbi;
		}
		else
		{
			if (!ISSET($entete))
			{
				$tbi = $_SESSION['tbi'];
			}
			else
			{
				$_SESSION['tbi'] = "";
			}
		}

		if (isset($etat_ouvert_ferme))
		{
			$_SESSION['etat_ouvert_ferme'] = $etat_ouvert_ferme;
		}
		else
		{
			if (!ISSET($entete))
			{
				$etat_ouvert_ferme = $_SESSION['etat_ouvert_ferme'];
			}
			else
			{
				$_SESSION['etat_ouvert_ferme'] = "";
			}
		}

		if ($origine == "cadre_gestion")
		{
			echo "<h2>Utiliser les filtres du bandeau du haut pour afficher des &Eacute;coles ou / et des EPLE</h2>";
		}
			else
			{
				if (isset($dep))
				{
					$_SESSION['departement_en_cours'] = $dep;
				}
				else
				{
					$dep = $_SESSION['departement_en_cours'];
				}

				if (isset($secteur))
				{
					$_SESSION['secteur_en_cours'] = $secteur;
				}
				else
				{
					$secteur = $_SESSION['secteur_en_cours'];
				}

				if (isset($filtre))
				{
					$_SESSION['filtre_en_cours'] = $filtre;
				}
				else
				{
					$filtre = $_SESSION['filtre_en_cours'];
				}

				$dep_en_cours = $_SESSION['departement_en_cours'];
				$sec_en_cours = $_SESSION['secteur_en_cours'];
				$filtre_en_cours = $_SESSION['filtre_en_cours'];

				if ($etat_ouvert_ferme <> "F")
				{
					$etat_ouvert_ferme = "O";
				}

				/*
				if (!isset($filtre))
				{
					$filtre = "T";
				}
				*/
				//echo "<br />dep : $dep - departement_en_cours : $dep_en_cours - filtre : $filtre - secteur_en_cours = $sec_en_cours - rechercher : $rechercher";

				//Test du champ r&eacute;cup&eacute;r&eacute;
				/*
				if(!isset($dep) || $dep == "" || !isset($indice) || $indice == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Erreur de r&eacute;cup&eacute;ration des donn&eacute;es</B></FONT>";
					echo "<br /><a href = \"body.php\" target = \"body\" class = \"bouton\">Retour &agrave; l'accueil</a>";
					exit;
				}
				*/
				//Inclusion des fichiers n&eacute;cessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");

				$nb_par_page = 10;

				if($_SESSION['droit'] == "Super Administrateur")
				{
					echo "<a href = \"form_etab.php\" class = \"bouton\">Ins&eacute;rer un nouvel &eacute;tablissement</a><br /><br />";
				}
				//echo "<FONT COLOR = \"#00BFFF\">Pour tout envoi de message &eacute;lectronique, l'adresse de la personne connect&eacute;e est mise en copie par defaut</FONT>

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
				}

				//Affectation du joker "%" s'il faut afficher tous les types de la table
				if ($filtre_en_cours == 'T')
				{
					$type_etab = "%";
				}
				else
				{
					$type_etab = $filtre_en_cours;
				}

				//Affectation du joker "%" s'il faut afficher tous les secteurs de la table
				if ($secteur == 'T')
				{
					$secteur_pour_requete = "%";
				}
				else
				{
					$secteur_pour_requete = $secteur;
				}

				//La requete g&eacute;n&eacute;rale &agrave; ex&eacute;cuter
				//echo "<br />secteur : $secteur - secteur_pour_requete : $secteur_pour_requete - rne_a_inclure : $rne_a_inclure - type_etab : $type_etab - &agrave; rechercher : $rechercher";

				if ($rechercher <>"")
				{
					switch ($dans)
					{
						case "T" :
							$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND MAIL LIKE '%$rechercher%') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
						break;

						case "N" :
							$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
						break;

						case "V" :
							if (($rechercher == "tours") OR ($rechercher == "orleans"))
							{
								$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
							}
							else
							{
								$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
							}
						break;

						case "M" :
							$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND MAIL LIKE '%$rechercher%') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
						break;

						case "RNE" :
							$query = "SELECT * FROM etablissements WHERE RNE LIKE '".$rechercher."%' AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."';";
						break;
					}
				}
				else
				{
					if ($tbi == "O")
					{
						//echo "<br />tbi : $tbi - rne_a_inclure : $rne_a_inclure";
						$dossier = $dossier_documents;
						if ($rne_a_inclure == "%")
						{
							$query = "SELECT * FROM documents WHERE module = 'TBI' ORDER BY nom_fichier ASC;";
							//echo "<br />query: $query";
						}
						else
						{
							//echo "<br />rne_a_inclure : $rne_a_inclure<br />";
							$query = "SELECT * FROM documents WHERE module = 'TBI' AND nom_fichier LIKE '".$rne_a_inclure."%' ORDER BY nom_fichier ASC;";
							//echo "<br />query: $query";
						}
					}
					elseif ($etat_ouvert_ferme == "F")
					{
						$query = "SELECT * FROM etablissements WHERE ETAT_OUVERT_FERME = 'F' AND PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' ORDER BY RNE ASC;";
					}
					else
					{
						$query = "SELECT * FROM etablissements WHERE (PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."') AND ETAT_OUVERT_FERME = '".$etat_ouvert_ferme."' ORDER BY RNE ASC;";
					}
				}
				$results = mysql_query($query);
				if(!$results)
				{
					echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
					echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
					mysql_close();
					exit;
				}
				$num_results = mysql_num_rows($results);
				//echo "<h3>".$liste_a_afficher." "." ".$secteur_a_afficher." ".$affiche_departement."</h3>";
				//Retourne le nombre de ligne rendu par la requ&egrave;te

				//Le traitement est diff&eacute;rent suivant que l'on affiche les &eacute;tablissements par rapport aux TBI
				if ($tbi) //il ne s'agit que les &eacute;tablissement ayant rempli une enqu�te TBI
				{
					//echo "<br />Je n'affiche que les &eacute;tablissements ayant remplis une enqu�te TBI";
					echo "<table width = \"95%\">
						<caption><h3>Nombre d'enqu&ecirc;te enregistr&eacute;es&nbsp;:&nbsp;$num_results</h3>
						(Cliquer sur le nom du fichier pour visualiser l'enqu&ecirc;te)<br /></caption>
						<tr>";
							echo "<td align=\"center\">RNE</td>
							<td align=\"center\">EPLE</td>";
							echo "<td align=\"center\">Date de l'enqu&ecirc;te</td>";
							echo "<td align=\"center\">Nom du fichier</td>";
							echo "<td align=\"center\">D&eacute;tails</td>";

							/*
							if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_tbi == 1))
							{
								echo "<td align=\"center\">
								ACTIONS
								</td>";
							}
							*/
						echo "</tr>";
/////////////////////////////////////////////////////////////////////////////////////
//////////////////////// Traitement de chaque ligne /////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
						$res = mysql_fetch_row($results);

						//if ($nombre_de_page)
						for ($i = 0; $i < $num_results; ++$i)
						{
							if ($res[0] <>"") //sert dans le cadre de la gestion des pages pour ne pas afficher de lignes vides en fin de tableau
							{
								//Il faut extraire le rne du nom du fichier
								//echo "nom du fichier : $res[3]";
								$nom_fichier = $res[3];
								for ($j = 0; $j < 8; ++$j)
								{
									$rne = $rne.$res[3][$j];
									//echo "<br />rne : $rne";
								}
								echo "<tr>";
									//On rechercher l'EPLE &agrave; afficher
									$query = "SELECT * FROM etablissements WHERE RNE LIKE '".$rne."';";
									$res_eple = mysql_query($query);
									$eple = mysql_fetch_row($res_eple);
									echo "<td>$rne</td>";
									echo "<td>";
										echo "$eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
									echo "</td>";
									echo "<td align = \"center\">";
										echo $res[2];
									echo "</td>";
									echo "<td align = \"center\">";
										$lien = $dossier.$res[3];
										echo "<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res[3]\"><FONT COLOR = \"#000000\"><b>".$res[3]."</b></FONT></a>";
									echo "</td>";
									echo "<td align = \"center\">";
										echo $res[5];
									echo "</td>";

									//Les actions
									/*
									if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_tbi == 1))
									{
										echo "<td class = \"fond-actions\">&nbsp;";
										*/
										/*
										echo "<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=modif_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la formation\" border=\"0\"></a>
										<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;annee=".$res[1]."&amp;type=".$res[2]."&amp;rne=".$res[3]."&amp;module=$module&amp;id_societe=$id_societe&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/docs_joints.png\" ALT = \"Ajouter un document\" title=\"Ajouter un document\" border=\"0\"></a>
										<!--A HREF = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=copie_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier la formation\" border=\"0\"></A-->
										<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=suppression_formation\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer la formation\" border=\"0\"></a>";
										*/

										//echo "</td>";
										//echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></a>";
										//echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\"></a>";
										//echo "<a href = \"formations_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></a>";
										//echo "<a href = \"formations_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></a>";
										/*
										echo "</td>";
									}
										*/
									echo "</tr>";
							} //Fin du if res[0] ==""
							$rne ="";
							$res = mysql_fetch_row($results);
						}
						echo "</table>";

				} //Fin du if $tbi
				else
				{
					if ($num_results >0)
					{
						//Affichage de l'ent�te du tableau
						echo "<h2>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h2>";
						echo "<br />
						<table width = \"95%\">
							<tr>
								<th>
									RNE
								</th>
								<th>
									TYPE
								</th>
								<th>
									DENOMMINATION
								</th>
								<th>
									VILLE
								</th>
								<th>
									T&Eacute;L
								</TD align=\"center\">
								<!--TD align=\"center\">
									CIRC.
								</TD-->
								<th>
									M&Eacute;L
									<br /><small><small>Cliquer sur l'adresse pour envoyer un message<br />(l'adresse de la personne connect&eacute;e est mise en copie par defaut)</small></small>
								</th>";

								if (verif_appartenance_groupe(18)) //gestion tickets
								{
									echo "<th>";
										echo "TICKETS<br /><small><small>En cours / Archiv&eacute;s / Total</small></small>";
									echo "</th>";
								}

								echo "<th>
									ACTIONS
								</th>";

								//Requ&egrave;te pour afficher les &eacute;tablissements selon le filtre appliqu&eacute;

								///////////////////////////////////
								//Partie sur la gestion des pages//
								///////////////////////////////////
								$nb_page = number_format($num_results/$nb_par_page,1);
								$par_navig = "0";

								echo "Page&nbsp;";
								If ($indice == 0)
								{
									echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
								}
								else
								{
									echo "<a href = \"ecl_gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"page_a_cliquer\">1&nbsp;</a>";
								}

								//echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><a href = \"ecl_gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">1&nbsp;</a>";
								for($j = 1; $j<$nb_page; ++$j)
								{
									$nb = $j * $nb_par_page;
									$page = $j + 1;
									$par_navig++;
									if($par_navig=="41")
									{
										echo "<br />";
										$par_navig=0;
									}
									if ($page * $nb_par_page == $indice + $nb_par_page)
									{
										//echo "<FONT COLOR = \"#000000\"><B><big>".$page."&nbsp;</big></B></FONT>";
										echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
									}
									else
									{
										echo "<a href = \"ecl_gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=".$nb."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"page_a_cliquer\">".$page."&nbsp;</a>";
									}
									//echo "<a href = \"ecl_gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=".$nb."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</a>";
								}

								$j = 0;
								while($j<$indice)
								{
									$res = mysql_fetch_row($results);
									++$j;
								}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// Fin gestion des pages ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// Traitement de chaque ligne //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
								$res = mysql_fetch_row($results);
								for ($i = 0; $i < $nb_par_page; ++$i)
								{
									//Requ&egrave;te pour voir le nombre de probl&egrave;mes non archiv&eacute;s pour un &eacute;tablissement
									//$query_nb_pb = "SELECT COUNT(*) FROM probleme WHERE  NUM_ETABLISSEMENT = '".$res[0]."' AND STATUT != 'R';";
									//$results_nb_pb = mysql_query($query_nb_pb);
									$query_nb_pb = "SELECT COUNT(*) FROM probleme WHERE  NUM_ETABLISSEMENT = '".$res[0]."' AND STATUT != 'R' AND STATUT != 'A';";
									$results_nb_pb = mysql_query($query_nb_pb);
									if(!$results_nb_pb)
									{
										echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
										echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
										mysql_close();
										exit;
									}
									$nb_pb = mysql_fetch_row($results_nb_pb);

									//Requ&egrave;te pour voir le nombre de probl&egrave;mes archiv&eacute;s pour un &eacute;tablissement
									$query_nb_pb_a = "SELECT COUNT(*) FROM probleme WHERE  NUM_ETABLISSEMENT = '".$res[0]."' AND STATUT = 'A';";
									$results_nb_pb_a = mysql_query($query_nb_pb_a);
									$nb_pb_a = mysql_fetch_row($results_nb_pb_a);

									$nb_pb_total = $nb_pb[0]+$nb_pb_a[0];

									//Requ&egrave;te pour selectionner toutes les formules de politesses
									$query_politesse = "SELECT * FROM politesse WHERE Id_politesse = '".$res[10]."';";
									$results_politesse = mysql_query($query_politesse);
									if(!$results_politesse)
									{
										echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
										echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
										mysql_close();
										exit;
									}
									$politesse = mysql_fetch_row($results_politesse);
									if ($res[0] <>"")
									{
										if ($res[15] == "O")
										{
											echo "<tr>";
										}
										else
										{
											echo "<tr class = \"ferme\">";
										}
											echo "<td>";
												if ($res[15] == "O")
												{
													echo $res[0];
												}
												else
												{
													echo "$res[0] (ferm&eacute;)";
												}
											echo "</td>";
											echo "<td align=\"center\">";
												echo strtoupper(str_replace("*", " ",$res[1]));
												echo "&nbsp;".strtoupper($res[2]);
											echo "</td>";
											echo "<td>";
												echo strtoupper(str_replace("*", " ",$res[3]));
											echo "</td>";
											echo "<td>";
												//echo strtoupper(str_replace("*", " ",$res[4]));
												//echo "<br />".str_replace("*", " ",$res[6]);
												echo "&nbsp;".strtoupper(str_replace("*", " ",$res[5]));
											echo "</td>";
											echo "<td>";
												echo $res[7];
											echo "</td>";
											echo "<td>";
												if($res[8] != "")
												{
													//Lien pour envoyer un mail
													echo "<a href = \"mailto:".str_replace(" ", "*",$res[8])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\">".$res[8]."</a>";
												}
											echo "</td>";

											if (verif_appartenance_groupe(18)) //gestion tickets
											{
												echo "<td align=\"center\">";
													echo "<b>$nb_pb[0]</b> / $nb_pb_a[0] / $nb_pb_total";
												echo "</td>";
											}

											echo "<td nowrap class = \"fond-actions\">";
												echo "&nbsp;<a href = \"ecl_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_personnes_ressources=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\" border = \"0\"></a>";
												if ($nb_pb_total==0)
												{
													if (verif_appartenance_groupe(18)) //gestion tickets
													{
														echo "&nbsp;<a href = \"verif_ticket.php?etab=".$res[0]."&amp;origine=gest_ecl&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
													}
												}
												if($_SESSION['droit'] == "Super Administrateur")
												{
													echo "&nbsp;<a href = \"delete_etab.php?rne=".$res[0]."&amp;denomination=".str_replace(" ", "*",$res[3])."&amp;adresse=".str_replace(" ", "*",$res[4])."&amp;CP=".str_replace(" ", "*",$res[6])."&amp;ville=".str_replace(" ", "*",$res[5])."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
													echo "&nbsp;<a href = \"modif_etab.php?rne=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" border = \"0\"></a>";
												}
												//echo "&nbsp;<a href = \"reunion__.php?rne=".$res[0]."&amp;denomination=".str_replace(" ", "*",$res[3])."&amp;adresse=".str_replace(" ", "*",$res[4])."&amp;CP=".str_replace(" ", "*",$res[6])."&amp;ville=".str_replace(" ", "*",$res[5])."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" ALT = \"r�union\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
												if (verif_appartenance_groupe(25)) //suivi dossier
												{
													echo "&nbsp;<a href = \"suivi_ajout.php?etab=".$res[0]."&amp;origine=ecl_gestion_ecl&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\" title=\"Ajouter un suivi\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivi_ajout.png\" ALT = \"Ajouter un suivi\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
													echo "&nbsp;<a href = \"evenement_ajout.php?etab=".$res[0]."&amp;origine=ecl_gestion_ecl&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\" title=\"Ajouter un &eacute;v&eacute;nement\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/evenement_ajout.png\" ALT = \"Ajouter un &eacute;v&eacute;nement\" height=\"24px\" width=\"24px\" border = \"0\"></a>";
												}
											echo "</td>";
										echo "</tr>";
									}
									$res = mysql_fetch_row($results);
								}
								//Fermeture de la connexion &agrave; la BDD
								mysql_close();
					}
					else
					{
						echo "<h2> Recherche infructueuse, modifiez les param&egrave;tres&nbsp;!</h2>";
					}
				} //Fin du else de $tbi

			}
?>
			</table>
		</div>
	</body>
</html>
