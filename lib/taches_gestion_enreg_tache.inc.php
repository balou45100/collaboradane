<?php
	$description_tache = $_GET['description_tache']; //récupération du nom du fichier
	$jour = $_GET['jour'];
	$mois = $_GET['mois'];
	$annee = $_GET['annee'];
	$jour_rappel = $_GET['jour_rappel'];
	$mois_rappel = $_GET['mois_rappel'];
	$annee_rappel = $_GET['annee_rappel'];
	$nbr_jours = $_GET['nbr_jours'];
	$etat = $_GET['etat'];
	$priorite = $_GET['priorite'];
	$visibilite = $_GET['visibilite'];
	$id_categorie = $_GET['id_categorie'];
	$id_util_traitant = $_GET['id_util_traitant'];
	$id_util_associes = $_GET['id_util_associes'];
	$observation_tache = $_GET['observation_tache'];
	$id_util = $_SESSION['id_util'];
	$etat = "1";
	
	//echo "<br />id_util_traitant : $id_util_traitant";
	
/*
	echo "<br>description_tache : $description_tache";
	echo "<br>jour : $jour";
	echo "<br>mois : $mois";
	echo "<br>annee : $annee";
	echo "<br>nbr_jours : $nbr_jours";
	echo "<br>jour_rappel : $jour_rappel";
	echo "<br>mois_rappel : $mois_rappel";
	echo "<br>annee_rappel : $annee_rappel";
	echo "<br>etat : $etat";
	echo "<br>visibilite : $visibilite";
	echo "<br>priorite : $priorite";
	echo "<br>id_util : $id_util";
	echo "<br>id_categorie : $id_categorie";
	echo "<br>id_util_traitant : $id_util_traitant";
	echo "<br>observation_tache : $observation_tache";
	echo "<br>aujourd'hui : $date_aujourdhui";
//	echo "<br>1 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";

*/


//Début des différents traitements


//////////////////////////////////////////////////////////////////////////
/////// Génération des différentes dates /////////////////////////////////
//////////////////////////////////////////////////////////////////////////
	$aujourdhui = date('Y/m/d');
	//$date_creation = date('Y/m/d',$aujourdhui);
	$date_creation = date('Y/m/d');
	$aujourdhui = strtotime($aujourdhui); //transforme la date en entier

	if ($nbr_jours == 0)
	{
		$date_echeance_a_enregistrer = crevardate($jour,$mois,$annee);
	}
	else
	{
		//echo "<br>1 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";
		$aujourdhui = date('Y/m/d');
		$aujourdhui = strtotime($aujourdhui);
		$date_echeance_a_enregistrer = $aujourdhui + ($nbr_jours*86400);
		//echo "<br>2 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_echeance_a_enregistrer : $date_echeance_a_enregistrer";
		$date_echeance_a_enregistrer = date('Y/m/d',$date_echeance_a_enregistrer);
		//echo "<br>3 - aujourdhui : $aujourdhui";
		//echo "<br>nbr_jours : $nbr_jours";
		//echo "<br>date_echeance_a_enregistrer : $date_echeance_a_enregistrer";
		
	}
	//echo "<br>date_echeance_a_enregistrer : $date_echeance_a_enregistrer";
	//echo "<br>date_creation : $date_creation";
	
	if ($jour_rappel <>"")
	{
		$date_rappel_a_enregistrer = crevardate($jour_rappel,$mois_rappel,$annee_rappel);
		//echo "<br>date_rappel_a_enregistrer : $date_rappel_a_enregistrer";
	}

	//On enregistre la tâche
	$requete_ajout = "INSERT INTO `taches` (`date_creation`,`date_echeance`,`date_rappel`,`description`,`etat`,`visibilite`,`priorite`,`observation`)
		VALUES ('".$date_creation."','".$date_echeance_a_enregistrer."','".$date_rappel_a_enregistrer."','".$description_tache."','".$etat."','".$visibilite."','".$priorite."','".$observation_tache."')";
	$resultat_ajout = mysql_query($requete_ajout);
