<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas l'utilisateur">

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
	<body vlink = "#FFFFFF" link = "#FFFFFF">
		<CENTER>
				<?php
					
					//Récupération des données de l'util à supprimer
					//La suppression d'un utilisateur se fait avec son nom et son mail
					
					$nom = strtoupper($_GET['nom']);
					$mail = $_GET['mail'];
					//Test des champs récupérés
					if ($_SESSION['nom'] == $nom && $_SESSION['mail'] == $mail)
					{
						echo "<FONT COLOR = \"#808080\"><B>Vous ne pouvez pas vous supprimer en étant connecté</B></FONT>";
						echo "<BR><BR><A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
						exit;
					}
					
					echo "<FONT COLOR = \"#808080\"><B>Voulez-vous vraiment supprimer cet utilisateur</B></FONT>
						<BR><BR>
						<TABLE BORDER = \"1\" BGCOLOR = \"#48D1CC\">
						<TR class = \"indre_loire\">
							<TD>
								<B>Nom</B>
							</TD>
							<TD>
								".$nom."
							</TD>
						</TR>
						<TR class = \"indre_loire\">
							<TD>
								<B>Mail</B>
							</TD>
							<TD>
								".$mail."
							</TD>
						</TR>
						</TABLE>
						<BR><BR>
						<A HREF = \"confirm_suppr_util.php?nom=".$nom."&amp;mail=".$mail."\"><IMG SRC = \"../image/oui.gif\" ALT = \"oui\"></A>
						<A HREF = \"gestion_user.php?indice=0\"><IMG SRC = \"../image/non.gif\" ALT = \"non\"></A>";
				?>
		</CENTER>
	</body>
</html>
