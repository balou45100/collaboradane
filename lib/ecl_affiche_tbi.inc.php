<?php
//echo "<h2>Page en pr&eacute;paration</h2>";
$autorisation_tbi = verif_appartenance_groupe(6);
$module = "FOR"; //n&eacute;cessaire pour le script qui ajoute des documents &agrave; une formation
$dossier = $dossier_documents;
//echo "<h2> Page en pr&eacute;paration</h2>";
//on extrait les formations concernant l'&eacute;tablissement
//AND annee_scolaire LIKE '".$annee_scolaire."'
//echo "<br />annee_en_cours : $annee_en_cours - annee_scolaire : $annee_scolaire";
$query = "SELECT * FROM documents WHERE nom_fichier LIKE '".$id_societe."%' AND module = 'TBI' ORDER BY id_doc DESC;";
$results = mysql_query($query);

if(!$results)
{
  echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</B>";
  echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
  mysql_close();
  exit;
}
echo "<br />";
if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_tbi == 1))
{
  echo "<a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_enquete_tbi&amp;module=TBI\" target = \"body\"><FONT COLOR = \"#000000\"><b>Ajouter une enqu&ecirc;te TBI<b></FONT></a><br />";
  echo "<br />";
}	
			
//Retourne le nombre de ligne rendu par la requ&egrave;te
$num_results = mysql_num_rows($results);
//echo "<br />num_results : $num_results";
if ($num_results >0)
{	
  //Affichage de l'entête du tableau
  echo "
			<table width = \"95%\">
			<caption><h3>Nombre d'enqu&ecirc;te enregistr&eacute;es&nbsp;:&nbsp;$num_results</h3>
        (Cliquer sur le nom du fichier pour visualiser l'enqu&ecirc;te)<br /></caption>
				<tr>";
					echo "<th>Date de l'enqu&ecirc;te</th>";
					echo "<th>Nom du fichier</th>";
					echo "<th>D&eacute;tails</th>";
          
          if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_tbi == 1))
          {
            echo "<th>
            ACTIONS
            </th>";
          }	
        echo "</tr>";
        //Traitement de chaque ligne
				$res = mysql_fetch_row($results);
				//if ($nombre_de_page)
				for ($i = 0; $i < $num_results; ++$i)
				{
				  if ($res[0] <>"")
					{
            echo "<tr>";
					  echo "<td align = \"center\">";
					  echo $res[2];
					  echo "</td>";
					  echo "<td align = \"center\">";
					  $lien = $dossier.$res[3];
            echo "<A target = \"_blank\" HREF = \"".$lien."\" title = \"$res[3]\"><FONT COLOR = \"#000000\"><b>".$res[3]."</b></FONT></a>";
					  echo "</td>";
            echo "<td align = \"center\">";
					  echo $res[5];
					  echo "</td>";
					  
					  //Les actions
						  
					  if (($_SESSION['droit'] == "Super Administrateur") OR ($autorisation_tbi == 1))
					  {
              echo "<td class = \"fond-actions\">&nbsp;";
              /*
              echo "
                    <a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=modif_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la formation\" border=\"0\"></a>
                    <a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;annee=".$res[1]."&amp;type=".$res[2]."&amp;rne=".$res[3]."&amp;module=$module&amp;id_societe=$id_societe&amp;action=ajout_document\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/docs_joints.png\" ALT = \"Ajouter un document\" title=\"Ajouter un document\" border=\"0\"></a>
                    <!--A HREF = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=copie_formation&amp;id_societe=".$id_societe."\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier la formation\" border=\"0\"></A-->
                    <a href = \"ecl_consult_fiche.php?CHGMT=O&amp;id_formation=".$res[0]."&amp;action=suppression_formation\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer la formation\" border=\"0\"></a>";
              */
              echo "</td>";
              
              
              //echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.gif\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\"></a>";
              //echo "<a href = \"formations_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\"></a>";
					    //echo "<a href = \"formations_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\"></a>";
					    //echo "<a href = \"formations_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\"></a>";
              echo "</td>";	
					  }
					  echo "</tr>";
          }
					$res = mysql_fetch_row($results);
				}
				echo "</table>";
				//Fermeture de la connexion &agrave; la BDD
				mysql_close();
}
else
{
   echo "<h2> Pas d'enqu&ecirc;tes pour l'instant&nbsp;!</h2>";
} 
       
?>
