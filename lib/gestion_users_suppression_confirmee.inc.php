<?php
	//On récupère les infos nécessaires au sujet de l'utilisateur à supprimer
	$requete_util = "SELECT nom, mail, id_util FROM util WHERE id_util = '".$id_util_a_supprimer."'";
	$resultat_requete_util = mysql_query($requete_util);
	$num_results = mysql_num_rows($resultat_requete_util);

	if ($num_results == 0)
	{
		echo "<h2>Erreur dans la requ&ecirc;te&nbsp;!</h2>";
		mysql_close();
		exit;
	}
	else
	{
		//On récupère les informations à afficher
		$res = mysql_fetch_row($resultat_requete_util);
		//Requète de suppression des catégories appartenant à l'utilisateur
		$query = "DELETE FROM categorie WHERE NOM_UTIL = '".$res[0]."' AND MAIL_UTIL = '".$res[1]."';";
		$results = mysql_query($query);
		//Dans le cas où aucun résultats n'est retourné
		if(!$results)
		{
			echo "<h2>Probl&egrave;me de connection &agrave; la base de donn&eacute;e ou probl&egrave;me avec la requ&ecirc;te</h2>";
			echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour &agrave; la gestion des utilisateurs</A>";
			mysql_close();
			exit;
		}
		else
		{
			//On supprime les enregistrements dans la table categorie_personnelle_ticket
			$query1 = "DELETE FROM categorie_personnelle_ticket WHERE id_util = '".$id_util_a_supprimer."'";
			$results1 = mysql_query($query1);
			
			//On finit par supprimer l'utilisateur
			$query2 = "DELETE FROM util WHERE id_util = '".$id_util_a_supprimer."'";
			$results2 = mysql_query($query2);
			if(!$results2)
			{
				echo "<h2>Probl&egrave;me de connection à la base de donn&eacute;e ou probl&egrave;me avec la requ&ecirc;te</h2>";
				echo "<h2>&Agrave; ce stade les cat&eacute;gories appartenant &agrave; l'utilisateur ".$nom." ont &eacute;t&eacute; supprim&eacute;es, mais pas l'utilisateur&nbsp;!</h2>";
				echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour &agrave; la gestion des utilisateurs</A>";
				mysql_close();
				exit;
			}
			else
			{
				echo "<h2>Utilisateur/trice correctement supprim&eacute;-e</h2>";
				//echo "<A HREF = \"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
			}
		}
		//Fermeture de la connexion à la BDD
		//mysql_close();
	}
?>
