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
<!DOCTYPE html> 
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
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
			//Inclusion des fichiers ncessaires
			include("../biblio/init.php");
			include ("../biblio/config.php");
			include("../biblio/fct.php");
			
			//recupration de l'indentifiant du problème, la rponse se fait par accs avec cette cl
			$idpb_pere = $_GET['idpb'];
			$tri = $_GET['tri'];
			$date_creation=date('j/m/Y');
			$date_creation_pour_tri=date('Y/m/j');
			$id_categ = $_GET['id_categ'];
			$contact_titre =$_GET['contact_titre'];
			$contact_prenom =$_GET['contact_prenom'];
			$contact_nom =$_GET['contact_nom'];
			$contact_mail =$_GET['contact_mail'];
			$contact_fonction =$_GET['contact_fonction'];

			//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui pour le nouveau champ de saisie de la date
			$aujourdhui_jour = date('d');
			$aujourdhui_mois = date('m');
			$aujourdhui_annee = date('Y');
			
			$date_demande = date('Y-m-j');

			//echo "<br />titre : $contact_titre - prenom : $contact_prenom - nom : $contact_nom - mail : $contact_mail - fonction : $contact_fonction";
			//Test du champ récupéré
			if(!isset($idpb_pere) || $idpb_pere == "")
			{
				echo "<b>Probl&egrave;me non r&eacute;f&eacute;renc&eacute; dans la base de donn&eacute;e</b>";
				echo "<br /><br /><a href = \"consult_ticket.php?CST=N&amp;idpb=".$idpb_pere."\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				exit;
			}

			$verrouille_par = $_SESSION['nom'];
			//echo "<br />On verrouille le ticket id = $idpb_pere traite par $verrouille_par<br />";
			$query_update = "UPDATE probleme SET VERROU = '1',VERROUILLE_PAR = '".$verrouille_par."' WHERE ID_PB='".$idpb_pere."';";
			$results_update = mysql_query($query_update);
			if(!$results_update)
			{
				echo "<b>Erreur</b>";
				//echo "<br /><br /> <a href = \"gestion_ticket.php\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				//mysql_close();
				//exit;
			}
			
			//Requête pour selectionner toutes les données correspondant a l'identifiant
			$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb_pere."';";
			$result_consult = mysql_query($query);

			//Dans le cas où aucun résultats n'est retourn
			if(!$result_consult)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b>";
				echo "<br /><br /><a href = \"consult_ticket.php?CST=N&amp;idpb=".$idpb_pere."\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				//Fermeture de la connexion à la BDD
				mysql_close();
				exit;
			}
			$res = mysql_fetch_row($result_consult);

			//Requête pour selectionner l'établissement dont il est le sujet
			$query_etab = "SELECT * FROM etablissements WHERE RNE = '".$res[4]."';";
			$results_etab = mysql_query($query_etab);
			//Dans le cas où aucun résultats n'est retourné
			if(!$results_etab)
			{
				echo "<b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</b>";
				echo "<br /><br /><a href = \"consult_ticket.php?CST=N&amp;idpb=".$idpb_pere."\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				//Fermeture de la connexion à la BDD
				mysql_close();
				exit;
			}
			$res_etab = mysql_fetch_row($results_etab);

			//Formulaire pour la réponse à un ticket, le tout est envoyé au script
			//verif_ajout_reponse_ticket.php pour vérification!!
			echo"
			<form action = \"verif_ajout_reponse_ticket.php\" METHOD = \"POST\">
				<input type = \"hidden\" VALUE = \"R\" NAME = \"statut\">
				<input type = \"hidden\" VALUE = \"".$idpb_pere."\" NAME = \"idpbpere\">
				<table>
					<tr>
						<td class = \"etiquette\">
							Emetteur&nbsp;:&nbsp;
						</td>
						<td>
							&nbsp;<input type = \"hidden\" VALUE = \"".$_SESSION['nom']."\" NAME = \"emetteur\">
							".$_SESSION['nom']."
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							Courriel Emetteur&nbsp;:&nbsp;
						</td>
						<td>
							&nbsp;<input type = \"hidden\" VALUE =\"".$_SESSION['mail']."\" NAME = \"mail_emetteur\">
							".$_SESSION['mail']."
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							&Eacute;tablissement&nbsp;:&nbsp;
						</td>
						<td>
							&nbsp;<input type = \"hidden\" VALUE =\"".$res[4]."\" NAME = \"etab\">
							".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])."
							<input type = \"hidden\" VALUE =\"".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])."\" NAME = \"denom_etab\">
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							Sujet&nbsp;:&nbsp;
						</td>
						<td>
							&nbsp;<input type = \"hidden\" VALUE = \"".$res[5]."\" NAME = \"sujet\" SIZE = \"32\">
							".$res[5]."
						</td>
					</tr>

					<TR>
						<td class = \"etiquette\">Date saisie</td>
						<td><input type = \"hidden\" VALUE = \"$date_creation\" NAME = \"date_creation\" SIZE = \"10\">$date_creation
						</td>
					</TR>

					<tr>
						<td class = \"etiquette\">Date contribution&nbsp;:&nbsp;</td>
						<td>";

							echo "<input type=\"text\" id=\"date_demande\"  name=\"date_demande\" value=\"$date_demande\" size = \"10\">";
							echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_demande&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";

						echo "</td>
					</tr>";
 
