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
  		<title>CARDIE - Visites</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	
		//include("../biblio/ticket.css");
		include ("../biblio/cardie_config.php");
		include ("../biblio/init.php");

	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";

	$util_connecte = $_SESSION['nom'];
	$res=mysql_query ("SELECT DISTINCT id_categ, intitule_categ FROM categorie_commune ORDER BY intitule_categ");
	$nbr = mysql_num_rows($res);
	//echo "<br />nbr : $nbr";
	echo "<form action = \"cardie_gestion_accompagnateurs.php\" target = \"body\" METHOD = \"GET\">";

		echo "<table style = \"border: 0\">";
			echo "<tr>";
				echo "<td>";

					//Choix de l'ann&eacute;e
					$anne_scolaire_a_afficher_par_defaut = $annee_en_cours+1;
					echo "&nbsp;&nbsp;Ann&eacute;e&nbsp;:&nbsp;<select size=\"1\" name=\"annee_a_filtrer\">
					<option selected value=\"$annee_en_cours\">$annee_en_cours-$anne_scolaire_a_afficher_par_defaut</option>
						<option value=\"%\">toutes</option>";
						for($annee = $annee_en_cours-1; $annee >2011; $annee-- )
						{
							$annee2=$annee+1;
							echo "<option value=\"$annee\">$annee-$annee2</option>";
						}
					echo "</select>";
					echo "&nbsp;&nbsp;";


					echo "&nbsp;<b>Accompagnateur/trice&nbsp;:&nbsp;</b>";
					//On récupère les accompagnateurs
					$requete_accompagnateurs = "SELECT DISTINCT PRT.nom, PRT.prenom, PRT.id_pers_ress 
						FROM personnes_ressources_tice AS PRT, 
							fonctions_des_personnes_ressources AS FPR
						WHERE PRT.id_pers_ress = FPR.id_pers_ress
							AND FPR.fonction = 'accompagnateur/trice CARDIE'
						ORDER BY PRT.nom";
					
					//echo "<br />$requete_accompagnateurs";
					
					$resultat_acc = mysql_query($requete_accompagnateurs);
					if(!$resultat_acc)
					{
						echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requ&egrave;te
					
					echo "<select  size=\"1\" name = \"id_accompagnateur\">";
						echo "<option value=\"T\" class = \"bleu\">TOU-TE-S</option>";
							while ($ligne = mysql_fetch_object($resultat_acc))
							{
								$nom = $ligne->nom;
								$prenom = $ligne->prenom;
								$id_pers_ress_a_transmettre = $ligne->id_pers_ress;
								
								echo "<option value=\"$id_pers_ress_a_transmettre\" class = \"bleu\">".$nom.", ".$prenom."</option>";
							}
					echo "</select>";
/*
				echo "</td>";
				echo "<td>";

					echo "&nbsp;<b>Type d'accompagnement&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"type_accompagnement\">";
							echo "<option value=\"T\" class = \"bleu\">tous types</option>";
							echo "<option value=\"NON_DEFINI\">non d&eacute;fini</option>";
							echo "<option value=\"INSITU\">in situ</option>";
							echo "<option value=\"A_DISTANCE\" class = \"bleu\">&agrave; distance</option>";
							echo "<option value=\"RECHERCHE\">par la recherche</option>";
							echo "<option value=\"GROUPE_DEVELOPPEMENT\">par groupe de d&eacute;veloppement</option>";
							echo "<option value=\"EXPERITHEQUE\" class = \"bleu\">dans exp&eacute;rith&egrave;que</option>";
							echo "<option value=\"PARTENARIAL\" class = \"bleu\">partenarial</option>";
						echo "</select>";
*/
						echo "&nbsp;<input type = \"submit\" value = \"Hop !\">";
						echo "<input type = \"hidden\" value = \"entete_accompagnateurs\" name = \"origine_appel\">";
						//echo "<input type = \"hidden\" value = \"Non\" name = \"categorie_commune\">";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";

?>
		</div>
	</body>
</html>

