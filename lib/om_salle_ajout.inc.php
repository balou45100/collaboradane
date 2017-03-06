<?php
	echo "<form method=\"post\" action=\"om_affichage_reunion.php\">";
		echo "<h2>Saisie d'une salle pour la r&eacute;union $idreunion</h2>";

/*
		echo "<br />choix-structure : $choix_structure";
		echo "<br />idreunion : $idreunion";
		echo "<br />rne : $rne";
		echo "<br />no_societe : $no_societe";
*/
		If ($choix_structure <> "O")
		{
			echo "<table>";
				echo "<tr>";
					echo "<td class = \"etiquette\">Choisir une salle dans une structure acad&eacute;d&eacute;mique&nbsp:&nbsp;</td>";
					echo "<td>";
						$requete1 = "SELECT * FROM etablissements ORDER BY RNE";
						//echo "<br />$requete1";
						$resultat1 = mysql_query($requete1);
						$ligne1 = mysql_fetch_assoc($resultat1);
						$num_rows = mysql_num_rows($resultat1);

						echo "<td><select size=\"1\" name=\"rne\">";

						if (mysql_num_rows($resultat1))
						{
							echo "<option selected value=\"-1\">Faire un choix</option>";
							while ($ligne1=mysql_fetch_object($resultat1))
							{
								$rne=$ligne1->RNE;
								$type=$ligne1->TYPE;
								$secteur=$ligne1->PUBPRI;
								$nom=$ligne1->NOM;
								$ville=$ligne1->VILLE;
								echo "<option value=\"$rne\">$rne $type $secteur $nom $ville</option>";
							}
						}
						echo "</select></td>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";

			echo "<h1>OU</h1>";
			
			echo "<table>";
				echo "<tr>";
					echo "<td class = \"etiquette\">Choisir une salle dans une structure priv&eacute;e&nbsp:&nbsp;</td>";
					echo "<td>";
						$requete2 = "SELECT * FROM repertoire ORDER BY societe";
						//echo "<br />$requete2";
						$resultat2 = mysql_query($requete2);
						$ligne2 = mysql_fetch_assoc($resultat2);
						$num_rows = mysql_num_rows($resultat2);

						echo "<td><select size=\"1\" name=\"no_societe\">";

						if (mysql_num_rows($resultat2))
						{
							echo "<option selected value=\"-1\">Faire un choix</option>";
							while ($ligne2=mysql_fetch_object($resultat2))
							{
								$no_societe=$ligne2->No_societe;
								$societe=$ligne2->societe;
								$ville=$ligne2->ville;
								echo "<option value=\"$no_societe\">$societe $ville</option>";
							}
						}
						echo "</select></td>";
						
					echo "</td>";
				echo "</tr>";
			echo "</table>";

			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Valider_choix\" title=\"Valider le choix\" border=\"0\" type=image Value=\"Valider\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Valider votre choix</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";
			echo "<input type=hidden name=\"choix_structure\" value=\"O\"/>";
		}
		else
		{
			echo "<table>";
				echo "<tr>";
					if ($rne <> "-1")
					{
						//On récupère les informations de la structure académique
						$requete1 = "SELECT * FROM etablissements WHERE RNE = '".$rne."'";
						//echo "<br />$requete1";
						$resultat1 = mysql_query($requete1);
						$ligne1=mysql_fetch_object($resultat1);
						$type=$ligne1->TYPE;
						$secteur=$ligne1->PUBPRI;
						$nom=$ligne1->NOM;
						$ville=$ligne1->VILLE;

						
						//On récupère les salles de cette structure
						$requete2 = "SELECT * FROM om_salle WHERE idstructure = '".$rne."' ORDER BY intitule_salle";
						
						//echo "<br />$requete2";
						
						$resultat2 = mysql_query($requete2);
						$nombre_salle = mysql_num_rows($resultat2);
						
						//echo "<br />nombre_salle : $nombre_salle";
						
						if ($nombre_salle >0)
						{
							echo "<h2>Les salles disponibles pour <br />$rne $type $secteur $nom $ville</h2>";
							echo "<td>";
								if (mysql_num_rows($resultat2))
								{
									while ($ligne21=mysql_fetch_object($resultat2))
									{
										$idsalle=$ligne21->idsalle;
										$intitule_salle=$ligne21->intitule_salle;
										$capacite=$ligne21->capacite;
										
										echo "<input type=\"radio\" name=\"idsalle\" value=\"$idsalle\">$intitule_salle ($capacite personnes)<br />";
									}
								}
							echo "</td>";
						}
						else
						{
							echo "<h2>Pas de salle pour cette structure</h2>";
						}
						//Formulaire d'ajout de salle
					} //Fin if rne <> -1
					else
					{
						//On récupère les informations de la société
						$requete3 = "SELECT * FROM repertoire WHERE No_societe = '".$no_societe."'";
						//echo "<br />$requete2";
						$resultat3 = mysql_query($requete3);
						$ligne3=mysql_fetch_object($resultat3);
						$no_societe=$ligne3->No_societe;
						$societe=$ligne3->societe;
						$ville=$ligne3->ville;

						//On récupère les salles de cette structure
						$requete4 = "SELECT * FROM om_salle WHERE idstructure = '".$no_societe."' ORDER BY intitule_salle";
						
						//echo "<br />$requete4";
						
						$resultat4 = mysql_query($requete4);
						$nombre_salle = mysql_num_rows($resultat4);
						
						//echo "<br />nombre_salle : $nombre_salle";

						if ($nombre_salle >0)
						{
							echo "<h2>Les salles disponibles pour <br />$societe $ville</h2>";
							echo "<td>";
								if (mysql_num_rows($resultat2))
								{
									while ($ligne21=mysql_fetch_object($resultat2))
									{
										$idsalle=$ligne41->idsalle;
										$intitule_salle=$ligne41->intitule_salle;
										$capacite=$ligne41->capacite;
										
										echo "<input type=\"radio\" name=\"idsalle\" value=\"$idsalle\">$intitule_salle ($capacite personnes)<br />";
									}
								}
							echo "</td>";
						}
						else
						{
							echo "<h2>Pas de salle pour cette structure</h2>";
						}
					} //Fin else if rne <> -1
				echo "</tr>";
			echo "</table>";

			echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				if ($nombre_salle >0)
				{
					echo "<td>";
						echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Valider_choix\" title=\"Valider le choix\" border=\"0\" type=image Value=\"Valider\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Valider votre choix</span><br />";
					echo "</TD>";
				}
			echo "</tr>";
		echo "</table>";
		echo "<input type=hidden name=\"action_supplementaire\" value=\"enreg_salle\"/>";

		}
		echo "<input type=hidden name=\"idreunion\" value=\"$idreunion\"/>";
		echo "<input type=hidden name=\"a_faire\" value=\"ajouter_salle\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
	echo "</form>";
	
	//echo "<br />choix_structure : $choix_structure";
	If ($choix_structure <> "")
	{
		//Formulaire d'ajout d'une salle
		echo "<hr>";
		
		echo "<form method=\"post\" action=\"om_affichage_reunion.php\">";
			if ($rne == "-1")
			{
				$structure = $no_societe;
			}
			else
			{
				$structure = $rne;
			}

			/*
			echo "<br />rne : $rne";
			echo "<br />no_societe : $no_societe";
			*/
			echo "<h2>Ajout d'une salle &agrave; la structure $structure</h2>";
			echo "<table>";
				echo "<tr>";
					echo "<td class = \"etiquette\">Nom de la salle&nbsp;:&nbsp;</td>";
					echo "<td><input type=\"text\" name=\"intitule_salle\" size=\"15\"></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td class = \"etiquette\">Capacit&eacute; d'accueil&nbsp;:&nbsp;</td>";
					echo "<td><input type=\"text\" name=\"capacite\" size=\"15\"></td>";
				echo "</tr>";
			echo "</table>";

			echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Valider_choix\" title=\"Valider le choix\" border=\"0\" type=image Value=\"Valider\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer la nouvelle salle</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
		echo "<input type=hidden name=\"idreunion\" value=\"$idreunion\"/>";
		echo "<input type=hidden name=\"a_faire\" value=\"ajouter_salle\"/>";
		echo "<input type=hidden name=\"choix_structure\" value=\"O\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
		echo "<input type=hidden name=\"action_supplementaire\" value=\"nouvelle_salle\"/>";
		echo "<input type=hidden name=\"rne\" value=\"$rne\"/>";
		echo "<input type=hidden name=\"no_societe\" value=\"$no_societe\"/>";

		echo "</form>";
	}
?>
