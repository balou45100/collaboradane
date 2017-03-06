<?php
	echo "<h2>Fiche d&eacute;taill&eacute;e du projet $id_projet</h2>";
	
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
		$decision_commission = $ligne->DECISION_COMMISSION;
		$reponse_ppe = $ligne->REPONSE_PPE;
		$type_accompagnement = $ligne->TYPE_ACCOMPAGNEMENT;
		$nbr_eleves = $ligne->NBR_ELEVES;
		$nbr_enseignants = $ligne->NBR_ENSEIGNANTS;
		$propose_dans_ppe = $ligne->PROPOSE_DANS_PPE;
		$type_groupe_developpement = $ligne->TYPE_GROUPE_DEVELOPPEMENT;
		
		IF ($propose_dans_ppe <> "1")
		{
			$propose_dans_ppe = "NON";
		}
		else
		{
			$propose_dans_ppe = "OUI";
		}
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
		echo "<table width=\"95%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\"  width = \"20%\">INTITULE&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\"><b>&nbsp;$intitule_projet</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">ANN&Eacute;E D&Eacute;BUT&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$annee_a_afficher</td>";

				echo "<td class = \"etiquette\">D&Eacute;CISION COMMISSION&nbsp;:&nbsp;</td>";
				echo "<td>$decision_commission</td>";

				echo "<td class = \"etiquette\">TYPE ACCOMPAGNEMENT&nbsp;:&nbsp;</td>";
				echo "<td>$type_accompagnement</td>";

			echo "<tr>";
				echo "<td class = \"etiquette\">GROUPE DE D&Eacute;VELOPPEMENT*&nbsp;:&nbsp;</td>";
					$intitule_type_groupe_developpement = lecture_champ('cardie_type_groupe_developpement','intitule_TGD','id_TGD',$type_groupe_developpement);
					echo "<td colspan = \"5\">&nbsp;$intitule_type_groupe_developpement</td>";
			echo "</tr>";


			echo "<tr>";
				echo "<td class = \"etiquette\">INITIATEUR&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$initiateur</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">RAISONS / CONTEXTE / CONSTATS&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$description</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">RESUM&Eacute;&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$resume</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">OBJECTIFS&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$objectifs</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">INDICATEURS&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$indicateurs</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">MODES D'ACTION&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$modes_action</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">CHANGEMENTS&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$changements</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">PHASES DU PROJET&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$phases_du_projet</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">MOTS CLEF&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$mots_clef</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">NOMBRE D'&Eacute;L&Egrave;VES&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$nbr_eleves</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">NOMBRE D'ENSEIGNANT-E-ES&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$nbr_enseignants</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">PROPOS&Eacute; DANS PPE&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$propose_dans_ppe</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">OBSERVATIONS CARDIE (1&egrave;re ann&eacute;e)&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$rmq_cardie_A1</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">OBSERVATIONS CARDIE (2&egrave;me ann&eacute;e)&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$rmq_cardie_A2</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">R&Eacute;PONSE PPE&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">&nbsp;$reponse_ppe</td>";
			echo "</tr>";
			
			//Légende
			echo "<tr>";
				echo "<td class = \"etiquette\" colspan = \"6\">* si applicable</td>";
			echo "</tr>";
		echo "</table>";

		echo "* si applicable";
		
		//Partie moyens attribués
		//echo "<h2>Moyens attribu&eacute;s</h2>";
		
		echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

	}

?>
