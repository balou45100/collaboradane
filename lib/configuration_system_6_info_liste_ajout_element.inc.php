<?php
	echo "<h1>&nbsp;</h1>";
	//echo "<h2>Ajout d'un nouvel &eacute;l&eacute;ment &agrave; la liste</h2>";
	$nom_table = $_GET['nom_table'];
	
	//On interroge la table
	$requete="SELECT * FROM $nom_table";
	
	//echo "<br />requete : $requete<br />";
	
	$result=mysql_query($requete);
	
	//On récupère le nombre de colonnes de la table
	$nbr_colonnes = mysql_num_fields($result); 

	///////////////////////////////////////
	$req = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = $nom_table";
	$rest=mysql_query($req);
	
	///////////////////////////////////////
	
	//Avec le formatage des formulaires monForm
	echo "<form id=\"monForm\" action=\"configuration_systeme_6.php\" method=\"get\">";
		echo "<fieldset>";
		echo "<legend>Ajout d'un nouvel &eacute;l&eacute;ment dans la table &laquo;&nbsp;$nom_table&nbsp;&raquo;</legend>";
			//On récupère les intitulés et ajoute un champ de saisie de la valeur
			
			//On récupère tous les intitulés des colonnes et les affichent
			for ($i=0; $i<$nbr_colonnes; $i++)
			{
				$champ[$i] = mysql_field_name($result, $i);
				$type[$i] = mysql_field_type($result, $i);
				
				//On affiche les champs en fonction de leur caractéristiques
				if ($i == 0) //Je suis sur le champ de l'identifiant qu'il ne faut pas modifier
				{
					echo "<p>";
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "calcul&eacute; automatiquement";
					echo "</p>";
				}
				elseif ($champ[$i] == "actif") //Le champ est d'office mis à "O"
				{
					echo "<p>";
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "O";
					echo "</p>";
				}
				else //pour tous les autres cas de figures
				{
					echo "<p>";
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "<input type=\"text\" id=\"$champ[$i]\" name=\"champ_saisie[]\" />";
					echo "</p>";
				}
				
			}
		echo "</fieldset>";
		echo "<p>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer\"/>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
			echo "<input type = \"hidden\" VALUE = \"info_liste_enreg_element\" NAME = \"a_faire\">";
			echo "<input type = \"hidden\" VALUE = \"$nom_table\" NAME = \"nom_table\">";
			echo "<input type = \"hidden\" VALUE = \"$nbr_colonnes\" NAME = \"nbr_colonnes\">";
			echo "<input type = \"hidden\" VALUE = \"$champ\" NAME = \"champ\">";
		echo "</p>";
	echo "</form>";
?>
