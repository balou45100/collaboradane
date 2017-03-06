<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><h2>$message_non_connecte1</h2></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
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
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			//Récupération des variables pour faire fonctionner ce script
			$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
			$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
			$tri = $_GET['tri']; //Tri sur quelle colonne ?
			$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
			$indice = $_GET['indice']; //à partir de quelle page
			//$rechercher = $_GET['rechercher']; //détail à rechercher
			//$etat = $_GET['etat']; //quel genre de matériel : tout, affecté, non affecté, perdu
			//$affectation_materiel = $_GET['affectation_materiel']; //où le matériel a été affecté
			//$lettre = $_GET['lettre'];
			//$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériuel, ...
			//$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un m&triel existant (modifier, changer affectation, ...
			$traitement = $_GET['traitement']; //Concerne les traitements globaux sur catégories, affectations, propriétaires
			$actions = $_GET['actions']; //On doit faire une action générale comme créer un nouveau matériel, ...
			$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
			$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
			if ($bouton_envoyer_modif == "Retourner sans enregistrer")
			{
				$actions_courantes = "N";
				$actions = "N";
			}

			$autorisation_gestion_abo = verif_appartenance_groupe(17);
			//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où
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

			if(!isset($rechercher) || $rechercher == "")
			{
				$rechercher = $_SESSION['rechercher'];
			}
			else
			{
				$_SESSION['rechercher'] = $rechercher;
			}

				
			//$_SESSION['origine'] = "materiels_gestion";

			$nb_par_page = 14; //Fixe le nombre de ligne qu'il faut afficher à l'écran

			//echo "<br><b>***abo_gestion_categories.php***</b>";
			//echo "<br>bouton_envoyer_modif : $bouton_envoyer_modif";
/*
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
			echo "<br>action : $action";
			echo "<br>actions_courantes : $actions_courantes";
			echo "<br>actions : $actions";
			echo "<br>a_faire : $a_faire";
			echo "<br>traitement : $traitement";
			echo "<br>filtre : $filtre";
			echo "<br>etat : $etat";
			echo "<br>affectation_materiel : $affectation_materiel";
			echo "<br>tri : $tri";
			echo "<br>sense_tri : $sense_tri<br>";
*/
//////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements des actions ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////
			if ($actions == "O")
			{
				$id = $_GET['id'];
				//echo "<br>id : $id";
				switch ($a_faire)
				{
					case "ajout_categorie" :
						//echo "<br>ajout_categorie";
						echo "<form id=\"monForm\" action=\"abo_gestion_categories.php\" method=\"get\">
							<fieldset>
							<legend>Saisie d'une nouvelle cat&eacute;gorie principale</legend>
								<p>
									<label for=\"form_intitule\">Intitul&eacute;&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" name=\"intitule\" />
								</p>
								<p>";
								echo "<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la catégorie\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"enreg_categorie\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</fieldset>
						</form>";
						$affichage ="N";
					break; //ajout_categorie

					case "enreg_categorie" :
						$intitule = $_GET['intitule'];
						//echo "<br>enreg_categorie - intitule : $intitule";
						$requete_enreg = "INSERT INTO abo_categorie (
						`intitule_categ`
						)
						VALUES ('".$intitule."');";
						$result_enreg = mysql_query($requete_enreg);
						if (!$result_enreg)
						{
							echo "<h2>Erreur lors de l'enregistrement</h2>";
						}
						else
						{
							echo "<h2>La nouvelle cat&eacute;gorie a bien &eacute;t&eacute; enregistr&eacute;e</h2>";
						}
					break; //enreg_categorie

					case "modifier_categorie" :
						//Il faut écupérer les champs de l'enregistrement courant
						$requete_cat_princ = "SELECT * FROM abo_categorie WHERE idcateg = '".$id."'";
						$result_cat_princ=mysql_query($requete_cat_princ);
						$num_rows = mysql_num_rows($result_cat_princ);
						$ligne_cat_princ = mysql_fetch_object($result_cat_princ);
						$idcateg = $ligne_cat_princ->idcateg;
						$intitule_categ_a_modifier = $ligne_cat_princ->intitule_categ;
						echo "<form id=\"monForm\" action=\"abo_gestion_categories.php\" method=\"get\">
						<fieldset>
						<legend>MODIFICATION</legend>
							<p>
								<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
								<input type=\"text\" id=\"form_intitule\" VALUE = \"$intitule_categ_a_modifier\"name=\"intitule\" />
							</p>
						</fieldset>
							<p>
								<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
								<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
								<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
								<INPUT TYPE = \"hidden\" VALUE = \"maj_categorie\" NAME = \"a_faire\">
								<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
								<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
								<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
								<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
								<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
								<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							</p>
						</form>";
						$affichage ="N";
					break; //modif_cat_princ

					case "maj_categorie" :
						$intitule = $_GET['intitule'];
						//echo "<br>id : $id - intitule : $intitule";
						$requete_maj = "UPDATE abo_categorie SET intitule_categ = '".$intitule."' WHERE idcateg = '".$id."';";
						$result_maj = mysql_query($requete_maj);
						if (!$result_maj)
						{
							echo "<h2>Erreur lors de l'enregistrement</h2>";
						}
						else
						{
							echo "<h2>La cat&eacute;gorie a bien &eacute;t&eacute; modifi&eacute;e</h2>";
						}
					break; //maj_categorie

					case "supprimer_categorie" :
						//On demande confirmation
						echo "<h1>Confirmer la suppression de la catégorie</h1>";
						$requete = "SELECT * FROM abo_categorie WHERE idcateg = '".$id."';";
						$resultat = mysql_query($requete);
						if(!$resultat)
						{
							echo "<br>Problème lors de la connexion à la base de données";
						}
						$ligne_extraite = mysql_fetch_object($resultat);
						$intitule = $ligne_extraite->intitule_categ;
						$idcateg = $ligne_extraite->idcateg;
						echo "<FORM ACTION = \"abo_gestion_categories.php\" METHOD = \"GET\">";
							echo "<h1>$id - $intitule</h1>";
							echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_categorie\" NAME = \"actions\">";
							echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_categorie\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
						echo "</FORM>";
						$affichage ="N";
					break; //supprimer_categorie

					case "confirme_supprimer_categorie" :
						$id = $_GET['id'];
						$requete_suppression = "DELETE FROM abo_categorie WHERE idcateg =".$id.";";
						$resultat_suppression = mysql_query($requete_suppression);
						if(!$resultat_suppression)
						{
							echo "<h2>Erreur</h2>";
						}
						else
						{
							echo "<h2>La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e.</h2>";
						}
					break; //supprimer_categorie
				} //switch ($a_faire)
			} //if ($actions == "O")
