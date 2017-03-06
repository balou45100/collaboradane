<?php
	//Lancement de la session
	session_start();
	$id_util = $_SESSION['id_util'];
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
	echo "</head>
	<body>
		<div align = \"center\">";
			$largeur_tableau = "80%";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			$action = $_GET['action'];
			$intitule = $_GET['intitule'];
			//$id_util = $_GET['id_util'];
			$id_categ = $_GET['id_categ'];
			$id_fav = $_GET['id_fav'];
			$retour = $_GET['retour'];
			$adresse = $_GET['adresse'];
			$type_favoris = $_GET['type_favoris'];

			$largeur_tableau = "50%";
			/*
			echo "<br />action = $action";
			echo "<br />id_categ : $id_categ";
			echo "<br />intitule : $intitule";
			echo "<br />adresse : $adresse";
			echo "<br />id_util : $id_util";
			echo "<br />type_favoris : $type_favoris";
			echo "<br />id_fav : $id_fav";
			echo "<br />intitule : $intitule";
			*/

			if ($type_favoris == "publiques")
			{
				$id_util_a_rechercher = "0";
				$type = "Publique";
			}
			else
			{
				$id_util_a_rechercher = $id_util;
				$type = "Privée";
			}

			if ($intitule == "" || $adresse == "" and $action == "O")
			{
				echo "<br /><strong>2</strong>";
				echo "<h2>Modification du favori '$intitule'</h2>";
				echo "<h2>Informations manquantes&nbsp!</h2>";
				//echo "<form action = favoris_modif_fav.php?id_fav=$id_fav action=get>";
				echo "<form action = favoris_modif_fav.php>";
					echo "<TABLE width = \"$largeur_tableau%\">
						<TR>
							<TD class = \"etiquette\">Nom du favori&nbsp;:&nbsp;</TD>
							<TD><input name=intitule size=60 maxlength=60 value='$intitule'></td>
						</TR>";
						echo "<TR>
							<TD class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>";
								if ($adresse == "")
								{
									echo "<TD><input name=intitule size=120 maxlength=255 value='http://www.'></td>";
								}
								else
								{
									echo "<TD><input name=adresse size=120 maxlength=255 value=$adresse></td>";
								}
						echo "</TR>";
						echo "<TR>
							
							<TD class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</TD>
							<TD>";
								echo "<select name=id_categ>";
									//On récupère la liste des catégories disponibles 
									//D'abord celle du type d'origine
									
									if ($type_favoris == "publiques")
									{
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories publiques\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											test_option_select_new ($resultats_categ[0],$id_categ,$resultats_categ[1]);
										echo "</OPTGROUP>";
										
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories priv&eacute;es\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											echo "<option value = $resultats_categ[0]>$resultats_categ[1]</option>";
										echo "</OPTGROUP>";
									}
									else
									{
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories priv&eacute;es\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											test_option_select_new ($resultats_categ[0],$id_categ,$resultats_categ[1]);
										echo "</OPTGROUP>";

										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories publiques\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											echo "<option value = $resultats_categ[0]>$resultats_categ[1]</option>";
										echo "</OPTGROUP>";
									}
									
									/*
									echo "<br />$recup_categ";
									
									$exe_recup_categ = mysql_query ($recup_categ);
									while($resultats_categ = mysql_fetch_array($exe_recup_categ))
									if ($id_util == 0)
									{
										echo "<option value = $resultats_categ[0]>$resultats_categ[1]</option>";
									}
									else
									{
										echo "<option value = $resultats_categ[0]>$resultats_categ[1] (cat. priv&eacute;)</option>";
									}
									*/
								echo"</select>";
							echo "</TD>
						</TR>";
						echo "<TR>
							<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
						</TR>";
					echo "</table>";
					echo "<input type = hidden name = action value = O>";
					echo "<input type = hidden name = id_categ value = $id_categ>";
					echo "<input type = hidden name = id_fav value = $id_fav>";
					echo "<input type = hidden name = retour value = $retour>";
					echo "<br />";
					//echo "<input type = submit value = 'Modifier le favori'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Modifier le favori''\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				echo "</form>";

				//echo "<br>";
				//echo "<a href = $retour><input type=submit value=Retour></a>";		
			}
			else
			{
				if ($action <> "O")
				{
					//echo "<br /><strong>2</strong>";

					$recup_fav = "SELECT intitule, adresse, id_categ FROM favoris WHERE id_favori = '".$id_fav."';";
					$exe_recup_fav = mysql_query($recup_fav);
					while ($results_recup_fav = mysql_fetch_row($exe_recup_fav))
					{
						$intitule = $results_recup_fav[0];
						$adresse = $results_recup_fav[1];
						$id_categ = $results_recup_fav[2];
					}

					echo "<h2>Modification du favori '$intitule'</h2>";
					//echo "<form action = favoris_modif_fav.php?id_fav=$id_fav action=get>";
					echo "<form action = favoris_modif_fav.php>";
					echo "<TABLE width = \"$largeur_tableau%\">
						<TR>
							<TD class = \"etiquette\">Nom du favori&nbsp;:&nbsp;</TD>
							<TD><input name=intitule size=60 maxlength=60 value='$intitule'></td>
						</TR>";
						echo "<TR>
							<TD class = \"etiquette\">Adresse&nbsp;:&nbsp;</TD>
							<TD><input name=adresse size=120 maxlength=255 value='$adresse'></td>
						</TR>";
						echo "<TR>
							<TD class = \"etiquette\">Cat&eacute;gorie&nbsp;:&nbsp;</TD>
							<TD>";
								echo "<select name=id_categ>";
									//On récupère la liste des catégories disponibles 
									//D'abord celle du type d'origine

									if ($type_favoris == "publiques")
									{
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
										
										echo "<br />$recup_categ";
										
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories publiques\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											test_option_select_new ($resultats_categ[0],$id_categ,$resultats_categ[1]);
										echo "</OPTGROUP>";
										
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories priv&eacute;es\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											echo "<option value = $resultats_categ[0]>$resultats_categ[1]</option>";
										echo "</OPTGROUP>";
									}
									else
									{
										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = $id_util ORDER BY intitule_categ;";
										
										echo "<br />$recup_categ";
										
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories priv&eacute;es\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
										{
											test_option_select_new($resultats_categ[0],$id_categ,$resultats_categ[1]);
										}
										echo "</OPTGROUP>";

										$recup_categ = "SELECT * FROM favoris_categories WHERE id_util = 0 ORDER BY intitule_categ;";
										$exe_recup_categ = mysql_query ($recup_categ);
										echo "<OPTGROUP LABEL=\"Cat&eacute;gories publiques\">";
										while($resultats_categ = mysql_fetch_array($exe_recup_categ))
											echo "<option value = $resultats_categ[0]>$resultats_categ[1]</option>";
										echo "</OPTGROUP>";
									}
								echo"</select>";
							echo "</TD>
						</TR>";
						echo "<TR>
							<TD colspan=\"4\" class = \"td-1\"></TD>
						</TR>";
					echo "</table>";
					echo "<INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">";
					echo "<input type = hidden name = action value = O>";
					echo "<input type = hidden name = id_fav value = $id_fav>";
					echo "<input type = hidden name = retour value = $retour>";
					//echo "<input type = submit value = 'Modifier le favori'>";

					echo "<div align = \"center\">";
						echo "<table class = \"menu-boutons\">";
							echo "<tr>";
								echo "<td>";
									echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
								echo "</td>";
								echo "<td>";
									echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Modifier le favori''\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";

					echo "</form>";
					//echo "<br>";
					//echo "<a href = $retour><input type=submit value=Retour></a>";	
				}
				else //Il faut mettre à jour le favoris
				{
					$maj_fav = "UPDATE favoris SET intitule = '$intitule', adresse = '$adresse', id_categ = '".$id_categ."' WHERE id_favori = '".$id_fav."';";
					$exe_maj_fav = mysql_query ($maj_fav);
					if (!$exe_maj_fav)
					{
						echo "Erreur dans la BDD";
						echo "<br>";
						//echo "<a href = $retour><input type=submit value=Retour></a>";

						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					}
					else
					{
						echo "<h2>Le favori '$intitule' a &eacute;t&eacute; mis &agrave; jour avec succ&egrave;s</h2>";
						//echo "<a href = $retour><input type=submit value=Retour></a>";
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"$retour\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					}
				}
			}
?>
		</div>
	</body>
</html>
