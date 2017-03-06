<?php
	echo "<tr>";
		echo "<th>";
			echo "ST";
		echo "</th>";
		if ($_SESSION['id_util'] == 1) //C'est l'administrateur
		{
			echo "<th>";
				echo "ID";
			echo "</th>";
		}
		echo "<th>";
			echo "NOM, PR&Eacute;NOM";
		/*
		if ($sense_tri =="asc")
		{
			echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		}
		else
		{
			echo "NOM<A href=\"personnes_ressources_gestion.php?tri=NOM&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		}
*/
		echo "</th>";

		echo "<th>";
			echo "CODETAB";
		/*
		if ($sense_tri =="asc")
		{
			echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		}
		else
		{
			echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		}
		*/
		echo "</th>";
		echo "<th colspan = \"2\">";
			echo "&Eacute;V&Eacute;NEMENT";
		/*
		if ($sense_tri =="asc")
		{
			echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=desc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
		}
		else
		{
			echo "CODETAB<A href=\"personnes_ressources_gestion.php?tri=RNE&amp;sense_tri=asc&amp;indice=0&amp;en_liste=$en_liste\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
		}
		*/
		echo "</th>";

		echo "<th>";
			echo "FRAIS";
		echo "</th>";

		echo "<th>";
			echo "R&Eacute;F / MT OM";
		echo "</th>";
/*
		echo "<th>";
			echo "MT OM";
		echo "</th>";
*/
		echo "<th>";
			echo "R&Eacute;F / MT EF";
		echo "</th>";
/*
		echo "<th>";
			echo "MT EF";
		echo "</th>";
*/
		echo "<th>";
			echo "PAY&Eacute;";
		echo "</th>";
		echo "<th>AIMP</th>";
		echo "<th>RAP</th>";
		echo "<th>ACTIONS</th>";
		//echo "<th>OM CDT</th>";
		//echo "<th>EF CDT</th>";

	echo "</tr>";
?>
