<?php
				//Traitement de la variable $categorie
				//Dans le cas où la variable n'est pas renseign&eacute;, donc que l'on a juste cliqu&eacute; sur la consultation
				if(!isset($categorie) || $categorie == "")
				{}
				else
				{
					//Requ&egrave;te pour v&eacute;rifier que le probl&egrave;me figure d&eacute;j&agrave; ou non dans la cat&eacute;gorie en interrogeant la table categorie_personnelle_ticket
					$query_select_pb_categ_perso = "SELECT id_pb,id_categ,id_util FROM categorie_personnelle_ticket WHERE id_categ = '".$categorie."' AND id_pb = '".$idpb."' AND id_util = '".$_SESSION['id_util']."';";
					$results_select_pb_categ_perso = mysql_query($query_select_pb_categ_perso);
					$resultat = mysql_num_rows($results_select_pb_categ_perso);
					//echo "<br />resultat : $resultat";
					//On ins&egrave;re dans la table categorie_personnelle_ticket
					if ($resultat == 0)
					{
						$query_insert_categ_perso = "INSERT INTO categorie_personnelle_ticket (id_pb,id_categ,id_util) VALUES ('".$idpb."','".$categorie."','".$_SESSION['id_util']."');";
						//echo "<br />requête : $query_insert_categ_perso";
						$results_insert_categ_perso = mysql_query($query_insert_categ_perso);
					}
						
					//Requ&egrave;te pour v&eacute;rifier que le probl&egrave;me figure d&eacute;j&agrave; ou non dans la cat&eacute;gorie
					$query_select_pb_categ = "SELECT ID_PB_CATEG FROM categorie WHERE ID_CATEG = '".$categorie."';";
					$results_select_pb_categ = mysql_query($query_select_pb_categ);
					//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;s
					
					if(!$results_select_pb_categ OR !$results_select_pb_categ_perso)
					{
						echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e</b>";
						switch ($origine)
				    	{
              				case 'gestion_ticket':
                				echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				      		break;
         
              				case 'gestion_categories':
                				echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				      		break;
              
              				case 'fouille':
                				echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				      		break;
				      
				      		case 'repertoire_consult_fiche':
                				echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				      		break;
            			}
            			mysql_close();
						exit;
					}
					$res_select_pb_categ = mysql_fetch_row($results_select_pb_categ);
					
					//La fonction strtok &agrave; la diff&eacute;rence de explode permet de traiter les donn&eacute;es au fur &agrave;
					//Mesure que l'on parcours une chaine
					$idpb_array = strtok($res_select_pb_categ[0], ';');
					$no = "0";
					while ($idpb_array != '')
					{
						if ($idpb_array == $idpb)
						{
							echo "<b>Le probl&egrave;me figure d&eacute;j&agrave; dans cette cat&eacute;gorie</b>";
							$no = "1";
						}
						
						$idpb_array = strtok(';');
					};
					
					//Dans le cas où le probl&egrave;me ne fait pas parti de la cat&eacute;gorie
					//On concat la liste des probl&egrave;mes existants au nouveau prob&egrave;me &agrave; ajouter auquel on rajoute par derri&egrave;re
					//Un ;
					
					
					if($no == "0")
					{
						
						//On ajoute au champ ID_PB_CATEG &agrave; la suite des autres prob&egrave;mes
						$res_select_pb_categ[0] = $res_select_pb_categ[0]."".$idpb;
						
						$query_insert_categ = "UPDATE categorie SET ID_PB_CATEG = '".$res_select_pb_categ[0].";' WHERE ID_CATEG = '".$categorie."';";
						$results_insert_categ = mysql_query($query_insert_categ);
						//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
						if(!$results_insert_categ)
						{
							echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e</b>";
							switch ($origine)
				      		{
                				case 'gestion_ticket':
                 					echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				       			break;
         
                				case 'gestion_categories':
                  					echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				        		break;
              
                				case 'fouille':
				                  echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						        break;
				        
				        		case 'repertoire_consult_fiche':
					                echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
				    			break;
              				}
				            mysql_close();
							exit;
						}
						echo "<b>Ticket ins&eacute;r&eacute; dans la cat&eacute;gorie</b>";
					}
				}
				
				//Formulaire pour ins&eacute;rer un ticket dans une cat&eacute;gorie, nous appartenant
				echo "<form action = \"consult_ticket.php\" METHOD = \"GET\">";
					echo "<table BORDER = \"0\">";
						echo "<tr>";
							echo "<td>";
								echo "<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
								//echo "<FONT COLOR = \"#808080\"><b>Placer ce ticket dans une cat&eacute;gorie :</b></FONT>";
							echo "</td>";
							echo "<td>";
								echo "<select name = \"categorie\">";
								for($i = 0; $i < $num_categ; ++$i)
								{
									echo "<option value = \"".$res_categ[0]."\">".$res_categ[1]."</option>";
									$res_categ = mysql_fetch_row($results_categ);
								}
								echo "</select>";
							echo "</td>";
							echo "<td>";
								echo "<input type = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
								echo "<input type = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
			          echo "<input type = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
			          echo "<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">";
			          echo "<input type = \"submit\" VALUE = \"Ajouter &agrave; la cat&eacute;gorie personnelle\">";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</form>";
?>
