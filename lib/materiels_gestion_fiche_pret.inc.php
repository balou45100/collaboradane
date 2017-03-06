<?php
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<tr>";
			echo "<td><img src = \"$chemin_theme_images/logo_dane.png\"></IMG></td>";
			echo "<td><h2>&nbsp;Fiche de pr&ecirc;t et / ou de remise</h2></td>";
		echo "</tr>";
	echo "</table>";

	//Il faut récupérer les informations concernant le matériel
	$requete_materiel="SELECT * FROM materiels WHERE a_editer= '1'";
	$result_materiel=mysql_query($requete_materiel);
	$num_rows = mysql_num_rows($result_materiel);

	while ($ligne_materiel=mysql_fetch_object($result_materiel))
	{
	$id = $ligne_materiel->id;
	$no_serie = $ligne_materiel->no_serie;
	$cle_install = $ligne_materiel->cle_install;
	$denomination = $ligne_materiel->denomination;
	$categorie_principale = $ligne_materiel->categorie_principale;
	$categorie_secondaire = $ligne_materiel->categorie_secondaire;
	$origine = $ligne_materiel->origine;
	$date_livraison = $ligne_materiel->date_livraison;
	$affectation_materiel = $ligne_materiel->affectation_materiel;
	$duree = $ligne_materiel->duree;
	$date_affectation = $ligne_materiel->date_affectation;
	$date_retour = $ligne_materiel->date_retour;
	$type_affectation = $ligne_materiel->type_affectation;
	$details_article = $ligne_materiel->details_article;
	$details_garantie = $ligne_materiel->details_garantie;
	$fin_garantie = $ligne_materiel->fin_garantie;
	
	//Transformation des dates extraites pour l'affichage
	$date_affectation_a_afficher = strtotime($date_affectation);
	$date_affectation_a_afficher = date('d/m/Y',$date_affectation_a_afficher);
	$date_retour_a_afficher = strtotime($date_retour);
	$date_retour_a_afficher = date('d/m/Y',$date_retour_a_afficher);
	$date_livraison_a_afficher = strtotime($date_livraison);
	$date_livraison_a_afficher = date('d/m/Y',$date_livraison_a_afficher);
	$fin_garantie_a_afficher = strtotime($fin_garantie);
	$fin_garantie_a_afficher = date('d/m/Y',$fin_garantie_a_afficher);

	//On récupère l'intiulé de l'affectation
	$requete_affectation="SELECT DISTINCT intitule_affectation FROM materiels_affectations WHERE id_affectation = '".$affectation_materiel."'";
	$result_affectation=mysql_query($requete_affectation);
	$ligne_affectation=mysql_fetch_object($result_affectation);
	$intitule_affectation=$ligne_affectation->intitule_affectation;
	echo "<br><table border = \"1\" align = \"center\" width = \"80%\">";
		echo "<tr>";
			echo "<td colspan = \"2\">N° inventaire $id&nbsp;:&nbsp;";
			echo "<b>$denomination</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan = \"2\">D&eacute;tail&nbsp;:&nbsp;$details_article</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan = \"2\">affectation&nbsp;:&nbsp;$intitule_affectation</td>";
		echo "</tr>";
		echo "<tr>";
			if ($type_affectation == "ponctuelle")
			{
				echo "<td>pr&ecirc;t&eacute;(e) le&nbsp;:&nbsp;$date_affectation_a_afficher</td>";
				echo "<td>Retour le&nbsp;:&nbsp;$date_retour_a_afficher</td>";
			}
			else
			{
				echo "<td colspan = \"2\">remis le&nbsp;:&nbsp;$date_affectation_a_afficher</td>";
			}
		echo "</tr>";
	echo "</table>";
	}
	echo "<p>Signature (de l'emprunteur)&nbsp;:&nbsp;
	<br><br><br><br>________________________________________</p>";

	echo "<br><hr width = \"80\" height = \"5\"></hr><br>";
	echo "<p>retour, le&nbsp;:&nbsp;________________________________________</p>
	<p><br><br>Signature (du / de la repr&eacute;sentant(e) du service)&nbsp;:&nbsp;
	<br><br><br><br>________________________________________</p>";
?>
