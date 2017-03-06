<?php

	$id_liste = $_GET['id_liste'];

	$requete = "SELECT * FROM configuration_systeme_listes_deroulantes
		WHERE ID = $id_liste";
		
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);
	$ligne = mysql_fetch_object($resultat);
	$intitule = $ligne->INTITULE;
	
	echo "<h2>Suppression de la liste &laquo;&nbsp;$intitule&nbsp;&raquo;</h2>";
		echo "<form action=\"configuration_systeme_6.php\" method=\"GET\">";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Confirmer\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=\"Confirmer la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmation_supprimer_liste\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_liste\" NAME = \"id_liste\">";

	echo "</form>";
?>
