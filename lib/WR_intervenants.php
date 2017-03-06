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

	$theme = $_SESSION['chemin_theme']."WR_principal.css";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>Webradio intervenants</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="../../../ckeditor/ckeditor.js"></script>
<?php
		echo "<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
</head>
<body>

<?php
	$script = "intervenants";
	$test = include ("WR_menu_barre.php");
	echo "<div id = \"barre_module_22\">&nbsp;</div>";
	//echo "<div align = \"center\" class = \"espace_principal\">";
	echo "<div align = \"center\">";
	echo "<h1>Gestion des intervenant-e-s</h1>";
//include('../../biblio/fonctions_communes.php');

	//On récupère les variables
	$action = $_GET['action'];
	if (!ISSET($action))
	{
		$action = $_POST['action'];
	}

	$a_faire = $_GET['a_faire'];
	if (!ISSET($a_faire))
	{
		$a_faire = $_POST['a_faire'];
	}

	$choix_annee = $_GET['choix_annee'];
	if (!ISSET($choix_annee))
	{
		$choix_annee = $_POST['choix_annee'];
	}
	
	/*
	echo "<br />choix_annee : $choix_annee";
	echo "<br />action : $action";
	echo "<br />a_faire : $a_faire";
	*/
	//On connecte la base et charge les fonctions
	include ("../biblio/init.php");
	include ("../biblio/fct.php");

	//Les traitemants éventuels
	if ($action == 'O')
	{
		switch ($a_faire)
		{
			case "ajout_intervenant" :
				include ("WR_intervenants_ajout.inc.php");
				$affichage ='N';
			break;

			case "enreg_intervenant" :
				include("../biblio/init.php"); //On se connecte à la base
				//On récupère les variables
				$bouton_envoyer = $_POST['bouton_envoyer'];
				if ($bouton_envoyer <> "Retourner sans enregistrer")
				{
					$titre = $_POST['IntervenantTitre'];
					$sexe = $_POST['IntervenantSexe'];
					$nom = strtoupper($_POST['IntervenantNom']);
					$prenom = $_POST['IntervenantPrenom'];
					$adresse1 = $_POST['IntervenantAdresse1'];
					$adresse2 = $_POST['IntervenantAdresse2'];
					$cp = $_POST['IntervenantCodePostal'];
					$ville = $_POST['IntervenantVille'];
					$pays = $_POST['IntervenantPays'];
					$tel_fixe = $_POST['IntervenantTelFixe'];
					$tel_mobile = $_POST['IntervenantTelMobile'];
					$courriel = $_POST['IntervenantCourriel'];
					$remarques = $_POST['IntervenantRemarques'];
					
					//echo "<br />nom : $nom";
					//echo "<br />rne : $rne";

					//On échappe les caractères ', " avant d'enregistrer dans la base
					/*
					$nom = echappe_caracteres($nom); 
					$prenom = echappe_caracteres($prenom); 
					$fonction = echappe_caracteres($fonction); 
					$infos_contact = echappe_caracteres($infos_contact); 
					//$infos_personne = echappe_caracteres($infos_personne); 
					*/
					//On enregistre le tout
					$request="INSERT INTO WR_Intervenants (IntervenantTitre, IntervenantSexe, IntervenantNom, IntervenantPrenom, IntervenantAdresse1, IntervenantAdresse2, IntervenantCodePostal, IntervenantVille, IntervenantPays, IntervenantTelFixe, IntervenantTelMobile, IntervenantCourriel, IntervenantRemarques)
						values('".$titre."','".$sexe."','".$nom."','".$prenom."','".$adresse1."','".$adresse2."','".$cp."','".$ville."','".$pays."','".$tel_fixe."','".$tel_mobile."','".$courriel."','".$remarques."')";
					
					//echo "<br />$request";
					
					$result=mysql_query($request);
					if ($result)
					{
						echo "<h1>Intervenant-e enregistr&eacute;e</h1>";
					}
					else
					{
						echo "<h1>Probl&egrave;me de connection!</h1>";
					}
				}
			break;

			case "modifier" :
				echo "<h1>Modification d'un-e intervenant-e</h1>";
				
				$id_intervenant = $_GET['id_intervenant']; 
				include ("intervenants_modifier.inc.php");
				$affichage ='N';
			break;

			case "maj_intervenant" :
				$bouton_envoyer_modif = $_POST['bouton_envoyer_modif'];
				if ($bouton_envoyer_modif <> "Retourner sans enregistrer")
				{
					echo "<h1>L'intervenant-e a &eacute;t&eacute; mis-e &agrave; jour </h1>";
					//On récupère les variables
					$id_intervenant = $_POST['id_intervenant']; 
					$nom = strtoupper($_POST['nom']);
					$prenom = $_POST['prenom'];
					$fonction = $_POST['fonction'];
					$rne = $_POST['rne'];
					$infos_contact = $_POST['infos_contact'];
					$infos_personne = $_POST['infos_personne'];
					$mel = $_POST['mel'];
					$a_publier = $_POST['a_publier'];
					$OM = $_POST['OM'];
					$annee = $_POST['annee'];

					//echo "<br />OM : $OM";
					
					//On échappe les caractères ', " avant d'enregistrer dans la base
					/*
					$nom = echappe_caracteres($nom); 
					$prenom = echappe_caracteres($prenom); 
					$fonction = echappe_caracteres($fonction); 
					$infos_contact = echappe_caracteres($infos_contact); 
					//$infos_personne = echappe_caracteres($infos_personne); 
					*/

					//enregistrement dans la base 
					$requete_maj = "UPDATE WR_Intervenants SET 
						`nom` = '".$nom."',
						`prenom` = '".$prenom."',
						`fonction` = '".$fonction."',
						`rne` = '".$rne."',
						`infos_contact` = '".$infos_contact."',
						`infos_personne` = '".$infos_personne."',
						`mel` = '".$mel."',
						`a_publier` = '".$a_publier."',
						`OM` = '".$OM."',
						`annee` = '".$annee."'
					WHERE id = '".$id_intervenant."';";

					$result_maj = mysql_query($requete_maj);
					if (!$result_maj)
					{
						echo "<h2>Erreur lors de l'enregistrement</h2>";
					}
				}
			break;

			case "supprimer" :
				echo "<h1>Supprimer un-e intervenant-e</h1>";
				$id_intervenant = $_GET['id_intervenant']; 
				include ("intervenants_supprimer.inc.php");
				$affichage ='N';
			break;

			case "conf_supprimer" :
				$id_intervenant = $_GET['id_intervenant']; 
				$bouton_envoyer_suppression = $_GET['bouton_envoyer_suppression'];
				if ($bouton_envoyer_suppression <> "Retourner sans supprimer")
				{
					//On supprime définitivement
					$requete_suppression = "DELETE FROM WR_Intervenants WHERE id = '".$id_intervenant."'";
					$resultat_suppression = mysql_query($requete_suppression);
					if(!$resultat_suppression)
					{
						echo "<h2>Erreur</h2>";
					}
					else
					{
						echo "<h1>L'intervenant-e a &eacute;t&eacute; supprim&eacute;-e</h1>";
					}
					//On supprime égalmement toutes les références de participation à des événements
					$requete_suppression2 = "DELETE FROM WR_Intervenants_evenements WHERE id_intervenant = '".$id_intervenant."'";
					$resultat_suppression2 = mysql_query($requete_suppression2);
					if(!$resultat_suppression2)
					{
						echo "<h2>Erreur</h2>";
					}
					else
					{
						echo "<h1>L'intervenant-e a &eacute;t&eacute; d&eacute;t&acirc;ch&eacute;-e de tous les &eacute;v&eacute;nements</h1>";
					}
				}
			break;

			case "modifier_OM" :
				//echo "<h1>L'intervenant a &eacute;t&eacute; mis &agrave; jour </h1>";
				//On récupère les variables
				$id_intervenant = $_GET['id_intervenant']; 
				$OM = $_GET['OM'];

				if ($OM == "O")
				{
					$OM = "F";
				}
				else
				{
					$OM = "O";
				}

				//enregistrement dans la base 
				$requete_maj = "UPDATE WR_Intervenants SET 
					`OM` = '".$OM."'
				WHERE id = '".$id_intervenant."';";

				$result_maj = mysql_query($requete_maj);
				if (!$result_maj)
				{
					echo "<h2>Erreur lors de l'enregistrement</h2>";
				}
			break;
		} //Fin switch a_faire
	}
	
	

	if ($affichage <> "N")
	{
		///////////////////////////////////////////////////////////////////////////////////////////////
		//On affiche les liens pour les différentes commandes
		//echo "<p><A HREF = \"WR_intervenants.php?action=O&amp;a_faire=ajout_intervenant&amp;choix_annee=$choix_annee\" class = \"td-bouton-2\" TARGET = \"basefrm\"><IMG SRC = \"../../image/intervenants_ajout.png\" ALT = \"Ajout intervenant\" title=\"Ajouter un intervenant\" border = \"0\"></A></td>";

				echo "<div align = \"center\">";
					echo "<table class = \"menu-boutons\">";
						echo "<tr>";
							echo "<td>";
								echo "<a href = \"WR_intervenants.php?action=O&amp;a_faire=ajout_intervenant\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$chemin_theme_images/ajout.png\" ALT = \"Nouveau\" title=\"Ins&eacute;rer une nouvelle fiche\" align=\"top\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Nouvel-le intervenant-e</span><br />";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";

		$requete_types = "SELECT * FROM WR_Intervenants ORDER BY IntervenantNom,IntervenantPrenom";

		$results = mysql_query($requete_types);
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
			echo "<br /><TABLE WIDTH=95% BORDER=1 CELLPADDING=4 CELLSPACING=0>
			<COL WIDTH=5%>
			<!--COL WIDTH=5%-->
			<COL WIDTH=10%>
			<COL WIDTH=10%>
			<COL WIDTH=20%>
			<COL WIDTH=10%>
			<COL WIDTH=10%>
			<COL WIDTH=10%>
			<COL WIDTH=15%>
			<COL WIDTH=10%>
			<TR class = \"entete_tableau\">
				<th><P ALIGN=CENTER>ID</P></th>
				<!--th><P ALIGN=CENTER>Titre</P></th-->
				<th><P ALIGN=CENTER>Nom</P></th>
				<th><P ALIGN=CENTER>Pr&eacute;nom</P></th>
				<th><P ALIGN=CENTER>Adresse</P></th>
				<th><P ALIGN=CENTER>T&eacute;l fixe</P></th>
				<th><P ALIGN=CENTER>T&eacute;l mobile</P></th>
				<th><P ALIGN=CENTER>m&eacute;l</P></th>
				<th><P ALIGN=CENTER>Remarques</P></th>
				<th><P ALIGN=CENTER>Actions</P></th>
			</TR>";

			$requete_types = "SELECT * FROM WR_Intervenants ORDER BY IntervenantNom,IntervenantPrenom";
			$resultat_types = mysql_query($requete_types);
			while ($ligne = mysql_fetch_object($resultat_types))
			{
				$id = $ligne->idIntervenant;
				$titre = $ligne->IntervenantTitre;
				$sexe = $ligne->IntervenantSexe;
				$nom = $ligne->IntervenantNom;
				$prenom = $ligne->IntervenantPrenom;
				$adresse1 = $ligne->IntervenantAdresse1;
				$adresse2 = $ligne->IntervenantAdresse2;
				$cp = $ligne->IntervenantCodePostal;
				$ville = $ligne->IntervenantVille;
				$pays = $ligne->IntervenantPays;
				$tel_fixe = $ligne->IntervenantTelFixe;
				$tel_mobile = $ligne->IntervenantTelMobile;
				$courriel = $ligne->IntervenantCourriel;
				$remarques = $ligne->IntervenantRemarques;
				
				echo "<TR VALIGN=TOP>";
					echo "<TD align = \"center\">$id</TD>";
					//echo "<TD align = \"center\">$titre</TD>";
					echo "<TD>&nbsp;$nom</TD>";
					echo "<TD align = \"center\">$prenom</TD>";
					echo "<TD align = \"center\">";
						if ($adresse1 <> "")
						{
							echo "$adresse1<br />";
						}
						if ($adresse2 <> "")
						{
							echo "$adresse2<br />";
						}
						echo "$cp $ville";
					echo "</TD>";
					
					$tel_fixe = affiche_tel($tel_fixe);
					echo "<td align = \"center\">$tel_fixe</td>";
					$tel_mobile = affiche_tel($tel_mobile);
					echo "<TD align = \"center\">$tel_mobile</TD>";
					echo "<TD align = \"center\">$courriel</TD>";
					echo "<TD align = \"center\">$remarques</TD>";
					//Les actions
					echo "<TD class = \"fond-actions\">";
					/*
					echo "<A HREF = \"WR_intervenants.php?action=O&amp;a_faire=modifier&amp;id_intervenant=$id&amp;choix_annee=$choix_annee\" TARGET = \"basefrm\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" height=\"24px\" width=\"24px\" title=\"Modifier l'intervenant-e\"></A>";
					echo "&nbsp;<A HREF = \"WR_intervenants.php?action=O&amp;a_faire=supprimer&amp;id_intervenant=$id&amp;choix_annee=$choix_annee\" TARGET = \"basefrm\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" height=\"24px\" width=\"24px\" title=\"Supprimer l'intervenant-e\"></A>";
					*/
					echo "</td>";
				echo "</TR>";
			} //Fin while
			echo "</TABLE>";
		}
		else
		{
			echo "<h2> Recherche infructueuse, modifez les param&egrave;tres&nbsp;!</h2>";
		}

	}
	echo "</div>";
?>

<P CLASS="western" STYLE="margin-bottom: 0cm"><BR>
</P>
</body>
</html>
