<?PHP
	//On récupère les informations saisies et on vérifie que le titre est bien renseigné
	$nom = $_POST['nom'];
	$contenu = $_POST['contenu'];
	$id_categ_pere = $_POST['id_categ'];
	//$id_util = $_SESSION['id_util'];
	//$nom_util = $_SESSION['nom'];

	/*
	echo "<br />nom : $nom";
	echo "<br />contenu : $contenu";
	echo "<br />id_categ : $id_categ";
	echo "<br />id_util : $id_util";
	*/
	if(!isset($nom) || $nom == "")
	{
		echo "<h2>Veuillez renseigner le titre de la cat&eacute;gorie</h2>";
		include ("gestion_categories_ajout_categorie.inc.php");
		$affichage = "N";
	}
	else //on peut l'enregistrer
	{
		//Il faut vérifier si la catégorie existe déjà pour l'utilisateur
		$requete_verif = "SELECT * FROM categorie WHERE nom = '".$nom."' AND id_util = '".$_SESSION['id_util']."'";
		$resultat_verif = mysql_query($requete_verif);
		$verif = mysql_num_rows($resultat_verif);
		if ($verif <> 0)
		{
			echo "<h2>Cette cat&eacute;gorie existe d&eacute;j&agrave;&nbsp;!</h2>";
		}
		else
		{
			//sinon on enregistre
			$requete_insertion = "INSERT INTO categorie (NOM, NOM_UTIL, MAIL_UTIL, INFO_DIVERS, DATE_CREATION, ID_CATEG_PERE, id_util)
				VALUES ('".$nom."','".$_SESSION['nom']."','".$_SESSION['mail']."','".$contenu."','".date('j/m/Y')."', '".$id_categ_pere."', '".$_SESSION['id_util']."');";
			$resultat_requete_insertion = mysql_query($requete_insertion);
			if (!$resultat_requete_insertion)
			{
				echo "<h2>Probl&egrave;me d'&eacute;x&eacute;cution de la requ&egrave;te.</h2>";
				echo "<A HREF = \"gestion_categories.php?id_categ=$id_categ\" TARGET = \"body\" class = \"bouton\"><BR>Retour à la gestion des catégories</B></FONT></A>";
				mysql_close();
				exit;
			}
			else
			{
				echo "<h2>Cat&eacute;gorie enregistr&eacute;e</h2>";
			}
		}
	}
?>
