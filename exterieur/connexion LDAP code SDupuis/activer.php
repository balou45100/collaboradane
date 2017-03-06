<?php
	// Divers variables liées à la localisation su script.
	require_once 'includes/host_configuration.inc.php';
	// Netoyage du dossier temp.
	require_once 'includes/clean_temp.inc.php';
	// Entête de la page.
	include 'includes/header.inc.php';

	if (file_exists($temp_dir.'/'.$_GET['id'].'.inc.php'))
	{
		include $temp_dir.'/'.$_GET['id'].'.inc.php';
		unlink($temp_dir.'/'.$_GET['id'].'.inc.php');
		
		if (($host == $host_org) or (empty($host_org)))
		{		
			if (!file_exists($base_dir.'/'.$etab))
				mkdir ($base_dir.'/'.$etab);
			$index = fopen($base_dir.'/'.$etab.'/index.php','w');
			fwrite($index,'<?php'."\n");
			fwrite($index,'$default = "'.$defaut.'";'."\n");
			fwrite($index,'$urls = explode(",",$_SERVER["HTTP_X_FORWARDED_HOST"]);'."\n");
			fwrite($index,'$url = $urls[0];'."\n");
			fwrite($index,'$uri = $_SERVER["REQUEST_URI"];'."\n");
			fwrite($index,'header("Location: http://".$url."/".$default.$uri);'."\n");
			fwrite($index,'?>'."\n");
			fclose($index);
			?>
			
			<table style="margin-left: auto; margin-right: auto;">
			<tr>
				<td>
				L'adresse :<br /><br />
				<center><a href="http://<?php echo $host;?>/" target="_blank">http://<?php echo $host;?>/</a></center>
				<br />
				Est maintenant redirigée vers l'adresse :<br /><br />
				<center><a href="http://<?php echo $host.'/'.$defaut.'/';?>" target="_blank">http://<?php echo $host.'/'.$defaut.'/';?></a></center>
				<br />
				</td>
			</tr>
			</table>
			<?php
		}
		else
		{
			?>
			<table style="margin-left: auto; margin-right: auto;">
			<tr>
				<td>
				<h3 style="color: red; font-weight: bold;">
				Nom d'hôte non valide !
				</h3>
				<br />
				Le site utilisé lors de la demande de redirection était : <b>http://<?php echo $host_org;?>/</b>.<br />
				Le site utilisé actuellement pour son activation est : <b>http://<?php echo $host;?>/</b>.<br />
				Le nom d'hôte utilisé pour activer cette redirection ne correspond pas à celui utilisé lors de l'enregistrement.<br />
				La redirection ne peut donc pas être activée.<br />
				<br />
				Vous pouvez redéfinir la redirection par défaut pour ce site à l'adresse :
				<br />
				<center><a href="http://<?php echo $host;?>/redirection/">http://<?php echo $host;?>/redirection/</a></center>
				<br />
				Si vous pensez qu'il s'agit d'une erreur, merci de nous contacter à l'adresse <a href="mailto:hebergement-web-tice@ac-orleans-tours.fr">hebergement-web-tice@ac-orleans-tours.fr</a>.
				</td>
			</tr>
			</table>
			<?php
		}
	}
	else
	{
		?>
		<table style="margin-left: auto; margin-right: auto;">
		<tr>
			<td>
			<h3 style="color: red; font-weight: bold;">
			La redirection ne peut pas, ou plus, être activée.
			</h3>
			<br />
			Ceci peut indiquer deux choses :
			<ul>
				<li>la redirection a déjà; été activée;</li>
				<li>le délai pour activer la redirection a été dépassé.</li>
			</ul>
			<br />
			Si vous êtes dans le deuxième cas, vous pouvez redéfinir la redirection par défaut à l'adresse :
			<br /><br />
			<center><a href="http://<?php echo $host;?>/redirection/">http://<?php echo $host;?>/redirection/</a></center>
			<br />
			</td>
		</tr>
		</table>
		<?php
	}
?>
</body>
</html>