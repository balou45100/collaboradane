<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
<SCRIPT>
 var index
 function sort_int(p1,p2) { return p1[index]-p2[index]; } //fonction pour trier les nombres
 function sort_char(p1,p2) { return ((p1[index]>=p2[index])<<1)-1; } //fonction pour trier les strings

 function TableOrder(e,Dec)  //Dec= 0:Croissant, 1:Décroissant
 { //---- Détermine : oCell(cellule) oTable(table) index(index cellule) -----//
 var FntSort = new Array()
 if(!e) e=window.event
 for(oCell=e.srcElement?e.srcElement:e.target;oCell.tagName!="TD";oCell=oCell.parentNode); //determine la cellule sélectionnée
 for(oTable=oCell.parentNode;oTable.tagName!="TABLE";oTable=oTable.parentNode); //determine l'objet table parent
 for(index=0;oTable.rows[0].cells[index]!=oCell;index++); //determine l'index de la cellule

 //---- Copier Tableau Html dans Table JavaScript ----//
 var Table = new Array()
 for(r=1;r<oTable.rows.length;r++) Table[r-1] = new Array()

 for(c=0;c<oTable.rows[0].cells.length;c++) //Sur toutes les cellules
 { var Type;
 objet=oTable.rows[1].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
 if(objet.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d$/)) { FntSort[c]=sort_char; Type=0; } //date jj/mm/aaaa
 else if(objet.match(/^[0-9£?$\.\s-]+$/)) { FntSort[c]=sort_int; Type=1; } //nombre, numéraire
 else { FntSort[c]=sort_char; Type=2; } //Chaine de caractère

 for(r=1;r<oTable.rows.length;r++) //De toutes les rangées
 { objet=oTable.rows[r].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
 switch(Type)
 { case 0: Table[r-1][c]=new Date(objet.substring(6),objet.substring(3,5),objet.substring(0,2)); break; //date jj/mm/aaaa
 case 1: Table[r-1][c]=parseFloat(objet.replace(/[^0-9.-]/g,'')); break; //nombre
 case 2: Table[r-1][c]=objet.toLowerCase(); break; //Chaine de caractère
 }
 Table[r-1][c+oTable.rows[0].cells.length] = oTable.rows[r].cells[c].innerHTML
 }
 }

 //--- Tri Table ---//
 Table.sort(FntSort[index]);
 if(Dec) Table.reverse();

 //---- Copier Table JavaScript dans Tableau Html ----//
 for(c=0;c<oTable.rows[0].cells.length;c++) //Sur toutes les cellules
 for(r=1;r<oTable.rows.length;r++) //De toutes les rangées
 oTable.rows[r].cells[c].innerHTML=Table[r-1][c+oTable.rows[0].cells.length];  
 }
 </SCRIPT>
