<?php
////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_evenement="SELECT * FROM evenements AS e, util AS u, categorie_commune AS cc
		WHERE e.fk_id_util = u.ID_UTIL
			AND e.fk_id_dossier = cc.id_categ
			AND e.id_evenement = '".$id_evenement."'";

	//echo "<br />$requete_evenement";

	$result_evenement=mysql_query($requete_evenement);
	$num_rows = mysql_num_rows($result_evenement);
	$ligne_evenement = mysql_fetch_object($result_evenement);

	$titre_evenement = $ligne_evenement->titre_evenement;
	$date_evenement_debut = $ligne_evenement->date_evenement_debut;
	$date_evenement_fin = $ligne_evenement->date_evenement_fin;
	$heure_debut_evenement = $ligne_evenement->heure_debut_evenement;
	$heure_fin_evenement = $ligne_evenement->heure_fin_evenement;
	$fk_id_util = $ligne_evenement->fk_id_util;
	$responsable  = $ligne_evenement->NOM;
	$fk_rne = $ligne_evenement->fk_rne;
	$fk_id_dossier = $ligne_evenement->fk_id_dossier;
	$detail_evenement = $ligne_evenement->detail_evenement;
	$fk_repertoire = $ligne_evenement->fk_repertoire;
	$autre_lieu = $ligne_evenement->autre_lieu;
	

/*
	echo "<br />titre_evenement : $titre_evenement";
	echo "<br />date_evenement : $date_evenement";
	echo "<br />heure_debut_evenement : $heure_debut_evenement";
	echo "<br />heure_fin_evenement : $heure_fin_evenement";
	echo "<br />fk_id_util : $fk_id_util";
	echo "<br />fk_rne : $fk_rne";
	echo "<br />fk_id_dossier : $fk_id_dossier";
	echo "<br />detail_evenement : $detail_evenement";
*/
	//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections
	$date_creation_a_afficher = strtotime($date_creation);
	$date_creation_a_afficher = date('d/m/Y',$date_creation_a_afficher);

/*
	$date_evenement_a_afficher = strtotime($date_evenement);
	$date_evenement_a_afficher = date('d/m/Y',$date_evenement_a_afficher);
*/
	$date_debut_a_afficher = $date_evenement_debut;
	$date_fin_a_afficher = $date_evenement_fin;
	//echo "<br />origine : $origine";

	//Récupération des information de l'établissement du evenement pour alimenter l'option select
	$requete_etab = "SELECT * FROM etablissements WHERE RNE = '".$fk_rne."';";

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
	//Récupération des information de la société pour alimenter l'option select
	$requete_societe = "SELECT * FROM repertoire WHERE No_societe = '".$fk_repertoire."';";

	//echo "<br />$requete_etab";

	$resultat_requete_repertoire = mysql_query($requete_societe);
	$ligne4=mysql_fetch_object($resultat_requete_repertoire);

	$id_societe=$ligne4->No_societe;
	$intitule_societe=$ligne4->societe;
	$ville_societe=$ligne4->ville;

