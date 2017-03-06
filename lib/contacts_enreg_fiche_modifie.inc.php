<?php
$id_contact = $_GET['id_contact'];
$proprietaire = $_GET['proprietaire'];
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

//Mise à jour de la fiche
include("../biblio/init.php");
if ($proprietaire == "O")
{
	$query_maj = "UPDATE contacts SET
		PRENOM = '".$prenom."',
		NOM = '".$nom."',
		FONCTION = '".$fonction."',
		SERVICE = '".$service."',
		TEL_DIRECTE = '".$tel_directe."',
		FAX = '".$fax."',
		MOBILE = '".$mobile."',
		MEL_PRO = '".$mel_pro."',
		ADRESSE = '".$adresse."',
		CODE_POSTAL = '".$code_postal."',
		VILLE = '".$ville."',
		PAGE_WEB_PRO = '".$page_web_pro."',
		ADRESSE_PERSO = '".$adresse_perso."',
		CODE_POSTAL_PERSO = '".$code_postal_perso."',
		VILLE_PERSO = '".$ville_perso."',
		TEL_PERSO = '".$tel_perso."',
		FAX_PERSO = '".$fax_perso."',
		MOBILE_PERSO = '".$mobile_perso."',
		MEL_PERSO = '".$mel_perso."',
		PAGE_WEB_PERSO = '".$page_web_perso."',
		REMARQUES = '".$remarques."',
		STATUT = '".$statut."',
		EMETTEUR = '".$emetteur."',
		CATEGORIE = '".$categ."'
		WHERE ID_CONTACT = '".$id_contact."';";
	}
	else
	{
		$query_maj = "UPDATE contacts SET
			PRENOM = '".$prenom."',
			NOM = '".$nom."',
			FONCTION = '".$fonction."',
			SERVICE = '".$service."',
			TEL_DIRECTE = '".$tel_directe."',
			FAX = '".$fax."',
			MOBILE = '".$mobile."',
			MEL_PRO = '".$mel_pro."',
			ADRESSE = '".$adresse."',
			CODE_POSTAL = '".$code_postal."',
			VILLE = '".$ville."',
			PAGE_WEB_PRO = '".$page_web_pro."',
			ADRESSE_PERSO = '".$adresse_perso."',
			CODE_POSTAL_PERSO = '".$code_postal_perso."',
			VILLE_PERSO = '".$ville_perso."',
			TEL_PERSO = '".$tel_perso."',
			FAX_PERSO = '".$fax_perso."',
			MOBILE_PERSO = '".$mobile_perso."',
			MEL_PERSO = '".$mel_perso."',
			PAGE_WEB_PERSO = '".$page_web_perso."',
			REMARQUES = '".$remarques."'
			WHERE ID_CONTACT = '".$id_contact."';";
	}
	$results_maj = mysql_query($query_maj); 
?>
