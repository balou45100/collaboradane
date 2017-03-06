<?php
	echo "<table border = \"0\" width = \"100%\">";
		echo "<tr>";
			$cat=0;
			while ($cat<16) // Nombre de catégories
			{
				if ($compteur == 4) // Nombre de catégories par ligne
				{
					$compteur = 0;
					echo "<br />";
					echo "<table border = \"0\" width = \"100%\">";
					echo "<tr>";
				}
				echo "<td>
					<table border = \"1\">";
						echo "<tr align = \"center\">
							<td width = \"19%\">catégorie</td>
							<td width = \"3%\">B1</td>
							<td width = \"3%\">B2</td>
						</tr>";
						$fav=0;
						while ($fav<5) // Nombre de favoris pour une catégorie
						{
							echo "<tr>
								<td width = \"19%\">favoris $fav</td>
								<td  align = \"center\" width = \"3%\">B1</td>
								<td  align = \"center\" width = \"3%\">B2</td>
							</tr>";
							$fav ++;
						}
					echo "</table>
				</td>";
			$cat ++;
			$compteur ++;
			if ($compteur == 4) // Si fin de ligne on va à la suivante...
			{
				echo "</tr>";
				echo "</table>";
			}
		}
			echo "</tr>";
	echo "</table>";
?>