////////////////////////////////////////////////////////////
// Traitement des contacts du tickets //////////////////////
////////////////////////////////////////////////////////////

			//On vérifie si le ticket a déjà des contributions, si oui on récupère le dernier contact
			$requete_contributions = "SELECT * FROM probleme WHERE ID_PB_PERE = '".$idpb_pere."' ORDER BY ID_PB DESC";
			$res_req_contr = mysql_query($requete_contributions);
			$nb_contributions = mysql_num_rows($res_req_contr);
			
			if ($nb_contributions > 0)
			{
				//echo "<br />Je regarde ....";
				$ligne_contribution = mysql_fetch_object($res_req_contr);
				$id_pb_extrait = $ligne_contribution->ID_PB;
				$contact_titre_extrait = $ligne_contribution->CONTACT_TITRE;
				$contact_prenom_extrait = $ligne_contribution->CONTACT_PRENOM;
				$contact_nom_extrait = $ligne_contribution->CONTACT_NOM;
				$contact_mail_extrait = $ligne_contribution->CONTACT_MAIL;
				$contact_fonction_extrait = $ligne_contribution->CONTACT_FONCTION;
			}
			else
			{
				$id_pb_extrait = $idpb_pere;
				$contact_titre_extrait = $res[17];
				$contact_prenom_extrait = $res[19];
				$contact_nom_extrait = $res[18];
				$contact_mail_extrait = $res[20];
				$contact_fonction_extrait = $res[21];
			}
