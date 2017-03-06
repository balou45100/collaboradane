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

	//On inclue les pages nécessaires
	include ("../biblio/init.php");
	include ("../biblio/fct.php");

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">";
?>
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
<?php
	echo "</head>
	<body>
		<div align = \"center\">";
				//recupération de l'indentifiant du problème, la modification se fait par accès avec cette clé
				$idpb = $_GET['idpb'];
				$tri = $_GET['tri']; //pour pouvoir repartir vers la gestion des tickets
				$id_categ = $_GET['id_categ']; //pour pouvoir repartir vers la gestion des catégories
				$origine = $_SESSION['origine']; //permet de savoir quel script appelle le script actuel
				$a_chercher = $_GET['a_chercher']; //pour pouvoir repartir vers l'affichage d'une recherche
				$ou = $_GET['ou']; //pour pouvoir repartir vers l'affichage d'une recherche
				$a_faire = $_GET['a_faire']; //traitement des intervenants
				$id_interv = $_GET['id_interv'];
				$id_interv_a_afficher = $_GET['id_interv_a_afficher'];
				$id_util = $_SESSION['id_util'];
				$id_proprio_extrait = $_GET['id_proprio_extrait'];

				//echo "<br />origine : $origine";
				//On regarde s'il faut faire quelque chose
				switch ($a_faire)
				{
					case "ajout_intervenant" :
						/*
						echo "<br />idpb : $idpb";
						echo "<br />id_util : $id_util";
						echo "<br />idinterv : $id_interv";
						*/
						//echo "<br />id_proprio_extrait : $id_proprio_extrait";
						//Il faut r�cup�rer l'id du propri�taire du ticket
						$ajout = "INSERT INTO intervenant_ticket VALUES ($idpb, $id_proprio_extrait, $id_interv);";
						$maj = mysql_query ($ajout);
					break;

					case "suppression_intervenant" :
						$suppression_interv = "DELETE FROM intervenant_ticket WHERE id_tick = $idpb AND id_interv = $id_interv_a_afficher";
						$resultat_suppression = mysql_query($suppression_interv);
					break;
				}
				//echo "<br />origine : $origine<br />";
		        //Test du champ récupéré
				if( !isset($idpb) || $idpb == "")
				{
					echo "<b>Probl&egrave;me non r&eacute;f&eacute;renc&eacute; dans la base de donn&eacute;e</b>";
					switch ($origine)
					{
						case 'gestion_ticket':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'gestion_categories':
							echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'fouille':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'repertoire_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'ecl_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					exit;
				}

				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
				$results = mysql_query($query);
				//Dans le cas o� aucun résultats n'est retourné
				if(!$results)
				{
					echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
					switch ($origine)
					{
						case 'gestion_ticket':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'gestion_categories':
							echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'fouille':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'repertoire_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'ecl_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
					mysql_close();
					exit;
				}

				//Récupération des données concernant le ticket
				$res = mysql_fetch_row($results);

				//On r�cup�re l'id du propri�taire pour le traitement des intervenants plus tard
				$requete_id_proprietaire = "SELECT id_util FROM util WHERE nom LIKE '".$res[3]."' AND MAIL LIKE '".$res[2]."'";

				//echo "<br />$requete_id_proprietaire";

				$res_req_id_proprio = mysql_query($requete_id_proprietaire);
				$ligne_extraite = mysql_fetch_row($res_req_id_proprio);
				$id_proprio_extrait = $ligne_extraite[0];

				//echo "<br />id_proprio_extrait : $id_proprio_extrait";

				//On transforme la date de cr�ation du champ date_crea pour pouvoir l'afficher dans des champs de s�lections
				//$date_demande_a_traiter = strtotime($res[28]);
				$date_demande_a_traiter2 = $res[28];
				/*
				$date_demande_jour = date('d',$date_demande_a_traiter);
				$date_demande_mois = date('m',$date_demande_a_traiter);
				$date_demande_annee = date('Y',$date_demande_a_traiter);
				*/

				//Traitement des priorités

				switch ($res[13])
				{
					case "2":
						$priorite_selection = "Normal";
						$priorite_non_selection_ref_1 = "1";
						$priorite_non_selection_ref_2 = "3";
						$priorite_non_selection_nom_1 = "Haute";
						$priorite_non_selection_nom_2 = "Basse";
					break;

					case "1":
						$priorite_selection = "Haute";
						$priorite_non_selection_ref_1 = "2";
						$priorite_non_selection_ref_2 = "3";
						$priorite_non_selection_nom_1 = "Normal";
						$priorite_non_selection_nom_2 = "Basse";
					break;

					case "3":
						$priorite_selection = "Basse";
						$priorite_non_selection_ref_1 = "1";
						$priorite_non_selection_ref_2 = "2";
						$priorite_non_selection_nom_1 = "Haute";
						$priorite_non_selection_nom_2 = "Normal";
					break;

					default:
						$res[13] = "2";
						$priorite_selection = "Normal";
						$priorite_non_selection_ref_1 = "1";
						$priorite_non_selection_ref_2 = "3";
						$priorite_non_selection_nom_1 = "Haute";
						$priorite_non_selection_nom_2 = "Basse";
					break;

				}
				//echo "<br />RNE / N� soci&eacute;t&eacute; : $res[4] - module : $res[23]";

				switch ($res[23])
				{
					case 'GT' :
						//Récupération des données en rapport avec l'établissement
						$query_etab = "SELECT * FROM etablissements where RNE = '".$res[4]."';";
						$results_etab_select = mysql_query($query_etab);
						//Dans le cas o� aucun résultats n'est retourné
						if(!$results_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							switch ($origine)
							{
								case 'gestion_ticket':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'gestion_categories':
									echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'fouille':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'repertoire_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'ecl_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
							}
							mysql_close();
							exit;
						}
						$num_results_etab_select = mysql_num_rows($results_etab_select);
						$res_etab = mysql_fetch_row($results_etab_select);
						//echo "<br />RNE récupéré : $res_etab[0]";
						//fin récupération de l'établissement selectionné

						//Récupération des établissements non selectionnés
						$query_non_etab_select = "SELECT * FROM etablissements where RNE != '".$res[4]."';";
						$results_non_etab_select = mysql_query($query_non_etab_select);
						//Dans le cas o� aucun résultats n'est retourné
						if(!$results_non_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							switch ($origine)
							{
								case 'gestion_ticket':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'gestion_categories':
									echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'fouille':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'repertoire_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'ecl_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
							}
							mysql_close();
							exit;
						}
						$num_results_etab_non_select = mysql_num_rows($results_non_etab_select);
						$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
						//fin de recup de tous les établissements non selectionnées
					break; //case "GT"

					case 'REP' :
						//Récupération des données en rapport avec l'établissement
						$query_etab = "SELECT * FROM repertoire where No_societe = '".$res[4]."';";
						$results_etab_select = mysql_query($query_etab);
						//Dans le cas o� aucun résultats n'est retourné
						if(!$results_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							switch ($origine)
							{
								case 'gestion_ticket':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'gestion_categories':
									echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'fouille':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'repertoire_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'ecl_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
							}
							mysql_close();
							exit;
						}
						$num_results_etab_select = mysql_num_rows($results_etab_select);
						$res_etab = mysql_fetch_row($results_etab_select);
						//echo "<br />N� soci&eacute;t&eacute; r&eacute;cup&eacute;r&eacute; : $res_etab[0]";
						//fin récupération de l'établissement selectionné

						//Récupération des établissements non selectionnés
						$query_non_etab_select = "SELECT * FROM repertoire where NO_societe != '".$res[4]."';";
						$results_non_etab_select = mysql_query($query_non_etab_select);
						//Dans le cas o� aucun résultats n'est retourné
						if(!$results_non_etab_select)
						{
							echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
							switch ($origine)
							{
								case 'gestion_ticket':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'gestion_categories':
									echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'fouille':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'repertoire_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;

								case 'ecl_consult_fiche':
									echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
								break;
							}
							mysql_close();
							exit;
						}
						$num_results_etab_non_select = mysql_num_rows($results_non_etab_select);
						$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
						//fin de recup de tous les établissements non selectionnées
					break; //case "REP"

				} //fin switch res[23]
				echo "
				<form action = \"verif_ticket.php\" METHOD = \"POST\">
					<input type = \"hidden\" VALUE = \"M\" NAME = \"statut\">
					<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">
						<table>
							<tr>
								<td class = \"etiquette\">
									Emetteur&nbsp;:&nbsp;
								</td>
								<td>
									<input type = \"hidden\" VALUE = \"".$res[3]."\" NAME = \"emetteur\">
									&nbsp;".$res[3]."
								</td>
							</tr>

							<tr>
								<td class = \"etiquette\">
									M&eacute;l Emetteur&nbsp;:&nbsp;
								</td>
								<td>
									<input type = \"hidden\" VALUE =\"".$res[2]."\" NAME = \"mail_emetteur\">
									&nbsp;".$res[2]."
								</td>
							</tr>

							<TR>
								<td class = \"etiquette\">Date saisie&nbsp;:&nbsp;</td>
								<td>";
									$date_saisie_a_afficher = strtotime($res[27]);
									$date_saisie_a_afficher = date('d/m/Y',$date_saisie_a_afficher);
									echo "&nbsp;<input type = \"hidden\" VALUE = \"".$res[27]."\" NAME = \"date_creation\" SIZE = \"10\">$date_saisie_a_afficher
								</td>
							</TR>";

					echo "<tr>
						<td class = \"etiquette\">Date demande&nbsp;:&nbsp;</td>
						<td>";
							echo "<input type=\"text\" id=\"date_demande\"  name=\"date_demande\" value=\"$date_demande_a_traiter2\" size = \"10\">";
							echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_demande&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
						echo "</td>
					</tr>


							<tr>
								<td class = \"etiquette\">Ouvert pour&nbsp;:&nbsp;</td>";
									switch ($res[23])
									{
										case 'GT' :
											echo "<td>
												<select name = \"etab\">";
												for ($i=0; $i < $num_results_etab_non_select; ++$i)
												{
													echo "<option value =".$res_non_etab_select[0].">".$res_non_etab_select[0]." -- ".str_replace("*", " ",$res_non_etab_select[1])." ".str_replace("*", " ",$res_non_etab_select[3]). " -- ".$res_non_etab_select[5]."</option>";
													$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
												}
												echo "<option selected = \"".$res_etab[0]."\" VALUE = \"".$res_etab[0]."\">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])."</option>
												</select>";
										break;

										case 'REP' :
											echo "<td>
												<select name = \"etab\">";
												for ($i=0; $i < $num_results_etab_non_select; ++$i)
												{
													echo "<option value =".$res_non_etab_select[0].">".$res_non_etab_select[0]." -- ".str_replace("*", " ",$res_non_etab_select[1])." ".str_replace("*", " ",$res_non_etab_select[4])."</option>";
													$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
												}
												echo "<option selected = \"".$res_etab[0]."\" VALUE = \"".$res_etab[0]."\">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[4])."</option>
												</select>";
										break;
									}
								echo "</td>
							</tr>

							<tr>
								<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>
								<td class = \"etiquette\">Titre&nbsp;:&nbsp;
									<select size= \"1\" name = \"contact_titre\">
										<option selected>".$res[17]."</option>
										<option value=\"M\">M.</option>
										<option value=\"MME\">MME</option>
									</select>
									&nbsp;Pr&eacute;nom&nbsp;:&nbsp;<input type = \"text\" VALUE = \"".$res[19]."\" NAME = \"contact_prenom\" SIZE = \"32\">
									&nbsp;Nom&nbsp;:&nbsp;<input type = \"text\" VALUE = \"".$res[18]."\" NAME = \"contact_nom\" SIZE = \"32\">
									<br />&nbsp;M&eacute;l&nbsp;:&nbsp;<input type = \"text\" VALUE = \"".$res[20]."\" NAME = \"contact_mail\" SIZE = \"50\">";

									//On charge la liste déroulante à partir de la table contacts-qualites
									remplir_champ_select("INTITULE","contacts_qualites","Fonction&nbsp;:&nbsp","contact_fonction","$res[21]");
								echo "</td>
							</tr>

							<tr>
								<td class = \"etiquette\">Sujet&nbsp;:&nbsp;</td>
								<td>
									<input type = \"text\" VALUE = \"".$res[5]."\" NAME = \"sujet\" SIZE = \"64\">
								</td>
							</tr>
							<tr>
								<td class = \"etiquette\">
									Type&nbsp;:&nbsp;
								</td>
								<td>";
								remplir_champ_select("INTITULE","contacts_types","","contact_type","$res[22]");
/*									echo "<select name = \"contact_type\">
										<option selected>".$res[22]."</option>
										<option = \"courriel re�u\" VALUE = \"courriel re�u\">courriel re�u</option>
										<option = \"courriel envoy&eacute;\" VALUE = \"courriel envoy&eacute;\">courriel envoy&eacute;</option>
										<option = \"appel t&eacute;l. re�u\" VALUE = \"appel t&eacute;l. re�u\">appel t&eacute;l. re�u</option>
										<option = \"appel t&eacute;l. donn&eacute;\" VALUE = \"appel t&eacute;l. donn&eacute;\">appel t&eacute;l. donn&eacute;</option>
										<option = \"courrier re�u\" VALUE = \"courrier re�u\">courrier re�u</option>
										<option = \"courrier envoy&eacute;\" VALUE = \"courrier envoy&eacute;\">courrier envoy&eacute;</option>
										<option = \"rencontre\" VALUE = \"rencontre\">rencontre</option>
										<option = \"OTA\" VALUE = \"OTA\">OTA</option>
										<option = \"information\" VALUE = \"information\">information</option>
									</select>";
*/
								echo "</td>
							</tr>
							<tr>
								<td class = \"etiquette\">
									Priorit&eacute;&nbsp;:&nbsp;
								</td>
								<td>
									<select name = \"priorite\">
										<option selected = \"".$res[13]."\" VALUE = \"".$res[13]."\">".$priorite_selection."</option>
										<option = \"".$priorite_non_selection_ref_1."\" VALUE = \"".$priorite_non_selection_ref_1."\">".$priorite_non_selection_nom_1."</option>
										<option = \"".$priorite_non_selection_ref_2."\" VALUE = \"".$priorite_non_selection_ref_2."\">".$priorite_non_selection_nom_2."</option>
									</select>
								</td>
							</tr>

				<!--////////////////////////////////////////////////////////////
				/////Affichage des intervenants ////////////////////////////
				////////////////////////////////////////////////////////////
							<tr>
								<td class = \"etiquette\">
									Intervenants&nbsp;:&nbsp;
								</td>

								<td>
									<input type = \"text\" VALUE =\"".$res[10]."\" NAME = \"intervenant\" SIZE = \"40\">&nbsp;(s&eacute;par&eacute;s par des ; aucun caract&egrave;res accentu&eacute;s, ni d'espace)
								</td>

				<////////////////////////////////////////////////////////////-->

							</tr>
							<tr>
								<td class = \"etiquette\">
									Contenu&nbsp;:&nbsp;
								</td>
								<td>
									<textarea rows = \"10\" COLS = \"120\" NAME = \"contenu\">".str_replace("<br />","",$res[6])."</textarea>";
										echo "<script type=\"text/javascript\">
											CKEDITOR.replace( 'contenu' );
										</script></td>";
								echo "</td>
							</tr>
							<tr>
								<td class = \"etiquette\">
								</td>
							</tr>
						</table>
							<center>
								<input type = \"hidden\" VALUE = \"".$id_categ."\" NAME = \"id_categ\">
								<input type = \"hidden\" VALUE = \"".$origine."\" NAME = \"origine\">
								<input type = \"hidden\" VALUE = \"M\" NAME = \"statut\">
								<input type = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">
								<input type = \"submit\" VALUE = \"Enregistrer les modifications\">";
					echo "</form></center>";

					//////////////////////////////////////////////
					/// Traitement des intervenant-e-s////////////
					//////////////////////////////////////////////

					//On affiche la liste déroulante
					echo "<hr />";
					echo "<form action = \"modif_ticket.php\" method = \"get\">";
					$query_utils = "SELECT * FROM util WHERE visible = 'O' ORDER BY NOM";
					$results_utils = mysql_query($query_utils);

					echo "<center><b>Modifier la liste des intervenant-e-s :</b>
						<br />- Ajout &agrave; l'aide de la liste d&eacute;roulante
						<br />- Suppression en cliquant sur la croix derri&egrave;re le nom<br/><br />";
					//$no = mysql_num_rows($results_utils);
					echo "<select name = \"id_interv\">";
					while ($ligne_utils = mysql_fetch_object($results_utils))
					{
						$id_interv = $ligne_utils->ID_UTIL;
						$nom = $ligne_utils->NOM;
						$prenom = $ligne_utils->PRENOM;
						//on vérifie si le nom existe déj&agrave;
						$verif_intervenant = "SELECT * FROM intervenant_ticket WHERE id_tick = $idpb AND id_interv = $id_interv";
						$resultat_verif_intervenant = mysql_query($verif_intervenant);
						//On extrait les champs id_crea et id_interv. S'ils sont identiques on n'affiche pas la personne
						$test_createur_intervenant = mysql_fetch_row($resultat_verif_intervenant);
						$id_createur = $test_createur_intervenant[1];
						$id_intervenant = $test_createur_intervenant[2];
						//echo "<option value = \"".$id_interv."\">$id_createur - $id_intervenant</option>";
						//echo "<br />id_crea : $id_crea - id_intervenant : $id_intervenant";
						if (mysql_num_rows($resultat_verif_intervenant) == 0)
						{
							//Il faut tester si l'intervenant et le créateur sont identiques, dans ce cas on ne l'affiche pas
							//if ($id_createur <> $id_intervenant)
							//{
								echo "<option value = \"".$id_interv."\">".$nom." - ".$prenom."</option>";
							//}
						}
					}
					echo "</select>";
					echo "<input type = \"hidden\" VALUE = \"$idpb\" NAME = \"idpb\">";
					echo "<input type = \"hidden\" VALUE = \"$id_proprio_extrait\" NAME = \"id_proprio_extrait\">
					<input type = \"hidden\" VALUE = \"ajout_intervenant\" NAME = \"a_faire\">
					<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
					echo "<input type = \"submit\" VALUE = \"Ajouter un-e intervenant-e\">";
					echo "</center><br />";
				echo "</form>";

					//On affiche les intervenants de la table intervenant_ticket
					$liste_intervenants = "SELECT nom,id_util,id_crea,id_interv FROM intervenant_ticket, util WHERE intervenant_ticket.id_interv = util.id_util AND id_tick = $idpb";
					$resultat_liste_intervenants = mysql_query($liste_intervenants);

					echo "<center>";
					//echo "<table BORDER = \"2\" align = \"center\">";
						//echo "<tr>";
							//echo "<td class = \"td-bouton\" width=\"10%\">Intervenant-e-s&nbsp;:&nbsp;</td>";
							//echo "Intervenant-e-s&nbsp;:&nbsp;";

								$intervenants = "";
								while ($resultats = mysql_fetch_row($resultat_liste_intervenants))
								{
									//echo "<br />0 : $resultats[0] - 1 : $resultats[1] - 2 : $resultats[2] - 3 : $resultats[3]";
									$id_interv_a_afficher = $resultats[1];
									if ($intervenants == "")
									{
										if ($resultats[2] <> $resultats[3])
										{
											$intervenants = $resultats[0]."&nbsp<a href = \"modif_ticket.php?&amp;a_faire=suppression_intervenant&amp;origine=$origine&amp;idpb=$idpb&amp;id_interv_a_afficher=$id_interv_a_afficher\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer l'intervenant-e\"></a>";
										}
									}
									else
									{
										if ($resultats[2] <> $resultats[3])
										{
											$intervenants = $intervenants.";".$resultats[0]."&nbsp<a href = \"modif_ticket.php?&amp;a_faire=suppression_intervenant&amp;origine=$origine&amp;idpb=$idpb&amp;id_interv_a_afficher=$id_interv_a_afficher\" TARGET = \"body\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/delete.png\" ALT = \"supprimer\" border = \"0\" title=\"Supprimer l'intervenant-e\"></a>";
										}
									}
								}
									if ($intervenants <>"")
									{
										//echo "<td class = \"td-1\" width=\"90%\">$intervenants";
										echo "$intervenants";
										//echo "<br /><i><small>Il est possible de retirer un-e intervenant-e en cliquant sur la croix derri&egrave;re le nom</small></i>";
									}
									else
									{
										//echo "<td class = \"td-1\" width=\"90%\"><i>Pas d'intervenant-e pour ce ticket, ajouter en un-e avec la liste déroulante ci-dessus</i>";
										echo "<i>Pas d'intervenant-e pour ce ticket, ajouter en un-e avec la liste d&eacute;roulante ci-dessus</i>";
									}

							echo "</td>";
						echo "</tr>";
					echo "</table>";
					//echo "</center>";
					mysql_close();

					//////////////////////////////////////////////
					/// Affichage du bouton retour ///////////////
					//////////////////////////////////////////////
					echo "<hr />";
					switch ($origine)
					{
						case 'gestion_ticket':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'gestion_categories':
							echo "<br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'fouille':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'repertoire_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;

						case 'ecl_consult_fiche':
							echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
						break;
					}
?>
		</div>
	</body>
</html>
