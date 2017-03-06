<?php
	/*
	$suivant = $_POST['suivant'];
	$Suivant2 = $_POST['Suivant2'];
	$typelieu = $_POST['typelieu'];
	$valid_etab1 = $_POST["valid_etab1"];
	$valid_etab2 = $_POST["valid_etab2"];
	$ville=$_POST["ville"];
	$idE=$_POST["idE"];
	
	echo "<br />suivant : $suivant";
	echo "<br />Suivant2 : $Suivant2";
	echo "<br />typelieu : $typelieu";
	echo "<br />valid_etab1 : $valid_etab1";
	echo "<br />valid_etab2 : $valid_etab2";
	echo "<br />ville : $ville";
	//echo "<br />idE : $idE";
	*/
	echo "<form method=\"POST\">";
	/*
	echo "<br />om_etablissement : typelieu : $typelieu";
	echo "<br />connexion : $connexion";
	*/
	$requete_ville= "SELECT DISTINCT VILLE FROM etablissements ORDER BY VILLE;";

	//echo "<br />requete_ville : $requete_ville";

	//$result_ville=mysql_query ($requete_ville, $connexion);
	$result_ville=mysql_query ($requete_ville);
	echo "<tr>";
		echo "<td class = \"etiquette\">&Eacute;tape 2&nbsp;:&nbsp;Choisir une ville&nbsp;:&nbsp;</td>";
		echo "<td>";
			echo "<SELECT name=\"ville\">";
				if(ISSET($_POST["ville"])) //On a déjà choisi une ville et on la raffiche dans le champ de sélection
				{
					$ville=$_POST["ville"];
					echo "<option value=\"\">$ville</option>";
				}
				else
				{
					echo "<option value=\"\">Tout</option>";
				}
					while ($ligne_ville=mysql_fetch_assoc($result_ville))
					{
					$nom=$ligne_ville["VILLE"];
					echo '<OPTION value="'.$nom.'">'.$nom.'</option>';
					}
			echo "</select>";
		echo "</td>";
		echo "<td class = \"fond-actions\" nowrap>";
			echo "<input type=\"submit\" name=\"suivant\" value=\">> &eacute;tape 3\"/>";
			echo "<input type=\"hidden\" name=\"typelieu\" value=\"1\"/>";
			echo "<input type=\"hidden\" name=\"Suivant2\" value=\"XX\"/>";
		echo "</td>";

	echo "</tr>";

	echo "</form>";

	if(isset($_POST["suivant"]))
	{

	$ville=$_POST["ville"];
	if($ville!="")
	{
		$requete_etab="SELECT * FROM etablissements where VILLE='$ville' Order by NOM;";
		$result_etab=mysql_query($requete_etab);

		echo "<form method=\"post\">";
		$valid_etab1 = $_POST['valid_etab1'];
		//echo "<br />valid_etab1 : $valid_etab1";
		echo "<td class = \"etiquette\">&Eacute;tape 3&nbsp;:&nbsp;Choisir un lieu&nbsp;:&nbsp;</td>";
		
		echo "<td>";
			echo "<select name=\"etab\">";
			while ($ligne_etab=mysql_fetch_assoc($result_etab))
			{
				$type=$ligne_etab["TYPE"];
				$nomE=$ligne_etab["NOM"];
				$idE=$ligne_etab["RNE"];
				//echo '<OPTION value="'.$idE.'">'.$nomE.' 	&nbsp; -- 	&nbsp; '.$type.' 	&nbsp; -> 	&nbsp; '.$idE.'</option>';
				echo '<OPTION value="'.$idE.'">'.$type.'&nbsp;'.$nomE.'&nbsp;&nbsp;('.$idE.')</option>';
			}
				echo "</select>";

		echo "</td>";
		
		echo "<td class = \"fond-actions\" nowrap>";
				echo "<input type=\"submit\" name=\"valid_etab1\" value=\">> &eacute;tape 4\"/>";
				echo "<input type=\"hidden\" name=\"typelieu\" value=\"1\"/>";
				echo "<input type=\"hidden\" name=\"Suivant2\" value=\"XX\"/>";

		echo "</td>";

		//echo "<tr><td><p>Indiquez le numéro de salle:&nbsp;</p></td><td><input type=\"text\" name=\"numsalle1\" size=\"35\"</td></tr>";

		echo "</form>";
	}
	else //on affiche toute la lisqte des établissement triés par ville
	{
		$requete_etab="SELECT * FROM etablissements Order by VILLE;";
		$result_etab=mysql_query($requete_etab);

		echo "<form method=\"post\"><center>";
		echo "<td class = \"etiquette\">&Eacute;tape 3&nbsp;:&nbsp;Choisir un lieu dans la liste&nbsp;:&nbsp;</td>";
		echo "<td>";
			echo "<select name=\"etab\">";
				while ($ligne_etab=mysql_fetch_assoc($result_etab))
				{
					$type=$ligne_etab["TYPE"];
					$nomE=$ligne_etab["NOM"];
					$idE=$ligne_etab["RNE"];
					$ville2=$ligne_etab["VILLE"];
					echo '<OPTION value="'.$idE.'">'.$ville2.'&nbsp;-&nbsp;'.$type.'&nbsp; &nbsp;'.$nomE.'&nbsp;&nbsp;('.$idE.')</option>';
				}
			echo "</select>";
		echo "</td>";

		//echo "<td>Indiquez le numéro de salle:&nbsp;</td>";
		//echo "<td><input type=\"text\" name=\"numsalle2\" size=\"35\"</td>";
		echo "<td class = \"fond-actions\" nowrap>";
			echo "<input type=\"submit\" name=\"valid_etab2\" value=\">> &eacute;tape 4\"/>";
		echo "</td>";
	echo "</tr>";
	echo "<input type=\"hidden\" name=\"typelieu\" value=\"1\"/>";
	echo "<input type=\"hidden\" name=\"Suivant2\" value=\"XX\"/>";

	echo "</form>";
		}
	}

	if(isset($_POST["valid_etab1"]))
	{
		@$idE=$_POST["etab"];
		@$numsalle1=$_POST["numsalle1"];
 
		$requete1 = "INSERT INTO `om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES ('', '$idE', '', '$numsalle1');";
		echo "<br />$requete1";
		$result1 = mysql_query($requete1, $connexion);

		echo 'ça marche pour les établissements';
	}

	if(isset($_POST["valid_etab2"]))
	{
		@$idE=$_POST["etab"];
		@$numsalle2=$_POST["numsalle2"];

		$requete2 = "INSERT INTO `om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES ('', '$idE', '', '$numsalle2');";
		echo "<br />$requete2";
		$result2 = mysql_query($requete2, $connexion);

		echo 'ça marche pour le répertoire !!!!!!!!!!';
	}
?>
