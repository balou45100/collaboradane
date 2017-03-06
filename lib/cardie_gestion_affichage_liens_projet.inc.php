<?php
	//echo "On interroge la base pour voir s'il y a des liens associés au projet";
	//echo "id_projet : $id_projet";
	$requete_liens = 
	"SELECT * FROM cardie_projets_liens
		WHERE id_projet = $id_projet
		ORDER BY experitheque ASC";
		
	//echo "<br />requete : $requete_liens";
	
	$resultat_liens = mysql_query($requete_liens);
	$nbr_enreg = mysql_num_rows($resultat_liens);

	//echo "<br />$nbr_enreg";
	
	while ($ligne = mysql_fetch_object($resultat_liens))
	{
		$adresse = $ligne->adresse;
		$experitheque = $ligne->experitheque;
		$intitule = $ligne->intitule;
		$id_lien = $ligne->id_lien;
		
		/*
		echo "<br />adresse : $adresse";
		echo "<br />experitheque : $experitheque";
		echo "<br />intitule : $intitule";
		*/
		//On affiche l'icône avec le lien
		
		//On teste s'il s'agit d'un lien expérithèque ou pas
		if ($experitheque == "O")
		{
			echo "<a target = '_blank' href = '$adresse'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_lien_experitheque.png\" border = \"0\" ALT = \"lien_experitheque\" title='$intitule'></a>";
			if ($niveau_droits <> 2) // les accompagnateurs et les gestionnaires CARDIE
			{
				echo "<a href = \"?action=O&amp;a_faire=supprimer_lien&amp;id_lien=".$id_lien."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Supprimer le lien\"></a>";
			}
		}
		else
		{
			echo "<a target = '_blank' href = '$adresse'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/cardie_projet_lien.png\" border = \"0\" ALT = \"lien_experitheque\" title='$intitule'></a>";
						if ($niveau_droits <> 2) // les accompagnateurs et les gestionnaires CARDIE
			{
				echo "<a href = \"?action=O&amp;a_faire=supprimer_lien&amp;id_lien=".$id_lien."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Supprimer le lien\"></a>";
			}
		}
		
		
	}
?>
