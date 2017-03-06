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
	include ("../biblio/entete_et_menu.css");
	include ("../biblio/init.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	$id_util = $_SESSION['id_util'];
	//echo "<br />id_util : $id_util";
	
	//On regarde les préférence de l'utilisateur déans la table préférence
	//$pref_util_courrier_type = lecture_preference("pref_util_courrier_type",$id_util); 
	//$pref_util_courrier_demarrage = lecture_preference("pref_util_courrier_demarrage",$id_util); 
	/*
	echo "<br />pref_util_courrier_type : $pref_util_courrier_type";
	echo "<br />pref_util_courrier_demarrage : $pref_util_courrier_demarrage";
	*/
	unset($_SESSION['type_courrier']); //On réinitialise la variable session
/*
	$type_courrier = $_GET['type_courrier'];
	if (!ISSET($type_courrier))
	{
		$_SESSION['type_courrier'] = "sortant";
		$type_courrier = "sortant";
	}
	else
	{
		$_SESSION['type_courrier'] = $type_courrier;
	}
*/
	//echo "<br />type_courrier : $type_courrier";
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<body class = "fond_entete">
<?php
	echo "<center>";
	echo "<table>";
		echo "<tr>";
			echo "<td valign = \center\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivant.png\" border=\"0\">&nbsp;<b>ENTRANT</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<td><a href=\"gc_saisie.php?type_courrier=entrant\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_entrant.png\" id=\"Image2\" title = \"Saisir un courrier entrant\" align=\"top\" border=\"0\"></a></td>";
			//echo "<td><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_entrant.png\" ALT = \"GC\" border=\"0\"></A><br />Courrier entrant</td>";
			echo "<td>&nbsp;&nbsp;<a href=\"gc_recherche.php?type_courrier=entrant&amp;origine=menu\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_entrant_recherche.png\" id=\"Image2\" title = \"Rechercher un courrier entrant\" align=\"top\" border=\"0\"></a></td>";
			echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";
			echo "<td>&nbsp;&nbsp;<a href=\"gc_gestion_categorie.php\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_categories.png\" title = \"G&eacute;rer les cat&eacute;gories\" align=\"top\" border=\"0\"></a></td>";
			echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">&nbsp;&nbsp;</td>";
			echo "<td>&nbsp;&nbsp;<a href=\"gc_saisie.php?type_courrier=sortant\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png\" id=\"Image1\" title = \"Saisir un courrier sortant\" align=\"top\" border=\"0\"></a></td>";
			echo "<td>&nbsp;&nbsp;<a href=\"gc_recherche.php?type_courrier=sortant&amp;origine=menu\" target=\"zone_travail\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant_recherche.png\" id=\"Image2\" title = \"Rechercher un courrier sortant\" align=\"top\" border=\"0\"></a></td>";
			echo "<td valign = \center\">&nbsp;&nbsp;<b>SORTANT</b>&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/suivant.png\" border=\"0\">&nbsp;</td>";
		echo "</tr>";
	echo "</table>";
	echo "<!--a href=\"gc_saisie.php\" target=\"zone_travail\">Saisir un courrier</a> <a href=\"gc_recherche.php\" target=\"zone_travail\">Rechercher un courrier</a> <a href=\"gc_gestion_categorie.php\" target=\"zone_travail\">Gérer les catégories</a-->";
	echo "</center>";
?>
		</body>
</html>
