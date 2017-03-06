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
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			$action = $_GET['action'];
			$intitule_categ = $_GET['intitule_categ'];
			$id_categ = $_GET['id_categ'];
			$id_util = $_GET['id_util'];
			$retour = $_GET['retour'];
			$type_favoris = $_GET['type_favoris'];

			/*
			echo "<br />favoris_creation_categorie - retour : $retour";
			echo "<br />favoris_creation_categorie - intitule_categ : $intitule_categ";
			echo "<br />favoris_creation_categorie - id_util : $id_util";
			echo "<br />type_favoris : $type_favoris";
			*/

			if ($action <> "O")
			{
				$recup_categ = "SELECT intitule_categ, id_util FROM favoris_categories WHERE id_categ = '".$id_categ."';";
				$exe_recup_categ = mysql_query ($recup_categ);
				while ($results_recup_categ = mysql_fetch_row ($exe_recup_categ))
				{
					$intitule_categ = $results_recup_categ[0];
					$id_util = $results_recup_categ[1];
				}
				if ($type_favoris == "publiques")
				{
					echo "<h2>Suppression de la cat&eacute;gorie publique '$intitule_categ'</h2>";
				}
				else
				{
					echo "<h2>Suppression de la cat&eacute;gorie priv&eacute;e '$intitule_categ'</h2>";
				}
				$affichage_infos_categ = "SELECT * FROM favoris_categories WHERE id_categ = '".$id_categ."'";
				$exe_affichage_infos_categ = mysql_query ($affichage_infos_categ);
				while ($results_infos_categ = mysql_fetch_row ($exe_affichage_infos_categ))
				{
					$intitule_categ = $results_infos_categ[1];
					$id_util = $results_infos_categ[2];
				}
				if ($id_util == 0)
				{
					$type = "Publique";
				}
				else
				{
					$type = "Privée";
				}
				echo "<h2>Attention la cat&eacute;gorie et tous les favoris appertenant &agrave; cette cat&eacute;gorie seront supprim&eacute;s&nbsp!</h2>";
				echo "<form action = favoris_suppr_categ_fav.php?id_categ=$id_categ action=get>";
					echo "<input type = hidden name = action value = O>";
					echo "<input type = hidden name = intitule_categ value = '$intitule_categ'>";
					echo "<input type = hidden name = id_categ value = $id_categ>";
					echo "<input type = hidden name = id_util value = $id_util>";
					echo "<input type = hidden name = retour value = $retour>";
					echo"<input type =hidden name=type_favoris value=$type_favoris>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<Td>";
									echo "<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"Valider\" title=\"Supprimer la cat&eacute;gorie et les favoris\" border=\"0\" type=image Value= \"Supprimer la categorie et les favoris\" submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

				echo "</form>";
			}
			else
			{
				// Sinon on supprime cette catégorie
				$requete_supp_cat = "DELETE FROM favoris_categories WHERE id_categ = $id_categ";
				$exec_requete_supp_cat = mysql_query($requete_supp_cat);
				//echo "<br />requete : $requete_supp_cat";
				if (!$exec_requete_supp_cat)
				{
					echo "<br />Erreur !";
				}
				else
				{
					//On supprime les favoris appertenant à cette catégorie
					$requete_supp_fav = "DELETE FROM favoris WHERE id_categ = $id_categ";
					$exec_requete_supp_fav = mysql_query($requete_supp_fav);
					if ($type_favoris == "publiques")
					{
						echo "<h2>La cat&eacute;gorie publique '$intitule_categ' et les favoris inscits dans cette cat&eacute; ont &eacute;t&eacute; supprim&eacute;s avec succ&egrave;s</h2>";
					}
					else
					{
						echo "<h2>La cat&eacute;gorie priv&eacute;e '$intitule_categ' et les favoris inscits dans cette cat&eacute; ont &eacute;t&eacute; supprim&eacute;s avec succ&egrave;s</h2>";
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
?>
</center>
</body>
</html>
