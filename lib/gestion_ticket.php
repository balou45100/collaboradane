<?php
	//Lancement de la session
	session_start();
	error_reporting(0);

	if(!isset($_SESSION['nom']))
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

	include ("../biblio/config.php");
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include("../biblio/javascripts.php");
			//include('../biblio/init.php');
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_gestion_tickets.png\" ALT = \"Titre\">";
			//Définition des variables de session utilisées plus tard
			  $_SESSION['origine'] = "gestion_ticket";
				//Pour filtrer les tickets
				$tri = $_GET['tri'];
				$tri2 = $_GET['tri2'];
				$indice = $_GET['indice'];
				$sense_tri = $_GET['sense_tri'];
				$categorie_commune = $_GET['categorie_commune'];
				$categorie_commune_ses = $_SESSION['categorie_commune'];
				$etat = $_GET['etat']; //dans le cadre des cat. communes, actif ou archiv&eacute;
				$deverrouiller = $_GET['deverrouiller']; //Pour savoir si quelqu'un foce le d&eacute;verrouillage d'un ticket
				$idpb = $_GET['idpb'];

				//echo "<br />categorie_commune avant : $categorie_commune";
				//echo "<br />categorie_commune session avant: $categorie_commune_ses";
				if(!isset($categorie_commune) || $categorie_commune == "")
				{
					//echo "<br />Je récupère la variable session";
					$categorie_commune = $_SESSION['categorie_commune'];
				}
				else
				{
					//echo "<br />Je crée la variable session";
					$_SESSION['categorie_commune'] = $categorie_commune;
				}
				$categorie_commune_ses = $_SESSION['categorie_commune'];
				//echo "<br />categorie_commune session après: $categorie_commune_ses";

				//echo "<br />etat avant : $etat";
				//echo "<br />etat session avant: $etat_ses";
				if(!isset($etat) || $etat == "")
				{
					//echo "<br />Je r&eacute;cup&egrave;re la variable session";
					$etat = $_SESSION['etat'];
				}
				else
				{
					//echo "<br />Je crée la variable session";
					$_SESSION['etat'] = $etat;
				}
				$etat_ses = $_SESSION['etat'];
				//echo "<br />etat session après: $etat_ses";

				//Test du champ récupéré
				/*
        if(!isset($tri) || $tri == "" || !isset($indice) || $indice == "")
				{
					//echo "probl&egrave;me";
					$tri="G";
					$indice=0;
					//exit;
				}
				*/
				
        //Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où
        if(!isset($tri) || $tri == "")
				{
					$tri = $_SESSION['tri'];
				}
				else
				{
          $_SESSION['tri'] = $tri;
				}
        
        if(!isset($tri2) || $tri2 == "")
				{
					$tri2 = $_SESSION['tri2'];
        }
				else
				{
          $_SESSION['tri2'] = $tri2;
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
        
        if(!isset($dans) || $dans == "")
				{
					$dans = $_SESSION['dans'];
        }
				else
				{
          $_SESSION['dans'] = $dans;
				}
/*
				echo "<br />categorie_commune apr&egrave;s : $categorie_commune";
				echo "<br />tri : $tri";
				echo "<br />tri2 : $tri2";
				echo "<br />sense du tri : $sense_tri<br />";
*/
        //Permet de fixer l'intitul&eacute; suivant qu'il s'agit d'un EPLE ou d'une soci&eacute;t&eacute;
        if ($tri == "REP")
		{
          $afiche_intitule = "N°";
        }
        else
        {
          $afiche_intitule = "RNE";
        }
					
		//Affectation des variables sessions pour contrôle et affichage
        //$ses_origine_gestion = $_SESSION['origine_gestion'];
		$ses_indice = $_SESSION['indice'];
		//$ses_filtre = $_SESSION['filtre'];
		//$ses_rechercher = $_SESSION['rechercher'];
		//$ses_dans = $_SESSION['dans'];
		/*
        $ses_tri = $_SESSION['tri'];
		$ses_tri2 = $_SESSION['tri2'];
		$ses_sense_tri = $_SESSION['sense_tri'];
		echo "<br />variables ordinaires : indice : $indice -  tri : $tri - tri2 : $tri2 - sense_tri : $sense_tri";
        echo "<br />variables session : indice : $ses_indice -  tri : $ses_tri - tri2 : $ses_tri2 - sense_tri : $ses_sense_tri<br />";
        */
        
 				$nb_par_page = $nb_tickets_par_page_tickets;
				//echo "<br />Date du jour : $date_aujourdhui<br />";
				//Inclusion des fichiers n&eacute;cessaires
				include ("../biblio/fct.php");
				include ("../biblio/init.php");

				//Si jamais il faut d&eacute;verrouiller manuellement un ticket
				if ($deverrouiller == 'Oui')
				{
					deverouiller($idpb);
				}

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"form_ticket.php\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau ticket\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouveau ticket</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";


			echo "<table>
				<tr>
					<th>";
						if ($sense_tri =="asc")
						{
							echo "ID&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "ID&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					echo "</th>
					<th>
						ST
					</th>";
					if ($tri <> "MeAa" AND $tri <> "Me")
					{
						echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "Cr&eacute;&eacute; par&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "Cr&eacute;&eacute; par&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par &eacute;metteur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					}
					echo "
					</th>
					<th>
						Cr&eacute;&eacute; le
					</th>
					<th>";
					if ($sense_tri =="asc")
					{
						echo "Trait&eacute; par&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=TP&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par 'trait&eacute; par', ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "Trait&eacute; par&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=TP&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par 'trait&eacute; par', ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
					echo "</th>
					<th>";
					if ($sense_tri =="asc")
					{
						echo "Dern. interv.&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=DI&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par dates derni&egrave;re intervention, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "Dern. interv.&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=DI&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par dates derni&egrave;re intervention, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
					echo "</th>";
					if ($tri <> "SRNE")
					{
						echo "<th>";
						if ($sense_tri =="asc")
						{
							echo "$afiche_intitule&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=RNE&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par RNE, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "$afiche_intitule&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=RNE&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\" title=\"Trier par RNE, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					}
					echo "<th>
						Sujet
					</th>
					<th>
						Nb mes
					</th>
					<th>";
					if ($tri <> "PH")
					{
						if ($sense_tri =="asc")
						{
							echo "Priorit&eacute;&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par priorit&eacute; par ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
						}
						else
						{
							echo "Priorit&eacute;&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par priorit&eacute; par ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
						}
					}
					else 
					{
						echo "Priorit&eacute;";
					}
					echo "</th>";
					echo "<th>";
						if ($tri == "MAL")
						{
							if ($sense_tri =="asc")
							{
								echo "Alerte&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=AL&amp;indice=0&amp;sense_tri=desc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par date d'alerte, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
							}
							else
							{
								echo "Alerte&nbsp;<a href=\"gestion_ticket.php?tri=$tri&amp;tri2=AL&amp;indice=0&amp;sense_tri=asc&amp;categorie_commune=$categorie_commune\" target=\"body\"  title=\"Trier par date d'alerte, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
							}
						}
						else
						{
							//echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/alerte.png\">";
							echo "Alerte";
						}
					echo "</th>
					<th>
						Cat
					</th>
					<th>
						Actions
					</th>
				</tr>";
					
////////////////////////////////////////////////////////////////////////////////////////////
////////// Affichage pour l'administrateur /////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
////////// On regarde si nous travaillons sur les cat&eacute;gories communes //////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
					if ($categorie_commune == "Oui")
					{
						//echo "<br />affichage des tickets par rapport aux cat&eacute;gories communes";
						include("gestion_ticket_affiche_cat_com.inc.php");
					}
					else
					{
						//On appelle le fichier qui regroupe toutes les possibilit&eacute;s de requêtes, aussi en fonction
						//si l'administrateur est connect&eacute;
						include("gestion_ticket_composition_requete.inc.php");
					}
						
						//echo "<br />$requete_complete";
						
						$results = mysql_query($requete_complete);
						if(!$results)
						{
							echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
							echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
							mysql_close();
							exit;
						}
						//Retourne le nombre de ligne rendu par la requ&egrave;te
						$num_results = mysql_num_rows($results);
						echo "Nombre d'enregistrements&nbsp;:&nbsp;<strong>&nbsp;$num_results&nbsp;</strong><br />";
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
							echo "<a href = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
						}
						
						//echo "<FONT COLOR = \"#808080\"><b>Page&nbsp;</b></FONT><a href = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">1&nbsp;</a>";
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
								echo "&nbsp;<a href = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=".$nb."&amp;sense_tri=$sense_tri\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
							}
							//echo "<a href = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=".$nb."&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">".$page."&nbsp;</a>";
						}
						
						$j = 0;
						while($j<$indice) //On se positionne dans la table au niveau de l'indice de la page
						{
							$res = mysql_fetch_row($results);
							++$j;
						}
						/////////////////////////
						//Fin gestion des pages//
						/////////////////////////
						
						////////////////////////////////////////
						
						//Traitement de chaque ligne
						

						for($i = 0; $i < $nb_par_page; ++$i)
						{
							$res = mysql_fetch_row($results);
							if($res[11] != "R") //statut
							{
								$query_count = "SELECT * FROM probleme WHERE ID_PB_PERE = ".$res[0].";";
								$results_count = mysql_query($query_count);
								
								if(!$results_count)
								{
									mysql_close();
									exit;
								}
								switch ($res[13]) //priorit&eacute;
								{
									case "2":
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "1";
									$priorite_non_selection_ref_2 = "3";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									switch ($res[11])
									{
										case "M":
											$fond = "#B3CEEF";
										break;

										case "N":
											$fond = "#A4EFCA";
										break;

										case "A":
											$fond = "#FF9FA3";
										break;
									}
									break;

									case "1":
										$priorite_selection = "Haute";
										$priorite_non_selection_ref_1 = "2";
										$priorite_non_selection_ref_2 = "3";
										$priorite_non_selection_nom_1 = "Normal";
										$priorite_non_selection_nom_2 = "Basse";
										$fond = "#ff0000";
									break;

									case "3":
										$priorite_selection = "Basse";
										$priorite_non_selection_ref_1 = "1";
										$priorite_non_selection_ref_2 = "2";
										$priorite_non_selection_nom_1 = "Haute";
										$priorite_non_selection_nom_2 = "Normal";
										switch ($res[11])
										{
											case "M":
												$fond = "#B3CEEF";
											break;

											case "N":
												$fond = "#A4EFCA";
											break;

											case "A":
												$fond = "#FF9FA3";
											break;
										}
									break;

									default:
										$res[13] = "2";
										$priorite_selection = "Normal";
										$priorite_non_selection_ref_1 = "1";
										$priorite_non_selection_ref_2 = "3";
										$priorite_non_selection_nom_1 = "Haute";
										$priorite_non_selection_nom_2 = "Basse";
										switch ($res[11])
										{
											case "M":
												$fond = "#B3CEEF";
											break;

											case "N":
												$fond = "#A4EFCA";
											break;

											case "A":
												$fond = "#FF9FA3";
											break;
										}
									break;
								}
								switch ($res[14]) //Statut traitement
								{
									case "N":
										//$couleur_fond = "#ffffff";
										$classe_fond = "nouveau";
									break;

									case "C":
										//$couleur_fond = "#00cc33";
										$classe_fond = "en_cours";
									break;

									case "T":
										//$couleur_fond = "#ff0000";
										$classe_fond = "transfere";
									break;

									case "A":
										//$couleur_fond = "#ffff66";
										$classe_fond = "attente";
									break;

									case "F":
										//$couleur_fond = "#FF9FA3";
										$classe_fond = "acheve";
									break;

								}

								//Retourne le nombre de ligne rendu par la requ&egrave;te
								$num_results_count = mysql_num_rows($results_count);
								if ($res[25] == 1) //le ticket est verrouill&eacute;
								{
									//$fond = "#FFFFFF"; //le fond de la priorit&eacute; est mis &agrave; blanc
									//$couleur_fond = "#FFFFFF"; //Le fond du statut est mis &agrave; blanc
									echo "<tr class = \"verrou\">";
								}
								else
								{
									//echo "<tr class = \"".statut($res[11])."\">";
									//echo "<tr class = \"fond_tableau\">";
									echo "<tr>";
								}
								echo "<td align=\"center\">";
									echo $res[0];
								echo "</td>";
								if ($res[25] == 1) //le ticket est verrouill&eacute;
								{
									//$fond = "#FFFFFF"; //le fond de la priorit&eacute; est mis &agrave; blanc
									//$couleur_fond = "#FFFFFF"; //Le fond du statut est mis &agrave; blanc
									echo "<td align=\"center\">";
								}
								else
								{
									echo "<td class = \"$classe_fond\" align=\"center\">";
								}
								echo " ";
								echo "</td>";
								if ($tri <> "MeAa" AND $tri <> "Me")
								{
									echo "<td>";
									echo $res[3]; //cr&eacute;&eacute; par
									echo "</td>";
								}
								echo "<td>";
								//Transformation de la date de cr&eacute;ation extraite pour l'affichage
								$date_de_creation_a_afficher = strtotime($res['27']);
								$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);

								//echo $res[27]; //cr&eacute;&eacute; le 
								echo $date_de_creation_a_afficher; //cr&eacute;&eacute; le
								echo "</td>";
								echo "<td>";
									echo $res[15]; //trait&eacute; par
								echo "</td>";
								echo "<td align=\"center\">";
								If ($res[24] <> "") //derni&egrave;re intervention
								{
									$date = strtotime($res[24]);
									$date_derniere_intervention_a_afficher = date('d/m/Y',$date);
									echo $date_derniere_intervention_a_afficher;
								}
								else
								{
									echo "&nbsp;";
								}
								//echo "$res[23] \n ($res[25])"; //derni&egrave;re intervention pour tri
								echo "</td>";
								if ($tri <> "SRNE")
								{
									echo "<td>";
									//echo "<a href=# style='color:#333399' onclick=\"afficher('info_etab.php?id=".$res[4]."')\" title = \"Cliquer pour afficher l'&eacute;tablissement\">".$res[4]."</a>";
									//echo $res[4]; //RNE
									affiche_info_bulle($res[4],$res[23],$res[0]);
									echo "</td>";
								}
								echo "<td>";
								echo $res[5]; //Intitul&eacute; du ticket
								echo "</td>";
								echo "<td align=\"center\">";
								echo $num_results_count;
								echo "</td>";
//								echo "<td BGCOLOR = $fond align=\"center\">";
								echo "<td align=\"center\">";
								echo $priorite_selection;
								echo "</td>";
								$id_util = $_SESSION['id_util'];
								verif_alerte($res[0],$id_util,$date_aujourdhui,"gestion");
								echo "</td>";
								echo "<td align=\"center\">";
								verif_categorie($res[0]);
								echo "</td>";
								if ($res[25] == 1) //verrou
								{
									echo "<td>";
									if ($res[26] == $_SESSION['nom']) //verrouill&eacute; par
									{
										echo "&nbsp;&nbsp;<a href = \"gestion_ticket.php?deverrouiller=Oui&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" ALT = \"verrouill&eacute; par $res[26]\" title=\"verrouill&eacute; par $res[26], cliquer pour lib&eacute;rer le ticket\" border = \"0\"></a>&nbsp;&nbsp;";
									}
									else
									{
										echo "&nbsp;&nbsp;<a href = \"gestion_ticket.php?deverrouiller=Oui&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" ALT = \"verrouill&eacute; par $res[26]\" title=\"verrouill&eacute; par $res[26], cliquer pour lib&eacute;rer le ticket\" border = \"0\"></a>&nbsp;&nbsp;";
									}
									echo "&nbsp;<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border = \"0\"></a>";
								}
								else
								{
									//echo "<td BGCOLOR = \"#48D1CC\">";
									echo "<td nowrap class = \"fond-actions\">";
									echo "&nbsp;<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\"></a>";
									echo "&nbsp;<a href = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></a>";
									echo "&nbsp;<a href = \"affiche_categories.php?idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les cat&eacute;gories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" border = \"0\" ALT = \"Cat&eacute;gories\" border=\"0\" width=\"32px\" height=\"32px\"></a>";
									
									if (($_SESSION['nom'] == $res[3])OR ($_SESSION['droit'] == "Super Administrateur" ))
									{
										if($res[11] != "A") //statut
										{
											echo "<a href = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archiver.png\" border = \"0\" ALT = \"archiver\" title=\"Archiver ce ticket\"></a>";
											//echo "<a href = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></a>";
										}
										echo "&nbsp;<a href = \"delete_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"32px\" width=\"32px\"></a>";
									}
									
								}
								echo "&nbsp;</td>";
								echo "</tr>";
							}
						}
					//Fermeture de la connexion &agrave; la BDD
					mysql_close();
				?>
			</table>
		</div>
	</body>
</html>

