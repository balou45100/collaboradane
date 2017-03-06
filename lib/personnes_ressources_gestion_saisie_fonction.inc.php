<?php
	echo "<h1>Saisie d'une fonction</h1>";
	//Il faut récupérer les informations concernant la personne
	$requete_personne="SELECT * FROM personnes_ressources_tice WHERE id_pers_ress = '".$id."'";
	$result_personne=mysql_query($requete_personne);
	$num_rows = mysql_num_rows($result_personne);
	//echo "<br>Nombre d'enregistrements retourné : $num_rows";
	$ligne_personne=mysql_fetch_object($result_personne);
	$id_pers_ress = $ligne_personne->id_pers_ress;
	$civil = $ligne_personne->civil;
	$nom = $ligne_personne->nom;
	$prenom = $ligne_personne->prenom;
	$codetab = $ligne_personne->codetab;
	$id_discipline = $ligne_personne->id_discipline;
	$id_poste = $ligne_personne->id_poste;
	$mel = $ligne_personne->mel;
	
	//echo "annee_en_cours : $annee_en_cours";
	
	echo "<form id=\"monForm\" action=\"personnes_ressources_gestion.php\" method=\"get\">
		<fieldset>
		<legend>Renseignements sur la personne ressource</legend>
			<p>
				<label for=\"form_id\">ID&nbsp;:&nbsp;</label>
				<a for = \"form_id_valeur\">&nbsp;$id</a>
			</p>
			<p>
				<label for=\"form_nom\">Nom&nbsp;:&nbsp;</label>
				<a for = \"form_nom_valeur\">&nbsp;$nom</a>
				
			</p>
			<p>
				<label for=\"form_prenom\">Pr&eacute;nom&nbsp;:&nbsp;</label>
				<a for = \"form_prenom_valeur\">&nbsp;$prenom</a>
				
			</p>";
			if ($id_discipline <>"")
			{
				//On récupère l'intiulé de la discipline
				$requete_intitule_discipline="SELECT DISTINCT discipline FROM discipline WHERE id_discipline = '".$id_discipline."'";
				$result_intitule_discipline=mysql_query($requete_intitule_discipline);
				$ligne_intitule_discipline=mysql_fetch_object($result_intitule_discipline);
				$intitule_discipline=$ligne_intitule_discipline->discipline;
				echo "<p>
					<label for=\"form_discipline\">Discipline&nbsp;:&nbsp;</label>
					<a for = \"form_discipline_valeur\">&nbsp;$intitule_discipline</a>
				</p>";
			}
			if ($id_poste <>"")
			{
				//On récupère l'intiulé du poste
				$requete_intitule_poste="SELECT DISTINCT poste FROM postes WHERE id_poste = '".$id_poste."'";
				$result_intitule_poste=mysql_query($requete_intitule_poste);
				$ligne_intitule_poste=mysql_fetch_object($result_intitule_poste);
				$intitule_poste=$ligne_intitule_poste->poste;
				echo "<p>
					<label for=\"form_poste\">Poste&nbsp;:&nbsp;</label>
					<a for = \"form_poste_valeur\">&nbsp;$intitule_poste</a>
				</p>";
			}
			echo "<p>";
				echo "<label for=\"form_mel\">M&eacute;l&nbsp;:&nbsp;</label>
				<a for = \"form_mel_valeur\">&nbsp;$mel</a>";
			echo "</p>
		</fieldset>
		<fieldset>
		<legend>Renseignements sur l'&eacute;cole ou l'EPLE de rattachement</legend>
			<p>
				<label for=\"form_rne\">RNE&nbsp;:&nbsp;</label>
				<a for = \"form_rne_valeur\">&nbsp;$codetab</a>
				
			</p>";
			//On récupère les autres informations de l'étab
			$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements WHERE RNE = '".$codetab."'";
			$result_etabs=mysql_query($requete_etabs);
			$ligne=mysql_fetch_object($result_etabs);
			$rne = $ligne->RNE;
			$type = $ligne->TYPE;
			$nom = $ligne->NOM;
			$ville = $ligne->VILLE;
			echo "<p>
				<label for=\"form_type\">Type&nbsp;:&nbsp;</label>
				<a for = \"form_type_valeur\">&nbsp;$type</a>
			</p>
			<p>
				<label for=\"form_nom\">D&eacute;nomination&nbsp;:&nbsp;</label>
				<a for = \"form_nom_valeur\">&nbsp;$nom</a>
			</p>
			<p>
				<label for=\"form_ville\">Ville&nbsp;:&nbsp;</label>
				<a for = \"form_ville_valeur\">&nbsp;$ville</a>
			</p>
		</fieldset>
		<fieldset>
		<legend>La fonction &agrave; saisir</legend>";
			echo "<p>
				<label for=\"form_fonction\">Fonction&nbsp;:&nbsp;</label>
			</p>
			<p>";
				$requete_fonctions = "SELECT * FROM fonctions_personnes_ressources WHERE selection = 'O' ORDER BY intitule_fonction";
				$resultat_fonctions = mysql_query($requete_fonctions);
				$num_rows = mysql_num_rows($resultat_fonctions);
				
				echo "<select size=\"1\" id=\"form_id_fonction\" name=\"id_fonction_exercice\">";
				if (mysql_num_rows($resultat_fonctions))
				{
					echo "<option selected value=\"\">Faire un choix</option>";
					while ($ligne_fonction=mysql_fetch_object($resultat_fonctions))
					{
						$intitule_fonction=$ligne_fonction->intitule_fonction;
						$id_fonction=$ligne_fonction->id_fonction;
						$annee_fonction=$ligne_fonction->annee;
						echo "<option value=\"$id_fonction\">$intitule_fonction ($annee_fonction)</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>";
			echo "<p>";
				//On rempli le champs de sélection
				$requete_etabs="SELECT DISTINCT RNE,TYPE,NOM,VILLE FROM etablissements ORDER BY RNE";
				$result_etabs=mysql_query($requete_etabs);
				$num_rows = mysql_num_rows($result_etabs);
				echo "<label for=\"form_rne\">Fonction exerc&eacute;e dans (RNE)&nbsp;:&nbsp;</label>
				<select size=\"1\" id=\"form_rne\" name=\"rne_exercice\">";
				if (mysql_num_rows($result_etabs))
				{
					echo "<option selected VALUE = \"".$rne."\">".$rne." - ".str_replace("*", " ",$type)." ".str_replace("*", " ",$nom). " - ".$ville."</OPTION>";
					while ($ligne=mysql_fetch_object($result_etabs))
					{
						$rne = $ligne->RNE;
						$type = $ligne->TYPE;
						$nom = $ligne->NOM;
						$ville = $ligne->VILLE;
						echo "<OPTION VALUE = \"".$rne."\">".$rne." - ".str_replace("*", " ",$type)." ".str_replace("*", " ",$nom). " - ".$ville."</OPTION>";
						//echo "<option value=\"$intitule_materiels\">$intitule_materiels</option>";
					}
				}
				echo "</SELECT>"; 
			echo "</p>";
			echo "<p>";
				echo "<label for=\"form_annee\">Ann&eacute;e&nbsp;:&nbsp;</label>";
			echo "</p>";
			echo "<p>";
				$annee2 = $annee_en_cours+1;
				//echo "annee2 : $annee2";
				echo "<select size=\"1\" id=\"form_annee\" name=\"annee_exercice\">
					<option selected value=\"$annee_en_cours\">$annee_en_cours-$annee2</option>";
					for( $annee1 = $annee_en_cours-2; $annee1 < $annee_en_cours+5; $annee1++ )
					{
						$annee2 = $annee1+1;
						echo "<option value=\"$annee1\">$annee1-$annee2</option>";
					}
				echo "</select>";
			echo "</p>";
			if($annee_en_cours < 2015) // Avant le changement vers les IMP
			{
				echo "<p>
					<label for=\"form_nbr_heures\">Nombre d'heures attribu&eacute;es&nbsp;:&nbsp;</label>
					<input type=\"text\" id=\"form_nbr_heures\" name=\"nbr_heures_exercice\" />
				</p>";
				echo "<p>";
					echo "<label for=\"form_hse\">&Agrave;&nbsp;cocher s'il s'agit d'HSE&nbsp;:&nbsp;</label>";
				echo "</p>";
				echo "<p>";
					echo "<a for = \"form_hse_valeur\">&nbsp;<input type=\"checkbox\" name=\"hse_exercice\" value=\"Oui\" size=\"4\" /></a>";
				echo "</p>";
			}
			else // Nous sommes dans le cas de saisie d'IMP
			{
				echo "<p>";
					echo "<label for=\"form_taux_imp\">Taux IMP attribu&eacute;&nbsp;:&nbsp;</label>";
					//On génère la liste de sélection
					remplir_champ_select_par_annee('','taux_imp_exercice','taux','montant','imp','','Faire un choix','annee',$annee_en_cours,'taux');
				echo "</p>";
			}
			echo "<p>
				<label for=\"form_observation\">Observation&nbsp;:&nbsp;</label>
				<TEXTAREA name=\"observation\" rows=3 COLS=60></TEXTAREA>
				<!--input type=\"text\" id=\"form_observation\" name=\"observation\" /-->
			</p>";

		echo "</fieldset>";
		echo "<p>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer\"/>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$id_pers_ress\" NAME = \"id_pers_ress_exercice\">
			<INPUT TYPE = \"hidden\" VALUE = \"$tri\" NAME = \"tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"$sense_tri\" NAME = \"sense_tri\">
			<INPUT TYPE = \"hidden\" VALUE = \"filtre\" NAME = \"origine_gestion\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"actions_courantes\">
			<INPUT TYPE = \"hidden\" VALUE = \"enreg_fonction\" NAME = \"a_faire\">
		</p>
	</form>";
?>
