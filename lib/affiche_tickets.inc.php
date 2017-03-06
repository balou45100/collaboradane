<?php
	/*
	echo "<br />id_societe : $id_societe";
	echo "<br />tri : $tri";
	echo "<br />sense_tri : $sense_tri";
	echo "<br />tri2 : $tri2";
	echo "<br />origine_gestion : $origine_gestion";
	//echo "<br /> : $";
	*/

	// Extraction des enregistrements concern&eacute;s

	if($_SESSION['droit'] == "Super Administrateur" )
	{
		//$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
		$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = '".$origine_tickets."' ORDER BY ID_PB DESC;";
	}
	else
	{
		$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = '".$origine_tickets."' ORDER BY ID_PB DESC;";
		//$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' ORDER BY ID_PB DESC;";
	}
	$results = mysql_query($query);
	
	//echo "<br />$query";
	
	if(!$results)
	{
		echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
		echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
		mysql_close();
		exit;
	}
	//Retourne le nombre de ligne rendu par la requ&egrave;te
	$num_results = mysql_num_rows($results);
	//echo $num_results;

	echo "<h2>Nombre de tickets <strong>en cours</strong>&nbsp;:&nbsp;$num_results</h2>";
	echo "<table>";
		//echo "<caption><b>Nombre de tickets <strong>en cours</strong>&nbsp;:&nbsp;$num_results</b></caption>";
		echo "<tr>";
			echo "<th>";
			/*
			if ($sense_tri =="asc")
			{
				echo "ID&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
			}
			else
			{
				echo "ID&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
			}
			*/
				echo "ID";
			echo "</th>
			<th>ST</th>";
			echo "<th>";
			/*
			if ($sense_tri =="asc")
			{
				*/
				echo "Cr&eacute;&eacute; par";
				//echo "Cr&eacute;&eacute; par&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
				/*
			}
			else
			{
				echo "Cr&eacute;&eacute; par&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
			}
			*/
			echo "</th>
			<th>
				Cr&eacute;&eacute; le
			</th>
			<th>
				Trait&eacute; par
			</th>
			<th>
				Dern. interv.
			</th>";
			echo "<th>
				Sujet
			</th>
			<th>
				Nb mes
			</th>
			<th>";
				echo "Priorit&eacute;</th>";
			echo "<th>";
				echo "Alerte";
			echo "</th>";
			echo "<th>
				Cat
			</th>";
			echo "<th>
				Actions
			</th>
		</tr>";
			//L'utilisateur &agrave; le droit de voir les tickets qu'il a envoy&eacute;s ou ceux dont il est intervenant
			//echo "<br />Je suis un utilisateur";
			//Requ&egrave;te pour afficher les tickets selon le filtre appliqu&eacute;
			if ($sense_tri == "")
			{
				$sense_tri="DESC";
			}
			////////////////////////////////////////
			//Traitement de chaque ligne
			for($i = 0; $i < $num_results; ++$i)
			{
				$res = mysql_fetch_row($results);
				if($res[11] != "R")
				{
					$query_count = "SELECT * FROM probleme WHERE ID_PB_PERE = ".$res[0].";";
					$results_count = mysql_query($query_count);
					if(!$results_count)
					{
						mysql_close();
						exit;
					}

					switch ($res[13])
					{
						case "2":
							$priorite_selection = "Normal";
							$priorite_non_selection_ref_1 = "1";
							$priorite_non_selection_ref_2 = "3";
							$priorite_non_selection_nom_1 = "Haute";
							$priorite_non_selection_nom_2 = "Basse";
							switch ($res[11])
							{
								case "M":
									$fond = "#B3CEEF";
								break;

								case "N":
									$fond = "#A4EFCA";
								break;

								case "A":
									$fond = "#FF9FA3";
								break;
							}
						break;

						case "1":
							$priorite_selection = "Haute";
							$priorite_non_selection_ref_1 = "2";
							$priorite_non_selection_ref_2 = "3";
							$priorite_non_selection_nom_1 = "Normal";
							$priorite_non_selection_nom_2 = "Basse";
							$fond = "#ff0000";
						break;

						case "3":
							$priorite_selection = "Basse";
							$priorite_non_selection_ref_1 = "1";
							$priorite_non_selection_ref_2 = "2";
							$priorite_non_selection_nom_1 = "Haute";
							$priorite_non_selection_nom_2 = "Normal";
							switch ($res[11])
							{
								case "M":
									$fond = "#B3CEEF";
								break;

								case "N":
									$fond = "#A4EFCA";
								break;

								case "A":
									$fond = "#FF9FA3";
								break;
							}
						break;

						default:
							$res[13] = "2";
							$priorite_selection = "Normal";
							$priorite_non_selection_ref_1 = "1";
							$priorite_non_selection_ref_2 = "3";
							$priorite_non_selection_nom_1 = "Haute";
							$priorite_non_selection_nom_2 = "Basse";
							switch ($res[11])
							{
								case "M":
									$fond = "#B3CEEF";
								break;

								case "N":
									$fond = "#A4EFCA";
								break;

								case "A":
									$fond = "#FF9FA3";
								break;
							}
						break;
					}

					switch ($res[14])
					{
						case "N":
							$couleur_fond = "#ffffff";
						break;

						case "C":
							$couleur_fond = "#00cc33";
						break;

						case "T":
							$couleur_fond = "#ff0000";
						break;

						case "A":
							$couleur_fond = "#ffff66";
						break;

						case "F":
							$couleur_fond = "#FF9FA3";
						break;

					}

					//Retourne le nombre de ligne rendu par la requ&egrave;te
					$num_results_count = mysql_num_rows($results_count);
					if ($res[25] == 1) //le ticket est verrouill&eacute;
					{
						$fond = "#FFFFFF"; //le fond de la priorit&eacute; est mis &agrave; blanc
						$couleur_fond = "#FFFFFF"; //Le fon du statut est mis &agrave; blanc
						echo "<TR class = \"verrou\">";
					}
					else
					{
						echo "<TR class = \"".statut($res[11])."\">";
					}

					//echo "<TR class = \"".statut($res[11])."\">";
						echo "<td align=\"center\">";
							echo $res[0];
						echo "</td>";
						echo "<td BGCOLOR = $couleur_fond align=\"center\">";
							echo " ";
						echo "</td>";
						echo "<td>";
							echo $res[3];
						echo "</td>";
						echo "<td>";
							//Transformation de la date de cr&eacute;ation extraite pour l'affichage
							$date_de_creation_a_afficher = strtotime($res['27']);
							$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
						    //echo $res[7];
							echo $date_de_creation_a_afficher; //cr&eacute;&eacute; le
						echo "</td>";
						echo "<td>";
							echo $res[15]; //trait&eacute; par
						echo "</td>";
						echo "<td align=\"center\">";
							If ($res[24] <> "") //derni&egrave;re intervention
							{
								$date = strtotime($res[24]);
								$date_derniere_intervention_a_afficher = date('d/m/Y',$date);
								echo $date_derniere_intervention_a_afficher;
							}
							else
							{
								echo "&nbsp;";
							}
							echo "</td>";
							echo "<td>";
								echo $res[5];
							echo "</td>";

							echo "<td align=\"center\">";
								echo $num_results_count;
							echo "</td>";
							echo "<td BGCOLOR = $fond align=\"center\">";
								echo $priorite_selection;
							echo "</td>";
								$id_util = $_SESSION['id_util'];
								verif_alerte($res[0],$id_util,$date_aujourdhui,"gestion");
							echo "<td align=\"center\">";
								verif_categorie($res[0]);
							echo "</td>";
								if ($res[25] == 1)
								{
									echo "<td>";
									if ($res[26] == $_SESSION['nom'])
									{
										echo "<a href = \"ecl_consult_fiche.php?deverrouiller=Oui&amp;idpb=".$res[0]."&amp;affiche_tickets=O&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" title=\"verrouill&eacute; par $res[26] ; Cliquer pour d&eacute;verrouiller ce ticket\"></a>";
									}
									else
									{
										echo "<a href = \"ecl_consult_fiche.php?deverrouiller=Oui&amp;idpb=".$res[0]."&amp;affiche_tickets=O&amp;affiche_personnes_ressources=N&amp;affiche_formations=N&amp;affiche_tickets_archives=N&amp;affiche_tbi=N\" target=\"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" title=\"verrouill&eacute; par $res[26] ; Cliquer pour d&eacute;verrouiller ce ticket\"></a>";
									}
									echo "<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border = \"0\"></a>";
								}
								else
								{
									echo "<td class = \"fond-actions\">";
										echo "<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border=\"0\"></a>";
										echo "<a href = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\" border=\"0\"></a>";
										//echo "&nbsp;<a href = \"affiche_categories.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les cat&eacute;gories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\" width=\"25px\" height=\"32px\"></a>";
										if (($_SESSION['nom'] == $res[3]) OR ($_SESSION['droit'] == "Super Administrateur"))
										{
											if($res[11] != "A")
											{
												//echo "<a href = \"archiver_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\" border=\"0\"></a>";	
												echo "<a href = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"22px\" border=\"0\"></a>";
											}
											//echo "<a href = \"delete_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" border=\"0\" height=\"24px\" width=\"22px\"></a>";
										}
								}
							echo "</td>";
						echo "</tr>";
				}
			}
		echo "</table>";
		//Fermeture de la connexion &agrave; la BDD
		mysql_close();
?>
