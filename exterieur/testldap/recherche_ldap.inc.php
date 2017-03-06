<?php
	$pwd = $_POST['pwd'];
	$uid = $_POST['uid'];
	$ldap_server = $_POST['ldap_server'];
	$ldap_dn = $_POST['ldap_dn'];
	$ldap_dnf = $_POST['ldap_dnf'];
	$ldap_dna = $_POST['ldap_dna'];
	
	echo "<br />uid : $uid";
	echo "<br />recherche_ldap.inc.php";
	echo "<br />ldap_server : $ldap_server";
	echo "<br />ldap_dn : $ldap_dn";
	echo "<br />ldap_dnf : $ldap_dnf";
	echo "<br />ldap_dna : $ldap_dna";
	//echo "<br />pwd : $pwd";

	// Vérification de la connectivité avec le serveur ldap.
	$ldap_conn = ldap_connect($ldap_server);
	
	//echo "<br />ldap_conn : $ldap_conn";
	
	if (!$ldap_conn)
		die('<br />Impossible de se connecter au serveur ldap '.$ldap_server);
	
	// Vérification des paramètres d'authentification
	// pour un personnel... 
	//$dn = 'uid='.$uid.','.$ldap_dn;
	$dn = 'uid='.$_POST['uid'].','.$ldap_dn;
	$auth = @ldap_bind($ldap_conn,$dn,$_POST['pwd']);
	//$auth = @ldap_bind($ldap_conn,$dn);
	
	echo "<br />1 - auth : $auth";
	
	// ou pour une boîte fonctionnelle. 
	if (!$auth)
	{
		$dn = 'uid='.$_POST['uid'].','.$ldap_dnf;
		$auth = @ldap_bind($ldap_conn,$dn,$_POST['pwd']);
	}
	
	if (!$auth)
	{
		$dn = 'uid='.$_POST['uid'].','.$ldap_dna;
		$auth = @ldap_bind($ldap_conn,$dn,$_POST['pwd']);
	}

	if ($auth)  // Si l'authentification a fonctionné...
	{
		//echo "<br />2 - auth";
		//$_SESSION['auth_status'] = 'auth';  // L'utilisateur est authentifié.
	   
		// On récupère l'adresse mail, le RNE de l'établissement et la discipline de l'utilisateur.
		$filtre = '(|(uid='.$_POST['uid'].'))';
		$attr = array ('mail','rneextract','discipline','cn','sn','givenname','profilbv','finfonction','codecivilite','dateFF');
		$result = ldap_search($ldap_conn,$dn,$filtre,$attr);
		$info = ldap_get_entries($ldap_conn,$result);
		ldap_unbind($ldap_conn);
		
		$civilite_utilisateur = $info[0]['codecivilite'][0];
		$nom_complet_utilisateur = $info[0]['cn'][0];
		$nom_utilisateur = $info[0]['sn'][0];
		$prenom_utilisateur = $info[0]['givenname'][0];
		$mail_utilisateur = $info[0]['mail'][0];
		$discipline_utilisateur = $info[0]['discipline'][0];
		$rne_utilisateur = $info[0]['rneextract'][0];
		$statut_utilisateur = $info[0]['profilbv'][0];
		$fin_fonction_utilisateur = $info[0]['finfonction'][0];
		$date_fin_fonction_utilisateur = $info[0]['dateFF'][0];
		
		
		echo "<br />civilite_utilisateur : $civilite_utilisateur";
		echo "<br />nom_complet_utilisateur : $nom_complet_utilisateur";
		echo "<br />nom_utilisateur : $nom_utilisateur";
		echo "<br />prenom_utilisateur : $prenom_utilisateur";
		echo "<br />mail_utilisateur : $mail_utilisateur";
		echo "<br />rne_utilisateur : $rne_utilisateur";
		echo "<br />discipline_utilisateur : $discipline_utilisateur";
		echo "<br />statut_utilisateur : $statut_utilisateur";
		echo "<br />fin_fonction_utilisateur : $fin_fonction_utilisateur";
		echo "<br />fin_fonction_utilisateur : $fin_fonction_utilisateur";
		
		/*
		if ($_SESSION['RNE'] == strtolower($info[0]['rneextract'][0]))
		{
			$_SESSION['auth_status'] = 'etab'; // L'utilisateur fait partie de l'établissement au quel est rattaché le site. 
		}
		
		// On vérifie si l'utilisateur est un webmestre.
		// Avec l'adresse mail.
		if ( count($_SESSION['webmestre']['mail']) > 0)
			foreach($_SESSION['webmestre']['mail'] as $mail)
			{
				if ($mail == strtolower($_SESSION['mail_utilisateur']))
					$_SESSION['auth_status'] = 'webm'; // L'utilisateur est un webmestre du site
			}

		// On vérifie si l'utilisateur est un responsable.
		// Avec l'adresse mail...
		if ( count($_SESSION['responsable']['mail']) > 0)
			foreach($_SESSION['responsable']['mail'] as $mail)
			{
				if ($mail == strtolower($_SESSION['mail_utilisateur']))
					$_SESSION['auth_status'] = 'resp'; // L'utilisateur est un responsable du site
			}
		// Sinon avec le RNE et la discipline.
		if (!$_SESSION['auth_status'] == 'none')
		{
			if (($_SESSION['RNE'] == strtolower($info[0]['rneextract'][0])) 
			&&  ((strtoupper($info[0]['discipline'][0]) == 'D0010')    // Proviseur ou Principal
			||   (strtoupper($info[0]['discipline'][0]) == 'D0011')))  // Adjoint
			{
				$_SESSION['auth_status'] = 'resp'; // L'utilisateur est un responsable du site
			}
		}
		if (($_SESSION['auth_status'] == 'webm')
		|| ($_SESSION['auth_status'] == 'resp'))
		{
			$_SESSION['connecte'] = true; // Connexion réussie.
			$auth_error = 0;
		}
		else
			$auth_error = 3;  // l'authentification a réussi mais l'utilisateur n'est pas autoriser à se connecter.
		*/
	}
	else
	{
		//$auth_error = 2;  // L'identifiant et/ou le mot de passe ne sont pas bons.
		echo "<br />l'authentification a échouée";

	}
?>
