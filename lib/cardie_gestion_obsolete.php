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
			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
			
			//On recupère la variable session pour l'utilisateur connecté
			$id_util = $_SESSION['id_util'];
			
			//On vérifie les droits
			$autorisation_cardie = verif_appartenance_groupe(31);
			$niveau_droits = verif_droits("Cardie");
			
			//On vérifie si on vient de l'entête
			$origine_appel = $_GET['origine_appel'];
			
			//echo "<br />origine_appel : $origine_appel";
			
			//On récupère les filtres envoyés par l'entête 
			if ($origine_appel == "entete_projets")
			{
				$decision_commission = $_GET['decision_commission'];
				$type_accompagnement = $_GET['type_accompagnement'];
				$etat_projet = $_GET['etat_projet'];
			}
			elseif ($origine_appel == "entete_visites")
			{
				$etat_avancement = $_GET['etat_avancement'];
			}
			/*
			echo "<br />decision_commission eeeeeeeee: $decision_commission";
			echo "<br />type_accompagnement : $type_accompagnement";
			*/
			//echo "<br />etat_avancement : $etat_avancement";
			
			//On fixe les étiquettes des boutons généraux
			if ($niveau_droits > 1) //Il s'agit des droits de gestion au niveau de la CARDIE
			{
				$etiquette_bouton_visites = "Affichage par visites";
				$etiquette_bouton_projets = "Affichage par projets"; 
			}
			else
			{
				$etiquette_bouton_visites = "Mes visites";
				$etiquette_bouton_projets = "Mes projets"; 
			}
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

			$id_projet = $_GET['id_projet'];
			if (!ISSET($id_projet))
			{
				$id_projet = $_POST['id_projet'];
			}

			$id_visite = $_GET['id_visite'];
			if (!ISSET($id_visite))
			{
				$id_visite = $_POST['id_visite'];
			}
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
				$tri = "CP.RNE";
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
					////////// actions concernant les projets //////////////////
					case "ajout_projet": //ajout d'un nouveau projet
						//echo "<br />Je dois ajouter un projet";
						include("cardie_gestion_ajout_projet.inc.php");
						$affichage = "N";
					break;

					case "enreg_projet": //enregistrement d'un nouveau projet
						echo "<br />Je dois enregistrer un projet";
						include("cardie_gestion_enreg_projet.inc.php");
					break;

					case "info_projet": //consultation des détails du projet
						include("cardie_gestion_info_projet.inc.php");
						$affichage = "N";
					break;
					
					case "modif": //modifier le projet
						include("cardie_gestion_modif_projet.inc.php");
						$affichage = "N";
					break;
					
					case "enreg_modif_projet": //enregistrer le projet modifié
						include("cardie_gestion_enreg_modif_projet.inc.php");
					break;

					case "archiver_projet": //archiver le projet
						include("cardie_gestion_archiver_projet.inc.php");
					break;
					
					case "suppression_projet": //supprimer le projet
						include("cardie_gestion_suppression_projet.inc.php");
						$affichage = "N";
					break;

					case "confirm_suppression_projet": //confirmer la suppression du projet
						include("cardie_gestion_confirm_suppression_projet.inc.php");
					break;
					
					////////// actions concernant les visites //////////////////
					case "ajout_visite": //ajouter une visite au projet
						include("cardie_gestion_ajout_visite.inc.php");
						$affichage = "N";
					break;

					case "enreg_visite": //enregistre une visite au projet
						include("cardie_gestion_enreg_visite.inc.php");
						$avancer = $_POST['avancer'];
						
						//echo "<br />avancer : $avancer";
						
						if ($avancer == "O")
						{
							//echo "<br />j'avance la visite vers les gestionnaires de la CARDIE";
							$expediteur_nom = $_SESSION['nom'];
							
							//echo "<br />expediteur_nom : $expediteur_nom";
							
							include("cardie_gestion_avancer_visite_e0.inc.php");
						}
						//$affichage = "N";
					break;

					case "modifier_visite": //modifie une visite
						include("cardie_gestion_modif_visite.inc.php");
						$affichage = "N";
					break;

					case "enreg_modif_visite": //enregistre une visite au projet
						include("cardie_gestion_enreg_modif_visite.inc.php");
					break;

					case "supprimer_visite": //supprime une visite
						//echo "<h2>Suppression d'une visite</h2>";
						include("cardie_gestion_supprimer_visite.inc.php");
						$affichage = "N";
					break;

					case "confirmation_supprimer_visite": //supprime une visite
						//echo "<h2>Suppression d'une visite</h2>";
						include("cardie_gestion_confirmation_supprimer_visite.inc.php");
						//$affichage = "N";
					break;

					case "avancer_visite": //avancer le statut de la visite
						include("cardie_gestion_avancer_visite.inc.php");
						//$affichage = "N";
					break;

					////////// actions concernant les accompagnateurs //////////////////
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
				//Choix du mode d'affichage par visite ou par projet
				$mode_affichage = $_GET['mode_affichage']; //On récupère le mode d'affichage
				if (!ISSET($mode_affichage))
				{
					$mode_affichage = $_POST['mode_affichage'];
				}
