<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	header('Content-Type: text/html;charset=UTF-8');
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
	$util = array ();
	$i = 0;
	$j = 0;
	$pb="SELECT ID_PB, intervenant, nom_individu_emetteur FROM probleme WHERE intervenant <> '' ORDER BY ID_PB";
	$query_pb = mysql_query ($pb);
	while ($results = mysql_fetch_row ($query_pb))
	{
		$id_tick = $results[0];
		$nom_crea = $results[2];
		$req_crea = "select id_util from util,probleme where probleme.nom_individu_emetteur = util.nom and nom_individu_emetteur = '$nom_crea'";
		$query_crea = mysql_query ($req_crea);
		while ($results_crea = mysql_fetch_row ($query_crea))
		{
			$id_crea = $results_crea[0];
		}
		// Si le ticket selectionné a au moins un intervenant
		if ($results[1] <> "")
		{
			// On "explose" le champ des intervenants pour les séparer en plusieurs
			$nom = explode (";",$results[1]);
			// On compte le nombre de valeurs du tableau donc d'intervenants du ticket
			$nb = count ($nom);
			$nb_reel = $nb;
			$nb=0;
			// On sélectionne l'id correspondant pour chaucun d'eux
			for ($nb=0; $nb<$nb_reel; $nb++)
			{
				$id="select id_util from util where nom = '$nom[$nb]';";
				$query = mysql_query ($id);
				while ($results1 = mysql_fetch_row ($query))
				{
					$nom1 = $results1[0];
					//On teste si l'enregistrement existe
					$test_enregistrement = "SELECT * FROM intervenant_ticket WHERE id_tick = $id_tick AND id_crea = $id_crea AND id_interv = $nom1";
					$resultat_test_enregistrement = mysql_query($test_enregistrement);
					$nbr_enreg = mysql_num_rows($resultat_test_enregistrement);
					
					//echo "nbr_enreg : $nbr_enreg - ";
					if ($nbr_enreg == 0)
					{
						$ajout = "INSERT INTO intervenant_ticket VALUES ($id_tick, $id_crea, $nom1);";
						$maj = mysql_query ($ajout);
						echo "<b>$id_tick - </b>";
					}
					else
					{
						echo "* -";
					}
				}
			}
		}
	}
		//Fin d'insertion du code
?>
</center>
</body>
		</html>
