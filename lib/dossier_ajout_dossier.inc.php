<?php
	//Transformation de la date de création extraite pour l'affichage
	$aujourdhui_jour = date('d',$date_rappel_a_afficher);
	$aujourdhui_mois = date('m',$date_rappel_a_afficher);
	$aujourdhui_annee = date('Y',$date_rappel_a_afficher);

	echo "<h2>Cr&eacute;ation d'un nouveau dossier</h2>";
	echo "<form method=\"get\" action=\"dossier_accueil.php\" name=\"AjoutDossier\">";
		echo "<table>";
			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Intitul&eacute; du Dossier&nbsp:&nbsp;</td>";
				echo "<td><input type=\"text\" name=\"intitule\" size=\"40\" required></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Description du dossier&nbsp;:&nbsp;</td>";
				echo "<td><textarea name=\"description\" cols=\"50\" rows=\"5\"></textarea></td>";
			echo "</tr>";

			//Désignation du respopnsable par défaut - la personne connectée
			
			//echo "<br />id_util : $id_util";
			
			$query_responsable_defaut = "SELECT NOM, PRENOM FROM util WHERE ID_UTIL = '".$_SESSION['id_util']."'";
			$results_responsable_defaut = mysql_query($query_responsable_defaut);
			$ligne_responsable_defaut = mysql_fetch_object($results_responsable_defaut);
			$responsable_nom_defaut =  $ligne_responsable_defaut->NOM;
			$responsable_prenom_defaut =  $ligne_responsable_defaut->PRENOM;
			$id_util = $_SESSION['id_util'];

			//On récupère les id des structures à la quelle la personne connéctée appartient
			$structures = recup_structure_util2($_SESSION['id_util']);
			
			//echo "<br >structures : $structures";

			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Responsable&nbsp;:&nbsp;</td>";
					$query_responsable = "SELECT * FROM util AS u, util_groupes AS ug
						WHERE visible = 'O' 
							AND u.ID_UTIL = ug.ID_UTIL
							AND ug.ID_GROUPE = '25'
						ORDER BY NOM";
					$results_responsable = mysql_query($query_responsable);
				echo "<td>";
					echo "<select size=\"1\" name=\"id_responsable\">";
					echo "<option selected value=\"$id_util\">$responsable_nom_defaut - $responsable_prenom_defaut</option>";
					while ($ligne_responsable = mysql_fetch_object($results_responsable))
					{
						$id_responsable = $ligne_responsable->ID_UTIL;
						$nom = $ligne_responsable->NOM;
						$prenom = $ligne_responsable->PRENOM;
						if ($id_responsable <> $id_util)
						{
							echo "<OPTION VALUE = \"".$id_responsable."\">".$nom." - ".$prenom."</OPTION>";
						}
					}
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";
/*
			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Personnes associ&eacute;es&nbsp;:&nbsp;<br /><small>Il est possible de s&eacute;lectionner plusieurs personnes</small></td>";
					//$query_util_associes = "SELECT DISTINCT ID_UTIL, NOM, PRENOM from util AS U, util_structures_util AS USU WHERE U.ID_UTIL = USU.FK_id_util AND USU.FK_id_structure IN $structures AND (U.DROIT <>'Super Administrateur' AND U.visible = 'O') ORDER BY NOM ASC";
					$query_util_associes = "SELECT DISTINCT ID_UTIL, NOM, PRENOM from util AS U, util_structures_util AS USU WHERE U.ID_UTIL = USU.FK_id_util AND USU.FK_id_structure IN $structures AND U.DROIT <>'Super Administrateur' AND U.visible = 'O' ORDER BY NOM ASC";
					
					//echo "<br />$query_util_associes";
						
					//$query_util_associes = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
					$results_util_associes = mysql_query($query_util_associes);
				echo "<td>";
					echo "<select size=\"8\" name=\"id_util_associes[]\" multiple>";
					echo "<option selected value=\"0\">Faire un choix</option>";
					while ($ligne_util_associes = mysql_fetch_object($results_util_associes))
					{
						$id_util_associes = $ligne_util_associes->ID_UTIL;
						$nom_associes = $ligne_util_associes->NOM;
						$prenom_associes = $ligne_util_associes->PRENOM;
						//if ($id_util_associes <> $_SESSION['id_util'])
						//{
							echo "<OPTION VALUE = \"".$id_util_associes."\">".$nom_associes." - ".$prenom_associes."</OPTION>";
						//}
					}
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";
*/
			echo "<tr>";
				echo "<td class = \"etiquette\"align = \"right\">Confidentialit&eacute;&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select size=\"1\" name=\"confidentialite\">";
					echo "<option selected value=\"PU\">Public</option>";
					echo "<option value=\"PR\">Priv&eacute;</option>";
					echo "</SELECT>";
				echo "</td>";
			echo "</tr>";

		echo "</table>";
		//echo "<a href=\"dossier_index.php\" title=\"Retour au module de gestion de dossier\" img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/retour.png\"></a>";
		
		// Les variables à retransmettre ///////////
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_dossier\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";


		// Boutons de validation et retour ////////
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"dossier_accueil.php?tri=$tri&amp;sense_tri=$sense_tri&amp;visibilite=$visibilite\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</TD>";
					echo "</tr>";
			echo "</table>";
		echo "</div>";

	
	
	echo "</form>";
