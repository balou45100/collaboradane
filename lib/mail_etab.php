<!DOCTYPE HTML>

<!"Ce fichier propose le formulaire pour envoyer un mail AUCUNE gestion des pièces jointes n'est faites">

<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<CENTER>
			<FORM ACTION = "send_mail.php" METHOD = "POST">
				<?php
					session_start();
					$mail = $_GET['mail'];
					$denomination = $_GET['denomination'];
					echo "Madame / Monsieur ".$_SESSION['nom']." d'adresse mail: ".$_SESSION['mail']."<BR>";
					echo "Vous vous apprêtez à ecrire un mail à l'établissement ".$denomination." de mail : ".$mail;
					echo "<BR><BR><FONT COLOR = \"#FF0000\">Ces données seront automatiquement ajoutées de plus une copie du mail vous sera envoyer</FONT>";
					echo "<BR><BR>Veuillez remplir les champs suivants";
					
					echo "<INPUT TYPE = \"hidden\" VALUE = \"".$mail."\" NAME = \"destinataire\">";
					echo "<BR><BR>Sujet du message : ";
					echo "<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"sujet\" SIZE = \"60\">";
					echo "<BR><BR>Texte du message : ";
					echo "<BR><BR><TEXTAREA ROWS = \"15\" COLS = \"120\" NAME = \"contenu\"></TEXTAREA><BR>";	
				?>
				<INPUT TYPE = "submit" VALUE = "envoyer">
			</FORM>
		</CENTER>
	</body>
</html>
