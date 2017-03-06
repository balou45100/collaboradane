<?php
	//echo "On récupère les accompagnateurs";
	$requete_accompagnateurs = 
	"SELECT CP.NUM_PROJET, PRT.NOM, PRT.PRENOM, PRT.id_pers_ress FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA, personnes_ressources_tice AS PRT
		WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
			AND CPA.FK_ID_PERS_RESS = PRT.ID_PERS_RESS
			AND CP.NUM_PROJET = $id_projet
		ORDER BY PRT.NOM";
		
	//echo "requete : $requete_accompagnateurs";
	
	$resultat2 = mysql_query($requete_accompagnateurs);
	$nbr_accompagnateurs = mysql_num_rows($resultat2);
	$compteur = 0;
	$noms_a_afficher ="";
	/*
	//On affiche l'icône pour ajouter un accompagnateur si la personne connectée est un gestionnaire
	if ($niveau_droits == 3)
	{
		echo "&nbsp;<a href = \"cardie_gestion.php?action=O&amp;a_faire=ajout_accompagnateur&amp;id_projet=".$id_projet."&amp;mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."\" target = \"body\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/cardie_ajout_accompagnateur.png\" border = \"0\" ALT = \"ajouter accompagnateur-e\" title=\"Ajouter un-e accompagnateur-e\"></a>";
	}
	*/
	//echo "<br />niveau_droits : $niveau_droits";
	
	while ($ligne = mysql_fetch_object($resultat2))
	{
		
		$compteur++;
		//echo "$compteur";
		$id_pers_ress_extrait = $ligne->id_pers_ress;
		$nom = $ligne->NOM;
		$prenom = $ligne->PRENOM;
		if ($compteur < $nbr_accompagnateurs)
		{
			$noms_a_afficher=$noms_a_afficher.$nom.", ".$prenom;
			if ($niveau_droits == 3)
			{
				$noms_a_afficher=$noms_a_afficher."&nbsp<a href = \"?action=O&amp;a_faire=dissocier_accompagnateur&amp;id_projet=".$id_projet."&amp;id_pers_ress=".$id_pers_ress_extrait."&amp;module=T&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Dissocier l'accompagnateur/trice du projet\"></a><br />";
			}
			else
			{
				$noms_a_afficher=$noms_a_afficher."<br/>";
			}
		}
		else
		{
			$noms_a_afficher=$noms_a_afficher.$nom.", ".$prenom;
			if ($niveau_droits == 3)
			{
				$noms_a_afficher=$noms_a_afficher."&nbsp<a href = \"?action=O&amp;a_faire=dissocier_accompagnateur&amp;id_projet=".$id_projet."&amp;id_pers_ress=".$id_pers_ress_extrait."&amp;module=T&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"dissocier du projet\" border = \"0\" title=\"Dissocier l'accompagnateur/trice du projet\"></a>";
			}
		}
	}
	echo "$noms_a_afficher";
?>
