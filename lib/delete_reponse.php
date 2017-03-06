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

	echo "<html>
	<head>
		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";
		echo "<body>
		<div align = \"center\">";
			//R&eacute;cup&eacute;ration de l'identifiant concernant le ticket &agrave; supprimer
			$idrep = $_GET['idrep'];
			$idpb = $_GET['idpb'];
			$tri = $_GET['tri'];
			//Test du champ r&eacute;cup&eacute;r&eacute;
			if(!isset($idrep) || $idrep == "")
			{
				echo "<b>Probl&egrave;mes de r&eacute;cup&eacute;ration de la variable</b>";
				echo "<br /><br /><a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb."\" target = \"body\" class = \"bouton\">Retour &agrave; la Gestion des cat&eacute;gories</a>";
				exit;
			}
			//Inclusion des fichiers n&eacute;cessaires	
			include("../biblio/init.php");
			//R&eacute;cup&eacute;ration des donn&eacute;es r&eacute;sumant le ticket pour proc&eacute;der &agrave; sa suppression ou non
			$query = "SELECT * FROM probleme WHERE id_pb = '".$idrep."';";
			$results = mysql_query($query);
			if(!$results)
			{
				echo "<b>probl&egrave;me lors de l'execution de la requ&egrave;te</b>";
				echo "<a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb."\" target = \"body\" class =\"bouton\">Retour au ticket</a>";
				mysql_close();
				exit;
			}
			$res = mysql_fetch_row($results);
			echo "<h2>Voulez-vous vraiment supprimer cette r&eacute;ponse&nbsp;?</h2>";
			echo "<table width=\"95%\">";
			//echo "<form action = \"consult_ticket.php\" METHOD = \"GET\">";
				echo "<tr>";
					echo "<td class = \"etiquette\" width=\"10%\">N°&nbsp;:&nbsp;</td>";
					echo "<td width = \"10%\">&nbsp;$res[0]</td>";
					echo "<td class = \"etiquette\" width=\"10%\">cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
					echo "<td width=\"20%\">&nbsp;$res[3]</td>";
					echo "<td class = \"etiquette\" width=\"10%\">cr&eacute;&eacute; le&nbsp;:&nbsp;</td>";
					echo "<td width=\"40%\">&nbsp;$res[7]</td>";

				echo "<tr>";
					echo "<td class = \"etiquette\" >Contenu&nbsp;:&nbsp;</td>";
					echo "<td colspan=\"6\">$res[6]</td>";
				echo "</tr>";
			echo "</table>";
			//echo "<table width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";	

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb."\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"retour\" border = \"0\"></a>";
								echo "<br /><span class=\"IconesAvecTexte\">Retour</span>";
							echo "</td>";
							echo "<td>";
								echo "<a href = \"confirm_suppr_reponse.php?tri=$tri&amp;idrep=".$idrep."&amp;idpb=".$idpb."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></a>";
								echo "<br /><span class=\"IconesAvecTexte\">Confirmer la suppression</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";


			mysql_close();
?>
		</div>
	</body>
</html>
					
