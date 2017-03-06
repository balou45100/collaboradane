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

	//On inclue les fichiers de configuration et de fonctions /////
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");

	// On vérifie le niveau des droits de la personne connectée /////
	$niveau_droits = verif_droits("suivi_dossiers");

	//echo "<br />niveau_droits : $niveau_droits";

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
			//echo "<meta charset=\"utf-8\">";
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
		echo "<div align = \"center\">";
			//Récupération des variables

			// On vérifie si on vient du formulaire
			$envoi_formulaire = $_POST['envoi_formulaire'];
			if ($envoi_formulaire == "O")
			{
				$action = $_POST['action'];
				$origine = $_POST['origine']; // 4 possibilités : ecl_gestion, ecl_consult_fiche, suivi_gestion, suivi_consult_suivi
				$etab = $_POST['etab'];
			}
			else
			{
				$origine = $_GET['origine']; // 4 possibilités : ecl_gestion, ecl_consult_fiche, suivi_gestion, suivi_consult_suivi
				$etab = $_GET['etab'];
			}

			// Affichager variables pour contrôles du script
/*
			echo "<br />origine : $origine";
			echo "<br />etab : $etab";
			echo "<br />action : $action";
			echo "<br />indice : $indice";
*/
			////////////////////////////////////////////////////////////////////////
			// Début du traitement des actions /////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			if ($action == "O") //Il faut enregistrer le suivi
			{
				//echo "<h2>Enregistrement du suivi</h2>";

				// On initialise les différents constantes
				$date_creation = date('Y-m-j');

				// On récupère les différentes variables à partir du formulaire
				$emetteur = $_POST['emetteur'];
				$mail_emetteur = $_POST['mail_emetteur'];
				$date_suivi = $_POST['date_suivi'];
				$ecl = $_POST['ecl'];
				$sujet = $_POST['sujet'];
				$contact_type = $_POST['contact_type'];
				$description = $_POST['description'];
				$categorie_commune = $_POST['categorie_commune'];

				//$date_suivi_a_enregistrer = crevardate($jour,$mois,$annee); //nouvelle methode pour le champ date_crea
				$date_suivi_a_enregistrer = $date_suivi;

				// Affichage des variables récupérées pour contrôle
/*
				echo "<br />emetteur : $emetteur";
				echo "<br />mail_emetteur : $mail_emetteur";
				echo "<br />date_suivi : $date_suivi";
				echo "<br />ecl : $ecl";
				echo "<br />sujet : $sujet";
				echo "<br />contact_type : $contact_type";
				echo "<br />description : $description";
				echo "<br />categorie_commune : $categorie_commune";
*/
				// On entregistre le suivi dans la table suivi
				include ("suivi_ajout_enreg_suivi.inc.php");

				////////////////////////////////////////////////////////////
				// Boutons Retour //////////////////////////////////////////
				////////////////////////////////////////////////////////////
				//echo "<br />date_suivi : $date_suivi";

				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

			}
			else //On saisit un suivi
			{
				////////////////////////////////////////////////////////////
				// Affichage du formulaire de saisie ///////////////////////
				////////////////////////////////////////////////////////////
				echo "<h2>Saisie d'un suivi</h2>";

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

				// Initialisation des constantes
				$emetteur = $_SESSION['nom'];
				$id_util = $_SESSION['id_util'];
				$mail_emetteur = $_SESSION['mail'];
				$date_creation_a_afficher = date('j/m/Y');
				//$date_suivi_a_afficher = $date_creation_a_afficher;
				$date_suivi_a_afficher = date('Y-m-j');
				// On affiche le formulaire
				echo "<form action = \"suivi_ajout.php\" METHOD = \"POST\">";
					echo "<input type = \"hidden\" VALUE = \"".$statut."\" NAME = \"statut\">";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Emetteur&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$id_util."\" NAME = \"emetteur\">".$emetteur."</td>";
						echo "</tr>";
/*
						echo "<tr>";
							echo "<td class = \"etiquette\">M&eacute;l Emetteur&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input type = \"hidden\" VALUE =\"".$mail_emetteur."\" NAME = \"mail_emetteur\">".$mail_emetteur."</td>";
						echo "</tr>";
*/
						echo "<tr>";
							echo "<td class = \"etiquette\">Date de la saisie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">$date_creation_a_afficher</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">EPLE/Ecole&nbsp;:&nbsp;</td>";
								echo "<td><select name = \"ecl\">";
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

						echo "<tr>";
							echo "<td class = \"etiquette\">Date du suivi&nbsp;:&nbsp;</td>";
							echo "<td>";
								echo "<input type=\"text\" id=\"date_suivi\"  name=\"date_suivi\" value=\"$date_suivi_a_afficher\" size = \"10\" required>";
								echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_suivi&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
							echo "</td>";
						echo "</tr>";

/*
						echo "<tr>
							<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>
							<td class = \"etiquette\">Titre&nbsp;:&nbsp;
								<select size= \"1\" name = \"contact_titre\">
									<option selected>$contact_titre</option>
									<option value=\"M\">M.</option>
									<option value=\"MME\">MME</option>
								</select>";

								//On fait appel à la datalist pour proposer les prénoms de contact déjà dans la base
								fc_datalist("probleme","CONTACT_PRENOM","contact_prenom",$contact_prenom,32,"Pr&eacute;nom","PRENOM","l_prenom");

								//On fait appel à la datalist pour proposer les noms de contact déjà dans la base
								fc_datalist("probleme","CONTACT_NOM","contact_nom",$contact_nom,32,"Nom","NOM","l_nom");
								echo "<br />";

								//On fait appel à la datalist pour proposer les adresses électronique déjà dans la base
								fc_datalist("probleme","CONTACT_MAIL","contact_mail",$contact_mail,50,"M&eacute;l","courriel","l_mail");

								//echo "<br />contact_mail : $contact_mail<br />";

								//On récupère les enregistrements de la table contacts_qualites
								remplir_champ_select("INTITULE","contacts_qualites","Qualit&eacute;","contact_fonction",$contact_fonction);
							echo "</td>
						</tr>";
*/
						echo "<tr>";
							echo "<td class = \"etiquette\">";
								if ($sujet == "")
								{
									echo "<span class = \"champ_obligatoire\">Sujet*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Sujet&nbsp;:&nbsp;";
								}
							echo "</td>";
							echo "<td><input type = \"text\" VALUE = \"".$sujet."\" NAME = \"sujet\" SIZE = \"64\" required placeholder=\"Titre du suivi\"></td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class = \"etiquette\">";
								if ($contact_type == "")
								{
									echo "<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Type&nbsp;:&nbsp;";
								}
							echo "</td>
							<td>
								<select name = \"contact_type\" required>
									<option selected = \"$contact_type\" VALUE = \"$contact_type\">$contact_type</option>
									<option = \"courriel re&ccedil;u\" VALUE = \"courriel re&ccedil;u\">courriel re&ccedil;u</option>
									<option = \"courriel envoy&eacute;\" VALUE = \"courriel envoy&eacute;\">courriel envoy&eacute;</option>
									<option = \"appel t&eacute;l. re&ccedil;u\" VALUE = \"appel t&eacute;l. re&ccedil;u\">appel t&eacute;l. re&ccedil;u</option>
									<option = \"appel t&eacute;l. donn&eacute;\" VALUE = \"appel t&eacute;l. donn&eacute;\">appel t&eacute;l. donn&eacute;</option>
									<option = \"courrier re&ccedil;u\" VALUE = \"courrier re&ccedil;u\">courrier re&ccedil;u</option>
									<option = \"courrier envoy&eacute;\" VALUE = \"courrier envoy&eacute;\">courrier envoy&eacute;</option>
									<option = \"rencontre\" VALUE = \"rencontre\">rencontre</option>
									<option = \"information\" VALUE = \"information\">information</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class = \"etiquette\"><span class = \"champ_obligatoire\">Dossier concern&eacute*&nbsp;:&nbsp;</span></td>
							<td>";
								include("../biblio/init.php");
								//Je récupère l'intitulé de la catégorie commune à afficher
								//echo "<br />categorie_commune : $categorie_commune";
								if (ISSET($categorie_commune))
								{
									$requete_int_cat_com = "SELECT * FROM categorie_commune WHERE id_categ = $categorie_commune";
									$result_int_cat_com = mysql_query($requete_int_cat_com);
									$ligne = mysql_fetch_object($result_int_cat_com);
									$intitule_categ_a_afficher=$ligne->intitule_categ;
									$id_categ_a_afficher=$ligne->id_categ;
								}
								//Maintenant je recupère les autres intitulés
								$requete_cat="SELECT * FROM categorie_commune WHERE actif = 'O' ORDER BY intitule_categ ASC";
								$result=mysql_query($requete_cat);
								$num_rows = mysql_num_rows($result);
								echo "<select size=\"1\" name=\"categorie_commune\" required>";
								if (mysql_num_rows($result))
								{
									echo "<option selected value=\"$id_categ_a_afficher\">$intitule_categ_a_afficher</option>";
									while ($ligne=mysql_fetch_object($result))
									{
										$id_categ=$ligne->id_categ;
										$intitule_categ=$ligne->intitule_categ;
										if ($intitule_categ <> $intitule_categ_a_afficher)
										{
											echo "<option value=\"$id_categ\">$intitule_categ</option>";
										}
									}
								}
								echo "</select>";
							echo "</td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">";
								if ($contenu == "")
								{
									echo "<span class = \"champ_obligatoire\">Description rapide du suivi*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Description&nbsp;:&nbsp;";
								}
							echo "</td>";
							echo "<td><textarea rows = \"15\" COLS = \"120\" NAME = \"description\" placeholder=\"Description du suivi\">".$contenu."</textarea>";
								//echo "<script type=\"text/javascript\">CKEDITOR.replace( 'description' );</script>";
								echo "<script>CKEDITOR.replace( 'description' );</script>";
							echo "</td>";
						echo "</tr>";

						echo "<tr>";
							echo "<td class =\"etiquette\"></td>";
							echo "<td align = \"center\">";
								echo "<input type = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
								echo "<input type = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
								echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
								echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
								echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"envoi_formulaire\">";
								//echo "<input type = \"submit\" VALUE = \"Enregistrer le suivi\">";
							echo "</td>";
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
								echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le suivi\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
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
