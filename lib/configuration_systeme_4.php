<?php
	//Lancement de la session
	session_start();

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
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_configuration_systeme.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");

			echo "<h2>Configuration des boutons du fichier repertoire_consult_fiche </h2>";

			//Vérification des droits pour pouvoir intervenir sur la configuration
			$droit_configuration_systeme = verif_droits("configuration_systeme");

			if ($droit_configuration_systeme == 3)
			{
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_1.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_1.png\" title = \"Configuration de base\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration de base&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_2.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_2.png\" title = \"Configuration dossiers de stockage\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Dossiers stockage&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_3.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_3.png\" title = \"Configuration des modules\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration modules&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_32.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_3.png\" title = \"Configuration module OM\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration module OM&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_5.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_5.png\" title = \"Configuration taille des ic&ocirc;nes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Taille ic&ocirc;nes&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_6.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_6.png\" title = \"Configuration listes d&eacute;roulantes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Listes d&eacute;roulantes&nbsp;";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

				$action = $_POST['action'];
				
				if ($action == "O")
				{
					$bt_salon = $_POST['bt_salon'];
					$bt_manifestation = $_POST['bt_manifestation'];
					$bt_partenaire = $_POST['bt_partenaire'];
					$bt_participant = $_POST['bt_participant'];

					//On enregistre les modifications
					$req_maj = "UPDATE configuration_systeme SET
						`bt_salon` = '".$bt_salon."',
						`bt_manifestation` = '".$bt_manifestation."',
						`bt_partenaire` = '".$bt_partenaire."',
						`bt_participant` = '".$bt_participant."'
						";
						
					$result_maj = mysql_query($req_maj);
					if (!$result_maj)
					{
						echo "<h2>Erreur lors de l'enregistrement</h2>";
					}
					else
					{
						echo "<h2>La fiche a bien &eacute;t&eacute; modifi&eacute;e</h2>";
					}
				} // Fin action

				//On se connecte à la table configuration_systeme pour récupérer les différentes variables
				$req_conf_systeme = "SELECT * FROM configuration_systeme";
				$res_req_conf_systeme = mysql_query($req_conf_systeme);
				$ligne = mysql_fetch_object($res_req_conf_systeme);

				echo "<form action = \"configuration_systeme_4.php\" METHOD = \"POST\">";
					echo "<table>";
						echo "<tr>
							<td class = \"etiquette\">Bouton <<&nbsp;salon&nbsp;>>&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_salon\" NAME = \"bt_salon\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Bouton <<&nbsp;manifestation&nbsp;>>&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_manifestation\" NAME = \"bt_manifestation\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Bouton <<&nbsp;partenaires&nbsp;>>&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_partenaire\" NAME = \"bt_partenaire\" SIZE=\"70\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Bouton <<&nbsp;participants&nbsp;>>&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->bt_participant\" NAME = \"bt_participant\" SIZE=\"70\"></td>
						</tr>";
					echo "</table>";

					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
							echo "</TD>";
						echo "</tr>";
					echo "</table>";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
					echo "<INPUT TYPE = \"hidden\" VALUE = \"1\" NAME = \"domaine\">";

				echo "</FORM>";
			} //Fin vérif droits
			else
			{
				echo "<h1>Vous n'avez pas les droits pour intervenir sur la configuration de l'espace</h1>";
			}
	echo "</div>";
?>
