<?php
$id_societe = $_GET['id_societe'];
$id_etab = $_GET['id_etab'];
$prenom = $_GET['prenom'];
$nom = $_GET['nom'];
$fonction = $_GET['fonction'];
$service = $_GET['service'];
$tel_directe = $_GET['tel_directe'];
$fax = $_GET['fax'];
$mobile = $_GET['mobile'];
$mel_pro = $_GET['mel_pro'];
$adresse = $_GET['adresse'];
$code_postal = $_GET['code_postal'];
$ville = $_GET['ville'];
$page_web_pro = $_GET['page_web_pro'];
$adresse_perso = $_GET['adresse_perso'];
$code_postal_perso = $_GET['code_postal_perso'];
$ville_perso = $_GET['ville_perso'];
$tel_perso = $_GET['tel_perso'];
$fax_perso = $_GET['fax_perso'];
$mobile_perso = $_GET['mobile_perso'];
$mel_perso = $_GET['mel_perso'];
$page_web_perso = $_GET['page_web_perso'];
$statut = $_GET['statut'];
$categ = $_GET['categ'];
$emetteur = $_GET['emetteur'];
$remarques = $_GET['remarques'];

//Formatage des N°s de téléphone
$tel_directe = format_no_tel($tel_directe);
$fax = format_no_tel($fax);
$mobile = format_no_tel($mobile);
$tel_perso = format_no_tel($tel_perso);
$fax_perso = format_no_tel($fax_perso);
$mobile_perso = format_no_tel($mobile_perso);

//echo "<br>id_etab : $id_etab - id_societe : $id_societe";
if ($id_societe == "null")
{
  $id_societe = $id_etab;
}

              
$nom = strtoupper($nom);
//echo "<BR>id_societe : $id_societe - id_etab : $id_etab - prenom : $prenom - nom : $nom - fonction : $fonction - tel_directe : $tel_directe - mobile : $mobile - fax : $fax - remarques : $remarques - emetteur : $emetteur";
//Mise à jour de la fiche
include("../biblio/init.php");
$query = "INSERT INTO contacts (ID_SOCIETE, PRENOM, NOM, FONCTION, SERVICE, TEL_DIRECTE, FAX, MOBILE, MEL_PRO, ADRESSE, 
  CODE_POSTAL, VILLE, PAGE_WEB_PRO, ADRESSE_PERSO, CODE_POSTAL_PERSO, VILLE_PERSO, TEL_PERSO, FAX_PERSO, MOBILE_PERSO,
  MEL_PERSO, PAGE_WEB_PERSO, STATUT, CATEGORIE, EMETTEUR, REMARQUES) 
    VALUES ('".$id_societe."', '".$prenom."', '".$nom."', '".$fonction."', '".$service."', '".$tel_directe."', '".$fax."', '".$mobile."', '".$mel_pro."', '".$adresse."',
     '".$code_postal."', '".$ville."', '".$page_web_pro."', '".$adresse_perso."', '".$code_postal_perso."', '".$ville_perso."', '".$tel_perso."', '".$fax_perso."', '".$mobile_perso."', 
     '".$mel_perso."', '".$page_web_perso."', '".$statut."', '".$categ."', '".$emetteur."', '".$remarques."');";
				
$results = mysql_query($query);
//Dans le cas où aucun résultats n'est retourné
if(!$results)
{
  echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
  //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
  mysql_close();
  //exit;
}
				      
?>
