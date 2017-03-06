<?php
	//Lancement de la session
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
?>

<!DOCTYPE HTML>
  
<html>
	<head>
  		<title>CollaboraDANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>

		<body>
			<h2>Saisie d'une r&eacute;union </h2>

<?php
	
	//include ("../biblio/config.php");
	//include ("../biblio/init.php");
	//include ("../biblio/fct.php");
	/*

	$typelieu = $_POST['typelieu'];
	$suivant = $_POST['suivant'];
	$suivant2 = $_POST['Suivant2'];
	*/
	/*
	echo "<br />chemin_theme_images : $chemin_theme_images'";
	echo "<br />typelieu : $typelieu";
	echo "<br />suivant : $suivant";
	echo "<br />suivant2 : $suivant2";
	*/


	echo "<center>";
		echo "<form method=\"post\" >";
			echo "<table border=1 cellpading=10>";
				echo "<tr>";
					echo "<td class = \"etiquette\">&Eacute;tape 1&nbsp;:&nbsp;Choisir une structure&nbsp;:&nbsp;</p></td>";
					echo "<td>";
						echo "<SELECT name=\"typelieu\" size=\"1\">";
							echo "<OPTION value=\"1\" selected>Structure &Eacute;ducation nationale</option>";
							//echo "<OPTION value=\"2\">Structure priv&eacute;e</option>";
							//echo "<OPTION value=\"3\">Nouveau lieu</option>";
						echo "</SELECT>";
					echo "</td>";
				   echo "<td class = \"fond-actions\" nowrap>";
					 echo "<input type=\"submit\" name=\"Suivant2\" value=\">>&nbsp;&eacute;tape 2\"/>";
				   echo "</td>";
				echo "</tr>";

		echo "</form>";

////////##############################################################################################################//////

		if(isset($_POST["Suivant2"]))
		{
			//echo "<br />boucle suivant2";
			//debut des attributs
			@$typelieu=isset($_POST["typelieu"]) ? $_POST["typelieu"] : '';
			//fin des attributs

			if ($typelieu == 1) //il s'agit d'une structure EN
			{
				$list0 = "";
				$list1 = "";

				//########### Listes déroulantes: trouver un établissement ###########

				include 'om_etablissements.inc.php';

////////##############################################################################################################//////
			}
			else
			{
				if ($typelieu == 2) //il s'agit d'une structure privée
				{
					// Listes déroulantes: trouver un lieu dans le répertoire
					include 'om_repertoire.inc.php';
				}
				 else
				{
					if ($typelieu == 3) //Il faut créer un nouveau lieu
					{
						$list0 = "";
						$list1 = "";

						//########### Formulaire d'ajout d'un nouveau lieu ###########
						include 'om_formulairelieu.inc.php';
					}
				}
			}
		}
		echo "</table>";
	echo "</center>";
?>
</body>
</html>
