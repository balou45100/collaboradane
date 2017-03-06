<?php
	//echo "<br />niveau_droits : $niveau_droits";
	//echo "<br />id_evenement : $id_evenement";
	//On construit la requête
	$requete_participants = "SELECT * FROM personnes_ressources_tice AS prt, evenements_participants AS ep
		WHERE prt.id_pers_ress = ep.id_participant
			AND ep.id_evenement = $id_evenement
		ORDER BY prt.nom, prt.prenom";
			
	//echo "<br />$requete_participants";
	
	$resultat = mysql_query($requete_participants);
	if(!$resultat)
	{
		echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
		echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
		mysql_close();
		exit;
	}

	$nbr_enregistrements = mysql_num_rows($resultat);
	//On récupère l'id du propriétaire de l'événement
	$id_proprio = lecture_champ("evenements","fk_id_util","id_evenement",$id_evenement);
	//echo "<br />id_pers_ress : $id_pers_ress";
	if ($nbr_enregistrements == 0)
	{
		echo "<h2>Pas de participants pour cet &eacute;v&eacute;nement</h2>";
	}
	else
	{
		echo "<h2>Nombre de participants : $nbr_enregistrements</h2>";
		//On vérifie les droits, seul le "propriétaire" d'un événement ou les administrateurs ont droit aux actions
		
		if ($niveau_droits == 3 OR $_SESSION['id_util'] == $id_proprio)
		{
			if ($nbr_enregistrements > 5)
			{
				////////////////////////////////////////////////////////////////////////
				// On affiche les deux champs de saisie pour ajouter des participants //
				////////////////////////////////////////////////////////////////////////
				//include ("evenement_liste_participants_ajout_participants.inc.php");
			}
			echo "<table class = \"menu-boutons\">";
				/*
				echo "<colgroup>";
					echo "<col width=\"20%\">";
					echo "<col width=\"20%\">";
					echo "<col width=\"20%\">";
					echo "<col width=\"20%\">";
					echo "<col width=\"20%\">";
				echo "</colgroup>";
				*/
				echo "<tr>";
					echo "<td>";
						//echo "&nbsp;";
						echo "<a href=\"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=suppression_liste_participants&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target=\"body\"  title=\"Effacer la liste\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" border=\"0\"></a><br /><span class=\"IconesAvecTexte\">Effacer la liste</span>";
					echo "</td>";
					if ($niveau_droits == 3)
					{
/*
						echo "<td>";
							//echo "<a href=\"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=liste_OM&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target=\"body\"  title=\"CSV pour OM\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/om.png\" border=\"0\"></a><br /><span class=\"IconesAvecTexte\">CSV pour OM</span>";
							echo "<FORM ACTION = \"evenements_accueil.php\" target = \"_blank\" METHOD = \"GET\">";
							//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"g&eacute;n&eacute;rer&nbsp; un CSV\" src=\"$chemin_theme_images/fichier_csv.png\" ALT = \"CSV\" title = \"g&eacute;n&eacute;rer&nbsp; un CSV\">";
							echo "<br /><span class=\"IconesAvecTexte\">CSV pour OM</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_om\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
							//echo "&nbsp;";
							//echo "&nbsp;";
							//echo "&nbsp;";
							//echo "&nbsp;";
						echo "</td>";
*/
						echo "<td>";
							//echo "<a href=\"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=liste_OM&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target=\"body\"  title=\"CSV pour OM\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/om.png\" border=\"0\"></a><br /><span class=\"IconesAvecTexte\">CSV pour OM</span>";

							echo "<FORM ACTION = \"evenements_accueil.php\" target = \"_blank\" METHOD = \"GET\">";
							//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"liste_emargement\" src=\"$chemin_theme_images/liste_emargement.png\" ALT = \"CSV\" title = \"Liste d'&eacute;margements\">";
							echo "<br /><span class=\"IconesAvecTexte\">&Eacute;margements</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_emargement\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
						echo "</td>";

						echo "<td>";
							echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"liste_emargement_valider_edition_om\" src=\"$chemin_theme_images/liste_emargement_marquer_edition_om.png\" ALT = \"EDITIONOM\" title = \"Marquer les OM &eacute;dit&eacute;s\">";
							echo "<br /><span class=\"IconesAvecTexte\">Marquer OM &eacute;dit&eacute;s</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_emargement_marquer_edition_om\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
						echo "</td>";

						echo "<td>";
							echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"Remis_signature\" src=\"$chemin_theme_images/om_marquer_remis_signature.png\" ALT = \"SignatureOM\" title = \"OM remis &agrave; la signature\">";
							echo "<br /><span class=\"IconesAvecTexte\">Marquer OM remis &agrave; la signature</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_marquer_remis_signature_om\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
						echo "</td>";

						echo "<td>";
							echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"liste_emargement_valider_envoi_om\" src=\"$chemin_theme_images/om_envoi.png\" ALT = \"ENVOIOM\" title = \"Marquer les OM envoy&eacute;s\">";
							echo "<br /><span class=\"IconesAvecTexte\">Marquer OM envoy&eacute;s</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_emargement_marquer_envoi_om\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
						echo "</td>";

						echo "<td>";
							//echo "<a href=\"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=liste_OM&amp;id_evenement=".$id_evenement."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target=\"body\"  title=\"CSV pour OM\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/om.png\" border=\"0\"></a><br /><span class=\"IconesAvecTexte\">CSV pour OM</span>";

							echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
							//echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"&eacute;diter&nbsp; la fiche de pr&ecirc;t ou de remise\">";
							echo "&nbsp;<INPUT TYPE = \"image\" VALUE = \"liste_emargement_valider_presences\" src=\"$chemin_theme_images/liste_emargement_valider_presences.png\" ALT = \"VALPRESENCE\" title = \"Valider les pr&eacute;sences des participants\">";
							echo "<br /><span class=\"IconesAvecTexte\">Valider pr&eacute;sences</span>";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"liste_emargement_valider_presences\" NAME = \"a_faire2\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
							echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
							echo "</FORM>";
						echo "</td>";

					}
				echo "</tr>";
			echo "<table>";
		}

		echo "<table>";
			echo "<tr>";
				echo "<th>";
					echo "ID";
				/*
				if ($sense_tri =="asc")
				{
					echo "ID<A href=\"personnes_ressources_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par N&ordm; de soci&eacute;t&eacute;, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "ID<A href=\"personnes_ressources_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par N&ordm; de soci&eacute;t&eacute;, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
					echo "ST";
				echo "</th>";
				echo "<th>";
					echo "CIVIL";
				echo "</th>";
				echo "<th>";
					echo "NOM";
				/*
				if ($sense_tri =="asc")
				{
					echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
						echo "PRENOM";
				echo "</th>";
				echo "<th>";
					echo "DISCIPLINE";
				/*
				if ($sense_tri =="asc")
				{
					echo "DISCIPLINE<A href=\"personnes_ressources_gestion.php?tri=DISC&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "DISCIPLINE<A href=\"personnes_ressources_gestion.php?tri=DISC&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
					echo "POSTE";
				/*
				if ($sense_tri =="asc")
				{
					echo "POSTE<A href=\"personnes_ressources_gestion.php?tri=POSTE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "POSTE<A href=\"personnes_ressources_gestion.php?tri=POSTE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
					echo "FONCTION";
				/*
				if ($sense_tri =="asc")
				{
					echo "FONCTION<A href=\"personnes_ressources_gestion.php?tri=FONCTION&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "FONCTION<A href=\"personnes_ressources_gestion.php?tri=FONCTION&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
					echo "MEL";
				echo "</th>";
				echo "<th>";
					echo "CODETAB";
				/*
				if ($sense_tri =="asc")
				{
					echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
				}
				else
				{
					echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
				}
				*/
				echo "</th>";
				echo "<th>";
					echo "FRAIS";
				echo "</th>";
/*
				echo "<th>";
					echo "AIMP";
				echo "</th>";
*/
				if ($en_liste <> "Oui")
				{
					if ($niveau_droits == "3" OR $_SESSION['id_util'] == $id_proprio)
					{
						echo "<th>ACTIONS</th>";
					}
				}
				else
				{
					echo "<th>Type</th>";
					echo "<th>Nom_etab</th>";
					echo "<th>Ville_etab</th>";
					echo "<th>courriel</th>";
				}
				while ($ligne = mysql_fetch_object($resultat))
				{
					$id_pers_ress = $ligne->id_pers_ress;
					$civil = $ligne->civil;
					$nom = $ligne->nom;
					$prenom = $ligne->prenom;
					$codetab = $ligne->codetab;
					$discipline = $ligne->discipline;
					$poste = $ligne->poste;
					$fonction = $ligne->fonction;
					$mel_extrait = $ligne->mel;
					$frais = $ligne->frais;
					$etat_om = $ligne->etat_om;
					$montant_paye_chorus = $ligne->montant_paye_chorus;
					$annee_imputation = $ligne->annee_imputation;
					
					//On fixe le fond de la cellule pour les frais
					switch ($frais)
					{
						case "A":
							$classe_fond = "avec";
						break;

						case "S":
							$classe_fond = "sans";
						break;

						case "C":
							$classe_fond = "sans";
						break;
					}

					//On récupère les infos concernant l'établissements
					$query_etab = "SELECT TYPE, NOM, VILLE, MAIL FROM etablissements WHERE rne = '".$codetab."'";
					$resultat_etab = mysql_query($query_etab);
					$ligne_etab = mysql_fetch_object($resultat_etab);
					$type_etab = $ligne_etab->TYPE;
					$nom_etab = $ligne_etab->NOM;
					$ville_etab = $ligne_etab->VILLE;
					$mel_etab = $ligne_etab->MAIL;
					if ($id_pers_ress <> "")
					{
						$mel = $mel_extrait."@ac-orleans-tours.fr";
						echo "<tr>";
							echo "<td align = \"center\">";
								echo $id_pers_ress;
							echo "</td>";
							$classe_etat_om = etat_om($etat_om);
							$om_image = $classe_etat_om.".png";
							$titre_icone = etat_om_en_clair($etat_om);
							
							//echo "<td class = \"$classe_etat_om\" align=\"center\">";
							echo "<td align=\"center\">";
								//echo "$om_image";
								echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/$om_image\" border=\"0\" title=\"$titre_icone\">";
							echo "</td>";
							echo "<td align = \"center\">";
								echo $civil;
							echo "</td>";
							echo "<td>";
								echo $nom;
							echo "</td>";
							echo "<td>";
								echo $prenom;
							echo "</td>";
							echo "<td align=\"center\">";
								echo $discipline;
							echo "</td>";
							echo "<td align=\"center\">";
								echo $poste;
							echo "</td>";
							echo "<td align=\"center\">$fonction</td>";
							
							echo "<td>";
								echo "<a href=\"mailto:".$mel."?cc=".$_SESSION['mail']."\">$mel</a>";
							echo "</td>";
							echo "<td>";
								if ($en_liste <> "Oui")
								{
									affiche_info_bulle($codetab,"RESS",0); //rne, module, id_ticket
								}
								else
								{
									echo $codetab;
								}
							echo "</td>";

							echo "<td align=\"center\" nowrap>";
							//echo "<td class = \"$classe_fond\" align=\"center\" nowrap>";
								//echo "$frais&nbsp;";
								if ($niveau_droits == 3)
								{
									if ($frais == "A")
									{
										echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\">";
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=S&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\"></a>";
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=C&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"sans frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\"></a>";
									}
									elseif ($frais == "S")
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=A&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\"></a>";
										echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\">";
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=C&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"sans frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\"></a>";
									}
									elseif ($frais == "C")
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=A&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_avec_frais.png\" border=\"0\"></a>";
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=changer_frais&amp;frais=S&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\" title=\"avec frais\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/om_sans_frais.png\" border=\"0\"></a>";
										echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/covoiturage.png\" border=\"0\">";
									}
								}
								echo "</td>";
								
							echo "</td>";
/*
							echo "<td align=\"center\">";
								//echo $annee_imputation;
								///////////////////////
								if ($montant_paye_chorus == "0.00")
								{
									echo "<FORM ACTION = \"evenements_accueil.php\" METHOD = \"GET\">";
									echo "<input type = \"text\" VALUE = \"$annee_imputation\" NAME = \"annee_imputation\" SIZE = \"4\" required placeholder=\"ann&eacute;e imputation\">";
									echo "&nbsp;<input type = \"submit\" VALUE = \">>\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_participant\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"changer_annee_imputation\" NAME = \"a_faire2\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
									echo "<INPUT TYPE = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
									echo "</FORM>";
								}
								else
								{
									echo $annee_imputation;
								}
*/
								///////////////////////////
							echo "</td>";

							if ($en_liste == "Oui")
							{
								echo "<td align=\"center\">";
									echo $type_etab;
								echo "</td>";
								echo "<td align=\"center\">";
									echo $nom_etab;
								echo "</td>";
								echo "<td align=\"center\">";
									echo $ville_etab;
								echo "</td>";
								echo "<td align=\"center\">";
									echo $mel_etab;
								echo "</td>";
							}
//////////////////////////////Les actions//////////////////////////////////////////////////////////////
							echo "<td class = \"fond-actions\" nowrap>";
								if (($niveau_droits == "3" OR $_SESSION['id_util'] == $id_proprio) AND $etat_om < 4)
								{
									echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=suppression_participant&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer la personne de l'&eacute;v&eacute;nement\"></a>";
								}
								else
								{
									echo "&nbsp;";
								}
								if ($niveau_droits == "3")
								{
									if ($etat_om <> -1) 
									{
										echo "&nbsp;<a target = \"_blank\" href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=affiche_om&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om.png\" border = \"0\" ALT = \"OM\" title=\"Afficher l'OM\"></a>";
									}
									
									if ($etat_om == -1) //le participant n'a pas besoin d'OM
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=activer_om&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_activer.png\" border = \"0\" ALT = \"ActiverOM\" title=\"Activer l'OM\"></a>";
									}
									
									if ($etat_om == 0) 
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=desactiver_om&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_sans.png\" border = \"0\" ALT = \"D&eacute;sactiverOM\" title=\"D&eacute;sactiver l'OM\"></a>";
									}

									if ($etat_om == 1)
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_remis_signature_individuel&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_marquer_remis_signature.png\" border = \"0\" ALT = \"SignatureOM\" title=\"Marquer OM en attente de signature\"></a>";
									}

									if ($etat_om == 2)
									{
										echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_envoi_om&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_envoi.png\" border = \"0\" ALT = \"ENVOIOM\" title=\"Marquer OM envoy&eacute;\"></a>";
									}

		
		
									if ($etat_om == 3 OR $etat_om == 5)
									{
										if ($civil <> "MME")
										{
											echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_present&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/present.png\" border = \"0\" ALT = \"PRESENT\" title=\"Marquer pr&eacute;sent\"></a>";
										}
										else
										{
											echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_present&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/present.png\" border = \"0\" ALT = \"PRESENTE\" title=\"Marquer pr&eacute;sente\"></a>";
										}
									}
									if ($etat_om == 3 OR $etat_om == 4)
									{
										if ($civil <> "MME")
										{
											echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_absent&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/absent.png\" border = \"0\" ALT = \"ABSENT\" title=\"Marquer absent\"></a>";
										}
										else
										{
											echo "&nbsp;<a href = \"evenements_accueil.php?action=O&amp;a_faire=info_evenement&amp;action2=O&amp;a_faire2=marquer_absent&amp;id_evenement=".$id_evenement."&amp;id_participant=".$id_pers_ress."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=$visibilite&amp;date_filtre=".$date_filtre."&amp;id_pers_ress=".$id_pers_ress."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/absent.png\" border = \"0\" ALT = \"ABSENTE\" title=\"Marquer absente\"></a>";
										}
									}
								}
							echo "</td>";
					}
				}
			echo "</tr>";
		echo "</table>";
		//On affiche la légende
		$debut_compteur=0;
		include ("om_legende_statut.inc.php");

	}
	if ($niveau_droits == 3 OR $_SESSION['id_util'] == $id_proprio)
	{
		////////////////////////////////////////////////////////////////////////
		// On affiche les deux champs de saisie pour ajouter des participants //
		////////////////////////////////////////////////////////////////////////
		include ("evenement_liste_participants_ajout_participants.inc.php");
	}
?>
