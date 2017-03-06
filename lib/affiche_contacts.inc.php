<?php
	$ses_emetteur = $_SESSION['nom'];
	$query_contacts = "SELECT * FROM contacts WHERE id_societe = '".$id_societe."' AND emetteur = '".$ses_emetteur."' OR id_societe = '".$id_societe."' AND emetteur <> '".$ses_emetteur."' AND statut = 'public' ORDER BY NOM ASC;";
	
	//echo "<br />$query_contacts";
	echo "<tr>";
		echo "<th colspan = \"2\">Contact(s)&nbsp;:&nbsp;</th>";
	echo "</tr>";

	$result_contacts = mysql_query($query_contacts);
	$num_results_contacts = mysql_num_rows($result_contacts);
	if ($num_results_contacts == 0)
	{
		echo "<tr>
			<!--TD colspan = \"2\"><h2>Pas de contacts&nbsp;-&nbsp;</h2-->
			<td><!--B>Pas de contacts&nbsp;-&nbsp;</B-->
				<a href = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contact_ajout.png\" ALT = \"Ajout contact\" title=\"Ajouter un contact\" border = \"0\"></a>
			</td>
		</tr>";
	}
	else
	{
		echo "<tr>";
			echo "<td colspan=\"2\">";
			//echo "<td>";
				if ($module == "FOR")
				{
					if ($num_results_contacts == 1)
					{
						echo "$num_results_contacts contact &nbsp;:&nbsp;(<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts_ajout.png\" ALT = \"Ajout contact\" title=\"Ajouter un contact\" border = \"0\"></a>)";  
					}
					else
					{
						echo "$num_results_contacts contacts &nbsp;:&nbsp;(<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><b>Cliquez ici pour ajouter un contact</b></a>)";  
					}
				}
				else
				{
					if ($num_results_contacts == 1)
					{
						echo "$num_results_contacts contact &nbsp;:&nbsp;(<a href = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><b>Cliquez ici pour ajouter un contact</b></a>)";
					}
					else
					{
						echo "$num_results_contacts contacts &nbsp;:&nbsp;(<a href = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_contact\" target = \"body\"><b>Cliquez ici pour ajouter un contact</b></a>)";
					}
				}

				if ($affiche_contacts == "oui")
				{
					if ($module == "FOR")
					{
						echo "<a href = \"ecl_consult_fiche.php?CHGMT=N&amp;id_societe=".$id_societe."&amp;affiche_contacts=non\" target = \"body\"><b>&nbsp;-&nbsp;Cliquez ici pour cacher le(s) contact(s)</b></a>";
					}
					else
					{
						echo "<a href = \"repertoire_consult_fiche.php?CHGMT=N&amp;id_societe=".$id_societe."&amp;affiche_contacts=non\" target = \"body\"><b>&nbsp;-&nbsp;Cliquez ici pour cacher le(s) contact(s)</b></a>";
					}
						echo "<table width=\"95%\">
							<tr>
								<th width=\"5%\">Id</th>
								<th width=\"10%\">Nom</th>
								<th width=\"10%\">Pr&eacute;nom</th>
								<th width=\"10%\">fonction</th>
								<th width=\"10%\">t&eacute;l directe<b></th>
								<th width=\"10%\">fax</th>
								<th width=\"10%\">mobile</th>
								<th width=\"10%\">m&eacute;l</th>
								<th width=\"15%\">remarques</th>
								<th width=\"2%\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\"></th>
								<th width=\"8%\">Actions</th>
							</tr>";
							//Affichage des contacts
							$res_contacts = mysql_fetch_row($result_contacts);
							for($i = 0; $i < $num_results_contacts; ++$i)
							{
								echo "<tr>
									<td align = \"center\">".$res_contacts[0]."</td>
									<td>".$res_contacts[2]."</td>
									<td>".$res_contacts[3]."</td>
									<td>".$res_contacts[4]."</td>";
									echo "<td align = \"center\">";
										$tel = affiche_tel($res_contacts[8]);
										echo $tel;
									echo "</td>";
									echo "<td align = \"center\">";
										$tel = affiche_tel($res_contacts[9]);
										echo $tel;
									echo "</td>";
									echo "<td align = \"center\">";
										$tel = affiche_tel($res_contacts[10]);
										echo $tel;
									echo "</td>";
									echo "<td><a href = \"mailto:".str_replace(" ", "*",$res_contacts[11])."?cc=".$_SESSION['mail']."><FONT COLOR=\"#696969\">".$res_contacts[11]."</a></td>";
									//echo "<td width=\"10%\">".$res_contacts[11]."</td>
									echo "<td>".$res_contacts[13]."</td>";
									if ($res_contacts[15] == "privé")
									{
										echo "<td align = \"center\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\"></td>";
									}
									else
									{
										echo "<td>&nbsp;</td>";
									}
									echo "<td class = \"fond-actions\" nowrap>
										<a href = \"$page_retour?CHGMT=O&amp;id_contact=".$res_contacts[0]."&amp;id_societe=".$id_societe."&amp;action=affiche_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"Consulter\" title=\"Consulter la fiche du contact\" border=\"0\"></a>
										<a href = \"$page_retour?CHGMT=O&amp;id_contact=".$res_contacts[0]."&amp;id_societe=".$id_societe."&amp;action=modif_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le lot\" border=\"0\"></a>";
										if ($res_contacts[14] == $_SESSION['nom'])
										{
											echo "<a href = \"$page_retour?CHGMT=O&amp;id_contact=".$res_contacts[0]."&amp;action=suppression_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer le contact\" border=\"0\"></a>";
										}
									echo "</td>
								</tr>";
								$res_contacts = mysql_fetch_row($result_contacts);
							}
						echo "</table>";
				}
				else
				{
					if ($module == "FOR")
					{
						echo "<a href = \"ecl_consult_fiche.php?CHGMT=N&amp;id_societe=".$id_societe."&amp;affiche_contacts=oui\" target = \"body\"><b>&nbsp;-&nbsp;Cliquez ici pour afficher les contacts</b></a>";
					}
					else
					{
						echo "<a href = \"repertoire_consult_fiche.php?CHGMT=N&amp;id_societe=".$id_societe."&amp;affiche_contacts=oui\" target = \"body\"><b>&nbsp;-&nbsp;Cliquez ici pour afficher les contacts</b></a>";
					}
				}

				echo "</td>
			</tr>";
	}
?>
