<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas une fiche de la table repertoire">

<html>
	<head>
  		<title>CollaboraDANE</title>
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
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
			<?php
				//Récupération de l'identifiant concernant la fiche à supprimer
				$id_societe = $_GET['id_societe'];
				$origine = $_SESSION['origine'];
				$origine_gestion = $_SESSION['origine_gestion'];
				
				//echo "<BR>origine : $origine - origine_gestion : $origine_gestion - id_societe : $id_societe<BR>";
				
				//Test du champ récupéré
				if(!isset($id_societe) || $id_societe == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Problèmes de récupération de la variable</B></FONT>";
					echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				  exit;
				}
				
				//Inclusion des fichiers nécessaires	
				include("../biblio/init.php");
				include ("../biblio/fct.php");
				//Récupération des données résumant la catégorie pour procéder à sa suppression ou non
				$query = "SELECT * FROM repertoire WHERE No_societe = '".$id_societe."';";
				$result_consult = mysql_query($query);
				$num_rows = mysql_num_rows($result_consult);
        if (mysql_num_rows($result_consult))
        {
		        $ligne=mysql_fetch_object($result_consult);
		        $id_societe=$ligne->No_societe;
		        $societe=$ligne->societe;
		        $adresse=$ligne->adresse;
		        $cp=$ligne->cp;
		        $ville=$ligne->ville;
		        $tel_standard=$ligne->tel_standard;
		        $fax=$ligne->fax;
		        $internet=$ligne->internet;
		        $remarques=$ligne->remarques;
		        $editeur=$ligne->editeur;
		        $fabricants=$ligne->fabricants;
		        $entreprise_de_service=$ligne->entreprise_de_service;
		        $presse_specialisee=$ligne->presse_specialisee;
		        $a_traiter=$ligne->a_traiter;
		        $a_faire_quand_date=$ligne->a_faire_quand_date;
		        $a_faire=$ligne->a_faire;
		        $urgent=$ligne->urgent;
		        $part_fgmm=$ligne->part_fgmm;
		        $nb_pb=$ligne->nb_pb;
		        $emetteur=$ligne->emetteur;
		        $statut=$ligne->statut;
		        
		    }
		    else
		    {
          //Dans le cas où aucun résultats n'est retourné
				  echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée ou problème inexistant</B></FONT>";
					echo "<BR><A HREF = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
          mysql_close();
					exit;
        }
					
				//$res = mysql_fetch_row($results);
					
				echo "<FONT COLOR = \"#808080\"><B>Voulez-vous vraiment supprimer cete fiche&nbsp;?</B></FONT> <BR>";
        echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
					         <CAPTION><b>Détails de l'enregistrement</b></CAPTION>
              <tr CLASS = \"new\">
                <td BGCOLOR = \"#48D1CC\" align = \"right\">Id&nbsp;:&nbsp;</td>
                <td align = \"center\">$id_societe</td>
                <td BGCOLOR = \"#48D1CC\" align = \"right\">Soci&eacute;t&eacute;&nbsp;:&nbsp;</td>
                <td align = \"center\">$societe</td>
                <td align = \"center\">";  
                  $checked=Testpourcocher($a_traiter);
                  echo "à traiter&nbsp;<input type=\"checkbox\" name=\"a_traiter\" value=\"1\" $checked>
                </td>
                <td align = \"center\">date&nbsp;(aaaa-mm-jj)&nbsp;:&nbsp;<input type=\"text\" name=\"a_faire_quand_date\" value=\"$a_faire_quand_date\" size=\"19\"></td>";
                  $checked=Testpourcocher($urgent); 
                  echo "<td align = \"center\">urgent&nbsp;:&nbsp;<input type=\"checkbox\" name=\"urgent\" value=\"1\" $checked>&nbsp;&nbsp; 
                </td>
                <td align = \"center\">";  
                  $checked=Testpourcocher($editeur);
			            echo "&eacute;diteur&nbsp;<input type=\"checkbox\" name=\"editeur\" value=\"1\" $checked></td>";
			            $checked=Testpourcocher($fabricants);
			            echo "<td align = \"center\">fabricant&nbsp;<input type=\"checkbox\" name=\"fabricants\" value=\"1\" $checked></td>";
                  $checked=Testpourcocher($entreprise_de_service);
                  echo "<td align = \"center\">service&nbsp;<input type=\"checkbox\" name=\"entreprise_de_service\" value=\"1\" $checked></td>";
                  $checked=Testpourcocher($presse_specialisee);
                  echo "<td align = \"center\">presse&nbsp;<input type=\"checkbox\" name=\"presse_specialisee\" value=\"1\" $checked>
                </td>
              </tr>
            </TABLE>
            <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
              <tr CLASS = \"new\">
                <td BGCOLOR = \"#48D1CC\" align = \"right\">Adresse&nbsp;:&nbsp;</td>
                <td align = \"center\">$adresse&nbsp;</td>
                <td BGCOLOR = \"#48D1CC\" align = \"right\">CP&nbsp;:&nbsp;</td>
                <td align = \"center\">$cp</td>
                <td BGCOLOR = \"#48D1CC\" align = \"right\">Ville&nbsp;:&nbsp;</td>
                <td align = \"center\">$ville</td>
              </tr>
              </TABLE>
            <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
            <tr CLASS = \"new\">
                <td BGCOLOR = \"#48D1CC\" align = \"right\">Site Web&nbsp;:&nbsp;</td>
                <td align = \"center\">$internet</td>
                <td BGCOLOR = \"#48D1CC\" align = \"right\">t&eacute;l Standard&nbsp;:&nbsp;</td>
                <td align = \"center\">$tel_standard</td>
                <td BGCOLOR = \"#48D1CC\" align = \"right\">fax&nbsp;:&nbsp;</td>
                <td align = \"center\">$fax</td>
              </tr>
            </TABLE>";
            if ($remarques <> "")
            {
              echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
                <tr CLASS = \"new\">
                  <TD BGCOLOR = \"#48D1CC\" align = \"right\" width = \"10%\">Remarques&nbsp;:&nbsp;</TD>
                  <TD width = \"90%\">$remarques</TD>
		            </tr>
              </TABLE>";
            }
            echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
              $ses_emetteur = $_SESSION['nom'];
		          $query_contacts = "SELECT * FROM contacts WHERE id_societe = '".$id_societe."' AND emetteur = '".$ses_emetteur."' OR id_societe = '".$id_societe."' AND emetteur <> '".$ses_emetteur."' AND statut = 'public' ORDER BY NOM ASC;";
	            $result_contacts = mysql_query($query_contacts);
	            $num_results_contacts = mysql_num_rows($result_contacts);
	            if ($num_results_contacts == 0)
	            {
	              echo "<TR>
                        <TD colspan = \"2\"><FONT COLOR = \"#000000\"><B>Pas de contact pour cette société&nbsp;-&nbsp;</B></FONT>
                          <A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><FONT COLOR = \"#000000\"><b>Cliquez ici pour ajouter un contact</b></FONT></A>
                        </TD>
                      </TR>";
	            }
	            else
	            {
  	            echo "<tr CLASS = \"new\">
                  <td colspan=\"2\">
                    Contacts &nbsp;:&nbsp;
                    <TABLE align = \"center\" width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
                      <tr>
                        <td width=\"5%\" align = \"center\"><b>Id</b></td>
                        <td width=\"10%\" align = \"center\"><b>Nom</b></td>
                        <td width=\"10%\" align = \"center\"><b>Pr&eacute;nom</b></td>
                        <td width=\"10%\" align = \"center\"><b>fonction</b></td>
                        <td width=\"10%\" align = \"center\"><b>t&eacute;l directe<b></td>
                        <td width=\"10%\" align = \"center\"><b>fax</b></td>
                        <td width=\"10%\" align = \"center\"><b>mobile</b></td>
                        <td width=\"10%\" align = \"center\"><b>m&eacute;l</b></td>
                        <td width=\"20%\" align = \"center\"><b>remarques</b></td>
                      </tr>";
                      //Affichage des contacts
                      $res_contacts = mysql_fetch_row($result_contacts);
                      for($i = 0; $i < $num_results_contacts; ++$i)
			                {
		                    echo "<tr CLASS = \"new\">
                          <td width=\"5%\" align = \"center\">".$res_contacts[0]."</td>
                          <td width=\"10%\">".$res_contacts[2]."</td>
                          <td width=\"10%\">".$res_contacts[3]."</td>
                          <td width=\"10%\">".$res_contacts[4]."</td>
                          <td width=\"10%\" align = \"center\">".$res_contacts[8]."</td>
                          <td width=\"10%\" align = \"center\">".$res_contacts[9]."</td>
                          <td width=\"10%\" align = \"center\">".$res_contacts[10]."</td>
                          <td width=\"10%\">".$res_contacts[11]."</td>
                          <td width=\"20%\">".$res_contacts[13]."</td>
                        </tr>";
                        $res_contacts = mysql_fetch_row($result_contacts);
                      }
                    echo "</table>";
                  echo "</td>
                </tr>";
              }
              if ($emetteur == $_SESSION['nom'])
              {
                echo "<tr CLASS = \"new\">
                  <TD  colspan=\"2\">Confidentialit&eacute;&nbsp;:&nbsp;
                  <select size=\"1\" name=\"statut\">
		                      <option selected value=\"$statut\">$statut</option>
			                    <option value=\"public\">Public (visible pour tous)</option>
			                    <option value=\"privé\">Privé (visible uniquement au propriétaire)</option>
			                  </select>
                  </TD>
                </TR>";
              }
              if ($autorisation_genies == "1")
              {
                echo "<tr CLASS = \"new\">";
                  $checked=Testpourcocher($part_fgmm);
                  echo "<td colspan=\"2\">Partenaire du Festival des Génies du Multimédia&nbsp;<input type=\"checkbox\" name=\"part_fgmm\" value=\"1\" $checked> 
                  </td>
                </tr>";
              }
            echo "</table>";
            echo "
            <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
              <TR CLASS = \"new\">
                <TD>A faire&nbsp;:&nbsp;</TD>
                <TD align=\"left\"><textarea rows=\"4\" name=\"a_faire\" cols=\"100\">$a_faire</textarea></TD>
				     </TR>
		        </TABLE>";
		        
		        
		        //Affichage du bouton de confirmation et du bouton retour
		        echo "<BR>
				    <A HREF = \"repertoire_confirm_suppression_fiche.php?id_societe=".$id_societe."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\"></A>";
				    echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				
		        //Affichage des tickest enregistrés
		        
		        echo "<BR>
                <TABLE BORDER = \"0\"  BGCOLOR = \"#48D1CC\">
                <CAPTION><b>Tickets enregistrés</b></CAPTION>
                  <TR>
	                   <TD align=\"center\">ID</TD>
                     <TD align=\"center\">ST</TD>
					           <TD align=\"center\">Créé par</TD>
					           <TD align=\"center\">Créé le</TD>
					           <TD align=\"center\">Traité par</TD>
					           <TD align=\"center\">Dern. interv.</TD>
                     <TD align=\"center\">Sujet</TD>
                     <TD align=\"center\">Nb mes</TD>
                     <TD align=\"center\">Priorité</TD>
        				  </TR>";
            $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
						/*
            if($_SESSION['droit'] == "Super Administrateur" )
						{
              $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
            }
            else
            {
          	   $query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' AND NUM_ETABLISSEMENT = '".$id_societe."' AND MODULE = 'REP' ORDER BY ID_PB DESC;";
						}
						*/
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
								    echo $res[7];
								  echo "</TD>";
								  echo "<TD>";
								    echo $res[15];
								  echo "</TD>";
								  echo "<TD align=\"center\">";
								    echo $res[23];
								  echo "</TD>";
								  echo "<TD>";
								    echo $res[5];
								  echo "</TD>";
								  
                  echo "<TD align=\"center\">";
								    echo $num_results_count;
								  echo "</TD>";
								  echo "<TD BGCOLOR = $fond align=\"center\">";
								    echo $priorite_selection;
								  echo "</TD>";
								echo "</TR>";
							}
						}
					echo "</TABLE>";
        mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
					
