<?php
	
	//echo "<h2>Affichage par accompagnateurs/trices</h2>";
	
	/*
	echo "<br />niveau_droits : $niveau_droits";
	echo "<br />util : $id_util";
	echo "<br />decision_commission : $decision_commission";
	*/
	
	//Composition de la requête de base
	$requete_base = "SELECT * FROM 
		personnes_ressources_tice AS PRT, 
		fonctions_des_personnes_ressources AS FPR 
	WHERE PRT.id_pers_ress = FPR.id_pers_ress
		AND FPR.fonction = 'accompagnateur/trice CARDIE'";

	//echo "<br />requete_base : $requete_base";
	//On ajoute l'année scolaire dans le filtre
	$requete_compl_annee = " AND annee = '".$annee_a_filtrer."'";
	/*
	echo "<br />gestion_accompagnateurs";
	echo "<br />accompagnateur_a_filtrer : $accompagnateur_a_filtrer";
	*/
	//On ajoute l'accompaganteur dans le filtre
	if ($accompagnateur_a_filtrer == "T")
	{
		$requete_compl_acc = " ";
	}
	else
	{
		$requete_compl_acc = " AND PRT.id_pers_ress = '".$accompagnateur_a_filtrer."'";
	}

	//On filtre les enregistrements en fonction de la décision de la commission choisie
	
/*	switch ($decision_commission)
	{
		case "T" : //Tous les projets
			echo "<h2>Tous les projets</h2>";
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
*/
	//On rajoute le filtre "etat"
	//$etat = $_GET['etat'];
	/*
	if (!ISSET($etat))
	{
		$etat = "%";
	}
	*/
	//echo "<br />etat : $etat";
	
/*
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
*/	
	$requete_compl_tri = " ORDER BY $tri $sense_tri";
	$requete_complete = $requete_base.$requete_compl_annee.$requete_compl_acc.$requete_compl_tri;
	
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
		echo "<h2>Nombre d'accompagnateurs/trices&nbsp;:&nbsp;$num_results</h2>";
		//On affiche l'entête du tableau
		echo "<table>";
			echo "<tr>";
/*
				echo "<th nowrap>";
				if ($sense_tri =="asc")
				{
					echo "ID&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=PRT.id_pers_ress&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'accompagnateur, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "ID&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=PRT.id_pers_ress&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'accompagnateur, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
*/
				echo "<th>";
				if ($sense_tri =="asc")
				{
					echo "NOM&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=nom&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par Nom, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "NOM&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=nom&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par Nom, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				//echo "<th>&nbsp;&Eacute;tat&nbsp;</th>";
				echo "<th>";
					echo "PR&Eacute;NOM";
				echo "</th>";
				echo "<th nowrap>";
				if ($sense_tri =="asc")
				{
					echo "ECL&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=PRT.codetab&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par RNE, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
				}
				else
				{
					echo "ECL&nbsp;<a href=\"cardie_gestion_accompagnateurs.php?tri=PRT.codetab&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par RNE, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
				}
				echo "</th>";
				echo "<th>&nbsp;Projet(s)&nbsp;</th>";
				echo "<th>&nbsp;Visite(s)&nbsp;</th>";
				echo "<th>&nbsp;Actions&nbsp;</th>";
			echo "</tr>";
			
			//On récupère les lignes des enregistrement
			while ($ligne = mysql_fetch_object($resultat))
			{
				$id_pers_ress = $ligne->id_pers_ress;
				$nom = $ligne->nom;
				$prenom = $ligne->prenom;
				$annee = $ligne->annee;
				$rne = $ligne->codetab;
				
				echo "<tr>";
/*
					echo "<td align = \"center\">";
						echo "&nbsp;$id_pers_ress&nbsp;";
					echo "</td>";
*/
					echo "<td>";
						echo "&nbsp;$nom&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$prenom&nbsp;";
					echo "</td>";
					echo "<td nowrap>";
						echo "&nbsp;";
						affiche_info_bulle($rne,"RESS",0);
						echo "&nbsp;";
					echo "</td>";

					echo "<td align = \"center\">";
						$nombre_projets = compte_projets($id_pers_ress,"T");
						if ($nombre_projets >0)
						{
							echo "<b>";
							bulle_d_aide($nombre_projets,"total des projets suivis");
							echo "</b>&nbsp;";
							$nombre_projets_suivis_in_situ = compte_projets($id_pers_ress,"in situ");
							if ($nombre_projets_suivis_in_situ >0)
							{
								bulle_d_aide($nombre_projets_suivis_in_situ,"projets suivi in situ");
								echo "&nbsp;";
							}
							$nombre_projets_suivis_a_distance = compte_projets($id_pers_ress,"a distance");
							if ($nombre_projets_suivis_a_distance >0)
							{
								bulle_d_aide($nombre_projets_suivis_a_distance,"projets suivi &agrave; distance");
								echo "&nbsp;";
							}
							$nombre_projets_suivis_par_la_recherche = compte_projets($id_pers_ress,"recherche");
							if ($nombre_projets_suivis_par_la_recherche >0)
							{
								bulle_d_aide($nombre_projets_suivis_par_la_recherche,"projets suivi par la recherche");
								echo "&nbsp;";
							}
							$nombre_projets_suivis_par_groupe_de_developpement = compte_projets($id_pers_ress,"groupe developpement");
							if ($nombre_projets_suivis_par_groupe_de_developpement >0)
							{
								bulle_d_aide($nombre_projets_suivis_par_groupe_de_developpement,"projets suivi par groupe de d&eacute;veloppement");
								echo "&nbsp;";
							}
							$nombre_projets_suivis_de_facon_partenarial = compte_projets($id_pers_ress,"partenarial");
							if ($nombre_projets_suivis_de_facon_partenarial >0)
							{
								bulle_d_aide($nombre_projets_suivis_de_facon_partenarial,"projets suivi de fa&ccedil;on partenarial");
							}
							//echo ")";
						}
					echo "</td>";
					echo "<td align = \"center\">";
						$nombre_visites = compte_visites($id_pers_ress);
						if ($nombre_visites >0)
						{
							echo "&nbsp;$nombre_visites&nbsp;";
						}
					echo "</td>";
/*
					echo "<td nowrap>";
						include ('cardie_gestion_affichage_donnees_recup_acc.inc.php');
					echo "</td>";
					echo "<td nowrap>";
						include ('cardie_gestion_affichage_donnees_recup_visites.inc.php');	
					echo "</td>";
*/
					echo "<td class = \"fond-actions\" nowrap>";
						//echo "&nbsp;<a href = \"cardie_gestion_accompagnateurs.php?action=O&amp;a_faire=info_accompagnateur&amp;id_pers_ress=".$id_pers_ress."&amp;mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter la fiche de l'accompagnateur/trice\"></a>";
						//echo "&nbsp;<a href = \"cardie_gestion_accompagnateurs.php?action=O&amp;a_faire=modif&amp;id_pers_ress=".$id_pers_ress."&amp;mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier l'accompagnateur/trice\"></a>";
						//echo "&nbsp;<a href = \"cardie_gestion_accompagnateurs.php?action=O&amp;a_faire=suppression_accompagnateur&amp;id_pers_ress=".$id_pers_ress."&amp;mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer l'accompagnateur/trice\"></a>";
						//echo "&nbsp;";
					echo "</td>";
				echo "</tr>";
			} //Fin while
		echo "</table>";
	}
?>