/*
	if(!$resultat_ajout)
	{
		echo "<br>Erreur";
	}
	else
	{
		echo "<h2>La t&acirc;che a &eacute;t&eacute; enregistr&eacute;e</h2>";
	}
*/
	//On récupère l'id_tache
	$id_tache_insere = mysql_insert_id();
	//echo "<br />Voici le dernier identifiant enregistré : $id_tache_insere";
	
	//On renseigne la table taches_util avec le créateur et la personne traitant la tâche
	//Il faut regarder si le créateur et le traitant sont la même personne
	if (($id_util == $id_util_traitant) OR ($id_util_traitant == 0))
	{
		$requete_ajout_tache_util = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
			VALUES ('".$id_tache_insere."','".$id_util."','110')";
		$resultat_ajout_tache_util = mysql_query($requete_ajout_tache_util);
/*
		if(!$resultat_ajout_tache_util)
		{
			echo "<br>Erreur";
		}
		else
		{
			echo "<h2>Le cr&eacute;ateur a &eacute;t&eacute; enregistr&eacute;</h2>";
		}
*/	
	} //Fin if (($id_util == $id_util_traitant) OR ($id_util_traitant == 0))
	elseif (($id_util <> $id_util_traitant) AND ($id_util_traitant <> 0))
	{
		$requete_ajout_tache_util = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
			VALUES ('".$id_tache_insere."','".$id_util."','100')";
		$resultat_ajout_tache_util = mysql_query($requete_ajout_tache_util);
/*
		if(!$resultat_ajout_tache_util)
		{
			echo "<br>Erreur";
		}
		else
		{
			echo "<h2>Le cr&eacute;ateur a &eacute;t&eacute; enregistr&eacute;</h2>";
		}
*/
		$requete_ajout_tache_traitant = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
			VALUES ('".$id_tache_insere."','".$id_util_traitant."','010')";
		$resultat_ajout_tache_traitant = mysql_query($requete_ajout_tache_traitant);
/*
		if(!$resultat_ajout_tache_traitant)
		{
			echo "<br>Erreur";
		}
		else
		{
			echo "<h2>La t&acirc;che a été enregistrée</h2>";
		}
*/
	}
	//On renseigne la table taches_util avec les personnes associées
	//Il faudra vérifier que le créateur et le traitant ne soient pas enregistrés une deuxième fois
	
	$nombre_elements = count($id_util_associes);
	if (($id_util_associes[0] <> 0) OR ($id_util_associes[0] == 0 AND $nombre_elements >1))
	{
		//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
		$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
		while($i < $nombre_elements)
		{
			//echo "<br />compteur : $i - id_util : $id_util - id_util_traitant : $id_util_traitant - id_util_associe : $id_util_associes[$i]";
			if (($id_util_associes[$i] <> $id_util) AND ($id_util_associes[$i] <> $id_util_traitant) AND $id_util_associes[$i] <> 0)
			{
				//echo " - On enregistrera la fiche";
				$requete_ajout_personne_associee = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
					VALUES ('".$id_tache_insere."','".$id_util_associes[$i]."','001')";
				$resultat_ajout_personne_associee = mysql_query($requete_ajout_personne_associee);
/*
				if(!$resultat_ajout_personne_associee)
				{
					echo "<br>Erreur";
				}
				else
				{
					echo "<h2>La personne associ&eacute;e a &eacute;t&eacute; enregistr&eacute;e</h2>";
				}
*/
			}
			$i++;
		} 
	}
/*
	else
	{
		echo "<br />Pas de personnes associ&eacute;es &agrave; la t&acirc;che";
	}
*/	
	//On renseigne la table taches_categories si nécessaire
/*
	if ($id_categorie <> "")
	{
		$requete_enreg_categ = "INSERT INTO taches_categories (`id_tache`,`id_categorie`)
			VALUES ('".$id_tache_insere."','".$id_categorie."')";
		$resultat_enreg_categ = mysql_query($requete_enreg_categ);
		if (!$resultat_enreg_categ)
		{
			echo "<br>Erreur lors de l'enregistrement de la cat&eacute;gorie";
		}
	}
*/
	$nombre_elements = count($id_categorie);
	if (($id_categorie[0] <> 0) OR ($id_categorie[0] == 0 AND $nombre_elements >1))
	{
		//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
		$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
		while($i < $nombre_elements)
		{
			//echo "<br />compteur : $i - id_util : $id_util - id_util_traitant : $id_util_traitant - id_util_associe : $id_util_associes[$i]";
			if ($id_categorie[$i] <> 0)
			{
				//echo " - On enregistrera la fiche";
				$requete_enreg_categ = "INSERT INTO taches_categories (`id_tache`,`id_categorie`)
					VALUES ('".$id_tache_insere."','".$id_categorie[$i]."')";
				$resultat_enreg_categ = mysql_query($requete_enreg_categ);
				if (!$resultat_enreg_categ)
				{
					echo "<br>Erreur lors de l'enregistrement de la cat&eacute;gorie";
				}
/*
				if(!$resultat_ajout_personne_associee)
				{
					echo "<br>Erreur";
				}
				else
				{
					echo "<h2>La personne associ&eacute;e a &eacute;t&eacute; enregistr&eacute;e</h2>";
				}
*/
			}
			$i++;
		} 
	}
1
	
?>