<?php
	echo "</head>";
			//Inclusion des fichiers nécessaires
			//include ("../biblio/init.php");
			include ("../biblio/config.php");
	echo "<body>";
	$page_appelant = "om";
	echo "<div align = \"center\">";
		echo "<h1>Gestion des ordres de mission</h1>";

		//include ("om_menu_principal.inc.php");

		$path_parts = pathinfo($_SERVER['PHP_SELF']);
		$page = $path_parts['basename'];

		$_SESSION['page']=$page;
		//Initialisation de la chaîne complémentaire pour la requ$ete
		$plus="";
		
		//On récupère des variables pour les traitements
		$actions_courantes = $_GET['actions_courantes']; //On doit faire une action sur un OM (modifier, changer affectation, ...
		$a_faire = $_GET['a_faire']; //sur une ligne du tableau (modifier, changer d'affectation,...
		$tri = $_GET['tri']; //Tri sur quelle colonne ?

		echo "<br />actions_courantes : $actions_courantes";
		echo "<br />a_faire : $a_faire";
		echo "<br />tri : $tri";
		
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////Début des actions à faire avant affichage //////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
		if ($actions_courantes == "O")
		{
			$id = $_GET['id'];
			//echo "<br>id : $id";
			switch ($a_faire)
			{
				case "changer_etat" :
					$id_etat = $_GET['id_etat'];
					/*
					echo "<br />id_etat : $id_etat";
					echo "<br />id : $id";
					*/
					$requete_ce = "UPDATE om_suivi_om SET `etat_om` = '".$id_etat."' WHERE RefOM='".$id."'";
					$result_ce = mysql_query($requete_ce);
					if (!$result_ce)
					{
						echo "<h2>Erreur lors de l'enregistrement</h2>";
					}
				break; //changement d'etat

				case "changer_etat_traitement" :
					$id_etat = $_GET['id_etat'];
					/*
					echo "<br />id_etat : $id_etat";
					echo "<br />id : $id";
					*/
					$requete_ce = "UPDATE om_ordres_mission SET `etat_traite` = '".$id_etat."' WHERE RefOM='".$id."'";
					$result_ce = mysql_query($requete_ce);
					if (!$result_ce)
					{
						echo "<h2>Erreur lors de l'enregistrement</h2>";
					}
				break; //changement d'etat

			} //Fin switch $a_faire
		} //Fin if actions_courantes == O


		if(isset($_POST['validRecherche_om']))
		{
			$etat=$_POST['etat'];
			$personne=$_POST['searchpers'];
			$etat_om=$_POST['etat_om'];
			$annee=$_POST['searchannee'];
		}
		else
		{
			if (!ISSET($etat))
			{
				$etat=$_GET['etat'];
			}
		}
		/*
		echo "<br />personne : $personne";
		echo "<br />annee : $annee";
		echo "<br />etat : $etat";
		echo "<br />etat_om : $etat_om";
		echo "<br />";
		*/

		//On compose le complément de la requête si les filtres sont activés
		if ($annee == "%" OR (!ISSET($annee)))
		{
			$plus=" AND nom like '%$personne%' AND etat_om LIKE'%$etat_om%'";
		}
		else
		{
			$plus=" AND nom like '%$personne%' AND etat_om LIKE'%$etat_om%' AND annee = '$annee'";
		}

		if ($etat == "%" OR (!ISSET($etat)))
		{
			$plus_etat="";
		}
		else
		{
			$plus_etat=" AND etat_traite='$etat'";
		}

		if(isset($_POST['validDate']))
		{
			$date=$_POST['date'];
			$date_angl=date("Y-m-d", strtotime($date));
			$plus="and date_horaire_debut like '%$date_angl%' ";
		}

		$requete_SuiviOM="SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion ;";
		
		//echo "<br />$requete_SuiviOM";
		
		$result4=mysql_query($requete_SuiviOM);


		//=========================================

		// initialisation des variables 

		//=========================================

		// on va afficher 5 résultats par page.
		require 'om_fonctions.php';

		//$nombre = 15000; // nombre de traitement par pages ICI //

		// si limite n'existe pas on l'initialise à zéro

		if (!$limite) $limite = 0; 

		// on cherche le nom de la page.    

		$path_parts = pathinfo($_SERVER['PHP_SELF']);

		$page = $path_parts['basename'];

		//=========================================    
		// requête SQL qui compte le nombre total 
		// d'enregistrements dans la table.
		//=========================================
