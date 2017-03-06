<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
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

	echo "<body>
		<div align = \"center\">";
			//Inclusion des fichiers nécessaires
			include ("../biblio/fct.php");
			include ("../biblio/config.php");
			$action = $_GET['action']; // récupération de la variable pour savoir ce qu'il faut faire
			
			//echo "<br />action : $action";
			
			switch ($action)
			{
				case ('ajout_fiche') :
					echo "<FORM ACTION = \"repertoire_ajout_fiche.php\" METHOD = \"GET\">";
						echo "<h2>Les détails à renseigner pour créer une nouvelle fiche</h2>";
						echo "<TABLE width=\"95%\">";
							echo "<tr>";
								echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
								echo "<td colspan = \"7\"><input type=\"text\" value = \"$societe\" name=\"societe\" size=\"40\">&nbsp;&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Adresse&nbsp;:&nbsp;</td>";
								echo "<td colspan = \"7\"><input type=\"text\" value = \"$adresse\" name = \"adresse\" size=\"78\">&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td class = \"etiquette\">CP&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$cp\" name=\"cp\" size=\"6\">&nbsp;</td>";
								echo "<td class = \"etiquette\">Ville&nbsp;:&nbsp;</td>";
								echo "<td colspan = \"3\"><input type=\"text\" value = \"$ville\" name=\"ville\" size=\"68\"></td>";
								echo "<td class = \"etiquette\">Pays&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$pays\" name=\"pays\" size=\"20\"></td>";
							echo "</tr>";
							echo "<tr>";
								$checked=Testpourcocher($editeur);
								echo "<td class = \"etiquette\">&eacute;diteur&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name=\"editeur\" value=\"1\" $checked>&nbsp;&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								$checked=Testpourcocher($fabricants);
								echo "<td class = \"etiquette\">fabricant&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name=\"fabricants\" value=\"1\" $checked>&nbsp;&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								$checked=Testpourcocher($entreprise_de_service);
								echo "<td class = \"etiquette\">service&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name=\"entreprise_de_service\" value=\"1\" $checked>&nbsp;&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								$checked=Testpourcocher($presse_specialisee);
								echo "<td class = \"etiquette\">presse&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name= \"presse_specialisee\" value=\"1\" $checked></td>";
							echo "</tr>";
							echo "<tr>";
						echo "</TABLE>";
						echo "<TABLE width=\"95%\">";
								$checked=Testpourcocher($a_traiter);
								echo "<td class = \"etiquette\">à traiter&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name=\"a_traiter\" value=\"1\" $checked>&nbsp;&nbsp;</td>";
								echo "<td class = \"etiquette\">date&nbsp;(aaaa-mm-jj)&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" name=\"a_faire_quand_date\" value=\"$a_faire_quand_date\" size=\"19\">&nbsp;&nbsp;</td>";
								$checked=Testpourcocher($urgent); 
								echo "<td class = \"etiquette\">urgent&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"checkbox\" name=\"urgent\" value=\"1\" $checked>&nbsp;&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td class = \"etiquette\">Site Web&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$internet\" name=\"internet\" size=\"50\">&nbsp;</td>";
								echo "<td class = \"etiquette\">t&eacute;l Standard&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$tel_standard\" name=\"tel_standard\" size=\"19\">&nbsp;</td>";
								echo "<td class = \"etiquette\">fax&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$fax\" name=\"fax\" size=\"19\">&nbsp;</td>";
								echo "<td class = \"etiquette\">m&eacute;l&nbsp;:&nbsp;</td>";
								echo "<td><input type=\"text\" value = \"$email\" name=\"email\" size=\"30\"></td>";
							echo "</tr>";
						echo "</TABLE>";
						echo "<TABLE width=\"95%\">";
							echo "<tr>";
								echo "<TD class = \"etiquette\">Remarques&nbsp;:&nbsp;</TD>";
								echo "<TD ><textarea rows=\"4\" name=\"remarques\" cols=\"100\">$remarques</textarea></TD>";
							echo "</tr>";
						echo "</table>";
						echo "<TABLE width=\"95%\">";
							echo "<tr>";
								echo "<TD class = \"etiquette\">Statut&nbsp;:&nbsp;</TD>";
									echo "<td>&nbsp;<select size=\"1\" name=\"statut\">";
										echo "<option selected value=\"public\">Public (visible pour tous)</option>";
										echo "<option value=\"public\">Public (visible pour tous)</option>";
										echo "<option value=\"privé\">Privé (visible uniquement au propriétaire)</option>";
									echo "</select>";
								echo "</TD>";
							echo "</tr>";
						echo "</table>";

					echo "<TABLE width=\"95%\">
						<TR>
							<TD class = \"etiquette\">A faire&nbsp;:&nbsp;</TD>
							<TD align=\"left\"><textarea rows=\"4\" name=\"a_faire\" cols=\"100\">$a_faire</textarea></TD>
						</TR>";
/*						echo "<TR>
							<TD class = \"etiquette\" colspan = \"2\" align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Enregistrer la fiche\"></TD>
						</TR>";
*/					echo "</TABLE>
					<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
					<INPUT TYPE = \"hidden\" VALUE = \"enreg_fiche\" NAME = \"action\">";

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
							echo "</td>";
							//echo "<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\"></TD>";
							echo "<td>";
								echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
							echo "</TD>";
							echo "</tr>";
					echo "</table>";
				echo "</div>";


				echo "</FORM>";
				break;

				case ('enreg_fiche') : //enregistrement d'un lot modifié
					$societe = $_GET['societe'];
					$adresse = $_GET['adresse'];
					$cp = $_GET['cp'];
					$ville = $_GET['ville'];
					$tel_standard = $_GET['tel_standard'];
					$fax = $_GET['fax'];
					$email = $_GET['email'];
					$internet = $_GET['internet'];
					$remarques = $_GET['remarques'];
					$editeur = $_GET['editeur'];
					$fabricants = $_GET['fabricants'];
					$entreprise_de_service = $_GET['entreprise_de_service'];
					$presse_specialisee = $_GET['presse_specialisee'];
					$a_traiter = $_GET['a_traiter'];
					$a_faire_quand_date = $_GET['a_faire_quand_date'];
					$a_faire = $_GET['a_faire'];
					$urgent = $_GET['urgent'];
					$part_fgmm = $_GET['part_fgmm'];
					$emetteur = $_SESSION['nom'];
					$statut = $_GET['statut'];
					$pays = $_GET['pays'];
					if ($pays == "")
					{
						$pays = "France";
					}
					//Formatage des N°s de téléphone
					$tel_standard = format_no_tel($tel_standard);
					$fax = format_no_tel($fax);
					$societe = strtoupper($societe);
					/*  
					echo "<BR>societe : $societe - adresse : $adresse - cp : $cp - ville : $ville - tel_standard : $tel_standard - internet : $internet - fax : $fax
					<br>remarques : $remarques - editeur : $editeur - fabricant : $fabricants - service : $entreprise_de_service
					<br>presse : $presse_specialisee - à traiter : $a_traiter - à faire quand : $a_faire_quand_date - à faire : $a_faire
					<br>urgent : $urget - participation FGMM : $part_fgmm - emetteur : $emetteur - statut : $statut";

					*/ //Mise à jour de la fiche


					include("../biblio/init.php");
					$query = "INSERT INTO repertoire (societe, adresse, cp, ville, tel_standard, fax, email, internet, remarques, editeur, fabricants, entreprise_de_service, presse_specialisee, a_traiter, a_faire, a_faire_quand_date, urgent, part_fgmm, emetteur, statut, pays) 
						VALUES ('".$societe."', '".$adresse."', '".$cp."', '".$ville."', '".$tel_standard."', '".$fax."', '".$email."', '".$internet."', '".$remarques."', '".$editeur."', '".$fabricants."', '".$entreprise_de_service."', '".$presse_specialisee."', '".$a_traiter."', '".$a_faire."', '".$a_faire_quand_date."', '".$urgent."', '".$part_fgmm."', '".$emetteur."', '".$statut."','".$pays."');";
					$results = mysql_query($query);
					//Dans le cas où aucun résultats n'est retourné
					if(!$results)
					{
						echo "<B>Erreur de connexion à la base de données ou erreur de requète</B>";
						//echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
						mysql_close();
						//exit;
					}
					else
					{
						echo "<h2>La fiche a été enregistrée.</h2>";
						echo "<div align = \"center\">";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"repertoire_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					}
				break;
			}
?>
		</div>
	</BODY>
</HTML>
