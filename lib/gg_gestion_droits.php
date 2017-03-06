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

			include ("../biblio/config.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_gestion_droits.png\" ALT = \"Titre\">";
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
			/////////////////////////////////////////////////////////////////////////////////////////
			// Fonction permettant de verifier si une catégorie est utilisée, renvoie vrai ou faux //
			/////////////////////////////////////////////////////////////////////////////////////////
			function verifier_droit($id_droit)
			{
				$requete = "select count(*) from util_droits
					where id_droit=".$id_droit;
				$resultat = mysql_query($requete);
				while ($ligne=mysql_fetch_array($resultat))
				{
					if ($ligne[0] > 0)
					{
						return true	;
					}
					else
					{
						return false;
					}
				}
			}
			////////////////////////////////////////////////////////////
			// Fin fonctions ///////////////////////////////////////////
			////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		// On récupère les variables transmises ////////////////////////
		////////////////////////////////////////////////////////////////
		$action = $_GET['action'];
		$a_faire = $_GET['a_faire'];
		$id_droit = $_GET['id_droit'];
		
		/*
		echo "<br />action : $action";
		echo "<br />a_faire : $a_faire";
		echo "<br />id_droit : $id_droit";
		*/
		
		////////////////////////////////////////////////////////////////
		// Les actions à faire /////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		if ($action == "O")
		{
			switch ($a_faire)
			{
				case "ajouter_droit" :
					$requete = "INSERT INTO droits VALUE (NULL, '".$_GET['nom']."')";
					$resultat = mysql_query($requete);
					if ($resultat)
					{
						echo "<h2>Ajout effectu&eacute; avec succ&egrave;s</h2>";
					}
					else
					{
						echo "<h2>Erreur lors de l'ajout</h2>";
					}
				break;

				case "attribuer_droits" :
					include("gg_gestion_droits_attribution_droits.inc.php");
					$affichage = "N";
				break;

				case "enreg_droits" :
					include("gg_gestion_droits_enreg_droits.inc.php");
				break;

				case "supprimer" :
					$requete = "delete from droits
						where id_droit=".$_GET['id_droit'];
					$resultat = mysql_query($requete);
					if ($resultat)
					{
						echo "<h2>Suppression effectu&eacute;e avec succ&egrave;s</h2>";
					}
					else
					{
						echo "<h2>Erreur lors de la suppression</h2>";
					}
				break;

				case "modifier_droit" :
					$requete = "update droits
						set nom_droit = '".$_POST['modif_nom_droit']."'
						where id_droit = ".$_POST['modif_id_droit'];
					$resultat = mysql_query($requete);
					if ($resultat)
					{
						echo "<h2>Modification effectu&eacute;e avec succ&egrave;s</h2>";
					}
					else
					{
						echo "<h2>Erreur lors de la modification</h2>";
					}
				break;
			} // Fin switch a_faire
		} // Fin action = "O"
		////////////////////////////////////////////////////////////////
		// Fin des des actions à faire /////////////////////////////////
		////////////////////////////////////////////////////////////////

	if ($affichage <> "N")
	{
		echo "<form action=\"gg_gestion_droits.php\" method=\"GET\">";
			echo "<h2>Ajout d'un nouveau droit</h2>";
			echo "Intitul&eacute;&nbsp;:&nbsp;<input type=\"text\" value=\"\" name=\"nom\">";
			echo "&nbsp;<input type=\"submit\" value=\"Ajouter\" name=\"ajouter\">";
			// Les autres variables à transmettre
			echo "<input type=\"hidden\" name=\"action\" value=\"O\">";
			echo "<input type=\"hidden\" name=\"a_faire\" value=\"ajouter_droit\">";
		echo "</form>";
		
		echo "<form action=\"gg_gestion_droits.php\" method=\"GET\">";
		echo "<table>";
			echo "<tr class = \"entete_tableau\">";
				echo "<th>ID</th>";
				echo "<th>Intitul&eacute;</th>";
				echo "<th>Membres</th>";
				echo "<th>Actions</th>";
			echo "</tr>";

				//On récupère toute les groupes existants
						$requete = "select *
									from droits";
						$resultat = mysql_query($requete);
						$num_rows = mysql_num_rows($resultat);
						
						if (mysql_num_rows($resultat))
						{	
							while ($ligne=mysql_fetch_array($resultat))
							{
							//On les affiches
								echo"<tr class = \"fond_tableau\">";
									echo "<td align = \"center\">".$ligne[0]."</td>";
									echo"<td>".$ligne[1]."</td>";
								
									//On récupère les initiales des membres du groupe
									$requete_utils = 
									"SELECT u.initiales, ud.id_util, ud.niveau, u.prenom, u.nom FROM util AS u, util_droits AS ud 
										WHERE u.id_util = ud.id_util 
											AND ud.id_droit = $ligne[0] 
										ORDER BY nom";
									
									//echo "$requete_utils";
									
									$resultat_requete_utils = mysql_query($requete_utils);
									$nbr_utils = mysql_num_rows($resultat_requete_utils);
								
									//echo "<br />gg_gestion_groupe - nbr_utils : $nbr_utils";
									
									echo "<td>";
										if ($nbr_utils > 0)
										{
											$compteur = 0;
											$util_a_aficher ="";
											while ($ligne_utils=mysql_fetch_array($resultat_requete_utils))
											{
												//On les affiches sans l'admin
												
												if ($ligne_utils[0] <> "ADM")
												{
													$compteur++;
													if ($compteur < $nbr_utils)
													{
														affiche_util_droit($ligne_utils[0],$ligne_utils[2],$ligne_utils[3],$ligne_utils[4]);
														echo ",&nbsp;";
													}
													else
													{
														affiche_util_droit($ligne_utils[0],$ligne_utils[2],$ligne_utils[3],$ligne_utils[4]);
													}
													$test_fin_de_ligne = $compteur/10;
													If (is_int($test_fin_de_ligne))
													{
														echo "<br />";
													}
												}
											}
										}
										else
										{
											echo "&nbsp;";
										}
									echo "</td>";
									//echo "<td align = \"center\">$ligne_utils[1]</td>";
									//echo "<td class = \"entete_tableau\"><a href='gg_modif_droit.php?num=".$ligne[0]."'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le groupe\" border = \"0\"></a>";
			////////////////////////////////////////////////////////////////////////
			//////////////// On affiche les icônes des actions possibles ///////////
			////////////////////////////////////////////////////////////////////////
									echo "<td class = \"fond-actions\" nowrap>";
										echo "&nbsp;<a href=\"gg_gestion_droits.php?id_droit=".$ligne[0]."&amp;action=O&amp;a_faire=attribuer_droits\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/droits_ajout_personne.png\" ALT = \"Attribuer droits\" title=\"Attribuer droits\" border = \"0\"></a>";
										//On vérifie si le groupe est utilisé, si il ne l'est pas, on affiche le bouton permettant de le supprimer
										if (!verifier_droit($ligne[0]))
										{
											echo "&nbsp;<a href=\"gg_gestion_droits.php?id_droit=".$ligne[0]."&amp;action=O&amp;a_faire=supprimer\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer le groupe\" border = \"0\"></a>";
										}
									echo"</td>";
								echo "</tr>";
							}
						}
		echo "</table>";
		echo "</form>";
	} // Fin affichage <> "N"

	echo "</center>";
	echo "</body>";
echo "</html>";
?>
