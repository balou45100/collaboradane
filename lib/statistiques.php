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
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
	echo "</head>";

	echo "<body>
		<div align = \"center\">";
			echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_statistiques.png\" ALT = \"Titre\">";
			include("../biblio/fct.php");
			include ("../biblio/config.php");
			include("../biblio/init.php");

	//Vérification des droits pour pouvoir afficher les détails
	$droit_detail = verif_droits("statistiques_detail");
	
	echo "<h1>Statistiques d'utilisation</h1>";
	if ($droit_detail == 3)
	{
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td align = \"center\">";
						echo "<a href=\"statistiques_detail.php\" target=\"body\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/statistiques.png\" title = \"G&eacute;rer les cat&eacute;gories\" align=\"top\" border=\"0\"></a>";
						echo "<br />&nbsp;D&eacute;tails&nbsp;";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
	}

?>
	</head>
	<body>
		<CENTER>
<?php
			//echo "<h2>Statistiques d'utilisation</h2>";

						/////////////////////////////////////
						//Definition des pages personnelles//
						/////////////////////////////////////

						//$page = $_GET['page'];

						/*echo"<CENTER><A HREF = \"statistiques.php?page=1\" target = \"body\" class=\"bouton\">1</A>&nbsp;
							<A HREF = \"statistiques.php?page=2\" target = \"body\" class=\"bouton\">2</A>&nbsp;
						</CENTER>"; */

						//if($page == 1)
						//{
						/////////////////////////////////////////////////////////
						
						//Liste des différentes requètes utilisés partie global//
						/////////////////////////////////////////////////////////

						//////////////////////////////////////////////
						//Recupération des données de l'utilisateur//
						//////////////////////////////////////////////
						
						$query_individu = "SELECT * FROM util WHERE NOM = '".$_SESSION['nom']."' AND ID_UTIL = '".$_SESSION['id_util']."';";
						$results_individu = mysql_query($query_individu);
						if(!$results_individu)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						
						$ligne=mysql_fetch_object($results_individu);
						
						$nom=$ligne->NOM;
						$prenom=$ligne->PRENOM;
						$sexe=$ligne->SEXE;

						
						/////////////////////////////
						//Nombre de messages postés//
						/////////////////////////////
				
						$query_tot_ticket = "SELECT * FROM probleme;";
									$results_tot_ticket = mysql_query($query_tot_ticket);
						if(!$results_tot_ticket)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_tot_ticket = mysql_num_rows($results_tot_ticket);

						///////////////////////////////
						//Nombre de messages nouveaux//
						///////////////////////////////

						$query_tot_tickets_nouveaux = "SELECT * FROM probleme WHERE STATUT = 'N' OR STATUT = 'M';";
						$results_tot_tickets_nouveaux = mysql_query($query_tot_tickets_nouveaux);
						if(!$results_tot_tickets_nouveaux)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_tot_tickets_nouveaux = mysql_num_rows($results_tot_tickets_nouveaux);

						///////////////////////////////
						//Nombre de messages modifiés//
						///////////////////////////////

						$query_tot_tickets_mod = "SELECT * FROM probleme WHERE STATUT = 'M';";
						$results_tot_tickets_mod = mysql_query($query_tot_tickets_mod);
						if(!$results_tot_tickets_mod)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_tot_tickets_mod = mysql_num_rows($results_tot_tickets_mod);

						//////////////////////////////
						//Nombre de réponses postées//
						//////////////////////////////

						$query_tot_tickets_rep = "SELECT * FROM probleme WHERE STATUT = 'R';";
						$results_tot_tickets_rep = mysql_query($query_tot_tickets_rep);
						if(!$results_tot_tickets_rep)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_tot_tickets_rep = mysql_num_rows($results_tot_tickets_rep);

						/////////////////////////////
						//Nombre de Ticket archivés//
						/////////////////////////////

						$query_tot_tickets_ar = "SELECT * FROM probleme WHERE STATUT = 'A';";
						$results_tot_tickets_ar = mysql_query($query_tot_tickets_ar);
						if(!$results_tot_tickets_ar)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_tot_tickets_ar = mysql_num_rows($results_tot_tickets_ar);

