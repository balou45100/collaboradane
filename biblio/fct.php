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
		//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
			//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
				//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
				//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
			//echo "<br />N� cat&eacute;gorie : $res_cat[0]";
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

			//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
		echo "<br />N� du ticket : $idpb";
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
		//echo "<br />N� cat&eacute;gorie : $res_cat[0]";
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

		//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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

			case 'February':
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
				$month = "Ao�t";
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
	function traduction_mois($mois)
	{
		switch($mois)
		{
			case 'January':
				$month = "Janvier";
			break;

			case 'February':
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
				$month = "Ao�t";
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
				$month = "non connu";
			break;
		}
		return $month;
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
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=A&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'A'\">&nbsp;A&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=B&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'B'\">&nbsp;B&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=C&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'C'\">&nbsp;C&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=D&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'D'\">&nbsp;D&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=E&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'E'\">&nbsp;E&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=F&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'F'\">&nbsp;F&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=G&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'G'\">&nbsp;G&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=H&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'H'\">&nbsp;H&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=I&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'I'\">&nbsp;I&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=J&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'J'\">&nbsp;J&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=K&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'K'\">&nbsp;K&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=L&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'L'\">&nbsp;L&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=M&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'M'\">&nbsp;M&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=N&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'N'\">&nbsp;N&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=O&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'O'\">&nbsp;O&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=P&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'P'\">&nbsp;P&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Q&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'Q'\">&nbsp;Q&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=R&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'R'\">&nbsp;R&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=S&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'S'\">&nbsp;S&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=T&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'T'\">&nbsp;T&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=U&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'U'\">&nbsp;U&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=V&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'V'\">&nbsp;V&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=W&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'W'\">&nbsp;W&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=X&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'X'\">&nbsp;X&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Y&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'Y'\">&nbsp;Y&nbsp;</a></td>
				<td><a href=\"$fichier.php?indice=0&amp;tri=$tri&amp;sense_tri=ASC&amp;lettre=Z&amp;origine_gestion=alpha\" target = \"body\" title=\"Les enregistrements commen�ants par 'Z'\">&nbsp;Z&nbsp;</a></td>
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
			echo "Probl&egrave;me de connexion, Vous n'�tes pas inscrit ou erreur dans la requ&egrave;te";
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
		//Vérification si la personne connect&eacute;e appartient au groupe passé; en paramètre
		$ses_id_util = $_SESSION['id_util'];
		$query = "SELECT * FROM `util_droits` as ud, droits as d WHERE ud.id_droit = d.id_droit AND ud.id_util = '".$ses_id_util."' AND d.nom_droit LIKE '".$fonction."'";

		//echo "<br />$query";

		$results = mysql_query($query);
		if(!$results)
		{
			echo "<br />Probl&egrave;me de connexion, Vous n'�tes pas inscrit ou erreur dans la requ&egrave;te";
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
		$test = include ("../biblio/init.php");
		//echo "<br />test : $test";

		//$util = $_SESSION['nom'];
		$id_util = $_SESSION['id_util'];

		//echo "<br />module : $module";
		//echo "<br />id_util : $id_util";

		//On récupère la valeur du module à incrémenter
		$query1 = "SELECT * FROM statistiques_utilisation WHERE idUtilisateur = $id_util";

		//echo "<br />query : $query1";

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
				$id = $module."_0000000".$id;
			}
			if ($id <100 AND $id>9)
			{
				$id = $module."_000000".$id;
			}
			if ($id <1000 AND $id>99)
			{
				$id = $module."_00000".$id;
			}
			if ($id <10000 AND $id>999)
			{
				$id = $module."_0000".$id;
			}
			if ($id <100000 AND $id>9999)
			{
				$id = $module."_000".$id;
			}
			if ($id <1000000 AND $id>99999)
			{
				$id = $module."_00".$id;
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
		//Le fichier doit être renommé en incrémentant son indice
		//echo "<br />renommage du fichier $fichier_a_placer - extension : $extension<br />";

		$a_rechercher = "_";
		//$pos = strpos($fichier_a_placer,$a_rechercher);
		$indice_initial = strrchr($fichier_a_placer,$a_rechercher);
		//echo "<br />chaîne apr&egrave;s le dernier caract&egrave;re recherch&eacute; $a_rechercher : $indice_initial<br />";
		//$indice = substr($fichier_a_placer,$pos+1,$pos+3);
		$indice = substr($indice_initial,1,2);
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
		//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
					//echo "<br />N� doc : $res[0] - N� formation : $res[1] - Nom du fichier : $res[3]";
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
					//Dans le cas o� aucun r&eacute;sultats n'est retourn&eacute;
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
	function affiche_info_bulle_initiales($initiales,$prenom,$nom)
	{
		echo "<a id=\"info_bulle_2\" class=\"info_bulle_2\">$id
			<span class=\"info_bulle_2\">
				<!--span class=\"header\">Pour information :</span-->
				<span class=\"content_2\">
					<b>$prenom $nom</b>";
				echo "</span>
				<!--span class=\"footer_2\"></span-->
			</span>
		</a>";
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
	function format_chiffre($chiffre) //en arrondissant systématiquement à 2 décimales
	{
		$chiffre = number_format($chiffre,2,',',' ');
		return $chiffre;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function supprime_accents($chaine) //supprime tous les caract&egrave;res non compatible avec une adresse m&eacute;l
	{
		$ch0 = array( 
		" "=>"-",
		"œ"=>"oe",
		"Œ"=>"OE",
		"æ"=>"ae",
		"Æ"=>"AE",
		"À" => "A",
		"Á" => "A",
		"Â" => "A",
		"Ã" => "A",
		"Ä" => "A",
		"Å" => "A",
		"&#256;" => "A",
		"&#258;" => "A",
		"&#461;" => "A",
		"&#7840;" => "A",
		"&#7842;" => "A",
		"&#7844;" => "A",
		"&#7846;" => "A",
		"&#7848;" => "A",
		"&#7850;" => "A",
		"&#7852;" => "A",
		"&#7854;" => "A",
		"&#7856;" => "A",
		"&#7858;" => "A",
		"&#7860;" => "A",
		"&#7862;" => "A",
		"&#506;" => "A",
		"&#260;" => "A",
		"à" => "a",
		"á" => "a",
		"â" => "a",
		"ã" => "a",
		"ä" => "a",
		"å" => "a",
		"&#257;" => "a",
		"&#259;" => "a",
		"&#462;" => "a",
		"&#7841;" => "a",
		"&#7843;" => "a",
		"&#7845;" => "a",
		"&#7847;" => "a",
		"&#7849;" => "a",
		"&#7851;" => "a",
		"&#7853;" => "a",
		"&#7855;" => "a",
		"&#7857;" => "a",
		"&#7859;" => "a",
		"&#7861;" => "a",
		"&#7863;" => "a",
		"&#507;" => "a",
		"&#261;" => "a",
		"Ç" => "C",
		"&#262;" => "C",
		"&#264;" => "C",
		"&#266;" => "C",
		"&#268;" => "C",
		"ç" => "c",
		"&#263;" => "c",
		"&#265;" => "c",
		"&#267;" => "c",
		"&#269;" => "c",
		"Ð" => "D",
		"&#270;" => "D",
		"&#272;" => "D",
		"&#271;" => "d",
		"&#273;" => "d",
		"È" => "E",
		"É" => "E",
		"Ê" => "E",
		"Ë" => "E",
		"&#274;" => "E",
		"&#276;" => "E",
		"&#278;" => "E",
		"&#280;" => "E",
		"&#282;" => "E",
		"&#7864;" => "E",
		"&#7866;" => "E",
		"&#7868;" => "E",
		"&#7870;" => "E",
		"&#7872;" => "E",
		"&#7874;" => "E",
		"&#7876;" => "E",
		"&#7878;" => "E",
		"è" => "e",
		"é" => "e",
		"ê" => "e",
		"ë" => "e",
		"&#275;" => "e",
		"&#277;" => "e",
		"&#279;" => "e",
		"&#281;" => "e",
		"&#283;" => "e",
		"&#7865;" => "e",
		"&#7867;" => "e",
		"&#7869;" => "e",
		"&#7871;" => "e",
		"&#7873;" => "e",
		"&#7875;" => "e",
		"&#7877;" => "e",
		"&#7879;" => "e",
		"&#284;" => "G",
		"&#286;" => "G",
		"&#288;" => "G",
		"&#290;" => "G",
		"&#285;" => "g",
		"&#287;" => "g",
		"&#289;" => "g",
		"&#291;" => "g",
		"&#292;" => "H",
		"&#294;" => "H",
		"&#293;" => "h",
		"&#295;" => "h",
		"î" => "i",
		"ï" => "i",
		"Ì" => "I",
		"Í" => "I",
		"Î" => "I",
		"Ï" => "I",
		"&#296;" => "I",
		"&#298;" => "I",
		"&#300;" => "I",
		"&#302;" => "I",
		"&#304;" => "I",
		"&#463;" => "I",
		"&#7880;" => "I",
		"&#7882;" => "I",
		"&#308;" => "J",
		"&#309;" => "j",
		"&#310;" => "K",
		"&#311;" => "k",
		"&#313;" => "L",
		"&#315;" => "L",
		"&#317;" => "L",
		"&#319;" => "L",
		"&#321;" => "L",
		"&#314;" => "l",
		"&#316;" => "l",
		"&#318;" => "l",
		"&#320;" => "l",
		"&#322;" => "l",
		"Ñ" => "N",
		"&#323;" => "N",
		"&#325;" => "N",
		"&#327;" => "N",
		"ñ" => "n",
		"&#324;" => "n",
		"&#326;" => "n",
		"&#328;" => "n",
		"&#329;" => "n",
		"Ò" => "O",
		"Ó" => "O",
		"Ô" => "O",
		"Õ" => "O",
		"Ö" => "O",
		"Ø" => "O",
		"&#332;" => "O",
		"&#334;" => "O",
		"&#336;" => "O",
		"&#416;" => "O",
		"&#465;" => "O",
		"&#510;" => "O",
		"&#7884;" => "O",
		"&#7886;" => "O",
		"&#7888;" => "O",
		"&#7890;" => "O",
		"&#7892;" => "O",
		"&#7894;" => "O",
		"&#7896;" => "O",
		"&#7898;" => "O",
		"&#7900;" => "O",
		"&#7902;" => "O",
		"&#7904;" => "O",
		"&#7906;" => "O",
		"ò" => "o",
		"ó" => "o",
		"ô" => "o",
		"õ" => "o",
		"ö" => "o",
		"ø" => "o",
		"&#333;" => "o",
		"&#335;" => "o",
		"&#337;" => "o",
		"&#417;" => "o",
		"&#466;" => "o",
		"&#511;" => "o",
		"&#7885;" => "o",
		"&#7887;" => "o",
		"&#7889;" => "o",
		"&#7891;" => "o",
		"&#7893;" => "o",
		"&#7895;" => "o",
		"&#7897;" => "o",
		"&#7899;" => "o",
		"&#7901;" => "o",
		"&#7903;" => "o",
		"&#7905;" => "o",
		"&#7907;" => "o",
		"ð" => "o",
		"&#340;" => "R",
		"&#342;" => "R",
		"&#344;" => "R",
		"&#341;" => "r",
		"&#343;" => "r",
		"&#345;" => "r",
		"&#346;" => "S",
		"&#348;" => "S",
		"&#350;" => "S",
		"Š" => "S",
		"&#347;" => "s",
		"&#349;" => "s",
		"&#351;" => "s",
		"š" => "s",
		"&#354;" => "T",
		"&#356;" => "T",
		"&#358;" => "T",
		"&#355;" => "t",
		"&#357;" => "t",
		"&#359;" => "t",
		"Ù" => "U",
		"Ú" => "U",
		"Û" => "U",
		"Ü" => "U",
		"&#360;" => "U",
		"&#362;" => "U",
		"&#364;" => "U",
		"&#366;" => "U",
		"&#368;" => "U",
		"&#370;" => "U",
		"&#431;" => "U",
		"&#467;" => "U",
		"&#469;" => "U",
		"&#471;" => "U",
		"&#473;" => "U",
		"&#475;" => "U",
		"&#7908;" => "U",
		"&#7910;" => "U",
		"&#7912;" => "U",
		"&#7914;" => "U",
		"&#7916;" => "U",
		"&#7918;" => "U",
		"&#7920;" => "U",
		"ù" => "u",
		"ú" => "u",
		"û" => "u",
		"ü" => "u",
		"&#361;" => "u",
		"&#363;" => "u",
		"&#365;" => "u",
		"&#367;" => "u",
		"&#369;" => "u",
		"&#371;" => "u",
		"&#432;" => "u",
		"&#468;" => "u",
		"&#470;" => "u",
		"&#472;" => "u",
		"&#474;" => "u",
		"&#476;" => "u",
		"&#7909;" => "u",
		"&#7911;" => "u",
		"&#7913;" => "u",
		"&#7915;" => "u",
		"&#7917;" => "u",
		"&#7919;" => "u",
		"&#7921;" => "u",
		"&#372;" => "W",
		"&#7808;" => "W",
		"&#7810;" => "W",
		"&#7812;" => "W",
		"&#373;" => "w",
		"&#7809;" => "w",
		"&#7811;" => "w",
		"&#7813;" => "w",
		"Ý" => "Y",
		"&#374;" => "Y",
		"Ÿ" => "Y",
		"&#7922;" => "Y",
		"&#7928;" => "Y",
		"&#7926;" => "Y",
		"&#7924;" => "Y",
		"ý" => "y",
		"ÿ" => "y",
		"&#375;" => "y",
		"&#7929;" => "y",
		"&#7925;" => "y",
		"&#7927;" => "y",
		"&#7923;" => "y",
		"&#377;" => "Z",
		"&#379;" => "Z",
		"Ž" => "Z",
		"&#378;" => "z",
		"&#380;" => "z",
		"ž" => "z"
		);
		$chaine = strtr($chaine,$ch0);
		return $chaine;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function wd_remove_accents($str, $charset='utf-8')
{
   echo "<br />1 - str : $str - charset : $charset";
   
    $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    echo "<br />2 - str : $str";
    return $str;
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
		if ($aujourdhui_mois == 2) //le mois de f&eacute;vrier et &agrave; traiter de fa�on diff&eacute;rente
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

		//echo "<br />extension : $extension";

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

			default :
				$image = "fichier_document.png";
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
		//echo "req_champ : $req_champ";
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
	function verif_doublon_participation_evenement($id_evenement, $id_participant)
	{
		//echo "<br />dans verif_identifiant";

		$requete_verif_doublon_participation_evenement = "SELECT * FROM evenements_participants WHERE id_evenement = '".$id_evenement."' AND id_participant = '".$id_participant."'";
		$execution= mysql_query($requete_verif_doublon_participation_evenement);
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

			//S'il existe on ajoute un indice que l'on teste jusqu'� obtention d'un identifiant valable
			if ($verif_identifiant <> 0)
			{
				$indice ++;
				if ($script <> "inscription")
				{
					echo "<h2>l'identifiant $identifiant existe d&eacute;j&agrave;, essayez un autre&nbsp;!</h2>";
				}
				//On ajoute un indice et on v�rifie � nouveau
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
	function genere_initiales($prenom,$nom)
	{
		//echo "<br />dans genere_identifiant";
		//on construit les initiales
		$initiales = strtoupper($prenom{0}).strtoupper($nom{0});

		//echo "<br />initiales : $initiales";
		return $initiales;
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
			//echo "<br>nombre d'�l�ments dans le tableau : $nombre_elements";
			$i = 0; //on d�finit la variable $i qui sera notre nombre que l'on incr�mentera. Ici $i va commencer � 0
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
	function recupPerDir($fonction,$rne,$annee_scolaire) //Permet de r�cup�r�r les informations sur les PerDir d'un �tablissement donn�
	{
		IF ($fonction == 1)
		{
			$complement_requete = "Fonction = 'DIR' OR Fonction = 'PRINC' OR Fonction = 'PROV'";
		}
		else
		{
			$complement_requete = "Fonction = 'DIR-ADJ' OR Fonction = 'PRINC-ADJ' OR Fonction = 'PROV-ADJ'";
		}
		$requete="SELECT Nom, Prenom, annee_scolaire, Fonction, Civilite FROM perdir WHERE RNE = '".$rne."' AND annee_scolaire = '".$annee_scolaire."' AND (".$complement_requete.")";

		//echo "$requete";

		$execution= mysql_query($requete);
		$res = mysql_fetch_row($execution);
		return $res;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function remplir_champ_select($intitule,$nom_table,$intitule_champ,$nom_champ,$valeur_selectionne)
	{
		/*
		echo "<br />fonction remplir_champ_select";
		echo "<br >intitule : $intitule";
		echo "<br /> nom_table : $nom_table";
		echo "<br />intitule_champ : $intitule_champ";
		echo "<br />nom_champ : $nom_champ";
		echo "<br />valeur_selectionne : $valeur_selectionne";
		*/

		$requete="SELECT * FROM $nom_table WHERE actif = 'O' ORDER BY $intitule";

		//echo "<br />requete : $requete<br />";

		$result=mysql_query($requete);
		$num_rows = mysql_num_rows($result);

		//echo "<br />num_rows : $num_rows<br />";

		echo "$intitule_champ<select size=\"1\" name=\"$nom_champ\">";
		if ($valeur_selectionne <> "")
		{
			echo "<option selected value=\"$valeur_selectionne\">$valeur_selectionne</option>";
		}

		if (mysql_num_rows($result))
		{
			//pr�voir de tester l'intitul� s�lectionn�
			while ($ligne=mysql_fetch_object($result))
			{
				$intitule_recupere=$ligne->$intitule;
				if ($valeur_selectionne <> $intitule_recupere)
				{
					echo "<option value=\"$intitule_recupere\">$intitule_recupere</option>";
				}
			}
		}
		else
		{
			mysql_free_result($result);
			//mysql_close();
		}
		echo "</select>";
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function remplir_champ_select_par_annee($intitule_champ,$nom_champ,$champ1,$champ2,$nom_table,$valeur_selectionne,$intitule_valeur_selectionne,$champ_condition,$condition, $tri)
	{
		$requete="SELECT * FROM $nom_table WHERE $champ_condition = $condition ORDER BY $tri";

		//echo "<br />requete : $requete<br />";
		//echo "<br />valeur_selectionne : $valeur_selectionne";
		//echo "<br />intitule_valeur_selectionne : $intitule_valeur_selectionne";

		$result=mysql_query($requete);
		$num_rows = mysql_num_rows($result);

		//echo "<br />num_rows : $num_rows<br />";

		echo "$intitule_champ<select size=\"1\" name=\"$nom_champ\">";
/*
		if ($valeur_selectionne <> "")
		{
			echo "<option selected value=\"$valeur_selectionne\">$intitule_valeur_selectionne</option>";
		}
*/
		if($valeur_selectionne == '')
		{
			echo "<option selected value=\"$valeur_selectionne\">$intitule_valeur_selectionne</option>";
		}
		else
		{
			echo "<option selected value=\"$valeur_selectionne\">$valeur_selectionne - $intitule_valeur_selectionne&nbsp;&euro;</option>";
		}
		if (mysql_num_rows($result))
		{
			//prévoir de tester l'intitulé sélectionné
			while ($ligne=mysql_fetch_object($result))
			{
				$valeur_champ1_recupere=$ligne->$champ1;
				$valeur_champ2_recupere=$ligne->$champ2;
				if ($valeur_champ1_recupere <> $valeur_selectionne)
				{
					echo "<option value=\"$valeur_champ1_recupere\">$valeur_champ1_recupere - $valeur_champ2_recupere&nbsp;&euro;</option>";
				}
			}
		}
		else
		{
			mysql_free_result($result);
			//mysql_close();
		}
		echo "</select>";

	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recup_accompagnateurs()
	{
		$requete_accompagnateurs =
		"SELECT * FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA, util AS U
			WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CPA.FK_ID_UTIL = U.ID_UTIL
				AND CP.NUM_PROJET = $id_projet
			ORDER BY U.NOM";

		$resultat2 = mysql_query($requete_accompagnateurs);
		$nbr_enreg = mysql_num_rows($resultat2);
		$compteur = 0;
		$noms_a_aficher ="";
		while ($ligne = mysql_fetch_object($resultat2))
		{
			$compteur++;
			$nom = $ligne->NOM;
			if ($compteur < $nbr_enreg)
			{
				echo "$nom - ";
			}
			else
			{
				echo "$nom";
			}
		}
		return $noms_a_afficher;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recup_structure_util($id_util)
	{
		$requete_structures =
		"SELECT * FROM util_structures_util AS USU, util_structures AS US
			WHERE USU.FK_id_structure = US.id_structure
				AND USU.FK_id_util = $id_util
			ORDER BY US.intitule_structure";

		$resultat = mysql_query($requete_structures);
		$nbr_enreg = mysql_num_rows($resultat);
		$compteur = 0;
		$structure_a_afficher ="";
		while ($ligne = mysql_fetch_object($resultat))
		{
			$compteur++;
			$intitule_structure = $ligne->intitule_structure;
			if ($compteur < $nbr_enreg)
			{
				echo "$intitule_structure - ";
			}
			else
			{
				echo "$intitule_structure";
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recup_structure_util2($id_util)
	{
		$compteur = 0;
		$requete_structures =
		"SELECT * FROM util_structures_util AS USU, util_structures AS US
			WHERE USU.FK_id_structure = US.id_structure
				AND USU.FK_id_util = $id_util
			ORDER BY US.id_structure";

		$resultat = mysql_query($requete_structures);
		$nbr_enreg = mysql_num_rows($resultat);
		$structures ="(";
		while ($ligne = mysql_fetch_object($resultat))
		{
			$compteur++;
			$id_structure = $ligne->id_structure;
			if ($compteur < $nbr_enreg)
			{
				$structures .= "'".$id_structure."',";
			}
			else
			{
				$structures .= "'".$id_structure."')";
			}
		}
		Return $structures;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_util_droit($initiales,$niveau_droits,$prenom,$nom)
	{
		echo "<span title=\"$prenom&nbsp;$nom\">$initiales</span>&nbsp;($niveau_droits)";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function bulle_d_aide($texte_a_afficher,$bulle)
	{
		echo "<span title=\"$bulle\">$texte_a_afficher</span>";
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recup_intitule_etat_visite_cardie($code)
	{
		//echo "<br />etat : $etat";

		$requete_intitule_etat =
		"SELECT INTITULE FROM cardie_visite_etats AS CVE WHERE CVE.CODE ='".$code."'";

		//echo "<br />$requete_intitule_etat";

		$resultat_requete_intitule_etat = mysql_query($requete_intitule_etat);
		$ligne_etat = mysql_fetch_object($resultat_requete_intitule_etat);
		$intitule_etat_extrait = $ligne_etat->INTITULE;

		//echo "<br />intitule_etat_extrait : $intitule_etat_extrait";

		RETURN $intitule_etat_extrait;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_date($date)
	{

		$date = strtotime($date);
		$date_a_afficher = date('d/m/y',$date);
		RETURN $date_a_afficher;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function calcul_no_ordre_visite($id_visite,$num_projet)
	{
		$requete =
		"SELECT CV.FK_NUM_PROJET, CV.ID_VISITE, CV.DATE_VISITE, CV.HORAIRE_VISITE FROM cardie_visite AS CV, cardie_projet AS CP
			WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
				AND CP.NUM_PROJET = '".$num_projet."'
			ORDER BY CV.DATE_VISITE";

		$resultat = mysql_query($requete);

		$compteur = 0;
		while ($ligne = mysql_fetch_object($resultat))
		{
			$compteur++;
			$id_visite_extrait = $ligne->ID_VISITE;
			if ($id_visite_extrait == $id_visite)
			{
				$no_ordre = $compteur;
				Return $no_ordre;
				break;
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function alimente_visite_historique($id_visite,$etat)
	{
		//On compose la date
		$jour = date('d');
		$mois = date('m');
		$annee = date('Y');

		$date_a_enregistrer = crevardate($jour,$mois,$annee);

		$requete_enreg = "INSERT INTO cardie_visites_historique
		(
		`DATE`,
		`FK_ID_VISITE`,
		`ETAT`
		)
		VALUES
		(
			'".$date_a_enregistrer."',
			'".$id_visite."',
			'".$etat."'
		);";
		$result_enreg = mysql_query($requete_enreg);
		if (!$result_enreg)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
		else
		{
			//echo "<h2>Le projet a bien &eacute;t&eacute; ajout&eacute;</h2>";
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function alimente_ef_historique($id_ef,$etat)
	{
		//On compose la date
		$jour = date('d');
		$mois = date('m');
		$annee = date('Y');

		$date_a_enregistrer = crevardate($jour,$mois,$annee);

		$requete_enreg = "INSERT INTO cardie_visites_ef_historique
		(
		`DATE`,
		`FK_ID_EF`,
		`ETAT`
		)
		VALUES
		(
			'".$date_a_enregistrer."',
			'".$id_ef."',
			'".$etat."'
		);";
		$result_enreg = mysql_query($requete_enreg);
		if (!$result_enreg)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
		else
		{
			//echo "<h2>Le projet a bien &eacute;t&eacute; ajout&eacute;</h2>";
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function compte_projets($id_accompagnateur,$type_accompagnement)
	{
		$requete_base = "SELECT * FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA
			WHERE CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CPA.FK_ID_PERS_RESS = $id_accompagnateur";

		if ($type_accompagnement == "T")
		{
			$complement_requete = "";
		}
		else
		{

			$complement_requete = " AND CP.TYPE_ACCOMPAGNEMENT = '".$type_accompagnement."'";
		}

		$requete_finale = $requete_base.$complement_requete;

		//echo "<br />$requete_finale<br />";

		$resultat = mysql_query ($requete_finale);
		$nombre_enregistrements = mysql_num_rows($resultat);

		RETURN $nombre_enregistrements;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function compte_visites($id_accompagnateur)
	{
		$requete = "SELECT * FROM cardie_projet AS CP, cardie_projet_accompagnement AS CPA, cardie_visite AS CV
			WHERE CP.NUM_PROJET = CV.FK_NUM_PROJET
				AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CPA.FK_ID_PERS_RESS = $id_accompagnateur";

		//echo "<br />$requete";

		$resultat = mysql_query ($requete);
		$nombre_enregistrements = mysql_num_rows($resultat);

		RETURN $nombre_enregistrements;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function fc_datalist($table,$champ,$nom_variable,$valeur_selectionnee,$taille_champ,$intitule_champ,$placeholder,$nom_liste)
	{
		$requete = "SELECT $champ FROM $table GROUP BY $champ ORDER BY $champ";

		//echo "<br />$requete<br />";

		$res_req = mysql_query($requete);
		$nb_res = mysql_num_rows($res_req);

		//echo "<br />nb_res : $nb_res<br />";

		echo "<label>&nbsp;$intitule_champ&nbsp;:&nbsp;</label>";

		echo "<input list=\"$nom_liste\" type=\"text\" name = \"$nom_variable\" VALUE = \"$valeur_selectionnee\" SIZE = \"$taille_champ\" placeholder=\"$placeholder\">";
		echo "<datalist id=\"$nom_liste\">";
			while ($ligne = mysql_fetch_object($res_req))
			{
				$valeur_extraite = $ligne->$champ;
				if ($valeur_extraite <> "")
				{
					echo "<option value=\"$valeur_extraite\">";
				}
			}
		echo "</datalist>";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function fc_verif_visite_sans_ef()
	{
		//Il faut r�cup�rer l'identifiant de la table persoinnes_ressources_tice de l'accompagnateur connect�
		//On extrait la partie avant l'@ de la adresse �lectronique
		$adresse_electronique = $_SESSION['mail'];
		$debut_adresse_electronique = explode("@", $adresse_electronique);
		$mel_pers_ress = $debut_adresse_electronique[0];
		/*
		echo "<br />adresse &eacute;lectronique : $adresse_electronique";
		echo "<br />mel_pers_ress = $mel_pers_ress";
		*/
		$requete_id_pers_ress = "SELECT * FROM personnes_ressources_tice WHERE mel = '".$mel_pers_ress."'";

		//echo "<br />requete_id_pers_ress : $requete_id_pers_ress";

		$resultat = mysql_query($requete_id_pers_ress);
		$ligne = mysql_fetch_object($resultat);
		$id_pers_ress = $ligne->id_pers_ress;

		//echo "<br />id_pers_ress = $id_pers_ress";


		$requete = "SELECT * FROM cardie_visite AS CV LEFT JOIN cardie_etats_frais AS CEF ON CV.ID_VISITE = CEF.FK_ID_VISITE, cardie_projet AS CP, cardie_projet_accompagnement AS CPA
			WHERE CV.FK_NUM_PROJET = CP.NUM_PROJET
				AND CP.NUM_PROJET = CPA.FK_NUM_PROJET
				AND CV.ETAT = '4'
				AND CPA.FK_ID_PERS_RESS = $id_pers_ress
				AND FK_ID_VISITE IS NULL
			ORDER BY CV.DATE_VISITE, CV.HORAIRE_VISITE";

		//echo "<br />$requete<br />";

		$res_req = mysql_query($requete);
		$nb_res = mysql_num_rows($res_req);

		//echo "<br />nb_res : $nb_res<br />";
		RETURN $nb_res;

		/*

		echo "<label>&nbsp;$intitule_champ&nbsp;:&nbsp;</label>";

		echo "<input list=\"$nom_liste\" type=\"text\" name = \"$nom_variable\" VALUE = \"$valeur_selectionnee\" SIZE = \"$taille_champ\" placeholder=\"$placeholder\">";
		echo "<datalist id=\"$nom_liste\">";
			while ($ligne = mysql_fetch_object($res_req))
			{
				$valeur_extraite = $ligne->$champ;
				if ($valeur_extraite <> "")
				{
					echo "<option value=\"$valeur_extraite\">";
				}
			}
		echo "</datalist>";
		*/
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function comptage_nbr_enregistrements_d_une_table($table,$champ_condition,$condition) //Permet de compter le nombre d'enregistrements d'une table en fonction d'une condition
	function comptage_nbr_enregistrements_d_une_table($table,$condition) //Permet de compter le nombre d'enregistrements d'une table en fonction d'une condition
	{
		//echo "<br />table : $table";
		//echo "<br />champ_condition : $champ_condition";
		//echo "<br />condition : $condition";
		
		//echo "<br />SELECT COUNT(*) FROM $table WHERE $condition";
		
		$result = mysql_query("SELECT COUNT(*) FROM $table WHERE $condition");
		//echo mysql_result($result, 0);
		return mysql_result($result, 0);
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function pour afficher le bouton retour //
	function affiche_bouton_retour($script,$image) //Permet de compter le nombre d'enregistrements d'une table en fonction d'une condition
	{
		echo "<div align = \"center\">";
			echo "<table class = \"menu-boutons\">";
				echo "<tr>";
					echo "<td>";
						echo "<a href = \"$script\"><img height=\"$hauteur_icone_menu\" width=\"$largeur_icone_menu\" src = \"$image\" ALT = \"Retour\" border = \"0\"></a><br /><span class=\"IconesAvecTexte\">Retour</span><br />";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function remplace_caracteres_vers_code_html($chaine)
	{
		$chaine_convertie = str_replace("'", "&#39;", $chaine);
		$chaine_convertie = str_replace("é", "&eacute;", $chaine_convertie);
		//$chaine_convertie = str_replace("t", "v", $chaine_convertie);
		return $chaine_convertie;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function affiche_lieu_evenement($fk_rne, $fk_repertoire, $autre_lieu)
	{
		if ($fk_rne <> "")
		{
			$type_ecl = lecture_champ("etablissements","TYPE","RNE",$fk_rne);
			$nom_ecl = lecture_champ("etablissements","NOM","RNE",$fk_rne);
			$ville_ecl = lecture_champ("etablissements","VILLE","RNE",$fk_rne);
			echo "$type_ecl $nom_ecl, $ville_ecl";
		}
		if ($fk_repertoire <> 0)
		{
			$nom_societe = lecture_champ("repertoire","societe","No_societe",$fk_repertoire);
			$ville_societe = lecture_champ("repertoire","ville","No_societe",$fk_repertoire);
			echo "$nom_societe, $ville_societe";
		}
		if ($autre_lieu <> "")
		{
			echo "$autre_lieu";
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function etat_om($etat_om)
	{
		switch ($etat_om) //on vérifie l'état de l'OM
		{
			case "-1":
				$classe_etat_om = "om_sans";
			break;

			case "0":
				$classe_etat_om = "om_NonEdite";
			break;

			case "1":
				$classe_etat_om = "om_edite";
			break;

			case "2":
				$classe_etat_om = "om_marquer_remis_signature";
			break;

			case "3":
				$classe_etat_om = "om_envoye";
			break;

			case "4":
				$classe_etat_om = "om_present";
			break;

			case "5":
				$classe_etat_om = "om_absent";
			break;

			case "6":
				$classe_etat_om = "om_valide";
			break;

			case "7":
				$classe_etat_om = "om_revise";
			break;

			case "8":
				$classe_etat_om = "om_refuse";
			break;

			case "9":
				$classe_etat_om = "ef_cree";
			break;

			case "10":
				$classe_etat_om = "ef_valide";
			break;

			case "11":
				$classe_etat_om = "ef_revise";
			break;

			case "12":
				$classe_etat_om = "ef_refuse";
			break;

			case "13":
				$classe_etat_om = "ef_annule";
			break;

			case "14":
				$classe_etat_om = "ef_paye";
			break;
		}
		return $classe_etat_om;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function etat_om_en_clair($etat_om)
	{
		switch ($etat_om) //on affiche le statut en clair
		{
			case "-1":
				$etat_om_en_clair = " Sans OM";
			break;

			case "0":
				$etat_om_en_clair = " OM Non &eacute;dit&eacute";
			break;

			case "1":
				$etat_om_en_clair = "OM &eacute;dit&eacute";
			break;

			case "2":
				$etat_om_en_clair = "OM &agrave; la signature";
			break;

			case "3":
				$etat_om_en_clair = "OM envoy&eacute";
			break;

			case "4":
				$etat_om_en_clair = "OM pr&eacute;sent-e&nbsp;";
			break;

			case "5":
				$etat_om_en_clair = "OM absent-e&nbsp;";
			break;

			case "6":
				$etat_om_en_clair = "OM valid&eacute;";
			break;

			case "7":
				$etat_om_en_clair = "OM r&eacute;vis&eacute;";
			break;

			case "8":
				$etat_om_en_clair = "OM refus&eacute;";
			break;

			case "9":
				$etat_om_en_clair = "EF cr&eacute;&eacute;";
			break;

			case "10":
				$etat_om_en_clair = "EF valid&eacute;";
			break;

			case "11":
				$etat_om_en_clair = "EF r&eacute;vis&eacute;";
			break;

			case "12":
				$etat_om_en_clair = "EF refus&eacute;";
			break;

			case "13":
				$etat_om_en_clair = "EF annul&eacute;";
			break;

			case "14":
				$etat_om_en_clair = "EF pay&eacute;";
			break;
		}
		return $etat_om_en_clair;
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enreg_suivi_om($id_evenement,$type_suivi,$remarque_suivi)
	{
		/*
		echo "<br />id_evenement : $id_evenement";
		echo "<br />type_suivi : $type_suivi";
		echo "<br />remarque_suivi : $remarque_suivi";
		*/
		$requete_ajout_suivi = "INSERT INTO evenements_participants_suivis (fk_id_evenement, type_suivi, detail_suivi)
		VALUES ('".$id_evenement."','".$type_suivi."','".$remarque_suivi."');";

		//echo "<br />requete_ajout_suivi : $requete_ajout_suivi";

		$resultat_ajout_suivi = mysql_query($requete_ajout_suivi);
		if(!$resultat_ajout_suivi)
		{
			echo "<b>Probl&egrave;me dans la connexion a la base de donn&eacute;es et/ou l'execution de la requ&egrave;te</b>";
			mysql_close();
			exit;
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function supp_suivi_om($id_evenement)
	{
		//echo "<br />id_evenement : $id_evenement";
		$requete_suppression = "DELETE FROM evenements_participants_suivis WHERE fk_id_evenement =".$id_evenement."";
		
		//echo "<br />$requete_suppression";
		
		$resultat_suppression = mysql_query($requete_suppression);
		if(!$resultat_suppression)
		{
			echo "<h2>Erreur</h2>";
		}
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function recup_id_evenement_participant($id_evenement, $id_participant)
	{
	
		//On récupère les informations sur le participant à convoquer
		$requete = "SELECT id FROM evenements_participants
		WHERE id_participant = $id_participant
			AND id_evenement = $id_evenement";
		
		//echo "<br />$requete"; 
		$resultat = mysql_query($requete);

		$ligne = mysql_fetch_object($resultat);
		//$id_ep = $ligne->id;
		return $ligne->id;
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function maj_evenement_participant($id_evenement, $id_participant, $champ, $contenu)
	{
		$requete_maj = "UPDATE evenements_participants SET `$champ` = '".$contenu."' WHERE id_evenement ='".$id_evenement."' AND id_participant = '".$id_participant."'";
		$resultat_maj = mysql_query($requete_maj);
		if (!$resultat_maj)
		{
			echo "<h2>Erreur lors de l'enregistrement</h2>";
		}
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function calcul_somme_champ($champ, $annee)
	{
		/*
		$sql = "SELECT SUM($champ) AS total FROM evenements_participants AS ep, evenements AS e
			WHERE ep.id_evenement = e.id_evenement AND e.annee = $annee";
		*/
		$sql = "SELECT SUM($champ) AS total FROM evenements_participants
			WHERE annee_imputation = $annee";
		
		//echo "<br />$sql";
		
		$req = mysql_query($sql) or die('Erreur : '.mysql_query());
		$data = mysql_fetch_assoc($req);
		RETURN $data['total'];
	}

?>
