<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td>
	Veuillez choisir, dans la liste déroulante ci-dessous, le site vers lequel renverra l'adresse :<br /><br />
	<center><a href="http://<?php echo $host;?>/" target="_blank">http://<?php echo $host;?>/</a></center>
	<br />
	</td>
</tr>
</table>
<table style="margin-left: auto; margin-right: auto;">
<tr>
	<td> 
	<form method="post" action="<?php echo $script_url; ?>">
	<table style="border-width: 1px; border-style: solid; border-color: black;">
	<tr>
		<td>
		Site de redirection actuel :
		</td>
	</tr>
	<tr>
		<td style="text-align: center;">
		<?php
		if ($_SESSION['defaut'] === false)
			echo 'Aucun';
		else
			echo '<a href="http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/" target="_blank">http://'.$host.'/'.$_SESSION['site'][$_SESSION['defaut']].'/</a>';
		?>
		</td>
	</tr>
	<tr>
		<td>
		<hr />
		</td>
	</tr>
	<tr>
		<td>
		Sites disponibles pour la redirection :
		</td>
	</tr>
	<tr>
		<td>
		<select name="site">
		<?php
		foreach ($_SESSION['site'] as $site)
		{
			echo '<option value="'.$site.'">http://'.$host.'/'.$site.'/</option>';
		}
		?>
		</select>
		<br />&nbsp;
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td style="text-align: right;">
	<table style="margin-left: auto; margin-right: 0;">
	<tr>
		<td>
		<input type="hidden" name="sauve" value=true />
		<input type="submit" value="Appliquer" />
		</form>
		</td>
		<td>
		<form method="post" action="<?php echo $script_url; ?>">
		<input type="hidden" name="deconnecte" value=true />
		<input type="submit" value="Annuler" />
		</form>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>