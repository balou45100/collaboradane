<?php
	echo "<h2>Ajout d'un projet</h2>";
	
		echo "<form action=\"cardie_gestion_projets.php\" method=\"post\">";

		//Partie ECL
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">ECL&nbsp;:&nbsp;</td>";
				echo "<td>";
					//Requête pour selectionner tous les établissements
					$query_etab = "SELECT * FROM etablissements";
					$results_etab = mysql_query($query_etab);
					if(!$results_etab)
					{
						echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requ&egrave;te
					$num_results_etab = mysql_num_rows($results_etab);

					echo "<select name = rne required>";
						echo "<option selected = \"null\" VALUE = \"null\"></option>";
						$res_etab = mysql_fetch_row($results_etab);
						for ($j = 0; $j < $num_results_etab; ++$j)
						{
							echo "<option VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>";
							$res_etab = mysql_fetch_row($results_etab);
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		//Partie projet

			echo "<table width=\"85%\">";
				echo "<caption></caption>";
				echo "<tr>";
					echo "<td class = \"etiquette\">INTITULE&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\"><input type=\"text\" VALUE = \"\" size = \"75\" name=\"intitule_projet\" required/></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td class = \"etiquette\">ANN&Eacute;E D&Eacute;BUT&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"annee\">";
							echo "<option selected value=\"$annee_en_cours\">$annee_en_cours</option>";
							for($annee = $annee_en_cours-3; $annee < $annee_en_cours+3; $annee++ )
							{
								echo "<option value=\"$annee\">$annee</option>";
							}
						echo "</select>";
					echo "</td>";

					//echo "<input type=\"text\" VALUE = \"$annee_projet\" size = \"75\" name=\"intitule_projet\" /></td>";
					echo "<td class = \"etiquette\">D&Eacute;CISION COMMISSION&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"decision_commission\">";
							echo "<option value=\"\">aucune</option>";
							echo "<option value=\"autonome\">autonome</option>";
							echo "<option value=\"poursuite\">poursuite</option>";
							echo "<option value=\"retenu\">retenu</option>";
						echo "</select>";
					echo "</td>";

					echo "<td class = \"etiquette\">TYPE ACCOMPAGNEMENT&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select size=\"1\" name=\"type_accompagnement\">";
							echo "<option value=\"\">pas encore d&eacute;fini</option>";
							echo "<option value=\"in situ\">in situ</option>";
							echo "<option value=\"a distance\">a distance</option>";
							echo "<option value=\"recherche\">par la recherche</option>";
							echo "<option value=\"groupe developpement\">par groupe de d&eacute;veloppement</option>";
							echo "<option value=\"experitheque\">dans exp&eacute;rith&egrave;que</option>";
							echo "<option value=\"partenarial\">partenarial</option>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				
				echo "<tr>";
					echo "<td class = \"etiquette\">GROUPE DE D&Eacute;VELOPPEMENT (si applicable)&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
					
						//on récupère les valeurs dans la table cardie_type_groupe_developpement
						
						$res=mysql_query ("SELECT * FROM cardie_type_groupe_developpement WHERE actif = 'O' ORDER BY intitule_TGD");
						$nbr = mysql_num_rows($res);
						
						if(!$res)
						{
							echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
							mysql_close();
							exit;
						}

						echo "<select size=\"1\" name=\"type_groupe_developpement\">";
							echo "<option selected value=\"null\">faire un choix</option>";
							while ($ligne = mysql_fetch_object($res))
							{
								$id_TGD = $ligne->id_TGD;
								$intitule_TGD = $ligne->intitule_TGD;
								echo "<option value=\"$id_TGD\">$intitule_TGD</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td class = \"etiquette\">DESCRIPTION&nbsp;:&nbsp;</td>";
					echo "<td colspan = \"5\">";
						echo "<textarea name=\"description\" rows=\"6\" cols=\"75\">$description</textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'description' );
								</script>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";

			//Boutons retour et enregistrement
			echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le projet\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_projet\" NAME = \"a_faire\">";
	echo "</form>";


?>
