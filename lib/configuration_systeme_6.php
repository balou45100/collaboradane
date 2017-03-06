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
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_configuration_systeme.png\" ALT = \"Titre\">";
			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
			
			//On recupère la variable session pour l'utilisateur connecté
			$id_util = $_SESSION['id_util'];
			
			//On vérifie les droits
			$droit_configuration_systeme = verif_droits("configuration_systeme");
			

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

			$id_liste = $_GET['id_liste'];
			if (!ISSET($id_liste))
			{
				$id_liste = $_POST['id_liste'];
			}
			/*
			echo "<br />configuration_systeme_6.php";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />id_liste : $id_liste";
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
///////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Traitement de la liste de la liste (configuration_systeme_listes_deroulantes) /////////
///////////////////////////////////////////////////////////////////////////////////////////////////
					case "ajout_liste": //ajouter une table dans la base qui contiendra les éléments d'une liste déroulante
						include("configuration_system_6_ajout_liste.inc.php");
						//echo "<h1>Ajout de liste</h1>";
						$affichage = "N";
					break;

					case "enreg_liste": //On enregistre la nouvelle liste
						include("configuration_system_6_enreg_liste.inc.php");
					break;

					case "modif_liste": //modifie l'intitulé d'une liste
						include("configuration_system_6_modif_liste.inc.php");
						$affichage = "N";
					break;

					case "enreg_modif_liste": //enregistre la liste modifiée
						include("configuration_system_6_enreg_modif_liste.inc.php");
					break;

					case "supprimer_liste": //supprime une liste
						include("configuration_system_6_supprimer_liste.inc.php");
						$affichage = "N";
					break;

					case "confirmation_supprimer_liste": //supprime la liste
						include("configuration_system_6_confirmation_supprimer_liste.inc.php");
					break;

					case "changer_etat": //on bascule un élément de actif à inactif et vice et versa
						//echo "<h1>Changement d'&eacute;tat</h1>";
						//$nom_table = $_GET['nom_table'];
						$etat= $_GET['etat_liste'];
						$id_liste = $_GET['id_liste'];
						
						/*
						echo "<br />etat : $etat";
						echo "<br />id_liste : $id_liste";
						*/
						if ($etat == 'O')
						{
							$etat = 'N';
						}
						else
						{
							$etat = 'O';
						}

						$requete_maj = "UPDATE configuration_systeme_listes_deroulantes SET 
							`actif` = '".$etat."'
							WHERE `ID` = ".$id_liste.";";
						
						//echo "<br />$requete_maj";
						
						$resultat_maj = mysql_query($requete_maj);
						if (!$resultat_maj)
						{
							echo "<h2>Erreur lors de l'enregistrement</h2>";
						}
						else
						{
							echo "<h2>L'&eacute;tat a bien &eacute;t&eacute; modifi&eacute;</h2>";
						}
						//include("configuration_system_6_info_liste.inc.php");
						//$affichage = "N";
					break;


