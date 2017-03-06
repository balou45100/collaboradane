<?php
	echo "<h2>Ajout d'un-e accompagnateur-trice</h2>";
	
	//On affiche le projet
	
	$requete_etab = "SELECT * FROM 
			cardie_projet AS CP, 
			etablissements AS ETAB 
		WHERE CP.RNE = ETAB.RNE AND CP.NUM_PROJET = '".$id_projet."'";
		
	$resultat = mysql_query($requete_etab);
	$ligne = mysql_fetch_object($resultat);
	
	$id_projet = $ligne->NUM_PROJET;
	$intitule_projet = $ligne->INTITULE;
	$mise_en_route = $ligne->ANNEE;
	$rne = $ligne->RNE;
	$etat = $ligne->ACTIF;
	$decision_commission = $ligne->DECISION_COMMISSION;
	$type_accompagnement = $ligne->TYPE_ACCOMPAGNEMENT;
	$type_etab = $ligne->TYPE;
	$nom_etab = $ligne->NOM;
	$ville_etab = $ligne->VILLE;
	
	echo "<table width=\"85%\">";
		echo "<tr>";
			echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
			echo "<td>$id_projet</td>";
			echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>$intitule_projet</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Structure&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"2\">$type_etab&nbsp;$nom_etab,&nbsp;$ville_etab</td>";
		echo "</tr>";
	echo "</table>";

	//////////////////////////////////////////////
	/// Traitement des accompagnateur-e-s/////////
	//////////////////////////////////////////////

	//On affiche la liste d&eacute;roulante
	echo "<hr />";
	echo "<form action = \"cardie_gestion_projets.php\" method = \"get\">";
	$requete_accompagnateurs_cardie = "SELECT * FROM fonctions_des_personnes_ressources AS FPR, personnes_ressources_tice AS PRT
		WHERE FPR.ID_PERS_RESS = PRT.ID_PERS_RESS
			AND FPR.FONCTION = 'accompagnateur/trice CARDIE'
			AND FPR.ANNEE = '".$annee_en_cours."'
		ORDER BY PRT.NOM, PRT.PRENOM";
		
	//echo "<br />$requete_accompagnateurs_cardie";
	
	$resultat_requete_accompagnateurs_cardie = mysql_query($requete_accompagnateurs_cardie);

	echo "<center><b>Modifier la liste des intervenant-e-s :</b>
		<br />- Ajout &agrave; l'aide de la liste d&eacute;roulante
		<br />- Suppression en cliquant sur la croix derri&egrave;re le nom<br/><br />";
	//$no = mysql_num_rows($results_utils);
	echo "<select name = \"id_pers_ress\">";
	while ($ligne_accompagnateur = mysql_fetch_object($resultat_requete_accompagnateurs_cardie))
	{
		$id_pers_ress = $ligne_accompagnateur->id_pers_ress;
		$nom = $ligne_accompagnateur->nom;
		$prenom = $ligne_accompagnateur->prenom;
		
		//on vérifie si le nom existe déjà
		$requete_verif_accompagnateur = 
			"SELECT CP.NUM_PROJET, PRT.NOM, PRT.PRENOM, PRT.id_pers_ress FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA, personnes_ressources_tice AS PRT
			WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CPA.FK_ID_PERS_RESS = PRT.ID_PERS_RESS
				AND CPA.FK_NUM_PROJET = $id_projet
				AND CPA.FK_ID_PERS_RESS = $id_pers_ress
			ORDER BY PRT.NOM";
		
		$resultat_verif_accompagnateur = mysql_query($requete_verif_accompagnateur);
		$verif_accompagnateur = mysql_num_rows($resultat_verif_accompagnateur);
		if ($verif_accompagnateur == 0)
		{
			echo "<option value = \"".$id_pers_ress."\">".$nom." - ".$prenom."</option>";
		}
		/*
		$verif_intervenant = "SELECT * FROM intervenant_ticket WHERE id_tick = $idpb AND id_interv = $id_interv";
		$resultat_verif_intervenant = mysql_query($verif_intervenant);
		
		//On extrait les champs id_crea et id_interv. S'ils sont identiques on n'affiche pas la personne
		$test_createur_intervenant = mysql_fetch_row($resultat_verif_intervenant);
		$id_createur = $test_createur_intervenant[1];
		$id_intervenant = $test_createur_intervenant[2];
		//echo "<option value = \"".$id_interv."\">$id_createur - $id_intervenant</option>";
		//echo "<br />id_crea : $id_crea - id_intervenant : $id_intervenant";
		if (mysql_num_rows($resultat_verif_intervenant) == 0)
		{
			//Il faut tester si l'intervenant et le cr&eacute;ateur sont identiques, dans ce cas on ne l'affiche pas
			//if ($id_createur <> $id_intervenant)
			//{
				echo "<option value = \"".$id_interv."\">".$nom." - ".$prenom."</option>";
			//}
		}
		*/
	}
	echo "</select>";
	echo "<input type = \"hidden\" VALUE = \"$id_projet\" NAME = \"id_projet\">";
	echo "<input type = \"hidden\" VALUE = \"ajout_accompagnateur\" NAME = \"a_faire\">";
	echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
	echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"enreg_accompagnateur\">";
	echo "<input type = \"submit\" VALUE = \"Ajouter un-e accompagntaur/trice\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</center><br />";
	echo "</form>";

	//On affiche les accompagnateurs pour le projet sélectionné
	$liste_accompagnateurs = "SELECT id_pers_ress, nom, prenom FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA, personnes_ressources_tice AS PRT
		WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CPA.FK_ID_PERS_RESS = PRT.ID_PERS_RESS
			AND CP.NUM_PROJET = '".$id_projet."'
		ORDER BY PRT.nom";
			
	//echo "<br />$liste_accompagnateurs";
	
	$resultat_liste_accompagnateurs = mysql_query($liste_accompagnateurs);
	$nb_accompagnateurs = mysql_num_rows($resultat_liste_accompagnateurs);
	
	//echo "<br />nb_accompagnateurs : $nb_accompagnateurs";
	
	if ($nb_accompagnateurs > 0)
	{
		echo "<center>";
		echo "<table BORDER = \"2\" align = \"center\" width=\"85%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\" width=\"10%\">Accompagnateur/trice(s)&nbsp;:&nbsp;</td>";
				//echo "Intervenant-e-s&nbsp;:&nbsp;";

				$intervenants = "";
				$compteur = 0;
				echo "<td>";

					while ($ligne = mysql_fetch_object($resultat_liste_accompagnateurs))
					{
						$compteur++;
						//echo "<br />0 : $resultats[0] - 1 : $resultats[1] - 2 : $resultats[2]";
						$id_pers_ress_extrait = $ligne->id_pers_ress;
						$nom = $ligne->nom;
						$prenom = $ligne->prenom;
							if ($compteur < $nb_accompagnateurs)
							{
								echo "$nom".", ".$prenom."&nbsp<a href = \"?action=O&amp;a_faire=confirmation_dissocier_accompagnateur&amp;id_projet=".$id_projet."&amp;id_pers_ress=".$id_pers_ress_extrait."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Dissocier l'accompagnateur/trice du projet\"></a>";"&nbsp;-&nbsp;";
							}
							else
							{
								echo "$nom".", ".$prenom."&nbsp<a href = \"?action=O&amp;a_faire=confirmation_dissocier_accompagnateur&amp;id_projet=".$id_projet."&amp;id_pers_ress=".$id_pers_ress_extrait."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Dissocier l'accompagnateur/trice du projet\"></a>";"&nbsp;-&nbsp;";;
							}
					}
				echo "</td>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	} //Fin if ($nb_accompagnateurs > 0)
		echo "<form action=\"cardie_gestion_projets.php\" method=\"post\">";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
/*
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le projet\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
*/
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_projet\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</form>";
?>
