<?php
/*
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<tr>";
//			echo "<td><img src = \"$chemin_theme_images/logo_dane.png\"></IMG></td>";
			echo "<td align=\"center\"><h2>&nbspListe d'&eacute;margements</h2></td>";
		echo "</tr>";
	echo "</table>";
*/
	//echo "<br />id_evenement : $id_evenement";
	
	//Largeur du tableau
	$largeur_tableau = "95%";
	
	//Il faut récupérer les informations concernant l'événement
	$requete_evenement="SELECT * FROM evenements WHERE id_evenement= '$id_evenement'";

	//echo "<br />$requete_evenement";
	
	$resultat_evenement=mysql_query($requete_evenement);
	$num_rows = mysql_num_rows($resultat_evenement);
	
	$ligne_evenement = mysql_fetch_object($resultat_evenement);
	
	$id_evenement = $ligne_evenement->id_evenement;
	$titre_evenement = $ligne_evenement->titre_evenement;
	$date_evenement_debut = $ligne_evenement->date_evenement_debut;
	$date_evenement_fin = $ligne_evenement->date_evenement_fin;
	$heure_debut_evenement = $ligne_evenement->heure_debut_evenement;
	$heure_fin_evenement = $ligne_evenement->heure_fin_evenement;
	$fk_id_util = $ligne_evenement->fk_id_util;
	$fk_rne = $ligne_evenement->fk_rne;
	$fk_id_dossier = $ligne_evenement->fk_id_dossier;
	$fk_repertoire = $ligne_evenement->fk_repertoire;
	$autre_lieu = $ligne_evenement->autre_lieu;
	$detail_evenement = $ligne_evenement->detail_evenement;
	
	//On retire les secondes pour l'affichage
	$heure_debut_evenement = substr($heure_debut_evenement, 0, 5);
	$heure_fin_evenement = substr($heure_fin_evenement, 0, 5);

	/*
	echo "<br />id_evenement : $id_evenement";
	echo "<br />titre_evenement : $titre_evenement";
	echo "<br />date_evenement : $date_evenement";
	echo "<br />heure_debut_evenement : $heure_debut_evenement";
	echo "<br />heure_fin_evenement : $heure_fin_evenement";
	echo "<br />fk_id_util : $fk_id_util";
	echo "<br />fk_rne : $fk_rne";
	echo "<br />fk_id_dossier : $fk_id_dossier";
	echo "<br />detail_evenement : $detail_evenement";
	*/
	//Transformation des dates extraites pour l'affichage
	$date_debut_a_afficher = strtotime($date_evenement_debut);
	//echo "<br />date_debut_a_afficher : $date_debut_a_afficher";
	$date_debut_a_afficher = date('d-m-Y',$date_debut_a_afficher);
	//echo "<br />date_debut_a_afficher : $date_debut_a_afficher";

	if ($date_evenement_fin <> "0000-00-00")
	{
		$date_fin_a_afficher = strtotime($date_evenement_fin);
		//echo "<br />date_evenement_a_afficher : $date_evenement_a_afficher";
		$date_fin_a_afficher = date('d-m-Y',$date_fin_a_afficher);
		//echo "<br />date_evenement_a_afficher : $date_evenement_a_afficher";
	}
	echo "<table border = \"1\" align = \"center\" width = \"$largeur_tableau\">";
		echo "<tr>";
			echo "<td align=\"center\"><h2>$titre_evenement</h2></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td align=\"center\">";
				if ($date_evenement_fin <> "0000-00-00")
				{
					echo "<h2>$date_debut_a_afficher - $date_fin_a_afficher</h2>";
				}
				else
				{
					echo "<h2>$date_debut_a_afficher</h2>";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td align=\"center\">";
				echo "<h2>$heure_debut_evenement - $heure_fin_evenement</h2>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td align=\"center\">";
				echo "<h2>";
					affiche_lieu_evenement($fk_rne, $fk_repertoire, $autre_lieu);
				echo "</h2>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";

	// On affiche les participants
	
	$requete_participants = "SELECT * FROM evenements_participants as ep, personnes_ressources_tice as prt
		WHERE ep.id_participant = prt.id_pers_ress
			AND ep.id_evenement = $id_evenement
		ORDER by prt.nom";
	
	//echo "<br />$requete_participants";
	
	$resultat_requete_participants=mysql_query($requete_participants);
	$num_rows = mysql_num_rows($resultat_requete_participants);
	echo "<br />";
	echo "<h2>Participants ($num_rows)</h2>";
	echo "<table border = \"1\" align = \"center\" width = \"$largeur_tableau\">";
		echo "<colgroup>";
			echo "<col width=\"40%\">";
			echo "<col width=\"30%\">";
			echo "<col width=\"30%\">";
			//echo "<col width=\"30%\">";
		echo "</colgroup>";
		echo "<tr>";
			echo "<th>";
				echo "Nom, Pr&eacute;nom";
			echo "</th>";
			echo "<th>";
				echo "Rattachement";
			echo "</th>";
/*
			echo "<th>";
				echo "";
			echo "</th>";
*/
			echo "<th>";
				echo "Signature";
			echo "</th>";
		echo "</tr>";

		//On initialise un compteur pour insérer un saut de page si nécessaire
		$compteur = 0;
		$compteur_page = 1;
		$maxi_page1 = 13;
		$maxi_autres_pages = 19;
		//Calcul du nombre de page globale
		$nombre_pages = ceil((($num_rows - $maxi_page1) / $maxi_autres_pages)+1);
		//echo "nombre_pages : $nombre_pages";
		
		while ($ligne_participant=mysql_fetch_object($resultat_requete_participants))
		{
			$compteur++;
			//echo "Page $compteur_page - $compteur - ";
			if (($compteur_page == 1 AND $compteur > $maxi_page1) OR ($compteur_page > 1 AND $compteur > $maxi_autres_pages))
			{
				$compteur = 0;
				$compteur_page_a_afficher = $compteur_page;
				$compteur_page = $compteur_page + 1;
				//On ferme le tableau
				echo "</tr></table>";
				//On rajoute le compteur de page
				echo "<br />Liste &eacute;margement pour $titre_evenement - $date_debut_a_afficher<br />Page $compteur_page_a_afficher / $nombre_pages";
				//on insère le saut de page
				echo "<div STYLE=\"page-break-before:always\"></div>";
				//On ouvre le tableau à nouveau
				echo "<table border = \"1\" align = \"center\" width = \"$largeur_tableau\">";
					echo "<colgroup>";
						echo "<col width=\"40%\">";
						echo "<col width=\"30%\">";
						echo "<col width=\"30%\">";
						//echo "<col width=\"30%\">";
					echo "</colgroup>";
					echo "<tr>";
						echo "<th>";
							echo "Nom, Pr&eacute;nom";
						echo "</th>";
						echo "<th>";
							echo "Rattachement";
						echo "</th>";
			/*
						echo "<th>";
							echo "";
						echo "</th>";
			*/
						echo "<th>";
							echo "Signature";
						echo "</th>";
					echo "</tr>";
			}
			$nom_participant = $ligne_participant->nom;
			$prenom_participant = $ligne_participant->prenom;
			$etab_participant = $ligne_participant->codetab;
			
			echo "<tr>";
				echo "<td>$nom_participant<br />$prenom_participant</td>";
				//echo "<td>$etab_participant</td>";
				//echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	echo "</table>";
	//On rajoute le compteur de page final
	echo "<br />Liste &eacute;margement pour $titre_evenement - $date_debut_a_afficher<br />Page $compteur_page / $nombre_pages";
	//echo "<br /><br />Page $compteur_page / $nombre_pages";
?>
