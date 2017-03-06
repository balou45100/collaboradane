<?php
	echo "<h2>Modification du projet $id_projet</h2>";
	
	//On filtre le projet de la table cardie_projet
	
	$requete_projet = "SELECT * FROM cardie_projet AS CP, etablissements AS ETAB
		WHERE CP.RNE = ETAB.RNE
			AND CP.NUM_PROJET = '".$id_projet."';";
			
	//echo "<br />$requete_projet";
	
	$resultat_requete = mysql_query($requete_projet);
	$num_rows = mysql_num_rows($resultat_requete);
	if (mysql_num_rows($resultat_requete))
	{
		$ligne=mysql_fetch_object($resultat_requete);
		$rne=$ligne->RNE;
		$type_etab = $ligne->TYPE;
		$pubpri = $ligne->PUBPRI;
		$nom_etab = $ligne->NOM;
		$adresse_etab = $ligne->ADRESSE;
		$ville_etab = $ligne->VILLE;
		$cp_etab = $ligne->CODE_POSTAL;
		$id_projet=$ligne->NUM_PROJET;
		$annee_projet=$ligne->ANNEE;
		$intitule_projet=$ligne->INTITULE;
		$description = $ligne->DESCRIPTION;
		$objectifs = $ligne->OBJECTIFS;
		$indicateurs = $ligne->INDICATEURS;
		$initiateur = $ligne->INITIATEUR;
		$modes_action = $ligne->MODES_ACTION;
		$phases_du_projet = $ligne->PHASES_DU_PROJET;
		$changements = $ligne->CHANGEMENTS;
		$resume = $ligne->RESUME;
		$mots_clef = $ligne->MOTS_CLEF;
		$rmq_cardie_A2 = $ligne->RMQ_CARDIE_A2;
		$rmq_cardie_A1 = $ligne->RMQ_CARDIE_A1;
		$decision_commission=$ligne->DECISION_COMMISSION;
		$reponse_ppe = $ligne->REPONSE_PPE;
		$type_accompagnement = $ligne->TYPE_ACCOMPAGNEMENT;
		$nbr_eleves = $ligne->NBR_ELEVES;
		$nbr_enseignants = $ligne->NBR_ENSEIGNANTS;
		$propose_dans_ppe = $ligne->PROPOSE_DANS_PPE;
		$type_groupe_developpement = $ligne->TYPE_GROUPE_DEVELOPPEMENT;
		
		//echo "type_groupe_developpement : $type_groupe_developpement";
		
		//On ajoute l'année suivante pour l'affichage
		if ($annee_projet <> "")
		{
			$annee_n1 = $annee_projet+1;
			$annee_a_afficher = $annee_projet."-".$annee_n1;
		}
		else
		{
			$annee_a_afficher = "";
		}
		//echo "<br />RNE : $rne";
		
		//Partie ECL
		echo "<table width=\"95%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">RNE/UAI&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$rne</td>";
				echo "<td class = \"etiquette\">STRUCTURE&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$type_etab&nbsp;$pubpri&nbsp$nom_etab&nbsp;$ville_etab</td>";
			echo "</tr>";
		echo "</table>";
		
		//Partie projet
		echo "<form action=\"cardie_gestion_projets.php\" method=\"post\">";

			echo "<table width=\"95%\">";
				echo "<caption></caption>";
				echo "<tr>";
					echo "<td class = \"etiquette\"  width = \"15%\">INTITULE&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\"><input type=\"text\" VALUE = \"$intitule_projet\" size = \"75\" name=\"intitule_projet\" /></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td class = \"etiquette\">ANN&Eacute;E D&Eacute;BUT&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"annee\">";
							echo "<option selected value=\"$annee_projet\">$annee_a_afficher</option>";
							for($annee = $annee_en_cours-3; $annee < $annee_en_cours+2; $annee++ )
							{
								$annee_n1 = $annee+1;
								$annee_a_afficher = $annee."-".$annee_n1;
								if ($annee <> $annee_projet)
								{
									echo "<option value=\"$annee\">$annee_a_afficher</option>";
								}
							}
						echo "</select>";
					echo "</td>";

					echo "<td class = \"etiquette\">D&Eacute;CISION COMMISSION&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"decision_commission\">";
							echo "<option selected value=\"$decision_commission\">$decision_commission</option>";
							if ($decision_commission <> "")
							{
								echo "<option value=\"\">aucune</option>";
							}
							if ($decision_commission <> "autonome")
							{
								echo "<option value=\"autonome\">autonome</option>";
							}
							if ($decision_commission <> "poursuite")
							{
								echo "<option value=\"poursuite\">poursuite</option>";
							}
							if ($decision_commission <> "retenu")
							{
								echo "<option value=\"retenu\">retenu</option>";
							}
						echo "</select>";
					echo "</td>";

					echo "<td class = \"etiquette\">TYPE ACCOMPAGNEMENT&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"type_accompagnement\">";
							echo "<option selected value=\"$type_accompagnement\">$type_accompagnement</option>";
							if ($type_accompagnement <> "")
							{
								echo "<option value=\"\">pas encore d&eacute;fini</option>";
							}
							if ($type_accompagnement <> "in situ")
							{
								echo "<option value=\"in situ\">in situ</option>";
							}
							if ($type_accompagnement <> "a distance")
							{
								echo "<option value=\"a distance\">a distance</option>";
							}
							if ($type_accompagnement <> "recherche")
							{
								echo "<option value=\"recherche\">par la recherche</option>";
							}
							if ($type_accompagnement <> "groupe developpement")
							{
								echo "<option value=\"groupe developpement\">par groupe de d&eacute;veloppement</option>";
							}
							if ($type_accompagnement <> "experitheque")
							{
								echo "<option value=\"experitheque\">dans exp&eacute;rith&egrave;que</option>";
							}
							if ($type_accompagnement <> "partenarial")
							{
								echo "<option value=\"partenarial\">partenarial</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">GROUPE DE D&Eacute;VELOPPEMENT (si applicable)&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
					
						//on récupère les valeurs dans la table cardie_type_groupe_developpement
						
						$res=mysql_query ("SELECT * FROM cardie_type_groupe_developpement WHERE actif = 'O' ORDER BY intitule_TGD");
						$nbr = mysql_num_rows($res);
						
						if(!$res)
						{
							echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
							mysql_close();
							exit;
						}

						echo "<select size=\"1\" name=\"type_groupe_developpement\">";
							echo "<option value=\"null\">aucun</option>";
							while ($ligne = mysql_fetch_object($res))
							{
								$id_TGD = $ligne->id_TGD;
								$intitule_TGD = $ligne->intitule_TGD;
								
								test_option_select_new ($id_TGD,$type_groupe_developpement,$intitule_TGD);
								//echo "<option value=\"$id_TGD\">$intitule_TGD</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\"  width = \"15%\">INTITIATEUR(S)&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\"><input type=\"text\" VALUE = \"$initiateur\" size = \"75\" name=\"initiateur\" /></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td class = \"etiquette\">RAISONS / CONTEXTE / CONSTATS&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"description\" rows=\"6\" cols=\"75\">$description</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'description' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">RESUM&Eacute;&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"resume\" rows=\"3\" cols=\"75\">$resume</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'resume' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">OBJECTIFS&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"objectifs\" rows=\"3\" cols=\"75\">$objectifs</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'objectifs' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">INDICATEURS&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"indicateurs\" rows=\"3\" cols=\"75\">$indicateurs</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'indicateurs' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">MODES D'ACTION&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"modes_action\" rows=\"3\" cols=\"75\">$modes_action</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'modes_action' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">CHANGEMENTS&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"changements\" rows=\"3\" cols=\"75\">$changements</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'changements' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">PHASES DU PROJET&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"phases_du_projet\" rows=\"3\" cols=\"75\">$phases_du_projet</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'phases_du_projet' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">MOTS CLEF&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"mots_clef\" rows=\"3\" cols=\"75\">$mots_clef</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'mots_clef' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">NOMBRE D'&Eacute;L&Egrave;VES&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"nbr_eleves\" rows=\"3\" cols=\"75\">$nbr_eleves</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'nbr_eleves' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">NOMBRE D'ENSEIGNANTS&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"nbr_enseignants\" rows=\"3\" cols=\"75\">$nbr_enseignants</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'nbr_enseignants' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">PROPOS&Eacute; DANS PPE&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<select size=\"1\" name=\"propose_dans_ppe\">";
							if ($propose_dans_ppe <> "1")
							{
								echo "<option selected value=\"0\">NON</option>";
								echo "<option value=\"1\">OUI</option>";
							}
							else
							{
								echo "<option selected value=\"1\">OUI</option>";
								echo "<option value=\"0\">NON</option>";
							}
							
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">OBSERVATIONS CARDIE (1&eacute;re ann&eacute;e)&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"rmq_cardie_A1\" rows=\"3\" cols=\"75\">$rmq_cardie_A1</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'rmq_cardie_A1' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">OBSERVATIONS CARDIE (2&eacute;me ann&eacute;e)&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"rmq_cardie_A2\" rows=\"3\" cols=\"75\">$rmq_cardie_A2</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'rmq_cardie_A2' );
								</script>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">&nbsp;</td>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
					echo "<td colspan = \"4\">";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">R&Eacute;PONSE PPE&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"reponse_ppe\" rows=\"3\" cols=\"75\">$reponse_ppe</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'reponse_ppe' );
								</script>";
					echo "</td>";
				echo "</tr>";

			echo "</table>";

			//Boutons retour et enregistrement
			echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_modif_projet\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_projet\" NAME = \"id_projet\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</form>";

	}

?>
