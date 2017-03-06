<?php
	session_start();
/*
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
*/
	//Inclusion des fichiers nécessaires
	@include ("../biblio/config.php");
	@include ("../biblio/init.php");
?>

<!DOCTYPE HTML>

<?php
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

	echo "</head>

	<body>
	<h2>Saisie d'une r&eacute;union &eacute;tape 1</h2>
	<!--p><center>Veuillez compl&eacute;ter le formulaire suivant en remplissant tout les champs: </center></p-->";

	echo "<form method=\"post\" action=\"om_saisie_reunion_etape2.php\">";

	//echo "<div align=\"left\">Date d'arriv&eacute;e&nbsp;:&nbsp;<input type=\"text\" id=\"date_arrive1\"  name=\"date_arrive\" value=\"\">";
	//echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_arrive1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
					
?>
	<table>
		<tr>
			<!--td colspan=3><h3>Informations g&eacute;n&eacute;rales</h3></td>
		</tr-->
			<td>Intitul&eacute;&nbsp;:</td>
			<td><input type="text" id="intitule"  name="intitule" value="" size = "50"></td>
		</tr>
		<tr>
			<td>Description&nbsp;:</td>
			<td><TEXTAREA NAME="description" ROWS="5" COLS="38"></TEXTAREA></td>
		</tr>
		<tr>
			<td>Date du d&eacute;but&nbsp;:&nbsp;<!--p><br />(format: JJ-MM-AAAA)</p--></td>
			<td>
				<input type="text" id="datedebut"  name="datedebut" value="">
				<!--input type="text" name="datedebut" size="50"-->
<?php
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datedebut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
?>
			</td>
		</tr>
		<tr>
			<td>Heure du d&eacute;but&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
			<td><input type="text" name="heuredebut" size="10"></td>
		</tr>
		<tr>
			<td>Date de fin&nbsp;:&nbsp;<!--p><br>(format: JJ-MM-AAAA)</p--></td>
			<td>
				<!--input type="text" name="datefin" size="50"-->
				<input type="text" id="datefin"  name="datefin" value="">
<?php
				echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datefin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
?>
			</td>
		</tr>
		<tr>
			<td>Heure de fin&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
			<td><input type="text" name="heurefin" size="10"></td>
		</tr>
		<!--tr>
			<td>Intitul&eacute; de la mission&nbsp;:</td>
			<td><TEXTAREA NAME="description" ROWS="5" COLS="38"></TEXTAREA></td>
		</tr-->
		<!--tr>
			<td align = center colspan=3><input type=submit name="Suivant" value="&Eacute;tape suivante&nbsp;>>>"/></td>
		</tr-->
	</table>
		
<?php
	echo "<table class = \"menu-boutons\">";
		echo "<tr>";
			echo "<td>";
				echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
			echo "</td>";
			echo "<td>";
				echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer la r&eacute;union</span><br />";
			echo "</TD>";
		echo "</tr>";
	echo "</table>";
	//echo "<input type=hidden name=\"Suivant\" value=\"XX\"/>";
	echo "<input type=hidden name=\"etape\" value=\"2\"/>";
	echo "<input type=hidden name=\"action\" value=\"O\"/>";
?>
</form>
</div>
</body>
</html>
