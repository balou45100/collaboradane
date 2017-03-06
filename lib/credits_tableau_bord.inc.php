<?php
/*
 *      credits_tableau_bord.inc.php
 *      
 *      Copyright 2008 mendel <mendel@mendel-ubuntu>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
	$annee = $annee_budgetaire; // en attendant un développement pour pouvoir afficher n'importe quelle année
	echo "<h1>Tableau de bord des cr&eacute;dits TICE pour $annee</h1>";
	echo "<form action=\"credits_gestion.php\" method=\"get\">";
		echo "<TABLE width = \"90%\" BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">";
			echo "<colgroup>";
				//echo "<col width=\"10%\">"; //ID
				echo "<col width=\"55%\">"; //domaine
				echo "<col width=\"15%\">"; //total affecté
				echo "<col width=\"15%\">"; //total distribué
				echo "<col width=\"15%\">"; //total encore à distribuer
			echo "</colgroup>";
			//echo "<th>ID</th>";
			echo "<th>domaine du budget</th>";
			echo "<th>Total allou&eacute;</th>";
			echo "<th>Total distribu&eacute;</th>";
			echo "<th>Reste &agrave; distribuer</th>";
		//On lit la table personnes_ressources_doamines_budget
		$requete_credits_chapitre = "SELECT * FROM credits_chapitres WHERE utilise ='O' ORDER BY intitule_chapitre ASC";
		$resultat_credits_chapitre = mysql_query($requete_credits_chapitre);
		$num_rows = mysql_num_rows($resultat_credits_chapitre);
		//echo "<br>nombre d'enregistrements : $num_rows";
		//on réinitialise les compteurs des totaux
		$compteur_credits_initiaux = 0; //La somme affectée à un domaine du budget
		$compteur_credits_distribuees = 0; //La somme distribuée
		while ($ligne_credits_chapitre = mysql_fetch_object($resultat_credits_chapitre))
		{
			$id_credits_chapitre = $ligne_credits_chapitre->id_chapitre;
			$intitule_credits_chapitre = $ligne_credits_chapitre->intitule_chapitre;
			//$credits_alloues_domaine_budget = $ligne_domaine_budget->montant_alloue;
			//on totalise les hsa initiales
			//$compteur_credits_initiaux = $compteur_credits_initiaux + $credits_alloues_domaine_budget;
			
			//Il faut récupérer le total des crédits affectés par domaine
			$requete_total_alloue = " SELECT SUM(montant_alloue) FROM credits_domaines_budget WHERE `id_credits_chapitres` ='".$id_credit_chapitre."' AND annee = '".$annee."'";
			$resultat_total_alloue = mysql_query($requete_total_alloue);
			$total_alloue = mysql_fetch_row($resultat_total_alloue);
			$total_alloue_a_afficher = $total_alloue[0];
			//on totalise les hsa initiales
			//$compteur_hsa_distribuees = $compteur_hsa_distribuees + $total_distribue_a_afficher;
			
			//$total_distribue_a_afficher = number_format($total_distribue[0],2,',',' ');
			//$total_distribue_a_afficher_en_HSE = $total_distribue_a_afficher*36;
			//$total_distribue_a_afficher_en_HSE = number_format($total_distribue_a_afficher_en_HSE,2,',',' ');
			
			//On calcul le total qui reste encore à distribuer
			//$total_encore_a_distribuer = $nbr_heures_attribuees_domaine_budget - $total_distribue_a_afficher;
			//$total_encore_a_distribuer = number_format($total_encore_a_distribuer,2,',',' ');
			//$total_encore_a_distribuer_en_HSE = $total_encore_a_distribuer*36;
			//$total_encore_a_distribuer_en_HSE = number_format($total_encore_a_distribuer_en_HSE,2,',',' ');
			echo "<tr class = \"new\">";
/*				echo "<td align = \"center\">";
					echo "$id_domaine_budget";
				echo "</td>";
*/				echo "<td>";
					echo "$intitule_credits_chapitre";
				echo "</td>";

				echo "<td align = \"center\">";
					echo "$total_alloue";
				echo "</td>";

				echo "<td align = \"center\">";
					echo "$nbr_heures_attribuees_domaine_budget_en_HSE";
				echo "</td>";

				echo "<td align = \"center\">";
					affiche_chiffre_si_pas_0($total_distribue_a_afficher);
					//echo "$total_distribue_a_afficher";
/*				echo "</td>";
				echo "<td align = \"center\">";
					affiche_chiffre_si_pas_0($total_distribue_a_afficher_en_HSE);
					//echo "$total_distribue_a_afficher_en_HSE";
				echo "</td>";
				echo "<td align = \"center\">";
					affiche_chiffre_si_pas_0($total_encore_a_distribuer);
					//echo "$total_encore_a_distribuer";
				echo "</td>";
				echo "</td>";
				echo "<td align = \"center\">";
					//echo "$total_encore_a_distribuer_en_HSE";
					affiche_chiffre_si_pas_0($total_encore_a_distribuer_en_HSE);
				echo "</td>";
*/			echo "</tr>";
		}
			echo "<tr>";
				echo "<td align = \"right\">";
					echo "<b>Totaux&nbsp;:&nbsp;</b>";
				echo "</td>";

				echo "<td align = \"center\">";
					//$compteur_hsa_initiales = format_chiffre($compteur_hsa_initiales);
					echo "<b>$compteur_credits_initiaux</b>";
				echo "</td>";

				echo "<td align = \"center\">";
					$compteur_hsa_initiales_en_HSE = $compteur_hsa_initiales*36;
					$compteur_hsa_initiales_en_HSE = format_chiffre($compteur_hsa_initiales_en_HSE);
					echo "<b>$compteur_hsa_initiales_en_HSE</b>";
				echo "</td>";

				echo "<td align = \"center\">";
					$compteur_hsa_distribuees_a_afficher = format_chiffre($compteur_hsa_distribuees);
					echo "<b>$compteur_hsa_distribuees_a_afficher</b>";
				echo "</td>";

/*				echo "<td align = \"center\">";
					$compteur_hsa_distribuees_en_HSE = $compteur_hsa_distribuees*36;
					$compteur_hsa_distribuees_en_HSE = format_chiffre($compteur_hsa_distribuees_en_HSE);
					echo "<b>$compteur_hsa_distribuees_en_HSE</b>";
				echo "</td>";

				echo "<td align = \"center\">";
					$compteur_hsa_encore_a_distribuees = $compteur_hsa_initiales - $compteur_hsa_distribuees;
					$compteur_hsa_encore_a_distribuees = format_chiffre($compteur_hsa_encore_a_distribuees);
					echo "<b>$compteur_hsa_encore_a_distribuees</b>";
				echo "</td>";
				echo "<td align = \"center\">";
					$compteur_hsa_encore_a_distribuees_en_HSE = $compteur_hsa_encore_a_distribuees*36;
					$compteur_hsa_encore_a_distribuees_en_HSE = format_chiffre($compteur_hsa_encore_a_distribuees_en_HSE);
					echo "<b>$compteur_hsa_encore_a_distribuees_en_HSE</b>";
				echo "</td>";
*/			echo "</tr>";
		echo "</table>";
		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner &agrave; la liste\"/>
		<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
		<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
		<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">";
	echo "</form>";
?>
