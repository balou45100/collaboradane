<?php
	echo "<h2>Ajout d'une visite</h2>";
	
	//On vérifie si on appel le script à partir du tableau des projets ou du scripts des visites
	$origine_appel = $_GET['origine_appel'];
	
	//echo "<br />origine_appel : $origine_appel";

	//On affiche le projet
	
	$requete_etab = "SELECT * FROM 
			cardie_projet AS CP, 
			etablissements AS ETAB 
		WHERE CP.RNE = ETAB.RNE AND CP.NUM_PROJET = '".$id_projet."'";
		
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
	
	//Il faut afficher les dates déjà saisie et leurs états
	$requete_visites = "SELECT CV.FK_NUM_PROJET, CV.DATE_VISITE, CV.HORAIRE_VISITE, CV.ETAT FROM 
			cardie_visite AS CV, 
			cardie_projet AS CP 
		WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
			AND CP.NUM_PROJET = '".$id_projet."'
		ORDER BY CV.DATE_VISITE";
		
	//echo "<br />$requete_visites";
	
	$resultat_requete_visites = mysql_query($requete_visites);
	
	$nb_visites = mysql_num_rows($resultat_requete_visites);
	$compteur = 0; //On va numéroter les visites en fonction des dates
	if ($nb_visites > 0)
	{
		echo "<h2>Les visites programm&eacute;es</h2>";
		echo "<table width=\"85%\">";
			echo "<th>No de visite</th>";
			echo "<th>Date de la visite</th>";
			echo "<th>Horaire de la visite</th>";
			echo "<th>&Eacute;tat</th>";
			while ($ligne_visite = mysql_fetch_object($resultat_requete_visites))
			{
				$compteur++;
				$date_visite = $ligne_visite->DATE_VISITE;
				$horaire_visite = $ligne_visite->HORAIRE_VISITE;
				$etat_visite = $ligne_visite->ETAT;
				
						echo "<tr>";
							echo "<td class = \"etiquette\">Visite $compteur&nbsp;:&nbsp;</td>";
							echo "<td>$date_visite</td>";
							echo "<td>$horaire_visite</td>";
							echo "<td>".recup_intitule_etat_visite_cardie($etat_visite)."</td>";
						echo "</tr>";

				//echo "<br />$date_visite (".recup_intitule_etat_visite_cardie($etat_visite).")";
			}
		echo "</table>";

	}
	else
	{
		echo "<h2>Pas de visites pour ce projet</h2>";
	}
	//On afiche le formulaire pour la saisie d'une date
	echo "<h2>Saisir une date</h2>";
	echo "<form action=\"cardie_gestion_projets.php\" method=\"post\">";
		
		echo "<table width=\"85%\">";
			echo "<caption></caption>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Date&nbsp;:&nbsp;</td>";
				
				echo "<td><input type=\"date\" id=\"date_visite\" name=\"date_visite\" required />";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_visite&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
				echo "</td>";
				echo "<td class = \"etiquette\">Horaire de d&eacute;but&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select  size=\"1\" name = \"horaire_debut\">";
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
		echo "</table>";
		echo "<table width=\"85%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Remarques&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"5\">";
					echo "<textarea name=\"remarques\" rows=\"6\" cols=\"75\"></textarea>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		echo "<table width=\"85%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Transmission directe aux gestionnaires CARDIE pour demande d'&eacute;tablissement d'OM&nbsp;:&nbsp;</td>";
				echo "<td>";
					echo "<select  size=\"1\" name = \"avancer\">";
						echo "<option value=\"N\" class = \"bleu\">NON (la visite sera enregistr&eacute;e comme brouillon et pourra &ecirc;tre modifi&eacute;e ult&eacute;rieurement)</option>";
						echo "<option value=\"O\" class = \"bleu\">OUI (la visite sera transmise directement aux gestionnaires CARDIE et ne pourra plus &ecirc;tre modifi&eacute;e)</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
			//Boutons retour et enregistrement
			echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"cardie_gestion_projets.php?tri=".$tri."&amp;sense_tri=".$sense_tri."&amp;mes_projets=".$mes_projets."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour<br />sans enregistrer</span><br />";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;<INPUT border=0 height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\"  src=\"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer le projet\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Valider<br />le formulaire</span><br />";
					echo "</td>";
					echo "<td>";
						//echo "<a href = \"cardie_gestion_projets.php?action=O&amp;mode_affichage=".$mode_affichage."&amp;tri=".$tri."&amp;sense_tri=".$sense_tri."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/cardie_avancer.png\" ALT = \"Enregistrer et avancer\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Avancer<br />aux gestionnaires CARDIE</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

		echo "<INPUT TYPE = \"hidden\" VALUE = \"$id_projet\" NAME = \"id_projet\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"enreg_visite\" NAME = \"a_faire\">";
		echo "<INPUT TYPE = \"hidden\" VALUE = \"$mes_projets\" NAME = \"mes_projets\">";
	echo "</form>";

?>
