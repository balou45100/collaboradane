<?php
	header('Content-Type: text/html;charset=UTF-8');
/*
 *      verif_intervenant_dans_table_intervenant_ticket.php
 *      
 *      Copyright 2009 mendel <mendel@mendel-ubuntu>
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

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>sans titre</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.16" />
</head>

<body>
<?php
	include("../biblio/init.php");
	include ("../biblio/fct.php");
	include ("../biblio/config.php"); //pour récupérer les couleurs pour le tableau

$requete = "SELECT `ID_PB`, `NOM_INDIVIDU_EMETTEUR`,`ID_UTIL` FROM `probleme`,`util` WHERE `NOM_INDIVIDU_EMETTEUR`=`util`.`NOM` ORDER BY ID_PB";
$resultat = mysql_query($requete);

$nbr_lignes = mysql_num_rows($resultat);

echo "<br>nbr de lignes extraites : $nbr_lignes";

$compteur = 0;
$compteur_ok = 0;
$compteur_pok = 0;
while($res = mysql_fetch_row($resultat))
{
	$compteur++;
	$id_pb = $res[0];
	$id_util = $res[2];
	echo "<br />$compteur : id_pb : $id_pb - id_util : $id_util";
	
	//On regarde si le créateur figure dans la table intervenant_ticket
	$requete2 = "SELECT * FROM `intervenant_ticket` WHERE id_tick = $id_pb AND id_crea = $id_util AND id_interv = $id_util";
	$resultat2 = mysql_query($requete2);
	$nbr_enregistrements = mysql_num_rows($resultat2);
	
	echo " - nbr_enregistrements : $nbr_enregistrements";
	
	//On regarde s'il faut ajouter le créateur dans la table intervenant_ticket
	if ($nbr_enregistrements == 0)
	{
		$compteur_pok++;
		echo " - il faut l'ajouter";
		
		$ajout = "INSERT INTO intervenant_ticket VALUES ($id_pb, $id_util, $id_util);";
		$maj = mysql_query ($ajout);
		echo " - c'est fait";
		
	}
	else
	{
		$compteur_ok++;
		echo " - pas besoin de l'ajouter";
	}

}
	echo "<br />total : $compteur";
	echo "<br />total ok : $compteur_ok";
	echo "<br />total pas ok : $compteur_pok";
	$compteur_total = $compteur_ok+$compteur_pok;
	echo "<br />total ok + pas ok : $compteur_total";
?>
</body>
</html>
