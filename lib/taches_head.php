<?php
	header('Content-Type: text/html;charset=UTF-8');
	echo "<div align =\"center\">";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// appel &agrave; taches_gestion.php //////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<form action = \"taches_gestion.php\" target = \"body\" method = \"get\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					//Choix des filtres
					//$requete_categorie="SELECT DISTINCT id_categ,intitule_categ FROM categorie_commune, taches_categories WHERE taches_categories.id_categorie = categorie_commune.id_categ ORDER BY intitule_categ";
					$requete_categorie="SELECT DISTINCT id_categ,intitule_categ FROM categorie_commune, taches_categories, taches_util WHERE taches_categories.id_tache = taches_util.id_tache AND taches_categories.id_categorie = categorie_commune.id_categ AND taches_util.id_util = '".$_SESSION['id_util']."' ORDER BY intitule_categ";
					$result=mysql_query($requete_categorie);
					$num_rows = mysql_num_rows($result);
					echo "Cat&eacute;gorie&nbsp;:&nbsp;<select size=\"1\" name=\"categorie_filtre\">";
					if (mysql_num_rows($result))
					{
						echo "<OPTGROUP LABEL=\"-----------------------\">";
							echo "<option selected value=\"%\">toutes</option>";
							echo "<option value=\"S\">sans</option>";
				    	echo "</OPTGROUP>";
						echo "<OPTGROUP LABEL=\"-----------------------\">";
			    		echo "</OPTGROUP>";
						echo "<OPTGROUP LABEL=\"cat&eacute;gories communes\">";
						while ($ligne=mysql_fetch_object($result))
						{
							$intitule=$ligne->intitule_categ;
							$id_categ=$ligne->id_categ;
							echo "<option value=\"$id_categ\">$intitule</option>";
						}
				    	echo "</OPTGROUP>";
					}
					echo "</select>"; 
				echo "</td>";
				echo "<td>";
					echo "&nbsp;&eacute;tat&nbsp;:&nbsp;"; 
						echo "<select size=\"1\" name=\"etat_filtre\">";
							echo "<option selected value=\"0\">non achev&eacute;</option>";
							echo "<option value=\"1\">nouveau</option>";
							echo "<option value=\"2\">en cours</option>";
							echo "<option value=\"3\">achev&eacute;</option>";
							echo "<option value=\"%\">tout</option>";
						echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;visibilit&eacute;&nbsp;:&nbsp;"; 
						echo "<select size=\"1\" name=\"visibilite_filtre\">";
							echo "<option selected value=\"PU\">public</option>";
							echo "<option value=\"PR\">priv&eacute;</option>";
							echo "<option value=\"%\">tout</option>";
						echo "</select>";

					echo "&nbsp;&nbsp;D&eacute;tail&nbsp;:&nbsp; 
					<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

						echo "&nbsp;<input type = \"submit\" VALUE = \"hop !\">
							<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<input type = \"hidden\" VALUE = \"entete\" NAME = \"origine_appel\">
							<input type = \"hidden\" VALUE = \"O\" NAME = \"controle_entete\">
							<input type = \"hidden\" VALUE = \"N\" NAME = \"affiche_barrees\">
							<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<input type = \"hidden\" VALUE = \"DATECR\" NAME = \"tri\">";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel &agrave; taches_gestion.php //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//		echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Filtre pour les tâches partag&eacute;es ////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
		$id_util = $_SESSION['id_util'];
		echo "<td>&nbsp;partages&nbsp;:&nbsp;</td>";
		$query_util_filtre = "SELECT * FROM util, taches_util, taches WHERE taches_util.id_util = '".$id_util."' AND taches_util.id_tache = taches.id_tache AND taches.id_util_creation = util.id_util AND visible = 'O' ORDER BY NOM";
		//$query_util_filtre = "SELECT * FROM util, taches_util, taches WHERE util.id_util = taches_util.id_util AND taches_util.id_util = '".$id_util."' AND visible = 'O' ORDER BY NOM";
		$results_util_filtre = mysql_query($query_util_filtre);
		$no = mysql_num_rows($results_util_filtre);
		//echo "id_util : $id_util";

		echo "<form action = \"taches_gestion.php\"  target = \"body\" method = \"get\">";
		echo "<td>";
			echo "<input type = \"hidden\" VALUE = \"".$id."\" NAME = \"id\">";
		echo "</td>";
		echo "<td>";
			echo "<select name = \"id_util_filtre\">";
				echo "<option selected VALUE = \"0\">Tous</option>";
				while ($ligne_util_filtre = mysql_fetch_object($results_util_filtre))
				{
					$id_util_filtre = $ligne_util_filtre->ID_UTIL;
					$nom = $ligne_util_filtre->NOM;
					$prenom = $ligne_util_filtre->PRENOM;
					if ($id_util_filtre <> $id_util)
					{
						echo "<option value = \"".$id_util_filtre."\">".$nom." - ".$prenom."</option>";
					}
				}
				echo "</select>";
			echo "</td>";
			echo "<td>";
				echo "&nbsp;<input type = \"submit\" VALUE = \"hop !\">
					<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
					<input type = \"hidden\" VALUE = \"entete_util\" NAME = \"origine_appel\">
					<input type = \"hidden\" VALUE = \"N\" NAME = \"affiche_barrees\">
					<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
					<input type = \"hidden\" VALUE = \"DATECR\" NAME = \"tri\">";
	
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		echo "</form>";
*/
?>
		</div>
	</body>
</html>

