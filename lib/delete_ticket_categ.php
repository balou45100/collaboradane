<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Le but de ce fichier est de demander si l'on veut supprimer ou pas un ticket">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
			<?php
				//Récupération de l'identifiant concernant le ticket à supprimer
				$idpb = $_GET['idpb'];
				$id_categ = $_GET['id_categ'];
        		$tri = $_GET['tri'];
				$origine = $_GET['origine'];
				
				/*
				echo "<BR>N° du ticket : $idpb";
				echo "<BR>N° de la catégorie : $id_categ";
				*/
				//Test du champ récupéré
				if(!isset($idpb) || $idpb == "" ||!isset($id_categ) || $id_categ == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Problèmes de récupération des variables</B></FONT>";
					echo "<BR><A HREF = \"affiche_categories.php?origine=$origine&amp;idpb=$idpb&amp;id_categ=$id_categ\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				}
				
				//Inclusion des fichiers nécessaires	
				include("../biblio/init.php");
				
				
				//Récupération des données résumant le ticket pour procéder à sa suppression ou non
				
        
        $query_pb = "SELECT * FROM probleme WHERE id_pb = '".$idpb."';";
				$result_pb = mysql_query($query_pb);
				if(!$result_pb)
				{
					echo "<FONT COLOR = \"#808080\"><B>problème lors de l'execution de la requète</B></FONT>";
					echo "<A HREF = \"affiche_categories.php?origine=$origine&amp;idpb=$idpb&amp;id_categ=$id_categ\">Retour au ticket</A>";
					mysql_close();
					exit;
				}
					
				$res = mysql_fetch_row($result_pb);
					
				//Sélection des catégories concernées
				$query_cat = "SELECT * FROM categorie WHERE ID_CATEG = '".$id_categ."%';";
				$result_cat = mysql_query($query_cat);
				//Dans le cas où aucun résultats n'est retourné
				if(!$result_cat)
				{
					echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
					echo "<BR><A HREF = \"affiche_categories.php?origine=$origine&amp;idpb=$idpb&amp;id_categ=$id_categ\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
				  mysql_close();
					exit;
				}
				
				$res_cat = mysql_fetch_row($result_cat);
				
				echo "<FONT COLOR = \"#808080\"><B>Voulez-vous vraiment supprimer le ticket N° ".$res[0]." de la catégorie ".$res_cat[1]."&nbsp;?</B></FONT> <BR>";
        
			  echo "<BR>";
				echo "<A HREF = \"confirm_suppr_ticket_categorie.php?origine=$origine&amp;idpb=$idpb&amp;id_categ=".$id_categ."&amp;nom_categ=".$res_cat[1]."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer de cette catégorie\"></A>
        <A HREF = \"affiche_categories.php?origine=$origine&amp;idpb=$idpb&amp;id_categ=$id_categ\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"retour\"></A>";
					
				echo "<BR>";
				
        //Affichage du détail du ticket :
        echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
         	echo "<TR class = \"indre_loire\">";
						echo "<TD align = \"center\" width=\"10%\">N° : <b>$res[0]</b></TD>";
						echo "<TD width=\"5%\">créé par&nbsp:</TD>";
						echo "<TD align = \"center\" width=\"20%\">$res[3]</TD>";
						echo "<TD width=\"5%\">créé le&nbsp:</TD>";
						echo "<TD align = \"center\" width=\"10%\">$res[7]</TD>";
						
				  echo "<TR CLASS = \"indre_loire\">";
						echo "<TD>Sujet&nbsp;:&nbsp;</TD>";
						echo "<TD colspan=\"4\">$res[5]</TD>";
					echo "</TR>";
          echo "<TR class = \"indre_loire\">";
          	echo "<TD>Contenu&nbsp;:</TD>";
						echo "<TD colspan=\"6\">$res[6]</TD>";
					echo "</TR>";
				echo "</TABLE>";
				
        mysql_close();
				
			?>
		</CENTER>
	</BODY>
</HTML>
					
