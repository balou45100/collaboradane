<?php
	session_start();
/*
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
*/
	//Inclusion des fichiers nécessaires
	@include ("../biblio/config.php");
	@include ("../biblio/fct.php");
	@include ("../biblio/init.php");
?>

<!DOCTYPE HTML>
<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";

	echo "<body>
		<div align = \"center\">";

	echo "</head>";

	echo "<body>";

	$suivant = $_POST['Suivant'];
	$etape = $_POST['etape'];
	$action = $_POST['action'];
	/*
	echo "<br />suivant : $suivant";
	echo "<br />etape : $etape";
	echo "<br />action : $action";
	*/
	//echo "<h2>Saisie d'une r&eacute;union, &eacute;tape $etape</h2>";
	if ($action == "O")
	{
		switch ($etape)
		{
			case "1":
				//echo "<h2>Saisie d'une r&eacute;union &eacute;tape $etape</h2>";
				//include ("gestion_categories_ajout_categorie.inc.php");
				//$affichage = "N";
			break;

			case "2":
				@$date1=$_POST["datedebut"];
				@$date_angl1=date("Y-m-d", strtotime($date1));
				@$heure1=$_POST["heuredebut"];
				@$FinalDate1=$date_angl1.' '.$heure1;
				@$date2=$_POST["datefin"];
				@$date_angl2=date("Y-m-d", strtotime($date2));
				@$heure2=$_POST["heurefin"];
				@$FinalDate2=$date_angl2.' '.$heure2;
				@$intitule=$_POST["intitule"];
				@$description=$_POST["description"];

				
				
				echo "<br />date1 : $date1";
				echo "<br />date_angl1 : $date_angl1";
				echo "<br />heure1 : $heure1";
				echo "<br />FinalDate1 : $FinalDate1";
				echo "<br />date_angl2 : $date_angl2";
				echo "<br />FinalDate2 : $FinalDate2";
				echo "<br />intitule : $intitule";
				echo "<br />description : $description";
				

				//Il faut tester si les champs sont tous renseignés

				//Tout est ok, on peut enregistrer la réunion
				$requete1="INSERT INTO `om_reunion` 
					(`idsalle`,`intitule_reunion`, `date_horaire_debut`, `date_horaire_fin`, `etat_reunion`, `description`) 
					VALUES ('1','$intitule', '$FinalDate1', '$FinalDate2', '', '$description');";

				//echo "<br />$requete1";
				//il faut récupérer l'id de la réunion pour ensuite pouvoir rajouter la salle

				$dernier_id_reunion = get_current_insert_id(om_reunion);

				//echo "<br />dernier_id_reunion : $dernier_id_reunion";

				$result1 = mysql_query($requete1);

				if($result1)
				{
					echo "<h2>La r&eacute;union a &eacute;t&eacute; enregistr&eacute;e</h2>";
				}

/*

				//echo "<h2>S&eacute;lection du type de lieu</h2>";

				echo "<center>";
					echo "<form method=\"post\" >";

						echo "<table>";
							/*
							echo "<!--tr>";
								echo "<td colspan=3 align center bgcolor="#014DFF"><p><center><b>Informations sur le lieu</b></center></p></td>";
							echo "</tr-->";


							echo "<tr>";
								echo "<td><h2>S&eacute;lection du type de lieu</h2></td>";
								echo "<td>";
									echo "<SELECT name=\"typelieu\" size=\"1\">";
										echo "<OPTION value=\"1\" selected>Etablissement scolaire</option>";
										echo "<OPTION value=\"2\">Répertoire</option>";
										echo "<OPTION value=\"3\">Nouvel ajout</option>";
									echo "</SELECT>";
								echo "</td>";
							echo "</tr>";


							echo "<!--tr>";
								echo "<td colspan=3>";
									echo "<center><input type="submit" name="Suivant2" value="Suivant"/></center>";
								echo "</td>";
							echo "</tr-->";


						echo "</table>";

						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT name = \Suivant2\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer et passer &agrave; l'&eacute;tape suivante</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
						//echo "<input type=hidden name=\"Suivant\" value=\"XX\"/>";
						echo "<input type=hidden name=\"etape\" value=\"3\"/>";
						echo "<input type=hidden name=\"action\" value=\"O\"/>";

					echo "</form>";
				echo "</center>";


				echo "<!--//////##############################################################################################################//////-->";
*/
				//echo "<h2>Saisie d'une r&eacute;union &eacute;tape $etape</h2>";
				//include ("gestion_categories_ajout_categorie.inc.php");
				//$affichage = "N";
			break;

			case "3":
				//debut des attributs
				@$typelieu=isset($_POST["typelieu"]) ? $_POST["typelieu"] : '';
				//fin des attributs
				$typelieu = $_POST['typelieu'];
				echo "<br />typelieu : $typelieu";

				switch ($typelieu)
				{
					case "1":
						$list0 = "";
						$list1 = "";
						echo "<br />########### Listes déroulantes: trouver un établissement ###########";
						include 'om_etablissements.inc.php';
						echo "<br />####################################################################";
					break;
					
					case "2":
						// Listes déroulantes: trouver un lieu dans le répertoire
						include 'om_repertoire.php';
					break;
					
					case "3":
						$list0 = "";
						$list1 = "";
						echo "<br />########### Formulaire d'ajout d'un nouveau lieu ###########";
						include 'om_formulairelieu.inc.php';
					break;
				}
				//echo "<h2>Saisie d'une r&eacute;union &eacute;tape $etape</h2>";
				//include ("gestion_categories_ajout_categorie.inc.php");
				//$affichage = "N";
			break;
		} //Fin switch ($etape)
	} //Fin if ($action == "O")

	mysql_close();
?>

</div>
</body>
</html>
