<?php
	//Lancement de la session
	session_start();

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
	include ("../biblio/config.php");

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
				echo "<form action = \"contacts_gestion.php\" target = \"body\" METHOD = \"GET\">";
				
				echo "Filtres&nbsp;:&nbsp;";
					echo "&nbsp;&nbsp;<a href=\"contacts_gestion.php?filtre=T&amp;indice=0&amp;tri=NOM&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Tous les contacts publics\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts.png\" ALT = \"Tous les contacts publics\" border=\"0\"></a>";
					echo "&nbsp;&nbsp;<a href=\"contacts_gestion.php?filtre=MC&amp;indice=0&amp;tri=NOM&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Mes contacts seulement\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/mes_contacts.png\" ALT = \"Mes contacts\" border=\"0\"></a>";
					echo "&nbsp;&nbsp;<a href=\"contacts_gestion.php?filtre=AC&amp;indice=0&amp;tri=NOM&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Tous les contacts &agrave; contacter\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/a_contacter.png\" ALT = \"Tous les contacts &agrave; contacter\" border=\"0\"></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rechercher&nbsp;:&nbsp; 
				<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"dans\">";
					echo "<option value=\"T\">tout</option>";
					echo "<option value=\"N\">Nom</option>";
					echo "<option value=\"V\">Ville</option>";
					echo "<option value=\"M\">M&eacute;l</option>";
					echo "<option value=\"ENTITE\">d'une entit&eacute;</option>";
				echo "</select>";
/*
				
				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;
				<input type = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;Tout
				<input type = \"radio\" NAME = \"dans\" VALUE = \"N\">&nbsp;Nom
				<input type = \"radio\" NAME = \"dans\" VALUE = \"V\">&nbsp;Ville
				<input type = \"radio\" NAME = \"dans\" VALUE = \"M\">&nbsp;M&eacute;l
				<input type = \"radio\" NAME = \"dans\" VALUE = \"ENTITE\">&nbsp;d'une entit&eacute;
				&nbsp;&nbsp;&nbsp;
*/
        echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Afficher\">
        <input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
        <input type = \"hidden\" VALUE = \"recherche\" NAME = \"origine_gestion\">
        <input type = \"hidden\" VALUE = \"T\" NAME = \"filtre\">
        <input type = \"hidden\" VALUE = \"NOM\" NAME = \"tri\">
        <input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
				</form>";
				
				//Table servant pour les filtres
				
				
			?>
		</center>
	</body>
</html>

