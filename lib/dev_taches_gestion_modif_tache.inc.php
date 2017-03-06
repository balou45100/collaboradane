<?php

////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_tache="SELECT * FROM dev_taches WHERE id_tache = '$id'";
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

	//On regarde qui est le créateur de la tâche
	$requete_createur="SELECT * FROM dev_taches_util WHERE id_tache = '".$id."' AND (statut_cta = '100' OR statut_cta = '110')";
	$result_createur=mysql_query($requete_createur);
	$num_rows = mysql_num_rows($result_createur);
	$ligne_createur = mysql_fetch_object($result_createur);
	$id_createur = $ligne_createur->id_util;
	
	//On regarde qui traite la tâche
	$requete_traitant="SELECT * FROM dev_taches_util WHERE id_tache = '".$id."' AND (statut_cta = '110' OR statut_cta = '010')";
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
		case "ajout_module" :
			//echo "<br />procédure ajout_module";
			$id_module = $_GET['id_module'];
			$nombre_elements = count($id_module);
			//echo "<br />nombre_elements : $nombre_elements";
			if (($id_module[0] <> 0) OR ($id_module[0] == 0 AND $nombre_elements >1))
			{
				//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
				$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
				while($i < $nombre_elements)
				{
					//echo "<br>id_module : $id_module";
					//echo "<h1>Ajout du module</h1>";
					//Il faut regarder s'il figure déjà dans cette catégorie
					$query_verif_modules = "SELECT * FROM dev_taches_modules WHERE id_tache = $id AND id_module = $id_module[$i]";
					$results_verif_modules = mysql_query($query_verif_modules);
					$nbr_resultats = mysql_num_rows($results_verif_modules);
					//echo "<br>nbre_resultats : $nbr_resultats";
					if ($nbr_resultats > 0)
					{
						//echo "<h2>La t&acirc;che figure d&eacute;j&agrave; dans cette module</h2>";
					}
					else
					{
						$requete_ajout = "INSERT INTO `dev_taches_modules` (`id_tache`,`id_module`)
							VALUES ('".$id."','".$id_module[$i]."')";
						$resultat_ajout = mysql_query($requete_ajout);
						if(!$resultat_ajout)
						{
							echo "<br>Erreur";
						}
/*						else
						{
							echo "<h2>La (les) module(s) a (ont) &eacute;t&eacute; enregistr&eacute;e(s)</h2>";
						}
*/					}
					$i++;
				} //Fin while
			}
		break;

		case "supprimer_module" :
			$id_module = $_GET['id_module'];
			//echo "<br>id_module : $id_module";
			//echo "<h1>Suppression du module</h1>";
			$requete_suppression = "DELETE FROM `dev_taches_modules` WHERE id_tache = '".$id."' AND id_module = '".$id_module."';";
			$resultat_suppression = mysql_query($requete_suppression);
			if(!$resultat_suppression)
			{
				echo "<br>Erreur";
			}
