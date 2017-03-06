<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
			<?php
				//Petit message d'accueil, résumant le nom et les droits de l'accesseur
				include("../biblio/fct.php");
				if ($_SESSION['sexe'] == "M") {
          $titre_a_afficher="Monsieur";
        } else {
          $titre_a_afficher="Madame";
        }
				if ($_SESSION['droit'] == "Utilisateur") {
          echo "<FONT COLOR = \"#808080\"><B>Bienvenue $titre_a_afficher ".strtoupper($_SESSION['nom'])."</B></FONT>";
				  echo "<BR><BR><FONT COLOR = \"#808080\"><B>Nous sommes le&nbsp;".date('j/m/Y')."</B></FONT>";
        } else {
          echo "<BR><BR><FONT COLOR = \"#808080\"><B>Vous êtes logué en temps que ".$_SESSION['droit']."</B></FONT>";
        }
      ?>
		</CENTER>
	</body>
</html>
