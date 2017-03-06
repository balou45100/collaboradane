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

			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<h2>&nbsp;<a href=\"reglages.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages.png\" ALT = \"Infos personnelles\" title = \"Informations personnelles\"></a>&nbsp;</h2>";
						echo "</td>";
/*
						echo "<td>";
							echo "<h2>&nbsp;Pr&eacute;f&eacute;rences pour le tableau de bord&nbsp;</h2>";
						echo "</td>";
*/
						echo "<td>";
							echo "<h2>&nbsp;<a href=\"preferences_taches.php\" class = \"bouton\"><img src=\"$chemin_theme_images/reglages_preferences.png\" ALT = \"Pr&eacute;f&eacute;rences T&acirc;ches\" title = \"Pr&eacute;f&eacute;rences T&acirc;ches\"></a>&nbsp;</h2>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";

			$autorisation_gestion_materiels = verif_appartenance_groupe(8);
			//echo "<h2>Pr&eacute;f&eacute;rences pour le tableau de bord - <a href=\"reglages.php\" class = \"bouton\">Informations personnelles - <a href=\"preferences_taches.php\" class = \"bouton\">Pr&eacute;f&eacute;rences pour les t&acirc;ches</a></a></h2>";
			// On teste s'il s'agit d'une mise &agrave; jour ou d'une insertion
			$util="SELECT * FROM preference WHERE ID_UTIL = $id;";
			$execution= mysql_query($util);
			$num_results = mysql_num_rows($execution);
			if($num_results == "1") //L'utilisateur a d&egrave;j&agrave; renseign&eacute; ses pr&eacute;f&eacute;rences
			{
				while($donnees=mysql_fetch_array($execution))
				{
					// Affectation des donn&eacute;es r&eacute;cup&eacute;r&eacute;es dans des variables
					// Pour les tickets
					if ($donnees['tri_tick']== "1")
					{
						$tri_tick="Priorit&eacute;";
					}
					else
					{
						if ($donnees['tri_tick'] == "2")
						{
							$tri_tick="Date derni&egrave;re r&eacute;ponse";
						}
						else
						{
							$tri_tick="Date de cr&eacute;ation";
						}
					}
					// Statut du ticket
					if ($donnees['statut']== "Tous")
					{
						$statut="Tous";
					}
					else
					{
						if ($donnees['statut'] == "N")
						{
							$statut="Nouveau";
						}
						else
						{
							if ($donnees['statut'] == "T")
							{
								$statut="Transf&eacute;r&eacute;";
							}
							else
							{
								$statut="En cours";
							}
						}
					}

					// Pour les tâches
					if ($donnees['tri_tac']== "0")
					{
						$tri_tac="Toutes";
					}
					else
					{
						if ($donnees['tri_tac'] == "1")
						{
							$tri_tac="Priv&eacute;es";
						}
						else
						{
							$tri_tac="Publiques";
						}
					}
					// Pour les cat&eacute;gories
					// Dans le cas où l'utilisateur a saisi "Toutes" = 0 dans la BDD
					if ($donnees['categorie'] == "0")
					{
						$categorie = "Toutes";
					}
					else
					{
						$categorie = "NON";
						// R&eacute;cup&eacute;ration de la cat&eacute;gorie COMMUNE souhait&eacute;e si elle existe
						$query="SELECT intitule_categ FROM categorie_commune where id_categ = ".$donnees['categorie'].";";
						$execution = mysql_query ($query);
						while($results = mysql_fetch_array($execution))
						{
							$categorie = $results['intitule_categ'];
						}
						// Si la cat&eacute;gorie est personnelle...
						if ($categorie == "NON")
						{
							$query="SELECT nom FROM categorie where id_categ = ".$donnees['categorie'].";";
							$execution=mysql_query($query);	
							while($recup=mysql_fetch_array($execution))
							{
								$categorie=$recup['nom'];
							}
						}
					}
					// Pour les infos modules
					if ($donnees['pers_form']=="Tout")
					{
						$pers_form="Nouvelle saisie et modification";
					}
					else
					{
						if ($donnees['pers_form']=="Nsaisie")
						{
							$pers_form="Nouvelle saisie";
						}
						else
						{
							$pers_form="Modification";
						}
					}
					$nb_j_tache=$donnees['nb_j_tache'];
					$nb_j_tache_av=$donnees['nb_j_tache_av'];
					$nb_j_alerte=$donnees['nb_j_alerte'];
					$nb_j_alerte_av=$donnees['nb_j_alerte_av'];
					$nb_j_ech=$donnees['nb_j_ech'];
					$nb_j_pret=$donnees['nb_j_pret'];
					$nb_j_pret_av=$donnees['nb_j_pret_av'];
					//$largeur_tableau = "800px";
				} //Fin while($donnees=mysql_fetch_array($execution))

			} //Fin if($num_results == "1")
			else //la fiche de pr&eacute;f&eacute;rence n'existe pas encore
			{
				$nb_j_tache = $tb_valeur_par_defaut;
				$nb_j_tache_av = $tb_valeur_par_defaut;
				$nb_j_alerte = $tb_valeur_par_defaut;
				$nb_j_alerte_av = $tb_valeur_par_defaut;
				$nb_j_ech = $tb_valeur_par_defaut;
				$nb_j_pret = $tb_valeur_par_defaut;
				$nb_j_pret_av = $tb_valeur_par_defaut;
			} //Fin else la fiche de pr&eacute;f&eacute;rence n'existe pas encore		

			//echo "<br />";
			echo"<form method = GET action = tb_preferences1.php>";
			//echo "Vous pouvez ici modifier les pr&eacute;f&eacute;rences d'affichage de votre tableau de bord";
			//echo "<br />";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Pr&eacute;f&eacute;rences pour les tickets ///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo "<table width = \"$largeur_tableau\">
					<tr>
						<th colspan=\"4\">Tickets</th>
					</tr>
					<tr>
						<td class = \"etiquette\" width = \"35%\">Trier par&nbsp;:&nbsp;</td>
						<td>
							&nbsp;<select name=tri_tick>";
								$donnees=$tri_tick;
								test_option_select ($donnees,"Priorit&eacute;","1");
								test_option_select ($donnees,"Date derni&egrave;re r&eacute;ponse","2");
								test_option_select ($donnees,"Date de cr&eacute;ation","3");
							echo"</select>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">Statut traitement&nbsp;:&nbsp;</td>
						<td>
							&nbsp;<select name=statut>";
							$donnees=$statut;
								test_option_select ($donnees,"Tous","Tous");
								test_option_select ($donnees,"Nouveau","N");
								test_option_select ($donnees,"Transf&eacute;r&eacute;","T");
								test_option_select ($donnees,"En cours","C");
							echo"</select>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">Alertes tickets&nbsp;:&nbsp;</td>
						<td>";
							echo "&nbsp;<input type=int name=nb_jours_alerte_av size=3 maxlength=3 value=".$nb_j_alerte_av."> jour(s) avant la date d'aujourd'hui<br />
							&nbsp;<input type=int name=nb_jours_alerte size=3 maxlength=3 value=".$nb_j_alerte."> jour(s) apr&egrave;s la date d'aujourd'hui";
						echo "</td>
					</tr>
				</table>
				<input type=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";

				echo "<div align = \"center\">";
					echo "<input type=submit value=Modifier a href = tb_preferences1.php>";
				echo "</div>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Pr&eacute;f&eacute;rences pour les tâches ////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo "<table width = \"$largeur_tableau\">
					<tr>
						<th colspan=\"4\">Suivi des t&acirc;ches</th>
					</tr>
					<tr>
						<td class = \"etiquette\" width = \"35%\">Filtr&eacute;es sur&nbsp;:&nbsp;</td>
						<td>
							&nbsp;<select name=tri_tac>";
								$donnees=$tri_tac;
								test_option_select ($donnees,"Toutes","0");
								test_option_select ($donnees,"Priv&eacute;es","1");
								test_option_select ($donnees,"Publiques","2");
							echo"</select>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</td>
						<td>";
							echo "&nbsp;<input type=int name=nb_jours_tache_av size=3 maxlength=3 value=".$nb_j_tache_av."> jour(s) avant la date d'aujourd'hui<br />
							&nbsp;<input type=int name=nb_jours_tache size=3 maxlength=3 value=".$nb_j_tache."> jour(s) apr&egrave;s la date d'aujourd'hui";
						echo "</td>
					</tr>
				</table>
				<input type=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";

				echo "<div align = \"center\">";
					echo "<input type=submit value=Modifier a href = tb_preferences1.php>";
				echo "</div>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// Pr&eacute;f&eacute;rences pour la gestion du mat&eacute;riel ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				if ($autorisation_gestion_materiels == 1)
				{
				echo "<table width = \"$largeur_tableau\">
						<tr>
							<th colspan=\"4\">Garanties des mat&eacute;riels</th>
						</tr>
						<tr>
							<td class = \"etiquette\">Ech&eacute;ance&nbsp;:&nbsp;</td>
							<td>";
								echo "&nbsp;dans <input type=int name=nb_jours_echeance_gar size=3 maxlength=3 value=".$nb_j_ech."> jour(s)";
							echo "</td>
						</tr>
					</table>
					<input type=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";

					echo "<div align = \"center\">";
						echo "<input type=submit value=Modifier a href = tb_preferences1.php>";
					echo "</div>";

				echo "<table width = \"$largeur_tableau\">
						<tr>
							<th colspan=\"4\">Suivi des pr&ecirc;ts des mat&eacute;riels</th>
						</tr>
						<tr>
							<td class = \"etiquette\">Ech&eacute;ance&nbsp;:&nbsp;</td>
							<td>";
								echo "&nbsp;<input type=int name=nb_jours_echeance_pret_av size=3 maxlength=3 value=".$nb_j_pret_av."> jour(s) avant la date d'aujourd'hui<br />
								&nbsp;<input type=int name=nb_jours_echeance_pret size=3 maxlength=3 value=".$nb_j_pret."> jour(s) apr&egrave;s la date d'aujourd'hui";
							echo "</td>
						</tr>";
					echo "</table>
					<input type=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";

					echo "<div align = \"center\">";
						echo "<input type=submit value=Modifier a href = tb_preferences1.php>";
					echo "</div>";

				} //Fin if ($autorisation_gestion_materiels == 1)
				echo "<br />";
				//echo "<input type=submit value=Modifier a href = tb_preferences1.php>";
			echo "</form>";
?>
		</div>
	</body>
</html>
