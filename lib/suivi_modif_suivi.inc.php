<?php
////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_suivi="SELECT * FROM suivis AS s, util AS u, categorie_commune AS cc, suivis_categories_communes AS scc
		WHERE s.emetteur = u.ID_UTIL
			AND s.id = scc.id_suivi
			AND scc.id_categorie_commune = cc.id_categ
			AND s.id = '".$id_suivi."'";

	//echo "<br />$requete_suivi";

	$result_suivi=mysql_query($requete_suivi);
	$num_rows = mysql_num_rows($result_suivi);
	$ligne_suivi = mysql_fetch_object($result_suivi);
	$date_creation = $ligne_suivi->date_crea;
	$date_suivi = $ligne_suivi->date_suivi;
	$titre = $ligne_suivi->titre;
	$description = $ligne_suivi->description;
	$emetteur = $ligne_suivi->NOM;
	$dossier = $ligne_suivi->intitule_categ;
	$contact_type = $ligne_suivi->contact_type;
	$id_categorie_commune_a_afficher = $ligne_suivi->id_categorie_commune;
	$intitule_categ_a_afficher = $ligne_suivi->intitule_categ;
	$ecl = $ligne_suivi->ecl;

/*
	echo "<br />date_creation : $date_creation";
	echo "<br />date_suivi : $date_suivi";
	echo "<br />contact_type : $contact_type";
	echo "<br />id_categorie_commune_a_afficher : $id_categorie_commune_a_afficher";
	echo "<br />intitule_categ_a_afficher : $intitule_categ_a_afficher";
	echo "<br />ecl : $ecl";
*/
	//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections
	$date_creation_a_afficher = strtotime($date_creation);
	$date_creation_a_afficher = date('d/m/Y',$date_creation_a_afficher);

	/*
	$date_suivi_a_afficher = strtotime($date_suivi);
	$date_suivi_a_afficher = date('d/m/Y',$date_suivi_a_afficher);
	*/
	//echo "<br />origine : $origine";

	//Récupération des information de l'établissement du suivi pour alimenter l'option select
	$requete_etab = "SELECT * FROM etablissements WHERE RNE = '".$ecl."';";

	//echo "<br />$requete_etab";

	$resultat_requete_etab = mysql_query($requete_etab);
	$ligne3=mysql_fetch_object($resultat_requete_etab);

	$rne=$ligne3->RNE;
	$type_ecl=$ligne3->TYPE;
	$nom_ecl=$ligne3->NOM;
	$ville_ecl=$ligne3->VILLE;
/*
	echo "<br />rne : $rne";
	echo "<br />type_ecl : $type_ecl";
	echo "<br />nom_ecl : $nom_ecl";
	echo "<br />ville_ecl : $ville_ecl";
*/

