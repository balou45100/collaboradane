<?php
	//Requète pour afficher les tickets selon le filtre appliqué
	if ($sense_tri == "")
	{
	  $sense_tri="DESC";
	}
/*	
	echo "<br>tri : $tri";
	echo "<br>tri2 : $tri2";
	echo "<br>sense_tri : $sense_tri";
	echo "<br>";					
*/
	//Requête de base
	if ($tri == "MAL")
	{
		if($_SESSION['droit'] == "Super Administrateur")
		{
			$query = "SELECT DISTINCT * FROM probleme, alertes WHERE `probleme`.`ID_PB` = `alertes`.`id_ticket`";
		}
		else
		{
			$query = "SELECT DISTINCT * 
				FROM probleme,alertes
			
				WHERE `probleme`.`ID_PB` = `alertes`.`id_ticket`
				AND `alertes`.`id_util` = '".$_SESSION['id_util']."'";
		}
	}
	else
	{
		if($_SESSION['droit'] == "Super Administrateur")
		{
			$query = "SELECT DISTINCT ID_PB, ID_PB_PERE, MAIL_INDIVIDU_EMETTEUR, NOM_INDIVIDU_EMETTEUR, NUM_ETABLISSEMENT, NOM, TEXTE, DATE_CREATION, DATE_MODIF, DATE_ARCHI, 
				INTERVENANT, STATUT, NB_MESS, PRIORITE, STATUT_TRAITEMENT, TRAITE_PAR, A_FAIRE, CONTACT_TITRE, CONTACT_NOM, CONTACT_PRENOM, CONTACT_MAIL, CONTACT_FONCTION, CONTACT_TYPE,
				MODULE, DATE_DERNIERE_INTERVENTION, VERROU, VERROUILLE_PAR, DATE_CREA, date_demande
				
				FROM probleme, intervenant_ticket 
			
				WHERE probleme.id_pb = intervenant_ticket.id_tick
				AND STATUT = 'N'";
		}
		else
		{
			$query = "SELECT DISTINCT ID_PB, ID_PB_PERE, MAIL_INDIVIDU_EMETTEUR, NOM_INDIVIDU_EMETTEUR, NUM_ETABLISSEMENT, NOM, TEXTE, DATE_CREATION, DATE_MODIF, DATE_ARCHI, 
				INTERVENANT, STATUT, NB_MESS, PRIORITE, STATUT_TRAITEMENT, TRAITE_PAR, A_FAIRE, CONTACT_TITRE, CONTACT_NOM, CONTACT_PRENOM, CONTACT_MAIL, CONTACT_FONCTION, CONTACT_TYPE,
				MODULE, DATE_DERNIERE_INTERVENTION, VERROU, VERROUILLE_PAR, DATE_CREA, date_demande
				
				FROM probleme, intervenant_ticket 
			
				WHERE probleme.id_pb = intervenant_ticket.id_tick
				AND STATUT = 'N'
				AND (id_crea = '".$_SESSION['id_util']."' OR id_interv = '".$_SESSION['id_util']."')";
		}
 	}
	switch($tri)
	{
		case 'G' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
				case 'ID' :
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY ID_PB $sense_tri;";
				break;
							
                case 'Cr' :
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
				break;
							
                case 'RNE' :
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
				break;
							
				case 'P' :
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
				break;
							   
                case 'DI' : //Dernière intervention
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
				break;
							
				case 'TP' : //Traité par
					$complement_req2 = " AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY TRAITE_PAR $sense_tri;";
				break;
							
/*
				case 'AL' : //les alertes de la personne connectée
					$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND MODULE = 'GT' AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY date_alerte $sense_tri;";
				break;
*/
				default :
					$complement_req2 = " ORDER BY probleme.ID_PB DESC;";
				break;
			}
        break;
					
		case 'OTA' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT IN ('N','C','T') AND MODULE = 'GT'";
			switch ($tri2)
			{
           		case 'ID' :
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY ID_PB $sense_tri;";
				break;
				
           		case 'Cr' :
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
				break;
							
               case 'RNE' :
					$complement_req2 = "AND STATUT_TRAITEMENT IN ('N','C','T') AND `CONTACT_TYPE` = 'OTA' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
				break;

           		case 'P' :
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
				break;
							   
           		case 'DI' : //Dernière intervention
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
				break;
							
           		case 'TP' : //Traité par
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY TRAITE_PAR $sense_tri;";
				break;
							
				default :
					$complement_req2 = " AND `CONTACT_TYPE` = 'OTA' ORDER BY ID_PB DESC;";
				break;
        	}
        break;
							
		case 'NOUV' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT ='N' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
						
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
            	case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
            	case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri, ID_PB DESC;";
			  	break;
							   
            	case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = "AND STATUT_TRAITEMENT ='N' ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;

        case 'TRAITE' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT ='C' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
							
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri, ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
							
        case 'TRANS' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT ='T' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
							
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							  
        		case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
							
        case 'ATTENTE' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT ='A' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
						
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri, ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
							
        case 'PH' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND PRIORITE = '1' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
						
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
					
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
				
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB DESC;";
				break;
        	}
        break;
							
		case 'REP' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'REP'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
					
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
			  	case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
        	}
        break;
							
        case 'Aa' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND STATUT_TRAITEMENT = 'F' AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
							
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
			  	case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
		
		/*					
		case 'MeAa' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
		  			$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
			  	break;
						
        		case 'Cr' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
			  	case 'P' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT_TRAITEMENT = 'F' AND STATUT != 'R' AND STATUT <> 'A' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
		
							
		case 'A' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
			  	break;
							
        		case 'Cr' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
							
        		case 'RNE' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
			  	case 'P' :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
						   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
				
        		case 'TP' : //Traité par
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT = 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
			  	break;
        	}
        break;
		
							
		case 'Me' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
				case 'ID' :
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
				break;
							
				case 'Cr' :
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
				break;
							
				case 'RNE' :
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
				break;
							
				case 'P' :
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
				break;
							
				case 'DI' : //Dernière intervention
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
				break;
							
				case 'TP' : //Traité par
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
				break;
							
				default :
					$complement_req2 = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
				break;
			}
		break;
		*/
		
		case 'MAL' :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
				case 'ID' :
					$complement_req2 = " ORDER BY ID_PB $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND TRAITE_PAR LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."'ORDER BY ID_PB $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB $sense_tri;";
				break;
							
				case 'Cr' :
					$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
				break;
							
				case 'RNE' :
					$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
				break;
							
				case 'P' :
					$complement_req2 = " ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
				//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
				break;
							
				case 'DI' : //Dernière intervention
					$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
				break;
							
				case 'TP' : //Traité par
					$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY TRAITE_PAR $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
				break;
							
				case 'AL' : //par alerte
					$complement_req2 = " ORDER BY date_alerte $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY date_alerte $sense_tri;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY TRAITE_PAR $sense_tri;";
				break;
					
				default :
					$complement_req2 = " ORDER BY date_alerte ASC;";
					//$query = "SELECT DISTINCT * FROM probleme,alertes WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' OR STATUT != 'R' AND STATUT <> 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND `probleme`.`ID_PB` = `alertes`.`id_ticket`AND `alertes`.`id_util` = '".$_SESSION['id_util']."' ORDER BY date_alerte ASC;";
					//$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' AND MODULE = 'GT' ORDER BY ID_PB DESC;";
				break;
			}
		break;

		default :
			//On ajoute la partie au sujet du STATUT_TRAITEMENT
			$complement_req1 = " AND MODULE = 'GT'";
			switch ($tri2)
			{
        		case 'ID' :
			  		$complement_req2 = " ORDER BY ID_PB $sense_tri;";
			  	break;
						
        		case 'Cr' :
			  		$complement_req2 = " ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			  	break;
					
        		case 'RNE' :
			  		$complement_req2 = " ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			  	break;
							
			  	case 'P' :
			  		$complement_req2 = " ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			  	break;
							   
        		case 'DI' : //Dernière intervention
			  		$complement_req2 = " ORDER BY DATE_DERNIERE_INTERVENTION $sense_tri;";
			  	break;
							
        		case 'TP' : //Traité par
			  		$complement_req2 = " ORDER BY TRAITE_PAR $sense_tri;";
			  	break;
							
			  	default :
			  		$complement_req2 = " ORDER BY ID_PB;";
			  	break;
        	}
        break;
	}
	$requete_complete = $query.$complement_req1.$complement_req2;
	//echo "<br />requete_complete : $requete_complete<br />";
?>
