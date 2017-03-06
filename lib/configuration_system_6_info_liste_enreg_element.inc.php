<?php
	//On récupère toutes les valeurs dans la variable array champ_saisie[]
	$bouton_envoyer_modif = $_GET['bouton_envoyer_modif']; //Pour vérifier s'il faut enregistrer

	if ($bouton_envoyer_modif == "Enregistrer")
	{
		$champ_saisie = $_GET['champ_saisie'];
		$nom_table = $_GET['nom_table'];
		$nbr_colonnes = $_GET['nbr_colonnes'];

		//On récupère les intitulés des champs de la table
		$requete="SELECT * FROM $nom_table";
		$result=mysql_query($requete);
		for ($i=0; $i<$nbr_colonnes; $i++)
		{
			$nom_champ[$i] = mysql_field_name($result, $i);
		}

		//On vérifie le nombre de champs renseignés pour savoir s'il y a un champ "actif" ou non
		$nbr_elements_retournes = count($champ_saisie);
		
		//On compare par rapport au nombre de champs de la table
		$difference = $nbr_colonnes - $nbr_elements_retournes;
		/*
		echo "<br />script enreg_element";
		echo "<br />bouton_envoyer_modif : $bouton_envoyer_modif";
		echo "<br />nbr_colonnes : $nbr_colonnes";
		echo "<br />difference : $difference";
		echo "<br />nbr_elements_retournes : $nbr_elements_retournes";
		echo "<br />nom_table : $nom_table";
		*/
		
		//On construit la requête
		$requete_enreg_element = "INSERT INTO $nom_table (";
		
		//echo "<br />$requete_enreg_element";
		
		//Si la différence est de 2 on n'utilise pas le dernier intitule de champ qui est "actif"
		if ($difference == 1) // il n'y pas de champ "actif"
		{
			$limite_compteur = $nbr_colonnes;
		}
		else
		{
			$limite_compteur = $nbr_colonnes-1;
		}
		for ($i=1; $i<$limite_compteur; $i++) //On exclu le premier champ "ID" qui est numéroté automatiquement
		{
			//On constitue la liste des noms de champs
			$liste_champs = $liste_champs."`".$nom_champ[$i]."`, ";
			//echo "<br />$liste_champs";
		}
		//On retire la dernière virgule de la liste des noms de champs
		$longueur_liste_champs = strlen($liste_champs);
		//echo "<br />longueur_liste_champs : $longueur_liste_champs";
		$longueur_liste_champs = $longueur_liste_champs-2;
		//echo "<br />longueur_liste_champs : $longueur_liste_champs";
		$liste_champs = substr($liste_champs,0,$longueur_liste_champs);

		//On constitue la liste des valeurs
		for ($i=0; $i<$limite_compteur-1; $i++) //On exclu le premier champ "ID" qui est numéroté automatiquement
		{
			//On constitue la liste des noms de champs
			$liste_valeurs = $liste_valeurs."'".$champ_saisie[$i]."', ";
			//echo "<br />$liste_valeurs";
		}
		//On retire la dernière virgule de la liste des valeurs
		$longueur_liste_valeurs = strlen($liste_valeurs);
		//echo "<br />longueur_liste_valeurs : $longueur_liste_valeurs";
		$longueur_liste_valeurs = $longueur_liste_valeurs-2;
		//echo "<br />longueur_liste_champs : $longueur_liste_champs";
		$liste_valeurs = substr($liste_valeurs,0,$longueur_liste_valeurs);
		
		// ... et on ajoute la suite
		$requete_enreg_element = $requete_enreg_element.$liste_champs.") VALUES (".$liste_valeurs.")";
		//echo "<br />$requete_enreg_element";

		//On exécute la requête
		$resultat_enreg_element = mysql_query($requete_enreg_element);
		if (!$resultat_enreg_element)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
		else
		{
			echo "<h2>L'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;</h2>";
		}
	}
	//On raffiche la liste
	include("configuration_system_6_info_liste.inc.php");
	$affichage = "N";
?>
