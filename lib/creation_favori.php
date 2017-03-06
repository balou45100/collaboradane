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
		$adresse = $_GET['adresse'];
		$intitule = $_GET['intitule'];
		$id_util = $_GET['id_util'];
		$id_categ = $_GET ['id_categ'];
		echo "<h2>Création d'une nouvelle catégorie</h2><br>";
		if ($intitule <> "" and $action == "O")
		{
		// On vérifie si le favori existe déjà ou non
		$verif_favori = "SELECT * FROM favori WHERE adresse = '$adresse' AND intitule = '$intitule' AND id_categ = $id_categ;";
		$exe_verif_favori = mysql_query ($verif_favori);
		$nb = mysql_num_rows ($exe_verif_favori);
		if ($nb == 1)
		{
		echo "Ce favori a déjà été ajoutée<br><br>";
		echo "<form action = creation_favori.php action=get>";
		echo "Nom du favori	<input name=intitule size=20 maxlength=20 value=$intitule><br><br>";
		echo "Adresse du favori	<input name=adresse size=50 maxlength=200 value=$adresse><br><br>";
		echo "Catégorie <select name=id_categ>";
		$recup_categ_public = "SELECT * FROM categorie_favori WHERE id_util =0 ORDER BY intitule_categ;";
		$exe_recup_categ_public = mysql_query ($recup_categ_public);
		while($results_public = mysql_fetch_array($exe_recup_categ_public))
		echo "<option value = $results_public[0]>$results_public[1] (Public)</option>";
		$recup_categ_privee = "SELECT * FROM categorie_favori WHERE id_util =$id ORDER BY intitule_categ;";
		$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
		while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
		echo "<option value = $results_privee[0]>$results_privee[1] (Privée)</option>";
		echo"</select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter le favori'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		// Sinon on ajoute ce favori
		{
		$ajout_favori = "INSERT INTO favori (adresse, intitule, id_categ) VALUES ('$adresse', '$intitule', $id_categ);";
		$exe_ajout_favori = mysql_query ($ajout_favori);
		if (!$exe_ajout_favori)
		{
		echo "Erreur dans la BDD";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		else
		{
		$nom_categorie = "SELECT intitule_categ, id_util FROM categorie_favori WHERE id_categ = $id_categ;";
		$exe_nom_categorie = mysql_query ($nom_categorie);
		while($results_categ = mysql_fetch_array($exe_nom_categorie))
		{
		$nom_categ = $results_categ[0];
		$id_util = $results_categ[1];
		}
		if ($id_util == 0)
		{
		echo "Le favori '$intitule' ($adresse) a été ajoutée avec succès dans la catégorie publique '$nom_categ'<br><br>";
		}
		else
		{
		echo "Le favori '$intitule' ($adresse) a été ajoutée avec succès dans la catégorie privée '$nom_categ'<br><br>";
		}
		echo "<a href = creation_favori.php><input type=submit value='Nouveau favori'></a><br><br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";
		}
		}
		}
		else
		{
		if ($action == "O" and $intitule == "")
		{
		echo "Informations manquantes sur le favori<br><br>";
		echo "<form action = creation_favori.php action=get>";
		echo "Nom du favori	<input name=intitule size=20 maxlength=20 value=$intitule><br><br>";
		echo "Adresse du favori	<input name=adresse size=50 maxlength=200 value=$adresse><br><br>";
		echo "Catégorie <select name=id_categ>";
		$recup_categ_public = "SELECT * FROM categorie_favori WHERE id_util =0 ORDER BY intitule_categ;";
		$exe_recup_categ_public = mysql_query ($recup_categ_public);
		while($results_public = mysql_fetch_array($exe_recup_categ_public))
		echo "<option value = $results_public[0]>$results_public[1] (Public)</option>";
		$recup_categ_privee = "SELECT * FROM categorie_favori WHERE id_util =$id ORDER BY intitule_categ;";
		$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
		while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
		echo "<option value = $results_privee[0]>$results_privee[1] (Privée)</option>";
		echo"</select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter le favori'>";
		echo "</form>";
		echo "<br>";
		echo "<a href = favoris.php><input type=submit value=Retour></a>";		
		}
		else
		{
		echo "<form action = creation_favori.php action=get>";
		echo "Nom du favori	<input name=intitule size=20 maxlength=20 value=><br><br>";
		echo "Adresse du favori	<input name=adresse size=50 maxlength=200 value='http://www.'><br><br>";
		echo "Catégorie <select name=id_categ>";
		$recup_categ_public = "SELECT * FROM categorie_favori WHERE id_util =0 ORDER BY intitule_categ;";
		$exe_recup_categ_public = mysql_query ($recup_categ_public);
		while($results_public = mysql_fetch_array($exe_recup_categ_public))
		echo "<option value = $results_public[0]>$results_public[1] (Public)</option>";
		$recup_categ_privee = "SELECT * FROM categorie_favori WHERE id_util =$id ORDER BY intitule_categ;";
		$exe_recup_categ_privee = mysql_query ($recup_categ_privee);
		while($results_privee = mysql_fetch_array($exe_recup_categ_privee))
		echo "<option value = $results_privee[0]>$results_privee[1] (Privée)</option>";
		echo"</select><br><br>";
		echo"<input type =hidden name=action value=O>";
		echo "<input type=submit value='Ajouter le favori'>";
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
