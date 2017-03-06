<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include_once("../fckeditor/fckeditor.php") ;
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script>
function visibilite(thingId)
{
var targetElement;
targetElement = document.getElementById(thingId) ;
if (targetElement.style.display == "none")
{
targetElement.style.display = "" ;
} else {
targetElement.style.display = "none" ;
}
}
</script>
	</head>
	<body>
		<h1>Publi-postage</h1><br /><br />
		<center>
		<table border="0" width="80%">
			<tr>
				<td width="80%">
				Liste de destinataire : <a href="" onclick="window.open('pp_edit_liste_destinataire.php','pop_up','toolbar=no, status=no, scrollbars=yes,type=fullWindow,fullscreen')"> éditer </a><br />
					<?php					
					$destinataire="";
					if (isset($_SESSION['code_etab']) && $_SESSION['code_etab']==1 && isset($_GET['etab']))
					{
					$_SESSION['Derniere_ligne'] = 0;
					unset($_SESSION['liste_destinataire']);
					$_SESSION['liste_destinataire']=array();
					foreach($_SESSION['liste_destinataire2'] as $valeur)
					{
					$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']] = $valeur;
					$_SESSION['Derniere_ligne']++;
					}
					$_SESSION['message']="Envoyer un mail aux etablissement";
					unset($_SESSION['code_etab']);
					}
					if (isset($_SESSION['liste_destinataire']))
					{
					foreach($_SESSION['liste_destinataire'] as $valeur)
					{
					$destinataire=$destinataire.$valeur->mail."; ";
					}
					}
					
					
					echo"<input type='text' name='liste_destinataire' readonly size='170' value='".$destinataire."'><br />";
					?>
				</td>
			</tr>
			<tr>			
				<form id="mail" action="pp_mailing.php" method="POST">
				<td width="80%" height="60%">
					<?php
					if(!isset($_SESSION['message']))
					{
						$_SESSION['message']="Saisir un mail";
					}
					
					if(isset($_POST['civilite']))
					{
						$message = $_POST['corps']." *civil* ";
						$_SESSION['message']=$message;
						$_SESSION['objet']=$_POST['objet'];
						$_SESSION['mail']=$_POST['adr_reponse'];
					}
					else
					{
						$message = $_SESSION['message'];
					}
					if(isset($_POST['prenom']))
					{
						$message = $_POST['corps']." *prenom* ";
						$_SESSION['message']=$message;
						$_SESSION['objet']=$_POST['objet'];
						$_SESSION['mail']=$_POST['adr_reponse'];
					}
					else
					{
						$message = $_SESSION['message'];
					}
					if(isset($_POST['nom']))
					{
						$message = $_POST['corps']." *nom* ";
						$_SESSION['message']=$message;
						$_SESSION['objet']=$_POST['objet'];
						$_SESSION['mail']=$_POST['adr_reponse'];
					}
					else
					{
						$message = $_SESSION['message'];
					}
					if(isset($_POST['Sauvegarder']))
					{
						$message = $_POST['corps'];
						$_SESSION['message']=$message;
						$_SESSION['objet']=$_POST['objet'];
						$_SESSION['mail']=$_POST['adr_reponse'];
					}
					else
					{
						$message = $_SESSION['message'];
					}
					if(isset($_POST['envoyer']))
					{
						$_SESSION['message']=$_POST['corps'];
						echo"<script type='text/javascript'>location.href = 'pp_mailing_exec.php';</script>";
						//header('Location: pp_mailing_exec.php');
						exit();
					}
					$objet=$_SESSION['objet'];
					$objet = str_replace("'","`",$objet);
					echo"Objet : <br /><input type='text' name='objet' value='".$objet."' size='170'><br />";
					echo"Mail de réponse : <br /><input type='text' name='adr_reponse' value='".$_SESSION['mail']."' size='170'><br />";
					//Mise en place du textarea "corps" du mail
						$oFCKeditor = new FCKeditor('corps') ;
						$oFCKeditor->BasePath = '../fckeditor/' ;
						$oFCKeditor->Value = $message ;
						$oFCKeditor->Create() ;
					?>
				</td>
				<td>
				<div align = "right">
					<input type="submit" value="Civilité" name="civilite"><br />
					<input type="submit" value="Nom" name="nom"><br />
					<input type="submit" value="Prenom" name="prenom">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
				<div align ="left">
					<input type="submit" value="Sauvegarder" name="Sauvegarder"></div>
				<div align = "right">	
					<input type="submit" value="Envoyer" name="envoyer"></div>				
				</form>
			</tr>
			<tr>
			<td>
			<form name="piece_jointe" enctype="multipart/form-data" method="post" action="pp_piece_jointe.php">
			<fieldset>
			<legend><a href="" onclick="javascript:visibilite('P_jointe'); return false;">Pièce jointe</a></legend>
			<div id="P_jointe" style="display:none;">
			Titre du document : <input type="text" value = "" name="nom_doc" SIZE = "50"><br />
			Description du document : <br />
			<TEXTAREA  value = "" name="description_doc" rows = "4" cols = "50"></TEXTAREA><br />
			Fichier à déposer : <input type="file" name="file" SIZE = "40"><br />
              <?php
			  echo "<input type='hidden' name='folder' value='".$dossier_docs_publipostage."'>";?>
			<input type="submit" name="bouton_submit" value="Joindre le fichier">
			</form>
			</div>
			</td>
			</tr>
		</table>
		</center>
	</body>
</html>
