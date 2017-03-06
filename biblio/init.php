<?php
	//Fichier pour la connexion à la base de données
	$host="localhost";
	$user="root";
	$passe="azerty";
	$base="collaboradane";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
	//mysql_query("SET NAMES ISO-8859-1");
	mysql_query("SET NAMES 'utf8'");
?>
