<?php
	$saisie_enquete = $_POST['saisie_enquete'];
	
	//echo "<br />saisie_enquete : $saisie_enquete";
	
	if ($saisie_enquete=="oui")
	{
		include("connect_mysql.php");

		echo "<head>
			<title>Vote visuel webradio 2012</title>
			<LINK HREF=\"commun.css\" REL=\"stylesheet\" TYPE=\"text/css\">
			</head>
			<body>";

		//On récupère les résultats du formulaire
		$choix1 = $_POST['choix1'];
		$choix2 = $_POST['choix2'];
		$choix3 = $_POST['choix3'];
/*
		echo "<br>choix1 : $choix1";
		echo "<br>choix2 : $choix2";
		echo "<br>choix3 : $choix3";
*/
		// enregistrement du formulaire

		$requete="INSERT INTO vote_logo_webradio_2012 (choix1,choix2,choix3) VALUES ('$choix1','$choix2','$choix3')";
		
		//echo "<br />$requete<br />";
		
		$resultat=mysql_query ($requete); 
		if(!$resultat){
			echo "<H1>Une erreur s'est produite ! <br>Vérifiez que vous avez bien renseigné tous les champs et revalidez le questionnaire.
			<BR><FONT size =\"3\"><a href=enquete.php>Retour au questionnaire</a></FONT></H1>";
		}
		else
		{
			echo "<H1><br>Votre vote a bien &eacute;t&eacute; enregistr&eacute;. <br>Nous vous remercions pour votre participation.</H1>";
		}
	}
	else
	{
		echo "Acc&egrave;s interdit &agrave; cette page !";
} 
?>
