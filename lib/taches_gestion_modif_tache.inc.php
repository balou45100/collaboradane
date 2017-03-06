<?php

////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_tache="SELECT * FROM taches WHERE id_tache = '$id'";
	$result_tache=mysql_query($requete_tache);
	$num_rows = mysql_num_rows($result_tache);
	$ligne_tache = mysql_fetch_object($result_tache);
	$id_tache = $ligne_tache->id_tache;
	$date_creation = $ligne_tache->date_creation;
	$date_echeance = $ligne_tache->date_echeance;
	$date_rappel = $ligne_tache->date_rappel;
	$description = $ligne_tache->description;
	$etat = $ligne_tache->etat;
	$visibilite = $ligne_tache->visibilite;
	$priorite = $ligne_tache->priorite;
	//$id_util_creation = $ligne_tache->id_util_creation;
	//$id_util_traitant = $ligne_tache->id_util_traitant;
	$observation = $ligne_tache->observation;
	//echo "<br />observation : $observation";

	//On regarde qui est le créateur de la tâche
	$requete_createur="SELECT * FROM taches_util WHERE id_tache = '".$id."' AND (statut_cta = '100' OR statut_cta = '110')";
	$result_createur=mysql_query($requete_createur);
	$num_rows = mysql_num_rows($result_createur);
	$ligne_createur = mysql_fetch_object($result_createur);
	$id_createur = $ligne_createur->id_util;

	//On regarde qui traite la tâche
	$requete_traitant="SELECT * FROM taches_util WHERE id_tache = '".$id."' AND (statut_cta = '110' OR statut_cta = '010')";
	$result_traitant=mysql_query($requete_traitant);
	$num_rows = mysql_num_rows($result_traitant);
	$ligne_traitant = mysql_fetch_object($result_traitant);
	$id_traitant = $ligne_traitant->id_util;

	//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections
	$date_creation_a_traiter = strtotime($date_creation);
	$date_creation_jour = date('d',$date_creation_a_traiter);
	$date_creation_mois = date('m',$date_creation_a_traiter);
	$date_creation_annee = date('Y',$date_creation_a_traiter);

	$date_echeance_a_traiter = strtotime($date_echeance);
	$date_echeance_jour = date('d',$date_echeance_a_traiter);
	$date_echeance_mois = date('m',$date_echeance_a_traiter);
	$date_echeance_annee = date('Y',$date_echeance_a_traiter);

	//On initialise la date d'aujourd'hui au cas que la date de rappel n'est pas fixée
	$aujourdhui_jour = date('d');
	$aujourdhui_jour = $aujourdhui_jour+7;
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	$date_rappel_a_traiter = strtotime($date_rappel);
	$date_rappel_annee = date('Y',$date_rappel_a_traiter);

	// Initialisation des compteurs glissants pour les années ///
	$debut_compteur_annee = $aujourdhui_annee-2;
	$fin_compteur_annee = $aujourdhui_annee+4;
	/*
	echo "<br />aujourdhui_annee : $aujourdhui_annee";
	echo "<br />debut_compteur_annee : $debut_compteur_annee";
	echo "<br />fin_compteur_annee : $fin_compteur_annee";
	*/

	if ($date_rappel_annee <> "1970")
	{
		$date_rappel_a_traiter = strtotime($date_rappel);
		$date_rappel_jour = date('d',$date_rappel_a_traiter);
		$date_rappel_mois = date('m',$date_rappel_a_traiter);
		$date_rappel_annee = date('Y',$date_rappel_a_traiter);
	}
	else
	{
		$date_rappel_jour = "";
		$date_rappel_mois = $aujourdhui_mois;
		$date_rappel_annee = $aujourdhui_annee;
	}

	$travail_sur_fonction = $_GET['travail_sur_fonction'];
	//$id_exercice = $_GET['id_exercice'];

