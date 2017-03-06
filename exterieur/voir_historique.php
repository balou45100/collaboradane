<?php
	//Lancement de la session
	session_start();
?>
<html>
<head>
</head>
<?php
include ("../biblio/fct.php");
include ("../biblio/config.php");
include ("../biblio/init.php");
$num = $_GET['num'];
?>
<body>
<?php
		$requete = "select id_pb, id_pb_pere, statut_traitement, nom, texte, date_creation
					from probleme
					where id_pb = ".$num;
		//echo $requete;
		$resultat = mysql_query($requete);
		$ligne=mysql_fetch_array($resultat);
		//on affiche le premier resultat
		echo"<table border = '1'  width = '80%'>";
		echo"
		<tr>
			<td>N° Dossier : ".$ligne[0]."</td>
			<td>".$ligne[3]."</td>
			<td>".trad_statut($ligne[2])."</td>
			<td>".$ligne[5]."</td>
		</tr>
		<tr>
			<td colspan='4'>".$ligne[4]."</td>
		</tr></table>
		
		<a href='Accueil_pers_ext.php'>Retour</a>";
		$num = $ligne[0];
		$num_pere=$ligne[1];
		$requete = "select id_pb, id_pb_pere, statut_traitement, nom, texte, date_creation
					from probleme
					where id_pb_pere = $num";
		//echo $requete;
		$resultat = mysql_query($requete);
		echo"<table border = '1'  width = '80%'>";
		while(mysql_num_rows($resultat)>0)
		{		
		$ligne=mysql_fetch_array($resultat);
		echo"
		<tr>
			<td>N° Dossier : ".$ligne[0]."</td>
			<td>".$ligne[3]."</td>
			<td>".trad_statut($ligne[2])."</td>
			<td>".$ligne[5]."</td>
		</tr>
		<tr>
			<td colspan='4'>".$ligne[4]."</td>
		</tr>";
		$num = $ligne[0];
		$num_pere=$ligne[1];
		
		$requete = "select id_pb, id_pb_pere, statut_traitement, nom, texte, date_creation
					from probleme
					where id_pb_pere = $num";
		//echo $requete;
		$resultat = mysql_query($requete);
		}
		echo"</table>";
		?>
</body>
</html>