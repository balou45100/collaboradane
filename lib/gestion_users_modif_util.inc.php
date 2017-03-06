<?php
	//Récupération des données de l'util à modifier
	//La modification d'un utilisateur se fait avec son nom et son mail
	$query = "SELECT * FROM util where id_util = '".$id_util_a_modifier."'";
	$results = mysql_query($query);
	//Dans le cas où aucun résultats n'est retourné
	if(!$results)
	{
		echo "<h2>Problème de connexion à la base de données</h2>";
		echo "<A HREF=\"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
		mysql_close();
		exit;
	}
	else
	{
		//Récupération des données concernant l'utilisateur
		$res = mysql_fetch_row($results);
		$password_origine = $res[2];
		$identifiant_origine = $res[18];

		//echo "<br>password_origine : $password_origine";
		echo" <div align = \"center\">";
			echo "<h2>Modification d'un-e utilisateur/trice</h2>";
			echo "<form action = \"gestion_user.php\" METHOD = \"POST\">";
				echo "<table>";
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations obligatoires</td>";
					echo "</tr>";
					echo "<tr>
						<td class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"hidden\" VALUE =\"$res[0]\" NAME = \"prenom\">$res[0]</td>
					</tr>

					<tr>
						<td class = \"etiquette\">Nom&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"hidden\" VALUE = \"$res[1]\" NAME = \"nom\" SIZE=\"40\">$res[1]</td>
					</tr>

					<tr>
						<td class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"hidden\" VALUE = \"$res[3]\" NAME = \"mail\" SIZE=\"40\">$res[3]</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Identifiant&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"hidden\" VALUE =\"$res[18]\" NAME = \"identifiant\" SIZE=\"34\">$res[18]</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Mot de passe&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"password\" VALUE = \"$res[2]\" NAME = \"password1\" SIZE=\"34\">&nbsp;</td>
					</tr>
					<tr>
						<td class = \"etiquette\">V&eacute;rification du mot de passe&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"password\" VALUE = \"$res[2]\" NAME = \"password2\" SIZE=\"34\">&nbsp;</td>
					</tr>";

					echo "<tr>
						<td class = \"etiquette\">Utilisateur/trice activ&eacute;-e&nbsp;?</td>
						<td>&nbsp;
							<select size=\"1\" name=\"visible\">";
							if($res[15] == "O")
							{
								echo "<option selected value=\"O\">Oui</option>";
								echo "<option value=\"N\">Non</option>";
							}
							else
							{
								echo "<option selected value=\"N\">Non</option>";
								echo "<option value=\"O\">Oui</option>";
							}
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td class = \"champ_obligatoire\" colspan = \"2\">Informations facultatives</td>";
					echo "</tr>";


					echo "<tr>
						<td class = \"etiquette\">T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE = \"$res[4]\" NAME = \"num_tel\" SIZE=\"34\">&nbsp;</td>
					</tr>

					<tr>
						<td class = \"etiquette\">Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$res[9]\" NAME = \"poste_tel\" SIZE=\"34\">&nbsp;</td>
					</tr>

					<tr>
						<td class = \"etiquette\">Mobile professionnel&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$res[5]\" NAME = \"num_tel_port\" SIZE=\"34\">&nbsp;</td>
					</tr>

					<tr>
						<td class = \"etiquette\">T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$res[10]\" NAME = \"num_tel_perso\" SIZE=\"34\">&nbsp;</td>
					</tr>

					<tr>
						<td class = \"etiquette\">Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$res[14]\" NAME = \"tel_autre\" SIZE=\"34\">&nbsp;</td>
					</tr>

					<tr>
						<td class = \"etiquette\">Mobile personnel&nbsp;:&nbsp;</td>
						<td>&nbsp;<input type=\"text\" VALUE =\"$res[11]\" NAME = \"num_tel_port_perso\" SIZE=\"34\">&nbsp;</td>
					</tr>";

				echo "</table>";

				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_user.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
/*
						echo "<td>";
							echo "<a href = \"gestion_user.php?action=O&amp;a_faire=modification_confirmee&amp;id_util=$res[3]\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/oui.png\" ALT = \"Enregistrer\" title=\"Enregistrer les modifications\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
						echo "</td>";
*/
						echo "<td>";
							echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
						echo "</TD>";
					echo "</tr>";
				echo "</table>";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"modification_confirmee\" NAME = \"a_faire\">";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_util_a_modifier\" NAME = \"id_util_a_modifier\">";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"$password_origine\" NAME = \"password_origine\">";
				echo "<INPUT TYPE = \"hidden\" VALUE = \"$identifiant_origine\" NAME = \"identifiant_origine\">";

			echo "</FORM>";
		echo "</div>";
/*
		//Ancien formulaire
		echo "<FORM ACTION = \"verif_util.php\" METHOD = \"POST\">
			          <TABLE>
			           
                 <TR>
                   
			 	           <TD class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</TD>
			 	           <TD><INPUT TYPE=\"hidden\" VALUE =".str_replace("*", " ",$res[0])." NAME = \"prenom\">".str_replace("*", " ",$res[0])."</TD>
									 
								 </TR>
								 <TR>
								   
									 <TD class = \"etiquette\">Nom&nbsp;:&nbsp;</TD>
									 <TD bgcolor = $fd_cel_donnee><INPUT TYPE=\"hidden\" VALUE =".strtoupper($res[1])." NAME = \"nom\" SIZE=\"40\">".strtoupper($res[1])."</TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
                   <TD bgcolor = $fd_cel_donnee><INPUT TYPE=\"hidden\" VALUE =".$res[3]." NAME = \"mail\" SIZE=\"40\">".$res[3]."</TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =".$res[4]." NAME = \"num_tel\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[9]."\" NAME = \"poste_tel\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mobile professionnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[5]."\" NAME = \"num_tel_port\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[10]."\" NAME = \"num_tel_perso\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[14]."\" NAME = \"tel_autre\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mobile personnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[11]."\" NAME = \"num_tel_port_perso\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mot de passe&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"password\" VALUE =".$res[2]." NAME = \"password1\" SIZE=\"34\"></TD>
								   
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Pour v&eacute;rification du Mot de passe&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"password\" VALUE =".$res[2]." NAME = \"password2\" SIZE=\"34\"></TD>
								   
                </TABLE>
                <BR>
                <INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">
                <INPUT TYPE=\"hidden\" VALUE =\"$password_origine\" NAME = \"password_origine\">
                <INPUT TYPE=\"hidden\" VALUE =\"$origine\" NAME = \"origine\">
				        <INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\">
			        </FORM>";
*/
	}
						//Fermeture de la connexion à la BDD
						mysql_close();
?>
