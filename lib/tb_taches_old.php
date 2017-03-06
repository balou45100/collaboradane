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
		//on initialise le timestamp pour la date du jour
		$date_auj = time();

		$num_results2=0;
		$req_tick="SELECT tri_tac, date_t, nb_j_tache FROM preference WHERE ID_UTIL = $id";
		$exe_tick=mysql_query($req_tick);
		while($recup_tick = mysql_fetch_row ($exe_tick))
		{
			$tri_tac = $recup_tick[0];
			$date_t = $recup_tick[1];
			$nb_j_t= $recup_tick [2];
		}
		$base="SELECT taches.id_tache, description, priorite, date_echeance FROM taches
		WHERE id_util_creation = $id AND etat !='3'";
		switch ($tri_tac)
		{
			case "0" :
				$req_tri= "";
			break;
			case "1" :
				$req_tri= " AND visibilite = 'PR'";
			break;
			case "2" :
				$req_tri= " AND visibilite = 'PU'";
			break;
		}
		//Ordre d'affichage
		$ordre_affichage = " ORDER BY date_echeance ASC";
		$query2=$base.$req_tri.$ordre_affichage;
		//echo "<br />requete : $query2";	
		$execution2=mysql_query($query2);
		if ($execution2)
		{
			$num_results2 = mysql_num_rows($execution2);
			if($num_results2 >= "1")
			{
				$num_results2=0;
				while($results2 = mysql_fetch_row($execution2))
				{
					//$date_auj = time();
					//echo "<br />date_auj : $date_auj";
					//On récupère la date de la tâche enregistrée
					list($annee1, $mois1, $jour1)= explode ("-",$results2[3]);
					//On crée le timestamp correspondant à la date de la tâche enregistrée
					$date_comp1= mktime(0,0,0,$mois1,$jour1,$annee1);
					//On calcul la différence entre les deux
					$diff1 = $date_comp1 - $date_auj;
					//On récupère les préférences enregistrées pour l'utilisateur connecté
					$req_jour1 = "SELECT date_t, nb_j_tache FROM preference WHERE ID_UTIL = $id;";
					$nb_jour_a1=mysql_query($req_jour1);
					//On compte le nombre de tickets concernés
					while($results_j1 = mysql_fetch_row($nb_jour_a1))
					{	
						//if ($results_j1 [0] == "1" and $diff1 <= (86400*$results_j1[1]) and $diff1 >= 0)
						if ($results_j1 [0] == "1" AND $date_comp1 <= ($date_auj+86400*$results_j1[1]) AND $date_comp1 >= ($date_auj-86400*$results_j1[1]))
						{
							$num_results2 ++ ;
						}
						else
						{
							if ($results_j1 [0] == "2" and $diff1 >= (-86400*$results_j1[1]) and $diff1 <= 0)
							{
								$num_results2 ++ ;
							}
						}
					} //Fin while compte des enregistrements
				} //Fin while($results2 = mysql_fetch_row($execution2))
				if($num_results2 >= "1")
				{
					$query1=$base.$req_tri.$ordre_affichage;
					$execution1=mysql_query($query1);
					echo "<form method = get target = _top action = tb_tache_cadre.php>";
					if($num_results2 == 1)
					{
						echo "Vous avez $num_results2 tâche en attente &nbsp &nbsp";
					}
					else
					{
						echo "Vous avez $num_results2 tâches en attente &nbsp &nbsp";
					}
					echo"<input type=submit value='Voir en plein écran' a href= tb_tache_cadre.php><br><br>";
					echo "</form>";
					echo "<table border = 1 align = center BGCOLOR = #48D1CC><tr><td><center>Date d'échéance</center></td><td><center>Priorité</center></td><td><center>Description</center></td><td><center>Catégorie</center></td><td><center>Infos</center></td></tr>";
					while($results2 = mysql_fetch_row($execution1))
					{	
						if ($results2[2] == "N")
						{
							$priorite = "Normale";
						}
						else
						{
							if ($results2[2] == "H")
							{
								$priorite = "Haute";
							}
							else
							{
								$priorite = "Basse";
							}
						}
						//$date_auj = time();
						list($annee1, $mois1, $jour1)= explode ("-",$results2[3]);
						$date_comp1= mktime(0,0,0,$mois1,$jour1,$annee1);
						$diff1 = $date_comp1 - $date_auj;
						$req_jour1 = "SELECT date_t, nb_j_tache FROM preference WHERE ID_UTIL = $id;";
						$nb_jour_a1= mysql_query($req_jour1);
						while($results_j1 = mysql_fetch_row($nb_jour_a1))
						{			
							//if ($results_j1 [0] == "1" and $diff1 <= (86400*$results_j1[1]) and $diff1 >= 0)
							if ($results_j1 [0] == "1" AND $date_comp1 <= ($date_auj+86400*$results_j1[1]) AND $date_comp1 >= ($date_auj-86400*$results_j1[1]))
							{
								$req_catf = "SELECT id_categ, intitule_categ FROM taches_categories, categorie_commune WHERE taches_categories.id_categorie = categorie_commune.id_categ AND id_tache =$results2[0];";
								$exe_cat = mysql_query ($req_catf);
								$categ = mysql_num_rows($exe_cat);
								if ($categ == 0)
								{
									$categorie = "";
								}
								else
								{
									while($results_categ = mysql_fetch_row($exe_cat))	
									{
										$categorie = $results_categ[1];
									}
								}
								/*echo $date_comp1."<br>";
								echo $date_auj."<br>";
								echo $diff1."<br>";
								*/	
								$date_a1=$jour1."/".$mois1."/".$annee1;
								if (strlen ($results2[1]) >= 50)
								{
									$results2[1] = substr("$results2[1]",0, 50)."...";
								}
								echo "<tr bgcolor= $bg_color2><td><center>$date_a1</center></td><td><center>$priorite</center></td><td><center>$results2[1]</center></td><td><center>$categorie</center></td><td><center><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
							}
							else
							{
								if ($results_j1 [0] == "2" and $diff1 >= (-86400*$results_j1[1]) and $diff1 <= 0)
								{
									$req_catf = "SELECT id_categ, intitule_categ FROM taches_categories, categorie_commune WHERE taches_categories.id_categorie = categorie_commune.id_categ AND id_tache =$results2[0];";
									$exe_cat = mysql_query ($req_catf);
									$categ = mysql_num_rows($exe_cat);
									if ($categ == 0)
									{
										$categorie = "";
									}
									else
									{
										while($results_categ = mysql_fetch_row($exe_cat))	
										{
											$categorie = $results_categ[1];
										}
									}
									$date_a1=$jour1."/".$mois1."/".$annee1;
									if (strlen ($results2[1]) >= 50)
									{
										$results2[1] = substr("$results2[1]",0, 50)."...";
									}
									echo "<tr bgcolor= $bg_color2><td><center>$date_a1</center></td><td><center>$priorite</center></td><td><center>$results2[1]</center></td><td><center>$categorie</center></td><td><center><a href = taches_gestion.php?origine_appel=cadre&actions_courantes=O&a_faire=afficher_tache&id=$results2[0]&id_util_filtre=&indice=0&affiche_barrees=N target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
								}
							}
						}
					}
					echo"</table>";
				}
				else
				{
					echo "Vous n'avez aucune tâche<br>";
				}
			}
			else
			{
				echo "Vous n'avez aucune tâche<br>";
			}
		}
		else
		{
			echo "Vous n'avez aucune tâche<br>";
		}
		$_SESSION[nb_taches]=$num_results2;
		?>
		</body>
		</html>
