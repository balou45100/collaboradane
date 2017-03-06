<?php
  //Mise en place de la durée de la session
	session_start();
	//$origine = $_SESSION['origine'];

	if(!isset($_SESSION['id_util']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
	$theme = $_SESSION['chemin_theme']."WR_principal.css";
	echo "<!DOCTYPE html>";
	echo "<html>
	<head>
  		<title>Webradio - conducteurs</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>";
	echo "<body>";

	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	
	// Récupération des variables
	$DESTINATION_FOLDER = $_POST['Dossier'];	
	$script = $_POST['script']; //pour savoir où il faut retourner
	$RessourceIntitule = $_POST['RessourceIntitule']; //Titre du document
	$RessourceDescription = $_POST['RessourceDescription']; //Description du documents joints
	$choixEmission = $_POST['choixEmission'];
	$idConducteur = $_POST['idConducteur'];

	/*
	echo "<CENTER><br>WR_depot_fichier :"; 
	echo "<br />choixEmission : ".$choixEmission."";
	echo "<br>dossier : $DESTINATION_FOLDER";
	echo "<br>nom_doc : $nom_doc";
	echo "<br>script : $script";
	*/

	//$fichier_a_placer = creation_nom_doc_a_enregistrer_webradio($choixEmission,$idConducteur);
	/*
	echo "<br>nom_fichier_a_enregistrer : $fichier_a_placer";
	echo "<br><br></CENTER>";
	*/
  
	// Taille maximale de fichier, valeur en bytes					//
	$MAX_SIZE = 5000000;											//

	// Récupération de l'url de retour								//
	$RETURN_LINK = $_SERVER['HTTP_REFERER'];						//

	// Définition des extensions de fichier autorisées (avec le ".")//
	$AUTH_EXT = array(".doc", ".DOC", ".pdf", ".PDF", ".jpg", ".JPG",
		".png", ".PNG", ".eps", ".EPS", ".ppt", ".PPT", ".xls", ".XLS",
		".gif", ".GIF", ".odt", ".ODT", ".ods", ".ODS", ".odg", ".ODG",
		".psd", ".PSD", ".txt", ".TXT", ".gz", ".GZ", ".tar", ".TAR",
		".zip",  ".ZIP",".mp3", ".MP3", ".ogg", ".OGG");//
	// ############################################################ //

	// Fonction permettant de créer un lien de retour automatique

	function createReturnLink()
	{
		global $RETURN_LINK;
		echo "<a href='".$RETURN_LINK."'>Retour</a><br>";
	}

	// Fonction permettant de vérifier si l'extension du fichier est
	// autorisée.

	function isExtAuthorized($ext)
	{
		global $AUTH_EXT;
		if(in_array($ext, $AUTH_EXT)){
			return true;
		}
		else
		{
			return false;
		}
	}

	// On vérifie que le champs contenant le chemin du fichier soit
	// bien rempli.

	if(!empty($_FILES["file"]["name"]))
	{
		// Nom du fichier choisi:
		$nomFichier = $_FILES["file"]["name"] ;
		
		//echo "<br />nomFichier : $nomFichier";
		
		// Nom temporaire sur le serveur:
		$nomTemporaire = $_FILES["file"]["tmp_name"] ;
		// Type du fichier choisi:
		$typeFichier = $_FILES["file"]["type"] ;
		// Poids en octets du fichier choisit:
		$poidsFichier = $_FILES["file"]["size"] ;
		// Code de l'erreur si jamais il y en a une:
		$codeErreur = $_FILES["file"]["error"] ;
		// Extension du fichier
		$extension = strrchr($nomFichier, ".");

		/*
		echo "<br />extension : $extension";
		echo "<br />nomFichier : $nomFichier";
		*/
		//if(file_exists($DESTINATION_FOLDER.$fichier_a_placer.$extension))
		if(file_exists($DESTINATION_FOLDER.$nomFichier))
		{
			//echo "<CENTER>eh oui, il existe...</CENTER><br>";
			//$fichier_a_placer = renomme_fichier_a_placer($fichier_a_placer,$extension,$DESTINATION_FOLDER);
			$nomFichier = renomme_fichier_a_placer($nomFichier,$extension,$DESTINATION_FOLDER);
			$suite = "O"; //on procède avec le reste des tests pour le dépôt
			$nomFichier = $nomFichier.$extension;
			//echo "<br>de retour du renommage : fichier renommé : $nomFichier<br>";
			//unlink($DESTINATION_FOLDER.$nom_fichier.$extension);
		}
		else
		{
			//echo "<CENTER>eh non, il n'existe pas...<br></CENTER><br>";
			$suite = "O"; //on procède avec le reste des tests pour le dépôt
		}
		if ($suite == "O")
		{
			if($poidsFichier <> 0)
			{
				// Si la taille du fichier est supérieure à la taille
				// maximum spécifiée => message d'erreur
				if($poidsFichier < $MAX_SIZE)
				{
					// On teste ensuite si le fichier a une extension autorisée
					if(isExtAuthorized($extension))
					{
						// Ensuite, on copie le fichier uploadé ou bon nous semble.
						//$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$fichier_a_placer.$extension);
						$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$nomFichier);
						if($uploadOk)
						{
							echo("<h2 align = \"center\">Le fichier a bien &eacute;t&eacute; d&eacute;pos&eacute; sur le serveur !</h2>");
							/*
							echo "<br />juste avant l'inscription dans la base";
							echo "<br>RessourceIntitule : $RessourceIntitule";
							echo "<br>RessourceNomFichier : $RessourceNomFichier";
							echo "<br>RessourceDescription : $RessourceDescription";
							*/

							//$fichier_a_placer = $fichier_a_placer.$extension; 
							//Il faut renseigner la table documents
							include("../biblio/init.php");
							$query_insert = "INSERT INTO WR_Ressources (RessourceIntitule, RessourceNomFichier, RessourceDescription)
								VALUES ('".$RessourceIntitule."', '".$nomFichier."', '".$RessourceDescription."');";
								
								//echo "<br />requete : $query_insert";
							
							//exit;
							$results_insert = mysql_query($query_insert);
							if(!$results_insert)
							{
								echo "<FONT COLOR = \"#808080\"><br /><B>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</B></FONT>";
								echo "<BR><BR> <A HREF = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour à la gestion des tickets</A>";
								mysql_close();
								exit;
							}
							else
							{
								//On renseigne la table WR_ConducteursRessources (idConducteur, idRessource)
								//On recupère l'idRessources
								$no_dernier_id_genere = mysql_insert_id();
								/*
								echo "<br />Dernier id g&eacute;n&eacute;r&eacute; : $no_dernier_id_genere";
								echo "<br />idConducteur : $idConducteur";
								*/
								$requete2 = "INSERT INTO WR_ConducteursRessources (idRessource, idConducteur)
								VALUES ('".$no_dernier_id_genere."', '".$idConducteur."');";
								$resultat2 = mysql_query($requete2);

							}
							//echo(createReturnLink());
							//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						}
						else
						{
							echo("<h2 align = \"center\">Le fichier n'a pas pu &ecirc;tre d&eacute;pos&eacute; sur le serveur !<br /></h2>");
							//echo(createReturnLink());
							//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
						}
					}
					else
					{
						echo ("<h2 align = \"center\">Les fichiers avec l'extension $extension ne peuvent pas &ecirc;tre d&eacute;pos&eacute;s !</h2>");
						//echo (createReturnLink()."<br>");
						//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					}
				}
				else
				{
					$tailleKo = $MAX_SIZE / 1000;
					echo("<h2 align = \"center\">Vous ne pouvez pas d&eacute;poser de fichiers dont la taille est sup&eacute;rieure à : $tailleKo Ko.</h2>");
					//echo (createReturnLink()."<br>");
					//echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				}
			}
			else
			{
				echo("<h2 align = \"center\">Le fichier choisi est invalide !</h2>");
				//echo (createReturnLink()."<br>");
			}
		} 
		// Si le poids du fichier est de 0 bytes, le fichier est
		// invalide (ou le chemin incorrect) => message d'erreur
		// sinon, le script continue.
	}
	else
	{
		echo("<h2 align = \"center\">Vous n'avez pas choisi de fichier !</h2>");
		//echo (createReturnLink()."<br>");
	}

	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"WR_conducteurs.php?choixEmission=$choixEmission\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "</tr>";
		echo "</table>";
	echo "</div>";


	//echo "<CENTER><A HREF = \"$script.php?idpb=$idpb&amp;chgt=N\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A></CENTER>";
?>
	</body>
</html>
