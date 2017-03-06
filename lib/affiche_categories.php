<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
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
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//include ("../biblio/ticket.css");
			//include ("../biblio/config.php");
			//include ("../biblio/javascripts.php");
			//include ('../biblio/init.php');
	echo "<body>
		<div align = \"center\">";
				//Inclusion des fichiers n&eacute;cessaires
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
								
				//R&eacute;cup&eacute;ration de la variable indiquant le num&eacute;ro du ticket pour lequel il faut afficher les cat&eacute;gories
				@$idpb = $_GET['idpb'];
				@$idc = $_GET[id_categ];
				@$origine = $_SESSION['origine'];
				@$tri = $_GET['tri'];
				$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
				$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
				
				//echo "<br />origine : $origine";
				
        //R&eacute;cup&eacute;ration des donn&eacute;es r&eacute;sumant le ticket
				
        $query_pb = "SELECT * FROM probleme WHERE id_pb = '".$idpb."';";
				$result_pb = mysql_query($query_pb);
				if(!$result_pb)
				{
					echo "<B>probl&egrave;me lors de l'execution de la requ&egrave;te</B>";
					switch ($origine)
				  {
            case 'gestion_ticket':
              echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
         
            case 'gestion_categories':
              echo "<br /><a href = ".$origine.".php?id_categ=$idc&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
				    
				    case 'fouille':
              echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
          }
          mysql_close();
					exit;
				}
					
				$res = mysql_fetch_row($result_pb);
					
				echo "<h2>Voici le d&eacute;tail du ticket&nbsp;:</h2>";
				echo "<table width=\"95%\">";
					echo "<tr>";
						echo "<td class = \"etiquette\" width=\"10%\">N°&nbsp;:&nbsp;</td>";
						echo "<td width = \"10%\"><b>&nbsp;$res[0]</b></td>";
						echo "<td class = \"etiquette\" width=\"10%\">cr&eacute;&eacute; par&nbsp:&nbsp;</td>";
						echo "<td width=\"30%\">&nbsp;$res[3]</td>";
						echo "<td class = \"etiquette\" width=\"10%\">cr&eacute;&eacute; le&nbsp:&nbsp;</td>";
						echo "<td width=\"30%\">&nbsp;$res[7]</td>";

					echo "<tr>";
						echo "<td class = \"etiquette\">Sujet&nbsp;:&nbsp;</td>";
						echo "<td colspan=\"5\">$res[5]</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td class = \"etiquette\" >Contenu&nbsp;:&nbsp;</td>";
						echo "<td colspan=\"5\">$res[6]</td>";
					echo "</tr>";
				echo "</table>";

				//S&eacute;lection des cat&eacute;gories concern&eacute;es
				$query_cat = "SELECT * FROM categorie WHERE ID_PB_CATEG LIKE '%".$idpb."%';";
				$result_cat = mysql_query($query_cat);
				//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
				if(!$result_cat)
				{
					echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
					switch ($origine)
				  {
            case 'gestion_ticket':
              echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
         
            case 'gestion_categories':
              echo "<br /><a href = ".$origine.".php?id_categ=$idc&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
				    
				    case 'fouille':
              echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    break;
          }
          mysql_close();
					exit;
				}
				
				//Retourne le nombre de ligne rendu par la requ&egrave;te
				$num_results_cat = mysql_num_rows($result_cat);
				//echo "<br />1 - Nombre d'enregistrements renvoy&eacute;s : $num_results_cat";
				
				if ($num_results_cat >0)
				{
				  //echo "<br />2 - Nombre d'enregistrements renvoy&eacute;s : $num_results_cat";
				  if ($num_results_cat == 1)
          { 
				    echo "<br />Inscrit dans la cat&eacute;gorie&nbsp;:";
				  }
          else
          {  
				    echo "<br />Inscrit dans&nbsp;:";
				  }
				  
          $res_cat = mysql_fetch_row($result_cat);
			    echo "<table>";
				    echo "<tr>";
					   echo "<th>Cat&eacute;gorie</th>";
					   echo "<th>Propri&eacute;tare</th>";
					   echo "<th>Supprimer de la cat&eacute;gorie</th>";
				    echo "</tr>";
				  for($i=0; $i<$num_results_cat; ++$i)
				  {
				    if ($res_cat[2] == $_SESSION['nom'])
				    {
              echo "<tr>";
					    echo "<td>";
					    echo "<a href = \"gestion_categories.php?id_categ=".$res_cat[0]."\" TARGET = \"body\">".$res_cat[1]."</a>";
					    echo "</td>";
					    echo "<td>$res_cat[2]</td>";
              echo "<td class = \"fond-actions\" align = \"center\">";
					    echo "&nbsp;<a href = \"delete_ticket_categ.php?origine=$origine&amp;id_categ=".$res_cat[0]."&amp;idpb=$idpb\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer de cette cat&eacute;gorie\" border = \"0\"></a>";
					    echo "</td>";
					    echo "</tr>";
            }
					  $res_cat = mysql_fetch_row($result_cat);
				  }
				  echo "</table>";
				  
        }
        else
        {
          echo "<B><br />Le ticket N° $res[0] n'est inscrit dans aucune cat&eacute;gorie.</B>";
        }
        switch ($origine)
				{
          case 'gestion_ticket':
            echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				  break;
         
          case 'gestion_categories':
            echo "<br /><br /><a href = ".$origine.".php?id_categ=$idc&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				  break;
				  
				  case 'fouille':
            echo "<br /><br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				  break;
        }
			?>
		</div>
	</body>
</html>
