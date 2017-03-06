<?php
	//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui
	/*
	$aujourdhui_jour = date('d');
	$aujourdhui_jour = $aujourdhui_jour+7;
	//Il faut vérifier que la date reste valable à travers une fonction
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	*/
	//echo "<br />nbr_jours_decallage_pour_rappel : $nbr_jours_decallage_pour_rappel";
	//On regarde que la date à afficher pour le rappel a le bon format
	$date_rappel = verif_date_rappel ($nbr_jours_decallage_pour_rappel);
	//echo "<br />date_rappel : $date_rappel";
	
	//Transformation de la date de création extraite pour l'affichage
	$date_rappel_a_afficher = strtotime($date_rappel);
	$aujourdhui_jour = date('d',$date_rappel_a_afficher);
	$aujourdhui_mois = date('m',$date_rappel_a_afficher);
	$aujourdhui_annee = date('Y',$date_rappel_a_afficher);
	/*
	echo "<br />jour : $aujourdhui_jour";
	echo "<br />mois : $aujourdhui_mois";
	echo "<br />année : $aujourdhui_annee";
	*/
	//On récupère les préférences
	
	//echo "<br />id_util : $id_util";
	
	$util="SELECT * FROM preference WHERE ID_UTIL = $id_util";
	$execution= mysql_query($util);
	$ligne = mysql_fetch_object($execution);
	$choix_type_tache_defaut = $ligne->choix_type_tache_defaut;
	
	//echo "<br />choix_type_tache_defaut : $choix_type_tache_defaut";

	
	echo "<form action=\"taches_gestion.php\" method=\"get\">";
	echo "<table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"30%\">";
			echo "<col width=\"30%\">";
			echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";
		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">Desription de la t&acirc;che&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"2\"><textarea rows=\"3\" name=\"description_tache\" cols=\"60\"></textarea></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\"rowspan= \"2\" align = \"right\">&Eacute;ch&eacute;ance&nbsp;:&nbsp;</td>";
			/*
			echo "<td class = \"etiquette\"align = \"right\">Nombre de jour(s)&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" id=\"form_echeance\" name=\"nbr_jours\">
						<option value=\"0\"></option>
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
					</select>";
			echo "</td>";
			
		echo "</tr>";
		echo "<tr>";
		*/
			echo "<td class = \"etiquette\"align = \"right\">&agrave; partir du&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour\">
						<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>
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
					<select size=\"1\" name=\"mois\">
						<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>
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
					<select size=\"1\" name=\"annee\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
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
			echo "<td class = \"etiquette\"align = \"right\">rappel le&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_rappel\">
						<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>
						<!--option selected value=\"\"></option-->
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
					<select size=\"1\" name=\"mois_rappel\">
						<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>
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
					<select size=\"1\" name=\"annee_rappel\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
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
			echo "<td class = \"etiquette\"align = \"right\">Priorit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"2\">
				Haute&nbsp;<input type=\"radio\" name=\"priorite\" value=\"H\" />
				Normale&nbsp;<input type=\"radio\" name=\"priorite\" value=\"N\" checked=\"checked\"/>
				Basse&nbsp;<input type=\"radio\" name=\"priorite\" value=\"B\" />
			</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">Visibilit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td colspan = \"2\">";
				if ($choix_type_tache_defaut == "PU")
				{
					echo "public&nbsp;<input type=\"radio\" name=\"visibilite\" value=\"PU\" checked=\"checked\"/>";
					echo "priv&eacute;&nbsp;<input type=\"radio\" name=\"visibilite\" value=\"PR\" />";
				}
				else
				{
					echo "public&nbsp;<input type=\"radio\" name=\"visibilite\" value=\"PU\"/>";
					echo "priv&eacute;&nbsp;<input type=\"radio\" name=\"visibilite\" value=\"PR\" checked=\"checked\" />";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">Cat&eacute;gorie(s)&nbsp;:&nbsp;<br /><small>Il est possible de s&eacute;lectionner plusieurs cat&eacute;gories</small></td>";
				$requete_categorie="SELECT DISTINCT id_categ,intitule_categ FROM categorie_commune ORDER BY intitule_categ";
				$result=mysql_query($requete_categorie);
				$num_rows = mysql_num_rows($result);
			echo "</td>";
			echo "<td>";
				echo "<select size=\"4\" name=\"id_categorie[]\" multiple>";
				if (mysql_num_rows($result))
				{
					echo "<option selected value=\"0\">Faire un choix</option>";
					while ($ligne=mysql_fetch_object($result))
					{
						$intitule=$ligne->intitule_categ;
						$id_categorie = $ligne->id_categ;
						echo "<option value=\"$id_categorie\">$intitule</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";
		
		//Personne qui doit traiter la tâche
		//echo "<br />id_util : $id_util";
		$query_util_traitant_defaut = "SELECT NOM, PRENOM FROM util WHERE ID_UTIL = '".$id_util."'";
		$results_util_traitant_defaut = mysql_query($query_util_traitant_defaut);
		$ligne_util_traitant_defaut = mysql_fetch_object($results_util_traitant_defaut);
		$traitant_nom_defaut =  $ligne_util_traitant_defaut->NOM;
		$traitant_prenom_defaut =  $ligne_util_traitant_defaut->PRENOM;
		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">&Agrave; traiter par&nbsp;:&nbsp;</td>";
				$query_util_traitant = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
				$results_util_traitant = mysql_query($query_util_traitant);
			echo "<td>";
				echo "<select size=\"1\" name=\"id_util_traitant\">";
				echo "<option selected value=\"$id_util\">$traitant_nom_defaut - $traitant_prenom_defaut</option>";
				while ($ligne_util_traitant = mysql_fetch_object($results_util_traitant))
				{
					$id_util_traitant = $ligne_util_traitant->ID_UTIL;
					$nom = $ligne_util_traitant->NOM;
					$prenom = $ligne_util_traitant->PRENOM;
					if ($id_util_traitant <> $id_util)
					{
						echo "<OPTION VALUE = \"".$id_util_traitant."\">".$nom." - ".$prenom."</OPTION>";
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">Personnes associ&eacute;es&nbsp;:&nbsp;<br /><small>Il est possible de s&eacute;lectionner plusieurs personnes</small></td>";
				$query_util_associes = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
				$results_util_associes = mysql_query($query_util_associes);
			echo "<td>";
				echo "<select size=\"4\" name=\"id_util_associes[]\" multiple>";
				echo "<option selected value=\"0\">Faire un choix</option>";
				while ($ligne_util_associes = mysql_fetch_object($results_util_associes))
				{
					$id_util_associes = $ligne_util_associes->ID_UTIL;
					$nom_associes = $ligne_util_associes->NOM;
					$prenom_associes = $ligne_util_associes->PRENOM;
					if ($id_util_associes <> $id_util)
					{
						echo "<OPTION VALUE = \"".$id_util_associes."\">".$nom_associes." - ".$prenom_associes."</OPTION>";
					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\"align = \"right\">Observations et remarques&nbsp;:&nbsp;</td>";
			//echo "<td colspan = \"2\"><textarea rows=\"10\" name=\"observation_tache\" cols=\"60\"></textarea></td>";
			echo "<td colspan = \"2\"><textarea rows = \"15\" COLS = \"120\" NAME = \"observation_tache\"></textarea>";
				echo "<script type=\"text/javascript\">
						CKEDITOR.replace( 'observation_tache' );
					</script></td>";
		echo "</tr>";
		echo "</table>";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la t&acirc;che\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_tache\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</form>";
?>
