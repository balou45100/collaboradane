<?php
	//Liste et d&eacute;veloppement des fonctions cr&eacute;&eacute;s et utilis&eacute;es dans les diff&eacute;rents scripts
	//echo "<br />fct.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction statut
	//@in $statut: Initial d&eacute;finissant le statut d'un message
	//@out text: Caract&eacute;risant le statut, utilis&eacute; dans la balise style
	function statut($statut)
	{
		if($statut == "N") return "new";
		if($statut == "M") return "modif";
		if($statut == "A") return "archi";
		if($statut == "R") return "reponse";
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction DROIT
	//@in $droit: Droit de l'utilisateur logu&eacute;
	//@out text: Raccourcissant la d&eacute;nomination du statut
	function droit($droit)
	{
		if($droit == "Utilisateur") return "user";
		if($droit == "Super Administrateur") return "admin";
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction dep
	//@in $dep: Les deux premiers chiffres du code postal de l'&eacute;tablissement
	//@out text: D&eacute;finissant le nom du d&eacute;partement correspondant &agrave; $dep, utilis&eacute; dans la balise style	
	function dep($dep){
		if($dep == "45") return "loiret";
		if($dep == "37") return "indre_loire";
		if($dep == "18") return "cher";
		if($dep == "28") return "eure_loire";
		if($dep == "36") return "indre";
		if($dep == "41") return "loire_cher";
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction navigation
	//&eacute;tat de prototype ne marchant pas donc non utilis&eacute;
	//But faciliter la navigation dans les cat&eacute;gories sous forme de ./nom_categ/nom_categ
	function navigation($tab, $dossier){
		$nb = count($tab);
		$tab[$nb + 1] = $dossier;
		$tab[$nb + 2] = "/";
		$dossier1 = "/".$dossier;
		$nb = count($tab);
		return $dossier1 = $dossier1."/".$nb;	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction suppr_r
	//@in $id_categ: l'identifiant de la cat&eacute;gorie &agrave; supprimer
	//@out text: Synth&eacute;tisant la r&eacute;ussite ou l'echec de la suppression d'une cat&eacute;gorie et de ses sous-cat&eacute;gories
	function suppr_r($id_categ)
	{
		//Requ&egrave;te pour s&eacute;l&eacute;ctionner toutes les cat&eacute;gories qui ont pour p&egrave;re celle que l'on veut supprimer
		//afin de voir si'il y a des sous dossier
		$query = "SELECT * FROM categorie WHERE ID_CATEG_PERE = '".$id_categ."';";
		$result = mysql_query($query);
		//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
		if(!$result)
		{
			echo "1 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
			echo "<br /> <a href = \"gestion_categories.php?id_categ=-1\" target = \"body\">Retour &agrave; la Gestion des cat&eacute;gories</a>";
			mysql_close();
			exit;
		}
		//R&eacute;cup&eacute;ration des r&eacute;sultats dans une table des r&eacute;sultats
		$res = mysql_fetch_row($result);
		//Si il n'y a pas de valeur dans la premi&egrave;re case du tableau alors c'est qu'il n'y a pas de sous-dossier
		if($res[0] == "")
		{
			//Requ&egrave;te proc&eacute;dant &agrave; la suppression du dossier
			$query_suppression = "DELETE FROM categorie WHERE ID_CATEG = '".$id_categ."';";
			$result = mysql_query($query_suppression);
			//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
			if(!$result)
			{
				echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
				echo "<br /> <a href = \"gestion_categories.php?id_categ=-1\" target = \"body\">Retour &agrave; la Gestion des cat&eacute;gories</a>";
				mysql_close();
				exit;
			}
		}
		//Sinon on proc&egrave;de r&eacute;cursivement &agrave; la suppression des sous-dossiers en r&eacute;-injectant dans la fonction
		//le num de la sous-cat&eacute;gorie et la cat&eacute;gorie p&egrave;re
		else
		{
			suppr_r($res[0]);
			suppr_r($id_categ);
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonctionne qui permet de supprimer un ticket avec ses r&eacute;ponses de la table probleme
	function suppr_t($idpb,$origine)
	{
		//echo "<br />Bienvenu dans la fonction suppr_t pour supprimer le ticket $idpb<br />";
		//echo "Je viens de $origine<br />";
		//Requ&egrave;te pour s&eacute;l&eacute;ctionner toutes les r&eacute;ponses qui ont pour p&egrave;re celui que l'on veut supprimer
		//afin de voir si'il y a des r&eacute;ponses
		switch ($origine)
		{
			case "sup_ticket":
				//suppression du ticket 'p&egrave;re'
				$query = "SELECT * FROM probleme WHERE ID_PB = '".$idpb."';";
				$result = mysql_query($query);
				//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
				if(!$result)
				{
					echo "1 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
					echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des tickets</a>";
					mysql_close();
					exit;
				}

				//Requ&egrave;te proc&eacute;dant &agrave; la suppression du ticket
				//echo "Je vais supprimer le ticket $idpb<br />";
				$query_suppression = "DELETE FROM probleme WHERE ID_PB = '".$idpb."';";
				$result = mysql_query($query_suppression);
				//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
				if(!$result)
				{
					echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
					echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des tickets</a>";
					mysql_close();
					exit;
				}
				//suppression des r&eacute;ponses
				$query_suppression = "DELETE FROM probleme WHERE ID_PB_PERE = '".$idpb."';;";
				$result = mysql_query($query_suppression);

				//suppressions des alertes
				$query_suppression = "DELETE FROM alertes WHERE id_ticket = '".$idpb."';;";
				$result = mysql_query($query_suppression);

				//suppression des intervenants du ticket
				$query_suppression = "DELETE FROM intervenant_ticket WHERE id_tick = '".$idpb."';;";
				$result = mysql_query($query_suppression);

				//suppression des cat&eacute;gories communes du ticket
				$query_suppression = "DELETE FROM categorie_commune_ticket WHERE id_ticket = '".$idpb."';;";
				$result = mysql_query($query_suppression);

				//suppression des cat&eacute;gories personnelles du ticket
				$query_suppression = "DELETE FROM categorie_personnelle_ticket WHERE id_pb = '".$idpb."';;";
				$result = mysql_query($query_suppression);
			break;

			case "sup_reponse" :
				//Suppression d'une r&eacute;ponse
				$query_suppression = "DELETE FROM probleme WHERE ID_PB = '".$idpb."';";
				$result = mysql_query($query_suppression);
		    break;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonctionne qui nettoie les cat&eacute;gories d'un ticket supprim&eacute;
	function nettoie_categ($idpb,$origine)
	{
		//echo "<br />Bienvenu dans la fonction nettoie_categ pour supprimer le ticket $idpb";
		//echo "<br />J'arrive de $origine";

		//On supprime tous les r&eacute;f&eacute;rences de cat&eacute;gorie dans la table jointe categorie_personnelle_ticket
		$query_supp="DELETE FROM categorie_personnelle_ticket WHERE id_pb = '".$idpb."';";
		$result_supp = mysql_query($query_supp);

		//On supprime toutes les r&eacute;f&eacute;rences dans le champ ID_PB_CATEG
		$query="SELECT ID_CATEG, ID_PB_CATEG FROM categorie WHERE ID_PB_CATEG LIKE '%".$idpb."%';";
		$result = mysql_query($query);

		if(!$result)
		{
			echo "<br />2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
			//echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des tickets</a>";
			mysql_close();
			exit;
		}
		$res_cat = mysql_fetch_row($result);
		if($res_cat[0] <> "")
		{
			//Il faut regarder chaque enregistrement et supprimer la r&eacute;f&eacute;rence au ticket
			//echo "<br />avant l'affectation du tableau";
			//echo "<br />N° cat&eacute;gorie : $res_cat[0]";
			//echo "<br />Tickets dans cette cat&eacute;gorie : $res_cat[1]<br />";
			$chaine_a_modifier = $res_cat[1];
			$chaine_a_supprimer="$idpb".";";
			//echo "<br />Chaine &agrave; supprimer : $chaine_a_supprimer<br />";
			//echo "<br />Chaine &agrave; modifier : $chaine_a_modifier<br />";
			$chaine_modifiee = ereg_replace($chaine_a_supprimer,'', $chaine_a_modifier);
			//echo "<br />Chaine &agrave; enregistrer apr&egrave;s traitement : $chaine_modifiee<br />";

			//Requ&egrave;te proc&eacute;dant &agrave; la mise &agrave; jour de la cat&eacute;gorie
			$query_modif = "UPDATE categorie SET
				ID_PB_CATEG = '$chaine_modifiee'
				WHERE ID_CATEG = '$res_cat[0]';";
			$results_modif = mysql_query($query_modif);

			//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
			if(!$results_modif)
			{
				echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
				echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des cat&eacute;gories</a>";
				mysql_close();
				exit;
			}
			nettoie_categ($idpb,fonction); 
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function sup_ticket_categ($idpb,$id_categ)
	{
		/*
		echo "<br />Bienvenu dans la fonction sup_ticket_categ pour enlever le ticket $idpb de la cat&eacute;gorie $id_categ";
		echo "<br />J'arrive de $origine";
		echo "<br />N° du ticket : $idpb";
		echo "<br />Cat&eacute;gorie : $id_categ";
		*/
		//On supprime la cat&eacute;gorie dans la table jointe categorie_personnelle_ticket
		$query_supp="DELETE FROM categorie_personnelle_ticket WHERE id_pb = '".$idpb."' AND id_categ = '".$id_categ."';";
		$result_supp = mysql_query($query_supp);

		$query="SELECT ID_CATEG, ID_PB_CATEG FROM categorie WHERE ID_CATEG = '".$id_categ."';";
		$result = mysql_query($query);

		if(!$result)
		{
			echo "<br />2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
			//echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des tickets</a>";
			mysql_close();
			exit;
		}
		$res_cat = mysql_fetch_row($result);
		//echo "<br />avant l'affectation du tableau";
		//echo "<br />N° cat&eacute;gorie : $res_cat[0]";
		//echo "<br />Tickets dans cette cat&eacute;gorie : $res_cat[1]<br />";
		$chaine_a_modifier = $res_cat[1];
		$chaine_a_supprimer="$idpb".";";

		//echo "<br />Chaine &agrave; supprimer : $chaine_a_supprimer<br />";
		//echo "<br />Chaine &agrave; modifier : $chaine_a_modifier<br />";
		$chaine_modifiee = ereg_replace($chaine_a_supprimer,'', $chaine_a_modifier);
		//echo "<br />Chaine &agrave; enregistrer apr&egrave;s traitement : $chaine_modifiee<br />";

		//Requ&egrave;te proc&eacute;dant &agrave; la mise &agrave; jour de la cat&eacute;gorie
		$query_modif = "UPDATE categorie SET
			ID_PB_CATEG = '$chaine_modifiee'
			WHERE ID_CATEG = '$res_cat[0]';";
		$results_modif = mysql_query($query_modif);

		//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
		if(!$results_modif)
		{
			echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
			echo "<br /> <a href = \"gestion_ticket.php?tri=G&amp;indice=0\" target = \"body\">Retour &agrave; la Gestion des cat&eacute;gories</a>";
			mysql_close();
			exit;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonction date_d
	//@in rien
	//@out date_heure: Date et heure de la journ&eacute;e
	function date_d()
	{
		switch(date('l'))
		{
			case 'Monday':
			$day = "Lundi";
			break;
				
			case 'Tuesday':
			$day = "Mardi";
			break;
					
			case 'Wednesday':
			$day = "Mercredi";
			break;
					
			case 'Thursday':
			$day = "Jeudi";
			break;
					
			case 'Friday':
			$day = "Vendredi";
			break;
					
			case 'Saturday':
			$day = "Samedi";
			break;
					
			case 'Sunday':
			$day = "Dimanche";
			break;
					
			default :
			$day = "unknown";
			break;
		}
		switch(date('F'))
		{
			case 'January':
				$month = "Janvier";
			break;

			case 'Frebruary':
				$month = "F&eacute;vrier";
			break;

			case 'March':
				$month = "Mars";
			break;

			case 'April':
				$month = "Avril";
			break;

			case 'May':
				$month = "Mai";
			break;

			case 'June':
				$month = "Juin";
			break;

			case 'July':
				$month = "Juillet";
			break;

			case 'August':
				$month = "Août";
			break;

			case 'September':
				$month = "Septembre";
			break;

			case 'October':
				$month = "Octobre";
			break;

			case 'November':
				$month = "Novembre";
			break;

			case 'December':
				$month = "D&eacute;cembre";
			break;

			default :
				$day = "unknown";
			break;
		}
		$nb = date('j');
		$annee = date('Y');
		$heure_min_sec = date('G:i:s');
				
		$aujourdhui = "<br /><br />Nous sommes le ".$day." ".$nb." ".$month."<br /><br /> il est ".$heure_min_sec;
				
		return $aujourdhui;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function gen_mot_passe($id_util,$mel)
	{
		$tableau = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", "x", "X", "y", "Y", "z", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		$valeurs_aleatoires = array_rand($tableau, 6);

		$mot_de_passe = "";

		foreach($valeurs_aleatoires as $i)
		{
			$mot_de_passe = $mot_de_passe . $tableau[$i];
		}
		RETURN $nouveau_mot_de_passe=$mot_de_passe;
		//echo "<br />mot de passe g&eacute;n&eacute;r&eacute; : $mot_de_passe";
		/*
		$query = "UPDATE util SET PASSWORD = '".md5($mot_de_passe)."' WHERE NOM = '".$util."' AND MAIL = '".$mel."';";
		$results = mysql_query($query);
		*/
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function Testpourcocher($variable)
	{
		if ($variable=="1") {
			$checked="checked";
		}
		else
		{
			$checked="";
		}
		return($checked);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function Formatage_Nombre($nombre,$monnaie)
	{
		if ($nombre < 1000)
		{
			$nombre_a_afficher = $nombre." ".$monnaie;
		}
		if (($nombre > 999) AND ($nombre < 10000))
		{
			$nombre_a_afficher = substr($nombre, 0, 1)." ".substr($nombre, 1, 4)." ".$monnaie;
		}
		if (($nombre > 9999) AND ($nombre < 100000))
		{
			$nombre_a_afficher = substr($nombre, 0, 2)." ".substr($nombre, 2, 5)." ".$monnaie;
		}
		if (($nombre > 99999) AND ($nombre < 1000000))
		{
			$nombre_a_afficher = substr($nombre, 0, 3)." ".substr($nombre, 3, 5)." ".$monnaie;
		}
		if (($nombre > 999999) AND ($nombre < 10000000))
		{
			$nombre_a_afficher = substr($nombre, 0, 1)." ".substr($nombre, 1, 3)." ".substr($nombre, 4, 5)." ".$monnaie;
		}
		if (($nombre > 9999999) AND ($nombre < 100000000))
		{
			$nombre_a_afficher = substr($nombre, 0, 2)." ".substr($nombre, 2, 3)." ".substr($nombre, 5, 5)." ".$monnaie;
		}
		if (($nombre > 99999999) AND ($nombre < 1000000000))
		{
			$nombre_a_afficher = substr($nombre, 0, 3)." ".substr($nombre, 3, 3)." ".substr($nombre, 6, 5)." ".$monnaie;
		}
		return($nombre_a_afficher);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function DeFormatage_Nombre($nombre,$monnaie)
	{
		$nombre = str_replace(' '.$monnaie, '', $nombre);
		$nombre = str_replace(' ', '', $nombre);
		return($nombre);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function AfficheRechercheAlphabet($tri,$fichier)
	{
		echo "<table class = \"menu-boutons\">
			<tr>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=A&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'A'\">&nbsp;A&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=B&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'B'\">&nbsp;B&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=C&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'C'\">&nbsp;C&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=D&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'D'\">&nbsp;D&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=E&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'E'\">&nbsp;E&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=F&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'F'\">&nbsp;F&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=G&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'G'\">&nbsp;G&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=H&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'H'\">&nbsp;H&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=I&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'I'\">&nbsp;I&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=J&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'J'\">&nbsp;J&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=K&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'K'\">&nbsp;K&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=L&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'L'\">&nbsp;L&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=M&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'M'\">&nbsp;M&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=N&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'N'\">&nbsp;N&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=O&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'O'\">&nbsp;O&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=P&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'P'\">&nbsp;P&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Q&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'Q'\">&nbsp;Q&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=R&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'R'\">&nbsp;R&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=S&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'S'\">&nbsp;S&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=T&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'T'\">&nbsp;T&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=U&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'U'\">&nbsp;U&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=V&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'V'\">&nbsp;V&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=W&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'W'\">&nbsp;W&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=X&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'X'\">&nbsp;X&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Y&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'Y'\">&nbsp;Y&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Z&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commençants par 'Z'\">&nbsp;Z&nbsp;</a></td>
			</tr>
		</table>";
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_categorie($id_pb)
	{
		//echo "id_pb : $id_pb";
		//il faut v&eacute;rifier si le ticket est dans une cat&eacute;gorie de la personne connect&eacute;e
		$nom = $_SESSION['nom']; //On assigne le nom de la personne connect&eacute;e
		//On extrait tous les cat&eacute;gories de la personne connect&eacute;e
		$querys = "SELECT * FROM categorie WHERE NOM_UTIL = '".$nom."' AND ID_PB_CATEG LIKE '%$id_pb%';";
		$result = mysql_query($querys);
		if(!$result)
		{
			echo "Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
			echo "<br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
			mysql_close();
			exit;
		}
		$num_results_count = mysql_num_rows($result); //on regarde combien de cat&eacute;gorie poss&egrave;de la personne connect&eacute;e
		if ($num_results_count == 0)
		{
			//Il n'y a rien d'autre &agrave; faire
			echo "&nbsp;"; 
		}
		else
		{
			echo "X";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_appartenance_groupe($id_groupe)
	{
		//V&eacute;rification si la personne connect&eacute;e appartient au groupe pass&eacute; en param&egrave;tre
		$ses_id_util = $_SESSION['id_util'];
		$query = "SELECT * FROM `util_groupes` WHERE `ID_UTIL` = $ses_id_util AND `ID_GROUPE` = $id_groupe";
		$results = mysql_query($query);
		if(!$results)
		{
			echo "Probl&egrave;me de connexion, Vous n'êtes pas inscrit ou erreur dans la requ&egrave;te";
			//mysql_close();
			//exit;
		}
		else
		{
			$num_results = mysql_num_rows($results);
			if ($num_results > 0)
			{
				//la personne connect&eacute;e fait partie du groupe recherch&eacute;
				RETURN TRUE;
			}
			else
			{
				//la personne connect&eacute;e ne fait pas partie du groupe recherch&eacute;
				RETURN FALSE;
			} //Fin else
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_droits($fonction)
	{
		//Vérification si la personne connect&eacute;e appartient au groupe pass&eacute; en param&egrave;tre
		$ses_id_util = $_SESSION['id_util'];
		$query = "SELECT * FROM `util_droits` as ud, droits as d WHERE ud.id_droit = d.id_droit AND ud.id_util = '".$ses_id_util."' AND d.nom_droit LIKE '".$fonction."'";
		
		//echo "<br />$query";
		
		$results = mysql_query($query);
		if(!$results)
		{
			echo "<br />Probl&egrave;me de connexion, Vous n'êtes pas inscrit ou erreur dans la requ&egrave;te";
			//mysql_close();
			//exit;
		}
		else
		{
			$num_results = mysql_num_rows($results);
			if ($num_results = 0)
			{
				//la personne connect&eacute;e n'a pas de droits
				$niveau = 0;
			}
			else
			{
				//il faut r&eacute;cup&eacute;rer le niveau des droits
				$ligne=mysql_fetch_object($results);
				$niveau = $ligne->niveau;
			} //Fin else
			RETURN $niveau;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enreg_utilisation_module($module)
	{
		include ("../biblio/init.php");
		
		//$util = $_SESSION['nom'];
		$id_util = $_SESSION['id_util'];
		
		//echo "<br />module : $module";
		//echo "<br />id_util : $id_util";
		
		//On récupère la valeur du module à incrémenter
		$query1 = "SELECT * FROM statistiques_utilisation WHERE idUtilisateur = $id_util";
		$resultat_query1 = mysql_query($query1);
		$ligne1 = mysql_fetch_object($resultat_query1);
		$module_a_modifier = $ligne1 ->$module;
		//echo "<br />module_a_modifier : $module_a_modifier";
		$module_a_modifier = $module_a_modifier+1;
		//echo "<br />module_a_modifier : $module_a_modifier";
		
		//echo "on enregistre l'utilisation du module $module";
		$query_module = "UPDATE statistiques_utilisation SET `$module` = '".$module_a_modifier."' WHERE idUtilisateur = $id_util";
		
		//echo "<br />query_module : $query_module";
		
		$results_module = mysql_query($query_module);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enreg_utilisation_module_ancien($module)
	{
		include ("../biblio/init.php");
		$util = $_SESSION['nom'];
		$id_util = $_SESSION['id_util'];
		//echo "on enregistre l'utilisation du module $module";
		$query_module = "INSERT INTO utilisation_modules (MODULE, UTIL, ID_UTIL) VALUES ('".$module."', '".$util."', '".$id_util."');";
		$results_module = mysql_query($query_module);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_statistiques_modules($titre,$nb_access_tous_modules,$nb_acces_global,$nb_acces_perso)
	{
		echo "<tr>";
			echo "<td class =\"etiquette\">";
				echo $titre."&nbsp;:&nbsp;";
			echo "</td>";
			echo "<td align = \"center\">";
				echo $nb_acces_global;
			echo "</td>";

		if ($nb_access_tous_modules >0)
		{
			echo "<td align = \"center\">";
			$pourcentage=number_format(($nb_acces_global * 100)/ $nb_access_tous_modules,1);
			echo "$pourcentage%";
		}
		else
		{
			echo "<td>";
			echo "&nbsp;";
		}
			echo "&nbsp;";
			echo "</td>";
			echo "<td align = \"center\">";
				echo $nb_acces_perso;
			echo "</td>";
			echo "<td align = \"center\">";
		if ($nb_acces_global >0)
		{
			$pourcentage=number_format(($nb_acces_perso * 100)/ $nb_acces_global,1);
			echo "$pourcentage%";
		}
		else
		{
			echo "&nbsp;";
		}
			echo "</td>";
		echo "</tr>";
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function total_module($module)
	{
		$total = mysql_fetch_row(mysql_query("SELECT SUM($module) FROM `statistiques_utilisation`"));
		RETURN $total[0];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function extraction_statistiques_modules($module,$utilisateur,$id_utilisateur)
	{
		if ($module == "T")
		{
			if ($utilisateur == "T")
			{
				$total = 0; 
				$resultat = total_module("ABO");
				$total = $total+$resultat;
				$resultat = total_module("ACC");
				$total = $total+$resultat;
				$resultat = total_module("ALE");
				$total = $total+$resultat;
				$resultat = total_module("CAT");
				$total = $total+$resultat;
				$resultat = total_module("CON");
				$total = $total+$resultat;
				$resultat = total_module("COP");
				$total = $total+$resultat;
				$resultat = total_module("COU");
				$total = $total+$resultat;
				$resultat = total_module("CRE");
				$total = $total+$resultat;
				$resultat = total_module("DEV");
				$total = $total+$resultat;
				$resultat = total_module("DOS");
				$total = $total+$resultat;
				$resultat = total_module("ECL");
				$total = $total+$resultat;
				$resultat = total_module("FAV");
				$total = $total+$resultat;
				$resultat = total_module("FGM");
				$total = $total+$resultat;
				$resultat = total_module("FORM");
				$total = $total+$resultat;
				$resultat = total_module("GMA");
				$total = $total+$resultat;
				$resultat = total_module("GOM");
				$total = $total+$resultat;
				$resultat = total_module("GRO");
				$total = $total+$resultat;
				$resultat = total_module("GTI");
				$total = $total+$resultat;
				$resultat = total_module("GUS");
				$total = $total+$resultat;
				$resultat = total_module("INF");
				$total = $total+$resultat;
				$resultat = total_module("PUB");
				$total = $total+$resultat;
				$resultat = total_module("REC");
				$total = $total+$resultat;
				$resultat = total_module("REG");
				$total = $total+$resultat;
				$resultat = total_module("REP");
				$total = $total+$resultat;
				$resultat = total_module("RES");
				$total = $total+$resultat;
				$resultat = total_module("RTI");
				$total = $total+$resultat;
				$resultat = total_module("STA");
				$total = $total+$resultat;
				$resultat = total_module("TAC");
				$total = $total+$resultat;
				$resultat = total_module("TBAL");
				$total = $total+$resultat;
				$resultat = total_module("TBGA");
				$total = $total+$resultat;
				$resultat = total_module("TBO");
				$total = $total+$resultat;
				$resultat = total_module("TBPR");
				$total = $total+$resultat;
				$resultat = total_module("TBTI");
				$total = $total+$resultat;
				$resultat = total_module("WRA");
				$total = $total+$resultat;

				RETURN $total;
			}
			else
			{
				//$query = "SELECT * FROM `utilisation_modules` WHERE UTIL = '".$utilisateur."' AND ID_UTIL = '".$id_utilisateur."';";
				//$query = "SELECT * FROM `utilisation_modules` WHERE ID_UTIL = '".$id_utilisateur."';";
			}
		}
		else
		{
			//les modules individuellement
			if ($utilisateur == "T")
			{
				$resultat = total_module($module);
				RETURN $resultat;
			}
			else
			{
				//$query = "SELECT * FROM `utilisation_modules` WHERE module = '$module' AND UTIL = '".$utilisateur."' AND ID_UTIL = '".$id_utilisateur."';";
				//$query = "SELECT * FROM `utilisation_modules` WHERE module = '$module' AND ID_UTIL = '".$id_utilisateur."';";
				$query1 = "SELECT * FROM `statistiques_utilisation` WHERE idUtilisateur = '".$id_utilisateur."';";
				
				//echo "<br />query1 : $query1";
				
				$resultat_query1 = mysql_query($query1);
				$ligne1 = mysql_fetch_object($resultat_query1);
				$compteur_module = $ligne1 ->$module;
				RETURN $compteur_module;
				
				
			}
		}
		/*
		$results = mysql_query($query);
		if(!$results)
		{
			echo "<FONT COLOR = \"#808080\"><b>Erreur de connexion &agrave; la base de donn&eacute;es ou erreur de requ&egrave;te</b></FONT>";
			echo "<br /><a href = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour &agrave; l'accueil</a>";
			mysql_close();
			exit;
		}
		RETURN $num_results = mysql_num_rows($results);
		*/
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function extraction_statistiques_modules_ancien($module,$utilisateur,$id_utilisateur)
	{
		if ($module == "T")
		{
			if ($utilisateur == "T")
			{
				$query = "SELECT * FROM `utilisation_modules`;";
			}
			else
			{
				//$query = "SELECT * FROM `utilisation_modules` WHERE UTIL = '".$utilisateur."' AND ID_UTIL = '".$id_utilisateur."';";
				$query = "SELECT * FROM `utilisation_modules` WHERE ID_UTIL = '".$id_utilisateur."';";
			}
		}
		else
		{
			//les modules individuellement
			if ($utilisateur == "T")
			{
				$query = "SELECT * FROM `utilisation_modules` WHERE module = '$module';";
			}
			else
			{
				//$query = "SELECT * FROM `utilisation_modules` WHERE module = '$module' AND UTIL = '".$utilisateur."' AND ID_UTIL = '".$id_utilisateur."';";
				$query = "SELECT * FROM `utilisation_modules` WHERE module = '$module' AND ID_UTIL = '".$id_utilisateur."';";
			}
		}
		$results = mysql_query($query);
		if(!$results)
		{
			echo "<FONT COLOR = \"#808080\"><b>Erreur de connexion &agrave; la base de donn&eacute;es ou erreur de requ&egrave;te</b></FONT>";
			echo "<br /><a href = \"body.php\" TARGET = \"body\" class = \"bouton\">Retour &agrave; l'accueil</a>";
			mysql_close();
			exit;
		}
		RETURN $num_results = mysql_num_rows($results);
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function creation_nom_doc_a_enregistrer($id,$nom_doc,$module,$rne)
	{
		if ($module == "TBI")
		{
			$id = $rne;
		}
		else
		{
			if($id <10)
			{
				$id = "0000000".$id;
			}
			if ($id <100 AND $id>9)
			{
				$id = "000000".$id;
			}
			if ($id <1000 AND $id>99)
			{
				$id = "00000".$id;
			}
			if ($id <10000 AND $id>999)
			{
				$id = "0000".$id;
			}
			if ($id <100000 AND $id>9999)
			{
				$id = "000".$id;
			}
			if ($id <1000000 AND $id>99999)
			{
				$id = "00".$id;
			}
		}
		RETURN $id."_01";        
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function creation_nom_doc_a_enregistrer_webradio($choixEmission,$idConducteur)
	{
		//echo "<br />choixEmission : $choixEmission";
		//echo "<br />idConducteur : $idConducteur";
		
		if($choixEmission <10)
		{
			$choixEmission = "0000".$choixEmission;
		}
		if ($choixEmission <100 AND $choixEmission>9)
		{
			$choixEmission = "000".$choixEmission;
		}
		if ($choixEmission <1000 AND $choixEmission>99)
		{
			$choixEmission = "00".$choixEmission;
		}
		if ($choixEmission <10000 AND $choixEmission>999)
		{
			$choixEmission = "0".$choixEmission;
		}

		if($idConducteur <10)
		{
			$idConducteur = "000".$idConducteur;
		}
		if ($idConducteur <100 AND $idConducteur>9)
		{
			$idConducteur = "00".$idConducteur;
		}
		if ($idConducteur <1000 AND $idConducteur>99)
		{
			$idConducteur = "0".$idConducteur;
		}
		RETURN $choixEmission."_".$idConducteur;        
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function renomme_fichier_a_placer($fichier_a_placer,$extension,$dossier)
	{
		//Le fichier doit être renomm&eacute; en incr&eacute;mentant son indice
		//echo "<br />renommage du fichier $fichier_a_placer - extension : $extension<br />";

		$a_rechercher = "_";
		$pos = strpos($fichier_a_placer,$a_rechercher);

		//echo "<br />position du $a_rechercher : $pos<br />";
		$indice = substr($fichier_a_placer,$pos+1,$pos+3);
		//echo "indice extrait : $indice<br />";
		$indice_avant = "_".$indice;
		//echo "<br />indice_avant : $indice_avant";
		$indice = $indice +1; //on incr&eacute;mente l'indice d'un
		//echo "<br />indice 2 : $indice<br />";
		if ($indice <10) //pour garder une structure homog&egrave;ne du nom du fichier
		{
			$indice = "0".$indice;
			//echo "<br />indice 3 : $indice<br />";
		}
		$indice="_".$indice;
		//echo "<br />indice 4 : $indice<br />";
		$fichier_renomme = eregi_replace($indice_avant,$indice,$fichier_a_placer); //on pose le nouvel indice
		//echo "<br />fichier renomm&eacute; : $fichier_renomme avec extension $extension<br />";
    
		//On v&eacute;rifie &agrave; nouveau s'il existe
		if(file_exists($dossier.$fichier_renomme.$extension))
		{
			//echo "<center>eh oui, il existe toujours...</center><br />";
			$fichier_renomme = renomme_fichier_a_placer($fichier_renomme,$extension,$dossier);
			if(file_exists($dossier.$fichier_renomme.$extension))
			{
				//echo "<center>eh oui, il existe toujours...</center><br />";
				$fichier_renomme = renomme_fichier_a_placer($fichier_renomme,$extension,$dossier);
			}
			else
			{
				//echo "<center>eh non, il n'existe pas celui-l&agrave; ...<br /></center><br />";
				RETURN $fichier_renomme;
			}
		}
		else
		{ 
			//echo "<center>eh non, il n'existe pas celui-l&agrave; ...<br /></center><br />";
			RETURN $fichier_renomme;
		}
	}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonctionne qui permet de supprimer un document
	function suppr_doc($id_doc,$dossier,$nom_fichier)
	{
		//echo "<br />Bienvenu dans la fonction suppr_doc pour supprimer le document $id_doc ($nom_fichier) du dossier $dossier<br />";

		//il faut supprimer le fichier sur le disque
		if(file_exists($dossier.$nom_fichier))
		{
			$sup = unlink($dossier.$nom_fichier);
			if ($sup)
			{
				echo "<br />Le document a &eacute;t&eacute; supprim&eacute; du disque<br />";
			}
		}
		else
		{
			echo "<br />Le document n'existe pas sur le disque<br />";
		}

		//Maintenent il faut nettoyer la base de donn&eacute;es
		$query_suppression = "DELETE FROM documents WHERE id_doc = '".$id_doc."';";
		$result = mysql_query($query_suppression);
		//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
		if(!$result)
		{
			echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
			echo "<br /> <a href = \"ecl_consult_fiche.php\" target = \"body\">Retour</a>";
			mysql_close();
			exit;
		}
		else
		{
			echo "<br />Le document a &eacute;t&eacute; supprim&eacute; de la base de donn&eacute;es<br /><br />";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Fonctionne qui permet de supprimer les documents joints du disque et de la table documents concernant une formation ou d'un tickets supprim&eacute;
	function efface_documents_joints($id_ticket,$module,$dossier)
	{
		//echo "<br />proc&eacute;dure efface_entree_table_documents($id_ticket,$module,$dossier)";    
		//Il faut balayer la table pour rep&eacute;rer tous les documents sur le disque et les supprimer un par un
		$query = "SELECT DISTINCT * FROM documents WHERE id_ticket = '".$id_ticket."' AND module = '".$module."';";
		$results = mysql_query($query);
		if(!$results)
		{
			echo "<FONT COLOR = \"#808080\"><b>Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es</b></FONT>";
			echo "<br /><br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
			mysql_close();
			exit;
		}
		else
		{
			$num_results = mysql_num_rows($results);
			//echo "<br />$num_results documents &agrave; supprimer du dossier $dossier";
			if ($num_results >0)
			{
				//echo "<h2>Nombre de documents &agrave; supprimer pour la formation $id_ticket : $num_results</h2>";
				$res = mysql_fetch_row($results);
				for ($i=0; $i<$num_results; $i++)
				{
					//echo "<br />N° doc : $res[0] - N° formation : $res[1] - Nom du fichier : $res[3]";
					//Il faut supprimer le fichiers un par un
					if(file_exists($dossier.$res[3]))
					{
						//echo "<br />le fichier existe";
						$sup = unlink($dossier.$res[3]);
						if ($sup)
						{
							//echo "<br />Le fichier a &eacute;t&eacute; supprim&eacute; du disque<br />";
						}
					}
					else
					{
						//echo "<br />le fichier n'existe pas";
					}
					//Il faut maintenir effacer l'entr&eacute;e dans la table documants
					$query_suppression = "DELETE FROM documents WHERE id_doc = '".$res[0]."';";
					$result = mysql_query($query_suppression);
					//Dans le cas où aucun r&eacute;sultats n'est retourn&eacute;
					if(!$result)
					{
						echo "2 : Erreur d'execution de la requ&egrave;te ou de connexion &agrave; la base de donn&eacute;es";
						echo "<br /> <a href = \"ecl_consult_fiche.php\" target = \"body\">Retour</a>";
						mysql_close();
						exit;
					}
					else
					{
						//echo "<br />Le document a &eacute;t&eacute; supprim&eacute; de la base de donn&eacute;es<br />";
					}
					$res = mysql_fetch_row($results);
				} //Fin for pour traiter chaque ligne &agrave; supprimer
			} //Fin if num_resultats >0	 
		} //Fin if resultats
      //On efface toutes les r&eacute;f&eacute;rences de la formations supprim&eacute;e 'id_formation' de la table documents
      
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function deverouiller($idpb) //n&eacute;cessite une connection &agrave; la base pr&eacute;alablement
	{
		$query_deverrouillage = "UPDATE probleme SET VERROU = '0', VERROUILLE_PAR = '' WHERE ID_PB = '".$idpb."';";
		$results_deverrouillage = mysql_query($query_deverrouillage);
		if(!$results_deverrouillage)
		{
			echo "<FONT COLOR = \"#808080\"><b>Erreur</b></FONT>";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_alerte($id_ticket,$id_util,$date_aujourdhui,$origine) 
	{
		if ($origine <> "tache")
		{
			$query = "SELECT * FROM alertes WHERE id_util = '".$id_util."' AND id_ticket = '".$id_ticket."';";
			$result = mysql_query($query);
			if(!$result)
			{
				echo "Probl&egrave;me lors de la connexion &agrave; la base de donn&eacute;es";
				//echo "<br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
				//mysql_close();
				//exit;
			}
			$num_results_count = mysql_num_rows($result); //on regarde s'il y a une alerte pour ce ticket
		}
		else
		{
			echo "<br />Je doit traiter les &eacute;ch&eacute;ances des t&acirc;ches";
		}
		switch ($origine)
		{
			case "gestion" :
				if ($num_results_count == 0)
				{
					//Il n'y a rien d'autre &agrave; faire
					echo "<td align=\"center\">";
					echo "&nbsp;";
				}
				else
				{
					//echo "date_aujourdhui : $date_aujourdhui";
					//on test le nombre de jour de d&eacute;calage par rapport &agrave; la date du jour
					$res = mysql_fetch_row($result);
					$description_alerte = $res[4];
					//echo "<br />date_alerte dans base : $res[3]";
					//On stocke la date de la table dans une variable date pour la compaison ult&eacute;rieure
					$alerte = strtotime($res[3]);
					//echo " - date_alerte apr&egrave;s premier traitement : $alerte";
					$aujourdhui = date('Y/m/d');
					//echo " - aujourdhui : $aujourdhui";
					$aujourdhui = strtotime($aujourdhui);
					//echo " - date_aujourdhui apr&egrave;s premier traitement : $aujourdhui";

					//$alerte = date('d/m/Y',$alerte);
					//On compare les deux dates
					$nbr_jours = ceil(($alerte-$aujourdhui)/86400);
					//echo " - nbr_jours : $nbr_jours";
					//Traitement suivant le nombre de jours s&eacute;parant la date d'alerte de la date du jour
					$nbr_jours = $nbr_jours*-1;
					if ($nbr_jours < 0)
					{
						//$nbr_jours = $date_du_jour - $rappel;
						echo "<td align=\"center\" bgcolor = \"#00FF3C\">"; //vert
						$nbr_jours = $nbr_jours*-1;
						$texte = "J - $nbr_jours";
					}
					elseif ($nbr_jours == 0)
					{
						echo "<td align=\"center\" bgcolor = \"#FFFB00\">"; //jaune
						//$texte = "aujourd'hui";
						$texte = "J 0&nbsp;";
					}
					elseif (($nbr_jours > 0) AND ($nbr_jours < 8))
					{
						echo "<td align=\"center\" bgcolor = \"#FF7B00\">"; //orange
						$texte = "J + $nbr_jours";
					}
					else
					{
						echo "<td align=\"center\" bgcolor = \"#FF0000\">"; //rouge
						$texte = "J + $nbr_jours";
						//echo "<a title = \"$description_alerte\"> depuis $nbr_jours j.</a>";
					}
					if ($description_alerte <>"")
					{
						echo "<a id=\"info_bulle\" class=\"info_bulle\">$texte
							<span class=\"info_bulle\">
								<!--span class=\"header\">Pour information :</span-->
								<span class=\"content\">$description_alerte</span>
								<!--span class=\"footer\"></span-->
							</span>
						</a>";
					}
					else
					{
						echo "$texte";
					}
				}
			break;

			case "ticket" :
				if ($num_results_count == 0)
				{
					//Il n'y a rien d'autre &agrave; faire
					return 0;
				}
				else
				{
					return 1;
				}
			break;
		} //Fin switch origine
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function verif_alerte_rep($id_societe,$id_util) 
	{
		//echo " - (fct)id_soci&eacute;t&eacute; : $id_societe - id_util : $id_util";
		$requete_verif_alerte = "SELECT * FROM probleme, alertes WHERE `probleme`.`ID_PB` = `alertes`.`id_ticket` AND `probleme`.`NUM_ETABLISSEMENT` = '".$id_societe."' AND `alertes`.`id_util` = '".$id_util."';";
		$result_verif_alerte = mysql_query($requete_verif_alerte);
		if(!$result_verif_alerte)
		{
			echo "ERREUR";
			//echo "<br /><a href = \"body.php\" class = \"bouton\" target = \"body\">Retour &agrave; l'accueil</a>";
			//mysql_close();
			//exit;
		}
		else
		{
			$num_results_count = mysql_num_rows($result_verif_alerte); //on regarde s'il y a au moins une alerte pour ce ticket
			//echo " - num_results_count : $num_results_count";
			if ($num_results_count == 0)
			{
				//Il n'y a rien d'autre &agrave; faire
				echo "<td align=\"center\">";
				echo "&nbsp;";
			}
			else
			{
				echo "<td align=\"center\" bgcolor = \"#FF0000\">";
				echo "&nbsp;";
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crevardate($jour,$mois,$annee)
	{
		if (($mois <10) AND (strlen($mois)== 1))
		{
			$mois = "0".$mois;
		}
		if (($jour <10) AND (strlen($jour)== 1))
		{
			$jour = "0".$jour;
		}
		//echo "<br />(fct.php) jour : $jour - mois : $mois - annee : $annee";
		//$date = $jour."-".$mois."-".$annee;
		$date = $annee."-".$mois."-".$jour;
		//echo "<br />(fct.php) date compos&eacute;e des &eacute;l&eacute;ments transmis : $date";
		$date = strtotime($date);
		//echo "<br />(fct.php) date apr&egrave;s strtotime : $date";
		$date_a_enregistrer = date('Y-m-d',$date);
		return $date_a_enregistrer;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function suppression_alertes($idpb)
	{
		$requete_suppression = "DELETE FROM `alertes` WHERE `alertes`.`id_ticket` =".$idpb.";";
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<br />Erreur";
		}
		else
		{
			echo "<h2>Les alertes ont &eacute;t&eacute; supprim&eacute;es.</h2>";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_info_bulle($id,$module,$id_ticket)
	{
		//echo "<br />$id - $module";
		if ($id <>"")
		{
			switch ($module)
			{
				case "GT" :
					//echo "RNE";
					$requete = "SELECT * FROM etablissements WHERE RNE = '".$id."'";
					$resultat = mysql_query($requete);
					if (!$resultat)
					{
						echo "<br />Erreur";
					}
					else
					{
						$champs = mysql_fetch_row($resultat);
						//il fdaut &eacute;galement r&eacute;cup&eacute;rer le contact du ticket
						$requete_ticket = "SELECT * FROM probleme WHERE ID_PB = '".$id_ticket."'";
						$resultat_ticket = mysql_query($requete_ticket);
						$champs_ticket = mysql_fetch_row($resultat_ticket);

						//echo "<br />9 : $champs[9]";
						echo "<a id=\"info_bulle_2\" class=\"info_bulle_2\">$id
							<span class=\"info_bulle_2\">
								<!--span class=\"header\">Pour information :</span-->
								<span class=\"content_2\">
									<b>$champs[1] $champs[3]</b>
									<br />$champs[4]
									<br />$champs[6]&nbsp;<b>$champs[5]</b>";
									$tel = affiche_tel($champs[7]);
									echo "<br />$tel";
									echo "<br />$champs[8]
									<br />contact initial&nbsp;:&nbsp;<b>$champs_ticket[19]&nbsp;$champs_ticket[18]</b>&nbsp;($champs_ticket[21])
									<br />autre(s) contact(s)&nbsp;:&nbsp;";
									$requete_contact = "SELECT DISTINCT * FROM probleme WHERE ID_PB_PERE = '".$id_ticket."'";
									$resultat_contact = mysql_query($requete_contact);
									while ($champs_contact = mysql_fetch_row($resultat_contact))
									{
										//echo "$champs_ticket[18] - $champs_contact[18]";
										if (($champs_ticket[18] <> $champs_contact[18]) AND ($champs_contact[18] <>""))
										{
											echo "<br />- $champs_contact[19]&nbsp;$champs_contact[18]</b>&nbsp;($champs_contact[21])";
										}
									}
								echo "</span>
								<!--span class=\"footer_2\"></span-->
							</span>
						</a>";
					}
				break;

				case "REP" :
					$requete = "SELECT * FROM repertoire WHERE No_societe = '".$id."'";
					$resultat = mysql_query($requete);
					if (!resultat)
					{
						echo "<br />Erreur";
					}
					else
					{
						$champs = mysql_fetch_row($resultat);
						//il fdaut &eacute;galement r&eacute;cup&eacute;rer le contact du ticket
						$requete_ticket = "SELECT * FROM probleme WHERE ID_PB = '".$id_ticket."'";
						$resultat_ticket = mysql_query($requete_ticket);
						$champs_ticket = mysql_fetch_row($resultat_ticket);
						echo "<a id=\"info_bulle_2\" class=\"info_bulle_2\">$id
							<span class=\"info_bulle_2\">
								<!--span class=\"header\">Pour information :</span-->
								<span class=\"content_2\">
									<b>$champs[1]</b>
									<br />$champs[2]
									<br />$champs[3]<b>&nbsp;$champs[4]</b>";
									$tel = affiche_tel($champs[5]);
									echo "<br />$tel";
									echo "<br />$champs[8]
									<br />contact initial&nbsp;:&nbsp;<b>$champs_ticket[19]&nbsp;$champs_ticket[18]</b>
									<br />autre(s) contact(s)&nbsp;:&nbsp;";
									$requete_contact = "SELECT DISTINCT * FROM probleme WHERE ID_PB_PERE = '".$id_ticket."'";
									$resultat_contact = mysql_query($requete_contact);
									while ($champs_contact = mysql_fetch_row($resultat_contact))
									{
										//echo "$champs_ticket[18] - $champs_contact[18]";
										if (($champs_ticket[18] <> $champs_contact[18]) AND ($champs_contact[18] <>""))
										{
											echo "<br />- $champs_contact[19]&nbsp;$champs_contact[18]</b>";
										}
									}
								echo "</span>
								<!--span class=\"footer_2\"></span-->
							</span>
						</a>";
					}
				break;

				case "RESS" :
					//echo "RNE";
					$requete = "SELECT * FROM etablissements WHERE RNE = '".$id."'";
					$resultat = mysql_query($requete);
					if (!resultat)
					{
						echo "<br />Erreur";
					}
					else
					{
						$champs = mysql_fetch_row($resultat);
					
						echo "<a id=\"info_bulle_2\" class=\"info_bulle_2\">$id
							<span class=\"info_bulle_2\">
								<!--span class=\"header\">Pour information :</span-->
								<span class=\"content_2\">
									<b>$champs[1] $champs[3]</b>
									<br />$champs[4]
									<br />$champs[6]&nbsp;<b>$champs[5]</b>";
									$tel = affiche_tel($champs[7]);
									echo "<br />$tel";
									echo "<br />$champs[8]";
								echo "</span>
								<!--span class=\"footer_2\"></span-->
							</span>
						</a>";
					}
				break;
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function format_no_tel($tel)
	{
		//$tel = chunk_split($tel,"2",".");
		$tel = str_replace(" ","",$tel);
		$tel = str_replace(".","",$tel);
		$tel = str_replace("-","",$tel);
		$tel = str_replace("/","",$tel);
		$tel = str_replace("*","",$tel);
		return "$tel";
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_tel($tel) //pour ajouter un "." apr&egrave;s chaque groupe de 2 chiffres
	{
		//echo "<br />tel : $tel";
		if (($tel <> "") AND ($tel <> "0"))
		{
			$tel = format_no_tel($tel);
			$tel = chunk_split($tel,"2",".");
			$longueur = strlen($tel);
			$longueur = $longueur-1;
			$tel = substr($tel,0,$longueur);
		}
		else
		{
			$tel = "";
		}
		return $tel;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_chiffre_si_pas_0($chiffre) //pour ne pas afficher un chiffre qui serait 0, tout en changeant la couleur s'il est n&eacute;gatif
	{
		//echo "<br />fonction affiche_chiffre_si_pas_0($chiffre)";
		//echo "<br />chiffre : $chiffre";
		if ($chiffre > 0)
		{
			echo $chiffre;
		}  //Fin if chiffre > 0
		elseif ($chiffre < 0)
		{
			echo "<font color=\"red\"><b>($chiffre)</b></font>";
		}
		else
		{
			echo "&nbsp;";
		}  //Fin else if chiffre > 0
		 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function format_chiffre($chiffre) //en arrondissant syst&eacute;matiquement &agrave; 2 d&eacute;cimales
	{
		$chiffre = number_format($chiffre,2,',',' ');
		return $chiffre;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function supprime_accents($chaine) //supprime tous les caract&egrave;res non compatible avec une adresse m&eacute;l
	{
		$chaine = strtr($chaine, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
		'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		return $chaine;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function test_option_select ($donnees,$option,$champ)
	{
		if ($donnees == $option)
		{ 
			//echo "<option selected=$champ value = $champ>$donnees</option>";
			echo "<option selected value = $champ>$donnees</option>";
		}
		else
		{
			echo "<option value =$champ>$option</option>";
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function test_option_select_new ($valeur1,$valeur2,$etiquette)
	{
		/*
		echo "<br />valeur 1 : $valeur1";
		echo "<br />valeur 2 : $valeur2";
		echo "<br />&eacute;tiquette : $etiquette";
		*/
		if ($valeur1 == $valeur2)
		{ 
			//echo "<option selected=$champ value = $champ>$donnees</option>";
			//echo "<br /><strong>selected</strong>";
			//echo "<option selected=\"selected\" value = \"$valeur1\">$etiquette</option>";
			echo "<option selected value = \"$valeur1\">$etiquette</option>";
		}
		else
		{
			echo "<option value =\"$valeur1\">$etiquette</option>";
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function extraction_intervenants_ticket ($no_ticket)
	{
		include ("../biblio/init.php");
		//echo "<br />fct.php - no_ticket : $no_ticket";
		$liste_intervenants = "SELECT nom, id_crea, id_interv FROM intervenant_ticket, util WHERE intervenant_ticket.id_interv = util.id_util AND id_tick = $no_ticket";
		$resultat_liste_intervenants = mysql_query($liste_intervenants);
		$intervenants = "";
		while ($resultats = mysql_fetch_row($resultat_liste_intervenants))
		{
			if ($intervenants == "")
			{
				if ($resultats[1] <> $resultats[2])
				{
					$intervenants = $resultats[0];
				}
			}
			else
			{
				if ($resultats[1] <> $resultats[2])
				{
					$intervenants = $intervenants.";".$resultats[0];
				}
				
			}
			//echo "<br />intervenants : $intervenants";		
		}
		return $intervenants;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_date_rappel ($nbr_jours)
	{
		//il faut analyser la date du jour
		//on r&eacute;cup&egrave;re le jour, le mois et l'ann&eacute;e dans des variables diff&eacute;rentes
		$aujourdhui_jour = date('d');
		$aujourdhui_jour = $aujourdhui_jour+$nbr_jours;
		$aujourdhui_mois = date('m');
		$aujourdhui_annee = date('Y');

		//On fonctionne du mois et du jour
		if ($aujourdhui_mois == 2) //le mois de f&eacute;vrier et &agrave; traiter de façon diff&eacute;rente
		{
			//traitement mois de f&eacute;vrier
			$decalage = $aujourdhui_jour - 28;
		}
		elseif (($aujourdhui_mois == 4) 
			OR ($aujourdhui_mois == 6)
			OR ($aujourdhui_mois == 9)
			OR ($aujourdhui_mois == 11))
		{
			//traitement pour les mois &agrave; 30 jours
			$decalage = $aujourdhui_jour - 30;
		}
		else
		{
			//traitement pour les mois &agrave; 31 jours
			$decalage = $aujourdhui_jour - 31;
		}
		//On regarde le d&eacute;callage calcul&eacute;
		if ($decalage > 0)
		{
			$aujourdhui_jour = $decalage;
			$aujourdhui_mois = $aujourdhui_mois+1;
		}
		//On regarde si le mois d&eacute;passe le mois e d&eacute;cembre
		if ($aujourdhui_mois == 13)
		{
			$aujourdhui_mois = 1;
			$aujourdhui_annee = $aujourdhui_annee+1;
		}
		$date_a_retourner = crevardate($aujourdhui_jour,$aujourdhui_mois,$aujourdhui_annee);
		return $date_a_retourner;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////Fonctions Mailing////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Cette fonction v&eacute;rifie si le mail se trouve dans le tableau
	function verifmail($mail, $tableau, $derniere_ligne)
	{
		$it=0;
		//Tant qu'on a pas parcouru tout le tableau ou qu'on pas un mail identique
		while($it < $derniere_ligne && $tableau[$it] <> $mail)
		{
			$it++;
		}
		if (isset($tableau[$it]) && $tableau[$it] == $mail)
		{
			//Si on &agrave; trouv&eacute; le mail : on retourne vrai
			return true;
		}
		else
		{
			//Sinon on retourne faux
			return false;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////Fonctions pour module acc&egrave;s ext&eacute;rieur////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_nom_serveur($nom_serveur)
	{
		$autorise = array("php5", "ecl", "etab", "gabee", "gstages", "dafpic", "libmol2", "sti2", "wikinimst", "grr", "wordpress", "joomla", "moodle", "cdt", "dokeos", "dotclear", "eva4","group-office");
		$imax = sizeof($autorise);
		$i=0;
		while($i<$imax && strtolower($nom_serveur) != $autorise[$i])
		{
			$i++;
			
		}
		if(strtolower($nom_serveur) == $autorise[$i])
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function trad_statut($statut)
	{
		switch($statut)
		{
			case 'N' : 
				$statut = "Nouveau"; 
				break;
			case 'A' : 
				$statut = "Archiv&eacute;"; 
				break;
			case 'T' : 
				$statut = "En cours"; 
				break;
			case 'F' : 
				$statut = "Termin&eacute;"; 
				break;
			case 'C' : 
				$statut = "En cours"; 
			break;
		}
		return $statut;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function lecture_preference($preference,$id_util)
	{
		$req_pref="SELECT $preference FROM preference WHERE ID_UTIL = $id_util;";
		$execution= mysql_query($req_pref);
		$res = mysql_fetch_row($execution);
		$preference_extraite = $res[0];
		return $preference_extraite;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function lecture_utilisateur($champ,$id_util)
	{
		$req_util="SELECT $champ FROM util WHERE ID_UTIL = $id_util;";
		$execution= mysql_query($req_util);
		$res = mysql_fetch_row($execution);
		$champ_extrait = $res[0];
		return $champ_extrait;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function image_fichier_joint($nomfichier)
	{
		//On extrait l'extension et on transforme en minuscules
		$extension = strtolower(strrchr($nomfichier, "."));
		
		switch($extension)
		{
			case '.pdf' :
				$image = "fichier_pdf.png";
			break;

			case '.doc' :
				$image = "fichier_traitement_de_texte.png";
			break;

			case '.docx' :
				$image = "fichier_traitement_de_texte.png";
			break;

			case '.odt' :
				$image = "fichier_traitement_de_texte.png";
			break;

			case '.ppt' :
				$image = "fichier_presentation.png";
			break;

			case '.pps' :
				$image = "fichier_presentation.png";
			break;

			case '.odp' :
				$image = "fichier_presentation.png";
			break;

			case '.jpg' :
				$image = "fichier_image.png";
			break;

			case '.gif' :
				$image = "fichier_image.png";
			break;

			case '.png' :
				$image = "fichier_image.png";
			break;

			case '.eps' :
				$image = "fichier_image.png";
			break;

			case '.pds' :
				$image = "fichier_image.png";
			break;

			case '.xls' :
				$image = "fichier_tableur.png";
			break;

			case '.ods' :
				$image = "fichier_tableur.png";
			break;

			case '.odg' :
				$image = "fichier_dessin.png";
			break;

			case '.txt' :
				$image = "fichier_texte.png";
			break;

			case '.zip' :
				$image = "fichier_compresse.png";
			break;

			case '.gz' :
				$image = "fichier_compresse.png";
			break;

			case '.tar' :
				$image = "fichier_compresse.png";
			break;
		}
		return $image;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function test_ent($rne)
	{
		$test_ent="SELECT * FROM ENT WHERE rne = '".$rne."'";
		$execution = mysql_query($test_ent);
		$exist = mysql_num_rows($execution);
		return $exist;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function lecture_table_ent($champ,$rne)
	{
		$req_table = "SELECT $champ FROM ENT WHERE rne = '".$rne."'";
		$execution= mysql_query($req_table);
		$res = mysql_fetch_row($execution);
		$champ_extrait = $res[0];
		return $champ_extrait;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function lecture_champ($table,$champ,$champ_condition,$condition) //Permet d'extraire le contenu d'un champ dans une table donnée
	{
		$req_champ="SELECT $champ FROM $table WHERE $champ_condition = '".$condition."'";
		$execution= mysql_query($req_champ);
		$res = mysql_fetch_row($execution);
		$champ_extrait = $res[0];
		return $champ_extrait;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function changer_ordre_conducteur($idConducteur,$NoOrdre) //Permet de modifier le No d'ordre d'une entrée dans le conducteur
	{
		$requete_maj = "UPDATE WR_Conducteurs SET 
			`ConducteurNoOrdre` = '".$NoOrdre."'
		WHERE idConducteur = '".$idConducteur."';";
		$execution= mysql_query($requete_maj);
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verif_identifiant($identifiant)
	{
		//echo "<br />dans verif_identifiant";
		
		$requete_verif_identifiant = "SELECT identifiant FROM util WHERE identifiant = '".$identifiant."'";
		$execution= mysql_query($requete_verif_identifiant);
		$resultat = mysql_num_rows($execution);
		return $resultat;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function genere_identifiant($prenom,$nom,$script)
	{
		//echo "<br />dans genere_identifiant";
		//On supprime les accents, remplace les espaces et les apostrophes par des "-" 
		
		//on construit l'identifiant
		$premiere_lettre = strtolower($prenom{0});
		$identifiant_initial = $premiere_lettre.strtolower($nom);
		
		//echo "<br />identifiant_initial : $identifiant_initial";
		
		$identifiant = $identifiant_initial; //A cause de la gestion des indices
		$indice = 0;
		$boucle = "O";
		//On vérifie qu'il n'existe pas
		while ($boucle == "O")
		{
			$verif_identifiant = verif_identifiant($identifiant);
			/*
			$verif_identifiant = "SELECT identifiant FROM util WHERE identifiant = '".$identifiant."'";
			$execution= mysql_query($verif_identifiant);
			$resultat = mysql_num_rows($execution);
			*/
			//echo "<br />retour verif_identifiant  : $verif_identifiant";
			
			//S'il existe on ajoute un indice que l'on teste jusqu'à obtention d'un identifiant valable
			if ($verif_identifiant <> 0)
			{
				$indice ++;
				if ($script <> "inscription")
				{
					echo "<h2>l'identifiant $identifiant existe d&eacute;j&agrave;, essayez un autre&nbsp;!</h2>";
				}
				//On ajoute un indice et on vérifie à nouveau
				$identifiant = $identifiant_initial.$indice;
				//echo "<br />identifiant : $identifiant";
			}
			else
			{
				$boucle = "N";
				//On accepte le nouvel identifiant
			}
		}
		
		//Et pour finir on le retourne
		$_SESSION['identifiant'] = $identifiant;
		return $identifiant;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function get_current_insert_id($table)
	{
		$q = "SELECT LAST_INSERT_ID() FROM $table";
		return mysql_num_rows(mysql_query($q)) + 1;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function tronquer_chaine($chaine, $debut, $max)
	{
		if (strlen($chaine) >= $max)
		{
			$chaine = substr($chaine, $debut, $max);
			$espace = strrpos($chaine, " ");
			$chaine = substr($chaine, $debut, $espace).'...';
			return $chaine;
		}
		else
		{
			return $chaine;
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function compte_enregistrements($table,$idEmission,$NomChamp)
	{
		$requete = "SELECT * FROM $table WHERE $NomChamp = ".$idEmission."";
		$resultat = mysql_query ($requete);
		$nombre_enregistrement = mysql_num_rows($resultat);

		//RETURN mysql_num_rows(mysql_query ("SELECT * FROM $table WHERE $NomChamp = $idEmission"));
		RETURN $nombre_enregistrement;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enreg_categories_webradio($EmissionCategories,$idEmission)
	{
		//echo "<br />fonction enreg_categories_webradio";
		
		$nombre_elements = count($EmissionCategories);
		/*
		echo "<br />nombre_elements : $nombre_elements";
		echo "<br />idEmission : $idEmission";
		*/
		if (($EmissionCategories[0] <> 0) OR ($EmissionCategories[0] == 0 AND $nombre_elements >1))
		{
			//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
			$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
			while($i < $nombre_elements)
			{
				//echo "<br />compteur : $i - id_util : $id_util - id_util_traitant : $id_util_traitant - id_util_associe : $id_util_associes[$i]";
				if ($EmissionCategories[$i] <> 0)
				{
					//echo " - On enregistrera la fiche";
					$requete_enreg_categ = "INSERT INTO WR_Emissions_EmissionsCategories (`idEmission`,`idEmissionsCategorie`)
						VALUES ('".$idEmission."','".$EmissionCategories[$i]."')";
					
					//echo "<br />requete_enreg_categ : $requete_enreg_categ";
					
					$resultat_enreg_categ = mysql_query($requete_enreg_categ);
					if (!$resultat_enreg_categ)
					{
						echo "<br>Erreur lors de l'enregistrement de la cat&eacute;gorie";
					}
				}
				$i++;
			} 
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recupPerDir($fonction,$rne) //Permet de récupérér les informations sur les PerDir d'un établissement donné
	{
		IF ($fonction == 1)
		{
			$complement_requete = "Fonction = 'DIR' OR Fonction = 'PRINC' OR Fonction = 'PROV'";
		}
		else
		{
			$complement_requete = "Fonction = 'DIR-ADJ' OR Fonction = 'PRINC-ADJ' OR Fonction = 'PROV-ADJ'";
		}
		$requete="SELECT Nom, Prenom, annee_scolaire, Fonction, Civilite FROM perdir WHERE RNE = '".$rne."' AND (".$complement_requete.")";
		$execution= mysql_query($requete);
		$res = mysql_fetch_row($execution);
		return $res;
	}
?>
