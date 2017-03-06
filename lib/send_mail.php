<!DOCTYPE HTML>

<!"Ce fichier permet d'envoyer un mail a un établissement AUCUNE gestion des pièces jointes n'est faites">

<html>
	<head>
   		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<CENTER>
			<?php
				session_start();
				$destinataire = $_POST['destinataire'];
				$sujet = $_POST['sujet'];
				$contenu = $_POST['contenu'];
				mail($destinataire, $sujet, $contenu);
				echo "message envoyé";
				echo "<BR><A HREF = \"gest_etab.php\">Retour à la gestion des établissements</A>";
			?>
		</CENTER>
	</body>
</html>
