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
		$nb_pb=0;
		$req_mat="SELECT echeance_gar, nb_j_ech FROM preference where ID_UTIL = $id";
		$exe_mat=mysql_query($req_mat);
		while($recup_mat = mysql_fetch_row ($exe_mat))
				{
				$echeance = $recup_mat[0];
				$nb_j_m= $recup_mat[1];
				}
		$query3="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, fin_garantie, materiels.id_etat, intitule_etat 
		FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats 
		WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ 
		AND materiels.affectation_materiel=materiels_affectations.id_affectation 
		AND materiels_etats.id_etat = materiels.id_etat AND fin_garantie <> 0000-00-00 
		AND materiels.id_etat IN ('3','4','5','6');";
		$execution3=mysql_query($query3);
		while($results3 = mysql_fetch_row($execution3))
			{	
				list($annee2, $mois2, $jour2) = explode("-", $results3[4]);
				$auj=time();
				$date2=mktime(0,0,0,$mois2,$jour2,$annee2);
				$inter=$date2-$auj;
				if ($echeance == "moins" and $inter <= (86400*$nb_j_m) and $inter >= 0)
				{
				$nb_pb ++;
				}
			else
			{
			if ($echeance == "retard" and $inter >= (-86400*$nb_j_m) and $inter <= 0)
			{
			$nb_pb ++ ;
			}
			}
			}
		if ($nb_pb >= 1)
		{
		echo "<form method = get target = _top action = tb_garantie_cadre.php>";
		if ($nb_pb == 1)
		{
		echo "Vous avez $nb_pb problème de garantie avec les matériels &nbsp &nbsp";
		}
		else
		{
		echo "Vous avez $nb_pb problèmes de garantie avec les matériels &nbsp &nbsp";
		}
		echo"<input type=submit value='Voir en plein écran' a href= tb_garantie_cadre.php><br><br>";
		echo "</form>";
		$query3="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, fin_garantie, materiels.id_etat, intitule_etat FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ AND materiels.affectation_materiel=materiels_affectations.id_affectation AND materiels_etats.id_etat = materiels.id_etat AND fin_garantie <> 0000-00-00 AND materiels.id_etat IN ('3','4','5','6') ORDER BY fin_garantie";
		$execution3=mysql_query($query3);
		if ($echeance == "moins")
		{
		echo "<table border = 1 bgcolor = #48D1CC align = center><tr><td><center>Dénomination</center></td><td><center>Catégorie</center></td><td><center>Affecté à</center></td><td><center>Etat</center></td><td><center>Fin garantie dans</center></td><td><center>Infos</center></td></tr>";
		}
		else
		{
		if ($echeance == "retard")
		{
		echo "<table border = 1 bgcolor = #48D1CC align = center><tr><td><center>Nom</center></td><td><center>Catégorie</center></td><td><center>Affecté à</center></td><td><center>Etat</center></td><td><center>Garantie depassée depuis</center></td><td><center>Infos</center></td></tr>";
		}
		}
		
				while($results3 = mysql_fetch_row($execution3))
			{	
				list($annee2, $mois2, $jour2) = explode("-", $results3[4]);
				$auj=time();
				$date2=mktime(0,0,0,$mois2,$jour2,$annee2);
				$inter=$date2-$auj;
				if ($echeance == "moins" and $inter <= (86400*$nb_j_m) and $inter >= 0)
				{
						if (strlen ($results3[1]) >= 20)
				{
				$results3[1] = substr("$results3[1]",0, 20)."...";
				}
				$nb_jour=floor($inter/(60*60*24))+1;
				echo "<tr bgcolor=$bg_color2><td><center>$results3[1]</center></td><td><center>$results3[2]</center></td><td><center>$results3[3]</center></td><td><center>$results3[6]</center></td><td><center>$nb_jour jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results3[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
				}
				else
				{
				if ($echeance == "retard" and $inter >= (-86400*$nb_j_m) and $inter <= 0)
				{
						if (strlen ($results3[1]) >= 20)
				{
				$results3[1] = substr("$results3[1]",0, 20)."...";
				}
				$nb_jour=floor(($inter/(60*60*24))*-1);
				echo "<tr bgcolor=$bg_color2><td><center>$results3[1]</center></td><td><center>$results3[2]</center></td><td><center>$results3[3]</center></td><td><center>$results3[6]</center></td><td><center>$nb_jour jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results3[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";		}
				}
				}
				echo"</table>";
		}
		else
		{
		echo "Vous n'avez aucun problème de garantie de matériels<br>";
		}	
		$_SESSION[nb_pb1]=$nb_pb;
		?>
		</body>
		</html>
