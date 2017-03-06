<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
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
		<script language="JavaScript" type="text/javascript">
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
		</head>
	<body>
		<table align = "center">
			<tr>
				<td>
					<fieldset>
						<legend><b>Modifier une cat&eacute;gorie</b></legend>
						<form action="gc_gestion_categorie.php" method="post">
							<?php
							//recupération des variables identifiant la catégorie
							$num=$_GET['num'];
							$requete = "select *
										from courrier_categorie
										where numero=".$num;
							$resultat = mysql_query($requete);
							$num_rows = mysql_num_rows($resultat);
							if (mysql_num_rows($resultat))
							{	
								while ($ligne=mysql_fetch_array($resultat))
								{
								//Récupération des informations sur le courrier à modifier
									$nom = $ligne[1];	
								}
							}
							//Champs numéro et type non modifiables
							echo "<div align='left'>Num&eacute;ro de cat&eacute;gorie&nbsp;:&nbsp;<input type='text' name='modif_numero_cat' value='".$num."' readonly></div><br />";
							echo "<div align='left'>Intitul&eacute; de la cat&eacute;gorie&nbsp;:&nbsp;<input type='text' name='modif_nom_cat' size = \"30\" value='".$nom."'></div><br />";
							?>
							<div align="center"><input type="submit" value="Modifier" name="modifier_categorie"></div>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
	</body>
</html>
