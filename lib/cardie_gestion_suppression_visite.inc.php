<?php
	echo "<h2>Suppression du projet $id_projet</h2>";
	
	//On filtre le projet de la table cardie_projet
	
	$requete_projet = "SELECT * FROM cardie_projet AS CP, etablissements AS ETAB
		WHERE CP.RNE = ETAB.RNE
			AND CP.NUM_PROJET = '".$id_projet."';";
			
	//echo "<br />$requete_projet";
	
	$resultat_requete = mysql_query($requete_projet);
	$num_rows = mysql_num_rows($resultat_requete);
	if (mysql_num_rows($resultat_requete))
	{
		$ligne=mysql_fetch_object($resultat_requete);
		$rne=$ligne->RNE;
		$type_etab = $ligne->TYPE;
		$pubpri = $ligne->PUBPRI;
		$nom_etab = $ligne->NOM;
		$adresse_etab = $ligne->ADRESSE;
		$ville_etab = $ligne->VILLE;
		$cp_etab = $ligne->CODE_POSTAL;
		$id_projet=$ligne->NUM_PROJET;
		$annee_projet=$ligne->ANNEE;
		$intitule_projet=$ligne->INTITULE;
		
		
		//echo "<br />RNE : $rne";
		
		//Partie ECL
		echo "<table width=\"95%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">RNE/UAI&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$rne</td>";
				echo "<td class = \"etiquette\">STRUCTURE&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$type_etab&nbsp;$pubpri&nbsp$nom_etab&nbsp;$ville_etab</td>";
			echo "</tr>";
		echo "</table>";
		
		//Partie projet
		echo "<form action=\"cardie_gestion.php\" method=\"post\">";

			echo "<table width=\"95%\">";
				echo "<caption></caption>";
				echo "<tr>";
					echo "<td class = \"etiquette\">INTITULE&nbsp;:&nbsp;</td>";
					echo "<td><input type=\"text\" VALUE = \"$intitule_projet\" size = \"75\" name=\"intitule_projet\" /></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td class = \"etiquette\">ANN&Eacute;E D&Eacute;BUT&nbsp;:&nbsp;</td>";
					echo "<td><input type=\"text\" VALUE = \"$annee_projet\" size = \"75\" name=\"intitule_projet\" /></td>";
				echo "</tr>";
			echo "</table>";

			//Boutons retour et confirmation de suppression
			echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion.php?mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Supprimer\" title=\"supprimer\" border=\"0\" type=image Value=\"Valider la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirm_suppression_projet\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_projet\" NAME = \"id_projet\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</form>";

	}

?>
