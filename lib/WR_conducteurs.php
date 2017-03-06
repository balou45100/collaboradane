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
	$theme = $_SESSION['chemin_theme']."WR_principal.css";

	echo "<!DOCTYPE html>";
	echo "<html>
	<head>
  		<title>Webradio - conducteurs</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
?>
		<script type="text/javascript">
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
		$script = "conducteurs";
		$test = include ("WR_menu_barre.php");

	echo "<body>";
		echo "<div id = \"barre_module_12\">&nbsp;</div>";
		//echo "<div align = \"center\" class = \"espace_principal\">";
		echo "<div align = \"center\">";
			echo "<h1>Gestion des conducteurs</h1>";
			//Récupération des variables pour faire fonctionner ce script
			$rechercher = $_GET['rechercher']; //détail à rechercher
			$dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
			$lettre = $_GET['lettre'];
			$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériel, ...
			$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
			$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
			$choixEmission = $_POST['choixEmission'];

			if (!ISSET($choixEmission))
			{
				$choixEmission = $_GET['choixEmission'];
			}
			//echo "<br />choixEmission : $choixEmission";
			
			
			if (!ISSET($choixEmission))
			{
				//$affichage = "N";
				$choixEmission = "-1";
			}
			

			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}

			/*
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />bouton_envoyer_modif : $bouton_envoyer_modif";
			echo "<br />choixEmission : $choixEmission";
			*/
			
			//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où

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

			if(!isset($lettre) || $lettre == "")
			{
				$lettre = $_SESSION['lettre'];
			}
			else
			{
				$_SESSION['lettre'] = $lettre;
			}

			$_SESSION['origine'] = "repertoire_gestion";

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");

			$nb_par_page = 10; //Fixe le nombre de ligne qu'il faut afficher à l'écran
			/*
			//Affectation des variables sessions pour contrôle et affichage
			echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
			*/

