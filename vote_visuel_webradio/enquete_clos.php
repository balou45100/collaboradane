<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>Vote visuel webradio 2012</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<LINK HREF="commun.css" REL="stylesheet" TYPE="text/css">
</head>
<body>

<?php
	error_reporting(0);
	//include("../include/config.php");
	//$fondcellule="#f3d877";
	// ------ D&eacute;but du formulaire pour les renseignements g&eacute;n&eacute;raux ------
	echo "<div align = \"center\">";
	echo "<form method=\"POST\" action=\"confirmation_enquete.php\">";
		echo "<h1><img src=\"logo_mt.png\">&nbsp;Choix visuel webradio Acad&eacute;mie Orl&eacute;ans-Tours</h1>";
		echo "<b>Pour envoyer vos r&eacute;ponses, n'oubliez pas de cliquer sur \"Envoyer les r&eacute;ponses\".</b>";

		//include("../include/boutons.php");

		echo "<table align=\"center\" border=\"1\" cellpadding=\"5\" cellspacing=\"2\" width=\"800px\">
			<tr>
				<td align = \"center\"><b>Premier choix&nbsp;:&nbsp;</b>
					<select name=\"choix1\">
						<option value=\"a\">A</option>
						<option value=\"b\">B</option>
						<option value=\"c\">C</option>
						<option value=\"d\">D</option>
						<option value=\"e\">E</option>
						<option value=\"f\">F</option>
						<option value=\"g\">G</option>
						<option value=\"h\">H</option>
						<option value=\"i\">I</option>
						<option value=\"j\">J</option>
						<option value=\"k\">K</option>
						<option value=\"l\">L</option>
						<option value=\"m\">M</option>
						<option value=\"n\">N</option>
						<option value=\"o\">O</option>
						<option value=\"p\">P</option>
						<option value=\"q\">Q</option>
						<option value=\"r\">R</option>
						<option value=\"s\">S</option>
					</select>
				</td>

				<td align = \"center\"><b>Deuxi&egrave;me choix&nbsp;:&nbsp;</b>
					<select name=\"choix2\">
						<option value=\"a\">A</option>
						<option value=\"b\">B</option>
						<option value=\"c\">C</option>
						<option value=\"d\">D</option>
						<option value=\"e\">E</option>
						<option value=\"f\">F</option>
						<option value=\"g\">G</option>
						<option value=\"h\">H</option>
						<option value=\"i\">I</option>
						<option value=\"j\">J</option>
						<option value=\"k\">K</option>
						<option value=\"l\">L</option>
						<option value=\"m\">M</option>
						<option value=\"n\">N</option>
						<option value=\"o\">O</option>
						<option value=\"p\">P</option>
						<option value=\"q\">Q</option>
						<option value=\"r\">R</option>
						<option value=\"s\">S</option>
					</select>
				</td>

				<td align = \"center\"><b>Trosi&egrave;me choix&nbsp;:&nbsp;</b>
					<select name=\"choix3\">
						<option value=\"a\">A</option>
						<option value=\"b\">B</option>
						<option value=\"c\">C</option>
						<option value=\"d\">D</option>
						<option value=\"e\">E</option>
						<option value=\"f\">F</option>
						<option value=\"g\">G</option>
						<option value=\"h\">H</option>
						<option value=\"i\">I</option>
						<option value=\"j\">J</option>
						<option value=\"k\">K</option>
						<option value=\"l\">L</option>
						<option value=\"m\">M</option>
						<option value=\"n\">N</option>
						<option value=\"o\">O</option>
						<option value=\"p\">P</option>
						<option value=\"q\">Q</option>
						<option value=\"r\">R</option>
						<option value=\"s\">S</option>
					</select>
				</td>
			</tr>
			
		</table>
		<table align=\"center\" cellpadding=\"5\" width=\"90%\">
			<tr>
				<td align=\"center\">
				<input type=\"hidden\" value=\"oui\" name=\"saisie_enquete\">
				<input type=\"submit\" value=\"Envoyer les r&eacute;ponses\" style=\"background-color: #ffffcc;\" name=\"B1\"> 
				</td>
			<tr>
		</table>
	</form>";
	echo "<img src=\"WebRadio_choix_visuel.jpg\">"; 
	echo "</div>";
?>
