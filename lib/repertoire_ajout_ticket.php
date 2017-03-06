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
	echo "</head>";
	echo "<body>
		<div align = \"center\">";
			//Inclusion des fichiers nécessaires
			include("../biblio/init.php");
			include("../biblio/config.php");
			include("../biblio/fct.php");
			//Récupération des variables
			$origine_ajout = $_GET['origine_ajout'];

			//echo "<BR>origine : $origine";

			if ($origine_ajout == "repertoire") //j'arrive du fichier repertoire_gestion.php
			{
				$id_societe = $_GET['id_societe'];
				$priorite = "2";
				$statut = "N";
				//$methode_origine = "GET";
				$passage = "1"; //permet de supprimer le message qu'il manque des informations au premier passage dans le formulaire 
				/*
				echo "<BR>if ...";
				echo "<BR>id_societe : $id_societe";
				echo "<BR>origine_ajout : $origine_ajout";
				echo "<BR>origine_gestion : $origine_gestion";
				echo "<BR>rechercher : $rechercher";
				echo "<BR>priorite : $priorite";
				echo "<BR>statut : $statut";
				echo "<BR>indice : $indice";
				echo "<BR>tri : $tri";
				echo "<BR>filtre : $filtre";
				*/              
				//echo "<BR> : $";
				}
				else //j'arrive du même fichier et je vérifie si tout se passe bien
				{
					$origine_ajout = $_POST['origine_ajout'];
					$origine_gestion = $_POST['origine_gestion'];
					$indice = $_POST['indice'];
					$tri = $_POST['tri'];
					$sense_tri = $_POST['sense_tri'];
					$filtre = $_POST['filtre'];
					$rechercher = $_POST['rechercher'];
					$dans = $_POST['dans'];
					$date_creation = $_POST['date_creation'];
					$jour= $_POST['jour'];
					$mois = $_POST['mois'];
					$annee= $_POST['annee'];
					$id_societe = $_POST['id_societe'];
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
					$contact_type = $_POST['contact_type'];
					$fichier = $_POST['fichier'];
  
					 /*
					echo "<br>pas_projet : $pas_projet";
					echo "<BR>else ...";
					echo "<BR>id_societe : $id_societe";
					echo "<BR>origine_ajout : $origine_ajout";
					echo "<BR>origine_gestion : $origine_gestion";
					echo "<BR>rechercher : $rechercher";
					echo "<BR>priorite : $priorite";
					echo "<BR>statut : $statut";
					echo "<BR>indice : $indice";
					echo "<BR>tri : $tri";
					echo "<BR>filtre : $filtre";
					*/
				}
				$emetteur = $_SESSION['nom'];
				$mail_emetteur = $_SESSION['mail'];

				//echo "<br>date création 1 : $date_creation";
				//Pour le champ DATE_CREATION
				if ($date_creation == "")
				{
					$date_creation=date('j/m/Y');
				}
				//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui pour le nouveau champ de saisie de la date
				$aujourdhui_jour = date('d');
				$aujourdhui_mois = date('m');
				$aujourdhui_annee = date('Y');
				$date_creation_a_enregistrer = crevardate($jour,$mois,$annee); //nouvelle methode pour le champ date_crea	

				/*
				echo "<br>origine : $origine";
				echo "<br>indice : $indice";
				echo "<br>rechercher : $rechercher";
				echo "<br>etab : $etab";
				echo "<br>date création 2 : $date_creation";
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

				//Récupération des données en rapport avec la société'établissement
				$query_societe = "SELECT * FROM repertoire where No_societe = '".$id_societe."';";
				$results_societe_select = mysql_query($query_societe);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results_societe_select)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$num_results_societe_select = mysql_num_rows($results_societe_select);
				$res_societe = mysql_fetch_row($results_societe_select);
				//fin récupération de la société selectionnée
				
				//Récupération des établissements non selectionnés
				$query_non_societe_select = "SELECT * FROM repertoire where No_societe != '".$id_societe."';";
				$results_non_societe_select = mysql_query($query_non_societe_select);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results_non_societe_select)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$num_results_societe_non_select = mysql_num_rows($results_non_societe_select);
				$res_non_societe_select = mysql_fetch_row($results_non_societe_select);
				//fin de recup de toutes les sociétés non selectionnées
				
				//Récupération des données sur l'emetteur
				/*
				$query_emetteur = "SELECT * FROM individu WHERE MAIL = '".$mail_emetteur."' AND NOM = '".$emetteur."';";
				$result_emetteur = mysql_query($query_emetteur);
				if(!$result_emetteur)
				{
					echo "Problème de connexion à la base de données";
					exit;
				}
				$res_emetteur = mysql_fetch_row($result_emetteur);
				*/
				
				/*
				echo "<br>emetteur : $emetteur";
				echo "<br>mail_emetteur : $mail_emetteur";
				echo "<br>etab : $etab";
				echo "<br>sujet : $sujet";
				echo "<br>intervanant : $intervenant";
				echo "<br>contenu : $contenu";
				echo "<br>statut : $statut";
				*/
				
				if(!isset($emetteur) || !isset($mail_emetteur) || !isset($id_societe) ||
				!isset($sujet) || !isset($contenu) || !isset($statut) ||
				$emetteur == "" || $mail_emetteur == "" ||
				$sujet == "" || $contenu == "" || $statut == "" || $origine_ajout == "" || $contact_type == "")
				{
					mysql_close();
					if ($passage <> "1")
					{
						echo"<FONT COLOR = \"red\"><B>Informations manquantes!!</B></FONT><BR><BR><BR>";
					}
					$passage = "2"; // permet d'afficher le message ci-dessus en cas d'oubli de saisie d'informations
					echo "
						<FORM ACTION = \"repertoire_ajout_ticket.php\" METHOD = \"POST\">
						<TABLE BORDER = \"0\">
							<TR>
								<TD class = \"td-1\">
								</TD>
								<TD class = \"td-bouton\">
									<!--FONT COLOR = \"red\">Le nom de l'émetteur et le mail sont configurés par rapport à la personne connecté</FONT-->
								</TD>
							</TR>
							<TR>
								<TD class = \"td-1\">
									<INPUT TYPE = \"hidden\" VALUE = \"".$statut."\" NAME = \"statut\">
								</TD>
							</TR>
							<TR>
								<TD class = \"td-bouton\">
									Emetteur&nbsp;:&nbsp;
								</TD>
								<TD class = \"td-1\">
									<INPUT TYPE = \"hidden\" VALUE = \"".$emetteur."\" NAME = \"emetteur\">
									".$emetteur."
								</TD>
								
							</TR>
							<TR>
								<TD class = \"td-bouton\">
									Mél Emetteur&nbsp;:&nbsp;
								</TD>
								<TD class = \"td-1\">
									<INPUT TYPE = \"hidden\" VALUE =\"".$mail_emetteur."\" NAME = \"mail_emetteur\">
									".$mail_emetteur."
								</TD>
							</TR>
							
							<!--TR>
								<TD class = \"td-bouton\">Date création&nbsp;:&nbsp;</TD>
								<TD class = \"td-1\">
									<INPUT TYPE = \"text\" VALUE = \"".$date_creation."\" NAME = \"date_creation\" SIZE = \"10\">
								</TD>
							</TR-->

							<TR>
								<TD class = \"td-bouton\">Date création&nbsp;:&nbsp;</TD>
								<TD class = \"td-1\">
									<select size=\"1\" name=\"jour\">
										<option selected value=\"$aujourdhui_jour\">$aujourdhui_jour</option>
										<option value=\"1\">01</option>
										<option value=\"2\">02</option>
										<option value=\"3\">03</option>
										<option value=\"4\">04</option>
										<option value=\"5\">05</option>
										<option value=\"6\">06</option>
										<option value=\"7\">07</option>
										<option value=\"8\">08</option>
										<option value=\"9\">09</option>
										<option value=\"10\">10</option>
										<option value=\"11\">11</option>
										<option value=\"12\">12</option>
										<option value=\"13\">13</option>
										<option value=\"14\">14</option>
										<option value=\"15\">15</option>
										<option value=\"16\">16</option>
										<option value=\"17\">17</option>
										<option value=\"18\">18</option>
										<option value=\"19\">19</option>
										<option value=\"20\">20</option>
										<option value=\"21\">21</option>
										<option value=\"22\">22</option>
										<option value=\"23\">23</option>
										<option value=\"24\">24</option>
										<option value=\"25\">25</option>
										<option value=\"26\">26</option>
										<option value=\"27\">27</option>
										<option value=\"28\">28</option>
										<option value=\"29\">29</option>
										<option value=\"30\">30</option>
										<option value=\"31\">31</option>
									</select>
									<select size=\"1\" name=\"mois\">
										<option selected value=\"$aujourdhui_mois\">$aujourdhui_mois</option>
										<option value=\"1\">01</option>
										<option value=\"2\">02</option>
										<option value=\"3\">03</option>
										<option value=\"4\">04</option>
										<option value=\"5\">05</option>
										<option value=\"6\">06</option>
										<option value=\"7\">07</option>
										<option value=\"8\">08</option>
										<option value=\"9\">09</option>
										<option value=\"10\">10</option>
										<option value=\"11\">11</option>
										<option value=\"12\">12</option>
									</select>
									<select size=\"1\" name=\"annee\">
										<option selected value=\"$aujourdhui_annee\">$aujourdhui_annee</option>";
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
								echo "</TD>
							</TR>

							<TR>
								<TD class = \"td-bouton\">
									Société&nbsp;:&nbsp;
								</TD>
								<TD class = \"td-1\">
									<SELECT NAME = \"id_societe\">";
									for ($i=0; $i < $num_results_societe_non_select; ++$i)
									{
										echo "<OPTION VALUE = \"".$res_non_societe_select[0]."\">".$res_non_societe_select[0]." -- ".str_replace("*", " ",$res_non_societe_select[1])." - ".str_replace("*", " ",$res_non_societe_select[4])."</OPTION>";
										//echo "<OPTION VALUE=".$res_etab[0].">".$res_etab[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3]). " -- ".$res_etab[5]."</OPTION>";
										$res_non_societe_select = mysql_fetch_row($results_non_societe_select);
									}
									echo "<OPTION SELECTED = \"".$res_societe[0]."\" VALUE = \"".$res_societe[0]."\">".$res_societe[0]." -- ".str_replace("*", " ",$res_societe[1])." - ".str_replace("*", " ",$res_societe[4])."</OPTION>
									</SELECT>
								</TD>
							</TR>

							<TR>
								<TD class = \"td-bouton\">Contact&nbsp;:&nbsp;</TD>
								<TD class = \"td-bouton\">Titre&nbsp;:&nbsp;<select size= \"1\" name = \"contact_titre\">
									<option selected>$contact_titre</option>
										<option value=\"M\">M.</option>
										<option value=\"MME\">MME</option>
									</select>
									&nbsp;Prénom&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"$contact_prenom\" NAME = \"contact_prenom\" SIZE = \"32\">
									&nbsp;Nom&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"$contact_nom\" NAME = \"contact_nom\" SIZE = \"32\">
									<BR>&nbsp;Mél&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"$contact_mail\" NAME = \"contact_mail\" SIZE = \"50\">
									&nbsp;Fonction&nbsp;:&nbsp;<select size= \"1\" name = \"contact_fonction\">
									<option selected>$contact_fonction</option>
										<option value=\"directeur/directrice\">directeur/directrice</option>
										<option value=\"enseignant-e\">enseignant-e</option>
										<option value=\"IA-DSDEN\">IA-DSDEN</option>
										<option value=\"IA-IPR\">IA-IPR</option>
										<option value=\"IEN\">IEN</option>
										<option value=\"IEN-ET\">IEN-ET</option>
									<option value=\"personnel administratif\">personnel administratif</option>			        
										<option value=\"principal-e\">principal-e</option>
										<option value=\"principal-e adjoint-e\">principal-e adjoint-e</option>
										<option value=\"proviseur-e\">proviseur-e</option>
										<option value=\"proviseur-e adjoint-e\">proviseur-e adjoint-e</option>
									<option value=\"responsable site\">responsable site</option>
										<option value=\"webmestre\">webmestre</option>
										<option value=\"autre\">autre</option>
										</select>
								</TD>
							</TR>
							<TR>
								<TD class = \"td-bouton\">";
									if ($sujet == "")
									{
										echo "<FONT COLOR = \"red\">Sujet*&nbsp;:&nbsp;</FONT>";
									}
									else
									{
										echo "Sujet&nbsp;:&nbsp;";
									}
									echo "</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".$sujet."\" NAME = \"sujet\" SIZE = \"64\">
								</TD>
							</TR>
							<TR>
								<TD class = \"td-bouton\">";
									if ($contact_type == "")
									{
										echo "<FONT COLOR = \"red\">Type*&nbsp;:&nbsp;</FONT>";
									}
									else
									{
										echo "Type&nbsp;:&nbsp;";
									}
								echo "</TD>
								<TD class = \"td-1\">
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
											<OPTION = \"information\" VALUE = \"information\">information</OPTION>
									</SELECT>
								</TD>
							</TR>
							<TR>
								<TD class = \"td-bouton\">
									Priorité&nbsp;:&nbsp;
								</TD>

								<TD class = \"td-1\">
									<SELECT NAME = \"priorite\">
										<OPTION SELECTED = \"".$priorite."\" VALUE = \"".$priorite."\">".$priorite_selection."</OPTION>
											<OPTION = \"".$priorite_non_selection_ref_1."\" VALUE = \"".$priorite_non_selection_ref_1."\">".$priorite_non_selection_nom_1."</OPTION>
											<OPTION = \"".$priorite_non_selection_ref_2."\" VALUE = \"".$priorite_non_selection_ref_2."\">".$priorite_non_selection_nom_2."</OPTION>
									</SELECT>
								</TD>
							</TR>
							<TR>";
/*
							echo "<TD class = \"td-bouton\">";
								if ($intervenant == "")
								{
									echo "<FONT COLOR = \"red\">Intervenant*&nbsp;:&nbsp;</FONT>";
								}
								else
								{
									echo "Intervenant&nbsp;:&nbsp;";
								}
							echo "</TD>

							<TD class = \"td-1\">
								<INPUT TYPE = \"text\" VALUE =\"".$intervenant."\" NAME = \"intervenant\" SIZE = \"60\">&nbsp;(séparés par des ; aucun caractères accentués, ni d'espace)
							</TD>";
*/
						echo "</TR>
						<TR>
							<TD class = \"td-bouton\">";
								if ($contenu == "")
								{
									echo "<FONT COLOR = \"red\">Contenu*&nbsp;:&nbsp;</FONT>";
								}
								else
								{
									echo "Contenu&nbsp;:&nbsp;";
								}
							echo "</TD>
							<TD class = \"td-bouton\">
								<TEXTAREA ROWS = \"15\" COLS = \"120\" NAME = \"contenu\">".$contenu."</TEXTAREA>
							</TD>
						</TR>
						<TR>
							<TD class = \"td-1\">
							</TD>
							<TD class =\"td-bouton\">
							  <INPUT TYPE = \"hidden\" VALUE = \"$origine_ajout\" NAME = \"origine_ajout\">
								<INPUT TYPE = \"submit\" VALUE = \"Enregistrer le ticket\">
							</TD>
						</TR>
					</TABLE>
					<FONT COLOR = \"red\">*champs obligatoires
						<br />N.B. Les intervenant-e-s doivent &ecirc;tre saisi-e-s une fois le ticket cr&eacute;&eacute;, dans l'&eacute;cran de modification !
					</FONT>
					</FORM>";
				}
				else //Fin de test que tout est rempli qui permet d'enregistrer le ticket
				{	
					$sujet = str_replace("'", " ", $sujet);
					//la fonction nl2br remplace tout les symboles de retour chariot par des balises <BR>
					$contenu_modif = nl2br(str_replace("'"," ", $contenu));
					//Cas de l'ajout d'un problème
					if($statut == "N")
					{
						$id_util_session = $_SESSION['id_util'];
						//echo "<br />id_util : $id_util_session<br />";
						
						$query_insert = "INSERT INTO probleme (MAIL_INDIVIDU_EMETTEUR,NOM_INDIVIDU_EMETTEUR,
						NUM_ETABLISSEMENT,
						NOM, TEXTE, DATE_CREATION, INTERVENANT, STATUT, NB_MESS, PRIORITE, CONTACT_TITRE, CONTACT_PRENOM, CONTACT_NOM, CONTACT_MAIL, CONTACT_FONCTION, CONTACT_TYPE, MODULE,date_crea)
						VALUES ('".$mail_emetteur."', '".$emetteur."', '".$res_societe[0]."', '".$sujet."', '".$contenu_modif."'
						, '".$date_creation."','".strtoupper($intervenant)."', '".$statut."', '0', '".$priorite."', '".$contact_titre."', '".$contact_prenom."', '".$contact_nom."', '".$contact_mail."', '".$contact_fonction."', '".$contact_type."', 'REP','".$date_creation_a_enregistrer."');";
						//exit;
						$results_insert = mysql_query($query_insert);
						if(!$results_insert)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
							mysql_close();
							exit;
						}
						//On incremente le nombre des problèmes dans la base
						/*
						$query_update = "UPDATE repertoire SET nb_pb = nb_pb+1 WHERE No_societe ='".$res_societe[0]."'";
						$results_update = mysql_query($query_update);
						if(!$results_update)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
							mysql_close();
							exit;
						}
						*/
						//On insére les infos dans la table intervenant_ticket
						$no_dernier_id_genere = mysql_insert_id();
						//echo "<br />Dernier id g&eacute;n&eacute;r&eacute; : $no_dernier_id_genere";

						//On ajoute le cr&eacute;ateur comme intervenant
						
						//echo "<br />id : $id_util";
						
						$ajout = "INSERT INTO intervenant_ticket VALUES ($no_dernier_id_genere, $id_util_session, $id_util_session);";
						
						//echo "<br />requete : $ajout<br />";

						$maj = mysql_query($ajout);
						
						//récupération du N° du ticket
						$query_no = "SELECT * FROM probleme where MAIL_INDIVIDU_EMETTEUR = '".$mail_emetteur."' AND NOM = '".$sujet."' AND TEXTE = '".$contenu_modif."';";
						$results_no = mysql_query($query_no);
						$ligne=mysql_fetch_object($results_no);
						$no_ticket=$ligne->ID_PB;

						//récupération des infos de l'emetteur
						$query_emetteur = "SELECT * FROM util where MAIL = '".$mail_emetteur."';";
						$results_emetteur = mysql_query($query_emetteur);
						$ligne=mysql_fetch_object($results_emetteur);
							$nom=$ligne->NOM;
							$prenom=$ligne->PRENOM;
							$sexe=$ligne->SEXE;
							
							//echo "<BR>N° du ticket : $no_ticket";
							
							$sujet = "[REP"." N° ".$no_ticket." du ".$date_creation."] ".$sujet;
							$entete="From: collaboratice\r\nReply-To: jurgen.mendel@ac-orleans-tours.fr\r\nX-Mailer: PHP/";
							
						//Composition du message à envoyer
						$contenu_a_envoyer="- Ticket créé par ".$prenom." ".$nom;
						$contenu_a_envoyer=$contenu_a_envoyer."
