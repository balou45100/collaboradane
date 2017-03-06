<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>

<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	?>
	
<html>	
<head>
<?php
if(isset($_POST['generer']))
{
for($i=1;$i-1 < $_POST['entrant'];$i++) 
     { 
			$requete = "insert into courrier (type, num_enr, annee_scolaire)
						values ('entrant', $i, '$annee_scolaire')";
			mysql_query($requete);
     }
	 echo $_POST['entrant']." courriers entrants générés <br />";
for($i=1;$i-1 < $_POST['sortant'];$i++) 
     { 
			$requete = "insert into courrier (type, num_enr, annee_scolaire)
						values ('sortant', $i, '$annee_scolaire')";
			mysql_query($requete);
     }
	 echo $_POST['sortant']." courriers entrants générés";
}
?>
<form action="gc_generer_courrier.php" method="post">
	Courrier entrant : <input type="text" name="entrant"><br />
	Courrier sortant : <input type="text" name="sortant"><br />
	<input type="submit" value = "Générer" name="generer">
</form>
</head>
<body>