/*
						//////////////////////////////////////////////////
						//Nombre d'établissement dans la base de données//
						//////////////////////////////////////////////////

						$query_tot_etab = "SELECT * FROM etablissements;";
						$results_tot_etab = mysql_query($query_tot_etab);
						if(!$results_tot_etab)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab = mysql_num_rows($results_tot_etab);

						/////////////////////////////////////////
						//Nombre d'établissement du Loir & Cher//
						/////////////////////////////////////////

						$query_tot_etab_loir_et_cher = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '41%';";
						$results_tot_etab_loir_et_cher = mysql_query($query_tot_etab_loir_et_cher);
						if(!$results_tot_etab_loir_et_cher)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_loir_et_cher = mysql_num_rows($results_tot_etab_loir_et_cher);

						/////////////////////////////////////
						//Nombre d'établissement de l'Indre//
						/////////////////////////////////////

						$query_tot_etab_indre = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '36%';";
						$results_tot_etab_indre = mysql_query($query_tot_etab_indre);
						if(!$results_tot_etab_indre)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_indre = mysql_num_rows($results_tot_etab_indre);

						//////////////////////////////////
						//Nombre d'établissement du Cher//
						//////////////////////////////////

						$query_tot_etab_cher = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '18%';";
						$results_tot_etab_cher = mysql_query($query_tot_etab_cher);
						if(!$results_tot_etab_cher)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_cher = mysql_num_rows($results_tot_etab_cher);

						////////////////////////////////////
						//Nombre d'établissement du Loiret//
						////////////////////////////////////

						$query_tot_etab_loiret = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '45%';";
						$results_tot_etab_loiret = mysql_query($query_tot_etab_loiret);
						if(!$results_tot_etab_loiret)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_loiret = mysql_num_rows($results_tot_etab_loiret);

						/////////////////////////////////////////////
						//Nombre d'établissement de l'Indre & Loire//
						/////////////////////////////////////////////

						$query_tot_etab_indre_et_loire = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '37%';";
						$results_tot_etab_indre_et_loire = mysql_query($query_tot_etab_indre_et_loire);
						if(!$results_tot_etab_indre_et_loire)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_indre_et_loire = mysql_num_rows($results_tot_etab_indre_et_loire);

						///////////////////////////////////////////
						//Nombre d'établissement de l'Eure & Loir//
						///////////////////////////////////////////

						$query_tot_etab_eure_et_loir = "SELECT * FROM etablissements WHERE CODE_POSTAL LIKE '28%';";
						$results_tot_etab_eure_et_loir = mysql_query($query_tot_etab_eure_et_loir);
						if(!$results_tot_etab_eure_et_loir)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_etab_eure_et_loir = mysql_num_rows($results_tot_etab_eure_et_loir);
*/
						////////////////////////////////////////////////
						//Nombre d'utilisateur dans la base de données//
						////////////////////////////////////////////////

						$query_tot_util = "SELECT * FROM util WHERE visible ='O';";
						$results_tot_util = mysql_query($query_tot_util);
						if(!$results_tot_util)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$num_results_tot_util = mysql_num_rows($results_tot_util);

