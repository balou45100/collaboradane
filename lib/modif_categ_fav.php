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
			include ("../biblio/fct.php");
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
		$action = $_GET['action'];
		$intitule_categ = $_GET['intitule_categ'];
		$id_util = $_GET['id_util'];
		$id_categ = $_GET['id_categ'];
		if ($intitule_categ == "" and $action == "O")
		{
		echo "<br><br>";
		echo "Vous n'avez pas renseigné le nom de la catégorie<br><br>";
		echo "<form action = modif_categ_fav.php?id_categ=$id_categ action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value=><br><br>";
		echo "Type	<select name=id_util>
				<option value = 0> Publique </option>
				<option value = $id> Privée </option></select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo"<input type =hidden name=id_categ value=$id_categ>";
		echo "<input type=submit value='Ajouter la catégorie'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";		
		}
		else
		{
		if ($action <> "O")
		{
		$recup_categ = "SELECT intitule_categ, id_util FROM categorie_favori WHERE id_categ = $id_categ;";
		$exe_recup_categ = mysql_query ($recup_categ);
		while ($results_recup_categ = mysql_fetch_row ($exe_recup_categ))
		{
		$intitule_categ = $results_recup_categ[0];
		$id_util = $results_recup_categ[1];
		}
		if ($id_util == 0)
		{
		echo "<h2>Modification de la catégorie publique '$intitule_categ'</h2>";
		}
		else
		{
		echo "<h2>Modification de la catégorie privée '$intitule_categ'</h2>";
		}
		$affichage_infos_categ = "SELECT * FROM categorie_favori WHERE id_categ = $id_categ";
		$exe_affichage_infos_categ = mysql_query ($affichage_infos_categ);
		while ($results_infos_categ = mysql_fetch_row ($exe_affichage_infos_categ))
		{
		$intitule_categ = $results_infos_categ[1];
		$id_util = $results_infos_categ[2];
		}
		if ($id_util == 0)
		{
		$type = "Publique";
		}
		else
		{
		$type = "Privée";
		}
		echo "<form action = modif_categ_fav.php?id_categ=$id_categ action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value='$intitule_categ'><br><br>";
		echo "Type <select name=id_util>";
			$donnees = $type;
			test_option_select ($donnees,"Publique","0");
			test_option_select ($donnees,"Privée","$id");
		echo"</select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo"<input type =hidden name=id_categ value=$id_categ>";
		echo "<input type=submit value='Modifier la catégorie'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";	
		}
		else
		{
		$verif_categ = "SELECT * FROM categorie_favori WHERE intitule_categ = '$intitule_categ' AND id_util = $id_util;";
		$exe_verif_categ = mysql_query ($verif_categ);
		$nb = mysql_num_rows ($exe_verif_categ);
		if ($nb == 1)
		{
		echo "<br><br>Cette catégorie a déjà été ajoutée<br><br>";
		echo "<form action = modif_categ_fav.php?id_categ=$id_categ action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value= '$intitule_categ'><br><br>";
		echo "Type <select name=id_util>";
			$donnees = $id_util;
			test_option_select ($donnees,"Publique","0");
			test_option_select ($donnees,"Privée","$id");
		echo"<input type =hidden name=action value=O>";
		echo "<br><br>";
		echo "<input type=submit value='Modifier la catégorie'>";
		echo"<input type =hidden name=id_categ value=$id_categ>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		// Sinon on ajoute cette catégorie
		{
		$maj_categ_fav = "UPDATE categorie_favori SET intitule_categ = '$intitule_categ', id_util=$id_util WHERE id_categ = $id_categ;";
		$exe_maj_categ_fav = mysql_query ($maj_categ_fav);
		if (!$exe_maj_categ_fav)
		{
		echo "Erreur dans la BDD";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		{
		if ($id_util == 0)
		{
		echo "<br><br>La catégorie publique '$intitule_categ' a été mise à jour avec succès<br><br>";
		}
		else
		{
		echo "<br><br>La catégorie privée '$intitule_categ' a été mise à jour avec succès<br><br>";
		}
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		}
		}
		}
		//Fin d'insertion du code
         ?>
		</center>
		</body>
		</html>