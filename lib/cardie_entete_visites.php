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
  		<title>CARDIE - Visites</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	
		//include("../biblio/ticket.css");
		include ("../biblio/cardie_config.php");
		include ("../biblio/init.php");

	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";

	$util_connecte = $_SESSION['nom'];
	$res=mysql_query ("SELECT DISTINCT id_categ, intitule_categ FROM categorie_commune ORDER BY intitule_categ");
	$nbr = mysql_num_rows($res);
	//echo "<br />nbr : $nbr";
	echo "<form action = \"cardie_gestion_visites.php\" target = \"body\" METHOD = \"GET\">";

		echo "<table style = \"border: 0\">";
			echo "<tr>";
				echo "<td>";
					echo "&nbsp;<b>Filtrer en fonction de l'&eacute;tat d'avancement des visites&nbsp;:&nbsp;</b>";
					//On récupère les intitulés depuis la table cardie_visite_etat
					$requete_visite_etat = "SELECT * FROM cardie_visite_etats";
					$resultat_visite_etat = mysql_query($requete_visite_etat);
					if(!$resultat_visite_etat)
					{
						echo "<h2>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</h2>";
						mysql_close();
						exit;
					}

					//Retourne le nombre de ligne rendu par la requ&egrave;te
					
					echo "<select  size=\"1\" name = \"etat_avancement\">";
						echo "<option value=\"T\" class = \"bleu\">toutes les visites</option>";
							while ($ligne_etat = mysql_fetch_object($resultat_visite_etat))
							{
								$code = $ligne_etat->CODE;
								$intitule_etat = $ligne_etat->INTITULE;
								$code_a_transmettre = "STADE".$code;
								
								echo "<option value=\"$code_a_transmettre\" class = \"bleu\">$intitule_etat</option>";
							}
					echo "</select>";
				echo "</td>";

				echo "<td>";
/*
					echo "&nbsp;<b>Type d'accompagnement&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"type_accompagnement\">";
							echo "<option value=\"T\" class = \"bleu\">tous types</option>";
							echo "<option value=\"NON_DEFINI\">non d&eacute;fini</option>";
							echo "<option value=\"INSITU\">in situ</option>";
							echo "<option value=\"A_DISTANCE\" class = \"bleu\">&agrave; distance</option>";
							echo "<option value=\"RECHERCHE\">par la recherche</option>";
							echo "<option value=\"GROUPE_DEVELOPPEMENT\">par groupe de d&eacute;veloppement</option>";
							echo "<option value=\"EXPERITHEQUE\" class = \"bleu\">dans exp&eacute;rith&egrave;que</option>";
							echo "<option value=\"PARTENARIAL\" class = \"bleu\">partenarial</option>";
						echo "</select>";
*/
						echo "&nbsp;<input type = \"submit\" value = \"Hop !\">";
						echo "<input type = \"hidden\" value = \"entete_visites\" name = \"origine_appel\">";
						echo "<input type = \"hidden\" value = \"Visites\" name = \"mode_affichage\">";
						//echo "<input type = \"hidden\" value = \"Non\" name = \"categorie_commune\">";
						echo "<input type = \"hidden\" value = \"DESC\" name = \"sense_tri\">";
					echo "</form>";
				echo "</td>";
				//echo "<td>&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\"></td>";

