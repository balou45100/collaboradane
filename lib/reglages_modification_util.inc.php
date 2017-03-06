<?php
	//Récupération des données depuis form_util.php ou modif_util.php ou reglages.php
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$password_origine = $_POST['password_origine'];
	$mail = $_POST['mail'];
	$num_tel = $_POST['num_tel'];
	$num_tel_port = $_POST['num_tel_port'];
	$poste_tel = $_POST['poste_tel'];
	$num_tel_perso = $_POST['num_tel_perso'];
	$num_tel_port_perso = $_POST['num_tel_port_perso'];
	$tel_autre = $_POST['tel_autre'];
	$type = $_POST['type'];
	$identifiant = $_POST['identifiant'];
	$identifiant_origine = $_POST['identifiant_origine'];
	$choix_theme = $_POST['choix_theme'];

	/*
	echo "<br />prenom : $prenom";
	echo "<br />nom : $nom";
	echo "<br />mail : $mail";
	echo "<br />num_tel : $num_tel";
	echo "<br />num_tel_port : $num_tel_port";
	echo "<br />poste_tel : $poste_tel";
	echo "<br />num_tel_perso : $num_tel_perso";
	echo "<br />tel_autre : $tel_autre";
	echo "<br />origine : $origine";
	echo "<br />type : $type";
	echo "<br />password1 : $password1";
	echo "<br />password2 : $password2";
	echo "<br />password_origine : $password_origine";
	echo "<br />identifiant : $identifiant";
	echo "<br />identifiant_origine : $identifiant_origine";
	echo "<br />choix_theme : $choix_theme";
	*/

	//Test sur les valeurs obligatoires 
	if (!isset($password1) || !isset($password2) || $password1 == "" || $password2 == "" AND (!isset($identifiant) || $identifiant == "" ))
	{
		echo "<h2>Le mot de passe <strong>et</strong> l'identifiant sont obligatoires&nbsp;!</h2>";
		$password1_a_afficher = $password_origine;
		$password2_a_afficher = $password_origine;
		include ("verif_util_formulaire_modif_util.inc.php");
	}
	else if($password1 != $password2 || $password1 == "" AND (ISSET($identifiant) || $identifiant <> ""))
	{
		echo "<h2>Erreur dans la saisie du mot de passe, l'ancien est remis en fonction&nbsp;!</h2>";
		$password1_a_afficher = $password_origine;
		$password2_a_afficher = $password_origine;
		include ("verif_util_formulaire_modif_util.inc.php");
	}
	else if (!isset($identifiant) || $identifiant == "" )
	{
		echo "<h2>L'identifiant est obligatoire&nbsp;!</h2>";
		$password1_a_afficher = $password1;
		$password2_a_afficher = $password2;
		include ("verif_util_formulaire_modif_util.inc.php");
	}
	else //Tous les champs ont été renseignés correctement
	{
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
		$id_util = $_SESSION['id_util'];
		$query = "UPDATE util SET 
			TEL_BUREAU = '".$num_tel."', 
			MOBILE_PRO = '".$num_tel_port."', 
			POSTE_TEL_BUREAU = '".$poste_tel."', 
			TEL_PERSO = '".$num_tel_perso."', 
			TEL_AUTRE = '".$tel_autre."', 
			MOBILE_PERSO = '".$num_tel_port_perso."', 
			identifiant = '".$identifiant."', 
			choix_theme = '".$choix_theme."', 
			PASSWORD = '".$password1."' 
		WHERE id_util = '".$id_util."'";

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
			//On réinitialise le theme au cas où ...
			$_SESSION['chemin_theme'] = "../templates/".$choix_theme."/";
			$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
			$chemin_theme_images = $_SESSION['chemin_theme']."images";
			//echo "<br />theme : $theme";

			echo "<h2>Modifications enregistr&eacute;es</h2>";
/*
			echo "<div align = \"center\">";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"reglages.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
*/
		}
	}
?>