/*
		$select = "SELECT count(*) FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion ;";
		$result = mysql_query($select);
		$row = mysql_fetch_row($result);
		$total = $row[0];

		//=========================================
		// vérifier la validité de notre variable 
		// $limite;
		//=========================================

		$verifLimite= verifLimite($limite,$total,$nombre);

		// si la limite passée n'est pas valide on la remet à zéro

		if(!$verifLimite)
		{
			$limite = 0;
		}

		//=========================================
*/
		// requête SQL qui ne prend que le nombre 
		// d'enregistrement necessaire à l'affichage.
		//=========================================
		
		//On tri
		switch ($tri)
		{
			case "ID" :
				$query_tri = " ORDER BY personnes_ressources_tice.RefOM $sense_tri;";
			break;
				case "DEN" :
				$query_tri = " ORDER BY materiels.denomination $sense_tri;";
			break;
				case "CAT" :
				$query_tri = " ORDER BY materiels_categories_principales.intitule_cat_princ $sense_tri;";
			break;

			case "ORI" :
				$query_tri = " ORDER BY materiels_origine.intitule_origine $sense_tri;";
			break;

			default :
				$query_tri = " ORDER BY personnes_ressources_tice.nom ASC;";
			break;
		}

		//$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion ".$plus." ORDER BY nom ASC limit ".$limite.",".$nombre.";";
		//$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om where om_ordres_mission.RefOM=om_suivi_om.RefOM and personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress and om_ordres_mission.idreunion=om_reunion.idreunion ".$plus.$plus_etat." ORDER BY nom ASC;";
		$select = "SELECT *, DATE_FORMAT(date_horaire_debut, '%d-%m-%Y') AS Date_D, DATE_FORMAT(Date_horaire_debut, '%H:%i') AS Heure_D, DATE_FORMAT(date_horaire_fin, '%d-%m-%Y') AS Date_F, DATE_FORMAT(Date_horaire_fin, '%H:%i') AS Heure_F 
			FROM personnes_ressources_tice, om_reunion, om_ordres_mission, om_suivi_om 
			WHERE om_ordres_mission.RefOM=om_suivi_om.RefOM
				AND personnes_ressources_tice.id_pers_ress=om_ordres_mission.id_pers_ress
				AND om_ordres_mission.idreunion=om_reunion.idreunion ".$plus.$plus_etat.$query_tri;"";

		echo "<br >$select";

		$result = mysql_query($select);
		$total = mysql_num_rows($result);
		//=========================================    
		// si on a récupéré un resultat on l'affiche.
		//=========================================

		//=========================================    
		// si le nombre d'enregistrement à afficher 
		// est plus grand que $nombre 
		//=========================================

		//echo "<br />total : $total";
