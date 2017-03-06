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

			//Inclusion des fichiers nécessaires
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_contacts_societes.png\" ALT = \"Titre\">";
			$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
			$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
			$tri = $_GET['tri']; //Tri sur quelle colonne ?
			$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
			$indice = $_GET['indice']; //à partir de quelle page
			$rechercher = $_GET['rechercher']; //détail à rechercher
			$dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
			$lettre = $_GET['lettre'];
			$action = $_GET['action'];
			$CHGMT = $_GET['CHGMT'];
			If ($CHGMT == "O") 
			{
				$affichage = "N"; //on n'affiche pas la liste des contacts
			}
			//Initialisation des variables session pour pouvoir revenir dans cette page de n'importe où
			if(!isset($origine_gestion) || $origine_gestion == "")
			{
				$origine_gestion = $_SESSION['origine_gestion'];
			}
			else
			{
				$_SESSION['origine_gestion'] = $origine_gestion;
			}

			if(!isset($filtre) || $filtre == "")
			{
				$filtre = $_SESSION['filtre'];
			}
			else
			{
				$_SESSION['filtre'] = $filtre;
			}

			if(!isset($tri) || $tri == "")
			{
				$tri = $_SESSION['tri'];
			}
			else
			{
				$_SESSION['tri'] = $tri;
			}

			if(!isset($sense_tri) || $sense_tri == "")
			{
				$sense_tri = $_SESSION['sense_tri'];
			}
			else
			{
				$_SESSION['sense_tri'] = $sense_tri;
			}

			if(!isset($indice) || $indice == "")
			{
				$indice = $_SESSION['indice'];
			}
			else
			{
				$_SESSION['indice'] = $indice;
			}

			if(!isset($rechercher) || $rechercher == "")
			{
				$rechercher = $_SESSION['rechercher'];
			}
			else
			{
				$_SESSION['rechercher'] = $rechercher;
			}

			if(!isset($dans) || $dans == "")
			{
				$dans = $_SESSION['dans'];
			}
			else
			{
				$_SESSION['dans'] = $dans;
			}

			if(!isset($lettre) || $lettre == "")
			{
				$lettre = $_SESSION['lettre'];
			}
			else
			{
				$_SESSION['lettre'] = $lettre;
			}

			$_SESSION['origine'] = "contacts_gestion";

			$nb_par_page = 12; //Fixe le nombre de ligne qu'il faut afficher à l'écran

			/*
			//Affectation des variables sessions pour contrôle et affichage
			$ses_origine_gestion = $_SESSION['origine_gestion'];
			$ses_indice = $_SESSION['indice'];
			$ses_filtre = $_SESSION['filtre'];
			$ses_rechercher = $_SESSION['rechercher'];
			$ses_dans = $_SESSION['dans'];
			$ses_tri = $_SESSION['tri'];
			$ses_sense_tri = $_SESSION['sense_tri'];
			$ses_lettre = $_SESSION['lettre'];
			echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre";
			echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - à rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
			*/

			if ($CHGMT == "O") //pour traiter les modifications dans les différents formulaire de cette page
			{
				switch ($action)
				{
					case ('affiche_contact') :
						echo "<FORM ACTION = \"contacts_gestion.php\" METHOD = \"GET\">";
							include ("contacts_affiche_fiche.inc.php");
						echo "</FORM>";
						//echo "<BR><A HREF = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('ajout_contact') :
						echo "<FORM ACTION = \"contacts_gestion.php\" METHOD = \"GET\">";
							include ("contacts_ajout_fiche.inc.php");
						echo "</FORM>";
						//echo "<BR><A HREF = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('enreg_contact_ajoute') : //enregistrement d'un lot modifié
						include ("contacts_enreg_fiche.inc.php");
						$affichage = "O";
					break;

					case ('modif_contact') :
						echo "<FORM ACTION = \"contacts_gestion.php\" METHOD = \"GET\">";
							include ("contacts_modif_fiche.inc.php");
						echo "</FORM>";
						//echo "<BR><A HREF = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('enreg_contact_modifie') : //enregistrement d'un lot modifié
						include ("contacts_enreg_fiche_modifie.inc.php");
						$affichage = "O";
					break;

					case ('suppression_contact') :
						echo "<FORM ACTION = \"contacts_gestion.php\" METHOD = \"GET\">";
							include ("contacts_suppression_fiche.inc.php");
						echo "</FORM>";
						//echo "<BR><A HREF = \"contacts_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('confirm_suppression_contact') :
						include ("contacts_confirmation_suppression_fiche.inc.php");
						$affichage = "O";
					break;

					case ('a_contacter') :
						$id_contact = $_GET['id_contact'];
						//On passe le champ "a_contacter à 'O'
						$requete_a_contacter = "UPDATE contacts SET a_contacter = 'O' WHERE id_contact = '".$id_contact."'";
						$resultat_requete_a_contacter = mysql_query($requete_a_contacter);
						$affichage = "O";
					break;

					case ('a_contacter_non') :
						$id_contact = $_GET['id_contact'];
						//On passe le champ "a_contacter à 'O'
						$requete_a_contacter_non = "UPDATE contacts SET a_contacter = 'N' WHERE id_contact = '".$id_contact."'";
						$resultat_requete_a_contacter_non = mysql_query($requete_a_contacter_non);
						$affichage = "O";
					break;

					case ('a_contacter_aucun') :
						$id_contact = $_GET['id_contact'];
						//On passe le champ "a_contacter à 'O'
						$requete_a_contacter_aucun = "UPDATE contacts SET a_contacter = 'N'";
						$resultat_requete_a_contacter_aucun = mysql_query($requete_a_contacter_aucun);
						$affichage = "O";
					break;
				} // fin du switch $action
			} // fin du if de $CHGMT == "O"

			if ($affichage <> "N")
			{
				switch ($origine_gestion)
				{
					case "filtre" :
						switch ($filtre)
						{
							case "T" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
									break;

									case "NOM" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
									break;
								}
							break;

							case "MC" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
									break;

									case "NOM" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' ORDER BY NOM ASC;";
									break;
								}
							break;

							case "MCP" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_CONTACT $sense_tri;";
									break;

									case "NOM" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_SOCIETE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM ASC;";
									break;
								}
							break;

							case "AC" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM contacts WHERE a_contacter = 'O' AND (EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."') ORDER BY ID_CONTACT $sense_tri;";
									break;

									case "NOM" :
										$query = "SELECT * FROM contacts WHERE a_contacter = 'O' AND (EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."') ORDER BY NOM $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM contacts WHERE a_contacter = 'O' AND (EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."') ORDER BY ID_SOCIETE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE a_contacter = 'O' AND (EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."') ORDER BY NOM ASC;";
									break;
								}
							break;

						} // Fin switch $filtre
					break;

					case "recherche" :
						if ($rechercher <>"")
						{
							switch ($dans)
							{
								case "T" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR VILLE LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR VILLE LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR VILLE LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR VILLE LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "N" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "V" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "M" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' OR MEL_PRO LIKE '%$rechercher%' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "ENTITE" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' OR No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.STATUT = 'public' AND contacts.EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' OR No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.STATUT = 'public' AND contacts.EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' OR No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.STATUT = 'public' AND contacts.EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' OR No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.STATUT = 'public' AND contacts.EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
										break;
									}
								break;
							} // switch 'dans'
						} // Fin rechercher <>""
						else
						{
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
								break;

								case "NOM" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' OR STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
								break;
							}
						}
					break; //Fin case "recherche" :

					case "contacts_prives" :
						//echo "<BR>coucou du contacts_prives - filtre : $filtre tri : $tri";
						switch ($filtre)
						{
							case "T" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_CONTACT $sense_tri;";
									break;

									case "NOM" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_SOCIETE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM ASC;";
									break;
								}
							break;
						}
					break;

					case "alpha" :
						switch ($tri)
						{
							case "ID" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '".$lettre."' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_CONTACT $sense_tri;";
							break;

							case "NOM" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '".$lettre."' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM $sense_tri;";
							break;

							case "SO" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '".$lettre."' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY ID_SOCIETE $sense_tri;";
							break;

							default :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' OR NOM LIKE '".$lettre."' AND STATUT = 'public' AND EMETTEUR <> '".$_SESSION['nom']."' ORDER BY NOM ASC;";
							break;
						}
					break;
				} //Fin switch origine gestion

				//Affichage de la barre de recherche alphabétique 
				AfficheRechercheAlphabet("NOM","contacts_gestion");

				//Lien pour ajouter un nouveau contact 

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"contacts_gestion.php?CHGMT=O&amp;action=ajout_contact\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/contact_ajout.png\" ALT = \"Nouveau\" title=\"Ajouter contact\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un contact</span><br />";
							echo "</td>";
							echo "<td>";
								echo "<A HREF = \"contacts_gestion.php?CHGMT=O&amp;action=a_contacter_aucun\" class = \"bouton\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/contacts_pas_contacter.png\" ALT = \"Pas marquer\" title=\"Marquer personne\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Marquer tous les contacts <<&nbsp;ne pas contacter&nbsp;>></span><br /></A>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

				//echo "<BR><A HREF = \"contacts_gestion.php?CHGMT=O&amp;action=ajout_contact\" class = \"bouton\">Ins&eacute;rer un nouveau contact</A>";
				//echo "&nbsp; - &nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;action=a_contacter_aucun\" class = \"bouton\">Marquer tous les contacts <<&nbsp;ne pas contacter&nbsp;>></A>";

				$results = mysql_query($query);
				if(!$results)
				{
					echo "<B>Problème lors de la connexion à la base de données</B>";
					echo "<BR><BR><A HREF = \"body.php\" class = \"bouton\" target = \"body\">Retour à l'accueil</A>";
					mysql_close();
					exit;
				}

				//Retourne le nombre de ligne rendu par la requète
				$num_results = mysql_num_rows($results);
				if ($num_results >0)
				{
					//Affichage de l'entête du tableau
					echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
					echo "<TABLE width = \"95%\">
						<TR>
							<th width=\"4%\">";
								if ($sense_tri =="asc")
								{
									echo "Id&nbsp;<A href=\"contacts_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par identifiant du contact, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Id&nbsp;<A href=\"contacts_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par identifiant du contact, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th width=\"10%\">";
								if ($sense_tri =="asc")
								{
									echo "Nom&nbsp;<A href=\"contacts_gestion.php?tri=NOM&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Nom&nbsp;<A href=\"contacts_gestion.php?tri=NOM&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}

							echo "</th>
							<th width=\"8%\">Prénom</th>
							<th width=\"10%\">Fonction</th>
							<th width=\"10%\">";
								if ($sense_tri =="asc")
								{
									echo "Entit&eacute;&nbsp;<A href=\"contacts_gestion.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Entit&eacute;&nbsp;<A href=\"contacts_gestion.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th width=\"18%\">VILLE</th>
							<th width=\"10%\">T&Eacute;L</th>
							<th width=\"10%\">Mobile</th>
							<th width=\"10%\">m&eacute;l</th>
							<th><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\"></th>
							<th width=\"10%\">ACTIONS</th>";

							//Requète pour afficher les établissements selon le filtre appliqué

							///////////////////////////////////
							//Partie sur la gestion des pages//
							///////////////////////////////////
							$nombre_de_page = number_format($num_results/$nb_par_page,1);
							/*
							echo "<br>Nombre de pages : $nombre_de_page";
							echo "<br>Nb_par_page : $nb_par_page<br>";
							*/
							echo "Page&nbsp;";
							If ($indice == 0)
							{
								echo "<span class= \"page_courante\"><strong>&nbsp;1&nbsp;</strong></span>";
							}
							else
							{
								echo "<a href = \"contacts_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"contacts_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
							}
							//echo "<BR>indice : $indice<br>";
							for($j = 1; $j<$nombre_de_page; ++$j)
							{
								$nb = $j * $nb_par_page;
								$page = $j + 1;
								if ($page * $nb_par_page == $indice + $nb_par_page)
								{
									echo "<span class= \"page_courante\"><strong>&nbsp;".$page."&nbsp;</strong></span>";
								}
								else
								{
									echo "&nbsp;<a href = \"contacts_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"contacts_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
								}
							}

							$j = 0;
							while($j<$indice) //on se potionne sur la bonne page suivant la valeur de l'index
							{
								$res = mysql_fetch_row($results);
								++$j;
							}
							/////////////////////////
							//Fin gestion des pages//
							/////////////////////////

							//Traitement de chaque ligne
							$res = mysql_fetch_row($results);
							if ($nombre_de_page)
							for ($i = 0; $i < $nb_par_page; ++$i)
							{
								if ($res[0] <>"")
								{
									echo "<TR>";
										echo "<TD width=\"4%\" align = \"center\">$res[0]</TD>";
										echo "<TD width=\"10%\">$res[2]</TD>";
										echo "<TD width=\"8%\">$res[3]</TD>";
										echo "<TD width=\"10%\">$res[4]</TD>";
										// Il faut recupérer le nom de la société
										$query_donnateur = "SELECT * FROM repertoire WHERE No_societe = '".$res[1]."';";
										$result_consult = mysql_query($query_donnateur);
										$num_rows = mysql_num_rows($result_consult);
										if (mysql_num_rows($result_consult))
										{
											$ligne=mysql_fetch_object($result_consult);
											$societe=$ligne->societe;
										}
										else
										{
											$societe = "";
										}
										echo "<td width=\"10%\" align=\"center\">$societe</td>";
										echo "<TD width=\"18%\">$res[7]</TD>";
										echo "<TD width=\"10%\" align=\"center\">";
											$tel = affiche_tel($res[8]);
											echo $tel; //tél directe
										echo "</TD>";
										echo "<TD width=\"10%\" align=\"center\">";
											$tel = affiche_tel($res[10]);
											echo $tel;
										echo "</TD>";
										echo "<TD width=\"10%\">";
											echo "<A HREF = \"mailto:".str_replace(" ", "*",$res[11])."?cc=".$_SESSION['mail']."><!--FONT COLOR=\"#696969\"-->".$res[11]."<!--/FONT--></A>";
										echo "</TD>";
										if ($res[15] == "privé")
										{
											echo "<td><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"privé\"></td>";
										}
										else
										{
											echo "<td>&nbsp;</TD>";
										}
										//Les actions
										echo "<TD nowrap class = \"fond-actions\">";
											echo "&nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=affiche_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"Consulter\" title=\"Consulter la fiche du contact\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=modif_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier le contact\" border = \"0\"></A>";
											//echo "&nbsp;<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\" border = \"0\"></A>";
											if ($res[27] == "O")
											{
												echo "&nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=a_contacter_non\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/a_contacter.png\" ALT = \"&Agrave; contacter\" title=\"Marquer le contact &agrave; ne pas contacter\" border = \"0\"></A>";
											}
											else
											{
												echo "&nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=a_contacter\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/a_contacter_non.png\" ALT = \"&Agrave; contacter\" title=\"Marquer le contact &agrave; contacter\" border = \"0\"></A>";
											}

											if (($_SESSION['droit'] == "Super Administrateur") OR ($res[14] == $_SESSION['nom']))
											{
												echo "&nbsp;<A HREF = \"contacts_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=suppression_contact\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";	
											}
										echo "</TD>";
									echo "</TR>";
								} //Fin if res[0] <>""
								$res = mysql_fetch_row($results);
							} // Fin boucle for
							//Fermeture de la connexion à la BDD
							mysql_close();
				} //Fin if num_results >0
				else
				{
					echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
				}
			} //Fin if affichage <> 'N'
?>
			</TABLE>
		</div>
	</body>
</html>
