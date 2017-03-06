<?php
	//Lancement de la session
	session_start();
	$id_util = $_SESSION['id_util'];
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
	$id_util = $_SESSION['id_util'];
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>
	<body>
		<div align = \"center\">";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			$action = $_GET['action'];
			$intitule_categ = $_GET['intitule_categ'];
			//$id_util = $_GET['id_util'];
			$id_categ = $_GET['id_categ'];
			$id_type_categ = $_GET['id_type_categ'];
			$retour = $_GET['retour'];
			$type_favoris = $_GET['type_favoris'];

			$largeur_tableau = "50%";

			if ($type_favoris == "publiques")
			{
				$type = "Publique";
			}
			else
			{
				$type = "Privée";
			}
			/*
			echo "<br />action = $action";
			echo "<br />retour : $retour";
			echo "<br />intitule_categ : $intitule_categ";
			echo "<br />id_util : $id_util";
			echo "<br />type_favoris : $type_favoris";
			echo "<br />id_type_categ : $id_type_categ";
			echo "<br />id : $id";
			echo "<br />1 - type : $type";
			echo "<br />id_categ : $id_categ";
			*/

			if ($intitule_categ == "" and $action == "O")
			{
				echo "<h2>Vous n'avez pas renseign&eacute; le nom de la cat&eacute;gorie</h2>";
				echo "<form action = favoris_modif_categ_fav.php?id_categ=$id_categ action=get>";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value=></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Type</td>";
							echo "<td><select name=id_type_categ>";
								$donnees = $type;
								test_option_select ($donnees,"Publique","0");
								test_option_select ($donnees,"Privée","1");
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo "<input type = hidden name = action value = O>";
					echo "<input type = hidden name = id_categ value = $id_categ>";
					echo "<input type = hidden name = retour value = $retour>";
					echo "<input type = hidden name = type_favoris value = $type_favoris>";
					echo "<input type = submit value = 'Ajouter la cat&eacute;gorie'>";
				echo "</form>";
				echo "<br>";
				echo "<a href = $retour><input type=submit value=Retour></a>";
			}
			else
			{
				if ($action <> "O")
				{
					$recup_categ = "SELECT intitule_categ, id_util FROM favoris_categories WHERE id_categ = '".$id_categ."';";
					$exe_recup_categ = mysql_query($recup_categ);
					while ($results_recup_categ = mysql_fetch_row($exe_recup_categ))
					{
						$intitule_categ = $results_recup_categ[0];
						$id_util = $results_recup_categ[1];
					}
					if ($type_favoris == "publiques")
					{
						echo "<h2>Modification de la catégorie publique '$intitule_categ'</h2>";
					}
					else
					{
						echo "<h2>Modification de la catégorie privée '$intitule_categ'</h2>";
					}
					$affichage_infos_categ = "SELECT * FROM favoris_categories WHERE id_categ = '".$id_categ."'";
					$exe_affichage_infos_categ = mysql_query ($affichage_infos_categ);
					while ($results_infos_categ = mysql_fetch_row ($exe_affichage_infos_categ))
					{
						$intitule_categ = $results_infos_categ[1];
						$id_util = $results_infos_categ[2];
					}
					echo "<form action = favoris_modif_categ_fav.php?id_categ=$id_categ action=get>";
						echo "<table>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
								echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value='$intitule_categ'></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Type&nbsp;:&nbsp;</td>";
								echo "<td><select name=id_type_categ>";
									$donnees = $type;
									test_option_select ($donnees,"Publique","0");
									test_option_select ($donnees,"Privée","1");
								echo "</td>";
							echo "</tr>";
						echo "</table>";

						echo "<INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";
						echo "<input type = hidden name = action value = O>";
						echo "<input type = hidden name = id_categ value = $id_categ>";
						echo "<input type = hidden name = retour value = $retour>";
						echo"<input type =hidden name=type_favoris value=$type_favoris>";

						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Modifier la categorie''\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";

					echo "</form>";
				}
				else
				{
					if ($id_type_categ == "0")
					{
						$id_util_a_rechercher = "0";
					}
					else
					{
						$id_util_a_rechercher = $id_util;
					}
					$verif_categ = "SELECT * FROM favoris_categories WHERE intitule_categ = '$intitule_categ' AND id_util = $id_util_a_rechercher;";
					$exe_verif_categ = mysql_query ($verif_categ);
					$nb = mysql_num_rows ($exe_verif_categ);
					if ($nb == 1)
					{
						echo "<h2>Cette catégorie existe d&eacute;j&agrave;</h2>";
						echo "<form action = favoris_modif_categ_fav.php?id_categ=$id_categ action=get>";
						echo "<table>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Nom de la cat&eacute;gorie&nbsp;:&nbsp;</td>";
								echo "<td>&nbsp;<input name=intitule_categ size=60 maxlength=60 value='$intitule_categ'></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Type&nbsp;:&nbsp;</td>";
									echo "<td><select name=id_type_categ>";
										$donnees = $type;
										test_option_select ($donnees,"Publique","0");
										test_option_select ($donnees,"Privée","1");
									echo"</select>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
						echo "<input type = hidden name=action value=O>";
						echo "<input type = hidden name = id_categ value = $id_categ>";
						echo "<input type = hidden name = retour value = $retour>";
						echo "<input type =hidden name=type_favoris value=$type_favoris>";

						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Modifier la categorie''\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";

						echo "</form>";
					}
					else
						// Sinon on mets à jour cette catégorie
					{
						if ($id_type_categ == "0")
						{
							$id_util_a_enregistrer = "0";
						}
						else
						{
							$id_util_a_enregistrer = $id_util;
						}
						$maj_categ_fav = "UPDATE favoris_categories SET intitule_categ = '$intitule_categ', id_util='".$id_util_a_enregistrer."' WHERE id_categ = '".$id_categ."';";
						$exe_maj_categ_fav = mysql_query ($maj_categ_fav);
						if (!$exe_maj_categ_fav)
						{
							echo "<br /><strong>Erreur dans la BDD</strong>";
							echo "<br>";
							echo "<a href = $retour><input type=submit value=Retour></a>";
						}
						else
						{
							if ($type_favoris == "publiques")
							{
								echo "<h2>La cat&eacute;gorie publique '$intitule_categ' a &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s</h2>";
							}
							else
							{
								echo "<h2>La cat&eacute;gorie priv&eacute;e '$intitule_categ' a &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s</h2>";
							}
							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</div>";
						}
					}
				}
			}
?>
		</div>
	</body>
</html>
