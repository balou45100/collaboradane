<?php
//echo "<h2> Page en pr&eacute;paration - ann&eacute;e en cours : $annee_en_cours</h2>";
//echo "<br />RNE : $id_societe<br />";
//echo "<br />annee_en_cours : $annee_en_cours";
// Extraction des enregistrements concern&eacute;s
            //$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' AND NUM_ETABLISSEMENT = '".$id_societe."' ORDER BY ID_PB $sense_tri;";
            //$query_count = "SELECT * FROM personnes_ressources_tice, fonctions_personnes_ressources_tice WHERE personnes_ressources_tice.id_pers_ress = fonctions_personnes_ressources_tice.id_pers_ress AND ";";
            $query = "SELECT DISTINCT * FROM personnes_ressources_tice AS prt, fonctions_des_personnes_ressources AS fpr WHERE prt.id_pers_ress=fpr.id_pers_ress AND fpr.rne =  '".$id_societe."' AND fpr.annee=$annee_en_cours ORDER BY prt.nom, fpr.annee ASC;";
			
			//echo "<br />$query";
						/*
            if($_SESSION['droit'] == "Super Administrateur" )
						{
              $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
            }
            else
            {
          	   $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' ORDER BY ID_PB DESC;";
						}
						*/
            $results = mysql_query($query);
						if(!$results)
						{
							echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
							echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
							mysql_close();
							exit;
						}
						//Retourne le nombre de ligne rendu par la requ&egrave;te
						$num_results = mysql_num_rows($results);
						//echo $num_results;
						  
echo "<h2>Nombre de personnes ressources TICE&nbsp;:&nbsp;$num_results</h2>";
  
echo "<table>";
	//echo "<caption><b>Nombre de personnes ressources TICE&nbsp;:&nbsp;$num_results</b></caption>";
	echo "<tr>";
		echo "<th>";
	   /*
     if ($sense_tri =="asc")
		 {
      echo "ID<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
		 }
     else
     {
      echo "ID<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
		 }
		 */
		 echo "ID";
     echo "
			 </th>";
     /*
     echo "
       <th>ST</th>";
			*/
      		echo "<th>";
					  /*
            if ($sense_tri =="asc")
					  {
					  */
              echo "Nom";
              //echo "Cr&eacute;&eacute; par<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
					  /*
            }
            else
            {
              echo "Cr&eacute;&eacute; par<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par &eacute;metteur, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
					  }
					  */
				echo "
					</th>
					<th>
            Pr&eacute;nom
          </th>
					<th>
						discipline
					</th>
					<th>
						poste
					</th>";
	        echo "<th>
						domaine ressource
					</th>
					<th>
						m&eacute;l
					</th>
					<th>
          	Ann&eacute;e
					</th>
				</tr>";
	         /*
           if ($sense_tri =="asc")
					 {
            echo "Priorit&eacute;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par priorit&eacute; par ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></a>";
					 }
           else
           {
            echo "Priorit&eacute;<a href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par priorit&eacute; par ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></a>";
					 }
					 */
            //echo "Priorit&eacute;";
        /*  
        echo "
						</th>
					<th>
						Actions
					</th>
				</tr>";
        */
  
  
           //Requ&egrave;te pour afficher les personnes ressources
						if ($sense_tri == "")
						{
						  $sense_tri="DESC";
						}
						
            
            
						////////////////////////////////////////
						
						//Traitement de chaque ligne
						for($i = 0; $i < $num_results; ++$i)
						{
							$res = mysql_fetch_row($results);
							
              	//Retourne le nombre de ligne rendu par la requ&egrave;te
								//$num_results_count = mysql_num_rows($results_count);
							  //pour voir le contenu des champs recup&eacute;r&eacute;-->
                //echo "<br />res[0] : $res[0] - res[1] : $res[1] - res[2] : $res[2] - res[3] : $res[3] - res[4] : $res[4] - res[5] : $res[5] - res[12] : $res[12] - res[13] : $res[13] - res[14] : $res[14]";  
								echo "<TR   CLASS = \"new\">";
								  echo "<td align=\"center\">";
								    echo $res[0];
								  echo "</td>";
                  /*
                  echo "<td BGCOLOR = $couleur_fond align=\"center\">";
								    echo " ";
								  */
                  echo "</td>";
								  echo "<td>";
								  echo $res[2];
								  echo "</td>";
								  echo "<td>";
								    echo $res[3];
								  echo "</td>";
								  echo "<td align=\"center\">";
								  //R&eacute;cup&eacute;rer l'intitul&eacute; de la discipline 
								  //echo "<br />id_discipline : $res[5]";
								  if ($res[5]>0)
								  {
								    //echo "<br />ok";
								    $query_discipline = "SELECT DISTINCT * FROM discipline WHERE id_discipline =  '".$res[5]."';";
                    $result_discipline = mysql_query($query_discipline);
                    $res_discipline = mysql_fetch_row($result_discipline);
                    echo $res_discipline[0];
                  }
                  else
                  {
                    echo " ";
                  }
                  echo "</td>";
                  echo "<td align=\"center\">";
								  
                  //R&eacute;cup&eacute;rer l'intitul&eacute; du poste 
								  //echo "<br />id_discipline : $res[5]";
								  if ($res[7]>0)
								  {
								    //echo "<br />ok";
								    $query_poste = "SELECT DISTINCT * FROM postes WHERE id_poste =  '".$res[7]."';";
                    $result_poste = mysql_query($query_poste);
                    $res_poste = mysql_fetch_row($result_poste);
                    echo $res_poste[1];
                  }
                  else
                  {
                    echo " ";
                  }
                  echo "<td>";
								    echo $res[14];
								  echo "</td>";
                  echo "<td>";
                  $mel=$res[9]."@ac-orleans-tours.fr";
								  echo $mel;
								  echo "</td>";
								  echo "<td>";
								    echo $res[15];
								  echo "</td>";
                  
                  
                  /*
                  if ($tri <> "SRNE")
					        {
                    echo "<td>";
                    echo $res[4];
								    echo "</td>";
								  }
								  
								  
                  echo "<td>";
								    echo $res[5];
								  echo "</td>";
								  
                  echo "<td align=\"center\">";
								    echo $num_results_count;
								  echo "</td>";
								  echo "<td BGCOLOR = $fond align=\"center\">";
								    echo $priorite_selection;
								  echo "</td>";
								  echo "<td BGCOLOR = \"#48D1CC\">";
								    echo "<a href = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border=\"0\"></a>";
								    //echo "&nbsp;<a href = \"affiche_categories.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les cat&eacute;gories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\" width=\"25px\" height=\"32px\"></a>";
						       */ 
                    if (($_SESSION['nom'] == $res[3]) OR ($_SESSION['droit'] == "Super Administrateur"))
								    {
									     if($res[11] != "A")
									     {
										    //echo "<a href = \"archiver_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\" border=\"0\"></a>";	
										    echo "<a href = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\" border=\"0\"></a>";
										    echo "<a href = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"22px\" border=\"0\"></a>";
                       }
                        //echo "<a href = \"delete_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" border=\"0\" height=\"24px\" width=\"22px\"></a>";
                    }
                    
								  echo "</td>";
								echo "</tr>";
						}
					echo "</table>";
					//Fermeture de la connexion &agrave; la BDD
					mysql_close();
?>
