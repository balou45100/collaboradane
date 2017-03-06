<?php
	//Il faut récupérer les informations concernant la commande
	$requete_commande="SELECT * FROM materiels_commandes, repertoire WHERE materiels_commandes.fournisseur = repertoire.No_societe AND id_commande = '".$id_cde."'";
	$result_commande=mysql_query($requete_commande);
	$num_rows = mysql_num_rows($result_commande);
	//echo "<br>Nombre d'enregistrements retourné : $num_rows";
	$ligne_commande=mysql_fetch_object($result_commande);
	$id_cde = $ligne_commande->id_commande;
	$devis = $ligne_commande->devis;
	$ref_commande = $ligne_commande->ref_commande;
	$date_commande = $ligne_commande->date_commande;
	$bon_livraison = $ligne_commande->bon_livraison;
	$date_livraison_complete = $ligne_commande->date_livraison_complete;
	$id_facture = $ligne_commande->id_facture;
	$date_facture = $ligne_commande->date_facture;
	$fournisseur = $ligne_commande->fournisseur;
	$credits = $ligne_commande->credits;
	$annee_budgetaire = $ligne_commande->annee_budgetaire;
	$frais_de_port = $ligne_commande->frais_de_port;
	$total_commande = $ligne_commande->total_commande;
	$remarques = $ligne_commande->remarques;
	$societe = $ligne_commande->societe;
	$ville = $ligne_commande->ville;
	
	//On récupère l'intitulé des crédits
	$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire AND credits_chapitres.id_chapitre = '".$credits."'";
	$resultat_credits = mysql_query($query_credits);
	$ligne_credits = mysql_fetch_object($resultat_credits);
	$intitule_chapitre = $ligne_credits->intitule_chapitre;
	$intitule_gestionnaire = $ligne_credits->intitule_gestionnaire;

	
	//Transformation des dates extraites pour l'affichage
	$date_commande_a_afficher = strtotime($date_commande);
	$date_commande_a_afficher = date('d/m/Y',$date_commande_a_afficher);
	
	if (ISSET ($date_livraison_complete))
	{
		$date_livraison_a_afficher = strtotime($date_livraison_complete);
		$date_livraison_a_afficher = date('d/m/Y',$date_livraison_a_afficher);
	}
	else
	{
		$date_livraison_a_afficher = "";
	}
	
	if (ISSET ($date_facture))
	{
		$date_facture_a_afficher = strtotime($date_facture);
		$date_facture_a_afficher = date('d/m/Y',$date_facture_a_afficher);
	}
	else
	{
		$date_facture_a_afficher = "";
	}
	//echo "<br>date_livraison : $date_livraison_a_afficher";
	echo "<h2>Fiche de la commande $id_cde</h2>";
	echo "<form  action=\"materiels_gestion_commandes.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<colgroup>";
			echo "<col width=\"16%\">";
			echo "<col width=\"16%\">";
			echo "<col width=\"17%\">";
			echo "<col width=\"17%\">";
			echo "<col width=\"17%\">";
			echo "<col width=\"17%\">";
		echo "</colgroup>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;<b>$annee_budgetaire</b>&nbsp;</td>";
			echo "<td class = \"etiquette\">Cr&eacute;dits&nbsp;:&nbsp;</td>";
			echo "<td>";
			if ($intitule_chapitre <>"")
			{
				echo "&nbsp;$intitule_chapitre ($intitule_gestionnaire)&nbsp;";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";

			echo "<td class = \"etiquette\">Montant&nbsp;:&nbsp;</td>";
			echo "<td>";
			if ($total_commande >0)
			{
				$nombre_a_afficher = Formatage_Nombre($total_commande,$monnaie_utilise);
				echo "&nbsp;$nombre_a_afficher&nbsp;";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";
		echo "</tr>";

			echo "<td class = \"etiquette\">Devis&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$devis&nbsp;</td>";
			echo "<td class = \"etiquette\">No commande&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$ref_commande&nbsp;</td>";
			echo "<td class = \"etiquette\">Date commande&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$date_commande_a_afficher&nbsp;</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">B/L&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$bon_livraison&nbsp;</td>";
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
			echo "<td class = \"etiquette\">No facture&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;$id_facture&nbsp;</td>";
			echo "<td class = \"etiquette\">Date facture&nbsp;:&nbsp;</td>";
			if ($date_facture_a_afficher <> "01/01/1970")
			{
				echo "<td>&nbsp;$date_facture_a_afficher&nbsp;</td>";
			}
			else
			{
				echo "<td>&nbsp;</td>";
			}
		echo "</tr>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Fournisseur&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"5\">&nbsp;$societe, $ville&nbsp;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"5\">&nbsp;$remarques&nbsp;</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner à la liste\"/>
				<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
				<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions\">
				<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">
				<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">
				<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
				<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
				<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
				echo "</form>";
			
			echo "</td>";

			echo "<td>";
				echo "&nbsp;";
			echo "</td>";

			echo "<td>";
				echo "<form  action=\"materiels_gestion_commandes.php\" method=\"get\">";
					echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Ajouter un article\"/>
						<INPUT TYPE = \"hidden\" VALUE = \"$annee_budgetaire\" NAME = \"annee_budgetaire\">
						<INPUT TYPE = \"hidden\" VALUE = \"$id_cde\" NAME = \"id_cde\">
						<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
						<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
						<INPUT TYPE = \"hidden\" VALUE = \"afficher_commande\" NAME = \"a_faire\">
						<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"affiche_formulaire_ajout_article\">
						<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">
						<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">
						<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
						<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
						<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		
	echo "<br>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// On regarde s'il faut changer l'état d'un article //////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($changer_etat == "O")
	{
		//echo "<br>dans changer_etat";
		$id_etat = $_GET['id_etat'];
		$id = $_GET['id'];
		$requete_ce = "UPDATE materiels SET `id_etat` = '".$id_etat."' WHERE id='".$id."'";
		$result_ce = mysql_query($requete_ce);
		if (!$result_ce)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// On regarde si un article doit être enregistré /////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//echo "<br>bouton cliqué : $bouton_enreg_article";
	if ($bouton_enreg_article == "Ajouter")
	{
		//echo "<br>annee_budgetaire : $annee_budgetaire";
		include ("materiels_gestion_enreg_materiel.inc.php");
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// On affiche le formulaire d'ajout d'un article si demandé //////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($affiche_formulaire_ajout_article == "O")
	{
		//echo "<h2>J'affiche le formulaire d'ajout d'article</h2>";	
		//echo "<br>ref_commande : $ref_commande";
		include ("materiels_gestion_ajout_materiel.inc.php");

	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// On affiche les articles qui compose la commande ///////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//echo "<br />id_cde : $id_cde";
	
	$requete_articles = "SELECT * FROM VmaterielsTousIntitules WHERE id_cde = '".$id_cde."'";
	$resultat_articles = mysql_query($requete_articles);
	$num_rows = mysql_num_rows($resultat_articles);
	if ($num_rows >0)
	{
		echo "Nombre d'articles pour la commande : $num_rows";
		echo "<TABLE BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">";
			echo "<TR>";
				echo "<th align=\"center\">Id</th> ";
				echo "<th align=\"center\">INTITUL&Eacute;</th> ";
				echo "<th align=\"center\">Cat&eacute;gorie</th> ";
				echo "<th align=\"center\">propri&eacute;taire</th> ";
				echo "<th align=\"center\">affectation</th> ";
				echo "<th align=\"center\">&eacute;tat</th> ";
				if ($autorisation_gestion_materiels == 1)
				{
					echo "<th align=\"center\">ACTIONS</th> ";
				}
			echo "</tr>";
			while ($ligne_articles_extrait = mysql_fetch_object($resultat_articles))
			{
				$id = $ligne_articles_extrait->id;
				$denomination = $ligne_articles_extrait->denomination;
				$categorie = $ligne_articles_extrait->intitule_cat_princ;
				$origine = $ligne_articles_extrait->intitule_origine;
				$intitule_affectation = $ligne_articles_extrait->intitule_affectation;
				$a_editer = $ligne_articles_extrait->a_editer;
				$id_etat = $ligne_articles_extrait->id_etat;
				//echo "<br>1 : id : $id - denomination : $denomination";
				//on recherche l'affectation
/*				$requete_affectation = "SELECT * FROM materiels_affectations WHERE materiels_affectations.id_affectation = '".$affectation_materiel."';";
				$resultat_affectation = mysql_query($requete_affectation);
				$ligne_affectation = mysql_fetch_object($resultat_affectation);
*/				$affectation = $ligne_affectation->intitule_affectation;
				echo "<TR class = \"new\">";
					echo "<TD align = \"center\">";
						echo $id;
					echo "</TD>";
					echo "<TD>";
						echo $denomination;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $categorie;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $origine;
					echo "</TD>";
					echo "<TD>";
						echo $intitule_affectation;
					echo "</TD>";
					echo "<TD align = \"center\">";
					//il faut afficher les 11 états et permettre de les changer
					// on cherche d'abord l'intitulé
					$requete_intitule = "SELECT intitule_etat FROM materiels_etats WHERE id_etat = '".$id_etat."'";
					$resultat_intitule = mysql_query($requete_intitule);
					$ligne_intitule = mysql_fetch_object($resultat_intitule);
					$intitule_etat = $ligne_intitule->intitule_etat;
					
					if ($autorisation_gestion_materiels == 1)
					{
						//echo "$id_etat&nbsp;$intitule_etat<br>";
						if ($id_etat <> "1")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=1&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"demand&eacute;\">1&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"demand&eacute;\"><FONT COLOR = \"#000000\"><B><big>1&nbsp;</big></B></FONT></a>";
						}
						if ($id_etat <> "2")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=2&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"command&eacute;\">2&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"command&eacute;\"><FONT COLOR = \"#000000\"><B><big>2&nbsp;</big></B></FONT></a>";
						}
						
						if ($id_etat <> "3")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=3&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"livr&eacute;\">3&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"livr&eacute;\"><FONT COLOR = \"#000000\"><B><big>3&nbsp;</big></B></FONT></a>";
						}
						
						if ($id_etat <> "4")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=4&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"en pr&eacute;ration;\">4&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"en pr&eacute;paration\"><FONT COLOR = \"#000000\"><B><big>4&nbsp;</big></B></FONT></a>";
						}
										
						
						if ($id_etat <> "5")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=5&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"disponible\">5&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"disponible\"><FONT COLOR = \"#000000\"><B><big>5&nbsp;</big></B></FONT></a>";
						}
						
						if ($id_etat <> "6")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=6&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"affect&eacute; en interne\">6&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"affect&eacute; en interne\"><FONT COLOR = \"#000000\"><B><big>6&nbsp;</big></B></FONT></a>";
						}
						if ($id_etat <> "7")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=7&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"affect&eacute; &agrave; l'ext&eacute;rieur\">7&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"affect&eacute; &agrave; l'ext&eacute;rieur\"><FONT COLOR = \"#000000\"><B><big>7&nbsp;</big></B></FONT></a>";
						}
						
						if ($id_etat <> "8")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=8&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"en pr&ecirc;t\">8&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"en panne\"><FONT COLOR = \"#000000\"><B><big>8&nbsp;</big></B></FONT></a>";
						}


						if ($id_etat <> "9")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=9&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"en panne\">9&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"en panne\"><FONT COLOR = \"#000000\"><B><big>9&nbsp;</big></B></FONT></a>";
						}
						if ($id_etat <> "10")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=10&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"remis&eacute;\">10&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"remis&eacute;\"><FONT COLOR = \"#000000\"><B><big>10&nbsp;</big></B></FONT></a>";
						}
						if ($id_etat <> "11")
						{
							echo "<A href=\"materiels_gestion_commandes.php?actions=O&amp;a_faire=afficher_commande&amp;changer_etat=O&amp;id=$id&amp;id_etat=11&amp;id_cde=$id_cde&amp;rechercher=$rechercher&amp;dans=$dans\" target=\"body\" title=\"perdu\">11&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"perdu\"><FONT COLOR = \"#000000\"><B><big>11&nbsp;</big></B></FONT></a>";
						}
						echo "</TD>";
					}
					else
					{
						echo $intitule_etat;
					}
					echo "</TD>";
					//Les actions
					if ($autorisation_gestion_materiels == 1)
					{
						echo "<TD nowrap class = \"fond-actions\">";
						//echo "<A HREF = \"materiels_gestion_commandes_affiche_commande.php?actions=O&amp;a_faire=afficher_commande&amp;id_commande=$id_commande&amp;indice=$indice&amp;traitement=$traitement\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter\" title=\"Consulter la commande\"></A>";
						echo "<A HREF = \"materiels_gestion_commandes.php?actions=O&amp;a_faire=supprimer_article&amp;id=$id&amp;indice=$indice&amp;traitement=$traitement&amp;rechercher=$rechercher&amp;dans=$dans\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer l'article\"></A>";
						echo "</TD>";
					}
				echo "</TR>";
			} //Fin while $ligne
		echo "</table>";	
	} //Fin if num_rows >0
	else
	{
		echo "<h2>Pas d'articles pour cette commande</h2>";
	}

?>
