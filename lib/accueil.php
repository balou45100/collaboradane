<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<!"Ce fichier le sommaire avec une page d'aide">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
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
				$autorisation_genies = verif_appartenance_groupe(2);
				$autorisation_rt2008 = $_SESSION['autorisation_rt2008'];
				$largeur_tableau = "80%";
				$nouvelles = "
				<ul>
					<li><b>PERSONNES RESSOURCES</b>&nbsp;
						<A HREF = \"personnes_ressources_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Personnes ressources\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Personnes ressources\" border=\"0\"></A>
						&nbsp;(1/12/2008)&nbsp;saisies faites pour :</li>
					<ul>
						<li>&eacute;quipes disciplinaires des IA-IPR et des IEN-ET</li>
						<ul>
							<li>les IANTES académiques, ambassadeurs et administrateurs du 18, 28, 36, 37, 41, 45, correspondants TICE des inspecteurs, correspondants Orl&eacute;ans-Tours Assistance, webmestres</li>
						</ul>
						<li>&eacute;quipes d&eacute;partementales 28, 41, 45</li>
						<li>Mission TICE, CRDP, B2i</li>
					</ul>
				</ul>
				"; 
				$nouveautes = "
				<h4>Les nouveaut&eacute;s de la version 1.48.8 du 14.6.2008&nbsp:&nbsp;</h4>
				<ul>
					<li>envoi de message exclue dorénavant pour la personne connectée (pour les priorités hautes, transferts, archivages et ré-activations)</li>
					<li>suppression des tickets \"en attente\" du filtre \"tous\" dans l'affichage principal.cr&eacute;ation du module \"Gestion des t&acirc;ches\"</li>
				</ul>

				<h4>Les nouveaut&eacute;s de la version 1.48 du 11.11.2008&nbsp:&nbsp;</h4>
				<ul>
					<li>cr&eacute;ation du module \"Gestion des t&acirc;ches\"</li>
					<ul>
						<li>saisie et suppression d'une t&acirc;che;</li>
						<li>tri sur id, date de cr&eacute;ation, date d'&eacute;ch&eacute;ance et les personnes ayant cr&eacute;&eacute; une t&acirc;che (pour les tâches partagées)</li>
						<li>marquage d'une t&acirc;che comme achev&eacute;e</li>
						<li>activation d'une t&acirc;che marqu&eacute;e comme achev&eacute;e</li>
						<li>basculement de la piorit&eacute; directement dans la liste</li>
						<li>ajout de catégories</li>
						<li>possibilité de partage une tâches avec d'autres utilisateurs</li>
						<li>filtres à partir du bandeau</li>
						<ul>
							<li>sur les catégories</li>
							<li>l'état (non achevé, nouveau, en cours, achevé, tout)</li>
							<li>la visibilité (public, privé, les deux)</li>
							<li>les tâches partagées des autres utilisateurs</li>
						</ul>
					</ul>
				</ul>

				<h4>Les nouveaut&eacute;s de la version 1.40 du 3.11.2008&nbsp:&nbsp;</h4>
				<ul>
					<li>extensions dans le module \"Personnes ressources\"</li>
					<ul>
						<li>filtres plus &eacute;labor&eacute;s</li>
						<li>saisie des HSA (acc&egrave;s restreint)</li>
						<li>Tableau de bord des HSA par rapport aux diff&eacute;rents postes budg&eacute;taires (acc&egrave;s restreint)</li>
					</ul>
					<li>cr&eacute;ation du module \"Gestion des mat&eacute;riels\"</li>
					<ul>
						<li>filtre sur catégorie de matériel</li>
						<li>filtre sur disponibilité (affect&eacute;, non affect&eacute;, perdu)</li>
						<li>filtre sur affectation</li>
					</ul>
				</ul>

				<h4>Les nouveaut&eacute;s de la version 1.36 du 31.8.2008&nbsp:&nbsp;</h4>
				<ul>
					<li>traitement des n°s de téléphone, fax et mobile pour l'affichage avec des "."</li>
					<ul>
						<li>la saisie se fait sans espace ni autre caractères de séparation</li>
						<li>ajout du champ 'pays' pour les sociétés, si pas renseigné 'France' est automatiquement inséré'</li>
					</ul>
					<li>ajout des alertes dans les statistiques</li>
				</ul>

				<h4>Les nouveaut&eacute;s de la version 1.35 du 24.8.2008&nbsp:&nbsp;</h4>
				<ul>
					<li>ajout de la fonctionnalité d'alerte pour les tickets</li>
					<ul>
						<li>création, modification et suppression à partir de la fiche d'un ticket</li>
						<li>affiché dans la liste récapitulative des tickets en donnant le nbr de jour en avance ou en retard, associé à un code couleur, une info-bulle affiche l'alerte au survol de la souris</li>
						<ul>
							<li>blanc : pas d'alerte</li>
							<li>vert : date d'alerte pas encore atteinte</li>
							<li>jaune : alerte pour le jour même</li>
							<li>orange : dépassé jusqu'à 7 jours</li>
							<li>rouge : dépassé depuis plus de 7 jours</li>
						</ul>
						<li>toutes les alertes d'un ticket sont supprimées lors de l'archivage de celui-ci</li>
						<li>ajout d'un filtre 'mes alertes' dans la liste déroulante du bandeau</li>
					</ul>
				</ul>
				";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// Entête ////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo "<TABLE align=\"center\" width = \"$largeur_tableau\" BORDER = \"0\" BGCOLOR =\"$bg_color1\">
			<TR>
				<TD align = \"center\">
              		<h2>\"CollaboraTICE\"<br>Espace collaboratif de la Mission académique TICE</h2>
            	</TD>
            	<TD align = \"center\">
              		<img border=\"0\" src = \"$chemin_theme_images/$logo\" ALT = \"Logo\">
            	</TD>
          	</TR>
        </TABLE>";
        echo "<br>";
       //echo "<p><b>Choississez un module en cliquant sur une des icônes du bandeau du bas</b></p>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// Boîte pour indiquer les nouvelles /////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
         echo "<TABLE align=\"center\" width = \"$largeur_tableau\" BORDER = \"0\"  BGCOLOR =\"$bg_color1\">
			<tr>
				<td bgcolor =\"$bg_color2\" width = \"15%\" ALIGN =\"center\"><h4>NOUVELLES</h4>
					<i><small>Voir le détail des &eacute;volutions de la plate-forme apr&egrave;s le tableau des modules disponibles</small></i>
				</td>
				<td bgcolor =\"$bg_color2\" width = \"85%\">$nouvelles</td>
          	</tr>
        </TABLE>";
        echo "<br>";
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// Boîte centrale avec les modules ///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       echo "<TABLE align=\"center\" width = \"$largeur_tableau\" BORDER = \"0\" BGCOLOR =\"$bg_color1\">
			<TR>
				<td align = \"center\" BGCOLOR =\"$bg_color2\" rowspan = \"10\" width = \"15%\"><h4>MODULES DISPONIBLES</h4></td>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/accueil.png\" border=\"0\">
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Accueil</b>
				</TD>
				<TD>
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<A HREF = \"materiels_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des mat&eacute;riels\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"></A>
					<!--IMG src = \"$chemin_theme_images/materiels.png\" ALT = \"GESTMAT\" border=\"0\"-->
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Gestion des mat&eacute;riels</b><br><small><i>(Acc&egrave;s limit&eacute;)</small></i>
				</TD>
          	</TR>
          	<TR>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<A HREF = \"cadre_gestion_ecl.php\" target = \"_top\" class=\"bouton\" title=\"&Eacute;coles, coll&egrave;ges, lyc&eacute;es\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/eple.png\" ALT = \"ECL\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>&Eacute;coles, coll&egrave;ges, lyc&eacute;es</b><br><small><i>(Le fichier des écoles et EPLE de l'académie)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<A HREF = \"taches_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Gestion des t&acirc;ches\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/tache.png\" ALT = \"t&acirc;ches\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Gestion des tâches</b>
				</TD>
          	</TR>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"cadre_gestion_ticket.php\" target = \"_top\" class=\"bouton\" title=\"Gestion tickets\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket.png\" ALT = \"Gestion tickets\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Gestion des tickets</b><br><small><i>(Les tickets du module 'ECL' et 'répertoire')</small></i>
				</TD>
				<TD>
					&nbsp;
				</TD>
					<TD BGCOLOR =\"$bg_color2\">
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Gestion des ordres de mission</b><br><small><i>(à venir dans la version 1.60)</small></i>
				</TD>
          	</TR>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"personnes_ressources_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Personnes ressources\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/personnes_ressources.png\" ALT = \"Personnes ressources\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>Les personnes ressources TICE</b><br><small><i>(Administrateurs, ambassadeurs, équipes disciplinaires, ...)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Les favoris</b><br><small><i>(à venir dans la version 1.70)</small></small></i>
				</TD>
          	</TR>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"formations_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Formations\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/formations.png\" ALT = \"Formations\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>Les formations</b><br><small><i>(transversales, organisées par la Mission TICE)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					&nbsp;
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Suivi des fonctionnalités et bogues de l'application</b><br><small><i>(à venir dans la version 1.80)</small></i>
				</TD>
          	</TR>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"repertoire_cadre.php\" target = \"_top\" class=\"bouton\" title=\"R&eacute;pertoire des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/repertoire.png\" ALT = \"Répertoire\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>R&eacute;pertoires des soci&eacute;t&eacute;s</b><br><small><i>(Le fichier des sociétés privées)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<A HREF = \"cadre_statistiques.php\" target = \"_top\" class=\"bouton\" title=\"Statistiques\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/statistiques.png\" ALT = \"Statistiques\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Les statistiques d'utilisation</b>
				</TD>
          	</TR>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"contacts_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts des soci&eacute;t&eacute;s\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts.png\" ALT = \"Contacts\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>Contacts des soci&eacute;t&eacute;s</b><br><small><i>(Les contacts des sociétés privés)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<A HREF = \"cadre_reglages.php\" target = \"_top\" class=\"bouton\" title=\"Informations personnelles\"><IMG height=\"32px\" width=\"32px\" src = \"$chemin_theme_images/reglages.png\" ALT = \"Infos persos\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Les informations personnelles</b><br><small><i>(Les informations concernant la personne connectée)</small></i>
				</TD>
          	<TR>
            	<TD align = \"center\" BGCOLOR =\"$bg_color2\">
              		<A HREF = \"contacts_prives_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Contacts privés\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/contacts_prives.png\" ALT = \"Contacts privés\" border=\"0\"></A>
            	</TD>
            	<TD BGCOLOR =\"$bg_color2\">
              		<b>Les contacts privés</b><br><small><i>(Les contacts privés de la personne connectée)</small></i>
            	</TD>
				<TD>
					&nbsp;
				</TD>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<A HREF = \"cadre_gestion_users.php\" target = \"_top\" class=\"bouton\" title=\"Utilisateurs\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/utilisateurs.png\" ALT = \"Utilisateurs\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Les membres de la plateforme CollaboraTICE</b><br><small><i>(Coordonnées téléphoniques et mél)</small></i>
				</TD>
			</TR>
			<TR>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">";
				if ($autorisation_genies == "1")
				{
					echo "<A HREF = \"fgmm_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Festival Génie du Multimédia\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie.png\" ALT = \"FGMM\" border=\"0\"></A>
					</TD>
					<TD BGCOLOR =\"$bg_color2\"><b>Gestion du Festival des Génies du Multimédia</b><br><small><i>(Accès réservé)</i></small>";
				}
				else
				{
					echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/genie.png\" ALT = \"FGMM\" border=\"0\">
					</TD>
					<TD BGCOLOR =\"$bg_color2\"><b>Gestion du Festival des Génies du Multimédia</b><br><small><i>(Accès réservé)</i></small>";
				}
				echo "</TD>
				<TD>
					&nbsp;
				</TD>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/bdd.png\" ALT = \"Cohérence BDD\" border=\"0\">
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Vérification de la base de données</b><br><small><i>(Administrateur seulement)</i></small>
				</TD>
          	</TR>
			<TR>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">";
				if ($autorisation_rt2008 == "O")
				{
					echo "<A HREF = \"rt2008_cadre.php\" target = \"_top\" class=\"bouton\" title=\"Rencontres TICE 2008\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008.png\" ALT = \"RT2008\" border=\"0\"></A>
					</TD>
					<TD BGCOLOR =\"$bg_color2\"><b>Gestion des Rencontres TICE 2008</b><br><small><i>(Accès réservé)</i></small>";
				}
				else
				{
					echo "<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/rt2008.png\" ALT = \"RT2008\" border=\"0\">
					</TD>
					<TD BGCOLOR =\"$bg_color2\"><b>Gestion des Rencontres TICE 2008</b><br><small><i>(Accès réservé)</i></small>";
				}
				echo "</TD>
				<TD>
					&nbsp;
				</TD>
				<TD align = \"center\" BGCOLOR =\"$bg_color2\">
					<A HREF = \"deconnexion.php\" target = \"_top\" class=\"bouton\" title=\"Déconnexion\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/sortir.png\" ALT = \"Déconnexion\" border=\"0\"></A>
				</TD>
				<TD BGCOLOR =\"$bg_color2\">
					<b>Déconnexion</b>
				</TD>
          	</TR>
       </TABLE>
       <br>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////// Boîte pour indiquer les nouveautés ////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       echo "<TABLE align=\"center\" width = \"$largeur_tableau\" BORDER = \"0\"  BGCOLOR =\"$bg_color1\">
			<TR>
				<TD BGCOLOR =\"$bg_color2\" width = \"15%\" ALIGN =\"CENTER\" valign = \"top\"><h4>&Eacute;VOLUTIONS DE L'ESPACE collaboraTICE</h4></td>
				<td BGCOLOR =\"$bg_color2\" width = \"85%\">$nouveautes</td>
          	</TR>
       </TABLE>";
      	?>
		</CENTER>
	</body>
</html>
