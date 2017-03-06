<?php
	// Paramètres de connexion du serveur mysql hébergeant la base "sites".
	require_once 'includes/mysql_configuration.inc.php';
	// Paramètres de connexion au serveur ldap académique.
	require_once 'includes/ldap_configuration.inc.php';
	// Divers variables liées à la localisation su script.
	require_once 'includes/host_configuration.inc.php';
	// Variables liées à la session.
	require_once 'includes/session_variables.inc.php';
	// Entête de la page.
	include 'includes/header.inc.php';

	if (! count($_SESSION['site']) )
	{
		?>
		<h2>Aucun site trouvé !</h2>
		<p>Aucun site éligible à la redirection n'est associé à l'URL <?php echo $host; ?></p>
		<p>Si vous pensez qu'il devrait en être autrement, merci de nous contacter à l'adresse <a href="hebergement-web-tice@ac-orleans-tours.fr">hebergement-web-tice@ac-orleans-tours.fr</a>.</p>
		<?php
	}
	elseif (! count($_SESSION['responsable']['nom']) )
	{
		?>
		<h2>Aucun responsable trouvé !</h2>
		<p>Aucun responsable n'est associé é l'URL <?php echo $host; ?></p>
		<p>Vous ne pouvez donc pas paramètrer la redirection.</p>
		<p>Pour corriger ce probléme, merci de nous contacter à l'adresse <a href="hebergement-web-tice@ac-orleans-tours.fr">hebergement-web-tice@ac-orleans-tours.fr</a>.</p>
		<?php
	}
	else
	{
		?>
		<table style="width: 100%;">
		<tr>
			<td style="text-align: center;">
			<?php
			if (!empty($_POST['uid'])) // Si on a un identifiant...
			{
				if (!empty($_POST['pwd'])) // Si on a un mot de passe...
					include 'includes/ldap_auth.inc.php'; // On vérifie l'authentification
				else
					$auth_error = 1; // Il faut donner un mot de passe.
			}
			else
				$auth_error =0;  // L'utilisateur ne s'est pas encore authentifié

			if (!$_SESSION['connecte'])  // Si on est pas authentifié...
				include 'includes/open_session.inc.php';  // On affiche le formulaire d'authentification.
			else  // Si on est connecté...
			{
				if ($_POST['sauve'])  // Si on a choisi la redirection par défaut...
					include 'includes/save_default.inc.php';  // On l'enregistre.
				else
					include 'includes/change_default.inc.php';  // Sinon, on affiche la page de choix.
			}
			?>
			</td>
		</tr>
		</table>
		<?php
	}
?>
</body>
</html>
