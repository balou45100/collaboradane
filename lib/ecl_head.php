<?php
	//Lancement de la session
	session_start();
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

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
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	//include("../biblio/ticket.css");
	include ("../biblio/config.php");

	echo "</head>
	<body class = \"menu-boutons\">
		<div align =\"center\">";

	include ("../biblio/init.php");
	echo "<form action = \"ecl_gestion_ecl.php\" target = \"body\" METHOD = \"GET\">";
				
				//Choix des filtres      
            $requeteliste_dep="SELECT DISTINCT TYPE_ETAB_GEN FROM etablissements ORDER BY TYPE_ETAB_GEN";
		        $result=mysql_query($requeteliste_dep);
		        $num_rows = mysql_num_rows($result);
		        
		        //echo "requete : $requeteliste_dep";
		        
            echo "Type&nbsp;:&nbsp;<select size=\"1\" name=\"filtre\">";
           
            if (mysql_num_rows($result))
            {
              
			       echo "<option selected value=\"T\">Tous</option>";
			       while ($ligne=mysql_fetch_object($result))
             {
			          $type=$ligne->TYPE_ETAB_GEN;
				        echo "<option value=\"$type\">$type</option>";
			       }
		        }
            echo "</select>"; 
            
            echo "&nbsp;&nbsp;Secteur&nbsp;:&nbsp;<select size=\"1\" name=\"secteur\">
		          <option selected value=\"T\">Tous</option>
			        <option value=\"PU\">Public</option>
			        <option value=\"PR\">Priv&eacute;</option>
			        </select>";
			      echo "</td>";
						
        //Choix du champs acad&eacute;mique ou d&eacute;partemental
				    
            echo "&nbsp;&nbsp;D&eacute;partement&nbsp;:&nbsp;<select size=\"1\" name=\"dep\">
		          <option selected value=\"T\">Tous</option>
			        <option value=\"18\">Cher (18)</option>
			        <option value=\"28\">Eure-et-Loire (28)</option>
			        <option value=\"36\">Indre (36)</option>
			        <option value=\"37\">Indre-et-Loire (37)</option>
			        <option value=\"41\">Loir-et-Cher (41)</option>
			        <option value=\"45\">Loiret (45)</option>
			        </select>";
			      echo "</td>";
						
				//Champ pour une recherche avec entr&eacute;e libre
				
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D&eacute;tail&nbsp;:&nbsp; 
				<input type = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";
				
				//echo "&nbsp;&nbsp;<input type = \"checkbox\" NAME = \"tbi\" VALUE = \"O\">&nbsp;TBI";
			  
				echo "&nbsp;&nbsp;<input type = \"checkbox\" NAME = \"etat_ouvert_ferme\" VALUE = \"F\">&nbsp;ferm&eacute;";
				
			/*
				//Affichage des liens en fonction du statut de la personne connect&eacute;
				if($_SESSION['droit'] == "Super Administrateur")
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Fonctions&nbsp;:&nbsp;</b>
            &nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes r&eacute;glages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"R&eacute;glages\" border=\"0\"></a>
            &nbsp;&nbsp;<a href = \"gestion_user.php?indice=0\" target = \"body\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></a>
            &nbsp;&nbsp;<!--A HREF = \"cadre_gestion_ecl.php?tri=T&amp;indice=0\" target = \"body\" class=\"bouton\" title=\"Etablissements / Ecoles\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"Etabs/Ecoles\" border=\"0\"></A-->
            &nbsp;&nbsp;&nbsp;<a href = \"verif_coherence_base.php?taf=verifier\" target = \"body\" class=\"bouton\" title=\"V&eacute;rification de la base de donn&eacute;es\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Coh&eacute;rence BDD\" border=\"0\"></a>
            ";
				}
				else
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Fonctions&nbsp;:&nbsp;</b>
              &nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></a>
              &nbsp;&nbsp;<!--A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes r&eacute;glages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"R&eacute;glages\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"cadre_gestion_ecl.php?tri=T&amp;indice=0\" target = \"body\" class=\"bouton\" title=\"Etablissements / Ecoles\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"Etabs/Ecoles\" border=\"0\"></A-->
              ";
				}
				*/
				echo "&nbsp;&nbsp;&nbsp;dans&nbsp;:&nbsp;";
				echo "<select size=\"1\" name=\"dans\">";
					echo "<option value=\"T\">tous</option>";
					echo "<option value=\"N\">D&eacute;nomination</option>";
					echo "<option value=\"V\">Ville</option>";
					echo "<option value=\"M\">M&eacute;l</option>";
					echo "<option value=\"RNE\">RNE</option>";
				echo "</select>";
/*
				echo "<input type = \"radio\" NAME = \"dans\" VALUE = \"T\" checked value=\"T\">&nbsp;Tout";
				echo "<input type = \"radio\" NAME = \"dans\" VALUE = \"N\">&nbsp;D&eacute;nomination";
				echo "<input type = \"radio\" NAME = \"dans\" VALUE = \"V\">&nbsp;Ville";
				echo "<input type = \"radio\" NAME = \"dans\" VALUE = \"M\">&nbsp;M&eacute;l";
				echo "<input type = \"radio\" NAME = \"dans\" VALUE = \"RNE\">&nbsp;RNE";
*/
				echo "<input type = \"hidden\" NAME = \"indice\" VALUE = \"0\">";
				echo "<input type = \"hidden\" NAME = \"entete\" VALUE = \"0\">";
				echo "&nbsp;&nbsp;&nbsp;";
				echo "<input type = \"submit\" VALUE = \"Afficher\">";
				echo "</form>";
			?>
		</div>
	</body>
</html>

