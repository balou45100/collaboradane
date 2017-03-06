<?php
/*
 *      personnes_ressources_gestion_modif_fonction.inc.php
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
	$requete_fonction_a_modifier = "SELECT * FROM fonctions_des_personnes_ressources WHERE id = '".$id_exercice."'";
	$resultat_fonction_a_modifier = mysql_query($requete_fonction_a_modifier);
	$ligne_fonction_a_modifier = mysql_fetch_object($resultat_fonction_a_modifier);
	$annee_fonction_a_modifier = $ligne_fonction_a_modifier->annee;
	$fonction_a_modifier = $ligne_fonction_a_modifier->fonction;
	$rne_fonction_a_modifier = $ligne_fonction_a_modifier->rne;
	$id_fonction_a_modifier = $ligne_fonction_a_modifier->id;
	$nbr_hsa_a_modifier = $ligne_fonction_a_modifier->nbr_hsa;
	$somme_imp_a_modifier = $ligne_fonction_a_modifier->somme_imp;
	$domaine_budgetaire_a_modifier = $ligne_fonction_a_modifier->domaine_budgetaire;
	$observation_a_modifier = $ligne_fonction_a_modifier->observation;
	//echo "<br>observation_a_modifier : $observation_a_modifier";
	echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">";
		echo "<fieldset>
			<legend>La fonction &agrave; modifier</legend>";
			echo "<p>
				<label for=\"form_fonction\">Fonction&nbsp;:&nbsp;</label>
			</p>
			<p>";
				$requete_fonctions = "SELECT * FROM fonctions_personnes_ressources WHERE selection = 'O' ORDER BY intitule_fonction";
				$resultat_fonctions = mysql_query($requete_fonctions);
				$num_rows = mysql_num_rows($resultat_fonctions);
				
				echo "<select size=\"1\" id=\"form_fonction\" name=\"intitule_fonction_a_modifier\">";
				if (mysql_num_rows($resultat_fonctions))
				{
					echo "<option selected value=\"$fonction_a_modifier\">$fonction_a_modifier</option>";
					while ($ligne_fonction=mysql_fetch_object($resultat_fonctions))
					{
						$intitule_fonction=$ligne_fonction->intitule_fonction;
						//$id_fonction=$ligne_fonction->id_fonction;
						echo "<option value=\"$intitule_fonction\">$intitule_fonction ($annee_fonction_a_modifier)</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>";
			echo "<p>";
				/*
				//recherche des informations de l'étab de rattachement de la personne
				$requete_etab_rattachement="SELECT RNE,TYPE,NOM,VILLE FROM etablissements WHERE rne = ".$codetab."";
				$result_etab_rattachement=mysql_query($requete_etab_rattachement);
				$num_rows = mysql_num_rows($result_etab_rattachement);
				$ligne_etab_rattachement=mysql_fetch_object($result_etab_rattachement);
				$rne_etab_rattachement = $ligne_etab_rattachement->rne;
				$ville_etab_rattachement = $ligne_etab_rattachement->ville;
				$type_etab_rattachement = $ligne_etab_rattachement->type;
				$nom_etab_rattachement = $ligne_etab_rattachement->nom;
				*/
				//On rempli le champ de sélection avec l'étab de rattachement comme sélection
				//echo "<br>rne_fonction_a_modifier : $rne_fonction_a_modifier";
				if ($rne_fonction_a_modifier =="")
				{
					//On modifie la variable pour refléter celui de rattachement dans la fiche de la personne	
					//echo "<br>id : $id";
					$requete_personne="SELECT codetab FROM personnes_ressources_tice WHERE id_pers_ress = '".$id."'";
					$result_personne=mysql_query($requete_personne);
					$num_rows = mysql_num_rows($result_personne);
					$ligne_personne=mysql_fetch_object($result_personne);
					$rne_fonction_a_modifier = $ligne_personne->codetab;
					//echo "<br>codetab_extrait : $rne_fonction_a_modifier";
				}
				$requete_etab_selection="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements WHERE rne = '".$rne_fonction_a_modifier."'";
				$result_etab_selection=mysql_query($requete_etab_selection);
				$num_rows = mysql_num_rows($result_etab_selection);
				$ligne_selection=mysql_fetch_object($result_etab_selection);
				$rne_selection = $ligne_selection->RNE;
				$type_selection = $ligne_selection->TYPE;
				$nom_selection = $ligne_selection->NOM;
				$ville_selection = $ligne_selection->VILLE;

				//Ensuite on recherche le reste de la liste
				$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements ORDER BY RNE";
				$result_etabs=mysql_query($requete_etabs);
				$num_rows = mysql_num_rows($result_etabs);
				echo "<label for=\"form_rne\">fonction exerc&eacute;e dans (RNE)&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_rne\" name=\"rne_a_modifier\">";
				if (mysql_num_rows($result_etabs))
				{
					echo "<option selected VALUE = \"".$rne_selection."\">".$rne_selection." - ".str_replace("*", " ",$type_selection)." ".str_replace("*", " ",$nom_selection). " - ".$ville_selection."</OPTION>";
					while ($ligne=mysql_fetch_object($result_etabs))
					{
						$rne = $ligne->RNE;
						$type = $ligne->TYPE;
						$nom = $ligne->NOM;
						$ville = $ligne->VILLE;
						echo "<OPTION VALUE = \"".$rne."\">".$rne." - ".str_replace("*", " ",$type)." ".str_replace("*", " ",$nom). " - ".$ville."</OPTION>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>";
			echo "<p>";
				echo "<label for=\"form_annee\">Ann&eacute;e&nbsp;:&nbsp;</label>";
			echo "</p>";
			echo "<p>";
				echo "<select size=\"1\" id=\"form_annee\" name=\"annee_fonction_a_modifier\">
					<option selected value=\"$annee_fonction_a_modifier\">$annee_fonction_a_modifier</option>";
					if ($annee_en_cours > 2014) //début du système des IMP
					{
						$compteur_debut = 2015;
						$compteur_fin = $annee_fonction_a_modifier+3;
					}
					else //Système des HSA
					{
						$compteur_debut = $annee_fonction_a_modifier-3;
						$compteur_fin = 2014;
					}
					for ($i = $compteur_debut; $i <= $compteur_fin; $i++)
					{
						if($i <> $annee_fonction_a_modifier)
						{
							echo "<option value=\"$i\">$i</option>";
						}
					}
			        echo "</select>";
			echo "</p>";
			if($annee_en_cours < 2015) // Avant le changement vers les IMP
			{
				echo "<p>
					<label for=\"form_nbr_heures\">Nombre d'heures&nbsp;:&nbsp;</label>
					<input type=\"text\" id=\"form_nbr_heures\" value = \"".$nbr_hsa_a_modifier."\" name=\"nbr_hsa_a_modifier\" />
				</p>";
				echo "<p>";
					echo "<label for=\"form_hse\">&agrave;&nbsp;cocher s'il s'agit d'HSE&nbsp;:&nbsp;</label>";
				echo "</p>";
				echo "<p>";
					echo "<a for = \"form_hse_valeur\">&nbsp;<input type=\"checkbox\" name=\"hse_exercice\" value=\"Oui\" size=\"4\" /></a>";
				echo "</p>";
			}
			else //Système des IMP
			{
				echo "<p>";
					echo "<label for=\"form_taux_imp\">Taux IMP attribu&eacute;&nbsp;:&nbsp;</label>";
					//On génère la liste de sélection
					//À partir de 2015 il faut récupérer le taux IMP à afficher
					if($annee >2014)
					{
						$req_champ="SELECT taux FROM imp WHERE montant = '".$somme_imp_a_modifier."' AND annee = '".$annee_en_cours."'";
						$execution= mysql_query($req_champ);
						$res = mysql_fetch_row($execution);
						$taux_imp_a_modifier = $res[0];
					}
					//echo "<br />taux_imp_a_modifier : $taux_imp_a_modifier";
					//echo "<br />somme_imp_a_modifier : $somme_imp_a_modifier";
					//remplir_champ_select_par_annee('','taux_imp_exercice','taux','montant','imp','','Faire un choix','annee',$annee_en_cours,'taux');
					remplir_champ_select_par_annee('','taux_imp_exercice','taux','montant','imp',$taux_imp_a_modifier,$somme_imp_a_modifier,'annee',$annee_en_cours,'taux');
				echo "</p>";

			}
			echo "<p>
				<label for=\"form_observation\">Observation&nbsp;:&nbsp;</label>
				<TEXTAREA name=\"observation\" rows=3 COLS=60>$observation_a_modifier</TEXTAREA>
				<!--input type=\"text\" id=\"form_observation\" name=\"observation\" /-->
			</p>";

		echo "</fieldset>";
		echo "<p>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer la fiche\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id_exercice\" NAME = \"id_exercice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_fonction\" NAME = \"travail_sur_fonction\">
			<INPUT TYPE = \"hidden\" VALUE = \"consulter_personne\" NAME = \"a_faire\">";
		echo "</p>";
	echo "</form>";

?>
