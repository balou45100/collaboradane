<?php
	//Fichier pour la connexion � la base de donn�es
	$host="localhost";
	$user="limbesi06";
	$passe="lecoTembl@";
	$base="collaboratice-test";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
