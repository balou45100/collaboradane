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
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_configuration_systeme.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");

			echo "<h2>Configuration du syst&egrave;me - R&eacute;glages de bases</h2>";

			//Vérification des droits pour pouvoir intervenir sur la configuration
			$droit_configuration_systeme = verif_droits("configuration_systeme");

			if ($droit_configuration_systeme == 3)
			{
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
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
							echo "<a href=\"configuration_systeme_4.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_4.png\" title = \"Configuration boutons fichier repertoire_consult_fiche\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Boutons fichier repertoire_consult_fiche&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_5.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_5.png\" title = \"Configuration taille des ic&ocirc;nes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Taille ic&ocirc;nes&nbsp;";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_6.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_6.png\" title = \"Configuration listes d&eacute;roulantes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Listes d&eacute;roulantes&nbsp;";
						echo "</td>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

				$action = $_POST['action'];
				
				//echo "<br />action : $action";
				
				if ($action == "O")
				{
					$nom_espace = $_POST['nom_espace'];
					$description_espace = $_POST['description_espace'];
					$version = $_POST['version'];
					$version_date = $_POST['version_date'];
					$logo1 = $_POST['logo1'];
					$logo2 = $_POST['logo2'];
					$logo2 = $_POST['logo2'];
					$image_connexion = $_POST['image_connexion'];
					$chemin_images = $_POST['chemin_images'];
					$annee_en_cours = $_POST['annee_en_cours'];
					$annee_scolaire = $_POST['annee_scolaire'];
					$annee_RT = $_POST['annee_RT'];
					$adresse_collaboratice = $_POST['adresse_collaboratice'];
					$dossier_lib_adresse_absolu = $_POST['dossier_lib_adresse_absolu'];
					$message_non_connecte1 = $_POST['message_non_connecte1'];
					$message_non_connecte2 = $_POST['message_non_connecte2'];
					$intitule_structure_support = $_POST['intitule_structure_support'];
					$intitule_service = $_POST['intitule_service'];
					$adresse_service_rue = $_POST['adresse_service_rue'];
					$adresse_service_cp = $_POST['adresse_service_cp'];
					$adresse_service_ville = $_POST['adresse_service_ville'];
					$adresse_service_cedex = $_POST['adresse_service_cedex'];
					$dan = $_POST['dan'];

					//On enregistre les modifications
					$req_maj = "UPDATE configuration_systeme SET
						`nom_espace` = '".$nom_espace."',
						`description_espace` = '".$description_espace."',
						`version` = '".$version."',
						`version_date` = '".$version_date."',
						`logo1` = '".$logo1."',
						`logo2` = '".$logo2."',
						`image_connexion` = '".$image_connexion."',
						`chemin_images` = '".$chemin_images."',
						`annee_en_cours` = '".$annee_en_cours."',
						`annee_scolaire` = '".$annee_scolaire."',
						`annee_RT` = '".$annee_RT."',
						`adresse_collaboratice` = '".$adresse_collaboratice."',
						`dossier_lib_adresse_absolu` = '".$dossier_lib_adresse_absolu."',
						`message_non_connecte1` = '".$message_non_connecte1."',
						`message_non_connecte2` = '".$message_non_connecte2."',
						`intitule_structure_support` = '".$intitule_structure_support."',
						`intitule_service` = '".$intitule_service."',
						`adresse_service_rue` = '".$adresse_service_rue."',
						`adresse_service_cp` = '".$adresse_service_cp."',
						`adresse_service_ville` = '".$adresse_service_ville."',
						`adresse_service_cedex` = '".$adresse_service_cedex."',
						`dan` = '".$dan."'
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

				//On se connecte à la table configuration_systeme pour récupérer les différentes variables
				$req_conf_systeme = "SELECT * FROM configuration_systeme";
				$res_req_conf_systeme = mysql_query($req_conf_systeme);
				$ligne = mysql_fetch_object($res_req_conf_systeme);

				echo "<form action = \"configuration_systeme_1.php\" METHOD = \"POST\">";
					echo "<table>";
						echo "<tr>
							<td class = \"etiquette\">Nom de l'espace&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->nom_espace\" NAME = \"nom_espace\" SIZE=\"20\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Description de l'espace&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->description_espace\" NAME = \"description_espace\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Version&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->version\" NAME = \"version\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Date derni&egrave;re mise &agrave; jour (AAAA-MM-JJ)&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" ID = \"date_version\" VALUE = \"$ligne->version_date\" NAME = \"version_date\" SIZE=\"10\">
							<!--a href=\"javascript:popupwnd('calendrier.php?idcible=version_date&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\"></a--></td>

						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Logo 1&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->logo1\" NAME = \"logo1\" SIZE=\"20\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/$ligne->logo1\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Logo 2&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->logo2\" NAME = \"logo2\" SIZE=\"20\"><img height=\"$ligne->hauteur_icone_favoris\" width=\"$ligne->largeur_icone_favoris\" src = \"$chemin_theme_images/$ligne->logo2\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\"></td>
						</tr>";

						$chemin_image_connexion = $ligne->chemin_images.$ligne->image_connexion;
						//echo "<br />$chemin_image_connexion";
						
						echo "<tr>
							<td class = \"etiquette\">Image de connexion&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->image_connexion\" NAME = \"image_connexion\" SIZE=\"20\"><img height=\"$ligne->hauteur_icone_favoris\" width=\"ligne->$largeur_icone_favoris\" src = \"$chemin_image_connexion\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Chemin des images&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE =\"$ligne->chemin_images\" NAME = \"chemin_images\" SIZE=\"20\"></td>
						</tr>";
						
						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e en cours&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_en_cours\" NAME = \"annee_en_cours\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e scolaire&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_scolaire\" NAME = \"annee_scolaire\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Ann&eacute;e Rencontres&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->annee_RT\" NAME = \"annee_RT\" SIZE=\"10\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse espace&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->adresse_collaboratice\" NAME = \"adresse_collaboratice\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse absolu dossier /lib/&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dossier_lib_adresse_absolu\" NAME = \"dossier_lib_adresse_absolu\" SIZE=\"40\"></td>
						</tr>";
						echo "<tr>
							<td class = \"etiquette\">Intitul&eacute; de la structure de support&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->intitule_structure_support\" NAME = \"intitule_structure_support\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Intitul&eacute; du service&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->intitule_service\" NAME = \"intitule_service\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Adresse du service&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->adresse_service_rue\" NAME = \"adresse_service_rue\" SIZE=\"50\"></td>
						</tr>";
						
						echo "<tr>
							<td class = \"etiquette\">Code postal du service&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->adresse_service_cp\" NAME = \"adresse_service_cp\" SIZE=\"50\"></td>
						</tr>";
						
						echo "<tr>
							<td class = \"etiquette\">Ville du service&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->adresse_service_ville\" NAME = \"adresse_service_ville\" SIZE=\"50\"></td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Nom du responsable&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type=\"text\" VALUE = \"$ligne->dan\" NAME = \"dan\" SIZE=\"50\"></td>
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
