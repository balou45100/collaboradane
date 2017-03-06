<?php
			@include("../biblio/ticket.css");
			@include ("../biblio/config.php");
			session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
?>
<!DOCTYPE HTML>

<html>


<head>

<body bgcolor="#FFB301" text="#000000">
<title> Formulaire réunion </title>
<p><center><strong><u> Formulaire de saisies d'une réunion </u></strong></center></p>
</head>

<body>
<br>
<p><center>Veuillez compléter le formulaire suivant en remplissant tout les champs: </center></p>
<br>
<br>

<center>
<form method="post" action="om_FORMULAIRE-1er.php">

<table border=1 cellpading=10 bgcolor="#01C4FF">
<tr><td colspan=3 align center bgcolor="#014DFF"><p><center><b>Informations générales</b></center></p></td></tr>
<tr><td><p>Choisir la date du debut de la mission:<br>(format: JJ-MM-AAAA)</p></td><td><input type="text" name="datedebut" size="50"></td></tr>
<tr><td><p>Veuillez choisir l'heure du debut rendez-vous:<br>(format HH:MM)</p></td><td><input type="text" name="heuredebut" size="50"></td></tr>

<tr><td><p>Choisir la date de la fin de la mission:<br>(format: JJ-MM-AAAA)</p></td><td><input type="text" name="datefin" size="50"></td></tr>
<tr><td><p>Veuillez choisir l'heure de la fin du rendez-vous:<br>(format HH:MM)</p></td><td><input type="text" name="heurefin" size="50"></td></tr>

<tr><td><p>Donnez une description de la mission:</p></td><td><TEXTAREA NAME="description" ROWS="5" COLS="38"></TEXTAREA></td></tr>


<tr>
   <td colspan=3 align right bgcolor="#014DFF">
       <center><input type=submit name="Suivant" value="Suivant"/></center>
   </td>
</tr>

</table>
</form>
</center>



</body>


</html>
