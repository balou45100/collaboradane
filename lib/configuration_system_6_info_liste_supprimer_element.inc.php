<?php

	$id_element = $_GET['id'];
	$nom_table = $_GET['nom_table'];

	//echo "<br />id_visite : $id_visite";
	
	$requete = "SELECT * FROM 
			$nom_table 
		WHERE ID = $id_element";
		
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);
	$ligne = mysql_fetch_object($resultat);
	$intitule = $ligne->INTITULE;
	
	echo "<h2>Suppression de l'&eacute;l&eacute;ment << $intitule >></h2>";
		echo "<form action=\"configuration_systeme_6.php\" method=\"GET\">";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste&amp;nom_table=$nom_table&amp;id=$id&amp;etat=N&amp;tri=$tri&amp;sense_tri=$sense_tri\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour<br />sans enregistrer</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Confirmer\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=\"Confirmer la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"$nom_table\" NAME = \"nom_table\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"info_liste_confirmation_supprimer_element\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_element\" NAME = \"id_element\">";

	echo "</form>";
?>
