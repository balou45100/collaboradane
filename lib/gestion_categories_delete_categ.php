<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><h2>$message_non_connecte1</h2></center>";
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

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
				//Récupération de l'identifiant concernant la catégorie à supprimer
				$id_categ = $_GET['id_categ'];
				
				//Test du champ récupéré
				if(!isset($id_categ) || $id_categ == "")
				{
					echo "<h2>Probl&egrave;mes de r&eacute;cup&eacute;ration des variables</h2>";
					echo "<BR><BR><A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class = \"bouton\">Retour &agrave; la gestion des cat&eacute;gories</A>";
					exit;
				}
				
				//Inclusion des fichiers nécessaires	
				include("../biblio/init.php");
				
				
				//Récupération des données résumant la catégorie pour procéder à sa suppression ou non
				$query = "SELECT * FROM categorie WHERE id_categ = '".$id_categ."';";
				$results = mysql_query($query);
				if(!$results)
				{
					echo "<h2>Probl&egrave;me lors de l'ex&eacute;cution de la requ&ecirc;te</h2>";
					echo "<A HREF = \"gestion_categories.php?id_categ=-1\" target = \"body\" class =\"bouton\">Retour &agrave; la gestion des cat&eacute;gories</A>";
					mysql_close();
					exit;
				}
					
				$res = mysql_fetch_row($results);
					
				echo "<h2>Voulez-vous vraiment supprimer cette cat&eacute;gorie&nbsp;?</h2>
				<FONT COLOR = \"red\">
				Toutes les sous-cat&eacute;gories seront &eacute;galement supprim&eacute;es&nbsp;!
				</FONT><BR>
				<TABLE BORDER = \"1\">
				<TR>
					<TD class = \"etiquette\">Intitul&eacute;&nbsp;:&nbsp;</TD>
					<TD>&nbsp;".$res[1]."&nbsp;</TD>
				</TR>
				<TR>
					<TD class = \"etiquette\">Informations diverses&nbsp;:&nbsp;</TD>
					<TD>&nbsp;".$res[4]."&nbsp;</TD>
				</TR>
				</TABLE>
				<BR>";
				/*
				echo "<A HREF = \"confirm_suppr_categ.php?id_categ=".$id_categ."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"oui\"></A>
				&nbsp;<A HREF = \"gestion_categories.php?id_categ=-1\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"non\"></A>";
				*/
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_categories.php?id_categ=$res[6]\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
						echo "</td>";
							echo "<td>";
							echo "&nbsp;<A HREF = \"gestion_categories_confirm_suppr_categ.php?id_categ=".$id_categ."&amp;id_categ_pere=$res[6]\"><IMG src = \"$chemin_theme_images/supprimer.png\" ALT = \"oui\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Suppression<br />d&eacute;finitive</span><br />";
						echo "</TD>";
					echo "</tr>";
				echo "</table>";
					
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
					
