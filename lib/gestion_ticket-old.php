<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Ce fichier affiche la liste de tous les Tickets avec leurs informations et pour chaque Ticket"
"Un bouton pour la consultation et deux boutons pour la modification et l'archivage"
"Ces deux derniers étant accessible que si l'on est créateur du message">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>vous n'ètes pas logué</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A HREF=\"../index.php\" class = \"bouton\">Retour à la mire de connexion</A></CENTER>";
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
			
				//Pour filtrer les tickets
				$tri = $_GET['tri'];
				$indice = $_GET['indice'];
				
								
				//Test du champ récupéré
				if(!isset($tri) || $tri == "" || !isset($indice) || $indice == "")
				{
					echo "problème";
					exit;
				}
				
				$nb_par_page = 10;
				
				//Inclusion des fichiers nécessaires
				include ("../biblio/fct.php");
				include ("../biblio/init.php");
				
				//Table servant pour les filtres
				
				echo "<TABLE BORDER = \"0\"  BGCOLOR = \"#000000\">";
					echo "<TR>";
						echo "<TD BGCOLOR = \"#FFFF99\">";
							echo "<A href=\"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Tous</FONT></B></A>";
						echo "</TD>";
            			echo "<TD BGCOLOR = \"#A4EFCA\">";
							echo "<A href=\"gestion_ticket.php?tri=N&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Nouveaux</FONT></B></A>";
						echo "</TD>";
						echo "<TD BGCOLOR = \"#B3CEEF\">";
							echo "<A href=\"gestion_ticket.php?tri=M&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Modifiés</FONT></B></A>";
						echo "</TD>";
						echo "<TD BGCOLOR = \"#FF0000\">";
							echo "<A href=\"gestion_ticket.php?tri=P&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Priorité Haute</FONT></B></A>";
						echo "</TD>";
            			echo "<TD BGCOLOR = \"#FF9FA3\">";
							echo "<A href=\"gestion_ticket.php?tri=A&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Archivés</FONT></B></A>";
						echo "</TD>";
						echo "<TD BGCOLOR = \"#B300EF\">";
							echo "<A href=\"gestion_ticket.php?tri=Me&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Mes Tickets</FONT></B></A>";
						echo "</TD>";
					echo "</TR>";
				echo "</TABLE><BR>";
							
			?>
			<A HREF = "form_ticket.php" class = "bouton">Insérer un nouveau Ticket</A>
			<BR><BR>
			<TABLE BORDER = "0"  BGCOLOR = "#48D1CC">
				<TR>
					<TD align="center">
						ID
					</TD>
          <TD align="center">
						Emetteur &nbsp;&nbsp;
					</TD>
					<TD align="center">
						Créé le&nbsp;&nbsp;
					</TD>
					<!--TD>
						Date de modification &nbsp;&nbsp;
					</TD>
					<TD>
						Date d'archivage &nbsp;&nbsp;
					</TD-->
					<TD align="center">
						RNE &nbsp;&nbsp;
					</TD>
					<TD align="center">
						Sujet &nbsp;&nbsp;
					</TD>
					<TD align="center">
						Nb mes &nbsp;&nbsp;
					</TD>
					<TD align="center">
						Priorité &nbsp;&nbsp;
					</TD>
					<TD align="center">
						Option &nbsp;&nbsp;
					</TD>
				</TR>
					
				<?php
					//L'administrateur à le droit de voir tous les tickets
					if($_SESSION['droit'] == "Super Administrateur" )
					{
						//Requète pour afficher les tickets selon le filtre appliqué
						switch($tri)
						{
							case 'G' :
							$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
						
							case 'N' :
							$query = "SELECT DISTINCT * FROM probleme WHERE STATUT = 'N' ORDER BY ID_PB DESC;";
							break;
							
							case 'M' :
							$query = "SELECT DISTINCT * FROM probleme WHERE STATUT = 'M' ORDER BY ID_PB DESC;";
							break;
						
							case 'A' :
							$query = "SELECT DISTINCT * FROM probleme WHERE STATUT = 'A' ORDER BY ID_PB DESC;";
							break;
							
							case 'P' :
							$query = "SELECT DISTINCT * FROM probleme WHERE PRIORITE = 'H' AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
							
							case 'Me' :
							$query = "SELECT DISTINCT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
							
              				default :
							$query = "SELECT DISTINCT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
						}
						
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
						//echo $num_results;
						///////////////////////////////////
						//Partie sur la gestion des pages//
						///////////////////////////////////
						$nombre_de_page = number_format($num_results/$nb_par_page,1);						
						
						echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_ticket.php?tri=".$tri."&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						for($j = 1; $j<$nombre_de_page; ++$j)
						{
							$nb = $j * 10;
							$page = $j + 1;
							echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
		
									case "N":
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									break;

									case "H":
									$priorite_selection = "Haute";
									$priorite_non_selection_ref_1 = "N";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Normal";
									$priorite_non_selection_nom_2 = "Basse";
									break;

									case "B":
									$priorite_selection = "Basse";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "N";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Normal";
									break;

									default:
									$res[13] = "N";
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									break;
								}
								//Retourne le nombre de ligne rendu par la requète
								$num_results_count = mysql_num_rows($results_count);
								echo "<TR class = \"".statut($res[11])."\">";
								echo "<TD>";
								echo $res[0];
								echo "</TD>";
                echo "<TD>";
								echo $res[3];
								echo "</TD>";
								echo "<TD>";
								echo $res[7];
								echo "</TD>";
								echo "<TD>";
								echo $res[4];
								echo "</TD>";
								/*echo "<TD>";
								echo $res[8];
								echo "</TD>";
								echo "<TD>";
								echo $res[9];
								echo "</TD>";*/
								echo "<TD>";
								echo $res[5];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $num_results_count;
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $priorite_selection;
								echo "</TD>";
								echo "<TD BGCOLOR = \"#48D1CC\">";
								echo "<A HREF = \"consult_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter\"></A>";
								
								if($res[11] != "A" && $_SESSION['droit'] == "Super Administrateur")
									{
										echo "<A HREF = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\"></A>";	
										echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\"></A>";
									}
								echo "</TD>";
								echo "</TR>";
							}
						}						
					}
			
					//L'utilisateur à le droit de voir les tickets qu'il a envoyés ou ceux dont il est intervenant
					if($_SESSION['droit'] == "Utilisateur")
					{
						//Requète pour afficher les tickets selon le filtre appliqué
						switch($tri)
						{
							case 'G' :
							$query = "SELECT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT != 'R' AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
							
							case 'N' :
							$query = "SELECT * FROM probleme WHERE STATUT = 'N' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR STATUT = 'N' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' ORDER BY ID_PB DESC;";
							break;
							
							case 'M' :
							$query = "SELECT * FROM probleme WHERE STATUT = 'M' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR STATUT = 'M' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' ORDER BY ID_PB DESC;";
							break;
							
							case 'A' :
							$query = "SELECT * FROM probleme WHERE STATUT = 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR STATUT = 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' ORDER BY ID_PB DESC;";
							break;
							
							case 'P' :
							$query = "SELECT * FROM probleme WHERE PRIORITE = 'H' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR STATUT = 'A' AND INTERVENANT LIKE '%".$_SESSION['nom']."%' AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
							
							case 'Me' :
							$query = "SELECT * FROM probleme WHERE MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND STATUT != 'R'  AND STATUT <> 'A' ORDER BY ID_PB DESC;";
							break;
							
              				default :
							$query = "SELECT * FROM probleme WHERE STATUT != 'R' AND STATUT <> 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' AND MAIL_INDIVIDU_EMETTEUR = '".$_SESSION['mail']."' OR INTERVENANT LIKE '%".$_SESSION['nom']."%'AND STATUT != 'R' AND STATUT <> 'A' ORDER BY ID_PB;";
							break;
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
						///////////////////////////////////
						//Partie sur la gestion des pages//
						///////////////////////////////////
						$nombre_de_page = number_format($num_results/$nb_par_page,1);
						
						echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_ticket.php?tri=".$tri."&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
						for($j = 1; $j<$nombre_de_page; ++$j)
						{
							$nb = $j * 10;
							$page = $j + 1;
							echo "<A HREF = \"gestion_ticket.php?tri=".$tri."&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
								switch ($res[13]) {
		
									case "N":
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									break;

									case "H":
									$priorite_selection = "Haute";
									$priorite_non_selection_ref_1 = "N";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Normal";
									$priorite_non_selection_nom_2 = "Basse";
									break;

									case "B":
									$priorite_selection = "Basse";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "N";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Normal";
									break;

									default:
									$res[13] = "N";
									$priorite_selection = "Normal";
									$priorite_non_selection_ref_1 = "H";
									$priorite_non_selection_ref_2 = "B";
									$priorite_non_selection_nom_1 = "Haute";
									$priorite_non_selection_nom_2 = "Basse";
									break;
								}
								//Retourne le nombre de ligne rendu par la requète
								$num_results_count = mysql_num_rows($results_count);
								echo "<TR class = \"".statut($res[11])."\">";
								echo "<TD>";
								echo $res[0];
								echo "</TD>";
                echo "<TD>";
								echo $res[3];
								echo "</TD>";
								echo "<TD>";
								echo $res[7];
								echo "</TD>";
								echo "<TD>";
								echo $res[4];
								echo "</TD>";
								/*echo "<TD>";
								echo $res[8];
								echo "</TD>";
								echo "<TD>";
								echo $res[9];
								echo "</TD>";*/
								echo "<TD>";
								echo $res[5];
								echo "</TD>";
								echo "<TD align=\"center\">";
								echo $num_results_count;
								echo "</TD>";
								echo "<TD>";
								echo $priorite_selection;
								echo "</TD align=\"center\">";
								echo "<TD BGCOLOR = \"#48D1CC\">";
								echo "<A HREF = \"consult_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter\"></A>";
								if($_SESSION['nom'] == $res[3])
								{
									if($res[11] != "A")
									{
										echo "<A HREF = \"archiver_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\"></A>";	
										echo "<A HREF = \"modif_ticket.php?idpb=".$res[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\"></A>";	
									}
								}
								echo "</TD>";
								echo "</TR>";
							}
						}
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
				?>
			</TABLE>
		</CENTER>
	</body>
</html>

