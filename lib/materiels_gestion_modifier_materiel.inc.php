<?php
	//Il faut récupérer les champs de l'enregistrement courant
	$requete_materiel="SELECT * FROM materiels WHERE id = '".$id."'";
	//$query_materiel = "SELECT * FROM materiels, materiels_categories_principales, materiels_origine WHERE materiels.categorie_principale = materiels_categories_principales.id_cat_princ AND materiels.origine = materiels_origine.id_origine AND materiels.affectation = materiels_affectation.id_affectation AND materiels.id = '".$id."';";
	$result_materiel=mysql_query($requete_materiel);
	$num_rows = mysql_num_rows($result_materiel);
	$ligne_materiel = mysql_fetch_object($result_materiel);
	
	//On récupère les variables de l'enregistrement courant
	$id = $ligne_materiel->id;
	$denomination = $ligne_materiel->denomination;
	$id_cat_princ = $ligne_materiel->categorie_principale;
	$no_serie = $ligne_materiel->no_serie;
	$cle_install = $ligne_materiel->cle_install;
	$prix = $ligne_materiel->prix;
	$credits = $ligne_materiel->credits;
	$annee_budgetaire = $ligne_materiel->annee_budgetaire;
	$date_livraison = $ligne_materiel->date_livraison;
	$details_garantie = $ligne_materiel->details_garantie;
	$fin_garantie = $ligne_materiel->fin_garantie;
	$type_affectation = $ligne_materiel->type_affectation;
	$date_affectation = $ligne_materiel->date_affectation;
	$date_retour = $ligne_materiel->date_retour;
	$id_affectation_materiel = $ligne_materiel->affectation_materiel;
	$id_cde = $ligne_materiel->id_cde;
	$id_facture = $ligne_materiel->id_facture;
	$details_article = $ligne_materiel->details_article;
	$remarques = $ligne_materiel->remarques;
	$a_editer = $ligne_materiel->a_editer;
	$problemes_rencontres = $ligne_materiel->problemes_rencontres;
	$id_origine = $ligne_materiel->origine;
	$id_etat = $ligne_materiel->id_etat;
	$id_lieu_stockage = $ligne_materiel->lieu_stockage;
	
	//echo "<br />id_lieu_stockage : $id_lieu_stockage";
	
	//On converti la date de fin de garantie pour affichage
	$fin_garantie = strtotime($fin_garantie);
	$fin_garantie_jour = date('d',$fin_garantie);
	$fin_garantie_mois = date('m',$fin_garantie);
	$fin_garantie_annee = date('Y',$fin_garantie);
	
	//On converti la date de livraison pour affichage
	$date_livraison = strtotime($date_livraison);
	$date_livraison_jour = date('d',$date_livraison);
	$date_livraison_mois = date('m',$date_livraison);
	$date_livraison_annee = date('Y',$date_livraison);
	
	//On converti la date d'affectation pour affichage
	$date_affectation = strtotime($date_affectation);
	$date_affectation_jour = date('d',$date_affectation);
	$date_affectation_mois = date('m',$date_affectation);
	$date_affectation_annee = date('Y',$date_affectation);
	
	//On converti la date de retour pour affichage
	$date_retour = strtotime($date_retour);
	$date_retour_jour = date('d',$date_retour);
	$date_retour_mois = date('m',$date_retour);
	$date_retour_annee = date('Y',$date_retour);
