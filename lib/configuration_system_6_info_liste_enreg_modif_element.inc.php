<?php
	//On récupère toutes les valeurs dans la variable array champ_saisie[]
	$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //Pour vérifier s'il faut enregistrer

	//echo "<br />bouton_envoyer_modif : $bouton_envoyer_modif";
	
	if ($bouton_envoyer_modif == "Enregistrer")
	{
		//On récupère les variables
		$id_element = $_GET['id_element'];
		$valeur_a_modifier = $_GET['valeur_a_modifier'];
		$champ_saisie = $_GET['champ_saisie'];
		$nom_table = $_GET['nom_table'];
		$nbr_colonnes = $_GET['nbr_colonnes'];
		/*
		echo "<br />id_element : $id_element";
		echo "<br />nom_table : $nom_table";
		echo "<br />nbr_colonnes : $nbr_colonnes";
		
		for ($i=0; $i<$nbr_colonnes-1; $i++)
		{
			echo "<br />champ_saisie[".$i."] : $champ_saisie[$i]";
		}
		*/
		//On récupère les intitulés des champs de la table
		$requete="SELECT * FROM $nom_table";
		$result=mysql_query($requete);

		//On construit la requête
		$requete_enreg_modif = "UPDATE $nom_table SET ";
		
		//On récupère l'intitulé du champ "ID"
		$nom_champ[0] = mysql_field_name($result, 0);
		
		//On récupère les intitulés des champs, sauf le premier "ID"
		for ($i=1; $i<$nbr_colonnes; $i++)
		{
			$nom_champ[$i] = mysql_field_name($result, $i);
			//echo "<br />nom_champ[".$i."] : ".$nom_champ[$i];
			$requete_enreg_modif = $requete_enreg_modif."`".$nom_champ[$i]."` = '".$champ_saisie[$i-1]."', ";
			//echo "<br />$requete_enreg_modif";
		}
/*
		//On fait de même pour les valeurs
		
		for ($i=0; $i<$nbr_colonnes-1; $i++)
		{
			echo "<br />champ_saisie[".$i."] : $champ_saisie[$i]";
		}
*/
		//On retire la dernière virgule de la liste 
		$longueur_requete = strlen($requete_enreg_modif);
		//echo "<br />longueur_liste_champs : $longueur_liste_champs";
		$longueur_requete = $longueur_requete-2;
		//echo "<br />longueur_liste_champs : $longueur_liste_champs";
		$requete_enreg_modif = substr($requete_enreg_modif,0,$longueur_requete);

		//On rajoute la condition
		$requete_enreg_modif = $requete_enreg_modif." WHERE $nom_champ[0] = $id_element";
		//echo "<br />$requete_enreg_modif";
		
		//On exécute la requête
		$resultat_requete_maj = mysql_query($requete_enreg_modif);
		
		if (!$resultat_requete_maj)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
		else
		{
			echo "<h2>L'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;</h2>";
		}
	}

	/*
	
	$requete_maj = "UPDATE $nom_table SET 
		`INTITULE` = '".$intitule."'
	WHERE ID = '".$id_element."';";
	
	*/
?>
