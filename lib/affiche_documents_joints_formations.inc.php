<?php
	$query_documents = "SELECT * FROM documents WHERE id_ticket = '".$res[0]."' AND module = 'FOR' ORDER BY id_doc ASC;";
	$result_documents = mysql_query($query_documents);
	$num_results_documents = mysql_num_rows($result_documents);
	if ($num_results_documents == 0)
	{}
	else
	{
		//Affichage des documlents joints
		$res_documents = mysql_fetch_row($result_documents);
		for($i = 0; $i < $num_results_documents; ++$i)
		{
			//echo "id_doc : $res_documents[0] - id_formation : $res_documents[1] - nom_fichier : $res_documents[2] - module : $res_documents[3]<br>";
			$lien = $dossier.$res_documents[3];
			$image = image_fichier_joint($res_documents[3]); //on r&eacute;cup&egrave;re le type de l'image &agrave; afficher
			$image = $chemin_theme_images."/".$image;
			
			//echo "<br />image : $image";
			
			//echo "&nbsp;-&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res_documents[2]\"><FONT COLOR = \"#000000\"><b>".$res_documents[3]."</b></FONT></A>";
			echo "&nbsp;&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res_documents[2]\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$image\" ALT = \"$res_documents[2]\" title=\"$res_documents[2]\" border = \"0\"></a>";
			if ($res_documents[3])
			{
				if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_formation == 1))
				{ 
					echo "&nbsp;<A HREF = \"delete_document.php?tri=$tri&amp;id_doc=".$res_documents[0]."&amp;idrep=".$ticket."&amp;nom_fichier=".$res_documents[3]."\" TARGET = \"body\"><img src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" title=\"Supprimer ce fichier\" height=\"18px\" width=\"18px\" border = \"0\"></A>";
				}
			}
			$res_documents = mysql_fetch_row($result_documents);
		}
		echo "</TD>";
	}
?>
