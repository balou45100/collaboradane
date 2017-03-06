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
		$categ = array();
		$util = array ();
		$i = 0;
		$j = 0;
		$pb="SELECT ID_CATEG,ID_PB_CATEG,ID_UTIL FROM categorie, util WHERE categorie.nom_util = util.nom ORDER BY ID_CATEG;";
		$query_pb = mysql_query ($pb);
		while ($results = mysql_fetch_row ($query_pb))
		{
		// Si la catégorie sélectionnée a au moins un ticket
		if ($results[1] <> "")
				{
				// On stocke la catégorie et l'utilisateur dans le tableau
				$categ[$i]=$results[0];
				$util[$i]=$results[2];
				// On "explose" le champ des tickets pour les séparer en plusieurs
				$pb = explode (";",$results[1]);
				// On compte le nombre de valeurs du tableau donc de tickets de la catégorie
				$nb = count ($pb);
				$nb_reel = $nb - 1;
				$nb = 0;
				$id_categ = 0;
				// On fait les insertions de données par tickets puis par catégorie
				for ($nb=0; $nb<$nb_reel; $nb++)
				{
				$ajout = "INSERT INTO categorie_personnelle_ticket VALUES ($pb[$j], $categ[$i], $util[$i]);";
				$maj = mysql_query ($ajout);
				echo "$ajout<br>";
				$j++;
				}
				$j = 0;
				$i++;
				}
		}		
		//Fin d'insertion du code
        		 ?>
		</center>
		</body>
		</html>
