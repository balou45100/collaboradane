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
			$action = $_GET['action'];
			$intitule_categ = $_GET['intitule_categ'];
			$id_util = $_SESSION['id_util'];
			$retour = $_GET['retour'];
			$type_favoris = $_GET['type_favoris'];

			/*
			echo "<br />favoris_creation_categorie - retour : $retour";
			echo "<br />favoris_creation_categorie - intitule_categ : $intitule_categ";
			echo "<br />favoris_creation_categorie - id_util : $id_util";
			echo "<br />type_favoris : $type_favoris";
			*/
			if ($type_favoris == "publiques")
			{
				echo "<h2>Création d'une nouvelle cat&eacute;gorie publique</h2>";
			}
			else
			{
				echo "<h2>Création d'une nouvelle cat&eacute;gorie priv&eacute;e</h2>";
			}
			//echo "<h2>Cr&eacute;ation d'une nouvelle cat&eacute;gorie</h2>";
			if ($intitule_categ <> "" and $action == "O")
			{
				if ($type_favoris == "publiques")
				{
					$id_util_a_verifier = "0";
				}
				else
				{
					$id_util_a_verifier = $id_util;
				}
				// On vérifie si la catégorie existe déjà ou non
				$verif_categ = "SELECT * FROM favoris_categories WHERE intitule_categ = '$intitule_categ' AND id_util = $id_util_a_verifier;";
				$exe_verif_categ = mysql_query ($verif_categ);
				$nb = mysql_num_rows ($exe_verif_categ);
				if ($nb == 1)
				{
					echo "<h2>La cat&eacute;gorie $intitule_categ existe d&eacute;j&agrave, choisissez un autre intitul&eacute;</h2>";
					echo "<form action = favoris_creation_categorie.php action=get>";
					echo "<table id = \tablefavoris\">";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value=></td>";
						echo "</tr>";
					echo "</table>";
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";
					echo"<input type =hidden name=type_favoris value=$type_favoris>";
					//echo "<input type=submit value='Ajouter la catégorie'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter la catégorie'\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

					echo "</form>";
					//echo "<a href = $retour><input type=submit value=Retour></a>";
				}
				else
				// Sinon on ajoute cette catégorie
				{
					//echo "<br />retour : $retour";
					if ($retour == "favoris.php?type_favoris=publiques")
					{
						//echo "<br />J'ajoute en public ...";
						$ajout_categ = "INSERT INTO favoris_categories (intitule_categ,id_util) VALUES ('$intitule_categ', '0');";
					}
					else
					{
						//echo "<br />J'ajoute en priv&eacute; ...";
						$ajout_categ = "INSERT INTO favoris_categories (intitule_categ,id_util) VALUES ('$intitule_categ', $id_util);";
					}
					$exe_ajout_categ = mysql_query ($ajout_categ);
					if (!$exe_ajout_categ)
					{
						echo "Erreur dans la BDD";
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					//echo "<a href = $retour><input type=submit value=Retour></a>";
					}
					else
					{
						if ($type_favoris == "publiques")
						{
							echo "<h2>La cat&eacute;gorie publique '$intitule_categ' a &eacute;t&eacute; ajout&eacute;e avec succ&egrave;s</h2>";
						}
						else
						{
							echo "<h2>La cat&eacute;gorie priv&eacute;e '$intitule_categ' a &eacute;t&eacute; ajout&eacute;e avec succ&egrave;s</h2>";
						}
						//echo "<a href = favoris_creation_categorie.php?retour=$retour><input type=submit value='Nouvelle cat&eacute;gorie'></a><br><br>";
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;<a href = favoris_creation_categorie.php?retour=$retour&amp;type_favoris=$type_favoris><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/favoris_categorie_ajout.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter une cat&eacute;gorie</span><br />";
									echo "</TD>";
							echo "</tr>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
						//echo "<a href = $retour><input type = submit value = Retour></a>";
					}
				}
			}
			else
			{
				if ($action == "O" and $intitule_categ == "")
				{
					echo "<h2>Vous n'avez pas renseign&eacute; le nom de la cat&eacute;gorie</h2>";
					echo "<form action = favoris_creation_categorie.php action=get>";
					echo "<table id = \tablefavoris\">";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value=></td>";
						echo "</tr>";
					echo "</table>";

					//echo "Nom de la cat&eacutegorie&nbsp;:&nbsp;<input name=intitule_categ size=60 maxlength=60 value=><br><br>";
					/*
					echo "Type	<select name=id_util>
						<option value = 0> Publique </option>
						<option value = $id> Privée </option></select><br><br>";
					*/
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";
					echo"<input type =hidden name=type_favoris value=$type_favoris>";
					//echo "<input type=submit value='Ajouter la cat&eacute;gorie'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter la catégorie'\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

					echo "</form>";
					echo "<br>";
					//echo "<a href = favoris.php><input type=submit value=Retour></a>";		
				}
				else
				{
					echo "<form action = favoris_creation_categorie.php action=get>";
					echo "<table id = \tablefavoris\">";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value=></td>";
						echo "</tr>";
					echo "</table>";

					//echo "Nom de la cat&eacute;gorie&nbsp;:&nbsp;<input name=intitule_categ size=60 maxlength=60 value=><br><br>";
					/*
					echo "Type	<select name=id_util>
						<option value = 0> Publique </option>
						<option value = $id> Privée </option></select><br><br>";
					*/
					echo"<input type =hidden name=action value=O>";
					echo"<input type =hidden name=retour value=$retour>";
					echo"<input type =hidden name=type_favoris value=$type_favoris>";
					//echo "<input type=submit value='Ajouter la catégorie'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Ajouter la catégorie'\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

					echo "</form>";
					//echo "<br>";
					//echo "<a href = $retour<input type=submit value=Retour></a>";		
				}
			}
			//echo "<br>";
			//echo "<a href = $retour<input type=submit value=Retour></a>";		
?>
		</div>
	</body>
</html>
