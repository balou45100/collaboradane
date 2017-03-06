<?php
/*
 *      personnes_ressources_gestion_tableau_bord_heures.inc.php
 *      
 *      Copyright 2008-2015 Jürgen Mendel <jurgen.mendel@ac-orleans-tours.fr>
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
	$annee = $annee_en_cours; // en attendant un développement pour pouvoir afficher n'importe quelle année
	
	//echo "<br />annee : $annee";
	
	//Il faut tenir compte du changement de système de la disparition des HSA en faveur des IMP à partir de l'année 2015-2016
	if ($annee < 2015)
	{
		echo "<h1>Tableau de bord des HSA TICE pour $annee_en_cours</h1>";
		echo "<form action=\"personnes_ressources_gestion.php\" method=\"get\">";
			echo "<TABLE width = \"90%\">";
				echo "<colgroup>";
					echo "<col width=\"5%\">"; //ID
					echo "<col width=\"47%\">"; //domaine
					echo "<col width=\"8%\">"; //total affecté HSA
					echo "<col width=\"8%\">"; //total affecté HSE
					echo "<col width=\"8%\">"; //total distribué HSA
					echo "<col width=\"8%\">"; //total distribué HSE
					echo "<col width=\"8%\">"; //total encore à distribuer en HSA
					echo "<col width=\"8%\">"; //total encore à distribuer en HSE
				echo "</colgroup>";
				echo "<th rowspan =\"2\">ID</th>";
				echo "<th rowspan =\"2\">domaine du budget</th>";
				echo "<th colspan = \"2\">Total affect&eacute;</th>";
				echo "<th colspan = \"2\">Total distribu&eacute;</th>";
				echo "<th colspan = \"2\">Reste &agrave; distribuer</th>";
				echo "<tr>";
					echo "<th><b>en HSA</b></th>";
					echo "<th><b>en HSE</b></th>";
					echo "<th><b>en HSA</b></th>";
					echo "<th><b>en HSE</b></th>";
					echo "<th><b>en HSA</b></th>";
					echo "<th><b>en HSE</b></th>";
				echo "</tr>";

			//On lit la table personnes_ressources_domaines_budget
			$requete_domaine_budget = "SELECT * FROM personnes_ressources_domaines_budget 
				WHERE annee ='".$annee."' 
				AND enveloppe_globale = 1 
				ORDER BY id ASC";
				
			$resultat_domaine_budget = mysql_query($requete_domaine_budget);
			$num_rows = mysql_num_rows($resultat_domaine_budget);
			
			//echo "<br>nombre d'enregistrements : $num_rows";

			//on réinitialise les compteurs des totaux
			$compteur_hsa_initiales = 0; //La somme affectée à un domaine du budget
			$compteur_hsa_distribuees = 0; //La somme distribuée
			while ($ligne_domaine_budget = mysql_fetch_object($resultat_domaine_budget))
			{
				$id_domaine_budget = $ligne_domaine_budget->id;
				$annee_domaine_budget = $ligne_domaine_budget->annee;
				$intitule_domaine_budget = $ligne_domaine_budget->intitule;
				$nbr_heures_attribuees_domaine_budget = $ligne_domaine_budget->nbr_heures_attribuees;
				$nbr_heures_attribuees_domaine_budget_en_HSE = $nbr_heures_attribuees_domaine_budget*36;
				$nbr_heures_attribuees_domaine_budget_en_HSE = number_format($nbr_heures_attribuees_domaine_budget_en_HSE,2,',',' ');

				//on totalise les hsa initiales
				$compteur_hsa_initiales = $compteur_hsa_initiales + $nbr_heures_attribuees_domaine_budget;

				//Il faut récupérer le total es heures affecté par domaine
				$requete_total_distribue = " SELECT SUM(nbr_hsa) FROM fonctions_des_personnes_ressources WHERE `domaine_budget` ='".$id_domaine_budget."' AND annee = '".$annee."'";
				$resultat_total_distribue = mysql_query($requete_total_distribue);
				$total_distribue = mysql_fetch_row($resultat_total_distribue);
				$total_distribue_a_afficher = $total_distribue[0];

				//on totalise les hsa initiales
				$compteur_hsa_distribuees = $compteur_hsa_distribuees + $total_distribue_a_afficher;
				$total_distribue_a_afficher = number_format($total_distribue[0],2,',',' ');
				$total_distribue_a_afficher_en_HSE = $total_distribue_a_afficher*36;
				$total_distribue_a_afficher_en_HSE = number_format($total_distribue_a_afficher_en_HSE,2,',',' ');
				
				//On calcul le total qui reste encore à distribuer
				$total_encore_a_distribuer = $nbr_heures_attribuees_domaine_budget - $total_distribue_a_afficher;
				$total_encore_a_distribuer = number_format($total_encore_a_distribuer,2,',',' ');
				$total_encore_a_distribuer_en_HSE = $total_encore_a_distribuer*36;
				$total_encore_a_distribuer_en_HSE = number_format($total_encore_a_distribuer_en_HSE,2,',',' ');
				echo "<tr>";
					echo "<td align = \"center\">";
						echo "$id_domaine_budget";
					echo "</td>";
					echo "<td>";
						echo "$intitule_domaine_budget";
					echo "</td>";
					echo "<td align = \"center\">";
						echo "$nbr_heures_attribuees_domaine_budget";
					echo "</td>";
					echo "<td align = \"center\">";
						echo "$nbr_heures_attribuees_domaine_budget_en_HSE";
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_distribue_a_afficher);
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_distribue_a_afficher_en_HSE);
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_encore_a_distribuer);
					echo "</td>";
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_encore_a_distribuer_en_HSE);
					echo "</td>";
				echo "</tr>";
			}
				echo "<tr>";
					echo "<td colspan = \"2\" align = \"right\">";
						echo "<b>Totaux&nbsp;:&nbsp;</b>";
					echo "</td>";
					echo "<td align = \"center\">";
						echo "<b>$compteur_hsa_initiales</b>";
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
					echo "<td align = \"center\">";
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
				echo "</tr>";
			echo "</table>";
	} // Fin if ($annee < 2015)
	else // Suivi en IMP
	{
		echo "<h1>Tableau de bord des IMP DANE pour $annee_en_cours</h1>";
		echo "<form action=\"personnes_ressources_gestion.php\" method=\"get\">";
			echo "<TABLE width = \"90%\">";
				echo "<colgroup>";
					echo "<col width=\"5%\">"; //ID
					echo "<col width=\"65%\">"; //domaine
					echo "<col width=\"10%\">"; //total affecté
					echo "<col width=\"10%\">"; //total distribué
					echo "<col width=\"10%\">"; //total encore à distribuer
				echo "</colgroup>";
				echo "<th>ID</th>";
				echo "<th>domaine du budget</th>";
				echo "<th>Total affect&eacute;</th>";
				echo "<th>Total distribu&eacute;</th>";
				echo "<th>Reste &agrave; distribuer</th>";
			//On lit la table personnes_ressources_domaines_budget
			$requete_domaine_budget = "SELECT * FROM personnes_ressources_domaines_budget 
				WHERE annee ='".$annee."' 
				AND enveloppe_globale = 1 
				ORDER BY id ASC";

			//echo "<br />requete_domaine_budget : $requete_domaine_budget";

			$resultat_domaine_budget = mysql_query($requete_domaine_budget);
			$num_rows = mysql_num_rows($resultat_domaine_budget);

			//on réinitialise les compteurs des totaux
			$compteur_imp_initiales = 0; //La somme affectée à un domaine du budget
			$compteur_imp_distribuees = 0; //La somme distribuée
			while ($ligne_domaine_budget = mysql_fetch_object($resultat_domaine_budget))
			{
				$id_domaine_budget = $ligne_domaine_budget->id;
				$annee_domaine_budget = $ligne_domaine_budget->annee;
				$intitule_domaine_budget = $ligne_domaine_budget->intitule;
				$somme_IMP_attribuee_domaine_budget = $ligne_domaine_budget->somme_imp_attribuee;
				$somme_IMP_attribuee_domaine_budget_a_afficher = number_format($somme_IMP_attribuee_domaine_budget,2,',',' ');
				//$somme_IMP_attribuee_domaine_budget_a_afficher = $somme_IMP_attribuee_domaine_budget;
				
				//on totalise les imp initiales
				$compteur_imp_initiales = $compteur_imp_initiales + $somme_IMP_attribuee_domaine_budget;

				//Il faut récupérer le total des IMP affectées par domaine
				$requete_total_distribue = " SELECT SUM(somme_imp) AS total FROM fonctions_des_personnes_ressources WHERE `domaine_budget` ='".$id_domaine_budget."' AND annee = '".$annee."'";
				$resultat_total_distribue = mysql_query($requete_total_distribue);
				$total_distribue = mysql_fetch_assoc($resultat_total_distribue);
				$total_distribue_a_afficher = $total_distribue['total'];
				
				//on totalise les imp distribuées
				$compteur_imp_distribuees = $compteur_imp_distribuees + $total_distribue['total'];
				$total_distribue_a_afficher = number_format($total_distribue['total'],2,',',' ');
				
				//On calcul le total qui reste encore à distribuer
				$total_encore_a_distribuer = $somme_IMP_attribuee_domaine_budget - $total_distribue['total'];
				$total_encore_a_distribuer = number_format($total_encore_a_distribuer,2,',',' ');

				echo "<tr>";
					echo "<td align = \"center\">";
						echo "$id_domaine_budget";
					echo "</td>";
					echo "<td>";
						echo "$intitule_domaine_budget";
					echo "</td>";
					echo "<td align = \"center\">";
						echo "$somme_IMP_attribuee_domaine_budget_a_afficher";
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_distribue_a_afficher);
					echo "</td>";
					echo "<td align = \"center\">";
						affiche_chiffre_si_pas_0($total_encore_a_distribuer);
					echo "</td>";
					echo "</td>";
				echo "</tr>";
			}
				echo "<tr>";
					echo "<td colspan = \"2\" align = \"right\">";
						echo "<b>Totaux&nbsp;:&nbsp;</b>";
					echo "</td>";
					echo "<td align = \"center\">";
						$compteur_imp_initiales_a_afficher = format_chiffre($compteur_imp_initiales);
						echo "<b>$compteur_imp_initiales_a_afficher</b>";
					echo "</td>";
					echo "<td align = \"center\">";
						$compteur_imp_distribuees_a_afficher = format_chiffre($compteur_imp_distribuees);
						echo "<b>$compteur_imp_distribuees_a_afficher</b>";
					echo "</td>";
					echo "<td align = \"center\">";
						$compteur_imp_encore_a_distribuees = $compteur_imp_initiales - $compteur_imp_distribuees;
						$compteur_imp_encore_a_distribuees = format_chiffre($compteur_imp_encore_a_distribuees);
						echo "<b>$compteur_imp_encore_a_distribuees</b>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
	}
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
		<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
		<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">";

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<Td>";
						echo "<INPUT border=0 src=\"$chemin_theme_images/retour.png\" ALT = \"Valider\" title=\"Retourner &agrave; la liste\" border=\"0\" type=image Value= \"Retourner à la liste\" submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</TD>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";


	echo "</form>";
?>
