<?php
	// Récupération du nouveau site par défaut.
	for ($i=0;$i<count($_SESSION['site']);$i++)
		if ($_POST['site'] == $_SESSION['site'][$i])
		{
			$_SESSION['defaut'] = $i;
			break;
		}

	// Si l'utilisateur est un responsable
	// on génére directement le .htaccess.
	if ($_SESSION['auth_status'] == 'resp')
	{
		if (!file_exists($base_dir.'/'.$etab))
			mkdir ($base_dir.'/'.$etab);
		$index = fopen($base_dir.'/'.$etab.'/index.php','w');
		fwrite($index,'<?php'."\n");
		fwrite($index,'$default = "'.$_SESSION['site'][$_SESSION['defaut']].'";'."\n");
		fwrite($index,'$urls = explode(",",$_SERVER["HTTP_X_FORWARDED_HOST"]);'."\n");
		fwrite($index,'$url = $urls[0];'."\n");
		fwrite($index,'$uri = $_SERVER["REQUEST_URI"];'."\n");
		fwrite($index,'header("Location: http://".$url."/".$default.$uri);'."\n");
		fwrite($index,'?>'."\n");
		fclose($index);
		
		// On envoie un mail de confirmation.
		$to      = $_SESSION['mail_utilisateur'];
		$subject = 'Confirmation - Redirection par défaut pour le site "'.$host.'"';
		$message = 	'Bonjour,<br />'."\n".
						'<br />'."\n".
						'Nous vous confirmons la mise en place d\'une redirection par défaut pour l\'adresse "<a href="http://'.$host.'/">http://'.$host.'/</a>".<br />'."\n".
						'<br />'."\n".
						'Cette addresse est désormais redirigée vers l\'adresse "<a href="http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/">http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/</a>".<br />'."\n".
						'<br />'."\n".
						'Cordialement.<br />'."\n".
						'<br />'."\n".
						'L\'équipe hébergement web de la Mission Académique TICE.<br />'."\n";

		$headers = 	'From: hebergement-web-tice@ac-orleans-tours.fr'."\n".
						'Reply-To: hebergement-web-tice@ac-orleans-tours.fr'."\n".
						'Content-type: text/html; charset=utf8'."\n";
		mail($to, $subject, $message, $headers); 		  
		
	}
	// Sinon, on envoie un mail aux responsables.
	else
	{
		if (!file_exists($base_dir.'/temp'))
			mkdir ($base_dir.'/temp');

		// Génération d'un identifiant unique.			
		$car = "abcdefghijklmnopqrstuvwxyz0123456789";
 		srand(time());
 		$j = 0;
 		do
 		{
 			$j++;
 			$id = '';
 			for ($i=0;$i<40;$i++)
				$id .= substr($car,rand(0,strlen($car)-1),1); 			
 		}
 		while ((file_exists($temp_dir.'/'.$id.'.inc.php')) && ($j < 10) );
 		
 		// Création d'un fichier contenant les infos sur la redirection.
 		$inc = fopen($temp_dir.'/'.$id.'.inc.php','w');
 		fwrite($inc,'<?php'."\n");
 		fwrite($inc,'$expire = '.(time ()+(48*3600)).';'."\n");
 		fwrite($inc,'$host_org = "'.$host.'";'."\n");
 		fwrite($inc,'$defaut = "'.$_SESSION['site'][$_SESSION['defaut']].'";'."\n");
 		fwrite($inc,'?>'."\n");
 		fclose($inc);
		
		// Envoie du mail d'activations aux responsables du site.
		$to = '';
		if ( count($_SESSION['responsable']['mail']) > 0)
			foreach ($_SESSION['responsable']['mail'] as $resp) // Affichage des responsables du sites.
				$to .= $resp.',';
		$to = substr($to,0,-1);
		
		$subject = 'Demande de redirection par défaut pour le site "'.$host.'"';
		$message = 	'Bonjour,<br />'."\n".
						'<br />'."\n".
						'vous recevez ce message de la part de l\'équipe hébergement de la Mission Académique TICE car vous êtes référencé chez nous comme responsable du site "'.$host.'".<br />'."\n".
						'Si par hasard ce n\'était plus (ou pas) le cas, merci de nous le signaler, et si possible de nous indiquer une personne à contacter.<br />'."\n".
						'<br />'."\n".
						'Une demande de redirection a été faite pour l\'adresse "<a href="http://'.$host.'/">http://'.$host.'/</a>".<br />'."\n".
						'Cette demande a été faite par '.$_SESSION['nom_utilisateur'].' (<a href="mailto:'.$_SESSION['mail_utilisateur'].'">'.$_SESSION['mail_utilisateur'].'</a>).<br />'."\n".
						'<br />'."\n".
						'Si vous activez cette redirection, l\'adresse "<a href="http://'.$host.'/">http://'.$host.'/</a>" sera désormais redirigée vers l\'adresse "<a href="http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/">http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/</a>".<br />'."\n".
						'<br />'."\n".
						'Pour activer cette redirection, cliquez sur le lien suivant :<br />'."\n".
						'<a href="http://'.$host.'/redirection/activer.php?id='.$id.'">http://'.$host.'/redirection/activer.php?id='.$id.'</a>,<br />'."\n".
						'ou copiez-le dans la barre d\'adresse de votre navigateur.<br />'."\n".
						'<br />'."\n".
						'Pour ne pas activer cette redirection, vous n\'avez rien à faire. La demande sera automatiquement annulée dans 48h.<br />'."\n".
						'<br />'."\n".
						'Cordialement.<br />'."\n".
						'<br />'."\n".
						'L\'équipe hébergement web de la Mission Académique TICE.<br />'."\n";

		$headers = 	'From: hebergement-web-tice@ac-orleans-tours.fr'."\n".
						'Reply-To: hebergement-web-tice@ac-orleans-tours.fr'."\n".
						'Content-type: text/html; charset=utf8'."\n";
		mail($to, $subject, $message, $headers); 		  
	}
?>
<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td>
	<?php
		if ($_SESSION['auth_status'] == 'resp')
		{
		?>
			L'adresse :<br /><br />
			<center><a href="http://<?php echo $host;?>/" target="_blank">http://<?php echo $host;?>/</a></center>
			<br />
			Est maintenant redirig&eacute;e vers l'adresse :<br /><br />
			<center><a href="http://<?php echo $host."/".$_SESSION['site'][$_SESSION['defaut']];?>/" target="_blank">http://<?php echo $host."/".$_SESSION['site'][$_SESSION['defaut']];?>/</a></center>
			<br />
			<hr />		
		<?php
		}
		else
		{
			if ( count($_SESSION['responsable']['nom']) == 1 )
				echo "Un courriel a &eacute;t&eacute; envoy&eacute; au responsable de ce site.<br />";
			else
				echo "Un courriel a &eacute;t&eacute; envoy&eacute; aux responsables de ce site.<br />";
			?>			
			Ce courriel contient toutes les indications n&eacute;cessaires pour activer cette nouvelle redirection.<br />
			<br />
			<hr />
		<?php	
		}
	?>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
	<table style="margin-left: auto; margin-right: 0;">
	<tr>
		<td>
		<form method="post" action="<?php echo $script_url; ?>">
		<input type="submit" value="Retour" />
		</form>
		</td>
		<td>
		<form method="post" action="<?php echo $script_url; ?>">
		<input type="hidden" name="deconnecte" value=true />
		<input type="submit" value="Quitter" />
		</form>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>