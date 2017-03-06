<?php
						//Requète pour afficher les tickets selon le filtre appliqué
						if ($sense_tri == "")
						{
						  $sense_tri="DESC";
						}
						
              switch($tri)
						  {
							 case 'G' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
                
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
												   
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
							 case 'OTA' :
							
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY DATE_DERNIERE_INTEVENTION_POUR_TRI $sense_tri;";
							  break;

                case 'TP' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY TRAITE_PAR $sense_tri;";
							  break;

							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `CONTACT_TYPE` = 'OTA' ORDER BY ID_PB DESC;";
							  break;
               }
               break;

               case 'NOUV' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='N' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
               case 'TRAITE' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='C' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
               case 'TRANS' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Pour tri
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='T' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
						   case 'ATTTENTE' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : // Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : // Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT ='A' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
               case 'PH' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : // Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : // Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = '1' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
							
							 case 'REP' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : // Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
						
						   case 'Aa' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
							
							 case 'MeAa' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R' AND STATUT_TRAITEMENT = 'F' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
							
               case 'A' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
							
							 case 'Me' :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
							  break;
               }
               break;
							
               default :
							 switch ($tri2)
							 {
                case 'ID' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
							  break;
							
                case 'Cr' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
							  break;
							
                case 'RNE' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
							  break;
							
							  case 'P' :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
							  break;
							   
                case 'DI' : //Dernière intervention
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
							  break;
							
                case 'TP' : //Traité par
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
							  break;
							
							  default :
							  $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE,ID_PB DESC;";
							  break;
               }
               break;
						  }
/*
						
						$results = mysql_query($query);
						
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
							echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						
						//Retourne le nombre de ligne rendu par la requète
						$num_results = mysql_num_rows($results);
						//echo "<br>nbr d'enregistrements : $num_results";
						///////////////////////////////////
						//Partie sur la gestion des pages//
						///////////////////////////////////
						$nombre_de_page = number_format($num_results/$nb_par_page,1);						
						
						echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_ticket.php?tri=".$tri."&amp;tri2=".$tri2."&amp;indice=0&amp;sense_tri=$sense_tri\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						for($j = 1; $j<$nombre_de_page; ++$j)
						{
							$nb = $j * $nb_par_page;
							$page = $j + 1;
							echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;sense_tri=$sense_tri&amp;tri2=".$tri2."&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
						for($i = 0; $i < $nb_par_page; ++$i)
						{
							if($i > $num_results)
							{
								mysql_close();
								exit;
							}
						
							$res = mysql_fetch_row($results);
							if($res[11] != "R")
							{
								$query_count = "SELECT * FROM probleme WHERE ID_PB_PERE = ".$res[0].";";
								@$results_count = mysql_query($query_count);
								if(!$results_count)
								{
									mysql_close();
									exit;
								}
								switch ($res[13]) {
		
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
                  }break;

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
								
								switch ($res[14]) {
		
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
								//echo "<br>champ 1 : $res[0]";
								echo "<TR class = \"".statut($res[11])."\">";
								echo "<TD align=\"center\">";
								echo $res[0];
								echo "</TD>";
                echo "<TD BGCOLOR = $couleur_fond align=\"center\">";
								echo " ";
								echo "</TD>";
								if ($tri <> "MeAa" AND $tri <> "Me")
					      {
								echo "<TD>";
								echo $res[3];
								echo "</TD>";
								}
								echo "<TD>";
								echo $res[7]; 
								echo "</TD>";
								echo "<TD>";
								echo $res[15];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $res[23];
								echo "</TD>";
              	if ($tri <> "SRNE")
					      {
                echo "<TD>";
                echo "<a href=# style='color:#333399' onclick=\"afficher('info_etab.php?id=".$res[4]."')\">".$res[4]."</a>";
								echo "</TD>";
								}
								echo "<TD>";
								echo $res[5];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $num_results_count;
								echo "</TD>";
								echo "<TD BGCOLOR = $fond align=\"center\">";
								echo $priorite_selection;
								echo "</TD>";
								echo "<TD align=\"center\">";
								verif_categorie($res[0]);
								echo "</TD>";
								
								echo "<TD BGCOLOR = \"#48D1CC\">";
								echo "<A HREF = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\"></A>";
								
								if($res[11] != "A" && $_SESSION['droit'] == "Super Administrateur")
									{
										echo "<A HREF = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\"></A>";	
										echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></A>";
										echo "&nbsp;<A HREF = \"affiche_categories.php?idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les catégories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\" width=\"25px\" height=\"32px\"></A>";
					
									}
								if($_SESSION['droit'] == "Super Administrateur")
									{
										echo "<A HREF = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"22px\"></A>";
									}
								
								echo "</TD>";
								echo "</TR>";
							}
						}
*/
?>
