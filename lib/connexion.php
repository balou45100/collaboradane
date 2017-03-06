<!DOCTYPE HTML>
<?php
	
	include ("../biblio/config.php");
/*
	$theme = "test";
	$css = "biblio/".$theme."_collaboratice_principal.css";
	*/
	echo "<html>
	<head>
		<title>$nom_espace_collaboratif</title>
		<link href=\"../templates/collaboratice_mire_connexion.css\" rel=\"stylesheet\" type=\"text/css\" />";
/*
		<SCRIPT LANGUAGE = "JavaScript">
			//D'autres scripts sur http://www.multimania.com/jscript
			//Si vous utilisez ce script, merci de m'avertir ! 	< jscript@multimania.com >

			function DonnerFocus(nom) {
				document.forms[0].elements[nom].focus();
			}
		</SCRIPT>
*/
	echo "</head>";
	//echo "<!--body onLoad='DonnerFocus("login")'-->";
	echo "<body>";

	//include ("../biblio/config.php");

	echo "<form name = \mire\" method=\"POST\" action=\"verif_connexion.php\">";
		include ("mire_connexion.inc.php");
	echo "</form>";
?>
	</body>
</html>
