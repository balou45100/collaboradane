<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	include ("../biblio/ticket.css");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	$origine = $_GET['origine'];
	$type_courrier = $_GET['type_courrier'];

	//echo "<br />-1 type_courrier GET : $type_courrier";

	if (!ISSET($type_courrier))
	{
		$type_courrier = $_POST['type_courrier'];
		//echo "<br />0 type_courrier POST : $type_courrier";
	}
	
	//echo "<br />origine : $origine";
	
	if (ISSET($origine))
	{
		$_SESSION['type_courrier'] = $type_courrier;
	}
	
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
		echo "<br />";
		*/
		$requete = "UPDATE courrier
				SET date = '".$_POST['modif_date']."'
					,date_creation = '".$_POST['modif_date_creation']."'
					,expediteur = '".$_POST['modif_expediteur']."'
					,destinataire = '".$_POST['modif_destinataire']."'
					,description = '".$_POST['modif_description']."'
					,categorie = '".$_POST['modif_categorie']."'
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
			echo "<h2>Modification effectuée avec succès</h2>";
		}
		else
		{
			echo "<h2>Erreur lors de la modification</h2>";
		}
	} //Fin procédure de modification
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<body>
<?php
	//echo "<br />pref_util_type_courrier : $pref_util_type_courrier";
	//Il faut afficher les filtres en fonction du type_courrier entrant / sortant
	
	$filtre_active = $_POST['filtre_active'];
	//On fixe l'année scolaire à filtrer
	//Pour la recherche ça peut concerner toutes les années
	if (isset($_POST['annee_scolaire_filtree']) AND $_POST['annee_scolaire_filtree']=="T")
	{
		$annee_scolaire_filtree = "%";
	}
	elseif (isset($_POST['annee_scolaire_filtree']) AND $_POST['annee_scolaire_filtree']!="")
	{
		$annee_scolaire_filtree = $_POST['annee_scolaire_filtree'];
	}
	else
	{
		$annee_scolaire_filtree = $annee_scolaire;
	}

	
	//echo "<br />avant filtres : type_courrier : $type_courrier";
	//echo "<br />avant filtres : filtre_active : $filtre_active";
	$titre_choix_criteres = "Choix des crit&egrave;res pour la recherche de courriers ".$type_courrier."s";
	echo "<fieldset>";
		echo "<legend><b>$titre_choix_criteres</b></legend>";
		echo "<form action=\"gc_recherche.php\" method=\"post\">";
		echo "<table width = \"100%\" border = \"0\">";
			echo "<colgroup>";
				echo "<col width=\"50%\">";
				echo "<col width=\"50%\">";
			echo "</colgroup>";
		echo "<tr>";
		echo "<td align=\"left\">";
			echo "&nbsp;Année scolaire&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"annee_scolaire_filtree\" >";
					echo "<option value=\"$annee_scolaire\">$annee_scolaire</option>";
					echo "<option value=\"T\">toutes</option>";
					$requete = "
						SELECT distinct annee_scolaire
						FROM courrier
						ORDER by 1 DESC";
					
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
							if ($ligne[0] <> $annee_scolaire)
							{
								echo"<option value=\"".$ligne[0]."\">".$ligne[0]."</option>";						
							}
						}
					}
				echo "</select>";
/*
		echo "</td>";
		echo "<td align=\"Center\">";
*/
			echo "&nbsp;&nbsp;Mois&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"mois\" >";
					echo "<option value=\"\">Choisir un mois</option>";
					echo "<option value=\"1\">Janvier</option>";
					echo "<option value=\"2\">Février</option>";
					echo "<option value=\"3\">Mars</option>";
					echo "<option value=\"4\">Avril</option>";
					echo "<option value=\"5\">Mai</option>";
					echo "<option value=\"6\">Juin</option>";
					echo "<option value=\"7\">Juillet</option>";
					echo "<option value=\"8\">Aout</option>";
					echo "<option value=\"9\">Septembre</option>";
					echo "<option value=\"10\">Octobre</option>";
					echo "<option value=\"11\">Novembre</option>";
					echo "<option value=\"12\">Décembre</option>";
				echo "</select>";
		echo "</td>";
