<?php
						//echo "<br />Je vérifie si le formulaire est bien renseigné";
						//Je récupère d'abord toutes les données saisies
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
						$structure = $_POST['structure'];
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
*/
						//On regarde s'il y a des erreurs dans le formulaire saisie
						if ($prenom =="" || $nom =="" || $mail == "" || $password1 == "")
						{
							echo "<h2>Le pr&eacute;nom, le nom, l'adresse &eacute;lectronique et le mot de passe sont obligatoires&nbsp;!</h2>";
							include ("gestion_user_formulaire_saisie_util.inc.php");
							$affichage = "N";
						}
						else
						{
							//Il faut tester si les deux mots de passe saisie sont egaux
							if ($password1 <> $password2)
							{
								echo "<h2>Les mots de passes ne sont pas identiques, recommencez&nbsp;</h2>";
								include ("gestion_user_formulaire_saisie_util.inc.php");
								$affichage = "N";
							}
							else
							{
								//echo "<br />Il semblerait que tout est en ordre et que l'on peut enregistrer la personne";
								//il faut enregistrer la personne
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
													echo "<a href = \"gestion_user.php?indice=0\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
													echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
												echo "</td>";
											echo "</tr>";
										echo "</table>";
									echo "</div>";
									//echo "<BR> <A HREF = \"gestion_user.php?indice=0\" class=\"bouton\">Retour &agrave; la gestion des utilisateurs</A>";
									mysql_close();
									exit;
									$affichage = "N";
								}
								//On génère l'identifiant
								$identifiant = genere_identifiant($prenom, $nom,inscription);
								$initiales = genere_initiales($prenom,$nom);

								//echo "<br />identifiant : $identifiant";
								//echo "<br />initiales : $initiales";

								$query = "INSERT INTO util (PRENOM, NOM, PASSWORD, MAIL, TEL_BUREAU, MOBILE_PRO, POSTE_TEL_BUREAU, TEL_PERSO, TEL_AUTRE, MOBILE_PERSO, identifiant, initiales) 
									VALUES ('".str_replace(" ", "*",$prenom)."', '".$nom."', '".md5($password1)."', '".$mail."', '".$num_tel."', '".$num_tel_port."', '".$poste_tel."','".$num_tel_perso."','".$tel_autre."','".$num_tel_port_perso."','".$identifiant."','".$initiales."');";
								$results = mysql_query($query);
								if(!$results)
								{
									echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es et/ou l'ex&eacute;cution de la requ&ecirc;te</h2>";
									echo "<div align = \"center\">";
										echo "<table class = \"menu-boutons\">";
											echo "<tr>";
												echo "<td>";
													echo "<a href = \"gestion_user.php?indice=0\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
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
									//On crée la fiche pour les statistiques
									$no_dernier_id_genere = mysql_insert_id();
									//echo "<br />no_dernier_id_genere : $no_dernier_id_genere";
									$requete_fiche_stat = "INSERT INTO statistiques_utilisation (idUtilisateur) VALUE ('".$no_dernier_id_genere."')";
									
									//echo "<br />requete_fiche_stat : $requete_fiche_stat";
									
									$resultat = mysql_query($requete_fiche_stat);
									echo "<h2>$prenom $nom a bien &eacute;t&eacute; ins&eacute;r&eacute;-e</h2>";

									//On ajoute dans la table structure_util
									//echo "<br />structure : $structure";
									//echo "<br />no_dernier_id_genere : $no_dernier_id_genere";
									
									if ($structure <> "")
									{
										$requete_insertion = "INSERT INTO util_structures_util (FK_id_util, FK_id_structure)
											VALUES ('".$no_dernier_id_genere."', '".$structure."')";
										
										//echo "<br />$requete_insertion";
										
										$resultat_insert_structure = mysql_query($requete_insertion);
									}
/*
									echo "<div align = \"center\">";
										echo "<table class = \"menu-boutons\">";
											echo "<tr>";
												echo "<td>";
													echo "<a href = \"gestion_user.php?indice=0\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
													echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
												echo "</td>";
											echo "</tr>";
										echo "</table>";
									echo "</div>";
*/
								}
							}
						}
?>
