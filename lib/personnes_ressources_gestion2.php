<?php
	//Mise en place de la durÃ©e de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
?>

<!DOCTYPE HTML>
  
<!"Ce fichier affiche la liste de tous les Ã©tablissements avec leurs informations et pour chaque Ã©tablissement"
"Un bouton pour la suppression et la modification">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<!"Pour protÃ©ger les couleur des liens des boutons"
	"Choix de la couleur blanche, car sinon il apparait un carrÃ© de couleur moche autour des images"
	"Correspondant Ã  la suppression et Ã  la modification">
	<body link="#48D1CC" Vlink="#48D1CC">
		<CENTER>
			<?php
					//Pour filtrer les Ã©tablissements
				$dep = $_GET['dep'];
				$intitule_fonction = $_GET['intitule_fonction'];
				$indice = $_GET['indice'];
				$secteur = $_GET['secteur'];
        $rechercher = $_GET['rechercher'];
        $dans = $_GET['dans'];
        $origine = $_GET['origine'];
        //Initialisation des variables session pour pouvoir revenir dans cette page de n'importe oÃ¹
        if ($dans == "")
        {
          $dans = "T";
        }
        
        if ($origine == "cadre_gestion")
        {
          echo "<h2>Utiliser les filtres du bandeau du haut pour afficher des Ecoles ou / et des EPLE</h2>";
        } 
        else
        {
          if (isset($dep))
				  {
				    $_SESSION['departement_en_cours'] = $dep;
          }
          else
          {
            $dep = $_SESSION['departement_en_cours'];
          }
        
          /*
          if (isset($secteur))
				  {
				    $_SESSION['secteur_en_cours'] = $secteur;
          }
          else
          {
            $secteur = $_SESSION['secteur_en_cours'];
          }
          */
          
          if (isset($intitule_fonction))
				  {
				    $_SESSION['intitule_fonction_en_cours'] = $intitule_fonction;
          }
          else
          {
            $intitule_fonction = $_SESSION['intitule_fonction_en_cours'];
          }
        
          $dep_en_cours = $_SESSION['departement_en_cours'];
          //$sec_en_cours = $_SESSION['secteur_en_cours'];
          $intitule_fonction_en_cours = $_SESSION['intitule_fonction_en_cours'];
          
          if(!isset($lettre) || $lettre == "")
				  {
					 $lettre = $_SESSION['lettre'];
          }
				  else
				  {
            $_SESSION['lettre'] = $lettre;
				  }
				
				$_SESSION['origine'] = "repertoire_gestion";
				
        //Inclusion des fichiers nÃ©cessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
				
				$nb_par_page = 10; //Fixe le nombre de ligne qu'il faut afficher Ã  l'Ã©cran
				/*
				//Affectation des variables sessions pour contrÃ´le et affichage
        $ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_filtre = $_SESSION['filtre'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
        echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - Ã  rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
        echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - Ã  rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
        */
        switch ($dep)
				{
          case 'T' :
          $rne_a_inclure = "%";
          $affiche_departement = "de l'acadÃ©mie";
          break;
          
          case '18' :
          $rne_a_inclure = "018";
          $affiche_departement = "du dÃ©partement du Cher";
          break;
          
          case '28' :
          $rne_a_inclure = "028";
          $affiche_departement = "du dÃ©partement de l'Eure-et-Loire";
          break;
          
          case '36' :
          $rne_a_inclure = "036";
          $affiche_departement = "du dÃ©partement de l'Indre";
          break;
          
          case '37' :
          $rne_a_inclure = "037";
          $affiche_departement = "du dÃ©partement de l'Indre-et-Loire";
          break;
          
          case '41' :
          $rne_a_inclure = "041";
          $affiche_departement = "du dÃ©partement du Loir-et-Cher";
          break;
          
          case '45' :
          $rne_a_inclure = "045";
          $affiche_departement = "du dÃ©partement du Loiret";
          break;
        }   
       
       //Affectation du joker "%" s'il faut afficher tous les types de la table 
        if ($intitule_fonction_en_cours == 'T')
        {
          $intitule_pour_requete = "%";
        }
        else
        {
          $intitule_pour_requete = $intitule_fonction_en_cours;
        }        
       
       //Affectation du joker "%" s'il faut afficher tous les secteurs de la table 
        /*
        if ($secteur == 'T')
        {
          $secteur_pour_requete = "%";
        }
        else
        {
          $secteur_pour_requete = $secteur;
        }
       */
       //La requete gÃ©nÃ©rale Ã  exÃ©cuter
       //echo "<BR>secteur : $secteur - secteur_pour_requete : $secteur_pour_requete - rne_a_inclure : $rne_a_inclure - type_etab : $type_etab - Ã  rechercher : $rechercher";
       
       if ($rechercher <>"")
       {
          switch ($dans)
          {
            case "T" :
              $query = "SELECT * FROM personnes_ressources, fonction_des_personnes_ressources WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND MAIL LIKE '%$rechercher%' ORDER BY RNE ASC;";
            break;
            
            case "N" :
              $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' ORDER BY RNE ASC;";
            break;
            
            case "V" :
              if (($rechercher == "tours") OR ($rechercher == "orleans"))
              {
                $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%'ORDER BY RNE ASC;";
              }
              else
              {
                $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%'ORDER BY RNE ASC;";
              }
            break;
            
            case "M" :
              $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND MAIL LIKE '%$rechercher%' ORDER BY RNE ASC;";
            break;
            
            case "RNE" :
              $query = "SELECT * FROM etablissements WHERE RNE LIKE '".$rechercher."%';";
            break;
          }
       }
       else
       {
          $query = "SELECT * FROM personnes_ressources, fonction_des_personnes_ressources WHERE personnes_ressources_fonctions.intitule_fonction LIKE '".$intitule_pour_requete."' ORDER BY nom, prenom ASC;";
  		 }
       $results = mysql_query($query);
			 if(!$results)
			 {
			   echo "<b>Erreur de connexion Ã  la base de donn&eacute;es</b>";
			   echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour Ã  l'accueil</A>";
			   mysql_close();
			   exit;
			 }
					
			//echo "<h3>".$liste_a_afficher." "." ".$secteur_a_afficher." ".$affiche_departement."</h3>";
			//Retourne le nombre de ligne rendu par la requÃ¨te
			$num_results = mysql_num_rows($results);
			       
			 if(!$results)
			 {
			   echo "<b>Erreur de connexion Ã  la base de donn&eacute;es</b>";
			   echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour Ã  l'accueil</A>";
			   mysql_close();
			   exit;
			 }
					
			//Retourne le nombre de ligne rendu par la requÃ¨te
			$num_results = mysql_num_rows($results);
			if ($num_results >0)
      {	
          //Affichage de l'entÃªte du tableau
          
          echo "<h2>Nombre d'enregistrements sÃ©lectionnÃ©s : $num_results</h2>";
          
          echo "
			<TABLE BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
				<TR>
					<TD align=\"center\">";
					if ($sense_tri =="asc")
		      {
            echo "ID<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par NÂ° de sociÃ©tÃ©, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		      }
          else
          {
            echo "ID<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par NÂ° de sociÃ©tÃ©, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		      }
					echo "</TD>
					<TD align=\"center\">";
					if ($sense_tri =="asc")
		      {
            echo "CIVIL<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par sociÃ©tÃ©, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		      }
          else
          {
            echo "CIVIL<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par sociÃ©tÃ©, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		      }
						
					echo "</TD>
					<TD align=\"center\">
						NOM
					</TD>
					<TD align=\"center\">
						PRENOM
					</TD>
					<TD align=\"center\">
						CODETAB
					</TD>
					<TD align=\"center\">
						DISCIPLINE
					</TD>
					<TD align=\"center\">
						POSTE
					</TD>
					<TD align=\"center\">
						MEL
					</TD>
					<!--TD align=\"center\">
						PG
					</TD>
					<TD align=\"center\">
						&nbsp;
					</TD-->
          <TD align=\"center\">
            ACTIONS
          </TD>";
          
          //RequÃ¨te pour afficher les personnes ressources selon le filtre appliquÃ©
						
					///////////////////////////////////
					//Partie sur la gestion des pages//
					///////////////////////////////////
					$nombre_de_page = number_format($num_results/$nb_par_page,1);
					$par_navig = "0";
					/*
          echo "<br>Nombre de pages : $nombre_de_page";
          echo "<br>Nb_par_page : $nb_par_page<br>";
          */	
						echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT>";
            If ($indice == 0)
						{
              echo "<FONT COLOR = \"#000000\"><B><big>1</big>&nbsp;</B></FONT>";
						}
            else
            {
              echo "<A HREF = \"personnes_ressources_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						}
            //echo "<BR>indice : $indice<br>";
            for($j = 1; $j<$nombre_de_page; ++$j)
						{
							$nb = $j * $nb_par_page;
							$page = $j + 1;
							$par_navig++;
							if($par_navig=="41")
						  {
							 echo "<BR>";
							 $par_navig=0;
              }
							if ($page * $nb_par_page == $indice + $nb_par_page)
							{
                echo "<FONT COLOR = \"#000000\"><B><big>".$page."&nbsp;</big></B></FONT>";
              }
              else
              {
                echo "<A HREF = \"personnes_ressources_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
              }
							
						}
						
						$j = 0;
						while($j<$indice) //on se potionne sur la bonne page suivant la valeur de l'index
						{
						  $res = mysql_fetch_row($results);
							++$j;
						}
					
					/////////////////////////
					//Fin gestion des pages//
					/////////////////////////
					
					//Traitement de chaque ligne
					$res = mysql_fetch_row($results);
					if ($nombre_de_page)
					for ($i = 0; $i < $nb_par_page; ++$i)
					{
					  if ($res[0] <>"")
					  {
              echo "<TR class = \"new\">";
						echo "<TD align = \"center\">";
						echo $res[0];
						echo "</TD>";
						echo "<TD>";
						echo $res[1];
						echo "</TD>";
						echo "<TD>";
						echo $res[2];
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo $res[3];
						echo "</TD>";
						echo "<TD>";
						echo "$res[4]";
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo "$res[6]";
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo "$res[8]";
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo "<a href=\"$res[9]\" target=\"_blank\">$res[9]</a>";
						echo "</TD>";
/*
						echo "<TD align=\"center\">";
						if ($res[20] == "1")
						{
              echo "X";
						}
						else
						{
              //echo "&nbsp;";
						}
						echo "</TD>";
						if ($res[22] == "privÃ©")
						{
              echo "<td><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"privÃ©\"></td>";
            }
            else
            {
              echo "<td>&nbsp;</TD>";
						}
*/
						//Les actions
						echo "<TD BGCOLOR = \"#48D1CC\">";
						echo "<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></A>";
            echo "<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\"></A>";
						echo "<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></A>";
						  
						if (($_SESSION['droit'] == "Super Administrateur") OR ($res[21] == $_SESSION['nom']))
						{
               echo "<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></A>";	
						}
						echo "</TD>";
						echo "</TR>";
            }
						$res = mysql_fetch_row($results);
					}
					//Fermeture de la connexion Ã  la BDD
					mysql_close();
			}
			else
			{
        echo "<h2> Recherche infructueuse, modifez les paramÃ¨tres&nbsp;!</h2>";
      }
    }
 	?>
			</TABLE>
		</CENTER>
	</body>
</html>
