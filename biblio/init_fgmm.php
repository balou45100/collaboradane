<?php
	//Fichier pour la connexion à la base de données
	$host="localhost";
	$user="ticktice";
	$passe="ticetick";
	$base="collaboratice";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
