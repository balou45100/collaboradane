<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
		$largeur_tableau = "80%";
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
    	?>
	</head>
	<!"Pour protéger les couleur des liens des boutons"
	"Choix de la couleur blanche, car sinon il apparait un carré de couleur moche autour des images"
	"Correspondant à la suppression et à la modification">
	<body link="#48D1CC" Vlink="#48D1CC">
		<CENTER>
		
<?php
	echo "<TABLE align=\"center\" width = \"$largeur_tableau\" BORDER = \"0\" BGCOLOR =\"$bg_color1\">
		<TR>
			<TD align = \"center\">
           		<h2>\"CollaboraTICE\"<br>Espace collaboratif de la Mission académique TICE</h2>
           	</TD>
           	<TD align = \"center\">
           		<img border=\"0\" src = \"$chemin_theme_images/$logo\" ALT = \"Logo\">
           	</TD>
       	</TR>
    </TABLE>";
	//Insérer ici le code
	// Initialisation tableau et compteurs


	//on balaie la table taches pour extraire les créateurs et de les balancer dans la table taches_util
	/*
	$util = array ();
	$i = 0;
	$j = 0;
	*/
	$taches="SELECT id_tache, id_util_creation, id_util_traitant FROM taches ORDER BY id_tache";
	$query_taches = mysql_query ($taches);
	$nombre_elements = mysql_num_rows($query_taches);
	echo "<br />nombre de tâches : $nombre_elements";
	$compteur = 0;
	$compteur_existe_tache = 0;
	$compteur_existe_crea = 0;
	$compteur_existe_trait = 0;
	while ($results = mysql_fetch_row ($query_taches))
	{
		$compteur = $compteur + 1;
		$id_tache = $results[0];
		$id_util_creation = $results[1];
		$id_util_traitant = $results[2];
		
		echo "<br />$compteur - id_tache : $results[0] - id_util_creation : $results[1] - id_util_traitant : $results[2]";
		
		//On vérifie si la tâche existe dans la table taches_util
		$verif_tache="SELECT id_tache, id_util, statut_cta FROM taches_util WHERE id_tache = $results[0]";
		$query_verif_tache = mysql_query ($verif_tache);
		$existe_tache = mysql_num_rows($query_verif_tache);
		
		if ($existe_tache >0)
		{
			$compteur_existe_tache = $compteur_existe_tache + 1;
			echo " - <b>fiche pour la tâche existe</b>";
		}
		else
		{
			echo " - fiche pour la tâche à ajouter";
			
			// 2 cas de figure : id_util_creation = id_util_traitant ou id_util_creation <> id_util_traitant
			
			if ($id_util_creation == $id_util_traitant)
			{
				echo " - créateur et traitant sont la même personne";
				$requete_ajout_fiche_tache = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
					VALUES ('".$results[0]."','".$results[1]."','110')";
				$resultat_ajout_fiche_tache = mysql_query($requete_ajout_fiche_tache);
				if(!$resultat_ajout_fiche_tache)
				{
					echo "<br>Erreur";
				}
				else
				{
					echo "<h2>La fiche a été enregistrée</h2>";
				}
			}
			else
			{
				echo "<b> - créateur et traitant sont des personnes différentes</b>";
				//On ajoute le créateur de la tâche
				$requete_ajout_fiche_tache = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
					VALUES ('".$results[0]."','".$results[1]."','100')";
				$resultat_ajout_fiche_tache = mysql_query($requete_ajout_fiche_tache);
				if(!$resultat_ajout_fiche_tache)
				{
					echo "<br>Erreur";
				}
				else
				{
					echo "<h2>La fiche a été enregistrée</h2>";
				}
				//On ajoute le traitant de la tâche
				$requete_ajout_fiche_tache = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut_cta`)
					VALUES ('".$results[0]."','".$results[2]."','010')";
				$resultat_ajout_fiche_tache = mysql_query($requete_ajout_fiche_tache);
				if(!$resultat_ajout_fiche_tache)
				{
					echo "<br>Erreur";
				}
				else
				{
					echo "<h2>La fiche a été enregistrée</h2>";
				}
			}
			/*
			$requete_ajout_fiche_tache = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut`)
				VALUES ('".$results[0]."','".$results[1]."','0')";
			$resultat_ajout_fiche_tache = mysql_query($requete_ajout_fiche_tache);
			if(!$resultat_ajout_fiche_tache)
			{
				echo "<br>Erreur";
			}
			else
			{
				echo "<h2>La fiche a été enregistrée</h2>";
			}
			*/
		}

		//On vérifie si le créateur existe dans la table taches_util
		$verif_crea="SELECT id_tache, id_util, statut_cta FROM taches_util WHERE id_tache = $results[0] AND id_util = $results[1] AND (statut_cta = '100' OR statut_cta = '110')";
		$query_verif_crea = mysql_query ($verif_crea);
		$existe = mysql_num_rows($query_verif_crea);
		
		if ($existe == 1)
		{
			$compteur_existe_crea = $compteur_existe_crea + 1;
			echo " - <b>fiche pour le créateur existe</b>";
		}
		else
		{
			echo " - fiche pour le créateur à ajouter";
		}
		
		//On vérifie si le traitant existe dans la table taches_util
		$verif_trait="SELECT id_tache, id_util, statut_cta FROM taches_util WHERE id_tache = $results[0] AND id_util = $results[2] AND (statut_cta = '110' OR statut_cta = '010')";
		$query_verif_trait = mysql_query ($verif_trait);
		$existe_trait = mysql_num_rows($query_verif_trait);
		
		if ($existe_trait == 1)
		{
			$compteur_existe_trait = $compteur_existe_trait + 1;
			echo " - <b>fiche pour le traitant existe</b>";
		}
		else
		{
			
			echo " - fiche pour le traitant à ajouter";
			//Il faut regarder si la tâches à un traitant
			if ($results[2] == 0) //Il n'y a pas de traitant
			{
				//echo " - Il n'y a pas de traitant pour la tâche $results[0]";
				$traitant = $results[1];
			}
			else
			{
				//echo " - Il n'y a pas de traitant pour la tâche $results[0]";
				$traitant = $results[2];
			}
			/*
			$requete_ajout_fiche_traitant = "INSERT INTO `taches_util` (`id_tache`,`id_util`,`statut`)
				VALUES ('".$results[0]."','".$traitant."','1')";
			$resultat_ajout_fiche_traitant = mysql_query($requete_ajout_fiche_traitant);
			if(!$resultat_ajout_fiche_traitant)
			{
				echo "<br>Erreur";
			}
			else
			{
				echo "<h2>La fiche avec le traitant a été enregistrée</h2>";
			}
			*/
		}
	} //Fin while ($results = mysql_fetch_row ($query_taches))
	echo "<br />Il existe $compteur_existe_tache fiches de tâches";
	echo "<br />Il existe $compteur_existe_crea fiches de créateurs de tâches";
	echo "<br />Il existe $compteur_existe_trait fiches de traitants de tâches";
		//Fin d'insertion du code
?>
</center>
</body>
		</html>
