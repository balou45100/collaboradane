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
				echo "<form action = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
				
				echo "Filtres&nbsp;:&nbsp;
						&nbsp;&nbsp;<a href=\"repertoire_gestion.php?filtre=T&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Tous les enregistrements\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/repertoire.png\" ALT = \"Tous\" border=\"0\"></a>
						&nbsp;&nbsp;<a href=\"repertoire_gestion.php?filtre=AT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les enregistrements &agrave; traiter\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/attention.png\" ALT = \"&agrave; traiter\" border=\"0\"></a>";
				
        //Affichage des liens en fonction du statut de la personne connect&eacute;
				
        /*
        if($_SESSION['droit'] == "Super Administrateur")
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Fonctions&nbsp;:&nbsp;</b>
          	&nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></a>
            &nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A-->
            &nbsp;&nbsp;<a href = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes r&eacute;glages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"R&eacute;glages\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"gestion_user.php?indice=0\" target = \"body\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></a>
            &nbsp;&nbsp;&nbsp;<a href = \"verif_coherence_base.php?taf=verifier\" target = \"body\" class=\"bouton\" title=\"V&eacute;rification de la base de donn&eacute;es\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Coh&eacute;rence BDD\" border=\"0\"></a>
            ";
				}
				else
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Fonctions&nbsp;:&nbsp;</b>
							&nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></a>
              &nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A-->
              &nbsp;&nbsp;<a href = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes r&eacute;glages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"R&eacute;glages\" border=\"0\"></a>";
				}
				*/
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rechercher&nbsp;:&nbsp; 
				<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"dans\">";
					echo "<option value=\"T\">tout</option>";
					echo "<option value=\"S\">Soci&eacute;t&eacute;</option>";
					echo "<option value=\"V\">Ville</option>";
					echo "<option value=\"M\">M&eacute;l</option>";
				echo "</select>";
/*
				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;
				<input type = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;Tout
				<input type = \"radio\" NAME = \"dans\" VALUE = \"S\">&nbsp;Soci&eacute;t&eacute;
				<input type = \"radio\" NAME = \"dans\" VALUE = \"V\">&nbsp;Ville
				<input type = \"radio\" NAME = \"dans\" VALUE = \"M\">&nbsp;M&eacute;l
				&nbsp;&nbsp;&nbsp;";
*/
				echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Afficher\">
				<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
				<input type = \"hidden\" VALUE = \"recherche\" NAME = \"origine_gestion\">
				<input type = \"hidden\" VALUE = \"T\" NAME = \"filtre\">
				<input type = \"hidden\" VALUE = \"SO\" NAME = \"tri\">
				<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
				</form>";		
				
				//Table servant pour les filtres
				
				
			?>
		</div>
	</body>
</html>