/*
		if($total > $nombre)
		{
			$limite_actuelle=$limite;
			// affichage des liens vers les pages

			//affichePages($nombre,$page,$total,$limite_actuelle);

			// affichage des boutons

			//displayNextPreviousButtons($limite,$total,$nombre,$page);
		}
		//echo "<BR />";
*/
		if($total)
		{
			echo "<h2>Nombre d'enregistrements : $total</h2>";
			// début du tableau


			echo "<table border id=trier>";
			echo "<TR class=title >"; 
				echo "<th>";
					if ($sense_tri =="asc")
					{
						echo "R&eacute;f. OM<A href=\"om_affichage_om.php?tri=ID&amp;sense_tri=desc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par r&eacute;f&acute;rence, ordre decroissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_desc.png\" border=\"0\"></A>";
					}
					else
					{
						echo "ID<A href=\"om_affichage_om.php?tri=ID&amp;sense_tri=asc&amp;indice=0&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"Trier par r&eacute;f&acute;rence, ordre croissant\"><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\" border=\"0\"></A>";
					}
				echo "</th>";

				//echo "<th align=center>R&eacute;f. OM</th>";
				echo "<th align=center>Personnes<BR /><p><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/DSC.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\"></span></p></th>
				<th align=center>R&eacute;union<BR /><p><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/DSC.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\"></span></p></th>
				<th align=center>R&eacute;f. Ulysse OM<BR /><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/DSC.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\"></span></th>
				<th align=center>&Eacute;tat traitement OM<BR /><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/DSC.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\"></span></th>
				<th align=center>Date OM<BR /><p><span onclick=TableOrder(event,1)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/DSC.png\"></span><span onclick=TableOrder(event,0)><img height=\"$hauteur_icone_tri\" width=\"$largeur_icone_tri\" src = \"$chemin_theme_images/tri_asc.png\"></span></p></th>
				<th align=center>&Eacute;tat OM</th>
				<th align=center>Motif OM</th>
				<th align=center>Actions sur l'EF</th>
				<th align=center>Actions sur la relance</th>
				<th align=center>Autres actions</th>";
			echo "</TR>";

			while($ligne4=mysql_fetch_array($result))
			{
				$id = $ligne4['RefOM'];
				echo "<TR>";
					echo "<TD align=\"center\">".$ligne4['RefOM']."</TD>
					<TD align=\"center\">".$ligne4['nom']." ".$ligne4['prenom']."</TD>
					<TD align=\"center\">".$ligne4['intitule_reunion']." <br />".$ligne4['Date_D']." ".$ligne4['Heure_D']." <br />".$ligne4['Date_F']." ".$ligne4['Heure_F']."</TD>
					<TD align=\"center\">".$ligne4['RefUlysse_om']."</TD>";

					echo "<TD align=\"center\">";
						if ($ligne4['etat_traite']<>"0")
						{
							echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat_traitement&amp;id=$id&amp;id_etat=0&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"non trait&eacute;\">NT&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"non trait&eacute;\"><FONT COLOR = \"#000000\"><B><big>NT&nbsp;</big></B></FONT></a>";
						}

						if ($ligne4['etat_traite']<>"1")
						{
							echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat_traitement&amp;id=$id&amp;id_etat=1&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"trait&eacute;\">T&nbsp;</A>";
						}
						else
						{
							echo "<a title = \"trait&eacute;\"><FONT COLOR = \"#000000\"><B><big>T&nbsp;</big></B></FONT></a>";
						}

					echo "</TD>";

/*
				if($ligne4['etat_traite']==0)
				{
					echo "<TD align=\"center\"><p id=non_traite>Non trait&eacute;</p></TD>";
				}
				else
				{
					if($ligne4['etat_traite']==1)
					{
						echo "<TD align=\"center\"><p id=traite>Trait&eacute;</p></TD>";
					}
				}
*/
				$DateV=date("d-m-Y", strtotime($ligne4['date_om']));
				echo "	<TD align=\"center\">".$DateV."</TD>";

				//Affichage de l'état avec lien pour le changement
				echo "<TD align=\"center\">";
				if ($ligne4['etat_om']<>"AC")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=AC&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"&agrave; convoquer\">AC&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"&agrave; convoquer\"><FONT COLOR = \"#000000\"><B><big>AC&nbsp;</big></B></FONT></a>";
				}

				if ($ligne4['etat_om']<>"C")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=C&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"convoqu&eacute;-e\">C&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"convoqu&eacute;-e\"><FONT COLOR = \"#000000\"><B><big>C&nbsp;</big></B></FONT></a>";
				}

				if ($ligne4['etat_om']<>"P")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=P&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"pr&eacute;sent-e\">P&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"pr&eacute;sent-e\"><FONT COLOR = \"#000000\"><B><big>P&nbsp;</big></B></FONT></a>";
				}

				if ($ligne4['etat_om']<>"A")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=A&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"absent-e\">A&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"absent-e\"><FONT COLOR = \"#000000\"><B><big>A&nbsp;</big></B></FONT></a>";
				}

				if ($ligne4['etat_om']<>"V")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=V&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"valid&eacute;-e\">V&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"valid&eacute;-e\"><FONT COLOR = \"#000000\"><B><big>V&nbsp;</big></B></FONT></a>";
				}

				if ($ligne4['etat_om']<>"R")
				{
					echo "<A href=\"om_affichage_om.php?actions_courantes=O&amp;a_faire=changer_etat&amp;id=$id&amp;id_etat=R&amp;etat=$etat&amp;tri=$tri&amp;sense_tri=$sense_tri&amp;indice=$indice&amp;rechercher=".$rechercher."&amp;dans=".$dans."\" target=\"body\"  title=\"refus&eacute;-e\">R&nbsp;</A>";
				}
				else
				{
					echo "<a title = \"refus&eacute;-e\"><FONT COLOR = \"#000000\"><B><big>R&nbsp;</big></B></FONT></a>";
				}

				echo "</TD>";
				
				//Ancien affichage
				/*
				if($ligne4['etat_om']=="C")
				{
					$couleur="convoque";
					//$affich="convoqué";
					$affich="C";
				}
				else
				{
					if($ligne4['etat_om']=="P")
					{
						$couleur="present";
						//$affich="présent";
						$affich="P";
					}
					else
					{
						if($ligne4['etat_om']=="A")
						{
							$couleur="absent";
							//$affich="absent";
							$affich="A";
						}else{
							if($ligne4['etat_om']=="V"){
							$couleur="valide";
							//$affich="validé";
							$affich="V";
							}else{
								if($ligne4['etat_om']=="R"){
								$couleur="refuse";
								//$affich="refusé";
								$affich="R";
								}
							}
						}
					}
				}
				
				echo "<TD align=\"center\"><p id=".$couleur.">".$affich."</p></TD>";
				*/
				echo "<TD align=\"center\">".$ligne4['motif_om']."</TD>
				<TD align=\"center\">";
				
				$valeur_om=$ligne4['RefOM'];
				$requete_trouve="SELECT RefOM, RefEF FROM om_etat_frais where RefOM=$valeur_om ;";
				$result5=mysql_query($requete_trouve);
				$ligne5=mysql_fetch_assoc($result5);
				
				if(!$ligne5['RefEF']==''){
				echo "<FORM method=\"post\" action=\"om_affichage_etatdefrais_suivantom.php\">
				<input type=\"hidden\" name=\"REFOM_recup1\" value=\"".$valeur_om."\" />
				<input type=\"submit\" name=\"ok1\" value=\"Affichage EF\" />
				</FORM>";
				}else{
				echo "Aucun etat de frais enregistré";
				echo "<FORM method=\"post\" action=\"om_ajout_ef.php\">
				<input type=\"hidden\" name=\"REFOM_recup\" value=\"".$ligne4['RefOM']."\" />
				<input type=\"submit\" name=\"ok\" value=\"Ajout EF\" />
				</FORM></TD>";
				}
				
				$requete_Relance="SELECT RefOM, id_relance FROM om_relance where RefOM=$valeur_om ;";
				$result_Relance=mysql_query($requete_Relance);
				$ligne_Relance=mysql_fetch_assoc($result_Relance);
				echo "<TD align=\"center\">";
				if(!$ligne_Relance['RefOM']==''){
				echo "
				<FORM method=\"post\" action=\"om_affichage_relance_SelonOM.php\">
				<input type=\"hidden\" name=\"REFOM\" value=\"".$ligne4['RefOM']."\" />
				<input type=submit name=\"AffichR\" value=\"Affichage Relance\" />
				</FORM>";
				
				echo "<FORM method=\"post\" action=\"om_ajout_relance.php\">
				<input type=\"hidden\" name=\"REFOM\" value=\"".$ligne4['RefOM']."\" />
				<input type=\"submit\" name=\"Envoi Relance\" value=\"Envoi R\" />
				</FORM>
				";
				}else{
				echo "Aucune relance enregistrée
				<FORM method=\"post\" action=\"om_ajout_relance.php\">
				<input type=\"hidden\" name=\"REFOM\" value=\"".$ligne4['RefOM']."\" />
				<input type=\"submit\" name=\"Envoi Relance\" value=\"Envoi R\" />
				</FORM>
				";
				}
				echo "</TD>";
				echo "
				<TD align=\"center\">
				<FORM method=\"post\" action=\"om_edition_1er.php\">
				<input type=\"hidden\" name=\"REFOM\" value=\"".$ligne4['RefOM']."\" />
				<input type=\"submit\" name=\"Envoi Relance\" value=\"Edition\" />
				</FORM>
				";
				echo "<FORM method=\"post\" action=\"om_maj_om.php\"><input type=\"hidden\" name=\"REFOM_recup1\" value=\"".$valeur_om."\" />
				<input type=\"submit\" name=\"ok2\" value=\"Mise à Jour OM\" /></FORM>";
				echo "</TD>";
				echo "</TR>";
			}
			echo "</TABLE>";

		}

		else echo "Pas d'enregistrements dans cette table...";

		//mysql_free_result($result);

?>
</div>
</body>
</HTML>
