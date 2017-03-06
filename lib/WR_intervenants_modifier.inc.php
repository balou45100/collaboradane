<?php
	//echo "<br />id_type_evenement : $id_type_evenement";
	
	//On récupère les information de l'événement à modifier
	$requete_intervenant = "SELECT * FROM Intervenants WHERE id = $id_intervenant"; 
	$resultat = mysql_query($requete_intervenant);
	$nombre = mysql_num_rows($resultat);
	
	//echo "<br />nombre : $nombre";
	
	if ($nombre > 0)
	{
		$ligne = mysql_fetch_object($resultat);
		$id_intervenant = $ligne->id;
		$nom = $ligne->nom;
		$prenom = $ligne->prenom;
		$fonction = $ligne->fonction;
		$rne = $ligne->rne;
		$infos_contact = $ligne->infos_contact;
		$infos_personne = $ligne->infos_personne;
		$mel = $ligne->mel;
		$a_publier = $ligne->a_publier;
		$OM = $ligne->OM;
		$annee = $ligne->annee;
		

		echo "<form action=\"WR_intervenants.php\" method=\"post\">";
		echo "<table border = \"1\">";
		echo "<tr>";
			echo "<td align = \"right\">Nom&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"nom\" size = \"30\" value = \"$nom\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Pr&eacute;nom&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"prenom\" size = \"30\" value = \"$prenom\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Fontion&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"fonction\" size = \"30\" value = \"$fonction\"></td>";
		echo "</tr>";

				echo "<tr>";
					echo "<td class = \"fond_etiquette_tableau\"align=\"right\"><nobr>UAI (RNE)</nobr>&nbsp;:&nbsp;</td>";
					echo "<td class = \"fond_saisie_tableau\">";
	
	$request1=mysql_query("SELECT * FROM info_etab WHERE rne = '".$rne."'");
	
	$l1=mysql_fetch_object($request1);
	$list_etab="<select name='rne'>"."<option selected value='$l1->rne'>".$l1->rne." - ".$l1->type_etab." ".$l1->nom_etab." ".$l1->ville_etab."</option>";

	$request=mysql_query("SELECT * FROM info_etab WHERE rne <> '".$rne."'");
	//$list_etab="<select name='rne'>"."<option value='-1'>Faire un choix</option>";
	while($l=mysql_fetch_object($request)){
		$list_etab=$list_etab."<option value='$l->rne'>".$l->rne." - ".$l->type_etab." ".$l->nom_etab." ".$l->ville_etab."</option>";
	}
	$list_etab=$list_etab."</select>";
	echo$list_etab;

					echo "</td>";
				echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Coordonn&eacute;es pour le-la contacter&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"infos_contact\" size = \"30\" value = \"$infos_contact\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">M&eacute;l&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"mel\" size = \"40\" value = \"$mel\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Publier dans la page des intervenants&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" id=\"form_inscription\" name=\"a_publier\">";
					if ($a_publier == "O")
					{
						echo "<option selected value=\"O\">Oui</option>
						<option value=\"N\">Non</option>";
					}
					else
					{
						echo "<option selected value=\"N\">Non</option>
						<option value=\"O\">Oui</option>";
					}
					echo "</select>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Envoyer un ordre de mission&nbsp;:&nbsp;</td>";
			echo "<td>
				<select size=\"1\" id=\"form_inscription\" name=\"OM\">";
					if ($OM == "O")
					{
						echo "<option selected value=\"O\">Oui</option>
						<option value=\"N\">Non</option>";
						echo "<option value=\"F\">Fait</option>";
					}
					elseif ($OM == "N")
					{
						echo "<option selected value=\"N\">Non</option>
						<option value=\"O\">Oui</option>";
						echo "<option value=\"F\">Fait</option>";
					}
					else
					{
						echo "<option selected value=\"F\">Fait</option>";
						echo "<option value=\"O\">Oui</option>";
						echo "<option value=\"N\">Non</option>";
					}
					
					echo "</select>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Br&egrave;ve description&nbsp;:&nbsp;</td>";
			echo "<td><TEXTAREA ROWS = \"4\" COLS = \"60\" NAME = \"infos_personne\">$infos_personne</TEXTAREA>";
				echo "<script type=\"text/javascript\">
				CKEDITOR.replace( 'infos_personne');
			</script></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Ann&eacute;e&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"annee\" size = \"10\" value = \"$annee\"></td>";
		echo "</tr>";

		echo "</table>";

		echo "<br><input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer les modifications\"/>
			<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id_intervenant\" NAME = \"id_intervenant\">
			<INPUT TYPE = \"hidden\" VALUE = \"maj_intervenant\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$choix_annee\" NAME = \"choix_annee\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "</form>";
	}
?>
