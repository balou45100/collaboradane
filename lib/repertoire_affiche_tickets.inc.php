<?php
/*
echo "<BR>tri : $tri";
echo "<BR>sense_tri : $sense_tri";
echo "<BR>tri2 : $tri2";
echo "<BR>origine_gestion : $origine_gestion";
//echo "<BR> : $";
*/
  
echo "<BR>
<TABLE BORDER = \"0\"  BGCOLOR = \"#48D1CC\">
<CAPTION><b>Tickets enregistrés</b></CAPTION>
  <TR>
	 <TD align=\"center\">";
	   /*
     if ($sense_tri =="asc")
		 {
      echo "ID&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		 }
     else
     {
      echo "ID&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=ID&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par N° de ticket, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		 }
		 */
		 echo "ID";
     echo "
			 </TD>
       <TD align=\"center\">ST</TD>";
					echo "<TD align=\"center\">";
					  /*
            if ($sense_tri =="asc")
					  {
					  */
              echo "Créé par";
              //echo "Créé par&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par émetteur, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
					  /*
            }
            else
            {
              echo "Créé par&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=Cr&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par émetteur, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
					  }
					  */
				echo "
					</TD>
					<TD align=\"center\">
            Créé le
          </TD>
					<TD align=\"center\">
						Traité par
					</TD>
					<TD align=\"center\">
						Dern. interv.
					</TD>";
	        echo "<TD align=\"center\">
						Sujet
					</TD>
					<TD align=\"center\">
						Nb mes
					</TD>
					<TD align=\"center\">";
	         /*
           if ($sense_tri =="asc")
					 {
            echo "Priorit&eacute;&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=desc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par priorité par ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
					 }
           else
           {
            echo "Priorit&eacute;&nbsp;<A href=\"repertoire_consult_fiche.php?tri=$tri&amp;tri2=P&amp;indice=0&amp;sense_tri=asc&amp;affiche_FGMM=$affiche_FGMM&amp;affiche_tickets=N&amp;origine_gestion=$origine_gestion&amp;rechercher=$rechercher&amp;dans=$dans&amp;filtre=$filtre&amp;action=$action\" target=\"body\"  title=\"Trier par priorité par ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
					 }
					 */
            echo "Priorité";
          
        echo "
						</TD>
					<TD align=\"center\">
						Actions
					</TD>
				</TR>";
  
  //L'utilisateur à le droit de voir les tickets qu'il a envoyés ou ceux dont il est intervenant
						//echo "<BR>Je suis un utilisateur";
            //Requète pour afficher les tickets selon le filtre appliqué
						if ($sense_tri == "")
						{
						  $sense_tri="DESC";
						}
						
            /*
            switch($tri)
						{
						  case 'G' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'REP' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND MODULE = 'REP' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT <>'' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR NUM_ETABLISSEMENT <>'' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT <> 'A' AND STATUT != 'R' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  echo "<BR>dans sélecteur par defaut du tri2";
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
              }
              break;
							
							case 'SRNE' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR NUM_ETABLISSEMENT ='' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT <> 'A' AND STATUT != 'R' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT ='' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR NUM_ETABLISSEMENT ='' AND STATUT = 'M' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
              }
              break;
							
							case 'PH' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							
							  break;
              }
              break;
							
              case 'Aa' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
              }
              
              break;
							
							case 'MeAa' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
              }
              break;
							
							case 'A' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
              }
              break;
							
							case 'Me' :
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
              }
              break;
							 
              default :
              echo "<BR>dans sélecteur par defaut du tri 1";
							switch ($tri2)
							{
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
							  default :
							  echo "<BR>dans sélecteur par defaut du tri 1 et 2";
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB;";
							  break;
              }
              break;
						  }
						*/
						//echo "<BR>id_societe : $id_societe<br>";
						if($_SESSION['droit'] == "Super Administrateur" )
						{
              $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
            }
            else
            {
          	   $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
						}
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
						//echo $num_results;
						
            /*
            ///////////////////////////////////
						//Partie sur la gestion des pages//
						///////////////////////////////////
						$nombre_de_page = number_format($num_results/$nb_par_page,1);
						
						echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT>";
            If ($indice == 0)
						{
              echo "<FONT COLOR = \"#000000\"><B><big>1</big>&nbsp;</B></FONT>";
						}
            else
            {
              echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						}
						
						//echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
                echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=".$nb."&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
              }
							//echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=".$nb."&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
						*/	
						
						////////////////////////////////////////
						
						//Traitement de chaque ligne
						for($i = 0; $i < $nb_par_page; ++$i)
						{
							$res = mysql_fetch_row($results);
							
              if($res[11] != "R")
							{
								$query_count = "SELECT * FROM probleme WHERE ID_PB_PERE = ".$res[0].";";
								$results_count = mysql_query($query_count);
								if(!$results_count)
								{
									mysql_close();
									exit;
								}
								
								switch ($res[13])
                {
									case "2":
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "1";
									$priorite_non_selection_ref_2 = "3";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									switch ($res[11])
									{
                    case "M":
                    $fond = "#B3CEEF";
                    break;
                    
                    case "N":
                    $fond = "#A4EFCA";
                    break;
                    
                    case "A":
                    $fond = "#FF9FA3";
                    break;
                  }
									break;

									case "1":
									$priorite_selection = "Haute";
									$priorite_non_selection_ref_1 = "2";
									$priorite_non_selection_ref_2 = "3";
									$priorite_non_selection_nom_1 = "Normal";
									$priorite_non_selection_nom_2 = "Basse";
									$fond = "#ff0000";
									break;

									case "3":
									$priorite_selection = "Basse";
									$priorite_non_selection_ref_1 = "1";
									$priorite_non_selection_ref_2 = "2";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Normal";
									switch ($res[11])
									{
                    case "M":
                    $fond = "#B3CEEF";
                    break;
                    
                    case "N":
                    $fond = "#A4EFCA";
                    break;
                    
                    case "A":
                    $fond = "#FF9FA3";
                    break;
                  }
									break;

									default:
									$res[13] = "2";
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "1";
									$priorite_non_selection_ref_2 = "3";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									switch ($res[11])
									{
                    case "M":
                    $fond = "#B3CEEF";
                    break;
                    
                    case "N":
                    $fond = "#A4EFCA";
                    break;
                    
                    case "A":
                    $fond = "#FF9FA3";
                    break;
                  }
									break;
								}
								
								switch ($res[14])
                {
		
									case "N":
									$couleur_fond = "#ffffff";
									break;

									case "C":
									$couleur_fond = "#00cc33";
                  break;

									case "T":
									$couleur_fond = "#ff0000";
									break;

									case "A":
									$couleur_fond = "#ffff66";
									break;

                  case "F":
									$couleur_fond = "#FF9FA3";
									break;

								}
								
								//Retourne le nombre de ligne rendu par la requète
								$num_results_count = mysql_num_rows($results_count);
							  
								echo "<TR class = \"".statut($res[11])."\">";
								  echo "<TD align=\"center\">";
								    echo $res[0];
								  echo "</TD>";
                  echo "<TD BGCOLOR = $couleur_fond align=\"center\">";
								    echo " ";
								  echo "</TD>";
								  echo "<TD>";
								  echo $res[3];
								  echo "</TD>";
								  echo "<TD>";
									//Transformation de la date de création extraite pour l'affichage
									$date_de_creation_a_afficher = strtotime($res['27']);
									$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
								    //echo $res[7];
									echo $date_de_creation_a_afficher; //créé le
								  echo "</TD>";
								  echo "<TD>";
								    echo $res[15];
								  echo "</TD>";
								  echo "<TD align=\"center\">";
								    echo $res[23];
								  echo "</TD>";
                  /*
                  if ($tri <> "SRNE")
					        {
                    echo "<TD>";
                    echo $res[4];
								    echo "</TD>";
								  }
								  */
								  echo "<TD>";
								    echo $res[5];
								  echo "</TD>";
								  
                  echo "<TD align=\"center\">";
								    echo $num_results_count;
								  echo "</TD>";
								  echo "<TD BGCOLOR = $fond align=\"center\">";
								    echo $priorite_selection;
								  echo "</TD>";
								  echo "<TD BGCOLOR = \"#48D1CC\">";
								    echo "<A HREF = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border=\"0\"></A>";
								    //echo "&nbsp;<A HREF = \"affiche_categories.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les catégories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\" width=\"25px\" height=\"32px\"></A>";
						        
                    if (($_SESSION['nom'] == $res[3]) OR ($_SESSION['droit'] == "Super Administrateur"))
								    {
									     if($res[11] != "A")
									     {
										    //echo "<A HREF = \"archiver_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\" border=\"0\"></A>";	
										    echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\" border=\"0\"></A>";
										    echo "<A HREF = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"22px\" border=\"0\"></A>";
                       }
                        //echo "<A HREF = \"delete_ticket.php?tri=$tri&amp;idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" border=\"0\" height=\"24px\" width=\"22px\"></A>";
                    }
                    
								  echo "</TD>";
								echo "</TR>";
							}
						}
					echo "</TABLE>";
					//Fermeture de la connexion à la BDD
					mysql_close();
?>
