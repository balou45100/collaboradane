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

			//Inclusion des fichiers nécessaires
			//include("../biblio/ticket.css");
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
	echo "<body>
		<div align = \"center\">";
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_contacts_prives.png\" ALT = \"Titre\">";
			//Récupération des variables pour faire fonctionner ce script
			//$FGMM = $_GET['FGMM']; //on arrive du fichier fgmm_cadre.php
			$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
			$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
			$tri = $_GET['tri']; //Tri sur quelle colonne ?
			$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
			$indice = $_GET['indice']; //à partir de quelle page
			$rechercher = $_GET['rechercher']; //détail à rechercher
			$dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
			$categorie = $_GET['categorie']; //la catégorie choisie
			$lettre = $_GET['lettre'];
			$action = $_GET['action'];
			$CHGMT = $_GET['CHGMT'];

			//echo "<BR>categorie : $categorie";

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

			if ((!isset($rechercher) || $rechercher == "") AND $origine_gestion <> "contacts_prives" )
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

			if (isset($categorie))
			{
				if ($categorie == "T")
				{
					$categorie = "%";
				}
				//echo "<br>catégorie set : $categorie";

				$_SESSION['categorie_en_cours'] = $categorie;
			}
			else
			{
				$categorie = $_SESSION['categorie_en_cours'];
			}
			$cat_en_cours = $_SESSION['categorie_en_cours'];

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

			echo "<BR>variables ordinaires : origine_gestion : $origine_gestion - indice : $indice -  filtre : $filtre - à rechercher : $rechercher - dans : $dans - tri : $tri - sense_tri : $sense_tri - lettre $lettre - categorie : $categorie - cat_en_cours : $cat_en_cours";
			echo "<BR>variables session : origine_gestion : $ses_origine_gestion - indice : $ses_indice -  filtre : $ses_filtre - à rechercher : $ses_rechercher - dans : $ses_dans - tri : $ses_tri - sense_tri : $ses_sense_tri - ses_lettre : $ses_lettre";
			*/

			if ($CHGMT == "O") //pour traiter les modifications dans les différents formulaire de cette page
			{
				switch ($action)
				{
					case ('affiche_contact') :
						echo "<FORM ACTION = \"contacts_prives_gestion.php\" METHOD = \"GET\">";
							include ("contacts_affiche_fiche.inc.php");
						echo "</FORM>";
						//echo "<BR><A HREF = \"contacts_prives_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('ajout_contact') :
						echo "<FORM ACTION = \"contacts_prives_gestion.php\" METHOD = \"GET\">";
							include ("contacts_ajout_fiche.inc.php");
						echo "</FORM>";
						echo "<BR><A HREF = \"contacts_prives_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('enreg_contact_ajoute') : //enregistrement d'un lot modifié
						include ("contacts_enreg_fiche.inc.php");
						$affichage = "O";
					break;

					case ('modif_contact') :
						echo "<FORM ACTION = \"contacts_prives_gestion.php\" METHOD = \"GET\">";
							include ("contacts_modif_fiche.inc.php");
						echo "</FORM>";
						echo "<BR><A HREF = \"contacts_prives_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('enreg_contact_modifie') : //enregistrement d'un lot modifié
						include ("contacts_enreg_fiche_modifie.inc.php");
						$affichage = "O";
					break;

					case ('suppression_contact') :
						echo "<FORM ACTION = \"contacts_prives_gestion.php\" METHOD = \"GET\">";
							include ("contacts_suppression_fiche.inc.php");
						echo "</FORM>";
						echo "<BR><A HREF = \"contacts_prives_gestion.php\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/retour.png\" ALT = \"Retour\" border = \"0\"></A>";
					break;

					case ('confirm_suppression_contact') :
						include ("contacts_confirmation_suppression_fiche.inc.php");
						$affichage = "O";
					break;

				} // fin du switch $action
			} // fin du if de $CHGMT == "O"

			if ($affichage <> "N")
			{
				switch ($origine_gestion)
				{
					case "contacts_prives" :
						//echo "<BR>coucou du contacts_prives - filtre : $filtre tri : $tri - cat_en_cours : $cat_en_cours";
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

									case "CAT" :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY CATEGORIE $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM ASC;";
									break;
								}
							break;
						}
					break;

					case "recherche_contacts_prives" :
						if ($rechercher <>"")
						{
							switch ($dans)
							{
								case "T" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PERSO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PERSO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PERSO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										case "CAT" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PERSO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' OR MEL_PERSO LIKE '%$rechercher%' AND EMETTEUR <> '".$_SESSION['nom']."' AND STATUT = 'public' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "N" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										case "CAT" :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE NOM LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "V" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										case "CAT" :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE VILLE LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "M" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										case "CAT" :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts WHERE MEL_PRO LIKE '%$rechercher%' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM ASC;";
										break;
									}
								break;

								case "ENTITE" :
									switch ($tri)
									{
										case "ID" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' AND contacts.STATUT = 'prive' AND contacts.CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
										break;

										case "NOM" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' AND contacts.STATUT = 'prive' AND contacts.CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;

										case "SO" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' AND contacts.STATUT = 'prive' AND contacts.CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
										break;

										case "CAT" :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' AND contacts.STATUT = 'prive' AND contacts.CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
										break;

										default :
											$query = "SELECT * FROM contacts,repertoire WHERE No_societe=ID_SOCIETE AND societe LIKE '%$rechercher%' AND contacts.EMETTEUR = '".$_SESSION['nom']."' AND contacts.STATUT = 'prive' AND contacts.CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
										break;
									}
								break;
							} //Fin switch ($dans)
						} //Fin if ($rechercher <>"")
						else
						{
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_CONTACT $sense_tri;";
								break;

								case "NOM" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY ID_SOCIETE $sense_tri;";
								break;

								case "CAT" :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY CATEGORIE $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM contacts WHERE EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' AND CATEGORIE LIKE '".$cat_en_cours."' ORDER BY NOM ASC;";
								break;
							}
						} 
					break; //Fin case "recherche_contacts_prives" :

					case "alpha" :
						switch ($tri)
						{
							case "ID" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_CONTACT $sense_tri;";
							break;

							case "NOM" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM $sense_tri;";
							break;

							case "SO" :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY ID_SOCIETE $sense_tri;";
							break;

							default :
								$lettre = $lettre."%";
								$query = "SELECT * FROM contacts WHERE NOM LIKE '".$lettre."' AND EMETTEUR = '".$_SESSION['nom']."' AND STATUT = 'prive' ORDER BY NOM ASC;";
							break;
						}
					break;
				} //Fin switch ($origine_gestion)
        
				//Affichage de la barre de recherche alphabétique 
				AfficheRechercheAlphabet("NOM","contacts_prives_gestion");

				//Lien pour ajouter un nouveau contact 

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"contacts_prives_gestion.php?CHGMT=O&amp;action=ajout_contact\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/contact_ajout.png\" ALT = \"Nouveau\" title=\"Ajouter contact\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Ajouter un contact</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

				//echo "<BR><A HREF = \"contacts_prives_gestion.php?CHGMT=O&amp;action=ajout_contact\" class = \"bouton\">Insérer un nouveau contact</A>";

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
					if ($categorie == "%")
					{
						$categorie_a_afficher = "Toutes";
					}
					else
					{
						$categorie_a_afficher = $categorie;
					}
					//echo "<h2>Nombre d'enregistrements sélectionnés : $num_results - cat&eacute;gorie&nbsp;:&nbsp;$categorie_a_afficher</h2>";
					echo "<h2>Nombre d'enregistrements sélectionnés : $num_results</h2>";
					echo "<TABLE width = \"95%\">
						<TR>
							<th width=\"4%\">";
								if ($sense_tri =="asc")
								{
									echo "Id<A href=\"contacts_prives_gestion.php?tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par identifiant du contact, ordre decroissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Id<A href=\"contacts_prives_gestion.php?tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par identifiant du contact, ordre croissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th width=\"10%\">";
								if ($sense_tri =="asc")
								{
									echo "Nom<A href=\"contacts_prives_gestion.php?tri=NOM&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre decroissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Nom<A href=\"contacts_prives_gestion.php?tri=NOM&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par nom, ordre croissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}

							echo "</th>
							<th width=\"5%\">Prénom</th>
							<th width=\"10%\">Fonction</th>
							<th width=\"15%\">ADRESSE</th>
							<th width=\"10%\">T&Eacute;L</th>
							<th width=\"10%\">Mobile</th>
							<th width=\"10%\">m&eacute;l</th>
							<th width=\"10%\">";
								if ($sense_tri =="asc")
								{
									echo "Entit&eacute;<A href=\"contacts_prives_gestion.php?tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Entit&eacute;<A href=\"contacts_prives_gestion.php?tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}
							echo "</th>
							<th width=\"8%\">";
								if ($sense_tri =="asc")
								{
									echo "Cat&eacute;gorie<A href=\"contacts_prives_gestion.php?tri=CAT&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/desc.png\" border=\"0\"></A>";
								}
								else
								{
									echo "Cat&eacute;gorie<A href=\"contacts_prives_gestion.php?tri=CAT&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/asc.png\" border=\"0\"></A>";
								}
							echo "</th>";
							echo "<th width=\"8%\">ACTIONS</th>";

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
								echo "<a href = \"contacts_prives_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
								//echo "<A HREF = \"contacts_prives_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
									echo "&nbsp;<a href = \"contacts_prives_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
									//echo "<A HREF = \"contacts_prives_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
										echo "<TD width=\"5%\">$res[3]</TD>";
										echo "<TD width=\"10%\">$res[4]</TD>";
										echo "<TD width=\"15%\">$res[5]<br>$res[6] $res[7]</TD>";
										echo "<TD width=\"10%\" align=\"center\">";
											$tel = affiche_tel($res[8]);
											echo $tel; //tél directe
											//+echo $res[8];
										echo "</TD>";
										echo "<TD width=\"10%\" align=\"center\">";
											$tel = affiche_tel($res[10]);
											echo $tel;
										echo "</TD>";
										echo "<TD width=\"10%\">$res[11]</TD>";
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
										echo "<TD width=\"8%\">$res[16]</TD>";
										//Les actions
										echo "<TD nowrap class = \"fond-actions\" width=\"8%\">";
											echo "&nbsp;<A HREF = \"contacts_prives_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=affiche_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"Consulter\" title=\"Consulter la fiche du contact\" border = \"0\"></A>";
											echo "&nbsp;<A HREF = \"contacts_prives_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=modif_contact\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier le contact\" border = \"0\"></A>";
											//echo "&nbsp;<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ajout_ticket.png\" ALT = \"Ajouter un ticket\" height=\"24px\" width=\"24px\" border = \"0\"></A>";
											if (($_SESSION['droit'] == "Super Administrateur") OR ($res[14] == $_SESSION['nom']))
											{
												echo "&nbsp;<A HREF = \"contacts_prives_gestion.php?CHGMT=O&amp;id_contact=$res[0]&amp;action=suppression_contact\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";	
											}
										echo "</TD>";
									echo "</TR>";
								} //Fin if ($res[0] <>"")
								$res = mysql_fetch_row($results);
							} //Fin for ($i = 0; $i < $nb_par_page; ++$i)
							//Fermeture de la connexion à la BDD
							mysql_close();
				} //Fin if ($num_results >0)
				else
				{
					echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
				}
			} //Fin if ($affichage <> "N")
?>
			</TABLE>
		</div>
	</body>
</html>
