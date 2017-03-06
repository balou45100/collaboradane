<?php
	include("../biblio/init.php");
	/*
	$query = "SELECT * FROM repertoire WHERE No_societe = '".$id_societe."';";
	$result_consult = mysql_query($query);
	$num_rows = mysql_num_rows($result_consult);
	if (mysql_num_rows($result_consult))
	{
		$ligne=mysql_fetch_object($result_consult);
		$id_societe=$ligne->No_societe;
	*/
	//echo "<BR>id_societe : $id_societe";  
	$query_partenaire_salon = "SELECT * FROM salon_suivi_partenaires WHERE salon_suivi_partenaires.id_societe = '".$id_societe."';";
	$result_partenaire_salon = mysql_query($query_partenaire_salon);
	if(!$result_partenaire_salon)
	{
		echo "<br>Pas de participation financière enregistré pour cette société";
	}
	$num_rows_partenaire_salon = mysql_num_rows($result_partenaire_salon);
	if (mysql_num_rows($result_partenaire_salon))
	{
		$ligne=mysql_fetch_object($result_partenaire_salon);
		$dossier_envoye=$ligne->dossier_envoye;
		$participation_exposition=$ligne->participation_exposition;
		$participation_agora=$ligne->participation_agora;
		$interesse_pour_exposition=$ligne->interesse_pour_exposition;
		$interesse_pour_agora=$ligne->interesse_pour_agora;
		$refus_exposition=$ligne->refus_exposition;
		$refus_agora=$ligne->refus_agora;
		$taille_stand=$ligne->taille_stand;
		$emplacement_exposition=$ligne->emplacement_exposition;
		$logo_sur_affiche=$ligne->logo_sur_affiche;
		$lien_logo=$ligne->lien_logo;
		$intervention_agora=$ligne->intervention_agora;
		$participation_financiere=$ligne->participation_financiere;
		$a_traiter = $ligne->a_traiter;
		$affiche_page_partenaire = $ligne->affiche_page_partenaire;
		$description_pour_salon = $ligne->description_pour_salon;
		$afficher_description_salon = $ligne->afficher_description_salon;
		
		$logo = $dossier_pour_logos.$lien_logo;

		//echo "<BR>participation_financiere : $participation_financiere";
		echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
		echo "<BR>
		<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
			<CAPTION><b>Détails du suivi</b></CAPTION>
			<tr CLASS = \"new\">
				<td width = \"10%\">";
					$checked=Testpourcocher($dossier_envoye);
					echo "Dossier transmis&nbsp;:&nbsp;
				</td>
				<td width = \"20%\">
					<input type=\"checkbox\" name=\"dossier_envoye\" value=\"1\" $checked>&nbsp;
				</td>";
				echo "<td width = \"10%\">";
					$checked=Testpourcocher($a_traiter);
					echo "A traiter&nbsp;:&nbsp;
				</td>
				<td width = \"15%\">
					<input type=\"checkbox\" name=\"a_traiter_salon\" value=\"1\" $checked>
				</td>
				<td width = \"55%\" BGCOLOR = \"#48D1CC\">&nbsp;</td>";
			echo "</tr>";
		echo "</table>";
		echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
			<tr CLASS = \"new\">
				<td width = \"10%\">Exposition&nbsp;:&nbsp;</td>
				<td width = \"45%\">";
					$checked=Testpourcocher($interesse_pour_exposition);
					echo "intéressé-e&nbsp;<input type=\"checkbox\" name=\"interesse_pour_exposition\" value=\"1\" $checked>&nbsp;";
					$checked=Testpourcocher($participation_exposition);
					echo "participe&nbsp;<input type=\"checkbox\" name=\"participation_exposition\" value=\"1\" $checked>&nbsp;";
					$checked=Testpourcocher($refus_exposition);
					echo "refuse&nbsp;<input type=\"checkbox\" name=\"refus_exposition\" value=\"1\" $checked>&nbsp;&nbsp;&nbsp;
				</td>";
					if ($participation_exposition ==1 OR $interesse_pour_exposition ==1)
					{
						echo "<td width = \"45%\">Taille du stand souhait&eacute;e&nbsp:&nbsp;<input type=\"text\" name=\"taille_stand\" value=\"$taille_stand\" size=\"4\">&nbsp;m²
						&nbsp;emplacement attribué&nbsp;:&nbsp;<input type=\"text\" name=\"emplacement_exposition\" value=\"$emplacement_exposition\" size=\"4\">";
						echo "</td>";
					}
					else
					{
						echo "<td width = \"45%\" BGCOLOR = \"#48D1CC\">&nbsp;</td>";
					}
			echo "</tr>
			<tr CLASS = \"new\">
				<td width = \"10%\">Agora&nbsp;:&nbsp;</td>
				<td width = \"45%\">";
					$checked=Testpourcocher($interesse_pour_agora);
					echo "intéressé-e&nbsp;<input type=\"checkbox\" name=\"interesse_pour_agora\" value=\"1\" $checked>&nbsp;";
					$checked=Testpourcocher($participation_agora);
					echo "participe&nbsp;<input type=\"checkbox\" name=\"participation_agora\" value=\"1\" $checked>&nbsp;";
					$checked=Testpourcocher($refus_agora);
					echo "refuse&nbsp;<input type=\"checkbox\" name=\"refus_agora\" value=\"1\" $checked>
				</td>";
					if ($participation_agora ==1 OR $interesse_pour_agora ==1)
					{
						echo "<td width = \"45%\">Th&egrave;me&nbsp:&nbsp;<input type=\"text\" name=\"intervention_agora\" value=\"$intervention_agora\" size=\"50\">";
						echo "</td>";
					}
					else
					{
						echo "<td width = \"45%\" BGCOLOR = \"#48D1CC\">&nbsp;</td>";
					}
			echo "</tr>";
			echo "</tr>";
		echo "</table>";
		echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
			<tr CLASS = \"new\">
				<td width =\"10%\">logo sur affiche&nbsp;:&nbsp;
				<td width = \"45%\">";
					$checked=Testpourcocher($logo_sur_affiche);
					echo "<input type=\"checkbox\" name=\"logo_sur_affiche\" value=\"1\" $checked>&nbsp;&nbsp;
				<td width =\"20%\">afficher dans la page partenaire&nbsp;:&nbsp;
				<td width = \"35%\">";
					$checked=Testpourcocher($affiche_page_partenaire);
					echo "<input type=\"checkbox\" name=\"affiche_page_partenaire\" value=\"1\" $checked>&nbsp;&nbsp;
				</td>
			</tr>";
			echo "</tr>";
		echo "</table>";
		if ($participation_agora == 1 OR $participation_exposition ==1 OR $logo_sur_affiche ==1)
		{
			echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
				<tr CLASS = \"new\">
					<td width = \"50%\">";
						if ($lien_logo == "") //On propose le dossier de stockage des logos
						{
							//$lien_logo = $dossier_pour_logos;
						}
						echo "lien du logo&nbsp;:&nbsp;<input type=\"text\" value = \"$lien_logo\" name=\"lien_logo\" size=\"60\">
					</TD>
					<!--td><img src=\"$logo\" height = \"50%\" width = \"50%\"-->
					<td><img src=\"$logo\">
					</td>
				</TR>
			</table>";
			$nombre_a_afficher = Formatage_Nombre($participation_financiere,$monnaie_utilise);
			echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
				<tr CLASS = \"new\">
					<td width = \"20%\">participation financière&nbsp;:&nbsp;
					<input type=\"text\" value = \"$nombre_a_afficher\" name=\"participation_financiere\" size=\"10\">
					<td width = \"20%\">description pour le salon&nbsp;:&nbsp;</td>
					<td width = \"30%\"><TEXTAREA name=\"description_pour_salon\" rows=10 cols=80>$description_pour_salon</TEXTAREA></td>
					<!--input type=\"text\" value = \"$description_pour_salon\" name=\"description\" size=\"10\"-->
					<td width = \"30%\">";
						$checked=Testpourcocher($afficher_description_salon);
						echo "Afficher la description pour le salon&nbsp;:&nbsp;<input type=\"checkbox\" name=\"afficher_description_salon\" value=\"1\" $checked>
					</td>
	
				</tr>
			</table>";
		}
			if ($autorisation_salon == "O")
			{
				echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
					<TR>
						<TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications du suivi\"></TD>
					</TR>
				</TABLE>";
			}
			echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_suivi_salon\" NAME = \"action\">
			<INPUT TYPE = \"hidden\" VALUE = \"$part_salon\" NAME = \"part_salon\">
			<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
			<BR>";
		}
    else
    {
      //echo "<br>pas de données à afficher";
    }

?>
