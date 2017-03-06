<?php
	session_start();
	
	if ($_POST['deconnecte'] // Si on demande à se deconnecté...
	 || empty($_SESSION['connecte'])  // ou si c'est la première visite sur la page ...
	 || $bad_referer)  // ou si la page appelante n'est pas le script lui même...
	{
		session_unset();  // Alors on réinitialise les variables de session.
		session_regenerate_id();
		$_SESSION['connecte'] = false;
	}
	
	if (empty($_SESSION['auth_status']))
	{
	  $_SESSION['auth_status'] = 'none';
	  //  none : l'utilisateur n'est pas authentifié
	  //  auth : l'utilisateur est authentifié, mais pas identifié
	  //  etab : l'utilisateur est identifié comme appartenant à l'établissement de rattachement du site
	  //  webm : l'utilisateur est identifié comme webmestre du site
	  //  resp : l'utilisateur est identifié comme un responsable du site
	}
	
	if (empty($_SESSION['nom_utilisateur']))
	{
	  $_SESSION['nom_utilisateur'] = '';
	}
	
   if (empty($_SESSION['mail_utilisateur']))
	{
	  $_SESSION['mail_utilisateur'] = '';
	}

	
	if (empty($_SESSION['responsable']) // Si les variables liées à la session ne sont pas définies...
	 || empty($_SESSION['webmestre']) 
	 || empty($_SESSION['RNE'])
	 || empty($_SESSION['site'])
	 || empty($_SESSION['defaut']))
	{
	   // Lecture des responsables dans la base "sites".
		mysql_connect($mysql_server,$mysql_user,$mysql_pwd);
		mysql_select_db($db_name);
		$query = 'select `prenom`,`nom`,`email` from `responsable` where `id_responsable` in ';
		$query .= '(select `id_responsable` from `responsable_site` where `id_site` in ';
		$query .= '(select `id_site` from `site` where `nom_dossier` like "'.$etab.'")) ';
		$query .= 'order by `nom` asc;';
		$result = mysql_query($query);
		if (!$result)
		{
			die('Impossible d\'exécuter la requête :'.mysql_error());
		}
		$_SESSION['responsable'] = array();
		for ($i=0;$i<mysql_num_rows($result);$i++)
		{
			$_SESSION['responsable']['nom'][] = htmlentities(mysql_result($result,$i,0).' '.mysql_result($result,$i,1));
			$_SESSION['responsable']['mail'][] = trim(strtolower(mysql_result($result,$i,2)));
		}
		
		// Lecture des webmestres dans la base "sites".
		mysql_connect($mysql_server,$mysql_user,$mysql_pwd);
		mysql_select_db($db_name);
		$query = 'select `prenom`,`nom`,`email` from `webmestre` where `id_webmestre` in ';
		$query .= '(select `id_webmestre` from `webmestre_site` where `id_site` in ';
		$query .= '(select `id_site` from `site` where `nom_dossier` like "'.$etab.'")) ';
		$query .= 'order by `nom` asc;';
		$result = mysql_query($query);
		if (!$result)
		{
			die('Impossible d\'ex&eacute;cuter la requ&ecirc;te :'.mysql_error());
		}
		$_SESSION['webmestre'] = array();
		for ($i=0;$i<mysql_num_rows($result);$i++)
		{
			$_SESSION['webmestre']['nom'][] = htmlentities(mysql_result($result,$i,0).' '.mysql_result($result,$i,1));
			$mail_tmp = trim(strtolower(mysql_result($result,$i,2)));
			if (! strpos($mail_tmp,'@ac-orleans-tours.fr'))
			{
				$mail_tmp = 'Adresse non valide';
			}
			$_SESSION['webmestre']['mail'][] = $mail_tmp;
		}
		
		// Lecture du RNE de l'établissement dans la base "sites".
		$query = 'select `RNE` from `site` where `nom_dossier` like "'.$etab.'";';
		$result = mysql_query($query);
		if (!$result)
		{
			die('Impossible d\'ex&eacute;cuter la requ&ecirc;te :'.mysql_error());
		}
		$_SESSION['RNE'] = strtolower(mysql_result($result,0,0));
		
		// Lecture des différents sites hébergés pour l'établissement dans la base "sites"
		$query = 'select `url`,`nom_serveur` from `serveurs` ';
		$query .= 'where `id_serveur` in (select `serveur` from `site` where `nom_dossier` like "'.$etab.'" ';
		$query .= '                                                       or `nom_dossier` like "'.$etab.'/%") ';
		$query .= 'and `url` like "<nom_site>.%" ';
		$query .= ' order by `nom_serveur` asc;';
		$result = mysql_query($query);
		if (!$result)
		{
			die('Impossible d\'ex&eacute;cuter la requ&ecirc;te :'.mysql_error());
		}
		$_SESSION['site'] = array();
		for ($i=0;$i<mysql_num_rows($result);$i++)
		{
			//$tmp_site = str_replace('<nom_site>',$etab,trim(mysql_result($result,$i,0)));
			$tmp_site = trim(mysql_result($result,$i,0));
			$tmp_site = substr($tmp_site,strpos($tmp_site,'/',7)+1,-1);
			if ($tmp_site != '')
				$_SESSION['site'][] = $tmp_site; 
		}		
		sort($_SESSION['site'],SORT_STRING);
		mysql_close();
		
		// Recherche de l'indexe du site par defaut à partir du fichier index.php si il existe.
		// L'indexe est fixé à false si le fichier index.php (et donc le site par défaut) n'existe pas encore.
		$_SESSION['defaut'] = false;
		if (file_exists($base_dir.'/'.$etab.'/index.php'))
		{
			$index = fopen($base_dir.'/'.$etab.'/index.php','r');
			fgets($index);
			$tmp_def = fgets($index);
			fclose($index);
			for ($i=0;$i<count($_SESSION['site']);$i++)
				if (strpos($tmp_def,$_SESSION['site'][$i]) !== false)
				{
					$_SESSION['defaut'] = $i;
					break;
				}			
		}
		 
	}
	
	
	
?>