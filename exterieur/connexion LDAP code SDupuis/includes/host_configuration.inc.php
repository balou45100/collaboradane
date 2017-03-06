<?php
   // Dossier d'installation du script.
	$base_dir = '/var/www/redirection';
	
	// Dossier pour les attentes d'activation
	$temp_dir = $base_dir.'/temp';
	
	// nom d'hôte fourni dans l'URL.
	$hosts = explode(",",$_SERVER["HTTP_X_FORWARDED_HOST"]);
	$host = $hosts[0];
	
	// nom d'hôte en ptaf (utile pour récupérer le nom de l'établissement
	// en cas de nom de domaine externe).
	$host_private = $_SERVER['HTTP_HOST'];
	
	// URI vers le script.
	$uri = $_SERVER['REQUEST_URI'];

   // Nom de l'établissement.
	$etab = substr($host_private,0,strpos($host_private,'.'));
	
	// Nom d'hôte en taf.
	$host_taf = $etab.'.tice.ac-orleans-tours.fr';
	
	// Nom du script.
	$self = $_SERVER['PHP_SELF'];
	
	// URL d'accès au script.
	$script_url = 'http://'.$host.$self;
	
	// On vérifie que les requettes viennent bien du script.
	$referer = $_SERVER['HTTP_REFERER'];
	if (($referer <> 'http://'.$host)
	 && ($referer <> $script_url))
		$bad_referer = true;
	else
		$bad_referer = false;
?>