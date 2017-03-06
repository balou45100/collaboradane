<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
		<script language="JavaScript" type="text/javascript">
		<!--
			function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
			{
				var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
			}
		//-->
		</script>

<?php
	echo "</head>";
	//Inclusion des fichiers nécessaires
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	include ("../biblio/fct.php");
	
	echo "<body>";
	
	//echo "<br />hauteur_icone_tri : $hauteur_icone_tri";
	//On récupère les variables pour les actions
	$action = $_GET['action'];
	$a_faire = $_GET['a_faire'];
	$idreunion = $_GET['idreunion'];
	
	if (!ISSET($action))
	{
		$action = $_POST['action'];
	}
	
	if (!ISSET($a_faire))
	{
		$a_faire = $_POST['a_faire'];
	}

	if (!ISSET($idreunion))
	{
		$idreunion = $_POST['idreunion'];
	}

	/*
	echo "<br />action : $action";
	echo "<br />a_faire : $a_faire";
	echo "<br />idreunion : $idreunion";
	*/

////////////////////////////////////////////////////////////////////////////////////////////
//////////// Début du traitement des actions à faire ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
	echo "<div align = \"center\">";
		if ($action == "O")
		{
			//echo "<br />Je dois faire quelque chose ...";
			switch ($a_faire)
			{
				case "saisie_reunion" :
					include("om_saisie_reunion.inc.php");
					//include("om_formulaire2.inc.php");
					$affichage = "N";
				break;

				case "enregistrer_reunion" :
					include("om_enregistrer_reunion.inc.php");
				break;
				
				case "modifier_reunion" :
					//echo "<h2>Je modifie la réunion</h2>";
					include("om_modifier_reunion.inc.php");
					$affichage = "N";
				break;

				case "maj_reunion" :
					include("om_maj_reunion.inc.php");
				break;

				case "gestion_participants" :
					$idreunion = $_POST['idreunion'];
					$id_pers_ress = $_POST['id_pers_ress'];
					$action_supplementaire = $_POST['action_supplementaire'];
					//include("om_gestion_reunion.inc.php");
					
					if (!ISSET($idreunion))
					{
						$idreunion = $_GET['idreunion'];
					}

					if (!ISSET($id_pers_ress))
					{
						$id_pers_ress = $_GET['id_pers_ress'];
					}

					if (!ISSET($action_supplementaire))
					{
						$action_supplementaire = $_GET['action_supplementaire'];
					}

					/*
					echo "<br />idreunion : $idreunion";
					echo "<br />id_pers_ress : $id_pers_ress";
					echo "<br />action_supplementaire : $action_supplementaire";
					*/
					switch ($action_supplementaire)
					{
						case "enregistrer_participant" :
							//echo "<h3>J'enregistre le participant...</h3>";
							include("om_enreg_participant_reunion.inc.php");
						break;

						case "supprimer_participant" :
							//echo "<h2>Je supprime le participant...</h2>";
							include("om_supprimer_participant_reunion.inc.php");
						break;
					}
					//echo "<h3>J'ajoute des participants</h3>";
					include("om_gestion_reunion.inc.php");
					//include("om_ajout_participant_reunion.inc.php");
					$affichage = "N";
				break;
				
				case "afficher_reunion" :
					include("om_gestion_reunion.inc.php");
					$affichage = "N";
				break;

				case "retirer_salle" :
					//echo "<h2>Je retire la salle de la r&eacute;union $idreunion</h2>";
					$requete_maj_reunion = "UPDATE om_reunion SET 
						`idsalle` = '0'
					WHERE idreunion = '".$idreunion."';";
					//echo "<br />$requete_maj_reunion";
					$result_maj_reunion = mysql_query($requete_maj_reunion);
					if($result_maj_reunion)
					{
						echo "<h2>La salle a bien &eacute;t&eacute; retir&eacute;e</h2>";
					}
				break;

				case "ajouter_salle" :
					//$idreunion = $_POST['idreunion'];
					$choix_structure = $_POST['choix_structure'];
					$no_societe = $_POST['no_societe'];
					$rne = $_POST['rne'];
					$action_supplementaire = $_POST['action_supplementaire'];
					
					//echo "<br />action_supplementaire : $action_supplementaire";
					
					switch ($action_supplementaire)
					{
						case "enreg_salle" :
							$idsalle = $_POST['idsalle'];
							echo "<h2>J'enregistre la salle $idsalle pour la r&eacute;union $idreunion</h2>";
								$requete_maj_reunion = "UPDATE om_reunion SET 
									`idsalle` = '".$idsalle."'
								WHERE idreunion = '".$idreunion."';";
							$result_maj_reunion = mysql_query($requete_maj_reunion);
							if($result_maj_reunion)
							{
								echo "<h2>La salle a bien &eacute;t&eacute; ajout&eacute;e</h2>";
							}
						break;
						
						case "nouvelle_salle" :
							//echo "<h2>J'enregistre la nouvelle salle</h2>";
							$intitule_salle = $_POST['intitule_salle'];
							$capacite = $_POST['capacite'];
							//on vérifie que l'intitule et la capacité sont renseigné
							if ($intitule_salle == "")
							{
								echo "<h2>Il faut pr&eacute;cisez l'intitul&eacute; de la salle</h2>";
								$enregistrer = "N";
							}
							if ($capacite == "")
							{
								echo "<h2>Il faut pr&eacute;cisez la capacit&eacute; d'accueil de la salle</h2>";
								$enregistrer = "N";
							}
							/*
							echo "<br />intitule_salle : $intitule_salle";
							echo "<br />capacite : $capacite";
							echo "<br />idreunion : $idreunion";
							*/
							//echo "<br />enregistrer : $enregistrer";
							
							if ($enregistrer <> "N")
							{
								//On vérifie le type de structuire
								if ($rne == -1)
								{
									$table = "societes";
									$id_structure = $no_societe;
								}
								else
								{
									$table = "etablissements";
									$id_structure = $rne;
								}
								//On enregistre la nopuvelle salle
								/*
								echo "<br />table : $table";
								echo "<br />id_structure : $id_structure";
								echo "<br />intitule_salle : $intitule_salle";
								echo "<br />capacite : $capacite";
								*/

								$requete_insert_salle = "INSERT INTO `om_salle` 
									(`table`, `idStructure`, `intitule_salle`, `capacite`) 
									VALUES ('$table', '$id_structure', '$intitule_salle', '$capacite');";
								$result_insert_salle = mysql_query($requete_insert_salle);
								
								//echo "<br />$requete_insert_salle";

								if($result_insert_salle)
								{
									//echo "<h2>La nouvelle salle a &eacute;t&eacute; enregistr&eacute;e</h2>";
								}
							}

							include("om_salle_ajout.inc.php");
							$affichage = "N";
						break;
					}
					if (!ISSET($action_supplementaire))
					{
						include("om_salle_ajout.inc.php");
						$affichage = "N";
					}
				break;
			}
			
		}
