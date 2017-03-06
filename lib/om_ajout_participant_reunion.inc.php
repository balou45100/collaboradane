<?php
	echo "<form action=\"om_affichage_reunion.php\" method=\"POST\">";
	echo "<table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"20%\">";
			echo "<col width=\"80%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";

	
		echo "<tr>";
			echo "<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>";
				$requete_personne = "SELECT * FROM personnes_ressources_tice AS PRT, etablissements AS ETAB WHERE PRT.codetab = ETAB.RNE ORDER BY PRT.nom, PRT.prenom ASC";
				
				//echo "<br />$requete_personne";
				
				$result_requete_personne = mysql_query($requete_personne);
				$num_rows = mysql_num_rows($result_requete_personne);
			echo "<td>";
				echo "<select size=\"1\" name=\"id_pers_ress\">";
				if (mysql_num_rows($result_requete_personne))
				{
					echo "<option selected value=\"122\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result_requete_personne))
					{
						$id_pers_ress=$ligne->id_pers_ress;
						$nom=$ligne->nom;
						$prenom = $ligne->prenom;
						$rne = $ligne->RNE;
						$discipline = $ligne->discipline;
						$poste = $ligne->poste;
						$mel = $ligne->mel;
						$type = $ligne->TYPE;
						$nom_etab = $ligne->NOM;
						$ville_etab = $ligne->VILLE;
						
						echo "<option value=\"$id_pers_ress\">$nom, $prenom, $discipline, $poste, $mel - $rne $type, $nom_etab, $ville_etab</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		echo "</table>";

		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Ajouter la personne &agrave; la r&eacute;union</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
		echo "<input type=hidden name=\"a_faire\" value=\"gestion_participants\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
		echo "<input type=hidden name=\"idreunion\" value=\"$idreunion\"/>";
		echo "<input type=hidden name=\"action_supplementaire\" value=\"enregistrer_participant\"/>";

	echo "</form>";

?>
