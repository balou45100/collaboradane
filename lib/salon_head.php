<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
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
						//echo "&nbsp;<B>Les partenaires&nbsp;:&nbsp;</B>";
							echo "<select size=\"1\" name=\"filtre\">";
								echo "<option value=\"RT2008\">tous les partenaires</option>";
								echo "<option value=\"RT2008_AT\">partenaires à traiter</option>";
								echo "<option value=\"RT2008_INT\">partenaires intéressés</option>";
								echo "<option value=\"RT2008_PART\">partenaires qui participent</option>";
								echo "<option value=\"LOGO\">Logo sur affiche</option>";
							echo "</SELECT>";
							echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
							<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
							<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
							<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">";
					echo "</FORM>";
				echo "</td>";

				echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";

				echo "<td>";
					echo "<FORM ACTION = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
						//echo "&nbsp;<B>Le salon&nbsp;:&nbsp;</B>";
							echo "<select size=\"1\" name=\"filtre\">";
								echo "<option value=\"SALON_INT\">partenaires intéressés par le salon</option>";
								echo "<option value=\"SALON_PART\">partenaires participant au salon</option>";
								echo "<option value=\"AGORA_INT\">partenaires intéressés par l'agora</option>";
								echo "<option value=\"AGORA_PART\">partenaires intervenant sur l'agora</option>";
							echo "</SELECT>";
							echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
							<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
							<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
							<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">";
					echo "</FORM>";
				echo "</td>";

				echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
/*
				echo "<td>";
					echo "<FORM ACTION = \"repertoire_gestion.php\" target = \"body\" METHOD = \"GET\">";
						//echo "&nbsp;<B>L'agora&nbsp;:&nbsp;</B>";
							echo "<select size=\"1\" name=\"filtre\">";
								echo "<option value=\"AGORA_INT\">partenaires intéressés par l'agora</option>";
								echo "<option value=\"AGORA_PART\">partenaires intervenant sur l'agora</option>";
							echo "</SELECT>";
							echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"Hop !\">
							<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"RT2008\">
							<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<INPUT TYPE = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
							<INPUT TYPE = \"hidden\" VALUE = \"SO\" NAME = \"tri\">";
					echo "</FORM>";
				echo "</td>";
*/
			echo "</tr>";
		echo "</table>";
/*
				echo "<B>Filtres&nbsp;:&nbsp;</B>
						&nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=RT2008&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Tous les partenaires des Rencontres TICE 2008\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008.png\" ALT = \"Partenaires RT2008\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=RT2008_AT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires des Rencontres TICE 2008 à traiter\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008_a_traiter.png\" ALT = \"Partenaires RT2008 à traiter\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=RT2008_INT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires des Rencontres TICE 2008 intéressés\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008_interesse.png\" ALT = \"Partenaires RT2008 intéressés\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=RT2008_PART&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires des Rencontres TICE 2008 participants\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008_participant.png\" ALT = \"Partenaires RT2008 participants\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=AGORA_INT&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires intéressé pour l'agora\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/agora_interesse.png\" ALT = \"Agora (intéressés)\" border=\"0\"></A>
            &nbsp;&nbsp;<A href=\"repertoire_gestion.php?RT2008=O&amp;filtre=AGORA_PART&amp;indice=0&amp;tri=SO&amp;sense_tri=ASC&amp;origine_gestion=filtre\" target = \"body\" class=\"bouton\" title=\"Les partenaires présents à l'agora\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/agora_present.png\" ALT = \"Agora (présents)\" border=\"0\"></A>";
*/
			?>
		</CENTER>
	</body>
</html>

