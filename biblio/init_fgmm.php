<?php
	//Fichier pour la connexion � la base de donn�es
	$host="localhost";
	$user="ticktice";
	$passe="ticetick";
	$base="collaboratice";

	@mysql_connect("$host","$user","$passe");
	$select_base=@mysql_selectdb("$base");
?>
