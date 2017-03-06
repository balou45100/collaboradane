<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];

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
		include ("../biblio/config.php");
		include ("../biblio/fct.php");
		include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
		$largeur_tableau = "800px";
		//On r&eacute;cup&egrave;re les variables
		$action = $_GET['action'];
		$a_faire = $_GET['a_faire'];
		$bouton = $_GET['bouton'];
		
		/*
		echo "<br />action : $action";
		echo "<br />a_faire : $a_faire";
		echo "<br />bouton : $bouton";
		*/
		if ($action == 'O')
		{
			//echo "<br />Je dois faire quelque chose ...";
			switch ($a_faire)
			{
				case "enreg_preferences" :
					//echo "<br />Je dois enregistrer les pr&eacute;f&eacute;rences";
					$choix_type_tache_defaut = $_GET['choix_type_tache_defaut'];
					//echo "<br />choix_type_tache_defaut : $choix_type_tache_defaut";
					$query="UPDATE preference SET choix_type_tache_defaut ='".$choix_type_tache_defaut."'";
					$exe=mysql_query($query);
					echo "<h2>La nouvelle pr&eacute;f&eacute;rence a &eacute;t&eacute; enregistr&eacute;e</h2>";
				break;
			} //Fin switch a_faire
		} //Fin if $action == 'O'

		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<h2>&nbsp;<a href=\"reglages.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages.png\" ALT = \"Infos personnelles\" title = \"Informations personnelles\"></a>&nbsp;</h2>";
					echo "</td>";

					echo "<td>";
						echo "<h2>&nbsp;<a href=\"tb_preferences.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages_tableau_bord.png\" ALT = \"Pr&eacute;f&eacute;rences TB\" title = \"Pr&eacute;f&eacute;rences Tableau de bord\"></a>&nbsp;</h2>";
					echo "</td>";
/*
					echo "<td>";
						echo "<h2>&nbsp;Pr&eacute;f&eacute;rences pour les t&acirc;ches&nbsp;</h2>";
					echo "</td>";
*/
				echo "</tr>";
			echo "</table>";
		echo "</div>";


//		echo "<h2>Pr&eacute;f&eacute;rences pour les t&acirc;ches - <a href=\"tb_preferences.php\" class = \"bouton\">Pr&eacute;f&eacute;rences pour le tableau de bord</a> - <a href=\"reglages.php\" class = \"bouton\">Informations personnelles</a></h2>";
		// On teste s'il s'agit d'une mise &agrave; jour ou d'une insertion
		$util="SELECT * FROM preference WHERE ID_UTIL = $id;";
		$execution= mysql_query($util);
		$num_results = mysql_num_rows($execution);
		if($num_results == "1") //L'utilisateur a d&egrave;j&agrave; renseign&eacute; ses pr&eacute;f&eacute;rences
		{
			$ligne = mysql_fetch_object($execution);
			$choix_type_tache_defaut = $ligne->choix_type_tache_defaut;
			
			//echo "<br />choix_type_tache_defaut : $choix_type_tache_defaut";
			
			echo"<form method = get action= preferences_taches.php>";
			//echo "Vous pouvez ici modifier les pr&eacute;f&eacute;rences d'affichage de votre tableau de bord";
			//echo "<br />";

			echo "<table width = \"$largeur_tableau\">
				<tr>
					<th colspan=\"2\">Pr&eacute;f&eacute;rences des t&acirc;ches</th>
				</tr>
				<tr>
					<td class = \"etiquette\" width = \"50%\">Choix du type de t&acirc;che par d&eacute;faut&nbsp;:&nbsp;</td>
					<td>
						<select name=choix_type_tache_defaut>";
							if ($choix_type_tache_defaut == 'PU')
							{
								echo "<option selected value = 'PU'>public</option>";
								echo "<option value = 'PR'>priv&eacute;</option>";
							}
							else
							{
								echo "<option selected value = 'PR'>priv&eacute;</option>";
								echo "<option value = 'PU'>public</option>";
							}
						echo"</select>";
					echo "</td>
				</tr>";
			echo "</table>";
			//echo "<br />";
			echo "<input type = submit name = bouton value = Enregistrer>&nbsp;";
			//echo "<input type = submit name = bouton value = Retour>";
			echo "<input type = hidden name = action value = 'O'>";
			echo "<input type = hidden name = a_faire value = 'enreg_preferences'>";
			echo "</form>";
		} //Fin if($num_results == "1")
?>
		</div>
	</body>
</html>
