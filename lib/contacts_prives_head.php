<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php

	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	include ("../biblio/config.php");

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
			 include ("../biblio/init.php");
				
				echo "<form action = \"contacts_prives_gestion.php\" target = \"body\" METHOD = \"GET\">";
				
				echo "Filtres&nbsp;:&nbsp;
						&nbsp;&nbsp;<a href=\"contacts_prives_gestion.php?filtre=T&amp;indice=0&amp;tri=NOM&amp;sense_tri=ASC&amp;origine_gestion=contacts_prives&amp;categorie=T\" target = \"body\" class=\"bouton\" title=\"Mes contacts priv&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts_prives.png\" ALT = \"Mes contacts priv&eacute;s\" border=\"0\"></a>&nbsp;&nbsp;";
				
       		$requeteliste_cat="SELECT DISTINCT CATEGORIE FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY 'CATEGORIE' ASC";
		        $result=mysql_query($requeteliste_cat);
		        $num_rows = mysql_num_rows($result);
		        
            echo "Cat&eacute;gorie&nbsp;:&nbsp;<select size=\"1\" name=\"categorie\">";
           
            if (mysql_num_rows($result))
            {
              
			       echo "<option selected value=\"T\">Toutes</option>";
			       while ($ligne=mysql_fetch_object($result))
             {
			          $categorie=$ligne->CATEGORIE;
				        echo "<option value=\"$categorie\">$categorie</option>";
			       }
		        }
            echo "</select>"; 
			
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rechercher&nbsp;:&nbsp; 
				<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";
				
				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"dans\">";
					echo "<option value=\"T\">tout</option>";
					echo "<option value=\"N\">Nom</option>";
					echo "<option value=\"V\">Ville</option>";
					echo "<option value=\"M\">M&eacute;l</option>";
					echo "<option value=\"ENTITE\">d'une entit&eacute;</option>";
				echo "</select>";
/*
				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;
				<input type = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;Tout
				<input type = \"radio\" NAME = \"dans\" VALUE = \"N\">&nbsp;Nom
				<input type = \"radio\" NAME = \"dans\" VALUE = \"V\">&nbsp;Ville
				<input type = \"radio\" NAME = \"dans\" VALUE = \"M\">&nbsp;M&eacute;l
				<input type = \"radio\" NAME = \"dans\" VALUE = \"ENTITE\">&nbsp;d'une entit&eacute;";
*/
				echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Afficher\">
				<input type = \"hidden\" VALUE = \"0\" NAME = \"indice\">
				<input type = \"hidden\" VALUE = \"recherche_contacts_prives\" NAME = \"origine_gestion\">
				<input type = \"hidden\" VALUE = \"T\" NAME = \"filtre\">
				<input type = \"hidden\" VALUE = \"NOM\" NAME = \"tri\">
				<input type = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
				</form>";
				
				//Table servant pour les filtres
				
				
			?>
		</center>
	</body>
</html>

