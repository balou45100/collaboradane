<?php
	//Transformation de la date de création extraite pour l'affichage
	$aujourdhui_jour = date('d',$date_rappel_a_afficher);
	$aujourdhui_mois = date('m',$date_rappel_a_afficher);
	$aujourdhui_annee = date('Y',$date_rappel_a_afficher);
	
	// On récupère l'intitulé du droit
	$intitule_droit = lecture_champ("droits","nom_droit","id_droit",$id_droit);

	echo "<h2>Attribution de droits</h2>";
	echo "<form method=\"get\" action=\"gg_gestion_droits.php\" name=\"AttributionDroits\">";
		echo "<table>";
			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Intitul&eacute; du droit&nbsp:&nbsp;</td>";
				echo "<td>$intitule_droit</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Membre de la plateforme&nbsp;:&nbsp;</td>";
					$query_responsable = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
					$results_responsable = mysql_query($query_responsable);
				echo "<td>";
					echo "<select size=\"1\" name=\"id_util\">";
					echo "<option selected value=\"0\">Faire un choix</option>";
					while ($ligne_responsable = mysql_fetch_object($results_responsable))
					{
						$id_responsable = $ligne_responsable->ID_UTIL;
						$nom = $ligne_responsable->NOM;
						$prenom = $ligne_responsable->PRENOM;
						if ($id_responsable <> $id_util)
						{
							echo "<OPTION VALUE = \"".$id_responsable."\">".$nom." - ".$prenom."</OPTION>";
						}
					}
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Niveau&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select size=\"1\" name=\"niveau_droit\">";
						echo "<option selected value=\"1\">simple utilisateur</option>";
						echo "<option value=\"2\">avec certains droits</option>";
						echo "<option value=\"3\">tous les droits</option>";
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";

		echo "</table>";
		//echo "<a href=\"dossier_index.php\" title=\"Retour au module de gestion de dossier\" img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/retour.png\"></a>";
		
		// Les variables à retransmettre ///////////
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_droits\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_droit\" NAME = \"id_droit\">";

		// Boutons de validation et retour ////////
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"gg_gestion_droits.php?\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
					echo "</tr>";
			echo "</table>";
		echo "</div>";

	
	
	echo "</form>";
