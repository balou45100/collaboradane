<?php
	//Traitement de la variable $categorie_commune
	//Dans le cas où la variable n'est pas renseign&eacute;, donc que l'on a juste cliqu&eacute; sur la consultation
	if(!isset($categorie_commune) || $categorie_commune == "")
	{}
	else
	{
		//echo "<br />idpb : $idpb";
		//echo "<br />categorie_commune : $categorie_commune";
	    //Requ&egrave;te pour v&eacute;rifier que le probl&egrave;me figure d&eacute;j&agrave; ou non dans la cat&eacute;gorie
		$query_select_pb_categ_commune = "SELECT * FROM categorie_commune_ticket WHERE id_ticket = '".$idpb."' AND id_categ = '".$categorie_commune."';";
		$results_select_pb_categ_commune = mysql_query($query_select_pb_categ_commune);
		//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;s
		if(!$results_select_pb_categ_commune)
		{
			echo "<br /><b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e</b>";
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
		$res_select_pb_categ_commune = mysql_fetch_row($results_select_pb_categ_commune);
		$no = mysql_num_rows($results_select_pb_categ_commune);
		//echo "<br />no : $no";
		if ($no > 0)
		{
			echo "<b>Le probl&egrave;me figure d&eacute;j&agrave; dans cette cat&eacute;gorie</b>";
		}
		//Dans le cas où le probl&egrave;me ne fait pas parti de la cat&eacute;gorie
		if($no == "0")
		{
			$res_select_pb_categ[0] = $res_select_pb_categ[0]."".$idpb;
			$query_insert_categ_commune = "INSERT INTO categorie_commune_ticket (id_ticket, id_categ) Values ('".$idpb."','".$categorie_commune."');";
			$results_insert_categ_commune = mysql_query($query_insert_categ_commune);
			//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
			if(!$results_insert_categ_commune)
			{
				echo "<br /><b>PPProbl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e</b>";
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
			echo "<br /><b>Ticket ins&eacute;r&eacute; dans la cat&eacute;gorie commune</b>";
		}
	}
	//Requ&egrave;te pour selectionner toutes les cat&eacute;gories communes afin de pouvoir affecter un ticket &agrave; une cat&eacute;gorie commune
	$query_categ_commune = "SELECT * FROM categorie_commune ORDER BY intitule_categ;";
	$results_categ_commune = mysql_query($query_categ_commune);
	//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
	if(!$results_categ_commune)
	{
		echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b>";
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
	$res_categ_commune = mysql_fetch_row($results_categ_commune);
	$num_categ_commune = mysql_num_rows($results_categ_commune);
	//Formulaire pour ins&eacute;rer un ticket dans une cat&eacute;gorie commune
	echo "<form action = \"consult_ticket.php\" METHOD = \"GET\">";
		echo "<table BORDER = \"0\">";
			echo "<tr>";
				echo "<td>";
					echo "<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
					//echo "<FONT COLOR = \"#808080\"><b>Placer ce ticket dans une cat&eacute;gorie :</b></FONT>";
				echo "</td>";
				echo "<td>";
					echo "<select name = \"categorie_commune\">";
					for($i = 0; $i < $num_categ_commune; ++$i)
					{
						echo "<option value = \"".$res_categ_commune[0]."\">".$res_categ_commune[1]."</option>";
						$res_categ_commune = mysql_fetch_row($results_categ_commune);
					}
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<input type = \"hidden\" VALUE = \"".$tri."\" NAME = \"tri\">";
					echo "<input type = \"hidden\" VALUE = \"".$a_chercher."\" NAME = \"a_chercher\">";
					echo "<input type = \"hidden\" VALUE = \"".$ou."\" NAME = \"ou\">";
					echo "<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">";
					echo "<input type = \"submit\" VALUE = \"Ajouter &agrave; la cat&eacute;gorie commune\">";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
?>
