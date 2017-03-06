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
		echo "<body>
		<div align = \"center\">";
				//R&eacute;cup&eacute;ration de l'identifiant concernant le ticket &agrave; supprimer
				$idpb = $_GET['idpb'];
				$id_categ = $_GET['id_categ']; //pour pouvoir repartir vers la gestion des cat&eacute;gories
				$origine = $_SESSION['origine']; //permet de savoir quel script appelle le script actuel
				$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
				$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
				$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
				//Test du champ r&eacute;cup&eacute;r&eacute;
				
				//echo "<br />origine : $origine";
				
				if(!isset($idpb) || $idpb == "")
				{
					echo "<b>Probl&egrave;mes de r&eacute;cup&eacute;ration de la variable</b>";
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

						case 'ecl_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					exit;
				}

				//Inclusion des fichiers n&eacute;cessaires	
				include("../biblio/init.php");
				//R&eacute;cup&eacute;ration des donn&eacute;es r&eacute;sumant la cat&eacute;gorie pour proc&eacute;der &agrave; sa suppression ou non
				$query = "SELECT * FROM probleme WHERE id_pb = '".$idpb."';";
				$results = mysql_query($query);
				if(!$results)
				{
					echo "<b>probl&egrave;me lors de l'execution de la requ&egrave;te</b>";
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

						case 'ecl_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					mysql_close();
					exit;
				}

				$res = mysql_fetch_row($results);
				echo "<h2>Voulez-vous vraiment supprimer ce ticket&nbsp;?<br />
				<span = \"champ_obligatoire\">Toutes les r&eacute;ponses seront aussi supprim&eacute;es&nbsp!</span></h2>";
				echo "<table width=\"95%\">";
					echo "<tr>";
						echo "<td class = \"etiquette\" width=\"10%\">N°&nbsp;:&nbsp;<b></td>";
						echo "<td width=\"10%\">&nbsp;$res[0]</b></td>";
						echo "<td class = \"etiquette\" width=\"5%\">cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
						echo "<td width=\"10%\">&nbsp;$res[3]</td>";
						echo "<td class = \"etiquette\" width=\"5%\">cr&eacute;&eacute; le&nbsp;:&nbsp;</td>";
						echo "<td width=\"10%\">&nbsp;$res[7]</td>";
						echo "<td class = \"etiquette\" width=\"10%\">Intervenants&nbsp;:&nbsp;</td>";
						echo "<td width=\"40%\">&nbsp;$res[10]</td>";

					echo "</tr>";
					echo "<tr>";
						echo "<td class = \"etiquette\">Sujet&nbsp;:&nbsp;</td>";
						echo "<td colspan=\"3\">&nbsp;$res[5]</td>";
						echo "<td class = \"etiquette\">&Eacute;tablissement&nbsp;:&nbsp;</td><td>";
							echo str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5])." ".str_replace("*", " ",$res_etab[7])." ".str_replace("*", " ",$res_etab[8]);
						echo "</td>";
					echo "</tr>";
				//echo "</table>";  
				//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
					echo "<tr>";
						echo "<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>";
						echo "<td colspan= \"5%\">&nbsp;$res[17]&nbsp;$res[19]&nbsp;$res[18]&nbsp;$res[20]&nbsp;-&nbsp;$res[21]</td>";
						echo "<td class = \"etiquette\">Type de contact&nbsp;:&nbsp;</td>";
						echo "<td>&nbsp;$res[22]</td>";
					echo "</tr>";

					echo "<tr>";
						echo "<td class = \"etiquette\">Contenu&nbsp;:&nbsp;</td>";
						echo "<td colspan=\"6\">$res[6]</td>";
					echo "</tr>";
				echo "</table>";

				//echo "<br />2 - origine : $origine";

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								switch ($origine)
								{
									case 'gestion_ticket':
										echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;
		
									case 'gestion_categories':
										echo "<a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;
	
									case 'fouille':
										echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;

									case 'repertoire_consult_fiche':
										echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;

									case 'ecl_consult_fiche':
										echo "<a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;

									case 'tb':
										echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									break;
								}
								echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
							echo "</td>";
							echo "<td>";
								echo "<a href = \"confirm_suppr_ticket.php?id_categ=$id_categ&amp;idpb=".$idpb."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></a>";
								echo "<br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				mysql_close();
?>
		</div>
	</body>
</html>
					
