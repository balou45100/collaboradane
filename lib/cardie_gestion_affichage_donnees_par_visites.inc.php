<?php
	//echo "<h2>Affichage par visites</h2>";
	//Composition de la requête pour afficher les visites de la personnes connectée ou de toutes les visites pour le gestionnaires
	/*
	echo "<br />script cardie_gestion_affichage_donnees_par_visites.inc.php";
	echo "<br />niveau_droits : $niveau_droits";
	echo "<br />util : $id_util";
	*/
	//Initialisation des variables de tri 
	$tri = $_GET['tri'];
	
	if (!ISSET($tri))
	{
		$tri = $_POST['tri'];
	}
	
	if (!ISSET($tri))
	{
		$tri = "CV.DATE_VISITE";
	}

	$sense_tri = $_GET['sense_tri'];
	if (!ISSET($sense_tri))
	{
		$sense_tri = $_POST['sense_tri'];
	}
	if (!ISSET($sense_tri))
	{
		$sense_tri = "asc";
	}
	/*
	echo "<br />gestion_visites";
	echo "<br />tri : $tri";
	echo "<br />sense_tri : $sense_tri";
	*/
	//Composition de la requête en fonction du profil de la personne connectée
	if ($niveau_droits == 3) //Il s'agit des droits de gestion au niveau de la CARDIE
	{
		$requete_base = "SELECT * FROM 
			cardie_visite AS CV, 
			cardie_projet AS CP, 
			etablissements AS ETAB 
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.RNE = ETAB.RNE
			AND CP.ACTIF = 'O'";
		
		//echo "<br />requete1 : $requete";
	}
	elseif ($niveau_droits == 1) //il s'agit des droits d'accompagnateur
	{
		//Il faut récupérer l'identifiant de la table persoinnes_ressources_tice de l'accompagnateur connecté
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
			cardie_visite AS CV, 
			cardie_projet AS CP, 
			etablissements AS ETAB,
			cardie_projet_accompagnement AS CPA,
			personnes_ressources_tice AS PRT
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.RNE = ETAB.RNE
			AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CP.ACTIF = 'O'
			AND CPA.FK_ID_PERS_RESS = PRT.ID_PERS_RESS
			AND CPA.FK_ID_PERS_RESS = $id_pers_ress";
		
		//echo "<br />requete2 : $requete";
	}
	elseif ($niveau_droits == 2) //Il s'agit du gestionnaire DAFOP
	{
		$requete_base = "SELECT * FROM 
			cardie_visite AS CV, 
			cardie_projet AS CP, 
			etablissements AS ETAB 
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.RNE = ETAB.RNE
			AND CP.ACTIF = 'O'
			AND (CV.ETAT > 1)";
			//AND (CV.ETAT = '2' OR CV.ETAT = '3' OR CV.ETAT = '4' OR CV.ETAT = '5' OR CV.ETAT = '6')";
	}
////////////////////////////////////////////////////////////////////////////////////////
	//On regarde si l'appel vient de l'entête
	if ($origine_appel == "entete_visites")
	{
		$_SESSION['etat_avancement'] = $etat_avancement;
	}
	else
	{
		$etat_avancement = $_SESSION['etat_avancement'];
	}
	//On filtre les enregistrements en fonction de la décision de la commission choisie
	
	//echo "<br />etat_avancement : $etat_avancement";
	
	switch ($etat_avancement)
	{
		case "T" : //Toutes les visites
			echo "<h2>Toutes les visites</h2>";
			$requete_compl_etat_avancement = "";
		break;

		case "STADE0" : //Les visites en création
			echo "<h2>Les visites en mode cr&eacute;ation</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '0'";
		break;

		case "STADE1" : //Toutes les visites transmises aux gestionnaires de la CARDIE
			echo "<h2>Les visites transmises aux gestionnaires de la CARDIE</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '1'";
		break;

		case "STADE2" : //Toutes les visites transmises à la DAFOP pour l'établissement de l'OM
			echo "<h2>Les visites transmises &agrave; la DAFOP pour &eacute;tablissement de l'ordre de mission</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '2'";
		break;

		case "STADE3" : //Toutes les visites dont les OM ont été envoyés
			echo "<h2>Les visites dont les ordres de mission ont &eacute;t&eacute; envoy&eacute;s aux accompagnateur/trice-s</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '3'";
		break;

		case "STADE4" : //Toutes les visites effectuées
			echo "<h2>Les visites effectu&eacute;es</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '4'";
		break;

		case "STADE5" : //Toutes les visites dont les EF ont été envoyés
			echo "<h2>Les visites dont les &eacute;tats de frais ont &eacute;t&eacute; envoy&eacute;s</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '5'";
		break;

		case "STADE6" : //Toutes les visites dont les EF ont été traités
			echo "<h2>Les visites dont les &eacute;tats de frais ont &eacute;t&eacute; trait&eacute;s</h2>";
			$requete_compl_etat_avancement = " AND CV.ETAT = '6'";
		break;
	} //Fin switch $etat_avancement

	$requete_compl_tri = " ORDER BY $tri $sense_tri";
	$requete_complete = $requete_base.$requete_compl_etat_avancement.$requete_compl_tri;
	
	//echo "<br />$requete_complete";

