<?php
	session_start();
	$autorisation_admin_materiel = verif_appartenance_groupe(10);
	//Il faut récupérer les informations concernant le matériel
	$requete_materiel="SELECT * FROM materiels WHERE id = '".$id."'";
	$result_materiel=mysql_query($requete_materiel);
	$num_rows = mysql_num_rows($result_materiel);
	//echo "<br>Nombre d'enregistrements retourné : $num_rows";
	$ligne_materiel=mysql_fetch_object($result_materiel);

	$id = $ligne_materiel->id;
	$denomination = $ligne_materiel->denomination;
	$categorie_principale = $ligne_materiel->categorie_principale;
	$categorie_secondaire = $ligne_materiel->categorie_secondaire;
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
	$affectation_materiel = $ligne_materiel->affectation_materiel;
	$id_cde = $ligne_materiel->id_cde;
	$id_facture = $ligne_materiel->id_facture;
	$details_article = $ligne_materiel->details_article;
	$a_editer = $ligne_materiel->a_editer;
	$problemes_rencontres = $ligne_materiel->problemes_rencontres;
	$origine = $ligne_materiel->origine;
	$id_etat = $ligne_materiel->id_etat;
	$lieux_stockage = $_GET['lieux_stockage'];
	
	
	//Transformation des dates extraites pour l'affichage
	$date_affectation_a_afficher = strtotime($date_affectation);
	$date_affectation_a_afficher = date('d/m/Y',$date_affectation_a_afficher);
	$date_retour_a_afficher = strtotime($date_retour);
	$date_retour_a_afficher = date('d/m/Y',$date_retour_a_afficher);
	$date_livraison_a_afficher = strtotime($date_livraison);
	$date_livraison_a_afficher = date('d/m/Y',$date_livraison_a_afficher);
	$fin_garantie_a_afficher = strtotime($fin_garantie);
	$fin_garantie_a_afficher = date('d/m/Y',$fin_garantie_a_afficher);
	//echo "<br>date_livraison : $date_livraison_a_afficher";
	
	/*
	echo "<br />***materiels_gestion_affiche_fiche_materiel.inc.php***";
	echo "<br />rechercher : $rechercher";
	echo "<br />dans : $dans";
	echo "<br />tri : $tri";
	echo "<br />sense_tri : $sense_tri";
	echo "<br />origine_gestion : $origine_gestion";
	*/
	echo "<h2>Fiche article</h2>";
//	echo "<form id=\"monForm\" action=\"materiels_gestion.php\" method=\"get\">";
	if ($_SESSION['origine1'] == "tb")
	{
	echo "<form  action=\"test.php\" method=\"get\">";
	}
	else
	{
	echo "<form  action=\"materiels_gestion.php\" method=\"get\">";
	}
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<colgroup>";
			echo "<col width=\"50%\">";
			echo "<col width=\"50%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";
	
		echo "<tr>";
			echo "<td bgcolor = \"$bg_color2\" align = \"center\" colspan = \"2\">Renseignements de base</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$id&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">D&eacute;nomination&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$denomination&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère l'intiulé de la catégorie principale
				$requete_intitule_cp="SELECT DISTINCT intitule_cat_princ FROM materiels_categories_principales WHERE id_cat_princ = '".$categorie_principale."'";
				$result_intitule_cp=mysql_query($requete_intitule_cp);
				$ligne_intitule_cp=mysql_fetch_object($result_intitule_cp);
				$intitule_cp=$ligne_intitule_cp->intitule_cat_princ;
			echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$intitule_cp&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère l'intiulé du propriétaire
				$requete_origine="SELECT DISTINCT intitule_origine FROM materiels_origine WHERE id_origine = '".$origine."'";
				$result_origine=mysql_query($requete_origine);
				$ligne_origine=mysql_fetch_object($result_origine);
				$intitule_origine=$ligne_origine->intitule_origine;
			echo "<td class = \"etiquette\">Propri&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$intitule_origine&nbsp;</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td bgcolor = \"$bg_color2\" align = \"center\" colspan = \"2\">D&eacute;tails sur la disponibilit&eacute;</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère l'intiulé de l'affectation
				$requete_affectation="SELECT DISTINCT intitule_affectation FROM materiels_affectations WHERE id_affectation = '".$affectation_materiel."'";
				$result_affectation=mysql_query($requete_affectation);
				$ligne_affectation=mysql_fetch_object($result_affectation);
				$intitule_affectation=$ligne_affectation->intitule_affectation;
			echo "<td class = \"etiquette\">affect&eacute; &agrave;&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$intitule_affectation&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">affect&eacute; le&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($date_affectation_a_afficher <> "01/01/1970")
				{
					echo "&nbsp;$date_affectation_a_afficher";
				}
				else
				{
					echo "&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
			if ($type_affectation == "ponctuelle")
			{
				echo "<tr>";
					echo "<td class = \"etiquette\">retour pr&eacute;vu le&nbsp;:&nbsp;</td>";
					if ($date_retour_a_afficher <> "01/01/1970")
					{
						echo "<td>&nbsp;$date_retour_a_afficher</td>";
					}
					else
					{
						echo "<td>&nbsp;</td>";
					}
				echo "</tr>";
			}
	
		echo "<tr>";
			echo "<td bgcolor = \"$bg_color2\" align = \"center\" colspan = \"2\">Renseignements d&eacute;taill&eacute;s</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Numéro de s&eacute;rie&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$no_serie&nbsp;</td>";
		echo "</tr>";
		if ($autorisation_admin_materiel == "1")
		{
			echo "<tr>";
				echo "<td class = \"etiquette\">Cl&eacute; d'installation&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$cle_install&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">mot de passe \"administrateur\"&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
		echo "<tr>";
			echo "<td class = \"etiquette\">mot de passe \"utilisateur\"&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td bgcolor = \"$bg_color2\" align = \"center\" colspan = \"2\">Renseignements sur la garantie</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date livraison&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($date_livraison_a_afficher <> "01/01/1970")
				{
					echo "&nbsp;$date_livraison_a_afficher&nbsp;";
				}
				else
				{
					echo "&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">garantie jusqu'au&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($fin_garantie_a_afficher <> "01/01/1970")
				{
					echo "&nbsp;$fin_garantie_a_afficher&nbsp;";
				}
				else
				{
					echo "&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">d&eacute;tails&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$details_garantie&nbsp;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td bgcolor = \"$bg_color2\" align = \"center\" colspan = \"2\">Renseignements divers</td>";
		echo "<tr>";
			echo "<td class = \"etiquette\">D&eacute;tails sur l'article&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$details_article&nbsp;</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
		if ($_SESSION['origine1'] == "tb")
			{
			echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><center><input type=submit Value = Retour></center></a>";
			}
			else
			{		
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner à la liste\"/>";
			}

			echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">";
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_gestion\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</form>";
?>
