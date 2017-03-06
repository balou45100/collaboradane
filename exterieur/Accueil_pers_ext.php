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
		//echo "<br />uid : $uid";
		//$uid = "blenglet";
		//echo "<br />uid : $uid";
		$filtre = '(|(uid='.$uid.'))';
		//$filtre = '(|(uid=blenglet))';
		
		$attr = array ('mail','rneextract','rne','discipline','cn','sn','givenname','profilbv','title','finfonction','codecivilite','dateff','FrEduRne');
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
		$_SESSION['fredurne'] = $info[0]['fredurne'][0];
		$test = $_SESSION['fredurne'];
		
		/*
		echo "<br />filtre : $filtre";
		echo "<br />test : $test";
		echo "<br />info 0 : ".$info[0]['fredurne']."";
		echo "<br />info 0/1 : ".$info[0]['fredurne'][1]."";
		echo "<br />info 1 : ".$info[1]['fredurne']."";
		*/
/*
		foreach ($_SESSION['fredurne'] AS $value)
		{
			echo "<br />value : $value";
		}
*/
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
	<br />
	'<a href='index.php?deco=1'>Déconnexion</a>'
	<br />
	<br />";
?>
	<u>Personnes ressources de l'&eacute;tablissement :</u><br />
<?php
	if (date('n') >= 9)
	{
		$date = date('Y');
	}
	else
	{
		$date = date('Y')-1;
	}
	//$date=2008;
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
		<h2>Sites web</h2>
		
		<!--<select name="rne" size='1'>-->
<?php 
/*
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
*/
?>
		<!--</select>-->
		
			<div id="id_list1"> 
			RNE : 
			<form method="post" action="Accueil_pers_ext.php">
		<select name="rne_select" id="id_niv1">
<?php
	$requete = "select rne from etablissements order by rne";
	$resultat = mysql_query($requete);			
	if (mysql_num_rows($resultat))
	{	
		while ($ligne=mysql_fetch_array($resultat))
		{
			if ( isset($_POST['rne_select']))
			{
				if ($ligne[0] == $_POST['rne_select'])
				{
					$selected = " selected ";
				}
				else
				{
					$selected = "";
				}
			}
			else
			{
				if ($ligne[0] == $rne_utilisateur)
				{
					$selected = " selected ";
				}
				else
				{
					$selected = "";
				}
			}							
			echo "<option value='".$ligne[0]."'".$selected.">".$ligne[0]."</option>";
		}
	}
