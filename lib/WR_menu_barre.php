<?php
	header('Content-Type: text/html;charset=UTF-8');
/*
	if ($script == "index")
	{
		$chemin_images = "./image/";
		$chemin_scripts = "./lib/";
	}
	else
	{
		$chemin_images = "../image/";
		$chemin_scripts = "../lib/";
	}

*/
	include ("../biblio/config.php");
	$theme = $_SESSION['chemin_theme']."WR_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	//echo "<br />script : $script";
		$chemin_images = "../image/";
		//$chemin_scripts = "../lib/";

	/*
	echo "<br />largeur_icone_action : $largeur_icone_action";
	echo "<br />hauteur_icone_action : $hauteur_icone_action";
	*/
	
	//$largeur = "30";
	//$hauteur = "30";
	
	echo "<div align = \"right\" id=\"menu_barre\">";
	
		If ($script <> "emissions")
		{
			echo "<a href = ".$chemin_scripts."WR_emissions.php title = \"Les &eacute;missions\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_11.jpg\" title = \"Les &eacute;missions\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_11.jpg\" title = \"Les &eacute;missions\"/>";
		}

		If ($script <> "conducteurs")
		{
			echo "<a href = ".$chemin_scripts."WR_conducteurs.php title = \"Les conducteurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_12.jpg\" title = \"Les conducteurs\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_12.jpg\" title = \"Les conducteurs\"/>";
		}

		If ($script <> "ressources")
		{
			echo "<a href = ".$chemin_scripts."WR_ressources.php title = \"Les ressources\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_13.jpg\" title = \"Les ressources\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_13.jpg\" title = \"Les ressources\"/>";
		}

		If ($script <> "emissions_categories")
		{
			//echo "<div id = \"barre_module_11\">&nbsp;</div>";
			echo "<a href = ".$chemin_scripts."WR_emissions_categories.php title = \"Cat&eacute;gories d'&eacute;mission\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_14.jpg\" title = \"Cat&eacute;gories d'&eacute;mission\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_14.jpg\" title = \"Cat&eacute;gories d'&eacute;mission\"/>";
		}

		If ($script <> "ressources_categories")
		{
			echo "<a href = ".$chemin_scripts."WR_ressources_categories.php title = \"Cat&eacute;gories ressources\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = ".$chemin_images."WR_menu_option_21.jpg title = \"Cat&eacute;gories ressources\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_21.jpg\" title = \"Cat&eacute;gories ressources\"/>";
		}

		//echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = ".$chemin_images."WR_menu_option_00.jpg/>";

		If ($script <> "intervenants")
		{
			echo "<a href = ".$chemin_scripts."WR_intervenants.php title = \"Les intervenants\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_22.jpg\" title = \"Les intervenants\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_22.jpg\" title = \"Les intervenants\"/>";
		}

		If ($script <> "partenaires")
		{
			echo "<a href = ".$chemin_scripts."WR_partenaires.php title = \"Les partenaires\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_23.jpg\" title = \"Les partenaires\"/></a>";
		}
		else
		{
			echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_23.jpg\" title = \"Les partenaires\"/>";
		}

		echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_menu_option_00.jpg\"/>";
		
		if ($script <> "accueil")
		{
			echo "&nbsp;<a href = WR_accueil.php title = \"Menu Webradio\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_accueil.png\" title = \"Menu Webradio\" height=\"$hauteur\" /></a>";
		}
		else
		{
			echo "&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/WR_accueil.png\" title = \"Menu Webradio\" height=\"$hauteur\" />";
		}
			echo "&nbsp;<a href = \"accueil_cadre.php\" title = \"Retour Collaboratice\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/accueil.png\" title = \"Retour Collaboratice\"/></a>";

	echo "</div>";
?>
