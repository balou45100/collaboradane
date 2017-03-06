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
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			//Inclusion des fichiers n�cessaires
			include("../biblio/init.php");
			include("../biblio/fct.php");

			//on fixe les variables pour les champs de s�lection des dates &agrave; la date d'aujourd'hui pour le nouveau champ de saisie de la date
			$aujourdhui_jour = date('d');
			$aujourdhui_mois = date('m');
			$aujourdhui_annee = date('Y');

			//pour l'ancien champ de saisie de date
			$date_creation=date('j/m/Y');

			echo"<form action = \"verif_ticket.php\" METHOD = \"POST\">
				<input type = \"hidden\" VALUE = \"N\" NAME = \"statut\">
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
							M&eacute;l Emetteur&nbsp;:&nbsp;
						</td>
						<td>
							&nbsp;<input type = \"hidden\" VALUE =\"".$_SESSION['mail']."\" NAME = \"mail_emetteur\">
							".$_SESSION['mail']."
						</td>
					</tr>
					<TR>
						<td class = \"etiquette\">Date saisie&nbsp;:&nbsp;</td>";
							//$date_creation_a_afficher = strtotime($date_creation);
							//$date_creation_a_afficher = date('d/m/Y',$date_creation_a_afficher);

						echo "<td><input type = \"hidden\" VALUE = \"$date_creation\" NAME = \"date_creation\" SIZE = \"10\">&nbsp;$date_creation</td>
					</TR>

					<tr>
						<td class = \"etiquette\">Date demande&nbsp;:&nbsp;</td>
						<td>";
							echo "<input type=\"text\" id=\"date_demande\"  name=\"date_demande\" value=\"$date_creation\" size = \"10\">";
							echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_demande&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";
						echo "</td>
					</tr>

					<tr>
						<td class = \"etiquette\">
							EPLE/Ecole&nbsp;:&nbsp;
						</td>
						<td>";
							//Requ&egrave;te pour selectionner tous les �tablissements
							$query_etab = "SELECT * FROM etablissements";
							$results_etab = mysql_query($query_etab);
							if(!$results_etab)
							{
								echo "<FONT COLOR = \"#808080\"><b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
								echo "<a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des &eacute;tablissements</a>";
								mysql_close();
								exit;
							}

							//Retourne le nombre de ligne rendu par la requ&egrave;te
							$num_results_etab = mysql_num_rows($results_etab);

							echo "<select name = etab>";
								echo "<option selected = \"null\" VALUE = \"null\"></option>";
								$res_etab = mysql_fetch_row($results_etab);
								for ($j = 0; $j < $num_results_etab; ++$j)
								{
									echo "<option VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>";
									$res_etab = mysql_fetch_row($results_etab);
								}
							echo "</select>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>
						<td class = \"etiquette\">Titre&nbsp;:&nbsp;
							<select size= \"1\" name = \"contact_titre\">
								<option selected>Faire un choix</option>
								<option value=\"M\">M.</option>
								<option value=\"MME\">MME</option>
							</select>";

							//On fait appel � la datalist pour proposer les pr�noms de contact d�j� dans la base
							fc_datalist("probleme","CONTACT_PRENOM","contact_prenom","",32,"Pr&eacute;nom","PRENOM","l_prenom");

							//On fait appel � la datalist pour proposer les noms de contact d�j� dans la base
							fc_datalist("probleme","CONTACT_NOM","contact_nom","",32,"Nom","NOM","l_nom");

							echo "<br />";
							//On fait appel � la datalist pour proposer les adresses �lectronique d�j� dans la base
							fc_datalist("probleme","CONTACT_MAIL","contact_mail","",50,"M&eacute;l","courriel","l_mail");

							//On charge la liste déroulante � partir de la table contacts-qualites
							remplir_champ_select("INTITULE","contacts_qualites","Fonction&nbsp;:&nbsp","contact_fonction","");
						echo "</td>
					</tr>

					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Sujet*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<input type = \"text\" VALUE = \"\" NAME = \"sujet\" SIZE = \"64\" required placeholder=\"Titre du ticket\">
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>
						</td>
						<td>";
						remplir_champ_select("INTITULE","contacts_types","","contact_type","");
/*
							echo "<select name = \"contact_type\" required>
								<option = \"\" VALUE = \"\"></option>
								<option = \"courriel re�u\" VALUE = \"courriel re�u\">courriel re�u</option>
								<option = \"courriel envoy&eacute;\" VALUE = \"courriel envoy&eacute;\">courriel envoy&eacute;</option>
								<option = \"appel t&eacute;l. re�u\" VALUE = \"appel t&eacute;l. re�u\">appel t&eacute;l. re�u</option>
								<option = \"appel t&eacute;l. donn&eacute;\" VALUE = \"appel t&eacute;l. donn&eacute;\">appel t&eacute;l. donn&eacute;</option>
								<option = \"courrier re�u\" VALUE = \"courrier re�u\">courrier re�u</option>
								<option = \"courrier envoy&eacute;\" VALUE = \"courrier envoy&eacute;\">courrier envoy&eacute;</option>
								<option = \"rencontre\" VALUE = \"rencontre\">rencontre</option>
								<option = \"OTA\" VALUE = \"OTA\">OTA</option>
								<option = \"Site TICE\" VALUE = \"Site TICE\">Site TICE</option>
								<option = \"information\" VALUE = \"information\">information</option>
							</select>";
*/
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							<b>Cat&eacute;gorie commune&nbsp;:&nbsp;</b>
						</td>
						<td>";
							echo "<select size=\"1\" name=\"categorie_commune\">";
								echo "<option value=\"\">&nbsp;</option>";
							$requeteliste_cat="SELECT * FROM categorie_commune WHERE actif = 'O' ORDER BY intitule_categ ASC";
							$result=mysql_query($requeteliste_cat);
							$num_rows = mysql_num_rows($result);
							if (mysql_num_rows($result))
							{
								//echo "<option selected value=\"000\">Toutes</option>";
								while ($ligne=mysql_fetch_object($result))
								{
									$id_categ=$ligne->id_categ;
									$intitule_categ=$ligne->intitule_categ;
									echo "<option value=\"$id_categ\">$intitule_categ</option>";
								}
							}
							echo "</select>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							Priorit&eacute;&nbsp;:&nbsp;
						</td>
						<td>
							<select name = \"priorite\">
								<option selected = \"2\" VALUE = \"2\">Normal</option>
								<option = \"1\" VALUE = \"1\">Haute</option>
								<option = \"3\" VALUE = \"3\">Basse</option>
							</select>
						</td>
					</tr>";

/////////////////////////////////////////////////////////////////////
//Affichage des intervenants ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

					echo "<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Contenu*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<textarea rows = \"15\" COLS = \"120\" NAME = \"contenu\"></textarea>";
							echo "<script type=\"text/javascript\">CKEDITOR.replace( 'contenu' );</script>";
						echo "</td>";
						echo "</td>
					</tr>
					<tr>
						<td class = \"etiquette\"></td>
						<td align = \"center\">
						  <input type = \"submit\" VALUE = \"Enregistrer le ticket\">
						  <input type = \"hidden\" VALUE = \"gest_ticket\" NAME = \"origine\">
						</td>
					</tr>
				</table>
				<span class = \"champ_obligatoire\">*champs obligatoires</span>
			</form>";

			//Fermeture de la connexion &agrave; la BDD
			mysql_close();
?>
		</div>
	</body>
</html>
