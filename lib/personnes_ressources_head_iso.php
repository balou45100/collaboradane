<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	//header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php

	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
			include ("../biblio/init.php");
			include ("../biblio/config.php");
			echo "<form action = \"personnes_ressources_gestion.php\" target = \"body\" METHOD = \"GET\">";

			//Choix de l'ann&eacute;e
			$anne_scolaire_a_afficher_par_defaut = $annee_en_cours+1;
			echo "&nbsp;&nbsp;Ann&eacute;e&nbsp;:&nbsp;<select size=\"1\" name=\"annee\">
			<option selected value=\"$annee_en_cours\">$annee_en_cours-$anne_scolaire_a_afficher_par_defaut</option>
				<option value=\"%\">toutes</option>";
				for($annee = $annee_en_cours-1; $annee >2002; $annee-- )
				{
					$annee2=$annee+1;
					echo "<option value=\"$annee\">$annee-$annee2</option>";
				}
				echo "<option value=\"1995\">avant 2003</option>";
			echo "</select>";
			echo "&nbsp;&nbsp;";

			//Choix de la fonction      
			$requeteliste_fonction="SELECT DISTINCT fonction FROM fonctions_des_personnes_ressources ORDER BY fonction ASC";
			$result=mysql_query($requeteliste_fonction);
			$num_rows = mysql_num_rows($result);

			echo "Fonction&nbsp;:&nbsp;<select size=\"1\" name=\"intitule_fonction\">";

			if (mysql_num_rows($result))
			{
				echo "<option selected value=\"T\">toutes</option>";
				while ($ligne=mysql_fetch_object($result))
				{
					$intitule_fonction=$ligne->fonction;
					echo "<option value=\"$intitule_fonction\">$intitule_fonction</option>";
				}
			}
			echo "</select>"; 

			//Choix du champs acad&eacute;mique ou d&eacute;partemental
			echo "&nbsp;&nbsp;D&eacute;p.&nbsp;:&nbsp;<select size=\"1\" name=\"dep\">
			<option selected value=\"T\">tous</option>
				<option value=\"18\">Cher (18)</option>
				<option value=\"28\">Eure-et-Loire (28)</option>
				<option value=\"36\">Indre (36)</option>
				<option value=\"37\">Indre-et-Loire (37)</option>
				<option value=\"41\">Loir-et-Cher (41)</option>
				<option value=\"45\">Loiret (45)</option>
			</select>";

			//Champ pour une recherche avec entr&eacute;e libre
			echo "&nbsp;&nbsp;D&eacute;tail&nbsp;:&nbsp; 
			<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"dans\">";
					//echo "<option value=\"T\">tout</option>";
					echo "<option value=\"T\">&nbsp;</option>";
					echo "<OPTGROUP LABEL=\"pour la personne\">";
						echo "<option value=\"N\">Nom</option>";
						echo "<option value=\"P\">Pr&eacute;nom</option>";
						echo "<option value=\"NP\">Nom et pr&eacute;nom</option>";
						echo "<option value=\"M\">M&eacute;l</option>";
			    	echo "</OPTGROUP>";
					echo "<OPTGROUP LABEL=\"ECL\">";
						echo "<option value=\"RNE\">RNE</option>";
						echo "<option value=\"V\">Ville</option>";
			    	echo "</OPTGROUP>";
				echo "</select>";
				echo "&nbsp;&nbsp;&nbsp;en liste&nbsp;:&nbsp;";
				echo "<input type=\"checkbox\" name=\"en_liste\" value=\"Oui\" size=\"4\" />";
				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
				echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Hop !\">
				</form>";
			?>
		</div>
	</body>
</html>

