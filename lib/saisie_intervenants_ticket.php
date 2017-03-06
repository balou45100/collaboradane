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
	echo "</head>
	<body>
		<div align = \"center\">";
	include ("../biblio/init.php");
	include ("../biblio/fct.php");
	include ("../biblio/config.php"); //pour récupérer les couleurs pour le tableau

	$no_ticket = $_GET['no_ticket'];
	$id_interv = $_GET['id_interv'];
	$id_interv_a_afficher = $_GET['id_interv_a_afficher'];
	$id_util = $_SESSION['id_util'];
	$a_faire = $_GET['a_faire'];
	$origine = $_GET['origine'];

	//$largeur_tableau = "70%";

	/*
	echo "<br />no_ticket : $no_ticket";
	echo "<br />id_interv : $id_interv";
	echo "<br />id_interv_a_afficher : $id_interv_a_afficher";
	echo "<br />id_util : $id_util";
	echo "<br />a_faire : $a_faire";
	echo "<br />origine : $origine";
	*/

	echo "<h1><center>Saisie des intervenants pour le ticket $no_ticket</center></h1>";
	//////////////////////////////////////////////////////////////////////
	// Les actions à faire en arrivant dans le script ////////////////////
	//////////////////////////////////////////////////////////////////////

	switch ($a_faire)
	{
		case "ajout_intervenant" :
			$ajout = "INSERT INTO intervenant_ticket VALUES ($no_ticket, $id_util, $id_interv);";
			$maj = mysql_query ($ajout);
		break;

		case "suppression_intervenant" :
			$suppression_interv = "DELETE FROM intervenant_ticket WHERE id_tick = $no_ticket AND id_interv = $id_interv_a_afficher";
			$resultat_suppression = mysql_query($suppression_interv);
		break;	
	}

	//Affichage du ticket 

	echo "<form action = \"saisie_intervenants_ticket.php\" method = \"get\">";

		//$query_utils = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
		$query_utils = "SELECT * FROM util AS U,util_groupes AS UG 
			WHERE U.ID_UTIL = UG.ID_UTIL
				AND visible = 'O'
				AND UG.ID_GROUPE = '18'
			ORDER BY NOM";
		$results_utils = mysql_query($query_utils);

		echo "<h2>Choisissez l'intervenant-e dans la liste d&eacute;roulante</h2>";
		//$no = mysql_num_rows($results_utils);
			echo "<SELECT NAME = \"id_interv\">";
				while ($ligne_utils = mysql_fetch_object($results_utils))
				{
					$id_interv = $ligne_utils->ID_UTIL;
					$nom = $ligne_utils->NOM;
					$prenom = $ligne_utils->PRENOM;

					//on vérifie si le nom existe déjà
					$verif_intervenant = "SELECT * FROM intervenant_ticket WHERE id_tick = $no_ticket AND id_interv = $id_interv";
					$resultat_verif_intervenant = mysql_query($verif_intervenant);
					if (mysql_num_rows($resultat_verif_intervenant) == 0)
					{
						echo "<OPTION VALUE = \"".$id_interv."\">".$nom." - ".$prenom."</OPTION>";
					}
				}
			echo "</SELECT>";
			echo "<input type = \"hidden\" VALUE = \"$no_ticket\" NAME = \"no_ticket\">
			<input type = \"hidden\" VALUE = \"ajout_intervenant\" NAME = \"a_faire\">
			<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
			echo "<input type = \"submit\" VALUE = \"Ajouter un-e intervenant-e\">";
		echo "</center><br />";
	echo "</form>";

	$query = "SELECT * FROM probleme WHERE ID_PB = '".$no_ticket."';";
	$result_consult = mysql_query($query);

	while ($res=mysql_fetch_row($result_consult))
	{
		//Récupération de l'établissement
		$query_etab = "SELECT * FROM etablissements WHERE RNE = '".$res[4]."';";
		$results_etab = mysql_query($query_etab);
		$res_etab = mysql_fetch_row($results_etab);
		//1ère ligne
		echo "<table width=\"95%\">";
			echo "<tr>";
				echo "<td class = \"etiquette\" width=\"10%\">No&nbsp;:&nbsp;</td>";
				echo "<td width = \"10%\"><b>&nbsp;$res[0]</b></td>";
				echo "<td class = \"etiquette\" width=\"5%\">cr&eacute;&eacute; par&nbsp;:&nbsp;</td>";
				echo "<td width=\"20%\">$res[3]</td>";
				echo "<td class = \"etiquette\" width=\"5%\">cr&eacute;&eacute; le&nbsp;:&nbsp;</td>";
				//Transformation de la date de création extraite pour l'affichage
				$date_de_creation_a_afficher = strtotime($res['27']);
				$date_de_creation_a_afficher = date('d/m/Y',$date_de_creation_a_afficher);
				echo "<td width=\"10%\">$date_de_creation_a_afficher</td>";
				//echo "<td align = \"center\" width=\"10%\">$res[7]</td>";
				echo "<td class = \"etiquette\" width=\"5%\">trait&eacute; par&nbsp;:&nbsp;</td>";
				echo "<td width=\"10%\">&nbsp;$res[15]</td>";
			echo "</tr>";
		//echo "</table>";

		//echo "<table width=\"$largeur_tableau\" BORDER = \"1\" BGCOLOR = \"#48D1CC\" align = \"center\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Sujet&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"7\">&nbsp;$res[5]</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class = \"etiquette\">Ouvert pour&nbsp;:&nbsp;</td>";
				switch ($res[23])
				{
					case 'GT' :
						echo "<td colspan = \"7\">".str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5])." ".str_replace("*", " ",$res_etab[7])." "."<a href = \"mailto:".str_replace(" ", "*",$res_etab[8])."?cc=".$_SESSION['mail']."&amp;body=\"coucou\"><FONT COLOR=\"#696969\">".$res_etab[8]."</FONT></a>";
					break;

					case 'REP' :
						echo "<td colspan = \"7\">".str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[4])."";
					break;
				}  
				echo "</td>";
			echo "</tr>";
		//echo "</table>";  

		//echo "<table width=\"$largeur_tableau\" BORDER = \"1\" BGCOLOR = \"#48D1CC\" align = \"center\">";
			echo "<tr>";
				echo "<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"4\">&nbsp;$res[17]&nbsp;$res[19]&nbsp;$res[18]&nbsp;<a href = \"mailto:".str_replace(" ", "*",$res[20])."?cc=".$_SESSION['mail']."&amp;body=".$politesse[1]."\"><FONT COLOR=\"#696969\">".$res[20]."</FONT></a>&nbsp;-&nbsp;$res[21]</td>";
				echo "<td class = \"etiquette\">Type de contact&nbsp;:&nbsp;</td>";
				echo "<td colspan = \"2\">&nbsp;$res[22]</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td class = \"etiquette\">Description&nbsp;:</td>";
				echo "<td colspan=\"6\">$res[6]</td>";
			echo "</tr>";
		//echo "</table>";

	} //fin while boucle principale

	//On récupère les intervenants de la table intervenant_ticket
	$liste_intervenants = "SELECT nom,id_util FROM intervenant_ticket, util
		WHERE intervenant_ticket.id_interv = util.id_util
		AND id_tick = $no_ticket
		AND id_crea != id_interv";
	$resultat_liste_intervenants = mysql_query($liste_intervenants);

	//echo "<form action = \"saisie_intervenants_ticket.php\" method = \"get\">";
		//echo "<table width=\"95%\" BORDER = \"1\">";
			echo "<tr>";

			$intervenants = "";
			while ($resultats = mysql_fetch_row($resultat_liste_intervenants))
			{
				$id_interv_a_afficher = $resultats[1];
				if ($intervenants == "")
				{
					$intervenants = $resultats[0]."&nbsp<a href = \"saisie_intervenants_ticket.php?&amp;a_faire=suppression_intervenant&amp;origine=$origine&amp;no_ticket=$no_ticket&amp;id_interv_a_afficher=$id_interv_a_afficher\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer l'intervenant-e\"></a>";
				}
				else
				{
					$intervenants = $intervenants.";".$resultats[0]."&nbsp<a href = \"saisie_intervenants_ticket.php?&amp;a_faire=suppression_intervenant&amp;origine=$origine&amp;no_ticket=$no_ticket&amp;id_interv_a_afficher=$id_interv_a_afficher\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer l'intervenant-e\"></a>";
				}
			}
				echo "<td class = \"etiquette\">Intervenant-e-s&nbsp;:&nbsp;</td>";
				if ($intervenants <>"")
				{
					echo "<td colspan = \"7\">$intervenants";
					echo "<br /><i><small>Il est possible de retirer un-e intervenant-e en cliquant sur la croix derri&egrave;re le nom</small></i>";
				}
				else
				{
					echo "<td width=\"90%\"><i>Ajouter un-e intervenant-e avec la liste d&eacute;roulante ci-dessus</i>";
				}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";

	echo "<br />";
	echo "<center>";
	//On affiche le bouton pour terminer la procédure et pour ensuite envoyer les courriels
	echo "<form action = \"envoi_courriels.php\" method = \"get\">";
		echo "<input type = \"hidden\" VALUE = \"$no_ticket\" NAME = \"no_ticket\">
		<input type = \"hidden\" VALUE = \"mel_nouveau_ticket\" NAME = \"a_faire\">
		<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
		echo "Cliquer sur le bouton <b>apr&egrave;s avoir ajout&eacute; tou-te-s les intervenant-e-s</b> pour envoyer les courriels aux intervenant-e-s&nbsp;:&nbsp;
		<input type = \"submit\" VALUE = \"Continuez\">";
	echo "</form>";
	echo "</center>";

	////////////////////////////////////////////////////////////////////////////////////////////////////
	/// Affichage d'un bouton retour pour ne pas envoyer de messages aux intervenants //////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<br /><center>";
	if ($origine == "gest_ticket")
	{
		echo "<form action = \"gestion_ticket.php\" METHOD = \"GET\">";
			echo "Cliquez sur le bouton <b>si vous ne souhaitez pas envoyer de courriels aux intervenant-e-s</b>&nbsp;:&nbsp;<input type = \"submit\" VALUE = \"Retour &agrave; la gestion des tickets\">";
			echo "</form>";
	}
	elseif ($origine == "ecl_consult_fiche")
   	{
		echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
			echo "Cliquez sur le bouton <b>si vous ne souhaitez pas envoyer de courriels aux intervenant-e-s</b>&nbsp;:&nbsp;<input type = \"submit\" VALUE = \"Retour &agrave; la fiche\">";
		echo "</form>";
    }
    else
    {
 		echo "<form action = \"gestion_ecl.php\" METHOD = \"GET\">";
			echo "Cliquez sur le bouton <b>si vous ne souhaitez pas envoyer de courriels aux intervenant-e-s</b>&nbsp;:&nbsp;<input type = \"submit\" VALUE = \"Retour\">";
			echo "<input type = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
			echo "<input type = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
		echo "</form>";
    }
	echo "</center>";
?>
</body>
</html>
