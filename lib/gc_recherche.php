<?php
	//Lancement de la session
	session_start();
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
?>
<!DOCTYPE HTML>

<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
		echo "<body>";
		echo "<div align = \"center\">";
 
	echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_courrier.png\" ALT = \"Titre\">";
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	//include ("../biblio/ticket.css");
	$menu = $_POST['menu'];
	//$origine = $_GET['origine'];
	$type_courrier = $_GET['type_courrier'];

	//echo "<br />-1 type_courrier GET : $type_courrier";

	if (!ISSET($type_courrier))
	{
		$type_courrier = $_POST['type_courrier'];
		//echo "<br />0 type_courrier POST : $type_courrier";
	}
	
	/*
	if (!ISSET($origine))
	{
		$origine = $_POST['origine'];
		//echo "<br />0 origine POST : $origine";
	}
	
	echo "<br />origine : $origine";
	echo "<br />menu : $menu";
	*/
	if (ISSET($menu))
	{
		//On r&eacute;cup&egrave;re les variables transmises &agrave; partir du menu
		$type_courrier = $_POST['type_courrier'];
		$annee_scolaire_filtree = $_POST['annee_scolaire_filtree'];
		$mois = $_POST['mois'];
		$categorie = $_POST['categorie'];
		$expediteur = $_POST['expediteur'];
		$destinataire = $_POST['destinataire'];
		$a_rechercher = $_POST['a_rechercher'];
		//Ensuite on enregistre les donn&eacute;es dans des variables session
		//echo "<h2>Je fixe les variables session</h2>";
		$_SESSION['type_courrier'] = $type_courrier;
		$_SESSION['annee_scolaire_filtree'] = $annee_scolaire_filtree;
		$_SESSION['mois'] = $mois;
		$_SESSION['categorie'] = $categorie;
		$_SESSION['expediteur'] = $expediteur;
		$_SESSION['destinataire'] = $destinataire;
		$_SESSION['a_rechercher'] = $a_rechercher;
	}
	else
	{
		//echo "<h2>Je r&eacute;cup&egrave;re les variables session</h2>";
		$type_courrier = $_SESSION['type_courrier'];
		$annee_scolaire_filtree = $_SESSION['annee_scolaire_filtree'];
		$mois = $_SESSION['mois'];
		$categorie = $_SESSION['categorie'];
		$expediteur = $_SESSION['expediteur'];
		$destinataire = $_SESSION['destinataire'];
		$a_rechercher = $_SESSION['a_rechercher'];
	}
	/*
	echo "<br />type_courrier : $type_courrier";
	echo "<br />annee_scolaire_filtree : $annee_scolaire_filtree";
	echo "<br />mois : $mois";
	echo "<br />categorie : $categorie";
	echo "<br />expediteur : $expediteur";
	echo "<br />destinataire : $destinataire";
	echo "<br />a_rechercher : $a_rechercher";
	*/
