<?php
	//Lancement de la session
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	//include ("../biblio/init.php");
	//Récupération des variables nécessaires
	if (isset($_POST['pwd']))
	{
	$_SESSION['pwd']=$_POST['pwd'];
	$_SESSION['uid']=$_POST['uid'];
	$_SESSION['ldap_dn']=$_POST['ldap_dn'];
	$_SESSION['ldap_dnf']=$_POST['ldap_dnf'];
	$_SESSION['ldap_dna']=$_POST['ldap_dna'];	
	$_SESSION['ldap_server']=$_POST['ldap_server'];
	}
	
	$pwd = $_SESSION['pwd'];
	$uid = $_SESSION['uid'];
	$ldap_server = $_SESSION['ldap_server'];
	$ldap_dn = $_SESSION['ldap_dn'];
	$ldap_dnf = $_SESSION['ldap_dnf'];
	$ldap_dna = $_SESSION['ldap_dna'];
	
	//Connexion au serveur LDAP
	include ("connect_ldap.php");
	
	if ($auth)  // Si l'authentification a fonctionné...
	{
	
	// On récupère l'adresse mail, le RNE de l'établissement et la discipline de l'utilisateur.
		$filtre = '(|(uid='.$uid.'))';
		$attr = array ('mail','rneextract','rne','discipline','cn','sn','givenname','profilbv','title','finfonction','codecivilite','dateFF');
		$result = ldap_search($ldap_conn,$dn,$filtre,$attr);
		$info = ldap_get_entries($ldap_conn,$result);
		ldap_unbind($ldap_conn);
		
		//Stockage dans des variables
		$_SESSION['civilite_utilisateur'] = $info[0]['codecivilite'][0];
		$_SESSION['nom_complet_utilisateur'] = $info[0]['cn'][0];
		$_SESSION['nom_utilisateur'] = $info[0]['sn'][0];
		$_SESSION['prenom_utilisateur'] = $info[0]['givenname'][0];
		$_SESSION['mail_utilisateur'] = $info[0]['mail'][0];
		$_SESSION['discipline_utilisateur'] = $info[0]['discipline'][0];
		$_SESSION['rne_utilisateur'] = $info[0]['rneextract'][0];
		if ($_SESSION['rne_utilisateur'] =="")
		{
			$_SESSION['rne_utilisateur'] = $info[0]['rne'][0];
		}
		$_SESSION['fonction_utilisateur'] = $info[0]['profilbv'][0];
		if ($_SESSION['fonction_utilisateur'] =="")
		{
			$_SESSION['fonction_utilisateur'] = $info[0]['title'][0];
		}
		
		//Verifier le mail		
		$mail_utilisateur = $_SESSION['mail_utilisateur'];
		$Syntaxe='#^[\w.-]+@ac-orleans-tours.fr$#';
		if (preg_match($Syntaxe,$mail_utilisateur))
		{
		///////////////////////////////////////////////////////////////////////////
		
		$civilite_utilisateur = $_SESSION['civilite_utilisateur'];
		$nom_complet_utilisateur = $_SESSION['nom_complet_utilisateur'];
		$nom_utilisateur = $_SESSION['nom_utilisateur'];
		$prenom_utilisateur = $_SESSION['prenom_utilisateur'];
		$discipline_utilisateur = $_SESSION['discipline_utilisateur'];
		$rne_utilisateur = $_SESSION['rne_utilisateur'];
		$statut_utilisateur = $info[0]['profilbv'][0];
		$fin_fonction_utilisateur = $info[0]['finfonction'][0];
		$date_fin_fonction_utilisateur = $info[0]['dateFF'][0];
		//Par défaut le niveau de droit de l'utilisateur est de 1
		$_SESSION['niveau'] = 1;
		//Verification webmaster
		@mysql_connect("localhost","bright91","ecoFemuLep");
		$select_base=@mysql_selectdb("sites");
		
	?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="feuille.css" rel="stylesheet" type="text/css">
<!--  Script de listes deroulantes liees  avec appel  par AJAX, (evite le rechargement de la page) -->
<script language="Javascript"type="text/JavaScript">
// Requette AJAX
function makeRequest(url,id_niveau,id_ecrire){
	var http_request = false;
		//créer une instance (un objet) de la classe désirée fonctionnant sur plusieurs navigateurs
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');//un appel de fonction supplémentaire pour écraser l'en-tête envoyé par le serveur, juste au cas où il ne s'agit pas de text/xml, pour certaines versions de navigateurs Mozilla
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Abandon :( Impossible de créer une instance XMLHTTP');
            return false;
        }
		//alert('HTTP request : '+http_request.status); = 0
        http_request.onreadystatechange = function() { traitementReponse(http_request,id_ecrire); } //affectation fonction appelée qd on recevra la reponse
		// lancement de la requete
		http_request.open('POST', url, true);
		//changer le type MIME de la requête pour envoyer des données avec la méthode POST ,  !!!! cette ligne doit etre absolument apres http_request.open('POST'....
		http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		obj=document.getElementById(id_niveau);
		data="val_sel="+obj.value;
        http_request.send(data);
}

function traitementReponse(http_request,id_ecrire) {
	var affich="";
	if (http_request.readyState == 4) {
		//if (http_request.status == 200) {
					// cas avec reponse de PHP en mode texte:
			//chargement des elements reçus dans la liste
			var affich_list=http_request.responseText;
         //alert("Reponse de php: "+affich_list);
				obj = document.getElementById(id_ecrire); 
                obj.innerHTML = affich_list;
		//} 
		//else {
       //         alert('Un problème est survenu avec la requête.'+http_request.status);
       // }
    }
}
</script>
	</head>
	<body>
	<div id="all">
	<div id="left" class="scrollbar">
	<?php
	echo"<b>Informations</b><br />
	<u>Résume :</u><br />
	Nom : $nom_utilisateur<br />
	Prenom : $prenom_utilisateur<br />
	Mail : $mail_utilisateur<br />
	RNE : $rne_utilisateur<br />
	(plan)<br />
	<br />
	<br />";
	?>
	<u>Personnel de l'établissement :</u><br />
	<?php
	/*if (date('n') >= 9)
	{
	$date = date('Y');
	}
	else
	{
	$date = date('Y')-1;
	}*/
	$date=2008;
	@mysql_close();
	include ("../biblio/init.php");
	$requete = "select prenom, nom, fonction from personnes_ressources_tice pr, fonctions_des_personnes_ressources fct where pr.id_pers_ress=fct.id_pers_ress and fct.annee = $date and rne like '$rne_utilisateur'  order by fonction, nom";
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo "- ".$ligne[0] ." ".$ligne[1]."<br /><i> ".$ligne[2]."</i><br />";
						}
					}
	?>
	</div>
	<div id="right">
		<div id="top" class="scrollbar">
		<b><u>Sites web</u></b><br />
		<br />
		
		<!--<select name="rne" size='1'>-->
		<?php 
		/*$requete = "select rne from etablissements order by rne";
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if ($ligne[0]== $rne_utilisateur)
							{
								$selected = " selected ";
							}
							else
							{
								$selected = "";
							}
							echo "<option value='".$ligne[0]."'".$selected.">".$ligne[0]."</option>";
						}
					}*/
				?>
		<!--</select>-->
		
			<div id="id_list1">RNE : <br />
		<select name="niv1" id="id_niv1" onChange="makeRequest('repsite.php','id_niv1','id_list2')">
			<option value="">Aucun</option>
