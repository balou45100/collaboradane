<?php
						$id_util = $_SESSION['id_util'];
						//echo "<br />dans supprimer_alerte - id_ticket : $idpb - id_util : $id_util";
						//On demande confirmation
						echo "<h1>Confirmer la suppression de l'alerte du ticket $idpb</h1>";
						$query = "SELECT * FROM alertes WHERE id_util = '".$id_util."' AND id_ticket = '".$idpb."';";
						$result = mysql_query($query);
						if(!$result)
						{
							echo "<br />Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
						}
						$res = mysql_fetch_row($result);
						$description_alerte = $res[4];
						echo "<form action = \"consult_ticket.php\" METHOD = \"GET\">";
						echo "<table width=\"95%\" BORDER = \"1\">";
							echo "<tr>";
								echo "<td class = \"etiquette\" width=\"10%\">Alerte&nbsp;:&nbsp;</td>";
								echo "<td width=\"60%\">$res[4]</td>";
								echo "<td class = \"etiquette\" width=\"10%\">date fix&eacute;e&nbsp;:&nbsp;</td>";
								$date = strtotime($res[3]);
								$date_a_afficher = date('d/m/Y',$date);
								echo "<td width = \"20%\">$date_a_afficher</td>";
							echo "</tr>";
						echo "</table>";
						echo "<a href = \"consult_ticket.php?idpb=".$idpb."&amp;action=confirmation_supprimer_alerte\" target = \"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/supprimer.png\" border = \"0\" ALT = \"supprimer\" title=\"Supprimer cette alerte\"></a>";
						echo "&nbsp;&nbsp;<input src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans supprimer cette alerte\" border = \"0\" TYPE = image VALUE = \"non\" NAME = \"bouton\">";
						echo "<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
						//echo "<input type = \"hidden\" VALUE = \"confirmation_supprimer_alerte\" NAME = \"action\">";
						echo "<input type = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[7]."\" NAME = \"date_creation\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[5]."\" NAME = \"sujet\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[3]."\" NAME = \"emetteur\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[2]."\" NAME = \"mail_emetteur\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[10]."\" NAME = \"intervenant\">";
						echo "<input type = \"hidden\" VALUE = \"".$res[15]."\" NAME = \"TRAITE_PAR\">";
						echo "<input type = \"hidden\" VALUE = \"N\" NAME = \"CHGMT\">";
						echo "<input type = \"hidden\" VALUE = \"$priorite_dans_base\" NAME = \"priorite_dans_base\">";
						echo "<input type = \"hidden\" VALUE = \"$statut_traitement_dans_base\" NAME = \"statut_traitement_dans_base\">";
						echo "<input type = \"hidden\" VALUE = \"$statut_dans_base\" NAME = \"statut_dans_base\">";
						echo "<input type = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
						echo "<input type = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
						echo "<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">";
						echo "</form>";
						$affichage = "N"; // pour &eacute;viter que le ticket s'affiche

?>
