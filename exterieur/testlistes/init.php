<?php
	//Fichier pour la connexion à la base de données
	$host="localhost";
	$user="limbesi06";
	$passe="lecoTembl@";
	$base="collaboratice-test";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
