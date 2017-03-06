<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	?>
	
<html>	
<head>
<title>Liste destinataires</title>
</head>
<body>	
		<fieldset>
		<legend>Liste des destinataires </legend>
			<select size="35">
			</select>
			<br />
			<div align="right">
			<input type="submit" value="Retirer">
			<input type="submit" value="Valider">
			</div>
		</fieldset>
</body>
