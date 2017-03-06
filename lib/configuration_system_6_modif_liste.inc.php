<?php
	//On récupère l'identifiant de la liste à modifier
	$id_liste = $_GET['id_liste'];
	$nom_table = $_GET['nom_table'];

	echo "<h2>Modification de la liste &laquo;&nbsp;$nom_table&nbsp;&raquo;</h2>";

	$requete = "SELECT * FROM configuration_systeme_listes_deroulantes
		WHERE ID = '".$id_liste."';";
			
	//echo "<br />$requete";
	
	$resultat = mysql_query($requete);
	$num_rows = mysql_num_rows($resultat);
	

	//echo "<br />num_rows : $num_rows";
	
	$ligne = mysql_fetch_object($resultat);
	//$id_element = $ligne->NUM_PROJET;
	$intitule = $ligne->INTITULE;
	$etat = $ligne->actif;
	
	//On afiche le formulaire pour la modification de l'intitule du nouvel élmément
	echo "<form action=\"configuration_systeme_6.php\" method=\"get\">";
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Intitul&eacute; du nouvel &eacute;l&eacute;ment&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" id=\"intitule\" name=\"intitule\" SIZE = \"40\" required / VALUE = \"$intitule\">";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Valider<br />le formulaire</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_modif_liste\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_liste\" NAME = \"id_liste\">";
	echo "</form>";
?>
