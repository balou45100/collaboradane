<?php
	//Fichier pour la connexion � la base de donn�es
	$host="db615120516.db.1and1.com";
	$user="dbo615120516";
	$passe="ipiFouvoho";
	$base="db615120516";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
