<?php
	//Fichier pour la connexion à la base de données
	$host="localhost";
	$user="root";
	$passe="ullafred";
	$base="collaboradane";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
