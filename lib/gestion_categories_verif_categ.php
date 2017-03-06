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
				//Récupération des données du formulaire
				$nom = $_POST['nom'];
				$contenu = $_POST['contenu'];
				$statut = $_POST['stat'];
								
				//Test des champs récupérés
				if(!isset($nom) || !isset($contenu) || $nom == "" || !isset($statut))
				{
					echo "<h2>Veuillez renseigner le nom de la cat&eacute;gorie</h2>";
					echo "
						<FORM ACTION = \"gestion_categories_verif_categ.php\" METHOD = \"POST\">
							<TABLE BORDER = \"0\">
								<TR>
									<TD class = \"etiquette\">
										Nom de la catégorie
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" NAME = \"nom\" VALUE = \"".$nom."\" SIZE = \"40\">
										<INPUT TYPE = \"hidden\" NAME = \"stat\" VALUE = \"".$statut."\">";
										$id_categ = $_POST['id_categ'];
										if(!isset($id_categ) || $id_categ == "")
										{
											echo "<h2>Problème sur la transmission de données du formulaire.</h2>";
											echo "<h2>Veuillez contacter votre administrateur.</h2>";
											echo "<A HREF = \"gestion_categories.php?id_categ=-1\" TARGET = \"body\" class = \"bouton\"><BR>Retour à la gestion des catégories</A>";
											exit;
										}
										echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ\" VALUE = \"".$id_categ."\">";
										echo "<INPUT TYPE = \"hidden\" NAME = \"stat\" VALUE = \"M\">";
										echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ\" VALUE = \"".$res[0]."\">";
										echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ_pere\" VALUE = \"".$res[6]."\">";
									echo"</TD>
								</TR>
								<TR>
									<TD class = \"etiquette\">
										Info complémentaire
									</TD>
									<TD class = \"td-1\">
										<TEXTAREA ROWS = \"10\" COLS = \"90\" NAME = \"contenu\">".$contenu."</TEXTAREA>
									</TD>
								</TR>";
/*
								echo "<TR>
									<TD class = \"td-1\">
										<INPUT TYPE = \"submit\" VALUE = \"Ok\">
									</TD>
								</TR>";
*/
							echo "</TABLE>";
							echo "<table class = \"menu-boutons\">";
								echo "<tr>";
									echo "<td>";
										echo "<a href = \"gestion_categories.php?id_categ=$res[6]\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
									echo "</td>";
									echo "<td>";
										echo "&nbsp;<INPUT border=0 src = \"$chemin_theme_images/enregistrer.png\" ALT = \"Enregistrer\" title=\"enregistrer\" border=\"0\" type=image Value=\"Enregistrer les modifications\"align=\"middle\"><br /><span class=\"IconesAvecTexte\">Enregistrer<br />les modifications</span><br />";
									echo "</TD>";
								echo "</tr>";
							echo "</table>";
						echo "</FORM>
					</CENTER>";
						exit;
				}

				//Dans le cas d'une modification
				//Récupération des données du formulaire
				$id_categ = $_POST['id_categ'];
				$id_categ_pere = $_POST['id_categ_pere'];

				//Test du champ récupéré
				if(!isset($id_categ) || $id_categ == "")
				{
					echo "<h2>Problème sur la transmission de données du formulaire père.</h2>";
					echo "<h2>Veuillez contacter votre administrateur.</h2>";
					echo "<A HREF = \"gestion_categories.php?id_categ=-1\" TARGET = \"body\" class = \"bouton\"><BR>Retour à la gestion des catégories</h2></A>";
					mysql_close();
					exit;
				}

				$query = "UPDATE categorie SET
					NOM = '".$nom."',
					INFO_DIVERS = '".$contenu."',
					DATE_MODIF = '".date('j/m/Y')."'
					WHERE ID_CATEG = '".$id_categ."';";				

				$results = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results)
				{
					echo "<h2>Problème sur l'excution de la requète.</h2>";
					echo "<h2>Veuillez contacter votre administrateur.</h2>";
					echo "<A HREF = \"gestion_categories.php?id_categ=-1\" TARGET = \"body\" class = \"bouton\"><BR>RRRRRetour à la gestion des cat&eacute;gories</h2></A>";
					mysql_close();
					exit;
				}
				echo "<h2>Les modifications ont bien &eacute;t&eacute; prises en compte</h2>";
				
				//echo "<BR><h2><A HREF = \"gestion_categories.php?id_categ=".$id_categ_pere."\" TARGET = \"body\" class = \"bouton\"><BR>Retour à la gestion des catégories</A></h2>";
				echo "<table class = \"menu-boutons\">";
					echo "<tr>";
						echo "<td>";
							echo "<a href = \"gestion_categories.php?id_categ=$id_categ_pere\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</tr>";
				echo "</table>";
				mysql_close();
?>
		</CENTER>
	</BODY>
</HTML>
