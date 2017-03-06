<?php
	//echo "<br />idreunion : $idreunion";
	
	// On récupère les informations de la réunion à modifier
	$requete1 = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM om_reunion AS REUN, om_responsables AS RES, om_enveloppe_budgetaire AS ENV, om_centre_couts AS COUT WHERE REUN.id_responsable = RES.id_responsable AND REUN.ref_enveloppe_budgetaire = ENV.ref_enveloppe_budgetaire AND REUN.ref_centre_cout = COUT.ref_centre_cout AND idreunion = '".$idreunion."'";
	
	//echo "<br />$requete";
	
	$resultat1 = mysql_query($requete1);
	$ligne1 = mysql_fetch_object($resultat1);
	$intitule_reunion = $ligne1->intitule_reunion;
	$ref_enveloppe_budgetaire_origine = $ligne1->ref_enveloppe_budgetaire;
	$intitule_enveloppe_budgetaire_origine = $ligne1->intitule_enveloppe_budgetaire;
	
	/*
	echo "<br />ref_enveloppe_budgetaire_origine : $ref_enveloppe_budgetaire_origine";
	echo "<br />intitule_enveloppe_budgetaire_origine : $intitule_enveloppe_budgetaire_origine";
	*/
	echo "<form method=\"post\" action=\"om_affichage_reunion.php\">";
	echo "<h2>Modification de la r&eacute;union $idreunion</h2>";
		echo "<table>";
			echo "<tr>
				<td>Intitul&eacute;&nbsp;:</td>
				<td><input type=\"text\" id=\"intitule\"  name=\"intitule\" value=\"$ligne1->intitule_reunion\" size = \"50\"></td>
			</tr>
			<tr>
				<td>Description&nbsp;:</td>
				<td><TEXTAREA NAME=\"description\" ROWS=\"4\" COLS=\"50\">$ligne1->description</TEXTAREA></td>
			</tr>
			<tr>
				<td>Date du d&eacute;but&nbsp;:&nbsp;<!--p><br />(format: JJ-MM-AAAA)</p--></td>
				<td>
					<input type=\"text\" id=\"datedebut\"  name=\"datedebut\" value=\"$ligne1->Date_D\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datedebut&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
				echo "</td>
			</tr>
			<tr>
				<td>Heure du d&eacute;but&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
				<td><input type=\"text\" name=\"heuredebut\" value=\"$ligne1->Heure_D\" size=\"10\"></td>
			</tr>
			<tr>
				<td>Date de fin&nbsp;:&nbsp;<!--p><br>(format: JJ-MM-AAAA)</p--></td>
				<td>
					<input type=\"text\" id=\"datefin\"  name=\"datefin\" value=\"$ligne1->Date_F\">";
					echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=datefin&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
				echo "</td>
			</tr>
			<tr>
				<td>Heure de fin&nbsp;(HH:MM)&nbsp;:&nbsp;</td>
				<td><input type=\"text\" name=\"heurefin\" value=\"$ligne1->Heure_F\" size=\"10\"></td>
			</tr>
			<!--tr>
				<td>Intitul&eacute; de la mission&nbsp;:</td>
				<td><TEXTAREA NAME=\"description\" ROWS=\"5\" COLS=\"38\"></TEXTAREA></td>
			</tr-->";

			echo "<tr>";
				//Choix de l'ann&eacute;e
				$anne_scolaire_a_afficher_par_defaut = $annee_en_cours+1;
				echo "<td>Ann&eacute;e budg&eacute;taire&nbsp;:&nbsp;</td>";
				echo "<td><select size=\"1\" name=\"annee\">";
				echo "<option selected value=\"$ligne1->annee\">$ligne1->annee</option>";
					for($annee = $annee_en_cours; $annee >1999; $annee-- )
					{
						echo "<option value=\"$annee\">$annee</option>";
					}
				echo "</select></td>";
			echo "</tr>";

			echo "<tr>";
				//Choix du responsable
				$requete4="SELECT * FROM om_responsables ORDER BY nom_responsable ASC";
				$resultat4=mysql_query($requete4);
				$num_rows = mysql_num_rows($resultat4);

				echo "<td>Responsable&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"id_responsable\">";

				if (mysql_num_rows($resultat4))
				{
					echo "<option selected value=\"$ligne1->id_responsable\">$ligne1->nom_responsable, $ligne1->prenom_responsable</option>";
					while ($ligne4=mysql_fetch_object($resultat4))
					{
						$id_responsable=$ligne4->id_responsable;
						$nom_responsable=$ligne4->nom_responsable;
						$prenom_responsable=$ligne4->prenom_responsable;
						echo "<option value=\"$id_responsable\">$nom_responsable, $prenom_responsable</option>";
					}
				}
				echo "</select></td>";
			echo "</tr>";

			echo "<tr>";
				//Choix de l'enveloppe budgetaire
				$requete2 = "SELECT * FROM om_enveloppe_budgetaire ORDER BY intitule_enveloppe_budgetaire ASC";
				$resultat2 = mysql_query($requete2);
				$num_rows = mysql_num_rows($resultat2);

				echo "<td>Enveloppe budg&eacute;taire&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"RefEnvBudg\">";

				if (mysql_num_rows($resultat2))
				{
					echo "<option selected value=\"$ligne1->ref_enveloppe_budgetaire\">$ligne1->ref_enveloppe_budgetaire - $ligne1->intitule_enveloppe_budgetaire</option>";
					while ($ligne2=mysql_fetch_object($resultat2))
					{
						$ref_enveloppe_budgetaire=$ligne2->ref_enveloppe_budgetaire;
						$intitule_enveloppe_budgetaire=$ligne2->intitule_enveloppe_budgetaire;
						echo "<option value=\"$ref_enveloppe_budgetaire\">$ref_enveloppe_budgetaire - $intitule_enveloppe_budgetaire</option>";
					}
				}
				echo "</select></td>"; 
			echo "</tr>";

			echo "<tr>";
				//Choix du centre de coût
				$requete3 = "SELECT * FROM om_centre_couts ORDER BY ref_centre_cout ASC";
				$resultat3 = mysql_query($requete3);
				$num_rows = mysql_num_rows($resultat3);

				echo "<td>Centre co&ucirc;t Chorus&nbsp;:&nbsp;</td>";
					echo "<td><select size=\"1\" name=\"ref_centre_cout\">";

				if (mysql_num_rows($resultat3))
				{
					echo "<option selected value=\"$ligne1->ref_centre_cout\">$ligne1->ref_centre_cout - $ligne1->intitule_centre_cout</option>";
					while ($ligne3=mysql_fetch_object($resultat3))
					{
						$ref_centre_cout=$ligne3->ref_centre_cout;
						$intitule_centre_cout=$ligne3->intitule_centre_cout;
						echo "<option value=\"$ref_centre_cout\">$ref_centre_cout - $intitule_centre_cout</option>";
					}
				}
				echo "</select></td>"; 
			echo "</tr>";
		echo "</table>";

		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"om_affichage_reunion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;<INPUT name = \Suivant\" border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer la r&eacute;union</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";

		echo "<input type=hidden name=\"a_faire\" value=\"maj_reunion\"/>";
		echo "<input type=hidden name=\"action\" value=\"O\"/>";
		echo "<input type=hidden name=\"idreunion\" value=\"$idreunion\"/>";
	echo "</form>";
?>
