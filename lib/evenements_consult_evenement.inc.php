<?php
	$id_evenement = $_GET['id_evenement'];
	//echo "id_evenement : $id_evenement";
	
	//On regarde s'il faut faire quelque chose avant d'afficher les informations de l'événement
	$action2 = $_GET['action2'];
	//echo "<br />action2 : $action2";

	if ($action2 == "O")
	{
		$a_faire2 = $_GET['a_faire2'];
		//echo "<br />a_faire2 : $a_faire2";
		switch ($a_faire2)
		{
			case "ajout_participant" :
				//echo "<h2>Ajout de participant-e</h2>";
				include("evenement_enreg_participant.inc.php");
			break;

			case "ajout_participant_par_fonction" :
				echo "<h2>Ajout de participant-e-s par fonction</h2>";
				include("evenement_enreg_participant_par_fonction.inc.php");
			break;

			case "suppression_participant" :
				echo "<h2>Suppression de participant-e</h2>";
				include("evenement_suppression_participant.inc.php");
				//$affichage = "N";
			break;

			case "suppression_liste_participants" :
				echo "<h2>Suppression de la liste des participant-e-s</h2>";
				include("evenement_suppression_liste_participants.inc.php");
				$affichage = "N";
			break;

			case "confirmer_supprimer_liste_participants" :
				echo "<h2>Confirmation de la suppression de la liste des participant-e-s</h2>";
				include("evenement_confirmation_suppression_liste_participants.inc.php");
				//$affichage = "N";
			break;

			case "liste_om" :
				echo "<h2>Liste pour &eacute;tablir les OM</h2>"; //pas opérationnel pour l'instant
				//include("evenement_enreg_participant_par_fonction.inc.php");
				$affichage = "N";
			break;

			case "liste_emargement" :
				//echo "<h2>Liste d'&eacute;margements</h2>";
				include("evenement_liste_emargement.inc.php");
				$affichage = "N";
			break;

			case "affiche_om" :
				//echo "<h2>Afficher un OM</h2>";
				include("evenement_affiche_om.inc.php");
				$affichage = "N";
			break;

			case "changer_frais" :
				$frais = $_GET['frais'];
				$id_participant = $_GET['id_participant'];
				/*
				echo "<br />frais : $frais";
				echo "<br />id_evenement : $id_evenement";
				echo "<br />id_participant : $id_participant";
				*/
				$requete_ce = "UPDATE evenements_participants SET `frais` = '".$frais."' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."'";
				$result_ce = mysql_query($requete_ce);
				if (!$result_ce)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "liste_emargement_valider_presences" :
				$requete = "UPDATE evenements_participants SET `etat_om` = '3' WHERE id_evenement ='".$id_evenement."' AND (`etat_om` = '2' OR `etat_om` = '4')";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "liste_marquer_remis_signature_om" :
				$requete = "UPDATE evenements_participants SET `etat_om` = '2' WHERE id_evenement ='".$id_evenement."' AND `etat_om` = '1'";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "liste_emargement_marquer_edition_om" :
				$requete = "UPDATE evenements_participants SET `etat_om` = '1' WHERE id_evenement ='".$id_evenement."' AND `etat_om` = '0'";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "liste_emargement_marquer_envoi_om" :
				$requete = "UPDATE evenements_participants SET `etat_om` = '2' WHERE id_evenement ='".$id_evenement."' AND `etat_om` = '40'";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "marquer_remis_signature_individuel" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '2' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = 1)";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					// On enregistre le suivi
					// On récupère l'identifiant unique
					$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
					
					//echo "<br />id_ep : $id_ep";
					
					//Et on enregistre le suivi
					enreg_suivi_om($id_ep,2,"");
				}
			break;

			case "desactiver_om" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '-1' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."'";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "activer_om" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '0' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = -1)";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;

			case "marquer_envoi_om" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '3' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = 2)";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					// On enregistre le suivi
					// On récupère l'identifiant unique
					$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
					
					//echo "<br />id_ep : $id_ep";
					
					//Et on enregistre le suivi
					enreg_suivi_om($id_ep,2,"");
				}
			break;
 
			case "marquer_present" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '4' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = 3 OR etat_om = 5)";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					// On enregistre le suivi
					// On récupère l'identifiant unique
					$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
					//Et on enregistre le suivi
					enreg_suivi_om($id_ep,3,"");
				}
			break;

			case "marquer_absent" :
				$id_participant = $_GET['id_participant'];
				$requete = "UPDATE evenements_participants SET `etat_om` = '5' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."' AND (etat_om = 3 OR etat_om = 4)";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					// On enregistre le suivi
					// On récupère l'identifiant unique
					$id_ep = recup_id_evenement_participant($id_evenement, $id_participant);
					//Et on enregistre le suivi
					enreg_suivi_om($id_ep,4,"");
				}
			break;

			case "changer_annee_imputation" :
				$id_participant = $_GET['id_participant'];
				$annee_imputation = $_GET['annee_imputation'];
				$requete = "UPDATE evenements_participants SET `annee_imputation` = '".$annee_imputation."' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."'";
				$resultat = mysql_query($requete);
				if (!$resultat)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;
		}

	} //Fin des actions supplémentaires
	If ($affichage <> "N")
	{
		////// Initialisation des variables ///////////////////////////////////////////////////////
		$requete_evenement="SELECT * FROM evenements AS e, util AS u, categorie_commune AS cc
			WHERE e.fk_id_util = u.ID_UTIL
				AND e.fk_id_dossier = cc.id_categ
				AND e.id_evenement = '".$id_evenement."'";

		//echo "<br />$requete_evenement";

		$result_evenement=mysql_query($requete_evenement);
		$num_rows = mysql_num_rows($result_evenement);
		$ligne_evenement = mysql_fetch_object($result_evenement);
		//$date_creation = $ligne_evenement->date_crea;
		$date_evenement_debut = $ligne_evenement->date_evenement_debut;
		$date_evenement_fin = $ligne_evenement->date_evenement_fin;
		$heure_debut_evenement = $ligne_evenement->heure_debut_evenement;
		$heure_fin_evenement = $ligne_evenement->heure_fin_evenement;
		$titre = $ligne_evenement->titre_evenement;
		$description = $ligne_evenement->detail_evenement;
		$emetteur = $ligne_evenement->NOM;
		$dossier = $ligne_evenement->intitule_categ;
		$fk_repertoire = $ligne_evenement->fk_repertoire;
		$fk_rne = $ligne_evenement->fk_rne;
		$autre_lieu = $ligne_evenement->autre_lieu;

		//$id_util_creation = $ligne_evenement->id_util_creation;
		//$id_util_traitant = $ligne_evenement->id_util_traitant;

		//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections
	/*
		$date_creation_a_traiter = strtotime($date_creation);
		$date_creation_jour = date('d',$date_creation_a_traiter);
		$date_creation_mois = date('m',$date_creation_a_traiter);
		$date_creation_annee = date('Y',$date_creation_a_traiter);
	*/
		$date_debut_a_afficher = affiche_date($date_evenement_debut);
		If ($date_evenement_fin <> "0000-00-00")
		{
			$date_fin_a_afficher = affiche_date($date_evenement_fin);
		}

/*
		$date_evenement_a_traiter = strtotime($date_evenement_debut);
		$date_evenement_jour = date('d',$date_evenement_a_traiter);
		$date_evenement_mois = date('m',$date_evenement_a_traiter);
		$date_evenement_annee = date('Y',$date_evenement_a_traiter);
*/
		//On initialise la date d'aujourd'hui au cas que la date de rappel n'est pas fixée
		$aujourdhui_jour = date('d');
		$aujourdhui_jour = $aujourdhui_jour+7;
		$aujourdhui_mois = date('m');
		$aujourdhui_annee = date('Y');

		//$date_rappel_a_traiter = strtotime($date_rappel);
		//$date_rappel_annee = date('Y',$date_rappel_a_traiter);

		//On retire les secondes pour l'affichage
		$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
		$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);

		/*
		echo "<br />heure_debut_evenement : $heure_debut_evenement";
		echo "<br />heure_fin_evenement : $heure_fin_evenement";
		*/

		echo "<br><table border = \"1\" align = \"center\">";
			echo "<colgroup>";
				echo "<col width=\"40%\">";
				echo "<col width=\"60%\">";
			echo "</colgroup>";
	/*
			echo "<tr>";
				echo "<td class = \"etiquette\">Identifiant du evenement&nbsp;:&nbsp;</th>";
				echo "<td>$id_evenement</td>";
			echo "</tr>";
	*/
			echo "<tr>";
				echo "<td class = \"etiquette\">Titre de l'&eacute;v&eacute;nement&nbsp;:&nbsp;</td>";
				echo "<td>$titre</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Responsable de cet &eacute;v&eacute;nement&nbsp;:&nbsp;</td>";
				echo "<td>";
						echo "$emetteur";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Dossier concern&eacute;&nbsp;:&nbsp;</td>";
				echo "<td>";
						echo "$dossier<br>";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Date et horaire de l'&eacute;v&eacute;nement&nbsp;:&nbsp;</td>";
				echo "<td>";
					If ($date_evenement_fin <> "0000-00-00")
					{
						echo "$date_debut_a_afficher - $date_fin_a_afficher -- $heure_debut_evenement-$heure_fin_evenement";
					}
					else
					{
						echo "$date_debut_a_afficher -- $heure_debut_evenement-$heure_fin_evenement";
					}
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Lieu&nbsp;:&nbsp;</td>";
				echo "<td>";
					affiche_lieu_evenement($fk_rne, $fk_repertoire, $autre_lieu);
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">D&eacute;tail&nbsp;:&nbsp;</td>";
				echo "<td>$description</td>";
			echo "</tr>";
		echo "</table>";

		//////////////////////////////////
		// Affichage du bouton retour ////
		//////////////////////////////////
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"evenements_accueil.php?&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;date_filtre=".$date_filtre."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		//On affiche les participants
		include ("evenement_liste_participants.inc.php");
	}
?>