/*

				echo "<td>";

				echo "<form action = \"gestion_ticket.php\" target = \"body\" METHOD = \"GET\">";
					echo "&nbsp;<b>cat&eacute;gories communes&nbsp;:&nbsp;</b>";
					echo "<select size=\"1\" name=\"tri\">";
					if (mysql_num_rows($res))
					{
						//echo "<option selected value=\"000\">Toutes</option>";
						while ($ligne=mysql_fetch_object($res))
						{
							$id_categ=$ligne->id_categ;
							$intitule_categ=$ligne->intitule_categ;
							echo "<option value=\"$id_categ\">$intitule_categ</option>";
						}
					}
					echo "</select>";
						echo "&nbsp;<b>&eacute;tat&nbsp;:&nbsp;</b>";
						echo "<select size=\"1\" name=\"etat\">";
							echo "<option value=\"Oui\">actif</option>";
							echo "<option value=\"Non\">archiv&eacute;</option>";
					echo "</select>";
						echo "&nbsp;<input type = \"submit\" value = \"Hop !\">
						<input type = \"hidden\" value = \"0\" name = \"indice\">
						<input type = \"hidden\" value = \"Oui\" name = \"categorie_commune\">
						<input type = \"hidden\" value = \"DESC\" name = \"sense_tri\">";
					echo "</form>";
						echo "</td>";
*/
/*
							echo "<td>";
						echo "&nbsp;<b>Filtres&nbsp;:&nbsp;</b>
						&nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=G&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tous les tickets\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket.png\" ALT = \"Tous\" border=\"0\"></a>
						&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;<a href=\"gestion_ticket.php?tri=NOUV&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Nouveaux tickets\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statut_nouveau.png\" ALT = \"nouveaux\" border=\"0\"></a>
            &nbsp;<a href=\"gestion_ticket.php?tri=TRAITE&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets traitement en cours\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statut_traite.png\" ALT = \"trait&eacute;s\" border=\"0\"></a>
            &nbsp;<a href=\"gestion_ticket.php?tri=TRANS&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets transf&eacute;r&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statut_transfere.png\" ALT = \"transf&eacute;r&eacute;s\" border=\"0\"></a>
            &nbsp;<a href=\"gestion_ticket.php?tri=ATTENTE&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets en attente\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statut_attente.png\" ALT = \"attente\" border=\"0\"></a>
            &nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;<a href=\"gestion_ticket.php?tri=PH&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets avec priorit&eacute; haute\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/attention.png\" ALT = \"Priorit&eacute; haute\" border=\"0\"></a>
            &nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=OTA&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets Orl&eacute;ans-Tours Assistance\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/OTA.png\" ALT = \"OTA\" border=\"0\"></a>
            &nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=Me&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Mes tickets\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/mes_tickets.png\" ALT = \"Mes Tickets\" border=\"0\"></a>
            &nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=MeAa&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Mes tickets &agrave; archiver\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/mes_a_archiver.png\" ALT = \"Mes tickets &agrave; archiver\" border=\"0\"></a>
						&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=REP&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tous les tickets du r&eacute;pertoire\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_repertoire.png\" ALT = \"Tousdu r&eacute;pertoire\" border=\"0\"></a>
						&nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
            &nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=Aa&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tickets &agrave; archiver\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/a_archiver.png\" ALT = \"A archiverTous\" border=\"0\"></a>
						&nbsp;&nbsp;<a href=\"gestion_ticket.php?tri=A&amp;indice=0&amp;categorie_commune=Non\" target = \"body\" class=\"bouton\" title=\"Tous les tickets archiv&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/archive.png\" ALT = \"Tickets archiv&eacute;s\" border=\"0\"></a>";
*/
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
            &nbsp;&nbsp;&nbsp;<a href = \"verif_coherence_base.php?taf=verifier\" target = \"body\" class=\"bouton\" title=\"V&eacute;rification de la base de donn&eacute;es\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Coh&eacute;rence BDD\" border=\"0\"></a>
            ";
				}
				else
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Fonctions&nbsp;:&nbsp;</b>
							&nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Rechercher\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Cat&eacute;gories\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"statistiques.php\" target = \"body\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"reglages.php\" target = \"body\" class=\"bouton\" title=\"Mes r&eacute;glages\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"R&eacute;glages\" border=\"0\"></a>";
				}
				*/
					echo "</td>";
/*
					echo "<td>";
						echo "
              &nbsp;&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/separateur4.png\" border=\"0\">
              &nbsp;&nbsp;<a href = \"rechercher.php\" target = \"body\" class=\"bouton\" title=\"Rechercher un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rechercher-2.png\" ALT = \"Recherche ticket\" border=\"0\"></a>
              &nbsp;&nbsp;<a href = \"gestion_categories.php?id_categ=-1\" target = \"body\" class=\"bouton\" title=\"Gestion des cat&eacute;gories\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/categories.png\" ALT = \"Gestion cat&eacute;gories\" border=\"0\"></a>";
					echo "</td>";
*/
				echo "</tr>";
			echo "</table>";
			echo "</form>";

?>
		</div>
	</body>
</html>

