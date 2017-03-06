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
		<table  class = "menu-boutons">
			<tr>
				<td>
					<fieldset>
						<legend>Modifier</legend>
						<form action="gg_gestion_groupe.php" method="post">
							Numéro de groupe :
							<?php
							//recupération des variables identifiant la catégorie
							$num=$_GET['num'];
							$requete = "select *
										from groupes
										where id_groupe=".$num;
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
							echo "<div align='right'><input type='text' name='modif_numero_groupe' value='".$num."' readonly></div><br />";
							echo "Nom : <div align='right'><input type='text' name='modif_nom_groupe' value='".$nom."'></div><br />";
							?>
							<div align="right"><input type="submit" value="Modifier" name="modifier_groupe"></div>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
	</body>
</html>
