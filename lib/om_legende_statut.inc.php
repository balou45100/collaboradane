<?php
	echo "<table>";
		echo "<tr>";
			echo "<th>L&eacute;gende&nbsp; pour le statut de l'OM</th>";
			for ($i = $debut_compteur; $i <= 8; $i++)
			{
				$classe_etat_om = etat_om($i);
				echo "<td class = \"$classe_etat_om\" align=\"center\">";
					$etat_en_clair = etat_om_en_clair($i);
					echo "&nbsp;$etat_en_clair&nbsp;";
				echo "</td>";
			}
		echo "</tr>";
	echo "</table>";
?>
