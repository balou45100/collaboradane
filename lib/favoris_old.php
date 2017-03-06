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
		$i = 0;
		$j = 0;
		$min = 1;
		$max = 4;
		$compteur = 0;
		$colonne = 4;
		echo"<h2>Vos sites favoris&nbsp &nbsp &nbsp";
		echo "<a href = creation_categorie.php><input type=submit value='Nouvelle catégorie'></a>";
		echo "&nbsp &nbsp &nbsp";
		echo "<a href = creation_favori.php><input type=submit value='Nouveau favori'></a><br><br></h2>";
		echo "<h3><a name = public>Catégories publiques</a> / <a href= #prive>Catégories privées</a></h3>";
		echo "<br>";
		// Affichage favoris, catégories publiques
		$nb_categ_public = 0;
		$categ = array();
		$nom_categ = array();
		$nb_favori = array();
		$test_categ = array();
		$recup_nb_fav = array();
		$adresse = array();
		$test_categ_public = "SELECT categorie_favori.id_categ, count(id_favori) as nb_favori, intitule_categ FROM categorie_favori, favori WHERE categorie_favori.id_categ = favori.id_categ AND id_util = 0 GROUP by categorie_favori.id_categ ORDER BY intitule_categ";
		$test_nb_categ_public = mysql_query ($test_categ_public);
		if (!$test_nb_categ_public)
		{
		echo "";
		}
		else
		{
		while ($results_nb_categ_public = mysql_fetch_row ($test_nb_categ_public))
		{
		$nb_categ_public ++;
		$categ[$i] = $results_nb_categ_public[0];
		$nb_favori[$i] = $results_nb_categ_public[1];
		$nom_categ[$i] = $results_nb_categ_public[2];
		$i++;
		}
		echo "<table border = \"0\" width = \"100%\">";
		echo "<tr>";
		$cat=0;
		while ($cat<$nb_categ_public) // Nombre de catégories
			{
			// On calcule le maximum de favori dans la ligne pour un bon affichage... 
			if ($compteur == 0)
			{
			// On compare ces enregistrements...
			$compteur_test_categ_public = "SELECT categorie_favori.id_categ, count(id_favori) as nb_favori, intitule_categ FROM categorie_favori, favori WHERE categorie_favori.id_categ = favori.id_categ AND id_util = 0 GROUP by categorie_favori.id_categ ORDER BY intitule_categ";
			$test_compteur_categ_public = mysql_query ($compteur_test_categ_public);
			$test = 0;
			while ($results_test_categ_public = mysql_fetch_row ($test_compteur_categ_public))
			{
			$test ++;
			if ($test >= $min and $test <= $max)
			{
			if ($results_test_categ_public[1]<>"")
			$recup_nb_fav[$test] = $results_test_categ_public[1];
			}
			}
			$max_favori = 0;
			$test = $min;
			// On compare maintenant le nombre de favoris des 4 enregistrements
			for ($test=$min; $test<=$max; $test++)
			{
			if ($recup_nb_fav[$test] > $max_favori)
			{
			$max_favori = $recup_nb_fav[$test];
			}
			}
			// On a déterminé le nombre max de favoris
			}
				if ($compteur == $colonne) // Nombre de catégories par ligne
				{
					$compteur = 0;
					echo "<br />";
					echo "<table border = \"0\" width = \"100%\">";
					echo "<tr>";
				}
				echo "<td valign = top>
					<table border = \"0\">";
						echo "<tr align = \"center\">
							<td width = \"92%\"><b>$nom_categ[$cat]</b></td>
							<td width = \"4%\" align = center><a href = modif_categ_fav.php?id_categ=$categ[$cat] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier cette catégorie'></A></td>
							<td width = \"4%\" align = center><a href = suppr_categ_fav.php?id_categ=$categ[$cat] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer cette catégorie'></a></td>
						</tr>";
		$nb_favori_public = "SELECT COUNT(id_favori) as nb_favori FROM favori WHERE id_categ = $categ[$cat]";
		$exe_nb_favori_public = mysql_query ($nb_favori_public);
		while ($results_nb_favori_public = mysql_fetch_row ($exe_nb_favori_public))
		{
		$nb_favori = $results_nb_favori_public[0];
		}
		$nom_favori_public = "SELECT id_favori, intitule, adresse FROM favori WHERE id_categ = $categ[$cat] order by intitule";
		$exe_nom_favori_public = mysql_query ($nom_favori_public);
		while ($results_nom_favori_public = mysql_fetch_row ($exe_nom_favori_public))
		{
		$id_fav[$j] = $results_nom_favori_public[0];
		$nom_favori[$j] = $results_nom_favori_public[1];
		$adresse[$j] = $results_nom_favori_public[2];
		$j ++;
		}
		$j =0;
		$fav=0;
		while ($fav<$nb_favori) // Nombre de favoris pour une catégorie
						{
							echo "<tr>";
							echo "<td width = \"92%\" align = center><a href = '$adresse[$j]'>$nom_favori[$fav]</a></td>
								<td width = \"4%\" align = center><a href = modif_fav.php?id_fav=$id_fav[$fav] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier ce favori'></a></td>
								<td width = \"4%\" align = center><a href = suppr_fav.php?id_fav=$id_fav[$fav] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer ce favori'></a></td>
							</tr>";
							$fav ++;
							$j++;
						}
						$j = 0;
				echo "</table>
				</td>";
			$cat ++;
			$compteur ++;
			if ($compteur == $colonne) // Si fin de ligne on va à la suivante...
			{
				echo "</tr>";
				echo "</table>";
				$min = $min + 4;
				$max = $max + 4;
			}
		}
			echo "</tr>";
			echo "</table>";
		} 
		echo "<br><br>";
		echo "<h3><a name =prive>Catégories privées</a> / <a href = #public>Catégories publiques</a></h3>";
		echo "<br>";
		// Affichage favoris, catégories privées
		$i = 0;
		$j = 0;
		$min = 1;
		$max = 4;
		$compteur = 0;
		$colonne = 4;
		$nb_categ_prive = 0;
		$categ = array();
		$nom_categ = array();
		$nb_favori = array();
		$test_categ = array();
		$recup_nb_fav = array();
		$adresse = array();
		$test_categ_prive = "SELECT categorie_favori.id_categ, count(id_favori) as nb_favori, intitule_categ FROM categorie_favori, favori WHERE categorie_favori.id_categ = favori.id_categ AND id_util = $id GROUP by categorie_favori.id_categ ORDER BY intitule_categ";
		$test_nb_categ_prive = mysql_query ($test_categ_prive);
		if (!$test_nb_categ_prive)
		{
		echo "";
		}
		else
		{
		while ($results_nb_categ_prive = mysql_fetch_row ($test_nb_categ_prive))
		{
		$nb_categ_prive ++;
		$categ[$i] = $results_nb_categ_prive[0];
		$nb_favori[$i] = $results_nb_categ_prive[1];
		$nom_categ[$i] = $results_nb_categ_prive[2];
		$i++;
		}
		echo "<table border = \"0\" width = \"100%\">";
		echo "<tr>";
		$cat=0;
		while ($cat<$nb_categ_prive) // Nombre de catégories
			{
			// On calcule le maximum de favori dans la ligne pour un bon affichage... 
			if ($compteur == 0)
			{
			// On compare ces enregistrements...
			$compteur_test_categ_prive = "SELECT categorie_favori.id_categ, count(id_favori) as nb_favori, intitule_categ FROM categorie_favori, favori WHERE categorie_favori.id_categ = favori.id_categ AND id_util = $id GROUP by categorie_favori.id_categ ORDER BY intitule_categ";
			$test_compteur_categ_prive = mysql_query ($compteur_test_categ_prive);
			$test = 0;
			while ($results_test_categ_prive = mysql_fetch_row ($test_compteur_categ_prive))
			{
			$test ++;
			if ($test >= $min and $test <= $max)
			{
			if ($results_test_categ_prive[1]<>"")
			$recup_nb_fav[$test] = $results_test_categ_prive[1];
			}
			}
			$max_favori = 0;
			$test = $min;
			// On compare maintenant le nombre de favoris des 4 enregistrements
			for ($test=$min; $test<=$max; $test++)
			{
			if ($recup_nb_fav[$test] > $max_favori)
			{
			$max_favori = $recup_nb_fav[$test];
			}
			}
			// On a déterminé le nombre max de favoris
			}
				if ($compteur == $colonne) // Nombre de catégories par ligne
				{
					$compteur = 0;
					echo "<br />";
					echo "<table border = \"0\" width = \"100%\">";
					echo "<tr>";
				}
				echo "<td valign = top>
					<table border = \"0\">";
						echo "<tr align = \"center\">
							<td width = \"92%\"><b>$nom_categ[$cat]</b></td>
							<td width = \"4%\" align = center><a href = modif_categ_fav.php?id_categ=$categ[$cat] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier cette catégorie'></A></td>
							<td width = \"4%\" align = center><a href = suppr_categ_fav.php?id_categ=$categ[$cat] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer cette catégorie'></a></td>
						</tr>";
		$nb_favori_prive = "SELECT COUNT(id_favori) as nb_favori FROM favori WHERE id_categ = $categ[$cat]";
		$exe_nb_favori_prive = mysql_query ($nb_favori_prive);
		while ($results_nb_favori_prive = mysql_fetch_row ($exe_nb_favori_prive))
		{
		$nb_favori = $results_nb_favori_prive[0];
		}
		$nom_favori_prive = "SELECT id_favori, intitule, adresse FROM favori WHERE id_categ = $categ[$cat] order by intitule";
		$exe_nom_favori_prive = mysql_query ($nom_favori_prive);
		while ($results_nom_favori_prive = mysql_fetch_row ($exe_nom_favori_prive))
		{
		$id_fav[$j] = $results_nom_favori_prive[0];
		$nom_favori[$j] = $results_nom_favori_prive[1];
		$adresse[$j] = $results_nom_favori_prive[2];
		$j ++;
		}
		$j =0;
		$fav=0;
		while ($fav<$nb_favori) // Nombre de favoris pour une catégorie
						{
							echo "<tr>";
							echo "<td width = \"92%\" align = center><a href = '$adresse[$j]'>$nom_favori[$fav]</a></td>
								<td width = \"4%\" align = center><a href = modif_fav.php?id_fav=$id_fav[$fav] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png ALT = modifier title='Modifier ce favori'></a></td>
								<td width = \"4%\" align = center><a href = suppr_fav.php?id_fav=$id_fav[$fav] target = body><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png ALT = supprimer title='Supprimer ce favori'></a></td>
							</tr>";
							$fav ++;
							$j++;
						}
						$j =0;
				echo "</table>
				</td>";
			$cat ++;
			$compteur ++;
			if ($compteur == $colonne) // Si fin de ligne on va à la suivante...
			{
				echo "</tr>";
				echo "</table>";
				$min = $min + 4;
				$max = $max + 4;
			}
		}
			echo "</tr>";
			echo "</table>";
		} 
		//Fin d'insertion du code
        		 ?>
		</center>
		</body>
		</html>
