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
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_statistiques.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");
	//Vérification des droits pour pouvoir afficher les détails
	$droit_detail = verif_droits("statistiques_detail");
	echo "<h1>Statistiques d'utilisation</h1>";
	if ($droit_detail == 3)
	{
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td align = \"center\">";
						echo "<a href=\"statistiques.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/statistiques.png\" title = \"G&eacute;rer les cat&eacute;gories\" align=\"top\" border=\"0\"></a>";
						echo "<br />&nbsp;Statistiques&nbsp;";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
	}

?>

	</head>
	<body>
		<CENTER>
<?php
			//echo "<h2>Statistiques d'utilisation</h2>";

	$nb_par_page = 25;
	//////////////////////////////////////////////
	//Recupération des données des utilisateurs //
	//////////////////////////////////////////////
	echo "<TABLE width = \"95%\">
		<TR>";
			include ("statistiques_detail_entete_liste.inc.php");
		echo "</TR>";


			$query_individu = "SELECT * FROM util ORDER BY NOM";
			$results = mysql_query($query_individu);
			
		for ($i = 0; $i < $nb_par_page; ++$i)
		{
			$res = mysql_fetch_row($results);
			if ($res[1] <>"")
			{
				///////////////////////////////////////////////
				//Nombre d'accès perso aux différents modules//
				///////////////////////////////////////////////

				$num_results_nb_ABO_perso = extraction_statistiques_modules("ABO",$res[1],$res[8]);
				$num_results_nb_ACC_perso = extraction_statistiques_modules("ACC",$res[1],$res[8]);
				$num_results_nb_ALE_perso = extraction_statistiques_modules("ALE",$res[1],$res[8]);
				$num_results_nb_CAT_perso = extraction_statistiques_modules("CAT",$res[1],$res[8]);
				$num_results_nb_CON_perso = extraction_statistiques_modules("CON",$res[1],$res[8]);
				$num_results_nb_CONF_perso = extraction_statistiques_modules("CONF",$res[1],$res[8]);
				$num_results_nb_COP_perso = extraction_statistiques_modules("COP",$res[1],$res[8]);
				$num_results_nb_COU_perso = extraction_statistiques_modules("COU",$res[1],$res[8]);
				$num_results_nb_CRE_perso = extraction_statistiques_modules("CRE",$res[1],$res[8]);
				$num_results_nb_DEV_perso = extraction_statistiques_modules("DEV",$res[1],$res[8]);
				$num_results_nb_DOS_perso = extraction_statistiques_modules("DOS",$res[1],$res[8]);
				$num_results_nb_ECL_perso = extraction_statistiques_modules("ECL",$res[1],$res[8]);
				$num_results_nb_FAV_perso = extraction_statistiques_modules("FAV",$res[1],$res[8]);
				$num_results_nb_FGM_perso = extraction_statistiques_modules("FGM",$res[1],$res[8]);
				$num_results_nb_FORM_perso = extraction_statistiques_modules("FORM",$res[1],$res[8]);
				$num_results_nb_GMA_perso = extraction_statistiques_modules("GMA",$res[1],$res[8]);
				$num_results_nb_GOM_perso = extraction_statistiques_modules("GOM",$res[1],$res[8]);
				$num_results_nb_GRO_perso = extraction_statistiques_modules("GRO",$res[1],$res[8]);
				$num_results_nb_GTI_perso = extraction_statistiques_modules("GTI",$res[1],$res[8]);
				$num_results_nb_GUS_perso = extraction_statistiques_modules("GUS",$res[1],$res[8]);
				$num_results_nb_INF_perso = extraction_statistiques_modules("INF",$res[1],$res[8]);
				$num_results_nb_PUB_perso = extraction_statistiques_modules("PUB",$res[1],$res[8]);
				$num_results_nb_REC_perso = extraction_statistiques_modules("REC",$res[1],$res[8]);
				$num_results_nb_REG_perso = extraction_statistiques_modules("REG",$res[1],$res[8]);
				$num_results_nb_REP_perso = extraction_statistiques_modules("REP",$res[1],$res[8]);
				$num_results_nb_RES_perso = extraction_statistiques_modules("RES",$res[1],$res[8]);
				$num_results_nb_RTI_perso = extraction_statistiques_modules("RTI",$res[1],$res[8]);
				$num_results_nb_STA_perso = extraction_statistiques_modules("STA",$res[1],$res[8]);
				$num_results_nb_TAC_perso = extraction_statistiques_modules("TAC",$res[1],$res[8]);
				$num_results_nb_TBAL_perso = extraction_statistiques_modules("TBAL",$res[1],$res[8]);
				$num_results_nb_TBGA_perso = extraction_statistiques_modules("TBGA",$res[1],$res[8]);
				$num_results_nb_TBO_perso = extraction_statistiques_modules("TBO",$res[1],$res[8]);
				$num_results_nb_TBPR_perso = extraction_statistiques_modules("TBPR",$res[1],$res[8]);
				$num_results_nb_TBTI_perso = extraction_statistiques_modules("TBTI",$res[1],$res[8]);
				$num_results_nb_WRA_perso = extraction_statistiques_modules("WRA",$res[1],$res[8]);
				//$num_results_nb_SOM_perso = extraction_statistiques_modules("SOM",$res[1],$res[8]);

				////////////////////////////////////////////////////////////
				//Fin zone de toutes les requètes utilisé partie personnel//
				////////////////////////////////////////////////////////////
				if ($i == 10 OR $i == 20)
				{
					include ("statistiques_detail_entete_liste.inc.php");
				}
				if ($res[15] == "N") //l'utilisateur n'est plus actif
				{
					echo "<TR class = \"acheve\">";
				}
				else
				{
					echo "<TR>";
				}
/*
					echo "<TD>";
						echo strtoupper($res[8]); //ID;
					echo "</TD>";
*/
					echo "<TD>";
						echo strtoupper($res[1]); //Nom
					echo "</TD>";
					echo "<TD>";
						echo str_replace("*", " ",$res[0]); //Prénom
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_ABO_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_ACC_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_ALE_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_CAT_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_CON_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_COP_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_COU_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_CRE_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_DEV_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_DOS_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_ECL_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_FAV_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_FGM_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_FORM_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_GMA_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_GOM_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_GRO_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_GTI_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_GUS_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_INF_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_PUB_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_REC_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_REG_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_REP_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_RES_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_RTI_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_STA_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_TAC_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_TBAL_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_TBGA_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_TBO_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_TBPR_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_TBTI_perso;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $num_results_nb_WRA_perso;
					echo "</TD>";
					echo "<TD align=\"center\">";
						echo $num_results_nb_CONF_perso;
					echo "</TD>";
				echo "</TR>";
			}
		} //Fin boucle

	echo "</TABLE>";
			mysql_close();
?>
		</div>
	</BODY>
</HTML>
