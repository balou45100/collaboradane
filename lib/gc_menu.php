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
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
?>
<!DOCTYPE HTML>

<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
	
	echo "</head>
	<body class = \"menu-boutons\">
		<div align = \"center\">";

	include ("../biblio/init.php");
	echo "<form action = \"gc_recherche.php\" target = \"zone_travail\" METHOD = \"POST\">";
	
	//Choix des filtres      
	
	echo "Type&nbsp;:&nbsp;<select size=\"1\" name=\"type_courrier\">";
		echo "<option selected value=\"entrant\">Entrant</option>";
			echo "<option value=\"sortant\">Sortant</option>";
			//echo "<option value=\"%\">Entrant et sortant</option>";
		echo "</select>";

	echo "&nbsp;&nbsp;Ann&eacute;e  scolaire&nbsp;:&nbsp;";
		echo "<select size=\"1\" name=\"annee_scolaire_filtree\" >";
			echo "<option value=\"$annee_scolaire\">$annee_scolaire</option>";
			echo "<option value=\"T\">toutes</option>";
			$requete = "
				SELECT distinct annee_scolaire
				FROM courrier
				ORDER by 1 DESC";

			$resultat = mysql_query($requete);
			$num_rows = mysql_num_rows($resultat);

			if (mysql_num_rows($resultat))
			{	
				while ($ligne=mysql_fetch_array($resultat))
				{	
					if ($ligne[0] <> $annee_scolaire)
					{
						echo"<option value=\"".$ligne[0]."\">".$ligne[0]."</option>";
					}
				}
			}
		echo "</select>";

		echo "&nbsp;&nbsp;Mois&nbsp;:&nbsp;";
			echo "<select size=\"1\" name=\"mois\" >";
				echo "<option value=\"\">Choisir un mois</option>";
				echo "<option value=\"1\">Janvier</option>";
				echo "<option value=\"2\">F&eacute;vrier</option>";
				echo "<option value=\"3\">Mars</option>";
				echo "<option value=\"4\">Avril</option>";
				echo "<option value=\"5\">Mai</option>";
				echo "<option value=\"6\">Juin</option>";
				echo "<option value=\"7\">Juillet</option>";
				echo "<option value=\"8\">Ao&ucirc;t</option>";
				echo "<option value=\"9\">Septembre</option>";
				echo "<option value=\"10\">Octobre</option>";
				echo "<option value=\"11\">Novembre</option>";
				echo "<option value=\"12\">D&eacute;cembre</option>";
			echo "</select>";

			echo "&nbsp;&nbsp;Cat&eacute;gorie&nbsp;:&nbsp;";
				$requete = "
					SELECT *
					FROM courrier_categorie
					ORDER BY nom";
				//echo "<br />$requete";

				$resultat = mysql_query($requete);
				$num_rows = mysql_num_rows($resultat);

			echo "<select name=\"categorie\">";
				echo "<option value=''>Choisir une cat&eacute;gorie</option>";
				if (mysql_num_rows($resultat))
				{	
					while ($ligne=mysql_fetch_array($resultat))
					{
						echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
					}
				}
			echo "</select>";
			echo "<br />";

			echo "&nbsp;&nbsp;Exp&eacute;diteur/trice&nbsp;:&nbsp;";
			echo "<select size=\"1\" name=\"expediteur\">";
				echo "<option value=\"\">Choisir un exp&eacute;diteur / une exp&eacute;ditrice</option>";
					//recherche du destinataire
					if (isset($_POST['type']) and $_POST['type']!='')
					{
						//Si le type de courrier &agrave; d&eacute;j&agrave; &eacute;t&eacute; selectionn&eacute;, on dit que l'on veux que les destinataire donc le courrier est entrant
						$complement=" where type like '".$_POST['type']."'";
					}
					else
					{
						$complement="";
					}
					$requete = "
						SELECT DISTINCT expediteur
						FROM courrier".$complement."
						ORDER BY expediteur";

					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);

					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
							//"Mise en m&eacute;moire" du choix
							if (isset($_POST['expediteur']) AND $ligne[0]==$_POST['expediteur'])
							{
								$selected=" selected";
							}
							else
							{
								$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}
				echo "</select>";

				echo "&nbsp;&nbsp;Destinataire/trice&nbsp;:&nbsp;";
					$requete = "
						SELECT DISTINCT destinataire
						FROM courrier
						ORDER BY destinataire";

						//echo "<br />$requete"; WHERE type LIKE '".$type_courrier."'

					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
				echo "<select size=\"1\" name=\"destinataire\">";
					echo "<option value=\"\">Choisir un destinataire / une destinatrice</option>";

					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
							//"Mise en m&eacute;moire" du choix
							if (isset($_POST['destinataire']) AND $ligne[0]==$_POST['destinataire'])
							{
								$selected=" selected";
							}
							else
							{
								$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";
						}
					}
				echo "</select>";
				//Champ pour une recherche avec entr&eacute;e libre
				echo "<br /><center>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D&eacute;tail (dans exp&eacute;diteur, destinataire, description)&nbsp;:&nbsp; 

				<input type = \"text\" VALUE = \"\" NAME = \"a_rechercher\" SIZE = \"30\">";

				echo "<input type = \"hidden\" NAME = \"menu\" VALUE = \"O\">";
				echo "<input type = \"hidden\" NAME = \"entete\" VALUE = \"0\">";
				echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Afficher les courriers selon les filtres ci-dessus\">";
				echo "</center>";
				echo "</form>";
?>
		</div>
	</body>
</html>

