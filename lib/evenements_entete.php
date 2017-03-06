<?php
	//Lancement de la session
	session_start();
	include("../biblio/init.php");
	header('Content-Type: text/html;charset=UTF-8');

?>

<!DOCTYPE html>

<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		//echo "<meta charset=\"UTF-8\">";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		echo "<body>";
			//echo "<h2>Gestion des suivis - Ent&ecirc;te en d&eacute;veloppement ; accueillera des possibilit&eacute;es de filtrer les enregistrements</h2>";
			echo "<div align =\"center\">";
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////// appel &agrave; taches_gestion.php //////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo "<form action = \"evenements_accueil.php\" target = \"body\" method = \"get\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							//Choix des filtres
							//$requete_categorie="SELECT DISTINCT id_categ,intitule_categ FROM categorie_commune, taches_categories WHERE taches_categories.id_categorie = categorie_commune.id_categ ORDER BY intitule_categ";
							$requete_utilisateurs="SELECT DISTINCT u.ID_UTIL, u.NOM, u.PRENOM FROM util AS u, util_groupes AS ug, evenements AS e
								WHERE u.ID_UTIL = ug.ID_UTIL
									AND ug.ID_GROUPE = 33
									AND e.fk_id_util = u.ID_UTIL
									AND u.visible = 'O'
								ORDER BY NOM";

							//echo "<br />$requete_utilisateurs";

							$resultat_requete_utilisateurs=mysql_query($requete_utilisateurs);
							$num_rows = mysql_num_rows($resultat_requete_utilisateurs);

							//echo "<br />num_rows : $num_rows";

							echo "&nbsp;Utilisateur/trice&nbsp;:&nbsp;";
							echo "<select size=\"1\" name=\"utilisateur_filtre\">";
							if (mysql_num_rows($resultat_requete_utilisateurs))
							{
								echo "<option selected value=\"%\">tou-te-s</option>";
								while ($ligne=mysql_fetch_object($resultat_requete_utilisateurs))
								{
									$id_util = $ligne->ID_UTIL;
									$nom = $ligne->NOM;
									$prenom = $ligne->PRENOM;
									echo "$nom";
									echo "<option value=\"$id_util\">$nom</option>";
								}
							}
							echo "</select>";
						echo "</td>";

						echo "<td>";

							$requete_dossier="SELECT DISTINCT cc.id_categ,cc.intitule_categ FROM categorie_commune AS cc, evenements AS e
								WHERE cc.id_categ = e.fk_id_dossier
									ORDER BY cc.intitule_categ";
							$resultat_requete_dossier=mysql_query($requete_dossier);
							$num_rows = mysql_num_rows($resultat_requete_dossier);
							echo "&nbsp;Dossier&nbsp;:&nbsp;<select size=\"1\" name=\"dossier_filtre\">";
							if (mysql_num_rows($resultat_requete_dossier))
							{
								echo "<option selected value=\"%\">tous</option>";
								while ($ligne=mysql_fetch_object($resultat_requete_dossier))
								{
									$intitule=$ligne->intitule_categ;
									$id_categ=$ligne->id_categ;
									echo "<option value=\"$id_categ\">$intitule</option>";
								}
							}
							echo "</select>";
						echo "</td>";


						echo "<td>";
							echo "&nbsp;par date&nbsp;:&nbsp;";
							echo "<select size=\"1\" name=\"date_filtre\">";
								echo "<option selected value=\"1\">&agrave; venir</option>";
								echo "<option value=\"2\">pass&eacute;es</option>";
								echo "<option value=\"%\">toutes</option>";
								
								//On ajoute toutes les dates des évènements

								$requete_par_date = "SELECT DISTINCT date_evenement_debut FROM evenements
									ORDER BY date_evenement_debut DESC";
								$resultat_requete_par_date = mysql_query($requete_par_date);
								$num_rows = mysql_num_rows($resultat_requete_par_date);
								if (mysql_num_rows($resultat_requete_par_date))
								{
									while ($ligne=mysql_fetch_object($resultat_requete_par_date))
									{
										$date_evenement_debut=$ligne->date_evenement_debut;
										echo "<option value=\"$date_evenement_debut\">$date_evenement_debut</option>";
									}
								}
							echo "</select>";
						echo "</td>";
/*
						echo "<td>";
							echo "&nbsp;&nbsp;D&eacute;tail&nbsp;:&nbsp;";
							echo "<input type = \"text\" VALUE = \"\" NAME = \"detail\" SIZE = \"20\">";
						echo "</td>";
*/

						echo "<td>";
								echo "&nbsp;<input type = \"submit\" VALUE = \"hop !\">
									<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
									<input type = \"hidden\" VALUE = \"O\" NAME = \"visibilite\">
									<input type = \"hidden\" VALUE = \"entete\" NAME = \"origine_appel\">
									<input type = \"hidden\" VALUE = \"O\" NAME = \"controle_entete\">
									<input type = \"hidden\" VALUE = \"N\" NAME = \"affiche_barrees\">
									<input type = \"hidden\" VALUE = \"DESC\" NAME = \"sense_tri\">
									<input type = \"hidden\" VALUE = \"date_evenement_debut asc, heure_debut_evenement\" NAME = \"tri\">";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</form>";
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////// Fin appel &agrave; taches_gestion.php //////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//		echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////// Filtre pour les t�ches partag&eacute;es ////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/*
				$id_util = $_SESSION['id_util'];
				echo "<td>&nbsp;partages&nbsp;:&nbsp;</td>";
				$query_util_filtre = "SELECT * FROM util, taches_util, taches WHERE taches_util.id_util = '".$id_util."' AND taches_util.id_tache = taches.id_tache AND taches.id_util_creation = util.id_util AND visible = 'O' ORDER BY NOM";
				//$query_util_filtre = "SELECT * FROM util, taches_util, taches WHERE util.id_util = taches_util.id_util AND taches_util.id_util = '".$id_util."' AND visible = 'O' ORDER BY NOM";
				$results_util_filtre = mysql_query($query_util_filtre);
				$no = mysql_num_rows($results_util_filtre);
				//echo "id_util : $id_util";

				echo "<form action = \"taches_gestion.php\"  target = \"body\" method = \"get\">";
				echo "<td>";
					echo "<input type = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
				echo "</td>";
				echo "<td>";
					echo "<select name = \"id_util_filtre\">";
						echo "<option selected VALUE = \"0\">Tous</option>";
						while ($ligne_util_filtre = mysql_fetch_object($results_util_filtre))
						{
							$id_util_filtre = $ligne_util_filtre->ID_UTIL;
							$nom = $ligne_util_filtre->NOM;
							$prenom = $ligne_util_filtre->PRENOM;
							if ($id_util_filtre <> $id_util)
							{
								echo "<option value = \"".$id_util_filtre."\">".$nom." - ".$prenom."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<input type = \"submit\" VALUE = \"hop !\">
							<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<input type = \"hidden\" VALUE = \"entete_util\" NAME = \"origine_appel\">
							<input type = \"hidden\" VALUE = \"N\" NAME = \"affiche_barrees\">
							<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<input type = \"hidden\" VALUE = \"DATECR\" NAME = \"tri\">";

					echo "</td>";
				echo "</tr>";
			echo "</table>";
				echo "</form>";
		*/
				echo "</div>";
		echo "</body>";
	echo "</html>";
?>
