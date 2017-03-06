<?php
	//Lancement de la session
		session_start();
?>

<!DOCTYPE HTML>

<!"Formulaire pour la recherche d'un ticket">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include("../biblio/ticket.css");
	include ("../biblio/config.php");
	include ("../biblio/fct.php");
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
			<h2>Rercherche de tickets</h2>
			<FORM ACTION = "fouille.php" METHOD = "POST">
				<TABLE BORDER = "0" align="center">
					<TR>
						<TD class = "td-bouton">
							Que rechercher ? 
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "a_chercher" SIZE = "30">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton" rowspan="11" valign="top">
							Chercher dans&nbsp;:
						</TD>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "SC" checked value="SC">&nbsp;Sujet et corps du ticket
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "S">&nbsp;Sujet
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "C">&nbsp;Corps du ticket
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "N">&nbsp;N° de ticket
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "NC">&nbsp;Nom contact
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "INT">&nbsp;Intervenant
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "PROP">&nbsp;Propri&eacute;taire du ticket
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "TRAITE_PAR">&nbsp;Trait&eacute; par (n'inclus pas les tickets archiv&eacute;s)
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "TRAITE_PAR_A">&nbsp;Trait&eacute; par (tickets archiv&eacute;s)
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "R">&nbsp;N° RNE
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "radio" NAME = "ou" VALUE = "SO">&nbsp;N° d'une soci&eacute;t&eacute;
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<!--BR>Nom étab <INPUT TYPE = "radio" NAME = "ou" VALUE = "NE"-->
						</TD>
					</TR>
					<TR>
					  <TD class = "td-bouton">
							&nbsp;
						</TD>
					  <TD class = "td-bouton">
							<INPUT TYPE = "submit" VALUE = "Chercher">
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</CENTER>
	</BODY>
</HTML>