////// Début des différents traitements	///////////////////////////////////////////////////////

	//echo "<br>travail_sur_fonction : $travail_sur_fonction";
	//echo "<br>id : $id";
	//echo "<br>id_exercice : $id_exercice";

	switch ($travail_sur_fonction)
	{
		case "ajout_categorie" :
			//echo "<br />procédure ajout_categorie";
			$id_categorie = $_GET['id_categorie'];
			$nombre_elements = count($id_categorie);
			//echo "<br />nombre_elements : $nombre_elements";
			if (($id_categorie[0] <> 0) OR ($id_categorie[0] == 0 AND $nombre_elements >1))
			{
				//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
				$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
				while($i < $nombre_elements)
				{
					//echo "<br>id_categorie : $id_categorie";
					//echo "<h1>Ajout de la categorie</h1>";
					//Il faut regarder s'il figure déjà dans cette catégorie
					$query_verif_categories = "SELECT * FROM taches_categories WHERE id_tache = $id AND id_categorie = $id_categorie[$i]";
					$results_verif_categories = mysql_query($query_verif_categories);
					$nbr_resultats = mysql_num_rows($results_verif_categories);
					//echo "<br>nbre_resultats : $nbr_resultats";
					if ($nbr_resultats > 0)
					{
						//echo "<h2>La t&acirc;che figure d&eacute;j&agrave; dans cette cat&eacute;gorie</h2>";
					}
					else
					{
						$requete_ajout = "INSERT INTO `taches_categories` (`id_tache`,`id_categorie`)
							VALUES ('".$id."','".$id_categorie[$i]."')";
						$resultat_ajout = mysql_query($requete_ajout);
						if(!$resultat_ajout)
						{
							echo "<br>Erreur";
						}
/*						else
						{
							echo "<h2>La (les) cat&eacute;gorie(s) a (ont) &eacute;t&eacute; enregistr&eacute;e(s)</h2>";
						}
*/					}
					$i++;
				} //Fin while
			}
		break;

		case "supprimer_categorie" :
			$id_categorie = $_GET['id_categorie'];
			//echo "<br>id_categorie : $id_categorie";
			//echo "<h1>Suppression de la categorie</h1>";
			$requete_suppression = "DELETE FROM `taches_categories` WHERE id_tache = '".$id."' AND id_categorie = '".$id_categorie."';";
			$resultat_suppression = mysql_query($requete_suppression);
			if(!$resultat_suppression)
			{
				echo "<br>Erreur";
			}
/*			else
			{
				echo "<h2>La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e</h2>";
			}
*/		break;

		case "ajout_util" :
			$id_util_associes = $_GET['id_util_associes'];
			$nombre_elements = count($id_util_associes);
			if (($id_util_associes[0] <> 0) OR ($id_util_associes[0] == 0 AND $nombre_elements >1))
			{
				//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
				$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
				while($i < $nombre_elements)
				{
					//echo "<br>id_util_partage : $id_util_partage";
					//echo "<h1>Ajout d'un utilisateur</h1>";
					//Il faut regarder s'il figure déjà dans cette catégorie
					$query_verif_util = "SELECT * FROM taches_util WHERE id_tache = $id AND id_util = $id_util_associes[$i]";
					$results_verif_util = mysql_query($query_verif_util);
					$nbr_resultats = mysql_num_rows($results_verif_util);
					//echo "<br>nbre_resultats : $nbr_resultats";
					if ($nbr_resultats > 0)
					{
						echo "<h2>La personne est d&eacute;j&agrave; associ&eacute;e &agrave; cette t&acirc;che</h2>";
					}
					else
					{
						$requete_ajout = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
							VALUES ('".$id."','".$id_util_associes[$i]."','001')";
						$resultat_ajout = mysql_query($requete_ajout);
						if(!$resultat_ajout)
						{
							echo "<br>Erreur";
						}
						else
						{
							//echo "<h2>La personne a &eacute;t&eacute; enregistr&eacute;e</h2>";
						}
					}
					$i++;
				} //Fin while
			}
		break;

		case "supprimer_util" :
			$id_util_partage = $_GET['id_util_partage'];
			//echo "<br>id_util_partage : $id_util_partage";
			//echo "<h1>Suppression de la personne</h1>";
			$requete_suppression = "DELETE FROM `taches_util` WHERE id_tache = '".$id."' AND id_util = '".$id_util_partage."';";
			$resultat_suppression = mysql_query($requete_suppression);
			if(!$resultat_suppression)
			{
				echo "<br>Erreur";
			}
			else
			{
				//echo "<h2>La personne a &eacute;t&eacute; supprim&eacute;e</h2>";
			}
		break;
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Ajouter une catégorie ///////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
	$query_categories = "SELECT * FROM categorie_commune ORDER BY intitule_categ";
	$results_categories = mysql_query($query_categories);

	$no = mysql_num_rows($results_categories);

	//echo "<br />id : $id";

	echo "<h1>Modification d'une t&acirc;che</h1>";
	echo "<FORM ACTION = \"taches_gestion.php\" method = \"get\">";
		echo "<TABLE BORDER = \"0\">";
			echo "<TR>";
				//echo "<TD class = \"td-1\">";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
				//echo "</TD>";
				echo "<TD class = \"td-1\" align = \"center\">";
					echo "<b>Ajouter d'autres cat&eacute;gories</b>";
					echo "<br /><SELECT size = \"4\" NAME = \"id_categorie[]\" multiple>";
					while ($ligne_categories = mysql_fetch_object($results_categories))
					{
						$id_categ = $ligne_categories->id_categ;
						$intitule_categ = $ligne_categories->intitule_categ;

						//On regarde si la catégorie est déjà affectée à la tâche
						$requete_categ_tache = "SELECT * FROM taches_categories WHERE id_tache = '".$id."' AND id_categorie = '".$id_categ."'";
						$resultat_categ_tache = mysql_query($requete_categ_tache);
						$num_rows = mysql_num_rows($resultat_categ_tache);

						if ($num_rows == 0)
						{
							echo "<OPTION VALUE = \"".$id_categ."\">".$intitule_categ."</OPTION>";
						}
					}
					echo "</SELECT>";
					//echo "<br />num_rows : $num_rows - id_categ : $id_categ";
/*				echo "</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD class = \"td-1\">";
*/					echo "<br /><INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
					<INPUT TYPE = \"hidden\" VALUE = \"modif_tache\" NAME = \"a_faire\">
					<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
					<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
					<INPUT TYPE = \"hidden\" VALUE = \"ajout_categorie\" NAME = \"travail_sur_fonction\">
					<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
					<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
					echo "<INPUT TYPE = \"submit\" VALUE = \"Ajouter les cat&eacute;gories s&eacute;lectionn&eacute;es ci-dessus\">";
				echo "</TD>";
//			echo "</TR>";
		//echo "</TABLE>";
	echo "</FORM>";

////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Partager la tâche ///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
	$query_util = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
	$results_util = mysql_query($query_util);

	$no = mysql_num_rows($results_util);
	//echo "<br />nombre d'utlisateurs : $no - id_tache : $id";
	echo "<FORM ACTION = \"taches_gestion.php\" method = \"get\">";
		//echo "<TABLE BORDER = \"0\">";
//			echo "<TR>";
				//echo "<TD class = \"td-1\">";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
				//echo "</TD>";
				echo "<TD class = \"td-1\" align = \"center\">";
					echo "<b>Associer d'autres personnes</b>";
					echo "<br /><SELECT size = \"4\" NAME = \"id_util_associes[]\" multiple>";
					while ($ligne_util = mysql_fetch_object($results_util))
					{
						$id_util = $ligne_util->ID_UTIL;
						$nom = $ligne_util->NOM;
						$prenom = $ligne_util->PRENOM;
						//On vérifie s'il fait déjà partie des personnes associées, traitant ou créateur
						$requete_verif2 = "SELECT * FROM taches_util WHERE id_tache = $id AND id_util = $id_util AND (statut_cta = '100' OR statut_cta = '110' OR statut_cta = '010' OR statut_cta = '001')";
						$resultat_verif2 = mysql_query($requete_verif2);
						$verif_existe = mysql_num_rows($resultat_verif2);
						//echo "<br />requete : $requete_verif2";
						//echo "<br />verif_existe : $verif_existe";
						if ($verif_existe == 0)
						{
							echo "<OPTION VALUE = \"".$id_util."\">".$nom." - ".$prenom."</OPTION>";
							//echo "<br />$id_util - $nom, $prenom.";
						}
					}
					echo "</SELECT>";
/*				echo "</TD>";
				echo "<TD class = \"td-1\">";
*/					echo "<br /><INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
					<INPUT TYPE = \"hidden\" VALUE = \"modif_tache\" NAME = \"a_faire\">
					<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
					<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
					<INPUT TYPE = \"hidden\" VALUE = \"ajout_util\" NAME = \"travail_sur_fonction\">
					<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
					<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
					echo "<INPUT TYPE = \"submit\" VALUE = \"Ajouter les personnes s&eacute;lectionn&eacute;es ci-dessus\">";
				echo "</TD>";
			echo "</TR>";
		echo "</TABLE>";
	echo "</FORM>";

	echo "<form action=\"taches_gestion.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"40%\">";
			echo "<col width=\"60%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Identifiant de la t&acirc;che&nbsp;:&nbsp;</td>";
			echo "<td>$id</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Desription de la t&acirc;che&nbsp;:&nbsp;</td>";
			echo "<td><TEXTAREA name=\"description\" rows=3 COLS=60>$description</TEXTAREA></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de cr&eacute;ation&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"date_creation_jour\">
					<option selected value=\"$date_creation_jour\">$date_creation_jour</option>";
					for ($i=1; $i < 32; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_creation_mois\">
					<option selected value=\"$date_creation_mois\">$date_creation_mois</option>";
					for ($i=1; $i < 13; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_creation_annee\">
					<option selected value=\"$date_creation_annee\">$date_creation_annee</option>";
					for ($i=$debut_compteur_annee; $i < $fin_compteur_annee; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"date_echeance_jour\">
					<option selected value=\"$date_echeance_jour\">$date_echeance_jour</option>";
					for ($i=1; $i < 32; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_echeance_mois\">
					<option selected value=\"$date_echeance_mois\">$date_echeance_mois</option>";
					for ($i=1; $i < 13; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_echeance_annee\">
					<option selected value=\"$date_echeance_annee\">$date_echeance_annee</option>";

					for ($i=$debut_compteur_annee; $i < $fin_compteur_annee; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de rappel&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"date_rappel_jour\">
					<option selected value=\"$date_rappel_jour\">$date_rappel_jour</option>";
					for ($i=1; $i < 32; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_rappel_mois\">
					<option selected value=\"$date_rappel_mois\">$date_rappel_mois</option>";
					for ($i=1; $i < 13; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				echo "</select>";
				echo "<select size=\"1\" name=\"date_rappel_annee\">";

				for ($i=$debut_compteur_annee; $i < $fin_compteur_annee; $i++)
				{
					echo "<option value=\"$i\">$i</option>";
				}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">&Eacute;tat de traitement&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_etat\" name=\"etat\">";
				if ($etat == "1")
				{
					echo "<option selected value=\"1\">nouvelle t&acirc;che</option>";
					echo "<option value=\"2\">t&acirc;che en cours de traitement</option>";
					echo "<option value=\"3\">t&acirc;che achev&eacute;e</option>";
				}
				elseif ($etat == "2")
				{
					echo "<option selected value=\"2\">t&acirc;che en cours de traitement</option>";
					echo "<option value=\"1\">nouvelle t&acirc;che</option>";
					echo "<option value=\"3\">t&acirc;che achev&eacute;e</option>";
				}
				elseif ($etat == "3")
				{
					echo "<option selected value=\"3\">t&acirc;che achev&eacute;e</option>";
					echo "<option value=\"1\">nouvelle t&acirc;che</option>";
					echo "<option value=\"2\">t&acirc;che en cours de traitement</option>";
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Priorit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_priorite\" name=\"priorite\">";
				if ($priorite == "H")
				{
					echo "<option selected value=\"H\">haute</option>";
					echo "<option value=\"N\">normale</option>";
					echo "<option value=\"B\">basse</option>";
				}
				elseif ($priorite == "N")
				{
					echo "<option selected value=\"N\">normale</option>";
					echo "<option value=\"H\">haute</option>";
					echo "<option value=\"N\">basse</option>";
				}
				elseif ($priorite == "B")
				{
					echo "<option selected value=\"B\">basse</option>";
					echo "<option value=\"H\">haute</option>";
					echo "<option value=\"N\">normale</option>";
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Confidentialit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" id=\"form_etat\" name=\"visibilite\">";
				if ($visibilite == "PU")
				{
					echo "<option selected value=\"PU\">public</option>";
					echo "<option value=\"PR\">priv&eacute;</option>";
				}
				elseif ($visibilite == "PR")
				{
					echo "<option selected value=\"PR\">priv&eacute;</option>";
					echo "<option value=\"PU\">public</option>";
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère le nom de l'utilisateur qui a créé la tâche
				$requete_util = "SELECT nom, prenom FROM util WHERE id_util = '".$id_createur."';";
				$resultat_util = mysql_query($requete_util);
				$ligne_util = mysql_fetch_object($resultat_util);
				$nom_util_creation = $ligne_util->nom;
				$prenom_util_creation = $ligne_util->prenom;
			echo "<td class = \"etiquette\">T&acirc;che cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
			echo "<td>$nom_util_creation, $prenom_util_creation</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère le nom de l'utilisateur qui traite la tâche
				$requete_util = "SELECT id_util, nom, prenom FROM util WHERE id_util = '".$id_traitant."';";
				$resultat_util = mysql_query($requete_util);
				$ligne_util = mysql_fetch_object($resultat_util);
				$id_util_traitant = $ligne_util->id_util;
				$nom_util_traitant = $ligne_util->nom;
				$prenom_util_traitant = $ligne_util->prenom;
			echo "<td class = \"etiquette\">T&acirc;che trait&eacute;e par&nbsp;:&nbsp;</td>";
//			echo "<td>$nom_util_traitant, $prenom_util_traitant</td>";


			echo "<td>";
				echo "<select size=\"1\" name=\"id_util_traitant\">";
					echo "<option selected value=\"$id_util_traitant\">$nom_util_traitant, $prenom_util_traitant</option>";
					$requete_utils = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
					$resultat_utils = mysql_query($requete_utils);
					$num_rows = mysql_num_rows($resultat_utils);

					if (mysql_num_rows($resultat_utils))
					{
						while ($ligne_utils=mysql_fetch_object($resultat_utils))
						{
							$id_util = $ligne_utils->ID_UTIL;
							$nom_util=$ligne_utils->NOM;
							$prenom_util = $ligne_utils->PRENOM;
							if ($id_util <> $id_util_traitant)
							{
								echo "<option value=\"$id_util\">$nom_util, $prenom_util</option>";
							}
						}
					}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Appartient aux cat&eacute;gories&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_categ_tache = "SELECT * FROM taches_categories, categorie_commune WHERE taches_categories.id_categorie = categorie_commune.id_categ AND id_tache = '".$id."' ORDER BY intitule_categ";
					$resultat_categ_tache = mysql_query($requete_categ_tache);
					$num_rows = mysql_num_rows($resultat_categ_tache);

					if (mysql_num_rows($resultat_categ_tache))
					{
						while ($ligne_categ_tache=mysql_fetch_object($resultat_categ_tache))
						{
							$intitule_categorie = $ligne_categ_tache->intitule_categ;
							$id_categorie = $ligne_categ_tache->id_categorie;
							echo "$intitule_categorie&nbsp<A HREF = \"taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_categorie&amp;id_categorie=$id_categorie&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A><br>";
						}
					}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Personnes associ&eacute;es&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_partage = "SELECT * FROM taches_util, util WHERE taches_util.id_util = util.ID_UTIL AND id_tache = '".$id."' AND statut_cta = '001' ORDER BY nom";
					$resultat_partage = mysql_query($requete_partage);
					$num_rows = mysql_num_rows($resultat_partage);

					if (mysql_num_rows($resultat_partage))
					{
						while ($ligne_partage=mysql_fetch_object($resultat_partage))
						{
							$id_util_partage = $ligne_partage->ID_UTIL;
							$nom = $ligne_partage->NOM;
							$prenom = $ligne_partage->PRENOM;
							echo "$nom, $prenom&nbsp<A HREF = \"taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_util&amp;id_util_partage=$id_util_partage&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer la cat&eacute;gorie\"></A><br>";
						}
					}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Observations&nbsp;:&nbsp;</td>";
			//echo "<td><TEXTAREA name=\"observation\" rows=3 COLS=60>$observation</TEXTAREA></td>";
			echo "<td><textarea rows = \"15\" COLS = \"120\" NAME = \"observation\">$observation</textarea>";
				echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'observation' );
					</script></td>";


		echo "</tr>";
	echo "</table>";
		echo "<p>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
			<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_tache\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id_createur\" NAME = \"id_createur\">
		</p>
	</form>";
?>
