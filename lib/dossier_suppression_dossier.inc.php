<?php
	echo "<h2>Suppression du dossier $id_dossier</h2>";
	
	//On filtre le dossier de la table categorie_commune
	
	$requete_dossier = "SELECT * FROM categorie_commune AS cc, dos_dossier AS dd, util AS u
		WHERE cc.id_categ = dd.idDossier
			AND dd.responsable = u.ID_UTIL
			AND cc.id_categ = '".$id_dossier."';";
			
	//echo "<br />$requete_dossier";
	
	$resultat_requete = mysql_query($requete_dossier);
	$num_rows = mysql_num_rows($resultat_requete);
	if (mysql_num_rows($resultat_requete))
	{
		$ligne=mysql_fetch_object($resultat_requete);
		$id_categ=$ligne->id_categ;
		$intitule_categ = $ligne->intitule_categ;
		$description_categ = $ligne->description_categ;
		$id_responsable = $ligne->responsable;
		$nom_responsable = $ligne->NOM;
		$prenom_responsable = $ligne->PRENOM;
		
		//echo "<br />RNE : $rne";
		echo "<form action=\"dossier_accueil.php\" method=\"GET\">";
		
		echo "<table width=\"95%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
				echo "<td>$intitule_categ</td>";
				echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
				echo "<td>&nbsp;$id_dossier</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Description&nbsp;:&nbsp;</td>";
				echo "<td><$description_categ</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Responsable&nbsp;:&nbsp;</td>";
				echo "<td>$nom_responsable</td>";
			echo "</tr>";
		echo "</table>";

			//Boutons retour et confirmation de suppression
			echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"dossier_accueil.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Supprimer\" title=\"supprimer\" border=\"0\" type=image Value=\"Valider la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirm_suppression_dossier\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_dossier\" NAME = \"id_dossier\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
	echo "</form>";

	}

?>
