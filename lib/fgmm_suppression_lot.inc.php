<?php
//echo "<BR> Je suis dans la procédure de suppression du lot $id_lot";
              $id_lot = $_GET['id_lot'];
              
              //Récupération des variables de la table lot 
              include("../biblio/init.php");
              $query_lots = "SELECT DISTINCT * FROM fgmm_lot WHERE id_lot = $id_lot;";
		          $results_lots = mysql_query($query_lots);
		          $num_results_lots = mysql_num_rows($results_lots);
              $lot_extrait = mysql_fetch_row($results_lots);
              
              
              //echo "<BR>lot : $id_lot - promis : $promis - recu : $recu - materiel : $materiel";
              
              echo "<BR>
                <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
                  <CAPTION><b>Supprimer ce lot&nbsp;?</b></CAPTION>
                  <tr>
                    <td width=\"7%\" align=\"center\">Id</td>
                    <td width=\"20%\" align=\"center\">Lot</td>
                    <td width=\"10%\" align=\"center\">Valeur</td>
                    <td width=\"15%\" align=\"center\">niveau</td>
                    <td width=\"5%\" align=\"center\">Valider</td>
                  </tr>";
                  
              echo "<tr CLASS = \"new\">
                      <td width=\"7%\" align = \"center\">".$lot_extrait[0]."</td>
                      <td width=\"20%\">".$lot_extrait[2]."</td>";
                        $nombre_a_afficher = Formatage_Nombre($lot_extrait[4],$monnaie_utilise);
                      echo "<td width=\"10%\" align=\"center\">$nombre_a_afficher</td>";
                      echo "<td width=\"15%\" align=\"center\">".$lot_extrait[9]."</TD>";
                      echo "<TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                        <INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
                      </TD>
                    </tr>
                  </TABLE>
                  <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
                  <INPUT TYPE = \"hidden\" VALUE = \"confirm_suppression_lot\" NAME = \"action\">
		              <INPUT TYPE = \"hidden\" VALUE = \"".$lot_extrait[0]."\" NAME = \"id_lot\">";
?>
