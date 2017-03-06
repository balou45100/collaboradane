<?php
		$autorisation_gestion_materiels = verif_appartenance_groupe(8);
//echo "coucou";
	//echo "<center>";
	echo 	"<table>
			<tr>
				<td><center><a href = tb_tickets.php?vue=page>Tickets ($_SESSION[nb_tickets])</a></center></td>
				<td><center><a href = tb_alertes.php?vue=page>Alertes ($_SESSION[nb_alertes])</a></center></td>
				<td><center><a href = tb_taches.php?vue=page>T&acirc;ches ($_SESSION[nb_taches])</a></center></td>
				<!--td><center><a href = tb_pers_form1.php>Personnes ressources ($_SESSION[nb_pers])</a></center></td-->";

			if ($autorisation_gestion_materiels == 1)
			//if ($util == "admin")
			{
				echo "<td><center><a href = tb_prets.php>Pr&ecirc;ts de mat&eacute;riels ($_SESSION[nb_prets])</a></center></td>
				<td><center><a href = tb_garanties.php?vue=page>Garanties des mat&eacute;riels ($_SESSION[nb_enregs])</a></center></td>";
			}
			echo "</tr>
	</table>
	<br />";
?>
<!--/center-->
