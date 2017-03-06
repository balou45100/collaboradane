<?php
	if ($sense_tri == "")
	{
		$sense_tri="DESC";
	}
	//echo "<br>etat : $etat";
	if ($etat == "Oui")
	{
		switch ($tri2)
		{
			case 'ID' :
				//$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND MODULE = 'GT' AND `categorie_commune`.`id_categ`=$tri ORDER BY ID_PB $sense_tri;";
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY ID_PB $sense_tri;";
			break;
			case 'Cr' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			break;
			case 'P' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			break;
			case 'RNE' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			break;
			default :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT <> 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY ID_PB DESC;";
			break;
		}
	}
	else
	{
		switch ($tri2)
		{
			case 'ID' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT = 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY ID_PB $sense_tri;";
			break;
			case 'Cr' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT = 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY NOM_INDIVIDU_EMETTEUR $sense_tri, ID_PB DESC;";
			break;
			case 'P' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT = 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY PRIORITE $sense_tri,ID_PB DESC;";
			break;
			case 'RNE' :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT = 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY NUM_ETABLISSEMENT $sense_tri, ID_PB DESC;";
			break;
			default :
				$query = "SELECT * FROM probleme,categorie_commune,categorie_commune_ticket WHERE `probleme`.`ID_PB` = `categorie_commune_ticket`.`id_ticket` AND `categorie_commune_ticket`.`id_categ` = `categorie_commune`.`id_categ` AND STATUT != 'R' AND STATUT = 'A' AND `categorie_commune`.`id_categ`=$tri ORDER BY ID_PB DESC;";
			break;
		}
	}
	$requete_complete = $query;
?>
