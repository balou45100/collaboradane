<?php
/*
 *      ajout-id_util_dans_table_categorie.php
 *      
 *      Copyright 2011 mendel <mendel@hp-1249>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>sans titre</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.20" />
</head>

<body>
<?php
	include ("../biblio/init.php");
	//On balaie la table util pour récupérér chaque utilisateur
	$requete = "SELECT * FROM util ORDER BY ID_UTIL";
	
	//echo "<br />$requete";
	
	$resultat_requete = mysql_query($requete);
	$nombre = mysql_num_rows($resultat_requete);

	echo "<br />nombre d'utilisateurs : $nombre<br />";

	while ($ligne = mysql_fetch_object($resultat_requete))
	{
		$id_util_extrait=$ligne->ID_UTIL;
		$nom_util_extrait = $ligne->NOM;
		//echo "<br />id_util_extrait : $id_util_extrait - nom_util_extrait : $nom_util_extrait";
		//On met à jour la table categorie
		$req_maj = "UPDATE `categorie` SET `id_util` = '".$id_util_extrait."' WHERE  `NOM_UTIL` LIKE  '".$nom_util_extrait."'";
		//echo "<br />$req_maj";
		echo "*";
		$res_maj = mysql_query($req_maj);
	}

	echo "<br />$nombre fiches ont &eacute;t&eacute; mise &agrave; jour";
?>
</body>

</html>