////////////////////////////////////////////////////////////////////////
////// On ex&eacute;cute les actions //////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
	if (isset($_POST['modifier']))
	{
		$modif_date = $_POST['modif_date'];
		$date_creation = $_POST['modif_date_creation'];
		$expediteur = $_POST['modif_expediteur'];
		$destinataire = $_POST['modif_destinataire'];
		$description = $_POST['modif_description'];
		$categorie = $_POST['modif_categorie'];
		$annee_scolaire = $_POST['modif_annee_scolaire'];
		$type = $_POST['modif_type'];
		$Num_enr = $_POST['modif_num_enr'];
		$confidentiel = $_POST['modif_confidentiel'];
		/*
		echo "<br />modif_date : $modif_date";
		echo "<br />date_creation : $date_creation";
		echo "<br />expediteur : $expediteur";
		echo "<br />destinataire : $destinataire";
		echo "<br />description : $description";
		echo "<br />categorie : $categorie";
		echo "<br />annee_scolaire : $annee_scolaire";
		echo "<br />type : $type";
		echo "<br />Num_enr : $Num_enr";
		echo "<br />confidentiel : $confidentiel";
		echo "<br />";
		*/
		$requete = "UPDATE courrier
				SET date = '".$_POST['modif_date']."'
					,date_creation = '".$_POST['modif_date_creation']."'
					,expediteur = '".$_POST['modif_expediteur']."'
					,destinataire = '".$_POST['modif_destinataire']."'
					,description = '".$_POST['modif_description']."'
					,categorie = '".$_POST['modif_categorie']."'
					,confidentiel = '".$_POST['modif_confidentiel']."'
				WHERE type LIKE '".$_POST['modif_type']."' 
				AND Num_enr = '".$_POST['modif_num_enr']."'
				AND annee_scolaire LIKE '".$_POST['modif_annee_scolaire']."'";
				
		//echo "<br />$requete";
		
		$resultat = mysql_query($requete);
		$requete = "delete from courrier_concerne
				where type like '".$_POST['modif_type']."'
				and num_enr = ".$_POST['modif_num_enr']."
				and annee_scolaire like '".$_POST['modif_annee_scolaire']."'";			
		$resultat = mysql_query($requete);
		if (isset($_POST['modif_concerne']))
		{
			foreach($_POST['modif_concerne'] as $valeur)
			{
				$requete = "insert into courrier_concerne
					values ('".$_POST['modif_type']."', ".$_POST['modif_num_enr'].", '".$_POST['modif_annee_scolaire']."', '".$valeur."')";			
				$resultat = mysql_query($requete);
			}
		}
		if ($resultat)
		{
			echo "<h2>Modification effectu&eacute;e avec succ&egrave;s</h2>";
		}
		else
		{
			echo "<h2>Erreur lors de la modification</h2>";
		}
	} //Fin proc&eacute;dure de modification

	If ($_GET['action'] == "ajout_document")
	{
		//echo "<br />action = ajout_document";
		$script = "gc_recherche";
		$id_courrier = $_GET['id_courrier'];
		$module = $_GET['module'];
		//echo "<h2>D&eacute;pôt de fichier sur le serveur pour le ticket $idpb</h2>";
		$affichage = "N"; // pour &eacute;viter que le ticket s'affiche
		include ("choix_fichier.inc.php");
	}
