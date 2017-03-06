<?php
	//Initialisation des variables pour la saisie des dates
	$aujourdhui_jour = date('d');
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	$fin_garantie_annee = $aujourdhui_annee + 1;
	
	//echo "<br>affiche_formulaire_ajout_article : $affiche_formulaire_ajout_article";
	//echo "<br>id_cde : $id_cde";
	if ($affiche_formulaire_ajout_article <> "O")
	{
		echo "<form action=\"materiels_gestion.php\" method=\"get\">";
	}
	else
	{
		echo "<form action=\"materiels_gestion_commandes.php\" method=\"get\">";
	}
	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"30%\">";
			echo "<col width=\"70%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";

	
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "D&eacute;nomination&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" name=\"denomination\" size = \"50\" />";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				$requete_materiels="SELECT DISTINCT id_cat_princ,intitule_cat_princ FROM materiels_categories_principales ORDER BY intitule_cat_princ";
				$result_materiels=mysql_query($requete_materiels);
				$num_rows = mysql_num_rows($result_materiels);
				echo "Type de mat&eacute;riel&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_typemateriel\">";
				if (mysql_num_rows($result_materiels))
				{
					echo "<option selected value=\"122\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result_materiels))
					{
						$intitule_typemateriel=$ligne->intitule_cat_princ;
						$id_typemateriel=$ligne->id_cat_princ;
						echo "<option value=\"$id_typemateriel\">$intitule_typemateriel</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		//N° de série
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Num&eacute;ro de s&eacute;rie&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" size = \"50\" name=\"no_serie\" />";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "D&eacute;tails de l'article&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"details_article\" rows=\"10\" cols=\"50\"></textarea>";
					echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'details_article' );
						</script></td>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Remarques&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"remarques\" rows=\"5\" cols=\"30\"></textarea>";
					echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'remarques' );
						</script></td>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				$requete_origine="SELECT DISTINCT id_origine,intitule_origine FROM materiels_origine ORDER BY intitule_origine";
				$result_origine=mysql_query($requete_origine);
				$num_rows = mysql_num_rows($result_origine);
				echo "Propri&eacute;taire&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_origine\">";
				if (mysql_num_rows($result_origine))
				{
					echo "<option selected value=\"1\">Mission TICE</option>";
					while ($ligne_origine=mysql_fetch_object($result_origine))
					{
						$id_origine=$ligne_origine->id_origine;
						$intitule_origine=$ligne_origine->intitule_origine;
						echo "<option value=\"$id_origine\">$intitule_origine</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($affiche_formulaire_ajout_article <> "O")
				{
					echo "<select size=\"1\" name=\"annee_budgetaire\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>";
						for($annee = $aujourdhui_annee-2; $annee < $aujourdhui_annee+10; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
				}
				else
				{
					echo "$annee_budgetaire";
				}
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Chapitre des cr&eacute;dits&nbsp;:&nbsp;";
			echo "</td>";
			if ($affiche_formulaire_ajout_article <> "O")
			{
					$requete_credits="SELECT DISTINCT id_chapitre,intitule_chapitre,id_gestionnaire FROM credits_chapitres ORDER BY intitule_chapitre";
					$result_credits=mysql_query($requete_credits);
					$num_rows = mysql_num_rows($result_credits);
				echo "<td>";
					echo "<select size=\"1\" name=\"id_chapitre_credits\">";
					if (mysql_num_rows($result_credits))
					{
						echo "<option selected value=\"\">Faire un choix</option>";
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
			}
			else
			{
				//Il faut récupérer les intitulés des crédits utilisés et du fournisseur
				$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire AND id_chapitre = '".$credits."'";
				$resultat_credits = mysql_query($query_credits);
				$ligne_credits = mysql_fetch_object($resultat_credits);
				$intitule_chapitre_extrait = $ligne_credits->intitule_chapitre;
				$intitule_gestionnaire_extrait = $ligne_credits->intitule_gestionnaire;
				echo "<td>";
					echo "$intitule_chapitre_extrait ($intitule_gestionnaire_extrait)";
				echo "</td>";
			}
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Prix TTC&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" name=\"prix_achat\" size = \"10\" /> &euro;";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "No de commande&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				if ($affiche_formulaire_ajout_article == "O")
				{
					echo "$id_cde - $ref_commande";
				}
				else
				{
					echo "<input type=\"text\" name=\"id_cde\" size = \"5\" value = \"\"/>";
				}
			echo "</td>";
		echo "</tr>";
		
		if ($affiche_formulaire_ajout_article <> "O")
		{
			echo "<tr>";
				echo "<td class = \"etiquette\">Date de livraison&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select size=\"1\" name=\"jour_livraison\">
						<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>";
						for($jour = 1; $jour < 32; $jour++ )
						{
							echo "<option value=\"$jour\">$jour</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"mois_livraison\">
						<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"annee_livraison\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>";
						for($annee = $aujourdhui_annee-2; $annee < $aujourdhui_annee+10; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
		}

		echo "<tr>";
			echo "<td class = \"etiquette\">Fin de garantie&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_fin_garantie\">
					<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>";
						for($jour = 1; $jour < 32; $jour++ )
						{
							echo "<option value=\"$jour\">$jour</option>";
						}
				echo "</select>
					<select size=\"1\" name=\"mois_fin_garantie\">
						<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>";
						for($mois = 1; $mois < 13; $mois++ )
						{
							echo "<option value=\"$mois\">$mois</option>";
						}
					echo "</select>
					<select size=\"1\" name=\"annee_fin_garantie\">
						<option selected value=\"$fin_garantie_annee\">$fin_garantie_annee</option>";
						for($annee = $aujourdhui_annee-2; $annee < $aujourdhui_annee+10; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				$requete_lieux_stockage="SELECT DISTINCT id_lieu_stockage,intitule_lieu_stockage FROM materiels_lieux_stockage ORDER BY intitule_lieu_stockage";
				$result_lieux_stockage=mysql_query($requete_lieux_stockage);
				$num_rows = mysql_num_rows($result_lieux_stockage);
					echo "Lieu de stockage&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_lieu_stockage\" name=\"id_lieu_stockage\">";
				if (mysql_num_rows($result_lieux_stockage))
				{
					echo "<option selected value=\"24\">aucun</option>";
					while ($ligne_lieux_stockage=mysql_fetch_object($result_lieux_stockage))
					{
						$intitule_lieu_stockage=$ligne_lieux_stockage->intitule_lieu_stockage;
						$id_lieu_stockage=$ligne_lieux_stockage->id_lieu_stockage;
						if ($id_lieu_stockage <> 24)
						{
							echo "<option value=\"$id_lieu_stockage\">$intitule_lieu_stockage</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td class = \"etiquette\">";
					$requete_affectation="SELECT DISTINCT id_affectation,intitule_affectation FROM materiels_affectations ORDER BY intitule_affectation";
				$result_affectation=mysql_query($requete_affectation);
				$num_rows = mysql_num_rows($result_affectation);
					echo "Affectation&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_affectation\" name=\"id_affectation\">";
				if (mysql_num_rows($result_affectation))
				{
					echo "<option selected value=\"6\">aucune</option>";
					while ($ligne_affectation=mysql_fetch_object($result_affectation))
					{
						$intitule_affectation=$ligne_affectation->intitule_affectation;
						$id_affectation=$ligne_affectation->id_affectation;
						if ($intitule_affectation <>"réserve à déterminer" AND $id_affectation <>6)
							{
							echo "<option value=\"$id_affectation\">$intitule_affectation</option>";
						}
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Nombre d'article &agrave; enregistrer&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<input type=\"text\" name=\"nombre_articles\" size = \"5\" value = \"1\"/>";
			echo "</td>";
		echo "</tr>";

		echo "</table>";
	echo "<br>";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"2\" NAME = \"id_etat\">"; //l'article sera marqué disponible
	if ($affiche_formulaire_ajout_article <> "O")
	{
		echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer l'article\"/>";
		echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_materiel\" NAME = \"a_faire\">";
	}
	else
	{
		echo "<input type=\"submit\" name=\"bouton_enreg_article\" Value = \"Ajouter\"/>";
		echo "<input type=\"submit\" name=\"bouton_enreg_article\" Value = \"Retourner sans enregistrer\"/>";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"afficher_commande\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$annee_budgetaire\" NAME = \"annee_budgetaire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_cde\" NAME = \"id_cde\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$credits\" NAME = \"credits\">";
	}
		echo "</form>";
?>
