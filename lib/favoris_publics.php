<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		include ("../biblio/config.php");
		include ("../biblio/init.php");
		echo "<body>";
		$max_par_ligne = "3";
		$id_util = $_SESSION['id_util'];
		$retour = "favoris_publics.php";

		echo "<h2>Cat&eacute;gories publiques</h2>";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris_categorie_inactif.png\" ALT = \"favoris publics\" border = \"0\" title=\"Favoris publics\">
							<br /><span class=\"IconesAvecTexte\">Favoris publics</span><br />";
					echo "</td>";
					echo "<td>";
						echo "<A HREF = \"favoris_prives.php\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris_categorie_privee.png\" ALT = \"favoris priv&eacute;s\" border = \"0\" title=\"Favoris priv&eacute;s\"></A>
							<br /><span class=\"IconesAvecTexte\">Favoris priv&eacute;</span><br />";
					echo "</td>";
					echo "<td>";
						echo "<a href = favoris_creation_categorie.php?retour=$retour><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris_categorie_ajout.png\" ALT = \"nouvelle cat&eacute;gorie\" border = \"0\" title=\"Nouvelle cat&eacute;gorie\"></a>
							<br /><span class=\"IconesAvecTexte\">Nouvelle cat&eacute;gorie</span><br />";
					echo "</td>";
					echo "<td>";
						echo "<a href = favoris_creation_favoris.php?retour=$retour><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris_ajout.png\" ALT = \"nouveau favori\" border = \"0\" title=\"Nouveau favori\"></a>
							<br /><span class=\"IconesAvecTexte\">Nouveau favoris</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<div align = \"center\">";

		//on prépare la requête pour extraire les catégories
		$test_categ_publique = "SELECT id_categ, intitule_categ FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ";
		$resultat_categ_publique = mysql_query($test_categ_publique);

		echo "<table id= \"tablefavoris\">";
		$cat=1; //Permet d'identifier chaque tableau par catégorie
		while ($categorie = mysql_fetch_row($resultat_categ_publique)) // on extrait ligne par ligne due la table catégories
		{
			if ($compteur == $max_par_ligne) // Nombre de catégories par ligne
			{
				$compteur = 0;
				echo "<br />";
				echo "<table id = \"tablefavoris\">";
					echo "<tr>";
			}
			elseif ($compteur == 0)
			{
				//on ne fait rien
			}
			else
			{
				echo "<td>&nbsp;</td>"; //On affiche une cellule pour séparer
			}
					echo "<td  valign=\"top\" width=\"33%\"><input type=\"hidden\" name=\"tab_$cat\" value=\"\" >";
						echo "<table id=\"tablefavoris\">";
							echo "<tr align = \"center\">";
								echo "<th width = \"92%\">$categorie[1]</th>
								<td class = \"fond-actions\" width = \"4%\" align = center><a href = favoris_modif_categ_fav.php?id_categ=$categorie[0]&amp;retour=$retour target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier cette cat&eacute;gorie' border = '0' width = \"20\" height = \"20\"></a></td>
								<td class = \"fond-actions\" width = \"4%\" align = center><a href = favoris_suppr_categ_fav.php?id_categ=$categorie[0]&amp;retour=$retour target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer cette cat&eacute;gorie' border = '0' width = \"20\" height = \"20\"></a></td>";
							echo "</tr>";
							echo "<tr align = \"center\">";
								echo "<td>";
									//on extrait les favories pour chaque cat&eacute;gorie
									$requete_favoris_publics = "SELECT id_favori, intitule, adresse FROM favoris WHERE id_categ = $categorie[0] order by intitule";
									$resultat_requete_favoris_publics = mysql_query($requete_favoris_publics);
									$nb_favoris = mysql_num_rows($resultat_requete_favoris_publics);
									if ($nb_favoris == 0)
									{
										echo "Aucun favoris dans cette cat&eacute;gorie";
									}
									else
									{
										while ($favori = mysql_fetch_row ($resultat_requete_favoris_publics)) // Tant qu'il y a des favoris pour la catégorie en cours
										{
											echo "<tr>
												<td width = \"92%\"><a target = '_blank' href = '$favori[2]'>$favori[1]</a></td>
												<td class = \"fond-actions\" width = \"4%\" align = center><a href = favoris_modif_fav.php?id_fav=$favori[0]&amp;retour=$retour target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier ce favoris' border = '0' width = \"20\" height = \"20\"></a></td>
												<td class = \"fond-actions\" width = \"4%\" align = center><a href = favoris_suppr_fav.php?id_fav=$favori[0]&amp;retour=$retour target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer ce favoris' border = '0' width = \"20\" height = \"20\"></a></td>
											</tr>";
											$fav ++;
										}
									}
						echo "</table>
					</td>";
			$cat ++;
			$compteur ++;
			if ($compteur == $max_par_ligne) // Si fin de ligne on va à la suivante...
			{
				echo "</table>";
			}
		}
		echo "</tr>";
	echo "</table>";
?>
		</div>
	</body>
</html>