////////////////////////////////////////////////////////////////////////
////// Fin des actions /////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
////// D&eacute;but de l'affichage du tableau /////////////////////////////////
////////////////////////////////////////////////////////////////////////
	if ($affichage <> "N")
	{
		//echo "<br />pref_util_type_courrier : $pref_util_type_courrier";
		//Il faut afficher les filtres en fonction du type_courrier entrant / sortant
	
		//$filtre_active = $_POST['filtre_active'];
	
		//echo "<br />filtre_active : $filtre_active";
	
		//On fixe l'ann&eacute;e scolaire &agrave; filtrer
		//Pour la recherche ça peut concerner toutes les ann&eacute;es
		//if (isset($_POST['annee_scolaire_filtree']) AND $_POST['annee_scolaire_filtree']=="T")
		if (isset($annee_scolaire_filtree) AND $annee_scolaire_filtree == "T")
		{
			$annee_scolaire_filtree = "%";
		}
		//elseif (isset($_POST['annee_scolaire_filtree']) AND $_POST['annee_scolaire_filtree']!="")
		elseif (isset($annee_scolaire_filtree) AND $annee_scolaire_filtree !="")
		{
			//$annee_scolaire_filtree = $_POST['annee_scolaire_filtree'];
		}
		else
		{
			$annee_scolaire_filtree = $annee_scolaire;
		}
		//Affichage des icônes pour la saisie des courriers et la gestion des cat&eacute;gories si la personne connect&eacute;e en a le droit
	
		//echo "<br />avant v&eacute;rification droits";
	
		$niveau_droits = verif_droits("courrier");
	
		//echo "<br />niveau_droits : $niveau_droits";
	
		if ($niveau_droits == 3) //Il faut avoir les droits de création pour avoir accès aux boutons
		{
			include ('gc_boutons_gestion.inc.php');
		}
		
		//On constitue la requête
		$complement = "";
		$t_courrier = $_SESSION['type_courrier'];
		$complement = $complement." and type like '".$type_courrier."'";
		//Filtre sur le mois si date est vide
		//if (isset($_POST['mois']) AND $_POST['mois']!="")
		if (isset($mois) AND $mois != "")
		{
			//$complement = $complement." AND month(date) = '".$_POST['mois']."'";
			$complement = $complement." AND month(date) = '".$mois."'";
		}
		//Filtre sur la date si mois est vide
/*
				if (isset($_POST['date']) AND $_POST['date']!="" AND $_POST['mois']=="" AND isset($_POST['mois']))
				{
					$complement = $complement." AND date = '".$_POST['date']."'";
				}
*/
		//Filtre sur l'expediteur
		//if (isset($_POST['expediteur']) AND $_POST['expediteur']!="")
		if (isset($expediteur) AND $expediteur != "")
		{
			//$complement = $complement." AND expediteur = '".$_POST['expediteur']."'";
			$complement = $complement." AND expediteur = '".$expediteur."'";
		}
		//Filtre sur le destinataire
		//if (isset($_POST['destinataire']) AND $_POST['destinataire']!="")
		if (isset($destinataire) AND $destinataire != "")
		{
			//$complement = $complement." AND destinataire like '".$_POST['destinataire']."'";
			$complement = $complement." AND destinataire like '".$destinataire."'";
		}

		//Filtre sur les mots cl&eacute;s
		//if (isset($_POST['categorie']) AND $_POST['categorie']!="")
		if (isset($categorie) AND $categorie != "")
		{
			//$complement = $complement." AND categorie = ".$_POST['categorie'];
			$complement = $complement." AND categorie = ".$categorie;
		}

		//if (isset($_POST['a_rechercher']) AND $_POST['a_rechercher']!="")
		if (isset($a_rechercher) AND $a_rechercher != "")
		{
			//on rajoute la recherche dans les champs exp&eacute;diteur, destinataire et description
			//$detail_a_rechercher = "'%".$_POST['a_rechercher']."%'";
			$detail_a_rechercher = "'%".$a_rechercher."%'";
			$complement = $complement." AND (description LIKE ".$detail_a_rechercher." OR expediteur LIKE ".$detail_a_rechercher." OR destinataire LIKE ".$detail_a_rechercher.")";

			//$complement = $complement." OR expediteur LIKE ".$detail_a_rechercher." OR destinataire LIKE ".$detail_a_rechercher;
			//$complement = $complement.")"; 
		}

		$requete = "
			SELECT type, Num_enr, date, date_creation, expediteur, destinataire, description, nom, annee_scolaire, cree_par, confidentiel, id_courrier
			FROM courrier, courrier_categorie
			WHERE courrier.categorie=courrier_categorie.numero AND courrier.annee_scolaire LIKE '".$annee_scolaire_filtree."'".$complement."
			ORDER BY 9 DESC,2 DESC";

		//echo "<br />$requete";

		$resultat = mysql_query($requete);
		$num_rows = mysql_num_rows($resultat);

		//echo "<br />num_rows : $num_rows";
		
		echo "<fieldset>";
			echo "<legend><b>Liste des $num_rows courriers <strong>$type_courrier</strong> filtr&eacute;s</b></legend>";

			if ($num_rows > 0)
			{
				echo "<table width = \"95%\">";
					//echo "<tr class = \"entete_tableau\">";
					echo "<tr>";
					//echo "<th>ID</th>";
					//echo "<th>Type</th>";
					echo "<th>No</th>";
					echo "<th>Ann&eacute;e scolaire</th>";
					echo "<th>Date de cr&eacute;ation</th>";
					echo "<th>Date</th>";
					echo "<th>Exp&eacute;diteur</th>";
					echo "<th>Destinataire</th>";
					echo "<th>Personnes concern&eacute;es</th>";
					echo "<th>Cat&eacute;gorie</th>";
					echo "<th>Description</th>";
					echo "<th>cr&eacute;e par</th>";
					echo "<th>Fichier(s) joint(s)</th>";
					echo "<th>&nbsp;</th>";
					echo "<th>Actions</th>";
					echo "</tr>";

					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							$date=strtotime($ligne[2]);
							$datecre=strtotime($ligne[3]);
							$date=date('d/m/Y',$date);
							$datecre=date('d/m/Y',$datecre);
							
							echo "<tr>";
								/*
								echo "<td>$ligne[11]</td>";
								if ($ligne[0] == "entrant")
								{
									echo "<td align = \"center\">E</td>";
								}
								else
								{
									echo "<td align = \"center\">S</td>";
								}
								*/
								echo "<td align = \"center\">".$ligne[1]."</td>
								<td align = \"center\">".$ligne[8]."</td>
								<td align = \"center\">".$datecre."</td>
								<td align = \"center\">".$date."</td>
								<td>".$ligne[4]."</td>
								<td>".$ligne[5]."</td>
								<td>";

							$requete2 = "
								SELECT nom, prenom, initiales
								FROM util u, courrier_concerne c
								WHERE u.id_util=c.id_util
									AND type like '".$ligne[0]."'
									AND num_enr = '".$ligne[1]."'
									AND annee_scolaire like '".$ligne[8]."'";
							$resultat2 = mysql_query($requete2);
							while ($ligne2=mysql_fetch_array($resultat2))
							{
								//echo $ligne2[1]." ".$ligne2[0]."<br />";
								echo "$ligne2[2], ";
							}
								echo"</td>";
								echo "<td>".$ligne[7]."</td>";
								echo "<td>".$ligne[6]."</td>";
								//On ajoute les initiales du cr&eacute;ateur du courrier
								$initiales = lecture_utilisateur(Initiales,$ligne[9]);
								//$initiales = lecture_utilisateur(NOM,$ligne[9]);
								echo "<td align = \"center\">$initiales</td>";
							
								//Ici on r&eacute;cup&egrave;re les fichiers joints
								//On attendant on affiche une cellule vide
								echo "<td>";
									include ("affiche_documents_joints_courriers.inc.php");
								echo "</td>";
							
								if ($ligne[10] == "O")
								{
									echo "<td><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\"></td>";
								}
								else
								{
									echo "<td>&nbsp;</td>";
								}

								//On affiche les boutons en fonctions des droits
								
								//echo "<br />ligne[9] : $ligne[9]";
								$niveau_droits = verif_droits("courrier");
								
								//echo "<br />niveau_droits : $niveau_droits";
								
								//if ($ligne[9] == $_SESSION['id_util'])
								if ($niveau_droits >2)
								{
									echo"<td nowrap class = \"fond-actions\">";
										echo "&nbsp;<a href = \"gc_recherche.php?id_courrier=".$ligne[11]."&amp;module=COU&amp;action=ajout_document\" target = \"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/document_ajout.png\" ALT = \"ajout doc\" border=\"0\" title=\"Ajouter une pi&egrave;ce\"></a>";
										echo "&nbsp;<a href = \"gc_modif_courrier.php?num=".$ligne[1]."&amp;type=".$ligne[0]."&amp;type_courrier=$type_courrier&amp;annee_scolaire_filtree=$annee_scolaire_filtree\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le courrier\" border = \"0\"></a>";
										echo "&nbsp;<a href = \"gc_prevenir.php?num=".$ligne[1]."&type=".$ligne[0]."&annee=".$ligne[8]."&amp;type_courrier=$type_courrier&amp;annee_scolaire_filtree=$annee_scolaire_filtree\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier.png\" ALT = \"pr&eacute;venir\" title=\"Pr&eacute;venir les personnes concern&eacute;es\" border = \"0\"></a>";
									echo "</td>";
								}
								else
								{
									echo "<td class = \"entete_tableau\">&nbsp;</td>";
								}
							echo "</tr>";
						}
					}
					echo "</table>";
					
					} //Fin num_rows > 0
					else
					{
						echo "<h2>Aucun courrier correspond aux crit&egrave;res</h2>";
					}

				echo "</fieldset>";
	} //Fin if affichage <> N
?>
	</div>
	</body>
</html>