////////////////////////////////////////////////////////////////////
// Affichage du formulaire pour saisir les modifications ///////////
////////////////////////////////////////////////////////////////////
	echo "<form action=\"suivi_accueil.php\" method=\"POST\">";
	echo "<table>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Emetteur&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$id_util."\" NAME = \"emetteur\">".$emetteur."</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Date cr&eacute;ation&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">$date_creation_a_afficher</td>";
		echo "</tr>";

		echo "<tr>
			<td class = \"etiquette\">Date du suivi&nbsp;:&nbsp;</td>
			<td>";

				echo "<input type=\"text\" id=\"date_suivi\"  name=\"date_suivi\" value=\"$date_suivi\" size = \"10\" required>";
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_suivi&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";

			echo "</td>
		</tr>
		<tr>
			<td class = \"etiquette\">EPLE/Ecole&nbsp;:&nbsp;</td>
			<td><select name = \"ecl\">";
				echo "<option selected = \"".$rne."\" VALUE = \"".$rne."\">".$rne." -- ".str_replace("*", " ",$type_ecl)." ".str_replace("*", " ",$nom_ecl). " -- ".$ville_ecl."</option>";

				//Récupération de la liste des établissements
				$requete_etab = "SELECT * FROM etablissements";
				$resultat_requete_etab = mysql_query($requete_etab);

				while ($ligne4=mysql_fetch_object($resultat_requete_etab))
				{
					$rne=$ligne4->RNE;
					$type_ecl=$ligne4->TYPE;
					$nom_ecl=$ligne4->NOM;
					$ville_ecl=$ligne4->VILLE;
					if ($rne <> $ecl)
					{
						echo "<option VALUE = \"".$rne."\">".$rne." -- ".str_replace("*", " ",$type_ecl)." ".str_replace("*", " ",$nom_ecl). " -- ".$ville_ecl."</option>";
					}
				}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				if ($titre == "")
				{
					echo "<span class = \"champ_obligatoire\">Sujet*&nbsp;:&nbsp;</span>";
				}
				else
				{
					echo "Sujet&nbsp;:&nbsp;";
				}
			echo "</td>";
			echo "<td><input type = \"text\" VALUE = \"".$titre."\" NAME = \"titre\" SIZE = \"64\" required placeholder=\"Titre du suivi\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				if ($contact_type == "")
				{
					echo "<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>";
				}
				else
				{
					echo "Type&nbsp;:&nbsp;";
				}
			echo "</td>
			<td>";

			remplir_champ_select("INTITULE","contacts_types","","contact_type","$contact_type");
			echo "</td>
		</tr>

		<tr>
			<td class = \"etiquette\"><b>Dossier concern&eacute;&nbsp;:&nbsp;</b></td>
			<td>";
				include("../biblio/init.php");
				//Je récupère l'intitulé de la catégorie commune à afficher
				//echo "<br />categorie_commune : $categorie_commune";
				/*
				if (ISSET($categorie_commune))
				{
					$requete_int_cat_com = "SELECT * FROM categorie_commune WHERE id_categ = $categorie_commune";
					$result_int_cat_com = mysql_query($requete_int_cat_com);
					$ligne = mysql_fetch_object($result_int_cat_com);
					$intitule_categ_a_afficher=$ligne->intitule_categ;
					$id_categ_a_afficher=$ligne->id_categ;
				}
				*/
				//Maintenant je recupère les autres intitulés
				$requete_cat="SELECT * FROM categorie_commune WHERE actif = 'O' ORDER BY intitule_categ ASC";
				$result=mysql_query($requete_cat);
				$num_rows = mysql_num_rows($result);
				echo "<select size=\"1\" name=\"categorie_commune\">";
				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"$id_categorie_commune_a_afficher\">$intitule_categ_a_afficher</option>";
					while ($ligne2=mysql_fetch_object($result))
					{
						$id_categ=$ligne2->id_categ;
						$intitule_categ=$ligne2->intitule_categ;
						if ($id_categ <> $id_categorie_commune_a_afficher)
						{
							echo "<option value=\"$id_categ\">$intitule_categ</option>";
						}
					}
				}
				echo "</select>";
			echo "</td>
		</tr>";

		echo "<tr>
			<td class = \"etiquette\">";
				if ($description == "")
				{
					echo "<span class = \"champ_obligatoire\">Description rapide du suivi*&nbsp;:&nbsp;</span>";
				}
				else
				{
					echo "Description&nbsp;:&nbsp;";
				}
			echo "</td>";
			echo "<td><textarea rows = \"15\" COLS = \"120\" NAME = \"description\" placeholder=\"Description du suivi\">".$description."</textarea>";
				echo "<script type=\"text/javascript\">CKEDITOR.replace( 'description' );</script>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class =\"etiquette\"></td>";
			echo "<td align = \"center\">";
				echo "<input type = \"hidden\" VALUE = \"$id_categorie_commune_a_afficher\" NAME = \"id_categorie_commune_original\">";
				echo "<input type = \"hidden\" VALUE = \"$id_suivi\" NAME = \"id_suivi\">";
				echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
				echo "<input type = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
				echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
				echo "<input type = \"hidden\" VALUE = \"enreg_modif_suivi\" NAME = \"a_faire\">";
				//echo "<input type = \"submit\" VALUE = \"Enregistrer le suivi\">";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	//echo "<span class = \"champ_obligatoire\">*champs obligatoires</span>";
	////////////////////////////////////////////////////////////
	// Boutons Retour et validation ////////////////////////////
	////////////////////////////////////////////////////////////
	echo "<table class = \"menu-boutons\">";
		echo "<tr>";
			echo "<td>";
				echo "<a href = \"".$origine.".php?visibilite=$visibilite\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
			echo "</td>";
			echo "<td>";
				echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le suivi\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
			echo "</td>";

/*
			if ($affiche_suivis_dossier == "O" OR $affiche_suivis_dossier_archives == "O")
			{
				echo "<td>";
				echo "<a href = \"suivi_ajout.php?etab=".$id_societe."&amp;origine=suivi_ajout&amp;visibilite=$visibilite&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacuterer un nouveau ticket\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouveau ticket</span><br />";
				echo "</td>";
			}
	*/
		echo "</tr>";
	echo "</table>";
echo "</form>";
////////////////////////////////////////////////////////////
// Fin formulaire de saisien ///////////////////////////////
////////////////////////////////////////////////////////////

?>
