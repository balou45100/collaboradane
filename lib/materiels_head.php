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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");

	$autorisation_gestion_materiels = verif_appartenance_groupe(8);
		echo "<table style = \"border: 0\">";
		//echo "<COL WIDTH=91>";
		//echo "<COL WIDTH=91>";

			echo "<tr>";
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Appel &agrave; materiels_gestion_structure.php /////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if ($autorisation_gestion_materiels == "O")
				{
					echo "<td>";
					echo "<form action = \"materiels_gestion_structure.php\" target = \"body\" METHOD = \"GET\">";
						echo "<select size=\"1\" name=\"traitement\">";
							echo "<option value=\"traitement_cat_princ\">cat&eacute;gories</option>";
							echo "<option value=\"traitement_affectation\">affectations</option>";
							echo "<option value=\"traitement_origine\">propri&eacute;taires</option>";
						echo "</select>";

						echo "&nbsp;<input type = \"submit\" VALUE = \">>\">
						<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
						<!--INPUT TYPE = \"hidden\" VALUE = \"action\" NAME = \"filtre\"-->
						<input type = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
						<input type = \"hidden\" VALUE = \"O\" NAME = \"actions_structurelles\">
						<input type = \"hidden\" VALUE = \"ID\" NAME = \"tri\">
						<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">";
					echo "</form>";
					echo "</td>";
					echo "<td>&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;</td>";
				}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel &agrave; materiels_gestion_structure.php /////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// appel &agrave; materiels_gestion.php, 1er traitement ///////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo "<td>";
				echo "<form action = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
					//Choix des filtres
					$requete_materiels="SELECT DISTINCT intitule_cat_princ FROM materiels_categories_principales ORDER BY intitule_cat_princ";
					$result=mysql_query($requete_materiels);
					$num_rows = mysql_num_rows($result);
					echo "Cat&eacute;gorie&nbsp;:&nbsp;<select size=\"1\" name=\"filtre\">";
					if (mysql_num_rows($result))
					{
						echo "<option selected value=\"T\">Tous</option>";
						while ($ligne=mysql_fetch_object($result))
						{
							$intitule=$ligne->intitule_cat_princ;
							echo "<option value=\"$intitule\">$intitule</option>";
						}
					}
					echo "</select>"; 
				echo "</td>";
				echo "<td>";
					echo "&nbsp;&eacute;tat&nbsp;:&nbsp;"; 
						echo "<select size=\"1\" name=\"etat\">";
							echo "<option value=\"0\">tous</option>";
							echo "<option value=\"1\">demand&eacute;</option>";
							echo "<option value=\"2\">command&eacute;</option>";
							echo "<option value=\"3\">livr&eacute;</option>";
							echo "<option value=\"4\">en pr&eacute;paration</option>";
							echo "<option value=\"5\">disponible</option>";
							echo "<option value=\"6\">affect&eacute; (int)</option>";
							echo "<option value=\"7\">affect&eacute; (ext)</option>";
							echo "<option value=\"8\">en pr&ecirc;t</option>";
							echo "<option value=\"9\">en panne</option>";
							echo "<option value=\"10\">remis&eacute;</option>";
							echo "<option value=\"11\">perdu</option>";
							echo "<option value=\"12\">&agrave; &eacute;diter</option>";
						echo "</select>";
						echo "&nbsp;<input type = \"submit\" VALUE = \">>\">
							<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<input type = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<input type = \"hidden\" VALUE = \"ID\" NAME = \"tri\">";
					echo "</form>";
				echo "</td>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel &agrave; materiels_gestion.php ///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;&nbsp;</td>";
				echo "<td>&nbsp;&nbsp;</td>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// appel &agrave; materiels_gestion.php, 2e traitement ////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo "<td>";
					echo "<form action = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
						
						//Choix des filtres
						$requete_materiels="SELECT DISTINCT intitule_affectation FROM materiels_affectations ORDER BY intitule_affectation";
						$result=mysql_query($requete_materiels);
						$num_rows = mysql_num_rows($result);
						echo "Affectation&nbsp;:&nbsp;<select size=\"1\" name=\"affectation_materiel\">";
						if (mysql_num_rows($result))
						{
							echo "<option selected value=\"T\">Tous</option>";
							while ($ligne=mysql_fetch_object($result))
							{
								$intitule=$ligne->intitule_affectation;
								if ($intitule <>"r&eacute;serve &agrave; d&eacute;terminer")
								{
									echo "<option value=\"$intitule\">$intitule</option>";
								}
							}
						}
						echo "</select>"; 
						echo "&nbsp;<input type = \"submit\" VALUE = \">>\">
							<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<input type = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<input type = \"hidden\" VALUE = \"affectation\" NAME = \"filtre\">
							<input type = \"hidden\" VALUE = \"T\" NAME = \"etat\">
							<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<input type = \"hidden\" VALUE = \"ID\" NAME = \"tri\">";
					echo "</form>";
				echo "</td>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel &agrave; materiels_gestion.php, 2e traitement ////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;&nbsp;</td>";
				echo "<td>&nbsp;&nbsp;</td>";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// appel &agrave; materiels_gestion.php, 3e traitement ////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo "<td>";
					echo "<form action = \"materiels_gestion.php\" target = \"body\" METHOD = \"GET\">";
						
						//Choix des filtres
						$requete_origine="SELECT DISTINCT intitule_origine FROM materiels_origine ORDER BY intitule_origine";
						$result=mysql_query($requete_origine);
						$num_rows = mysql_num_rows($result);
						echo "Propri&eacute;taire&nbsp;:&nbsp;<select size=\"1\" name=\"origine_materiel\">";
						if (mysql_num_rows($result))
						{
							//echo "<option selected value=\"T\">Tous</option>";
							while ($ligne=mysql_fetch_object($result))
							{
								$intitule=$ligne->intitule_origine;
								echo "<option value=\"$intitule\">$intitule</option>";
							}
						}
						echo "</select>"; 
							echo "&nbsp;<input type = \"submit\" VALUE = \">>\">
							<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<input type = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
							<input type = \"hidden\" VALUE = \"origine\" NAME = \"filtre\">
							<input type = \"hidden\" VALUE = \"T\" NAME = \"etat\">
							<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<input type = \"hidden\" VALUE = \"ID\" NAME = \"tri\">";
					echo "</form>";
				echo "</td>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel &agrave; materiels_gestion.php, 3e traitement ////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
			echo "</tr>";
		echo "</table>";
?>
		</div>
	</body>
</html>

