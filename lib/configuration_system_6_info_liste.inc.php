<?php
	$nom_table = $_GET['nom_table'];
	$intitule_champ = $_GET['intitule_champ'];
	$id_liste = $_GET['id_liste'];
	/*
	echo "<br />configuration_system_6_info_liste.inc.php";      
	echo "<br >intitule_champ : $intitule_champ";
	echo "<br />nom_table : $nom_table";
	echo "<br />id_liste : $id_liste";
	*/
	echo "<h2>Information sur la table &laquo;&nbsp;$nom_table&nbsp;&raquo;</h2>";
	
	$requete="SELECT * FROM $nom_table";
	
	//echo "<br />requete : $requete<br />";
	
	$result=mysql_query($requete);
	$num_rows = mysql_num_rows($result);
	
	//echo "<br />num_rows : $num_rows<br />";
	
	//On récupère le nombre de colonnes de la table
	$nbr_colonnes = mysql_num_fields($result); 
	
	//echo "<br />Nombre de colonnes de cette table : $nbr_colonnes<br />";
	
	/*
	for ($i=0; $i<$nbr_colonnes; $i++)
	{
		$champ[$i] = mysql_field_name($result, $i);
		echo "$i $champ[$i]<br />";
	}
	*/
	
	if (!$num_rows)
	{
		echo "<h2>Pas d'enregistrement pour l'instant</h2>";
	}
	else
	{
		//On récupère le nom du champ servant d'identifiant pour pouvoir trier la liste ensuite
		$intitule_pour_tri = mysql_field_name($result, 1);
		
		//On refait la requete avec tri
		$requete="SELECT * FROM $nom_table ORDER BY $intitule_pour_tri";
		$result=mysql_query($requete);
		
		echo "<h2>Nombre d'&eacute;l&eacute;ments : $num_rows</h2>";
		
		//On ajoute le bouton d'ajout d'élément de liste
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_ajout_element&amp;nom_table=$nom_table\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un &eacute;l&eacute;ment\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un &eacute;l&eacute;ment</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		//On affiche l'entête du tableau
		echo "<table>";
			echo "<tr>";
			
			//On récupère tous les intitulés des colonnes et les affichent
			for ($i=0; $i<$nbr_colonnes; $i++)
			{
				$champ[$i] = mysql_field_name($result, $i);
				echo "<th align = center>$champ[$i]</th>";
			}
			echo "<th align = center>&nbsp;Actions&nbsp;</th>";
			echo "</tr>";
			
			//On récupère les lignes des enregistrements
			while ($ligne = mysql_fetch_object($result))
			{
				for ($i=0; $i<$nbr_colonnes; $i++)
				{
					$champ[$i] = mysql_field_name($result, $i);
					//echo $champ[$i];
					$champ_a_afficher[$i] = $ligne->$champ[$i];
					//On vérifie s'il s'agit du champ "actif"
					if ($champ[$i] == "actif")
					{
						//On vérifie l'état
						if ($champ_a_afficher[$i] == "O")
						{
							echo "<td align = center>&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_changer_etat&amp;nom_champ_id=".$champ[0]."&amp;id_element=".$champ_a_afficher[0]."&amp;nom_table=".$nom_table."&amp;etat_element=".$champ_a_afficher[$i]."\" target = \"body\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/etat_actif.png\" border = \"0\" ALT = \"D&eacute;sactiver\" title=\"D&eacute;sactiver l'&eacute;l&eactute;ment\"></a></td>";
						}
						else
						{
							echo "<td align = center>&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_changer_etat&amp;nom_champ_id=".$champ[0]."&amp;id_element=".$champ_a_afficher[0]."&amp;nom_table=".$nom_table."&amp;etat_element=".$champ_a_afficher[$i]."\" target = \"body\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/etat_inactif.png\" border = \"0\" ALT = \"activer\" title=\"Activer l'&eacute;l&eactute;ment\"></a></td>";
						}
					}
					else
					{
						echo "<td>&nbsp;&nbsp;$champ_a_afficher[$i]</td>";
					}
				}

					echo "<td class = \"fond-actions\" nowrap>";
						echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_modif_element&amp;nom_table=$nom_table&amp;id=".$champ_a_afficher[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier l'&eacute;l&eacute;ment\"></a>";
						echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_supprimer_element&amp;nom_table=$nom_table&amp;id=".$champ_a_afficher[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer l'&eacute;l&eacute;ment\"></a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";

		echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"configuration_systeme_6.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
	}
?>
