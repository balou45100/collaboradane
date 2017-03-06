<?php
	//$description_alerte = $_POST['description_alerte'];
	//$date_alerte = $_POST['date_alerte'];
/*
	$jour = $_GET['jour'];
	$mois = $_GET['mois'];
	$annee = $_GET['annee'];
	$nbr_jours = $_GET['nbr_jours'];
*/
	$id_util = $_SESSION['id_util'];

	echo "<h1>Modification de l'alerte du ticket $idpb</h1>";

	//On récupère les infos de l'alerte à modifier
	$requete_alerte = "SELECT * FROM alertes WHERE id_util = '".$id_util."' AND id_ticket = ".$idpb."";
	
	//echo "<br />$requete_alerte";
	
	$resultat_requete_alerte = mysql_query($requete_alerte);
	$res_alerte = mysql_fetch_row($resultat_requete_alerte);
	$date_alerte = $res_alerte[3];
	$description_alerte = $res_alerte[4];
/*
	echo "<br />description_alerte : $description_alerte - jour : $jour - mois : $mois - annee : $annee - nbr_jours : $nbr_jours";
	echo "<br />id_ticket : $idpb - id_util : $id_util";
	echo "<br />date_alerte : $date_alerte";
*/
	//On d&eacute;coupe la date pour alimenter les diff&eacute;rentes variables
	$extraction = strtok($date_alerte, "-");
	$annee = $extraction;
	//echo " - extraction1 : $extraction"; 
	$extraction = strtok("-");
	//echo " - extraction2 : $extraction";
	$mois = $extraction;
	$extraction = strtok("-");
	//echo " - extraction3 : $extraction";
	$jour = $extraction;
/*
	echo "<br />annee_en_cours : $annee_en_cours";
	echo "<br />annee : $annee";
	echo "<br />mois : $mois";
	echo "<br />jour : $jour";
*/

	echo "<form action = \"consult_ticket.php\" METHOD = \"POST\">";
	echo "<table width=\"50%\">";
	echo "<tr>";
	echo "<td class = \"etiquette\" width = \"10%\">Saisir la desription de l'alerte&nbsp;:&nbsp;</td>";
	echo "<td width = \"90%\"><TEXTAREA ROWS = \"3\" COLS = \"50\" NAME = \"description_alerte\">".$description_alerte."</TEXTAREA></td>";
	echo "<script type=\"text/javascript\">
			CKEDITOR.replace( 'description_alerte',
			{
				toolbar : 'Basic'
			});
		</script></td>";
	echo "</td>";

	echo "</TR";
	echo "<tr>";
	/*
	echo "<td align = \"center\">Alerte dans&nbsp;<select size=\"1\" name=\"nbr_jours\">
		<option value=\"0\"></option>
		<option value=\"1\">01</option>
		<option value=\"2\">02</option>
		<option value=\"3\">03</option>
		<option value=\"4\">04</option>
		<option value=\"5\">05</option>
		<option value=\"6\">06</option>
		<option value=\"7\">07</option>
		<option value=\"8\">08</option>
		<option value=\"9\">09</option>
		<option value=\"10\">10</option>
		<option value=\"11\">11</option>
		<option value=\"12\">12</option>
		<option value=\"13\">13</option>
		<option value=\"14\">14</option>
		<option value=\"15\">15</option>
		<option value=\"16\">16</option>
		<option value=\"17\">17</option>
		<option value=\"18\">18</option>
		<option value=\"19\">19</option>
		<option value=\"20\">20</option>
		<option value=\"21\">21</option>
		<option value=\"22\">22</option>
		<option value=\"23\">23</option>
		<option value=\"24\">24</option>
		<option value=\"25\">25</option>
		<option value=\"26\">26</option>
		<option value=\"27\">27</option>
		<option value=\"28\">28</option>
		<option value=\"29\">29</option>
		<option value=\"30\">30</option>
		<option value=\"31\">31</option>
	</select> jour(s)";
	*/
	echo "<td class = \"etiquette\">&Eacute;ch&eacute;ance&nbsp;:&nbsp;</td>";
	echo "<td><select size=\"1\" name=\"jour\">
		<option selected>$jour</option>
		<option value=\"1\">01</option>
		<option value=\"2\">02</option>
		<option value=\"3\">03</option>
		<option value=\"4\">04</option>
		<option value=\"5\">05</option>
		<option value=\"6\">06</option>
		<option value=\"7\">07</option>
		<option value=\"8\">08</option>
		<option value=\"9\">09</option>
		<option value=\"10\">10</option>
		<option value=\"11\">11</option>
		<option value=\"12\">12</option>
		<option value=\"13\">13</option>
		<option value=\"14\">14</option>
		<option value=\"15\">15</option>
		<option value=\"16\">16</option>
		<option value=\"17\">17</option>
		<option value=\"18\">18</option>
		<option value=\"19\">19</option>
		<option value=\"20\">20</option>
		<option value=\"21\">21</option>
		<option value=\"22\">22</option>
		<option value=\"23\">23</option>
		<option value=\"24\">24</option>
		<option value=\"25\">25</option>
		<option value=\"26\">26</option>
		<option value=\"27\">27</option>
		<option value=\"28\">28</option>
		<option value=\"29\">29</option>
		<option value=\"30\">30</option>
		<option value=\"31\">31</option>
	</select>";
	echo "&nbsp;<select size=\"1\" name=\"mois\">
		<option selected>$mois</option>
		<option value=\"1\">01</option>
		<option value=\"2\">02</option>
		<option value=\"3\">03</option>
		<option value=\"4\">04</option>
		<option value=\"5\">05</option>
		<option value=\"6\">06</option>
		<option value=\"7\">07</option>
		<option value=\"8\">08</option>
		<option value=\"9\">09</option>
		<option value=\"10\">10</option>
		<option value=\"11\">11</option>
		<option value=\"12\">12</option>
	</select>";
		echo "&nbsp;<select size=\"1\" name=\"annee\">";
		echo "<option selected value=\"$annee\">$annee</option>";
		
		for ($i = $annee_en_cours; $i <= $annee_en_cours+3; $i++)
		{
			if ($annee <> $i)
			{
				echo "<option value=\"$i\">$i</option>";
			}
		}
	echo "</select>";
	echo "</TD";
	echo "</TR";
	echo "<tr>";
	echo "<td class = \"etiquette\">&nbsp;</td>";
	echo "<td align = \"center\"><input type = \"submit\" VALUE = \"Valider les modifications\" name = \"action\">";
	//echo "&nbsp;&nbsp;<input src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans modifier cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
	echo "&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Retour\" name = \"action\"></td>";
	//echo "&nbsp;&nbsp;<input src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" title=\"Retour sans modifier cette alerte\" border = \"0\" TYPE = image VALUE = \"\" NAME = \"action\">";
	//echo "<input type = \"hidden\" VALUE = \"confirmation_modif_alerte\" NAME = \"action\"></td>";
	$affichage = "N"; // pour &eacute;viter que le ticket s'affiche

?>