/*
		echo "<td align=\"Center\">";
			echo "Une date pr&eacute;cise&nbsp;:&nbsp;";
				echo "<input type=\"text\" id=\"date\" name=\"date\" value=\"\">";
				//	<a href=\"javascript:popupwnd('calendrier.php?idcible=date&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>
				echo "&nbsp;<a href=\"\" onclick=\"window.open('calendrier.php?idcible=date&langue=fr','pop_up','toolbar=no, status=no, scrollbars=yes, width=280, height=450')\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
		echo "</td>";
*/
			echo "<td align=\"left\">";
				echo "&nbsp;Catégorie&nbsp;:&nbsp;";
					$requete = "
						SELECT *
						FROM courrier_categorie
						ORDER BY nom";
					//echo "<br />$requete";
					
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
				echo "<select name=\"categorie\">";
					echo "<option value=''>Choisir une catégorie</option>";
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
						}
					}
				echo "</select>";
			echo "</td>";

	echo "</tr>";
	echo "<tr>";
		echo "<td align=\"left\">";
			echo "&nbsp;Exp&eacute;diteur&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"expediteur\">";
					echo "<option value=\"\">Choisir un expediteur</option>";
						//recherche du destinataire
						if (isset($_POST['type']) and $_POST['type']!='')
						{
						//Si le type de courrier à déjà été selectionné, on dit que l'on veux que les destinataire donc le courrier est entrant
						$complement=" where type like '".$_POST['type']."'";
						}
						else
						{
						$complement="";
						}
					$requete = "
						SELECT DISTINCT expediteur
						FROM courrier".$complement."
						ORDER BY expediteur";
					
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['expediteur']) AND $ligne[0]==$_POST['expediteur'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}
				echo "</select>";
			echo "</td>";

			echo "<td align=\"left\">";
				echo "&nbsp;Destinataire&nbsp;:&nbsp;";
