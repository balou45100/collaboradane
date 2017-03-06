<?php
	
	//echo "<br />id_courrier : $ligne[11]";
	
	$query_documents = "SELECT * FROM documents WHERE id_ticket = '".$ligne[11]."' AND module = 'COU' ORDER BY id_doc ASC;";
	
	//echo "<br />$query_documents";
	
	$result_documents = mysql_query($query_documents);
	$num_results_documents = mysql_num_rows($result_documents);
	if ($num_results_documents == 0)
	{
		
	}
	else
	{
		//Affichage des documents joints
		$res_documents = mysql_fetch_row($result_documents);

		for($i = 0; $i < $num_results_documents; ++$i)
		{
			//echo "id_doc : $res_documents[0] - id_formation : $res_documents[1] - nom_fichier : $res_documents[2] - module : $res_documents[3]<br />";
			$lien = $dossier_docs_courriers.$res_documents[3];
			
			$image = image_fichier_joint($res_documents[3]);
			
			//$image = "../image/".$image;
			$image = $chemin_theme_images."/".$image;
			//echo "<br />image : $image";
			//echo "<br />lien : $lien";
			
			echo "&nbsp;&nbsp;<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res_documents[2]\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$image\" ALT = \"$res_documents[2]\" title=\"$res_documents[2]\" border = \"0\"></a>";
			if ($res_documents[3])
			{
				if ($ligne[9] == $_SESSION['id_util'])
				{ 
					echo "<a href = \"delete_document.php?id_doc=".$res_documents[0]."&amp;retour=gc_recherche&amp;module=COU&amp;nom_fichier=".$res_documents[3]."\" TARGET = \"zone_travail\"><img src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" title=\"Supprimer ce fichier\" height=\"18px\" width=\"18px\" border = \"0\"></a>";
				}
			}
			$res_documents = mysql_fetch_row($result_documents);
		}
		echo "</td>";
	}
?>
