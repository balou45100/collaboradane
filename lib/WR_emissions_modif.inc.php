<?php
////// Initialisation des variables ///////////////////////////////////////////////////////
	//echo "<br />choixEmission : $choixEmission";
	
	$requete="SELECT * FROM WR_Emissions WHERE idEmission = '$choixEmission'";
	
	//echo "<br />requete : $requete<br />";
	
	$resultat=mysql_query($requete);
	//$num_rows = mysql_num_rows($resultat);
	$ligne = mysql_fetch_object($resultat);
	$idEmission = $ligne->idEmission;
	$EmissionTitre = $ligne->EmissionTitre;
	$EmissionDateDiffusion = $ligne->EmissionDateDiffusion;
	$EmissionHeureDiffusionDebut = $ligne->EmissionHeureDiffusionDebut;
	$EmissionHeureDiffusionFin = $ligne->EmissionHeureDiffusionFin;
	$EmissionLieuEnregistrement = $ligne->EmissionLieuEnregistrement;
	$EmissionRemarques = $ligne->EmissionRemarques;
	
	/*
	echo "<br />idEmission : $idEmission";
	echo "<br />EmissionTitre : $EmissionTitre";
	echo "<br />EmissionDateDiffusion : $EmissionDateDiffusion";
	echo "<br />EmissionHeureDiffusionDebut : $EmissionHeureDiffusionDebut";
	echo "<br />EmissionHeureDiffusionFin : $EmissionHeureDiffusionFin";
	echo "<br />EmissionLieuEnregistrement : $EmissionLieuEnregistrement";
	echo "<br />EmissionRemarques : $EmissionRemarques";
	*/
	//On vérifie s'il faut supprimer une catégoprie
	$supprimer_categorie = $_GET['supprimer_categorie'];

	IF (ISSET($supprimer_categorie))
	{
		$idEmissionsCategorie = $_GET['idEmissionsCategorie'];
		//echo "<br />Je dois supprimer la cat&eacute;gorie $idEmissionsCategorie";
		
		//On supprime la catégorie de la table WR_Emissions_EmissionsCategories
		$requete_suppression = "DELETE FROM WR_Emissions_EmissionsCategories WHERE idEmission =".$choixEmission." AND idEmissionsCategorie = $idEmissionsCategorie;";
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
		else
		{
			echo "<h2>La classification a &eacute;t&eacute; supprim&eacute;</h2>";
		}

	}
	echo "<FORM ACTION = \"WR_emissions.php\" METHOD = \"POST\">";
		echo "<!--h2>Les d&eacute;tails &agrave; renseigner pour cr&eacute;er une nouvelle &eacute;mission</h2-->";
		echo "<TABLE width=\"95%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionTitre \" name=\"EmissionTitre\" size=\"78\">&nbsp;&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";

			echo "<td class = \"etiquette\">Date de l'&eacute;mission&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" id=\"EmissionDateDiffusion\"  name=\"EmissionDateDiffusion\" value=\"$EmissionDateDiffusion\">";
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=EmissionDateDiffusion&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
			echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Horaires&nbsp;:&nbsp;</td>";
				echo "<td>
					de&nbsp;<input type=\"text\" value = \"$EmissionHeureDiffusionDebut\" name = \"EmissionHeureDiffusionDebut\" size=\"10\" title = \"ex : 15h30\">
					&nbsp;&agrave;&nbsp;<input type=\"text\" value = \"$EmissionHeureDiffusionFin\" name = \"EmissionHeureDiffusionFin\" size=\"10\" title = \"ex : 18h45\">&nbsp;
				</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Lieu d'enregistrement&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionLieuEnregistrement\" name = \"EmissionLieuEnregistrement\" size=\"78\">&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Classification&nbsp;:&nbsp;</td>";
				echo "<td>";
					//On affiche les catégories existantes
					$requete_categs = "SELECT * FROM WR_Emissions_EmissionsCategories AS EEC, WR_EmissionsCategories AS EC WHERE EEC.idEmissionsCategorie = EC.idEmissionsCategorie AND EEC.idEmission = '".$choixEmission."' ORDER BY EmissionsCategorieNom";
					
					//echo "<br />requete : $requete_categs<br />";
					
					$resultat_categs = mysql_query($requete_categs);
					$num_rows = mysql_num_rows($resultat_categs);
					
					if (mysql_num_rows($resultat_categs))
					{
						echo "appartient d&eacute;j&agrave; &agrave;&nbsp;:&nbsp;";
						while ($ligne_categs=mysql_fetch_object($resultat_categs))
						{
							$EmissionsCategorieNom = $ligne_categs->EmissionsCategorieNom;
							$idEmissionsCategorie = $ligne_categs->idEmissionsCategorie;
							echo "$EmissionsCategorieNom&nbsp<A HREF = \"WR_emissions.php?action=O&amp;a_faire=modif_emission&amp;supprimer_categorie=O&amp;choixEmission=$choixEmission&amp;idEmissionsCategorie=$idEmissionsCategorie\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A>&nbsp;";
						}
					}

					echo "<br /><select size=\"5\" name=\"EmissionCategories[]\" multiple>";
						//Selection des utilisateurs qui ne sont PAS dans le groupe actuel
						$requete = "SELECT * FROM WR_EmissionsCategories ORDER BY EmissionsCategorieNom";
						
						//echo "<br />$requete";
						
						$resultat = mysql_query($requete);
						$num_rows = mysql_num_rows($resultat);
						
						if (mysql_num_rows($resultat))
						{	
							while ($ligne=mysql_fetch_array($resultat))
							{
								echo"<option value=\"".$ligne[0]."\">".$ligne[1]."</option>";
							}
						}
					echo"</select>";
				echo "</td>";
			echo "</tr>";
/*
			echo "<tr>";
				echo "<td class = \"etiquette\">Lieu de stockage des ressources&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" value = \"$EmissionDossierStockage\" name=\"EmissionDossierStockage\" size=\"78\">&nbsp;</td>";
			echo "</tr>";
*/
			echo "<tr>";
				echo "<TD class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>";
				echo "<TD><textarea rows=\"4\" name=\"EmissionRemarques\" cols=\"100\">$EmissionRemarques</textarea></TD>";
			echo "</tr>";
		echo "</table>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"maj_emission\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$choixEmission\" NAME = \"choixEmission\">";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"WR_emissions.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
					echo "</TD>";
					echo "</tr>";
			echo "</table>";
		echo "</div>";
	echo "</FORM>";
	$affichage = "N";
?>
