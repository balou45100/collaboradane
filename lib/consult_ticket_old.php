<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">

<!"Ce fichier a pour but de consulter les données (problématique + réponses) concernant un ticket">

<HTML>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  		<?php
			include("../biblio/ticket.css");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>vous n'ètes pas logué</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A HREF=\"../index.php\" class = \"bouton\">Retour à la mire de connexion</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body link="#FFFFFF" Vlink="#FFFFFF">
		<CENTER>
			<?php
				//récupération de l'identifiant du problème, la consultation se fait par accés avec cette clé
				$idpb = $_GET['idpb'];
				if(!isset($idpb) || $idpb == "")
				{
					echo "<FONT COLOR = \"#808080\"><B>Erreur de récupération des données</B></FONT>";
					echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
					exit;
				}
				
				//Récupération de l'id de la catégorie quand celui-ci est selectionné
				//La présence du @ permet de ne pas faire afficher l'erreur dont à la consultation
				//En effet lors de la consultation aucune variable n'est envoyé
				//C'est juste lors de la selection dans la consultation d'une categorie que cette variable devient
				//Effective par récurrence
				@$categorie = $_GET['categorie'];
				
				//Inclusion des fichiers nécessaires
				include("../biblio/init.php");
				
				include ("../biblio/fct.php");
				
				$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
				$result_consult = mysql_query($query);
				
				//Dans le cas où aucun résultats n'est retourné
				if(!$result_consult)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée ou problème inexistant</B></FONT>";
					echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$res = mysql_fetch_row($result_consult);
				switch ($res[13]) {
		                       case "N":
                                       $priorite_selection = "Normal";
				       $priorite_non_selection_ref_1 = "H";
				       $priorite_non_selection_ref_2 = "B";
           			       $priorite_non_selection_nom_1 = "Haute";
				       $priorite_non_selection_nom_2 = "Basse";
				       break;

				       case "H":
				       $priorite_selection = "Haute";
				       $priorite_non_selection_ref_1 = "N";
				       $priorite_non_selection_ref_2 = "B";
				       $priorite_non_selection_nom_1 = "Normal";
				       $priorite_non_selection_nom_2 = "Basse";
				       break;

				       case "B":
				       $priorite_selection = "Basse";
				       $priorite_non_selection_ref_1 = "H";
				       $priorite_non_selection_ref_2 = "N";
				       $priorite_non_selection_nom_1 = "Haute";
				       $priorite_non_selection_nom_2 = "Normal";
				       break;

				       default:
				       $res[13] = "N";
				       $priorite_selection = "Normal";
				       $priorite_non_selection_ref_1 = "H";
				       $priorite_non_selection_ref_2 = "B";
				       $priorite_non_selection_nom_1 = "Haute";
				       $priorite_non_selection_nom_2 = "Basse";
				       break;
				}
				
				//Requète pour selectionner toutes les catégories dont la personne connectée est possesseur
				//Afin de pouvoir affecter un ticket à une catégorie
				$query_categ = "SELECT * FROM categorie WHERE NOM_UTIL = '".$_SESSION['nom']."' AND MAIL_UTIL = '".$_SESSION['mail']."';";
				$results_categ = mysql_query($query_categ);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results_categ)
				{
					echo "<b>Erreur de connexion à la base de donn&eacute;es</b>";
					echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$res_categ = mysql_fetch_row($results_categ);
				$num_categ = mysql_num_rows($results_categ);
				
				//Requète pour selectionner l'établissement dont il est le sujet
				$query_etab = "SELECT * FROM etablissements WHERE RNE = '".$res[4]."';";
				$results_etab = mysql_query($query_etab);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results_etab)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$res_etab = mysql_fetch_row($results_etab);
				
				//Requète pour selectionner les messages réponses à ce problème
				$query_rep = "SELECT * FROM probleme WHERE ID_PB_PERE = '".$idpb."' ORDER BY ID_PB DESC;";
				$results_rep = mysql_query($query_rep);
				//Dans le cas où aucun résultats n'est retourné
				if(!$results_rep)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
					mysql_close();
					exit;
				}
				$res_rep = mysql_fetch_row($results_rep);
				$num_rep = mysql_num_rows($results_rep);
				
				//Traitement dela variable $categorie
				//Dans le cas où la variable n'est pas renseigné, donc que l'on a juste cliqué sur la consultation
				if(!isset($categorie) || $categorie == "")
				{}
				else
				{
					//Requète pour vérifier que le problème figure déjà ou non dans la catégorie
					$query_select_pb_categ = "SELECT ID_PB_CATEG FROM categorie WHERE ID_CATEG = '".$categorie."';";
					$results_select_pb_categ = mysql_query($query_select_pb_categ);
					//Dans le cas où aucun résultats n'est retournés
					if(!$results_select_pb_categ)
					{
						echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée</B></FONT>";
						echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
						mysql_close();
						exit;
					}
					$res_select_pb_categ = mysql_fetch_row($results_select_pb_categ);
					
					//La fonction strtok à la différence de explode permet de traiter les données au fur à
					//Mesure que l'on parcours un chaine
					$idpb_array = strtok($res_select_pb_categ[0], ';');
					$no = "0";
					while ($idpb_array != '')
					{
						if ($idpb_array == $idpb)
						{
							echo "<FONT COLOR = \"#808080\"><B>Le problème figure déjà dans cette catégorie</B></FONT>";
							$no = "1";
						}
						
						$idpb_array = strtok(';');
					};
					
					//Dans le cas où le problème ne fait pas parti de la catégorie
					//On concat la liste des problèmes existants au nouveau probème à ajouter auquel on rajoute par derrière
					//Un ;
					if($no == "0")
					{
						$res_select_pb_categ[0] = $res_select_pb_categ[0]."".$idpb;
						
						$query_insert_categ = "UPDATE categorie SET ID_PB_CATEG = '".$res_select_pb_categ[0].";' WHERE ID_CATEG = '".$categorie."';";
						$results_insert_categ = mysql_query($query_insert_categ);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results_insert_categ)
						{
							echo "<FONT COLOR = \"#808080\"><B>Problème lors de la connexion à la base de donnée</B></FONT>";
							echo "<BR><BR><A HREF = \"gestion_ticket.php?tri=G\" class = \"bouton\">Retour à la gestion des tickets</A>";
							mysql_close();
							exit;
						}
						echo "<FONT COLOR = \"#808080\"><B>Ticket insérer dans la catégorie</B></FONT>";
					}
				}
				
				//Formulaire pour insérer un ticket dans une catégorie, nous appartenant
				echo "<FORM ACTION = \"consult_ticket.php\" METHOD = \"GET\">";
					echo "<TABLE BORDER = \"0\">";
						echo "<TR>";
							echo "<TD class = \"td-1\">";
								echo "<INPUT TYPE = \"hidden\" VALUE = \"".$idpb."\" NAME = \"idpb\">";
								echo "<FONT COLOR = \"#808080\"><B>Placer ce ticket dans une catégorie :</B></FONT>";
							echo "</TD>";
							echo "<TD class = \"td-1\">";
								echo "<SELECT NAME = \"categorie\">";
								for($i = 0; $i < $num_categ; ++$i)
								{
									echo "<OPTION VALUE = \"".$res_categ[0]."\">".$res_categ[1]."</OPTION>";
									$res_categ = mysql_fetch_row($results_categ);
								}
								echo "</SELECT>";
							echo "</TD>";
							echo "<TD class = \"td-1\">";
								echo "<INPUT TYPE = \"submit\" VALUE = \"OK\">";
							echo "</TD>";
						echo "</TR>";
					echo "</TABLE>";
				echo "</FORM>";
								
				//Résumé des infos concernant le problème
				echo "<TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">";
					echo "<TR CLASS = \"".statut($res[11])."\">";
						echo "<TD>";
							echo "Emetteur : ";
						echo "</TD>";
						echo "<TD>";
							echo $res[3];
						echo "</TD>";
						echo "<TD>";
							echo "Intervenant potentiel : ";
						echo "</TD>";
						echo "<TD>";
							echo $res[10];
						echo "</TD>";
					echo "</TR>";
					echo "<TR CLASS = \"".statut($res[11])."\">";
						echo "<TD>";
							echo "Date de création :";
						echo "</TD>";
						echo "<TD>";
							echo $res[7];
						echo "</TD>";
						echo "<TD>";
							echo "Date de modification :";
						echo "</TD>";
						echo "<TD>";
							echo $res[8];
						echo "</TD>";
					echo "</TR>";
					echo "<TR CLASS = \"".statut($res[11])."\">";
						echo "<TD>";
							echo "Sujet : ";
						echo "</TD>";
						echo "<TD>";
							echo $res[5];
						echo "</TD>";
						echo "<TD>";
							echo "Etablissement : ";
						echo "</TD>";
						echo "<TD>";
							echo str_replace("*", " ",$res_etab[0])." ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[3])." ".str_replace("*", " ",$res_etab[5]);
						echo "</TD>";
					echo "</TR>";
                                        echo "<TR CLASS = \"".statut($res[11])."\">";
						echo "<TD>";
							echo "Priorité : ";
						echo "</TD>";
						echo "<TD>";
							echo $priorite_selection;
						echo "</TD>";
						echo "<TD>";
						echo "</TD>";
						echo "<TD>";
						echo "</TD>";
					echo "</TR>";
					echo "<TR CLASS = \"".statut($res[11])."\">";
						echo "<TD>";
							echo "Contenu :";
						echo "</TD>";
						echo "<TD>";
							echo $res[6];
						echo "</TD>";
					echo "</TR>";
					echo "</TABLE>";
					
          
        //Dans le cas où le fichier n'est pas archivé l'utilisateur à le droit de répondre au sujet
				if($res[11] != "A")
				{
					// echo "<BR>";					
					echo "<A HREF = \"ajout_reponse_ticket.php?idpb=".$idpb."\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/new.gif\" ALT = \"ajouter une reponse\"></A>";
				}
					
					//Traitement de chaque ligne de réponse
					//Pour lister chaque réponse publié
					for($i = 0; $i < $num_rep; ++$i)
					{
						//echo "<BR>";
						echo "<TABLE width=\"95%\" BORDER = \"0\" BGCOLOR = \"#48D1CC\">";
							echo "<TR CLASS = \"".statut($res_rep[11])."\">";
								echo "<TD>";
									echo "Emetteur : ";
								echo "</TD>";
								echo "<TD>";
									echo $res_rep[3];
								echo "</TD>";
								echo "<TD>";
									echo "Date d'envoi :";
								echo "</TD>";
								echo "<TD>";
									echo $res_rep[7];
								echo "</TD>";
							echo "</TR>";
							echo "<TR CLASS = \"".statut($res_rep[11])."\">";
								echo "<TD>";
									echo "Contenu : ";
								echo "</TD>";
								echo "<TD>";
									echo $res_rep[6];
								echo "</TD>";
							echo "</TR>";
						echo "</TABLE>";
						$res_rep = mysql_fetch_row($results_rep);
					}
				
				
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
