<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
	$de = $_GET['de']; //On récupère la demande EF ou OM
	
	//echo "<br />de : $de";

?>
<!DOCTYPE HTML>
<?php
	include ("../biblio/config.php");
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	echo"<html>";
	echo "<head>";
		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo"</head>";
	echo "<body class = \"menu-boutons\">";
	include ("../biblio/init.php");

/*
echo "<div align=left>
<!--table-->

<a href = \"om_affichage_om.php\" target = \"body\" class=\"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_om.png\" border=\"0\" width=40 height=40%></img>OM</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
*/
	echo "<form action=\"om_affichage_om.php\" target=\"body\" method=\"GET\">";
/*
	$requete_annee="SELECT DISTINCT e.annee FROM evenements_participants AS ep, evenements AS e
		WHERE ep.id_evenement = e.id_evenement 
		ORDER BY e.annee";
*/
	$requete_annee="SELECT DISTINCT annee_imputation FROM evenements_participants
		ORDER BY annee_imputation";
	
	//echo "<br />$requete_annee";
	
	$result_requete_annee=mysql_query($requete_annee);
	//$num_rows = mysql_num_rows($result_requete_personnes);
	echo "Ann&eacute;e(s)&nbsp;:&nbsp;<select size=\"1\" name=\"filtre_annee\">";
	if (mysql_num_rows($result_requete_annee))
	{
  
		echo "<option selected value=\"%\">Toutes</option>";
		while ($ligne=mysql_fetch_object($result_requete_annee))
		{
			$annee_imputation=$ligne->annee_imputation;
			echo "<option value=\"$annee_imputation\">$annee_imputation</option>";
		}
	}
	echo "</select>"; 


	$requete_personnes="SELECT DISTINCT ep.id_participant, prt.nom, prt.prenom FROM evenements_participants AS ep, personnes_ressources_tice AS prt
		WHERE ep.id_participant = prt.id_pers_ress AND ep.etat_om > 1
		ORDER BY prt.nom, prt.prenom";
	
	//echo "<br />$requete_personnes";
	
	$result_requete_personnes=mysql_query($requete_personnes);
	//$num_rows = mysql_num_rows($result_requete_personnes);
	echo "&nbsp;Personne(s)&nbsp;:&nbsp;<select size=\"1\" name=\"filtre_personne\">";
	if (mysql_num_rows($result_requete_personnes))
	{
  
		echo "<option selected value=\"%\">Tous</option>";
		while ($ligne=mysql_fetch_object($result_requete_personnes))
		{
			$nom=$ligne->nom;
			$prenom=$ligne->prenom;
			$id_participant = $ligne->id_participant;
			echo "<option value=\"$id_participant\">$nom $prenom</option>";
		}
	}
	echo "</select>"; 

/*
	echo "&nbsp;&nbsp;Etat&nbsp;:&nbsp;<select name=\"etat_om\">";
		echo "<option value=\"%\">Tout</option>";
		echo "<option value=\"0\">non trait&eacute;</option>";
		echo "<option value=\"1\">trait&eacute;</option>";
	echo "</select>&nbsp;&nbsp;&nbsp;";
*/
	echo "&nbsp;&nbsp;Statut&nbsp;:&nbsp;<select name=\"statut_om\">";
		if($de==om)
		{
			echo "<option value=\"%\">Tout OM</option>";
			echo "<option value=\"0\">OM non &eacute;dit&eacute;</option>";
			echo "<option value=\"1\">OM &eacute;dit&eacute;</option>";
			echo "<option value=\"2\">OM &agrave; la signature</option>";
			echo "<option value=\"3\">OM envoy&eacute;</option>";
			echo "<option value=\"4\">pr&eacute;sent-e-s</option>";
			echo "<option value=\"5\">absent-e-s</option>";
			echo "<option value=\"6\">OM valid&eacute;</option>";
			echo "<option value=\"7\">OM r&eacute;vis&eacute;</option>";
			echo "<option value=\"8\">OM refus&eacute;</option>";
		}
		else
		{
			echo "<option value=\"%\">Tout EF</option>";
			echo "<option value=\"9\">EF cr&eacute;&eacute;</option>";
			echo "<option value=\"10\">EF valid&eacute;</option>";
			echo "<option value=\"11\">EF r&eacute;vis&eacute;</option>";
			echo "<option value=\"12\">EF refus&eacute;</option>";
			echo "<option value=\"13\">EF annul&eacute;</option>";
			echo "<option value=\"14\">EF pay&eacute;</option>";
		}
	echo "</select>&nbsp;&nbsp;&nbsp;";

	//echo "<td>";
		echo "&nbsp;par date&nbsp;:&nbsp;";
		echo "<select size=\"1\" name=\"date_filtre\">";
			echo "<option selected value=\"2\">pass&eacute;es</option>";
			echo "<option value=\"1\">&agrave; venir</option>";
			echo "<option value=\"%\">toutes</option>";
			
			//On ajoute toutes les dates des évènements

			$requete_par_date = "SELECT DISTINCT date_evenement_debut FROM evenements
				ORDER BY date_evenement_debut DESC";
			$resultat_requete_par_date = mysql_query($requete_par_date);
			$num_rows = mysql_num_rows($resultat_requete_par_date);
			if (mysql_num_rows($resultat_requete_par_date))
			{
				while ($ligne=mysql_fetch_object($resultat_requete_par_date))
				{
					$date_evenement_debut=$ligne->date_evenement_debut;
					echo "<option value=\"$date_evenement_debut\">$date_evenement_debut</option>";
				}
			}
		echo "</select>";
	//echo "</td>";
	echo "&nbsp;&nbsp;Frais&nbsp;:&nbsp;<select name=\"frais\">";
		echo "<option selected value=\"A\">Avec</option>";
		echo "<option value=\"S\">Sans</option>";
		echo "<option value=\"C\">Co-voiturage</option>";
		echo "<option value=\"%\">Tout</option>";
	echo "</select>&nbsp;&nbsp;&nbsp;";

		echo "<input type=\"submit\" name=\"validRecherche_om\" value=\"Hop !\" />";
		echo "<input type=\"hidden\" name=\"origine_appel\" value=\"entete\" />";
		echo "<input type=\"hidden\" name=\"de\" value=\"$de\" />";
	echo "</form>";

?>
<!--/div>
</table-->
</body>
</html>

