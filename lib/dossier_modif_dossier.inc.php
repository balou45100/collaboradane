<?php
	//echo "<br />id_dossier : $id_dossier";

	////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_dossier="SELECT * FROM categorie_commune AS cc, dos_dossier AS dd
		WHERE cc.id_categ = dd.idDossier
			AND id_categ = '$id_dossier'";

	//echo "<br />$requete_dossier";

	$result_dossier=mysql_query($requete_dossier);
	$num_rows = mysql_num_rows($result_dossier);


	$ligne_dossier = mysql_fetch_object($result_dossier);
	$id_dossier = $ligne_dossier->id_categ;
	$libelle_dossier = $ligne_dossier->intitule_categ;
	//$date_creation = $ligne_dossier->DateCreation;
	$description = $ligne_dossier->description_categ;
	$statut = $ligne_dossier->actif;
	//$visibilite = $ligne_dossier->visibilite;
	$responsable = $ligne_dossier->responsable;

/*
	echo "<br />id_dossier : $id_dossier";
	echo "<br />libelle_dossier : $libelle_dossier";
	echo "<br />date_creation : $date_creation";
	echo "<br />description : $description";
	echo "<br />statut : $statut";
	echo "<br />visibilite : $visibilite";
	echo "<br />responsable : $responsable";
*/

	// On récupère les variables pour le traitement des personnhes associées au dossier
	$modif_associes = $_GET['modif_associes']; 
	$type_action_associes = $_GET['type_action_associes']; 

	//$modif_associes = $_GET['modif_associes']; //On regarde si il y avait un changement côté des personnes associées
	//$id_exercice = $_GET['id_exercice'];

/*
	echo "<br />modif_associes : $modif_associes";
	echo "<br />id_dossier : $id_dossier";
	echo "<br>type_action_associes : $type_action_associes";
*/
	////// Début des différents traitements	///////////////////////////////////////////////////////
	if ($modif_associes == "O")
	{
		//echo "<h2>Il faut traiter les modification</h2>";
		switch ($type_action_associes)
		{
			case "- Ajouter >>":
				//echo "<h2>Il faut ajouter des collaborateurs</h2>";
				foreach ($_GET['associes'] as $valeur)
				{
						$requete = "INSERT INTO dos_dossier_util
							VALUE(NULL,".$_GET['id_dossier'].",".$valeur.")";
						$resultat = mysql_query($requete);
				}

			break;

			case "<< Retirer -":
				//echo "<h2>Il faut retirer des collaborateurs</h2>";
				foreach ($_GET['associes'] as $valeur)
				{
						$requete = "DELETE FROM dos_dossier_util
									where id_util = ".$valeur."
									and id_dossier = ".$_GET['id_dossier'];
						$resultat = mysql_query($requete);
				}
			break;
		}
	}

	//////////////////////////////////////////////////////////////////////////////
	// Procédure d'attribution et retraction des personnes associées au dossier //
	//////////////////////////////////////////////////////////////////////////////
	echo "<form action=\"dossier_accueil.php\" method=\"GET\">";
	echo "<table align = \"center\">";
		echo "<tr>";
			echo "<th COLSPAN = \"2\">";
				echo "Collaborateur/ trices associ&eacute;-e-s";
				echo "</th>";
		echo "</tr>";

		echo "<tr>";
			echo "<td>";
			echo "<select size=\"10\" name=\"associes[]\" multiple>";

			//Selection des utilisateurs qui ne sont PAS dans le groupe actuel
			$requete = "SELECT u.PRENOM, u.NOM, u.ID_UTIL
						FROM util AS u, util_groupes AS ug
						WHERE u.ID_UTIL not in (SELECT u.ID_UTIL
												FROM dos_dossier_util AS ddu, util AS u
												WHERE u.ID_UTIL = ddu.id_util
													AND id_dossier = ".$id_dossier.")
									AND u.visible = 'O'
									AND u.ID_UTIL = ug.ID_UTIL
									AND ug.ID_GROUPE = '25'
									ORDER BY nom";
			$resultat = mysql_query($requete);
			$num_rows = mysql_num_rows($resultat);

			if (mysql_num_rows($resultat))
			{
				while ($ligne=mysql_fetch_array($resultat))
				{
					if ($ligne[2] <> $responsable)
					{
						echo"<option value=\"".$ligne[2]."\">".$ligne[0]." ".$ligne[1]."</option>";
					}
				}
			}
			echo "<input type='hidden' name = 'groupe' value='".$groupe_en_cours."'>";

			echo "</select>";
			echo "<input type=\"submit\" name=\"type_action_associes\" value=\"- Ajouter >>\">";
			echo "<input type=\"hidden\" name = \"action\" value = \"O\">";
			echo "<input type=\"hidden\" name = \"a_faire\" value = \"modif_dossier\">";
			echo "<input type=\"hidden\" name = \"modif_associes\" value = \"O\">";
			echo "<input type=\"hidden\" name = \"id_dossier\" value = \"$id_dossier\">";
			echo "<input type=\"hidden\" name = \"visibilite\" value = \"$visibilite\">";
			echo "<input type=\"hidden\" name = \"tri\" value = \"$tri\">";
			echo "<input type=\"hidden\" name = \"sense_tri\" value = \"$sense_tri\">";
		echo "</form>";
		
		echo "</td>";
		echo "<td>";
		echo "<form action=\"dossier_accueil.php\" method=\"GET\">";
			//echo "<input type=\"submit\" value=\"<< Retirer -\" name=\"retirer\">";
			echo "<input type=\"submit\" name=\"type_action_associes\" value=\"<< Retirer -\">";
			echo "<select size=\"10\" name=\"associes[]\" multiple>";

			//Selection des utilisateurs qui sont dans le groupe actuel
			$requete = "SELECT u.PRENOM, u.NOM, u.ID_UTIL
						FROM util AS u
						WHERE ID_UTIL in (SELECT u.ID_UTIL
												FROM dos_dossier_util AS ddu, util AS u
												WHERE u.ID_UTIL = ddu.id_util
													AND id_dossier = ".$id_dossier.")
									AND u.visible = 'O'
									ORDER BY nom";

			$resultat = mysql_query($requete);
			$num_rows = mysql_num_rows($resultat);

			if (mysql_num_rows($resultat))
			{
				while ($ligne=mysql_fetch_array($resultat))
				{
					echo"<option value=\"".$ligne[2]."\">".$ligne[0]." ".$ligne[1]."</option>";
				}
			}
			//echo "<input type='hidden' name = 'groupe' value='".$groupe_en_cours."'>";

			echo "</select>";
			echo "<input type=\"hidden\" name = \"action\" value = \"O\">";
			echo "<input type=\"hidden\" name = \"a_faire\" value = \"modif_dossier\">";
			echo "<input type=\"hidden\" name = \"modif_associes\" value = \"O\">";
			echo "<input type=\"hidden\" name = \"id_dossier\" value = \"$id_dossier\">";
			echo "<input type=\"hidden\" name = \"visibilite\" value = \"$visibilite\">";
			echo "<input type=\"hidden\" name = \"tri\" value = \"$tri\">";
			echo "<input type=\"hidden\" name = \"sense_tri\" value = \"$sense_tri\">";
		echo "</td>";
		echo "</form>";
	echo "</tr>";
