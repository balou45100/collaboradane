<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<LINK HREF="../../style/rencontres.css" REL="stylesheet" TYPE="text/css">
        

</head>
<body>
<p><br/></p>
<?php
   include('../biblio/init.php');
   $rne=$_GET['id'];
   echo "<p align='center'>RNE&nbsp;:&nbsp;".$rne."</p>";
   $sql = "SELECT * FROM etablissements where RNE='$rne'";
   $resultat=mysql_query($sql);
   $etab=mysql_fetch_object($resultat);
          $type=$etab->TYPE;              
          $secteur=$etab->PUBPRI;              
          $nom=$etab->NOM;
          $adresse=$etab->ADRESSE;              
          $cp=$etab->CODE_POSTAL;
          $ville=$etab->VILLE;              
          $courriel=$etab->MAIL;
     
?>
<table border="1" align="center">
<thead>
<tr BGCOLOR = "#48D1CC">
<th align = "center">Type</th>
<th align = "center">Nom</th>
<th align = "center">Adresse</th>
<th align = "center">Courriel</th>
</tr>
</thead>
<tbody>
<tr>
<?php
echo"<td align = \"center\" bgcolor = \"#7FFFD4\">$type</td>
<td bgcolor = \"#7FFFD4\">$nom</td>
<td align = \"center\" bgcolor = \"#7FFFD4\">$adresse<br>$cp $ville</td>
<td align = \"center\" bgcolor = \"#7FFFD4\">$courriel</td>";
?>
</tr>
</tbody>
</table>
<!--p><br/></p-->
<form>
<p align='center'>
  <input type='button' value='Fermer' onClick='window.close()'>
  </p>
</form>

</body>
</html>