/*
					if (isset($_POST['type']) and $_POST['type']!='')
					{
						$complement=" where type like '".$_POST['type']."'";
					}
					else
					{
						$complement="";
					}
*/
					$requete = "
						SELECT DISTINCT destinataire
						FROM courrier
						WHERE type LIKE '".$type_courrier."'
						ORDER BY destinataire";
						
						//echo "<br />$requete";

					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
				echo "<select size=\"1\" name=\"destinataire\">";
					echo "<option value=\"\">Choisir un destinataire</option>";
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['destinataire']) AND $ligne[0]==$_POST['destinataire'])
							{
								$selected=" selected";
							}
							else
							{
								$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";

	echo "<br /><center>";
		echo "<input type=\"submit\" value=\"Afficher les courriers\">";
		echo "<input type=\"hidden\" value='".$type_courrier."' name=\"type_courrier\">";
		echo "<input type=\"hidden\" value= \"oui\" name=\"filtre_active\">";
	echo "</center>";

	echo "</form>";
	echo "</fieldset>";
		
		
		//echo "<br />1 type_courrier : $type_courrier";
		//echo "<br />pref_util_type_courrier : $pref_util_type_courrier";
		
		//On constitue la requête
				$complement = "";
				//Filtrage sur l'année scolaire
				//Filtre sur le type
				//On teste si le type a déjà été enregistré, sinon on le fix à la variable des préfrences
				
				$t_courrier = $_SESSION['type_courrier'];
				
				//echo "<br />t_courrier : $t_courrier";
				/*
				if (!ISSET($_SESSION['type_courrier']))
				{
					$_SESSION['type_courrier'] = $type_courrier;
					$type_courrier = $_SESSION['type_courrier'];
				}
				else
				{
					$type_courrier = $_SESSION['type_courrier'];
				}
				*/ 
				$complement = $complement." and type like '".$type_courrier."'";

				//echo "<br />2 type_courrier : $type_courrier";

				//Filtre sur le mois si date est vide
				//if (isset($_POST['mois']) AND $_POST['mois']!="" AND $_POST['date']=="" AND isset($_POST['date']))
				if (isset($_POST['mois']) AND $_POST['mois']!="")
				{
					$complement = $complement." AND month(date) = '".$_POST['mois']."'";
				}
				//Filtre sur la date si mois est vide
/*
				if (isset($_POST['date']) AND $_POST['date']!="" AND $_POST['mois']=="" AND isset($_POST['mois']))
				{
					$complement = $complement." AND date = '".$_POST['date']."'";
				}
*/
				//Filtre sur l'expediteur
				if (isset($_POST['expediteur']) AND $_POST['expediteur']!="")
				{
					$complement = $complement." AND expediteur = '".$_POST['expediteur']."'";
				}
				//Filtre sur le destinataire
				if (isset($_POST['destinataire']) AND $_POST['destinataire']!="")
				{
					$complement = $complement." AND destinataire like '".$_POST['destinataire']."'";
				}
				
				//Filtre sur les mots clés
				if (isset($_POST['categorie']) AND $_POST['categorie']!="")
				{
					$complement = $complement." AND categorie = ".$_POST['categorie'];
				}
				$requete = "
				SELECT type, Num_enr, date,date_creation, expediteur, destinataire, description, nom, annee_scolaire, scan
				FROM courrier, courrier_categorie
				WHERE courrier.categorie=courrier_categorie.numero AND courrier.annee_scolaire LIKE '".$annee_scolaire_filtree."'".$complement."
				ORDER BY 2 DESC";

				//echo "<br>$requete";
				
				$resultat = mysql_query($requete);
				$num_rows = mysql_num_rows($resultat);
				
				//echo "<br />num_rows : $num_rows";
				echo "<fieldset>";
					echo "<legend><b>Liste des $num_rows courriers filtr&eacute;s (en $type_courrier)</b></legend>";
				
				if ($num_rows > 0)
				{
						echo "<table width=\"100%\">";
							echo "<tr class = \"entete_tableau\">";
								echo "<th>Type</th>";
								echo "<th>No</th>";
								echo "<th>Ann&eacute;e scolaire</th>";
								echo "<th>Date de cr&eacute;ation</th>";
								echo "<th>Date</th>";
								echo "<th>Exp&eacute;diteur</th>";
								echo "<th>Destinataire</th>";
								echo "<th>Personnes concern&eacute;es</th>";
								echo "<th>Cat&eacute;gorie</th>";
								echo "<th>Description</th>";
								echo "<th>Fichier joint</th>";
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
						echo "<tr class = \"fond_tableau\">
							<td>".$ligne[0]."</td>
							<td align = \"center\">".$ligne[1]."</td>
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
							if ($ligne[9] !="")
							{
								echo"<td><a href='".$ligne[9]."' target='_blank'>Fichier joint</a></td>";
							}
							else
							{
								echo"<td></td>";
							}
							echo"<td class = \"entete_tableau\">&nbsp;<a href=\"gc_modif_courrier.php?num=".$ligne[1]."&amp;type=".$ligne[0]."&amp;type_courrier=$type_courrier&amp;annee_scolaire_filtree=$annee_scolaire_filtree\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le courrier\" border = \"0\"></a>";
							echo "&nbsp;<a href=\"gc_prevenir.php?num=".$ligne[1]."&type=".$ligne[0]."&annee=".$ligne[8]."&amp;type_courrier=$type_courrier&amp;annee_scolaire_filtree=$annee_scolaire_filtree\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier.png\" ALT = \"pr&eacute;venir\" title=\"Pr&eacute;venir les personnes concern&eacute;es\" border = \"0\"></a>&nbsp;</td>";
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
?>
	</body>
</html>