?>
		</select>
		<input type="submit" value="Choisir">
		</form>
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
			@mysql_close();
		
		@mysql_connect("localhost","bright91","ecoFemuLep");
		$select_base=@mysql_selectdb("sites");
		if(isset($_POST['rne_select']) AND $_POST['rne_select']!="")
		{
			$rne=$_POST['rne_select'];
		}
		else
		{
			$rne=$rne_utilisateur;
		}
		
		$requete = "SELECT nom_dossier, url, nom_serveur, si.id_site, prenom, nom, email
			FROM site si, serveurs se, webmestre W, webmestre_site WS  
			WHERE si.serveur = se.id_serveur 
				AND rne like '".$rne."' 
				AND WS.id_webmestre = W.id_webmestre 
				AND si.id_site = WS.id_site
			ORDER BY nom_dossier";
		$resultat = mysql_query($requete);
		//echo $requete;
		//echo "val_sel :".$_POST['val_sel'];
		$nombre_sites = mysql_num_rows($resultat);
		//echo "<br />nombre_sites : $nombre_sites";
		echo"<table border = '1' width = '80%'>";
		if ($nombre_sites >0)
		{
			echo "<tr>";
				echo "<th>site</th>";
				echo "<th>webmestre</th>";
			echo "</tr>";
		}
			while ($ligne=mysql_fetch_array($resultat))
			{	
				//echo "<br />ligne[0] : $ligne[0]";
				//echo " - ligne[1] : $ligne[1]";
				//echo " - ligne[2] : $ligne[2]";
				//echo $requete."<br />";
				//echo "test liste_site.php";
				//bidon();
				$requete1 = "select * from webmestre W, webmestre_site WS where email like '".$_SESSION['mail_utilisateur']."' and WS.id_site=".$ligne['id_site']." and WS.id_webmestre = W.id_webmestre";
				//echo "Webmestre : ".$requete1."<br />";
				$resultat1 = mysql_query($requete1);
						if (mysql_num_rows($resultat1)>0)
						{
						$_SESSION['niveau'] = 2;
						}
						else
						{
						$_SESSION['niveau'] = 1;
						}
						//$ligne=mysql_fetch_array($resultat);
						//echo "Webmestre : ".$ligne[0].$ligne[1].$ligne[2].$ligne[3]." <br />";
				$requete1 = "select * from responsable R, responsable_site RS where email like '".$_SESSION['mail_utilisateur']."' and RS.id_site=".$ligne['id_site']." and RS.id_responsable = R.id_responsable";
				//echo "Responsable : ".$requete1."<br />";
				$resultat1 = mysql_query($requete1);
					if (mysql_num_rows($resultat1) > 0)
					{
					$_SESSION['niveau'] = 3;
					}
					else
					{
						if($_SESSION['niveau'] == 2)
						{
							$_SESSION['niveau'] = 2;
						}
						else
						{
							$_SESSION['niveau'] = 1;
						}
					}
					//$ligne=mysql_fetch_array($resultat);
					//echo "Responsable :".$ligne[0].$ligne[1].$ligne[2].$ligne[3]." <br />";
				$verif = verif_nom_serveur($ligne[2]);
				//echo "<tr>verif :".$verif."</tr>";
				if($verif == 1)
				{
				$lien = str_replace('<nom_site>', $ligne[0], $ligne[1]);
				echo"<tr>
				<td width='40%'> 
				<a target = '_blank' href = 'http://".$lien."'>".$ligne[0]."</a>
				</td>
				<td>
				<a href='mailto:".$ligne[6]."'>".$ligne[4]." ".$ligne[5]."
				</td>";
			
				if ($_SESSION['niveau'] > 1)
				{
					echo"<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."'>?</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Mdp%20Perdu'>R-MDP</a>
					</td>";
				}
				if ($_SESSION['niveau'] == 3)
				{
					echo"
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Suppression%20Site'>X</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Changer%20Mdp'>C-MDP</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Demande%20Formation'>Formation</a>
					</td>";
					//echo"<td>
					//* Historique
					//</td>";
				}
				echo"</tr>";
			}
		}
			echo"</table>";
			?>
	<!-- ici sera charge la reponse mode texte de PHP à la request AJAX -->
			</div>
		
		
		<br />
		</div>
		<div id="bottom" class="scrollbar">
		<h2>Demandes</h2>
		<h3>Demandes en cours</h3>
		<a href="nouvelle_demande.php">Nouvelle demande </a><br />
		<table border = "1"  width = "80%">
		<tr>
			<th>N° dossier</th>
			<th>ST</th>
			<th>Date cr&eacute;ation</th>
			<th>Sujet</th>
			<th>Actions</th>
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
										<td align = \"center\">".$ligne[0]."</td>
										<td align = \"center\">".trad_statut($ligne['STATUT_TRAITEMENT'])."</td>
										<td align = \"center\"> ".$ligne[7]."</td>
										<td>".$ligne[5]."</td>
										<td>
											<a href='repondre.php?num_pere=".$ligne[0]."'>Répondre</a>
											&nbsp;<a href='Modif_reponse.php?num=".$ligne[0]."&mail=".$mail_utilisateur."'>Modifier dernière réponse</a>
											&nbsp;<a href='operation.php?supr=1&num=".$ligne[0]."'>Cloturer demande</a>
											&nbsp;<a href='voir_historique.php?num=".$ligne[0]."'>Détails</a>
										</td>										
									</tr>";
							$i++;
						}
					}
		?>
		
		</table>
		<?php
		echo "<a href='vue_generale.php?mail=".$mail_utilisateur."'>Voir toutes les demandes en cours</a>";
		?><br />		
		<h3>Demandes archivées</h3>
		<table border = "1"  width = "80%">
		<tr>
			<th>N° dossier</th>
			<th>ST</th>
			<th>Date cr&eacute;ation</th>
			<th>Sujet</th>
			<th>Actions</th>
		</tr>
		<?php
	@mysql_close();
	include ("../biblio/init.php");
		$requete = "select * from probleme where mail_individu_emetteur like '".$mail_utilisateur."' and ID_PB_PERE = 0 and (statut_traitement like 'A' or statut like 'F' )order by id_pb desc";
		$resultat = mysql_query($requete);
					if (mysql_num_rows($resultat))
					{	
						$i = 1;
						while ($ligne=mysql_fetch_array($resultat) AND $i <= 1)
						{
							echo "	<tr>
										<td align = \"center\">".$ligne[0]."</td>
										<td align = \"center\">".trad_statut($ligne['STATUT_TRAITEMENT'])."</td>
										<td align = \"center\">".$ligne[7]."</td>
										<td>".$ligne[5]."</td>
										<!--td>".$ligne[6]."</td-->
										<td>
											&nbsp;<a href='operation.php?desupr=1&num=".$ligne[0]."'>Désarchiver</a>
											&nbsp;<a href='voir_historique.php?num=".$ligne[0]."'>Détails</a>
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
