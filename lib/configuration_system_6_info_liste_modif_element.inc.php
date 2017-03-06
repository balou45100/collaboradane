<?php
	echo "<h1>&nbsp;</h1>";
	//echo "<h2>Modification de l'&eacute;l&eacute;ment $id_element</h2>";

	//On récupère les informations de l'élément à modifier
	$id_element = $_GET['id'];
	$nom_table = $_GET['nom_table'];
	/*
	echo "<br />id_element : $id_element";
	echo "<br />nom_table : $nom_table";
	*/
	//On interroge la table
	$requete="SELECT * FROM $nom_table";
	$result=mysql_query($requete);
	
	//On récupère le nombre de colonnes de la table
	$nbr_colonnes = mysql_num_fields($result); 
	
	//echo "<br />nbr_colonnes : $nbr_colonnes";

	//On récupère l'intitulé du champ "ID"
	$champ_id = mysql_field_name($result, 0);
	 
	//echo "<br />champ_id : $champ_id";
	
	//On récupère l'élément à modifier
	$requete_modif = "SELECT * FROM $nom_table
		WHERE $champ_id = '".$id_element."';";
			
	//echo "<br />$requete_modif";
	
	$resultat_requete_modif = mysql_query($requete_modif);
	$num_rows = mysql_num_rows($resultat_requete_modif);
	
	//echo "<br />num_rows : $num_rows";
	
	//On récupère les valeurs de l'élément à modifier
	$ligne = mysql_fetch_object($resultat_requete_modif);
	
	//On affiche le formulaire avec le formatage "monForm"
	echo "<form id=\"monForm\" action=\"configuration_systeme_6.php\" method=\"get\">";
		echo "<fieldset>";
		echo "<legend>Modification d'un &eacute;l&eacute;ment dans la table &laquo;&nbsp;$nom_table&nbsp;&raquo;</legend>";
			//On récupère les intitulés et ajoute un champ de saisie de la valeur
			
			//On récupère tous les intitulés des colonnes et les affichent
			for ($i=0; $i<$nbr_colonnes; $i++)
			{
				$champ[$i] = mysql_field_name($resultat_requete_modif, $i);
				$type[$i] = mysql_field_type($resultat_requete_modif, $i);
				$valeur_a_modifier[$i] = $ligne->$champ[$i];
				
				//echo "<br />valeur_a_modifier : $valeur_a_modifier";
				
				//On affiche les champs en fonction de leur caractéristiques
				echo "<p>";
					if ($i == 0) //Je suis sur le champ de l'identifiant qu'il ne faut pas modifier
					{
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "$valeur_a_modifier[$i]";
					}
					elseif ($champ[$i] == "actif") 
					{
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "<select size=\"1\" id=\"champ[$i]\" name=\"champ_saisie[]\">";
						if ($valeur_a_modifier[$i] == "O")
						{
							echo "<option selected value=\"O\">Oui</option>";
							echo "<option value=\"N\">Non</option>";
						}
						else
						{
							echo "<option selected value=\"N\">Non</option>";
							echo "<option value=\"O\">Oui</option>";
						}
					echo "</select>";
					}
					else //pour tous les autres cas de figures
					{
						echo "<label for=\"$champ[$i]\">$champ[$i]&nbsp;($type[$i])&nbsp;:&nbsp;</label>";
						echo "<input type=\"text\" id=\"$champ[$i]\" name=\"champ_saisie[]\" Value = \"$valeur_a_modifier[$i]\" />";
					}
				echo "</p>";
				
			}
		echo "</fieldset>";
		echo "<p>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Enregistrer\"/>";
			echo "<input type=\"submit\" name=\"bouton_envoyer_modif\" Value = \"Retourner sans enregistrer\"/>";
			echo "<input type = \"hidden\" VALUE = \"O\" NAME = \"action\">";
			echo "<input type = \"hidden\" VALUE = \"info_liste_enreg_modif_element\" NAME = \"a_faire\">";
			echo "<input type = \"hidden\" VALUE = \"$nom_table\" NAME = \"nom_table\">";
			echo "<input type = \"hidden\" VALUE = \"$nbr_colonnes\" NAME = \"nbr_colonnes\">";
			echo "<input type = \"hidden\" VALUE = \"$id_element\" NAME = \"id_element\">";
		echo "</p>";
	echo "</form>";
?>
