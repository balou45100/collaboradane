<?php
	//////////////////////////////////////////////////////////
	/// Traitement individuel des participant-e-s ////////////
	//////////////////////////////////////////////////////////
	
	/*
	if ($niveau_droits == "3")
	{
	*/
		echo "<hr />";
		echo "<h2>Ajout de participant-e-s individuellement</h2>";
		//echo "<br />- Ajout &agrave; l'aide de la liste d&eacute;roulante";
		//echo "<br />- Suppression en cliquant sur la croix derri&egrave;re le nom<br/><br />";
		//On affiche la liste déroulante
		echo "<form action = \"evenements_accueil.php\" method = \"get\">";
			$query_pers_ress = "SELECT * FROM personnes_ressources_tice AS prt, etablissements as e
				WHERE e.RNE = prt.codetab
				ORDER BY prt.nom, prt.prenom";
			
			//echo "<br />$query_pers_ress";
			
			$resultat_pers_ress = mysql_query($query_pers_ress);

			//$no = mysql_num_rows($results_utils);
			echo "<select name = \"id_participant\">";
			while ($ligne_utils = mysql_fetch_object($resultat_pers_ress))
			{
				$id_pers_ress = $ligne_utils->id_pers_ress;
				$nom = $ligne_utils->nom;
				$prenom = $ligne_utils->prenom;
				$codetab = $ligne_utils->codetab;
				$discipline = $ligne_utils->discipline;
				$type_etab = $ligne_utils->TYPE;
				$nom_etab = $ligne_utils->NOM;
				$ville_etab = $ligne_utils->VILLE;

				echo "<option value = \"".$id_pers_ress."\">".$nom.", ".$prenom." - ".$discipline." / ".$codetab." ".$type_etab." ".$nom_etab." ".$ville_etab."</option>";
			}
			echo "</select>";
			echo "<input type = \"submit\" VALUE = \"Ajouter comme participant-e\">";
			echo "<input type = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
			echo "<input type = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
			echo "<input type = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
			echo "<input type = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
			echo "<input type = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
			echo "<input type = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
			echo "<input type = \"hidden\" VALUE = \"ajout_participant\" NAME = \"a_faire2\">";
			echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
		echo "</form>";
		//echo "<hr />";


	//////////////////////////////////////////////////////////
	/// Traitement des participant-e-s par groupe ////////////
	//////////////////////////////////////////////////////////
		//echo "<hr />";
		echo "<h2>Ajout de participant-e-s par fonction</h2>";
		//On affiche la liste déroulante
		
		echo "<form action = \"evenements_accueil.php\" method = \"get\">";
			$query_fonction = "SELECT * FROM fonctions_personnes_ressources
				WHERE selection = 'O'
				ORDER BY intitule_fonction, annee DESC";
			
			//echo "<br />$query_fonction<br />";
			
			$resultat_fonction = mysql_query($query_fonction);

			//$no = mysql_num_rows($results_utils);
			echo "<select name = \"id_fonction\">";
			while ($ligne_fonction = mysql_fetch_object($resultat_fonction))
			{
				$id_fonction = $ligne_fonction->id_fonction;
				$intitule_fonction = $ligne_fonction->intitule_fonction;
				$annee = $ligne_fonction->annee;
				
				//On compte le nombre de personnes concernées par cette fonction
				$nbr_personnes = comptage_nbr_enregistrements_d_une_table("fonctions_des_personnes_ressources"," id_fonction = $id_fonction");

				if ($nbr_personnes == 1)
				{
					echo "<option value = \"".$id_fonction."\">".$intitule_fonction." (".$annee.") - (".$nbr_personnes." personne)"."</option>";
				}
				elseif ($nbr_personnes > 1)
				{
					echo "<option value = \"".$id_fonction."\">".$intitule_fonction." (".$annee.") - (".$nbr_personnes." personnes)"."</option>";
				}
			}
			echo "</select>";
			echo "<input type = \"submit\" VALUE = \"Ajouter les personnes de ce groupe\">";
			echo "<input type = \"hidden\" VALUE = \"$id_evenement\" NAME = \"id_evenement\">";
			echo "<input type = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
			echo "<input type = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
			echo "<input type = \"hidden\" VALUE = \"$visibilite\" NAME = \"visibilite\">";
			echo "<input type = \"hidden\" VALUE = \"$date_filtre\" NAME = \"date_filtre\">";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
			echo "<input type = \"hidden\" VALUE = \"info_evenement\" NAME = \"a_faire\">";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action2\">";
			echo "<input type = \"hidden\" VALUE = \"ajout_participant_par_fonction\" NAME = \"a_faire2\">";
			echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
			//echo "</center><br />";
		echo "</form>";
		echo "<hr />";
	//}
?>
