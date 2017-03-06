<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas un établissement">

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
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
				<?php
										
					//Récupération des données de l'établissement à supprimer
					//La suppression d'un établissement se fait avec son numéro RNE
					
					$rne = strtoupper($_GET['rne']);
					$denomination = strtoupper($_GET['denomination']);
					$adresse = strtoupper($_GET['adresse']);
					$CP = $_GET['CP'];
					$ville = strtoupper($_GET['ville']);
					
					echo "<FONT COLOR = \"#808080\"><B>Voulez-vous vraiment supprimer cet établissement</B></FONT>
						<BR><BR>
						<TABLE BORDER = \"1\">
						<TR>
							<TD>
								<FONT COLOR = \"#808080\"><B>Num RNE</B></FONT>
							</TD>
							<TD>
								".$rne."
							</TD>
						</TR>
						<TR>
							<TD>
								<FONT COLOR = \"#808080\"><B>Dénomintion</B></FONT>
							</TD>
							<TD>
								".str_replace("*", " ",$denomination)."
							</TD>
						</TR>
						<TR>
							<TD>
								<FONT COLOR = \"#808080\"><B>Adresse</B></FONT>
							</TD>
							<TD>
								".str_replace("*", " ",$adresse)."
							</TD>
						</TR>
						<TR>
							<TD>
								<FONT COLOR = \"#808080\"><B>Code Postal</B></FONT>
							</TD>
							<TD>
								".str_replace("*", " ",$CP)."
							</TD>
						</TR>
						<TR>
							<TD>
								<FONT COLOR = \"#808080\"><B>Ville</B></FONT>
							</TD>
							<TD>
								".str_replace("*", " ",$ville)."
							</TD>
						</TR>
						</TABLE>
						<BR><BR>
						<A HREF = \"confirm_suppr_etab.php?rne=".$rne."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/oui.gif\" ALT = \"oui\"></A>
						<A HREF = \"gestion_etab.php?tri=T&amp;indice=0\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/non.gif\" ALT = \"non\"></A>";
				?>
		</CENTER>
	</body>
</html>
