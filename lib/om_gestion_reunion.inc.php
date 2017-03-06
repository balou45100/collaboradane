<?php
	//Il faut récupérer les informations concernant la commande
	$requete_reunion="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_reunion WHERE idreunion = '".$idreunion."'";
	//$requete_reunion="SELECT * FROM om_reunion WHERE idreunion = '".$idreunion."'";
	
	//echo "<br >$requete_reunion";
	
	$result_reunion=mysql_query($requete_reunion);
	$num_rows = mysql_num_rows($result_reunion);
	//echo "<br>Nombre d'enregistrements retourné : $num_rows";
	
	$ligne_reunion=mysql_fetch_object($result_reunion);
	$idreunion = $ligne_reunion->idreunion;
	$date_debut = $ligne_reunion->Date_D;
	$date_fin = $ligne_reunion->Date_F;
	$heure_debut = $ligne_reunion->Heure_D;
	$heure_fin = $ligne_reunion->Heure_F;
	$idsalle = $ligne_reunion->idsalle;
	$intitule_reunion = $ligne_reunion->intitule_reunion;
	$date_horaire_debut = $ligne_reunion->date_horaire_debut;
	$date_horaire_fin = $ligne_reunion->date_horaire_fin;
	$date_livraison_complete = $ligne_reunion->date_livraison_complete;
	$etat = $ligne_reunion->etat;
	$annee_budgetaire = $ligne_reunion->annee;
	$description = $ligne_reunion->description;
	$id_responsable = $ligne_reunion->id_responsable;
	$ref_enveloppe_budgetaire = $ligne_reunion->ref_enveloppe_budgetaire;
	$ref_centre_cout = $ligne_reunion->ref_centre_cout;

	//On récupère les informations sur l'enveloppe budgétaire
	$requete_enveloppe_budgetaire = "SELECT * FROM om_enveloppe_budgetaire WHERE ref_enveloppe_budgetaire = '".$ref_enveloppe_budgetaire."'";
	
	//echo "<br />$requete_enveloppe_budgetaire";
	
	$result_requete_enveloppe_budgetaire=mysql_query($requete_enveloppe_budgetaire);
	$ligne_enveloppe_budgetaire = mysql_fetch_object($result_requete_enveloppe_budgetaire);
	$ref_enveloppe_budgetaire = $ligne_enveloppe_budgetaire->ref_enveloppe_budgetaire;
	$intitule_enveloppe_budgetaire = $ligne_enveloppe_budgetaire->intitule_enveloppe_budgetaire;

	//On récupère les informations sur le centre de coûts
	$requete_centre_cout = "SELECT * FROM om_centre_couts WHERE ref_centre_cout = '".$ref_centre_cout."'";
	
	//echo "<br />$requete_centre_cout";
	
	$result_requete_centre_cout=mysql_query($requete_centre_cout);
	$ligne_centre_cout = mysql_fetch_object($result_requete_centre_cout);
	$ref_centre_cout = $ligne_centre_cout->ref_centre_cout;
	$intitule_centre_cout = $ligne_centre_cout->intitule_centre_cout;

	echo "<h2>Fiche de la r&eacute;union $idreunion</h2>";
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		
		echo "<colgroup>";
			echo "<col width=\"15%\">";
			echo "<col width=\"10%\">";
			echo "<col width=\"15%\">";
			echo "<col width=\"25%\">";
			echo "<col width=\"15%\">";
			echo "<col width=\"5%\">";
			echo "<col width=\"5%\">";
			echo "<col width=\"10%\">";
		echo "</colgroup>";
		
		echo "<tr>";
			echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$idreunion</td>";
			echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$intitule_reunion</td>";
			echo "<td class = \"etiquette\">Dates&nbsp;:&nbsp;</td>";
			if ($date_debut == $date_fin)
			{
				echo "<td>&nbsp;$date_debut</td>";
			}
			else
			{
				echo "<td>&nbsp;$date_debut - $date_fin</td>";
			}
			echo "<td class = \"etiquette\">Horaires&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$heure_debut - $heure_fin</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Description&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"7\">&nbsp;$description</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Lieu&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"7\">&nbsp;$idsalle</td>";
		echo "</tr>";


		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$annee_budgetaire</td>";
			echo "<td class = \"etiquette\">Enveloppe budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "&nbsp;$ref_enveloppe_budgetaire - $intitule_enveloppe_budgetaire";
			echo "</td>";
			echo "<td class = \"etiquette\">Centre de coûts&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"3\">";
				echo "&nbsp;$ref_centre_cout - $intitule_centre_cout";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";

	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// On affiche les participants de la reunion /////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//echo "<h2>Les participants de la r&eacute;union $idreunion</h2>";

	$requete_participants = "SELECT * FROM om_ordres_mission AS OM, personnes_ressources_tice AS PRT WHERE OM.id_pers_ress = PRT.id_pers_ress AND OM.idreunion = '".$idreunion."'";
	
	//echo "<br />$requete_participants";
	
	$resultat_requete_participants = mysql_query($requete_participants);
	$num_rows = mysql_num_rows($resultat_requete_participants);
	if ($num_rows >0)
	{
		echo "<h2>Nombre de participants pour la r&eacute;union : $num_rows</h2>";
		echo "<TABLE BORDER=\"0\" ALIGN=\"CENTER\">";
			echo "<TR>";
				echo "<th align=\"center\">Nom</th> ";
				echo "<th align=\"center\">Pr&eacute;nom</th> ";
				echo "<th align=\"center\">M&eacute;l</th> ";
				echo "<th align=\"center\">Discipline</th> ";
				echo "<th align=\"center\">Poste</th> ";
				echo "<th align=\"center\">UAI / RNE</th> ";
				//if ($autorisation_gestion_materiels == 1)
				//{
					echo "<th align=\"center\">ACTIONS</th> ";
				//}
			echo "</tr>";
			while ($ligne_participants_extrait = mysql_fetch_object($resultat_requete_participants))
			{
				$id_pers_ress = $ligne_participants_extrait->id_pers_ress;
				$idreunion = $ligne_participants_extrait->idreunion;
				$nom = $ligne_participants_extrait->nom;
				$prenom = $ligne_participants_extrait->prenom;
				$mel = $ligne_participants_extrait->mel;
				$discipline = $ligne_participants_extrait->discipline;
				$poste = $ligne_participants_extrait->poste;
				$codetab = $ligne_participants_extrait->codetab;

				echo "<TR class = \"new\">";
					echo "<TD align = \"center\">";
						echo $nom;
					echo "</TD>";
					echo "<TD>";
						echo $prenom;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $mel;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $discipline;
					echo "</TD>";
					echo "<TD>";
						echo $poste;
					echo "</TD>";
					echo "<TD>";
						affiche_info_bulle($codetab,RESS,0);
						//echo $codetab;
					echo "</TD>";

					//Les actions
					//if ($autorisation_gestion_materiels == 1)
					//{
						echo "<TD nowrap class = \"fond-actions\">";
						//echo "<A HREF = \"materiels_gestion_commandes_affiche_reunion.php?actions=O&amp;a_faire=afficher_reunion&amp;id_reunion=$id_reunion&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter\" title=\"Consulter la reunion\"></A>";
						echo "<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=gestion_participants&amp;action_supplementaire=supprimer_participant&amp;id_pers_ress=$id_pers_ress&amp;idreunion=$idreunion\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer le participant\"></A>";
						echo "</TD>";
					//}
				echo "</TR>";
			} //Fin while $ligne
		echo "</table>";
	} //Fin if num_rows >0
	else
	{
		echo "<h2>Pas de participants pour cette r&eacute;union</h2>";
	}
	
	include ("om_ajout_participant_reunion.inc.php");

/*
	echo "<form method=\"post\" action=\"om_affichage_reunion.php\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/utilisateur_ajout.png\" ALT = \"Ajouter participant\" title=\"Ajouter participant\" border=\"0\" type=image Value=\"ajout_participant\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Ajouter un participant</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";

		echo "<input type=hidden name=\"a_faire\" value=\"gestion_participants\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
		echo "<input type=hidden name=\"idreunion\" value=\"$idreunion\"/>";
	echo "</form>";
*/

?>
