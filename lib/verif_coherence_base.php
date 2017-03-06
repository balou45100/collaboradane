<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de vérifier l'intégrété de la base de données et de supprimer les entrées erronnées">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include("../biblio/ticket.css");
	include("../biblio/fct.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>vous n'ètes pas logué</B></FONT></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">Retour à la mire de connexion</A></CENTER>";
		exit;
	}
?>
	</head>
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
			<?php
			
				echo "<h2>Vérification de la BDD</h2>";
			//Récupération de la variable de traitement
			$tache_a_faire = $_GET['taf'];
			//echo "<BR>TAF : $tache_a_faire";
			
      switch ($tache_a_faire)
			{
        case 'verifier': 	//Demande de confirmation pour l'exécution de la vérifiacation
          echo "<FONT COLOR = \"#808080\"><h2>L'intégrité de la base de données va être vérifiée...
                <BR><BR>Voulez-vous vraiment continuer&nbsp;?
                <BR><BR>Des enregistrements peuvent être supprimés&nbsp;!</h2></FONT>
				        <A HREF = \"verif_coherence_base.php?taf=verifier_ok\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/oui.png\" ALT = \"Oui\"></A>
				        &nbsp;<A HREF = \"gestion_ticket.php?tri=G&amp;indice=O\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/non.png\" ALT = \"Non\"></A>";
			  break;
        
        case 'verifier_ok':
          //Initialisation des compteurs
			  $compteur_entree_a_supprimer = 0;
			  $compteur_entree_ok = 0;
			  
				//Inclusion des fichiers nécessaires
        include("../biblio/init.php");
				
				
				echo "<FONT COLOR = \"#808080\"><h2>L'intégrité de la base de données va être vérifiée...<BR>Ne fermez pas la fenêtre avant la fin de la procédure&nbsp;!!</h2></FONT>";
				
				//Vérifiactaion de la table categorie pour effacer les tickets qui y figurent et qui n'existent plus
			  //-------------------------------------------------------------------------------------------------------
        echo "</CENTER>";
				echo "<TABLE width=\"50%\" align=\"center\">
              <TR>
              <TD>";
					echo "<FONT COLOR = \"#808080\"><h2>Etape 1 : Vérification des catégories...<BR></FONT>";
        /*
        echo "</TD>
            <TR>
              <TD>";
        */
        $query_cat = "SELECT * FROM categorie ORDER BY NOM ASC;";
				$result_cat = mysql_query($query_cat);
				if(!$result_cat)
				{
					echo "<FONT COLOR = \"#808080\"><B>problème lors de l'execution de la requète</B></FONT>";
					echo "<A HREF = \"gestion_tickets.php?tri=G&amp;indice=0\">Retour à la Gestion de ticket</A>";
					mysql_close();
					exit;
				}
				$num_result_cat_count = mysql_num_rows($result_cat);
				//echo "<BR><FONT COLOR = \"#808080\"><b>Nombre de catégories à traiter : $num_result_cat_count</b></FONT>";
				$res_cat = mysql_fetch_row($result_cat);
				
				for($i=0; $i<$num_result_cat_count; ++$i)
				  {
					  //echo "<BR><FONT COLOR = \"#808080\">Catégorie <b>".$res_cat[0]." - ".$res_cat[1]." (".$res_cat[2].")&nbsp;</b></FONT>";
					  $tickets_a_traiter = explode(";",".$res_cat[5].");
					  $nombre = count($tickets_a_traiter)-1;
					  //echo ".";
					  for($j=0; $j<$nombre; ++$j)
				    {
              //echo ".";
              //echo "<BR>N° du ticket : $tickets_a_traiter[$j]";
              $tickets = $tickets_a_traiter[$j];
              $tickets = trim($tickets,".");
              //echo "<BR>N° du ticket (nettoyé) : $tickets";
              
              $query_ticket = "SELECT * FROM probleme WHERE ID_PB = '$tickets';";
				      $result_ticket = mysql_query($query_ticket);
				      $num_result_ticket_count = mysql_num_rows($result_ticket);
				      $res_ticket = mysql_fetch_row($result_ticket);
				      //echo "<BR>N° du ticket extrait : $res_ticket[0]";
				      				      
				      if($num_result_ticket_count == 0)
				      {
					      //echo "<FONT COLOR = \"#000FFF\"><B>&nbsp;- ticket n'existe pas - entrée à supprimer</B></FONT>";
					      $compteur_entree_a_supprimer = $compteur_entree_a_supprimer + 1;
			          sup_ticket_categ($tickets,$res_cat[0]);
				      }
				      else
				      {
                //echo "<FONT COLOR = \"#AAA000\"><B>&nbsp;- ticket trouvé</B></FONT>";
                $compteur_entree_ok = $compteur_entree_ok + 1;
              }
              
            } 
					  
            $res_cat = mysql_fetch_row($result_cat);
				  }
        
         /*
        echo "</TD>";
        echo "<TR>
                <TD></h2>";
        */
				echo "<FONT COLOR = \"#808080\"><BR>Nombre de catégories traités : $num_result_cat_count
              <BR>Nombre d'entrée ok : $compteur_entree_ok
              <BR>Nombre d'entrée supprimées : $compteur_entree_a_supprimer</FONT></h2";
              
        echo "</TD>
            </TR>
          </TABLE>";
        //echo "</CENTER>";
				
        //Vérificataion de la table probleme pour effacer les réponses orphelines
			  //------------------------------------------------------------------------------------------------------
			  //Initialiszation des compteurs
			  $compteur_reponses_a_supprimer = 0;
			  $compteur_reponses_ok = 0;
			  $compteur_modifications = 0;
			  $nbr_tickets = 0;
			  
        echo "<TABLE width=\"50%\" align=\"center\">
              <TR>
              <TD>";
					echo "<FONT COLOR = \"#808080\"><h2>Etape 2 : Vérification des réponses orphelines...<BR></FONT>";
        /*
        echo "</TD>
            <TR>
              <TD>";
        */
        $query_rep = "SELECT * FROM probleme WHERE STATUT ='R' ORDER BY ID_PB ASC;";
				$result_rep = mysql_query($query_rep);
				if(!$result_rep)
				{
					echo "<FONT COLOR = \"#808080\"><B>problème lors de l'execution de la requète</B></FONT>";
					echo "<A HREF = \"gestion_tickets.php?tri=G&amp;indice=0\">Retour à la Gestion de ticket</A>";
					mysql_close();
					exit;
				}
				$num_result_rep_count = mysql_num_rows($result_rep);
				//echo "<BR><FONT COLOR = \"#808080\"><b>Nombre de réponses à traiter : $num_result_rep_count</b></FONT>";
				$res_rep = mysql_fetch_row($result_rep);
				
				for($i=0; $i<$num_result_rep_count; ++$i)
				  {
					  //echo "<BR><FONT COLOR = \"#808080\">Réponse <b>".$res_rep[0]." - ".$res_rep[1]." (".$res_cat[3].")&nbsp;</b></FONT>";
					  //echo "<BR>N° du ticket : $tickets_a_traiter[$j]";
            //$tickets = $reponse_a_traiter[$j];
            //$tickets = trim($tickets,".");
            //echo "<BR>N° de la réponse : $res_rep[0]";
            //echo "<BR>N° du ticket père : $res_rep[1]";
             
            $query_ticket = "SELECT * FROM probleme WHERE ID_PB = '$res_rep[1]';";
				    $result_ticket = mysql_query($query_ticket);
				    //$num_result_ticket_count = mysql_num_rows($result_ticket);
				    $res_ticket = mysql_fetch_row($result_ticket);
				    //echo "<BR>N° du ticket extrait : $res_ticket[0]";
				      				      
				    if(!$res_ticket)
				    {
					    //echo "<FONT COLOR = \"#000FFF\"><B>&nbsp;- ticket n'existe pas - réponse à supprimer</B></FONT>";
					    $compteur_reponses_a_supprimer = $compteur_reponses_a_supprimer + 1;
			        suppr_t($res_rep[0],sup_reponse);
				    }
				    else
				    {
              //echo "<FONT COLOR = \"#AAA000\"><B>&nbsp;- ticket trouvé</B></FONT>";
              $compteur_reponses_ok = $compteur_reponses_ok + 1;
            }
            
            $res_rep = mysql_fetch_row($result_rep);
				  }
        
        echo "<FONT COLOR = \"#808080\"><BR>Nombre de réponses traitées : $num_result_rep_count
              <BR>Nombre de réponses avec ticket : $compteur_reponses_ok
              <BR>Nombre de réponses orphelines supprimées : $compteur_reponses_a_supprimer</FONT></h2";
              
        echo "</TD>
            </TR>
          </TABLE>";
        //echo "</CENTER>";
        
        //vérification du nombre de tickets par entrée dans la table etablissements
        //------------------------------------------------------------------------------------
        
        echo "<TABLE width=\"50%\" align=\"center\">
              <TR>
              <TD>";
				echo "<FONT COLOR = \"#808080\"><h2>Etape 3 : Vérification du nombre de tickets par entrée dans la table \"etablissements\"...<BR></FONT>";
        
        $query_etab = "SELECT RNE, NB_PB FROM etablissements ORDER BY RNE ASC;";
				$result_etab = mysql_query($query_etab);
				if(!$result_etab)
				{
					echo "<FONT COLOR = \"#808080\"><B>problème lors de l'execution de la requète</B></FONT>";
					echo "<A HREF = \"gestion_tickets.php?tri=G&amp;indice=0\">Retour à la Gestion de ticket</A>";
					mysql_close();
					exit;
				}
				$num_result_etab_count = mysql_num_rows($result_etab);
				echo "<BR><FONT COLOR = \"#808080\"><b>Nombre d'entrées à traiter : $num_result_etab_count</b></FONT>";
				$res_etab = mysql_fetch_row($result_etab);
				$cpt = 0;
				for($i=0; $i<$num_result_etab_count; ++$i)
				  {
					  $cpt = $cpt + 1;
            //echo "*";
            //echo "<BR><FONT COLOR = \"#808080\">Réponse <b>".$res_rep[0]." - ".$res_rep[1]." (".$res_cat[3].")&nbsp;</b></FONT>";
					  //echo "<BR>N° du ticket : $tickets_a_traiter[$j]";
            //$tickets = $reponse_a_traiter[$j];
            //$tickets = trim($tickets,".");
            //echo "<BR>N° de la réponse : $res_rep[0]";
            //echo "<BR>N° du ticket père : $res_rep[1]";
             
            $query_ticket = "SELECT * FROM probleme WHERE NUM_ETABLISSEMENT = '$res_etab[0]' AND STATUT <>'R';";
				    $result_ticket = mysql_query($query_ticket);
				    $num_result_ticket_count = mysql_num_rows($result_ticket);
				    //echo "Nombre de tickets pour $res_etab[0] : $num_result_ticket_count";
				      				      
				    if($num_result_ticket_count > 0)
				    {
				      $nbr_tickets = $nbr_tickets + $num_result_ticket_count; 
					    //On compare par rapport aux nombre de pb enregistré
					    //echo "<FONT COLOR = \"#000FFF\"><B>&nbsp;Nbr de pb enregistrés : $res_etab[1]</B></FONT>";
					    if ($num_result_ticket_count <> $res_etab[1])
					    {
                //echo "il faut enregistrer le résultat trouvé";
                $compteur_modifications = $compteur_modifications + 1;
                $query_modif_etab = "UPDATE etablissements SET NB_PB = '$num_result_ticket_count'	WHERE RNE = '".$res_etab[0]."';";
						    $results_modif_etab = mysql_query($query_modif_etab);
              }
              else
				      {
                //echo "<FONT COLOR = \"#AAA000\"><B>&nbsp;On ne fait rien</B></FONT>";
              }
      		  }
				    else
				    {
              //echo "<FONT COLOR = \"#AAA000\"><B>&nbsp;On ne fait rien</B></FONT>";
            }
            $res_etab = mysql_fetch_row($result_etab);
				  }
        
        mysql_close();
        
        echo "<!--BR><FONT COLOR = \"#808080\"><b>Nombre d'entrées traitées : $cpt</b></FONT-->
              <BR><FONT COLOR = \"#808080\"><b>Nombre d'entrées modifiées : $compteur_modifications</b></FONT>
              <BR><FONT COLOR = \"#808080\"><b>Nombre de tickets en total : $nbr_tickets</b></FONT>";
              
        echo "</TD>
            </TR>
          </TABLE>";
        
        
        //------------------------------------------------------------------------------------
        
        //Affichage du nombre total d'erreur corrigées
        //------------------------------------------------------------------------------------
        
          $total = $compteur_reponses_a_supprimer+$compteur_entree_a_supprimer+$compteur_modifications;
          //echo "<BR>Total des problèmes : $total";
          
          echo "<CENTER><FONT COLOR = \"#808080\">";
          if ($total==0)
          {
            echo "<h2> VERIFICATION TERMINEE<BR>Pas de problèmes constatés<h2>";
          }
          else
          {
            if ($total==1)
            {
              echo "<h2> VERIFICATION TERMINEE<BR>1 problème corrigé<h2>";
            }
            else
            {
              echo "<h2> VERIFICATION TERMINEE<BR>".$total." problèmes corrigés<h2>";  
            }
          }
          
          echo "</FONT></CENTER>";
 		    break;
      }
		  ?>
		<!--/CENTER-->
	</BODY>
</HTML>
					