////////////////////////////////////////////////////////////////////
// Affichage du formulaire pour saisir les modifications ///////////
////////////////////////////////////////////////////////////////////
	echo "<form action=\"evenements_accueil.php\" method=\"POST\">";
	echo "<table>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Responsable&nbsp;:&nbsp;</td>";
				//On vérifie si la personne connectée peut saisir un évènement pour quelqu'un d'autre
				if($niveau_droits >2)
				{
					//On récupère la liste des personnes autorisées de créer des événements
					//echo "en pr&eacute;paration";
					//echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$id_util."\" NAME = \"fk_id_util\">".$emetteur."</td>";
					
					$query_utils = "SELECT * FROM util AS U,util_groupes AS UG 
						WHERE U.ID_UTIL = UG.ID_UTIL
							AND visible = 'O'
							AND UG.ID_GROUPE = '33'
						ORDER BY NOM";
					$results_utils = mysql_query($query_utils);

					//echo "echo <td>Choisissez le/la responsable de l'&eacute;v&eacute;nement dans la liste d&eacute;roulante&nbsp;:&nbsp;";
					echo "<td>";
					//$no = mysql_num_rows($results_utils);
						echo "<SELECT NAME = \"fk_id_util\">";
						echo "<OPTION selected VALUE = \"".$fk_id_util."\">".$responsable."</OPTION>";
							while ($ligne_utils = mysql_fetch_object($results_utils))
							{
								$id_util = $ligne_utils->ID_UTIL;
								$nom = $ligne_utils->NOM;
								//$prenom = $ligne_utils->PRENOM;
								if($nom <> $emetteur)
								{
									echo "<OPTION VALUE = \"".$id_util."\">".$nom."</OPTION>";
								}
							}
						echo "</SELECT>";
					echo "</td>";
				}
				else
				{
					echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$fk_id_util."\" NAME = \"fk_id_util\">".$responsable."</td>";
				}
			echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date cr&eacute;ation&nbsp;:&nbsp;</td>";
			echo "<td>&nbsp;<input type = \"hidden\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">$date_creation_a_afficher</td>";
		echo "</tr>";

		echo "<tr>
			<td class = \"etiquette\">Date d&eacute;but de l&eacute;v&eacute;nement&nbsp;:&nbsp;</td>
			<td>";

				echo "<input type=\"text\" id=\"date_evenement_debut\"  name=\"date_evenement_debut\" value=\"$date_debut_a_afficher\" size = \"10\">";
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_evenement_debut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";

			echo "</td>
		</tr>";

		echo "<tr>
			<td class = \"etiquette\">Date fin de l&eacute;v&eacute;nement (facultatif)&nbsp;:&nbsp;</td>
			<td>";

				echo "<input type=\"text\" id=\"date_evenement_fin\"  name=\"date_evenement_fin\" value=\"$date_fin_a_afficher\" size = \"10\">";
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_evenement_fin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
			echo "</td>
		</tr>";

		echo "<tr>";
		echo "<td class = \"etiquette\">";
			echo "Horaire de d&eacute;but&nbsp;:&nbsp;";
			//echo "<td class = \"etiquette\">Horaire de d&eacute;but&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select  size=\"1\" name = \"heure_debut_evenement\">";
					echo "<option selected value=\"$heure_debut_evenement\" class = \"bleu\">$heure_debut_evenement</option>";
					echo "<option value=\"09:00:00\" class = \"bleu\">09H00</option>";
					echo "<option value=\"09:30:00\" class = \"bleu\">09H30</option>";
					echo "<option value=\"10:00:00\" class = \"bleu\">10H00</option>";
					echo "<option value=\"10:30:00\" class = \"bleu\">10H30</option>";
					echo "<option value=\"11:00:00\" class = \"bleu\">11H00</option>";
					echo "<option value=\"11:30:00\" class = \"bleu\">11H30</option>";
					echo "<option value=\"12:00:00\" class = \"bleu\">12H00</option>";
					echo "<option value=\"12:30:00\" class = \"bleu\">12H30</option>";
					echo "<option value=\"13:00:00\" class = \"bleu\">13H00</option>";
					echo "<option value=\"13:30:00\" class = \"bleu\">13H30</option>";
					echo "<option value=\"14:00:00\" class = \"bleu\">14H00</option>";
					echo "<option value=\"14:30:00\" class = \"bleu\">14H30</option>";
					echo "<option value=\"15:00:00\" class = \"bleu\">15H00</option>";
					echo "<option value=\"15:30:00\" class = \"bleu\">15H30</option>";
					echo "<option value=\"16:00:00\" class = \"bleu\">16H00</option>";
					echo "<option value=\"16:30:00\" class = \"bleu\">16H30</option>";
					echo "<option value=\"17:00:00\" class = \"bleu\">17H00</option>";
					echo "<option value=\"17:30:00\" class = \"bleu\">17H30</option>";
					echo "<option value=\"18:00:00\" class = \"bleu\">18H00</option>";
				echo "</select>";
			echo "</td>";

		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Horaire de fin&nbsp;:&nbsp;";
			//echo "<td class = \"etiquette\">Horaire de fin&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select  size=\"1\" name = \"heure_fin_evenement\">";
					echo "<option selected value=\"$heure_fin_evenement\" class = \"bleu\">$heure_fin_evenement</option>";
					echo "<option value=\"10:00:00\" class = \"bleu\">10H00</option>";
					echo "<option value=\"10:30:00\" class = \"bleu\">10H30</option>";
					echo "<option value=\"11:00:00\" class = \"bleu\">11H00</option>";
					echo "<option value=\"11:30:00\" class = \"bleu\">11H30</option>";
					echo "<option value=\"12:00:00\" class = \"bleu\">12H00</option>";
					echo "<option value=\"12:30:00\" class = \"bleu\">12H30</option>";
					echo "<option value=\"13:00:00\" class = \"bleu\">13H00</option>";
					echo "<option value=\"13:30:00\" class = \"bleu\">13H30</option>";
					echo "<option value=\"14:00:00\" class = \"bleu\">14H00</option>";
					echo "<option value=\"14:30:00\" class = \"bleu\">14H30</option>";
					echo "<option value=\"15:00:00\" class = \"bleu\">15H00</option>";
					echo "<option value=\"15:30:00\" class = \"bleu\">15H30</option>";
					echo "<option value=\"16:00:00\" class = \"bleu\">16H00</option>";
					echo "<option value=\"16:30:00\" class = \"bleu\">16H30</option>";
					echo "<option value=\"17:00:00\" class = \"bleu\">17H00</option>";
					echo "<option value=\"17:30:00\" class = \"bleu\">17H30</option>";
					echo "<option value=\"18:00:00\" class = \"bleu\">18H00</option>";
					echo "<option value=\"18:30:00\" class = \"bleu\">18H30</option>";
					echo "<option value=\"19:00:00\" class = \"bleu\">19H00</option>";
					echo "<option value=\"19:30:00\" class = \"bleu\">19H30</option>";
					echo "<option value=\"20:00:00\" class = \"bleu\">20H00</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Titre&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td><input type = \"text\" VALUE = \"".$titre_evenement."\" NAME = \"titre_evenement\" SIZE = \"64\" placeholder=\"Titre de l'&eacute;v&eacute;nement\"></td>";
		echo "</tr>";

		echo "<tr>
			<td class = \"etiquette\"><b>Dossier concern&eacute;&nbsp;:&nbsp;</b></td>
			<td>";
				include("../biblio/init.php");
				//Je récupère l'intitulé de la catégorie commune à afficher
				//echo "<br />fk_id_dossier : $fk_id_dossier";
				
				$requete_int_cat_com = "SELECT * FROM categorie_commune WHERE id_categ = $fk_id_dossier";
				$result_int_cat_com = mysql_query($requete_int_cat_com);
				$ligne = mysql_fetch_object($result_int_cat_com);
				$intitule_categ_a_afficher=$ligne->intitule_categ;
				//$id_categ_a_afficher=$ligne->id_categ;
				
				//Maintenant je recupère les autres intitulés
				$requete_cat="SELECT * FROM categorie_commune WHERE actif = 'O' AND id_categ <> ".$fk_id_dossier." ORDER BY intitule_categ ASC";
				$result=mysql_query($requete_cat);
				$num_rows = mysql_num_rows($result);
				echo "<select size=\"1\" name=\"fk_id_dossier\">";
				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"$fk_id_dossier\">$intitule_categ_a_afficher</option>";
					while ($ligne2=mysql_fetch_object($result))
					{
						$id_categ=$ligne2->id_categ;
						$intitule_categ=$ligne2->intitule_categ;
						echo "<option value=\"$id_categ\">$intitule_categ</option>";
					}
				}
				echo "</select>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>
			<td class = \"etiquette\">";
				echo "D&eacute;tail&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td><textarea rows = \"15\" COLS = \"120\" NAME = \"detail_evenement\" placeholder=\"Description de l'&eacute;v&eacute;nement\">".$detail_evenement."</textarea>";
				echo "<script type=\"text/javascript\">CKEDITOR.replace('detail_evenement');</script>";
			echo "</td>";
		echo "</tr>";

		/////////////////////////////////
		// Proposition des lieux ////////
		/////////////////////////////////

		// les ECL
		echo "<tr>
			<td class = \"etiquette\">EPLE / &Eacute;cole&nbsp;:&nbsp;</td>
			<td><select name = \"fk_rne\">";
				echo "<option selected = \"".$rne."\" VALUE = \"".$rne."\">".$rne." -- ".str_replace("*", " ",$type_ecl)." ".str_replace("*", " ",$nom_ecl). " -- ".$ville_ecl."</option>";
				echo "<option VALUE = \"\">-- --</option>";
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
						
		// Les sociéte de la table repertoire
		$requete_repertoire = "SELECT * FROM repertoire ORDER BY societe ASC";
		$resultat_repertoire = mysql_query($requete_repertoire);

		if(!$resultat_repertoire)
		{
			echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
			//echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
			//mysql_close();
			exit;
		}
		
		$nb_societes = mysql_num_rows($resultat_repertoire);
		echo "<tr>";
			echo "<td class = \"etiquette\">Structures non EN&nbsp;:&nbsp;</td>";
				echo "<td><select name = \"fk_repertoire\">";
				if ($id_societe <> "")
				{
					echo "<option selected value=\"$id_societe\">$intitule_societe, $ville_societe</option>";
				}
				else
				{
					echo "<option selected value=\"\">-- --</option>";
				}
				echo "<option VALUE = \"0\">-- --</option>";
				while ($ligne_repertoire = mysql_fetch_object($resultat_repertoire))
				{
					$id_societe = $ligne_repertoire->No_societe;
					$intitule_societe = $ligne_repertoire->societe;
					$ville_societe = $ligne_repertoire->ville;
					echo "<option VALUE = \"".$id_societe."\">".$intitule_societe.", ".$ville_societe."</option>";
				}
				echo "</select>";
			echo "</td>";
		echo "</tr>";

		// Un autre lieu
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				echo "Autre lieu (Intitul&eacute;, Ville, Adresse)&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td><input type = \"text\" VALUE = \"$autre_lieu\" NAME = \"autre_lieu\" SIZE = \"100\" placeholder=\"Autre lieu (Intitul&eacute;, Ville, Adresse)\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class =\"etiquette\"></td>";
			echo "<td align = \"center\">";
				echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
				echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
			echo "</td>";

		/////////////////////////////////////
		// Fin proposition des lieux ////////
		/////////////////////////////////////

		echo "<tr>";
			echo "<td class =\"etiquette\"></td>";
			echo "<td align = \"center\">";
				echo "<input type = \"hidden\" VALUE = \"$id_categorie_commune_a_afficher\" NAME = \"id_categorie_commune_original\">";
				echo "<input type = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
				echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
				echo "<input type = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
				echo "<input type = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
				echo "<input type = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
				echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
				echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
				echo "<input type = \"hidden\" VALUE = \"maj_evenement\" NAME = \"a_faire\">";
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
				echo "<a href = \"".$origine.".php?&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;visibilite=".$visibilite."&amp;date_filtre=".$date_filtre."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
			echo "</td>";
			echo "<td>";
				echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le suivi\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
echo "</form>";
////////////////////////////////////////////////////////////
// Fin formulaire de saisie ////////////////////////////////
////////////////////////////////////////////////////////////

?>
