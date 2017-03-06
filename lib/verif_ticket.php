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
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	$id_util = $_SESSION['id_util'];
	
	//Inclusion des fichiers nécessaires
	include("../biblio/init.php");
	include("../biblio/fct.php");


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
			//Récupération des variables
			if ($methode_origine == "GET")
			{
				$origine = "gest_ecl_2e_tours";
				$indice = $_POST['indice'];
			}

			//echo "<br />methode_origine : $methode_origine";

			$origine = $_GET['origine'];
			if (($origine == "gest_ecl") OR ($origine == "ecl_consult_fiche")) 
			{
				$etab = $_GET['etab'];
				$rechercher = $_GET['rechercher'];
				$priorite = "2";
				$statut = "N";
				$methode_origine = "GET";
				$indice = $_GET['indice'];

				//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui pour le nouveau champ de saisie de la date
				$jour = date('d');
				$mois = date('m');
				$annee = date('Y');
			}
			else
			{
				$origine = $_POST['origine'];
				$indice = $_POST['indice'];
				$rechercher = $_POST['rechercher'];
				//$date_creation = $_POST['date_creation'];
				$date_demande = $_POST['date_demande'];
				//$jour= $_POST['jour'];
				//$mois = $_POST['mois'];
				//$annee= $_POST['annee'];
				$etab = $_POST['etab'];
				$sujet = $_POST['sujet'];
				$intervenant = str_replace(" ","",$_POST['intervenant']);
				$contenu = $_POST['contenu'];
				$statut = $_POST['statut'];
				$priorite = $_POST['priorite'];
				$contact_titre = $_POST['contact_titre'];
				$contact_prenom = $_POST['contact_prenom'];
				$contact_nom = $_POST['contact_nom'];
				$contact_mail = $_POST['contact_mail'];
				$contact_fonction = $_POST['contact_fonction'];
				$categorie_commune = $_POST['categorie_commune'];
				$contact_type = $_POST['contact_type'];
				$fichier = $_POST['fichier'];
				$id_categ = $_POST['id_categ'];
			}
			$emetteur = $_SESSION['nom'];
			$mail_emetteur = $_SESSION['mail'];
			
			/*
			echo "<br />contact_prenom : $contact_prenom";
			echo "<br />contact_mail : $contact_mail";
			echo "<br />contact_fonction : $contact_fonction";
			echo "<br />date cr&eacute;ation 1 : $date_creation";
			echo "<br />jour : $jour";
			echo "<br />mois : $mois";
			echo "<br />annee : $annee";
			echo "<br />categorie_commune : $categorie_commune";
			echo "<br />date_demande : $date_demande";
			*/

			/*
			if ($date_creation == "")
			{
				$date_creation=date('j/m/Y');
			}
			*/
			
			$date_creation = date('Y-m-j');
			$date_creation_a_afficher = date('j/m/Y');

			//$date_demande_a_enregistrer = crevardate($jour,$mois,$annee); //nouvelle methode pour le champ date_crea	
			$date_demande_a_enregistrer = $date_demande;

		/*
			echo "<br />origine : $origine<br />";
			echo "<br />indice : $indice";
			echo "<br />rechercher : $rechercher";
			echo "<br />etab : $etab";
			echo "<br />date cr&eacute;ation 2 : $date_creation";
			echo "<br />date_demande_a_enregistrer : $date_demande_a_enregistrer";
			*/

			//Traitement du cas des priorités
			switch ($priorite)
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
			}

			//Récupération des données en rapport avec l'établissement
			$query_etab = "SELECT * FROM etablissements where RNE = '".$etab."';";
			$results_etab_select = mysql_query($query_etab);
			//Dans le cas où aucun résultats n'est retourné
			if(!$results_etab_select)
			{
				echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
				echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				//mysql_close();
				exit;
			}
			$num_results_etab_select = mysql_num_rows($results_etab_select);
			$res_etab = mysql_fetch_row($results_etab_select);
			//fin récupération de l'établissement selectionné

			//Récupération des établissements non selectionnés
			$query_non_etab_select = "SELECT * FROM etablissements where RNE != '".$etab."';";
			$results_non_etab_select = mysql_query($query_non_etab_select);
			//Dans le cas où aucun résultats n'est retourné
			if(!$results_non_etab_select)
			{
				echo "<b>Probl&egrave;me de connexion &agrave; la base de donn&eacute;es</b>";
				echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
				//mysql_close();
				exit;
			}
			$num_results_etab_non_select = mysql_num_rows($results_non_etab_select);
			$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
			//fin de recup de tous les établissements non selectionnées

			//Récupération des données sur l'emetteur
			/*
			$query_emetteur = "SELECT * FROM individu WHERE MAIL = '".$mail_emetteur."' AND NOM = '".$emetteur."';";
			$result_emetteur = mysql_query($query_emetteur);
			if(!$result_emetteur)
			{
				echo "Probl&egrave;me de connexion &agrave; la base de donn&eacute;es";
				exit;
			}
			$res_emetteur = mysql_fetch_row($result_emetteur);
			*/

			/*
			echo "<br />emetteur : $emetteur";
			echo "<br />mail_emetteur : $mail_emetteur";
			echo "<br />etab : $etab";
			echo "<br />sujet : $sujet";
			echo "<br />intervanant : $intervenant";
			echo "<br />contenu : $contenu";
			echo "<br />statut : $statut";
			*/

			if(!isset($emetteur) || !isset($mail_emetteur) || !isset($etab) ||
				!isset($sujet) ||  !isset($contenu) || !isset($statut) ||
				$emetteur == "" || $mail_emetteur == "" ||
				$sujet == "" || $contenu == "" || $statut == "" || $contact_type == "")
			{
				//mysql_close();
				if (($origine <> "gest_ecl") AND ($origine <> "ecl_consult_fiche"))
				{
					echo"<h2 class = \"champ_obligatoire\">Informations manquantes&nbsp;!</h2>";
				}

				echo "<form action = \"verif_ticket.php\" METHOD = \"POST\">
					<input type = \"hidden\" VALUE = \"".$statut."\" NAME = \"statut\">
					<table>
						<tr>
							<td class = \"etiquette\">Emetteur&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type = \"hidden\" VALUE = \"".$emetteur."\" NAME = \"emetteur\">".$emetteur."</td>
						</tr>

						<tr>
							<td class = \"etiquette\">M&eacute;l Emetteur&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type = \"hidden\" VALUE =\"".$mail_emetteur."\" NAME = \"mail_emetteur\">".$mail_emetteur."</td>
						</tr>

						<TR>
							<td class = \"etiquette\">Date cr&eacute;ation&nbsp;:&nbsp;</td>
							<td>&nbsp;<input type = \"hidden\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">$date_creation_a_afficher</td>
						</TR>

						<tr>
							<td class = \"etiquette\">Date demande&nbsp;:&nbsp;</td>
							<td>";

								echo "<input type=\"text\" id=\"date_demande\"  name=\"date_demande\" value=\"$date_demande\" size = \"10\">";
								echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_demande&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a>";

/*
								echo "<select size=\"1\" name=\"jour\">
									<option selected value=\"$jour\">$jour</option>";
								for($i=1; $i < 32 ; $i++)
								{
									echo "<option value=\"$i\">$i</option>";
								} 
							echo "</select>";
								echo "<select size=\"1\" name=\"mois\">
									<option selected value=\"$mois\">$mois</option>";
								for($i=1; $i < 13 ; $i++)
								{
									echo "<option value=\"$i\">$i</option>";
								} 
							echo "</select>";
								echo "<select size=\"1\" name=\"annee\">
									<option selected value=\"$annee\">$annee</option>";
									for($i=$aujourdhui_annee-1; $i < $aujourdhui_annee+3 ; $i++)
									{
										if ($i <> $aujourdhui_annee)
										{
											echo "<option value=\"$i\">$i</option>";
										}
									} 
								echo "</select>";
*/
							echo "</td>
						</tr>
						<tr>
							<td class = \"etiquette\">EPLE/Ecole&nbsp;:&nbsp;</td>
							<td><select name = \"etab\">";
								for ($i=0; $i < $num_results_etab_non_select; ++$i)
								{
									echo "<option VALUE = \"".$res_non_etab_select[0]."\">".$res_non_etab_select[0]." -- ".str_replace("*", " ",$res_non_etab_select[1])." ".str_replace("*", " ",$res_non_etab_select[3]). " -- ".$res_non_etab_select[5]."</option>";
									//echo "<option VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>";

									$res_non_etab_select = mysql_fetch_row($results_non_etab_select);
								}
								echo "<option selected = \"".$res_etab[0]."\" VALUE = \"".$res_etab[0]."\">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</option>
									</select>
							</td>
						</tr>";

						echo "<tr>
							<td class = \"etiquette\">Contact&nbsp;:&nbsp;</td>
							<td class = \"etiquette\">Titre&nbsp;:&nbsp;
								<select size= \"1\" name = \"contact_titre\">
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
								
								//echo "<br />contact_mail : $contact_mail<br />";

								//On récupère les enregistrements de la table contacts_qualites
								remplir_champ_select("INTITULE","contacts_qualites","Qualit&eacute;","contact_fonction",$contact_fonction);
							echo "</td>
						</tr>

						<tr>
							<td class = \"etiquette\">";
								if ($sujet == "")
								{
									echo "<span class = \"champ_obligatoire\">Sujet*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Sujet&nbsp;:&nbsp;";
								}
							echo "</td>
							<td><input type = \"text\" VALUE = \"".$sujet."\" NAME = \"sujet\" SIZE = \"64\" required placeholder=\"Titre du ticket\"></td>
						</tr>

						<tr>
							<td class = \"etiquette\">";
								if ($contact_type == "")
								{
									echo "<span class = \"champ_obligatoire\">Type*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Type&nbsp;:&nbsp;";
								}
							echo "</td>
							<td>
								<select name = \"contact_type\" required>
									<option selected = \"$contact_type\" VALUE = \"$contact_type\">$contact_type</option>
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
							<td class = \"etiquette\"><b>Cat&eacute;gorie commune&nbsp;:&nbsp;</b></td>
							<td>";
								include("../biblio/init.php");
								//Je récupère l'intitulé de la catégorie commune à afficher
								//echo "<br />categorie_commune : $categorie_commune";
								if (ISSET($categorie_commune))
								{
									$requete_int_cat_com = "SELECT * FROM categorie_commune WHERE id_categ = $categorie_commune";
									$result_int_cat_com = mysql_query($requete_int_cat_com);
									$ligne = mysql_fetch_object($result_int_cat_com);
									$intitule_categ_a_afficher=$ligne->intitule_categ;
									$id_categ_a_afficher=$ligne->id_categ;
								}
								//Maintenant je recupère les autres intitulés
								$requete_cat="SELECT * FROM categorie_commune WHERE actif = 'O' ORDER BY intitule_categ ASC";
								$result=mysql_query($requete_cat);
								$num_rows = mysql_num_rows($result);
								echo "<select size=\"1\" name=\"categorie_commune\">";
								if (mysql_num_rows($result))
								{
									echo "<option selected value=\"$id_categ_a_afficher\">$intitule_categ_a_afficher</option>";
									while ($ligne=mysql_fetch_object($result))
									{
										$id_categ=$ligne->id_categ;
										$intitule_categ=$ligne->intitule_categ;
										if ($intitule_categ <> $intitule_categ_a_afficher)
										{
											echo "<option value=\"$id_categ\">$intitule_categ</option>";
										}
									}
								}
								echo "</select>";
							echo "</td>
						</tr>

						<tr>
							<td class = \"etiquette\">Priorit&eacute;&nbsp;:&nbsp;</td>
							<td>
								<select name = \"priorite\">
									<option selected = \"".$priorite."\" VALUE = \"".$priorite."\">".$priorite_selection."</option>
									<option = \"".$priorite_non_selection_ref_1."\" VALUE = \"".$priorite_non_selection_ref_1."\">".$priorite_non_selection_nom_1."</option>
									<option = \"".$priorite_non_selection_ref_2."\" VALUE = \"".$priorite_non_selection_ref_2."\">".$priorite_non_selection_nom_2."</option>
								</select>
							</td>
						</tr>";
/*
						<tr>
							<td class = \"etiquette\">";
								if ($intervenant == "")
								{
									echo "<span class = \"champ_obligatoire\">Intervenant*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Intervenant&nbsp;:&nbsp;";
								}
							echo "</td>
							<td><input type = \"text\" VALUE =\"".$intervenant."\" NAME = \"intervenant\" SIZE = \"60\">&nbsp;(s&eacute;par&eacute;s par des ; aucun caract&egrave;res accentu&eacute;s, ni d'espace)</td>
						</tr>
*/
						echo "<tr>
							<td class = \"etiquette\">";
								if ($contenu == "")
								{
									echo "<span class = \"champ_obligatoire\">Contenu*&nbsp;:&nbsp;</span>";
								}
								else
								{
									echo "Contenu&nbsp;:&nbsp;";
								}
							echo "</td>
							<td><textarea rows = \"15\" COLS = \"120\" NAME = \"contenu\">".$contenu."</textarea>";
								echo "<script type=\"text/javascript\">
									CKEDITOR.replace( 'contenu' );
								</script>";
							echo "</td>
						</tr>

						<tr>
							<td class =\"etiquette\"></td>
							<td align = \"center\">
								<input type = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">
								<input type = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">
								<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">
								<input type = \"submit\" VALUE = \"Enregistrer le ticket\">
							</td>
						</tr>
					</table>
					<span class = \"champ_obligatoire\">*champs obligatoires</span>
				</form>";
			}
			else
			{
				$sujet = str_replace("'", " ", $sujet);

				//la fonction nl2br remplace tout les symboles de retour chariot par des balises <br /> pas nécessaire avec CKEditor
				//$contenu_modif = nl2br(str_replace("'"," ", $contenu));

				$contenu_modif = $contenu;

				//Cas de l'ajout d'un problème
				if($statut == "N")
				{
					$query_insert = "INSERT INTO probleme (MAIL_INDIVIDU_EMETTEUR,NOM_INDIVIDU_EMETTEUR,
					NUM_ETABLISSEMENT,
					NOM, TEXTE, DATE_CREATION, INTERVENANT, STATUT, NB_MESS, PRIORITE, CONTACT_TITRE, CONTACT_PRENOM, CONTACT_NOM, CONTACT_MAIL, CONTACT_FONCTION, CONTACT_TYPE, date_crea, date_demande)
					VALUES ('".$mail_emetteur."', '".$emetteur."', '".$res_etab[0]."', '".$sujet."', '".$contenu_modif."',
						'".$date_creation."','".strtoupper($intervenant)."', '".$statut."', '0', '".$priorite."', '".$contact_titre."', '".ucfirst($contact_prenom)."', '".strtoupper($contact_nom)."', '".$contact_mail."', '".$contact_fonction."', '".$contact_type."','".$date_creation."','".$date_demande_a_enregistrer."');";
					//exit;
					//echo "<br />query_insert : $query_insert";
					
					$results_insert = mysql_query($query_insert);
					if(!$results_insert)
					{
						echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
						echo "<br /><br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
						mysql_close();
						exit;
					}
					else
					{
						//On ne mets plus à jour le champ NB_PB
						/*
						$query_update = "UPDATE etablissements SET NB_PB = NB_PB+1 WHERE RNE='".$res_etab[0]."'";
						$results_update = mysql_query($query_update);
						if(!$results_update)
						{
							echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
							echo "<br /><br /> <a href = \"gestion_ticket.php\" class = \"bouton\">Retour à la gestion des tickets</a>";
							mysql_close();
							exit;
						}
						*/
						$no_dernier_id_genere = mysql_insert_id();
						//echo "<br />Dernier id g&eacute;n&eacute;r&eacute; : $no_dernier_id_genere";

						//On ajoute le créateur comme intervenant
						
						//echo "<br />id : $id_util";
						
						$ajout = "INSERT INTO intervenant_ticket VALUES ($no_dernier_id_genere, $id_util, $id_util);";
						
						//echo "<br />requete : $ajout";
						
						$maj = mysql_query($ajout);

						//récupération du N° du ticket et ajout des intervenants dans la table intervenant_ticket
						$query_no = "SELECT * FROM probleme where MAIL_INDIVIDU_EMETTEUR = '".$mail_emetteur."' AND NOM = '".$sujet."' AND TEXTE = '".$contenu_modif."';";
						$results_no = mysql_query($query_no);
						$ligne=mysql_fetch_object($results_no);
						$no_ticket=$ligne->ID_PB;
						//echo "<br />Dernier id extrait : $no_ticket";
						//On regarde s'il y a une catégorie commune à enregistrer
						//echo "<br />categorie_c1ommune : $categorie_commune";
						//echo "<br />no_ticket : $no_ticket";

						if ($categorie_commune <>"")
						{
							//echo "<br />verif_ticket, test ISSET categorie_commune est vrai";
							$query_ajout_cat_com = "INSERT INTO categorie_commune_ticket (id_categ,id_ticket)
							VALUES ('$categorie_commune','$no_ticket');";
								$results_ajout_cat_com = mysql_query($query_ajout_cat_com);
						}

						////////////////////////////////////////////////////////////////////
						//On affiche le bouton pour aller à la page de saisie des intervenants//
						////////////////////////////////////////////////////////////////////////

						echo "<br /><h2>Le ticket No $no_ticket a &eacute;t&eacute; enregistr&eacute; </h2>";
						echo "<form action = \"saisie_intervenants_ticket.php\" METHOD = \"GET\">";
							echo "<input type = \"submit\" VALUE = \"Cliquez ici pour saisir les intervenants\">";
							echo "<input type = \"hidden\" VALUE = \"$no_ticket\" NAME = \"no_ticket\">";
							echo "<input type = \"hidden\" VALUE = \"$origine\" NAME = \"origine\">";
						echo "</form>";

						echo "<br /><br />";
						if ($origine == "gest_ticket")
						{
							echo "<form action = \"gestion_ticket.php\" METHOD = \"GET\">";
								echo "<input type = \"submit\" VALUE = \"Retour &agrave; la gestion des tickets sans enregistrer d'intervenants\">";
							echo "</form>";
						}
						elseif ($origine == "ecl_consult_fiche")
						{
							echo "<form action = \"ecl_consult_fiche.php\" METHOD = \"GET\">";
								echo "<input type = \"submit\" VALUE = \"Retour &agrave; la fiche sans enregistrer d'intervenants\">";
							echo "</form>";
						}
						else
						{
							echo "<form action = \"gestion_ecl.php\" METHOD = \"GET\">";
								echo "<input type = \"submit\" VALUE = \"Retour sans enregistrer d'intervenants\">";
								echo "<input type = \"hidden\" VALUE = \"$indice\" NAME = \"indice\">";
								echo "<input type = \"hidden\" VALUE = \"$rechercher\" NAME = \"rechercher\">";
							echo "</form>";
						}

						/*
						//Insertion des intervenants dans la table intervenant_ticket
						$nom = explode (";",strtoupper($intervenant));
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
								$ajout = "INSERT INTO intervenant_ticket VALUES ($no_ticket, $id, $nom1);";
								$maj = mysql_query ($ajout);
								//echo "$ajout<br />";
							}
						} // fin boucle for
						*/

	/*					/////////////////////////////////////////////////////////
						//Procédure pour envoyer les courriels aux intervenants//
						/////////////////////////////////////////////////////////

						//récupération des infos de l'emetteur
						$query_emetteur = "SELECT * FROM util where MAIL = '".$mail_emetteur."';";
						$results_emetteur = mysql_query($query_emetteur);
						$ligne=mysql_fetch_object($results_emetteur);
						$nom=$ligne->NOM;
						$prenom=$ligne->PRENOM;
						$sexe=$ligne->SEXE;
						//echo "<br />N° du ticket : $no_ticket";

						$sujet = "[GT"." N° ".$no_ticket." du ".$date_creation."] ".$sujet;
						$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";

						//Composition du message à envoyer
						$contenu_a_envoyer="- Ticket cr&eacute;&eacute; par ".$prenom." ".$nom;
						$contenu_a_envoyer=$contenu_a_envoyer."
- Intervenant(s) : $intervenant
- Contenu : ".$contenu;
						  $contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$no_ticket."
(il faut être connect&eacute;-e, les cookies de session ne sont pas g&eacute;r&eacute;s)";
              
            
						//envoi d'un message aux intervenants
						$pb_array = explode(';', $intervenant);
						$taille = count($pb_array);
						//echo "<br />nombre d'intervenants : $taille";
						for($j = 0; $j<$taille; ++$j)
						{
							//echo "<br />intervenant $j : $pb_array[$j]";
							$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
							$results_util = mysql_query($query_util);
							$ligne=mysql_fetch_object($results_util);
							$destinataire=$ligne->MAIL;

							$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
						}

						echo "<b>Un nouveau ticket a &eacute;t&eacute; ins&eacute;r&eacute;</b>";
						if ($origine == "gest_ticket")
						{
							echo "<br /><br /> <a href = \"gestion_ticket.php\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
						}
						elseif ($origine == "ecl_consult_fiche")
						{
							echo "<br /><br /> <a href = \"ecl_consult_fiche.php\" class = \"bouton\">Retour &agrave; la fiche</a>";
						}
						else
						{
							echo "<br /><br /> <a href = \"gestion_ecl.php?origine=verif_ticket&amp;rechercher=$rechercher&amp;indice=$indice\" class = \"bouton\">Retour</a>";
						}
	*/				} //fin else de l'enregistrement du probl&egrave;me

				} //fin if statut = "N" 

				//Cas d'une modification
				if($statut == "M")
				{
					//Récupération de la variable
					$idpb = $_POST['idpb'];
					//Test du champ récupéré
					if(!isset($idpb) || $idpb == "")
					{
						echo "<b>Probl&egrave;me non r&eacute;f&eacute;renc&eacute; dans la base de donn&eacute;e</b>";
						echo "<br /><br /> <a href = \"gestion_ticket.php\" class = \"bouton\">Retour &agrave; la gestion des tickets</a>";
						mysql_close();
						exit;
					}
					$query_modif = "UPDATE probleme SET
					NUM_ETABLISSEMENT = '".$etab."',
					NOM = '".$sujet."',
					TEXTE = '".$contenu."',
					DATE_MODIF = '".date('j/m/Y')."',
					INTERVENANT = '".strtoupper($intervenant)."',
					PRIORITE = '".$priorite."',
					DATE_CREATION = '".$date_creation."',
					CONTACT_TITRE = '".$contact_titre."',
					CONTACT_PRENOM = '".$contact_prenom."',
					CONTACT_NOM = '".$contact_nom."',
					CONTACT_MAIL = '".$contact_mail."',
					CONTACT_FONCTION = '".$contact_fonction."',
					CONTACT_TYPE = '".$contact_type."',
					date_demande = '".$date_demande_a_enregistrer."'
					WHERE ID_PB = '".$idpb."';";
					$results_modif = mysql_query($query_modif);
					if(!$results_modif)
					{
						echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
						switch ($origine)
						{
							case 'gestion_ticket':
								echo "<br /><br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'gestion_categories':
								echo "<br /><br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'fouille':
								echo "<br /><br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
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
					else
					{
						//On supprime d'abord les intervenants du tickets pour tenir compte de la liste modifiée ensuite
						//echo "<br />idpb : $idpb";

						//Ancienne procédure supprimée pour le traitement des intervenants par table de jointure intervenants_tickets
						/*

						$suppression_intervenants = "DELETE FROM intervenant_ticket WHERE id_tick = $idpb";
						$resultat_suppression_intervenants = mysql_query($suppression_intervenants);
						//echo "<br />resultat : $suppression_intervenants";
						//Insertion de nouveaux intervenants dans la table intervenant_ticket
						$nom = explode (";",strtoupper($intervenant));
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
								$ajout = "INSERT INTO intervenant_ticket VALUES ($idpb, $id, $nom1);";
								$maj = mysql_query ($ajout);
							}
						}

						*/
						echo "<b>Les donn&eacute;es du ticket ".$sujet." ont bien &eacute;t&eacute; modifi&eacute;es</b>";
						switch ($origine)
						{
							case 'gestion_ticket':
								echo "<br /><br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'gestion_categories':
								echo "<br /><br /><a href = ".$origine.".php?id_categ=$id_categ&amp;idpb=$idpb\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'fouille':
								echo "<br /><br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'repertoire_consult_fiche':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;

							case 'ecl_consult_fiche':
								echo "<br /><a href = ".$origine.".php><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></a>";
							break;
						}
					}
				}

				//Fermeture de la connexion à la BDD
				mysql_close();
			}
?>
		</div>
	</body>
</html>
