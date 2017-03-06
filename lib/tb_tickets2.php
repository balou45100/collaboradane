<?php
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$origine ="tb";
	$_SESSION['origine']=$origine;
	$_SESSION['origine1']=$origine;
	$vue = $_GET['vue'];

	//echo "<br />tb_tickets.php - vue : $vue<br />";

?>

<!DOCTYPE HTML>

<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include("../biblio/config.php");
			include("../biblio/init.php");
			include("../biblio/fct.php");

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

		if ($vue <> "tb")
		{
			// On inclut le fichier pour afficher le tableau de s�lection des tickets, alertes etc...
			include ("tb_inc.php");
		}

		$num_results=0;
		$req="SELECT tri_tick, statut, categorie FROM preference WHERE ID_UTIL = $id";
		$exe=mysql_query($req);
		$nb_results = mysql_num_rows($exe);
		if($nb_results >= "1")
		{
			while($recup = mysql_fetch_row ($exe))
			{
				$param_tri = $recup[0];
				$param_statut = $recup[1];
				$tri_categorie = $recup[2];
			}
			if ($param_tri == 1)
			{
				$tri = "priorit�";
			}
			else
			{
				if ($param_tri == 2)
				{
					$tri = "date de derni�re r�ponse";
				}
				else
				{
					$tri = "date de cr�ation";
				}
			}
			$query = "SELECT distinct PRIORITE, DATE_DERNIERE_INTERVENTION, date_crea, DATE_CREATION, STATUT_TRAITEMENT, NOM, ID_PB, STATUT FROM probleme, intervenant_ticket WHERE probleme.id_pb = intervenant_ticket.id_tick AND STATUT = 'N' AND (id_crea = $id OR id_interv = $id)";
			if ($param_tri ==1 AND $param_statut == "Tous")
			{
				$st=" AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY $param_tri ASC";
			}
			else
			{
				if ($param_tri <> 1 AND $param_statut == "Tous")
				{
					$st=" AND STATUT_TRAITEMENT IN ('N','C','T') ORDER BY $param_tri DESC";
				}
				else
				{
					if ($param_tri == 1 AND $param_statut <> "Tous")
					{
						$st=" AND STATUT_TRAITEMENT = '$param_statut' ORDER BY $param_tri ASC";
					}
					else
					{
						$st=" AND STATUT_TRAITEMENT = '$param_statut' ORDER BY $param_tri DESC";
					}
				}
			}
		}
		$final = $query.$st;
		$execution= mysql_query($final);
		if ($execution)
		{
			$num_results = mysql_num_rows($execution);
			if($num_results >= "1")
			{
				echo "<form method = get target =_top action = tb_ticket_cadre.php>";
				if ($vue == "tb")
				{
					// Affichage d'un message diff�rent s'il y a une ou plusieurs alertes...
					if($num_results == 1)
					{
						echo "Votre ticket qui correspond aux crit&egrave;res&nbsp &nbsp";
					}
					else
					{
						echo "Vos $num_results tickets tri�s par $tri qui correspondent aux crit&egrave;res&nbsp &nbsp";
					}
					echo"<input type=submit value='Voir en plein �cran' target =_top a href= tb_ticket_cadre.php><br><br>";
				}
				else
				{
					if ($num_results == 1)
					{
						echo "<center><b>Votre ticket qui correspond aux crit&egrave;res</b></center><br />";
					}
					else
					{
						echo "<b><center>Vos $num_results tickets tri�s par $tri qui correspondent aux crit&egrave;res</b></center><br />";
					}

				}

				echo "</form>";
				echo "<table border = 1 BGCOLOR = #48D1CC align = center><tr><td><center>ST</center></td><td><center>Cr�e le</center></td><td><center>Dern. interv.</center></td><td><center>Sujet</center></td><td><center>Priorit�</center></td><td><center>Cat&eacute;gories</center></td><td><center>Infos</center></td></tr>";
				while($results = mysql_fetch_row($execution))
				{
					// On r�cup�re la cat�gorie correspondante d'abord dans communes
					$cat = "SELECT intitule_categ FROM categorie_commune, categorie_commune_ticket WHERE categorie_commune.id_categ = categorie_commune_ticket.id_categ AND id_ticket = $results[6];";
					$exe_cat = mysql_query ($cat);
					$categorie1 = "";
					$categorie2 = "";
					while($results_cat = mysql_fetch_row($exe_cat))
					{
						$categorie1 = $results_cat[0];
					}
					// Sinon dans personnelles
					$cat = "SELECT categorie.id_categ, nom FROM categorie, categorie_personnelle_ticket WHERE categorie.id_categ = categorie_personnelle_ticket.id_categ AND id_pb = $results[6] AND id_util = $id;";
					$exe_cat = mysql_query ($cat);
					while($results_cat = mysql_fetch_row($exe_cat))
					{
						$categorie2 = $results_cat[1];
					}
					//Sinon pas de cat�gories
					if ($categorie1 == "" and $categorie2 == "")
					{
						$categorie = "";
					}
					else
					{
						if ($categorie1 <> "" and $categorie2 == "")
						{
							$categorie = $categorie1;
						}
						else
						{
							if ($categorie1 == "" and $categorie2 <> "")
							{
								$categorie = $categorie2;
							}
							else
							{
								$categorie = $categorie1." / ".$categorie2;
							}
						}
					}
					if ($results[1] <> "")
					{
						list($annee, $mois, $jour)= explode ("-",$results[1]);
						$date = $jour."/".$mois."/".$annee;
					}
					else
					{
						$date=$results[1];
					}
					if ($results[0] == 1)
					{
						$priorite = "Haute";
					}
					elseif ($results[0] == 2)
					{
						$priorite = "Normale";
					}
					else
					{
						$priorite = "Basse";
					}
				}
				if ($results[4] == "N")
				{
					$statut = "#ffffff";
				}
				elseif ($results[4] == "T")
				{
					$statut = "#ff0000";
				}
				else
				{
					$statut = "#00cc33";
				}
			} //Fin if($num_results >= "1")
			if (strlen ($results[5]) >= 52)
			{
				$results[5] = substr("$results[5]",0, 52)."...";
			}
			//Transformation de la date de cr�ation extraite pour l'affichage
			$date_de_creation_a_afficher = strtotime($results['2']);
			$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
			//echo "<tr bgcolor= $bg_color2><td bgcolor = $statut><center></center></td><td><center>$results[2]</center></td><td><center>$date</center></td><td><center>$results[5]</center></td><td><center>$priorite</center></td><td><center>$categorie</center></td><td><center><a href = consult_ticket.php?idpb=$results[6] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
			echo "<tr bgcolor= $bg_color2><td bgcolor = $statut><center></center></td><td><center>$date_de_creation_a_afficher</center></td><td><center>$date</center></td><td><center>$results[5]</center></td><td><center>$priorite</center></td><td><center>$categorie</center></td><td><center><a href = consult_ticket.php?idpb=$results[6] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif border = 0></img></a></center></td></tr>";
		} //Fin if ($execution)
		echo"</table>";
		/*/}
		else
		{
		echo "Vous n'avez pas de tickets en cours";
		}
		}
		else
		{
		echo "Vous n'avez pas de tickets en cours";
		}
		*/
		$_SESSION[nb_tickets]=$num_results;
		?>
		</body>
		</html>
