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
	echo "<body>
		<div align = \"center\">";

			//Inclusion des fichiers nécessaires
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			include ("../biblio/config.php");

			//On vérifie si l'utilisateur connecté a des droits pour le module du script
			$autorisation_[module] = verif_appartenance_groupe(xx);  
			
			//On regarde s'il y a des actions à faire
			$action = $_GET['action'];
			if (!ISSET($action))
			{
				$action = $_POST['action'];
			}

			$a_faire = $_GET['a_faire'];
			if (!ISSET($a_faire))
			{
				$a_faire = $_POST['a_faire'];
			}
			/*
			echo "<br />a_faire : $a_faire";
			echo "<br />action : $action";
			*/
			if ($action == "O")
			{
				switch ($a_faire)
				{
					case "cas 1":
						//echo explication de ce qu'il faut faire
						include ("[page_traitemlent].inc.php");
						$affichage = "N"; //si traitement le nécessite
					break;

					case "cas 2":
						//echo explication de ce qu'il faut faire
						include ("[page_traitemlent].inc.php");
						$affichage = "N"; //si traitement le nécessite
					break;
				} // Fin switch ($a_faire)
			} // Fin if ($action == "O")

			//Début de l'affichage principal
			if ($affichage <> "N")
			{
				echo "<h2>[Titre de la page affichée]</h2>";
					echo "<table>";

					///////////////////////
					// Gestion des pages //
					///////////////////////
					$nb_page = number_format($num_results/$nb_par_page,1);
					//echo "Page&nbsp;<A HREF = \"gestion_user.php?indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
					If ($indice == 0)
					{
						echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
					}
					else
					{
						echo "<a href = \"gestion_user.php?indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
					}

					for($j = 1; $j<$nb_page; ++$j)
					{
						$nb = $j * $nb_par_page;
						$page = $j + 1;
						if ($page * $nb_par_page == $indice + $nb_par_page)
						{
							echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
						}
						else
						{
							echo "&nbsp;<a href = \"[nom_script].php?indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
						}
					}
					$j = 0;
					while($j<$indice)
					{
						$res = mysql_fetch_row($results);
						++$j;
					}

					/////////////////////////
					//Fin gestion des pages//
					/////////////////////////

					//Traitement de chaque ligne
					for ($i = 0; $i < $nb_par_page; ++$i)
					{
						$res = mysql_fetch_row($results);
						echo "<tr>";
							echo "<td> </td>";
						echo "</tr>";
					}
					//Fermeture de la connexion à la BDD
					mysql_close();
				echo "</table>";
			} //Fin if ($affichage <> "N")
?>
		</div>
	</body>
</html>
