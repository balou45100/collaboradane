<?php
	echo "<h2>Modification de la visite $id_visite</h2>";
	
	//On récupère la visite
	//$id_visite = $_GET['id_visite'];
	//echo "<br />id_visite : $id_visite";
	
	$requete_visite = "SELECT * FROM cardie_visite AS CV
		WHERE CV.ID_VISITE = '".$id_visite."';";
			
	//echo "<br />$requete_visite";
	
	$resultat_requete_visite = mysql_query($requete_visite);
	$num_rows = mysql_num_rows($resultat_requete_visite);
	
	//echo "<br />num_rows : $num_rows";
	
	if (mysql_num_rows($resultat_requete_visite))
	{
		$ligne=mysql_fetch_object($resultat_requete_visite);
		$date_visite=$ligne->DATE_VISITE;
		$horaire_visite = $ligne->HORAIRE_VISITE;
		$remarques = $ligne->REMARQUES;
		
		//On découpe l'horaire
		$horaire = explode("-",$horaire_visite);
		$horaire_debut = $horaire[0];
		$horaire_fin = $horaire[1];
		/*
		echo "<br />date_visite : $date_visite";
		echo "<br />horaire_debut : $horaire_debut";
		echo "<br />horaire_fin : $horaire_fin";
		*/

		//On affiche le projet
		
		$requete_etab = "SELECT * FROM 
				cardie_visite AS CV,
				cardie_projet AS CP,
				etablissements AS ETAB 
			WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
				AND CP.RNE = ETAB.RNE
				AND CV.ID_VISITE = '".$id_visite."'";
			
		//echo "<br />$requete_etab";
		
		$resultat = mysql_query($requete_etab);
		$ligne = mysql_fetch_object($resultat);
		
		$id_projet = $ligne->NUM_PROJET;
		$intitule_projet = $ligne->INTITULE;
		$mise_en_route = $ligne->ANNEE;
		$rne = $ligne->RNE;
		$etat = $ligne->ACTIF;
		$decision_commission = $ligne->DECISION_COMMISSION;
		$type_accompagnement = $ligne->TYPE_ACCOMPAGNEMENT;
		$type_etab = $ligne->TYPE;
		$nom_etab = $ligne->NOM;
		$ville_etab = $ligne->VILLE;
		
		echo "<h2>Informations sur le projet</h2>";
		echo "<table width=\"85%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">ID&nbsp;:&nbsp;</td>";
				echo "<td>$id_projet</td>";
				echo "<td class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</td>";
				echo "<td>$intitule_projet</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Structure&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"2\">$type_etab&nbsp;$nom_etab,&nbsp;$ville_etab</td>";
			echo "</tr>";
		echo "</table>";
	
		echo "<h2>Modifier la date</h2>";
		echo "<form action=\"cardie_gestion_visites.php\" method=\"POST\">";
			
			echo "<table width=\"85%\">";
				echo "<caption></caption>";
				echo "<tr>";
					echo "<td class = \"etiquette\">Date&nbsp;:&nbsp;</td>";
					
					echo "<td><input type=\"date\" id=\"date_visite\" name=\"date_visite\" value = \"$date_visite\">";
						echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_visite&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
					echo "</td>";
					echo "<td class = \"etiquette\">Horaire de d&eacute;but&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select  size=\"1\" name = \"horaire_debut\">";
							echo "<option selected value=\"$horaire_debut\" class = \"bleu\">$horaire_debut</option>";
							echo "<option value=\"09H00\" class = \"bleu\">09H00</option>";
							echo "<option value=\"09H30\" class = \"bleu\">09H30</option>";
							echo "<option value=\"10H00\" class = \"bleu\">10H00</option>";
							echo "<option value=\"10H30\" class = \"bleu\">10H30</option>";
							echo "<option value=\"11H00\" class = \"bleu\">11H00</option>";
							echo "<option value=\"11H30\" class = \"bleu\">11H30</option>";
							echo "<option value=\"12H00\" class = \"bleu\">12H00</option>";
							echo "<option value=\"12H30\" class = \"bleu\">12H30</option>";
							echo "<option value=\"13H00\" class = \"bleu\">13H00</option>";
							echo "<option value=\"13H30\" class = \"bleu\">13H30</option>";
							echo "<option value=\"14H00\" class = \"bleu\">14H00</option>";
							echo "<option value=\"14H30\" class = \"bleu\">14H30</option>";
							echo "<option value=\"15H00\" class = \"bleu\">15H00</option>";
							echo "<option value=\"15H30\" class = \"bleu\">15H30</option>";
							echo "<option value=\"16H00\" class = \"bleu\">16H00</option>";
							echo "<option value=\"16H30\" class = \"bleu\">16H30</option>";
							echo "<option value=\"17H00\" class = \"bleu\">17H00</option>";
							echo "<option value=\"17H30\" class = \"bleu\">17H30</option>";
							echo "<option value=\"18H00\" class = \"bleu\">18H00</option>";
						echo "</select>";
					echo "</td>";
					echo "<td class = \"etiquette\">Horaire de fin&nbsp;:&nbsp;</td>";
					echo "<td>";
						echo "<select  size=\"1\" name = \"horaire_fin\">";
							echo "<option selected value=\"$horaire_fin\" class = \"bleu\">$horaire_fin</option>";
							echo "<option value=\"10H00\" class = \"bleu\">10H00</option>";
							echo "<option value=\"10H30\" class = \"bleu\">10H30</option>";
							echo "<option value=\"11H00\" class = \"bleu\">11H00</option>";
							echo "<option value=\"11H30\" class = \"bleu\">11H30</option>";
							echo "<option value=\"12H00\" class = \"bleu\">12H00</option>";
							echo "<option value=\"12H30\" class = \"bleu\">12H30</option>";
							echo "<option value=\"13H00\" class = \"bleu\">13H00</option>";
							echo "<option value=\"13H30\" class = \"bleu\">13H30</option>";
							echo "<option value=\"14H00\" class = \"bleu\">14H00</option>";
							echo "<option value=\"14H30\" class = \"bleu\">14H30</option>";
							echo "<option value=\"15H00\" class = \"bleu\">15H00</option>";
							echo "<option value=\"15H30\" class = \"bleu\">15H30</option>";
							echo "<option value=\"16H00\" class = \"bleu\">16H00</option>";
							echo "<option value=\"16H30\" class = \"bleu\">16H30</option>";
							echo "<option value=\"17H00\" class = \"bleu\">17H00</option>";
							echo "<option value=\"17H30\" class = \"bleu\">17H30</option>";
							echo "<option value=\"18H00\" class = \"bleu\">18H00</option>";
							echo "<option value=\"18H30\" class = \"bleu\">18H30</option>";
							echo "<option value=\"19H00\" class = \"bleu\">19H00</option>";
							echo "<option value=\"19H30\" class = \"bleu\">19H30</option>";
							echo "<option value=\"20H00\" class = \"bleu\">20H00</option>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";

		echo "<table width=\"85%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">";
					echo "<textarea name=\"remarques\" rows=\"6\" cols=\"75\">$remarques</textarea>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		

		//Boutons retour et enregistrement
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_visites.php?tri=".$tri."&amp;sense_tri=".$sense_tri."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Valider les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_modif_visite\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_visite\" NAME = \"id_visite\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">";
		echo "</form>";
	}
?>
