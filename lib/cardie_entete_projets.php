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
	
		//include("../biblio/ticket.css");
		include ("../biblio/cardie_config.php");
		include ("../biblio/init.php");
		include ("../biblio/fct.php");

	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";

	$util_connecte = $_SESSION['nom'];
	$res=mysql_query ("SELECT DISTINCT id_categ, intitule_categ FROM categorie_commune ORDER BY intitule_categ");
	$nbr = mysql_num_rows($res);
	//echo "<br />nbr : $nbr";

	//On vérifie les droits
	$autorisation_cardie = verif_appartenance_groupe(31);
	$niveau_droits = verif_droits("Cardie");


	echo "<form action = \"cardie_gestion_projets.php\" target = \"body\" METHOD = \"GET\">";
		echo "<table style = \"border: 0\">";
			echo "<tr>";
				echo "<td>";
					echo "&nbsp;<b>D&eacute;cision de la commision&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"decision_commission\">";
							echo "<option value=\"T\" class = \"bleu\">tous les projets</option>";
							echo "<option value=\"NOUV\">nouveaux sans d&eacute;cision</option>";
							echo "<option value=\"RETENU\" class = \"bleu\">retenus</option>";
							echo "<option value=\"POURSUITE\">poursuite</option>";
							echo "<option value=\"RETPOUR\" class = \"bleu\">retenus et pousuite</option>";
							echo "<option value=\"AUTONOME\">autonome</option>";
						echo "</select>";
				echo "</td>";

				echo "<td>";
					echo "&nbsp;<b>Type d'accompagnement&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"type_accompagnement\">";
							echo "<option value=\"T\" class = \"bleu\">tous types</option>";
							echo "<option value=\"NON_DEFINI\">non d&eacute;fini</option>";
							echo "<option value=\"INSITU\">in situ</option>";
							echo "<option value=\"A_DISTANCE\" class = \"bleu\">&agrave; distance</option>";
							echo "<option value=\"RECHERCHE\">par la recherche</option>";
							echo "<option value=\"GROUPE_DEVELOPPEMENT\">par groupe de d&eacute;veloppement</option>";
							echo "<option value=\"EXPERITHEQUE\" class = \"bleu\">dans exp&eacute;rith&egrave;que</option>";
							echo "<option value=\"PARTENARIAL\" class = \"bleu\">partenarial</option>";
						echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<b>&Eacute;tat du projet&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"etat_projet\">";
							echo "<option selected value=\"O\" class = \"bleu\">actif</option>";
							echo "<option value=\"N\">archiv&eacute;</option>";
						echo "</select>";
				echo "</td>";

				if ($niveau_droits == '3')
				{
					echo "<td>";
						echo "&nbsp;&nbsp;&nbsp;mes projets uniquement&nbsp;:&nbsp;";
						echo "<input type=\"checkbox\" name=\"mes_projets\" value=\"O\" size=\"4\" />";
					echo "</td>";
				}
				echo "<td>";
					echo "&nbsp;<input type = \"submit\" value = \"Hop !\">";
					echo "<input type = \"hidden\" value = \"entete_projets\" name = \"origine_appel\">";
					echo "<input type = \"hidden\" value = \"DESC\" name = \"sense_tri\">";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
?>
		</div>
	</body>
</html>

