<?php
//Script de test de copie du contenu du champ DATE_CREATION vers DATE_CREA en convertissant la date
	include ("../biblio/init.php");

	$query_select = "SELECT * FROM probleme";
	$results_select = mysql_query($query_select);
	$num_rows = mysql_num_rows($results_select);
	echo "<br>nbr d'enregistrements : $num_rows";

	//$res = mysql_fetch_row($results);
	//$ligne=mysql_fetch_object($results);
	echo "<table border = \"1\">";
		echo "<tr>";
			echo "<th>";
				echo "N°";
			echo "</th>";
			echo "<th>";
				echo "Date de création";
			echo "</th>";
			echo "<th>";
				echo "Date modifiée";
			echo "</th>";
			echo "<th>";
				echo "position 1";
			echo "</th>";
			echo "<th>";
				echo "jour extrait";
			echo "</th>";
			echo "<th>";
				echo "MM/AAAA";
			echo "</th>";
			echo "<th>";
				echo "mois extrait";
			echo "</th>";
			echo "<th>";
				echo "année extraite";
			echo "</th>";
			echo "<th>";
				echo "nouvelle_date";
			echo "</th>";
		echo "</tr>";
		
		//$ligne=mysql_fetch_object($results_select);

	while ($ligne=mysql_fetch_object($results_select))
	{
		$id=$ligne->ID_PB;
		$date_creation=$ligne->DATE_CREATION;
		$date_crea=$ligne->DATE_CREA;
		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td>$date_creation</td>";
		echo "<td>$date_crea</td>";
		//$date = "10-10-2008";
		//$pos = strpos($date,"-");
		$pos = strpos($date_creation,"/");
		
		//echo "<br>position : $pos";
		echo "<td>$pos</td>";
		if ($pos == 2)
		{
			$jour = substr($date_creation, 0, 2);
			$date = substr($date_creation, 3, 7);
		}
		else
		{
			$jour = "0".substr($date_creation, 0, 1);
			$date = substr($date_creation, 2, 7);
		}
		
		echo "<td>$jour</td>";
		echo "<td>$date</td>";

		$pos = strpos($date,"/");
		
		//echo "<br>position : $pos";
		//echo "<td>$pos</td>";
		if ($pos == 2)
		{
			$mois = substr($date, 0, 2);
			$date = substr($date, 3, 7);
		}
		else
		{
			$mois = "0".substr($date, 0, 1);
			$date = substr($date, 2, 7);
		}

		//$mois = substr($date_creation, 3, 2);
		//$annee = substr($date_creation, 6, 4);
		$annee = $date;

		echo "<td>$mois</td>";
		echo "<td>$annee</td>";
		$nouvelle_date = $annee."-".$mois."-".$jour." 00:00:00";
		echo "<td>$nouvelle_date</td>";
		echo "</tr>";

		$query = "UPDATE probleme SET DATE_CREA = '".$nouvelle_date."' WHERE ID_PB = '".$id."';";
		$results = mysql_query($query);

		//$res = mysql_fetch_row($results);

	}
	echo "</table>";
?>