/*			else
			{
				echo "<h2>La module a &eacute;t&eacute; supprim&eacute;e</h2>";
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
					$query_verif_util = "SELECT * FROM dev_taches_util WHERE id_tache = $id AND id_util = $id_util_associes[$i]";
					$results_verif_util = mysql_query($query_verif_util);
					$nbr_resultats = mysql_num_rows($results_verif_util);
					//echo "<br>nbre_resultats : $nbr_resultats";
					if ($nbr_resultats > 0)
					{
						echo "<h2>La personne est d&eacute;j&agrave; associ&eacute;e &agrave; cette t&acirc;che</h2>";
					}
					else
					{
						$requete_ajout = "INSERT INTO `dev_taches_util` (`id_tache`,`id_util`,`statut_cta`)
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
			$requete_suppression = "DELETE FROM `dev_taches_util` WHERE id_tache = '".$id."' AND id_util = '".$id_util_partage."';";
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
	$query_modules = "SELECT * FROM modules_collaboratice ORDER BY intitule_module";
	$results_modules = mysql_query($query_modules);
	
	$no = mysql_num_rows($results_modules);
	
	//echo "<br />id : $id";
	
	echo "<h1>Modification d'une t&acirc;che</h1>";
	echo "<FORM ACTION = \"dev_taches_gestion.php\" method = \"get\">";
		echo "<TABLE BORDER = \"0\">";
			echo "<TR>";
				//echo "<TD class = \"td-1\">";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
				//echo "</TD>";
				echo "<TD class = \"td-1\" align = \"center\">";
					echo "<b>Ajouter d'autres modules</b>";
					echo "<br /><SELECT size = \"4\" NAME = \"id_module[]\" multiple>";
					while ($ligne_modules = mysql_fetch_object($results_modules))
					{
						$id_module = $ligne_modules->id_module;
						$intitule_module = $ligne_modules->intitule_module;
						
						//On regarde si la catégorie est déjà affectée à la tâche
						$requete_module_tache = "SELECT * FROM dev_taches_modules WHERE id_tache = '".$id."' AND id_module = '".$id_module."'";
						$resultat_module_tache = mysql_query($requete_module_tache);
						$num_rows = mysql_num_rows($resultat_module_tache);
						
						if ($num_rows == 0)
						{
							echo "<OPTION VALUE = \"".$id_module."\">".$intitule_module."</OPTION>";
						}
					}
					echo "</SELECT>";
					//echo "<br />num_rows : $num_rows - id_module : $id_module";
/*				echo "</TD>";
			echo "</TR>";
			echo "<TR>";
				echo "<TD class = \"td-1\">";
*/					echo "<br /><INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
					<INPUT TYPE = \"hidden\" VALUE = \"modif_tache\" NAME = \"a_faire\">
					<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
					<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
					<INPUT TYPE = \"hidden\" VALUE = \"ajout_module\" NAME = \"travail_sur_fonction\">
					<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
					<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
					echo "<INPUT TYPE = \"submit\" VALUE = \"Ajouter les modules s&eacute;lectionn&eacute;es ci-dessus\">";
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
	echo "<FORM ACTION = \"dev_taches_gestion.php\" method = \"get\">";
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
						$requete_verif2 = "SELECT * FROM dev_taches_util WHERE id_tache = $id AND id_util = $id_util AND (statut_cta = '100' OR statut_cta = '110' OR statut_cta = '010' OR statut_cta = '001')";
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

	echo "<form action=\"dev_taches_gestion.php\" method=\"get\">";
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
					<option selected value=\"$date_creation_jour\">$date_creation_jour</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
					<option value=\"13\">13</option>
					<option value=\"14\">14</option>
					<option value=\"15\">15</option>
					<option value=\"16\">16</option>
					<option value=\"17\">17</option>
					<option value=\"18\">18</option>
					<option value=\"19\">19</option>
					<option value=\"20\">20</option>
					<option value=\"21\">21</option>
					<option value=\"22\">22</option>
					<option value=\"23\">23</option>
					<option value=\"24\">24</option>
					<option value=\"25\">25</option>
					<option value=\"26\">26</option>
					<option value=\"27\">27</option>
					<option value=\"28\">28</option>
					<option value=\"29\">29</option>
					<option value=\"30\">30</option>
					<option value=\"31\">31</option>
				</select>
				<select size=\"1\" name=\"date_creation_mois\">
					<option selected value=\"$date_creation_mois\">$date_creation_mois</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
				</select>
				<select size=\"1\" name=\"date_creation_annee\">
					<option selected value=\"$date_creation_annee\">$date_creation_annee</option>
					<option value=\"2008\">2008</option>
					<option value=\"2009\">2009</option>
					<option value=\"2010\">2010</option>
					<option value=\"2011\">2011</option>
					<option value=\"2012\">2012</option>
					<option value=\"2013\">2013</option>
					<option value=\"2014\">2014</option>
					<option value=\"2015\">2015</option>
				</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"date_echeance_jour\">
					<option selected value=\"$date_echeance_jour\">$date_echeance_jour</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
					<option value=\"13\">13</option>
					<option value=\"14\">14</option>
					<option value=\"15\">15</option>
					<option value=\"16\">16</option>
					<option value=\"17\">17</option>
					<option value=\"18\">18</option>
					<option value=\"19\">19</option>
					<option value=\"20\">20</option>
					<option value=\"21\">21</option>
					<option value=\"22\">22</option>
					<option value=\"23\">23</option>
					<option value=\"24\">24</option>
					<option value=\"25\">25</option>
					<option value=\"26\">26</option>
					<option value=\"27\">27</option>
					<option value=\"28\">28</option>
					<option value=\"29\">29</option>
					<option value=\"30\">30</option>
					<option value=\"31\">31</option>
				</select>
				<select size=\"1\" name=\"date_echeance_mois\">
					<option selected value=\"$date_echeance_mois\">$date_echeance_mois</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
				</select>
				<select size=\"1\" name=\"date_echeance_annee\">
					<option selected value=\"$date_echeance_annee\">$date_echeance_annee</option>
					<option value=\"2008\">2008</option>
					<option value=\"2009\">2009</option>
					<option value=\"2010\">2010</option>
					<option value=\"2011\">2011</option>
					<option value=\"2012\">2012</option>
					<option value=\"2013\">2013</option>
					<option value=\"2014\">2014</option>
					<option value=\"2015\">2015</option>
				</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de rappel&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"date_rappel_jour\">
					<option selected value=\"$date_rappel_jour\">$date_rappel_jour</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
					<option value=\"13\">13</option>
					<option value=\"14\">14</option>
					<option value=\"15\">15</option>
					<option value=\"16\">16</option>
					<option value=\"17\">17</option>
					<option value=\"18\">18</option>
					<option value=\"19\">19</option>
					<option value=\"20\">20</option>
					<option value=\"21\">21</option>
					<option value=\"22\">22</option>
					<option value=\"23\">23</option>
					<option value=\"24\">24</option>
					<option value=\"25\">25</option>
					<option value=\"26\">26</option>
					<option value=\"27\">27</option>
					<option value=\"28\">28</option>
					<option value=\"29\">29</option>
					<option value=\"30\">30</option>
					<option value=\"31\">31</option>
				</select>
				<select size=\"1\" name=\"date_rappel_mois\">
					<option selected value=\"$date_rappel_mois\">$date_rappel_mois</option>
					<option value=\"1\">01</option>
					<option value=\"2\">02</option>
					<option value=\"3\">03</option>
					<option value=\"4\">04</option>
					<option value=\"5\">05</option>
					<option value=\"6\">06</option>
					<option value=\"7\">07</option>
					<option value=\"8\">08</option>
					<option value=\"9\">09</option>
					<option value=\"10\">10</option>
					<option value=\"11\">11</option>
					<option value=\"12\">12</option>
				</select>
				<select size=\"1\" name=\"date_rappel_annee\">
					<option selected value=\"$date_rappel_annee\">$date_rappel_annee</option>
					<option value=\"2008\">2008</option>
					<option value=\"2009\">2009</option>
					<option value=\"2010\">2010</option>
					<option value=\"2011\">2011</option>
					<option value=\"2012\">2012</option>
					<option value=\"2013\">2013</option>
					<option value=\"2014\">2014</option>
					<option value=\"2015\">2015</option>
				</select>";
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
			echo "<td class = \"etiquette\">Appartient aux modules&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_module_tache = "SELECT * FROM dev_taches_modules, modules_collaboratice WHERE dev_taches_modules.id_module = modules_collaboratice.id_module AND id_tache = '".$id."' ORDER BY intitule_module";
					$resultat_module_tache = mysql_query($requete_module_tache);
					$num_rows = mysql_num_rows($resultat_module_tache);
					
					if (mysql_num_rows($resultat_module_tache))
					{
						while ($ligne_module_tache=mysql_fetch_object($resultat_module_tache))
						{
							$intitule_module = $ligne_module_tache->intitule_module;
							$id_module = $ligne_module_tache->id_module;
							echo "$intitule_module&nbsp<A HREF = \"dev_taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_module&amp;id_module=$id_module&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer le module\"></A><br>";
						}
					}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Personnes associ&eacute;es&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_partage = "SELECT * FROM dev_taches_util, util WHERE dev_taches_util.id_util = util.ID_UTIL AND id_tache = '".$id."' AND statut_cta = '001' ORDER BY nom";
					$resultat_partage = mysql_query($requete_partage);
					$num_rows = mysql_num_rows($resultat_partage);
					
					if (mysql_num_rows($resultat_partage))
					{
						while ($ligne_partage=mysql_fetch_object($resultat_partage))
						{
							$id_util_partage = $ligne_partage->ID_UTIL;
							$nom = $ligne_partage->NOM;
							$prenom = $ligne_partage->PRENOM;
							echo "$nom, $prenom&nbsp<A HREF = \"dev_taches_gestion.php?origine_appel=cadre&amp;actions_courantes=O&amp;a_faire=modif_tache&amp;travail_sur_fonction=supprimer_util&amp;id_util_partage=$id_util_partage&amp;id=$id&amp;indice=$indice&amp;affiche_barrees=$affiche_barrees\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer le module\"></A><br>";
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
