<?php
	echo "<h2>Enregistrement de l'&eacute;v&eacute;nement<h2>";
	$titre_evenement = str_replace("'", "&#39;", $titre_evenement);

	$query_insert = "INSERT INTO evenements (date_creation, titre_evenement, date_evenement_debut, date_evenement_fin, heure_debut_evenement, heure_fin_evenement, fk_id_util, fk_id_dossier, fk_rne, fk_repertoire, autre_lieu, detail_evenement, annee)
	VALUES ('".$date_creation."','".$titre_evenement."', '".$date_evenement_debut."', '".$date_evenement_fin."', '".$heure_debut_evenement."', '".$heure_fin_evenement."', '".$fk_id_util."', '".$fk_id_dossier."', '".$fk_rne."', '".$fk_repertoire."', '".$autre_lieu."', '".$detail_evenement."', '".$om_annee_budget."');";

	//echo "<br />query_insert : $query_insert";

	$results_insert = mysql_query($query_insert);
	if(!$results_insert)
	{
		echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
		echo "<br /><br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
		mysql_close();
		exit;
	}
	else
	{
		echo "<h2>&Eacute;v&eacute;nement enregistr&eacute;</h2>";
	}
?>
