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
		$delete = "0";
		$delete = $_GET['delete'];
		$max = "0";
		$max = $_GET['max'];
		if ($delete == "1")
		{
		$req_maj = "UPDATE preference SET info = $max WHERE id_util = $id";
		$exe_maj = mysql_query($req_maj);
		$_SESSION['nb_pers']="0";
		}
		$req_info = "SELECT pers_form, info FROM preference where id_util = $id";
		$exe_info = mysql_query ($req_info);
		while ($results_info = mysql_fetch_row ($exe_info))
		{
		$pers_form = $results_info [0];
		$info = $results_info [1] + 1;
		}
				if ($pers_form == "Nsaisie")
		{
		$req_max = "SELECT MAX(id_pers_ress) FROM personnes_ressources_tice";
		$exe_max = mysql_query ($req_max);
		$max = 0;
		if ($exe_max)
		{
		while ($results_max = mysql_fetch_row ($exe_max))
		{
		$max = $results_max[0];
		}
		$maxi = $max + 1 ;
		}
		if ($maxi > $info)
		{
		$i=$info;
		$nb_pers=0;
		for ($info=$info; $info < $maxi ; $info++)
		{
		$req_pers="SELECT id_pers_ress, civil, personnes_ressources_tice.nom, prenom, type_etab_gen, etablissements.nom, discipline, poste FROM etablissements, personnes_ressources_tice WHERE personnes_ressources_tice.codetab = etablissements.rne AND id_pers_ress = $info;"; 
		$query_pers = mysql_query ($req_pers);
		while ($results = mysql_fetch_row ($query_pers))
		{
		$nb_pers++;
		}
		}
		if ($nb_pers == 1)
		{
		echo "<h3>Depuis votre dernière visite, $nb_pers personne a été ajoutée dans le module 'Personnes et formations' &nbsp &nbsp<a href= tb_pers_form1.php?delete=1&amp;max=$max><input type='submit' value='Tout effacer'></a></h3>";
		}
		else
		{
		echo "<h3>Depuis votre dernière visite, $nb_pers personnes ont été ajoutées dans le module 'Personnes et formations' &nbsp &nbsp<a href= tb_pers_form1.php?delete=1&amp;max=$max><input type='submit' value='Tout effacer'></a></h3>";
		}
		echo "<table border = 1 bgcolor=#48D1CC align = center><tr><td><center>Civilité</center></td><td><center>Nom</center></td><td><center>Prénom</center></td><td><center>Etablissement</center></td><td><center>Discipline/Poste</center></td><td><center>Infos</center></td></tr>";
		for ($i=$i; $i < $info ; $i++)
		{
		$req_pers="SELECT id_pers_ress, civil, personnes_ressources_tice.nom, prenom, type_etab_gen, etablissements.nom, discipline, poste FROM etablissements, personnes_ressources_tice WHERE personnes_ressources_tice.codetab = etablissements.rne AND id_pers_ress = $i;"; 
		$query_pers = mysql_query ($req_pers);
		while ($pers = mysql_fetch_row ($query_pers))
		{
		if ($pers[6]<> "")
		{
		$emploi = $pers[6];
		}
		else
		{
		$emploi = $pers[7];
		}
		echo "<tr bgcolor=$bg_color2><td><center>$pers[1]</center></td><td><center>$pers[2]</center></td><td><center>$pers[3]</center></td><td><center>$pers[4] $pers[5]</center></td><td><center>$emploi</center></td><td><center><a href =personnes_ressources_gestion.php?actions_courantes=O&amp;a_faire=consulter_personne&amp;id=$pers[0] target=_blank><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif></img></a></center></td></tr>";
		}
		}
		echo "<table>";
		}
		else
		{
		echo "<h3>Depuis votre dernière visite, aucune personne n'a été ajoutée dans le module 'Personnes et formations' &nbsp &nbsp</h3>"; 	
		}
		}
		else
		{
		echo "<h3>Depuis votre dernière visite, aucune personne n'a été ajoutée dans le module 'Personnes et formations' &nbsp &nbsp</h3>"; 	
		}
		
		
		
		
		
		
		?>
		</body>
		</html>