<?php
$requete = "select rne from etablissements order by rne";
		$resultat = mysql_query($requete);			
if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if ($ligne[0]== $rne_utilisateur)
							{
								$selected = " selected ";
							}
							else
							{
								$selected = "";
							}
							echo "<option value='".$ligne[0]."'".$selected.">".$ligne[0]."</option>";
						}
					}
?>
		</select>
	</div>
	
		<?php
		if ($_SESSION['niveau'] == 3)
		{
		echo"Demande nouveau site <br />";
		}
		//echo "niveau :".$_SESSION['niveau'];
		?>
		
			<div id="id_list2">
			<?php
			if (!isset($_POST['val_sel']))
			{
			include("liste_site.php");
			}
			?>
	<!-- ici sera charge la reponse mode texte de PHP à la request AJAX -->
			</div>
		
		
		<br />
		</div>
		<div id="bottom" class="scrollbar">
		<u><b>Demandes</u></b>
		<br /><br />
		<a href="nouvelle_demande.php">Nouvelle demande </a><br />
		<table border = "1"  width = "80%">
		<tr>
			<td>ID</td>
			<td>ST</td>
			<td>Créé le</td>
			<td>Sujet</td>
			<td>Description</td>
		</tr>
		<?php
	@mysql_close();
	include ("../biblio/init.php");
		$requete = "select * from probleme where mail_individu_emetteur like '".$mail_utilisateur."' and ID_PB_PERE = 0 and statut_traitement not like 'A' order by id_pb desc";
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						$i = 1;
						while ($ligne=mysql_fetch_array($resultat) AND $i <= 3)
						{
							echo "	<tr>
										<td>".$ligne[0]."</td>
										<td>".$ligne['STATUT_TRAITEMENT']."</td>
										<td>".$ligne[7]."</td>
										<td>".$ligne[5]."</td>
										<td>".$ligne[6]."</td>
										<td>
										<a href='repondre.php?num_pere=".$ligne[0]."'>Répondre</a>
										</td>
										<td>
										<a href='Modif_reponse.php?num=".$ligne[0]."&mail=".$mail_utilisateur."'>Modifier dernière réponse</a>
										</td>
										<td>
										<a href='operation.php?supr=1&num=".$ligne[0]."'>Cloturer demande</a>
										</td>
										<td>
										<a href='voir_historique.php?num=".$ligne[0]."'>Historique demande</a>
										</td>										
									</tr>";
							$i++;
						}
					}
		?>
		
		</table>
		<?php
		echo "<a href='vue_generale.php?mail=".$mail_utilisateur."'>Voir tout les demandes en cours</a>";
		?><br /><br />
		<table border = "1"  width = "80%">
		<tr>
			<td>ID</td>
			<td>ST</td>
			<td>Créé le</td>
			<td>Sujet</td>
			<td>Description</td>
		</tr>
		<?php
	@mysql_close();
	include ("../biblio/init.php");
		$requete = "select * from probleme where mail_individu_emetteur like '".$mail_utilisateur."' and ID_PB_PERE = 0 and statut_traitement like 'A' order by id_pb desc";
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						$i = 1;
						while ($ligne=mysql_fetch_array($resultat) AND $i <= 1)
						{
							echo "	<tr>
										<td>".$ligne[0]."</td>
										<td>".$ligne['STATUT_TRAITEMENT']."</td>
										<td>".$ligne[7]."</td>
										<td>".$ligne[5]."</td>
										<td>".$ligne[6]."</td>
										<td>
										<a href='operation.php?desupr=1&num=".$ligne[0]."'>Désarchiver</a>
										</td>										
									</tr>";
							$i++;
						}
					}
		?>
		
		</table>
		<?php
		echo "<a href='vue_generale.php?archive=1&mail=".$mail_utilisateur."'>Voir tout les demandes archivée</a>";
		?>
		</div>
	</div>
	</div>
	<?php
	}
	else
	{
	Echo "Vous n'avez pas de mail academique, veuillez contacter HWT@ac-orleans-tours.fr";
	}
	}
	else
	{
	Echo "Erreur de connection, <a href='index.php'>réessayer ?</a>";
	}
	?>
	</body>
</html>