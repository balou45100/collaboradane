<?php

	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
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
  		<title>Webradio - &Eacute;missions</title>
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
		$script = "emissions";
		$test = include ("WR_menu_barre.php");

	echo "<body>";
		echo "<div id = \"barre_module_11\">&nbsp;</div>";
		//echo "<div align = \"center\" class = \"espace_principal\">";
		echo "<div align = \"center\">";
			echo "<h1>Gestion des &eacute;missions</h1>";
			//Récupération des variables pour faire fonctionner ce script
			$rechercher = $_GET['rechercher']; //détail à rechercher
			$dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
			$lettre = $_GET['lettre'];
			$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériel, ...
			$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
			$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...

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
				//echo "<br>Je dois agir sur la structure...<br>";
				$id = $_GET['id'];
				$choixEmission = $_GET['choixEmission'];
				if (!ISSET($choixEmission))
				{
					$choixEmission = $_POST['choixEmission'];
				}
				
				switch ($a_faire)
				{
					case "ajout_emission" :
						include ("WR_emissions_ajout.inc.php");
					break; //ajout_categorie
					
					case "enreg_emission" : //enregistrement d'une nouvelle fiche
						include ("WR_emissions_enreg.inc.php");
					break;

					case "modif_emission" :
						echo "<h1>Modifier l'&eacute;mission $choixEmission</h1>";
						//echo "<h2>Disponible sous peu ...</h2>";
						include ("WR_emissions_modif.inc.php");
						$affichage ="N";
					break; //modif_tache

					case "maj_emission" :
						echo "<h1>Mise &agrave; jour de l'&eacute;mission $choixEmission</h1>";
						include ("WR_emissions_maj.inc.php");
					break; //maj_emission

				} //Fin switch a_faire
			} //Fin if action = O

			//AfficheRechercheAlphabet("SO","repertoire_gestion");

			if ($affichage <> "N")
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"WR_emissions.php?action=O&amp;a_faire=ajout_emission\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer une nouvelle &eacute;mission\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle &eacute;mission</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				//echo "<A HREF = \"repertoire_ajout_emission.php?action=ajout_emission\" class = \"bouton\">Insérer une nouvelle fiche</A>";
				$query = "SELECT * FROM WR_Emissions ORDER BY EmissionDateDiffusion";
				
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
							<th>";
							if ($sense_tri =="asc")
							{
								echo "NO<A href=\"WR_emissions.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "NO<A href=\"WR_emissions.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th>";
							if ($sense_tri =="asc")
							{
								echo "Intitul&eacute;<A href=\"WR_emissions.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Intitul&eacute;<A href=\"WR_emissions.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th>
								Date de diffusion
							</th>
							<th>
								Horaires
							</th>
							<th>
								Lieu d'enregistrement
							</th>
							<th>
								Classification
							</th>
							<th>
								Entr&eacute;e-s<br />Conducteur
							</th>
							<th>
								Remarques
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
								echo "<a href = \"WR_emissions.php?indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"WR_emissions.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
									echo "&nbsp;<a href = \"WR_emissions.php?indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"WR_emissions.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
										echo "<TD>";
											echo $res[1];
										echo "</TD>";
										echo "<TD align=\"center\">";
											//Transformation de la date pour un affichage à la française
											$date_a_afficher = strtotime($res[2]);
											$date_a_afficher = date('d/m/Y',$date_a_afficher);
											echo $date_a_afficher;
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo "$res[3] - $res[4]";
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $res[5];
										echo "</TD>";
										
										//On extrait les catégories de l'émission
										echo "<TD align=\"center\">";
											$requete_categ_emission = "SELECT * FROM WR_Emissions_EmissionsCategories AS EEC, WR_EmissionsCategories AS EC WHERE EEC.idEmissionsCategorie = EC.idEmissionsCategorie AND EEC.idEmission = '".$res[0]."' ORDER BY EmissionsCategorieNom";
											
											//echo "<br />requete_categ_emission : $requete_categ_emission<br />";
											
											$resultat_categ_emission = mysql_query($requete_categ_emission);
											$num_rows = mysql_num_rows($resultat_categ_emission);
											$compteur = 0;
											if (mysql_num_rows($resultat_categ_emission))
											{
												while ($ligne_categ_emission=mysql_fetch_object($resultat_categ_emission))
												{
													$compteur ++;
													$intitule_categorie = $ligne_categ_emission->EmissionsCategorieNom;
													$id_categorie = $ligne_categ_emission->idEmissionsCategorie;
													//echo "$intitule_categorie&nbsp<A HREF = \"taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_categorie&amp;id_categorie=$id_categorie&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A>&nbsp;;&nbsp;";
													if ($compteur < $num_rows)
													{
														echo "$intitule_categorie&nbsp;;&nbsp;";
													}
													else
													{
														echo $intitule_categorie;
													}
												}
											}
										echo "</TD>";
										echo "<TD align = \"center\">";
											//Il faut regarder si le conducteur a été créé et s'il est complet
											$nombre_enregistrement = compte_enregistrements("WR_Conducteurs",$res[0], "idEmission");
											echo $nombre_enregistrement;
										echo "</TD>";
										echo "<TD>";
											echo $res[6];
										echo "</TD>";
										//Les actions
										echo "<TD class = \"fond-actions\">";
											/*
											echo "&nbsp;<A HREF = \"WR_emissions.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\" border = \"0\"></A>";
											//echo "&nbsp;<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajouter_32.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";
											*/
											echo "&nbsp;<A HREF = \"WR_emissions.php?action=O&amp;a_faire=modif_emission&amp;choixEmission=$res[0]\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\" border = \"0\"></A>";
										echo "</TD>";
									echo "</TR>";
								}
								$res = mysql_fetch_row($results);
							}
							//Fermeture de la connexion à la BDD
							mysql_close();
				} //Fin if ($num_results >0)
				else
				{
					echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
				}
				
			}

 ?>
			</TABLE>
		</div>
	</body>
</html>