///////////////////////////////////////////////////////
///////////// Traitement des actions //////////////////

			if ($action == "O")
			{
				switch ($a_faire)
				{
					case "ajout_ligne_conducteur" :
						//On récupère les détails de l'émission pour laquelle on ajoute une entrée
						$requete_emission = "SELECT * FROM WR_Emissions WHERE idEmission = ".$choixEmission."";
						$resultat_requete_emission = mysql_query($requete_emission);
						$resultat_emission=mysql_fetch_object($resultat_requete_emission);
						$EmissionTitre = $resultat_emission->EmissionTitre;
						$EmissionDateDiffusion = $resultat_emission->EmissionDateDiffusion;
						$EmissionHeureDiffusionDebut = $resultat_emission->EmissionHeureDiffusionDebut;
						$EmissionHeureDiffusionFin = $resultat_emission->EmissionHeureDiffusionFin;
						$EmissionLieuEnregistrement = $resultat_emission->EmissionLieuEnregistrement;

						$EmissionDateDiffusion = strtotime($EmissionDateDiffusion);
						$EmissionDateDiffusion = date('d/m/Y',$EmissionDateDiffusion);

						echo "<FORM ACTION = \"WR_conducteurs.php\" METHOD = \"POST\">";
							echo "<h2>Les d&eacute;tails &agrave; renseigner pour cr&eacute;er une nouvelle entr&eacute;e pour le conducteur de l'&eacute;mission
								<br />$EmissionTitre enregistr&eacute;e le $EmissionDateDiffusion</h2>";

							echo "<TABLE width=\"95%\">";
								echo "<tr>";
									echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$ConducteurIntitule \" name=\"ConducteurIntitule\" size=\"78\">&nbsp;&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";

								echo "<td class = \"etiquette\">Contenu&nbsp;:&nbsp;</td>";
								//echo "<td><input type=\"text\" id=\"ConducteurContenu\"  name=\"ConducteurContenu\" value=\"\">";
									echo "<td><textarea rows = \"15\" COLS = \"120\" NAME = \"ConducteurContenu\"></textarea>";
									echo "<script type=\"text/javascript\">
										CKEDITOR.replace( 'ConducteurContenu' );
									</script>
								</td>";
								echo "</td>";
								echo "</tr>";

								echo "<tr>";
									echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</td>";
									echo "<td>";
										echo "<select size=\"1\" name=\"idRessourceCategorie\">";
											$requete = "SELECT * FROM WR_RessourcesCategories ORDER BY RessourceCategorieNom";
											
											echo "<br />$requete";
											
											$resultat = mysql_query($requete);
											$num_rows = mysql_num_rows($resultat);
											
											if (mysql_num_rows($resultat))
											{	
												while ($ligne=mysql_fetch_array($resultat))
												{
													echo"<option value=\"".$ligne[0]."\">".$ligne[1]."</option>";
												}
											}
										echo"</select>";
									echo "</td>";
								echo "</tr>";
							echo "</table>";

							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_ligne_conducteur\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$choixEmission\" NAME = \"choixEmission\">";

							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"WR_conducteurs.php?choixEmission=$choixEmission\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
										echo "</td>";
										//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
										echo "<td>";
											echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
										echo "</TD>";
										echo "</tr>";
								echo "</table>";
							echo "</div>";
						echo "</FORM>";
						$affichage = "N";
					break; //ajout_categorie
					
					case "enreg_ligne_conducteur" : //enregistrement d'une nouvelle fiche
						
						//echo "<br />J'enregistre ...";
						
						$ConducteurIntitule = $_POST['ConducteurIntitule'];
						$ConducteurContenu = $_POST['ConducteurContenu'];
						$idRessourceCategorie = $_POST['idRessourceCategorie'];

						//include("../biblio/init.php");
						//On vérifie s'il y a déjà une ligne dans le conducteur
						$requete1 = "SELECT * FROM WR_Conducteurs WHERE idEmission = $choixEmission";
						$resultat_requete1 = mysql_query($requete1);
						$nombre_enreg = mysql_num_rows($resultat_requete1);
						if ($nombre_enreg > 0)
						{
							$ConducteurNoOrdre = $nombre_enreg+1;
							
						}
						else
						{
							$ConducteurNoOrdre = 1;
						}
						
						$query = "INSERT INTO WR_Conducteurs (idEmission, idRessourceCategorie, ConducteurIntitule, ConducteurContenu, ConducteurNoOrdre)
							VALUES ('".$choixEmission."', '".$idRessourceCategorie."', '".$ConducteurIntitule."', '".$ConducteurContenu."', '".$ConducteurNoOrdre."');";

						//echo "<br />$query";

						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<B>Erreur de connexion à la base de données ou erreur de requète</B>";
							mysql_close();
							//exit;
						}
					break;

					case "ajout_fichier_son" :
						$idConducteur = $_GET['idConducteur'];
						/*
						echo "<br /><br />procédure ajout_fichier_son";
						echo "<br />choixEmission : $choixEmission";
						echo "<br />idConducteur : $idConducteur";
						*/
						//Il faut récupérer le nom du dossier, c'est à dire la date de l'enregistrement
						$nom_dossier = $dossier_webradio_ressources.$choixEmission."/";
						
						//echo "<br />nom_dossier : $nom_dossier";
						
						echo "<form name=\"upload\" enctype=\"multipart/form-data\" method=\"post\" action=\"WR_depot_fichier.php\">";
							echo "<TABLE width=\"95%\">";
								echo "<tr>";
									echo "<td class = \"etiquette\">Intitul&eacute; au document&nbsp:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"\" name=\"RessourceIntitule\" SIZE = \"50\"></td>";
									//echo "<td><input type=\"text\" value = \"$ConducteurIntitule \" name=\"ConducteurIntitule\" size=\"78\">&nbsp;&nbsp;</td>";
								echo "</tr>";

								echo "<tr>";
									echo "<td class = \"etiquette\">d&eacute;tails au sujet du document<br>(ils permettront de faire des recherches sur ce champ)&nbsp:&nbsp;</td>";
									echo "<td><TEXTAREA \" value = \"\" name=\"RessourceDescription\" rows = \"4\" cols = \"50\"></TEXTAREA></td>";
								echo "</tr>";

								echo "<tr>";
									echo "<td class = \"etiquette\">Fichier à d&eacute;poser (utilisez le bouton parcourir)&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"file\" name=\"file\" SIZE = \"40\"></td>";
								echo "</tr>";

								echo "<tr>";
										echo "<td class = \"etiquette\">Valider le d&eacute;p&ocirc;t en cliquant sur le bouton&nbsp;:&nbsp;</TD>";
										echo "<td><input type=\"submit\" name=\"bouton_submit\" value=\"Joindre le fichier\">";
								echo "</TR>";
							echo "</TABLE>";
							echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">";
							echo "<input type=\"hidden\" name=\"choixEmission\" value=\"$choixEmission\">";
							echo "<input type=\"hidden\" name=\"idConducteur\" value=\"$idConducteur\">";
							echo "<input type=\"hidden\" name=\"Dossier\" value=\"$nom_dossier\">";
							echo "<input type=\"hidden\" name=\"script\" value=\"WR_conducteurs\">";
						echo "</form>";
							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"WR_conducteurs.php?choixEmission=$choixEmission\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
										echo "</td>";
										echo "</tr>";
								echo "</table>";
							echo "</div>";

						$affichage = "N"; 
					break;

					case "changer_ordre" :
						include("WR_conducteurs_changer_ordre.inc.php");
					break;
				} //Fin switch a_faire
			} //Fin if action = O

			//AfficheRechercheAlphabet("SO","repertoire_gestion");

			//Liste déroulante pour choisir une émission à traiter

			//echo "<br />affichage : $affichage";
			
			if ($affichage <> "N")
			{
				echo "<div align = \"center\">";
					echo "<FORM ACTION = \"WR_conducteurs.php\" METHOD = \"POST\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									//Selection d'une émission pour travailler sur le conducteur
									$requete = "SELECT * FROM WR_Emissions ORDER BY EmissionDateDiffusion";
									$resultat = mysql_query($requete);
									$verif_emission = mysql_num_rows($resultat);
									if ($verif_emission >0)
									{
										echo "Choisir une &eacute;mission<br />";
										echo "<select size=\"1\" name=\"choixEmission\"";
											echo "<option selected value = \"-1\">Faire un choix</option>";
											if (mysql_num_rows($resultat))
											{	
												while ($ligne=mysql_fetch_object($resultat))
												{
													$idEmission = $ligne->idEmission;
													$EmissionTitre = $ligne->EmissionTitre;
													$EmissionDateDiffusion = $ligne->EmissionDateDiffusion;
													if ($idEmission == $choixEmission)
													{
														echo"<option selected value=\"".$idEmission."\">".$EmissionTitre." (".$EmissionDateDiffusion.")</option>";
													}
													else
													{
														echo"<option value=\"".$idEmission."\">".$EmissionTitre." (".$EmissionDateDiffusion.")</option>";
													}
												}
											}
										echo"</select>";
										echo "<br /><INPUT TYPE = \"submit\" VALUE = \"Valider\">";
									}
									else
									{
										echo "Il faut d'abord cr&eacute;er une &eacute;mission<br />";
									}

								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</form>";
				echo "</div>";
				
				if ($choixEmission <> "-1")
				{
					
				//Bouton pour l'ajout d'une entrée du conducteur
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"WR_conducteurs.php?action=O&amp;a_faire=ajout_ligne_conducteur&amp;choixEmission=$choixEmission\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Nouvelle entr&eacute;e dans le conducteur\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle entr&eacute;e dans le conducteur</span><br />";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				}

				//Requête initiale
				$query = "SELECT * FROM WR_Conducteurs AS C, WR_Emissions As E, WR_RessourcesCategories AS RC WHERE C.idEmission = E.idEmission AND C.idRessourceCategorie = RC.idRessourceCategorie AND E.idEmission = ".$choixEmission." ORDER BY C.ConducteurNoOrdre";
				
				//echo "<br />$query<br />";
				
				$results = mysql_query($query);
				if(!$results)
				{
					echo "<B>Problème lors de la connexion à la base de données</B>";
					echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
					mysql_close();
					exit;
				}

				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
					//Affichage de l'entête du tableau
					echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
					echo "<TABLE width = \"95%\">
						<CAPTION>$intitule_tableau</CAPTION>
						<TR>
							<th>Temps<br />cumul&eacute;</th>
							<th>ID</th>";
/*
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "ID<A href=\"WR_conducteurs.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "ID<A href=\"WR_conducteurs.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>";
*/
							echo "<th>No ordre</th>";
/*
							echo "<th>";
							if ($sense_tri =="asc")
							{
								echo "Intitul&eacute;<A href=\"WR_conducteurs.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Intitul&eacute;<A href=\"WR_conducteurs.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>
*/
							echo "<th>Intitul&eacute;</th>";
							echo "<th>Intervenant-e-s</th>
							<th>Dur&eacute;e<br />(en sec)</th>
							<th>Type ressource</th>
							<th>D&eacute;tail</th>";

							echo "<th>
								Ressource
							</th>";
							echo "<th>
								ACTIONS
							</th>";

							//Requète pour afficher les établissements selon le filtre appliqué
							///////////////////////////////////
							//Partie sur la gestion des pages//
							///////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
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
								echo "<a href = \"WR_conducteurs.php?indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"WR_conducteurs.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
									echo "&nbsp;<a href = \"WR_conducteurs.php?indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"WR_conducteurs.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
							//$res = mysql_fetch_row($results);
							$res = mysql_fetch_object($results);
							if ($nombre_de_page)
							$duree_cumule = 0;
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								$idConducteur = $res->idConducteur;
								$ConducteurType = $res->ConducteurType;
								$ConducteurIntitule = $res->ConducteurIntitule;
								$ConducteurContenu = $res->ConducteurContenu;
								$ConducteurLien = $res->ConducteurLien;
								$ConducteurNoOrdre = $res->ConducteurNoOrdre;
								$ConducteurDuree = $res->ConducteurDuree;
								$Conducteur = $res->Conducteur;
								$RessourceCategorieNom = $res->RessourceCategorieNom;

								$duree_cumule = $duree_cumule + $ConducteurDuree; //On incrémente la durée cumulé
								if ($idConducteur <>"")
								{
									echo "<TR>";
										echo "<TD align = \"center\">";
											echo $duree_cumule;
										echo "</TD>";
										echo "<TD align = \"center\">";
											echo $idConducteur;
										echo "</TD>";
										echo "<TD align=\"center\">";
											if ($ConducteurNoOrdre >1)
											{
												echo "<A href=\"WR_conducteurs.php?action=O&amp;a_faire=changer_ordre&amp;sense=m&amp;choixEmission=$choixEmission&amp;idConducteur=$idConducteur\"  title=\"Monter\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\">";
											}
											else
											{
												echo "&nbsp;&nbsp;";
											}
											echo "&nbsp;$ConducteurNoOrdre&nbsp;";
											if ($ConducteurNoOrdre < $num_results)
											{
												echo "<A href=\"WR_conducteurs.php?action=O&amp;a_faire=changer_ordre&amp;sense=d&amp;choixEmission=$choixEmission&amp;idConducteur=$idConducteur\"  title=\"Descendre\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\">";
											}
											else
											{
												echo "&nbsp;&nbsp;";
											}
										echo "</TD>";
										echo "<TD>";
											echo $ConducteurIntitule;
										echo "</TD>";
										echo "<TD>";
											//Intervenants à rechercher dans la table WR_intervenants
											$requete_intervenant = "SELECT * FROM WR_ConducteursIntervenants AS CI, WR_Intervenants AS I WHERE CI.idIntervenant = I.idIntervenant AND CI.idConducteur = '".$idConducteur."' ORDER BY IntervenantNom";
											
											//echo "<br />$requete_intervenant<br />";
											
											$resultat_intervenant = mysql_query($requete_intervenant);
											$num_rows = mysql_num_rows($resultat_intervenant);
											
											//echo "<br />num_rows : $num_rows";
											
											$compteur = 0;
											if (mysql_num_rows($resultat_intervenant))
											{
												while ($ligne_intervenant=mysql_fetch_object($resultat_intervenant))
												{
													$compteur ++;
													$idIntervenant = $ligne_intervenant->idIntervenant;
													$IntervenantNom = $ligne_intervenant->IntervenantNom;
													$IntervenantPrenom = $ligne_intervenant->IntervenantPrenom;
													
													//echo "$intitule_categorie&nbsp<A HREF = \"taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_categorie&amp;id_categorie=$id_categorie&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A>&nbsp;;&nbsp;";
													if ($compteur < $num_rows)
													{
														echo "$IntervenantNom&nbsp;;&nbsp;";
													}
													else
													{
														echo $IntervenantNom;
													}
													
												}
											}
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $ConducteurDuree;
										echo "</TD>";
										
										echo "<TD align=\"center\">";
											echo $RessourceCategorieNom;
										echo "</TD>";
										echo "<TD>";
											if ($ConducteurContenu <> "")
											{
												echo tronquer_chaine($ConducteurContenu,0,20);
											}
										echo "</TD>";
										echo "<TD>";
											//On regarde s'il y a une ressource associée
											$requete_ressource = "SELECT * FROM WR_ConducteursRessources AS CR, WR_Ressources AS R WHERE CR.idRessource = R.idRessource AND CR.idConducteur = '".$idConducteur."'";
											
											//echo "<br />$requete_ressource<br />";
											
											$resultat_ressource = mysql_query($requete_ressource);
											$num_rows = mysql_num_rows($resultat_ressource);
											
											//echo "<br />num_rows : $num_rows";
											
											$compteur = 0;
											if (mysql_num_rows($resultat_ressource))
											{
												while ($ligne_ressource=mysql_fetch_object($resultat_ressource))
												{
													$compteur ++;
													$idRessource = $ligne_ressource->idRessource;
													$RessourceIntitule = $ligne_ressource->RessourceIntitule;
													$RessourceNomFichier = $ligne_ressource->RessourceNomFichier;
													
													//echo "$intitule_categorie&nbsp<A HREF = \"taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_categorie&amp;id_categorie=$id_categorie&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A>&nbsp;;&nbsp;";
													//if ($compteur < $num_rows)
													//{
														$nom_dossier = $dossier_webradio_ressources.$choixEmission."/";
														//echo "<br />$nom_dossier";
														//$fichier = $dossier_webradio_ressources.$RessourceNomFichier;
														echo "<audio controls=\"controls\">";
														echo "<source src=\"$nom_dossier"."$RessourceNomFichier\" type=\"audio/ogg\" />";
														echo "Your browser does not support the audio element.";
														echo "</audio> ";
														//echo "<a target = _blank href = $dossier_webradio_ressources"."$RessourceNomFichier>$RessourceIntitule</a>";
													/*
													}
													else
													{
														echo "<a targety = _blank href = $dossier_webradio_ressources"."$RessourceNomFichier>$RessourceIntitule</a>";
													}
													*/
												}
											}
										echo "</TD>";
										//Les actions
										echo "<TD class = \"fond-actions\">";
											
											if ($num_rows <1)
											{
												echo "&nbsp;<A HREF = \"WR_conducteurs.php?choixEmission=$choixEmission&amp;action=O&amp;a_faire=ajout_fichier_son&amp;idConducteur=$idConducteur\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fichier_son_ajout.png\" ALT = \"ajouter un fichier son\" title=\"ajouter un fichier son\" border = \"0\"></A>";
											}
											else
											{
												echo "&nbsp;<A HREF = \"WR_conducteurs.php?choixEmission=$choixEmission&amp;action=O&amp;a_faire=suppression_fichier_son&amp;idConducteur=$idConducteur\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/fichier_son_suppression.png\" ALT = \"supprimer le fichier son\" title=\"supprimer le fichier son\" border = \"0\"></A>";
											}
											/*
											echo "&nbsp;<A HREF = \"WR_conducteurs.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\" border = \"0\"></A>";
											//echo "&nbsp;<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajouter_32.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";
											*/
										echo "</TD>";
									echo "</TR>";
								}
								$res = mysql_fetch_object($results);
							}
							//Fermeture de la connexion à la BDD
							mysql_close();
				} //Fin if ($num_results >0)
				else
				{
					echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
				}
			} //Fin affichage <> "N"

?>
			</TABLE>
		</div>
	</body>
</html>
