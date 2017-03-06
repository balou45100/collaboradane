<?php
	//Il faut écupérer les champs de l'enregistrement courant
	$requete_commande="SELECT * FROM materiels_commandes WHERE id_commande = '".$id_cde."'";
	$result_commande=mysql_query($requete_commande);
	$num_rows = mysql_num_rows($result_commande);
	$ligne_commande = mysql_fetch_object($result_commande);
	
	$id_cde = $ligne_commande->id_commande;
	$devis = $ligne_commande->devis;
	$ref_commande = $ligne_commande->ref_commande;
	$date_commande = $ligne_commande->date_commande;
	$bon_livraison = $ligne_commande->bon_livraison;
	$date_livraison_complete = $ligne_commande->date_livraison_complete;
	$id_facture = $ligne_commande->id_facture;
	$date_facture = $ligne_commande->date_facture;
	$fournisseur = $ligne_commande->fournisseur;
	$credits = $ligne_commande->credits;
	$annee_budgetaire = $ligne_commande->annee_budgetaire;
	$frais_de_port = $ligne_commande->frais_de_port;
	$total_commande = $ligne_commande->total_commande;
	$remarques = $ligne_commande->remarques;
	
	//echo "<br>fournisseur : $fournisseur";
	
	//On convertyi les dates pour affichage
	$date_commande = strtotime($date_commande);
	$date_commande_jour = date('d',$date_commande);
	$date_commande_mois = date('m',$date_commande);
	$date_commande_annee = date('Y',$date_commande);
	
	$date_livraison_complete = strtotime($date_livraison_complete);
	$date_livraison_complete_jour = date('d',$date_livraison_complete);
	$date_livraison_complete_mois = date('m',$date_livraison_complete);
	$date_livraison_complete_annee = date('Y',$date_livraison_complete);

	$date_facture = strtotime($date_facture);
	$date_facture_jour = date('d',$date_facture);
	$date_facture_mois = date('m',$date_facture);
	$date_facture_annee = date('Y',$date_facture);

	//Initialisation des variables pour la saisie des dates
	$aujourdhui_jour = date('d');
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	
	//echo "<br />aujourdhui_annee : $aujourdhui_annee";
	
	//Il faut récupérer les intitulés des crédits utilisés et du fournisseur
	$query_credits = "SELECT * FROM credits_chapitres, credits_gestionnaires WHERE credits_chapitres.id_gestionnaire = credits_gestionnaires.id_gestionnaire AND id_chapitre = '".$credits."'";
	$resultat_credits = mysql_query($query_credits);
	$ligne_credits = mysql_fetch_object($resultat_credits);
	$intitule_chapitre_extrait = $ligne_credits->intitule_chapitre;
	$intitule_gestionnaire_extrait = $ligne_credits->intitule_gestionnaire;
	
	$query_fournisseurs = "SELECT * FROM repertoire WHERE No_societe = '".$fournisseur."'";
	$resultat_fournisseurs = mysql_query($query_fournisseurs);
	$ligne_fournisseurs = mysql_fetch_object($resultat_fournisseurs);
	$societe_extraite = $ligne_fournisseurs->societe;
	$ville_extraite = $ligne_fournisseurs->ville;


	echo "<h2>Modification de la commande $id_cde</h2>";
	echo "<form  action=\"materiels_gestion_commandes.php\" method=\"get\">";
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<colgroup>";
			echo "<col width=\"50%\">";
			echo "<col width=\"50%\">";
		echo "</colgroup>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" name=\"annee_budgetaire\" size = \"10\" value = \"$annee_budgetaire\"/></td>";
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
					echo "<option selected value=\"$credits\">$intitule_chapitre_extrait ($intitule_gestionnaire_extrait)</option>";
					while ($ligne_credits = mysql_fetch_object($resultat_credits))
					{
						$id_chapitre = $ligne_credits->id_chapitre;
						$intitule_chapitre = $ligne_credits->intitule_chapitre;
						$intitule_gestionnaire = $ligne_credits->intitule_gestionnaire;
						if ($id_chapitre <> $credits)
						{
							echo "<option value=\"$id_chapitre\">$intitule_chapitre ($intitule_gestionnaire)</option>";
						}
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
					echo "<option selected value=\"$fournisseur\">$societe_extraite ($ville_extraite)</option>";
					while ($ligne_fournisseurs = mysql_fetch_object($resultat_fournisseurs))
					{
						$No_societe = $ligne_fournisseurs->No_societe;
						$societe = $ligne_fournisseurs->societe;
						$ville = $ligne_fournisseurs->ville;
						if ($No_societe <> $fournisseur)
						{
							echo "<option value=\"$No_societe\">$societe ($ville)</option>";
						}
					}
				}
				echo "</SELECT>"; 
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Montant total&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value = \"$total_commande\" name=\"total_commande\" size = \"10\" />&nbsp;&euro;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Frais de port&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value = \"$frais_de_port\" name=\"frais_de_port\" size = \"10\" />&nbsp;&euro;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Devis&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value = \"$devis\" name=\"devis\" size = \"30\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">No commande&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value = \"$ref_commande\" name=\"ref_commande\" size = \"10\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Date commande&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"date_commande_jour\">
						<option selected value=\"$date_commande_jour\">$date_commande_jour</option>
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
					<select size=\"1\" name=\"date_commande_mois\">
						<option selected value=\"$date_commande_mois\">$date_commande_mois</option>
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
					</select>";
					echo "<select size=\"1\" name=\"date_commande_annee\">";
						echo "<option selected value=\"$date_commande_annee\">$date_commande_annee</option>";
						for($annee = $aujourdhui_annee-5; $annee < $aujourdhui_annee+3; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">B/L&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value=\"$bon_livraison\" name=\"bon_livraison\" size = \"10\" /></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td class = \"etiquette\">Date livraison&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"date_livraison_complete_jour\">
						<option selected value=\"$date_livraison_complete_jour\">$date_livraison_complete_jour</option>
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
					<select size=\"1\" name=\"date_livraison_complete_mois\">
						<option selected value=\"$date_livraison_complete_mois\">$date_livraison_complete_mois</option>
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
					</select>";
					echo "<select size=\"1\" name=\"date_livraison_complete_annee\">";
						echo "<option selected value=\"$date_livraison_complete_annee\">$date_livraison_complete_annee</option>";
						for($annee = $aujourdhui_annee-5; $annee < $aujourdhui_annee+3; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td class = \"etiquette\">No facture&nbsp;:&nbsp;</td>";
			echo "<td><input type=\"text\" value=\"$id_facture\" name=\"id_facture\" size = \"10\" /></td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td class = \"etiquette\">Date facture&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" name=\"date_facture_jour\">
						<option selected value=\"$date_facture_jour\">$date_facture_jour</option>
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
					<select size=\"1\" name=\"date_facture_mois\">
						<option selected value=\"$date_facture_mois\">$date_facture_mois</option>
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
					<select size=\"1\" name=\"date_facture_annee\">";
						echo "<option selected value=\"$date_facture_annee\">$date_facture_annee</option>";
						for($annee = $aujourdhui_annee-5; $annee < $aujourdhui_annee+3; $annee++ )
						{
							echo "<option value=\"$annee\">$annee</option>";
						}
					echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
			echo "<td>";
				echo "<textarea name=\"remarques\" rows=\"4\" cols=\"50\">$remarques</textarea>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer la commande\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id_cde\" NAME = \"id_cde\">
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_commande\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
	echo "</form>";
	echo "<br>";

?>
