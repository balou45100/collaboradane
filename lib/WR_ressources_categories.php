delet.pn,g<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><h2>$message_non_connecte1</h2></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
	$theme = $_SESSION['chemin_theme']."WR_principal.css";
	echo "<!DOCTYPE html>";
	echo "<html>
	<head>
  		<title>Webradio - Ressources</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>";
		$script = "ressources_categories";
		$test = include ("WR_menu_barre.php");
		//echo "<br />test : $test";
		
		echo "<div id = \"barre_module_21\">&nbsp;</div>";
		//echo "<div align = \"center\" class = \"espace_principal\">";
		echo "<div align = \"center\">";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");

			echo "<h1>Gestion des cat&eacute;gories des ressources</h1>";
				//Récupération des variables pour faire fonctionner ce script
				$action = $_GET['action']; //On doit faire une action générale comme créer un nouveau matériel, ...
				$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
				$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...

				if ($bouton_envoyer_modif == "Retourner sans enregistrer")
				{
					$action = "N";
				}

				$nb_par_page = 14; //Fixe le nombre de ligne qu'il faut afficher à l'écran

				/*
				//echo "<br><b>***WR_ressources_categories.php***</b>";
				//echo "<br>bouton_envoyer_modif : $bouton_envoyer_modif";
				echo "<br>action : $action";
				echo "<br>a_faire : $a_faire";
				*/
///////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements des actions  ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////
				if ($action == "O")
				{
					//echo "<br>Je dois agir sur la structure...<br>";
					$id = $_GET['id'];
					//echo "<br>id : $id";
					switch ($a_faire)
					{
						case "ajout_categorie" :
							//echo "<br>ajouter_categorie";
							echo "<form id=\"monForm\" action=\"WR_ressources_categories.php\" method=\"get\">
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
										<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">
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
							$requete_enreg = "INSERT INTO WR_RessourcesCategories (
							`RessourceCategorieNom`
							)
							VALUES ('".$intitule."');";
							$result_enreg = mysql_query($requete_enreg);
							if (!$result_enreg)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>La nouvelle cat&eacute;gorie a bien &eacute;t&eacute; enregistr&eacute;e";
							}
						break; //enreg_categorie

						case "modifier_categorie" :
							//Il faut écupérer les champs de l'enregistrement courant
							$requete_categorie = "SELECT * FROM WR_RessourcesCategories WHERE idRessourceCategorie = '".$id."'";
							$result_categorie=mysql_query($requete_categorie);
							$num_rows = mysql_num_rows($result_categorie);
							$ligne_categorie = mysql_fetch_object($result_categorie);
							$idRessourceCategorie = $ligne_categorie->idRessourceCategorie;
							$RessourceCategorieNom_a_modifier = $ligne_categorie->RessourceCategorieNom;
							echo "<form id=\"monForm\" action=\"WR_ressources_categories.php\" method=\"get\">
							<fieldset>
							<legend>MODIFICATION</legend>
								<p>
									<label for=\"form_no_srie\">D&eacute;nomination&nbsp;:&nbsp;</label>
									<input type=\"text\" id=\"form_intitule\" VALUE = \"$RessourceCategorieNom_a_modifier\"name=\"intitule\" />
								</p>
							</fieldset>
								<p>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
									<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
									<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
									<INPUT TYPE = \"hidden\" VALUE = \"maj_categorie\" NAME = \"a_faire\">
									<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">
									<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
									<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">
									<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
									<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
									<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
								</p>
							</form>";
							$affichage ="N";
						break; //modif_categorie

						case "maj_categorie" :
							$intitule = $_GET['intitule'];
							//echo "<br>id : $id - intitule : $intitule";
							$requete_maj = "UPDATE WR_RessourcesCategories SET RessourceCategorieNom = '".$intitule."' WHERE idRessourceCategorie = '".$id."';";
							$result_maj = mysql_query($requete_maj);
							if (!$result_maj)
							{
								echo "<h2>Erreur lors de l'enregistrement</h2>";
							}
							else
							{
								echo "<h2>La cat&eacute;gorie a bien &eacute;t&eacute; modifi&eacute;e</h2>";
							}
						break; //modif_categorie

						case "supprimer_categorie" :
							//On demande confirmation
							echo "<h1>Confirmer la suppression de la catégorie</h1>";
							$requete = "SELECT * FROM WR_RessourcesCategories WHERE idRessourceCategorie = '".$id."';";
							$resultat = mysql_query($requete);
							if(!$resultat)
							{
								echo "<br>Problème lors de la connexion à la base de données";
							}
							$ligne_extraite = mysql_fetch_object($resultat);
							$intitule = $ligne_extraite->RessourceCategorieNom;
							$idRessourceCategorie = $ligne_extraite->idRessourceCategorie;
							echo "<FORM ACTION = \"WR_ressources_categories.php\" METHOD = \"GET\">";
								echo "<h1>$id - $intitule</h1>";
								echo "<br><INPUT src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette cat&eacute;gorie\" border = \"0\" TYPE = image VALUE = \"confirme_supprimer_categorie\" NAME = \"action\">";
								echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$indice."\" NAME = \"indice\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"confirme_supprimer_categorie\" NAME = \"a_faire\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"$traitement\" NAME = \"traitement\">";
							echo "</FORM>";
							$affichage ="N";
						break; //supprimer_categorie

						case "confirme_supprimer_categorie" :
							$id = $_GET['id'];
							$requete_suppression = "DELETE FROM WR_RessourcesCategories WHERE idRessourceCategorie =".$id.";";
							$resultat_suppression = mysql_query($requete_suppression);
							if(!$resultat_suppression)
							{
								echo "<h2>Erreur</h2>";
							}
							else
							{
								echo "<h2>La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e.<h2>";
							}
						break; //supprimer_categorie
					}
				}

