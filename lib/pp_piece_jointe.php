<?php
  //Mise en place de la durée de la session
	//ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');

  include ("../biblio/fct.php");
  // Récupération des variables 	//
  include ("../biblio/config.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	
	$DESTINATION_FOLDER = $_POST["folder"];
	$ticket = 0; //N° du ticket à enregistrer
	$nom_doc = $_POST['nom_doc']; //Titre du document
	$module = "PP"; //Module dans lequel le ticket est inséré
	$description_doc = $_POST['description_doc']; //Description du documents joints
	
	$fichier_a_placer = "PP_".time() ;
	
	$MAX_SIZE = 5000000;
	$RETURN_LINK = $_SERVER['HTTP_REFERER'];
	
	$AUTH_EXT = array(".doc", ".DOC", ".pdf", ".PDF", ".jpg", ".JPG",
	".png", ".PNG", ".eps", ".EPS", ".ppt", ".PPT", ".xls", ".XLS",
	".gif", ".GIF", ".odt", ".ODT", ".ods", ".ODS", ".odg", ".ODG",
	".txt", ".TXT", ".gz", ".GZ", ".tar", ".TAR",  ".zip",  ".ZIP");
	function createReturnLink()
  {
	  global $RETURN_LINK;
	  echo "<a href='".$RETURN_LINK."'>Retour</a><br>";
  }
  
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
  if(!empty($_FILES["file"]["name"]))
  {
	  // Nom du fichier choisi:
	  $nomFichier = $_FILES["file"]["name"] ;
	
	
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
				    $uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$fichier_a_placer.$extension);
				    if($uploadOk)
            {
					    echo("<h2 align = \"center\">Le fichier a bien été déposé sur le serveur !</h2>");
					    /*
              echo "<br>ticket : $ticket";
					    echo "<br>nom_doc : $nom_doc";
					    echo "<br>nom_fichier : $nom_fichier";
					    echo "<br>module : $module";
					    echo "<br>description : $description_doc";
					    */
					    $fichier_a_placer = $fichier_a_placer.$extension; 
					    //Il faut renseigner la table documents
					    include("../biblio/init.php");
					    $query_insert = "INSERT INTO documents (id_ticket, nom_doc, nom_fichier, module, description_doc)
						  VALUES ('".$ticket."', '".$nom_doc."', '".$fichier_a_placer."', '".$module."', '".$description_doc."');";
						  //exit;
						  $results_insert = mysql_query($query_insert);
						  if(!$results_insert)
						  {
							  echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							  echo "<BR><BR> <A HREF = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour à la gestion des tickets</A>";
							  mysql_close();
							  exit;
						  }
						 //Création du lien dans le corps du mail
						 if (isset($_SESSION['message']))
						 {
						$_SESSION['message'] = $_SESSION['message']." <br /><a href='../".$DESTINATION_FOLDER.$fichier_a_placer."'>Pièce Jointe : ".$_POST['nom_doc']."</a>"; 
						}
						else
						{
						$_SESSION['message'] = "Saisir un mail <br /><a href='../".$DESTINATION_FOLDER.$fichier_a_placer."'>Pièce Jointe : ".$_POST['nom_doc']."</a>";
						}
						if(isset($_POST['courrier']))
						{
						$_SESSION['url'] = $DESTINATION_FOLDER.$fichier_a_placer;
						}
						createReturnLink();
					    //echo(createReturnLink());
					    //echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    }
            else
            {
					    echo("Le fichier n'a pas pu déposé sur le serveur !<br><br>");
					    //echo(createReturnLink());
					    //echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				    }
			    }
          else
          {
				    echo ("Les fichiers avec l'extension $extension ne peuvent pas être déposés !<br>");
				    //echo (createReturnLink()."<br>");
				    //echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
			    }
		    }
        else
        {
			    $tailleKo = $MAX_SIZE / 1000;
			    echo("Vous ne pouvez pas déposer de fichiers dont la taille est supérieure à : $tailleKo Ko.<br>");
			    //echo (createReturnLink()."<br>");
			    //echo "<A HREF = ".$origine.".php?idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
		    }		
	    }
      else
      {
		    echo("Le fichier choisi est invalide !<br>");
		    //echo (createReturnLink()."<br>");
	    }
		}
			
			
		?>
	