////////////////////////////////////////////////////////////////////////////////////
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
		echo "<h2>Nombre de visites : $num_results</h2>";
		//On affiche l'entête du tableau
		echo "<table>";
			echo "<tr>";
				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "ID&nbsp;<a href=\"cardie_gestion_visites.php?tri=ID_VISITE&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'ordre, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "ID&nbsp;<a href=\"cardie_gestion_visites.php?tri=ID_VISITE&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'ordre, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
				echo "</th>";
				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "Date&nbsp;<a href=\"cardie_gestion_visites.php?tri=DATE_VISITE&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'ordre, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "Date&nbsp;<a href=\"cardie_gestion_visites.php?tri=DATE_VISITE&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'ordre, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
				echo "</th>";
				echo "<th>&nbsp;Horaire&nbsp;</th>";
				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "&Eacute;tat&nbsp;visite&nbsp;<a href=\"cardie_gestion_visites.php?tri=ETAT&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'ordre, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "&Eacute;tat&nbsp;visite&nbsp;<a href=\"cardie_gestion_visites.php?tri=ETAT&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'ordre, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
				echo "</th>";

/*
				echo "<th>";
					echo "&Eacute;tat de frais&nbsp;";
				echo "</th>";
*/
				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "PROJ&nbsp;<a href=\"cardie_gestion_visites.php?tri=FK_NUM_PROJET&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'ordre, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "PROJ&nbsp;<a href=\"cardie_gestion_visites.php?tri=FK_NUM_PROJET&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'ordre, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
				echo "</th>";
				echo "<th>&nbsp;Intitul&eacute; projet&nbsp;</th>";

				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "ECL&nbsp;<a href=\"cardie_gestion_visites.php?tri=CP.RNE&amp;sense_tri=desc\" target=\"body\"  title=\"Trier par No d'ordre, ordre decroissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_desc.png\" border = \"0\"></b></a>";
					}
					else
					{
						echo "ECL&nbsp;<a href=\"cardie_gestion_visites.php?tri=CP.RNE&amp;sense_tri=asc\" target=\"body\"  title=\"Trier par No d'ordre, ordre croissant\"><b><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src=\"$chemin_theme_images/tri_asc.png\" border = \"0\"></b></a>";
					}
				echo "</th>";
				echo "<th>&nbsp;Accompagnateur/trice-s</th>";
				echo "<th>&nbsp;Bilan</th>";
				echo "<th>&nbsp;Actions&nbsp;</th>";
			echo "</tr>";
			//On récupère les lignes des enregistrement
			while ($ligne = mysql_fetch_object($resultat))
			{
				$id_visite = $ligne->ID_VISITE;
				$date_visite = $ligne->DATE_VISITE;
				$horaire_visite = $ligne->HORAIRE_VISITE;
				$rne = $ligne->RNE;
				$etat = $ligne->ETAT;
				$intitule_projet = $ligne->INTITULE;
				$id_projet = $ligne->FK_NUM_PROJET;
				
				echo "<tr>";
					echo "<td align = \"center\">";
						echo "&nbsp;$id_visite&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$date_visite&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$horaire_visite&nbsp;";
					echo "</td>";
					echo "<td align = \"center\">";
						//On récupère tous les états et on affiche en surbrillance l'état de la visite
						$requete_visite_etat = "SELECT * FROM cardie_visite_etats";
						$resultat_visite_etat = mysql_query($requete_visite_etat);
						$nb_etats = mysql_num_rows($resultat_visite_etat);
						$compteur = 0;
						while ($ligne_etat = mysql_fetch_object($resultat_visite_etat))
						{
							$compteur++;
							$code = $ligne_etat->CODE;
							$intitule_etat = $ligne_etat->INTITULE;

							if ($compteur < $nb_etats)
							{
								if ($code == $etat)
								{
									echo "<span title=\"$intitule_etat\"><strong>".$code."&nbsp;</strong>";
								}
								else
								{
									echo "<span title=\"$intitule_etat\">".$code."&nbsp;";
								}
							}
							else
							{
								if ($code == $etat)
								{
									echo "<span title=\"$intitule_etat\"><strong>".$code."</strong>";
								}
								else
								{
									echo "<span title=\"$intitule_etat\">".$code;
								}
							}
							
						}
					echo "</td>";
/*
					echo "<td align = \"center\">";
						//On récupère tous les états des états de frais et on affiche en surbrillance l'état de la visite
						$requete_visite_etat_ef = "SELECT * FROM cardie_visite_etats_ef";
						$resultat_visite_etat_ef = mysql_query($requete_visite_etat_ef);
						$nb_etats_ef = mysql_num_rows($resultat_visite_etat_ef);
						$compteur_ef = 0;
						while ($ligne_etat_ef = mysql_fetch_object($resultat_visite_etat_ef))
						{
							$compteur_ef++;
							$code = $ligne_etat_ef->CODE;
							$intitule_etat = $ligne_etat_ef->INTITULE;

							if ($compteur_ef < $nb_etats_ef)
							{
								if ($code == $etat)
								{
									echo "<span title=\"$intitule_etat\"><strong>".$code."&nbsp;</strong>";
								}
								else
								{
									echo "<span title=\"$intitule_etat\">".$code."&nbsp;";
								}
							}
							else
							{
								if ($code == $etat)
								{
									echo "<span title=\"$intitule_etat\"><strong>".$code."</strong>";
								}
								else
								{
									echo "<span title=\"$intitule_etat\">".$code;
								}
							}
							
						}
					echo "</td>";
*/
					echo "<td align = \"center\">";
						echo "&nbsp;$id_projet&nbsp;";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;$intitule_projet&nbsp;";
					echo "</td>";
					echo "<td nowrap>";
						affiche_info_bulle($rne,"RESS",0);
					echo "</td>";

					echo "<td nowrap>";
						include ('cardie_gestion_affichage_donnees_recup_acc.inc.php');	
					echo "</td>";
					echo "<td nowrap>";
						//On vérifie s'il existe un bilan, si oui on affiche l'icone avec la croix pour la suppression, si non on affiche l'icône d'ajout 
						$requete_verif_bilan = "SELECT * FROM documents WHERE id_ticket = '".$id_visite."' AND module = 'CVI'";
						
						//echo $requete_verif_bilan;
						
						$resultat_requete_verif_bilan = mysql_query($requete_verif_bilan);
						$verif_bilan = mysql_num_rows($resultat_requete_verif_bilan);
						
						if ($verif_bilan >0)
						{
							//On récupère le nom du fichier
							$ligne = mysql_fetch_object($resultat_requete_verif_bilan);
							$nom_fichier = $ligne->nom_fichier;
							$nom_doc = $ligne->nom_doc;
							$id_doc = $ligne->id_doc;
							$lien = $dossier.$nom_fichier;
							/*
							echo "<br />lien : $lien";
							echo "<br />nom_fichier : $nom_fichier";
							*/
							//On récupère la bonne icône en fonction du type de fichier
							$image = image_fichier_joint($nom_fichier); //on récupère le type de l'image à afficher
							$image = $chemin_theme_images."/".$image;
							
							//echo "<br />image : $image";
							
							echo "&nbsp;&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$nom_doc\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\"src = \"$image\" ALT = \"$nom_doc\" title=\"$nom_doc\" border = \"0\"></a>";
							//On vérifie si c'est l'accompagnateur de la visite ou un gestionnaire est connecté pour donner le droit de dépôt et de suppression
							//if ($niveau_droits == 3 OR $niveau_droits == 1)
							if ($niveau_droits == 3)
							{
								echo "<a href = \"delete_document.php?tri=$tri&amp;id_doc=".$id_doc."&amp;nom_fichier=".$nom_fichier."&amp;retour=cardie_gestion_visites\" TARGET = \"body\"><img src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" title=\"Supprimer ce fichier\" border = \"0\"></a>";
							}
						}
						else
						{
						}
					echo "</td>";
					echo "<td class = \"fond-actions\" nowrap>";
						//On fait la différence entre l'accompagnateur et les gestionnaires
						if ($niveau_droits == 3) //Les gestionnaires CARDIE
						{
							switch ($etat)
							{
								case "0" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"avancer\" title=\"Avancer vers gestionnaires pour OM\"></a>";
									//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;message_a_envoyer=O\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png\" border = \"0\" ALT = \"avancer avec message\" title=\"Avancer vers gestionnaires pour OM et joindre un message\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=modifier_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la visite\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=supprimer_visite&amp;id_visite=".$id_visite."&amp;contexte_appelant=visites&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer la visite\"></a>";
								break;

								case "1" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Revenir &agrave; l'&eacute;tat de cr&eacute;ation\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"Transmettre DAFOP pour OM\" title=\"Transmettre &agrave; la DAFOP pour &eacute;tablissement de l'OM\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=modifier_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la visite\"></a>";
								break;

								case "2" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Revenir &agrave; l'&eacute;tat 1\"></a>";
								break;

								case "3" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"Visite effectu&eacute;e\" title=\"Marquer la visite effectu&eacute;e\"></a>";
								break;

								case "4" :
									if ($verif_bilan == 0)
									{
										echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "5" :
									if ($verif_bilan == 0)
									{
										echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "6" :
									if ($verif_bilan == 0)
									{
										echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "7" :
									if ($verif_bilan == 0)
									{
										echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;
							}
						}
						elseif ($niveau_droits == 1) //Les accompagnateurs
						{
							
							switch ($etat)
							{
								
								case "0" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"avancer\" title=\"Avancer vers gestionnaires pour OM\"></a>";
									//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;message_a_envoyer=O\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png\" border = \"0\" ALT = \"avancer avec message\" title=\"Avancer vers gestionnaires pour OM et joindre un message\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=modifier_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la visite\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=supprimer_visite&amp;id_visite=".$id_visite."&amp;contexte_appelant=visites&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer la visite\"></a>";
								break;

								case "1" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Revenir &agrave; l'&eacute;tat de cr&eacute;ation\"></a>";
								break;

								case "3" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"Visite effectu&eacute;e\" title=\"Marquer la visite effectu&eacute;e\"></a>";
								break;


								case "4" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"EF envoy&eacute;\" title=\"L'&eacute;tat de frais est envoy&eacute;e\"></a>";
									if ($verif_bilan == 0)
									{
										//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "5" :
									if ($verif_bilan == 0)
									{
										//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "6" :
									if ($verif_bilan == 0)
									{
										//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;

								case "7" :
									if ($verif_bilan == 0)
									{
										//echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=ajout_bilan_visite&amp;id_visite=".$id_visite."&amp;date_visite=".$date_visite."&amp;horaire_visite=".$horaire_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" border = \"0\" ALT = \"Ajout bilan\" title=\"Ajouter un bilan de visite\"></a>";
									}
								break;
							}
						}
						elseif ($niveau_droits == 2) //Gestionnaire DAFOP
						{
							switch ($etat)
							{
								case "2" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Retourner aux gestionnaires de la CARDIE\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"avancer\" title=\"Indiquer OM envoy&eacute;(s)\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=modifier_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la visite\"></a>";
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=renvoyer_message2&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_renvoi_message.png\" border = \"0\" ALT = \"renvoi message\" title=\"Renvoyer le message\"></a>";
								break;

								case "3" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Revenir &agrave; l'&eacute;tat 2\"></a>";
								break;

								case "4" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"EF envoy&eacute;\" title=\"L'&eacute;tat de frais est envoy&eacute;e\"></a>";
								break;

								case "5" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=avancer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_avancer.png\" border = \"0\" ALT = \"EF trait&eacute;\" title=\"Accuser r&eacute;ception de la fiche de r&eacute;mun&eacute;ration\"></a>";
								break;

								case "6" :
									echo "&nbsp;<a href = \"cardie_gestion_visites.php?action=O&amp;a_faire=reculer_visite&amp;id_visite=".$id_visite."&amp;etat_visite=".$etat."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_reculer.png\" border = \"0\" ALT = \"avancer\" title=\"Revenir &agrave; l'&eacute;tat 5\"></a>";
								break;
							}
						}
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}
?>
