<?php
	// Paramètres de connexion du serveur mysql hébergeant la base "sites".
	//require_once 'includes/mysql_configuration.inc.php';
	// Paramètres de connexion au serveur ldap académique.
	require_once 'ldap_configuration.inc.php';
	// Divers variables liées à la localisation su script.
	//require_once 'includes/host_configuration.inc.php';
	// Variables liées à la session.
	//require_once 'includes/session_variables.inc.php';
	// Entête de la page.
	//include 'includes/header.inc.php';

	echo "<br />index.php";
	echo "<br />ldap_server : $ldap_server";
	echo "<br />ldap_dn : $ldap_dn";
	echo "<br />ldap_dnf : $ldap_dnf";
	echo "<br />ldap_dna : $ldap_dna";

	$nom = "Mendel";
	$prenom = "Jürgen";
	$mel = "jurgen.mendel@ac-orleans-tours.fr";
	$uid = "crdpmend";

	//include ("recherche_ldap.inc.php");
?>
	<form method="post" action="recherche_ldap.inc.php">
<table>
	<tr>
		<td style="text-align: right;">
		Nom d'utilisateur :
		</td>
		<td>
		<input type="text" name="uid" value="<?php echo $_SESSION['uid'];?>" />
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		Mot de passe :
		<br />&nbsp;
		</td>
		<td>
		<input type="password" name="pwd" value="" />
		<br />&nbsp;
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
	<?php echo"<input type=\"hidden\" value=\"$ldap_server\" name = \"ldap_server\"/>";?>
	<?php echo"<input type=\"hidden\" value=\"$ldap_dn\" name = \"ldap_dn\"/>";?>
	<?php echo"<input type=\"hidden\" value=\"$ldap_dnf\" name = \"ldap_dnf\"/>";?>
	<?php echo"<input type=\"hidden\" value=\"$ldap_dna\" name = \"ldap_dna\"/>";?>
	<input type="submit" value="Se connecter" />
	</td>
</tr>
</table>
</form>

<?php	
/*
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
*/
?>
</body>
</html>
