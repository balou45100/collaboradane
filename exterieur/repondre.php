<?php
	//Lancement de la session
	session_start();
?>
<html>
<head>
</head>
<?php
include ("config.php");
include ("../biblio/fct.php");
include ("../biblio/config.php");
include ("../biblio/init.php");
// Connexion a la base de donnees  
	$AccesBase = mysql_connect($host,$Login,$Pass);
	mysql_select_db($DB,$AccesBase);
	$QuestionBase = "SELECT num, nom FROM ext_titre WHERE num_pere = 0 ORDER BY nom ASC" ;
	$result_recherche=mysql_db_query($DB, $QuestionBase) or die (mysql_error());
	$nombre_enr=mysql_num_rows($result_recherche);
?>
<body>
<form name="test1" method="post" action="operation.php"  >
<?php
echo "
Date de création : <br /><input type='text' name='date' value='".date('Y-m-d')."' readonly><br />
Nom : <br /><input type='text' name='nom' value='".$_SESSION['nom_utilisateur']."' readonly><br />
Prénom : <br /><input type='text' name='prenom' value='".$_SESSION['prenom_utilisateur']."' readonly><br />
E-mail : <br /><input type='text' name='mail' value='".$_SESSION['mail_utilisateur']."' readonly><br />
Fonction : <br /><input type='text' name='fonction' value='".$_SESSION['fonction_utilisateur']."' readonly><br />
RNE : <br /><input type='text' name='etablissement' value='".$_SESSION['rne_utilisateur']."' readonly><br />
<input type='hidden' name='id_pb_pere' value = '".$_GET['num_pere']."'";
?>
Description : <br />
<textarea name="description" cols="50" rows="4"></textarea>
<br />
<input type="submit" value="Envoyer" name="repondre">
</form>
</body>
</html>