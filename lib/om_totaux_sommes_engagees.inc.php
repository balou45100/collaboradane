<?php
	//echo "<br />filtre_annee : $filtre_annee";
	
	if ($origine_appel == "entete" AND $filtre_annee <> '%')
	{
		$annee_choisie = $filtre_annee;
		$montant_alloue = lecture_champ("frais_deplacements_historique","montant","annee",$filtre_annee);
	}
	else
	{
		$annee_choisie = $om_annee_budget;
		$montant_alloue = lecture_champ("frais_deplacements_historique","montant","annee",$om_annee_budget);
	}
	
	$total_om = calcul_somme_champ("montant_om_chorus", $annee_choisie);
	$total_ef = calcul_somme_champ("montant_ef_chorus", $annee_choisie);
	$total_paye = calcul_somme_champ("montant_paye_chorus", $annee_choisie);

	//Calcul des différentes sommes disponibles
	$dispo_om = $montant_alloue-$total_om;
	$dispo_ef = $montant_alloue-$total_ef;
	$dispo_paye = $montant_alloue-$total_paye;
	
	//On convertit les nombres pour les afficher avcec un format monétaire
	//setlocale(LC_MONETARY, 'fr_FR');
	$montant_alloue_a_afficher = number_format($montant_alloue, 2, ',', ' ');
	$total_om_a_afficher = number_format($total_om, 2, ',', ' ');
	$total_ef_a_afficher = number_format($total_ef, 2, ',', ' ');
	$total_paye_a_afficher = number_format($total_paye, 2, ',', ' ');
	$dispo_om_a_afficher = number_format($dispo_om, 2, ',', ' ');
	$dispo_ef_a_afficher = number_format($dispo_ef, 2, ',', ' ');
	$dispo_paye_a_afficher = number_format($dispo_paye, 2, ',', ' ');
	
	echo "<hr>";
	echo "<table>";
		echo "<tr>";
			echo "<th>Ann&eacute;e&nbsp;:&nbsp;</th>";
			echo "<td>&nbsp;$annee_choisie&nbsp;</td>";
			echo "<th>Montant allou&eacute;&nbsp;:&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$montant_alloue_a_afficher&nbsp;&euro;</td>";
			echo "<th>Total OM&nbsp;:&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$total_om_a_afficher&nbsp;&euro;</td>";
			echo "<th>Total EF&nbsp;:&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$total_ef_a_afficher&nbsp;&euro;</td>";
			echo "<th>Total pay&eacute;&nbsp;:&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$total_paye_a_afficher&nbsp;&euro;</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<th colspan =\"5\">Disponibilit&eacute;s&nbsp;:&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$dispo_om_a_afficher&nbsp;&euro;</td>";
			echo "<th>&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$dispo_ef_a_afficher&nbsp;&euro;</td>";
			echo "<th>&nbsp;</th>";
			echo "<td align = \"right\">&nbsp;$dispo_paye_a_afficher&nbsp;&euro;</td>";
		
		echo "</tr>";

	echo "</table>";
	echo "<hr>";
?>
