<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td>
	<?php
	switch ($auth_error) // Gestion des messages en fonction des authentifications précédente. 
	{
		case 0:
			$login_label = 'Veuillez vous identifier :';
			break;
		case 1:
			echo '<h3 style="color: red; font-weight: bold;">Vous devez saisir un mot de passe !</h3><br />';
			$login_label = 'Veuillez vous identifier de nouveau :';
			break;
		case 2:
			echo '<h3 style="color: red; font-weight: bold;">L\'identifiant et/ou le mot de passe ne sont pas valides !</h3><br />';
			$login_label = 'Veuillez vous identifier de nouveau :';
			break;
		case 3:
			echo '<h3 style="color: red; font-weight: bold;">Vous ne faites partie ni des responsables, ni des webmestres du site !</h3><br />';
			echo 'Seuls les responsables et les webmestres du site peuvent changer la redirection par défaut.<br />';
			echo 'Si vous pensez qu\'il s\'agit d\'une erreur, merci de nous contacter à l\'adresse ';
			echo '<a href="mailto:hebergement-web-tice@ac-orleans-tours.fr">hebergement-web-tice@ac-orleans-tours.fr</a>.<br /><br />';
			$login_label = 'Veuillez vous identifier de nouveau :';
			break;
	}
	?>
	</td>
</tr>
</table>
<form method="post" action="<?php echo $script_url; ?>">
<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td>
	<?php echo $login_label;?> 
	<table style="border-width: 1px; border-style: solid; border-color: black;">
	<tr>
		<td style="text-align: right; vertical-align: top; ">
		<?php
			if ( count($_SESSION['responsable']['nom']) <= 1 )
				echo "Responsable du site : ";
			else
				echo "Responsables du site : ";
		?>
		</td>
		<td>
		<?php
		if ( count($_SESSION['responsable']['nom']) == 0 )
			echo "aucun";
		else
			for ($i=0;$i<count($_SESSION['responsable']['nom']);$i++) // Affichage des responsables du sites.
				echo '<b>'.$_SESSION['responsable']['nom'][$i].'</b> (<i>'.$_SESSION['responsable']['mail'][$i].'</i>)<br />';		
		?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right; vertical-align: top; ">
		<?php
			if ( count($_SESSION['webmestre']['nom']) <= 1 )
				echo "Webmestre du site : ";
			else
				echo "Webmestres du site : ";
		?>
		</td>
		<td>
		<?php
		if ( count($_SESSION['webmestre']['nom']) == 0 )
			echo "aucun";
		else
			for ($i=0;$i<count($_SESSION['webmestre']['nom']);$i++) // Affichage des responsables du sites.
				echo '<b>'.$_SESSION['webmestre']['nom'][$i].'</b> (<i>'.$_SESSION['webmestre']['mail'][$i].'</i>)<br />';		
		?>
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<hr />
		</td>
	</tr>
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
	<input type="submit" value="Se connecter" />
	</td>
</tr>
</table>
</form>
<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td>
	<h3 style="font-weight: bold;">Remarque importante :</h3><br />
	Vous devez utiliser les identifiants de connexion correspondant à l'adresse de courriel indiquée entre parenthèses.<br />
	Si aucune adresse n'apparait, merci de nous contacter à l'adresse <a href="mailto:hebergement-web-tice@ac-orleans-tours.fr">hebergement-web-tice@ac-orleans-tours.fr</a>.<br />
</tr>
</table>