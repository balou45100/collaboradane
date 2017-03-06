<?php
   // Vérification de la connectivité avec le serveur ldap.
	$ldap_conn = ldap_connect($ldap_server);
	if (!$ldap_conn)
		die('Impossible de se connecter au serveur ldap '.$ldap_server);
	
	// Vérification des paramètres d'authentification
	// pour un personnel... 
	$dn = 'uid='.$_POST['uid'].','.$ldap_dn;
	$auth = @ldap_bind($ldap_conn,$dn,$_POST['pwd']);
	
	// ou pour une boîte fonctionnelle. 
	if (!$auth)
	{
		$dn = 'uid='.$_POST['uid'].','.$ldap_dnf;
		$auth = @ldap_bind($ldap_conn,$dn,$_POST['pwd']);
	}
	
	if ($auth)  // Si l'authentification a fonctionné...
	{
	   $_SESSION['auth_status'] = 'auth';  // L'utilisateur est authentifié.
	   
	   // On récupère l'adresse mail, le RNE de l'établissement et la discipline de l'utilisateur.
		$filtre = '(|(uid='.$_POST['uid'].'))';
		$attr = array ('mail','rneextract','discipline','cn');
		$result = ldap_search($ldap_conn,$dn,$filtre,$attr);
		$info = ldap_get_entries($ldap_conn,$result);
		ldap_unbind($ldap_conn);
		
		$_SESSION['nom_utilisateur'] = $info[0]['cn'][0];
		$_SESSION['mail_utilisateur'] = $info[0]['mail'][0];
		
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
	}
	else
	{
		$auth_error = 2;  // L'identifiant et/ou le mot de passe ne sont pas bons.
	}
?>