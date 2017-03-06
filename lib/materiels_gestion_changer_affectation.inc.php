<?php
	//Initialisation des variables pour la saisie des dates
	
	$aujourdhui_jour = date('d');
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	$jour_retour = $aujourdhui_jour+7;
	
	$date_retour = verif_date_rappel ($nbr_jours_decallage_pour_rappel);
	//echo "<br />date_rappel : $date_rappel";
	
	//Transformation de la date de création extraite pour l'affichage
	$date_retour_a_afficher = strtotime($date_retour);
	$retour_jour = date('d',$date_retour_a_afficher);
	$retour_mois = date('m',$date_retour_a_afficher);
	$retour_annee = date('Y',$date_retour_a_afficher);


	//Il faut écupérer les champs de l'enregistrement courant
	$requete_materiel="SELECT * FROM materiels WHERE id = '".$id."'";
	$result_materiel=mysql_query($requete_materiel);
	$num_rows = mysql_num_rows($result_materiel);
	$ligne_materiel = mysql_fetch_object($result_materiel);
	$id = $ligne_materiel->id;
	$no_serie = $ligne_materiel->no_serie;
	$denomination = $ligne_materiel->denomination;
	$id_cat_princ = $ligne_materiel->categorie_principale;
	$id_origine = $ligne_materiel->origine;
	$id_affectation_materiel = $ligne_materiel->affectation_materiel;
	$a_editer = $ligne_materiel->a_editer;
	$type_affectation = $ligne_materiel->type_affectation;
	$date_affectation = $ligne_materiel->date_affectation;
	$date_retour = $ligne_materiel->date_retour;
	$id_lieu_stockage = $ligne_materiel->lieu_stockage;
	

	//On converti la date d'affectation pour affichage
	$date_affectation = strtotime($date_affectation);
	$date_affectation_jour = date('d',$date_affectation);
	$date_affectation_mois = date('m',$date_affectation);
	$date_affectation_annee = date('Y',$date_affectation);
	
	//On converti la date de retour pour affichage
	$date_retour = strtotime($date_retour);
	$date_retour_jour = date('d',$date_retour);
	$date_retour_mois = date('m',$date_retour);
	$date_retour_annee = date('Y',$date_retour);

	/*
	echo "<br><b>***materiels_gestion_modifier_materiel.inc.php***</b>";
	echo "<br>id : $id";
	echo "<br>denomination : $denomination";
	echo "<br>id_cat_princ : $id_cat_princ";
	echo "<br>id_origine : $id_origine";
	echo "<br>id_affectation_materiel : $id_affectation_materiel";
	*/
	
	//on récupère les différents intitulés
	//D'abord le type
	$requete_type = "SELECT * FROM materiels_categories_principales WHERE id_cat_princ = '".$id_cat_princ."';";
	$result_type = mysql_query($requete_type);
	$ligne_type = mysql_fetch_object($result_type);
	$intitule_materiel = $ligne_type->intitule_cat_princ;
	$id_cat_princ= $ligne_type->id_cat_princ;

	//echo "<br>intitule_materiel_extrait : $intitule_materiel - id_materiel_extrait : $id_materiel";

	//Ensuite l'origine
	$requete_origine = "SELECT * FROM materiels_origine WHERE id_origine = '".$id_origine."';";
	$result_origine = mysql_query($requete_origine);
	$ligne_origine = mysql_fetch_object($result_origine);
	$intitule_origine = $ligne_origine->intitule_origine;
	$id_origine = $ligne_origine->id_origine;

	//echo "<br>intitule_origine_extrait : $intitule_origine - id_origine_extrait : $id_origine";

	//Pour finir l'affectation
	$requete_affectation = "SELECT * FROM materiels_affectations WHERE id_affectation = '".$id_affectation_materiel."';";
	$result_affectation = mysql_query($requete_affectation);
	$ligne_affectation = mysql_fetch_object($result_affectation);
	$intitule_affectation = $ligne_affectation->intitule_affectation;
	$id_etat_affectation = $ligne_affectation->id_etat_affectation;
	//$id_affectation = $ligne_affectation->id_affectation;

	//echo "<br>intitule_affectation : $intitule_affectation - id_etat_affectation : $id_etat_affectation - id_affectation_materiel : $id_affectation_materiel";
	
	//le lieu de stockage
	$requete_stockage = "SELECT * FROM materiels_lieux_stockage WHERE id_lieu_stockage = '".$id_lieu_stockage."';";
	$result_stockage = mysql_query($requete_stockage);
	$ligne_stockage = mysql_fetch_object($result_stockage);
	$intitule_stockage = $ligne_stockage->intitule_lieu_stockage;

	//echo "<br>intitule_lieu_stockage : $intitule_stockage - id_lieu_stockage : $id_lieu_stockage";

	echo "<h2>$id - $denomination - $intitule_materiel - $intitule_origine</h2>";
	echo "<form action=\"materiels_gestion.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"50%\">";
			echo "<col width=\"50%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";
		echo "<tr>";
				$requete_affectation="SELECT * FROM materiels_affectations ORDER BY intitule_affectation";
				$result_affectation=mysql_query($requete_affectation);
				$num_rows = mysql_num_rows($result_affectation);
			echo "<td class = \"etiquette\">";
				echo "Nouvelle affectation&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"id_affectation\">";
				if (mysql_num_rows($result_affectation))
				{
					if ($id_affectation_materiel >0)
					{
						echo "<option selected value=\"$id_affectation_materiel\">$intitule_affectation</option>";
					}
					echo "<option value=\"\">aucune</option>";
					
					while ($ligne_affectation_extrait=mysql_fetch_object($result_affectation))
					{
						$id_affectation_extrait = $ligne_affectation_extrait->id_affectation;
						$intitule_affectation_extrait=$ligne_affectation_extrait->intitule_affectation;
						$id_etat_affectation_extrait = $ligne_affectation_extrait->id_etat_affectation;
						if (($intitule_affectation_extrait <> "réserve à déterminer") AND ($intitule_affectation_extrait <> $intitule_affectation))
						{
							echo "<option value=\"$id_affectation_extrait\">$intitule_affectation_extrait</option>";
						}					if ($id_affectation >0)
					{
						echo "<option selected value=\"$id_affectation\">$intitule_affectation</option>";
					}

					}
				}
				echo "</SELECT>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date d'affectation&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_affectation\">
						<option selected value=\"$date_affectation_jour\">$date_affectation_jour</option>
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
					<select size=\"1\" name=\"mois_affectation\">
						<option selected value=\"$date_affectation_mois\">$date_affectation_mois</option>
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
					<select size=\"1\" name=\"annee_affectation\">
						<option selected value=\"$date_affectation_annee\">$date_affectation_annee</option>
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
			echo "<td class = \"etiquette\">Date retour&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_retour\">
						<option selected value=\"$date_retour_jour\">$date_retour_jour</option>
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
					<select size=\"1\" name=\"mois_retour\">
						<option selected value=\"$date_retour_mois\">$date_retour_mois</option>
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
					<select size=\"1\" name=\"annee_retour\">
						<option selected value=\"$date_retour_annee\">$date_retour_annee</option>
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
			echo "<td class = \"etiquette\">Type d'affectation&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"type_affectation\">
					<option selected value=\"$type_affectation\">$type_affectation</option>
					<option value=\"permanente\">permanente</option>
					<option value=\"ponctuelle\">ponctuelle</option>
				</select>";
			echo "</td>";
		echo "</tr>";

		//Lieux de stockage
		echo "<tr>";
			$requete_lieux_stockage="SELECT * FROM materiels_lieux_stockage ORDER BY intitule_lieu_stockage";
			$result_lieux_stockage=mysql_query($requete_lieux_stockage);
			$num_rows = mysql_num_rows($result_lieux_stockage);
			
			//echo "<br />nbr lieux_stockage : $num_rows";
			
			echo "<td class = \"etiquette\">";
				echo "Lieu de stockage&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
			
				
				if ($num_rows > 0)
				{
					//echo "<br />nbr lieux_stockage >0 - id_lieu_stockage : $id_lieu_stockage";
				
					echo "<select size=\"1\" name=\"id_lieu_stockage\">";
					if ($id_lieu_stockage >0)
					{
						echo "<option selected value=\"$id_lieu_stockage\">$intitule_stockage</option>";
					}
					echo "<option value=\"\">aucun</option>";
					while ($ligne_lieux_stockage_extrait=mysql_fetch_object($result_lieux_stockage))
					{
						$intitule_lieu_stockage_extrait=$ligne_lieux_stockage_extrait->intitule_lieu_stockage;
						$id_lieu_stockage_extrait = $ligne_lieux_stockage_extrait->id_lieu_stockage;
						if (($id_lieu_stockage_extrait <> $id_lieu_stockage))
						{
							echo "<option value=\"$id_lieu_stockage_extrait\">$intitule_lieu_stockage_extrait</option>";
						}
					}
					echo "</SELECT>";
				}
			echo "</td>";
		echo "</tr>";
		

		echo "<tr>";
			echo "<td class = \"etiquette\">&Eacute;diter la fiche&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"a_editer\">";
					if ($a_editer == "0")
					{
						echo "<option selected value=\"0\">Non</option>";
						echo "<option value=\"1\">Oui</option>";
					}
					else
					{
						echo "<option selected value=\"1\">Oui</option>";
						echo "<option value=\"0\">Non</option>";
					}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Confirmer l'affectation\"/>
		<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
		
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$dans\" NAME = \"dans\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$origine_gestion\" NAME = \"origine_gestion\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"script_affectation\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"maj_materiel\" NAME = \"a_faire\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$a_editer\" NAME = \"a_editer\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$no_serie\" NAME = \"no_serie\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$denomination\" NAME = \"denomination\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_cat_princ\" NAME = \"id_cat_princ\">";
	echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_origine\" NAME = \"id_origine\">";
	echo "</form>";
?>
