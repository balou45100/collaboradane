<?php
	$autorisation_formation = verif_appartenance_groupe(5);
	$module = "FOR"; //n&eacute;cessaire pour le script qui ajoute des documents &agrave; une formation
	$dossier = $dossier_docs_formation;
	//echo "<h2> Page en pr&eacute;paration</h2>";
	//on extrait les formations concernant l'&eacute;tablissement
	//AND annee_scolaire LIKE '".$annee_scolaire."'
	//echo "<br />annee_en_cours : $annee_en_cours - annee_scolaire : $annee_scolaire";
	$query = "SELECT * FROM formations WHERE rne = '".$id_societe."' ORDER BY annee_scolaire DESC, id_formation DESC;";
	$results = mysql_query($query);
	
	//echo "<br />autorisation_formation : $autorisation_formation";
	
	if(!$results)
	{
		echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
		echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
		mysql_close();
		exit;
	}

	if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
	{
		echo "<h2>Formations</h2>";
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_formation\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer une nouvelle formation\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle formation</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
/*
		echo "<br />";
		echo "<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_formation\" target = \"body\"><FONT COLOR = \"#000000\"><b>Ajouter une formation<b></FONT></a><br />";
		echo "<br />";
*/
	}

	//Retourne le nombre de ligne rendu par la requ&egrave;te
	$num_results = mysql_num_rows($results);
	//echo "<br />num_results : $num_results";
	if ($num_results >0)
	{
		//Affichage de l'entête du tableau
		echo "<table width = \"95%\">
			<!--CAPTION><b>Nombre de formations r&eacute;alis&eacute;es&nbsp;:&nbsp;$num_results</b></CAPTION-->
				<tr>
					<th>ID</td>";
					echo "<th>Ann&eacute;e scolaire</th>";
					echo "<th>Type formation</th>";
					echo "<th>Documents</th>";
          
					if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
					{
						echo "<th>
							ACTIONS
						</th>";
					}
				echo "</tr>";

					//Traitement de chaque ligne
				$res = mysql_fetch_row($results);
				//if ($nombre_de_page)
				for ($i = 0; $i < $num_results; ++$i)
				{
				  if ($res[0] <>"")
					{
						echo "<TR class = \"new\">";
							echo "<td align = \"center\">";
								echo $res[0];
							echo "</td>";
							echo "<td align = \"center\">";
								echo $res[1];
							echo "</td>";
							echo "<td>";
								echo $res[2];
							echo "</td>";
							echo "<td>";
							//affichage des documents joints
							include ("affiche_documents_joints_formations.inc.php");
							echo "</td>";
								//Les actions
								if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
								{
									echo "<td class = \"fond-actions\">&nbsp;";
										echo "<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=modif_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la formation\" border=\"0\"></a>
										<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;annee=".$res[1]."&amp;type=".$res[2]."&amp;rne=".$res[3]."&amp;module=$module&amp;id_societe=$id_societe&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"Ajouter un document\" title=\"Ajouter un document\" border=\"0\"></a>
										<!--A HREF = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=copie_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier la formation\" border=\"0\"></A-->
										<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=suppression_formation\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer la formation\" border=\"0\"></a>";
										//echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></a>";
										//echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\"></a>";
										//echo "<a href = \"formations_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></a>";
										//echo "<a href = \"formations_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></a>";
									echo "</td>";	
								}
						echo "</tr>";
					}
					$res = mysql_fetch_row($results);
				}
				echo "</table>";
				//Fermeture de la connexion &agrave; la BDD
				mysql_close();
	}
	else
	{
		echo "<h2>Pas de formations&nbsp;!</h2>";
	}        
?>
