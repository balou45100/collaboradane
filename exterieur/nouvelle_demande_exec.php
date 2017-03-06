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
<?php
$requete = "select max(id_pb)
			from probleme";
$resultat = mysql_query($requete);
$ligne = mysql_fetch_array($resultat);
$id_pb=$ligne[0]+1;
$mail=$_POST['mail'];
$nom=$_POST['nom'];
$rne=$_POST['rne'];
$niv1=$_POST['niv1'];
$desc=$_POST['description'];
$date=$_POST['date'];
//Recuperation du titre
	$requete = "select nom, num_pere
			from ext_titre
			where num = $niv1";
			$resultat = mysql_query($requete);
			$ligne = mysql_fetch_array($resultat);
$titre2 = $ligne[0];
$niv1 = $ligne[1];
	$requete = "select nom
			from ext_titre
			where num = $niv1";
			$resultat = mysql_query($requete);
			$ligne = mysql_fetch_array($resultat);
			if ($ligne[0] !="")
			{
			$titre1 = $ligne[0];
			$titre = $titre1." : ".$titre2;
			}
			else
			{
			$titre=$titre2;
			}
	$titre = $titre." ".$_POST['titre'];
$requete = "insert into probleme (id_pb, mail_individu_emetteur, nom_individu_emetteur, num_etablissement, nom, texte, date_creation, module, statut_traitement)
			values ($id_pb, '$mail','$nom','$rne','$titre','$desc','$date','EXT', 'N')";
$resultat = mysql_query($requete);
//echo $requete;
if ($resultat)
{
	echo"Le ticket $id_pb traitant de $titre a été enregistré <br />";
}
else
{
	echo"Erreur lors de l'ajout";
}
?>
		<a href='Accueil_pers_ext.php'>Retour</a>
</body>
</html>