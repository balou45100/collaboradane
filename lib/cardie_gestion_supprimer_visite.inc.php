<?php

	$id_visite = $_GET['id_visite'];
	$contexte_appelant = $_GET['contexte_appelant'];
	
	//echo "<br >contexte_appelant : $contexte_appelant";
	//echo "<br />id_visite : $id_visite";
	
	$requete = "SELECT * FROM 
			cardie_visite 
		WHERE ID_VISITE = $id_visite";
	$resultat = mysql_query($requete);
	$ligne = mysql_fetch_object($resultat);
	$date_visite = $ligne->DATE_VISITE;
	$horaire_visite = $ligne->HORAIRE_VISITE;
	
	echo "<h2>Suppression de la visite $id_visite</h2>";
	if ($contexte_appelant == "visites")
	{
		echo "<form action=\"cardie_gestion_visites.php\" method=\"GET\">";
	}
	else
	{
		echo "<form action=\"cardie_gestion_projets.php\" method=\"GET\">";
	}
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Date&nbsp;:&nbsp;</td>";
				echo "<td>$date_visite</td>";
				echo "<td class = \"etiquette\">Horaire de d&eacute;but&nbsp;:&nbsp;</td>";
				echo "<td>$horaire_visite</td>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						if ($contexte_appelant == "visites")
						{
							echo "<a href = \"cardie_gestion_visites.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						}
						else
						{
							echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						}
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Confirmer\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=\"Confirmer la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmation_supprimer_visite\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_visite\" NAME = \"id_visite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</form>";
?>
