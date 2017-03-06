<?php
	// On récupère les variables
	$id_util = $_GET['id_util'];
	$niveau_droit = $_GET['niveau_droit'];
	
	/*
	echo "<br />id_util : $id_util";
	echo "<br />niveau_droit : $niveau_droit";
	*/
	// On enregistre les droits
	
	$requete_ajout = "INSERT INTO `util_droits` (`id_util`,`id_droit`,`niveau`)
		VALUES ('".$id_util."','".$id_droit."','".$niveau_droit."')";

	//echo "<br />$requete_ajout";
	
	$resultat_ajout = mysql_query($requete_ajout);

	if(!$resultat_ajout)
	{
		echo "<h2>Les droits n'ont pas pu &ecirc;tre enregistr&eacute;s</h2>";
	}
	else
	{
		echo "<h2>Les droits ont &eacute;t&eacute; enregistr&eacute;s</h2>";
	}


?>
