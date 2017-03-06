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
  		<title>Webradio - ressources</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>";
		$script = "ressources";
		$test = include ("WR_menu_barre.php");

	echo "<body>";
		echo "<div id = \"barre_module_13\">&nbsp;</div>";
		echo "<div id = \"menu_ressources\">menu ressources</div>";
		//echo "<div align = \"center\" class = \"espace_principal\">";
		echo "<div align = \"center\">";
			echo "<h1>Gestion des ressources</h1>";
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

			//$_SESSION['origine'] = "repertoire_gestion";

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
				//echo "<br>id : $id";
				switch ($a_faire)
				{
					case "ajout_fiche" :
						echo "<FORM ACTION = \"WR_ressources.php\" METHOD = \"POST\">";
							echo "<h2>Les d&eacute;tails &agrave; renseigner pour cr&eacute;er une nouvelle fiche</h2>";
							echo "<TABLE width=\"95%\">";
								echo "<tr>";
									echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireIntitule \" name=\"PartenaireIntitule\" size=\"78\">&nbsp;&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">Adresse&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireAdresse1\" name = \"PartenaireAdresse1\" size=\"78\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">Compl&eacute;ment d'adresse&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireAdresse2\" name = \"PartenaireAdresse2\" size=\"78\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">CP&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireCodePostal\" name=\"PartenaireCodePostal\" size=\"6\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">Ville&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireVille\" name=\"PartenaireVille\" size=\"68\"></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">Pays&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenairePays\" name=\"PartenairePays\" size=\"20\"></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">site Web&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireUrl\" name=\"PartenaireUrl\" size=\"78\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">t&eacute;l fixe&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireTelFixe\" name=\"PartenaireTelFixe\" size=\"19\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">t&eacute;l mobile&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireTelMobile\" name=\"PartenaireTelMobile\" size=\"19\">&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td class = \"etiquette\">courriel&nbsp;:&nbsp;</td>";
									echo "<td><input type=\"text\" value = \"$PartenaireCourriel\" name=\"PartenaireCourriel\" size=\"50\"></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<TD class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>";
									echo "<TD ><textarea rows=\"4\" name=\"PartenaireRemarques\" cols=\"100\">$PartenaireRemarques</textarea></TD>";
								echo "</tr>";
							echo "</table>";

							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">
							<INPUT TYPE = \"hidden\" VALUE = \"enreg_fiche\" NAME = \"a_faire\">";

							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"WR_ressources.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
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
					
					case "enreg_fiche" : //enregistrement d'une nouvelle fiche
						
						//echo "<br />J'enregistre ...";
						
						$PartenaireIntitule = $_POST['PartenaireIntitule'];
						$PartenaireAdresse1 = $_POST['PartenaireAdresse1'];
						$PartenaireAdresse2 = $_POST['PartenaireAdresse2'];
						$PartenaireCodePostal = $_POST['PartenaireCodePostal'];
						$PartenaireVille = $_POST['PartenaireVille'];
						$PartenairePays = $_POST['PartenairePays'];
						$PartenaireTelFixe = $_POST['PartenaireTelFixe'];
						$PartenaireTelMobile = $_POST['PartenaireTelMobile'];
						$PartenaireCourriel = $_POST['PartenaireCourriel'];
						$PartenaireUrl = $_POST['PartenaireUrl'];
						$PartenaireRemarques = $_POST['PartenaireRemarques'];
						
						//echo "<br />PartenaireAdresse1 : $PartenaireAdresse1";
						//echo "<br />PartenaireAdresse2 : $PartenaireAdresse2";

						if ($PartenairePays == "")
						{
							$PartenairePays = "France";
						}
						//Formatage des N°s de téléphone
						$PartenaireTelFixe = format_no_tel($PartenaireTelFixe);
						$PartenaireTelMobile = format_no_tel($PartenaireTelMobile);
						$PartenaireIntitule = strtoupper($PartenaireIntitule);
						/*  
						echo "<BR>societe : $societe - adresse : $adresse - cp : $cp - ville : $ville - tel_standard : $tel_standard - internet : $internet - fax : $fax
						<br>remarques : $remarques - editeur : $editeur - fabricant : $fabricants - service : $entreprise_de_service
						<br>presse : $presse_specialisee - à traiter : $a_traiter - à faire quand : $a_faire_quand_date - à faire : $a_faire
						<br>urgent : $urget - participation FGMM : $part_fgmm - emetteur : $emetteur - statut : $statut";

						*/ //Mise à jour de la fiche


						include("../biblio/init.php");
						$query = "INSERT INTO WR_Ressources (PartenaireIntitule, PartenaireAdresse1, PartenaireAdresse2, PartenaireCodePostal, PartenaireVille, PartenairePays, PartenaireTelFixe, PartenaireTelMobile, PartenaireCourriel, PartenaireUrl, PartenaireRemarques) 
							VALUES ('".$PartenaireIntitule."', '".$PartenaireAdresse1."', '".$PartenaireAdresse2."', '".$PartenaireCodePostal."', '".$PartenaireVille."', '".$PartenairePays."', '".$PartenaireTelFixe."', '".$PartenaireTelMobile."', '".$PartenaireCourriel."', '".$PartenaireUrl."', '".$PartenaireRemarques."');";
						
						//echo "<br />$query";
						
						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<B>Erreur de connexion à la base de données ou erreur de requète</B>";
							//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
							mysql_close();
							//exit;
						}
						else
						{
							echo "<h2>La fiche a &eacute;t&eacute; enregistr&eacute;e.</h2>";

							/*
							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</div>";
							*/
						}
					break;

				} //Fin switch a_faire
			} //Fin if action = O

			//AfficheRechercheAlphabet("SO","repertoire_gestion");

			if ($affichage <> "N")
			{
				//Bouton d'ajout de ressource
				/*
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"WR_ressources.php?action=O&amp;a_faire=ajout_fiche\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouvelle ressource\" title=\"Ins&eacute;rer une nouvelle ressource\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle ressource</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				*/
				
				//Requête initialme pour l'affichage
				$query = "SELECT * FROM WR_Ressources AS R, WR_RessourcesCategories AS RC WHERE R.RessourceCategorie = RC.idRessourceCategorie ORDER BY RessourceIntitule";
				
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
							<th>";
							if ($sense_tri =="asc")
							{
								echo "ID<A href=\"WR_ressources.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "ID<A href=\"WR_ressources.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th>";
							if ($sense_tri =="asc")
							{
								echo "Intitul&eacute;<A href=\"WR_ressources.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
							}
							else
							{
								echo "Intitul&eacute;<A href=\"WR_ressources.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
							}
							echo "</th>
							<th>
								Cat&eacute;gorie
							</th>";
							echo "<th>
								&eacute;couter
							</th>";
							echo "<th>
								ajout&eacute; le
							</th>";
							echo "<th>
								Actions
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
								echo "<a href = \"WR_ressources.php?indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"WR_ressources.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
									echo "&nbsp;<a href = \"WR_ressources.php?indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"WR_ressources.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
								}
							}

							$j = 0;
							while($j<$indice) //on se positionne sur la bonne page suivant la valeur de l'index
							{
							  $res = mysql_fetch_row($results);
								++$j;
							}
							/////////////////////////
							//Fin gestion des pages//
							/////////////////////////

							//Traitement de chaque ligne
							$res = mysql_fetch_object($results);
							
							//echo "<br />nombre de page : $nombre_de_page";
							
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								$idRessource = $res->idRessource;
								$RessourceIntitule = $res->RessourceIntitule;
								$RessourceNomFichier = $res->RessourceNomFichier;
								$RessourceCategorieNom = $res->RessourceCategorieNom;
								$RessourceNomFichier = $res->RessourceNomFichier;
								$RessourceDateCreation = $res->RessourceDateCreation;

								if ($idRessource <>"")
								{
									echo "<TR>";
										echo "<TD align = \"center\">";
											echo $idRessource;
										echo "</TD>";
										echo "<TD>";
											echo $RessourceIntitule;
										echo "</TD>";
										echo "<TD>";
											echo $RessourceCategorieNom;
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo "<audio controls=\"controls\">";
											echo "<source src=\"$dossier_webradio_ressources"."$RessourceNomFichier\" type=\"audio/ogg\" />";
											echo "Your browser does not support the audio element.";
											echo "</audio> ";
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $RessourceDateCreation;
										echo "</TD>";

										//Les actions
										echo "<TD class = \"fond-actions\">";
											/*
											echo "&nbsp;<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\" border = \"0\"></A>";
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
				
			}

 ?>
			</TABLE>
		</div>
	</body>
</html>
