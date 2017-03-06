<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>


<!DOCTYPE HTML>

<!"Pour la verification des données concernant"
"un utilisateur afin de procéder à sa mise à jour ou à son inscription"
"Les données qui afflux vers se fichier proviennent de form_util.php pour l'inscription &"
"de modif_util.php pour la modification ">

<?php
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
			<?php
				//Connexion à la base de données
				include ("../biblio/init.php");
				include ("../biblio/fct.php");
				//Récupération des données depuis form_util.php ou modif_util.php ou reglages.php
				$prenom = $_POST['prenom'];
				$nom = strtoupper($_POST['nom']);
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
				$choix_theme = $_POST['choix_theme'];
				
				/*
				echo "<br />tel_autre : $tel_autre<br>";
				echo "<br />origine : $origine";
				echo "<br />type : $type";
				echo "<br />password1 : $password1";
				echo "<br />password2 : $password2";
				echo "<br />password_origine : $password_origine";
				echo "<br />identifiant : $identifiant";
				echo "<br />choix_theme : $choix_theme";
				*/
				
				if($type == "inscription")
				{
					$droit = $_POST['droit'];
					//récupération des droits
					if($droit == "Utilisateur")
					{
						$selected = "Utilisateur";
						$other = "Super Administrateurn";
					}
					else
					{
						$selected = "Super Administrateur";
						$other = "Utilisateur";
					}
				}

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
					//Dans le cas d'une inscription
					//On se retrouve devant une requète insert
					if($type == "inscription")
					{
						//On vérifie d'abord si le nouvel utilisateur existe ou pas dans la base de donnée
						$query = "SELECT * FROM util where nom = '".$nom."' AND mail = '".$mail."';";
						$results = mysql_query($query);
						$num = mysql_num_rows($results);
						if($num >= 1)
						{
							echo "<h2>Utilisateur d&eacute;j&agrave; existant&nbsp;!</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
							//echo "<BR> <A HREF = \"gestion_user.php?indice=0\" class=\"bouton\">Retour &agrave; la gestion des utilisateurs</A>";
							mysql_close();
							exit;
						}
						//On génère l'identifiant
						$identifiant = genere_identifiant($prenom, $nom);
						
						//echo "<br />identifiant : $identifiant";
						
						$query = "INSERT INTO util (PRENOM, NOM, PASSWORD, MAIL, TEL_BUREAU, MOBILE_PRO, DROIT, POSTE_TEL_BUREAU, TEL_PERSO, TEL_AUTRE, MOBILE_PERSO, identifiant) 
							VALUES ('".str_replace(" ", "*",$prenom)."', '".$nom."', '".md5($password1)."', '".$mail."', '".$num_tel."', '".$num_tel_port."', '".$droit."', '".$poste_tel."','".$num_tel_perso."','".$tel_autre."','".$num_tel_port_perso."','".$identifiant."');";
						$results = mysql_query($query);
						if(!$results)
						{
							echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es et/ou l'ex&eacute;cution de la requ&ecirc;te</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
							mysql_close();
							exit;
						}
						else
						{
							echo "<h2>$prenom $nom a bien &eacute;t&eacute; ins&eacute;r&eacute;-e</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
						}
					}
					//Dans le cas d'une modification
					//On se retrouve devant une requéte update
					if($type == "modification")
					{
						if ($password_origine <> $password1)
						{
							echo "<BR>les mots de passe sont différents<BR>";
							$query = "UPDATE util SET TEL_BUREAU = '".$num_tel."', MOBILE_PRO = '".$num_tel_port."', POSTE_TEL_BUREAU = '".$poste_tel."', TEL_PERSO = '".$num_tel_perso."', TEL_AUTRE = '".$tel_autre."', MOBILE_PERSO = '".$num_tel_port_perso."' PASSWORD = '".md5($password1)."' WHERE NOM = '".$nom."' AND MAIL = '".$mail."';";
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
								echo "<h2>Vos donn&eacute;es ont bien &eacute;t&eacute; modifi&eacute;es</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
							}
						}
						else
						{
							echo "<BR>les mots de passe sont égaux<BR>";
							$query = "UPDATE util SET TEL_BUREAU = '".$num_tel."', MOBILE_PRO = '".$num_tel_port."', POSTE_TEL_BUREAU = '".$poste_tel."', TEL_PERSO = '".$num_tel_perso."', TEL_AUTRE = '".$tel_autre."', MOBILE_PERSO = '".$num_tel_port_perso."' WHERE NOM = '".$nom."' AND MAIL = '".$mail."';";
							$results = mysql_query($query);
							if(!$results)
							{
								echo "<h2>Probl&egrave;me de connexion &agrave; la base de données et/ou l'ex&eacute;cution de la requ&ecurc;te</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
								mysql_close();
								exit;
							}
							else
							{
								echo "<h2>Vos donn&eacute;es ont bien &eacute;t&eacute; modifi&eacute;es</h2>";
								echo "<div align = \"center\">";
									echo "<table class = \"menu-boutons\">";
										echo "<tr>";
											echo "<td>";
												echo "<a href = \"gestion_user.php?indice=0\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
												echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</div>";
							}
						}
					} //Fin type = modification
					if($type == "modification_perso")
					{
						//On vérifie si le mot de passe a été changé et dans ce cas on le chiffre
						if ($password_origine <> $password1)
						{
							$password1 = md5($password1);
						}
						//on vérifie si l'identifiant a été modifié
						if ($identifiant <> $_SESSION['identifiant'])
						{
							//On vérifie s'il n'existe pas déjà
							//echo "<br />L'identifiant $identifiant a &eacute;t&eacute; chang&eacute;";
							$verif_identifiant = verif_identifiant($identifiant);
							
							//echo "<br />retour modif_perso verif_identifiant : $verif_identifiant";
							
							if ($verif_identifiant <> 0)
							{
								echo "<h2>l'identifiant $identifiant existe d&eacute;j&agrave;, essayez un autre&nbsp;!</h2>";
								$identifiant = $_SESSION['identifiant'];
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

							//echo "<br />theme : $theme";
							
							echo "<h2>Vos donn&eacute;es ont bien &eacute;t&eacute; modifi&eacute;es</h2>";
							echo "<div align = \"center\">";
								echo "<table class = \"menu-boutons\">";
									echo "<tr>";
										echo "<td>";
											echo "<a href = \"reglages.php\"><img src = \"../image/retour_48.png\" ALT = \"Retour\" border = \"0\"></a>";
											echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</div>";
						}
					} //Fin type = modification_perso
				}
				//Fermeture de la connexion à la BDD
				mysql_close();
?>
		</CENTER>
	</body>
</html>
