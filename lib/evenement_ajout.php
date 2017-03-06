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
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	$id_util = $_SESSION['id_util'];

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
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
		echo "<div align = \"center\">";
			//Récupération des variables

			// On vérifie s'il faut enregistrer l'événement
			$action = $_POST['action'];

			if ($action == "O")
			{
				$origine = $_POST['origine']; // 4 possibilités : ecl_gestion, ecl_consult_fiche, evenement_gestion, evenement_consult_evenement
				$etab = $_POST['etab'];
			}
			else
			{
				$origine = $_GET['origine']; // 4 possibilités : ecl_gestion, ecl_consult_fiche, evenement_gestion, evenement_consult_evenement
				$etab = $_GET['etab'];
			}
/*
			// Affichage des variables pour contrôles du script

			echo "<br />origine : $origine";
			echo "<br />etab : $etab";
			echo "<br />action : $action";
			echo "<br />indice : $indice";
*/
			//On inclue les fichiers de configuration et de fonctions /////

			if ($origine == "ecl_gestion_ecl" OR $action == "O")
			{
				include ("../biblio/config.php");
				include ("../biblio/fct.php");
				include ("../biblio/init.php");
			}

			// On vérifie le niveau des droits de la personne connectée /////
			$niveau_droits = verif_droits("evenements");

			//echo "<br />niveau_droits : $niveau_droits";



			////////////////////////////////////////////////////////////////////////
			// Début du traitement des actions /////////////////////////////////////
			////////////////////////////////////////////////////////////////////////

			if ($action == "O") //Il faut enregistrer l'événement
			{
				//echo "<h2>Enregistrement de l'&eacute;v&eacute;nement</h2>";

				// On initialise les différents constantes
				$date_creation = date('Y-m-j');

				// On récupère les différentes variables à partir du formulaire
				$fk_id_util = $_POST['fk_id_util'];
				$date_evenement_debut = $_POST['date_evenement_debut'];
				$date_evenement_fin = $_POST['date_evenement_fin'];
				$heure_debut_evenement = $_POST['heure_debut_evenement'];
				$heure_fin_evenement = $_POST['heure_fin_evenement'];
				$fk_rne = $_POST['fk_rne'];
				$titre_evenement = $_POST['titre_evenement'];
				$detail_evenement = $_POST['detail_evenement'];
				$fk_id_dossier = $_POST['fk_id_dossier'];
				$fk_repertoire = $_POST['fk_repertoire'];
				$autre_lieu = $_POST['autre_lieu'];

				//$date_evenement_a_enregistrer = crevardate($jour,$mois,$annee); //nouvelle methode pour le champ date_crea
				$date_evenement_debut_a_enregistrer = $date_evenement_debut;
				$date_evenement_fin_a_enregistrer = $date_evenement_fin;

				// Affichage des variables récupérées pour contrôle
				//echo "<br />fk_id_util : $fk_id_util";
/*
				echo "<br />date_evenement : $date_evenement";
				echo "<br />date_creation : $date_creation";
				echo "<br />heure_debut_evenement : $heure_debut_evenement";
				echo "<br />heure_fin_evenement : $heure_fin_evenement";
				echo "<br />fk_rne : $fk_rne";
				echo "<br />titre_evenement : $titre_evenement";
				echo "<br />detail_evenement : $detail_evenement";
				echo "<br />fk_id_dossier : $fk_id_dossier";
*/
				// On entregistre l'&eacute;v&eacute;nement dans la table suivi
				include ("evenement_ajout_enreg_evenement.inc.php");

				////////////////////////////////////////////////////////////
				// Boutons Retour //////////////////////////////////////////
				////////////////////////////////////////////////////////////
				//echo "<br />date_evenement : $date_evenement";

				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"".$origine.".php?tri=date_evenement_debut asc, heure_debut_evenement&amp;sense_tri=ASC&amp;visibilite=O&amp;date_filtre=1\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

			}
			else //On saisit un évenement
			{
				//echo "<input type=\"color\" id=\"html5colorpicker\" class=\"form-control\" onchange=\"clickColor(0, -1, -1, 5)\" value=\"#ff0000\">";
				//echo "<input type=\"time\" name=\"heure_debut\">";
				// Affichage du formulaire de saisie ///////////////////////
				////////////////////////////////////////////////////////////
				echo "<h2>Saisie d'un &eacute;v&eacute;nement</h2>";

				// Initialisation des constantes
				$emetteur = $_SESSION['nom'];
				$id_util = $_SESSION['id_util'];
				$mail_emetteur = $_SESSION['mail'];
				$date_creation_a_afficher = date('j/m/Y');
				//$date_evenement_a_afficher = $date_creation_a_afficher;
				$date_evenement_a_afficher = date('Y-m-j');

				// On affiche le formulaire
				echo "<form action = \"evenement_ajout.php\" METHOD = \"POST\">";
					//echo "<input type = \"hidden\" VALUE = \"".$statut."\" NAME = \"statut\">";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Emetteur&nbsp;:&nbsp;</td>";
							
							//On vérifie si la personne connectée peut saisir un évènement pour quelqu'un d'autre
							if($niveau_droits >2)
							{
								//On récupère la liste des personnes autorisées de créer des événements
								//echo "en pr&eacute;paration";
								//echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$id_util."\" NAME = \"fk_id_util\">".$emetteur."</td>";
								
								$query_utils = "SELECT * FROM util AS U,util_groupes AS UG 
									WHERE U.ID_UTIL = UG.ID_UTIL
										AND visible = 'O'
										AND UG.ID_GROUPE = '33'
									ORDER BY NOM";
								$results_utils = mysql_query($query_utils);

								//echo "echo <td>Choisissez le/la responsable de l'&eacute;v&eacute;nement dans la liste d&eacute;roulante&nbsp;:&nbsp;";
								echo "<td>";
								//$no = mysql_num_rows($results_utils);
									echo "<SELECT NAME = \"fk_id_util\">";
									echo "<OPTION selected VALUE = \"".$id_util."\">".$emetteur."</OPTION>";
										while ($ligne_utils = mysql_fetch_object($results_utils))
										{
											$id_util = $ligne_utils->ID_UTIL;
											$nom = $ligne_utils->NOM;
											//$prenom = $ligne_utils->PRENOM;
											if($nom <> $emetteur)
											{
												echo "<OPTION VALUE = \"".$id_util."\">".$nom."</OPTION>";
											}
										}
									echo "</SELECT>";
								echo "</td>";
							}
							else
							{
								echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$id_util."\" NAME = \"fk_id_util\">".$emetteur."</td>";
							}
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">Date de la saisie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">$date_creation_a_afficher</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\"><span class = \"champ_obligatoire\">Date d&eacute;but de l'&eacute;v&eacute;nement*&nbsp;:&nbsp;</span></td>";
							echo "<td>";
									echo "<input type=\"text\" id=\"date_evenement_debut\"  name=\"date_evenement_debut\"  size = \"10\" required>";
									echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_evenement_debut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
							echo "</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">Date fin de l'&eacute;v&eacute;nement (facultatif)&nbsp;:&nbsp;</td>";
							echo "<td>";
									echo "<input type=\"text\" id=\"date_evenement_fin\"  name=\"date_evenement_fin\"  size = \"10\">";
									echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_evenement_fin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
							echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td class = \"etiquette\">";
							echo "<span class = \"champ_obligatoire\">Horaire de d&eacute;but*&nbsp;:&nbsp;</span>";
							//echo "<td class = \"etiquette\">Horaire de d&eacute;but&nbsp;:&nbsp;</td>";
							echo "<td>";
								echo "<select  size=\"1\" name = \"heure_debut_evenement\" required>";
									echo "<option value=\"09:00:00\" class = \"bleu\">09H00</option>";
									echo "<option value=\"09:30:00\" class = \"bleu\">09H30</option>";
									echo "<option value=\"10:00:00\" class = \"bleu\">10H00</option>";
									echo "<option value=\"10:30:00\" class = \"bleu\">10H30</option>";
									echo "<option value=\"11:00:00\" class = \"bleu\">11H00</option>";
									echo "<option value=\"11:30:00\" class = \"bleu\">11H30</option>";
									echo "<option value=\"12:00:00\" class = \"bleu\">12H00</option>";
									echo "<option value=\"12:30:00\" class = \"bleu\">12H30</option>";
									echo "<option value=\"13:00:00\" class = \"bleu\">13H00</option>";
									echo "<option value=\"13:30:00\" class = \"bleu\">13H30</option>";
									echo "<option value=\"14:00:00\" class = \"bleu\">14H00</option>";
									echo "<option value=\"14:30:00\" class = \"bleu\">14H30</option>";
									echo "<option value=\"15:00:00\" class = \"bleu\">15H00</option>";
									echo "<option value=\"15:30:00\" class = \"bleu\">15H30</option>";
									echo "<option value=\"16:00:00\" class = \"bleu\">16H00</option>";
									echo "<option value=\"16:30:00\" class = \"bleu\">16H30</option>";
									echo "<option value=\"17:00:00\" class = \"bleu\">17H00</option>";
									echo "<option value=\"17:30:00\" class = \"bleu\">17H30</option>";
									echo "<option value=\"18:00:00\" class = \"bleu\">18H00</option>";
								echo "</select>";
							echo "</td>";

						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">";
								echo "<span class = \"champ_obligatoire\">Horaire de fin*&nbsp;:&nbsp;</span>";
							//echo "<td class = \"etiquette\">Horaire de fin&nbsp;:&nbsp;</td>";
							echo "<td>";
								echo "<select  size=\"1\" name = \"heure_fin_evenement\" required>";
									echo "<option value=\"10:00:00\" class = \"bleu\">10H00</option>";
									echo "<option value=\"10:30:00\" class = \"bleu\">10H30</option>";
									echo "<option value=\"11:00:00\" class = \"bleu\">11H00</option>";
									echo "<option value=\"11:30:00\" class = \"bleu\">11H30</option>";
									echo "<option value=\"12:00:00\" class = \"bleu\">12H00</option>";
									echo "<option value=\"12:30:00\" class = \"bleu\">12H30</option>";
									echo "<option value=\"13:00:00\" class = \"bleu\">13H00</option>";
									echo "<option value=\"13:30:00\" class = \"bleu\">13H30</option>";
									echo "<option value=\"14:00:00\" class = \"bleu\">14H00</option>";
									echo "<option value=\"14:30:00\" class = \"bleu\">14H30</option>";
									echo "<option value=\"15:00:00\" class = \"bleu\">15H00</option>";
									echo "<option value=\"15:30:00\" class = \"bleu\">15H30</option>";
									echo "<option value=\"16:00:00\" class = \"bleu\">16H00</option>";
									echo "<option value=\"16:30:00\" class = \"bleu\">16H30</option>";
									echo "<option value=\"17:00:00\" class = \"bleu\">17H00</option>";
									echo "<option value=\"17:30:00\" class = \"bleu\">17H30</option>";
									echo "<option value=\"18:00:00\" class = \"bleu\">18H00</option>";
									echo "<option value=\"18:30:00\" class = \"bleu\">18H30</option>";
									echo "<option value=\"19:00:00\" class = \"bleu\">19H00</option>";
									echo "<option value=\"19:30:00\" class = \"bleu\">19H30</option>";
									echo "<option value=\"20:00:00\" class = \"bleu\">20H00</option>";
								echo "</select>";
							echo "</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">";
								if ($sujet == "")
								{
									echo "<span class = \"champ_obligatoire\">Titre*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Titre&nbsp;:&nbsp;";
								}
							echo "</td>";
							echo "<td><input type = \"text\" VALUE = \"".$sujet."\" NAME = \"titre_evenement\" SIZE = \"64\" required placeholder=\"Titre de l'&eacute;v&eacute;nement\"></td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\"><span class = \"champ_obligatoire\">Dossier concern&eacute*&nbsp;:&nbsp;</span></td>";
							echo "<td>";
								//include("../biblio/init.php");
								//Je récupère l'intitulé de la catégorie commune à afficher
								//echo "<br />categorie_commune : $categorie_commune";

	/*
								if (ISSET($categorie_commune))
								{
									$requete_int_cat_com = "SELECT * FROM categorie_commune WHERE id_categ = $categorie_commune";
									$result_int_cat_com = mysql_query($requete_int_cat_com);
									$ligne = mysql_fetch_object($result_int_cat_com);
									$intitule_categ_a_afficher=$ligne->intitule_categ;
									$id_categ_a_afficher=$ligne->id_categ;
								}
	*/

								//Maintenant je recupère les intitulés des catégories communes
								$requete_cat="SELECT * FROM categorie_commune WHERE actif = 'O' ORDER BY intitule_categ ASC";
								$result=mysql_query($requete_cat);
								$num_rows = mysql_num_rows($result);
								echo "<select size=\"1\" name=\"fk_id_dossier\" required>";
								if (mysql_num_rows($result))
								{
									echo "<option selected value=\"$id_categ_a_afficher\">$intitule_categ_a_afficher</option>";
									while ($ligne=mysql_fetch_object($result))
									{
										$id_categ=$ligne->id_categ;
										$intitule_categ=$ligne->intitule_categ;
										//if ($intitule_categ <> $intitule_categ_a_afficher)
										//{
											echo "<option value=\"$id_categ\">$intitule_categ</option>";
										//}
									}
								}
								echo "</select>";
							echo "</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">";
								if ($contenu == "")
								{
									echo "<span class = \"champ_obligatoire\">Description rapide de l'&eacute;v&eacute;nement*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Description&nbsp;:&nbsp;";
								}
							echo "</td>";

							echo "<td><textarea rows = \"10\" COLS = \"120\" NAME = \"detail_evenement\" placeholder=\"Description de l'&eacute;v&eacute;nement\">".$contenu."</textarea>";
								echo "<script type=\"text/javascript\">CKEDITOR.replace( 'detail_evenement' );</script>";
							echo "</td>";
						echo "</tr>";

						/////////////////////////////////
						// Proposition des lieux ////////
						/////////////////////////////////
		
						// les ECL
						//Récupération des données en rapport avec l'établissement sélectionné
						$query_etab = "SELECT * FROM etablissements where RNE = '".$etab."';";
						$results_etab_select = mysql_query($query_etab);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
							//mysql_close();
							exit;
						}
						$num_results_etab_select = mysql_num_rows($results_etab_select);
						$res_etab = mysql_fetch_row($results_etab_select);
						//fin récupération de l'établissement selectionné

						//Récupération des établissements non selectionnés
						$query_non_etab_select = "SELECT * FROM etablissements where RNE != '".$etab."';";
						$results_non_etab_select = mysql_query($query_non_etab_select);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results_non_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
							//mysql_close();
							exit;
						}
						$num_results_etab_non_select = mysql_num_rows($results_non_etab_select);
						$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
						//fin de recup de tous les établissements non selectionnées

						echo "<tr>";
							echo "<td class = \"etiquette\">EPLE / &Eacute;cole&nbsp;:&nbsp;</td>";
								echo "<td><select name = \"fk_rne\">";
								for ($i=0; $i < $num_results_etab_non_select; ++$i)
								{
									echo "<option VALUE = \"".$res_non_etab_select[0]."\">".$res_non_etab_select[0]." -- ".str_replace("*", " ",$res_non_etab_select[1])." ".str_replace("*", " ",$res_non_etab_select[3]). " -- ".$res_non_etab_select[5]."</option>";
									//echo "<option VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>";

									$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
								}
								echo "<option selected = \"".$res_etab[0]."\" VALUE = \"".$res_etab[0]."\">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>";
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						
						// Les sociéte de la table repertoire
						$requete_repertoire = "SELECT * FROM repertoire ORDER BY societe ASC";
						$resultat_repertoire = mysql_query($requete_repertoire);

						if(!$resultat_repertoire)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
							//mysql_close();
							exit;
						}
						
						$nb_societes = mysql_num_rows($resultat_repertoire);
						echo "<tr>";
							echo "<td class = \"etiquette\">Structures non EN&nbsp;:&nbsp;</td>";
								echo "<td><select name = \"fk_repertoire\">";
								echo "<option selected value=\"0\">-- --</option>";
								while ($ligne_repertoire = mysql_fetch_object($resultat_repertoire))
								{
									$id_societe = $ligne_repertoire->No_societe;
									$intitule_societe = $ligne_repertoire->societe;
									$ville_societe = $ligne_repertoire->ville;
									echo "<option VALUE = \"".$id_societe."\">".$intitule_societe.", ".$ville_societe."</option>";
								}
								echo "</select>";
							echo "</td>";
						echo "</tr>";

						// Un autre lieu
						echo "<tr>";
							echo "<td class = \"etiquette\">";
								echo "Autre lieu (Intitul&eacute;, Ville, Adresse)&nbsp;:&nbsp;";
							echo "</td>";
							echo "<td><input type = \"text\" VALUE = \"\" NAME = \"autre_lieu\" SIZE = \"100\" placeholder=\"Autre lieu (Intitul&eacute;, Ville, Adresse)\"></td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class =\"etiquette\"></td>";
							echo "<td align = \"center\">";
								echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
								echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
							echo "</td>";

						/////////////////////////////////////
						// Fin proposition des lieux ////////
						/////////////////////////////////////

						echo "</tr>";
					echo "</table>";

					echo "<span class = \"champ_obligatoire\">*champs obligatoires</span>";
					////////////////////////////////////////////////////////////
					// Boutons Retour et validation ////////////////////////////
					////////////////////////////////////////////////////////////
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
							echo "</td>";
							echo "<td>";
								echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer l'&eacute;v&eacute;nement\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</form>";

				////////////////////////////////////////////////////////////
				// Fin formulaire de saisien ///////////////////////////////
				////////////////////////////////////////////////////////////

			} // Fin else pour l'affichage du formulaire

		echo "</div>";
	echo "</body>";
echo "</html>";
?>
