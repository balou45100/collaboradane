<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
$nblist=1; // Nombre de listes dépendantes
// Connexion à la base MySQL
include ("../biblio/init.php");
$q=@$_GET["q"]; // "q" est le numéro du select à mettre à jour
$f=@$_POST["form"]; // Le nom du formulaire
$s=@$_POST["select"]; // Le nom du select
$ids=@$_POST["champ"]; // L'identifiant a rechercher
$id=explode("/",$ids."////");
$chp=array("id_poste","id_discipline","nom"); // Les noms des champs
// Creer le WHERE avec les identifiants
$w=" WHERE 1=1";
for($i=0;$i<sizeof($id);$i++){
   if(($id[$i]!="")&&($id[$i]!="*")){
      $w=$w." AND ".$chp[$i]."=".$id[$i];
   }
}
switch($q) {
// Il faut, pour toutes les requêtes, prendre, dans l'ordre, les champs : 
// identifiant, libellé où identifiant est numérique auto-incrémenté
   case "1": 
      $query = "SELECT id_pers_ress, nom, prenom FROM personnes_ressources_tice ".$w." ORDER BY nom";
    // On écrit du code JavaScript qui sera évalué et donc traité au retour
   echo 'var o = null;';
   // Création de l'objet "s" : la liste du formulaire à mettre à jour

   echo 'var s = document.forms["'.$f.'"].elements["'.$s.'"];';
   // On la vide en mettant sa taille à zéro
   echo 's.options.length = 0;';
   // On ajoute une première option à cette liste
   echo 's.options[s.options.length] = new Option("== Choisir ==","");';
   // On affiche l'option == Tout == en début
   echo 's.options[s.options.length] = new Option("== Tout ==","*");';
   // On ajoute les options trouvées dans le recordset
   $result = @mysql_query($query);
   while($r = mysql_fetch_array($result))
      echo 's.options[s.options.length] = new Option("'.utf8_encode($r[1].' '.$r[2]).'","'.utf8_encode($r[0]).'");';
   // Dernière option du select si pas le dernier
   //if($q<$nblist){echo 's.options[s.options.length] = new Option("== Tout ==","*");';}

   break;
//  Si q n'est ni 1, ni 2, ni 3, il faut préparer le 0 ;)
   default: // Liste des TYPES de produit (consommables, stylos, archives, papiers...)
   $liste_dpt = "";
   $SQL = "SELECT id_poste, poste FROM postes ORDER BY poste";
   $res = mysql_query($SQL);
   while($val = mysql_fetch_array($res))
   $liste_dpt .= "<option value=\"".$val[0]."\">".$val[1]."</option>\n";
   }

@mysql_close();
?>
