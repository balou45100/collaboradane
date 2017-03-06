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
		?>
	</head>
	<body>
		<CENTER>
<?php
			echo "<h2>Statistiques d'utilisation</h2>";

	$nb_par_page = 25;
	//////////////////////////////////////////////
	//Recupération des données des utilisateurs //
	//////////////////////////////////////////////
	echo "<TABLE width = \"95%\">
		<TR>
			<th>ID&nbsp;&nbsp;</th>
			<th>Nom &nbsp;&nbsp;</th>
			<th>Pr&eacute;nom &nbsp;&nbsp;</th>
			<th>ABO</th>
			<th>ACC</th>
			<th>ALE</th>
			<th>TBO</th>
			<th>CAT</th>
			<th>CON</th>
			<th>COP</th>
			<th>COU</th>
			<th>CRE</th>
			<th>DEV</th>
			<th>DOS</th>
			<th>ECL</th>
			<th>FAV</th>
			<th>FGM</th>
			<th>FOR</th>
			<th>GMA</th>
			<th>GOM</th>
			<th>GRO</th>
			<th>GTI</th>
			<th>GUS</th>
			<th>INFO</th>
			<th>PUB</th>
			<th>REC</th>
			<th>REG</th>
			<th>REP</th>
			<th>RES</th>
			<th>RTI</th>
			<th>STA</th>
			<th>TBAL</th>
			<th>TBGA</th>
			<th>TBO</th>
			<th>TBPR</th>
			<th>TBTI</th>
			<th>WRA</th>
			";
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

				$num_results_nb_ABO_perso = extraction_statistiques_modules_ancien("ABO",$res[1],$res[8]);
				$num_results_nb_ACC_perso = extraction_statistiques_modules_ancien("ACC",$res[1],$res[8]);
				$num_results_nb_ALE_perso = extraction_statistiques_modules_ancien("ALE",$res[1],$res[8]);
				$num_results_nb_CAT_perso = extraction_statistiques_modules_ancien("CAT",$res[1],$res[8]);
				$num_results_nb_CON_perso = extraction_statistiques_modules_ancien("CON",$res[1],$res[8]);
				$num_results_nb_COP_perso = extraction_statistiques_modules_ancien("COP",$res[1],$res[8]);
				$num_results_nb_COU_perso = extraction_statistiques_modules_ancien("COU",$res[1],$res[8]);
				$num_results_nb_CRE_perso = extraction_statistiques_modules_ancien("CRE",$res[1],$res[8]);
				$num_results_nb_DEV_perso = extraction_statistiques_modules_ancien("DEV",$res[1],$res[8]);
				$num_results_nb_DOS_perso = extraction_statistiques_modules_ancien("DOS",$res[1],$res[8]);
				$num_results_nb_ECL_perso = extraction_statistiques_modules_ancien("ECL",$res[1],$res[8]);
				$num_results_nb_FAV_perso = extraction_statistiques_modules_ancien("FAV",$res[1],$res[8]);
				$num_results_nb_FGM_perso = extraction_statistiques_modules_ancien("FGM",$res[1],$res[8]);
				$num_results_nb_FOR_perso = extraction_statistiques_modules_ancien("FOR",$res[1],$res[8]);
				$num_results_nb_GMA_perso = extraction_statistiques_modules_ancien("GMA",$res[1],$res[8]);
				$num_results_nb_GOM_perso = extraction_statistiques_modules_ancien("GOM",$res[1],$res[8]);
				$num_results_nb_GRO_perso = extraction_statistiques_modules_ancien("GRO",$res[1],$res[8]);
				$num_results_nb_GTI_perso = extraction_statistiques_modules_ancien("GTI",$res[1],$res[8]);
				$num_results_nb_GUS_perso = extraction_statistiques_modules_ancien("GUS",$res[1],$res[8]);
				$num_results_nb_INF_perso = extraction_statistiques_modules_ancien("INF",$res[1],$res[8]);
				$num_results_nb_PUB_perso = extraction_statistiques_modules_ancien("PUB",$res[1],$res[8]);
				$num_results_nb_REC_perso = extraction_statistiques_modules_ancien("REC",$res[1],$res[8]);
				$num_results_nb_REG_perso = extraction_statistiques_modules_ancien("REG",$res[1],$res[8]);
				$num_results_nb_REP_perso = extraction_statistiques_modules_ancien("REP",$res[1],$res[8]);
				$num_results_nb_RES_perso = extraction_statistiques_modules_ancien("RES",$res[1],$res[8]);
				$num_results_nb_RTI_perso = extraction_statistiques_modules_ancien("RTI",$res[1],$res[8]);
				$num_results_nb_STA_perso = extraction_statistiques_modules_ancien("STA",$res[1],$res[8]);
				$num_results_nb_TAC_perso = extraction_statistiques_modules_ancien("TAC",$res[1],$res[8]);
				$num_results_nb_TBAL_perso = extraction_statistiques_modules_ancien("TBAL",$res[1],$res[8]);
				$num_results_nb_TBGA_perso = extraction_statistiques_modules_ancien("TBGA",$res[1],$res[8]);
				$num_results_nb_TBO_perso = extraction_statistiques_modules_ancien("TBO",$res[1],$res[8]);
				$num_results_nb_TBPR_perso = extraction_statistiques_modules_ancien("TBPR",$res[1],$res[8]);
				$num_results_nb_TBTI_perso = extraction_statistiques_modules_ancien("TBTI",$res[1],$res[8]);
				$num_results_nb_WRA_perso = extraction_statistiques_modules_ancien("WRA",$res[1],$res[8]);
				//$num_results_nb_SOM_perso = extraction_statistiques_modules_ancien("SOM",$res[1],$res[8]);

				////////////////////////////////////////////////////////////
				//Fin zone de toutes les requètes utilisé partie personnel//
				////////////////////////////////////////////////////////////

				//On crée une npuvelle fiche et enregistre les résultats
				
				$requete_enreg = "INSERT INTO statistiques_utilisation
				(
					`idUtilisateur`,
					`ABO`,
					`ACC`,
					`ALE`,
					`CAT`,
					`CON`,
					`COP`,
					`COU`,
					`CRE`,
					`DEV`,
					`DOS`,
					`ECL`,
					`FAV`,
					`FGM`,
					`FORM`,
					`GMA`,
					`GOM`,
					`GRO`,
					`GTI`,
					`GUS`,
					`INF`,
					`PUB`,
					`REC`,
					`REG`,
					`REP`,
					`RES`,
					`RTI`,
					`STA`,
					`TAC`,
					`TBAL`,
					`TBGA`,
					`TBO`,
					`TBTI`,
					`TBPR`,
					`WRA`
				)
				VALUES
				(
					'".$res[8]."',
					'".$num_results_nb_ABO_perso."',
					'".$num_results_nb_ACC_perso."',
					'".$num_results_nb_ALE_perso."',
					'".$num_results_nb_CAT_perso."',
					'".$num_results_nb_CON_perso."',
					'".$num_results_nb_COP_perso."',
					'".$num_results_nb_COU_perso."',
					'".$num_results_nb_CRE_perso."',
					'".$num_results_nb_DEV_perso."',
					'".$num_results_nb_DOS_perso."',
					'".$num_results_nb_ECL_perso."',
					'".$num_results_nb_FAV_perso."',
					'".$num_results_nb_FGM_perso."',
					'".$num_results_nb_FOR_perso."',
					'".$num_results_nb_GMA_perso."',
					'".$num_results_nb_GOM_perso."',
					'".$num_results_nb_GRO_perso."',
					'".$num_results_nb_GTI_perso."',
					'".$num_results_nb_GUS_perso."',
					'".$num_results_nb_INF_perso."',
					'".$num_results_nb_PUB_perso."',
					'".$num_results_nb_REC_perso."',
					'".$num_results_nb_REG_perso."',
					'".$num_results_nb_REP_perso."',
					'".$num_results_nb_RES_perso."',
					'".$num_results_nb_RTI_perso."',
					'".$num_results_nb_STA_perso."',
					'".$num_results_nb_TAC_perso."',
					'".$num_results_nb_TBAL_perso."',
					'".$num_results_nb_TBGA_perso."',
					'".$num_results_nb_TBO_perso."',
					'".$num_results_nb_TBTI_perso."',
					'".$num_results_nb_TBPR_perso."',
					'".$num_results_nb_WRA_perso."'
				);";
				
				//echo "<br />$requete_enreg";
				
				$result_enreg = mysql_query($requete_enreg);
				echo "<TR>";
					echo "<TD>";
						if (!$result_enreg)
						{
							echo "Erreur";
						}
						else
						{
							echo strtoupper($res[8]); //ID;
						}
					echo "</TD>";
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
						echo $num_results_nb_FOR_perso;
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
				echo "</TR>";
			}
		} //Fin boucle

	echo "</TABLE>";
			mysql_close();
?>
		</div>
	</BODY>
</HTML>