/*
			echo "<br />id_pb_extrait : $id_pb_extrait";
			echo "<br />contact_nom_extrait : $contact_nom_extrait";
			echo "<br />contact_prenom_extrait : $contact_prenom_extrait";
			echo "<br />contact_mail_extrait : $contact_mail_extrait";
			echo "<br />contact_fonction_extrait : $contact_fonction_extrait";
*/
////////////////////////////////////////////////////////////
// Fin traitement des contacts du tickets //////////////////
////////////////////////////////////////////////////////////


					echo "<tr>";
						echo "<td class = \"etiquette\">Ancien(s) contact(s)&nbsp;:&nbsp;</td>";

						//nouvelle version avec liste déroulante de tous les contacts //pb des bals fonctionnelles avec des personnes différnetes qui les utilisentg
						echo "<td>";
							echo "<select size= \"1\" name = \"contact_id\">";
								if ($contact_mail_extrait <> "" AND $contact_nom_extrait <> "")
								{
									echo "<option selected value=\"$id_pb_extrait\">$contact_prenom_extrait $contact_nom_extrait - $contact_fonction_extrait - $contact_mail_extrait</option>";
								}
								else
								{
									echo "<option selected value=\"\"></option>";
								}
								//On récupère tous les autres contacts
								$requete_contacts = "SELECT ID_PB, CONTACT_TITRE, CONTACT_PRENOM, CONTACT_NOM, CONTACT_MAIL, CONTACT_FONCTION FROM probleme 
									WHERE ID_PB_PERE = '".$idpb_pere."' OR ID_PB = '".$idpb_pere."' 
									GROUP BY CONTACT_MAIL 
									ORDER BY CONTACT_NOM";
									
								//echo "<br />$requete_contacts";
								
								$res_req_contacts = mysql_query($requete_contacts);
								while ($ligne_contact = mysql_fetch_object($res_req_contacts))
								{
									$id_pb = $ligne_contact->ID_PB;
									$contact_titre = $ligne_contact->CONTACT_TITRE;
									$contact_prenom = $ligne_contact->CONTACT_PRENOM;
									$contact_nom = $ligne_contact->CONTACT_NOM;
									$contact_mail = $ligne_contact->CONTACT_MAIL;
									$contact_fonction = $ligne_contact->CONTACT_FONCTION;
									if ($contact_nom <> "" OR $contact_mail <> "")
									{
										if ($contact_mail <> $contact_mail_extrait)
										{
											echo "<option value=\"$id_pb\">$contact_prenom $contact_nom - $contact_fonction - $contact_mail</option>";
										}
									}
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";

					echo "<tr>";
						echo "<td class = \"etiquette\">Ajouter contact&nbsp;:&nbsp;</td>";
						echo "<td class = \"etiquette\">Titre&nbsp;:&nbsp;<select size= \"1\" name = \"contact_titre\">";
							echo "<option selected value=\"\">Faire un choix</option>";
								echo "<option value=\"M\">M.</option>";
								echo "<option value=\"MME\">MME</option>";
							echo "</select>";

							//On fait appel à la datalist pour proposer les prénoms de contact déjà dans la base
							fc_datalist("probleme","CONTACT_PRENOM","contact_prenom","",32,"Pr&eacute;nom","PRENOM","l_prenom");

							//On fait appel à la datalist pour proposer les noms de contact déjà dans la base
							fc_datalist("probleme","CONTACT_NOM","contact_nom","",32,"Nom","NOM","l_nom");

							echo "<br />";
							//On fait appel à la datalist pour proposer les adresses électronique déjà dans la base
							fc_datalist("probleme","CONTACT_MAIL","contact_mail","",50,"M&eacute;l","courriel","l_mail");

							//On charge la liste déroulante à partir de la table contacts-qualites
							remplir_champ_select("INTITULE","contacts_qualites","Qualité","contact_fonction","");
						echo "</td>";


					echo "</tr>
					<tr>";
						echo "<td class = \"etiquette\">Pas de contact&nbsp;:&nbsp;</td>
						<td><input type=\"checkbox\" name=\"sans_contact\" value=\"Oui\" $checked></td>
   					</tr> 
					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<select name = \"contact_type\" required>
								<option = \"\" VALUE = \"\"></option>
								<option = \"courriel reçu\" VALUE = \"courriel reçu\">courriel reçu</option>
								<option = \"courriel envoy&eacute;\" VALUE = \"courriel envoy&eacute;\">courriel envoy&eacute;</option>
								<option = \"appel t&eacute;l. reçu\" VALUE = \"appel t&eacute;l. reçu\">appel t&eacute;l. reçu</option>
								<option = \"appel t&eacute;l. donn&eacute;\" VALUE = \"appel t&eacute;l. donn&eacute;\">appel t&eacute;l. donn&eacute;</option>
								<option = \"courrier reçu\" VALUE = \"courrier reçu\">courrier reçu</option>
								<option = \"courrier envoy&eacute;\" VALUE = \"courrier envoy&eacute;\">courrier envoy&eacute;</option>
								<option = \"rencontre\" VALUE = \"rencontre\">rencontre</option>
								<option = \"OTA\" VALUE = \"OTA\">OTA</option>
								<option = \"Site TICE\" VALUE = \"Site TICE\">Site TICE</option>
								<option = \"information\" VALUE = \"information\">information</option>
							</select>
						</td>
					</tr>

					<!--/////////////////////////////////
					// Intervenants /////////////////////
					/////////////////////////////////////

            		<tr>
						<td class = \"etiquette\">
							Nom des destinataires&nbsp;:&nbsp;
						</td>

						<td>
							<input type = \"hidden\" VALUE =\"".$res[10]."\" NAME = \"intervenant\" SIZE = \"40\">
							".$res[10]." +
							<input type = \"text\" VALUE =\"\" NAME = \"new_intervenant\" SIZE = \"40\">(s&eacute;par&eacute;s par des ; aucun caract&egrave;res accentu&eacute;s, ni d'espace)
						</td>
					</TR-->

					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Contenu&nbsp;:&nbsp;*</span>
						</td>
						<td>
							<textarea rows = \"15\" COLS = \"120\" NAME = \"contenu\"></textarea>";
								echo "<script type=\"text/javascript\">
									CKEDITOR.replace( 'contenu' );
								</script>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
						</td>
						<td>
							<input type = \"hidden\" VALUE =\"".$tri."\" NAME = \"tri\"> 
							<input type = \"hidden\" VALUE =\"".$id_categ."\" NAME = \"id_categ\">
							<input type = \"hidden\" VALUE =\"".$date_creation_pour_tri."\" NAME = \"date_creation_pour_tri\">
							<input type = \"submit\" VALUE = \"Enregistrer la contribution\">
						</td>
					</tr>
				</table>
				<span class = \"champ_obligatoire\">*Champs obligatoires</span>
			</form>";

			//Fermeture de la connexion à la BDD
			mysql_close();
?>
		</div>
	</body>
</html>
