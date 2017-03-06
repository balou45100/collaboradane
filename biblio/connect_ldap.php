<?php	// Vérification de la connectivité avec le serveur ldap.
	echo "<br />connect_ldap.php";
	
	$ldap_conn = ldap_connect($ldap_server);
	
	//echo "<br />ldap_conn : $ldap_conn";
	
	if (!$ldap_conn)
		die('<br />Impossible de se connecter au serveur ldap '.$ldap_server);
	
	// Vérification des paramètres d'authentification
	// pour un personnel... 
	//$dn = 'uid='.$uid.','.$ldap_dn;
	$dn = 'login='.$login.','.$ldap_dn;
	$auth = @ldap_bind($ldap_conn,$dn,$password);
	//$auth = @ldap_bind($ldap_conn,$dn);
	
	//echo "<br />1 - auth : $auth";
	
	// ou pour une boîte fonctionnelle. 
	if (!$auth)
	{
		$dn = 'login='.$login.','.$ldap_dnf;
		$auth = @ldap_bind($ldap_conn,$dn,$password);
	}
	
	if (!$auth)
	{
		$dn = 'login='.$login.','.$ldap_dna;
		$auth = @ldap_bind($ldap_conn,$dn,$password);
	}
	?>
