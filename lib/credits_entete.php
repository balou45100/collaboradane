<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
<?php
	echo "<body BGCOLOR =\"$bg_color1\">";
	echo "<CENTER>";
	include ("../biblio/init.php");
	include ("../biblio/config.php");
	echo "<FORM ACTION = \"personnes_ressources_gestion.php\" target = \"body\" METHOD = \"GET\">";
/*
	//Choix de l'année
	$compteur_debut = "2006";
	$compteur_fin = $compteur_debut + 10; 
	echo "&nbsp;&nbsp;<FONT COLOR=\"#808080\">Année&nbsp;:&nbsp;</FONT><select size=\"1\" name=\"annee\">
		<option selected value=\"$annee_budgetaire\">$annee_budgetaire</option>
		<option value=\"%\">toutes</option>";
		while ($compteur_debut < $compteur_fin)
		{
			if ($compteur_debut <> $annee_budgetaire)
			{
				echo "<option value=\"$compteur_debut\">$compteur_debut</option>";
			}
			$compteur_debut++;
		}
		echo "</select>";
		echo "</TD>&nbsp;&nbsp;";
*/
		//Choix des chapitres      
		$requeteliste_chapitres="SELECT * FROM credits_chapitres WHERE utilise = 'O' ORDER BY intitule_chapitre ASC";
		$result=mysql_query($requeteliste_chapitres);
		$num_rows = mysql_num_rows($result);

		echo "<FONT COLOR=\"#808080\">Chapitres&nbsp;:&nbsp;</FONT><select size=\"1\" name=\"intitule_chapitre\">";
		if (mysql_num_rows($result))
		{
			echo "<option selected value=\"0\">tous</option>";
			while ($ligne=mysql_fetch_object($result))
			{
				$id_chapitre=$ligne->id_chapitre;
				$intitule_chapitre=$ligne->intitule_chapitre;
				echo "<option value=\"$id_chapitre\">$intitule_chapitre</option>";
			}
		}
		echo "</SELECT>"; 

		//Choix des lignes budgétaires      
		$requeteliste_lignes ="SELECT * FROM credits_domaines_budget ORDER BY intitule, annee ASC";
		$result=mysql_query($requeteliste_lignes);
		$num_rows = mysql_num_rows($result);

		echo "&nbsp;&nbsp;<FONT COLOR=\"#808080\">Ligne budg&eacute;taire&nbsp;:&nbsp;</FONT><select size=\"1\" name=\"intitule_domaine_budget\">";
		if (mysql_num_rows($result))
		{
			echo "<option selected value=\"0\">toutes</option>";
			while ($ligne=mysql_fetch_object($result))
			{
				$id_domaine_budget=$ligne->id;
				$intitule_domaine_budget=$ligne->intitule;
				$annee_domaine_budget = $ligne->annee;
				echo "<option value=\"$id_domaine_budget\">$intitule_domaine_budget ($annee_domaine_budget)</option>";
			}
		}
		echo "</SELECT>"; 
/*
		//Choix du champs académique ou départemental
		echo "&nbsp;&nbsp;<FONT COLOR=\"#808080\">Dép.&nbsp;:&nbsp;</FONT><select size=\"1\" name=\"dep\">
			<option selected value=\"T\">tous</option>
			<option value=\"18\">Cher (18)</option>
			<option value=\"28\">Eure-et-Loire (28)</option>
			<option value=\"36\">Indre (36)</option>
			<option value=\"37\">Indre-et-Loire (37)</option>
			<option value=\"41\">Loir-et-Cher (41)</option>
			<option value=\"45\">Loiret (45)</option>
		</select>";
		echo "</TD>";
*/
		//Champ pour une recherche avec entrée libre

/*
		echo "&nbsp;&nbsp;<FONT COLOR=\"#808080\">Détail&nbsp;:&nbsp;</FONT> 
			<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";
*/

/*
		//Affichage des liens en fonction du statut de la personne connecté
		if($_SESSION['droit'] == "Super Administrateur")
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR=\"#808080\">Fonctions&nbsp;:&nbsp;</FONT></B>
			&nbbsp;&nbsp;<A HREF = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Catégories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes réglages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Réglages\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"gestion_user.php?indice=0\" target = \"body\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></A>
			&nbsp;&nbsp;<!--A HREF = \"cadre_gestion_ecl.php?tri=T&amp;indice=0\" target = \"body\" class=\"bouton\" title=\"Etablissements / Ecoles\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"Etabs/Ecoles\" border=\"0\"></A-->
			&nbsp;&nbsp;&nbsp;<A HREF = \"verif_coherence_base.php?taf=verifier\" target = \"body\" class=\"bouton\" title=\"Vérification de la base de données\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Cohérence BDD\" border=\"0\"></A>
			";
		}
		else
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR=\"#808080\">Fonctions&nbsp;:&nbsp;</FONT></B>
			&nbsp;&nbsp;<A HREF = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></A>
			&nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Catégories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Catégories\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes réglages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Réglages\" border=\"0\"></A>
			&nbsp;&nbsp;<A HREF = \"cadre_gestion_ecl.php?tri=T&amp;indice=0\" target = \"body\" class=\"bouton\" title=\"Etablissements / Ecoles\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"Etabs/Ecoles\" border=\"0\"></A-->
			";
		}
*/
/*		echo "&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">dans&nbsp;:&nbsp;</FONT>";
		echo "<select size=\"1\" name=\"dans\">";
			//echo "<option value=\"T\">tout</option>";
			echo "<option value=\"T\">&nbsp;</option>";
			echo "<OPTGROUP LABEL=\"pour la personne\">";
				echo "<option value=\"N\">Nom</option>";
				echo "<option value=\"P\">Pr&eacute;nom</option>";
				echo "<option value=\"NP\">Nom et pr&eacute;nom</option>";
				echo "<option value=\"M\">M&eacute;l</option>";
			echo "</OPTGROUP>";
			echo "<OPTGROUP LABEL=\"ECL\">";
				echo "<option value=\"RNE\">RNE</option>";
				echo "<option value=\"V\">Ville</option>";
			echo "</OPTGROUP>";
		echo "</SELECT>";
*/
/*
				echo "&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">dans&nbsp;:&nbsp;</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;<FONT COLOR=\"#808080\">Tout</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"N\">&nbsp;<FONT COLOR=\"#808080\">Nom</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"D\">&nbsp;<FONT COLOR=\"#808080\">Discipline</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"P\">&nbsp;<FONT COLOR=\"#808080\">Poste</FONT>
				<INPUT TYPE = \"radio\" NAME = \"dans\" VALUE = \"RNE\">&nbsp;<FONT COLOR=\"#808080\">RNE</FONT>
				";
*/
				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
				//echo "&nbsp;&nbsp;&nbsp;<FONT COLOR=\"#808080\">en liste&nbsp;:&nbsp;</FONT>";
				//echo "<input type=\"checkbox\" name=\"en_liste\" value=\"Oui\" size=\"4\" />";
				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
				echo "&nbsp;&nbsp;&nbsp;<INPUT TYPE = \"submit\" VALUE = \"Hop !\">
				</FORM>";		
			?>
		</CENTER>
	</body>
</html>

