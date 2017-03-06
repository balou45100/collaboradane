<?php
	//Lancement de la session
	session_start();
	$id_util = $_SESSION['id_util'];
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
	echo "</head>
	<body>
		<div align = \"center\">";
			$largeur_tableau = "80%";
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");

			//Récupération des variables
			$action = $_GET['action'];
			$adresse = $_GET['adresse'];
			$intitule = $_GET['intitule'];
			//$id_util = $_GET['id_util'];
			$id_categ = $_GET ['id_categ'];
			$retour = $_GET['retour'];
			$type_favoris = $_GET['type_favoris'];
			
			/*
			echo "<br />retour : $retour";
			echo "<br />id_categ : $id_categ";
			echo "<br />intitule : $intitule";
			echo "<br />adresse : $adresse";
			echo "<br />action : $action";
			echo "<br />id_util : $id_util";
			echo "<br />id : $id";
			echo "<br />type_favoris : $type_favoris";
			echo "<br />retour : $retour";
			*/

			if ($type_favoris == "publiques")
			{
				echo "<h2>Création d'un nouveau favori publique</h2>";
			}
			else
			{
				echo "<h2>Création d'un nouveau favori priv&eacute;</h2>";
			}
			if ($intitule <> "" and $action == "O")
			{
				// On vérifie si le favori existe déjà ou non
				$verif_favori = "SELECT * FROM favoris WHERE adresse = '$adresse' AND intitule = '$intitule' AND id_categ = $id_categ;";
				$exe_verif_favori = mysql_query ($verif_favori);
				$nb = mysql_num_rows($exe_verif_favori);
				if ($nb == 1)
				{
					echo "<h2>Ce favori existe d&eacute;j&agrave; dans cette cat&eacute;gorie</h2>";
					echo "<form action = favoris_creation_favoris.php action=get>";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule size=60 maxlength=60 value= '".$intitule."'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Adresse du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=adresse size=120 maxlength=255 value='".$adresse."'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp:&nbsp;</td>";
							echo "<td>&nbsp;<select name=id_categ>";
								if ($retour == "favoris.php?type_favoris=privees")
								{
									$recup_categ_privee = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_privee";
									
									$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
									while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
										echo "<option value = $results_privee[0]>$results_privee[1]</option>";
								}
								else
								{
									$recup_categ_public = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_public";
									
									$exe_recup_categ_public = mysql_query ($recup_categ_public);
									while($results_public = mysql_fetch_array($exe_recup_categ_public))
										echo "<option value = $results_public[0]>$results_public[1]</option>";
								}
							echo"</select>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter le favori\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

				echo "</form>";
				}
				else // Sinon on ajoute ce favoris
				{
					$ajout_favori = "INSERT INTO favoris (adresse, intitule, id_categ) VALUES ('$adresse', '$intitule', $id_categ);";
					$exe_ajout_favori = mysql_query ($ajout_favori);
					if (!$exe_ajout_favori)
					{
						echo "Erreur dans la BDD";
						echo "<br>";
						echo "<a href = $retour><input type=submit value=Retour></a>";
					}
					else
					{
						$nom_categorie = "SELECT intitule_categ, id_util FROM favoris_categories WHERE id_categ = $id_categ;";
						$exe_nom_categorie = mysql_query ($nom_categorie);
						while($results_categ = mysql_fetch_array($exe_nom_categorie))
						{
							$nom_categ = $results_categ[0];
							$id_util = $results_categ[1];
						}
						if ($id_util == 0)
						{
							echo "<h2>Le favoris '$intitule' ($adresse) a &eacute;t&eacute; ajout&eacute;e avec succ&egrave;s dans la cat&eacute;gorie publique '$nom_categ'</h2>";
						}
						else
						{
							echo "<h2>Le favoris '$intitule' ($adresse) a &eacute;t&eacute; ajout&eacute;e avec succ&egrave;s dans la catégorie priv&eacute;e '$nom_categ'</h2>";
						}
						//echo "<a href = favoris_creation_favoris.php?retour=$retour><input type=submit value='Nouveau favori'></a><br><br>";
						//echo "<a href = $retour><input type=submit value=Retour></a>";
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;<a href = \"favoris_creation_favoris.php?retour=$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/favoris_ajout.png\" ALT = \"Ajout\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouveau favori</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					}
				}
			}
			elseif ($action == "O" and $intitule == "")
			{
				echo "<h2>Informations manquantes sur le favori</h2>";
				echo "<form action = favoris_creation_favoris.php action=get>";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule size=60 maxlength=60 value=$intitule></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Adresse du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=adresse size=120 maxlength=255 value=$adresse></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp:&nbsp;</td>";
							echo "<td>&nbsp;<select name=id_categ>";
								if ($retour == "favoris.php?type_favoris=privees")
								{
									$recup_categ_privee = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_privee";
									
									$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
									while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
										echo "<option value = $results_privee[0]>$results_privee[1]</option>";
								}
								else
								{
									$recup_categ_public = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_public";
									
									$exe_recup_categ_public = mysql_query ($recup_categ_public);
									while($results_public = mysql_fetch_array($exe_recup_categ_public))
										echo "<option value = $results_public[0]>$results_public[1]</option>";
								}
							echo"</select>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter le favori\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

				echo "</form>";
				//echo "<br>";
			}
			else //j'arrive pour la première fois dans la page
			{
				echo "<form action = favoris_creation_favoris.php action=get>";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule size=60 maxlength=60></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Adresse du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=adresse size=120 maxlength=255 value='http://'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp:&nbsp;</td>";
							echo "<td>&nbsp;<select name=id_categ>";
								if ($retour == "favoris.php?type_favoris=privees")
								{
									$recup_categ_privee = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_privee";
									
									$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
									while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
										echo "<option value = $results_privee[0]>$results_privee[1]</option>";
								}
								else
								{
									$recup_categ_public = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
									
									echo "<br />$recup_categ_public";
									
									$exe_recup_categ_public = mysql_query ($recup_categ_public);
									while($results_public = mysql_fetch_array($exe_recup_categ_public))
										echo "<option value = $results_public[0]>$results_public[1]</option>";
								}
							echo"</select>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";
					//echo "<input type=submit value='Ajouter le favori'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter le favori\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

				echo "</form>";
				echo "<br>";
				//echo "<a href = $retour><input type=submit value=Retour></a>";		
			}
?>
		</div>
	</body>
</html>