/*
				if ($niveau_droits == "2")
				{
					$mode_affichage = "Visites";
				}
*/
				//echo "<br />mode_affichage : $mode_affichage";
				
				if ($autorisation_cardie == "1") //Affichage pour les personnes appartenant au groupe Cardie
				{
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								if ($mode_affichage <> "Visites")
								{
									echo "<td>";
										echo "<a href = \"cardie_cadre_visites.php?mode_affichage=Visites\" target = \"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_mode_visite.png\" ALT = \"Affichage par visites\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">$etiquette_bouton_visites</span><br />";
									echo "</td>";
										echo "<td>";
											echo "&nbsp;&nbsp;";
										echo "</td>";
									if ($niveau_droits == 3)
									{
										echo "<td>";
											echo "<a href = \"cardie_gestion.php?action=O&amp;a_faire=ajout_projet&amp;mode_affichage=Projets\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter un projet\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un  projet</span><br />";
										echo "</td>";
										/*
										echo "<td>";
											echo "&nbsp;&nbsp;";
										echo "</td>";
										*/
									}
/*
									echo "<td>";
										echo "&nbsp;&nbsp;";
									echo "</td>";
									echo "<td>";
										echo "<a href = \"cardie_gestion.php?mode_affichage=Projets&amp;etat=O\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/archiver.png\" ALT = \"Affichage par projets actifs\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Les projets actifs</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;&nbsp;";
									echo "</td>";
									echo "<td>";
										echo "<a href = \"cardie_gestion.php?mode_affichage=Projets&amp;etat=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/archive.png\" ALT = \"Affichage par projets archives\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Les projets archiv&eacute;s</span><br />";
									echo "</td>";
*/
								}
								else
								{
									echo "<td>";
										echo "<a href = \"cardie_cadre_projets.php\" target = \"_top\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_mode_projet.png\" ALT = \"Affichage par projets\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">$etiquette_bouton_projets</span><br />";
									echo "</td>";
								}
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				}

///////////////////////////////////////////////////////////////
////////////// Début de l'affichage des données ///////////////
///////////////////////////////////////////////////////////////
				if ($mode_affichage <> "Visites")
				{
					//echo "<br />Affichage des donn&eacute;es par Projets";
					include ('cardie_gestion_affichage_donnees_par_projets.inc.php');
				}
				else
				{
					//echo "<br />else de if mode_affichage <> visites - niveau_droits : $niveau_droits";
					//echo "<br />Affichage des donn&eacute;es par visites";
					include ('cardie_gestion_affichage_donnees_par_visites.inc.php');
				}
			} //Fin if affichage <> "N"
?>
			</TABLE>
		</div>
	</body>
</html>