/*
						//////////////////////////////////////////////////
						//Etablissement(s) ayant eu le plus de problèmes//
						//////////////////////////////////////////////////
						$query_max_pb_etab = "SELECT MAX(NB_PB) FROM etablissements";
						$results_max_pb_etab = mysql_query($query_max_pb_etab);
						if(!$results_max_pb_etab)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$res_max_pb_etab = mysql_fetch_row($results_max_pb_etab);
						$query_max_pb = "SELECT * FROM etablissements WHERE NB_PB='".$res_max_pb_etab[0]."';";
						$results_max_pb = mysql_query($query_max_pb);
						if(!$results_max_pb)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_max_pb = mysql_num_rows($results_max_pb);
					
						//////////////////////////////////////////////////////
						//Fin établissement(s) ayant eu le plus de problèmes//
						//////////////////////////////////////////////////////

						////////////////////////////////////////////
						//Message(s) ayant eu le plus de réponses//
						////////////////////////////////////////////

						$query_pb = "SELECT * FROM probleme WHERE STATUT != 'R';";
						$results_pb = mysql_query($query_pb);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results_pb)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						//Retourne le nombre de ligne rendu par la requète
						$num_results = mysql_num_rows($results_pb);
						$res_pb = mysql_fetch_row($results_pb);

				
						$max_nb_rep = 0;
						$j = 0;
						$tab_egal_rep[$j] = 0;
						for($i=0; $i<$num_results; ++$i)
						{
					$query_nb_rep = "SELECT COUNT(*) FROM probleme WHERE STATUT = 'R' AND ID_PB_PERE = '".$res_pb[0]."';";
					$results_nb_rep = mysql_query($query_nb_rep);
					//Dans le cas où aucun résultats n'est retourné
					if(!$results_nb_rep)
					{
						echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
						echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
						mysql_close();
						exit;
					}
					//$res = mysql_fetch_row($results);
					$nb_rep = mysql_fetch_row($results_nb_rep);
					//echo $max_nb_rep;
					if($max_nb_rep < $nb_rep[0])
					{
						$max_nb_rep = $nb_rep[0];
						$tab_sup_rep[0] = $res_pb[0];
						$tab_egal_rep[0] = 0;
					}
					if($max_nb_rep > $nb_rep[0]){}
					if($max_nb_rep == $nb_rep[0])
					{
						//Si la première case du tableau est vide
						//Re-initialisation de la variable pour parcourir le tableau à 0
						//Affectation du num RNE lu dans la table
						//Incrémentation de la variable
						if($tab_egal_rep[0] == 0)
						{
							$j=0;
							$tab_egal_rep[$j] = $res_pb[0];
							++$j;
						}
						//Affectation du num RNE lu dans la table
						//Incrémentation de la variable
						else
						{
							$tab_egal_rep[$j] = $res_pb[0];
							++$j;
						}
					}
					$res_pb = mysql_fetch_row($results_pb);
						}
						////////////////////////////////////////////////
						//Fin message(s) ayant eu le plus de réponses//
						////////////////////////////////////////////////
*/
						///////////////:///////////////
						//Nombre total de catégories //
						///////////////////////////////

						$query_nb_categ_global = "SELECT * FROM `categorie`;";
						
						$results_nb_categ_global = mysql_query($query_nb_categ_global);
						if(!$results_nb_categ_global)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_categ_global = mysql_num_rows($results_nb_categ_global);

						/////////////////////////////////////////
						//Fin nombre de catégories globalement //
						/////////////////////////////////////////
						
						
						///////////////:////////////////////////////////
						//Nombre total d'acces aux différents modules //
						////////////////////////////////////////////////

						$num_results_nb_tous_modules_global = extraction_statistiques_modules("T","T","T");
						$num_results_nb_ABO_global = extraction_statistiques_modules("ABO","T","T");
						$num_results_nb_ACC_global = extraction_statistiques_modules("ACC","T","T");
						$num_results_nb_ALE_global = extraction_statistiques_modules("ALE","T","T");
						$num_results_nb_CAT_global = extraction_statistiques_modules("CAT","T","T");
						$num_results_nb_CON_global = extraction_statistiques_modules("CON","T","T");
						$num_results_nb_CONF_global = extraction_statistiques_modules("CONF","T","T");
						$num_results_nb_COP_global = extraction_statistiques_modules("COP","T","T");
						$num_results_nb_COU_global = extraction_statistiques_modules("COU","T","T");
						$num_results_nb_CRE_global = extraction_statistiques_modules("CRE","T","T");
						$num_results_nb_DEV_global = extraction_statistiques_modules("DEV","T","T");
						$num_results_nb_DOS_global = extraction_statistiques_modules("DOS","T","T");
						$num_results_nb_ECL_global = extraction_statistiques_modules("ECL","T","T");
						$num_results_nb_FAV_global = extraction_statistiques_modules("FAV","T","T");
						$num_results_nb_FGM_global = extraction_statistiques_modules("FGM","T","T");
						$num_results_nb_FORM_global = extraction_statistiques_modules("FORM","T","T");
						$num_results_nb_GMA_global = extraction_statistiques_modules("GMA","T","T");
						$num_results_nb_GOM_global = extraction_statistiques_modules("GOM","T","T");
						$num_results_nb_GRO_global = extraction_statistiques_modules("GRO","T","T");
						$num_results_nb_GTI_global = extraction_statistiques_modules("GTI","T","T");
						$num_results_nb_GUS_global = extraction_statistiques_modules("GUS","T","T");
						$num_results_nb_INF_global = extraction_statistiques_modules("INF","T","T");
						$num_results_nb_PUB_global = extraction_statistiques_modules("PUB","T","T");
						$num_results_nb_REC_global = extraction_statistiques_modules("REC","T","T");
						$num_results_nb_REG_global = extraction_statistiques_modules("REG","T","T");
						$num_results_nb_REP_global = extraction_statistiques_modules("REP","T","T");
						$num_results_nb_RES_global = extraction_statistiques_modules("RES","T","T");
						$num_results_nb_RTI_global = extraction_statistiques_modules("RTI","T","T");
						$num_results_nb_STA_global = extraction_statistiques_modules("STA","T","T");
						$num_results_nb_TAC_global = extraction_statistiques_modules("TAC","T","T");
						$num_results_nb_TBAL_global = extraction_statistiques_modules("TBAL","T","T");
						$num_results_nb_TBGA_global = extraction_statistiques_modules("TBGA","T","T");
						$num_results_nb_TBO_global = extraction_statistiques_modules("TBO","T","T");
						$num_results_nb_TBPR_global = extraction_statistiques_modules("TBPR","T","T");
						$num_results_nb_TBTI_global = extraction_statistiques_modules("TBTI","T","T");
						$num_results_nb_WRA_global = extraction_statistiques_modules("WRA","T","T");

						/////////////////////////////////////////////////////////
						//Fin zone de toutes les requètes utilisé partie global//
						/////////////////////////////////////////////////////////

						////////////////////////////////////////////////////////////
						//Liste des différentes requètes utilisés partie personnel//
						////////////////////////////////////////////////////////////

						/////////////////////////////
						//Nombre de messages postés//
						/////////////////////////////

						$query_nb_mess_perso = "SELECT * FROM probleme WHERE NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."';";
						$results_nb_mess_perso = mysql_query($query_nb_mess_perso);
						if(!$results_nb_mess_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}

						$res_nb_mess_perso = mysql_num_rows($results_nb_mess_perso);

						///////////////////////////////
						//Nombre de messages en cours//
						///////////////////////////////

						$query_nb_mess_nouv_perso = "SELECT * FROM probleme WHERE STATUT = 'N' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'M' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."';";
						$results_nb_mess_nouv_perso = mysql_query($query_nb_mess_nouv_perso);
						if(!$results_nb_mess_nouv_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_mess_nouv_perso = mysql_num_rows($results_nb_mess_nouv_perso);

						///////////////////////////////
						//Nombre de messages modifiés//
						///////////////////////////////

						$query_nb_mess_mod_perso = "SELECT * FROM probleme WHERE STATUT = 'M' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."';";
						$results_nb_mess_mod_perso = mysql_query($query_nb_mess_mod_perso);
						if(!$results_nb_mess_mod_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_mess_mod_perso = mysql_num_rows($results_nb_mess_mod_perso);

						///////////////////////////////
						//Nombre de messages archivés//
						///////////////////////////////

						$query_nb_mess_arch_perso = "SELECT * FROM probleme WHERE STATUT = 'A' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."';";
						$results_nb_mess_arch_perso = mysql_query($query_nb_mess_arch_perso);
						if(!$results_nb_mess_arch_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_mess_arch_perso = mysql_num_rows($results_nb_mess_arch_perso);

						///////////////////////////////
						//Nombre de messages réponses//
						///////////////////////////////

						$query_nb_mess_rep_perso = "SELECT * FROM probleme WHERE STATUT = 'R' AND NOM_INDIVIDU_EMETTEUR = '".$_SESSION['nom']."';";
						$results_nb_mess_rep_perso = mysql_query($query_nb_mess_rep_perso);
						if(!$results_nb_mess_rep_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_mess_rep_perso = mysql_num_rows($results_nb_mess_rep_perso);


						//////////////////////////////
						//Nombre de catégories perso//
						//////////////////////////////

						$query_nb_categ_perso = "SELECT * FROM categorie WHERE NOM_UTIL = '".$_SESSION['nom']."';";
						$results_nb_categ_perso = mysql_query($query_nb_categ_perso);
						if(!$results_nb_categ_perso)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><A HREF = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour à l'accueil</A>";
							mysql_close();
							exit;
						}
						$num_results_nb_categ_perso = mysql_num_rows($results_nb_categ_perso);

						///////////////////////////////////////////////
						//Nombre d'accès perso aux différents modules//
						///////////////////////////////////////////////

						$num_results_nb_ABO_perso = extraction_statistiques_modules("ABO",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_ACC_perso = extraction_statistiques_modules("ACC",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_ALE_perso = extraction_statistiques_modules("ALE",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_CAT_perso = extraction_statistiques_modules("CAT",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_CON_perso = extraction_statistiques_modules("CON",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_CONF_perso = extraction_statistiques_modules("CONF",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_COP_perso = extraction_statistiques_modules("COP",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_COU_perso = extraction_statistiques_modules("COU",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_CRE_perso = extraction_statistiques_modules("CRE",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_DEV_perso = extraction_statistiques_modules("DEV",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_DOS_perso = extraction_statistiques_modules("DOS",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_ECL_perso = extraction_statistiques_modules("ECL",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_FAV_perso = extraction_statistiques_modules("FAV",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_FGM_perso = extraction_statistiques_modules("FGM",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_FORM_perso = extraction_statistiques_modules("FORM",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_GMA_perso = extraction_statistiques_modules("GMA",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_GOM_perso = extraction_statistiques_modules("GOM",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_GRO_perso = extraction_statistiques_modules("GRO",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_GTI_perso = extraction_statistiques_modules("GTI",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_GUS_perso = extraction_statistiques_modules("GUS",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_INF_perso = extraction_statistiques_modules("INF",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_PUB_perso = extraction_statistiques_modules("PUB",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_REC_perso = extraction_statistiques_modules("REC",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_REG_perso = extraction_statistiques_modules("REG",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_REP_perso = extraction_statistiques_modules("REP",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_RES_perso = extraction_statistiques_modules("RES",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_RTI_perso = extraction_statistiques_modules("RTI",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_STA_perso = extraction_statistiques_modules("STA",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TAC_perso = extraction_statistiques_modules("TAC",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TBAL_perso = extraction_statistiques_modules("TBAL",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TBGA_perso = extraction_statistiques_modules("TBGA",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TBO_perso = extraction_statistiques_modules("TBO",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TBPR_perso = extraction_statistiques_modules("TBPR",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_TBTI_perso = extraction_statistiques_modules("TBTI",$_SESSION['nom'],$_SESSION['id_util']);
						$num_results_nb_WRA_perso = extraction_statistiques_modules("WRA",$_SESSION['nom'],$_SESSION['id_util']);

						////////////////////////////////////////////////////////////
						//Fin zone de toutes les requètes utilisé partie personnel//
						////////////////////////////////////////////////////////////

						//Partie sur les informations globales
						echo "<TABLE>";
							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre total d'utilisateurs&nbsp;:&nbsp;";
								echo "</TD>";
								echo "<TD align = \"center\">";
									  echo $num_results_tot_util;
								echo "</TD>";
							echo "</TR>";
////////////////////////////////////////////////////////////////////////////////  
							echo "<TR>";
								echo "<TD>";
									  echo "<b>Nombre d'accès aux modules</b>";
								echo "</TD>";
								echo "<TD colspan=\"2\" align = \"center\"><b>global</b></TD>";
								//echo "<TD></TD>";
								echo "<TD colspan=\"2\">";
									if ($sexe == "F")
									{
										echo "<b>Pour l'utilisatrice ".$prenom."&nbsp;".$nom."</b>";
									}
									else
									{
										echo "<b>Pour l'utilisateur ".$prenom."&nbsp;".$nom."</b>";
									}
								echo "</TD>";
							echo "</TR>";
							affiche_statistiques_modules("Abonnements",$num_results_nb_tous_modules_global,$num_results_nb_ABO_global,$num_results_nb_ABO_perso);
							//affiche_statistiques_modules("Accueil (jusqu'au 6/7/09)",$num_results_nb_tous_modules_global,$num_results_nb_ACC_global,$num_results_nb_ACC_perso);
							affiche_statistiques_modules("Catégories",$num_results_nb_tous_modules_global,$num_results_nb_CAT_global,$num_results_nb_CAT_perso);
							affiche_statistiques_modules("Contacts des soci&eacute;t&eacute;s",$num_results_nb_tous_modules_global,$num_results_nb_CON_global,$num_results_nb_CON_perso);
							affiche_statistiques_modules("Contacts priv&eacute;s",$num_results_nb_tous_modules_global,$num_results_nb_COP_global,$num_results_nb_COP_perso);
							affiche_statistiques_modules("Courrier",$num_results_nb_tous_modules_global,$num_results_nb_COU_global,$num_results_nb_COU_perso);
							affiche_statistiques_modules("Cr&eacute;dits",$num_results_nb_tous_modules_global,$num_results_nb_CRE_global,$num_results_nb_CRE_perso);
							affiche_statistiques_modules("D&eacute;veloppement collaboratice",$num_results_nb_tous_modules_global,$num_results_nb_DEV_global,$num_results_nb_DEV_perso);
							affiche_statistiques_modules("Dossiers",$num_results_nb_tous_modules_global,$num_results_nb_DOS_global,$num_results_nb_DOS_perso);
							affiche_statistiques_modules("ECL (&eacute;coles, coll&egrave;ges, lyc&eacute;es)",$num_results_nb_tous_modules_global,$num_results_nb_ECL_global,$num_results_nb_ECL_perso);
							affiche_statistiques_modules("Favoris",$num_results_nb_tous_modules_global,$num_results_nb_FAV_global,$num_results_nb_FAV_perso);
							affiche_statistiques_modules("Festival",$num_results_nb_tous_modules_global,$num_results_nb_FGM_global,$num_results_nb_FGM_perso);
							affiche_statistiques_modules("Formations",$num_results_nb_tous_modules_global,$num_results_nb_FORM_global,$num_results_nb_FORM_perso);
							affiche_statistiques_modules("Gestion groupes",$num_results_nb_tous_modules_global,$num_results_nb_GRO_global,$num_results_nb_GRO_perso);
							affiche_statistiques_modules("Gestion mat&eacute;riels",$num_results_nb_tous_modules_global,$num_results_nb_GMA_global,$num_results_nb_GMA_perso);
							affiche_statistiques_modules("Gestion ordres de mission",$num_results_nb_tous_modules_global,$num_results_nb_GOM_global,$num_results_nb_GOM_perso);
							affiche_statistiques_modules("Gestion tickets",$num_results_nb_tous_modules_global,$num_results_nb_GTI_global,$num_results_nb_GTI_perso);
							affiche_statistiques_modules("Gestion utilisateurs",$num_results_nb_tous_modules_global,$num_results_nb_GUS_global,$num_results_nb_GUS_perso);
							affiche_statistiques_modules("Informations Collaboratice",$num_results_nb_tous_modules_global,$num_results_nb_INF_global,$num_results_nb_INF_perso);
							affiche_statistiques_modules("Recherche",$num_results_nb_tous_modules_global,$num_results_nb_REC_global,$num_results_nb_REC_perso);
							affiche_statistiques_modules("R&eacute;glages",$num_results_nb_tous_modules_global,$num_results_nb_REG_global,$num_results_nb_REG_perso);
							affiche_statistiques_modules("R&eacute;pertoire des soci&eacute;t&eacute;s",$num_results_nb_tous_modules_global,$num_results_nb_REP_global,$num_results_nb_REP_perso);
							affiche_statistiques_modules("Personnes ressources TICE",$num_results_nb_tous_modules_global,$num_results_nb_RES_global,$num_results_nb_RES_perso);
							affiche_statistiques_modules("Rencontres TICE",$num_results_nb_tous_modules_global,$num_results_nb_RTI_global,$num_results_nb_RTI_perso);
							affiche_statistiques_modules("Statistiques",$num_results_nb_tous_modules_global,$num_results_nb_STA_global,$num_results_nb_STA_perso);
							affiche_statistiques_modules("T&acirc;ches",$num_results_nb_tous_modules_global,$num_results_nb_TAC_global,$num_results_nb_TAC_perso);
							affiche_statistiques_modules("TB Alertes",$num_results_nb_tous_modules_global,$num_results_nb_TBAL_global,$num_results_nb_TBAL_perso);
							affiche_statistiques_modules("TB Garanties",$num_results_nb_tous_modules_global,$num_results_nb_TBGA_global,$num_results_nb_TBGA_perso);
							affiche_statistiques_modules("Tableau de bord (depuis le 6/7/09)",$num_results_nb_tous_modules_global,$num_results_nb_TBO_global,$num_results_nb_TBO_perso);
							affiche_statistiques_modules("TB Pr&ecirc;ts",$num_results_nb_tous_modules_global,$num_results_nb_TBPR_global,$num_results_nb_TBPR_perso);
							affiche_statistiques_modules("TB Tickets",$num_results_nb_tous_modules_global,$num_results_nb_TBTI_global,$num_results_nb_TBTI_perso);
							affiche_statistiques_modules("Webradio",$num_results_nb_tous_modules_global,$num_results_nb_WRA_global,$num_results_nb_WRA_perso);
							affiche_statistiques_modules("Configuration du syst&egrave;me",$num_results_nb_tous_modules_global,$num_results_nb_CONF_global,$num_results_nb_CONF_perso);
////////////////////////////////////////////////////////////////////////////////  
							echo "<TR>";
								echo "<TD colspan=\"5\">";
									  echo "<b>D&eacute;tail gestion tickets</b>";
								echo "</TD>";
							echo "</TR>";

							affiche_statistiques_modules("Nombre de tickets en cours",0,$num_results_tot_tickets_nouveaux,$num_results_nb_mess_nouv_perso);
							affiche_statistiques_modules("Nombre de tickets archivés",0,$num_results_tot_tickets_ar,$num_results_nb_mess_arch_perso);
							affiche_statistiques_modules("Nombre de réponses",0,$num_results_tot_tickets_rep,$num_results_nb_mess_rep_perso);
							affiche_statistiques_modules("Nombre total de tickets postés",0,$num_results_tot_ticket,$res_nb_mess_perso);

							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre de réponses par ticket&nbsp;:&nbsp;";
								echo "</TD>";
								echo "<TD align = \"center\">";
									$reponses_par_ticket=number_format($num_results_tot_tickets_rep/($num_results_tot_tickets_nouveaux+$num_results_tot_tickets_ar),2);
									echo $reponses_par_ticket;
								echo "</TD>";
								echo "<TD>&nbsp;</TD>";
								echo "<TD align = \"center\">";
								if ($num_results_nb_mess_nouv_perso+$num_results_nb_mess_arch_perso>0)
								{
									$reponses_par_ticket_perso=number_format($num_results_nb_mess_rep_perso/($num_results_nb_mess_nouv_perso+$num_results_nb_mess_arch_perso),2);
									echo $reponses_par_ticket_perso;
								}
								else
								{
									echo "&nbsp;";
								}

								echo "</TD>";
								//echo "<TD>";
									  //$pourcentage=number_format(($num_results_nb_mess_rep_perso * 100)/ $num_results_tot_tickets_rep,1);
									  //echo "$pourcentage%";
								//echo "</TD>";
							echo "</TR>";

							affiche_statistiques_modules("Nombre total de catégories",0,$num_results_nb_categ_global,$num_results_nb_categ_perso);
										
////////////////////////////////////////////////////////////////////////////////  
							echo "<TR>";
								echo "<TD colspan = \"5\">";
									  echo "<b>Nombre d'accès à certaines fonctions</b>";
								echo "</TD>";
							echo "</TR>";
							

							affiche_statistiques_modules("Alertes",$num_results_nb_tous_modules_global,$num_results_nb_ALE_global,$num_results_nb_ALE_perso);
							affiche_statistiques_modules("Publi-postage",$num_results_nb_tous_modules_global,$num_results_nb_PUB_global,$num_results_nb_PUB_perso);
//////////////////////////////////////////////////////////////////////////////////						 
/*
							echo "<TR>";
								echo "<TD>";
									  echo "Autres";
								echo "</TD>";
							echo "</TR>";

							echo "<TR>";
								echo "<TD class =\"cher\">";
									  echo "Etablissement/&Eacute;cole ayant eu le plus de tickets";
								echo "</TD>";
								echo "<TD align = \"center\">";
									  echo $res_max_pb_etab[0];
									  if($res_max_pb_etab[0] == 0)
									  {
											echo "</TR>";
											echo "<TR>";
												echo "<TD align = \"center\">";
													  echo "Aucun";
												echo "</TD>";
										}
										else
										{
											for($i=0;$i<$num_results_max_pb;++$i)
											{
														$res_max_pb_etab = mysql_fetch_row($results_max_pb);
														echo "<TR>";
															 echo "<TD>";
																	echo strtoupper(str_replace("*", " ",$res_max_pb_etab[1]))." ".strtoupper(str_replace("*", " ",$res_max_pb_etab[3]));
															 echo "</TD>";
													  echo "</TR>";
												 }
											}
							echo "</TR>";
							  
							echo "<TR>";
								echo "<TD class =\"cher\">";
							echo "Message(s) ayant eu le plus de réponses";
								echo "</TD>";
								echo "<TD align = \"center\">";
									  echo $max_nb_rep;
								echo "</TD>";
								//Compte la taille du tableau
								$taille = count($tab_egal_rep);
								//Parcour du tableau pour afficher les informations concernant les établissements ayant eu des problèmes
								if($max_nb_rep == "0")
								{
									  echo "<TR>";
											 echo "<TD>";
													echo "Aucun";
											 echo "</TD>";
								}
								else
								{
									 for($k = 0; $k<$taille; ++$k)
									 {
										$query = " SELECT * FROM probleme WHERE  ID_PB = '".$tab_egal_rep[$k]."';";
										$results = mysql_query($query);
										if(!$results)
										{
											 echo "Problème de connexion à la base de données";
											 echo "<BR><A HREF = \"body.php\" TARGET = \"body\">Retour à l'accueil</A>";
											 mysql_close();
											 exit;
										}
										$res_affiche = mysql_fetch_row($results);
										echo "<TR>";
											  echo "<TD>";
													 echo $res_affiche[5];
											  echo "</TD>";
											}
									  }
							echo "</TR>";
							
							echo "<TR>";
								echo "<TD>";
								echo "</TD>";
							echo "</TR>";
							
							echo "<TR>";
								echo "<TD>";
								echo "</TD>";
							echo "</TR>";
							
							echo "<TR>";
								echo "<TD></TD>";
							echo "</TR>";
							  
							echo "<TR>";
								echo "<TD>";
									  echo "Etablissements / Ecoles";
								echo "</TD>";
							echo "</TR>";
							  
							echo "<TR>";
								echo "<TD class =\"cher\">";
									  echo "Nombre d'établissement dans la base de donnés";
								echo "</TD>";
								echo "<TD>";
									  echo $num_results_tot_etab;
								echo "</TD>";
							echo "</TR>";
							  
							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre d'établissements du Cher";
								echo "</TD>";
								echo "<TD>";
									  echo $num_results_tot_etab_cher;
								echo "</TD>";
							echo "</TR>";
							
							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre d'établissements de l'Eure et Loir";
								echo "</TD>";
								echo "<TD>";
									  echo $num_results_tot_etab_eure_et_loir;
								echo "</TD>";
							echo "</TR>";
							  
							echo "<TR>";
									echo "<TD class = \"etiquette\">";
										echo "Nombre d'établissements de l'Indre";
									echo "</TD>";
									echo "<TD>";
										echo $num_results_tot_etab_indre;
									echo "</TD>";
							echo "</TR>";
							  
							echo "<TR>";
									echo "<TD class = \"etiquette\">";
										echo "Nombre d'établissements de l'Indre et Loire";
									echo "</TD>";
									echo "<TD>";
										echo $num_results_tot_etab_indre_et_loire;
									echo "</TD>";
							echo "</TR>";
							  
							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre d'établissements du Loir et Cher";
								echo "</TD>";
								echo "<TD>";
									  echo $num_results_tot_etab_loir_et_cher;
								echo "</TD>";
							echo "</TR>";

							echo "<TR>";
								echo "<TD class = \"etiquette\">";
									  echo "Nombre d'établissements du Loiret";
								echo "</TD>";
								echo "<TD>";
									  echo $num_results_tot_etab_loiret;
								echo "</TD>";
							echo "</TR>";
							
							echo "<TR>";
								echo "<TD>";
								echo "</TD>";
							echo "</TR>";
*/
					echo "</TABLE>";
							mysql_close();
?>
		</div>
	</BODY>
</HTML>
