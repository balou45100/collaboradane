<?php
	//Lancement de la session
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	?>
<html>
<body>
<form action="gerer_titres.php" method="POST">
<?php
$requete = "select *
			from ext_titre
			where num = ".$_GET['num'];
			$resultat = mysql_query($requete);
			$num_rows = mysql_num_rows($resultat);
					
					if ($ligne=mysql_fetch_array($resultat))
					{
echo"Numéro : <input type='text' name='modif_num' value='".$ligne[0]."' readonly><br />";
?>
Titre père : <select name="modif_num_pere">
							<option value="0">Aucun</option>
							<?php
							$requete1 = "select *
										from ext_titre";
							$resultat1 = mysql_query($requete1);
							while ($ligne1=mysql_fetch_array($resultat1))
							{
							if($ligne1[0] == $ligne[1])
							{
								$selected=" selected";
							}
							else
							{
								$selected ="";
							}
								echo"<option value='".$ligne[0]."'".$selected.">".$ligne[2]."</option>";
							}
							?>
							</select><br />
<?php
echo"Nom : <input type='text' name='modif_nom' value='".$ligne[2]."'><br />";
					}
?>
<input type="submit" name="modifier_titre">
</form>
</body>
</html>