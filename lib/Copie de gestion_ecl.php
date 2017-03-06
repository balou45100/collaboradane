<?php
//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<!"Ce fichier affiche la liste de tous les établissements avec leurs informations et pour chaque établissement"
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
	<!"Pour protéger les couleur des liens des boutons"
	"Choix de la couleur blanche, car sinon il apparait un carré de couleur moche autour des images"
	"Correspondant à la suppression et à la modification">
	<body link="#48D1CC" Vlink="#48D1CC">
		<CENTER>
			<?php
				
				//Pour filtrer les établissements
				$dep = $_GET['dep'];
				$filtre = $_GET['filtre'];
				$indice = $_GET['indice'];
				$secteur = $_GET['secteur'];
        $rechercher = $_GET['rechercher'];
        $dans = $_GET['dans'];
        $origine = $_GET['origine'];
        $tbi = $_GET['tbi'];
        $entete = $_GET['entete']; //pour vérifier si on arrive de l'entete
        
        echo "<br>tbi : $tbi - dep : $dep - type : $filtre";
        
        if (isset($indice))
				{
				  $_SESSION['indice'] = $indice;
        }
        else
        {
          $indice = $_SESSION['indice'];
        }
       
        if (isset($rechercher))
				{
				  $_SESSION['rechercher'] = $rechercher;
        }
        else
        {
          $rechercher = $_SESSION['rechercher'];
        }
        
        if (isset($dans))
				{
				  $_SESSION['dans'] = $dans;
        }
        else
        {
          $dans = $_SESSION['dans'];
        }
        /*
        if ($dans == "")
        {
          $dans = "T";
        }
        */
        
        if (isset($tbi))
				{
				  $_SESSION['tbi'] = $tbi;
        }
        else
        {
          if (!ISSET($entete))
          {
            $tbi = $_SESSION['tbi'];
          }
          else
          {
            $_SESSION['tbi'] = "";
          }
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
        
          if (isset($secteur))
				  {
				    $_SESSION['secteur_en_cours'] = $secteur;
          }
          else
          {
            $secteur = $_SESSION['secteur_en_cours'];
          }
        
          if (isset($filtre))
				  {
				    $_SESSION['filtre_en_cours'] = $filtre;
          }
          else
          {
            $filtre = $_SESSION['filtre_en_cours'];
          }
        
          $dep_en_cours = $_SESSION['departement_en_cours'];
          $sec_en_cours = $_SESSION['secteur_en_cours'];
          $filtre_en_cours = $_SESSION['filtre_en_cours'];
				
        /*
        if (!isset($filtre))
			  {
          $filtre = "T";
        }	
			  */
        //echo "<BR>dep : $dep - departement_en_cours : $dep_en_cours - filtre : $filtre - secteur_en_cours = $sec_en_cours - rechercher : $rechercher";
				
				//Test du champ récupéré
				/*
				if(!isset($dep) || $dep == "" || !isset($indice) || $indice == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Erreur de récupération des données</B></FONT>";
					echo "<BR><A HREF = \"body.php\" target = \"body\" class = \"bouton\">Retour à l'accueil</A>";
					exit;
				}
				*/
				//Inclusion des fichiers nécessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
				
				$nb_par_page = 10;
				
				
      if($_SESSION['droit'] == "Super Administrateur")
			{	
			   echo "<A HREF = \"form_etab.php\" class = \"bouton\">Insérer un nouvel établissement</A><BR><BR>";
			}
			//echo "<FONT COLOR = \"#00BFFF\">Pour tout envoi de message électronique, l'adresse de la personne connectée est mise en copie par defaut</FONT>
			
				switch ($dep)
				{
          case 'T' :
          $rne_a_inclure = "%";
          $affiche_departement = "de l'académie";
          break;
          
          case '18' :
          $rne_a_inclure = "018";
          $affiche_departement = "du département du Cher";
          break;
          
          case '28' :
          $rne_a_inclure = "028";
          $affiche_departement = "du département de l'Eure-et-Loire";
          break;
          
          case '36' :
          $rne_a_inclure = "036";
          $affiche_departement = "du département de l'Indre";
          break;
          
          case '37' :
          $rne_a_inclure = "037";
          $affiche_departement = "du département de l'Indre-et-Loire";
          break;
          
          case '41' :
          $rne_a_inclure = "041";
          $affiche_departement = "du département du Loir-et-Cher";
          break;
          
          case '45' :
          $rne_a_inclure = "045";
          $affiche_departement = "du département du Loiret";
          break;
        }   
       
       //Affectation du joker "%" s'il faut afficher tous les types de la table 
        if ($filtre_en_cours == 'T')
        {
          $type_etab = "%";
        }
        else
        {
          $type_etab = $filtre_en_cours;
        }        
       
       //Affectation du joker "%" s'il faut afficher tous les secteurs de la table 
        if ($secteur == 'T')
        {
          $secteur_pour_requete = "%";
        }
        else
        {
          $secteur_pour_requete = $secteur;
        }
       
       //La requete générale à exécuter
       //echo "<BR>secteur : $secteur - secteur_pour_requete : $secteur_pour_requete - rne_a_inclure : $rne_a_inclure - type_etab : $type_etab - à rechercher : $rechercher";
       
       if ($rechercher <>"")
       {
          switch ($dans)
          {
            case "T" :
              $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND NOM LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND VILLE LIKE '%$rechercher%' OR PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' AND MAIL LIKE '%$rechercher%' ORDER BY RNE ASC;";
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
          if ($tbi == "O")
          {
            echo "<br>tbi : $tbi";
            $query = "SELECT * FROM documents WHERE module = 'TBI' ORDER BY id_doc ASC;";
          }
          else
          {
            $query = "SELECT * FROM etablissements WHERE PUBPRI LIKE '".$secteur_pour_requete."' AND RNE LIKE '".$rne_a_inclure."%' AND TYPE_ETAB_GEN LIKE '".$type_etab."' ORDER BY RNE ASC;";
          }
          
  		 }
       $results = mysql_query($query);
			 if(!$results)
			 {
			   echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
			   echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
			   mysql_close();
			   exit;
			 }
					
			//echo "<h3>".$liste_a_afficher." "." ".$secteur_a_afficher." ".$affiche_departement."</h3>";
			//Retourne le nombre de ligne rendu par la requète
			
      
      $num_results = mysql_num_rows($results);
			
			if ($num_results >0)
      {	
          //Affichage de l'entête du tableau
          
          echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
          
          echo "<BR>
			<TABLE BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
				<TR>
					<TD align=\"center\">
						RNE
					</TD>
					<TD align=\"center\">
						TYPE 
					</TD>
					<TD align=\"center\">
						DENOMMINATION 
					</TD>
					<TD align=\"center\">
						VILLE 
					</TD>
					<TD align=\"center\">
						T&Eacute;L 
					</TD align=\"center\">
					<!--TD align=\"center\">
						CIRC.
					</TD-->
					<TD align=\"center\">
						M&Eacute;L
						<br><small><small>Cliquer sur l'adresse pour envoyer un message<br>(l'adresse de la personne connectée est mise en copie par defaut)</small></small>
					</TD>
					<TD align=\"center\">
						TICKETS
					</TD>
          <TD align=\"center\">
            ACTIONS
          </TD>";
          
          //Requète pour afficher les établissements selon le filtre appliqué
						
					///////////////////////////////////
					//Partie sur la gestion des pages//
					///////////////////////////////////
					$nb_page = number_format($num_results/$nb_par_page,1);
					$par_navig = "0";
					
					echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT>";
            If ($indice == 0)
						{
              echo "<FONT COLOR = \"#000000\"><B><big>1</big>&nbsp;</B></FONT>";
						}
            else
            {
              echo "<A HREF = \"gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						}
          
          //echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
					for($j = 1; $j<$nb_page; ++$j)
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
                echo "<A HREF = \"gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=".$nb."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
              }
							//echo "<A HREF = \"gestion_ecl.php?dep=".$dep."&amp;filtre=".$filtre."&amp;indice=".$nb."&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
	        }
					
					$j = 0;
					while($j<$indice)
					{
						$res = mysql_fetch_row($results);
						++$j;
					}
					
					/////////////////////////
					//Fin gestion des pages//
					/////////////////////////
					
					//Traitement de chaque ligne
					$res = mysql_fetch_row($results);
					for ($i = 0; $i < $nb_par_page; ++$i)
					{
						//Requète pour voir le nombre de problème posté pour un établissement
						$query_nb_pb = "SELECT COUNT(*) FROM probleme WHERE  NUM_ETABLISSEMENT = '".$res[0]."' AND STATUT != 'R';";
						$results_nb_pb = mysql_query($query_nb_pb);
						if(!$results_nb_pb)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
							echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$nb_pb = mysql_fetch_row($results_nb_pb);
												
						//Requète pour selectionner toutes les formules de politesses
						$query_politesse = "SELECT * FROM politesse WHERE Id_politesse = '".$res[10]."';";
						$results_politesse = mysql_query($query_politesse);
						if(!$results_politesse)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
							echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$politesse = mysql_fetch_row($results_politesse);
						if ($res[0] <>"")
						{
              echo "<TR class = \"".dep(substr($res[6],0,2))."\">";
						echo "<TD>";
						echo $res[0];
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo strtoupper(str_replace("*", " ",$res[1]));
						echo "&nbsp;".strtoupper($res[2]);
						echo "</TD>";
						echo "<TD>";
						echo strtoupper(str_replace("*", " ",$res[3]));
						echo "</TD>";
						echo "<TD>";
						//echo strtoupper(str_replace("*", " ",$res[4]));
						//echo "<br>".str_replace("*", " ",$res[6]);
						echo "&nbsp;".strtoupper(str_replace("*", " ",$res[5]));
						echo "</TD>";
						echo "<TD>";
						echo $res[7];
						echo "</TD>";
						echo "<TD>";
						if($res[8] != "")
						{
							//Lien pour envoyer un mail
							echo "<A HREF = \"mailto:".str_replace(" ", "*",$res[8])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\"><FONT COLOR=\"#696969\">".$res[8]."</FONT></A>";
						}
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo $nb_pb[0];
						echo "</TD>";
						echo "<TD BGCOLOR = \"#48D1CC\">";
						echo "<A HREF = \"ecl_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_personnes_ressources=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></A>";
            if ($nb_pb[0]==0)
						{
              echo "<A HREF = \"verif_ticket.php?etab=".$res[0]."&amp;origine=gest_ecl&amp;rechercher=$rechercher&amp;indice=$indice\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></A>";
						}
						if($_SESSION['droit'] == "Super Administrateur")
						{
               echo "<A HREF = \"delete_etab.php?rne=".$res[0]."&amp;denomination=".str_replace(" ", "*",$res[3])."&amp;adresse=".str_replace(" ", "*",$res[4])."&amp;CP=".str_replace(" ", "*",$res[6])."&amp;ville=".str_replace(" ", "*",$res[5])."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></A>";	
						   echo "<A HREF = \"modif_etab.php?rne=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\"></A>";
						}
						echo "</TD>";
						echo "</TR>";
						
            }
						$res = mysql_fetch_row($results);
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
			}
			else
			{
        echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
      }
   
    }
        
        
      	?>
			</TABLE>
		</CENTER>
	</body>
</html>
