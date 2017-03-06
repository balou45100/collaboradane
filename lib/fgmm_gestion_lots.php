<?php
  //Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
  session_start();
  
    include("../biblio/init.php");
    include ("../biblio/fct.php");
    include("../biblio/ticket.css");
    include ("../biblio/config.php");
    
    //Récupération des variables
    $filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
    $tri = $_GET['tri'];
		$tri2 = $_GET['tri2'];
		$indice = $_GET['indice'];
		$sense_tri = $_GET['sense_tri'];
    $action = $_GET['action'];
    $CHGMT = $_GET['CHGMT'];
    
    If ($CHGMT == "O") 
    {
      $affichage = "N"; //on n'affiche pas la liste des lots
    }
    //echo "<BR>affichage : $affichage - filtre : $filtre - tri : $tri - tri2 : $tri2 - sense_tri : $sense_tri - CHGMT : $CHGMT - action : $action<BR>";
    
    if(!isset($filtre) || $filtre == "")
		{
			$filtre = $_SESSION['filtre'];
    }
		else
		{
      $_SESSION['filtre'] = $filtre;
		}
       
    if(!isset($tri) || $tri == "")
		{
			$tri = $_SESSION['tri'];
    }
		else
		{
      $_SESSION['tri'] = $tri;
		}
       
    if(!isset($sense_tri) || $sense_tri == "")
		{
		  $sense_tri = $_SESSION['sense_tri'];
    }
		else
		{
      $_SESSION['sense_tri'] = $sense_tri;
		}
    $ses_filtre = $_SESSION['filtre'];
    $ses_tri = $_SESSION['tri'];
    $ses_sense_tri = $_SESSION['sense_tri'];
    
    /*    
    echo "<BR>ses_filtre : $ses_filtre - ses_tri : $ses_tri - ses_sense_tri : $ses_sense_tri<BR>";
    echo "<BR>filtre : $filtre - tri : $tri - tri2 : $tri2 - sense_tri : $sense_tri - CHGMT : $CHGMT - action : $action<BR>";
    */
    //Initialisation des variables utilisées dans la page
    $total_lots = 0; //pour calculer le montant total des lots
    $nb_par_page = 12; //nombre d'enregistrement affichés par page
    //$autorisation_genies = "O";
    
    if ($CHGMT == "O") //pour traiter les modifications dans les différents formulaire de cette page
    {
      switch ($action)
      {
        case "modif_lot" :
          echo "<FORM ACTION = \"fgmm_gestion_lots.php\" METHOD = \"GET\">";
          include ("fgmm_modif_lot.inc.php");
          echo "</FORM>";
          echo "<BR><CENTER><A HREF = \"fgmm_gestion_lots.php?CHGMT=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
        break;
        
        case "enreg_lot_modifie" :
          include ("fgmm_enreg_lot_modifie.inc.php");
          //echo "<BR><CENTER><A HREF = \"fgmm_gestion_lots.php?CHGMT=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
          $affichage = "O";
        break;
        
        case "suppression_lot" :
          echo "<FORM ACTION = \"fgmm_gestion_lots.php\" METHOD = \"GET\">";
              
          include ("fgmm_suppression_lot.inc.php");
              
		      echo "</FORM>";
          echo "<BR><CENTER><A HREF = \"fgmm_gestion_lots.php?CHGMT=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
        break;
        
        case ('confirm_suppression_lot') :
          include ("fgmm_confirm_suppression_lot.inc.php");
              
          //Dans le cas où aucun résultats n'est retourné
				  if(!$result)
			 	  {
					  echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					  //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					  mysql_close();
					  //exit;
				  }
				  $affichage = "O";
        break;
        
      } // fin du switch $action
    } // fin du if de $CHGMT == "O"
    
    if ($affichage <> "N")
    {
      if ($affiche_message_lot == "O")
      {
        echo "<h2>$message_a_afficher</h2>";
      }
    
    //Récupération des lots suivant le filtre demandé
	$query_lots_base = "SELECT * FROM fgmm_lot WHERE annee = $annee_en_cours_FT";
    switch ($filtre)
    {
		case "LOT" :
           	$query_complement1 = "";
        	$intitule_tableau = "Tous les lots";
		break;
		  
		case "LM" :
           	$query_complement1 = " AND materiel = '1'";
			$intitule_tableau = "Les lots sous forme de matériel";
			$type_lot = "sous forme de matériels";
		break;
		  
		case "LP" :
        	$query_complement1 = " AND promis = '1'";
        	$intitule_tableau = "Les lots promis";
		    $type_lot = "promis";
		break;
		  
		case "LR" :
       		$query_complement1 = " AND recu = '1'";
        	$intitule_tableau = "Les lots reçus";
			$type_lot = "reçus";
		break;
    }
	//On ajoute la partie pour le tri
	switch ($tri)
    {
		case "ID" :
        	$query_tri_lots = " ORDER BY id_lot $sense_tri;";
		break;
		      
		case "LOT" :
        	$query_tri_lots = " ORDER BY lot $sense_tri;";
		break;
		      
      	case "VALEUR" :
       		$query_tri_lots = " ORDER BY valeur_lot $sense_tri;";
      	break;
	      
      	case "NIVEAU" :
       		$query_tri_lots = " ORDER BY niveau $sense_tri;";
      	break;
		      
      	case "DON" :
       		$query_tri_lots = " ORDER BY donnateur $sense_tri;";
      	break;
		      
      	case "PSFID" :
       		$query_tri_lots = " ORDER BY ps_fid $sense_tri;";
      	break;
	      
      	case "PS3P" :
       		$query_tri_lots = " ORDER BY ps_3p $sense_tri;";
      	break;
		      
      	case "PPART" :
       		$query_tri_lots = " ORDER BY p_part $sense_tri;";
      	break;
		      
      	case "ATTRIBUE" :
       		$query_tri_lots = " ORDER BY attribue_a $sense_tri;";
      	break;
		      
     	case "PROMIS" :
       		$query_tri_lots = " ORDER BY promis $sense_tri;";
      	break;
		      
      	case "RECU" :
       		$query_tri_lots = " ORDER BY recu $sense_tri;";
      	break;
		      
      	case "MATERIEL" :
       		$query_tri_lots = " ORDER BY materiel $sense_tri;";
      	break;
   	} //Fin switch tri
    //On compose la requête complète    	
    $requete_complete = $query_lots_base.$query_complement1.$query_tri_lots;
    $results_lots = mysql_query($requete_complete);
    $num_results_lots = mysql_num_rows($results_lots);
		    
    if ($num_results_lots == 0)
		{
		  echo "<CENTER><FONT COLOR = \"#000000\"><B>Pas de lots $type_lot</B></FONT>";
            //echo "<BR><A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_lot\" target = \"body\"><FONT COLOR = \"#000000\"><b>Ajouter un lot<b></A><BR></FONT>";
            echo "</CENTER>";
		}
		else
		{
			echo "<center><b>$entete_liste</b></center>";
			echo "  
        <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
            <CAPTION><b>$intitule_tableau ($num_results_lots)</b></CAPTION>
          <tr>
            <TD width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "ID<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "ID<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"17%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "Lot<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=LOT&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "Lot<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=LOT&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"10%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "Valeur<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=VALEUR&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "Valeur<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=VALEUR&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"7%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "Niveau<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=NIVEAU&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "Niveau<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=NIVEAU&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"13%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "Donnateur<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=DON&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "Donnateur<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=DON&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "PS fid.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PSFID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "PS fid.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PSFID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "PS 3proj.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PS3P&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "PS 3proj.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PS3P&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "Prix part.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PPART&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "Prix part.<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PPART&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "attribué<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=ATTRIBUE&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "attribué<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=ATTRIBUE&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "promis<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PROMIS&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "promis<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=PROMIS&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "reçu<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=RECU&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "reçu<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=RECU&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            <td width=\"5%\" align=\"center\">";
            if ($sense_tri =="asc")
		          {
                echo "matériel<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=MATERIEL&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		          }
              else
              {
                echo "matériel<A href=\"fgmm_gestion_lots.php?filtre=$filtre&amp;tri=MATERIEL&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par lot, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		          }
					  echo "</TD>
            
              <td width=\8%\" align=\"center\">Actions</td>
                    <!--td width=\"5%\" align=\"center\">Valider</td-->
                </tr>";
          //Affichage des lots
          $res_lots = mysql_fetch_row($results_lots);
          $total_lots = $total_lots + $res_lots[4];
          
          for($i = 0; $i < $num_results_lots; ++$i)
					{
					   echo "<FORM ACTION = \"fgmm_gestion_lots.php\" METHOD = \"GET\">";
             echo "<tr CLASS = \"new\">
              <td width=\"5%\" align=\"center\">".$res_lots[0]."</td>
              <td width=\"17%\">".$res_lots[2]."</td>";
              $nombre_a_afficher = Formatage_Nombre($res_lots[4],$monnaie_utilise);
              echo "<td width=\"10%\" align=\"center\">$nombre_a_afficher</td>";
              //echo "<br>promis : $res_lots[5]";
              if ($res_lots[9] =="")
              {
                echo "<td width=\"7%\" align=\"center\">&nbsp;</td>";
              }
              else
              {
                echo "<td width=\"7%\" align=\"center\">".$res_lots[9]."</td>";
              }
              // Il faut recupérer le nom du donnateur
              $query_donnateur = "SELECT * FROM repertoire WHERE No_societe = '".$res_lots[3]."';";
				      $result_consult = mysql_query($query_donnateur);
				      $num_rows = mysql_num_rows($result_consult);
              if (mysql_num_rows($result_consult))
              {
		            $ligne=mysql_fetch_object($result_consult);
		            $societe=$ligne->societe;
              }
              echo "<td width=\"13%\" align=\"center\">$societe</td>";
              
              echo "<td width=\"5%\" align=\"center\">"; 
              if ($res_lots[10] == "1")
						  {
                echo "X";
						  }
						  else
						  {
                echo "&nbsp;";
              }
						  echo "</TD>";
              
              /*
              $checked=Testpourcocher($res_lots[10]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"ps_fid\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[11] == "1")
						  {
                echo "X";
						  }
						  else
						  {
                echo "&nbsp;";
              }
						  echo "</TD>";
              /*
              $checked=Testpourcocher($res_lots[11]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"ps_3p\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[12] == "1")
						  {
                echo "X";
						  }
						  else
						  {
                echo "&nbsp;";
              }
						  echo "</TD>";
              /*
              $checked=Testpourcocher($res_lots[12]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"p_part\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[7] <> "0")
						  {
                echo "X";
						  }
						  else
						  {
                echo "&nbsp;";
              }
						  echo "</TD>";
              if ($autorisation_genies == "1")
              {
                $checked=Testpourcocher($res_lots[5]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"promis\" value=\"1\" $checked></td>";
                $checked=Testpourcocher($res_lots[6]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"recu\" value=\"1\" $checked></td>";
                $checked=Testpourcocher($res_lots[8]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"materiel\" value=\"1\" $checked></td>";
                echo "<TD width=\"8%\" BGCOLOR = \"#48D1CC\">
                    <A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le lot\" border=\"0\"></A>
                    <!--A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=copie_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier le lot\" border=\"0\"></A-->
                    <A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=suppression_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer le lot\" border=\"0\"></A>
                </TD>
                <TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                  <!--INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"--> 
                  <!--A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;promis=".$res_lots[5]."&amp;recu=".$res_lots[6]."&amp;materiel=".$res_lots[8]."&amp;action=enreg_modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\"></A-->
                </TD>";
              }
              else
              {
                if ($res_lots[5] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
						    if ($res_lots[6] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
						    if ($res_lots[8] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
              }
              echo "<TD width=\"8%\" BGCOLOR = \"#48D1CC\">
                    <A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le lot\" border=\"0\"></A>
                    <!--A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=copie_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier le lot\" border=\"0\"></A-->
                    <A HREF = \"fgmm_gestion_lots.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=suppression_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer le lot\" border=\"0\"></A>
                </TD>
                <!--TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\"-->
                  <!--INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"--> 
                  <!--A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;id_societe=".$id_societe."&amp;promis=".$res_lots[5]."&amp;recu=".$res_lots[6]."&amp;materiel=".$res_lots[8]."&amp;action=enreg_modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\"></A-->
                <!--/TD-->";
            echo "</tr>
            <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
		        <INPUT TYPE = \"hidden\" VALUE = \"enreg_modif_lot\" NAME = \"action\">
		        <INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
		        <INPUT TYPE = \"hidden\" VALUE = \"".$res_lots[0]."\" NAME = \"id_lot\">
          </FORM>";
          
            $res_lots = mysql_fetch_row($results_lots);
            $total_lots = $total_lots + $res_lots[4];
         }
         $nombre_a_afficher = Formatage_Nombre($total_lots,$monnaie_utilise);
         echo "<tr>
            <td align = \"center\" colspan=\"14\"><b>Nombre total de lots : $num_results_lots&nbsp;&nbsp;&nbsp;Valeur totale des lots&nbsp;:&nbsp;$nombre_a_afficher</b></td>
            </td>
          </tr>
        </table>
        ";
      
    
    }

    } // fin du if ($affichage <> = "N")
    
?>
