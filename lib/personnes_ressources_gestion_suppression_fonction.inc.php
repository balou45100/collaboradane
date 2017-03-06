<?php
/*
 *      personnes_ressources_gestion_suppression_fonction.inc.php
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
			echo "<h1>Confirmez la suppression de la fonction suivante :</h1>";
			// Requête pour recupérer les informations
			$requete_fonction_a_supprimer = "SELECT * FROM fonctions_des_personnes_ressources WHERE id = '".$id_exercice."'";
			$resultat_fonction_a_supprimer = mysql_query($requete_fonction_a_supprimer);
			$ligne_fonction_a_supprimer = mysql_fetch_object($resultat_fonction_a_supprimer);
			$annee_fonction_a_supprimer = $ligne_fonction_a_supprimer->annee;
			$fonction_a_supprimer = $ligne_fonction_a_supprimer->fonction;
			$rne_fonction_a_supprimer = $ligne_fonction_a_supprimer->rne;
			$id_fonction_a_supprimer = $ligne_fonction_a_supprimer->id;
			$nbr_hsa_a_supprimer = $ligne_fonction_a_supprimer->nbr_hsa;
			$somme_imp_a_supprimer = $ligne_fonction_a_supprimer->somme_imp;
			
			//echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">";
			echo "<form action=\"personnes_ressources_gestion.php\" method=\"get\">";
/*
				echo "<fieldset>
					<legend>Renseignements sur la fonction &agrave; supprimer</legend>
				<p>";
*/
				echo "<table border = \"1\">";
					//if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_personnes_ressource == "1"))
					if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
					{
						echo "<colgroup>";
							echo "<col width=\"10%\">";
							echo "<col width=\"40%\">";
							echo "<col width=\"20%\">";
							echo "<col width=\"10%\">";
							echo "<col width=\"10%\">";
							echo "<col width=\"10%\">";
						echo "</colgroup>";
					}
					else
					{
						echo "<colgroup>";
							echo "<col width=\"10%\">";
							echo "<col width=\"55%\">";
							echo "<col width=\"20%\">";
							echo "<col width=\"15%\">";
						echo "</colgroup>";
						
					}
					echo "<th bgcolor = \"$bg_color1\">ann&eacute;</th>";
					echo "<th bgcolor = \"$bg_color1\">fonction</th>";
					echo "<th bgcolor = \"$bg_color1\">exerc&eacute;e dans</th>";
					//if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_personnes_ressource == "1"))
					if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
					{
						echo "<th bgcolor = \"$bg_color1\">HSA</th>";
						echo "<th bgcolor = \"$bg_color1\">IMP</th>";

					}
					echo "<th bgcolor = \"$bg_color1\">actions</th>";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "&nbsp;$annee_fonction_a_supprimer";
						echo "</td>";
						echo "<td>";
							echo "&nbsp;$fonction_a_supprimer";
						echo "</td>";
						echo "<td align = \"center\">";
							affiche_info_bulle($rne_fonction_a_supprimer,"RESS",0);
							//echo "<a for = \"form_rne_valeur\">&nbsp;$rne_exercice</a>";
						echo "</td>";
						if ($autorisation_personnes_ressources == "1" AND $niveau_droits == "3")
						{
							echo "<td align = \"center\">";
								if ($nbr_hsa_a_supprimer <> 0)
								{
									echo "&nbsp;$nbr_hsa_a_supprimer";
								}
								else
								{
									echo "&nbsp;";
								}
							echo "</td>";
							echo "<td align = \"center\">";
								if ($somme_imp_a_supprimer <> 0)
								{
									echo "&nbsp;$somme_imp_a_supprimer";
								}
								else
								{
									echo "&nbsp;";
								}

							echo "</td>";
							echo "<td nowrap class = \"fond-actions\">";
								echo "<A HREF = \"personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=consulter_personne&amp;travail_sur_fonction=confirm_supp_fonction&amp;id=".$id."&amp;id_exercice=".$id_exercice."&amp;indice=".$indice."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" border = \"0\" title=\"Confirmer la suppression de cette fonction\"></A>";
							echo "</td>";
						}
					echo "</tr>";
					//echo "<a for = \"form_annee_valeur\">&nbsp;$annee_exercice&nbsp;-&nbsp;$fonction_exercice&nbsp;-&nbsp;$rne_exercice</a>";
					
				echo "</table>";
/*
				echo "</p>";
				echo "</fieldset>";
				echo "<p>";
*/
					//<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer le matériel\"/>
					echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans supprimer la fiche\"/>
					<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
					<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
					<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
					<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
					<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
					<INPUT TYPE = \"hidden\" VALUE = \"consulter_personne\" NAME = \"a_faire\">";
				//echo "</p>";
			echo "</form>";

?>
