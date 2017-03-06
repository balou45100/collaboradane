<!DOCTYPE HTML>

<!"Ce fichier envoie un message à l'administrateur">

<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="../biblio/collaboratice_principal.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
<?php
	$utilisateur = $_POST['utilisateur'];
	$message = $_POST['message'];

	$entete="From: gestion_ticket\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
	$destinataire = "jurgen.mendel@ac-orleans-tours.fr";

	switch ($message)
	{
		case "problème génération mot de passe":
			$sujet = "[GT] Problème de génération de nouveau mot de passe";
			$contenu_a_envoyer="Message de la part de M/ MME ".$utilisateur." qui n'arrive pas à générer un mot de passe.";
		break;
	}
          
	$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
	//echo "<CENTER><FONT COLOR = \"#808080\"><h2>Un message a été envoyé à l'administrateur. Il vous répondra le plus vite possible.</h2></FONT></CENTER>";
	echo "<h2>Un message a &eacute;t&eacute; envoy&eacute; à l'administrateur. Il vous répondra le plus vite possible.</h2>";
?>
	</body>
</html>
