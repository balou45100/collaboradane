<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	$id = $_SESSION['id_util'];
?>

<!DOCTYPE html>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	$id_util = $_SESSION['id_util'];
	
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
			//Inclusion des fichiers nécessaires
			include("../biblio/init.php");
			include("../biblio/fct.php");
			include ("../biblio/config.php");


			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
			//Récupération des données
			$statut = $_POST['statut'];
			$idpb_pere = $_POST['idpbpere'];
			$id_categ = $_POST['id_categ'];
			$emetteur = $_POST['emetteur'];
			$mail_emetteur = $_POST['mail_emetteur'];
			$etab = $_POST['etab'];
			$sujet = str_replace("'"," ", $_POST['sujet']);
			$intervenant = $_POST['intervenant'];
			$new_intervenant = $_POST['new_intervenant'];
			//$contenu = nl2br(str_replace("'"," ", $_POST['contenu'])); //Pas nécessaire avec CFKEditor
			$contenu = $_POST['contenu'];
			$denom_etab = $_POST['denom_etab'];
			//$date_creation = $_POST['date_creation'];
			$date_demande = $_POST['date_demande'];
			$jour= $_POST['jour'];
			$mois = $_POST['mois'];
			$annee= $_POST['annee'];
			$date_creation_pour_tri = $_POST['date_creation_pour_tri'];
			$contact_type = $_POST['contact_type'];
			$tri = $_POST['tri'];
			$contact_titre =$_POST['contact_titre'];
			$contact_prenom =$_POST['contact_prenom'];
			$contact_nom =$_POST['contact_nom'];
			$contact_mail =$_POST['contact_mail'];
			$contact_fonction =$_POST['contact_fonction'];
			$sans_contact = $_POST['sans_contact'];
			$contact_id = $_POST['contact_id'];

			/*
			echo "<br />date_demande : $date_demande";
			echo "<br />contact_id : $contact_id";
			echo "<br />contact_titre : $contact_titre";
			echo "<br />contact_prenom : $contact_prenom";
			echo "<br />contact_nom : $contact_nom";
			echo "<br />contact_mail : $contact_mail";
			echo "<br />contact_fonction : $contact_fonction";
			*/

			//On vérifie si un nouveau contact a été saisie
			if ($contact_nom == "" AND $contact_mail == "")
			{
				//Il faut récupérer le contact à partir de contact_id transmis par la liste déroulante
				$requete_contact = "SELECT ID_PB, CONTACT_TITRE, CONTACT_PRENOM, CONTACT_NOM, CONTACT_MAIL, CONTACT_FONCTION FROM probleme 
					WHERE ID_PB = '".$contact_id."'"; 
				$res_req_contact = mysql_query($requete_contact);
				$ligne_contact = mysql_fetch_object($res_req_contact);
				$id_pb = $ligne_contact->ID_PB;
				$contact_titre = $ligne_contact->CONTACT_TITRE;
				$contact_prenom = $ligne_contact->CONTACT_PRENOM;
				$contact_nom = $ligne_contact->CONTACT_NOM;
				$contact_mail = $ligne_contact->CONTACT_MAIL;
				$contact_fonction = $ligne_contact->CONTACT_FONCTION;
			}
			/*
			echo "<Br>verif_ajout_reponse : jour : $jour</Br>";
			echo "<Br>verif_ajout_reponse : mois : $mois</Br>";
			echo "<Br>verif_ajout_reponse : annee : $annee</Br>";
			echo "<br>date_creation_pour_tri : $date_creation_pour_tri<br>";
			*/
			//$date_demande_a_enregistrer = crevardate($jour,$mois,$annee); //nouvelle methode pour le champ date_crea
			$date_demande_a_enregistrer = $date_demande;
			
			$date_creation = date('Y-m-j');
			/*
			echo "<br />1- date_demande_a_enregistrer : $date_demande_a_enregistrer";
			echo "<br />1- date_creation : $date_creation";
			*/

			if ($sans_contact == "Oui")
			{
			  $contact_titre = "";
			  $contact_prenom = "";
			  $contact_nom = "";
			  $contact_mail = "";
			  $contact_fonction = "";
			  $checked ="checked";
			}
			else
			{
			  $checked ="";
			}
			
			//echo "<br>titre : $contact_titre - prenom : $contact_prenom - nom : $contact_nom - mail : $contact_mail - fonction : $contact_fonction";
			//Test des champs récupérés
			if(!isset($emetteur) || !isset($mail_emetteur) || !isset($etab) ||
			!isset($sujet) || !isset($contenu) || !isset($statut) ||
			!isset($idpb_pere) || $emetteur == "" || $mail_emetteur == "" ||
			$sujet == "" ||  $contenu == "" || $statut == "" || $contact_type == "")
			{
				echo"
					<h2 class = \"champ_obligatoire\">Informations manquantes&nbsp;!</h2>
					<FORM ACTION = \"verif_ajout_reponse_ticket.php\" METHOD = \"POST\">
						<INPUT TYPE = \"hidden\" VALUE = \"R\" NAME = \"statut\">
						<TABLE BORDER = \"0\">
						<TR>
							<td>
								<INPUT TYPE = \"hidden\" VALUE = \"".$idpb_pere."\" NAME = \"idpbpere\">
							</TD>
						</TR>
						<TR>
							<td class = \"etiquette\">
								Emetteur
							</TD>
							<td>
								<INPUT TYPE = \"hidden\" VALUE = \"".$_SESSION['nom']."\" NAME = \"emetteur\">
								".$_SESSION['nom']."
							</TD>
						</TR>
						<TR>
							<td class = \"etiquette\">
								Mail Emetteur
							</TD>
							<td>
								<INPUT TYPE = \"hidden\" VALUE =\"".$_SESSION['mail']."\" NAME = \"mail_emetteur\">
								".$_SESSION['mail']."
							</TD>
						</TR>
						<TR>
							<td class = \"etiquette\">
								Etablissement
							</TD>
							<td>
								<INPUT TYPE = \"hidden\" VALUE =\"".$etab."\" NAME = \"etab\">
								".$denom_etab."
								<INPUT TYPE = \"hidden\" VALUE =\"".$denom_etab."\" NAME = \"denom_etab\">
							</TD>
						</TR>
						<TR>
							<td class = \"etiquette\">
								Sujet
							</TD>
							<td>
								<INPUT TYPE = \"hidden\" VALUE = \"".$sujet."\" NAME = \"sujet\" SIZE = \"32\">
								".$sujet."
							</TD>
						</TR>
				<TR>
						<td class = \"etiquette\">Date saisie</TD>
						<td><INPUT TYPE = \"hidden\" VALUE = \"$date_creation\" NAME = \"date_creation\" SIZE = \"10\">$date_creation
						</TD>
				</TR>

				  <TR>
						<td class = \"etiquette\">Date contribution&nbsp;:&nbsp;</TD>
						<td>";

							echo "<input type=\"text\" id=\"date_demande\"  name=\"date_demande\" value=\"$date_demande\" size = \"10\">";
							echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_demande&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";

						echo "</TD>
					</TR>";

					echo "<TR>
						<td class = \"etiquette\">Contact&nbsp;:&nbsp;</TD>
						<td class = \"etiquette\">Titre&nbsp;:&nbsp;<select size= \"1\" name = \"contact_titre\">
						  <option selected>$contact_titre</option>
							<option value=\"M\">M.</option>
							<option value=\"MME\">MME</option>
							</select>";

								//On fait appel à la datalist pour proposer les prénoms de contact déjà dans la base
								fc_datalist("probleme","CONTACT_PRENOM","contact_prenom",$contact_prenom,32,"Pr&eacute;nom","PRENOM","l_prenom");

								//On fait appel à la datalist pour proposer les noms de contact déjà dans la base
								fc_datalist("probleme","CONTACT_NOM","contact_nom",$contact_nom,32,"Nom","NOM","l_nom");
								
								echo "<br />";

								//On fait appel à la datalist pour proposer les adresses électronique déjà dans la base
								fc_datalist("probleme","CONTACT_MAIL","contact_mail",$contact_mail,50,"M&eacute;l","courriel","l_mail");
								

								//On récupère les enregistrements de la table contacts_qualites
								remplir_champ_select("INTITULE","contacts_qualites","Qualit&eacute;","contact_fonction",$contact_fonction);
						echo "</TD>
					
					</TR>
					<TR>
						<td class = \"etiquette\">Pas de contact&nbsp;:&nbsp;</TD>
						<td><input type=\"checkbox\" name=\"sans_contact\" value=\"Oui\" $checked></TD>
					</TR> 

					<TR>
						<td class = \"etiquette\">";
							if ($contact_type == "")
							{
								echo "Type*&nbsp;:&nbsp;";
							}
							else
							{
								echo "Type&nbsp;:&nbsp;";
							}
						echo "</TD>
						<td>
							<SELECT NAME = \"contact_type\">
								<OPTION SELECTED = \"$contact_type\" VALUE = \"$contact_type\">$contact_type</OPTION>
								<OPTION = \"courriel reçu\" VALUE = \"courriel reçu\">courriel reçu</OPTION>
								<OPTION = \"courriel envoyé\" VALUE = \"courriel envoyé\">courriel envoyé</OPTION>
								<OPTION = \"appel tél. reçu\" VALUE = \"appel tél. reçu\">appel tél. reçu</OPTION>
								<OPTION = \"appel tél. donné\" VALUE = \"appel tél. donné\">appel tél. donné</OPTION>
								<OPTION = \"courrier reçu\" VALUE = \"courrier reçu\">courrier reçu</OPTION>
								<OPTION = \"courrier envoyé\" VALUE = \"courrier envoyé\">courrier envoyé</OPTION>
								<OPTION = \"rencontre\" VALUE = \"rencontre\">rencontre</OPTION>
								<OPTION = \"OTA\" VALUE = \"OTA\">OTA</OPTION>
								<OPTION = \"Site TICE\" VALUE = \"Site TICE\">Site TICE</OPTION>
								<OPTION = \"information\" VALUE = \"information\">information</OPTION>
							</SELECT>
						</TD>
					</TR>
			<!--/////////////////////////////////
			// Intervenants /////////////////////
			/////////////////////////////////////

					<TR>
					  <td class = \"etiquette\">
								Nom des destinataires
						</TD>
						<td class = \"etiquette\">
								<INPUT TYPE = \"hidden\" VALUE =\"".$intervenant."\" NAME = \"intervenant\" SIZE = \"40\">
								".$intervenant." +
								<INPUT TYPE = \"text\" VALUE =\"".$new_intervenant."\" NAME = \"new_intervenant\" SIZE = \"40\">(séparés par des ; aucun caractères accentués, ni d'espace)
						</TD>
					</TR>
					
			/////////////////////////////////////-->
					
					<TR>
						<td class = \"etiquette\">";
							if ($contenu == "")
							{
								echo "Contenu*&nbsp;:&nbsp;";
							}
							else
							{
								echo "Contenu&nbsp;:&nbsp;";
							}
						echo "</TD>
						<td class = \"etiquette\">
							<TEXTAREA ROWS = \"15\" COLS = \"120\" NAME = \"contenu\">".$contenu."</TEXTAREA>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'contenu' );
							</script></td>";
						echo "</TD>
					</TR>
					<TR>
						<td class = \"etiquette\">
						</TD>
						<td class = \"etiquette\">
							  <INPUT TYPE = \"hidden\" VALUE =\"".$tri."\" NAME = \"tri\">
							  <INPUT TYPE = \"hidden\" VALUE =\"".$id_categ."\" NAME = \"id_categ\">
								<INPUT TYPE = \"hidden\" VALUE =\"".$date_creation_pour_tri."\" NAME = \"date_creation_pour_tri\">
							  <INPUT TYPE = \"submit\" VALUE = \"Enregistrer la contribution\">
						</TD>
					</TR>
					</TABLE>
					<B>*Champs obligatoires</B>
				</FORM>
			</CENTER>";
				exit;
			}
			
			//La fonction trim permet l'élagage des espaces avant et aprés la chaîne
			if(trim($new_intervenant) != "")
			{
				$intervenant_glo = $intervenant.";".$new_intervenant;
			}
			else
			{
				$intervenant_glo = $intervenant;
			}
						
			include("../biblio/init.php");
			/*
			echo "<br />2- date_demande : $date_demande";
			echo "<br />2- date_demande_a_enregistrer : $date_demande_a_enregistrer";
			*/
			//Insertion d'une réponse
			$query = "INSERT INTO probleme (ID_PB_PERE, MAIL_INDIVIDU_EMETTEUR, NOM_INDIVIDU_EMETTEUR,
			NUM_ETABLISSEMENT, NOM, TEXTE,  DATE_CREATION, CONTACT_TYPE, INTERVENANT, STATUT, CONTACT_TITRE,CONTACT_PRENOM,CONTACT_NOM,CONTACT_MAIL,CONTACT_FONCTION,date_crea, date_demande) VALUES ('".$idpb_pere."', '".$mail_emetteur."',
			'".$emetteur."', '".$etab."', '".$sujet."', '".$contenu."', '".$date_creation."', '".$contact_type."','".$intervenant_glo."', '".$statut."','".$contact_titre."','".ucfirst($contact_prenom)."','".strtoupper($contact_nom)."','".$contact_mail."','".$contact_fonction."','".$date_creation."','".$date_demande_a_enregistrer."');";
			
			//echo "<br />$query<br />";
			
			$results = mysql_query($query);
			
			//Dans le cas où aucun résultats n'est retourné
			if(!$results)
			{
				echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
				echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
				mysql_close();
				exit;
			}
			else
			{
				//Mise à Jour de la liste des intervenants
				/*
				$query = "UPDATE probleme SET INTERVENANT = '".$intervenant_glo."', statut_traitement='C' WHERE ID_PB = '".$idpb_pere."';";
				$results = mysql_query($query);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results)
				{
					echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					mysql_close();
					exit;
				}
				else
				{
					//On supprime d'abord les intervenants du tickets pour tenir compte de la liste modifiée ensuite
					//echo "<br>idpb : $idpb";
					$suppression_intervenants = "DELETE FROM intervenant_ticket WHERE id_tick = $idpb_pere";
					$resultat_suppression_intervenants = mysql_query($suppression_intervenants);
					//echo "<br>resultat : $suppression_intervenants";
					//Insertion de nouveaux intervenants dans la table intervenant_ticket
					$nom = explode (";",strtoupper($intervenant_glo));
					// On compte le nombre de valeurs du tableau donc d'intervenants du ticket
					$nb = count ($nom);
					$nb_reel = $nb;
					$nb=0;
					// On sélectionne l'id correspondant pour chaucun d'eux
					for ($nb=0; $nb<$nb_reel; $nb++)
					{
						$id_interv="select id_util from util where nom = '$nom[$nb]';";
						$query = mysql_query ($id_interv);
						while ($results1 = mysql_fetch_row ($query))
						{
							$nom1 = $results1[0];
							$ajout = "INSERT INTO intervenant_ticket VALUES ($idpb_pere, $id, $nom1);";
							$maj = mysql_query ($ajout);
						}
					}
				}
				*/
				echo "<B>Une nouvelle r&eacute;ponse a &eacute;t&eacute; ins&eacute;r&eacute;e</B>";
				echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
				//echo "<br /<a href = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
			}
			//Enregistrement de la date de dernière intervention et mis à jour du champ de la personne traitant le ticket dans le ticket père
			$query_maj_date_derniere_intervention = "UPDATE probleme SET DATE_DERNIERE_INTERVENTION = '".$date_creation_pour_tri."', TRAITE_PAR ='".$emetteur."', VERROU = '0', VERROUILLE_PAR = '', STATUT_TRAITEMENT = 'C' WHERE ID_PB = '".$idpb_pere."';";
			$results_maj_date_derniere_intervention = mysql_query($query_maj_date_derniere_intervention);
			if(!$results_maj_date_derniere_intervention)
			{
				echo "<B>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;e ou probl&egrave;me inexistant</B>";
				echo "<BR><BR><A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
				mysql_close();
				exit;
			}
			
			//Fermeture de la connexion à la BDD
			mysql_close();
?>
		</CENTER>
	</BODY>
</HTML>
