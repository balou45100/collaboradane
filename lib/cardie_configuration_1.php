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
<!DOCTYPE html>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
		<script language="JavaScript" type="text/javascript">
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>

<?php
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_cardie_configuration.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");

			echo "<h2>Configuration de l'espace CARDIE</h2>";

			//Vérification des droits pour pouvoir intervenir sur la configuration
			$droit_cardie_configuration = verif_droits("Cardie");

			if ($droit_cardie_configuration == 3)
			{
/*
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "<a href=\"cardie_configuration_2.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_configuration_2.png\" title = \"Configuration dossiers de stockage\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Dossiers stockage&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"cardie_configuration_3.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_configuration_3.png\" title = \"Configuration des modules\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration modules&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"cardie_configuration_4.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_configuration_4.png\" title = \"Configuration boutons fichier repertoire_consult_fiche\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Boutons fichier repertoire_consult_fiche&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"cardie_configuration_5.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_configuration_5.png\" title = \"Configuration taille des ic&ocirc;nes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Taille ic&ocirc;nes&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"cardie_configuration_6.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_configuration_6.png\" title = \"Configuration listes d&eacute;roulantes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Listes d&eacute;roulantes&nbsp;";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
*/
				$action = $_POST['action'];
				
				//echo "<br />action : $action";
				
				if ($action == "O")
				{
					$nom_espace = $_POST['nom_espace'];
					$description_espace = $_POST['description_espace'];
					$annee_en_cours = $_POST['annee_en_cours'];
					$annee_scolaire = $_POST['annee_scolaire'];
					$cardie_dispositif_formation = $_POST['cardie_dispositif_formation'];
					$cardie_module_formation = $_POST['cardie_module_formation'];
					$cardie_mel_fonctionnelle = $_POST['cardie_mel_fonctionnelle'];
					$dafop_mel_fonctionnelle = $_POST['dafop_mel_fonctionnelle'];

					
					//On enregistre les modifications
					$req_maj = "UPDATE cardie_configuration SET
						`nom_espace` = '".$nom_espace."',
						`description_espace` = '".$description_espace."',
						`annee_en_cours` = '".$annee_en_cours."',
						`annee_scolaire` = '".$annee_scolaire."',
						`cardie_dispositif_formation` = '".$cardie_dispositif_formation."',
						`cardie_module_formation` = '".$cardie_module_formation."',
						`cardie_mel_fonctionnelle` = '".$cardie_mel_fonctionnelle."',
						`dafop_mel_fonctionnelle` = '".$dafop_mel_fonctionnelle."'
						";
						
					//echo "<br />requete : $req_maj";
						
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

				//On se connecte à la table cardie_configuration pour récupérer les différentes variables
				$req_conf_systeme = "SELECT * FROM cardie_configuration";
				$res_req_conf_systeme = mysql_query($req_conf_systeme);
				$ligne = mysql_fetch_object($res_req_conf_systeme);

				echo "<form action = \"cardie_configuration_1.php\" METHOD = \"POST\">";
					echo "<table>";
						echo "<tr>
							<td class = \"etiquette\">Nom de l'espace&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->nom_espace\" NAME = \"nom_espace\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Description de l'espace&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->description_espace\" NAME = \"description_espace\" SIZE=\"40\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e en cours&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_en_cours\" NAME = \"annee_en_cours\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e scolaire&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_scolaire\" NAME = \"annee_scolaire\" SIZE=\"10\"></td>
						</tr>";
/*
						echo "<tr>";
							echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations Module CARDIE</td>";
						echo "</tr>";
*/
						echo "<tr>
							<td class = \"etiquette\">Dispositif de formation&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_dispositif_formation\" NAME = \"cardie_dispositif_formation\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Module de formation&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_module_formation\" NAME = \"cardie_module_formation\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse(s) &eacute;lectronique(s) de la CARDIE&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->cardie_mel_fonctionnelle\" NAME = \"cardie_mel_fonctionnelle\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse(s) &eacute;lectronique(s) de la DAFOP&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dafop_mel_fonctionnelle\" NAME = \"dafop_mel_fonctionnelle\" SIZE=\"50\"></td>
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

				echo "</FORM>";
			} //Fin vérif droits
			else
			{
				echo "<h1>Vous n'avez pas les droits pour intervenir sur la configuration de l'espace</h1>";
			}
	echo "</div>";
?>