- Intervenant(s) : $intervenant
- Contenu :
".$contenu;
						$contenu_a_envoyer=$contenu_a_envoyer."
 
- raccourci : ".$dossier_lib_adresse_absolu."consult_ticket.php?idpb=";
              $contenu_a_envoyer=$contenu_a_envoyer.$no_ticket."
(il faut être connecté-e, les cookies de session ne sont pas gérés)";

						//envoi d'un message aux intervenants
						$pb_array = explode(';', $intervenant);
						$taille = count($pb_array);
						//echo "<BR>nombre d'intervenants : $taille";
						for($j = 0; $j<$taille; ++$j)
						{
							//echo "<BR>intervenant $j : $pb_array[$j]";
							$query_util = "SELECT * FROM util where NOM = '".$pb_array[$j]."';";
							$results_util = mysql_query($query_util);
							$ligne=mysql_fetch_object($results_util);
							$destinataire=$ligne->MAIL;
							$ok=mail($destinataire, $sujet, $contenu_a_envoyer, $entete);
						}

						echo "<b>Un nouveau ticket a &eacute;t&eacute; ins&eacute;r&eacute;</b>";
						echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour au répertoire</A>";

					}

					//Cas d'une modification
					if($statut == "M")
					{
						//Récupération de la variable
						$idpb = $_POST['idpb'];
						//Test du champ récupéré
						if(!isset($idpb) || $idpb == "")
						{
							echo "<b>Probl&egrave;me non r&eacute;f&eacute;renc&eacute; dans la base de donn&eacute;e</b>";
							echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour à la gestion des tickets</A>";
							mysql_close();
							exit;
						}
						$query_modif = "UPDATE probleme SET
							NUM_ETABLISSEMENT = '".$id_societe."',
							NOM = '".$sujet."',
							TEXTE = '".$contenu."',
							DATE_MODIF = '".date('j/m/Y')."',
							INTERVENANT = '".strtoupper($intervenant)."',
							STATUT = '".$statut."',
							PRIORITE = '".$priorite."',
							DATE_CREATION = '".$date_creation."',
							CONTACT_TITRE = '".$contact_titre."',
							CONTACT_PRENOM = '".$contact_prenom."',
							CONTACT_NOM = '".$contact_nom."',
							CONTACT_MAIL = '".$contact_mail."',
							CONTACT_FONCTION = '".$contact_fonction."',
							CONTACT_TYPE = '".$contact_type."'
						WHERE ID_PB = '".$idpb."';";
						$results_modif = mysql_query($query_modif);
						if(!$results_modif)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour au répertoire</A>";
							mysql_close();
							exit;
						}
						else
						{
							echo "<b>Les données du ticket ".$sujet." ont bien &eacute;t&eacute; modifi&eacute;es</b>";
							echo "<BR><BR> <A HREF = \"repertoire_gestion.php\" class = \"bouton\">Retour au répertoire</A>";
						}
					}

					//Fermeture de la connexion à la BDD
					mysql_close();
				}
			?>
		</div>
	</BODY>
</HTML>
