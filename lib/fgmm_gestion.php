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
				//Récupération des variables pour faire fonctionner ce script
				$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
        $filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
				$tri = $_GET['tri']; //Tri sur quelle colonne ?
        $sense_tri = $_GET['sense_tri']; // ascendant ou descendant
        $indice = $_GET['indice']; //à partir de quelle page
        $rechercher = $_GET['rechercher']; //détail à rechercher
        $dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
        $lettre = $_GET['lettre'];
        
        //Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où
        if(!isset($origine_gestion) || $origine_gestion == "")
				{
					$origine_gestion = $_SESSION['origine_gestion'];
				}
				else
				{
          $_SESSION['origine_gestion'] = $origine_gestion;
        }
        
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
        
        if(!isset($indice) || $indice == "")
				{
					$indice = $_SESSION['indice'];
				}
				else
				{
          $_SESSION['indice'] = $indice;
        }
        
        if(!isset($rechercher) || $rechercher == "")
				{
					$rechercher = $_SESSION['rechercher'];
        }
				else
				{
          $_SESSION['rechercher'] = $rechercher;
				}
        
        if(!isset($dans) || $dans == "")
				{
					$dans = $_SESSION['dans'];
        }
				else
				{
          $_SESSION['dans'] = $dans;
				}
        
        if(!isset($lettre) || $lettre == "")
				{
					$lettre = $_SESSION['lettre'];
        }
				else
				{
          $_SESSION['lettre'] = $lettre;
				}
				
				$_SESSION['origine'] = "repertoire_gestion";
				
        //Inclusion des fichiers nécessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
				
				$nb_par_page = 10; //Fixe le nombre de ligne qu'il faut afficher à l'écran
				/*
				//Affectation des variables sessions pour contrôle et affichage
        $ses_origine_gestion = $_SESSION['origine_gestion'];
				$ses_indice = $_SESSION['indice'];
				$ses_filtre = $_SESSION['filtre'];
				$ses_rechercher = $_SESSION['rechercher'];
				$ses_dans = $_SESSION['dans'];
				$ses_tri = $_SESSION['tri'];
				$ses_sense_tri = $_SESSION['sense_tri'];
				$ses_lettre = $_SESSION['lettre'];
        echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
        echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - à rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
        */
        switch ($origine_gestion)
        {
          case "filtre" :
            switch ($filtre)
            {
              case "T" :
                switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
                  break;
                }
                
              break;
            
              case "AT" :
                switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe ASC;";
                  break;
                }
              break;
            
              case "FGMM" :
                switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY societe ASC;";
                  break;
                }
              break;
            
              case "FGMM_AT" :
                switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1'  OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' AND a_traiter = '1' ORDER BY societe ASC;";
                  break;
                }
              break;
            
              }
            break;
            
          case "recherche" :
            if ($rechercher <>"")
            {
              switch ($dans)
              {
                case "T" :
                  switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY societe ASC;";
                  break;
                }
                break;
            
                case "S" :
                  switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
                  break;
                }
                break;
            
                case "V" :
                switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
                  break;
                }
                break;
            
                case "M" :
                  switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
                  break;
                }
                break;
              }
            }
            else
            {
              switch ($tri)
                {
                  case "ID" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
                  break;
                  
                  case "SO" :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
                  break;
                  
                  default :
                    $query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
                  break;
                }
            } 
          break;
          
          case "alpha" :
            switch ($tri)
            {
              case "ID" :
                $lettre = $lettre."%";
                $query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
              break;
                
              case "SO" :
                $lettre = $lettre."%";
                $query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
              break;
                
              default :
                $lettre = $lettre."%";
                $query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
              break;
            }
          break;
         }
         //Affichage de la barre de recherche alphabétique 
         AfficheRechercheAlphabet("SO","repertoire_gestion");
      
        echo "<BR><A HREF = \"repertoire_ajout_fiche.php?action=ajout_fiche\" class = \"bouton\">Insérer une nouvelle fiche</A>";
			  
       $results = mysql_query($query);
       
			 if(!$results)
			 {
			   echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
			   echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
			   mysql_close();
			   exit;
			 }
					
			//Retourne le nombre de ligne rendu par la requète
			$num_results = mysql_num_rows($results);
			if ($num_results >0)
      {	
          //Affichage de l'entête du tableau
          
          echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
          
          echo "
			<TABLE BORDER=\"0\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
				<TR>
					<TD align=\"center\">";
					if ($sense_tri =="asc")
		      {
            echo "NO<A href=\"repertoire_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		      }
          else
          {
            echo "NO<A href=\"repertoire_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		      }
					echo "</TD>
					<TD align=\"center\">";
					if ($sense_tri =="asc")
		      {
            echo "INTITUL&Eacute;<A href=\"repertoire_gestion.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		      }
          else
          {
            echo "INTITUL&Eacute;<A href=\"repertoire_gestion.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		      }
						
					echo "</TD>
					<TD align=\"center\">
						ADRESSE
					</TD>
					<TD align=\"center\">
						T&Eacute;L
					</TD>
					<TD align=\"center\">
						SITE WEB 
					</TD>
					<TD align=\"center\">
						AT
					</TD>
					<TD align=\"center\">
						AF
					</TD>
					<TD align=\"center\">
						UR
					</TD>
					<TD align=\"center\">
						PG
					</TD>
          <TD align=\"center\">
            ACTIONS
          </TD>";
          
          //Requète pour afficher les établissements selon le filtre appliqué
						
					///////////////////////////////////
					//Partie sur la gestion des pages//
					///////////////////////////////////
					$nombre_de_page = number_format($num_results/$nb_par_page,1);
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
              echo "<A HREF = \"repertoire_gestion.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						}
            //echo "<BR>indice : $indice<br>";
            for($j = 1; $j<$nombre_de_page; ++$j)
						{
							$nb = $j * $nb_par_page;
							$page = $j + 1;
							if ($page * $nb_par_page == $indice + $nb_par_page)
							{
                echo "<FONT COLOR = \"#000000\"><B><big>".$page."&nbsp;</big></B></FONT>";
              }
              else
              {
                echo "<A HREF = \"repertoire_gestion.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
						echo $res[2]."<br>$res[3]"." ".$res[4];
						echo "</TD>";
						echo "<TD align=\"center\">";
						echo $res[5];
						echo "</TD>";
						echo "<TD>";
						echo $res[7];
						echo "</TD>";
						echo "<TD align=\"center\">";
						if ($res[10] == "1")
						{
              echo "X";
						}
            else
						{
              //echo "<input type=\"checkbox\" name=\"a_traiter\" value=\"Non\">";
						}
						echo "</TD>";
						echo "<TD align=\"center\">";
						if ($res[13] <> "")
						{
              echo "X";
						}
						else
						{
              //echo "<input type=\"checkbox\" name=\"a_faire\" value=\"Non\">";
						}
						echo "</TD>";
						echo "<TD align=\"center\">";
						if ($res[14] == "1")
						{
              echo "X";
						}
						else
						{
              //echo "&nbsp;";
						}
						echo "</TD>";
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
						
						//Les actions
						echo "<TD BGCOLOR = \"#48D1CC\">";
						echo "<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\"></A>";
            echo "<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier ce ticket\"></A>";
						echo "<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></A>";
						  
						if (($_SESSION['droit'] == "Super Administrateur") OR ($res[21] == $_SESSION['nom']))
						{
               //echo "<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></A>";	
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
 	?>
			</TABLE>
		</CENTER>
	</body>
</html>
