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
	//Lancement de la session
	session_start();
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

		echo "<body>
		<CENTER>";
				echo "<table border = \"0\">";
					echo "<tr>";
						echo "<td>";
							echo "<FORM ACTION = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
								echo "Rechercher&nbsp;:&nbsp; 
								<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";
								echo "&nbsp;dans&nbsp;:&nbsp;"; 
									echo "<select size=\"1\" name=\"dans\">";
										echo "<option value=\"T\">tous</option>";
										echo "<option value=\"S\">nom de société</option>";
										echo "<option value=\"V\">Ville</option>";
										echo "<option value=\"M\">mél</option>";
									echo "</SELECT>";
								echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
								<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
								<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
								<INPUT TYPE = \"hidden\" VALUE = \"recherche\" NAME = \"origine_gestion\">
								<INPUT TYPE = \"hidden\" VALUE = \"T\" NAME = \"filtre\">
								<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">
								<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
							echo "</FORM>";		
						echo "<td>";

				echo "<td>&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;</td>";

						echo "<td>";
				echo "<FORM ACTION = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
					//echo "&nbsp;<B>Les &nbsp;:&nbsp;</B>";
						echo "<select size=\"1\" name=\"filtre\">";
							echo "<option value=\"FGMM\">tous les partenaires</option>";
							echo "<option value=\"FGMM_AT\">partenaires à traiter</option>";
							echo "<option value=\"FGMM_INT\">partenaires intéressés</option>";
							echo "<option value=\"FGMM_PART\">partenaires qui participent</option>";
							echo "<option value=\"FGMM_PART_LOGO\">partenaires avec logo sur affiche</option>";
						echo "</SELECT>";
						echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
						<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
						<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
						<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
						<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
						<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">";
				echo "</FORM>";
						echo "</td>";

				echo "<td>&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;</td>";

						echo "<td>";
				echo "<FORM ACTION = \"fgmm_gestion_salon.php\" target = \"body\" METHOD = \"GET\">";
					//echo "&nbsp;<B>Le salon&nbsp;:&nbsp;</B>";
						echo "<select size=\"1\" name=\"filtre\">";
							echo "<option value=\"SALON_INT\">intéressés par le salon</option>";
							echo "<option value=\"SALON_PART\">participants au salon</option>";
						echo "</SELECT>";
						echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
						<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
						<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
						<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
						<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
						<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">";
				echo "</FORM>";
						echo "</td>";

						echo "<td>&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;</td>";

						echo "<td>";
				echo "<FORM ACTION = \"fgmm_gestion_lots.php\" target = \"body\" METHOD = \"GET\">";
					//echo "&nbsp;<B>Les lots&nbsp;:&nbsp;</B>";
						echo "<select size=\"1\" name=\"filtre\">";
							echo "<option value=\"LOT\">Tous les lots</option>";
							echo "<option value=\"LM\">lots matériel</option>";
							echo "<option value=\"LP\">lots promis</option>";
							echo "<option value=\"LR\">lots reçus</option>";
						echo "</SELECT>";
						echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
						<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
						<!--INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\"-->
						<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
						<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
						<INPUT TYPE = \"hidden\" VALUE = \"ID\" NAME = \"tri\">";
				echo "</FORM>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";

/*
				echo "<B>Filtres&nbsp;:&nbsp;</B>
						&nbsp;&nbsp;<A href=\"repertoire_gestion.php?FGMM=O&amp;filtre=FGMM&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires du Festival des Génies du Multimédia\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie.png\" ALT = \"Partenaires FGMM\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?FGMM=O&amp;filtre=FGMM_AT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires du Festival des Génies du Multimédia à traiter\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie_a_traiter.png\" ALT = \"Partenaires FGMM à traiter\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?FGMM=O&amp;filtre=FGMM_INT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires du Festival des Génies du Multimédia intéressés\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie_interesse.png\" ALT = \"intéressés\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?FGMM=O&amp;filtre=FGMM_PART&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires du Festival des Génies du Multimédia participants\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie_participant.png\" ALT = \"participants\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_lots.php?filtre=LOT&amp;indice=0&amp;tri=ID&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les lots\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/lot.png\" ALT = \"Lots\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_lots.php?filtre=LM&amp;indice=0&amp;tri=ID&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les lots sous forme de matériel\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/lot_materiel.png\" ALT = \"Lots (Matériels)\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_lots.php?filtre=LP&amp;indice=0&amp;tri=ID&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les lots promis\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/lot_promis.png\" ALT = \"Lots promis\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_lots.php?filtre=LR&amp;indice=0&amp;tri=ID&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les lots reçus\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/lot_recu.png\" ALT = \"Lots reçus\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_salon.php?FGMM=O&amp;filtre=SALON_INT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires intéressé pour le salon\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/salon_interesse.png\" ALT = \"Salon (intéressés)\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"fgmm_gestion_salon.php?FGMM=O&amp;filtre=SALON_PART&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires présents au salon\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/salon_presents.png\" ALT = \"Salon (présents)\" border=\"0\"></A>";
*/
		
			?>
		</CENTER>
	</body>
</html>

