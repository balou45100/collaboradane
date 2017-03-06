<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	$type_courrier = $_GET['type_courrier'];
	
	//echo "<br />type_courrier : $type_courrier";
	
	if (!ISSET($type_courrier))
	{
		$type_courrier = $_SESSION['type_courrier'];
	}
	//$_SESSION['type_courrier'] = "sortant";
	//
	
	//echo "<br />type_courrier : $type_courrier";

echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script language=\"JavaScript\" type=\"text/javascript\">";
?>
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
		</head>
	<body>
<?php
	echo "<div align = \"center\">";
	echo "<table align = \"center\">";
		echo "<tr>";
			echo "<td>";

	if ($type_courrier == "entrant")
	{
		echo "<fieldset>";
			echo "<legend><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_entrant.png\" id=\"Image1\" title = \"Courrier entrant\" align=\"top\" border=\"0\"><b>Courrier entrant</b></legend>";
				echo "<form action=\"gc_saisie_exec.php\" method=\"post\">";
					echo "<div align=\"left\">Ann&eacute;e scolaire&nbsp;:&nbsp;<input type='text' name='annee_scolaire' value='".$annee_scolaire."' readonly></div><br />";
					//On récupère le N° du dernier courrier enregistré
					$requete = "
						SELECT count(*)
						FROM courrier
						WHERE type like 'entrant'
							AND annee_scolaire like '".$annee_scolaire."'";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							$numero_enregistrement = $ligne[0]+1;
							echo "<div align=\"left\">Num&eacute;ro d'enregistrement&nbsp;:&nbsp;<input type='text' name='num_enr' value='".$numero_enregistrement."' readonly></div><br />";
						}
					}
					echo "<div align=\"left\">Date d'arriv&eacute;e&nbsp;:&nbsp;<input type=\"text\" id=\"date_arrive1\"  name=\"date_arrive\" value=\"\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_arrive1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
					echo "</div><br />";
					echo "<div align=\"left\">Date cr&eacute;ation&nbsp;:&nbsp;<input type=\"text\" id=\"date_courrier1\"  name=\"date_courrier\" value=\"\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_courrier1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
					echo "</div><br />";
					echo "<div align=\"left\">Exp&eacute;diteur&nbsp;:&nbsp;<input type=\"text\" size = \"50\" name=\"expediteur\"></div><br />";
					echo "<div align=\"left\">Destinataire&nbsp;:&nbsp;<select name=\"destinataire\">";
					$requete = "
						SELECT nom
						FROM util
						WHERE visible = 'O'
						ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";						
						}
					}
					echo "</select></div><br />";
						echo "<div align=\"left\">Cat&eacute;gorie&nbsp;:&nbsp;<select name=\"categorie\">";
						echo"<option value = '1' >Autre</option>";
						$requete = "
							SELECT *
							FROM courrier_categorie
							ORDER BY nom";
						$resultat = mysql_query($requete);
						$num_rows = mysql_num_rows($resultat);
						if (mysql_num_rows($resultat))
						{
							while ($ligne=mysql_fetch_array($resultat))
							{
								if ($ligne[0] <> 1) // on n'affiche pas "Autre" une deuxième fois
								{
									echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
								}
							}
						}
					echo "</select></div><br />";
					echo "<div align=\"left\">Concerne&nbsp;:&nbsp;<select name=\"concerne[]\" size=\"4\" multiple>";
					$requete = "
						SELECT nom, prenom, id_util
						FROM util
						WHERE visible = 'O'
						ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";
						}
					}
					echo "</select></div><br />";
						echo "<div align=\"left\">Description&nbsp;:&nbsp;<textarea name=\"description\" rows=\"4\" cols=\"50\"></textarea></div><br />";

					echo "<div align=\"left\">Confidentiel&nbsp;:&nbsp;<select name=\"confidentiel\" size=\"1\">";
						echo"<option selected value=\"N\" >Non</option>";
						echo"<option value=\"O\" >Oui</option>";
					echo "</select>";

						echo "<div align=\"center\"><input type=\"submit\" value=\"Envoyer\" name=\"entrant\"></div>";
						echo "</form>";
					echo "</fieldset>";
				echo "</td>";
				echo "<td>";
	}
	else
	{

				echo "<fieldset>";
					echo "<legend><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png\" id=\"Image2\" title = \"Courrier sortant\" align=\"top\" border=\"0\">&nbsp;<b>Courrier sortant</b></legend>";
					echo "<form action=\"gc_saisie_exec.php\" method=\"post\">";
					echo "<div align=\"left\">Ann&eacute;e scolaire&nbsp;:&nbsp;<input type='text' name='annee_scolaire' value='".$annee_scolaire."' readonly></div><br />";
					//On récupère le N° du dernier courrier saisie
					$requete = "
						SELECT count(*)
						FROM courrier
						WHERE type like 'sortant'
							AND annee_scolaire like '".$annee_scolaire."'";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
							
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							$numero_enregistrement = $ligne[0]+1;
							echo "<div align=\"left\">Num&eacute;ro d'enregistrement&nbsp;:&nbsp;<input type='text' name='num_enr' value='".$numero_enregistrement."' readonly></div><br />";
						}
					}
					echo "<div align=\"left\">Date d'envoi&nbsp;:&nbsp;<input type=\"text\" id=\"date_arrive\"  name=\"date_arrive\" value=\"\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_arrive&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
					echo "</div><br />";
					echo "<div align=\"left\">Date r&eacute;daction du courrier&nbsp;:&nbsp;<input type=\"text\" id=\"date_courrier\"  name=\"date_courrier\" value=\"\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_courrier&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
					echo "</div><br />";
					echo "<div align=\"left\">Destinataire&nbsp;:&nbsp;<input type=\"text\" size = \"50\" name=\"destinataire\"></div><br />";
					echo "<div align=\"left\">Exp&eacute;diteur&nbsp;:&nbsp;<select name=\"expediteur\">";
					$requete = "
						SELECT nom
						FROM util
						WHERE visible = 'O'
						ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";						
						}
					}
					echo "</select></div><br />";
					echo "<div align=\"left\">Categorie&nbsp;:&nbsp;<select name=\"categorie\">";
					echo"<option value = '1' >Autre</option>";
					$requete = "
						SELECT *
						FROM courrier_categorie
						ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							if ($ligne[0] <> 1) // on n'affiche pas "Autre" une deuxième fois
							{
								echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
							}
						}
					}
					echo "</select></div><br />";
					echo "<div align=\"left\">Concerne&nbsp;:&nbsp;<select name=\"concerne[]\" size=\"4\" multiple>";
					$requete = "
						SELECT nom, prenom, id_util
						FROM util
						WHERE visible = 'O'
						ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";						
						}
					}
					echo "</select></div><br />";
					echo "<div align=\"left\">Description&nbsp;:&nbsp;<textarea name=\"description\" rows=\"4\" cols=\"50\"></textarea></div><br />";

					echo "<div align=\"left\">Confidentiel&nbsp;:&nbsp;<select name=\"confidentiel\" size=\"1\">";
						echo"<option selected value=\"N\" >Non</option>";
						echo"<option value=\"O\" >Oui</option>";
					echo "</select>";


					echo "<div align=\"center\"><input type=\"submit\" value=\"Envoyer\" name=\"sortant\"></div>";
					echo "</form>";
					echo "</fieldset>";
				echo "</td>";
			echo "</tr>";

/*
			echo "<tr>";
				echo "<td colspan=\"2\">";
				echo "<form name=\"joindre_courrier\" enctype=\"multipart/form-data\" method=\"post\" action=\"pp_piece_jointe.php\">";
			echo "<fieldset>";
			echo "<legend>Joindre courrier</legend>";
			echo "Titre du document&nbsp;:&nbsp;<input type=\"text\" value = \"\" name=\"nom_doc\" SIZE = \"50\"><br />";
			echo "Description du document&nbsp;:&nbsp;<br />";
			echo "<TEXTAREA  value = \"\" name=\"description_doc\" rows = \"4\" cols = \"50\"></TEXTAREA><br />";
			echo "Fichier à d&eacute;poser&nbsp;:&nbsp;<input type=\"file\" name=\"file\" SIZE = \"40\"><br />";
			echo "<input type='hidden' name='folder' value='".$dossier_docs_courrier."'>";
			echo "<input type=\"submit\" name=\"courrier\" value=\"Joindre le fichier\">";
			echo "</form>";
				echo "</td>";
			echo "</tr>";
*/
	}
		echo "</table>";
		echo "</div>";
?>
	</body>
</html>
