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
		$action = $_GET['action'];
		$intitule_categ = $_GET['intitule_categ'];
		$id_util = $_GET['id_util'];
		echo "<h2>Création d'une nouvelle catégorie</h2><br>";
		if ($intitule_categ <> "" and $action == "O")
		{
		// On vérifie si la catégorie existe déjà ou non
		$verif_categ = "SELECT * FROM categorie_favori WHERE intitule_categ = '$intitule_categ' AND id_util = $id_util;";
		$exe_verif_categ = mysql_query ($verif_categ);
		$nb = mysql_num_rows ($exe_verif_categ);
		if ($nb == 1)
		{
		echo "Cette catégorie a déjà été ajoutée<br><br>";
		echo "<form action = creation_categorie.php action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value=><br><br>";
		echo "Type	<select name=id_util>
				<option value = 0> Publique </option>
				<option value = $id> Privée </option></select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter la catégorie'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		// Sinon on ajoute cette catégorie
		{
		$ajout_categ = "INSERT INTO categorie_favori (intitule_categ,id_util) VALUES ('$intitule_categ', $id_util);";
		$exe_ajout_categ = mysql_query ($ajout_categ);
		if (!$exe_ajout_categ)
		{
		echo "Erreur dans la BDD";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		{
		if ($id_util == 0)
		{
		echo "La catégorie publique '$intitule_categ' a été ajoutée avec succès<br><br>";
		}
		else
		{
		echo "La catégorie privée '$intitule_categ' a été ajoutée avec succès<br><br>";
		}
		echo "<a href = creation_categorie.php><input type=submit value='Nouvelle catégorie'></a><br><br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		}
		}
		else
		{
		if ($action == "O" and $intitule_categ == "")
		{
		echo "Vous n'avez pas renseigné le nom de la catégorie<br><br>";
		echo "<form action = creation_categorie.php action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value=><br><br>";
		echo "Type	<select name=id_util>
				<option value = 0> Publique </option>
				<option value = $id> Privée </option></select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter la catégorie'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";		
		}
		else
		{
		echo "<form action = creation_categorie.php action=get>";
		echo "Nom de la catégorie	<input name=intitule_categ size=20 maxlength=20 value=><br><br>";
		echo "Type	<select name=id_util>
				<option value = 0> Publique </option>
				<option value = $id> Privée </option></select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter la catégorie'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";		
		}
		}		
		//Fin d'insertion du code
        		 ?>
		</center>
		</body>
		</html>
