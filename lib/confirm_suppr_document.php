<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
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

			//test de récupération des données
			$idpb = $_GET['idpb'];
			$id_doc = $_GET['id_doc']; //le document à supprimer
			$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
			$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
			$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
			$nom_fichier = $_GET['nom_fichier'];
			//$origine = $_SESSION['origine']; //pour le retour
			$module = $_GET['module'];
			$origine = $module; 
			if(!isset($id_doc) || $id_doc == "")
			{
				echo "<B>Identifiant du ticket inexistant</B>";
				switch ($origine)
				{
					case 'gestion_ticket':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'ecl_consult_ticket':
						echo "<BR><A HREF = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'formations_gestion':
						echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'consult_ticket':
						echo "&nbsp;<A HREF = ".$origine.".php?idpb=$idpb><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'gc_recherche':
						echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;

					case 'cardie_gestion_visites':
						echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
					break;
				}
				exit;
			}

			//Appel de la fonction pour supprimer un document

			switch ($origine)
			{
				case 'gestion_ticket':
					echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;

				case 'ecl_consult_ticket':
					suppr_doc($id_doc,$dossier_docs_formation,$nom_fichier);
				break;

				case 'formations_gestion':
					suppr_doc($id_doc,$dossier_docs_formation,$nom_fichier);
				break;

				case 'consult_ticket':
					suppr_doc($id_doc,$dossier_docs_gestion_tickets,$nom_fichier);
				break;

				case 'gc_recherche':
					suppr_doc($id_doc,$dossier_docs_courriers,$nom_fichier);
				break;

				case 'cardie_gestion_visites':
					suppr_doc($id_doc,$dossier_docs_cardie,$nom_fichier);
				break;
			}

			//echo "<B>Le document a été supprimé</B>";
			switch ($origine)
			{
				case 'gestion_ticket':
					echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la gestion des tickets\" border = \"0\"></A>";
				break;

				case 'ecl_consult_fiche':
					echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour à la gestion des catégories\" border = \"0\"></A>";
				break;

				case 'formations_gestion':
					echo "<BR><BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;

				case 'consult_ticket':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;

				case 'gc_recherche':
					echo "&nbsp;<A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;

				case 'cardie_gestion_visites':
					echo "<BR><A HREF = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\" title = \"Retour\"></A>";
				break;
			}
			//Fermeture de la connexion à la BDD
			mysql_close();
?>
		</CENTER>
	</BODY>
</HTML>
