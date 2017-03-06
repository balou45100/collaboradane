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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>
	<body>
		<div align = \"center\">";
			$largeur_tableau = "80%";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
			$action = $_GET['action'];
			$intitule_categ = $_GET['intitule_categ'];
			$id_categ = $_GET['id_categ'];
			$intitule_fav = $_GET['intitule_fav'];
			$id_fav = $_GET['id_fav'];
			$id_util = $_GET['id_util'];
			$retour = $_GET['retour'];
			/*
			echo "<br />retour = $retour";
			echo "<br />action = $action";
			echo "<br />id_categ : $id_categ";
			echo "<br />intitule_categ : $intitule_categ";
			echo "<br />id_fav : $id_fav";
			echo "<br />intitule_fav : $intitule_fav";
			*/
			if ($action <> "O")
			{
				$recup_fav = "SELECT intitule, adresse, favoris.id_categ, intitule_categ, id_util FROM favoris_categories, favoris WHERE favoris_categories.id_categ = favoris.id_categ AND id_favori = $id_fav;";
				$exe_recup_fav = mysql_query ($recup_fav);
				while ($results_recup_fav = mysql_fetch_row ($exe_recup_fav))
				{
					$intitule_fav = $results_recup_fav[0];
					$adresse_fav = $results_recup_fav[1];
					$intitule_categ = $results_recup_fav[3];
					$id_util = $results_recup_fav[4];
				}
				if ($id_util == 0)
				{
					echo "<h2>Suppression du favori '$intitule_fav' de la catégorie publique '$intitule_categ'</h2>";
				}
				else
				{
					echo "<h2>Suppression du favori '$intitule_fav' de la catégorie privée '$intitule_categ'</h2>";
				}
				echo "<form action = favoris_suppr_fav.php?id_fav=$id_fav action=get>";
					//echo "<table id = \"tablefavoris\">";
					echo "<table>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Intitul&eacute; du favori&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;$intitule_fav</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Adresse&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;$adresse_fav</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</td>";
							echo "<td>&nbsp;$intitule_categ</td>";
						echo "</tr>";
					echo "</table>";
					echo "<input type = hidden name = action value = O>";
					echo "<input type = hidden name = id_util value = $id_util>";
					echo "<input type = hidden name = intitule_categ value = '$intitule_categ'>";
					echo "<input type = hidden name = intitule_fav value = '$intitule_fav'>";
					echo "<input type = hidden name = id_fav value = '$id_fav'>";
					echo "<input type = hidden name = retour value = $retour>";
					//echo "<br><br>";
					//echo "<input type = submit value = 'Confirmer la supprimession du favori'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<Td>";
									echo "<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"Valider\" title=\"Supprimer la cat&eacute;gorie et les favoris\" border=\"0\" type=image Value= \"Confirmer la supprimession du favori\" submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

				echo "</form>";
				//echo "<br>";
				//echo "<a href = $retour><input type = submit value = Retour></a>";	
			}
			else
			{
				// Sinon on supprime ce favori
				$requete_supp_fav = "DELETE FROM favoris WHERE id_favori = $id_fav";
				$exec_requete_supp_fav = mysql_query($requete_supp_fav);
				//echo "<br />requete : $requete_supp_cat";
				if (!$exec_requete_supp_fav)
				{
					echo "<br />Erreur !";
				}
				else
				{
					if ($id_util == 0)
					{
						echo "<h2>Le favori '$intitule_fav' de la cat&eacute;gorie publique '$intitule_categ' a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s</h2>";
					}
					else
					{
						echo "<h2>Le favori '$intitule_fav' de la cat&eacute;gorie priv&eacute;e '$intitule_categ' a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s</h2>";
					}
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

				//echo "<a href = $retour><input type=submit value=Retour></a>";
			}
			//Fin d'insertion du code
?>
		</div>
	</body>
</html>
