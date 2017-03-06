<?php
		//echo "<br />ticket : $ticket - contact : $contact<br />type contact : $typecontact<br />contenu : $contenuticket<br />";
		//$ses_emetteur = $_SESSION['nom'];
		//echo "<br />cr&eacute;&eacute; par : $creepar";
		include("../biblio/init.php");
		$query_documents = "SELECT * FROM documents WHERE id_ticket = '".$ticket."' AND MODULE = 'GT' ORDER BY id_doc ASC;";
		$result_documents = mysql_query($query_documents);
		$num_results_documents = mysql_num_rows($result_documents);
		//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
		echo "<tr>";
			if ($num_results_documents == 0)
			{
				if (($_SESSION['droit'] == "Super Administrateur") OR ($_SESSION['nom'] == $creepar))
				{
					echo "<td class = \"etiquette\"><b>Docs joints&nbsp;:&nbsp;</b></td>";
					if ($type_enregistrement == "reponse")
					{
						echo "<td class = \"reponse\" colspan = \"10\">";
					}
					else
					{
						echo "<td colspan = \"10\">";
					}
					echo "&nbsp;<a href = \"consult_ticket.php?idpb=".$idpb."&amp;ticket=$ticket&amp;creepar=$creepar&amp;creele=$creele&amp;intervenants=$intervenants&amp;sujet=$sujet&amp;etab=$etab&amp;contact=$contact&amp;typecontact=$typecontact&amp;module=$module&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"Ajout pi&egrave;ce\" title=\"Ajouter une pi&egrave;ce\" border = \"0\"></a></td>";
					echo "</td>";
				}

			}
			else
			{
				//Affichage des documents joints
				$res_documents = mysql_fetch_row($result_documents);
				echo "<td class= \"etiquette\"><b>Docs joints&nbsp;:&nbsp;</b></td>";
				if ($type_enregistrement == "reponse")
				{
					echo "<td class = \"reponse\" colspan = \"10\">";
				}
				else
				{
					echo "<td colspan = \"8\">";
				}
					for($i = 0; $i < $num_results_documents; ++$i)
					{
						//echo "id_doc : $res_documents[0] - nom_doc : $res_documents[1] - nom_fichier : $res_documents[2] - module : $res_documents[3]<br />";
						$lien = $dossier.$res_documents[3];
						$image = image_fichier_joint($res_documents[3]); //on r&eacute;cup&egrave;re le type de l'image &agrave; afficher
						//$image = "../image/".$image;
						$image = $chemin_theme_images."/".$image;
						//echo " - <A target = \"_blank\" HREF = \"".$lien."\" title = \"$res_documents[2]\"><FONT COLOR = \"#000000\"><b>".$res_documents[3]."</b></FONT></a>";
						echo "&nbsp;&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res_documents[2]\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\"src = \"$image\" ALT = \"$res_documents[2]\" title=\"$res_documents[2]\" border = \"0\"></a>";
			
						if ($res_documents[3])
						{
							if (($_SESSION['droit'] == "Super Administrateur") OR ($_SESSION['nom'] == $creepar))
							{
								echo "<a href = \"delete_document.php?tri=$tri&amp;id_doc=".$res_documents[0]."&amp;idpb=".$ticket."&amp;nom_fichier=".$res_documents[3]."&amp;retour=consult_ticket\" TARGET = \"body\"><img src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" title=\"Supprimer ce fichier\" border = \"0\"></a>";
							}
						}

						$res_documents = mysql_fetch_row($result_documents);
					}
				if (($_SESSION['droit'] == "Super Administrateur") OR ($_SESSION['nom'] == $creepar))
				{
					echo "&nbsp;&nbsp;&nbsp;<a href = \"consult_ticket.php?idpb=".$idpb."&amp;ticket=$ticket&amp;creepar=$creepar&amp;creele=$creele&amp;intervenants=$intervenants&amp;sujet=$sujet&amp;etab=$etab&amp;contact=$contact&amp;typecontact=$typecontact&amp;module=$module&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"Ajout pi&egrave;ce\" title=\"Ajouter une pi&egrave;ce\" border = \"0\"></a>";
				}
				echo "</td>";
			echo "</tr>";
		//echo "</table>";
			}
?>