////////////////////////////////////////////////////////////////////////////////////////////
//////////// Fin du traitement des actions à faire /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Début du script principal avec l'exécution des requetes et l'affichage du tableau avec la sélection ////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


		if ($affichage <> "N")
		{
			//On vérifie les différents filtres à appliquer
			//echo "<br />Je traite les filtres";
			$page_appelant = "reunion";
			echo "<h1>Gestion des r&eacute;unions</h1>";
			include ("om_menu_principal.inc.php");

			//On définit le complément de la requete si les filtres sont utilisés
			$filtres_requete = "";
			
			if(isset($_POST['validRecherche']))
			{
				$etat=$_POST['etat'];
				$intitule_reunion=$_POST['intitule_reunion'];
				$annee = $_POST['annee'];
				$date_reunion=$_POST['date_reunion'];
				
				/*
				echo "<br />annee : $annee";
				echo "<br />etat : $etat";
				echo "<br />intitule : $intitule";
				echo "<br />date_reunion : $date_reunion";
				*/
				if($etat<>"T")
				{
					$filtres_requete=" AND etat = '".$etat."'";
				}
				
				if ($intitule_reunion <> "")
				{
					$filtres_requete = $filtres_requete." AND intitule_reunion LIKE '%$intitule_reunion%'";
				}
				
				if ($annee <> "T")
				{
					$filtres_requete = $filtres_requete." AND annee Like '".$annee."'";
				}
				
				if($date_reunion <>"")
				{
					//$date_angl=date("Y-m-d", strtotime($date_reunion));
					//$filtres_requete = $filtres_requete." AND date_horaire_debut LIKE '%$date_angl%' ";
					$filtres_requete = $filtres_requete." AND date_horaire_debut LIKE '%$date_reunion%' ";
				}

				//echo "<br />filtres_requete : $filtres_requete";
				
			} // Fin test filtres
			//=========================================    
			// requête SQL qui compte le nombre total d'enregistrements dans la table.
			//=========================================
			
			$select = "SELECT count(idreunion) from om_reunion, om_salle where om_reunion.idsalle=om_salle.idsalle ;";
			$result = mysql_query($select);
			//$row = mysql_fetch_row($result);
			$total = $row[0];

			//=========================================
			// requête SQL complète pour l'affichage.
			//=========================================

			//$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_reunion, om_salle WHERE om_reunion.idsalle=om_salle.idsalle ".$filtres_requete." ORDER BY idreunion DESC;";
			//$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_reunion, om_salle WHERE om_reunion.idsalle=om_salle.idsalle ".$filtres_requete." ORDER BY date_horaire_debut DESC;";
			$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_reunion WHERE 1".$filtres_requete." ORDER BY date_horaire_debut DESC;";
			
			//echo "<br />$select<br />";
			
			$result = mysql_query($select);
			$total = mysql_num_rows($result);
			
			if($total)
			{
				echo "<h2>Nombre d'enregistrements : $total</h2>";
				
				echo "<table id=trier>";
					echo "<tbody>";
					echo "<tr>"; 
						//echo "<th align = \"center\"><nobr><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<b>id</b>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></nobr></th>";
						echo "<th align = \"center\"><b>ID</th>";
						//echo "<th align = \"center\"><b>Libell&eacute;<br /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>"; 	
						echo "<th align = \"center\"><b>Intitul&eacute; (description)</th>";
						//echo "<th align = \"center\"><b>Date d&eacute;but<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>"; 
						echo "<th align = \"center\"><b>Date d&eacute;but / fin</th>";
						//echo "<th align = \"center\"><b>Heure d&eacute;but</b></th>"; 
						//echo "<th align = \"center\"><b>Date fin<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>"; 
						echo "<th align = \"center\"><b>Horaires</th>";
						//echo "<th align = \"center\"><b>Heure fin</b></th>"; 
						//echo "<th align = \"center\"><b>&Eacute;tat</b></th>"; 
						//echo "<th align = \"center\"><b>Lieu<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>";  
						echo "<th align = \"center\"><b>Lieu</th>";
						echo "<!--th align = \"center\"><b>Adresse</b></th>";  
						//echo "<th align = \"center\"><b>Code&nbsp;Postal<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th-->"; 
						echo "<th align = \"center\"><b>Code&nbsp;Postal</th>";
						//echo "<th align = \"center\"><b>Ville<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>";  
						echo "<th align = \"center\"><b>Ville</th>";
						echo "<!--th align = \"center\"><b>Pays<BR /><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>";  
						echo "<th align = \"center\"><b>T&eacute;l&eacute;phone</b></th>";  
						echo "<th align = \"center\"><b>M&eacute;l</th-->";
						//echo "<th align = \"center\"><b>&nbsp;Salle&nbsp;<BR /><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\"></span>&nbsp;<span onclick=TableOrder(event,1)>&nbsp;<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\"></span></b></th>"; 
						echo "<th align = \"center\"><b>Salle</th>";
						echo "<th align = \"center\"><b>Nbr part.</b></th>"; 
						echo "<th align = \"center\"><b>Actions</b></th>"; 
						echo "<th align = \"center\"><b>&Eacute;ditions</b></th>"; 
					echo "</tr>";

					while($ligne1 = mysql_fetch_array($result))
					{
						//on calcule le nombre de participant par réunion
						$requete_nbr_participants = "SELECT * FROM om_ordres_mission WHERE idreunion = '".$ligne1['idreunion']."'";
						$nombre_participants = mysql_num_rows(mysql_query($requete_nbr_participants));
						echo "<TR>";
							echo "<TD align=\"center\">".$ligne1['idreunion']."</TD>";
							if ($ligne1['description'] <>"")
							{
								echo "<TD>".$ligne1['intitule_reunion']."<br />(".$ligne1['description'].")</TD>";
							}
							else
							{
								echo "<TD>".$ligne1['intitule_reunion']."</TD>";
							}

							if ($ligne1['Date_D'] == $ligne1['Date_F'])
							{
								echo "<TD align=\"center\">".$ligne1['Date_D']."</TD>";
							}
							else
							{
								echo "<TD align=\"center\">".$ligne1['Date_D']." - ".$ligne1['Date_F']."</TD>";
							}
							echo "<TD align=\"center\">".$ligne1['Heure_D']." - ".$ligne1['Heure_F']."</TD>";
	/*
							if($ligne1['etat_reunion']==0)
							{
								echo"<TD align=center>NT</TD>";
							}
							else
							{
								if($ligne1['etat_reunion']==1)
								{
									echo"<TD align=center>T</TD>";
								}
							}
	*/
							if($ligne1['idsalle']<>0)
							{
								//echo "<br />idsalle = 0";
								//Je recupère les informations concernant la salle
								//$idsalle = $ligne1['idsalle'];
								$requete_salle = "SELECT * FROM om_salle WHERE idsalle = '".$ligne1['idsalle']."'";
								//echo "<br />$requete_salle";
								
								//$code=$ligne1['idNo_societe'];
								//$requete_inter="SELECT * from repertoire where No_societe='$code';";
								$resultat_requete_salle=mysql_query($requete_salle);
								$ligne2=mysql_fetch_assoc($resultat_requete_salle);
								
								
								//On récupère les informations de la structure hébergeant la salle
								If ($ligne2['table'] == "etablissements")
								{
									$requete_structure = "SELECT * FROM etablissements WHERE RNE = '".$ligne2['idStructure']."'";
									//echo "<br />$requete_structure";
									$resultat_requete_structure = mysql_query($requete_structure);
									$ligne3 = mysql_fetch_assoc($resultat_requete_structure);
									
									echo "<TD align=center>".$ligne3['TYPE']."&nbsp;".$ligne3['NOM']."<br />".$ligne3['VILLE']."</TD>"; 
									echo "<TD align=center>".$ligne2['intitule_salle']."</TD>";
								}
								else
								{
									$requete_structure = "SELECT * from repertoire where No_societe = '".$ligne2['idStructure']."'";
									//echo "<br />$requete_structure";
									$resultat_requete_structure = mysql_query($requete_structure);
									$ligne3=mysql_fetch_assoc($resultat_requete_structure);
									echo "<TD align=center>".$ligne3['societe']."<br />".$ligne3['ville']."</TD>"; 
									echo "<TD align=center>".$ligne2['intitule_salle']."</TD>";
									
								}
							}
							else
							{
								echo "<td>&nbsp;</td>";
								echo "<td>&nbsp;</td>";
							}
							
							echo "<TD align=center>".$nombre_participants."</TD>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////// Colonne des actions /////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							
							// On vérifie si la personne a les droits nécessaires :
							
							$niveau_droits = verif_droits("ordres_mission");
							
							//echo "<br />niveau_droits : $niveau_droits";
							echo"<TD class = \"fond-actions\" nowrap>";
							
							if ($niveau_droits > 3) //Il faut avoir les droits de création pour avoir accès aux boutons d'action
							{
								$idreunion = $ligne1['idreunion'];
								echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=afficher_reunion&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"d&eacute;tails\" title=\"D&eacute;tails de la r&eacute;union\" border = \"0\"></A>";
								echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=modifier_reunion&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la r&eacute;union\" border = \"0\"></A>";
								
								//echo "<br />idsalle : $ligne1['idsalle']";
								
								if($ligne1['idsalle']==0)
								{
									echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=ajouter_salle&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/salle_ajout.png\" ALT = \"ajouter_salle\" title=\"Ajouter une salle &agrave; la r&eacute;union\" border = \"0\"></A>";
								}
								else
								{
									//echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=modifier_salle&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier_salle\" title=\"Modifier la salle de la r&eacute;union\" border = \"0\"></A>";
									echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=retirer_salle&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/salle_supprimer.png\" ALT = \"retirer_salle\" title=\"Retirer la salle de la r&eacute;union\" border = \"0\"></A>";
								}
							}
								echo "</td>";
								echo"<td class = \"fond-actions\" nowrap>";
							if ($niveau_droits > 3) //Il faut avoir les droits de création pour avoir accès aux boutons d'action
							{
								if (($nombre_participants > 0) AND ($ligne1['idsalle'] > 0))
								{
									//echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=liste_emargement&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/liste_emargement.png\" ALT = \"liste_emargement\" title=\"&Eacute;diter la liste d'&eacute;margement\" border = \"0\"></A>";
									echo "&nbsp;<A HREF = \"om_edition_liste_emargement.php?idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/liste_emargement.png\" ALT = \"liste_emargement\" title=\"&Eacute;diter la liste d'&eacute;margement\" border = \"0\"></A>";
									echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=imprimer_om&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/imprimer.png\" ALT = \"imprimer_om\" title=\"Imprimer les ordres de mission\" border = \"0\"></A>";
								}
							}
							echo "</td>";
								/*
						echo"<TD class = \"fond-actions\" nowrap>";
							echo "&nbsp;";
							//echo "&nbsp;<A HREF = \"om_affichage_reunion.php?action=O&amp;a_faire=afficher_reunion&amp;idreunion=$idreunion\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"d&eacute;tails\" title=\"D&eacute;tails de la r&eacute;union\" border = \"0\"></A>";
						echo "</td>";
	*/
				/*
							echo "<td>
								<FORM method=post action=\"om_affichage_invites_suivantom.php\">
									<INPUT border=0 src = \"$chemin_theme_images/utilisateurs.png\" type=image Value=MAJ R&eacute;union align=\"center\" title = \"Afficher les participants\"> 
									<input type=\"hidden\" name=\"idR\" value=\"'.$ligne1['idreunion'].'\" />
									<!--input type=\"submit\" name=\"affich\" value=\"Participants\" /-->
								</FORM>
							</TD>
							<TD>
								<FORM method=post action=\"om_edition_2eme.php\">
									<INPUT border=0 src = \"$chemin_theme_images/edition.png\" type=image Value=Liste_emargement align=\"center\" title = \"Liste &eacute;margement\"> 
									<input type=\"hidden\" name=\"idREUN\" value=\"'.$ligne1['idreunion'].'\" />
									<!--input type=\"submit\" name=\"Envoi Relance\" value=\"Edition\" /-->
								</FORM>
							</td>
							<td>
								<FORM method=post action=\"om_edition_3eme.php\">
									<INPUT border=0 src = \"$chemin_theme_images/edition-detaillee.png\" type=image Value=Recapitulatif align=\"center\" title = \"R&eacute;capitulatif\"> 
									<input type=\"hidden\" name=\"idREUN\" value=\"'.$ligne1['idreunion'].'\" />
									<!--input type=\"submit\" name=\"Envoi Relance\" value=\"Edition détaillée\" /-->
								</FORM>
							</TD>";
				*/
							echo "</TR>";
					} // Fin while pour récupérer les enregistrements
					echo "</tbody>";
				echo "</table>";
			} // Fin if total > 0
			else echo "Pas d'enregistrements dans cette table...";
			mysql_free_result($result);
		} //Fin affichage <> "N"
		echo "</div>";
	echo "</body>";
echo "</HTML>";
?>
