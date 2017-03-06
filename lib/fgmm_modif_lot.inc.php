<?php
//echo "<BR> Je suis dans la procédure de modification du lot $id_lot";
              $id_lot = $_GET['id_lot'];
              //Récupération des variables de la table lot 
              include("../biblio/init_fgmm.php");
              $query_lots = "SELECT DISTINCT * FROM fgmm_lot WHERE id_lot = $id_lot;";
		          $results_lots = mysql_query($query_lots);
		          $num_results_lots = mysql_num_rows($results_lots);
              $lot_extrait = mysql_fetch_row($results_lots);
              
              
              //echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";
              
              echo "<BR>
                <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
                  <CAPTION><b>Lots</b></CAPTION>
                  <tr>
                    <td width=\"5%\" align=\"center\">Id</td>
                    <td width=\"30%\" align=\"center\">Lot</td>
                    <td width=\"10%\" align=\"center\">Valeur</td>
                    <td width=\"10%\" align=\"center\">niveau</td>
                    
					<!--td width=\"5%\" align=\"center\">PS fid.</td>
                    <td width=\"5%\" align=\"center\">PS 3proj.</td>
                    <td width=\"5%\" align=\"center\">Prix part.</td>
                    <td width=\"5%\" align=\"center\">attribué</td-->
                    
					<td width=\"20%\" align=\"center\">illustration</td>
                    <td width=\"5%\" align=\"center\">afficher</td>
                    <td width=\"5%\" align=\"center\">promis</td>
                    <td width=\"5%\" align=\"center\">reçu</td>
                    <td width=\"5%\" align=\"center\">matériel</td>
                    <td width=\"5%\" align=\"center\">Valider</td>
                  </tr>";
                  
              echo "<tr CLASS = \"new\">
                      <td width=\"5%\" align = \"center\">".$lot_extrait[0]."</td>
                      <td width=\"30%\"><input type=\"text\" value = \"".$lot_extrait[2]."\" name=\"lot\" size = \"50\"></td>";
                        $nombre_a_afficher = Formatage_Nombre($lot_extrait[4],$monnaie_utilise);
                      echo "<td width=\"10%\" align=\"center\"><input type=\"text\" value = \"$nombre_a_afficher\" name=\"valeur_lot\"></td>";
                      echo "<td width=\"10%\" align=\"center\">
                        <select size=\"1\" name=\"niveau\">
		                      <option selected value=\"".$lot_extrait[9]."\">".$lot_extrait[9]."</option>
			                    <option value=\"Tous\">Tous</option>
			                    <option value=\"Ecole\">Ecole</option>
			                    <option value=\"Ecole/Collège\">Ecole/Collège</option>
			                    <option value=\"Collège\">Collège</option>
			                    <option value=\"Collège/Lycée\">Collège/Lycée</option>
                          <option value=\"Lycée\">Lycée</option>
                        </select>";
                      echo "</TD>";
                      echo "<td width=\"20%\" align = \"center\"><input type=\"text\" value = \"".$lot_extrait[13]."\" name=\"illustration_lot\" size = \"30\"></td>";
                      $checked=Testpourcocher($lot_extrait[14]);
                		echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"afficher_pour_selection\" value=\"1\" $checked></td>";
						$checked=Testpourcocher($lot_extrait[5]);
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"promis\" value=\"1\" $checked></td>";
                      $checked=Testpourcocher($lot_extrait[6]);
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"recu\" value=\"1\" $checked></td>";
                      $checked=Testpourcocher($lot_extrait[8]);
                      echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"materiel\" value=\"1\" $checked></td>";
                      echo "<TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                        <INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
                      </TD>
                    </tr>
                  </TABLE>
                  <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
                  <INPUT TYPE = \"hidden\" VALUE = \"enreg_lot_modifie\" NAME = \"action\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[0]."\" NAME = \"id_lot\">";
?>
