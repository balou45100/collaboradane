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
	echo "</head>";
			//include("../biblio/ticket.css");
			//include ("../biblio/config.php");
	echo "</head>
	<body>
		<div align = \"center\">";
			//Inclusion des fichiers nécessaires
			include("../biblio/config.php");
			include("../biblio/init.php");
			include("../biblio/fct.php");

			//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui pour le nouveau champ de saisie de la date
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
							<input type = \"hidden\" VALUE = \"".$_SESSION['nom']."\" NAME = \"emetteur\">
							".$_SESSION['nom']."
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							M&eacute;l Emetteur&nbsp;:&nbsp;
						</td>
						<td>
							<input type = \"hidden\" VALUE =\"".$_SESSION['mail']."\" NAME = \"mail_emetteur\">
							".$_SESSION['mail']."
						</td>
					</tr>
					<!--TR>
						<td class = \"etiquette\">Date cr&eacute;ation&nbsp;:&nbsp;</td>
						<td><input type = \"text\" VALUE = \"$date_creation\" NAME = \"date_creation\" SIZE = \"10\">
						</td>
					</TR-->

					<tr>
						<td class = \"etiquette\">Date cr&eacute;ation&nbsp;:&nbsp;</td>
						<td>
							<select size=\"1\" name=\"jour\">
								<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>";
								
								for ($i = 1; $i <= 31; $i++)
								{
									echo "<option value=\"$i\">$i</option>";
								}
							echo "</select>
							<select size=\"1\" name=\"mois\">";
							echo "<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>";
							for ($i = 1; $i <= 12; $i++)
							{
								echo "<option value=\"$i\">$i</option>";
							}
							echo "</select>
							<select size=\"1\" name=\"annee\">
								<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>";
							/*
							for ($i = 1; $i <= 12; $i++)
							{
								echo "<option value=\"$i\">$i</option>";
							}
							*/	
								$annee_a_afficher1=$aujourdhui_annee-1;
								echo "<option value=\"$annee_a_afficher1\">$annee_a_afficher1</option>";
								$annee_a_afficher2=$aujourdhui_annee+1;
								echo "<option value=\"$annee_a_afficher2\">$annee_a_afficher2</option>";
								$annee_a_afficher3=$aujourdhui_annee+2;
								echo "<option value=\"$annee_a_afficher3\">$annee_a_afficher3</option>";
								$annee_a_afficher4=$aujourdhui_annee+3;
								echo "<option value=\"$annee_a_afficher4\">$annee_a_afficher4</option>";
								$annee_a_afficher5=$aujourdhui_annee+4;
								echo "<option value=\"$annee_a_afficher5\">$annee_a_afficher5</option>";
								$annee_a_afficher6=$aujourdhui_annee+5;
								echo "<option value=\"$annee_a_afficher6\">$annee_a_afficher6</option>";
							echo "</select>";
						echo "</td>
					</tr>

					<tr>
						<td class = \"etiquette\">
							EPLE/Ecole&nbsp;:&nbsp;
						</td>
						<td>";
							//Requête pour selectionner tous les établissements
							$query_etab = "SELECT * FROM etablissements";
							$results_etab = mysql_query($query_etab);
							if(!$results_etab)
							{
								echo "<FONT COLOR = \"#808080\"><b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
								echo "<a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des &eacute;tablissements</a>";
								mysql_close();
								exit;
							}

							//Retourne le nombre de ligne rendu par la requète
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
								<option selected></option>
								<option value=\"M\">M.</option>
								<option value=\"MME\">MME</option>
							</select>
							&nbsp;Pr&eacute;nom&nbsp;:&nbsp;<input type = \"text\" VALUE = \"\" NAME = \"contact_prenom\" SIZE = \"32\">
							&nbsp;Nom&nbsp;:&nbsp;<input type = \"text\" VALUE = \"\" NAME = \"contact_nom\" SIZE = \"32\">
							<br />&nbsp;M&eacute;l&nbsp;:&nbsp;<input type = \"text\" VALUE = \"\" NAME = \"contact_mail\" SIZE = \"50\">&nbsp;&nbsp;";

							$test_fonction = remplir_champ_select("qualite","contacts_qualite","Qualité","contact_fonction","");
						echo "</td>
					</tr>

					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Sujet*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<input type = \"text\" VALUE = \"\" NAME = \"sujet\" SIZE = \"64\">
						</td>
					</tr>
					<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<select name = \"contact_type\">
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
					<tr>
						<td class = \"etiquette\">
							<b>Cat&eacute;gorie commune&nbsp;:&nbsp;</b>
						</td>
						<td>";
							echo "<select size=\"1\" name=\"categorie_commune\">";
								echo "<option value=\"\">&nbsp;</option>";
							$requeteliste_cat="SELECT * FROM categorie_commune ORDER BY intitule_categ ASC";
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

///////////////////////////////////////////////////////////////////////////
//Affichage des intervenants avant/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
/*

            			<!--TR>
							<td class = \"etiquette\">
								<span class = \"champ_obligatoire\">Intervenants*&nbsp;:&nbsp;</span>
							</td>
							<td class = \"etiquette\">
								<input type = \"text\" VALUE =\"\" NAME = \"intervenant\" SIZE = \"60\">&nbsp;(s&eacute;par&eacute;s par des ; aucun caract&egrave;res accentu&eacute;s, ni d'espace)
							</td>
						</TR-->
*/
/////////////////////////////////////////////////////////////////////
//Affichage des intervenants apr&egrave;s /////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

					echo "<tr>
						<td class = \"etiquette\">
							<span class = \"champ_obligatoire\">Contenu*&nbsp;:&nbsp;</span>
						</td>
						<td>
							<textarea rows = \"15\" COLS = \"120\" NAME = \"contenu\"></textarea>";
							echo "<script type=\"text/javascript\">
								CKEDITOR.replace( 'contenu' );
							</script></td>";
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
