<?php
	//Initialisation des variables pour la saisie des dates
	$aujourdhui_jour = date('d');
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');

	echo "<h2>Ajout de commande</h2>";
	echo "<form  action=\"materiels_gestion_commandes.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<colgroup>";
			echo "<col width=\"50%\">";
			echo "<col width=\"50%\">";
		echo "</colgroup>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"annee_budgetaire\" size = \"10\" value = \"$annee_budgetaire_en_cours\"/></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">";
				$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire ORDER BY id_chapitre ASC";
				$resultat_credits = mysql_query($query_credits);
				echo "Cr&eacute;dits&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"credits\">";
				if (mysql_num_rows($resultat_credits))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne_credits = mysql_fetch_object($resultat_credits))
					{
						$id_chapitre = $ligne_credits->id_chapitre;
						$intitule_chapitre = $ligne_credits->intitule_chapitre;
						$intitule_gestionnaire = $ligne_credits->intitule_gestionnaire;
						echo "<option value=\"$id_chapitre\">$intitule_chapitre ($intitule_gestionnaire)</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">";
				$query_fournisseurs = "SELECT * FROM repertoire ORDER BY societe ASC";
				$resultat_fournisseurs = mysql_query($query_fournisseurs);
				echo "Fournisseur&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td>";
				echo "<select size=\"1\" name=\"fournisseur\">";
				if (mysql_num_rows($resultat_fournisseurs))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne_fournisseurs = mysql_fetch_object($resultat_fournisseurs))
					{
						$No_societe = $ligne_fournisseurs->No_societe;
						$societe = $ligne_fournisseurs->societe;
						$ville = $ligne_fournisseurs->ville;
						echo "<option value=\"$No_societe\">$societe ($ville)</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Montant total&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"total_commande\" size = \"10\" />&nbsp;&euro;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Frais de port&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"frais_de_port\" size = \"10\" />&nbsp;&euro;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Devis&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"devis\" size = \"30\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">No commande&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"ref_commande\" size = \"10\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Date commande&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_commande\">
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
					<select size=\"1\" name=\"mois_commande\">
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
					<select size=\"1\" name=\"annee_commande\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
						<option value=\"2007\">2007</option>
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
			echo "<td class = \"etiquette\">B/L&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"bon_livraison\" size = \"10\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Date livraison&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_livraison\">
						<option selected value=\"\"></option>
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
					<select size=\"1\" name=\"mois_livraison\">
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
					<select size=\"1\" name=\"annee_livraison\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
						<option value=\"2007\">2007</option>
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
			echo "<td class = \"etiquette\">No facture&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"id_facture\" size = \"10\" /></td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Date facture&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"jour_facture\">
						<option selected value=\"\"></option>
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
					<select size=\"1\" name=\"mois_facture\">
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
					<select size=\"1\" name=\"annee_facture\">
						<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>
						<option value=\"2007\">2007</option>
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
			echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<textarea name=\"remarques\" rows=\"4\" cols=\"50\"></textarea>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la commande\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_commande\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</form>";
	echo "<br>";

?>
