<?php
	//echo "<br />origine : $origine";
	/*
	echo "<br />id_societe : $id_societe";
	echo "<br />tri : $tri";
	echo "<br />sense_tri : $sense_tri";
	echo "<br />tri2 : $tri2";
	echo "<br />origine_gestion : $origine_gestion";
	//echo "<br /> : $";
	*/

	// Requête pour l'extraction des enregistrements concernés

	switch ($origine)
	{
		case "ECL" :
			$query = "SELECT DISTINCT * FROM suivis AS s, util AS u, categorie_commune AS cc, suivis_categories_communes AS scc 
				WHERE s.id = scc.id_suivi 
					AND s.emetteur = u.ID_UTIL 
					AND ecl = '".$id_societe."' 
					AND scc.id_categorie_commune = cc.id_categ 
				ORDER BY s.id;";
			$message_pas_d_enregistrement = "Pas de suivis pour l'instant";
		break;

		case "SUIVI" :
			$query = "SELECT DISTINCT * FROM suivis AS s, util AS u, categorie_commune AS cc, suivis_categories_communes AS scc 
				WHERE s.id = scc.id_suivi 
				AND s.emetteur = u.ID_UTIL 
				AND scc.id_categorie_commune = '".$id_dossier."' 
				AND scc.id_categorie_commune = cc.id_categ 
			ORDER BY s.date_suivi;";
			$message_pas_d_enregistrement = "Pas de suivis pour ce dossier pour l'instant";
		break;

	}

	//echo "<br />$query";
	
	$results = mysql_query($query);
	if(!$results)
	{
		echo "<h2></h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
		echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
		mysql_close();
		exit;
	}
	//Retourne le nombre de ligne rendu par la requ&egrave;te
	$num_results = mysql_num_rows($results);
	
	//echo "<br />num_results : $num_results";

	echo "<h2>Nombre de suivis <strong>en cours</strong>&nbsp;:&nbsp;$num_results</h2>";
	if ($num_results > 0)
	{
		echo "<table>";
			//echo "<caption><b>Nombre de suivis <strong>en cours</strong>&nbsp;:&nbsp;$num_results</b></caption>";
			echo "<tr>";
				echo "<th>ID</th>";
				//echo "<th>EMETTEUR</th>";
				echo "<th>";
				/*
				if ($sense_tri =="asc")
				{
					*/
					echo "Cr&eacute;&eacute; par";
					//echo "Cr&eacute;&eacute; par&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
					/*
				}
				else
				{
					echo "Cr&eacute;&eacute; par&nbsp;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
				}
				*/
				echo "</th>";
				echo "<th>Cr&eacute;&eacute; le</th>";
				echo "<th>Date suivi</th>";
				echo "<th>Titre</th>";
				echo "<th>Type suivi</th>";
				if ($origine <> "SUIVI")
				{
					echo "<th>Dossier</th>";
				}
				if ($origine <> "ECL")
				{
					echo "<th>ECL</th>";
				}

				echo "<th>Actions</th>";
			echo "</tr>";
			////////////////////////////////////////
			// Traitement de chaque ligne //////////
			////////////////////////////////////////
			for($i = 0; $i < $num_results; ++$i)
			{
				$ligne = mysql_fetch_object($results);

				$id_suivi = $ligne->id;
				$emetteur = $ligne->NOM;
				$date_creation = $ligne->date_crea;
				$date_suivi = $ligne->date_suivi;
				$ecl = $ligne->ecl;
				$titre = $ligne->titre;
				$description = $ligne->description;
				$contact_type = $ligne->contact_type;
				$intitule_categ = $ligne->intitule_categ;

				echo "<tr>";
					echo "<td align=\"center\">";
						echo $id_suivi;
					echo "</td>";
					echo "<td align=\"center\">$emetteur</td>";
					echo "<td>";
						//Transformation de la date de création extraite pour l'affichage
						$date_de_creation_a_afficher = strtotime($date_creation);
						$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
						echo $date_de_creation_a_afficher;
					echo "</td>";
					echo "<td>";
						//Transformation de la date du suivi extraite pour l'affichage
						$date_de_suivi_a_afficher = strtotime($date_suivi);
						$date_de_suivi_a_afficher = date('d/m/Y',$date_de_suivi_a_afficher);
						echo $date_de_suivi_a_afficher; 
					echo "</td>";
					echo "<td>$titre</td>";
					echo "<td>$contact_type</td>";
					if ($origine <> "SUIVI")
					{
						echo "<td>$intitule_categ</td>";
					}

					if ($origine <> "ECL")
					{
						echo "<td>$ecl</td>";
					}
					////////////////////////////////////////////////////////
					// L'affichage des actions possibles ///////////////////
					////////////////////////////////////////////////////////
					echo "<td class = \"fond-actions\">";
						//echo "<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border=\"0\"></a>";
						//echo "<a href = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\" border=\"0\"></a>";
						//echo "<a href = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"22px\" border=\"0\"></a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}
	else
	{
		echo "<h2>$message_pas_d_enregistrement</h2>";
	}
	//Fermeture de la connexion &agrave; la BDD
	mysql_close();
?>
