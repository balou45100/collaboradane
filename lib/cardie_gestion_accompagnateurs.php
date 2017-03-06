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

<!DOCTYPE html> 
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\">";
?>
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
<?php
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_cardie.png\" ALT = \"Titre\">";
			include ("../biblio/cardie_config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
			
/*
			//On recupère la variable session pour l'utilisateur connecté
			$id_util = $_SESSION['id_util'];
			
			//On vérifie les droits
			$autorisation_cardie = verif_appartenance_groupe(31);
			$niveau_droits = verif_droits("Cardie");
			
*/
			//On vérifie si on vient de l'entête
			$origine_appel = $_GET['origine_appel'];
			
			//echo "<br />origine_appel : $origine_appel";
			
			//On récupère les filtres envoyés par l'entête 
			if ($origine_appel == "entete_accompagnateurs")
			{
				$annee_a_filtrer = $_GET['annee_a_filtrer'];
				$accompagnateur_a_filtrer = $_GET['id_accompagnateur'];
				$_SESSION['tri'] = "PRT.nom";
				$_SESSION['sense_tri'] = "asc";
				$_SESSION['annee_a_filtrer'] = $annee_a_filtrer;
				$_SESSION['accompagnateur_a_filtrer'] = $accompagnateur_a_filtrer;
			}
			else
			{
				$tri = $_SESSION['tri'];
				$sense_tri = $_SESSION['sense_tri'];
				$annee_a_filtrer = $_SESSION['annee_a_filtrer'];
				$accompagnateur_a_filtrer = $_SESSION['accompagnateur_a_filtrer'];
			}

			if (!ISSET($annee_a_filtrer)) //On n'est pas passé par l'entête
			{
				$annee_a_filtrer = $annee_en_cours;
			}

			//echo "<br />annee_a_filtrer : $annee_a_filtrer";

			if (!ISSET($accompagnateur_a_filtrer)) //On n'est pas passé par l'entête
			{
				$accompagnateur_a_filtrer = "T";
			}

			//On fixe les étiquettes des boutons généraux
			$etiquette_bouton_visites = "Gestion visites";
			$etiquette_bouton_projets = "Gestion projets"; 

			/*
			echo "<br />cardie_gestion.php";
			echo "<br>autorisation_cardie : $autorisation_cardie";
			echo "<br>niveau_droits : $niveau_droits";
			*/

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////// Début du script pour gérer les actions à faire ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
			$action = $_GET['action'];
			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			$a_faire = $_GET['a_faire'];
			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}

			$id_pers_ress = $_GET['id_pers_ress'];
			if (!ISSET($id_pers_ress))
			{
				$id_pers_ress = $_POST['id_pers_ress'];
			}
/*
			$id_visite = $_GET['id_visite'];
			if (!ISSET($id_visite))
			{
				$id_visite = $_POST['id_visite'];
			}
*/
			/*
			echo "<br />cardie_gestion.php";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />id_projet : $id_projet";
			echo "<br />id_visite : $id_visite";

			*/
			//Initialisation des variables de tri 
			$tri = $_GET['tri'];
			if (!ISSET($tri))
			{
				$tri = $_POST['tri'];
			}

			if (!ISSET($tri))
			{
				$tri = "PRT.nom";
			}

			$sense_tri = $_GET['sense_tri'];
			if (!ISSET($sense_tri))
			{
				$sense_tri = $_POST['sense_tri'];
			}

			if (!ISSET($sense_tri))
			{
				$sense_tri = "asc";
			}

			/*
			echo "<br />tri : $tri";
			echo "<br />sense_tri : $sense_tri";
			*/

			if ($action == "O")
			{
				switch ($a_faire)
				{
					////////// actions concernant les accompagnateurs //////////////////
					case "info_accompagnateur": //consultation des détails d'un-e accompagnateur/trice
						include("cardie_gestion_info_accompagnateur.inc.php");
						$affichage = "N";
					break;
					
					case "ajout_accompagnateur": //ajouter une visite au projet
						$enreg_accompagnateur = $_GET['enreg_accompagnateur'];
						if ($enreg_accompagnateur == "O")
						{
							//echo "<h2>J'enregistre l'accompagnateur $id_pers_ress</h2>";
							include("cardie_gestion_enreg_accompagnateur.inc.php");
						}
						include("cardie_gestion_ajout_accompagnateur.inc.php");
						$affichage = "N";
					break;

					case "dissocier_accompagnateur": //dissocier un accompagnateur d'un projet
						include("cardie_gestion_dissocier_accompagnateur.inc.php");
						$module = $_GET['module'];
						/*
						if ($module <> "T") //On arrive de la page cardie_gestion_ajout_accompagnateur.inc.php
						{
							include("cardie_gestion_ajout_accompagnateur.inc.php");
							$affichage = "N";
						}
						*/
						$affichage = "N";
					break;

					case "confirmation_dissocier_accompagnateur": //dissocier un accompagnateur d'un projet
						include("cardie_gestion_confirmation_dissocier_accompagnateur.inc.php");
						$module = $_GET['module'];
						if ($module <> "T") //On arrive de la page cardie_gestion_ajout_accompagnateur.inc.php
						{
							include("cardie_gestion_ajout_accompagnateur.inc.php");
							$affichage = "N";
						}
					break;
				} //Fin switch "a_faire"

			} //Fin if action == O

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////// Début du script principal pour l'affichage des enregistrepments //////////////
//////////////////////////////////////////////////////////////////////////////////////////////
			if ($affichage <> "N")
			{
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"cardie_cadre_visites.php?mode_affichage=Visites\" target = \"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_mode_visite.png\" ALT = \"Affichage par visites\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">$etiquette_bouton_visites</span><br />";
							echo "</td>";

							echo "<td>";
								echo "<a href = \"cardie_cadre_projets.php\" target = \"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_mode_projet.png\" ALT = \"Affichage par projets\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">$etiquette_bouton_projets</span><br />";
							echo "</td>";
/*
							echo "<td>";
								echo "&nbsp;&nbsp;";
							echo "</td>";
							echo "<td>";
								//echo "<a href = \"cardie_gestion_accompagnateurs.php?action=O&amp;a_faire=ajout_accompagnateur\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un-e accompagnateur/trice\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un-e accompagnateur/trice</span><br />";
							echo "</td>";
*/
						echo "</tr>";
					echo "</table>";
				echo "</div>";

///////////////////////////////////////////////////////////////
////////////// Début de l'affichage des données ///////////////
///////////////////////////////////////////////////////////////
				include ('cardie_gestion_affichage_donnees_par_accompagnateurs.inc.php');
			} //Fin if affichage <> "N"
?>
		</div>
	</body>
</html>
