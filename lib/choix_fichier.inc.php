<?php
	//Script qui permet de faire un choix de fichier à déposer sur le serveur
	/*
	echo "<h2>choix_fichier.inc.php</h2>";
	echo "<br />module : $module";
	echo "<br />script : $script";
	//echo "<br />id_visite : $id_visite";
	echo "<br />id_evenement : $id_evenement";
	//echo "<br />id_courrier : $id_courrier";
	//echo "<br />type_courrier : $type_courrier";
	//echo "<br />annee_scolaire : $annee_scolaire";
	echo "<br />dossier_om : $dossier_om";
	echo "<br />nom_fichier_a_enregistrer : $nom_fichier";
	echo "<br />nom_fichier_original : $file <br />";
	*/
	header('Content-Type: text/html;charset=UTF-8');
	switch($script)
	{
		case 'consult_ticket' :
			echo "<h2 align = \"center\">S&eacute;lection d'un document &agrave; joindre au ticket suivant&nbsp;:</h2>";
			echo "<TABLE width=\"95%\">";
				echo "<TR>";
					echo "<TD align = \"center\" width=\"10%\">No&nbsp;:&nbsp; <b>$ticket</b></TD>";
					echo "<TD width=\"5%\">cr&eacute;&eacute; par&nbsp:</TD>";
					echo "<TD align = \"center\" width=\"20%\">$creepar</TD>";
					echo "<TD width=\"5%\">cr&eacute;&eacute; le&nbsp:</TD>";
					echo "<TD align = \"center\" width=\"10%\">$creele</TD>";
					echo "<TD width=\"55%\">Intervenants&nbsp;:&nbsp;$intervenants</TD>";

				echo "</TR>";
				  echo "<TR>";
						echo "<TD>Sujet&nbsp;:&nbsp;</TD>";
						echo "<TD colspan=\"3\">$sujet</TD>";
						echo "<TD colspan=\"2\">Structure&nbsp;:&nbsp;";
							echo $etab;
						echo "</TD>";
					echo "</TR>";
					echo "</TR>";
				echo "</TABLE>";  
				echo "<TABLE width=\"95%\">";
					echo "<TR>";
						echo "<TD width=\"10%\">Contact&nbsp;:&nbsp;</TD>";
						echo "<TD width=\"60%\">$contact</TD>";
						echo "<TD width=\"10%\">Type de contact&nbsp;:&nbsp;</TD>";
						echo "<TD width=\"20%\">$typecontact</TD>";
					echo "</TR>";
				echo "</TABLE>";

		break;

		case 'ecl_consult_fiche' :
			//On rechercher l'EPLE à afficher
			include ("../biblio/init.php");
			$query = "SELECT * FROM etablissements WHERE RNE LIKE '".$id_societe."';";
			$res_eple = mysql_query($query);
			$eple = mysql_fetch_row($res_eple);
			//echo "<br>etab : $eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
			switch ($module)
			{
				case 'FOR' :
					echo "<h2 align = \"center\">Sélection d'un document à joindre à la formation suivante&nbsp;:</h2>";
					echo "<TABLE>
						<TR>
							<TD align=\"center\">ID</TD>";
							echo "<TD align=\"center\">Ann&eacute;e scolaire</TD>";
							echo "<TD align=\"center\">Type formation</TD>";
							echo "<TD align=\"center\">RNE</TD>";
							echo "<TD align=\"center\">EPLE</TD>";
						echo "</TR>";
						echo "<TR>";
							echo "<TD align = \"center\">";
								echo $id_formation;
							echo "</TD>";
							echo "<TD align = \"center\">";
								echo $annee;
							echo "</TD>";
							echo "<TD>";
								echo $type;
							echo "</TD>";
							echo "<TD>";
								echo $rne;
							echo "</TD>";
							echo "<TD>";
								echo "$eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
							echo "</TD>";
						echo "</TR>";
					echo "</TABLE>";
				break;

				case 'TBI' :
					echo "<h2 align = \"center\">Sélection d'une enqu&ecirc;te TBI&nbsp;:</h2>";
					echo "<TABLE>";
						echo "<TR>";
							echo "<TD align=\"center\">RNE</TD>";
							echo "<TD align=\"center\">EPLE</TD>";
						echo "<TR>";
							echo "<TD>";
								echo "$id_societe";
							echo "</TD>";echo "<TD>";
								echo "$eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
							echo "</TD>";
						echo "</TR>";
					echo "</TABLE>";
				break;
			}
			//echo "<br>module : $module";

		break;
	  
		case 'formations_gestion' :
			echo "<h2 align = \"center\">Sélection d'un document à joindre à la formation suivante&nbsp;:</h2>";
			//echo "<br>module : $module";
			echo "<TABLE>
				<TR>
					<TD align=\"center\">ID</TD>";
					echo "<TD align=\"center\">Ann&eacute;e scolaire</TD>";
					echo "<TD align=\"center\">Type formation</TD>";
					echo "<TD align=\"center\">RNE</TD>";
					echo "<TD align=\"center\">EPLE</TD>";
				echo "</TR>";
				echo "<TR>";
					echo "<TD align = \"center\">";
						echo $id_formation;
					echo "</TD>";
					echo "<TD align = \"center\">";
						echo $annee;
					echo "</TD>";
					echo "<TD>";
						echo $type;
					echo "</TD>";
					echo "<TD>";
						echo $rne;
					echo "</TD>";
					//On rechercher l'EPLE à afficher
					include ("../biblio/init.php");
					$query = "SELECT * FROM etablissements WHERE RNE LIKE '".$rne."';";
					$res_eple = mysql_query($query);
					$eple = mysql_fetch_row($res_eple);
					echo "<TD>";
						echo "$eple[1]&nbsp;$eple[3],&nbsp;$eple[5]";
					echo "</TD>";
				echo "</TR>";
			echo "</TABLE>";  
		break;

		case 'gc_recherche' :
			echo "<h2 align = \"center\">Sélection d'un document à joindre au courrier suivant&nbsp;:</h2>";

					echo "<table width=\"100%\">";
						echo "<tr class = \"entete_tableau\">";
						echo "<th>ID</th>";
						echo "<th>Type</th>";
						echo "<th>No</th>";
						echo "<th>Ann&eacute;e scolaire</th>";
						echo "<th>Date de cr&eacute;ation</th>";
						echo "<th>Date</th>";
						echo "<th>Exp&eacute;diteur</th>";
						echo "<th>Destinataire</th>";
						echo "<th>Personnes concern&eacute;es</th>";
						echo "<th>Cat&eacute;gorie</th>";
						echo "<th>Description</th>";
						echo "<th>cr&eacute;e par</th>";
						echo "</tr>";

			$requete = "
				SELECT type, Num_enr, date, date_creation, expediteur, destinataire, description, nom, annee_scolaire, cree_par, confidentiel, id_courrier
				FROM courrier, courrier_categorie
				WHERE courrier.categorie=courrier_categorie.numero
					AND id_courrier='".$id_courrier."'";

			//echo "<br>$requete";

			$resultat = mysql_query($requete);

						if (mysql_num_rows($resultat))
						{
							while ($ligne=mysql_fetch_array($resultat))
							{
								$date=strtotime($ligne[2]);
								$datecre=strtotime($ligne[3]);
								$date=date('d/m/Y',$date);						
								$datecre=date('d/m/Y',$datecre);
								echo "<tr class = \"fond_tableau\">";
									echo "<td>$ligne[11]</td>";
									if ($ligne[0] == "entrant")
									{
										echo "<td align = \"center\">E</td>";
									}
									else
									{
										echo "<td align = \"center\">S</td>";
									}
									echo "<td align = \"center\">".$ligne[1]."</td>
									<td align = \"center\">".$ligne[8]."</td>
									<td align = \"center\">".$datecre."</td>
									<td align = \"center\">".$date."</td>
									<td>".$ligne[4]."</td>
									<td>".$ligne[5]."</td>
									<td>";

								$requete2 = "
									SELECT nom, prenom, initiales
									FROM util u, courrier_concerne c
									WHERE u.id_util=c.id_util
										AND type like '".$ligne[0]."'
										AND num_enr = '".$ligne[1]."'
										AND annee_scolaire like '".$ligne[8]."'";
								$resultat2 = mysql_query($requete2);
								while ($ligne2=mysql_fetch_array($resultat2))
								{
									//echo $ligne2[1]." ".$ligne2[0]."<br />";
									echo "$ligne2[2], ";
								}
									echo"</td>";
									echo "<td>".$ligne[7]."</td>";
									echo "<td>".$ligne[6]."</td>";
									//On ajoute les initiales du créateur du courrier
									$initiales = lecture_utilisateur(Initiales,$ligne[9]);
									//$initiales = lecture_utilisateur(NOM,$ligne[9]);
									echo "<td align = \"center\">$initiales</td>";
								echo "</tr>";
							}
						}
						echo "</table>";
		break;

		case 'cardie_gestion_visites' :
			echo "<h2>D&eacute;p&ocirc;t de bilan pour la visite $id_visite ($date_visite_a_afficher, $horaire_visite)</h2>";
		break;

		case 'evenements_accueil' :
			echo "<h2>D&eacute;p&ocirc;t de la liste d'&eacute;margement de l'&eacute;v&eacute;nement $id_evenement</h2>";
		break;
	} //fin switch $script

	echo "<TABLE width=\"95%\">";
	//echo "<br>";
	echo "<form name=\"upload\" enctype=\"multipart/form-data\" method=\"post\" action=\"uploader.inc.php\">";
		echo "<TABLE width=\"70%\" cellpadding=\"3\" cellspacing=\"5\" align = \"center\">";
			echo "<TR class = \"td-bouton\">";
				echo "<TD class = \"etiquette\">Donner un titre au document&nbsp:&nbsp;</TD>";
				echo "<TD class = \"td-1\" ><input type=\"text\" value = \"\" name=\"RessourceIntitule\" SIZE = \"50\"></TD>";
			echo "</TR>";
			echo "<TR class = \"td-bouton\">";
				echo "<TD class = \"etiquette\">Donner des d&eacute;tails au sujet du document<br>(ils permettront de faire des recherches sur ce champ)&nbsp:&nbsp;</TD>
				<TD class = \"td-1\" ><TEXTAREA \" value = \"\" name=\"RessourceDescription\" rows = \"4\" cols = \"50\"></TEXTAREA></TD>";
			echo "</TR>";
			echo "<TR class = \"td-bouton\">";
				echo "<TD class = \"etiquette\">Fichier &agrave; d&eacute;poser (utilisez le bouton parcourir)&nbsp;:&nbsp;</TD>
				<TD class = \"td-1\" ><input type=\"file\" name=\"file\" SIZE = \"40\"></TD>";
			echo "</TR>";
			echo "<TR class = \"td-bouton\">";
				echo "<TD class = \"etiquette\">Valider le d&eacute;p&ocirc;t en cliquant sur le bouton&nbsp;:&nbsp;</TD>
				<TD class = \"td-1\" ><input type=\"submit\" name=\"bouton_submit\" value=\"Joindre le fichier\">";

	switch($script)
	{
		case 'consult_ticket' :
			echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
			<input type=\"hidden\" name=\"idpb\" value=\"$idpb\">
			<input type=\"hidden\" name=\"ticket\" value=\"$ticket\">
			<input type=\"hidden\" name=\"folder\" value=\"$dossier_docs_gestion_tickets\">
			<input type=\"hidden\" name=\"module\" value=\"$module\">
			<input type=\"hidden\" name=\"script\" value=\"$script\">";
		break;
		
		case 'ecl_consult_fiche' :
			switch ($module)
			{
				case 'FOR' :
					echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
					<input type=\"hidden\" name=\"id_societe\" value=\"$id_societe\">
					<input type=\"hidden\" name=\"folder\" value=\"$dossier_docs_formation\">
					<input type=\"hidden\" name=\"ticket\" value=\"$id_formation\">
					<input type=\"hidden\" name=\"module\" value=\"$module\">
					<input type=\"hidden\" name=\"script\" value=\"$script\">";    
				break;
		  
				case 'TBI' :
					echo "<input type=\"hidden\" name=\"id_societe\" value=\"$id_societe\">
					<input type=\"hidden\" name=\"folder\" value=\"$dossier_documents\">
					<input type=\"hidden\" name=\"module\" value=\"$module\">
					<input type=\"hidden\" name=\"script\" value=\"$script\">";
				break;
			}
		break;
	  
		case 'formations_gestion' :
			echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
			<input type=\"hidden\" name=\"id_societe\" value=\"$id_societe\">
			<input type=\"hidden\" name=\"folder\" value=\"$dossier_docs_formation\">
			<input type=\"hidden\" name=\"ticket\" value=\"$id_formation\">
			<input type=\"hidden\" name=\"module\" value=\"$module\">
			<input type=\"hidden\" name=\"script\" value=\"$script\">";  
		break;

		case 'gc_recherche' :
			echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
			<input type=\"hidden\" name=\"ticket\" value=\"$id_courrier\">
			<input type=\"hidden\" name=\"folder\" value=\"$dossier_docs_courriers\">
			<input type=\"hidden\" name=\"module\" value=\"$module\">
			<input type=\"hidden\" name=\"script\" value=\"$script\">";
		break;

		case 'cardie_gestion_visites' :
			echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
			<input type=\"hidden\" name=\"ticket\" value=\"$id_visite\">
			<input type=\"hidden\" name=\"folder\" value=\"$dossier_docs_cardie\">
			<input type=\"hidden\" name=\"module\" value=\"$module\">
			<input type=\"hidden\" name=\"script\" value=\"$script\">";
		break;

		case 'evenements_accueil' :
			echo "<input type=\"hidden\" name=\"action2\" value=\"depot_fichier\">
			<input type=\"hidden\" name=\"ticket\" value=\"$id_evenement\">
			<input type=\"hidden\" name=\"folder\" value=\"$dossier_om\">
			<input type=\"hidden\" name=\"module\" value=\"$module\">
			<input type=\"hidden\" name=\"script\" value=\"$script\">";
		break;
	} //fin switch $script

				echo "</TD>";
			echo "</TR>";
			echo "<TR>";
		echo "</TABLE>";
	echo "</form>"; 
?>
