<html>
<body>
<?php

echo '<center><form method="POST">';

$requete_ville= "SELECT DISTINCT ville FROM repertoire ORDER BY ville;";
$result_ville= mysql_query ($requete_ville,$connexion);
echo '
<br>
<p><blink>-->&nbsp;</blink>Trouver un lieu dans le repertoire:</p>
<br>

<p>Ville:	&nbsp;
<SELECT name="ville">
<option value=" ">Tout</option></p>

';
while ($ligne_ville=mysql_fetch_assoc($result_ville))
{
$nom=$ligne_ville["ville"];
echo '<OPTION value="'.$nom.'">'.$nom.'</option>';
}
echo'</select>
<input type="submit" name="suivant_ville" value=">>"/>
<input type="hidden" name="typelieu" value="2"/>
<input type="hidden" name="Suivant2" value="XX"/>
</form></center>';

if(isset($_POST["suivant_ville"]))
{

$ville=$_POST["ville"];
if($ville!=" ")
{
$requete_etab="SELECT * FROM repertoire where ville='$ville' Order by societe;";
$result_etab=mysql_query($requete_etab,$connexion);

echo'<form method="post"><center>
<p>-&nbsp;-&nbsp;-</p>
<br>
<p><blink>-->&nbsp;</blink>Sélectionnez un lieu:</p>
<br>
<select name="etab">';
while ($ligne_etab=mysql_fetch_assoc($result_etab))
{

$nomE=$ligne_etab["societe"];
$idE=$ligne_etab["No_societe"];
echo '<OPTION value="'.$idE.'">'.$nomE.' 	&nbsp; ----------> 	&nbsp; '.$idE.'</option>';
}

echo'</select>
<table border=0 cellpading=0>
<tr><td><p>Indiquez le numéro de salle:&nbsp;</p></td><td><input type="text" name="numsalle1" size="17" /></td><td><input type="submit" name="valid_etab1" value="Valider"/></td></tr>
</table>
<input type="hidden" name="typelieu" value="2"/>
<input type="hidden" name="Suivant2" value="XX"/>
</form></center>';
}

else
{

$requete_etab="SELECT * FROM repertoire Order by ville;";
$result_etab=mysql_query($requete_etab,$connexion);

echo'<form method="post"><center>
<p>-&nbsp;-&nbsp;-</p>
<br>
<p><blink>-->&nbsp;</blink>Sélectionnez un lieu:</p>
<br>
<select name="etab">';
while ($ligne_etab=mysql_fetch_assoc($result_etab))
{

$nomE=$ligne_etab["societe"];
$idE=$ligne_etab["No_societe"];
$ville2=$ligne_etab["ville"];
echo '<OPTION value="'.$idE.'">'.$ville2.' 	&nbsp; ----------> 	&nbsp; '.$nomE.' 	&nbsp; ----------> 	&nbsp; '.$idE.'</option>';
}


echo'</select>

<table border=0 cellpading=0>
<tr><td><p>Indiquez le numéro de salle:&nbsp;</p></td><td><input type="text" name="numsalle2" size="17" /></td><td><input type="submit" name="valid_etab2" value="Valider"/></td></tr>
</table>
<input type="hidden" name="typelieu" value="2"/>
<input type="hidden" name="Suivant2" value="XX"/>
</form></center>';
}
}


if(isset($_POST["valid_etab1"]))
{

 @$idE=$_POST["etab"];
 @$numsalle1=$_POST["numsalle1"];
 
 $requete1 = "INSERT INTO `om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES ('', '', '$idE', '$numsalle1');";
 $result1 = mysql_query($requete1, $connexion);

echo 'ça marche';

}


if(isset($_POST["valid_etab2"]))
{

 @$idE=$_POST["etab"];
 @$numsalle2=$_POST["numsalle2"];
 
 $requete2 = "INSERT INTO `om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES ('', '', '$idE', '$numsalle2');";
 $result2 = mysql_query($requete2, $connexion);
 
echo 'ça marche !!!!!!!!!!';

}


?>
</body>
</html>
