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
		echo "<img class = \"titre\" src=\"$chemin_theme_images/titres_modules/titre_repertoire_societes.png\" ALT = \"Titre\">";
			//Récupération des variables pour faire fonctionner ce script
			$FGMM = $_GET['FGMM']; //on arrive du fichier fgmm_cadre.php
			$salon = $_GET['salon']; //on arrive du fichier salon_cadre.php
			$origine_gestion = $_GET['origine_gestion']; //du cadre, filtre de l'entête ou recherche de l'entête
			$filtre = $_GET['filtre']; //quel filtrage sur les enregistrements
			$tri = $_GET['tri']; //Tri sur quelle colonne ?
			$sense_tri = $_GET['sense_tri']; // ascendant ou descendant
			$indice = $_GET['indice']; //à partir de quelle page
			$rechercher = $_GET['rechercher']; //détail à rechercher
			$dans = $_GET['dans']; //dans quel champs, partout, ville, société ou messagerie
			$lettre = $_GET['lettre'];

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

			$_SESSION['origine'] = "repertoire_gestion";

			//Inclusion des fichiers nécessaires
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			//On regarde la somme de la participation financiere pour les rencontres
			$total_part_finance = "SELECT SUM(participation_financiere) FROM salon_suivi_partenaires;";
			//$total_part_finance = "SELECT SUM('participation_financiere') FROM 'salon_suivi_partenaires'";
			$resultat_total = mysql_query($total_part_finance);
			$total = mysql_fetch_row($resultat_total);
			$total = Formatage_Nombre($total[0],$monnaie_utilise);
			//echo "<br>total : $total[0]";

			$nb_par_page = 10; //Fixe le nombre de ligne qu'il faut afficher à l'écran
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
			switch ($origine_gestion)
			{
				case "filtre" :
					switch ($filtre)
					{
						case "T" :
							$intitule_tableau = "Toutes les soci&eacute;t&eacute;s";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
								break;
							}
						break;
            
						case "AT" :
							$intitule_tableau = "les soci&eacute;t&eacute;s à traiter";
							switch ($tri)
							{
								case "ID" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY No_societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' ORDER BY No_societe $sense_tri;";
								break;
                 
								case "SO" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' ORDER BY societe $sense_tri;";
								break;
                  
								default :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe ASC;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' ORDER BY societe ASC;";
								break;
							}
						break;

						case "CONT" :
							$intitule_tableau = "les soci&eacute;t&eacute;s contact&eacute;es";
							switch ($tri)
							{
								case "ID" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY No_societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND contacte = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND contacte = '1' ORDER BY No_societe $sense_tri;";
								break;
                  
								case "SO" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND contacte = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND contacte = '1' ORDER BY societe $sense_tri;";
								break;
                  
								default :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND a_traiter = '1' AND part_fgmm = '0' ORDER BY societe ASC;";
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND contacte = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND contacte = '1' ORDER BY societe ASC;";
								break;
							}
						break;

						case "FGMM" :
							$intitule_tableau = "Tous les partenaires du Festival TICE";
							switch ($tri)
							{
								case "ID" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY No_societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE part_fgmm = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY societe ASC;";
									$query = "SELECT * FROM repertoire WHERE part_fgmm = '1' ORDER BY No_societe $sense_tri;";
								break;
							}
						break;

						case "FGMM_AT" :
							$intitule_tableau = "Les partenaires du Festival TICE à traiter";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND fgmm_suivi_partenaires.a_traiter = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND fgmm_suivi_partenaires.a_traiter = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND fgmm_suivi_partenaires.a_traiter = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "FGMM_INT" :
							$intitule_tableau = "Les partenaires du Festival TICE intéressés";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND interesse_pour_concours = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND interesse_pour_concours = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND interesse_pour_concours = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "FGMM_PART" :
							$intitule_tableau = "Les partenaires du Festival TICE qui participent";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND participation_concours = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND participation_concours = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND participation_concours = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "FGMM_PART_LOGO" :
							$intitule_tableau = "Les partenaires du Festival TICE avec logo sur l'affiche";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND logo_sur_affiche = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND logo_sur_affiche = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, fgmm_suivi_partenaires WHERE id_societe = No_societe AND part_fgmm = '1' AND logo_sur_affiche = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "salon" :
							$intitule_tableau = "Tous les partenaires des Rencontres TICE";
							switch ($tri)
							{
								case "ID" :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY No_societe $sense_tri;";
									$query = "SELECT * FROM repertoire WHERE part_salon = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_salon = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_salon = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									//$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' AND part_fgmm = '1' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' AND part_fgmm = '1' ORDER BY societe ASC;";
									$query = "SELECT * FROM repertoire WHERE part_salon = '1' ORDER BY No_societe $sense_tri;";
								break;
							}
						break;

						case "salon_AT" :
							$intitule_tableau = "Les partenaires des Rencontres TICE &agrave; traiter";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.a_traiter = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.a_traiter = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.a_traiter = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "salon_CONT" :
							$intitule_tableau = "Les partenaires des Rencontres TICE contact&eacute;s";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.contacte = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.contacte = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND salon_suivi_partenaires.contacte = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "salon_INT" :
							$intitule_tableau = "Les partenaires des Rencontres TICE intéressés";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "salon_PART" :
							$intitule_tableau = "Les partenaires des Rencontres TICE qui participent";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "SALON_INT" :
							$intitule_tableau = "Les partenaires des Rencontres TICE intéressés par le salon";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_exposition = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "SALON_PART" :
							$intitule_tableau = "Les partenaires des Rencontres TICE qui participent au salon";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_exposition = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "salon_handicap" :
							$intitule_tableau = "Les partenaires des Rencontres TICE dans le parcours handicap";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND handicap = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND handicap = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND handicap = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "AGORA_INT" :
							$intitule_tableau = "Les partenaires des Rencontres TICE intéressés par l'agora";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_agora = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_agora = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND interesse_pour_agora = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "AGORA_PART" :
							$intitule_tableau = "Les partenaires des Rencontres TICE qui interviennent sur l'agora";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_agora = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_agora = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND participation_agora = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

						case "LOGO" :
							$intitule_tableau = "Les partenaires des Rencontres TICE qui auront leur logo sur l'affiche";
							switch ($tri)
							{
								case "ID" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND logo_sur_affiche = '1' ORDER BY No_societe $sense_tri;";
								break;

								case "SO" :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND logo_sur_affiche = '1' ORDER BY societe $sense_tri;";
								break;

								default :
									$query = "SELECT * FROM repertoire, salon_suivi_partenaires WHERE id_societe = No_societe AND part_salon = '1' AND logo_sur_affiche = '1' ORDER BY societe $sense_tri;";
								break;
							}
						break;

					} //Fin switch $filtre
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
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY No_societe $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY societe $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR ville LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR email LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR ville LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' OR email LIKE '%$rechercher%' AND emetteur <> '".$_SESSION['nom']."' AND statut = 'public' ORDER BY societe ASC;";
									break;
								}
							break;

							case "S" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM repertoire WHERE societe LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
									break;
								}
							break;

							case "V" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM repertoire WHERE VILLE LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR  VILLE LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
									break;
								}
							break;

							case "M" :
								switch ($tri)
								{
									case "ID" :
										$query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
									break;

									case "SO" :
										$query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
									break;

									default :
										$query = "SELECT * FROM repertoire WHERE EMAIL LIKE '%$rechercher%' AND emetteur = '".$_SESSION['nom']."' OR EMAIL LIKE '%$rechercher%' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
									break;
								}
							break;
						} //Fin switch $dans
					}
					else
					{
						switch ($tri)
						{
							case "ID" :
								$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
							break;

							case "SO" :
								$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
							break;

							default :
								$query = "SELECT * FROM repertoire WHERE emetteur = '".$_SESSION['nom']."' OR statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
							break;
						}
					} 
				break; //rechercher

				case "alpha" :
					switch ($tri)
					{
						case "ID" :
							$lettre = $lettre."%";
							$query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY No_societe $sense_tri;";
						break;

						case "SO" :
							$lettre = $lettre."%";
							$query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe $sense_tri;";
						break;

						default :
							$lettre = $lettre."%";
							if ($FGMM == "O")
							{
								$query = "SELECT * FROM repertoire WHERE part_fgmm = '1' AND societe LIKE '".$lettre."' ORDER BY societe ASC;";
							}
							else
							{
								$query = "SELECT * FROM repertoire WHERE societe LIKE '".$lettre."' AND emetteur = '".$_SESSION['nom']."' OR societe LIKE '".$lettre."' AND statut = 'public' AND emetteur <> '".$_SESSION['nom']."' ORDER BY societe ASC;";
							}

						break;
					}
				break;
			} //Fin switch origine_gestion
			//Affichage de la barre de recherche alphabétique 
			
			//echo "<br />query : $query";
			
			if ($FGMM <> "O" AND $salon <> "O")
			{
				AfficheRechercheAlphabet("SO","repertoire_gestion");
			}

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"repertoire_ajout_fiche.php?action=ajout_fiche\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/repertoire_ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer une nouvelle fiche\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvelle fiche</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

			//echo "<A HREF = \"repertoire_ajout_fiche.php?action=ajout_fiche\" class = \"bouton\">Insérer une nouvelle fiche</A>";
			
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
				echo "<h2>Nombre d'enregistrements s&eacute;lectionn&eacute;s : $num_results</h2>";
				echo "<TABLE width = \"95%\">
					<!--CAPTION>$intitule_tableau - Total participation financière&nbsp;:&nbsp;$total</CAPTION-->
					<CAPTION>$intitule_tableau</CAPTION>
					<TR>
						<th>";
						if ($sense_tri =="asc")
						{
							echo "NO<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=ID&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
						}
						else
						{
							echo "NO<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=ID&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par N° de société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
						}
						echo "</th>
						<th>";
						if ($sense_tri =="asc")
						{
							echo "INTITUL&Eacute;<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=SO&amp;sense_tri=desc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
						}
						else
						{
							echo "INTITUL&Eacute;<A href=\"repertoire_gestion.php?FGMM=$FGMM&amp;tri=SO&amp;sense_tri=asc&amp;indice=0\" target=\"body\"  title=\"Trier par société, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
						}
						echo "</th>
						<th>
							ADRESSE
						</th>
						<th>
							T&Eacute;L
						</th>
						<th>
							SITE WEB 
						</th>";
						if (($filtre == "SALON_INT") OR ($filtre == "SALON_PART"))
						{
							echo "<th>TS</th>";
							echo "<th>Empl.</th>";
						}
						echo "<th>
							<a title = \"à traiter\">AT</a>
						</th>
						<th>
							<a title = \"à faire\">AF</a>
						</th>
						<th>
							<a title = \"urgent\">UR</a>
						</th>
						<th>
							<a title = \"Partenaire d'au moins d'une édition du FGMM\">PG</a>
						</th>
						<th>
							<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/alerte.png\" border=\"0\" title = \"alertes\">
						</th>
						<th>
							<img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title = \"priv&eacute;\">
						</th>
						<th>
							ACTIONS
						</th>";

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
							echo "<a href = \"repertoire_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"page_a_cliquer\">1</a>&nbsp;";
							//echo "<A HREF = \"repertoire_gestion.php?FGMM=$FGMM&amp;indice=0\" target=\"body\" class=\"bouton\">1&nbsp;</A>";
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
								echo "&nbsp;<a href = \"repertoire_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"page_a_cliquer\">".$page."</a>&nbsp;";
								//echo "<A HREF = \"repertoire_gestion.php?FGMM=$FGMM&amp;indice=".$nb."\" target=\"body\" class=\"bouton\">".$page."&nbsp;</A>";
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
									echo "<TD align = \"center\">";
										echo $res[0];
									echo "</TD>";
									echo "<TD>";
										echo $res[1];
									echo "</TD>";
									echo "<TD>";
										echo $res[2]."<br>$res[3]"." ".$res[4];
									echo "</TD>";
									echo "<TD align=\"center\">";
										$tel = affiche_tel($res[5]);
										echo $tel;
									echo "</TD>";
									echo "<TD>";
										echo "<a href=\"$res[7]\" target=\"_blank\">$res[7]</a>";
									echo "</TD>";
									if (($filtre == "SALON_INT") OR ($filtre == "SALON_PART"))
									{
										echo "<TD align=\"center\">";
										if ($res[34] <> 0)
										{
											echo $res[34]; //Taille du stand
										}
										else
										{
											echo "&nbsp;"; //Taille du stand
										}
										echo "</TD>";
										echo "<TD align=\"center\">";
											echo $res[38]; //emplacement du stand
										echo "</TD>";
									}
									echo "<TD align=\"center\">";
									if ($res[10] == "1")
									{
										echo "X";
									}
									else
									{
										//echo "<input type=\"checkbox\" name=\"a_traiter\" value=\"Non\">";
									}
									echo "</TD>";
									echo "<TD align=\"center\">";
									if ($res[13] <> "")
									{
										echo "X";
									}
									else
									{
										//echo "<input type=\"checkbox\" name=\"a_faire\" value=\"Non\">";
									}
									echo "</TD>";
									echo "<TD align=\"center\">";
									if ($res[14] == "1")
									{
										echo "X";
									}
									else
									{
										//echo "&nbsp;";
									}
									echo "</TD>";
									echo "<TD align=\"center\">";
									if ($res[20] == "1")
									{
										echo "X";
									}
									else
									{
										//echo "&nbsp;";
									}
									echo "</TD>";
									$id_util = $_SESSION['id_util'];
									//echo "<br>N° société avant fct : $res[0]";
									verif_alerte_rep($res[0],$id_util);
									echo "</TD>";
									//echo "res[22] : $res[22]";
									if ($res[23] == "privé")
									{
										echo "<td align = \"center\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/confidentiel.png\" border=\"0\" title=\"priv&eacute;\"></td>";
									}
									else
									{
										echo "<td>&nbsp;</TD>";
									}
									//Les actions
									echo "<TD nowrap class = \"fond-actions\">";
										echo "&nbsp;<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=affichage&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/info.png\" ALT = \"consulter/traiter\" title=\"Consulter la fiche\" border = \"0\"></A>";
										echo "&nbsp;<A HREF = \"repertoire_consult_fiche.php?origine_ajout=$origine_ajout&amp;CHGMT=N&amp;id_societe=".$res[0]."&amp;action=modif&amp;affiche_FGMM=N\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"Modifier\" title=\"Modifier la fiche\" border = \"0\"></A>";
										echo "&nbsp;<A HREF = \"repertoire_ajout_ticket.php?origine_ajout=repertoire&amp;id_societe=".$res[0]."\" TARGET = \"body\" title=\"Ajouter un ticket\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/ticket_ajout.png\" ALT = \"Ajouter un ticket\" border = \"0\"></A>";
										if (($_SESSION['droit'] == "Super Administrateur") OR ($res[21] == $_SESSION['nom']))
										{
											echo "&nbsp;<A HREF = \"repertoire_suppression_fiche.php?origine_ajout=$origine_ajout&amp;id_societe=".$res[0]."\" TARGET = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" border = \"0\"></A>";
										}
									echo "</TD>";
								echo "</TR>";
							}
							$res = mysql_fetch_row($results);
						}
						//Fermeture de la connexion à la BDD
						mysql_close();
			} //Fin if ($num_results >0)
			else
			{
				echo "<h2> Recherche infructueuse, modifez les paramètres&nbsp;!</h2>";
			}
 ?>
			</TABLE>
		</div>
	</body>
</html>
