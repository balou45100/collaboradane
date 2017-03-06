<?php
	//echo "On récupère les visites";
	//echo "id_projet : $id_projet";
	$requete_visites = 
	"SELECT * FROM cardie_projet AS CP, cardie_visite AS CV
		WHERE CP.NUM_PROJET = CV.FK_NUM_PROJET
			AND CP.NUM_PROJET = $id_projet
		ORDER BY CV.DATE_VISITE";
		
	//echo "requete : $requete_visites";
	
	$resultat3 = mysql_query($requete_visites);
	$nbr_enreg = mysql_num_rows($resultat3);
	//echo "$nbr_enreg";
	$compteur = 0;
	$dates_a_afficher ="";
	while ($ligne = mysql_fetch_object($resultat3))
	{
		
		$image_a_afficher = ""; //Il faut initialiser la variable des bilans à afficher
		$compteur++;
		//echo "$compteur";
		$date_visite = $ligne->DATE_VISITE;
		$id_visite = $ligne->ID_VISITE;
		$etat_visite = $ligne->ETAT;
		
		//On vérifie s'il y a un bilan déposé pou la visite
		$req_verif_bilan = "SELECT * FROM documents WHERE id_ticket = '".$id_visite."' AND module = 'CVI'";
		
		//echo "<br />req_verif_bilan : $req_verif_bilan<br />";
		
		$res_req_verif_bilan = mysql_query($req_verif_bilan);
		$nb_bilan = mysql_num_rows($res_req_verif_bilan);
		
		//echo "<br />nb_bilan : $nb_bilan";
		
		if ($nb_bilan >0)
		{
			//On récupère le nom du fichier
			$ligne_bilan = mysql_fetch_object($res_req_verif_bilan);
			$nom_fichier = $ligne_bilan->nom_fichier;
			$nom_doc = $ligne_bilan->nom_doc;
			$id_doc = $ligne_bilan->id_doc;
			$lien = $dossier.$nom_fichier;
			/*
			echo "<br />lien : $lien";
			echo "<br />nom_fichier : $nom_fichier";
			echo "<br />id_doc : $id_doc";
			*/
			
			//On récupère la bonne icône en fonction du type de fichier
			$image = image_fichier_joint($nom_fichier); //on récupère le type de l'image à afficher
			$image = $chemin_theme_images."/".$image;
			
			//echo "<br />image : $image";
			
			$image_a_afficher = "&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$nom_doc\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\"src = \"$image\" ALT = \"$nom_doc\" title=\"$nom_doc\" border = \"0\">&nbsp;</a>";

		}
		if ($compteur < $nbr_enreg)
		{
/*
			//echo "$nom - ";
			$dates_a_afficher=$dates_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite."<br />";
		}
		else
		{
			$dates_a_afficher=$dates_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite."&nbsp;";
*/
			if ($niveau_droits == 3 AND $etat_visite  == 0)
			{
				$dates_a_afficher=$dates_a_afficher.$image_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite." ($etat_visite)&nbsp<a href = \"?action=O&amp;a_faire=supprimer_visite&amp;id_visite=".$id_visite."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer \" border = \"0\" title=\"Supprimer la visite\"></a><br />";
			}
			else
			{
				$dates_a_afficher=$dates_a_afficher.$image_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite." ($etat_visite)<br/>";
			}
		}
		else
		{
			if ($niveau_droits == 3 AND $etat_visite  == 0)
			{
				$dates_a_afficher=$dates_a_afficher.$image_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite." ($etat_visite)&nbsp<a href = \"?action=O&amp;a_faire=supprimer_visite&amp;id_visite=".$id_visite."&amp;mes_projets=".$mes_projets."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la visite\"></a>";
			}
			else
			{
				$dates_a_afficher=$dates_a_afficher.$image_a_afficher."V".$compteur."&nbsp;:&nbsp;".$date_visite." ($etat_visite)";
			}
		}
	}
	echo "$dates_a_afficher";
?>
