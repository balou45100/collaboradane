<?php
	//Lancement de la session pour verifier si l'on est logué
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
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>vous n'ètes pas logué</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">Retour à la mire de connexion</A></CENTER>";
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
				$tri = $_GET['tri'];
				$indice = $_GET['indice'];
				//Test du champ récupéré
				if(!isset($tri) || $tri == "" || !isset($indice) || $indice == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Erreur de récupération des données</B></FONT>";
					echo "<BR><A HREF = \"body.php\" target = \"body\" class = \"bouton\">Retour à l'accueil</A>";
					exit;
				}
				
				//Inclusion des fichiers nécessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
				
				$nb_par_page = 10;
				
				//Table servant pour les filtres
				echo "<TABLE BORDER = \"0\" BGCOLOR = \"#000000\">";
					echo "<TR>";
						echo "<TD BGCOLOR = \"#AFEEEE\">";
							echo "<A href=\"gestion_etab.php?tri=18&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles du Cher</FONT></B></A>";
						echo "</TD>";
            
            echo "<TD BGCOLOR = \"#20B2AA\">";
							echo "<A href=\"gestion_etab.php?tri=28&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles de l'Eure et Loir</FONT></B></A>";
						echo "</TD>";
            
            echo "<TD BGCOLOR = \"#87CEFA\">";
							echo "<A href=\"gestion_etab.php?tri=36&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles de l'Indre</FONT></B></A>";
						echo "</TD>";
						
            echo "<TD BGCOLOR = \"#05FA92\">";
							echo "<A href=\"gestion_etab.php?tri=37&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles de l'Indre et Loire</FONT></B></A>";
						echo "</TD>";
						
            echo "<TD BGCOLOR = \"#039EFC\">";
							echo "<A href=\"gestion_etab.php?tri=41&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles du Loir et Cher</FONT></B></A>";
						echo "</TD>";
						
						echo "<TD BGCOLOR = \"#7FFFD4\">";
							echo "<A href=\"gestion_etab.php?tri=45&amp;indice=0\" target = \"body\"><B><FONT COLOR=\"BLACK\">Etabs/Ecoles du Loiret</FONT></B></A>";
						echo "</TD>";
						
					echo "</TR>";
				echo "</TABLE>";
				echo "<BR>";
				
			?>
			<A HREF = "form_etab.php" class = "bouton">Insérer un nouvel établissement</A><BR><BR>
			
			<FONT COLOR = "#00BFFF">Pour tout envoie de mail, l'adresse de la personne connecté est mise par defaut en copie</FONT>
			<BR><BR>
			<TABLE BORDER="0" ALIGN="CENTER" BGCOLOR = "#48D1CC">
				<TR>
					<TD>
						N° RNE
					</TD>
					<TD>
						Type 
					</TD>
					<TD>
						Pu/Pr
					</TD>
					<TD>
						Dénomination 
					</TD>
					<TD>
						Adresse 
					</TD>
					<TD>
						Code postal
					</TD>
					<TD>
						Ville 
					</TD>
					<TD>
						N° de téléphone 
					</TD>
					<TD>
						Circonscription 
					</TD>
					<TD>
						Email
					</TD>
					<TD>
						Nb de tickets postés
					</TD>
					<TD>
						Option 
					</TD>
				</TR>
					
				<?php
					
					//Requète pour afficher les établissements selon le filtre appliqué
					switch($tri)
					{
						case 'T' :
						$query = "SELECT * FROM etablissements;";
						break;
						
						case '18' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '18%';";
						break;
							
						case '28' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '28%';";
						break;
							
						case '36' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '36%';";
						break;
						
						case '37' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '37%';";
						break;
						
						case '41' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '41%';";
						break;
						case '45' :
						$query = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '45%';";
						break;
						
						default :
						$query = "SELECT * FROM etablissements;";
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
					
					///////////////////////////////////
					//Partie sur la gestion des pages//
					///////////////////////////////////
					$nb_page = number_format($num_results/$nb_par_page,1);
					$par_navig = "0";
					echo "<FONT COLOR = \"#808080\"><B>Page&nbsp;</B></FONT><A HREF = \"gestion_etab.php?tri=".$tri."&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
					for($j = 1; $j<$nb_page; ++$j)
					{
						$nb = $j * $nb_par_page;
						$page = $j + 1;
						$par_navig++;
							if($par_navig=="41")
							{
								echo "<BR>";
								$par_navig=0;}
							echo "<A HREF = \"gestion_etab.php?tri=".$tri."&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
						echo "<TR class = \"".dep(substr($res[6],0,2))."\">";
						echo "<TD>";
						echo $res[0];
						echo "</TD>";
						echo "<TD>";
						echo strtoupper(str_replace("*", " ",$res[1]));
						echo "</TD>";
						echo "<TD>";
						echo strtoupper($res[2]);
						echo "</TD>";
						echo "<TD>";
						echo strtoupper(str_replace("*", " ",$res[3]));
						echo "</TD>";
						echo "<TD>";
						echo strtoupper(str_replace("*", " ",$res[4]));
						echo "</TD>";
						echo "<TD>";
						echo str_replace("*", " ",$res[6]);
						echo "</TD>";
						echo "<TD>";
						echo strtoupper(str_replace("*", " ",$res[5]));
						echo "</TD>";
						echo "<TD>";
						echo $res[7];
						echo "</TD>";
						echo "<TD>";
						echo str_replace("*", " ",$res[9]);
						echo "</TD>";
						echo "<TD>";
						if($res[8] != "")
						{
							//Lien pour envoyer un mail
							echo "<A HREF = \"mailto:".str_replace(" ", "*",$res[8])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\"><FONT COLOR=\"#696969\">".$res[8]."</FONT></A>";
						}
						echo "</TD>";
						echo "<TD>";
						echo $nb_pb[0];
						echo "</TD>";
						echo "<TD BGCOLOR = \"#48D1CC\">";
						echo "<A HREF = \"delete_etab.php?rne=".$res[0]."&amp;denomination=".str_replace(" ", "*",$res[3])."&amp;adresse=".str_replace(" ", "*",$res[4])."&amp;CP=".str_replace(" ", "*",$res[6])."&amp;ville=".str_replace(" ", "*",$res[5])."\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\"></A>";	
						echo "<A HREF = \"modif_etab.php?rne=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\"></A>";
						echo "</TD>";
						echo "</TR>";
						$res = mysql_fetch_row($results);
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
				?>
			</TABLE>
		</CENTER>
	</body>
</html>
