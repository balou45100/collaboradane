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
	$type_courrier = $_GET['type_courrier'];
	echo "<br />type_courrier : $type_courrier";
	
	$_SESSION['type_courrier'] = "sortant";
	$type_courrier = $_SESSION['type_courrier'];
	
	echo "<br />type_courrier : $type_courrier";
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
		<h2 align = "center"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_entrant.png" id="Image1" title = "Courrier entrant" align="top" border="0">&nbsp;<img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant-2_inactif.png" id="Image2" title = "Courrier sortant" align="top" border="0"></h2>
		<table align = "center">
			<tr>
				<td>
					<fieldset>
						<legend><b>Courrier entrant</b></legend>
						<form action="gc_saisie_exec.php" method="post">
							Numéro d'enregistrement :
							<?php
							$requete = "select count(*)
										from courrier
										where type like 'entrant'
										and annee_scolaire like '".$annee_scolaire."'";
							$resultat = mysql_query($requete);
							$num_rows = mysql_num_rows($resultat);
					
							if (mysql_num_rows($resultat))
							{	
								while ($ligne=mysql_fetch_array($resultat))
								{
									$numero_enregistrement = $ligne[0]+1;
									echo "<div align='right'><input type='text' name='num_enr' value='".$numero_enregistrement."' readonly></div><br />";
								}
							}
							?>
							Année scolaire :
							<?php
							echo "<div align='right'><input type='text' name='annee_scolaire' value='".$annee_scolaire."' readonly></div><br />";
							?>
							Date d'arrivée :
							<div align="right"><input type="text" id="date_arrive1"  name="date_arrive" value="">
							<a href="javascript:popupwnd('calendrier.php?idcible=date_arrive1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="_self"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></div>
							</div><br />
							Date création :
							<div align="right"><input type="text" id="date_courrier1"  name="date_courrier" value="">
							<a href="javascript:popupwnd('calendrier.php?idcible=date_courrier1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="_self"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></div>
							</div><br />
							Expediteur :
							<div align="right"><input type="text" name="expediteur"></div><br />						
							Destinataire :
							<div align="right"><select name="destinataire">
						<?php
					$requete = "select nom
								from util WHERE visible = 'O' ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";						
						}
					}?>
					</select></div><br />
							Categorie :
							<div align="right"><select name="categorie">
						<?php
					echo"<option value = '1' >Autre</option>";
					$requete = "select *
								from courrier_categorie ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if ($ligne[0] <> 1) // on n'affiche pas "Autre" une deuxième fois
							{
								echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
							}
						}
					}?>
					</select></div><br />						
							Concerne :
							<div align="right"><select name="concerne[]" size="4" multiple>
						<?php
					$requete = "select nom, prenom, id_util
								from util WHERE visible = 'O' ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";						
						}
					}?></select></div><br />
							Description :
							<div align="right"><textarea name="description" rows="4" cols="30"></textarea></div><br />
							URL courrier :
							<?php
							if (isset($_SESSION['url']))
							{
								$url = $_SESSION['url'];
							}
							else
							{
								$url = "";
							}
							echo'<div align="right"><input type="text" id="fichier_joint"  name="fichier_joint" value="'.$url.'"></div><br />';
							?>
							<div align="right"><input type="submit" value="Envoyer" name="entrant"></div>
						</form>
					</fieldset>
				</td>
				<td>
					<fieldset>
						<legend><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/courrier_sortant.png" id="Image2" title = "Courrier sortant" align="top" border="0">&nbsp;<b>Courrier sortant</b></legend>
						<form action="gc_saisie_exec.php" method="post">
							Numéro d'enregistrement :
							<?php
							$requete = "select count(*)
										from courrier
										where type like 'sortant'
										and annee_scolaire like '".$annee_scolaire."'";
							$resultat = mysql_query($requete);
							$num_rows = mysql_num_rows($resultat);
							
							if (mysql_num_rows($resultat))
							{	
								while ($ligne=mysql_fetch_array($resultat))
								{
									$numero_enregistrement = $ligne[0]+1;
									echo "<div align='right'><input type='text' name='num_enr' value='".$numero_enregistrement."' readonly></div><br />";
								}
							}
							?>
							Année scolaire :
							<?php
							echo "<div align='right'><input type='text' name='annee_scolaire' value='".$annee_scolaire."' readonly></div><br />";
							?>
							Date d'envoi :
							<div align="right"><input type="text" id="date_arrive"  name="date_arrive" value="">
							<a href="javascript:popupwnd('calendrier.php?idcible=date_arrive&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="_self"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></div>
							</div><br />
							Date r&eacute;daction du courrier :
							<div align="right"><input type="text" id="date_courrier"  name="date_courrier" value="">
							<a href="javascript:popupwnd('calendrier.php?idcible=date_courrier&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="_self"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></div>
							</div><br />
							Destinataire :
							<div align="right"><input type="text" name="destinataire"></div><br />
							Expediteur :
							<div align="right"><select name="expediteur">
						<?php
					$requete = "select nom
								from util WHERE visible = 'O' ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";						
						}
					}?>
					</select></div><br />
							Categorie :
							<div align="right"><select name="categorie">
						<?php
					echo"<option value = '1' >Autre</option>";
					$requete = "select *
								from courrier_categorie ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if ($ligne[0] <> 1) // on n'affiche pas "Autre" une deuxième fois
							{
								echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";						
							}
						}
					}?>
					</select><br /></div>						
							Concerne :
							<div align="right"><select name="concerne[]" size="4" multiple>
						<?php
					$requete = "select nom, prenom, id_util
								from util WHERE visible = 'O' ORDER BY nom ASC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";						
						}
					}?></select></div><br />
							Description :
							<div align="right"><textarea name="description" rows="4" cols="30"></textarea></div><br />
							URL courrier :
							<?php
							if (isset($_SESSION['url']))
							{
								$url = $_SESSION['url'];
							}
							else
							{
								$url = "";
							}
							echo'<div align="right"><input type="text" id="fichier_joint"  name="fichier_joint" value="'.$url.'"></div><br />';
							?>
							<div align="right"><input type="submit" value="Envoyer" name="sortant"></div>
						</form>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<form name="joindre_courrier" enctype="multipart/form-data" method="post" action="pp_piece_jointe.php">
			<fieldset>
			<legend>Joindre courrier</legend>
			Titre du document : <input type="text" value = "" name="nom_doc" SIZE = "50"><br />
			Description du document : <br />
			<TEXTAREA  value = "" name="description_doc" rows = "4" cols = "50"></TEXTAREA><br />
			Fichier à déposer : <input type="file" name="file" SIZE = "40"><br />
              <?php
			  echo "<input type='hidden' name='folder' value='".$dossier_docs_courrier."'>";?>
			<input type="submit" name="courrier" value="Joindre le fichier">
			</form>
				</td>
			</tr>
		</table>
	</body>
</html>
