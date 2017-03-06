<?php
	/*
	echo $_SERVER['HTTP_USER_AGENT'];
	echo "<br />";
	echo $_SERVER['DOCUMENT_ROOT'];
	echo "<br />";
	echo $_SERVER["HTTP_HOST"];
	*/
	include 'localhost/collaboradane/biblio/config.php';
	echo "<!DOCTYPE HTML>";
	echo "<html>";
	echo "<head>";
		echo "<title>$nom_espace_collaboratif</title>";
		$feuille_de_style = "../templates/collaboratice_mire_connexion.css\" rel=\"stylesheet\" type=\"text/css\"";
		
		//echo "<br />feuille_de_style : $feuille_de_style";
		
		//echo "<link href=\"../templates/collaboratice_mire_connexion.css\" rel=\"stylesheet\" type=\"text/css\" />";
		echo "<link href=$feuille_de_style>";

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

	echo "</body>";
	echo "</html>";
?>
