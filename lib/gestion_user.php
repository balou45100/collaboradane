<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	//Inclusion des fichiers nécessaires
	include ("../biblio/init.php");
	include ("../biblio/fct.php");
	include ("../biblio/config.php");

	//echo "<br />nb_utilisateurs_a_afficher : $nb_utilisateurs_a_afficher";

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_utilisateurs.png\" ALT = \"Titre\">";

			//On v�rifie si l'utilisateur connect� a des droits d'administration
			$autorisation_administration = verif_appartenance_groupe(14);

			//On regarde s'il y a des actions � faire
			$action = $_GET['action'];
			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			$a_faire = $_GET['a_faire'];
			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}
			/*
			echo "<br />a_faire : $a_faire";
			echo "<br />action : $action";
			*/
			$id_util = $_SESSION['id_util'];
			//echo "<br />id_util : $id_util";
			//On r�cup�re les id des structures � la quelle la personne conn�ct�e appartient
			$structures = recup_structure_util2($id_util);

			//echo "<br >structures : $structures";

			if ($action == "O")
			{
				switch ($a_faire)
				{
					case "inscription":
						//echo "<br />Il faut afficher le formulaire pour l'inscription";
						include ("gestion_user_formulaire_saisie_util.inc.php");
						$affichage = "N";
					break;

					case "verif_formulaire":
						include ("gestion_users_verif_formulaire_saisie.inc.php");
					break;

					case "modifier":
						//On r�cup�re l'identifiant de l'utilisateur � modifier
						$id_util_a_modifier = $_GET['id_util_a_modifier'];
						//echo "<h2>Il faut modifier l'utilisateur $id_util</h2>";
						include ("gestion_users_modif_util.inc.php");
						$affichage = "N";
					break;

					case "modification_confirmee":
						//echo "<br />On r�cup�re l'identifiant de l'utilisateur � modifier";
						$id_util_a_modifier = $_POST['id_util_a_modifier'];

						//echo "<br />id_util_a_modifier : $id_util_a_modifier";

						include ("gestion_users_confirmation_modif_util.inc.php");
						//$affichage = "N";
					break;

					case "supprimer":
						//On r�cup�re l'identifiant de l'utilisateur � supprimer
						$id_util_a_supprimer = $_GET['id_util_a_supprimer'];
						//echo "<h2>Il faut supprimer l'utilisateur $id_util</h2>";
						include ("gestion_users_suppression_util.inc.php");
						$affichage = "N";
					break;

					case "suppression_confirmee":
						//On r�cup�re l'identifiant de l'utilisateur � supprimer
						$id_util_a_supprimer = $_GET['id_util_a_supprimer'];
						//echo "<h2>L'utilisateur $id_util est d&eacute;finitivement supprim&eacute;</h2>";
						include ("gestion_users_suppression_confirmee.inc.php");
						//$affichage = "N";
					break;
				} // Fin switch ($a_faire)
			} // Fin if ($action == "O")

			//On affiche la liste s'il n'y a pas d'actions � faire
			if ($affichage <> "N")
			{
				echo "<h2>Les membres de l'espace '$nom_espace_collaboratif'</h2>";
				$indice = $_GET['indice'];

				//if($_SESSION['droit'] == "Super Administrateur")
				if($autorisation_administration == "1")
				{
					$nb_par_page = $nb_utilisateurs_a_afficher;
					//echo "<A HREF = \"form_util.php\" class = \"bouton\">Ins�rer un nouvel utilisateur</A><BR><BR>";
					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"gestion_user.php?action=O&amp;a_faire=inscription\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/utilisateur_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer un-e nouvel-le utilisateur/trice\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvel-le utilisateur/trice</span><br />";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				}
				else
				{
					$nb_par_page = $nb_utilisateurs_a_afficher;
				}

				//echo "<br />nb_par_page : $nb_par_page";

				//echo "Pour tout envoie de mail, l'adresse de la personne connect� est mise par defaut en copie<BR><BR>";
				echo "<TABLE width = \"95%\">
					<TR>
						<th>Nom &nbsp;&nbsp;</th>
						<th>Pr&eacute;nom &nbsp;&nbsp;</th>
						<th>Structure(s)&nbsp;&nbsp;</th>
						<th>M&eacute;l&nbsp;&nbsp;</th>
						<th>T&eacute;l&eacute;phone bureau&nbsp;&nbsp;</th>
						<th>Poste&nbsp;&nbsp;</th>
						<th>Mobile pro&nbsp;&nbsp;</th>
						<th>T&eacute;l&eacute;phone personnel&nbsp;&nbsp;</th>
						<th>Autre t&eacute;l&eacute;phone&nbsp;&nbsp;</th>
						<th>Mobile perso&nbsp;&nbsp;</th>";

						//if($_SESSION['droit'] == "Super Administrateur")
						if($autorisation_administration == "1")
						{
							echo "<th>Derni&egrave;re connexion</th>
							<th>Nb de connexions</th>
							<th>activ&eacute;-e</th>
							<th>Actions&nbsp;&nbsp;</th>";
						}
					echo "</TR>";
					//Requ�te pour afficher tout les utilisateurs
					//if($_SESSION['droit'] == "Super Administrateur")
					if($autorisation_administration == "1")
					{
						$query = "SELECT * from util ORDER BY NOM ASC";

						//echo "$query";

						$results = mysql_query($query);
						if(!$results)
						{
							echo "Probl&egrave;me lors de la connexion &egrave; la base de donn&eacute;es</B>";
							echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
							mysql_close();
							exit;
						}
					}
					else
					{
						$query = "SELECT * from util AS U, util_structures_util AS USU WHERE U.ID_UTIL = USU.FK_id_util AND USU.FK_id_structure IN $structures AND (U.DROIT <>'Super Administrateur' AND U.visible = 'O') ORDER BY NOM ASC";

						//echo "<br />$query";

						$results = mysql_query($query);
						if(!$results)
						{
							echo "<B>Probl&egrave;me lors de la connexion &egrave; la base de donn&eacute;es</B>";
							echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A>";
							mysql_close();
							exit;
						}
					}

					//Retourne le nombre de ligne rendu par la requ�te
					$num_results = mysql_num_rows($results);
					
					//echo "<br />num_results : $num_results";

					///////////////////////////////////
					//Partie sur la gestion des pages//
					///////////////////////////////////
					$nb_page = number_format($num_results/$nb_par_page,1);
					//echo "Page&nbsp;<A HREF = \"gestion_user.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
					If ($indice == 0)
					{
						echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
					}
					else
					{
						echo "<a href = \"gestion_user.php?indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
					}

					for($j = 1; $j<$nb_page; ++$j)
					{
						$nb = $j * $nb_par_page;
						$page = $j + 1;
						if ($page * $nb_par_page == $indice + $nb_par_page)
						{
							echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
						}
						else
						{
							echo "&nbsp;<a href = \"gestion_user.php?indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
						}
						//echo "<A HREF = \"gestion_user.php?indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
					}
					$j = 0;
					
					//echo "<br />indice : $indice";
					
					while($j<$indice)
					{
						$res = mysql_fetch_row($results);
						++$j;
					}
					
					//echo "<br />indice : $indice";
					//echo "<br />nb_par_page : $nb_par_page";

					/////////////////////////
					//Fin gestion des pages//
					/////////////////////////

					//Traitement de chaque ligne
					//il faut �viter qu'un m�me utilisateur s'affiche plusieurs fois
					$util_avant = 0;
					for ($i = 0; $i < $nb_par_page; ++$i)
					{
						$res = mysql_fetch_row($results);

						//echo "<br >for : util_avant : $util_avant ; res[8] : $res[8]";

						if ($res[8] <> $util_avant)
						{
							if ($res[1] <>"")
							{
								echo "<TR>";
									echo "<TD>";
										echo strtoupper($res[1]); //Nom
									echo "</TD>";
									echo "<TD>";
										echo str_replace("*", " ",$res[0]); //Pr�nom
									echo "</TD>";
									echo "<TD>";
										$structure_a_afficher = recup_structure_util($res[8]);
										echo "&nbsp;$structure_a_afficher"; //Appartenance structures
									echo "</TD>";

									echo "<TD nowrap>";
										if ($res[3] != "") //M�l
										{
											echo "<A HREF = \"mailto:".$res[3]."?cc=".$_SESSION['mail']."\">".$res[3]."</A>";
										}
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[4]);
										//echo $res[4]; //T�l bureau
										echo $tel; //T�l bureau
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[9]);
										echo $tel; //Poste t�l bureau
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[5]);
										echo $tel; //Mobile professionnel
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[10]);
										echo $tel; //T�l perso
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[14]);
										echo $tel; //Autre T�l perso
									echo "</TD>";
									echo "<TD align = \"center\">";
										$tel = affiche_tel($res[11]);
										echo $tel; //Mobile perso
									echo "</TD>";
									//if($_SESSION['droit'] == "Super Administrateur")
									if($autorisation_administration == "1")
									{
										echo "<TD align=\"center\">";
											echo $res[12]; //derni�re connexion
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $res[13]; //nombre de connexions
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $res[15]; //actif ou non
										echo "</TD>";

										echo "<TD class = \"fond-actions\" nowrap>";
											echo "&nbsp;<A HREF = \"gestion_user.php?action=O&amp;a_faire=modifier&amp;id_util_a_modifier=".$res[8]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"gestion_user.php?action=O&amp;a_faire=supprimer&amp;id_util_a_supprimer=".$res[8]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";
										echo "&nbsp;</TD>";
									}
								echo "</TR>";
							} //Fin boucle if res[1]<> ""
						} //Fin boucle if avant <> res[8]
						$util_avant = $res[8];
					} //Fin boucle for
					//Fermeture de la connexion � la BDD
					mysql_close();
			echo "</TABLE>";
			} //Fin if ($affichage <> "N")
?>
		</div>
	</body>
</html>
