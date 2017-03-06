<?php
	//On récupère les variables
	$id_util_a_modifier = $_POST['id_util_a_modifier'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$password_origine = $_POST['password_origine'];
	$visible = $_POST['visible'];
	$num_tel = $_POST['num_tel'];
	$num_tel_port = $_POST['num_tel_port'];
	$poste_tel = $_POST['poste_tel'];
	$num_tel_perso = $_POST['num_tel_perso'];
	$num_tel_port_perso = $_POST['num_tel_port_perso'];
	$tel_autre = $_POST['tel_autre'];
	$identifiant = $_POST['identifiant'];
	$identifiant_origine = $_POST['identifiant_origine'];

	/*
	echo "<br />id_util_a_modifier : $id_util_a_modifier";
	echo "<br />num_tel : $num_tel";
	echo "<br />num_tel_port : $num_tel_port";
	echo "<br />poste_tel : $poste_tel";
	echo "<br />num_tel_perso : $num_tel_perso";
	echo "<br />tel_autre : $tel_autre";
	echo "<br />origine : $origine";
	echo "<br />password1 : $password1";
	echo "<br />password2 : $password2";
	echo "<br />password_origine : $password_origine";
	echo "<br />identifiant : $identifiant";
	echo "<br />identifiant_origine : $identifiant_origine";
	echo "<br />visible : $visible";
	*/

	//On vérifie si le mot de passe a été changé et dans ce cas on le chiffre
	if ($password_origine <> $password1)
	{
		$password1 = md5($password1);
	}
	//on vérifie si l'identifiant a été modifié
	if ($identifiant <> $identifiant_origine)
	{
		//On vérifie s'il n'existe pas déjà
		//echo "<br />L'identifiant $identifiant a &eacute;t&eacute; chang&eacute;";
		$verif_identifiant = verif_identifiant($identifiant);

		//echo "<br />retour modif_perso verif_identifiant : $verif_identifiant";

		if ($verif_identifiant <> 0)
		{
			echo "<h2>l'identifiant \"$identifiant\" existe d&eacute;j&agrave;, essayez un autre&nbsp;!</h2>";
			$identifiant = $identifiant_origine;
		}
		else
		{
			//On accepte le nouvel identifiant
			$_SESSION['identifiant'] = $identifiant;
		}
	}
	//$id_util = $_SESSION['id_util'];
	$query = "UPDATE util SET 
		TEL_BUREAU = '".$num_tel."', 
		MOBILE_PRO = '".$num_tel_port."', 
		POSTE_TEL_BUREAU = '".$poste_tel."', 
		TEL_PERSO = '".$num_tel_perso."', 
		TEL_AUTRE = '".$tel_autre."', 
		MOBILE_PERSO = '".$num_tel_port_perso."', 
		identifiant = '".$identifiant."', 
		visible = '".$visible."', 
		PASSWORD = '".$password1."' 
	WHERE id_util = '".$id_util_a_modifier."'";

	$results = mysql_query($query);
	if(!$results)
	{
		echo "<h2>Probl&egrave;me de connexion &agrave; la base de données et/ou l'ex&eacute;cution de la requ&ecurc;te</h2>";
		echo "<BR><BR> <A HREF = \"gestion_user.php?indice=0\" class=\"bouton\">Retour à la gestion des utilisateurs</A>";
		mysql_close();
		exit;
	}
	else
	{
		echo "<h2>Modifications enregistr&eacute;es</h2>";
/*
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"gestion_users.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
*/
	}
?>
