<?php
	echo "<form method=\"post\" action = \"abo_affichage_abo.php\">";
		echo "<table>";
			echo "<TR>";
				echo "<TD>Nom de la publication&nbsp;:&nbsp;</TD>";
				echo "<TD><input type=\"text\" name=\"nom_mag\"/></TD>";
			echo "</TR>";
			echo "<tr>";
				echo "<td>&Eacute;diteur&nbsp;:&nbsp;</td>";
				echo "<td>";
					$requete_recup="SELECT * FROM repertoire WHERE presse_specialisee='1' ORDER BY societe ;";
					$result_recup=mysql_query($requete_recup);

					echo "<select name=\"soc\">";
						while($ligne_recup=mysql_fetch_assoc($result_recup)){
							$soc=$ligne_recup["societe"];
							$idsoc=$ligne_recup["No_societe"];
							$ville=$ligne_recup["ville"];

							echo "<option value=\"$idsoc\">$soc - $ville</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<TR>";
				echo "<TD>Date de d&eacute;but d'abonnement&nbsp;:&nbsp;</TD>";
				echo "<td>";
					echo "&nbsp;<a href=\"javascript:popupwnd('calendrier.php?idcible=date_debut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
					echo "<input type=\"text\" id=\"date_debut\" size=\"10\" name=\"datedeb\" value=\"\">";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<TD>Date de fin d'abonnement&nbsp;:&nbsp;</TD>";
				echo "<td>";
					echo "&nbsp;<a href=\"javascript:popupwnd('calendrier.php?idcible=date_fin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
					echo "<input type=\"text\" id=\"date_fin\" size=\"10\" name=\"datefin\" value=\"\">";
				echo "</td>";
			echo "<TR>";
				echo "<TD>p&eacute;riodicit&eacute;&nbsp;:&nbsp;</TD>";
				echo "<TD>";
					echo "<select name=\"period\">";
						echo "<option selected value=\"mensuel\">mensuel (tous les mois)</option>";
						echo "<option value=\"quotidien\">quotidien (tous les jours)</option>";
						echo "<option value=\"hebdomadaire\">hebdomadaire (toutes les semaines)</option>";
						echo "<option value=\"bimensuel\">bimensuel (2 fois par mois)</option>";
						echo "<option value=\"bimestriel\">bimestriel (tous les 2 mois)</option>";
						echo "<option value=\"trimestriel\">trimestriel (tous les 3 mois)</option>";
						echo "<option value=\"semestriel\">semestriel (tous les 6 mois)</option>";
						echo "<option value=\"annuel\">annuel (tous les ans)</option>";
					echo "</select>";
				echo "</TD>";
			echo "</TR>";

			echo "<TR>";
				echo "<TD>prix&nbsp;:&nbsp;</TD>";
				echo "<TD><input type=\"text\" name=\"prix\"/> </TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD>Nombre de num&eacute;ros&nbsp;:&nbsp;</TD>";
				echo "<TD>";
					echo "<select name =\"nb\">";

					for($j = 1; $j<366; ++$j)
					{
						echo "<option value='".$j."'>$j</option>";
					}

					echo "</select>";
				echo "</TD>";
			echo "</TR>";

			$query_categories = "SELECT * FROM abo_categorie ORDER BY intitule_categ";
			$results_categories = mysql_query($query_categories);
			$no = mysql_num_rows($results_categories);
	
			echo "<tr>";
				echo "<td>";
					echo "Choisir les cat&eacute;gories&nbsp;:&nbsp;";
				echo "</td>";
				echo "<td>";
					echo "<SELECT size = \"4\" NAME = \"id_categorie[]\" multiple>";
					while ($ligne_categories = mysql_fetch_object($results_categories))
					{
						$idcateg = $ligne_categories->idcateg;
						$intitule_categ = $ligne_categories->intitule_categ;
						
						//On regarde si la catégorie est déjà affectée à la tâche
						$requete_categ_tache = "SELECT * FROM taches_categories WHERE id_tache = '".$id."' AND id_categorie = '".$id_categ."'";
						$resultat_categ_tache = mysql_query($requete_categ_tache);
						$num_rows = mysql_num_rows($resultat_categ_tache);
						
						if ($num_rows == 0)
						{
							echo "<OPTION VALUE = \"".$idcateg."\">".$intitule_categ."</OPTION>";
						}
					}
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"abo_affichage_abo.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
					echo "</tr>";
			echo "</table>";
		echo "</div>";
		echo "<input type=\"hidden\" name=\"action\" value=\"O\" />";
		echo "<input type=\"hidden\" name=\"a_faire\" value=\"enreg_abonnement\" />";
	echo "</form>";
