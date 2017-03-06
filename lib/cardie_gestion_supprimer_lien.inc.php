<?php

	$id_visite = $_GET['id_projet'];
	$id_pers_ress = $_GET['id_pers_ress'];
	$id_lien= $_GET['id_lien'];
	/*
	echo "<br />id_projet : $id_projet";
	echo "<br />id_pers_ress : $id_pers_ress";
	echo "<br />id_lien : $id_lien";
	*/
	
	$requete = "SELECT * FROM cardie_projets_liens
		WHERE id_lien = $id_lien";
			
	//echo "<br />requete : $requete";
	
	$resultat = mysql_query($requete);
	$ligne = mysql_fetch_object($resultat);
	$intitule = $ligne->intitule;
	$adresse = $ligne->adresse;

	echo "<h2>Suppression du lien $id_lien</h2>";
	echo "<form action=\"cardie_gestion_projets.php\" method=\"GET\">";
		
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">ID du lien&nbsp;:&nbsp;</td>";
				echo "<td>$id_lien</td>";
				echo "<td class = \"etiquette\">Intitul&eacute; du lien&nbsp;:&nbsp;</td>";
				echo "<td>$intitule</td>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Adresse du lien&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"3\"><a target = '_blank' href = '$adresse'>$adresse</a>&nbsp;(Cliquer sur le lien pour le v&eacute;rifier)";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/supprimer.png\" ALT = \"Confirmer\" title=\"Confirmer la suppression\" border=\"0\" type=image Value=\"Confirmer la suppression\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"confirmation_supprimer_lien\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_pers_ress\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_lien\" NAME = \"id_lien\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"T\" NAME = \"module\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</form>";
?>
