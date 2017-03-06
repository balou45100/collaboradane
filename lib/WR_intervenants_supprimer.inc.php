<?php
	//echo "<br />id_evenement : $id_evenement";
	
	//On récupère les information de l'événement à supprimer
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
		$infos_contact = $ligne->infos_contact;
		$annee = $ligne->annee;
		
		echo "<form action=\"WR_intervenants.php\" method=\"get\">";
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
			echo "<td align = \"right\">Coordonn&eacute;es pour le-la contacter&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"infos_contact\" size = \"30\" value = \"$infos_contact\"></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align = \"right\">Ann&eacute;e&nbsp;:&nbsp;</td>";
			echo "<td ><input type = \"text\" name=\"annee\" size = \"10\" value = \"$annee\"></td>";
		echo "</tr>";

		echo "</table>";

		echo "<br><input type=\"submit\" name=\"bouton_envoyer_suppression\" Value = \"Confirmer la suppression d&eacute;finitive\"/>
			<input type=\"submit\" name=\"bouton_envoyer_suppression\" Value = \"Retourner sans supprimer\"/>
			<INPUT TYPE = \"hidden\" VALUE = \"$id_intervenant\" NAME = \"id_intervenant\">
			<INPUT TYPE = \"hidden\" VALUE = \"conf_supprimer\" NAME = \"a_faire\">
			<INPUT TYPE = \"hidden\" VALUE = \"$choix_annee\" NAME = \"choix_annee\">
			<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"action\">";
		echo "</form>";
	}
?>
