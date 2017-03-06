<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html" />
<style type="text/css">
body{
background-color : #FFCC66;
}
TD{
background-color : #FEDD99;
}
</style>
</HEAD>
<BODY>
<?php
include ("../biblio/init.php");
?>

<form method="post">
Intitulé de la nouvelle catégorie :
<input type="text" name="intitule" />
<input type="submit" name="valid_categ" value="Envoyer"/>
</form>
<?php
if(isset($_POST["valid_categ"])){
$nom=$_POST["intitule"];
$requete_verif="SELECT * FROM abo_categorie where intitule_categ like'$nom' ;";
$result_verif=mysql_query($requete_verif);
$ligne_verif=mysql_fetch_assoc($result_verif);

if($ligne_verif["nom"]==''){
$requete_ajout="INSERT INTO abo_categorie values ('','$nom') ;";
$result_ajout=mysql_query($requete_ajout);
if($result_ajout){
echo' Ajout dans la table abo_categorie.<BR />';
}else{
echo' Erreur dans l\'ajout de la table abo_categorie.<BR />';
}
}else{
echo'Cette intitulé existe déjà.';
}
}
?>
</BODY>
</HTML>
