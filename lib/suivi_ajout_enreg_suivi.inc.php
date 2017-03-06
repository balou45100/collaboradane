<?php
	$query_insert = "INSERT INTO suivis (emetteur, date_crea, date_suivi, ecl, contact_type, titre, description)
	VALUES ('".$emetteur."', '".$date_creation."', '".$date_suivi."', '".$ecl."', '".$contact_type."','".$sujet."','".$description."');";
	
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
		//On récupère le dernier identifiant pour l'enregistrement des catégories communes
		$no_dernier_id_genere = mysql_insert_id();
		//echo "<br />Dernier id g&eacute;n&eacute;r&eacute; : $no_dernier_id_genere";

		// on ajoute la catégories commune
		if ($categorie_commune <>"")
		{
			//echo "<br />verif_ticket, test ISSET categorie_commune est vrai";
			$query_ajout_cat_com = "INSERT INTO suivis_categories_communes (id_suivi,id_categorie_commune)
			VALUES ('$no_dernier_id_genere','$categorie_commune');";
			
			//echo "<br />$query_ajout_cat_com";
			
			$results_ajout_cat_com = mysql_query($query_ajout_cat_com);
		}
		echo "<h2>Suivi enregistr&eacute;</h2>";

	}
?>
