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
		<CENTER>
		<!--TABLE align="center" width = "50%" height="13%" BORDER = "0" BGCOLOR ="#FFFF99">
			<TR>
				<TD align = "center">
              		<h2>"CollaboraTICE"<br>Espace collaboratif de la Mission académique TICE</h2>
            	</TD>
            	<TD align = "center">
              		<img border="0" src="../image/logo_tice.png" ALT = "Logo">
            	</TD>
          	</TR>
        </TABLE--><br>
		<body>
		<?php
		include ("tb_inc.php");
		$nb_pb=0;
		$req_pret="SELECT echeance_pret, nb_j_pret FROM preference where id_util = $id";
		$exe_pret=mysql_query($req_pret);
		while($recup_pret = mysql_fetch_row ($exe_pret))
				{
				$echeance1 = $recup_pret[0];
				$nb_j_p= $recup_pret[1];
				}
		$query4="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, date_affectation, date_retour, materiels.id_etat, intitule_etat 
		FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats 
		WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ 
		AND materiels.affectation_materiel=materiels_affectations.id_affectation 
		AND materiels_etats.id_etat = materiels.id_etat AND date_retour IS NOT NULL
		AND materiels.id_etat IN ('3','4','5','6');";
		$execution4=mysql_query($query4);
			while($results4 = mysql_fetch_row($execution4))
			{	
				list($annee3, $mois3, $jour3) = explode("-", $results4[5]);
				$auj=time();
				$date3=mktime(0,0,0,$mois3,$jour3,$annee3);
				$inter1=$date3-$auj;
				if ($echeance1 == "moins" and $inter1 <= (86400*$nb_j_p) and $inter1 >= 0)
				{
				$nb_pb ++;
				}
			else
			{
			if ($echeance1 == "retard" and $inter1 >= (-86400*$nb_j_p) and $inter1 <= 0)
			{
			$nb_pb ++ ;
			}
			}
			}
		if ($nb_pb > 0)
		{
		$query4="SELECT materiels.id, denomination, intitule_cat_princ , intitule_affectation, date_affectation, date_retour, materiels.id_etat, intitule_etat FROM materiels, materiels_categories_principales, materiels_affectations, materiels_etats WHERE materiels.categorie_principale=materiels_categories_principales.id_cat_princ AND materiels.affectation_materiel=materiels_affectations.id_affectation AND materiels_etats.id_etat = materiels.id_etat AND date_retour IS NOT NULL AND materiels.id_etat IN ('3','4','5','6') ORDER BY date_retour;";
		$execution4=mysql_query($query4);
		if ($echeance1 == "moins")
		{
		if ($nb_pb == 1)
		{
		echo "<h3>Vous avez $nb_pb prêt de matériel bientôt terminé &nbsp &nbsp</h3>";
		}
		else
		{
		echo "<h3>Vous avez $nb_pb prêts de matériels bientôt terminés &nbsp &nbsp</h3>";
		}
		echo "<table border = 1 bgcolor=#48D1CC><tr><td><center>Nom</center></td><td><center>Catégorie</center></td><td><center>Affecté</center></td><td><center>A rendre dans</center></td><td><center>Infos</center></td></tr>";
		}
		else
		{
		if ($echeance1 == "retard")
		{
		if ($nb_pb == 1)
		{
		echo "<h3>Vous avez $nb_pb prêt de matériels non encore rendu &nbsp &nbsp</h3>";
		}
		else
		{
		echo "<h3>Vous avez $nb_pb prêts de matériels non encore rendus &nbsp &nbsp</h3>";
		}
		echo "<table border = 1 bgcolor=#48D1CC><tr><td><center>Nom</center></td><td><center>Catégorie</center></td><td><center>Affecté</center></td><td><center>A rendre depuis</center></td><td><center>Infos</center></td></tr>";
		}
		}
		
				while($results4 = mysql_fetch_row($execution4))
			{
			if ($results4[7] == "disponible" or $results4[7] == "en panne")
			{
			$results4[3] = $results4[3].' ('.$results4[7].')';
			}
				if ($results4[4] <> "")
				{
				list($annee, $mois, $jour)= explode ("-",$results4[4]);
				$results4[4] = $jour."/".$mois."/".$annee;
				}
				if ($results4[5] <> "")
				{
				list($annee3, $mois3, $jour3) = explode("-", $results4[5]);
				$auj=time();
				$date3=mktime(0,0,0,$mois3,$jour3,$annee3);
				$inter1=$date3-$auj;
				list($annee, $mois, $jour)= explode ("-",$results4[5]);
				$results4[5] = $jour."/".$mois."/".$annee;
				}
				if ($echeance1 == "moins" and $inter1 <= (86400*$nb_j_p) and $inter1 >= 0)
				{
				$nb_jour1=floor($inter1/(60*60*24))+1;
				echo "<tr bgcolor=$bg_color2><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
				}
				else
				{
				if ($echeance1 == "retard" and $inter1 >= (-86400*$nb_j_p) and $inter1 <= 0)
				{
				$nb_jour1=floor(($inter1/(60*60*24))*-1);
				echo "<tr bgcolor=$bg_color2><td><center>$results4[1]</center></td><td><center>$results4[2]</center></td><td><center>$results4[3]</center></td><td><center>$nb_jour1 jour(s)</center></td><td><center><a href=materiels_gestion.php?origine_gestion=filtre&actions_courantes=O&a_faire=afficher_fiche_materiel&id=$results4[0]&indice=0 target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
				}
				}
				}
				echo"</table>";
		}
		else
		{
		echo "<h3>Vous n'avez aucun problème de prêt de matériels &nbsp &nbsp</h3>"; 	
		}
		
		
		
		
		
		
		?>
		</body>
		</html>
