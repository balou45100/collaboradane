<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<!"Formulaire pour l'inscription d'un nouvel utilisateur">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
			<FONT COLOR = "red">Tout les champs sont obligatoires!! Sauf le numéro de portable
			<BR>
			Une fois les droits sélectionnés, il est impossible de les modifier</FONT>
			<BR><BR>
			<FORM ACTION = "verif_util.php" METHOD = "POST">
				<TABLE BORDER="0" class="head">
					<TR>
						<TD class = "td-bouton">
							Nom (le nom vous servira de login)
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "nom">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Prénom
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "prenom">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Password
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "password" VALUE = "" NAME = "password1">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Répétez le password
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "password" VALUE = "" NAME = "password2">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Mail
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "mail" SIZE = "40">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Téléphone professionnel
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "num_tel">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Poste téléphonique
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "poste_tel">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Mobile professionnel
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "num_tel_port">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Téléphone personnel
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "num_tel_perso">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Mobile personnel
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "num_tel_port_perso">
						</TD>
					</TR>
					
          <TR>
						<TD class = "td-bouton">
							Droit
						</TD>
						<TD class = "td-1">
							<SELECT NAME = "droit">
								<OPTION VALUE = "Super Administrateur">Super Administrateur</OPTION>
								<OPTION SELECTED = "Utilisateur" VALUE = "Utilisateur">Utilisateur</OPTION>
							</SELECT>
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "hidden" VALUE = "inscription" NAME = "type">
						</TD>
						<TD class = "td-bouton">
							<INPUT TYPE = "submit" VALUE = "Ok">
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</CENTER>
	</body>
</html>