///////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Traitement des listes individuelles ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
					case "info_liste": //afficher les éléments de la liste déroulante
						include("configuration_system_6_info_liste.inc.php");
						$affichage = "N";
					break;

					case "info_liste_changer_etat": //on bascule un élément de actif à inactif et vice et versa
						//echo "<h1>Changement d'&eacute;tat</h1>";
						$nom_table = $_GET['nom_table'];
						$etat= $_GET['etat_element'];
						$id_element = $_GET['id_element'];
						$nom_champ_id = $_GET['nom_champ_id'];
						
						/*
						echo "<br />nom_table : $nom_table";
						echo "<br />etat : $etat";
						echo "<br />nom_champ_id : $nom_champ_id";
						echo "<br />id_element : $id_element";
						*/
						if ($etat == 'O')
						{
							$etat = 'N';
						}
						else
						{
							$etat = 'O';
						}

						$requete_maj = "UPDATE $nom_table SET 
							`actif` = '".$etat."'
							WHERE $nom_champ_id = ".$id_element.";";
						
						//echo "<br />$requete_maj";
						
						$resultat_maj = mysql_query($requete_maj);
						if (!$resultat_maj)
						{
							echo "<h2>Erreur lors de l'enregistrement</h2>";
						}
						else
						{
							echo "<h2>L'&eacute;tat a bien &eacute;t&eacute; modifi&eacute;</h2>";
						}
						include("configuration_system_6_info_liste.inc.php");
						$affichage = "N";
					break;

					case "info_liste_ajout_element": //On ajoute des éléments à la liste déroulante
						//echo "<br />info_liste_ajout_element";
						$nom_table = $_GET['nom_table'];
						include("configuration_system_6_info_liste_ajout_element.inc.php");
						$affichage = "N";
					break;

					case "info_liste_enreg_element": //On enregistre l'élément saisie
						$nom_table = $_GET['nom_table'];
						$intitule = $_GET['intitule'];
						
						echo "<br />nom_table : $nom_table";
						echo "<br />intitule : $intitule";
						
						$requete_enreg_element = "INSERT INTO $nom_table
						(
							`INTITULE`
						)
						VALUES
						(
							'".$intitule."'
						);";
						
						echo "<br />$requete_enreg_element<br />";
						
						$resultat_enreg_element = mysql_query($requete_enreg_element);
						if (!$resultat_enreg_element)
						{
							echo "<h2>Erreur lors de l'enregistrement</h2>";
						}
						else
						{
							echo "<h2>L'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;</h2>";
						}

						include("configuration_system_6_info_liste.inc.php");
						$affichage = "N";
					break;

					case "info_liste_modif_element": //modifie un élément de la liste
						include("configuration_system_6_info_liste_modif_element.inc.php");
						$affichage = "N";
					break;

					case "info_liste_enreg_modif_element": //enregistre l'élément modifié
						include("configuration_system_6_info_liste_enreg_modif_element.inc.php");
						include("configuration_system_6_info_liste.inc.php");
						$affichage = "N";
					break;

					case "info_liste_supprimer_element": //supprime un élément de la liste
						//echo "<h2>Suppression d'une visite</h2>";
						include("configuration_system_6_info_liste_supprimer_element.inc.php");
						$affichage = "N";
					break;

					case "info_liste_confirmation_supprimer_element": //supprime un élément de la liste
						//echo "<h2>Suppression d'une visite</h2>";
						include("configuration_system_6_info_liste_confirmation_supprimer_element.inc.php");
						include("configuration_system_6_info_liste.inc.php");
						$affichage = "N";
					break;


				} //Fin switch "a_faire"

			} //Fin if action == O

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////// Début du script principal pour l'affichage des enregistrepments //////////////
//////////////////////////////////////////////////////////////////////////////////////////////
			if ($affichage <> "N")
			{
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_1.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_1.png\" title = \"Configuration de base\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration de base&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_2.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_2.png\" title = \"Configuration dossiers de stockage\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Dossiers stockage&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_3.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_3.png\" title = \"Configuration des modules\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration modules&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_32.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_3.png\" title = \"Configuration module OM\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Configuration module OM&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_4.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_4.png\" title = \"Configuration boutons fichier repertoire_consult_fiche\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Boutons fichier repertoire_consult_fiche&nbsp;";
						echo "</td>";
						echo "<td align = \"center\">";
							echo "<a href=\"configuration_systeme_5.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/configuration_systeme_5.png\" title = \"Configuration taille des ic&ocirc;nes\" align=\"top\" border=\"0\"></a>";
							echo "<br />&nbsp;Taille ic&ocirc;nes&nbsp;";
						echo "</td>";
					echo "</tr>";
				echo "</table>";


				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
								echo "<td>";
									echo "<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=ajout_liste&amp;\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Ajouter une liste\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter une liste</span><br />";
								echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

///////////////////////////////////////////////////////////////
////////////// Début de l'affichage des données ///////////////
///////////////////////////////////////////////////////////////
				//On extrait les listes déroulante de la trable configuration_systeme_listes_deroulantes
				$requete_listes = "SELECT * FROM 
					configuration_systeme_listes_deroulantes ORDER BY INTITULE";
					
				//echo "<br />$requete_listes";
				
				$resultat_listes = mysql_query($requete_listes);
				$nb_listes = mysql_num_rows($resultat_listes);
				
				if ($nb_listes > 0)
				{
						echo "<h2>Nombre de liste : $nb_listes</h2>";
						//On affiche l'entête du tableau
						echo "<table>";
							echo "<tr>";
								echo "<th nowrap>";
									echo "&nbsp;ID&nbsp;";
								echo "</th>";
								echo "<th>";
									echo "&nbsp;INTITUL&Eacute; LISTE&nbsp;";
								echo "</th>";
								echo "<th>";
									echo "&nbsp;ACTIF&nbsp;";
								echo "</th>";
							echo "<th>&nbsp;ACTIONS&nbsp;</th>";
						echo "</tr>";
						
						//On récupère les lignes des enregistrements
						while ($ligne_listes = mysql_fetch_object($resultat_listes))
						{
							$id_liste = $ligne_listes->ID;
							$intitule_liste = $ligne_listes->INTITULE;
							$actif_liste = $ligne_listes->actif;
							echo "<tr>";
								echo "<td align = \"center\">&nbsp;$id_liste&nbsp;</td>";
								echo "<td>&nbsp;$intitule_liste&nbsp;</td>";
								if ($actif_liste == 'O')
								{
									echo "<td align = center>&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=changer_etat&amp;id_liste=".$id_liste."&amp;etat_liste=".$actif_liste."\" target = \"body\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/etat_actif.png\" border = \"0\" ALT = \"D&eacute;sactiver\" title=\"D&eacute;sactiver la liste\"></a></td>";
								}
								else
								{
									echo "<td align = center>&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=changer_etat&amp;id_liste=".$id_liste."&amp;etat_liste=".$actif_liste."\" target = \"body\"><img height=\"$hauteur_icone_favoris\" width=\"$largeur_icone_favoris\" src = \"$chemin_theme_images/etat_inactif.png\" border = \"0\" ALT = \"activer\" title=\"Activer la liste\"></a></td>";
								}
								//echo "<td align = center>&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste_changer_etat&amp;id_liste=".$id_liste."&amp;etat_liste=".$actif_liste."\" target = \"body\">&nbsp;$actif_liste&nbsp;</a></td>";
								echo "<td class = \"fond-actions\" nowrap>";
									echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=info_liste&amp;id_liste=".$id_liste."&amp;nom_table=".$intitule_liste."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = \"0\" ALT = \"consulter\" title=\"Consulter la liste\"></a>";
									echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=modif_liste&amp;id_liste=".$id_liste."&amp;nom_table=".$intitule_liste."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" border = \"0\" ALT = \"modifier\" title=\"Modifier la liste\"></a>";
									echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=supprimer_liste&amp;id_liste=".$id_liste."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer la liste\"></a>";
									/*
									echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=archiver_liste&amp;id_liste=".$id_liste."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_listes=".$mes_listes."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archive.png\" border = \"0\" ALT = \"desarchiver\" title=\"D&eacute;s-archiver le projet\"></a>";
									echo "&nbsp;<a href = \"configuration_systeme_6.php?action=O&amp;a_faire=suppression_liste&amp;id_liste=".$id_liste."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;etat=".$etat."&amp;mes_listes=".$mes_listes."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer le projet\"></a>";
									*/
									echo "&nbsp;";
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				}
				else
				{
					echo "<h2>Il n'y a pas de listes dans la table</h2>";
				}
				
			} //Fin if affichage <> "N"
?>
			</TABLE>
		</div>
	</body>
</html>
