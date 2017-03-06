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

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	include ("../biblio/config.php");
	include ("../biblio/fct.php");
	include ("../biblio/init.php");

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_gestion_groupes.png\" ALT = \"Titre\">";

	$autorisation_gestion_groupes = verif_appartenance_groupe(13);

	if($autorisation_gestion_groupes <> "1")
	{
		echo "<h1>Vous n'avez pas le droit d'acc&eacute;der &agrave; ce module</h1>";
		/*
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		*/
		exit;
	}
	////////////////////////////////////////////////////////////////////
	// Fonction permettant de verifier si une catégorie est utilisée, //
	// renvoie vrai ou faux ////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	function verifier_groupe($num_groupe)
	{
		$requete = "select count(*) FROM util_groupes
					WHERE id_groupe = ".$num_groupe."
						AND ID_UTIL <> 19"; // admin
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
	///////////////////////////////////////////////////////////////////////
	// Fin fonction permettant de verifier si une catégorie est utilisée //
	///////////////////////////////////////////////////////////////////////

	//Si on $ get num_groupe, c'est que l'on veux supprimer un groupe
	if (isset($_GET['num_groupe']))
	{
		$requete = "delete from groupes
					where id_groupe=".$_GET['num_groupe'];

		$resultat = mysql_query($requete);
		if ($resultat)
		{
			echo "<h2>Suppression effectu&eacute;e avec succ&egrave;s</h2>";
		}
		else
		{
			echo "<h2>Erreur lors de la suppression</h2>";
		}
	}
	//Si on a post num, c'est qu'on veux ajouter un groupe
	if (isset($_POST['ajouter']))
	{
		$requete = "INSERT INTO groupes VALUE (NULL, '".$_POST['nom']."')";
		$resultat = mysql_query($requete);
		if ($resultat)
		{
			echo "<h2>Ajout effectu&eacute; avec succ&egrave;s</h2>";
		}
		else
		{
			echo "<h2>Erreur lors de l'ajout</h2>";
		}
	}
	//Si cette variable post est présente, on veux modifier un groupe
	if (isset($_POST['modifier_groupe']))
	{
		$requete = "UPDATE groupes
					SET nom_groupe = '".$_POST['modif_nom_groupe']."'
					WHERE id_groupe = ".$_POST['modif_numero_groupe'];

		$resultat = mysql_query($requete);
		if ($resultat)
		{
			echo "<h2>Modification effectu&eacute;e avec succ&egrave;s</h2>";
		}
		else
		{
			echo "<h2>Erreur lors de la modification</h2>";
		}
	}

	echo "<form action=\"gg_gestion_groupe.php\" method=\"post\">";
		echo "<h2>Ajout d'un nouveau groupe</h2>";
		echo "Intitul&eacute;&nbsp;:&nbsp;<input type=\"text\" value=\"\" name=\"nom\">";
		echo "&nbsp;<input type=\"submit\" value=\"Ajouter\" name=\"ajouter\">";
	echo "<table width = \"90%\">";
		echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Intitul&eacute;</th>";
			echo "<th>Membres</th>";
			echo "<th>Actions</th>";
		echo "</tr>";

	//On récupère toutes les groupes existants
	$requete = "select * FROM groupes ORDER BY NOM_GROUPE";
	$resultat = mysql_query($requete);
	$num_rows = mysql_num_rows($resultat);

	if (mysql_num_rows($resultat))
	{
		while ($ligne=mysql_fetch_array($resultat))
		{
			//On les affiches
			echo"<tr class = \"fond_tableau\">";
				echo "<td align = \"center\">".$ligne[0]."</td>";
				echo"<td nowrap>".$ligne[1]."</td>";

				//On récupère les informations des membres du groupe
				$requete_utils = "SELECT u.initiales, ug.id_util, u.PRENOM, u.NOM FROM util AS u, util_groupes AS ug WHERE u.id_util = ug.id_util AND ug.id_groupe = $ligne[0] ORDER BY nom";
				$resultat_requete_utils = mysql_query($requete_utils);
				$nbr_utils = mysql_num_rows($resultat_requete_utils);
				echo "<td>";
				if ($nbr_utils > 0)
				{
					$nbr_par_ligne = 18; // pour ne pas faire de cellule trop large
					$compteur_utils_par_ligne = 0; //on initialise le compteur des utils à afficher par ligne
					while ($ligne_utils=mysql_fetch_array($resultat_requete_utils))
					{
						//On les affiches sans l'admin
						if ($ligne_utils[0] <> "ADM")
						{
							$compteur_utils_par_ligne ++;
							if ($compteur_utils_par_ligne > $nbr_par_ligne)
							{
								echo "<br />";
								$compteur_utils_par_ligne = 0;
							}
							affiche_info_bulle_initiales($ligne_utils[0],$ligne_utils[2],$ligne_utils[3]);
							echo "$ligne_utils[0]&nbsp;";
						}
					}
				}
				else
				{
					echo "&nbsp;";
				}
				echo "</td>";
				echo "<td class = \"fond-actions\" nowrap>";
				echo "<a href='gg_modif_groupe.php?num=".$ligne[0]."'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le groupe\" border = \"0\"></a>";
				//On vérifie si le groupe est utilisé, si il ne l'est pas, on affiche le bouton permettant de le supprimer
				if (!verifier_groupe($ligne[0]))
				{
					echo "&nbsp;<a href='gg_gestion_groupe.php?num_groupe=".$ligne[0]."'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer le groupe\" border = \"0\"></a>";
				}
				echo"</td>";
			echo "</tr>";
		}
	}
?>
	</table>
	</form>
	</center>
	</body>
<html>
