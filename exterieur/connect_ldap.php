<?php	// V�rification de la connectivit� avec le serveur ldap.
	$ldap_conn = ldap_connect($ldap_server);
	
	//echo "<br />ldap_conn : $ldap_conn";
	
	if (!$ldap_conn)
		die('<br />Impossible de se connecter au serveur ldap '.$ldap_server);
	
	// V�rification des param�tres d'authentification
	// pour un personnel... 
	//$dn = 'uid='.$uid.','.$ldap_dn;
	$dn = 'uid='.$uid.','.$ldap_dn;
	$auth = @ldap_bind($ldap_conn,$dn,$pwd);
	//$auth = @ldap_bind($ldap_conn,$dn);
	
	//echo "<br />1 - auth : $auth";
	
	// ou pour une bo�te fonctionnelle. 
	if (!$auth)
	{
		$dn = 'uid='.$uid.','.$ldap_dnf;
		$auth = @ldap_bind($ldap_conn,$dn,$pwd);
	}
	
	if (!$auth)
	{
		$dn = 'uid='.$uid.','.$ldap_dna;
		$auth = @ldap_bind($ldap_conn,$dn,$pwd);
	}
	?>