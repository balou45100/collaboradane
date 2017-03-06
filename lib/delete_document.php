<?php
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

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
		echo "<body>
			<CENTER>";

			//Récupération de l'identifiant concernant le ticket à supprimer
			$idpb = $_GET['idpb'];
			$id_doc = $_GET['id_doc']; //le document à supprimer
			$nom_fichier = $_GET['nom_fichier']; //Le nom du fichier à supprimer
			$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
			$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
			$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
			$origine = $_SESSION['origine']; //pour le retour
			$retour = $_GET['retour']; //pour le retour si on vient de la consultation des tickets de la gestion tickets
			$module = $_GET['module']; //
			if (ISSET($retour))
			{
				$origine = $retour;
			}
			/*
			echo "<br />module : $module";
			echo "<br />idpb : $idpb";
			echo "<br />id_document : $id_doc";
			echo "<br />origine : $origine";
			echo "<br />nom_fichier : $nom_fichier";
			echo "<br />";
			*/
			//Test du champ récupéré
			if(!isset($id_doc) || $id_doc == "")
			{
				echo "<B>Probl&egrave;mes de r&eacute;cup&eacute;ration de la variable</B>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'ecl_consult_fiche':
						echo "<BR><A HREF = ".$origine.".php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'formations_gestion':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'consult_ticket':
						echo "<BR><A HREF = ".$origine.".php?idpb=$idpb><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'gc_recherche':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'cardie_gestion_visites':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;
				}
				exit;
			}

			//Inclusion des fichiers nécessaires	
			include("../biblio/init.php");

			//Récupération des données résumant la catégorie pour procéder à sa suppression ou non
			$query = "SELECT * FROM documents WHERE id_doc = '".$id_doc."';";
			$results = mysql_query($query);
			if(!$results)
			{
				echo "<B>probl&egrave;me lors de l'execution de la requ&ecirc;te</B>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'ecl_consult_fiche':
						echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'formations_gestion':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'consult_ticket':
						echo "<BR><A HREF = ".$origine.".php?idpb=$idpb><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'gc_recherche':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'cardie_gestion_visites':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;
				}
				mysql_close();
				exit;
			}

			$res = mysql_fetch_row($results);

			echo "<B>Voulez-vous vraiment supprimer ce document&nbsp;?</B> <BR>";
			echo "<TABLE width=\"40%\" BORDER = \"1\">";
				echo "<TR>";
					echo "<TD class = \"etiquette\">N°&nbsp;:&nbsp;</TD>";
					echo "<TD>$res[0]</TD>";
				echo "</TR>";
				echo "<TR>";
				if ($origine == "gc_recherche")
				{
					echo "<TD class = \"etiquette\">ID courrier&nbsp;:&nbsp;</TD>";
					echo "<TD>$res[1]</TD>";
				}
				elseif ($origine == "formations_gestion")
				{
					echo "<TD class = \"etiquette\">ID Formation&nbsp;:&nbsp;</TD>";
					echo "<TD>$res[1]</TD>";
				}
				echo "</TR>";
				echo "<TR>";
					echo "<TD class = \"etiquette\">Intitul&eacute; du fichier&nbsp;:&nbsp;</TD>";
					echo "<TD>$res[2]</TD>";
				echo "</TR>";
				echo "<TR>";
					echo "<TD class = \"etiquette\">Nom du fichier&nbsp;:&nbsp;</TD>";
					echo "<TD>$res[3]</TD>";
				echo "</TR>";
			echo "</TABLE>";  

			echo "<BR>
			<A HREF = \"confirm_suppr_document.php?module=$origine&amp;id_doc=$id_doc&amp;nom_fichier=".$res[3]."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title = \"Confirmer la suppression\"></A>";
			switch ($origine)
			{
				case 'gestion_ticket':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retourner sans supprimer\"></A>";
				break;

				case 'ecl_consult_fiche':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retourner sans supprimer\"></A>";
				break;

				case 'formations_gestion':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retourner sans supprimer\"></A>";
				break;

				case 'consult_ticket':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retourner sans supprimer\"></A>";
				break;

				case 'gc_recherche':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retourner sans supprimer\"></A>";
				break;

				case 'cardie_gestion_visites':
					echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;
			}
		mysql_close();
?>
		</CENTER>
	</BODY>
</HTML>

