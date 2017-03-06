<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
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
	echo "<body>";
		echo "<div align = \"center\">";

		include ("../biblio/fct.php");
		include ("../biblio/config.php");
		include ("../biblio/init.php");
		$autorisation_gestion_groupes = verif_appartenance_groupe(13); 

		if($autorisation_gestion_groupes <> "1")
		{
			echo "<h1>Vous n'avez pas le droit d'accéder à ce module</h1>";
			/*
			echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
			echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
			*/
			exit;
		}

		//Gestion des traitements
		//Ajouter
		if (isset($_POST['ajouter']))
		{
			foreach ($_POST['util'] as $valeur)
			{
					$requete = "insert into util_groupes
								value(".$valeur.",".$_POST['groupe'].")";
					$resultat = mysql_query($requete);	
			}
		}
		//Retirer
		if (isset($_POST['retirer']))
		{
			foreach ($_POST['util_groupe'] as $valeur)
			{
					$requete = "delete from util_groupes
								where id_util = ".$valeur."
								and id_groupe = ".$_POST['groupe'];
					$resultat = mysql_query($requete);	
			}		
		}
?>
		<table>
			<tr>
				<td>
				<form action="gg_gestion_personnes.php" method="post">
					<select size="1" name="groupe" >
<?php
					//On prend tout les groupes
					$requete = "select *
								from groupes ORDER BY NOM_GROUPE";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							$selected = "";
							if (isset($_POST['groupe']))
							{
								if ($ligne[0] == $_POST['groupe'])
								{
								$selected=" selected";
								}
								else
								{
								$selected="";
								}
							$groupe_en_cours = $_POST['groupe'];
							}
							else
							{							
							//$groupe_en_cours = 1;
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[1]."</option>";						
						}
					}
?>
					</select>
					<input type="submit" value="Valider">
				</form>
				</td>
			</tr>
			<tr>
				<td>
				<form action="gg_gestion_personnes.php" method="post">
					<select size="10" name="util[]" multiple>
<?php
						//Selection des utilisateurs qui ne sont PAS dans le groupe actuel
					$requete = "SELECT prenom, nom, id_util 
								FROM util
								WHERE id_util not in (SELECT id_util
														FROM util_groupes
														WHERE id_groupe = ".$groupe_en_cours.") ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value=\"".$ligne[2]."\">".$ligne[0]." ".$ligne[1]."</option>";						
						}
					}
					echo "<input type='hidden' name = 'groupe' value='".$groupe_en_cours."'>";
?>
					</select>
					<input type="submit" value="- Ajouter >>" name="ajouter">
				</form>
				</td>
				<td>
				<form action="gg_gestion_personnes.php" method="post">
					<input type="submit" value="<< Retirer -" name="retirer">
					<select size="10" name="util_groupe[]" multiple>
<?php
					//Selection des utilisateurs qui ne sont PAS dans le groupe actuel
					$requete = "SELECT prenom, nom, id_util 
								FROM util
								WHERE id_util in (SELECT id_util
														FROM util_groupes
														WHERE id_groupe = ".$groupe_en_cours.") ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value=\"".$ligne[2]."\">".$ligne[0]." ".$ligne[1]."</option>";						
						}
					}
					echo "<input type='hidden' name = 'groupe' value='".$groupe_en_cours."'>";
?>
					</select>
				</form>
				</td>
			</tr>
		</table>
	</body>
</html>
