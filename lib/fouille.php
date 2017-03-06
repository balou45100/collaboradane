<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
			//include("../biblio/ticket.css");
	echo "</head>
	<body>";
		//Inclusion des fichiers nécessaires
		include ("../biblio/config.php");
		include("../biblio/init.php");
		include ("../biblio/fct.php");
				
		echo "<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_rechercher_ticket.png\" ALT = \"Titre\">";
				//Définition des variables de session utilisées plus tard
				$_SESSION['origine'] = "fouille";
				//Récupération des variables
				$a_chercher = $_GET['a_chercher'];
				$ou = $_GET['ou'];
				//echo "<br>a_chercher : $a_chercher - ou : $ou";
/*
				$a_chercher = $_POST['a_chercher'];
				@$ou = $_POST['ou'];
*/
				$deverrouiller = $_GET['deverrouiller']; //Pour savoir si quelqu'un foce le déverrouillage d'un ticket
				$idpb = $_GET['idpb'];
/*
        if (!isset($a_chercher))
        {
          $a_chercher = $_GET['a_chercher'];
          $ou = $_GET['ou'];
          //echo "<BR>à chercher : $a_chercher";
          //echo "<BR>où : $ou";
        }
			  */
			  /*
				if(!isset($a_chercher) || $a_chercher == "")
				{
					$a_chercher = $_SESSION['a_chercher'];
        }
				else
				{
          $_SESSION['a_chercher'] = $a_chercher;
				}
        
        if(!isset($ou) || $ou == "")
				{
					$ou = $_SESSION['ou'];
        }
				else
				{
          $_SESSION['ou'] = $ou;
				}
        */
				//Test des champs récupérés
				//if(!isset($a_chercher) || !isset($ou) || $a_chercher == "" || $ou == "")
				if(!isset($a_chercher) || $a_chercher == "")
				{
					echo "<h2>Vous n'avez pas renseigné le champs 'Que chercher'</h2>
					<FORM ACTION = \"fouille.php\" METHOD = \"GET\">";
?>
					<TABLE>
						<TR>
							<TD class = "etiquette">
								<b>Que rechercher&nbsp;?&nbsp;
							</TD>
							<TD>
								&nbsp;<INPUT TYPE = "text" VALUE = "" NAME = "a_chercher" SIZE = "50">
							</TD>
						</TR>
						<TR>
							<TD class = "etiquette" valign="top">
								Chercher dans&nbsp;:&nbsp;
							</TD>
							<TD>
								</b>&nbsp;<SELECT NAME = "ou">
								<OPTION SELECTED = "SC" VALUE = "SC">Sujet et corps du ticket</OPTION>
								<OPTION VALUE = "S">Sujet</OPTION>
								<OPTION VALUE = "C">Corps du ticket</OPTION>
								<OPTION VALUE = "N">N° de ticket</OPTION>
								<OPTION VALUE = "NC">Nom contact</OPTION>
								<OPTION VALUE = "INT">Intervenant</OPTION>
								<OPTION VALUE = "PROP">Propri&eacute;taire du ticket</OPTION>
								<OPTION VALUE = "TRAITE_PAR">Trait&eacute; par (n'inclus pas les tickets archiv&eacute;s)</OPTION>
								<OPTION VALUE = "TRAITE_PAR_A">Trait&eacute; par (tickets archiv&eacute;s)</OPTION>
								<OPTION VALUE = "R">N° RNE</OPTION>
								<OPTION VALUE = "SO">N° d'une soci&eacute;t&eacute;</OPTION>
							</TD>
						</TR>
						<!--TR>
							<TD class = "etiquette">
								&nbsp;
							</TD>
							<TD class = "etiquette">
								<INPUT TYPE = "submit" VALUE = "Chercher">
							</TD>
						</TR-->
					</TABLE>
<?php
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<Td>";
									echo "<INPUT border=0 src = \"$chemin_theme_images/rechercher.png\" ALT = \"Valider\" title=\"Supprimer la cat&eacute;gorie et les favoris\" border=\"0\" type=image Value= \"Chercher\" submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Lancer la recherche</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				echo "</FORM>";
					exit;
				}
				
				//Si jamais il faut déverrouiller manuellement un ticket
				if ($deverrouiller == 'Oui')
				{
					deverouiller($idpb);
				}
				//Traitement des différentes valeur que peux prendre la variable où
				//echo "<BR>2-où : $ou<BR>";
				switch ($ou)
				{
					case 'S' :
					$query = "SELECT DISTINCT * FROM probleme WHERE NOM LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;
					
					case 'C' :
					$query = "SELECT DISTINCT * FROM probleme WHERE TEXTE LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;
					
					case 'SC' :
					$query = "SELECT DISTINCT * FROM probleme WHERE TEXTE LIKE '%".$a_chercher."%' AND STATUT != 'R' OR NOM LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'R' :
					$query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;
					
					case 'SO' :
					$query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT = ".$a_chercher." AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'N' : //Sur le N° de ticket
					$query = "SELECT DISTINCT * FROM probleme WHERE ID_PB = '".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'NC' : //sur nom de contact
					$query = "SELECT DISTINCT * FROM probleme WHERE CONTACT_NOM LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'INT' : //sur nom d'intervenant
					$query = "SELECT DISTINCT * FROM probleme WHERE INTERVENANT LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'PROP' : //sur nom d'intervenant
					$query = "SELECT DISTINCT * FROM probleme WHERE NOM_INDIVIDU_EMETTEUR LIKE '%".$a_chercher."%' AND STATUT != 'R' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'TRAITE_PAR' : //sur la personne traitant le ticket (sans archives)
					$query = "SELECT DISTINCT * FROM probleme WHERE TRAITE_PAR LIKE '%".$a_chercher."%' AND STATUT != 'R' AND STATUT != 'A' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'TRAITE_PAR_A' : //sur la personne traitant le ticket (archives)
					$query = "SELECT DISTINCT * FROM probleme WHERE TRAITE_PAR LIKE '%".$a_chercher."%' AND STATUT = 'A' ORDER BY STATUT DESC, ID_PB DESC";
					break;

					case 'NE' : //sur nom étab pas encore fait
					//$query = "SELECT DISTINCT * FROM probleme WHERE NUM_ETABLISSEMENT LIKE '%".$a_chercher."%' AND STATUT != 'R'";
					break;

					default :
					$query = "SELECT DISTINCT * FROM probleme WHERE TEXTE LIKE '%".$a_chercher."%' AND STATUT != 'R' OR NOM LIKE '%".$a_chercher."%' AND STATUT != 'R'";
					break;
				}
				
				$results = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results)
				{
					echo "<B>Problème lors de la connexion à la base de donnée ou problème inexistant</B>";
					echo "<BR><BR><A HREF = \"rechercher.php\" class = \"bouton\" target = \"body\">Retour à la recherche</A>";
					mysql_close();
					exit;
				}
				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if($num_results == "0")
				{
					echo "<h2>Aucun ticket retourné par votre requète, veuillez la formuler différemment où cherchez dans des champs différents</h2>";
					echo "<BR><A HREF = \"rechercher.php\" class = \"bouton\" targe = \"body\">Retour à la recherche</A>";
					mysql_close();
					exit;
				}
				
				echo "<TABLE>
				<TR>
					<th>
						ID
					</th>
					<th>
						ST
					</th>
					<th>
						Créé par
					</th>
					<th>
						Créé le
					</th>
					<th>
						Traité par
					</th>
					<th>
						Dern. interv.
					</th>
					<th>";
						if ($ou == "R")
						{
              echo "RNE";
            }
            else
            {
              echo "Soci&eacute;t&eacute;";
            }
            
					echo "</th>
					<th>
						Sujet
					</th>
					<th>
						Nb mes
					</th>
					<th>
						Priorité
					</th>
					<th>
						Alerte
					</th>
					<th>
						Actions
					</th>
				</TR>";
				//Traitement de chaque ligne
						echo "<h2>".$num_results." résultat(s) retourné(s) par la requète<br />";
						echo "concernant la recherche de '$a_chercher'</h2>";
						for($i = 0; $i < $num_results; ++$i)
						{
							$res = mysql_fetch_row($results);
							if($res[11] != "R")
							{
								//Requète pour connaître combien de message on été envoyé en réponse au problème
								$query_count = "SELECT * FROM probleme WHERE ID_PB_PERE = ".$res[0].";";
								$results_count = mysql_query($query_count);
								//Dans le cas où aucun résultats n'est retourné
								if(!$results_count)
								{
									echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
									echo "<BR><BR><A HREF = \"rechercher.php\" class = \"bouton\" target = \"body\">Retour à la recherche</A>";
									mysql_close();
									exit;
								}
								//Retourne le nombre de ligne rendu par la requète
								$num_results_count = mysql_num_rows($results_count);
								
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
               
								//nouvelle version d'affichage identique à gestion_ticket.php
								//echo "<br>verrou : $res[25] - par : $res[26]";
								if ($res[25] == 1) //le ticket est verrouillé
								{
									//$fond = "#FFFFFF"; //le fond de la priorité est mis à blanc
									//$couleur_fond = "#FFFFFF"; //Le fon du statut est mis à blanc
									echo "<TR class = \"verrou\">";
								}
								else
								{
									echo "<TR class = \"".statut($res[11])."\">";
								}
								//echo "<TR class = \"".statut($res[11])."\">";
								echo "<TD align=\"center\">";
								echo $res[0];
								echo "</TD>";
								if ($res[25] == 1) //le ticket est verrouillé
								{
									//$fond = "#FFFFFF"; //le fond de la priorité est mis à blanc
									//$couleur_fond = "#FFFFFF"; //Le fon du statut est mis à blanc
									echo "<TD align=\"center\">";
								}
								else
								{
									echo "<TD BGCOLOR = $couleur_fond align=\"center\">";
								}
								echo " ";
								echo "</TD>";
								echo "<TD>";
								echo $res[3];
								echo "</TD>";
								echo "<TD>";
								//Transformation de la date de création extraite pour l'affichage
								$date_de_creation_a_afficher = strtotime($res['27']);
								$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);

								//echo $res[27]; //créé le 
								echo $date_de_creation_a_afficher; //créé le
								//echo $res[7];
								echo "</TD>";
								echo "<TD>";
								echo $res[15];
								echo "</TD>";
								echo "<TD align=\"center\">";
								affiche_info_bulle($res[4],$res[23],$res[0]);

								//echo $res[23];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $res[4];
								echo "</TD>";
								echo "<TD>";
								echo $res[5];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $num_results_count;
								echo "</TD>";
								//echo "<TD BGCOLOR = $fond align=\"center\">";
								echo "<TD align=\"center\">";
								echo $priorite_selection;
								echo "</TD>";
								$id_util = $_SESSION['id_util'];
								verif_alerte($res[0],$id_util,$date_aujourdhui,"gestion");
								echo "</TD>";
								if ($res[25] == 1)
								{
									echo "<TD>";
									if ($res[26] == $_SESSION['nom'])
									{
										echo "&nbsp;&nbsp;<A HREF = \"fouille.php?deverrouiller=Oui&amp;idpb=".$res[0]."&amp;a_chercher=".$a_chercher."&amp;ou=".$ou."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" ALT = \"verrouillé par $res[26]\" title=\"verrouillé par $res[26], cliquer pour libérer le ticket\" border = \"0\"></A>&nbsp;&nbsp;";
									}
									else
									{
										echo "&nbsp;&nbsp;<A HREF = \"fouille.php?deverrouiller=Oui&amp;idpb=".$res[0]."&amp;a_chercher=".$a_chercher."&amp;ou=".$ou."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/verrouille.png\" ALT = \"verrouillé par $res[26]\" title=\"verrouillé par $res[26], cliquer pour libérer le ticket\" border = \"0\"></A>&nbsp;&nbsp;";
									}
									echo "<A HREF = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border = \"0\"></A>";
								}
								else
								{
									echo "<TD nowrap class = \"fond-actions\">";
									echo "&nbsp;<A HREF = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter et traiter ce ticket\" border = \"0\"></A>";
									echo "&nbsp;<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\" border = \"0\"></A>";
									echo "&nbsp;<A HREF = \"affiche_categories.php?idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les catégories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\" width=\"25px\" height=\"32px\"></A>";
									if($_SESSION['nom'] == $res[3])
									{
										if($res[11] != "A")
										{
											echo "&nbsp;<A HREF = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archiver.png\" ALT = \"archiver\" title=\"Archiver ce ticket\" border = \"0\"></A>";
											//echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></A>";
										}
										echo "&nbsp;<A HREF = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\"  border = \"0\"></A>";
									}
								}

/*
								echo "<TD BGCOLOR = \"#48D1CC\">";
								echo "<A HREF = \"consult_ticket.php?CHGMT=N&amp;idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"Consulter et traiter ce ticket\"></A>";
								echo "&nbsp;<A HREF = \"affiche_categories.php?idpb=".$res[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les catégories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>";
								if($_SESSION['nom'] == $res[3])
								{
									if($res[11] != "A")
									{
										echo "<A HREF = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\"></A>";	
										echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></A>";
                    echo "<A HREF = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"24px\"></A>";
 									}
								}
*/
								if($_SESSION['droit'] == "Super Administrateur")
									{
										echo "&nbsp;<A HREF = \"delete_ticket.php?idpb=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\" height=\"24px\" width=\"24px\"></A>";
									}
								
								echo "&nbsp;</TD>";
								echo "</TR>";
								
							}
						}
				mysql_close();
			?>
			</TABLE>
			<?php echo "<BR><A HREF = \"rechercher.php\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" title=\"Retour\"></A>";?>
		</div>
	</BODY>
</HTML>
				
				
