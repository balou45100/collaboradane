<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
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
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_rechercher_ticket.png\" ALT = \"Titre\">";
		include ("../biblio/config.php");
		include ("../biblio/fct.php");
?>
			<h2>Rercherche de tickets</h2>
			<FORM ACTION = "fouille.php" METHOD = "GET">
				<TABLE>
					<TR>
						<TD class = "etiquette">
							<b>Que rechercher&nbsp;?&nbsp;
						</TD>
						<TD>
							&nbsp;<INPUT TYPE = "text" VALUE = "" NAME = "a_chercher" SIZE = "50">
						</TD>
					</TR>
					<TR>
						<TD class = "etiquette" valign="top">
							Chercher dans&nbsp;:&nbsp;
						</TD>
						<TD>
							</b>&nbsp;<SELECT NAME = "ou">
							<OPTION SELECTED = "SC" VALUE = "SC">Sujet et corps du ticket</OPTION>
							<OPTION VALUE = "S">Sujet</OPTION>
							<OPTION VALUE = "C">Corps du ticket</OPTION>
							<OPTION VALUE = "N">N° de ticket</OPTION>
							<OPTION VALUE = "NC">Nom contact</OPTION>
							<OPTION VALUE = "INT">Intervenant</OPTION>
							<OPTION VALUE = "PROP">Propri&eacute;taire du ticket</OPTION>
							<OPTION VALUE = "TRAITE_PAR">Trait&eacute; par (n'inclus pas les tickets archiv&eacute;s)</OPTION>
							<OPTION VALUE = "TRAITE_PAR_A">Trait&eacute; par (tickets archiv&eacute;s)</OPTION>
							<OPTION VALUE = "R">N° RNE</OPTION>
							<OPTION VALUE = "SO">N° d'une soci&eacute;t&eacute;</OPTION>
						</TD>
					</TR>
					<!--TR>
						<TD class = "etiquette">
							&nbsp;
						</TD>
					  <TD class = "etiquette">
							<INPUT TYPE = "submit" VALUE = "Chercher">
						</TD>
					</TR-->
				</TABLE>
<?php
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<Td>";
									echo "<INPUT border=0 src = \"$chemin_theme_images/rechercher.png\" ALT = \"Valider\" title=\"Lancer la recherche\" border=\"0\" type=image Value= \"Chercher\" submit align=\"middle\"><br /><span class=\"IconesAvecTexte\">Lancer la recherche</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
?>
			</FORM>
		</CENTER>
	</BODY>
</HTML>