//////////////////////////////////////////////////////////////////
////////////////////// Fin des actions ///////////////////////////
//////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début des traitements pour l'affichage des enregistrements sélectionnés ///////
////////////////////////////////////////////////////////////////////////////////////////////

				$query = "SELECT * FROM WR_RessourcesCategories ORDER BY RessourceCategorieNom";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// On affiche si nous venons d'une sélection
				if ($affichage <> "N")
				{
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"WR_ressources_categories.php?action=O&amp;a_faire=ajout_categorie\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer une nouvelle fiche\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter une cat&eacute;gorie</span><br />";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

					
					//echo "<a href = \"WR_ressources_categories.php?action=O&amp;a_faire=ajout_categorie\"><img src= \"../image/ajout.png\" title = \"Ajouter une cat&eacute;gorie\"></a><br />Ajouter une cat&eacute;gorie ";
					
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
						//echo "<br />";
						echo "<br /><h2>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h2>";
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

								while ($ligne = mysql_fetch_object($results)) // on extrait ligne par ligne de la table WR_RessourcesCategories
								{
									$id = $ligne->idRessourceCategorie;
									$intitule = $ligne->RessourceCategorieNom;
									if ($id <>"")
									{
										echo "<tr>";
											echo "<TD align = \"center\">$id</TD>";
											echo "<TD>$intitule</TD>";

										//Les actions
										echo "<td nowrap class = \"fond-actions\">";
											echo "<A HREF = \"WR_ressources_categories.php?action=O&amp;a_faire=modifier_categorie&amp;id=$id\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier\"></A>";
											echo "<A HREF = \"WR_ressources_categories.php?action=O&amp;a_faire=supprimer_categorie&amp;id=$id\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer le mat&eacute;riel\"></A>";
										echo "</TD>";
										echo "</TR>";
									} //Fin id <> ""
								} //fin boucle while

								mysql_close();
					}
					else
					{
							echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
					}
				} //Fin if affichage <> "N"
?>
			</TABLE>
		</CENTER>
	</body>
</html>
