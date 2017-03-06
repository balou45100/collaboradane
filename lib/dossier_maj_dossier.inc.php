<?php
	$id_dossier = $_GET['id_dossier'];
	$libelleDossier = $_GET['libelleDossier'];
	$description = $_GET['description'];
	$statut = $_GET['statut'];
	$id_responsable = $_GET['id_responsable'];
	$id_util_responsable_dans_base = $_GET['id_util_responsable_dans_base'];

/*
	echo "<br>id_dossier : $id_dossier";
	echo "<br>libelleDossier : $libelleDossier";
	echo "<br>description : $description";
	echo "<br>statut : $statut";
	echo "<br>id_responsable : $id_responsable";
*/

	// Étape 1 : enregistrement dans la table categorie_commune

	$requete_maj = "UPDATE categorie_commune SET 
		`intitule_categ` = '".$libelleDossier."',
		`description_categ` = '".$description."',
		`actif` = '".$statut."'
	WHERE id_categ = '".$id_dossier."';";
	
	echo "<br /$requete_maj>";

	$result_maj = mysql_query($requete_maj);
	if (!$result_maj)
	{
		echo "<h2>Erreur lors de l'enregistrement</h2>";
	}
	else
	{
		// Étape 2 : On vérifie le changement de responsable et on modifie la table dos_dossier en conséquence
		 
		if ($id_responsable <> $id_util_responsable_dans_base)
		{
			// On met à jour la table dos_dossier
			$requete_maj = "UPDATE dos_dossier SET 
				`responsable` = '".$id_responsable."'
			WHERE idDossier = '".$id_dossier."';";
			
			$result_maj = mysql_query($requete_maj);
			if (!$result_maj)
			{
				echo "<h2>Erreur lors de l'enregistrement</h2>";
			}
			else
			{
				// Étape 3 : On regarde si le nouveau responsable fait partie des personnes associées, si oui, on le supprime de la table dos_dossier_util
				$requete = "DELETE FROM dos_dossier_util
								WHERE id_util = ".$id_responsable." AND id_dossier = ".$id_dossier;
				$resultat = mysql_query($requete);
			}
			
		}
		echo "<h2>Le dossier &laquo;&nbsp;$libelleDossier&nbsp;&raquo; a bien &eacute;t&eacute; modifi&eacute;</h2>";
	}
?>
