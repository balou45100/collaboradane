<?php
	session_start ();
	$travail_sur_fonction = $_GET['travail_sur_fonction'];
	$id_exercice = $_GET['id_exercice'];
/*
	echo "<br>suppression_fonction : $suppression_fonction";
	echo "<br>id : $id";
	echo "<br>id_exercice : $id_exercice";
	echo "<br /><br />autorisation_personnes_ressources : $autorisation_personnes_ressources";
	echo "<br>niveau_droits : $niveau_droits";
*/

	switch ($travail_sur_fonction)
	{
		case "supp_fonction" :
			include ("personnes_ressources_gestion_suppression_fonction.inc.php");
			$affichage = "N";
		break;

		case "confirm_supp_fonction" :
			$requete_suppression = "DELETE FROM fonctions_des_personnes_ressources WHERE id =".$id_exercice.";";
			$resultat_suppression = mysql_query($requete_suppression);
			if(!$resultat_suppression)
			{
				echo "<h2>Erreur</h2>";
			}
			else
			{
				echo "<h2>La fonction a &eacute;t&eacute; supprim&eacute;e.</h2>";
			}
		break;

		case "modif_fonction" :
			echo "<h1>Modification d'une fonction</h1>";
			include ("personnes_ressources_gestion_modif_fonction.inc.php");
			$affichage = "N";
		break;

		case "maj_fonction" :
			echo "<h1>Mise &agrave; jour d'une fonction</h1>";
			$bouton_envoyer_modif = $_GET['bouton_envoyer_modif'];
			$intitule_fonction_a_modifier = $_GET['intitule_fonction_a_modifier'];
			$annee_fonction_a_modifier = $_GET['annee_fonction_a_modifier'];
			$rne_a_modifier = $_GET['rne_a_modifier'];
			if($annee_en_cours < 2015) // Système des HSA
			{
				$nbr_hsa_a_modifier = $_GET['nbr_hsa_a_modifier'];
				$hse_exercice = $_GET['hse_exercice'];
			}
			else
			{
				$taux_imp_exercice = $_GET['taux_imp_exercice'];
				//On récupère le montant correspondant
				$somme_imp = lecture_champ('imp','montant','taux',$taux_imp_exercice);
			}
			$observation_a_modifier = $_GET['observation'];
			//echo "<br>intitule_fonction_a_modifier : $intitule_fonction_a_modifier";
			if ($hse_exercice == "Oui")
			{
				$nbr_hsa_a_modifier = number_format($nbr_hsa_a_modifier/36,2);
			}
			//echo "id_exercice : $id_exercice";
			if ($bouton_envoyer_modif == "Enregistrer les modifications")
			{
				//echo "<br>J'enregistre";
					//Il faut récupérer le domaine budgétaire de la fonction saisie
					$requete_domaine_budget="SELECT DISTINCT domaine_budget FROM fonctions_personnes_ressources WHERE intitule_fonction = '".$intitule_fonction_a_modifier."' AND annee = '".$annee_fonction_a_modifier."'";
					
					//echo "<br />$requete_domaine_budget";
					
					$result_domaine_budget=mysql_query($requete_domaine_budget);
					$ligne_domaine_budget=mysql_fetch_object($result_domaine_budget);
					$id_domaine_budget=$ligne_domaine_budget->domaine_budget;
					//echo "<br>id_domaine_budget : $id_domaine_budget";

				if($annee_en_cours < 2015) // Système des HSA
				{
					$requete_maj = "UPDATE fonctions_des_personnes_ressources SET 
						`fonction` = '".$intitule_fonction_a_modifier."',
						`annee` = '".$annee_fonction_a_modifier."',
						`rne` = '".$rne_a_modifier."',
						`nbr_hsa` = '".$nbr_hsa_a_modifier."',
						`domaine_budget` = '".$id_domaine_budget."',
						`observation` = '".$observation_a_modifier."'
						 WHERE id = '".$id_exercice."' ;";
				}
				else //Système des IMP
				{
					$requete_maj = "UPDATE fonctions_des_personnes_ressources SET 
						`fonction` = '".$intitule_fonction_a_modifier."',
						`annee` = '".$annee_fonction_a_modifier."',
						`rne` = '".$rne_a_modifier."',
						`somme_imp` = '".$somme_imp."',
						`domaine_budget` = '".$id_domaine_budget."',
						`observation` = '".$observation_a_modifier."'
						 WHERE id = '".$id_exercice."' ;";
				}
				
				//echo "<br />requete_maj : $requete_maj";

				$result_maj = mysql_query($requete_maj);
				if (!$result_maj)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
				else
				{
					echo "<h2>La fonction a bien &eacute;t&eacute; modifi&eacute;e</h2>";
				}

				
			}
			//$affichage = "N";
		break;
	} // Fin switch travail_sur_fonction


	if ($affichage <> "N")
	{
		//Il faut récupérer les informations concernant la personne
		$requete_personne="SELECT * FROM personnes_ressources_tice WHERE id_pers_ress = '".$id."'";
		$result_personne=mysql_query($requete_personne);
		$num_rows = mysql_num_rows($result_personne);
		//echo "<br>Nombre d'enregistrements retourné : $num_rows";
		$ligne_personne=mysql_fetch_object($result_personne);
		$id_pers_ress = $ligne_personne->id_pers_ress;
		$civil = $ligne_personne->civil;
		$nom = $ligne_personne->nom;
		$prenom = $ligne_personne->prenom;
		$codetab = $ligne_personne->codetab;
		$id_discipline = $ligne_personne->id_discipline;
		$id_poste = $ligne_personne->id_poste;
		$mel = $ligne_personne->mel;
		if ($_SESSION['origine'] == "tb")
		{
			echo "<form id=\"monForm\" action=\"test.php\" method=\"get\">";
		}
		else
		{
			echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">";
		}
		echo "<fieldset>
		<legend>Renseignements sur la personne ressource</legend>
			<p>
				<label for=\"form_id\">ID&nbsp;:&nbsp;</label>
				<a for = \"form_id_valeur\">&nbsp;$id</a>
			</p>
			<p>
				<label for=\"form_nom\">Nom&nbsp;:&nbsp;</label>
				<a for = \"form_nom_valeur\">&nbsp;$nom</a>
				
			</p>
			<p>
				<label for=\"form_prenom\">Pr&eacute;nom&nbsp;:&nbsp;</label>
				<a for = \"form_prenom_valeur\">&nbsp;$prenom</a>
				
			</p>";
			if ($id_discipline <>"")
			{
				//On récupère l'intiulé de la discipline
				$requete_intitule_discipline="SELECT DISTINCT discipline FROM discipline WHERE id_discipline = '".$id_discipline."'";
				$result_intitule_discipline=mysql_query($requete_intitule_discipline);
				$ligne_intitule_discipline=mysql_fetch_object($result_intitule_discipline);
				$intitule_discipline=$ligne_intitule_discipline->discipline;
				echo "<p>
					<label for=\"form_discipline\">Discipline&nbsp;:&nbsp;</label>
					<a for = \"form_discipline_valeur\">&nbsp;$intitule_discipline</a>
				</p>";
			}
			if ($id_poste <>"")
			{
				//On récupère l'intiulé du poste
				$requete_intitule_poste="SELECT DISTINCT poste FROM postes WHERE id_poste = '".$id_poste."'";
				$result_intitule_poste=mysql_query($requete_intitule_poste);
				$ligne_intitule_poste=mysql_fetch_object($result_intitule_poste);
				$intitule_poste=$ligne_intitule_poste->poste;
				echo "<p>
					<label for=\"form_poste\">Poste&nbsp;:&nbsp;</label>
					<a for = \"form_poste_valeur\">&nbsp;$intitule_poste</a>
				</p>";
			}
			echo "<p>";
				echo "<label for=\"form_mel\">M&eacute;l&nbsp;:&nbsp;</label>
				<a for = \"form_mel_valeur\">&nbsp;$mel</a>";
			echo "</p>
		</fieldset>
		<fieldset>
		<legend>Renseignements sur l'&eacute;cole ou l'EPLE de rattachement</legend>
			<p>
				<label for=\"form_rne\">RNE&nbsp;:&nbsp;</label>
				<a for = \"form_rne_valeur\">&nbsp;$codetab</a>
				
			</p>";
			//On récupère les autres informations de l'étab
			$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements WHERE RNE = '".$codetab."'";
			$result_etabs=mysql_query($requete_etabs);
			$ligne=mysql_fetch_object($result_etabs);
			$rne = $ligne->RNE;
			$type = $ligne->TYPE;
			$nom = $ligne->NOM;
			$ville = $ligne->VILLE;
			echo "<p>
				<label for=\"form_type\">Type&nbsp;:&nbsp;</label>
				<a for = \"form_type_valeur\">&nbsp;$type</a>
			</p>
			<p>
				<label for=\"form_nom\">D&eacute;nomination&nbsp;:&nbsp;</label>
				<a for = \"form_nom_valeur\">&nbsp;$nom</a>
			</p>
			<p>
				<label for=\"form_ville\">Ville&nbsp;:&nbsp;</label>
				<a for = \"form_ville_valeur\">&nbsp;$ville</a>
			</p>
		</fieldset>
		<p>";
			//<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer le matériel\"/>
			if ($_SESSION['origine'] == "tb")
			{
				echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><center><input type=submit Value = Retour></center></a>";
			}
			else
			{
				echo "<center><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner à la liste\"/></center>";
			}
			echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
		</p>
		<!--fieldset>
		<legend>Renseignements sur les différentes fonctions en tant que personne ressource</legend-->";
		echo "</form>";
		if ($_SESSION['origine'] == "tb")
		{
			echo "<form action=\"test.php\" method=\"get\">";
		}
		else
		{
			echo "<form action=\"personnes_ressources_gestion.php\" method=\"get\">";
		}
			//echo "<p>";
				//echo "<label for=\"form_annee\">Année/Fonction&nbsp;:&nbsp;</label>";
				$requete_fonctions = "SELECT * FROM fonctions_des_personnes_ressources WHERE id_pers_ress = '".$id."' ORDER BY annee DESC";
				$resultat_fonctions = mysql_query($requete_fonctions);
				echo "<br><table border = \"1\">";
				echo "<caption>Renseignements sur les différentes fonctions en tant que personne ressource</caption>";
				
				if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
				{
					echo "<colgroup>";
						echo "<col width=\"8%\">";
						echo "<col width=\"35%\">";
						echo "<col width=\"20%\">";
						echo "<col width=\"7%\">";
						echo "<col width=\"10%\">";
						echo "<col width=\"20%\">";
					echo "</colgroup>";
				}
				elseif ($autorisation_personnes_ressources == "1" AND $niveau_droits == "2")
				{
					echo "<colgroup>";
						echo "<col width=\"20%\">";
						echo "<col width=\"50%\">";
						echo "<col width=\"20%\">";
						echo "<col width=\"10%\">";
					echo "</colgroup>";
				}
				elseif ($autorisation_personnes_ressources == "1")
				{
					echo "<colgroup>";
						echo "<col width=\"20%\">";
						echo "<col width=\"60%\">";
						echo "<col width=\"20%\">";
					echo "</colgroup>";
				}
				
				echo "<th bgcolor = \"$bg_color1\">ann&eacute;</th>";
				echo "<th bgcolor = \"$bg_color1\">fonction</th>";
				echo "<th bgcolor = \"$bg_color1\">exerc&eacute;e dans</th>";
				
				if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
				{
					echo "<th bgcolor = \"$bg_color1\">HSA</th>";
					echo "<th bgcolor = \"$bg_color1\">IMP (en &euro;)</th>";
					echo "<th bgcolor = \"$bg_color1\">actions</th>";
				}
				elseif ($autorisation_personnes_ressources == "1" AND $niveau_droits == "2")
				{
					echo "<th bgcolor = \"$bg_color1\">HSA</th>";
					echo "<th bgcolor = \"$bg_color1\">IMP</th>";
				}
				
				while ($ligne_fonctions = mysql_fetch_object($resultat_fonctions))
				{
					$annee_exercice = $ligne_fonctions->annee;
					$fonction_exercice = $ligne_fonctions->fonction;
					$rne_exercice = $ligne_fonctions->rne;
					$id_exercice = $ligne_fonctions->id;
					$nbr_hsa_exercice = $ligne_fonctions->nbr_hsa;
					$somme_imp = $ligne_fonctions->somme_imp;
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "&nbsp;$annee_exercice";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;$fonction_exercice";
						echo "</td>";
						echo "<td align = \"center\">";
							affiche_info_bulle($rne_exercice,"RESS",0);
						echo "</td>";

						if ($autorisation_personnes_ressources == "1" AND $niveau_droits > 1)
						{
							echo "<td align = \"center\">";
								if ($nbr_hsa_exercice <> 0)
								{
									echo "&nbsp;$nbr_hsa_exercice";
								}
								else
								{
									echo "&nbsp;";
								}
							echo "</td>";
							echo "<td align = \"center\">";
								if ($somme_imp <> 0)
								{
									echo "&nbsp;$somme_imp";
								}
								else
								{
									echo "&nbsp;";
								}
							echo "</td>";
						}
						if ($autorisation_personnes_ressources == "1" AND $niveau_droits > 2)
						{
							echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=consulter_personne&amp;travail_sur_fonction=modif_fonction&amp;id=".$id."&amp;id_exercice=".$id_exercice."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" border = \"0\" title=\"Modifier cette fonction\"></A>";
								echo "&nbsp;<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=consulter_personne&amp;travail_sur_fonction=supp_fonction&amp;id=".$id."&amp;id_exercice=".$id_exercice."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" border = \"0\" title=\"Supprimer cette fonction\"></A>";
							echo "</td>";
						}
					echo "</tr>";
				} //Fin while $ligne_fonctions
				echo "</table>";

			//echo "</p>
		//echo "</fieldset>";
		//echo "<p>";
			//<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer le matériel\"/>
			if ($_SESSION['origine'] == "tb")
			{
				echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><input type=submit Value = Retour></a>";
			}
			else
			{		
				echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner à la liste\"/>";
			}
			echo"<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">";
		//echo "</p>";
		echo "</form>";
	} // Fin if affichage <> "N"

?>
