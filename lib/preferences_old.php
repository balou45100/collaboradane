<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
?>

<!DOCTYPE HTML>
 
<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
		$largeur_tableau = "80%";
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
    	?>
	</head>
	<!"Pour protéger les couleur des liens des boutons"
	"Choix de la couleur blanche, car sinon il apparait un carré de couleur moche autour des images"
	"Correspondant à la suppression et à la modification">
	<body link="#48D1CC" Vlink="#48D1CC">
		<CENTER>
		
		<?php
			$autorisation_gestion_materiels = verif_appartenance_groupe(8);
			echo "<h2>Pr&eacute;f&eacute;rences pour le tableau de bord - <A HREF=\"reglages.php\" class = \"bouton\">Informations personnelles</A></h2>";
		// On teste s'il s'agit d'une mise à jour ou d'une insertion
		$util="SELECT * FROM preference WHERE ID_UTIL = $id;";
		$execution= mysql_query($util);
		$num_results = mysql_num_rows($execution);
		if($num_results == "1") //L'utilisateur a dèjà renseigné ses préférence
		{
			while($donnees=mysql_fetch_array($execution))
			{
				// Affectation des données récupérées dans des variables
				// Pour les tickets
				if ($donnees['tri_tick']== "1")
				{
					$tri_tick="Priorité";
				}
				else
				{
					if ($donnees['tri_tick'] == "2")
					{
						$tri_tick="Date dernière réponse";
					}
					else
					{
						$tri_tick="Date de création";
					}
				}
				// Statut du ticket
				if ($donnees['statut']== "Tous")
				{
					$statut="Tous";
				}
				else
				{
					if ($donnees['statut'] == "N")
					{
						$statut="Nouveau";
					}
					else
					{
						if ($donnees['statut'] == "T")
						{
							$statut="Transféré";
						}
						else
						{
							$statut="En cours";
						}
					}
				}

				// Pour les tâches
				if ($donnees['tri_tac']== "0")
				{
					$tri_tac="Toutes";
				}
				else
				{
					if ($donnees['tri_tac'] == "1")
					{
						$tri_tac="Privées";
					}
					else
					{
						$tri_tac="Publiques";
					}
				}
				// Pour les catégories
				// Dans le cas où l'utilisateur a saisi "Toutes" = 0 dans la BDD
				if ($donnees['categorie'] == "0")
				{
					$categorie = "Toutes";
				}
				else
				{
					$categorie = "NON";
					// Récupération de la catégorie COMMUNE souhaitée si elle existe
					$query="SELECT intitule_categ FROM categorie_commune where id_categ = ".$donnees['categorie'].";";
					$execution = mysql_query ($query);
					while($results = mysql_fetch_array($execution))
					{
						$categorie = $results['intitule_categ'];
					}
					// Si la catégorie est personnelle...
					if ($categorie == "NON")
					{
						$query="SELECT nom FROM categorie where id_categ = ".$donnees['categorie'].";";
						$execution=mysql_query($query);	
						while($recup=mysql_fetch_array($execution))
						{
							$categorie=$recup['nom'];
						}
					}
				}
				// Pour les infos modules
				if ($donnees['pers_form']=="Tout")
				{
					$pers_form="Nouvelle saisie et modification";
				}
				else
				{
					if ($donnees['pers_form']=="Nsaisie")
					{
						$pers_form="Nouvelle saisie";
					}
					else
					{
						$pers_form="Modification";
					}
				}
				$nb_j_tache=$donnees['nb_j_tache'];
				$nb_j_tache_av=$donnees['nb_j_tache_av'];
				$nb_j_alerte=$donnees['nb_j_alerte'];
				$nb_j_alerte_av=$donnees['nb_j_alerte_av'];
				$nb_j_ech=$donnees['nb_j_ech'];
				$nb_j_pret=$donnees['nb_j_pret'];
				$nb_j_pret_av=$donnees['nb_j_pret_av'];
				$largeur_tableau = "40%";
				
				//echo "<br>";
				echo"<form method = GET action = option2.php>";
				//echo "Vous pouvez ici modifier les préférences d'affichage de votre tableau de bord";
				//echo "<br>";

				echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Tickets</h3></caption>
					<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Trier par&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=tri_tick>";
							$donnees=$tri_tick;
								test_option_select ($donnees,"Priorité","1");
								test_option_select ($donnees,"Date dernière réponse","2");
								test_option_select ($donnees,"Date de création","3");
							echo"</select>";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Statut traitement&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=statut>";
							$donnees=$statut;
								test_option_select ($donnees,"Tous","Tous");
								test_option_select ($donnees,"Nouveau","N");
								test_option_select ($donnees,"Transféré","T");
								test_option_select ($donnees,"En cours","C");
							echo"</select>";
 						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Alertes tickets&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_alerte_av size=3 maxlength=3 value=".$nb_j_alerte_av."> jour(s) avant<br />
							<input type=int name=nb_jours_alerte size=3 maxlength=3 value=".$nb_j_alerte."> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
 						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
				 	<TR class = \"td-bouton\">
						<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
					</TR>
   	        	</TABLE>";

				echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Suivi des t&acirc;ches</h3></caption>
					<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Filtr&eacute;es sur&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=tri_tac>";
							$donnees=$tri_tac;
								test_option_select ($donnees,"Toutes","0");
								test_option_select ($donnees,"Privées","1");
								test_option_select ($donnees,"Publiques","2");
							echo"</select>";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_tache_av size=3 maxlength=3 value=".$nb_j_tache_av."> jour(s) avant<br />
							<input type=int name=nb_jours_tache size=3 maxlength=3 value=".$nb_j_tache."> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
				 	<TR class = \"td-bouton\">
						<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
					</TR>
   	        	</TABLE>";
				if ($autorisation_gestion_materiels == 1)
				{
					echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Garanties des mat&eacute;riels</h3></caption>
						<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
						<TR class = \"td-bouton\">
							<TD class = \"td-1\"></TD>
							<TD bgcolor = $fd_cel_etiq>Ech&eacute;ance&nbsp;:&nbsp;</TD>
							<TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "dans <input type=int name=nb_jours_echeance_gar size=3 maxlength=3 value=".$nb_j_ech."> jour(s)";
							echo "</TD>
							<TD class = \"td-1\"></TD>
						</TR>
						<TR class = \"td-bouton\">
							<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
						</TR>
					</TABLE>";

					echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Suivi des pr&ecirc;ts des mat&eacute;riels</h3></caption>
						<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
						<TR class = \"td-bouton\">
							<TD class = \"td-1\"></TD>
							<TD bgcolor = $fd_cel_etiq>Ech&eacute;ance&nbsp;:&nbsp;</TD>
							<TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_echeance_pret_av size=3 maxlength=3 value=".$nb_j_pret_av."> jour(s) avant<br />
							<input type=int name=nb_jours_echeance_pret size=3 maxlength=3 value=".$nb_j_pret."> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
							echo "</TD>
							<TD class = \"td-1\"></TD>
						</TR>
						<TR class = \"td-bouton\">
							<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
						</TR>";
					echo "</TABLE>";
   	        	} //Fin if ($autorisation_gestion_materiels == 1)
			} //Fin while($donnees=mysql_fetch_array($execution))
			echo "<br />";
			echo "<input type=submit value=Modifier a href = option2.php>";
			echo "</form>";
		} //Fin if($num_results == "1")
		else //la fiche de préférence n'existe pas encore
		{
			echo "<br />";
			echo"<form method =get action=option2.php>";
			echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Tickets</h3></caption>
					<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Trier par&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=tri_tick>";
							$donnees=$tri_tick;
								test_option_select ($donnees,"Priorité","1");
								test_option_select ($donnees,"Date dernière réponse","2");
								test_option_select ($donnees,"Date de création","3");
							echo"</select>";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Statut traitement&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=statut>";
							$donnees=$statut;
								test_option_select ($donnees,"Tous","Tous");
								test_option_select ($donnees,"Nouveau","N");
								test_option_select ($donnees,"Transféré","T");
								test_option_select ($donnees,"En cours","C");
							echo"</select>";
 						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Alertes tickets&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_alerte_av size=3 maxlength = 3 value = 7> jour(s) avant<br />
							<input type=int name=nb_jours_alerte size=3 maxlength=3 value = 7> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
 						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
				 	<TR class = \"td-bouton\">
						<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
					</TR>
   	        	</TABLE>";

				echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Suivi des t&acirc;ches</h3></caption>
					<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Filtr&eacute;es sur&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>
							<select name=tri_tac>";
							$donnees=$tri_tac;
								test_option_select ($donnees,"Toutes","0");
								test_option_select ($donnees,"Privées","1");
								test_option_select ($donnees,"Publiques","2");
							echo"</select>";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
    	            <TR class = \"td-bouton\">
        	        	<TD class = \"td-1\"></TD>
				 	    <TD bgcolor = $fd_cel_etiq>Date d'&eacute;ch&eacute;ance&nbsp;:&nbsp;</TD>
			 		    <TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_tache_av size=3 maxlength=3 value=7> jour(s) avant<br />
							<input type=int name=nb_jours_tache size=3 maxlength=3 value=7> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
						echo "</TD>
						<TD class = \"td-1\"></TD>
					</TR>
				 	<TR class = \"td-bouton\">
						<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
					</TR>
   	        	</TABLE>";
				if ($autorisation_gestion_materiels == 1)
				{
					echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Garanties des mat&eacute;riels</h3></caption>
						<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
						<TR class = \"td-bouton\">
							<TD class = \"td-1\"></TD>
							<TD bgcolor = $fd_cel_etiq>Ech&eacute;ance&nbsp;:&nbsp;</TD>
							<TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "dans <input type=int name=nb_jours_echeance_gar size=3 maxlength=3 value=7> jour(s)";
							echo "</TD>
							<TD class = \"td-1\"></TD>
						</TR>
						<TR class = \"td-bouton\">
							<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
						</TR>
					</TABLE>";

					echo "<TABLE BORDER=\"0\" BGCOLOR = $fd_tab cellpadding=\"3\" cellspacing=\"5\" width = \"$largeur_tableau%\">
						<caption><h3>Suivi des pr&ecirc;ts des mat&eacute;riels</h3></caption>
						<TR><TD class = \"td-1\" colspan=\"4\"></TD></TR>
						<TR class = \"td-bouton\">
							<TD class = \"td-1\"></TD>
							<TD bgcolor = $fd_cel_etiq>Ech&eacute;ance&nbsp;:&nbsp;</TD>
							<TD class = \"td-1\" bgcolor = $fd_cel_donnee>";
							echo "<input type=int name=nb_jours_echeance_pret_av size=3 maxlength=3 value=7> jour(s) avant<br />
							<input type=int name=nb_jours_echeance_pret size=3 maxlength=3 value=7> jour(s) apr&egrave;s<br />la date d'aujourd'hui";
							echo "</TD>
							<TD class = \"td-1\"></TD>
						</TR>
						<TR class = \"td-bouton\">
							<TD colspan=\"4\" class = \"td-1\"><INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\"></TD>
						</TR>";
					echo "</TABLE>";
   	        	} //Fin if ($autorisation_gestion_materiels == 1)

				echo "<br />";
				echo "<input type = submit value = Valider a href = option2.php>";
				echo "</form>";
				echo "<br />";
				echo "<br />";
		}		
		//Fin d'insertion du code
	 ?>
		</center>
		</body>
		</html>