/*
	echo "<br><b>***materiels_gestion_modifier_materiel.inc.php***</b>";
	echo "<br>id : $id";
	echo "<br>denomination : $denomination";
	echo "<br>categorie_principale : $categorie_principale";
	echo "<br>origine : $origine";
	echo "<br>affectation_materiel : $affectation_materiel";
	echo "<br>fin_garantie 2 : $fin_garantie";
	echo "<br>fin_garantie_jour : $fin_garantie_jour";
	echo "<br>fin_garantie_mois : $fin_garantie_mois";
	echo "<br>fin_garantie_annee : $fin_garantie_annee";
*/
	//on récupère les différents intitulés
	//D'abord le type
	$requete_type = "SELECT * FROM materiels_categories_principales WHERE id_cat_princ = '".$id_cat_princ."';";
	$result_type = mysql_query($requete_type);
	$ligne_type = mysql_fetch_object($result_type);
	$intitule_materiel = $ligne_type->intitule_cat_princ;
	$id_cat_princ= $ligne_type->id_cat_princ;
	
	
	//echo "<br>intitule_materiel : $intitule_materiel - id : $id_materiel";
	
	//Ensuite l'origine
	$requete_origine = "SELECT * FROM materiels_origine WHERE id_origine = '".$id_origine."';";
	$result_origine = mysql_query($requete_origine);
	$ligne_origine = mysql_fetch_object($result_origine);
	$intitule_origine = $ligne_origine->intitule_origine;
	$id_origine = $ligne_origine->id_origine;
	
	//echo "<br>intitule_origine : $intitule_origine - id : $id_origine";

	//l'affectation
	$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id_affectation_materiel."';";
	$result_affectation = mysql_query($requete_affectation);
	$ligne_affectation = mysql_fetch_object($result_affectation);
	$intitule_affectation = $ligne_affectation->intitule_affectation;
	$id_affectation = $ligne_affectation->id_affectation;
	
	//echo "<br>modifier_materiel : intitule_affectation : $intitule_affectation - id : $id_affectation";

	//le lieu de stockage
	$requete_stockage = "SELECT * FROM materiels_lieux_stockage WHERE id_lieu_stockage = '".$id_lieu_stockage."';";
	$result_stockage = mysql_query($requete_stockage);
	$ligne_stockage = mysql_fetch_object($result_stockage);
	$intitule_stockage = $ligne_stockage->intitule_lieu_stockage;
	//$id_stockage = $ligne_stockage->id_lieu_stockage;
	
	//echo "<br>modifier_materiel : intitule_lieu_stockage : $intitule_stockage - id : $id_stockage";

	//et pour finir l'état
	$requete_etat = "SELECT * FROM materiels_etats WHERE id_etat = '".$id_etat."';";
	$result_etat = mysql_query($requete_etat);
	$ligne_etat = mysql_fetch_object($result_etat);
	$intitule_etat = $ligne_etat->intitule_etat;
	$id_etat = $ligne_etat->id_etat;
	//echo "<br>intitule_etat : $intitule_etat - id_etat : $id_etat";

	echo "<form action=\"materiels_gestion.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"50%\">";
			echo "<col width=\"50%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";

		//ID
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "ID&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "$id";
			echo "</td>";
		echo "</tr>";

		//Intitulé
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "D&eacute;nomination&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$denomination\" size = \"50\" name=\"denomination\" />";
			echo "</td>";
		echo "</tr>";

		//Type de matériel
		echo "<tr>";
			$requete_materiels="SELECT * FROM materiels_categories_principales ORDER BY intitule_cat_princ";
			$result_materiels=mysql_query($requete_materiels);
			$num_rows = mysql_num_rows($result_materiels);
			echo "<td class = \"etiquette\">";
				echo "Type de mat&eacute;riel&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_cat_princ\">";
				if (mysql_num_rows($result_materiels))
				{
					echo "<option selected value=\"$id_cat_princ\">$intitule_materiel</option>";
					while ($ligne_materiel_extrait=mysql_fetch_object($result_materiels))
					{
						$intitule_materiel_extrait=$ligne_materiel_extrait->intitule_cat_princ;
						$id_cat_princ_extrait = $ligne_materiel_extrait->id_cat_princ;
						if ($intitule_materiel_extrait <> $intitule_materiel)
						{
							echo "<option value=\"$id_cat_princ_extrait\">$intitule_materiel_extrait</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		//Lieux de stockage
		echo "<tr>";
			$requete_lieux_stockage="SELECT * FROM materiels_lieux_stockage ORDER BY intitule_lieu_stockage";
			$result_lieux_stockage=mysql_query($requete_lieux_stockage);
			$num_rows = mysql_num_rows($result_lieux_stockage);
			
			//echo "<br />nbr lieux_stockage : $num_rows";
			
			echo "<td class = \"etiquette\">";
				echo "Lieu de stockage&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
			
				
				if ($num_rows > 0)
				{
					//echo "<br />nbr lieux_stockage >0 - id_lieu_stockage : $id_lieu_stockage";
				
					echo "<select size=\"1\" name=\"id_lieu_stockage\">";
					if ($id_lieu_stockage >0)
					{
						echo "<option selected value=\"$id_lieu_stockage\">$intitule_stockage</option>";
					}
					//echo "<option value=\"\">aucun</option>";
					while ($ligne_lieux_stockage_extrait=mysql_fetch_object($result_lieux_stockage))
					{
						$intitule_lieu_stockage_extrait=$ligne_lieux_stockage_extrait->intitule_lieu_stockage;
						$id_lieu_stockage_extrait = $ligne_lieux_stockage_extrait->id_lieu_stockage;
						if (($id_lieu_stockage_extrait <> $id_lieu_stockage))
						{
							echo "<option value=\"$id_lieu_stockage_extrait\">$intitule_lieu_stockage_extrait</option>";
						}
					}
					echo "</SELECT>";
				}
			echo "</td>";
		echo "</tr>";
		
		//N° de série
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Num&eacute;ro de s&eacute;rie&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$no_serie\" size = \"50\" name=\"no_serie\" />";
			echo "</td>";
		echo "</tr>";
		
		//Clé d'installation
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Cl&eacute; d'installation&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$cle_install\" size = \"50\" name=\"cle_install\" />";
			echo "</td>";
		echo "</tr>";
		
		//Détails de l'article
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "D&eacute;tails de l'article&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"details_article\" rows=\"4\" cols=\"50\">$details_article</textarea>";
					echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'details_article' );
						</script></td>";
			echo "</td>";
		echo "</tr>";
		
		//On insére les boutons
		echo "<tr>";
			echo "<td colspan = \"2\" align = \"center\">";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
				&nbsp;&nbsp;<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "</td>";
		echo "</tr>";
		
		//Remarques
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Remarques&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"remarques\" rows=\"4\" cols=\"50\">$remarques</textarea>";
					echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'remarques' );
						</script></td>";
			echo "</td>";
		echo "</tr>";

		//On insére les boutons
		echo "<tr>";
			echo "<td colspan = \"2\" align = \"center\">";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
				&nbsp;&nbsp;<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "</td>";
		echo "</tr>";
		
		//Problèmes rencontrés
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Probl&egrave;mes rencontr&eacute;s&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"problemes_rencontres\" rows=\"4\" cols=\"50\">$problemes_rencontres</textarea>";
					echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'problemes_rencontres' );
						</script></td>";
			echo "</td>";
		echo "</tr>";

		//On insére les boutons
		echo "<tr>";
			echo "<td colspan = \"2\" align = \"center\">";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
				&nbsp;&nbsp;<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "</td>";
		echo "</tr>";
		
		//Affectation
		echo "<tr>";
			$requete_affectation="SELECT * FROM materiels_affectations ORDER BY intitule_affectation";
			$result_affectation=mysql_query($requete_affectation);
			$num_rows = mysql_num_rows($result_affectation);
			echo "<td class = \"etiquette\">";
				echo "Affectation&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_affectation\">";
				if (mysql_num_rows($result_affectation))
				{
					if ($id_affectation <>6)
					{
						echo "<option selected value=\"$id_affectation\">$intitule_affectation</option>";
					}
					else
					{
						echo "<option value=\"6\">aucune</option>";
					}
					
					while ($ligne_affectation_extrait=mysql_fetch_object($result_affectation))
					{
						$intitule_affectation_extrait=$ligne_affectation_extrait->intitule_affectation;
						$id_affectation_extrait = $ligne_affectation_extrait->id_affectation;
						if (($intitule_affectation_extrait <> "réserve à déterminer") AND ($intitule_affectation_extrait <> $intitule_affectation))
						{
							echo "<option value=\"$id_affectation_extrait\">$intitule_affectation_extrait</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		//Date d'affectation
		echo "<tr>";
			echo "<td class = \"etiquette\">Date d'affectation&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"jour_affectation\">
					<option selected value=\"$date_affectation_jour\">$date_affectation_jour</option>";
					for($jour = 1; $jour < 32; $jour++ )
					{
						echo "<option value=\"$jour\">$jour</option>";
					}
				echo "</select>
					<select size=\"1\" name=\"mois_affectation\">
						<option selected value=\"$date_affectation_mois\">$date_affectation_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"annee_affectation\">
						<option selected value=\"$date_affectation_annee\">$date_affectation_annee</option>";
						for($annee = $date_affectation_annee-2; $annee < $date_affectation_annee+15; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";

		//Type d'affectation
		//On vérifie que le champ est renseigné
		if ($type_affectation =="")
		{
			$type_affectation = "permanente";
		}
		echo "<tr>";
			echo "<td class = \"etiquette\">Type d'affectation&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"type_affectation\">
					<option selected value=\"$type_affectation\">$type_affectation</option>";
					if ($type_affectation == "ponctuelle")
					{
						echo "<option value=\"permanente\">permanente</option>";
					}
					else
					{
						echo "<option value=\"ponctuelle\">ponctuelle</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		//On insère la date de retour
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de retour&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"jour_retour\">
					<option selected value=\"$date_retour_jour\">$date_retour_jour</option>";
					for($jour = 1; $jour < 32; $jour++ )
					{
						echo "<option value=\"$jour\">$jour</option>";
					}
				echo "</select>
				<select size=\"1\" name=\"mois_retour\">
					<option selected value=\"$date_retour_mois\">$date_retour_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
				<select size=\"1\" name=\"annee_retour\">
					<option selected value=\"$date_retour_annee\">$date_retour_annee</option>";
						for($annee = $date_retour_annee-2; $annee < $date_retour_annee+15; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		//Etat
		echo "<tr>";
			$requete_etat="SELECT DISTINCT intitule_etat,id_etat FROM materiels_etats ORDER BY intitule_etat";
			$result_etat=mysql_query($requete_etat);
			$num_rows = mysql_num_rows($result_etat);
			echo "<td class = \"etiquette\">";
				echo "&eacute;tat&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_etat\">";
				if (mysql_num_rows($result_etat))
				{
					echo "<option selected value=\"$id_etat\">$intitule_etat</option>";
					while ($ligne_etat_extrait=mysql_fetch_object($result_etat))
					{
						$intitule_etat_extrait=$ligne_etat_extrait->intitule_etat;
						$id_etat_extrait = $ligne_etat_extrait->id_etat;
						if ($intitule_etat_extrait <> $intitule_etat)
						{
							echo "<option value=\"$id_etat_extrait\">$intitule_etat_extrait</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		
		//Edition
		echo "<tr>";
			echo "<td class = \"etiquette\">&Eacute;diter la fiche&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"a_editer\">";
					if ($a_editer == "0")
					{
						echo "<option selected value=\"0\">Non</option>";
						echo "<option value=\"1\">Oui</option>";
					}
					else
					{
						echo "<option selected value=\"1\">Oui</option>";
						echo "<option value=\"0\">Non</option>";
					}
					echo "</select>";
			echo "</td>";
		echo "</tr>";

		//On insére les boutons
		echo "<tr>";
			echo "<td colspan = \"2\" align = \"center\">";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
				&nbsp;&nbsp;<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "</td>";
		echo "</tr>";
		
		//Propriétaire
		echo "<tr>";
			$requete_origine="SELECT * FROM materiels_origine ORDER BY intitule_origine";
			$result_origine=mysql_query($requete_origine);
			$num_rows = mysql_num_rows($result_origine);
			echo "<td class = \"etiquette\">";
				echo "Propri&eacute;taire&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_origine\">";
				if (mysql_num_rows($result_origine))
				{
					echo "<option selected value=\"$id_origine\">$intitule_origine</option>";
					while ($ligne_origine_extrait=mysql_fetch_object($result_origine))
					{
						$intitule_origine_extrait=$ligne_origine_extrait->intitule_origine;
						$id_origine_extrait = $ligne_origine_extrait->id_origine;
						if ($intitule_origine_extrait <> $intitule_origine)
						{
							echo "<option value=\"$id_origine_extrait\">$intitule_origine_extrait</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		//Année budgétaire
		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"annee_budgetaire\">
					<option selected value=\"$annee_budgetaire\">$annee_budgetaire</option>";
					for($annee = $annee_budgetaire-2; $annee < $annee_budgetaire+15; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		//Les crédits utilisés
		//Il faut récupérer les intitulés des crédits utilisés et du fournisseur
		$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires
			WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire
			AND id_chapitre = '".$credits."'";
		$resultat_credits = mysql_query($query_credits);
		$ligne_credits = mysql_fetch_object($resultat_credits);
		$intitule_chapitre_extrait = $ligne_credits->intitule_chapitre;
		$intitule_gestionnaire_extrait = $ligne_credits->intitule_gestionnaire;
	
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Chapitre des cr&eacute;dits&nbsp;:&nbsp;";
			echo "</td>";
				$requete_credits="SELECT DISTINCT id_chapitre,intitule_chapitre,id_gestionnaire FROM credits_chapitres ORDER BY intitule_chapitre";
				$result_credits=mysql_query($requete_credits);
				$num_rows = mysql_num_rows($result_credits);
			echo "<td>";
				echo "<select size=\"1\" name=\"id_chapitre_credits\">";
				if (mysql_num_rows($result_credits))
				{
					echo "<option selected value=\"$credits\">$intitule_gestionnaire_extrait - $intitule_chapitre_extrait</option>";
					echo "<option value=\"\">aucun</option>";
					while ($ligne_credits=mysql_fetch_object($result_credits))
					{
						$intitule_chapitre=$ligne_credits->intitule_chapitre;
						$id_gestionnaire = $ligne_credits->id_gestionnaire;
						$id_chapitre = $ligne_credits->id_chapitre;
						//Il faut récupérer l'intitulé du gestionnaire
						$requete_gestionnaire="SELECT DISTINCT intitule_gestionnaire FROM credits_gestionnaires WHERE id_gestionnaire = '".$id_gestionnaire."'";
						$result_gestionnaire=mysql_query($requete_gestionnaire);
						$num_rows = mysql_num_rows($result_credits);
						$ligne_gestionnaire=mysql_fetch_object($result_gestionnaire);
						$intitule_gestionnaire = $ligne_gestionnaire->intitule_gestionnaire;
			
						echo "<option value=\"$id_chapitre\">$intitule_gestionnaire - $intitule_chapitre</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		//Prix d'achat
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Prix d'achat&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" name=\"prix\" size = \"10\" value = \"$prix\" /> &euro;";
			echo "</td>";
		echo "</tr>";
		
		//Date de livraison
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de livraison&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"jour_livraison\">
						<option selected value=\"$date_livraison_jour\">$date_livraison_jour</option>";
						for($jour = 1; $jour < 32; $jour++ )
						{
							echo "<option value=\"$jour\">$jour</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"mois_livraison\">
						<option selected value=\"$date_livraison_mois\">$date_livraison_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"annee_livraison\">
						<option selected value=\"$date_livraison_annee\">$date_livraison_annee</option>";
						for($annee = $date_livraison_annee-2; $annee < $date_livraison_annee+15; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";

		//Fin de garantie
		echo "<tr>";
			echo "<td class = \"etiquette\">Fin de garantie&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_fin_garantie\">
						<option selected value=\"$fin_garantie_jour\">$fin_garantie_jour</option>";
						for($jour = 1; $jour < 32; $jour++ )
						{
							echo "<option value=\"$jour\">$jour</option>";
						}
				echo "</select>
					<select size=\"1\" name=\"mois_fin_garantie\">
						<option selected value=\"$fin_garantie_mois\">$fin_garantie_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"annee_fin_garantie\">
						<option selected value=\"$fin_garantie_annee\">$fin_garantie_annee</option>";
						for($annee = $fin_garantie_annee-2; $annee < $fin_garantie_annee+15; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";

		//Détail garantie
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "d&eacute;tails garantie&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$details_garantie\" name=\"details_garantie\" />";
			echo "</td>";
		echo "</tr>";
		
		//Commande
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "No de commande&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$id_cde\" name=\"id_cde\" />";
			echo "</td>";
		echo "</tr>";
		
		//Facture
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "facture&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" VALUE = \"$id_facture\" name=\"id_facture\" />";
			echo "</td>";
		echo "</tr>";
		
		//On insére les boutons
		echo "<tr>";
			echo "<td colspan = \"2\" align = \"center\">";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer la modification\"/>
				&nbsp;&nbsp;<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "</td>";
		echo "</tr>";

	echo "</table>";
	echo "<br>";
	
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_gestion\" NAME = \"origine_gestion\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"script_modification\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"maj_materiel\" NAME = \"a_faire\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$a_editer\" NAME = \"a_editer\">";
	echo "</form>";
?>
