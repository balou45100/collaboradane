<?php
	/*
	echo "<h2>Affichage par projets</h2>";
	echo "<br />niveau_droits : $niveau_droits";
	echo "<br />util : $id_util";
	echo "<br />decision_commission : $decision_commission";
	*/
	
	//Composition de la requête de base en fonction du profil de la personne connectée
	if ($niveau_droits > 1) //Il s'agit des droits de gestion au niveau de la CARDIE
	{
/*
		$requete_base = "SELECT * FROM 
			cardie_projet AS CP, 
			etablissements AS ETAB,
			cardie_projet_accompagnement AS CPA 
		WHERE CP.RNE = ETAB.RNE
			AND CP.NUM_PROJET = CPA.FK_NUM_PROJET";
*/
		if ($mes_projets <> "O")
		{
			$requete_base = "SELECT * FROM 
				cardie_projet AS CP, 
				etablissements AS ETAB
			WHERE CP.RNE = ETAB.RNE";
		}
		else
		{
			//Il faut récupérer l'identifiant de la table personnes_ressources_tice de l'accompagnateur connecté
			//On extrait la partie avant l'@ de la adresse électronique
			$adresse_electronique = $_SESSION['mail'];
			$debut_adresse_electronique = explode("@", $adresse_electronique);
			$mel_pers_ress = $debut_adresse_electronique[0];
			/*
			echo "<br />adresse &eacute;lectronique : $adresse_electronique";
			echo "<br />mel_pers_ress = $mel_pers_ress";
			*/
			$requete_id_pers_ress = "SELECT * FROM personnes_ressources_tice WHERE mel = '".$mel_pers_ress."'";
			
			//echo "<br />requete_id_pers_ress : $requete_id_pers_ress";
			
			$resultat = mysql_query($requete_id_pers_ress);
			$ligne = mysql_fetch_object($resultat);
			$id_pers_ress = $ligne->id_pers_ress;
			$requete_base = "SELECT * FROM 
				cardie_projet AS CP, 
				etablissements AS ETAB,
				cardie_projet_accompagnement AS CPA
			WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CP.RNE = ETAB.RNE
				AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CPA.FK_ID_PERS_RESS = '".$id_pers_ress."'";
		}
		//echo "<br />requete_base : $requete_base";
	}
	else //il s'agit des droits d'accompagnateur
	{
		//Il faut récupérer l'identifiant de la table personnes_ressources_tice de l'accompagnateur connecté
		//On extrait la partie avant l'@ de la adresse électronique
		$adresse_electronique = $_SESSION['mail'];
		$debut_adresse_electronique = explode("@", $adresse_electronique);
		$mel_pers_ress = $debut_adresse_electronique[0];
		/*
		echo "<br />adresse &eacute;lectronique : $adresse_electronique";
		echo "<br />mel_pers_ress = $mel_pers_ress";
		*/
		$requete_id_pers_ress = "SELECT * FROM personnes_ressources_tice WHERE mel = '".$mel_pers_ress."'";
		
		//echo "<br />requete_id_pers_ress : $requete_id_pers_ress";
		
		$resultat = mysql_query($requete_id_pers_ress);
		$ligne = mysql_fetch_object($resultat);
		$id_pers_ress = $ligne->id_pers_ress;
		$requete_base = "SELECT * FROM 
			cardie_projet AS CP, 
			etablissements AS ETAB,
			cardie_projet_accompagnement AS CPA
		WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CP.RNE = ETAB.RNE
			AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CPA.FK_ID_PERS_RESS = '".$id_pers_ress."'";
		
		//echo "<br />requete_base : $requete_base";
	}

	//On regarde si l'appel vient de l'entête
	if ($origine_appel == "entete_projets")
	{
		$_SESSION['decision_commission'] = $decision_commission;
		$_SESSION['type_accompagnement'] = $type_accompagnement;
		$_SESSION['etat_projet'] = $etat_projet;
	}
	else
	{
		$decision_commission = $_SESSION['decision_commission'];
		$type_accompagnement = $_SESSION['type_accompagnement'];
		$etat_projet = $_SESSION['etat_projet'];
	}

	//On filtre les enregistrements en fonction de la décision de la commission choisie
	
	switch ($decision_commission)
	{
		case "T" : //Tous les projets
			if ($mes_projets <> "O")
			{
				echo "<h2>Tous les projets</h2>";
			}
			else
			{
				echo "<h2>Tous mes projets</h2>";
			}
			$requete_compl_decision_commission = " AND CP.DECISION_COMMISSION LIKE '%'";
		break;

		case "NOUV" : //Les projets sans décision
			echo "<h2>Les projets sans d&eacute;cision de la commission</h2>";
			$requete_compl_decision_commission = " AND CP.DECISION_COMMISSION = ''";
		break;

		case "RETENU" : //Tous les projets retenus
			echo "<h2>Les projets retenus par la commission</h2>";
			$requete_compl_decision_commission = " AND CP.DECISION_COMMISSION = 'retenu'";
		break;

		case "POURSUITE" : //Tous les projets poursuivis
			echo "<h2>Les projets poursuivis une nouvelle ann&eacute;e</h2>";
			$requete_compl_decision_commission = " AND CP.DECISION_COMMISSION = 'poursuite'";
		break;

		case "RETPOUR" : //Tous les projets poursuivis et retenu
			echo "<h2>Les projets retenus et poursuivis</h2>";
			$requete_compl_decision_commission = " AND (CP.DECISION_COMMISSION = 'poursuite' OR CP.DECISION_COMMISSION = 'retenu')";
		break;

		case "AUTONOME" : //Tous les projets autonomes
			echo "<h2>Les projets autonomes apr&egrave;s d&eacute;cision de la commission</h2>";
			$requete_compl_decision_commission = " AND CP.DECISION_COMMISSION = 'autonome'";
		break;

	} //Fin switch $decision_commission
	
	//On ajoute le filtre pour le type d'accompagnement
	switch ($type_accompagnement)
	{
		case "T": //Tous types
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT LIKE '%'";
		break;

		case "NON_DEFINI": //Sans type
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = ''";
		break;

		case "INSITU": //Projets suivis in situ
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'in situ'";
		break;

		case "A_DISTANCE": //Projets suivis à distance
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'a distance'";
		break;

		case "RECHERCHE": //Suivis par la recherche
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'recherche'";
		break;

		case "GROUPE_DEVELOPPEMENT": //Suivis par des groupes de développements
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'groupe developpement'";
		break;

		case "EXPERITHEQUE": //Suivis dans Expérithèque
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'experitheque'";
		break;

		case "PARTENARIAL": //Suivis partenarial
			$requete_compl_type_accompagnement = " AND CP.TYPE_ACCOMPAGNEMENT = 'partenarial'";
		break;
	} //Fin switch type_accompagnement
	
	switch ($etat_projet)
	{
		case "O": 
			$requete_compl_etat = " AND actif = 'O'";
			$comp_titre = "actifs";
		break;

		case "%": 
			$requete_compl_etat = " AND actif = 'O'";
			$comp_titre = "actifs";
		break;

		case "N": 
			$requete_compl_etat = " AND actif = 'N'";
			$comp_titre = "archiv&eacute;s";
		break;
	}
	
	//On détermine le tri
	$requete_compl_tri = " ORDER BY $tri $sense_tri";
	
	//$requete_complete = $requete_base.$requete_compl_decision_commission.$requete_compl_type_accompagnement.$requete_compl_acc.$requete_compl_etat.$requete_compl_tri;
	$requete_complete = $requete_base.$requete_compl_decision_commission.$requete_compl_type_accompagnement.$requete_compl_etat.$requete_compl_tri;
	
	//echo "<br />requete_complete : $requete_complete";

	//Exécution de la requête
	$resultat = mysql_query($requete_complete);
	
	if(!$resultat)
	{
		echo "<br />Probl&egrave;me de connexion, Vous n'&ecirc;tes pas inscrit-e ou erreur dans la requ&egrave;te";
		//mysql_close();
		//exit;
	}
	else
	{
		$num_results = mysql_num_rows($resultat);
	}
	//Affichage de l'entête s'il y a des résultats retournés
	if (!$num_results)
	{
		echo "<h2>Pas d'enregistrement pour l'instant</h2>";
	}
	else
	{
		echo "<h2>Nombre de projets $comp_titre&nbsp;:&nbsp;$num_results</h2>";
		//On affiche l'entête du tableau
		echo "<table>";
			echo "<tr>";
				echo "<th nowrap>";
				if ($sense_tri =="asc")
				{
					echo "ID&nbsp;<a href=\"cardie_gestion_projets.php?tri=NUM_PROJET&amp;sense_tri=desc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par No de projet, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "ID&nbsp;<a href=\"cardie_gestion_projets.php?tri=NUM_PROJET&amp;sense_tri=asc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par No de projet, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				echo "<th>";
				if ($sense_tri =="asc")
				{
					echo "Intitul&eacute; projet&nbsp;<a href=\"cardie_gestion_projets.php?tri=INTITULE&amp;sense_tri=desc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "Intitul&eacute; rojet&nbsp;<a href=\"cardie_gestion_projets.php?tri=INTITULE&amp;sense_tri=asc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				//echo "<th>&nbsp;&Eacute;tat&nbsp;</th>";
				echo "<th>";
				if ($sense_tri =="asc")
				{
					echo "ECL&nbsp;<a href=\"cardie_gestion_projets.php?tri=CP.RNE&amp;sense_tri=desc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "ECL&nbsp;<a href=\"cardie_gestion_projets.php?tri=CP.RNE&amp;sense_tri=asc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				echo "<th nowrap>";
				if ($sense_tri =="asc")
				{
					echo "D&eacute;but&nbsp;<a href=\"cardie_gestion_projets.php?tri=ANNEE&amp;sense_tri=desc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "D&eacute;but&nbsp;<a href=\"cardie_gestion_projets.php?tri=ANNEE&amp;sense_tri=asc&amp;etat=".$etat."\" target=\"body\"  title=\"Trier par intitul&eacute;, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				echo "<th>&nbsp;D&eacute;cision<br />commission&nbsp;</th>";
				echo "<th>&nbsp;Type<br />accompagnement&nbsp;</th>";
				echo "<th>&nbsp;Groupe<br />d&eacute;veloppement&nbsp;</th>";
				echo "<th>&nbsp;Accompagnateur/trice(-s)&nbsp;</th>";
				echo "<th>&nbsp;Visites&nbsp;</th>";
				echo "<th>&nbsp;Liens&nbsp;</th>";
				//echo "<th>&nbsp;Pi&egrave;ces jointes&nbsp;</th>";
				echo "<th>&nbsp;Actions&nbsp;</th>";
			echo "</tr>";
			
			//On récupère les lignes des enregistrement
			while ($ligne = mysql_fetch_object($resultat))
			{
				$id_projet = $ligne->NUM_PROJET;
				$intitule_projet = $ligne->INTITULE;
				$mise_en_route = $ligne->ANNEE;
				$rne = $ligne->RNE;
				$etat = $ligne->ACTIF;
				$decision_commission = $ligne->DECISION_COMMISSION;
				$type_accompagnement = $ligne->TYPE_ACCOMPAGNEMENT;
				$type_groupe_developpement = $ligne->TYPE_GROUPE_DEVELOPPEMENT;

				//On ajoute l'année suivante pour l'affichage si une année a été saisie
				if ($mise_en_route <> "")
				{
					$annee_n1 = $mise_en_route+1;
					$annee_a_afficher = $mise_en_route."-".$annee_n1;
				}
				else
				{
					$annee_a_afficher = "";
				}
				echo "<tr>";
					
					echo "<td align = \"center\">";
						echo "&nbsp;$id_projet&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$intitule_projet&nbsp;";
					echo "</td>";
					/*
					echo "<td align = \"center\">";
						echo "&nbsp;$etat&nbsp;";
					echo "</td>";
					*/
					echo "<td nowrap>";
						affiche_info_bulle($rne,"RESS",0);
						//echo "&nbsp;$rne&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$annee_a_afficher&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$decision_commission&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$type_accompagnement&nbsp;";
					echo "</td>";
					echo "<td>";
						$intitule_type_groupe_developpement = lecture_champ('cardie_type_groupe_developpement','intitule_TGD','id_TGD',$type_groupe_developpement);
						echo "&nbsp;$intitule_type_groupe_developpement&nbsp;";
					echo "</td>";
					echo "<td nowrap>";
						include ('cardie_gestion_affichage_donnees_recup_acc.inc.php');
					echo "</td>";
					echo "<td nowrap>";
						include ('cardie_gestion_affichage_donnees_recup_visites.inc.php');	
					echo "</td>";
					
					echo "<td nowrap>";
						include ('cardie_gestion_affichage_liens_projet.inc.php');	
					echo "</td>";
/*
					echo "<td>";
						echo "&nbsp;";
					echo "</td>";
*/
					echo "<td class = \"fond-actions\" nowrap>";
						echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=info_projet&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter le projet\"></a>";
						if ($niveau_droits == 3)
						{
							if ($etat == "O")
							{
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=modif&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier le projet\"></a>";
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=archiver_projet&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archiver.png\" border = \"0\" ALT = \"archiver\" title=\"Archiver le projet\"></a>";
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=suppression_projet&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer le projet\"></a>";
								echo "<br />&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_accompagnateur&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_ajout_accompagnateur.png\" border = \"0\" ALT = \"ajouter accompagnateur-e\" title=\"Ajouter un-e accompagnateur-e\"></a>";
								if (($type_accompagnement == "in situ" OR $type_accompagnement == "recherche") AND $nbr_accompagnateurs>0 AND $niveau_droits <> 2)
								{
									echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_visite&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."&amp;origine_appel=T\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_ajout_visite.png\" border = \"0\" ALT = \"ajouter visite\" title=\"Ajouter une visite\"></a>";
								}
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_lien&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_projet_ajout_lien.png\" border = \"0\" ALT = \"ajout lien\" title=\"Ajouter un lien\"></a>";
								//echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_piece&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"ajout pi&egrave;ce\" title=\"Ajouter une pi&egrave;ce\"></a>";
							}
							else
							{
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=archiver_projet&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archive.png\" border = \"0\" ALT = \"desarchiver\" title=\"D&eacute;s-archiver le projet\"></a>";
							}
						}
						elseif ($niveau_droits <> 2)
						{
							if (($type_accompagnement == "in situ" OR $type_accompagnement == "recherche") AND $nbr_accompagnateurs>0 AND $niveau_droits <> 2)
							{
								echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_visite&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."&amp;origine_appel=T\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_ajout_visite.png\" border = \"0\" ALT = \"ajouter visite\" title=\"Ajouter une visite\"></a>";
							}
							echo "&nbsp;<a href = \"cardie_gestion_projets.php?action=O&amp;a_faire=ajout_lien&amp;id_projet=".$id_projet."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_projets=".$mes_projets."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_projet_ajout_lien.png\" border = \"0\" ALT = \"ajout lien\" title=\"Ajouter un lien\"></a>";
						}
						echo "&nbsp;";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}
?>
