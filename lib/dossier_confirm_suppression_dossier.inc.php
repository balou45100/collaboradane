<?php
	
	// Étape 1 : On supprime les personnes associée dans la table dos_dossier_util
	
	$requete_suppression = "DELETE FROM dos_dossier_util WHERE id_dossier = '".$id_dossier."';";
	
	//echo "<br />$requete_suppression";

	$resultat_suppression = mysql_query($requete_suppression);
	if(!$resultat_suppression)
	{
		echo "<h2>Erreur</h2>";
	}
	else
	{
		//echo "<h2>Les personnes associ&eacute;es au dossier $id_dossier ont bien &eacute;t&eacute; enlev&eacute;es de la table dos_dossier_util</h2>";
		// Étape 2 : On supprime l'enregistrement de la table dos_dossier
		$requete_suppression = "DELETE FROM dos_dossier WHERE idDossier = '".$id_dossier."';";
		
		//echo "<br />$requete_suppression";

		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
		else
		{
			//echo "<h2>L'enregistrement $id_dossier a bien &eacute;t&eacute; enlev&eacute;es de la table dos_dossier</h2>";

			// Étape 3 : On supprime l'enregistrement dans la table categorie_commune
			$requete_suppression = "DELETE FROM categorie_commune WHERE id_categ = '".$id_dossier."';";
			
			//echo "<br />$requete_suppression";

			$resultat_suppression = mysql_query($requete_suppression);
			if(!$resultat_suppression)
			{
				echo "<h2>Erreur</h2>";
			}
			else
			{
				echo "<h2>Le dossier $id_dossier a bien &eacute;t&eacute; supprim&eacute;</h2>";
			}
		}
	}
?>
