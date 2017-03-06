<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
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
	<form method ="get" action="reglages.php">
		<CENTER>
		
		<?php
		//Insérer ici le code
		$tri_tick=$_GET['tri_tick'];
		$statut=$_GET['statut'];
		$nb_j_alerte=$_GET['nb_jours_alerte'];
		$nb_j_alerte_av=$_GET['nb_jours_alerte_av'];
		$tri_tac=$_GET['tri_tac'];
		$nb_j_tache=$_GET['nb_jours_tache'];
		$nb_j_tache_av=$_GET['nb_jours_tache_av'];
		$categorie=$_GET['categorie'];
		$nb_j_ech_gar=$_GET['nb_jours_echeance_gar'];
		$nb_j_ech_gar_av=$_GET['nb_jours_echeance_gar_av'];
		$nb_j_echeance_pret=$_GET['nb_jours_echeance_pret'];
		$nb_j_echeance_pret_av=$_GET['nb_jours_echeance_pret_av'];
		$pers_form=$_GET['pers_form'];
		
		//echo "<br />nb_j_alerte_av : $nb_j_alerte_av";
		
		$util="SELECT * FROM preference WHERE ID_UTIL=$id;";
		$execution= mysql_query($util);
		$num_results = mysql_num_rows($execution);
		$req_info="SELECT MAX(id_pers_ress) FROM personnes_ressources_tice;";
		$query=mysql_query($req_info);
		while ($results=mysql_fetch_row ($query))
		{
		$info = $results[0];
		}
		if($num_results == "1")
		{
		$query="UPDATE preference SET tri_tick='".$tri_tick."', statut='".$statut."', nb_j_alerte='".$nb_j_alerte."', nb_j_alerte_av='".$nb_j_alerte_av."', tri_tac='".$tri_tac."', nb_j_tache ='".$nb_j_tache."', nb_j_tache_av ='".$nb_j_tache_av."', categorie='".$categorie."', nb_j_ech='".$nb_j_ech_gar."', nb_j_pret='".$nb_j_echeance_pret."', nb_j_pret_av='".$nb_j_echeance_pret_av."' WHERE ID_UTIL = '".$id."';";
		$exe=mysql_query($query);
		}
		else
		{
		$query="INSERT INTO preference (ID_UTIL, tri_tick, statut, nb_j_alerte, nb_j_alerte_av, tri_tac, nb_j_tache, nb_j_tache_av, categorie, nb_j_ech, nb_j_pret, nb_j_pret_av, pers_form, info) 
		VALUES ('".$id."', '".$tri_tick."', '".$statut."', '".$nb_j_alerte."', '".$nb_j_alerte_av."', '".$tri_tac."', '".$nb_j_tache."', '".$nb_j_tache_av."', '".$categorie."', '".$nb_j_ech_gar."', '".$nb_j_echeance_pret."', '".$nb_j_echeance_pret_av."', 'Nsaisie', '".$info."');";
		$exe=mysql_query($query);
		}
		echo "<br>";
		if ($exe)
		{
		echo "Votre compte a bien été mis à jour";
		echo "<br><br>";
		echo "<input type=submit value=Retour a href = reglages.php>";
		}
		else
		{
		echo "Problème lors de l'enregistrement dans la base de données";
		}
		echo mysql_error();
		
		//Fin d'insertion du code
        		 ?>
		</form>
		</center>
		</body>
		</html>
