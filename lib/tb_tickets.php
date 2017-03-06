<?php
	session_start();
	error_reporting(0);
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$origine ="tb";
	$_SESSION['origine']=$origine;
	$_SESSION['origine1']=$origine;
	$vue = $_GET['vue'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_images_theme = $_SESSION['chemin_images_theme'];
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	//echo "<br />tb_tickets.php - vue : $vue<br />";
	//echo "<br />chemin_theme_images : $chemin_theme_images<br />";
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<?php
	echo "<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
			//include("../biblio/ticket.css");
			include("../biblio/config.php");
			include("../biblio/init.php");
			include("../biblio/fct.php");

			if(!isset($_SESSION['nom']))
			{
				echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
				echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
				exit;
			}
			else
			{
				enreg_utilisation_module("TBTI");
			}
		?>
		</head>
		<body>
		<?php
		
		if ($vue <> "tb")
		{
			// On inclut le fichier pour afficher le tableau de s&eacute;lection des tickets, alertes etc...
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
				$tri = "priorit&eacute;";
			}
			else
			{
				if ($param_tri == 2)
				{
					$tri = "date de derni&egrave;re r&eacute;ponse";
				}
				else
				{
					$tri = "date de cr&eacute;ation";
				}
			}
			$query = "SELECT distinct PRIORITE, DATE_DERNIERE_INTERVENTION, date_crea, DATE_CREATION, STATUT_TRAITEMENT, NOM, ID_PB, STATUT
				FROM probleme, intervenant_ticket
				WHERE probleme.id_pb = intervenant_ticket.id_tick
				AND STATUT = 'N'
				AND (id_crea = $id
				OR id_interv = $id)";
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
				
				//On initialise le message expliquant le choix des tickets pour l'affichage
				switch ($param_statut)
				{
					case 'Tous' :
						if($num_results == 1)
						{ 
							$entete_liste_a_afficher = "Votre ticket&nbsp &nbsp";
						}
						else
						{ 
							$entete_liste_a_afficher = "Vos $num_results tickets, tri&eacute;s par $tri&nbsp &nbsp";
						}
					break;
					case 'N' :
						if($num_results == 1)
						{ 
							$entete_liste_a_afficher = "Votre nouveau ticket&nbsp &nbsp";
						}
						else
						{ 
							$entete_liste_a_afficher = "Les $num_results nouveaux tickets, tri&eacute;s par $tri&nbsp &nbsp";
						}
					break;
					case 'T' :
						if($num_results == 1)
						{ 
							$entete_liste_a_afficher = "Le ticket transf&eacute;r&eacute;&nbsp &nbsp";
						}
						else
						{ 
							$entete_liste_a_afficher = "Les $num_results tickets transf&eacute;r&eacute;s, tri&eacute;s par $tri&nbsp &nbsp";
						}
					break;
					case 'C' :
						if($num_results == 1)
						{ 
							$entete_liste_a_afficher = "Le ticket en cours de traitement;&nbsp &nbsp";
						}
						else
						{ 
							$entete_liste_a_afficher = "Les $num_results tickets en cours de traitement, tri&eacute;s par $tri&nbsp &nbsp";
						}
					break;
				} 
				if ($vue == "tb")
				{
					// Affichage de l'entête
					echo $entete_liste_a_afficher;
					echo"<input type=submit value='Voir en plein &eacute;cran' target =_top a href= tb_ticket_cadre.php><br /><br />";
				}
				else
				{
					echo "<center><b>$entete_liste_a_afficher</b></center><br />";
				
				}

				echo "</form>";
				//echo "<table border = 1 BGCOLOR = #48D1CC align = center><tr><td><center>Id</center></td><td><center>ST</center></td><td><center>Cr&eacute;e le</center></td><td><center>Dern. interv.</center></td><td><center>Sujet</center></td><td><center>Priorit&eacute;</center></td><td><center>Cat&eacute;gories</center></td><td><center>Infos</center></td></tr>";
				echo "<div align = \"center\">";
				echo "<table>";
					echo "<tr>";
						echo "<th>Id</th>";
						echo "<th>ST</th>";
						echo "<th>Cr&eacute;e le</th>";
						echo "<th>Dern. interv.</th>";
						echo "<th>Sujet</th>";
						echo "<th>Priorit&eacute;</th>";
						echo "<th>Cat&eacute;gories</th>";
						echo "<th>Infos</th>";
					echo "</tr>";
				while($results = mysql_fetch_row($execution))
				{
					// On r&eacute;cup&egrave;re la cat&eacute;gorie correspondante d'abord dans communes
					$cat = "SELECT intitule_categ FROM categorie_commune, categorie_commune_ticket WHERE categorie_commune.id_categ = categorie_commune_ticket.id_categ AND id_ticket = $results[6];";
					$exe_cat = mysql_query ($cat);
					$categorie1 = "";
					$categorie2 = "";
					while($results_cat = mysql_fetch_row($exe_cat))
					{
						$categorie1 = $results_cat[0];
					}
					// Sinon dans personnelles
					$cat = "SELECT categorie.id_categ, nom FROM categorie, categorie_personnelle_ticket WHERE categorie.id_categ = categorie_personnelle_ticket.id_categ AND id_pb = $results[6] AND categorie_personnelle_ticket.id_util = $id;";
					
					//echo "<br />$cat";
					
					$exe_cat = mysql_query ($cat);
					while($results_cat = mysql_fetch_row($exe_cat))
					{ 
						$categorie2 = $results_cat[1];
					}
					//Sinon pas de cat&eacute;gories
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
						else
						{
							if ($results[0] == 2)
							{
								$priorite = "Normale";
							}
							else
							{
								$priorite = "Basse";
							}
						}
						
						switch ($results[4]) //Statut traitement
						{
							case "N":
								//$couleur_fond = "#ffffff";
								$classe_fond = "nouveau";
							break;

							case "C":
								//$couleur_fond = "#00cc33";
								$classe_fond = "en_cours";
							break;

							case "T":
								//$couleur_fond = "#ff0000";
								$classe_fond = "transfere";
							break;

							case "A":
								//$couleur_fond = "#ffff66";
								$classe_fond = "attente";
							break;

							case "F":
								//$couleur_fond = "#FF9FA3";
								$classe_fond = "acheve";
							break;

						}

						/*
						if ($results[4] == "N")
						{
							$statut = "#ffffff";
							$classe_fond = "nouveau";
						}
						else
						{
							if ($results[4] == "T")
							{
								$statut = "#ff0000";
								$classe_fond = "transfere";
							}
							else
							{
								$statut = "#00cc33";
							}
						}
						*/ 
						if (strlen ($results[5]) >= 52)
						{
							$results[5] = substr("$results[5]",0, 52)."...";
						}
						//Transformation de la date de cr&eacute;ation extraite pour l'affichage
						$date_de_creation_a_afficher = strtotime($results['2']);
						$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
						//echo "<tr bgcolor= $bg_color2><td bgcolor = $statut><center></center></td><td><center>$results[2]</center></td><td><center>$date</center></td><td><center>$results[5]</center></td><td><center>$priorite</center></td><td><center>$categorie</center></td><td><center><a href = consult_ticket.php?idpb=$results[6] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\"></img></a></center></td></tr>";

						//echo "<tr bgcolor= $bg_color2><td><center>$results[6]</center></td><td bgcolor = $statut><center></center></td><td><center>$date_de_creation_a_afficher</center></td><td><center>$date</center></td><td><center>$results[5]</center></td><td><center>$priorite</center></td><td><center>$categorie</center></td><td><center><a href = consult_ticket.php?idpb=$results[6] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td></tr>";
						echo "<tr>";
							echo "<td><center>$results[6]</center></td>";
							echo "<td class = \"$classe_fond\" align=\"center\"></td>";
							echo "<td><center>$date_de_creation_a_afficher</center></td>";
							echo "<td><center>$date</center></td>";
							echo "<td><center>$results[5]</center></td>";
							echo "<td><center>$priorite</center></td>";
							echo "<td><center>$categorie</center></td>";
							echo "<td class = \"fond-actions\"><center><a href = consult_ticket.php?idpb=$results[6] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" border = 0></img></a></center></td>";
						echo "</tr>";
				} //Fin while($results = mysql_fetch_row($execution))
				echo"</table>";
			}// Fin if($num_results >= "1")
			else
			{
				echo "Vous n'avez pas de tickets en cours";
			}
		} //Fin if ($execution)
		else
		{
			echo "Vous n'avez pas de tickets en cours";
		}
		$_SESSION[nb_tickets]=$num_results;
?>
		</div>
	</body>
</html>
