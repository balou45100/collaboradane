<?php
////// Initialisation des variables ///////////////////////////////////////////////////////
	$requete_tache="SELECT * FROM dev_taches WHERE id_tache = '".$id."'";
	$result_tache=mysql_query($requete_tache);
	$num_rows = mysql_num_rows($result_tache);
	$ligne_tache = mysql_fetch_object($result_tache);
	$id_tache = $ligne_tache->id_tache;
	$date_creation = $ligne_tache->date_creation;
	$date_echeance = $ligne_tache->date_echeance;
	$date_rappel = $ligne_tache->date_rappel;
	$description = $ligne_tache->description;
	$etat = $ligne_tache->etat;
	$visibilite = $ligne_tache->visibilite;
	$priorite = $ligne_tache->priorite;
	//$id_util_creation = $ligne_tache->id_util_creation;
	//$id_util_traitant = $ligne_tache->id_util_traitant;
	$observation = $ligne_tache->observation;
	
	//On regarde qui est le créateur de la tâche
	$requete_createur="SELECT * FROM dev_taches_util WHERE id_tache = '".$id_tache."' AND (statut_cta = '100' OR statut_cta = '110')";
	$result_createur=mysql_query($requete_createur);
	$num_rows = mysql_num_rows($result_createur);
	$ligne_createur = mysql_fetch_object($result_createur);
	$id_createur = $ligne_createur->id_util;
	
	//On regarde qui traite la tâche
	$requete_traitant="SELECT * FROM dev_taches_util WHERE id_tache = '".$id_tache."' AND (statut_cta = '110' OR statut_cta = '010')";
	$result_traitant=mysql_query($requete_traitant);
	$num_rows = mysql_num_rows($result_traitant);
	$ligne_traitant = mysql_fetch_object($result_traitant);
	$id_traitant = $ligne_traitant->id_util;

	//On transforme les différentes dates pour pouvoir les afficher dans des champs de sélections	
	$date_creation_a_traiter = strtotime($date_creation);
	$date_creation_jour = date('d',$date_creation_a_traiter);
	$date_creation_mois = date('m',$date_creation_a_traiter);
	$date_creation_annee = date('Y',$date_creation_a_traiter);

	$date_echeance_a_traiter = strtotime($date_echeance);
	$date_echeance_jour = date('d',$date_echeance_a_traiter);
	$date_echeance_mois = date('m',$date_echeance_a_traiter);
	$date_echeance_annee = date('Y',$date_echeance_a_traiter);
	
	//On initialise la date d'aujourd'hui au cas que la date de rappel n'est pas fixée
	$aujourdhui_jour = date('d');
	$aujourdhui_jour = $aujourdhui_jour+7;
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	$date_rappel_a_traiter = strtotime($date_rappel);
	$date_rappel_annee = date('Y',$date_rappel_a_traiter);

	if ($date_rappel_annee <> "1970")
	{
		$date_rappel_a_traiter = strtotime($date_rappel);
		$date_rappel_jour = date('d',$date_rappel_a_traiter);
		$date_rappel_mois = date('m',$date_rappel_a_traiter);
		$date_rappel_annee = date('Y',$date_rappel_a_traiter);
	}
	else
	{
		$date_rappel_jour = "";
		$date_rappel_mois = $aujourdhui_mois;
		$date_rappel_annee = $aujourdhui_annee;
	}
		if ($_SESSION['origine1'] == "tb")
	{
	echo "<form action=\"test.php\" method=\"get\">";
	}
	else
	{
	echo "<form action=\"dev_taches_gestion.php\" method=\"get\">";
	}
	echo "<br><table border = \"1\" align = \"center\">";
	//echo "<caption>Renseignements sur la t&acirc;che</caption>";
		echo "<colgroup>";
			echo "<col width=\"40%\">";
			echo "<col width=\"60%\">";
			//echo "<col width=\"40%\">";
			//echo "<col width=\"10%\">";
			//echo "<col width=\"20%\">";
		echo "</colgroup>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Identifiant de la t&acirc;che&nbsp;:&nbsp;</td>";
			echo "<td>$id</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Desription de la t&acirc;che&nbsp;:&nbsp;</td>";
			echo "<td>$description</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de cr&eacute;ation&nbsp;:&nbsp;</td>";
			echo "<td>$date_creation_jour/$date_creation_mois/$date_creation_annee</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</td>";
			echo "<td>$date_echeance_jour/$date_echeance_mois/$date_echeance_annee</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Date de rappel&nbsp;:&nbsp;</td>";
			echo "<td>";
			if ($date_rappel_jour <>"")
			{
				echo "$date_rappel_jour/$date_rappel_mois/$date_rappel_annee";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">&Eacute;tat de traitement&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($etat == "1")
				{
					echo "nouvelle t&acirc;che";
				}
				elseif ($etat == "2")
				{
					echo "t&acirc;che en cours de traitement";
				}
				elseif ($etat == "3")
				{
					echo "t&acirc;che achev&eacute;e";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Priorit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($priorite == "H")
				{
					echo "haute";
				}
				elseif ($priorite == "N")
				{
					echo "normale";
				}
				elseif ($priorite == "B")
				{
					echo "basse";
				}
				else
				{
					echo "&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Confidentialit&eacute;&nbsp;:&nbsp;</td>";
			echo "<td>";
				if ($visibilite == "PU")
				{
					echo "public";
				}
				elseif ($visibilite == "PR")
				{
					echo "priv&eacute;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère le nom de l'utilisateur qui a créé la tâches
				$requete_util = "SELECT nom, prenom FROM util WHERE id_util = '".$id_createur."';";
				$resultat_util = mysql_query($requete_util);
				$ligne_util = mysql_fetch_object($resultat_util);
				$nom_util_creation = $ligne_util->nom;
				$prenom_util_creation = $ligne_util->prenom;
			echo "<td class = \"etiquette\">T&acirc;che cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
			echo "<td>";
					echo "$nom_util_creation, $prenom_util_creation";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
				//On récupère le nom de l'utilisateur qui doit traiter la tâches
				$requete_util_traitant = "SELECT nom, prenom FROM util WHERE id_util = '".$id_traitant."';";
				$resultat_util_traitant = mysql_query($requete_util_traitant);
				$ligne_util_traitant = mysql_fetch_object($resultat_util_traitant);
				$nom_util_traitant = $ligne_util_traitant->nom;
				$prenom_util_traitant = $ligne_util_traitant->prenom;
			echo "<td class = \"etiquette\">T&acirc;che trait&eacute;e par&nbsp;:&nbsp;</td>";
			echo "<td>";
					echo "$nom_util_traitant, $prenom_util_traitant";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Appartient aux cat&eacute;gories&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_module_tache = "SELECT * FROM dev_taches_modules, modules_collaboratice WHERE dev_taches_modules.id_module = modules_collaboratice.id_module AND id_tache = '".$id."' ORDER BY intitule_module";
					$resultat_module_tache = mysql_query($requete_module_tache);
					$num_rows = mysql_num_rows($resultat_module_tache);
					
					if (mysql_num_rows($resultat_module_tache))
					{
						while ($ligne_module_tache=mysql_fetch_object($resultat_module_tache))
						{
							$intitule_module = $ligne_module_tache->intitule_module;
							$id_module = $ligne_module_tache->id_module;
							echo "$intitule_module<br>";
						}
					}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Personne(s) associ&eacute;e(s)&nbsp;:&nbsp;</td>";
			echo "<td>";
					$requete_partage = "SELECT * FROM dev_taches_util, util WHERE dev_taches_util.id_util = util.ID_UTIL AND id_tache = '".$id."' AND statut_cta = '001' ORDER BY nom";
					$resultat_partage = mysql_query($requete_partage);
					$num_rows = mysql_num_rows($resultat_partage);
					
					if (mysql_num_rows($resultat_partage))
					{
						while ($ligne_partage=mysql_fetch_object($resultat_partage))
						{
							$id_util_partage = $ligne_partage->ID_UTIL;
							$nom = $ligne_partage->NOM;
							$prenom = $ligne_partage->PRENOM;
							echo "$nom, $prenom<br>";
						}
					}
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class = \"etiquette\">Observations&nbsp;:&nbsp;</td>";
			echo "<td>$observation</td>";
		echo "</tr>";
	echo "</table>";
		echo "<p>";
				if ($_SESSION['origine1'] == "tb")
			{
			$_SESSION['origine'] = "tb";
			echo "<a href='javascript:;' onclick='window.parent.opener.location.reload(); self.close();'><center><input type=submit Value = Retour></center></a>";
			}
			else
			{
			echo"<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			}
			echo"<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id\" NAME = \"id\">
			<INPUT TYPE = \"hidden\" VALUE = \"$affiche_barrees\" NAME = \"affiche_barrees\">
			<INPUT TYPE = \"hidden\" VALUE = \"$origine_appel\" NAME = \"origine_appel\">
			<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
		</p>
	</form>";
?>