//////////////////////////////////////////////////////////////////////////////
////////////////////// Fin des actions des actions ///////////////////////////
//////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements pour l'affichage des enregistrements sélectionnés ///////
////////////////////////////////////////////////////////////////////////////////////////////
					$query = "SELECT * FROM abo_categorie ORDER BY intitule_categ";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if ($affichage <> "N")
				{
					$page_appelant = "gestion_categories";
					include ("abo_menu_principal.inc.php");

					//On compose la requte globale
					//$query = $query_base.$query_etat.$query_tri;
					$results = mysql_query($query);
					if(!$results)
					{
						echo "<h2>Problème lors de la connexion à la base de données</h2>";
						echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requète
					$num_results = mysql_num_rows($results);
					if ($num_results >0)
					{
						//Affichage de l'entête du tableau
						echo "<h2>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h2>";
						//echo "<br>intitule_tableau : $intitule_tableau<br>";
						if ($filtre == "T")
						{
							$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout;
						}
						else
						{
							$intitule_tableau = $intitule_tableau."&nbsp;".$intitule_ajout2;
						}
						echo "<TABLE>
							<CAPTION>$intitule_tableau</CAPTION>";
							echo "<TR>";
								echo "<Th>ID</th>";
								echo "<Th>INTITUL&Eacute;</th>";
								echo "<Th>ACTIONS</th>";
								//Requète pour afficher les établissements selon le filtre appliqué
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
									echo "<A HREF = \"abo_gestion_categories.php?indice=0&amp;traitement=$traitement\" target=\"body\" class=\"page_a_cliquer\">1&nbsp;</A>";
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
										echo "<A HREF = \"abo_gestion_categories.php?indice=".$nb."&amp;traitement=$traitement\" target=\"body\" class=\"page_a_cliquer\">".$page."&nbsp;</A>";
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
								$id = $ligne->idcateg;
								$intitule = $ligne->intitule_categ;
								//echo "<br>1 : idcateg : $idcateg - intitule_categ : $intitule_categ";
								if ($nombre_de_page)
								for ($i = 0; $i < $nb_par_page; ++$i)
								{
									if ($id <>"")
									{
										//echo "<br>2 : id : $id - N° stand : $no_stand";
										//on recherche l'affectation
										echo "<tr>";
											echo "<td align = \"center\">$id</td>";
											echo "<td>$intitule</td>";
											//Les actions
											echo "<td nowrap class = \"fond-actions\">";
												echo "&nbsp;<A HREF = \"abo_gestion_categories.php?origine_gestion=filtre&amp;actions=O&amp;a_faire=modifier_categorie&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
												echo "&nbsp;<A HREF = \"abo_gestion_categories.php?origine_gestion=filtre&amp;actions=O&amp;a_faire=supprimer_categorie&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le mat&eacute;riel\"></A>";
											echo "&nbsp;</td>";
										echo "</tr>";
									} //Fin id <> ""

									$ligne = mysql_fetch_object($results);
									$id = $ligne->idcateg;
									$intitule = $ligne->intitule_categ;
								}
								//Fermeture de la connexion à la BDD
								mysql_close();
					} //if ($num_results >0)
					else
					{
						echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"
?>
			</TABLE>
		</div>
	</body>
</html>
