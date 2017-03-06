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

	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_informations_personnelles.png\" ALT = \"Titre\">";
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						//echo "<td align = \"center\">";
/*
						echo "<td>";
							echo "<h2>&nbsp;Informations personnelles&nbsp;</h2>";
						echo "</td>";
*/
						echo "<td>";
							echo "<h2>&nbsp;<a href=\"tb_preferences.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages_tableau_bord.png\" ALT = \"Pr&eacute;f&eacute;rences TB\" title = \"Pr&eacute;f&eacute;rences Tableau de bord\"></a>&nbsp;</h2>";
						echo "</td>";

						echo "<td>";
							echo "<h2>&nbsp;<a href=\"preferences_taches.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages_preferences.png\" ALT = \"Pr&eacute;f&eacute;rences T&acirc;ches\" title = \"Pr&eacute;f&eacute;rences T&acirc;ches\"></a>&nbsp;</h2>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";

			//On regarde s'il y a des actions à faire
			$action = $_GET['action'];
			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			$a_faire = $_GET['a_faire'];
			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}
			/*
			echo "<br />a_faire : $a_faire";
			echo "<br />action : $action";
			*/

			if ($action == "O")
			{
				switch ($a_faire)
				{
					case "modification_util":
						//On récupère l'identifiant de l'utilisateur à modifier
						$id_util_a_modifier = $_GET['id_util_a_modifier'];
						//echo "<h2>Il faut modifier l'utilisateur $id_util</h2>";
						include ("reglages_modification_util.inc.php");
					break;
				} //Fin switch ($a_faire)
			} //Fin if ($action == "O")
		
			if ($affichage <> "N")
			{
				//Récupération des données de l'utilisateur à modifier
				$query = "SELECT * FROM util where id_util = '".$_SESSION['id_util']."'";
				$results = mysql_query($query);
				//Dans le cas où aucun résultat n'est retourné
				if(!$results)
				{
					echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"gestion_user.php?indice=0\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
									echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
					mysql_close();
					exit;
				}
				else
				{
					//Récupération des données concernant l'utilisateur
					$res = mysql_fetch_row($results);

					//On récupère le mot de passe et l'identiçfiant de la table pour pouvoir le comparer lors de la validation du formulaire pour savoir si l'un ou l'autre a été modifié
					$password_origine = $res[2];
					$identifiant_origine = $res[18];

					//echo "<br />password_origine : $password_origine";
					//echo "<br />identifiant_origine : $identifiant_origine";

					echo "<form action = \"reglages.php\" METHOD = \"POST\">
						<table>
							<tr>
								<td class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"hidden\" VALUE =".str_replace("*", " ",$res[0])." NAME = \"prenom\">".str_replace("*", " ",$res[0])."&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"hidden\" VALUE =".strtoupper($res[1])." NAME = \"nom\" SIZE=\"40\">".strtoupper($res[1])."&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"hidden\" VALUE =".$res[3]." NAME = \"mail\" SIZE=\"40\">".$res[3]."&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Identifiant&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[18]."\" NAME = \"identifiant\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =".$res[4]." NAME = \"num_tel\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[9]."\" NAME = \"poste_tel\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Mobile professionnel&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[5]."\" NAME = \"num_tel_port\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[10]."\" NAME = \"num_tel_perso\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[14]."\" NAME = \"tel_autre\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Mobile personnel&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"text\" VALUE =\"".$res[11]."\" NAME = \"num_tel_port_perso\" SIZE=\"34\">&nbsp;</td>
							</tr>";

							echo "<tr>";
							$requete_themes="SELECT * FROM themes_interface ORDER BY id";
							$resultat_themes=mysql_query($requete_themes);
							$num_rows = mysql_num_rows($resultat_themes);
								echo "<td class = \"etiquette\">th&egrave;me choisi&nbsp;:&nbsp;</td>";
								echo "<td>&nbsp;";
									echo "<select size=\"1\" name=\"choix_theme\">";
									//On extrait les thèmes de la table themes_interface
									while ($ligne_theme_extrait=mysql_fetch_object($resultat_themes))
									{
										$intitule_theme_extrait=$ligne_theme_extrait->intitule;
										$id_theme_extrait = $ligne_theme_extrait->id;
										$remarques_theme_extrait = $ligne_theme_extrait->remarques;
										if ($id_theme_extrait == $res[17])
										{
											echo "<option selected value=\"$id_theme_extrait\">$intitule_theme_extrait ($remarques_theme_extrait)</option>";
										}
										else
										{
											echo "<option value=\"$id_theme_extrait\">$intitule_theme_extrait ($remarques_theme_extrait)</option>";
										}
									}
							echo "</tr>";

							echo "<tr>
								<td class = \"etiquette\">Mot de passe&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"password\" VALUE =".$res[2]." NAME = \"password1\" SIZE=\"34\">&nbsp;</td>
							</tr>
							<tr>
								<td class = \"etiquette\">Pour verification du Mot de passe&nbsp;:&nbsp;</td>
								<td>&nbsp;<input type=\"password\" VALUE =".$res[2]." NAME = \"password2\" SIZE=\"34\">&nbsp;</td>
							</tr>
						</table>
						<input type=\"hidden\" VALUE =\"modification_util\" NAME = \"a_faire\">
						<input type=\"hidden\" VALUE =\"O\" NAME = \"action\">
						<input type=\"hidden\" VALUE =\"$password_origine\" NAME = \"password_origine\">
						<input type=\"hidden\" VALUE =\"$identifiant_origine\" NAME = \"identifiant_origine\">";
						//echo "<input type=\"hidden\" VALUE =\"$origine\" NAME = \"origine\">";

						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "&nbsp;<INPUT border=0 src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";

					echo "</form>";
				}
/*
				echo "<br />password1 : $password1";
				echo "<br />password2 : $password2";
				echo "<br />password_origine : $password_origine";
*/
				//Fermeture de la connexion &agrave; la BDD
				mysql_close();
			} // Fin if ($affichage <> "N")
?>
		</div>
	</body>
</html>