echo "</table>";

	//////////////////////////////////////////////////////////////////////////////////
	// Fin procédure d'attribution et retraction des personnes associées au dossier //
	//////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////
	// Procédure de modification des données de base du dossier //
	//////////////////////////////////////////////////////////////
	echo "<form action=\"dossier_accueil.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\">";
		echo "<tr>";
			echo "<td class = \"etiquette\">Identifiant&nbsp;:&nbsp;</td>";
			echo "<td>$id_dossier</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Libell&eacute;&nbsp;:&nbsp;</td>";
				echo "<td><input type=\"text\" name=\"libelleDossier\" size=\"40\" value=\"$libelle_dossier\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Desription &nbsp;:&nbsp;</td>";
			echo "<td><TEXTAREA name=\"description\" rows=3 COLS=60>$description</TEXTAREA></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Dossier actif&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_etat\" name=\"statut\">";
				if ($statut == "O")
				{
					echo "<option selected value=\"O\">Oui</option>";
					echo "<option value=\"N\">Non</option>";
				}
				elseif ($statut == "N")
				{
					echo "<option selected value=\"N\">Non</option>";
					echo "<option value=\"O\">Oui</option>";
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
				//On récupère l'id du responsable du dossier
				//$requete_util = "SELECT ID_UTIL, nom, prenom FROM util AS u, dos_dossier_util AS ddu
				//	WHERE u.ID_UTIL = ddu.id_util AND ddu.role = 2;";
				$requete_responsable = "SELECT ID_UTIL, NOM, PRENOM FROM util
						WHERE ID_UTIL = '".$responsable."';";

				//echo "<br />$requete_responsable";

				$resultat_util = mysql_query($requete_responsable);
				$ligne_util = mysql_fetch_object($resultat_util);
				$id_util_responsable_dans_base = $ligne_util->ID_UTIL;
				$nom_util_responsable_dans_base = $ligne_util->NOM;
				$prenom_util_responsable_dans_base = $ligne_util->PRENOM;
			echo "<td class = \"etiquette\">Responsable&nbsp;:&nbsp;";
					$query_responsable = "SELECT * FROM util AS u, util_groupes AS ug
					 	WHERE u.visible = 'O'
							AND u.ID_UTIL = ug.ID_UTIL
							AND ug.ID_GROUPE = '25'
							ORDER BY NOM";
					$results_responsable = mysql_query($query_responsable);
				echo "<td>";
					echo "<select size=\"1\" name=\"id_responsable\">";
					echo "<option selected value=\"$id_util_responsable_dans_base\">$nom_util_responsable_dans_base - $prenom_util_responsable_dans_base</option>";
					while ($ligne_responsable = mysql_fetch_object($results_responsable))
					{
						$id_responsable = $ligne_responsable->ID_UTIL;
						$nom = $ligne_responsable->NOM;
						$prenom = $ligne_responsable->PRENOM;
						if ($id_responsable <> $id_util_responsable_dans_base)
						{
							echo "<OPTION VALUE = \"".$id_responsable."\">".$nom." - ".$prenom."</OPTION>";
						}
					}
					echo "</SELECT>";

			echo "</td>";
			echo "<td>$nom_util_responsable, $prenom_util_responsable</td>";
		echo "</tr>";
	echo "</table>";
	echo "<p>";
		//echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>";
		//echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_dossier\" NAME = \"id_dossier\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"maj_dossier\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_util_responsable_dans_base\" NAME = \"id_util_responsable_dans_base\">";
	echo "</p>";

	// Boutons de validation et retour ////////";

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
?>
