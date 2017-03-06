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
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";

	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_credits.png\" ALT = \"Titre\">";
			//On ins&egrave;re la barre de filtrage directement dans la page
			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			//$annee = $annee_budgetaire; // en attendant un développement pour pouvoir afficher n'importe quelle année
			
			//On recupère les différentes variables envoyées par les scripts
			$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur une personnes ressource 
			$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
			$annee = $_GET['annee'];
			$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //sur une ligne du tableau (modifier, changer d'affectation,...
			if ($bouton_envoyer_modif == "Retourner sans enregistrer")
			{
				$actions_courantes = "N";
			}


			//On fixe des variables pour le fonctionnement du script
			$nb_par_page = 15; //Fixe le nombre de ligne qu'il faut afficher à l'écran
			$autorisation_gestion_credits = verif_appartenance_groupe(11);

			//On affiche le bouton pour pouvoir ajouter un nouveau chapitre
			echo "<center>";
			//echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/credits_inactif.png\" ALT = \"Gestion cr&eacute;dits\" title=\"Gestion cr&eacute;dits\" border = \"0\"></A>";
			echo "&nbsp;&nbsp;&nbsp;";
			echo "<A HREF = \"credits_gestion_chapitres.php?annee=".$annee."\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categories.png\" ALT = \"Gestion chapitres\" title=\"Afficher le tableau par chapitres\" border = \"0\"></A>";
			echo "&nbsp;&nbsp;&nbsp;";
			//echo "<A HREF = \"credits_gestion_lignes_budgetaires.php?annee=".$annee."\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/credits_lignes_budgetaires.png\" ALT = \"Gestion lignes budg&eacute;taires\" title=\"Afficher le tableau par lignes budg&eacute;taires\" border = \"0\"></A>";
			echo "<br />";
			echo "<A HREF = \"credits_gestion.php?actions_courantes=O&amp;a_faire=ajout_chapitre&amp;annee=".$annee."&amp;id_credits_chapitre=".$id_credits_chapitre."\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un nouveau chapitre\" border = \"0\"></A>";
			echo "</center>";

		////////////////////////////////////////////////////////////////////////////////////////////
		//////////// Début du traitement des actions sur les personnes ressources //////////////////
		////////////////////////////////////////////////////////////////////////////////////////////
			if ($actions_courantes == "O")
			{
				$id_credits_chapitre = $_GET['id_credits_chapitre'];
				switch ($a_faire)
				{
					case "consulter_chapitre" :
						include ("credits_affiche_fiche_chapitre.inc.php");
						//echo "<h1>Afficher la fiche du chapitre $id_credits_chapitre</h1>";
						//echo "<A HREF = \"materiels_gestion.php?origine_gestion=filtre&amp;actions_courantes=N&amp;indice=$indice\" target = \"body\"><h2>Retour à la liste</h2></A>";
						$affichage ="N";
					break; //consulter_fiche_personne
					
					case "modif_chapitre" :
						include ("credits_modif_chapitre.inc.php");
						//echo "<h1>Modification d'un chapitre</h1>";							
						//echo "<h1>Bient&ocirc;t sur cet &eacute;cran :-;</h1>";							
						$affichage ="N";
					break; //modif_chapitre

					case "maj_chapitre" :
						include ("credits_maj_chapitre.inc.php");
						//echo "<h1>MAJ du chapitre</h1>";							
						//echo "<h1>Bient&ocirc;t sur cet &eacute;cran :-;</h1>";							
					break; //maj_personne

					case "ajout_chapitre" :
						include ("credits_ajout_chapitre.inc.php");
						//echo "<h1>Ajout d'un chapitre</h1>";							
						$affichage ="N";
					break; //ajout_personne

					case "enreg_chapitre" :
						include ("credits_enreg_chapitre.inc.php");
						//echo "<h1>Enregistrement d'un chapitre</h1>";							
					break; //enreg_personne

				}

			} //FIN if ($actions_courantes == "O")

		////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////// Fin des actions sur les personnes ressources ////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////// Début du script principal pour l'affichage des enregistrepments ///////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if ($affichage <> "N")
			{
				echo "<form action=\"credits_gestion.php\" method=\"get\">";
				echo "<h1><center>Tableau de bord des cr&eacute;dits TICE pour&nbsp;";
				echo "<select size=\"1\" name=\"annee\">
					<option selected value=\"$annee\">$annee</option>
					<!--option value=\"%\">toutes</option-->";
					while ($compteur_debut < $compteur_fin)
					{
						if ($compteur_debut <> $annee)
						{
							echo "<option value=\"$compteur_debut\">$compteur_debut</option>";
						}
						$compteur_debut++;
					}
					echo "</select>";
					echo "<input type=\"submit\" name=\"bouton_changement_annee\" Value = \"Changer l'ann&eacute;e\"/>
					<!--INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
					<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
					<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\"-->";
					echo "</center></h1>";

					echo "<TABLE width = \"90%\" BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">";
						echo "<colgroup>";
							//echo "<col width=\"10%\">"; //ID
							echo "<col width=\"50%\">"; //domaine
							echo "<col width=\"10%\">"; //total demandé
							echo "<col width=\"10%\">"; //total alloué
							echo "<col width=\"10%\">"; //total affecté
							echo "<col width=\"10%\">"; //total encore à affecter
							echo "<col width=\"10%\">"; //actions
						echo "</colgroup>";
						//echo "<th>ID</th>";
						echo "<th>Chapitre</th>";
						echo "<th>Total demand&eacute;</th>";
						echo "<th>Total allou&eacute;</th>";
						echo "<th>Total affect&eacute;</th>";
						echo "<th>Reste &agrave; affecter</th>";
						echo "<th>Actions</th>";
					//On lit la table credits_chapitres
					$requete_credits_chapitre = "SELECT * FROM credits_chapitres WHERE utilise ='O' ORDER BY intitule_chapitre ASC";
					$resultat_credits_chapitre = mysql_query($requete_credits_chapitre);
					$num_rows = mysql_num_rows($resultat_credits_chapitre);
					//echo "<br>nombre d'enregistrements : $num_rows";

					//on réinitialise les compteurs pour les différentes sommes
					$compteur_credits_demandes = 0; //Les sommes demandées
					$compteur_credits_alloues = 0; //Les sommes allouées
					$compteur_credits_distribues = 0; //Les sommes distribuées
					//On parcours la table pour extraire les différents chapitres
					while ($ligne_credits_chapitre = mysql_fetch_object($resultat_credits_chapitre))
					{
						$id_credits_chapitre = $ligne_credits_chapitre->id_chapitre;
						$intitule_credits_chapitre = $ligne_credits_chapitre->intitule_chapitre;

						//Il faut récupérer le total des crédits demandés par domaine dans la table credits_domaines_budget
						$requete_total_demande = "SELECT SUM(montant_demande) FROM credits_domaines_budget WHERE `credits_domaines_budget`.`id_credits_chapitres` = '$id_credits_chapitre' AND annee = '$annee'";
						$resultat_total_demande = mysql_query($requete_total_demande);
						$total_demande = mysql_fetch_row($resultat_total_demande);
						$total_demande_a_afficher = $total_demande[0];
						//echo "<br />total_demande_a_afficher : $total_demande_a_afficher";
						//echo "<br />requete_total_demande : $requete_total_demande";
						$compteur_credits_demandes = $compteur_credits_demandes + $total_demande_a_afficher;

						//Il faut récupérer le total des crédits affectés par domaine dans la table credits_domaines_budget
						$requete_total_alloue = "SELECT SUM(montant_alloue) FROM credits_domaines_budget WHERE `credits_domaines_budget`.`id_credits_chapitres` = '$id_credits_chapitre' AND annee = '$annee'";
						$resultat_total_alloue = mysql_query($requete_total_alloue);
						$total_alloue = mysql_fetch_row($resultat_total_alloue);
						$total_alloue_a_afficher = $total_alloue[0];
						//echo "<br />total_alloue_a_afficher : $total_alloue_a_afficher";
						//echo "<br />requete_total_alloue : $requete_total_alloue";
						$compteur_credits_alloues = $compteur_credits_alloues + $total_alloue_a_afficher;

						//On regarde dans les differents tables les sommes déjà distribuées
						$requete_total_distribue = "SELECT SUM(total_commande) FROM materiels_commandes WHERE `credits` = '$id_credits_chapitre' AND annee_budgetaire = '$annee'";
						$resultat_total_distribue = mysql_query($requete_total_distribue);
						$total_distribue = mysql_fetch_row($resultat_total_distribue);
						$total_distribue_a_afficher = $total_distribue[0];
						//echo "<br />total_distribue_a_afficher : $total_distribue_a_afficher";
						//echo "<br />requete_total_distribue : $requete_total_distribue";
						$requete_total_distribue2 = "SELECT SUM(montant) FROM credits_ecritures, credits_domaines_budget WHERE `credits_ecritures`.`ligne_budgetaire` = `credits_domaines_budget`.`id` AND `credits_domaines_budget`.`id_credits_chapitres` = '$id_credits_chapitre' AND annee_budgetaire = '$annee'";
						$resultat_total_distribue2 = mysql_query($requete_total_distribue2);
						$total_distribue2 = mysql_fetch_row($resultat_total_distribue2);
						$total_distribue2_a_afficher = $total_distribue2[0];
						//echo "<br />total_distribue2_a_afficher : $total_distribue2_a_afficher";
						//echo "<br />requete_total_distribue2 : $requete_total_distribue2";
						$total_distribue_a_afficher = $total_distribue_a_afficher + $total_distribue2_a_afficher;
						$compteur_credits_distribues = $compteur_credits_distribues + $total_distribue_a_afficher;
					
						//On calcul le total qui reste encore à distribuer
						$total_encore_a_distribuer = $total_alloue_a_afficher - $total_distribue_a_afficher;

						//On format le montants pour l'affichage
						$total_demande_a_afficher = number_format($total_demande[0],2,',',' ');
						$total_alloue_a_afficher = number_format($total_alloue[0],2,',',' ');
						$total_distribue_a_afficher = number_format($total_distribue_a_afficher,2,',',' ');
						$total_encore_a_distribuer_a_afficher = number_format($total_encore_a_distribuer,2,',',' ');

						//$total_encore_a_distribuer_en_HSE = number_format($total_encore_a_distribuer_en_HSE,2,',',' ');
						echo "<tr class = \"new\">";
							echo "<td>";
								echo "$intitule_credits_chapitre";
							echo "</td>";

							echo "<td align = \"center\">";
								affiche_chiffre_si_pas_0($total_demande_a_afficher);
								//echo "&nbsp;";
							echo "</td>";

							echo "<td align = \"center\">";
								affiche_chiffre_si_pas_0($total_alloue_a_afficher);
							echo "</td>";

							echo "<td align = \"center\">";
								affiche_chiffre_si_pas_0($total_distribue_a_afficher);
							echo "</td>";

							echo "<td align = \"center\">";
								affiche_chiffre_si_pas_0($total_encore_a_distribuer_a_afficher);
							echo "</td>";

							echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp";  //pour les actions
								echo "<A HREF = \"credits_gestion.php?actions_courantes=O&amp;a_faire=consulter_chapitre&amp;annee=".$annee."&amp;id_credits_chapitre=".$id_credits_chapitre."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"Consulter le chapitre\" border = \"0\"></A>";
								echo "<A HREF = \"credits_gestion.php?actions_courantes=O&amp;a_faire=modif_chapitre&amp;annee=".$annee."&amp;id_credits_chapitre=".$id_credits_chapitre."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le chapitre\" border = \"0\"></A>";
							echo "</td>";
						echo "</tr>";
					}
					//On calcule le reste à distribuer ou à dépenser
					$total_reste = $compteur_credits_alloues - $compteur_credits_distribues;

						echo "<tr>";
						echo "<td align = \"right\">";
							echo "<b>Totaux&nbsp;:&nbsp;</b>";
						echo "</td>";

						echo "<td align = \"center\">";
							//On format le montants pour l'affichage
							$compteur_credits_demandes = number_format($compteur_credits_demandes,2,',',' ');
							affiche_chiffre_si_pas_0($compteur_credits_demandes);
						echo "</td>";

						echo "<td align = \"center\">";
							//On format le montants pour l'affichage
							$compteur_credits_alloues = number_format($compteur_credits_alloues,2,',',' ');
							affiche_chiffre_si_pas_0($compteur_credits_alloues);
						echo "</td>";

						echo "<td align = \"center\">";
							$compteur_credits_distribues = number_format($compteur_credits_distribues,2,',',' ');
							affiche_chiffre_si_pas_0($compteur_credits_distribues);
						echo "</td>";
						echo "<td align = \"center\">";
							$total_reste = number_format($total_reste,2,',',' ');
							affiche_chiffre_si_pas_0($total_reste);
						echo "</td>";

					echo "</tr>";
				echo "</table>";
			echo "</form>";
			} //Fin if ($affichage <> "N")
		echo "</div>";
	echo "</body>";
echo "</html>";
?>
