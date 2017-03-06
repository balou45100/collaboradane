<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>Stats - Vote visuel webradio 2012</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<LINK HREF="commun.css" REL="stylesheet" TYPE="text/css">
</head>
<body>

<?php
	error_reporting(0);
	function compte_occurences($lettre,$choix)
	{
		$requete = "SELECT * FROM vote_logo_webradio_2012 WHERE $choix = '".$lettre."'";
		$resultat = mysql_query($requete);
		$nbr = mysql_num_rows($resultat);
		Return $nbr;
	}
	include("connect_mysql.php");
	
	echo "<div align = \"center\">";
		echo "<h1><img src=\"logo_mt.png\">&nbsp;Statistiques des votes pour le choix du visuel de la webradio Acad&eacute;mie Orl&eacute;ans-Tours</h1>";
		//Compte du nombre de vote :
		$requete = "SELECT * FROM vote_logo_webradio_2012";
		$resultat = mysql_query($requete);
		$nbr_vote = mysql_num_rows($resultat);

		echo "<h2>Nombre de vote&nbsp;:&nbsp;$nbr_vote</h2>";
		echo "<table align=\"center\" border=\"1\" cellpadding=\"5\" cellspacing=\"2\" width=\"800px\">";
			echo "<tr>";
				echo "<th>&nbsp;</th>";
				echo "<th>Choix 1</th>";
				echo "<th>Choix 2</th>";
				echo "<th>Choix 3</th>";
				echo "<th>Total</th>";
			echo "</tr>";
			for($i=97;$i < 116;$i++)
			 {
				$var = chr($i);
				$varmaj = strtoupper(chr($i));
				//On récupère les totaux
				$nbr_c1 = compte_occurences($var,Choix1);
				$nbr_c2 = compte_occurences($var,Choix2);
				$nbr_c3 = compte_occurences($var,Choix3);
				$total = $nbr_c1*3 + $nbr_c2*2 + $nbr_c3;
				echo "<tr>";
					echo "<td align = \"center\">$varmaj</td>";
					echo "<td align = \"center\">$nbr_c1</td>";
					echo "<td align = \"center\">$nbr_c2</td>";
					echo "<td align = \"center\">$nbr_c3</td>";
					echo "<td align = \"center\">$total</td>";
				echo "</tr>";
			 } 
/*
				echo "<td align = \"center\"><b>Premier choix&nbsp;:&nbsp;</b>
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
			</tr>";
*/
		echo "</table>";
	echo "</div>";
?>
