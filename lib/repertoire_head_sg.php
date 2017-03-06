<!DOCTYPE HTML>

<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');

	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></center>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}

	$theme = $_SESSION['theme'];

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
				echo "<FORM ACTION = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
				
				echo "<B><FONT COLOR=\"#808080\">Filtres&nbsp;:&nbsp;</FONT></B>
						&nbsp;&nbsp;<A href=\"repertoire_gestion.php?filtre=T&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Tous les enregistrements\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/repertoire.png\" ALT = \"Tous\" border=\"0\"></A>
						&nbsp;&nbsp;<A href=\"repertoire_gestion.php?filtre=AT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les enregistrements à traiter\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/attention.png\" ALT = \"à traiter\" border=\"0\"></A>";
				
        //Affichage des liens en fonction du statut de la personne connecté
				
        /*
        if($_SESSION['droit'] == "Super Administrateur")
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR=\"#808080\">Fonctions&nbsp;:&nbsp;</FONT></B>
          	&nbsp;&nbsp;<A HREF = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></A>
            &nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Catégories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>
            &nbsp;&nbsp;<A HREF = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A-->
            &nbsp;&nbsp;<A HREF = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes réglages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Réglages\" border=\"0\"></A>
            &nbsp;&nbsp;<A HREF = \"gestion_user.php?indice=0\" target = \"body\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></A>
            &nbsp;&nbsp;&nbsp;<A HREF = \"verif_coherence_base.php?taf=verifier\" target = \"body\" class=\"bouton\" title=\"Vérification de la base de données\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Cohérence BDD\" border=\"0\"></A>
            ";
				}
				else
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR=\"#808080\">Fonctions&nbsp;:&nbsp;</FONT></B>
							&nbsp;&nbsp;<A HREF = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></A>
              &nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Catégories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>
              &nbsp;&nbsp;<A HREF = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A-->
              &nbsp;&nbsp;<A HREF = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes réglages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Réglages\" border=\"0\"></A>";
				}
				*/
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">Rechercher&nbsp;:&nbsp;</FONT> 
				<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

				echo "&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">dans&nbsp;:&nbsp;</FONT>";
				echo "<select size=\"1\" name=\"dans\">";
					echo "<option value=\"T\">tout</option>";
					echo "<option value=\"S\">Soci&eacute;t&eacute;</option>";
					echo "<option value=\"V\">Ville</option>";
					echo "<option value=\"M\">M&eacute;l</option>";
				echo "</SELECT>";
/*
				echo "&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">dans&nbsp;:&nbsp;</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;<FONT COLOR=\"#808080\">Tout</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"S\">&nbsp;<FONT COLOR=\"#808080\">Société</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"V\">&nbsp;<FONT COLOR=\"#808080\">Ville</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"M\">&nbsp;<FONT COLOR=\"#808080\">Mél</FONT>
				&nbsp;&nbsp;&nbsp;";
*/
				echo "&nbsp;&nbsp;&nbsp;<INPUT TYPE = \"submit\" VALUE = \"Afficher\">
				<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
				<INPUT TYPE = \"hidden\" VALUE = \"recherche\" NAME = \"origine_gestion\">
				<INPUT TYPE = \"hidden\" VALUE = \"T\" NAME = \"filtre\">
				<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">
				<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
				</FORM>";		
				
				//Table servant pour les filtres
				
				
			?>
		</div>
	</body>
</html>

