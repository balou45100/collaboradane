<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

	<html>
	<head>
<?php
	include ("../biblio/config.php");
	echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<link href="../templates/collaboratice_mire_connexion.css" rel="stylesheet" type="text/css" />
			<SCRIPT LANGUAGE = "JavaScript">
			//D'autres scripts sur http://www.multimania.com/jscript
			//Si vous utilisez ce script, merci de m'avertir ! 	< jscript@multimania.com >

			function DonnerFocus(nom) {
				document.forms[0].elements[nom].focus();
			}
		</SCRIPT>
	</head>
	<body onLoad='DonnerFocus("login")'>
	<!--div align = "center"-->
<?php
	include("../biblio/config.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}

	//Destruction des valeurs figurant dans la session
	//Puis destruction de la session elle-même		
	unset($_SESSION['nom']);
	unset($_SESSION['id_util']);
	unset($_SESSION['mail']);
	unset($_SESSION['droit']);
	unset($_SESSION['sexe']);

	session_destroy();
	
	//On propose la mire pour se connecter &agrave; nouveau
	echo "<form method=\"POST\" action=\"verif_connexion.php\">";
		include ("mire_connexion.inc.php");
	echo "</form>";
	//echo "<br /><br />$version - $version_date";
?>		
	<!--/div-->
	</body>
</html>


