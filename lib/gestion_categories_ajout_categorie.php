<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
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

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			//include ("../biblio/javascripts.php");
			//include ("../biblio/fct.php");
			//include ("../biblio/init.php");
	echo "<body>
		<div align = \"center\">";
		
	//Variable définissant l'identifiant de la catégorie père
	@$id_categ = $_GET['id_categ'];
	
	//Par defaut si la valeur n'est pas renseigné, on assujettit par defaut le chiffre -1
	//Qui correspond à la racine des catégories
	if(!isset($id_categ) || $id_categ == "")
	{
		$id_categ = "-1";
	}
?>
	<h2>Ajout d'une cat&eacute;gorie</h2>
	<FORM ACTION = "verif_categ.php" METHOD = "POST">
				<TABLE BORDER = "0">
					<TR>
						<TD class = "etiquette">Nom de la catégorie&nbsp;:&nbsp;</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" NAME = "nom" VALUE = "" SIZE = "40">
							<INPUT TYPE = "hidden" NAME = "stat" VALUE = "I">
							<?php
								echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ_pere\" VALUE = \"".$id_categ."\">";
							?>
						</TD>
					</TR>
					<TR>
						<TD class = "etiquette">Info compl&eacute;mentaire&nbsp;:&nbsp;</TD>
						<TD class = "td-1">
							<TEXTAREA ROWS = "10" COLS = "90" NAME = "contenu"></TEXTAREA>
						</TD>
					</TR>

					<!--TR>
						<TD class = "td-1">
							<INPUT TYPE = "submit" VALUE = "Ok">
						</TD>
					</TR-->
				</TABLE>
<?php
	echo "<div align = \"center\">";
		echo "<table class = \"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					echo "<a href = \"gestion_categories.php?id_categ=$id_categ\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
				echo "</td>";

				echo "<td>";
					echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer la cat&eacute;gorie\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />la cat&eacute;gorie</span><br />";
				echo "</TD>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
?>
			</FORM>
		</div>
	</BODY>
</HTML>
