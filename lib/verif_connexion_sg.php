<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Ce fichier permet de connecter un utilisateur au service">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include ("../biblio/config.php");
		?>
	</head>
	<?php

		//Inclusion des fichiers nécessaires
		include ("../biblio/init.php");
		include ("../biblio/fct.php");
		

		//Récupération des variables du formulaire
		@$login = $_POST['login'];
		@$password = $_POST['password'];
		@$validation_formulaire = $_POST['validation_formulaire'];
	  
	  //echo "<BR>Validation du formualire : $validation_formulaire";
	  
	  if ($validation_formulaire == "Connexion")
	  {
	   /*
     echo "<BR>Validation du formualire 2 : $validation_formulaire";
	   echo "<BR>login : $login";
	   echo "<BR>login2 : $login2";
	   echo "<BR>Mot de passe : $password";
	   */
	   
    //Test de l'existance des variables et de leur contenu
		//Si les variables n'existent pas ou contiennent des champs vide, on réaffiche
		//Le  formulaire de connexion, sinon...
		
		if(!isset($login) || !isset($password) || $login == "" || $password == "")
		{
			echo "
<form method=\"POST\" action=\"verif_connexion.php\">

<table width=\"100%\" border=\"0\" height=\"94%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#000000\">
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"700\">&nbsp;</td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"160\" colspan=\"2\" rowspan=\"2\">
			<table width=\"100%\" border=\"1\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#333333\">
				<tr BGCOLOR = $bg_color1>
					<td height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Espace collaboratif</font></b></TD>
          <td align =\"center\"><img border=\"0\" src = \"$chemin_theme_images/$logo\"></td>
          
				</tr>
				<tr BGCOLOR = $bg_color2>
					<td colspan = \"2\" align=\"center\" valign=\"middle\">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
						  <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"login\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Mot de passe : </font></td>
								<td width=\"40%\">
									<input type=\"password\" name=\"password\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr  BGCOLOR = $bg_color2 align=\"center\">
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Connexion\" NAME = \"validation_formulaire\">
								</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
				      <tr BGCOLOR = $bg_color1>
					       <td colspan =\"3\" height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Mot de passe oublié</font></b></td>
				      </tr>
				      <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"login2\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Votre adresse électronique : </font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"mel\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Cliquez ici pour recupérer un nouveau\" NAME = \"validation_formulaire\">
								</td>
							</tr>
              <tr BGCOLOR = $bg_color2>
					       <td>&nbsp;</td>
				      </tr>
				      <tr BGCOLOR = $bg_color2>
					       <td align = \"center\" colspan =\"2\" height=\"10\"><font color=$color_text_version><small>$version</small></font></td>
				      </tr>
				      
						</table>
						</td>
				</tr>
			</table>
		</td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td height=\"150\">&nbsp;</td>
		<td width=\"10\" bgcolor=\"#666666\" height=\"*\"></td>
		<td height=\"150\">&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\" bgcolor=\"#666666\" width=\"250\"></td>
		<td height=\"10\" width=\"10\" bgcolor=\"#666666\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"400\" valign=\"top\"></td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
</table>
</FORM>

			";
		}
	
		//Sinon, on recherche dans la base de donnée, l'existance de l'utilisateur
		else
		{
		  
			$query = "SELECT nom, password, mail, droit, sexe, id_util FROM util where nom = '".$login."' and password = '".md5($password)."';";
			$results = mysql_query($query);
			if(!$results)
			{
				echo "Problème de connexion, Vous n'êtes pas inscrit ou erreur dans la requète";
				mysql_close();
				exit;
			}
			$trait_res = mysql_fetch_row($results);
			
			//Si on ne trouve rien sur l'utilisateur,on réaffiche le formulaire avec un message
			if(!$results || $trait_res[0] == "" || $trait_res[1] == "")
			{
				echo "
					<CENTER>
						<h2>Erreur d'identifiant ou de mot de passe, recommencer ou demander un nouveau mot de passe.</h2>
	<table width=\"100%\" border=\"0\" height=\"94%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#000000\">
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"700\">&nbsp;</td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"160\" colspan=\"2\" rowspan=\"2\">
			<table width=\"100%\" border=\"1\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#333333\">
				<tr BGCOLOR = $bg_color1>
					<td height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Espace collaboratif</font></b></TD>
          <td align =\"center\"><img border=\"0\" src = \"$chemin_theme_images/$logo\"></td>
          
				</tr>
				<tr BGCOLOR = $bg_color2>
					<td colspan = \"2\" align=\"center\" valign=\"middle\">
						<form method=\"POST\" action=\"verif_connexion.php\">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
						  <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"login\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Mot de passe : </font></td>
								<td width=\"40%\">
									<input type=\"password\" name=\"password\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr  BGCOLOR = $bg_color2 align=\"center\">
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Connexion\" NAME = \"validation_formulaire\">
								</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
				      <tr BGCOLOR = $bg_color1>
					       <td colspan =\"3\" height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Mot de passe oublié</font></b></td>
				      </tr>
				      <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"login2\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"60%\" align=\"right\"><font color=$color_text>Votre adresse électronique : </font></td>
								<td width=\"40%\">
									<input type=\"text\" name=\"mel\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Cliquez ici pour recupérer un nouveau\" NAME = \"validation_formulaire\">
								</td>
							</tr>
              <tr BGCOLOR = $bg_color2>
					       <td>&nbsp;</td>
				      </tr>
				      <tr BGCOLOR = $bg_color2>
					       <td align = \"center\" colspan =\"2\" height=\"10\"><font color=$color_text_version><small>$version</small></font></td>
				      </tr>
				      
						</table>
						</td>
				</tr>
			</table>
		</td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td height=\"150\">&nbsp;</td>
		<td width=\"10\" bgcolor=\"#666666\" height=\"*\"></td>
		<td height=\"150\">&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\" bgcolor=\"#666666\" width=\"250\"></td>
		<td height=\"10\" width=\"10\" bgcolor=\"#666666\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"400\" valign=\"top\"></td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
</table>
</FORM>
";
			}
			//Sinon on effectue la connexion
			else
			{
				//Mise en place du login dans la session
				$trait_res[0] = ucfirst($trait_res[0]);
				$_SESSION['nom'] = $trait_res[0];
				$_SESSION['mail'] = $trait_res[2];
				$_SESSION['droit'] = $trait_res[3];
				$_SESSION['sexe'] = $trait_res[4];
				$_SESSION['id_util'] = $trait_res[5];
				
				//on incrémente le compteur de connexion et met à jour la date de la dernière connexion
				//on extrait le compteur enregistré
				$query_stats = "SELECT DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS FROM util where nom = '".$login."';";
				$results_stats = mysql_query($query_stats);
				if(!$results_stats)
				{
					echo "Problème de connexion, Vous n'êtes pas inscrit ou erreur dans la requète";
					mysql_close();
					exit;
				}
				$res_stats = mysql_fetch_row($results_stats);
				//echo "date actuelle : $date_aujourdhui - dernière connexion : $res_stats[0] - nombre de connexions : $res_stats[1]";
        
				//on incrémente le compteur
				$nombre_connexions=$res_stats[1]+1;
				//echo "<br>nombre de connexions mis à jour : $nombre_connexions";
        
				//et maintenant on met à jour avec les nouvelles valeurs
				$query_maj_date_derniere_connexion = "UPDATE util SET DATE_DERNIERE_CONNEXION = '".$date_aujourdhui."', NOMBRE_CONNEXIONS ='".$nombre_connexions."' WHERE nom = '".$login."';";
				$results_maj_date_derniere_connexion = mysql_query($query_maj_date_derniere_connexion);
				if(!$results_maj_date_derniere_connexion)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée ou problème inexistant</B></FONT>";
					echo "<BR><BR><A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
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
		//Fermeture de la connexion à la BDD
		mysql_close();
    
    }
    else //Procédure pour la génération d'un nouveau mot de passe
    {
      @$login2 = $_POST['login2'];
		  @$mel = $_POST['mel'];
		  /*
      echo "<BR>login 2 : $login2";
      echo "<BR>mél : $mel";
      */
      if(!isset($login2) || $login2 == "")
		  {
			 echo "

<table width=\"100%\" border=\"0\" height=\"94%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#000000\">
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"550\">&nbsp;</td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"160\" colspan=\"2\" rowspan=\"2\">
			<table width=\"100%\" border=\"1\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#333333\">
				<tr BGCOLOR = $bg_color1>
					<td height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Mot de passe oublié</font></b></TD>
          <td align =\"center\"><img border=\"0\" src = \"$chemin_theme_images/$logo\"></td>
          
				</tr>
				<tr BGCOLOR = $bg_color2>
					<td colspan = \"2\" align=\"center\" valign=\"middle\">
						<form method=\"POST\" action=\"verif_connexion.php\">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
						  <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"50%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"50%\">
									<input type=\"text\" name=\"login2\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"50%\" align=\"right\"><font color=$color_text>Votre adresse électronique : </font></td>
								<td width=\"50%\">
									<input type=\"text\" name=\"mel\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr  BGCOLOR = $bg_color2 align=\"center\">
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Cliquez ici pour recupérer un nouveau\" NAME = \"validation_formulaire\">
								</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
				      
						</table>
						</td>
				</tr>
			</table>
		</td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td height=\"150\">&nbsp;</td>
		<td width=\"10\" bgcolor=\"#666666\" height=\"*\"></td>
		<td height=\"150\">&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\" bgcolor=\"#666666\" width=\"250\"></td>
		<td height=\"10\" width=\"10\" bgcolor=\"#666666\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"400\" valign=\"top\"></td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
</table>
</FORM>



			";
		}
	
		//Sinon, on recherche dans la base de donnée, l'existance de l'utilisateur
		else
		{
			$query = "SELECT nom, mail, droit, sexe FROM util where nom = '".$login2."' and mail = '".$mel."';";
			$results = mysql_query($query);
			if(!$results)
			{
				echo "Problème de connexion, Vous n'êtes pas inscrit ou erreur dans la requète";
				mysql_close();
				exit;
			}
			$trait_res = mysql_fetch_row($results);
			
			//Si on ne trouve rien sur l'utilisateur,on réaffiche le formulaire avec un message
			if(!$results || $trait_res[0] == "" || $trait_res[1] == "")
			{
				echo "

<table width=\"100%\" border=\"0\" height=\"94%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#000000\">
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"550\">&nbsp;</td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"160\" colspan=\"2\" rowspan=\"2\">
			<table width=\"100%\" border=\"1\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#333333\">
				<tr BGCOLOR = $bg_color1>
					<td height=\"52\" align=\"center\"><b><font size=\"6\" color=$color_text_titre>Mot de passe oublié</font></b></TD>
          <td align =\"center\"><img border=\"0\" src = \"$chemin_theme_images/$logo\"></td>
          
				</tr>
				<tr BGCOLOR = $bg_color2>
					<td colspan = \"2\" align=\"center\" valign=\"middle\">
						<form method=\"POST\" action=\"verif_connexion.php\">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
						  <tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"50%\" align=\"right\"><font color=$color_text>Identifiant (Votre nom)&nbsp;:</font></td>
								<td width=\"50%\">
									<input type=\"text\" name=\"login2\" maxlength=\"70\" size=\"50\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
								<td width=\"50%\" align=\"right\"><font color=$color_text>Votre adresse électronique : </font></td>
								<td width=\"50%\">
									<input type=\"text\" name=\"mel\" maxlength=\"50\" size=\"50\"\">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr  BGCOLOR = $bg_color2 align=\"center\">
							  <td>&nbsp;</td>
								<td colspan=\"2\" align=\"left\">
									<INPUT TYPE = \"submit\" VALUE = \"Cliquez ici pour recupérer un nouveau\" NAME = \"validation_formulaire\">
								</td>
							</tr>
							<tr BGCOLOR = $bg_color2>
					       <td colspan =\"2\">&nbsp;</td>
				      </tr>
				      </FORM>
				      <FORM ACTION = \"message_a_administrateur.php\" METHOD = \"POST\">
				      <tr align = \"center\" BGCOLOR = $bg_color1>
					       <td colspan =\"3\"><font size=\"3\" color=$color_text><b>Vous pouvez envoyer un message à l'administrateur pour lui signaler que vous n'avez pas réussi à demander un nouveau mot de passe. N'oubliez pas de renseigner l'identifiant.</font></b></td>
				      </tr>
				      <tr align = \"center\" BGCOLOR = $bg_color1>
					       <td colspan =\"3\">
                    <INPUT TYPE = \"hidden\" VALUE = \"".$login2."\" NAME = \"utilisateur\">
								    <INPUT TYPE = \"hidden\" VALUE = \"problème génération mot de passe\" NAME = \"message\">
						        <INPUT TYPE = \"submit\" VALUE = \"Cliquez ici pour envoyer un message\">
						      </td>
				      </tr>
				      </table>
						</td>
				</tr>
			</table>
		</td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td height=\"150\">&nbsp;</td>
		<td width=\"10\" bgcolor=\"#666666\" height=\"*\"></td>
		<td height=\"150\">&nbsp;</td>
	</tr>
	<tr>
		<td height=\"10\"></td>
		<td height=\"10\" width=\"10\"></td>
		<td height=\"10\" bgcolor=\"#666666\" width=\"250\"></td>
		<td height=\"10\" width=\"10\" bgcolor=\"#666666\"></td>
		<td height=\"10\"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width=\"10\"></td>
		<td width=\"400\" valign=\"top\"></td>
		<td width=\"10\"></td>
		<td>&nbsp;</td>
	</tr>
</table>
</FORM>

";
			}
			else // la personne est bien dans la base, on peut générer un nouveau mot de passe et l'envoyer
			{
        //include ("../biblio/fct.php");
        $nouveau_mot_de_passe = gen_mot_passe($trait_res[0],$trait_res[1]);
        /*echo "<BR>Nom : $trait_res[0]";
        echo "<BR>mél : $trait_res[1]";
        echo "<BR>droit : $trait_res[2]";
        echo "<BR>Sexe : $trait_res[3]";
        echo "<BR>mot de passe généré : $nouveau_mot_de_passe";
        */
        $query_modif_mp = "UPDATE util SET
						PASSWORD = '".md5($nouveau_mot_de_passe)."'
						WHERE NOM = '".$trait_res[0]."';";
						$results_modif_mp = mysql_query($query_modif_mp);
				if(!$results_modif_mp)
				{
					echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					echo "<BR><BR> <A HREF = \"index.php\" class = \"bouton\">Retour à la page d'accueil</A>";
					mysql_close();
					exit;
				}
				else //tout est bon, le mot de passe peuit être envoyé
				{
				  $sujet = "[GT] Nouveau mot de passe";
		      $entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
		        
          //Composition du message à envoyer
          $contenu_a_envoyer="Vous avez demandé un nouveau mot de passe. 
Le voici, il faut respecter minuscules et majuscules : ".
$nouveau_mot_de_passe;
          $contenu_a_envoyer=$contenu_a_envoyer."

Vous pouvez vous connecter à l'adresse ".$adresse_collaboratice;
		          
          $ok=mail($trait_res[1], $sujet, $contenu_a_envoyer, $entete);
					echo "<CENTER><FONT COLOR = \"#808080\"><h2>Un nouveau mot de passe a été généré. Il a été envoyé dans votre boîte aux lettres.</h2></FONT></CENTER>";
				}
      }
    }
  }
	  
?>

</html>
