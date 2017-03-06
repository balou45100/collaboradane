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
		$query = "SELECT DISTINCT DATE_CREATION FROM probleme";
		$exe= mysql_query ($query);
		$resultat=array();
		$tabdate=array();
		// Initialisation compteur tableau
		$i=0;
		$j=0;
		$nb=0;
		while($results = mysql_fetch_row($exe))
		{
			if ($results[0] <> "")
				{
				$resultat[$j]=$results[0];
				$j++;
				// On sépare la date en jour, mois, année
				list ($jour_c, $mois_c, $annee_c) = explode ("/",$results[0]);
				// Si le jour est composé d'un chiffre (9-5 etc.) on ajoute un 0 pour correspondre à la date en anglais
				if (strlen($jour_c) == 1)
				{
				$jour_c = "0".$jour_c;
				}
				// Mise en place de la date anglaise
				$date=$annee_c."-".$mois_c."-".$jour_c;
				$tabdate[$i]=$date;
				$i++;
				}
		}
				$max=$i;
				$i=0;
				$j=0;
				$nb=0;
				
				// Mise à jour en fonction des tableaux précédents
				FOR ($nb=0; $nb<$max; $nb++)
				{
				$ajout = "UPDATE probleme SET date_crea='".$tabdate[$i]."' WHERE DATE_CREATION = '".$resultat[$j]."' ;";
				$maj = mysql_query ($ajout);
				$i++;
				$j++;
				}
	
		
		
		
		
		//Fin d'insertion du code
        		 ?>
		</center>
		</body>
		</html>
