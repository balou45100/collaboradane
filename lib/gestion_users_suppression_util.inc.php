<?php
	//Récupération des données de l'utilisateur à supprimer
	
	//echo "<br />id_util : $id_util";
	
	$requete_util = "SELECT prenom, nom, mail, id_util FROM util WHERE id_util = '".$id_util_a_supprimer."'";
	$resultat_requete_util = mysql_query($requete_util);
	$num_results = mysql_num_rows($resultat_requete_util);
	
	//echo "<br />num_results : $num_results";
	
	if ($num_results == 0)
	{
		echo "<h2>Erreur dans la requ&ecirc;te&nbsp;!</h2>";
		mysql_close();
		exit;
	}
	else
	{
		//On récupère les informations à afficher
		$res = mysql_fetch_row($resultat_requete_util);
		echo "<h2>Voulez-vous vraiment supprimer cet utilisateur</h2>
			<TABLE>
				<TR class = \"indre_loire\">
					<td class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</td>
					<td>&nbsp;".$res[0]."</td>
				</TR>
				<TR class = \"indre_loire\">
					<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>
					<td>&nbsp;".$res[1]."
					</td>
				</TR>
				<TR class = \"indre_loire\">
					<td class = \"etiquette\">Courriel&nbsp;:&nbsp;</td>
					<td>&nbsp;".$res[2]."</td>
				</TR>
			</TABLE>";

			//On affiche les boutons
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_user.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Non</span><br />";
						echo "</td>";
						echo "<td>";
							echo "<a href = \"gestion_user.php?action=O&amp;a_faire=suppression_confirmee&amp;id_util_a_supprimer=$res[3]\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/oui.png\" ALT = \"Oui\" title=\"Confirmer la suppression\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Oui</span><br />";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
	}
?>
