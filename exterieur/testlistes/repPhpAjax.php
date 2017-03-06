<?php
// script PHP interrogation Base de donnees pour reponse a la requette AJAX
include ("config.php");

// Connexion a la base de donnees  
	$AccesBase = mysql_connect($host,$Login,$Pass);
	mysql_select_db($DB,$AccesBase);
	$QuestionBase = "SELECT num, nom FROM ext_titre  WHERE num_pere=".$_POST['val_sel']." ORDER BY num ASC " ;
	$result_recherche=mysql_db_query($DB, $QuestionBase) or die (mysql_error());
// construction de la liste deroulante
if (mysql_num_rows($resultat)>0)
{	
$aff=="";
$aff=$aff."Sous-titre:<br>
		<select name='niv1' id='cont_list2' >";
		while ($row=mysql_fetch_assoc($result_recherche)){
			$aff.="<option value='".$row['num']."'>".$row['nom']."</option>"; 
		}
	$aff=$aff."</select><br><br>";
// envoi reponse Php a Ajax	
	echo $aff;
	}
?>