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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/javascripts.php");
			include ("../biblio/fct.php");
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_categories.png\" ALT = \"Titre\">";
			//Récupération des variables
			$_SESSION['origine'] = "gestion_categories";
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
			//Récupération de la variable indiquant le numéro de la catégorie père
			$id_categ = $_GET['id_categ'];
			if (!ISSET($id_categ))
			{
				$id_categ = $_POST['id_categ'];
			}
			/*
			echo "<br />origine : $origine";
			echo "<br />id_categ : $id_categ";
			echo "<br />action : $action";
			echo "<br />a_faire : $a_faire";
			echo "<br />largeur_icone_action : $largeur_icone_action";
			echo "<br />hauteur_icone_action : $hauteur_icone_action";
			*/
			if ($id_categ == -1)
			{ //nous sommes à la racine des catégories
				$intitule="Catégorie";
				//echo "<br>intitule -1 : $intitule";
			}
			else
			{
				//il peut y avoir un mélange de catégorie et de tickets
				$intitule="Catégorie";
			}

			if ($action == "O")
			{
				switch ($a_faire)
				{
					case "ajout_categorie":
						echo "<h2>Ajout de cat&eacute;gorie</h2>";
						include ("gestion_categories_ajout_categorie.inc.php");
						$affichage = "N";
					break;

					case "enreg_categorie":
						include ("gestion_categories_enreg_categorie.inc.php");
					break;
				} //Fin switch ($a_faire)
			} //Fin if ($action == "O")

			if ($affichage <> "N")
			{
				//Regard sur les catégories selon les droits
				if($_SESSION['droit'] == "Super Administrateur")
				{
					$query = "SELECT * FROM categorie WHERE ID_CATEG_PERE = '".$id_categ."' ORDER BY NOM ASC;";
				}
				else
				{
					$query = "SELECT * FROM categorie WHERE ID_CATEG_PERE = '".$id_categ."' AND id_util = '".$_SESSION['id_util']."' ORDER BY NOM ASC;";
				}
				$results = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results)
				{
					echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
					echo "<h2><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A></h2>";
					mysql_close();
					exit;
				}

				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);

				//echo "<A HREF = \"gestion_categories_ajout_categorie.php?id_categ=".$id_categ."\" TARGET = \"body\" class = \"bouton\"title=\"Ins&eacute;rer une nouvelle catégorie\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/nouvelle_categorie.png\" ALT = \"Nouvelle\"></A>";
				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								//echo "<a href = \"gestion_categories_ajout_categorie.php?id_categ=".$id_categ."\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouvelle cat&eacute;gorie\" title=\"Ins&eacute;rer une nouvelle cat&eacute;gorie\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle cat&eacute;gorie</span><br />";
								echo "<a href = \"gestion_categories.php?id_categ=".$id_categ."&amp;action=O&amp;a_faire=ajout_categorie\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/categorie_ajout.png\" ALT = \"Nouvelle cat&eacute;gorie\" title=\"Ins&eacute;rer une nouvelle cat&eacute;gorie\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle cat&eacute;gorie</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

				$res = mysql_fetch_row($results);

				//Regard lorsque l'on rentre dans une catégorie
				if($_SESSION['droit'] == "Super Administrateur")
				{
					$query = "SELECT * FROM categorie WHERE ID_CATEG = '".$id_categ."';";
				}
				else
				{
					$query = "SELECT * FROM categorie WHERE ID_CATEG = '".$id_categ."' AND NOM_UTIL = '".$_SESSION['nom']."' AND MAIL_UTIL = '".$_SESSION['mail']."';";
				}
				$resultss = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$resultss)
				{
					echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
					echo "<h2><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A></h2>";
					mysql_close();
					exit;
				}
				$ress = mysql_fetch_row($resultss);

				//Récupération de tous les problèmes
				//Et découpage selon les ; placé dans le tableau $pb_array
				$pb_array = explode(';', $ress[5]);

				$taille = count($pb_array)-1;
				////////////////Navigation/////////////
				if($id_categ == "-1")
				{
					echo "<h2>Vous vous situez &agrave; la racine du dossier</h2>";
				}
				else
				{
					$querys = "SELECT * FROM categorie WHERE ID_CATEG = '".$ress[6]."';";
					$result = mysql_query($querys);
					if(!$result)
					{
						echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
						echo "<h2><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</A></h2>";
						mysql_close();
						exit;
					}
					$resul = mysql_fetch_row($result);
					if($resul[1] == "")
					{
						echo "<h3>Vous &ecirc;tes dans le dossier ".$ress[1]." et son p&egrave;re est <A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\">la racine du dossier de gestion des cat&eacute;gories</A></h3>";
					}
					else
					{
						echo "<h3>Vous &ecirc;tes dans le dossier ".$ress[1]." et son p&egrave;re est <A HREF = \"gestion_categories.php?id_categ=".$resul[0]."\" TARGET = \"body\">".$resul[1]."</A></h3>";
					}
				}
				/////////////Fin Navigation/////////////
				echo "<TABLE BORDER = \"0\" ALIGN = \"CENTER\">";
					echo "<TR>";
						echo "<th>$intitule</th>";
						//l'utilisateur est un administrateur
						//Donc possiblité pour lui de voir qui à créé la catégorie
						if($_SESSION['droit'] == "Super Administrateur")
						{
							echo "<th>Cr&eacute;ateur</th>";
						}
						echo "<th>&nbsp;Actions&nbsp;</TD>";
					echo "</TR>";

					//Affichage de toutes les catégories situés soit à la racine,
					//Soit dans la catégorie que l'on navigue actuellement
					//while ($ligne=mysql_fetch_object($results))
					for($i=0; $i<$num_results; ++$i)
					{
						//$res = mysql_fetch_row($results);
						echo "<TR>";
							echo "<TD>";
								echo "<A HREF = \"gestion_categories.php?id_categ=".$res[0]."\" TARGET = \"body\"><FONT COLOR = \"#696969\">".$res[1]."</FONT></A>";
							echo "</TD>";
							if($_SESSION['droit'] == "Super Administrateur")
							{
								echo "<TD>$res[2]</TD>";
							}
							echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<A HREF = \"gestion_categories_modif_categ.php?id_categ=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier cette catégorie\"></A>";
								echo "&nbsp;<A HREF = \"gestion_categories_delete_categ.php?id_categ=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer cette catégorie\" height=\"24px\" width=\"24px\" ></A>";	
							echo "&nbsp;</TD>";
						echo "</TR>";

						$res = mysql_fetch_row($results);
					}
				echo "</table>";
				//Affichage de tous les problèmes
				//Dans la catégorie que l'on navigue actuellement
				if (@$id_categ <> -1)
				{
					echo "<TABLE BORDER = \"0\" >
						<TR>
							<th>ID</th>
							<th>ST</th>
							<th>Cr&eacute;&eacute; par</th>
							<th>Cr&eacute;&eacute; le</th>
							<th>Trait&eacute; par</th>
							<th>Dern. interv.</th>
							<th>RNE/No soc.</th>
							<th>Sujet</th>
							<!--th>Nb mes</th-->
							<th>Priorit&eacute;</th>
							<th>Actions</th>
						</TR>";
				}
				for($j = 0; $j<$taille; ++$j)
				{
					$query_pb = "SELECT * FROM probleme WHERE ID_PB = '".$pb_array[$j]."' ORDER BY ID_PB DESC;";
					$results_pb = mysql_query($query_pb);
					if(!$results_pb)
					{
						echo "<h2>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</h2>";
						mysql_close();
						exit;
					}

					//echo "<BR>N° : $res_query[0] - Statut : $res_query[11]";
					$res_query = mysql_fetch_row($results_pb);
					$num_results_count = mysql_num_rows($results_pb);
					if ($res_query[11] <> "A")
					{
						echo "<TR class = \"".statut($res_query[11])."\">";
							echo "<td>$res_query[0]</td>";
								switch ($res_query[14])
								{
									case "N":
										$couleur_fond = "#ffffff";
									break;

									case "C":
										$couleur_fond = "#00cc33";
									break;

									case "T":
										$couleur_fond = "#ff0000";
									break;

									case "A":
										$couleur_fond = "#ffff66";
									break;

									case "F":
										$couleur_fond = "#FF9FA3";
									break;

								}

								switch ($res_query[13])
								{
									case "2":
										$priorite_selection = "Normal";
										$priorite_non_selection_ref_1 = "1";
										$priorite_non_selection_ref_2 = "3";
										$priorite_non_selection_nom_1 = "Haute";
										$priorite_non_selection_nom_2 = "Basse";
										switch ($res_query[11])
										{
											case "M":
												$fond = "#B3CEEF";
											break;

											case "N":
												$fond = "#A4EFCA";
											break;

											case "A":
												$fond = "#FF9FA3";
											break;
										}
									break;

									case "1":
										$priorite_selection = "Haute";
										$priorite_non_selection_ref_1 = "2";
										$priorite_non_selection_ref_2 = "3";
										$priorite_non_selection_nom_1 = "Normal";
										$priorite_non_selection_nom_2 = "Basse";
										$fond = "#ff0000";
									break;

									case "3":
										$priorite_selection = "Basse";
										$priorite_non_selection_ref_1 = "1";
										$priorite_non_selection_ref_2 = "2";
										$priorite_non_selection_nom_1 = "Haute";
										$priorite_non_selection_nom_2 = "Normal";
										switch ($res_query[11])
										{
											case "M":
												$fond = "#B3CEEF";
											break;

											case "N":
												$fond = "#A4EFCA";
											break;

											case "A":
												$fond = "#FF9FA3";
											break;
										}
									break;

									default:
										$res[13] = "2";
										$priorite_selection = "Normal";
										$priorite_non_selection_ref_1 = "1";
										$priorite_non_selection_ref_2 = "3";
										$priorite_non_selection_nom_1 = "Haute";
										$priorite_non_selection_nom_2 = "Basse";
										switch ($res_query[11])
										{
											case "M":
												$fond = "#B3CEEF";
											break;

											case "N":
												$fond = "#A4EFCA";
											break;

											case "A":
												$fond = "#FF9FA3";
											break;
										}
									break;
								}
							echo "</td>";
							echo "<td BGCOLOR = $couleur_fond align=\"center\">&nbsp;</td>";
							echo "<TD>$res_query[3]</TD>";
							echo "<TD>$res_query[7]</TD>";
							echo "<TD>$res_query[15]</TD>";
							echo "<TD>$res_query[23]</TD>";
							echo "<TD>$res_query[4]</TD>";
							echo "<TD>$res_query[5]</TD>";
							echo "<TD BGCOLOR = $fond align=\"center\">$priorite_selection</TD>";
							echo "<td class = \"fond-actions\" nowrap>";
								echo "&nbsp;<A HREF = \"consult_ticket.php?CHGMT=N&idpb=".$res_query[0]."&amp;id_categ=$id_categ\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter\" title=\"Consulter et traiter ce ticket\"></A>";
								echo "&nbsp;<A HREF = \"affiche_categories.php?id_categ=$id_categ&amp;idpb=".$res_query[0]."\" target = \"body\" class=\"bouton\" title=\"Afficher les catégories du ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>";
								if($res_query[11] != "A")
								{
									echo "&nbsp;<A HREF = \"archiver_ticket.php?id_categ=$id_categ&amp;idpb=".$res_query[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/icozip.gif\" ALT = \"archiver\" title=\"Archiver ce ticket\"></A>";
									echo "&nbsp;<A HREF = \"modif_ticket.php?id_categ=$id_categ&amp;idpb=".$res_query[0]."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le contenu de ce ticket\"></A>";
								}
								if($_SESSION['nom'] == $res_query[3])
								{
									echo "&nbsp;<A HREF = \"delete_ticket.php?id_categ=$id_categ&amp;&amp;idpb=".$res_query[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer ce ticket\"></A>";
								}
							echo "&nbsp;</TD>";
						echo "</TR>";
					}
				}
			} // Fin if ($affichage <> "N")
?>
			</TABLE>
		</div>
	</BODY>
</HTML>
