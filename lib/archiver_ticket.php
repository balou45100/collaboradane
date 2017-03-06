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

			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include('../biblio/init.php');
	echo "<body>
		<div align = \"center\">";
			//test de r&eacute;cup&eacute;ration des donn&eacute;es, l'archivage se fait selon l'identifiant du probl&egrave;me
				$idpb = $_GET['idpb'];
				$id_categ = $_GET['id_categ']; //pour pouvoir repartir vers la gestion des cat&eacute;gories
				$origine = $_SESSION['origine']; //permet de savoir quel script appelle le script actuel
				$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
				$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
				$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
				
				if(!isset($idpb) || $idpb == "")
				{
					echo "<B>Probl&egrave;me non r&eacute;f&eacute;renc&eacute; dans la base de donn&eacute;e</B>";
					switch ($origine)
					{
						case 'gestion_ticket':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
         
						case 'gestion_categories':
							echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'fouille':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					exit;
				}
				//Requ&egrave;te pour selectionner toutes les donn&eacute;es correspondant a l'identifiant du probl&egrave;me
				$query = "SELECT * FROM probleme WHERE  ID_PB = '".$idpb."';";
				$results = mysql_query($query);
				//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
				if(!$results)
				{
					echo "<B>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</B>";
					switch ($origine)
					{
						case 'gestion_ticket':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'gestion_categories':
							echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'fouille':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					mysql_close();
					exit;
				}

				$res = mysql_fetch_row($results);

				//R&eacute;sum&eacute; des infos du ticket pour valider l'archivage ou retourner &agrave; la gestion des tickets
				echo "<h2 class = \"champ_obligatoire\">Voulez-vous vraiment archiver ce ticket? <br />Toutes modifications ou r&eacute;ponses ult&eacute;rieures seront impossibles&nbsp;!</h2>";
				echo "<table>
					  	<tr>
						  <td class = \"etiquette\">
						  	Emetteur&nbsp;:&nbsp;
						  </td>
						  <td>&nbsp;
						  	".$res[3]."
						  </td>
						</tr>
						<tr>
						  <td class = \"etiquette\">
						  	Intervenant&nbsp;:&nbsp;
						  </td>
						  <td>&nbsp;
						  	".$res[10]."
						  </td>
						</tr>
						<tr>
						  <td class = \"etiquette\">
							Date de cr&eacute;ation&nbsp;:&nbsp;
						  </td>
						  <td>&nbsp;
						  	".$res[7]."
						  </td>
						</tr>
						<tr>
						  <td class = \"etiquette\">
						  	Date de derni&egrave;re modification&nbsp;:&nbsp;
						  </td>
						  <td>&nbsp;
						  	".$res[8]."
						  </td>
						</tr>
						<tr>
						  <td class = \"etiquette\">
						  	Sujet&nbsp;:&nbsp;
						  </td>
						  <td>&nbsp;
						  	".$res[5]."
						  </td>
						</tr>
					  </table>
					  <a href = \"confirm_archiver_ticket.php?a_chercher=$a_chercher&amp;ou=$ou&amp;id_categ=$id_categ&amp;tri=$tri&amp;idpb=".$idpb."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/oui.png\" ALT = \"oui\" border = \"0\"></a>";
					 switch ($origine)
				   {
              case 'gestion_ticket':
                echo "&nbsp;<a href = ".$origine.".php><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/non.png\" ALT = \"Non\" border = \"0\"></a>";
				      break;
         
              case 'gestion_categories':
                echo "&nbsp;<a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/non.png\" ALT = \"Non\" border = \"0\"></a>";
				      break;
				    
				      case 'fouille':
                echo "&nbsp;<a href = ".$origine.".php><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/non.png\" ALT = \"Non\" border = \"0\"></a>";
				      break;
           }
				//Fermeture de la connexion &agrave; la BDD	    	
				mysql_close();
			?>
		</div>
	</body>
</html>
