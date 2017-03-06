<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	include ("../biblio/config.php");
	echo "<html>
	<head>
  		<title>$nom_espace_collaboratif</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" >
		<link href=\"../templates/collaboratice_mire_connexion.css\" rel=\"stylesheet\" type=\"text/css\" >
	</head>";

	//echo "<div align = \"center\">";
	//Inclusion des fichiers n&eacute;cessaires
	//include ("../biblio/config.php");
	include ("../biblio/init.php");
	include ("../biblio/fct.php");

	//R&eacute;cup&eacute;ration des variables du formulaire
	@$login = $_POST['login'];
	@$password = $_POST['password'];
	@$validation_formulaire = $_POST['validation_formulaire'];
	if (!ISSET($validation_formulaire))
	{
		@$validation_formulaire = $_GET['validation_formulaire'];
	}
	//echo "<br />Validation du formualire : $validation_formulaire";
	  
	if ($validation_formulaire == "Se connecter")
	{
	/*
		echo "<br />Validation du formualire 2 : $validation_formulaire";
		echo "<br />login : $login";
		echo "<br />login2 : $login2";
		echo "<br />Mot de passe : $password";
	*/
	   
		//Test de l'existance des variables et de leur contenu
		//Si les variables n'existent pas ou contiennent des champs vide, on r&eacute;affiche
		//Le  formulaire de connexion, sinon...
	
		if(!isset($login) || !isset($password) || $login == "" || $password == "")
		{
			echo "<form method=\"POST\" action=\"verif_connexion.php\">";
				//echo "<br />";
				include ("mire_connexion.inc.php");
				/*
				echo "<br />";
				include ("mire_oubli_mot_de_passe.inc.php");
				*/
			echo "</form>";
		}
	
		//Sinon, on recherche dans la base de donn&eacute;e, l'existance de l'utilisateur
		else
		{
			$query = "SELECT nom, password, mail, droit, sexe, id_util, choix_theme, identifiant, visible FROM util where identifiant = '".$login."' and password = '".md5($password)."';";
			
			//echo "<br />$query";
			
			$results = mysql_query($query);
			if(!$results)
			{
				echo "Probl&egrave;me de connexion, Vous n'&ecirc;tes pas inscrit ou erreur dans la requ&egrave;te";
				mysql_close();
				exit;
			}
			$trait_res = mysql_fetch_row($results);
		
			//Si on ne trouve rien sur l'utilisateur,on r&eacute;affiche le formulaire avec un message
			if(!$results || $trait_res[0] == "" || $trait_res[1] == "")
			{
				//echo "<center>";
				echo "<span class = \"erreur-connexion\">Erreur d'identifiant<br />ou de mot de passe,<br />recommencer<br />ou demander<br />un nouveau<br />mot de passe&nbsp;!</span>";
					echo "<form method=\"POST\" action=\"verif_connexion.php\">";
						//echo "<br />";
						include ("mire_connexion.inc.php");
						/*
						echo "<br />";
						include ("mire_oubli_mot_de_passe.inc.php");
						*/
					echo "</form>";
			}
			//Sinon on effectue la connexion
			else
			{
				//On vérifie si le compte est activé ou non
				
				$visible = $trait_res[8];
				if ($visible == "N")
				{
					echo "<h2>Votre compte n'est pas activ&eacute;, contactez l'administrateur&nbsp;!</h2>";
					exit;
				}
				//Mise en place du login dans la session
				$trait_res[0] = ucfirst($trait_res[0]);
				$_SESSION['nom'] = $trait_res[0];
				$_SESSION['mail'] = $trait_res[2];
				$_SESSION['droit'] = $trait_res[3];
				$_SESSION['sexe'] = $trait_res[4];
				$_SESSION['id_util'] = $trait_res[5];
				//$_SESSION['choix_theme'] = $trait_res[6]; //on r&eacute;cup&egrave;re le theme choisi de l'utilisateur
				//$_SESSION['theme'] = "../templates/".$trait_res[6]."/collaboratice_principal.css";
				$_SESSION['chemin_images_theme'] = "../templates/".$trait_res[6]."/images/";
				$_SESSION['chemin_theme'] = "../templates/".$trait_res[6]."/";
				$_SESSION['identifiant'] = $trait_res[7];
	
				//on incr&eacute;mente le compteur de connexion et met &agrave; jour la date de la derni&egrave;re connexion
				//on extrait le compteur enregistr&eacute;
				$query_stats = "SELECT DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS FROM util where id_util = '".$_SESSION['id_util']."';";
				$results_stats = mysql_query($query_stats);
				if(!$results_stats)
				{
					echo "Probl&egrave;me de connexion, Vous n'êtes pas inscrit ou erreur dans la requ&egrave;te";
					mysql_close();
					exit;
				}
				$res_stats = mysql_fetch_row($results_stats);
				//echo "date actuelle : $date_aujourdhui - derni&egrave;re connexion : $res_stats[0] - nombre de connexions : $res_stats[1]";
       
				//on incr&eacute;mente le compteur
				$nombre_connexions=$res_stats[1]+1;
				//echo "<br />nombre de connexions mis &agrave; jour : $nombre_connexions";
       
				//et maintenant on met &agrave; jour avec les nouvelles valeurs
				$query_maj_date_derniere_connexion = "UPDATE util SET DATE_DERNIERE_CONNEXION = '".$date_aujourdhui."', NOMBRE_CONNEXIONS ='".$nombre_connexions."' WHERE id_util = '".$_SESSION['id_util']."';";

				//echo "$query_maj_date_derniere_connexion";

				$results_maj_date_derniere_connexion = mysql_query($query_maj_date_derniere_connexion);
				
				if(!$results_maj_date_derniere_connexion)
				{
					echo "<FONT COLOR = \"#808080\"><b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b></FONT>";
					echo "<br /><br /><a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</a>";
					mysql_close();
					exit;
				}
////////////////////////////////////////////////////////////////////////////////
/*
				echo "<frameset rows=\"90,*\">";
					echo "<frame name=\"body\" src=\"entete_tb.php\" FRAMEBORDER=\"0\"scrolling=\"no\">";
					echo "<frameset cols = \"100,*,200\">";
						echo "<frame name = \"cadre_menu\" src=\"modules_verticales.php\" FRAMEBORDER=\"0\">";
						echo "<frameset rows=\"*,65\">";
							echo "<frame name=\"body\" src=\"tb.php\" FRAMEBORDER=\"0\">";
							echo "<frame name=\"cadre_modules\" src=\"modules_horizontales.php\" FRAMEBORDER=\"0\" scrolling=\"no\">";
						echo "</frameset>";
						echo "<frame name = \"cadre_menu_droite\" src=\"bloc_informations.php\" FRAMEBORDER=\"0\">";
					echo "</frameset>";
				echo "</frameset>";
*/
////////////////////////////////////////////////////////////////////////////////
/*

				echo "<frameset cols = \"100,*,100\">
					<frame name = \"cadre_menu\" src=\"modules_verticales.php\" FRAMEBORDER=\"0\">
					<frameset rows=\"90,*,65\">
						<frame name=\"body\" src=\"entete_tb.php\" FRAMEBORDER=\"0\"scrolling=\"no\">
						<frame name=\"body\" src=\"tb.php\" FRAMEBORDER=\"0\">
						<frame name=\"cadre_modules\" src=\"modules.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
					</frameset>
					<frame name = \"cadre_menu_droite\" src=\"modules_verticales_droite.php\" FRAMEBORDER=\"0\">
				</frameset>";
*/


				echo "<frameset rows=\"*,65\">
					<frame name=\"body\" src=\"tb.php\" FRAMEBORDER=\"0\">
					<frame name=\"cadre_modules\" src=\"modules.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
				</frameset>";

			}
		}
		//Fermeture de la connexion &agrave; la BDD
		mysql_close();
	} //Fin if ($validation_formulaire == "Cliquez ici pour se connecter")
	else //Proc&eacute;dure pour la g&eacute;n&eacute;ration d'un nouveau mot de passe
	{
		@$login2 = $_POST['login2'];
		@$mel = $_POST['mel'];
		/*
		echo "<br />login 2 : $login2";
		echo "<br />m&eacute;l : $mel";
		*/
		//if(!isset($login2) || $login2 == "")
		if(!isset($mel) || $mel == "")
		{
			echo "<form method=\"POST\" action=\"verif_connexion.php\">";
				//echo "<br />";
				include ("mire_oubli_mot_de_passe.inc.php");
			echo "</form>";
		}
		//Sinon, on recherche dans la base de donn&eacute;e, l'existance de l'utilisateur
		else
		{
			//$query = "SELECT nom, mail, droit, sexe, visible FROM util where identifiant = '".$login2."' and mail = '".$mel."' AND visible = 'O';";
			$query = "SELECT id_util, nom, mail, droit, sexe, visible FROM util where mail = '".$mel."' AND visible = 'O';";
			//echo "<br />$query";
			
			$results = mysql_query($query);
			if(!$results)
			{
				echo "Probl&egrave;me de connexion, Vous n'&ecirc;tes pas inscrit ou erreur dans la requ&ecirc;te";
				mysql_close();
				exit;
			}
			$trait_res = mysql_fetch_row($results);
			
			//Si on ne trouve rien sur l'utilisateur,on r&eacute;affiche le formulaire avec un message
			//if(!$results || $trait_res[0] == "" || $trait_res[1] == "")
			if(!$results || $trait_res[0] == "")
			{
				echo "<form method=\"POST\" action=\"verif_connexion.php\">";
					echo "<br />";
					include ("mire_oubli_mot_de_passe.inc.php");
				echo "</form>";

				echo "<form action = \"message_a_administrateur.php\" METHOD = \"POST\">
				<h2>Vous pouvez envoyer un message &agrave; l'administrateur pour lui signaler que vous n'avez pas r&eacute;ussi &agrave; demander un nouveau mot de passe.</h2>
					<input type = \"hidden\" VALUE = \"".$login2."\" NAME = \"utilisateur\">
					<input type = \"hidden\" VALUE = \"probl&egrave;me g&eacute;n&eacute;ration mot de passe\" NAME = \"message\">
					<input type = \"submit\" VALUE = \"Cliquez ici pour envoyer un message\">
				</form>";
			}
			else // la personne est bien dans la base, on peut g&eacute;n&eacute;rer un nouveau mot de passe et l'envoyer
			{
				//include ("../biblio/fct.php");
				$nouveau_mot_de_passe = gen_mot_passe($trait_res[0],$trait_res[1]);
				/*
				echo "<br />id_util : $trait_res[0]";
				echo "<br />nom : $trait_res[1]";
				echo "<br />m&eacute;l : $trait_res[2]";
				echo "<br />droit : $trait_res[3]";
				echo "<br />Sexe : $trait_res[4]";
				echo "<br />mot de passe g&eacute;n&eacute;r&eacute; : $nouveau_mot_de_passe";
				*/
				$query_modif_mp = "UPDATE util SET
					PASSWORD = '".md5($nouveau_mot_de_passe)."'
					WHERE id_util = '".$trait_res[0]."';";
					$results_modif_mp = mysql_query($query_modif_mp);
				if(!$results_modif_mp)
				{
					echo "<FONT COLOR = \"#808080\"><b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'ex&eacute;cution de la requ&ecirc;te</b></FONT>";
					echo "<br /><br /> <a href = \"index.php\" class = \"bouton\">Retour &agrave; la page d'accueil</a>";
					mysql_close();
					exit;
				}
				else //tout est bon, le mot de passe peuit être envoy&eacute;
				{
					$sujet = "[GT] Nouveau mot de passe";
					$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
					//Composition du message &agrave; envoyer
					$contenu_a_envoyer="Vous avez demand&eacute; un nouveau mot de passe. 
Le voici, il faut respecter minuscules et majuscules : ".
$nouveau_mot_de_passe;
          $contenu_a_envoyer=$contenu_a_envoyer."

Vous pouvez vous connecter &agrave; l'adresse ".$adresse_collaboratice;
		          
          $ok=mail($trait_res[2], $sujet, $contenu_a_envoyer, $entete);
					echo "<span class = \"envoi-mdp\">Un nouveau mot de passe<br />a &eacute;t&eacute; g&eacute;n&eacute;r&eacute;.<br />Il a &eacute;t&eacute; envoy&eacute; dans<br />votre boîte aux lettres.</span>";
				}
			}
		}
	}  
	//echo "</div>";
?>
</body>
</html>
