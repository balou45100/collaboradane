<?php
	//Fichier pour la connexion � la base de donn�es
	$host="localhost";
	$user="root";
	$passe="ullafred";
	$base="collaboradane";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
