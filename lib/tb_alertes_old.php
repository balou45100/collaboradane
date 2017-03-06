<?php
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$origine="tb";
	$_SESSION['origine']=$origine;
	$_SESSION['origine1']=$origine;
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
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
		<body>
		<?php
		$num_results=0;
		$date = date("d");
		// Selection des tickets de l'utilisateurs
		$query1="SELECT id_alerte, id_ticket, description, NOM, TEXTE, date_alerte 
			FROM alertes, probleme 
			WHERE alertes.id_ticket = probleme.ID_PB and id_util = $id order by date_alerte";
		$execution1=mysql_query($query1);
		$num_results1 = mysql_num_rows($execution1);
		// S'il y en a 1 minimum
		if($num_results1 >= "1")
		{
			$num_results1=0;
			while($results1 = mysql_fetch_row($execution1))
			{
				//On convertit la date actuelle en TIMESTAMP (nb secondes depuis 1er janvier 1970)
				$date_auj = time();
				// On explose la date de la base de données pour la faire convertir en format TIMESTAMP
				list($annee, $mois, $jour)= explode ("-",$results1[5]);
				$date_comp= mktime(0,0,0,$mois,$jour,$annee);
				//On calcule la différence de secondes entre la date de la BDD et aujourd'hui
				$diff = $date_comp - $date_auj;
				// Sélection des paramètres d'alertes de l'utilisateur
				$req_jour = "SELECT alerte, nb_j_alerte FROM preference WHERE ID_UTIL = $id;";
				$nb_jour_a=mysql_query($req_jour);
				// CETTE PARTIE NE SERT QU'A COMPTER LE NOMBRE D'ALERTES
				while($results_j = mysql_fetch_row($nb_jour_a))
				{	
					// Si la différence est négative, donc que la date de la BDD est antérieure à celle d'aujourd'hui
					if ($results_j [0] == "1" and $diff <= (86500*$results_j[1]) and $diff >= 0)
					{
						$num_results1 ++ ;
					}
					else
					{	
						// La différence est positive donc la date de la BDD est postérieure à celle d'aujourd'hui
						if ($results_j [0] == "2" and $diff >= (-86500*$results_j[1]) and $diff <= 0)
						{
						$num_results1 ++ ;
						}
					}
				}
			}
			if($num_results1 >= "1")
			{
				//Sélection des alertes de l'utilisateur classé par date
				$query1="SELECT id_alerte, id_ticket, description, NOM, TEXTE, date_alerte 
					FROM alertes, probleme 
					WHERE alertes.id_ticket = probleme.ID_PB and id_util = $id order by date_alerte";
				$execution1=mysql_query($query1);
				// Affichage d'un message différent s'il y a une ou plusieurs alertes...
				if($num_results1 == 1)
				{
					echo "Vous avez $num_results1 alerte &nbsp &nbsp";
				}
				else
				{
					echo "Vous avez $num_results1 alertes &nbsp &nbsp";
				}
				echo"<a href= tb_alerte_cadre.php target =_top><input type=submit value='Voir en plein écran'></a><br><br>";
				// On affiche le tableau...	
				echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Date alerte</center></td><td><center>Nom</center></td><td><center>Description</center></td><td><center>Infos</center></td></tr>";
				// MEME SCRIPT QUE LIGNE 39
				while($results1 = mysql_fetch_row($execution1))
				{
					$date_auj = time();
					list($annee, $mois, $jour)= explode ("-",$results1[5]);
					$date_comp= mktime(0,0,0,$mois,$jour,$annee);
					$diff = $date_comp - $date_auj;
					$req_jour = "SELECT alerte, nb_j_alerte FROM preference WHERE ID_UTIL = $id;";
					$nb_jour_a=mysql_query($req_jour);
					while($results_j = mysql_fetch_row($nb_jour_a))
					{			
						if ($results_j [0] == "1" and $diff <= (86500*$results_j[1]) and $diff >= 0)
						{
							$date_a=$jour."/".$mois."/".$annee;
							// On affiche les resultats et un lien vers le ticket concerné
							echo "<tr bgcolor=$bg_color2><td><center>$date_a</center></td><td><center>$results1[3]</center></td><td><center>$results1[2]</center></td><td><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
						}
						else
						{
							if ($results_j [0] == "2" and $diff >= (-86500*$results_j[1]) and $diff <= 0)
							{
								$date_a=$jour."/".$mois."/".$annee;
								// On affiche les resultats et un lien vers le ticket concerné
								echo "<tr bgcolor=$bg_color2><td><center>$date_a</center></td><td><center>$results1[3]</center></td><td><center>$results1[2]</center></td><td><center><a href = consult_ticket.php?idpb=$results1[1] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
							}
						}
					}
				}
						echo"</table>";
			}			
			else
			{
				echo "Vous n'avez aucune alerte<br>";
			}
		}
		else
		{
			echo "Vous n'avez aucune alerte<br>";
		}
		$_SESSION[nb_alertes]=$num_results1;
		?>
		</body>
		</html>
