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
<?php
	//recupération des variables identifiant le courrier à modifer
	$type=$_GET['type'];
	$num=$_GET['num'];
	$type_courrier=$_GET['type_courrier']; //pour le filtre principal entrant / sortant
	$annee_scolaire_filtree = $_GET['annee_scolaire_filtree'];
	
	//echo "<br />modif : type_courrier : $type_courrier";
	//echo "<br />modif : annee_scolaire_filtree : $annee_scolaire_filtree";
?>
		<table align = "center">
			<tr>
				<td>
					<fieldset>
						<legend><b>Modifier</b></legend>
						<form action="gc_recherche.php" method="post">
							<?php
							
							$requete = "
								SELECT *
								FROM courrier
								WHERE type like '".$type."'
									AND num_enr=".$num."
									AND annee_scolaire LIKE '".$annee_scolaire_filtree."'";
										
							//echo "<br />$requete";
							
							$resultat = mysql_query($requete);
							$num_rows = mysql_num_rows($resultat);
							if (mysql_num_rows($resultat))
							{	
								while ($ligne=mysql_fetch_array($resultat))
								{
								//Récupération des informations sur le courrier à modifier
									$date=$ligne[2];
									$date_cre=$ligne[3];
									$expediteur=$ligne[4];
									$destinataire=$ligne[5];
									$description=$ligne[6];
									$categorie=$ligne[7];
									$annee_scolaire_enreg = $ligne[8];
									$confidentiel = $ligne[10];
								}
							}
							
							//echo "<br />annee_scolaire_enreg : $annee_scolaire_enreg";
							
							//Champs numéro et type non modifiables
							echo "<div align='left'>Num&eacute;ro d'enregistrement&nbsp;:&nbsp;<input type='text' name='modif_num_enr' value='".$num."' readonly></div><br />";
							echo "<div align='left'>Type&nbsp;:&nbsp;<input type='text' name='modif_type' value='".$type."' readonly></div><br />";
							?>
							<?php
							echo "<div align='left'>Année scolaire&nbsp;:&nbsp;<input type='text' name='modif_annee_scolaire' value='".$annee_scolaire_enreg."' readonly></div><br />";
							echo"<div align='left'>Date création&nbsp;:&nbsp;<input type='text' id='date_arrive1'  name='modif_date_creation' value='".$date_cre."'>";
							?>
							<a href="javascript:popupwnd('calendrier.php?idcible=date_arrive1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="_self"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></div>
							</div><br />
							
							<?php
							if ($type == "entrant")
							{
							//Si le courrier est entrant, le destinataire est choisi dans une liste
							//echo "Expediteur :";
							echo"<div align='left'>Date d'arrivée&nbsp;:&nbsp;<input type='text' id='date_courrier1'  name='modif_date' value='".$date."'>";
							echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_courrier1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
							echo "<br />";
							echo '<div align="left">Expediteur&nbsp;:&nbsp;<input type="text" size = "50" name="modif_expediteur" value="'.$expediteur.'"></div><br />';

							echo '<div align="left">';
							
							echo 'Destinataire&nbsp;:&nbsp;<select name="modif_destinataire">';
					$requete = "select nom
								from util
								WHERE visible = 'O'
								ORDER BY NOM";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if($ligne[0] == $destinataire)
							{
								echo"<option value='".$ligne[0]."' selected>".$ligne[0]."</option>";	
							}
							else
							{
								echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";
							}
						}
					}
					echo"</select></div><br />";
					}
					else
					{
						//Sinon c'est l'expediteur qui est dans une liste
						echo"<div align='left'>Date d'expédition&nbsp;:&nbsp;<input type='text' id='date_courrier1'  name='modif_date' value='".$date."'>";
						echo "<a href=\"javascript:popupwnd('calendrier.php?idcible=date_courrier1&langue=fr','no','no','no','yes','yes','no','50','50','450','280')\" target=\"_self\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/calendrier.png\" id=\"Image1\" alt=\"\" align=\"top\" border=\"0\" style=\"width:26px;height:26px;\"></a></div>";
						echo "<br />";
					echo'<div align="left">Destinataire&nbsp;:&nbsp;<input type="text" size = "50" name="modif_destinataire" value="'.$destinataire.'"></div><br />
							
							<div align="left">Expéditeur&nbsp;:&nbsp;
							
							<select name="modif_expediteur">';
					$requete = "select nom
								from util
								WHERE visible = 'O'
								ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if($ligne[0] == $expediteur)
							{
							echo"<option value='".$ligne[0]."' selected>".$ligne[0]."</option>";	
							}
							else
							{
							echo"<option value='".$ligne[0]."' >".$ligne[0]."</option>";
							}
						}
					}
					echo"</select></div><br />";
					}
							echo"<div align='left'>Categorie&nbsp;:&nbsp;<select name='modif_categorie'>";
						
					$requete = "select *
								from courrier_categorie ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							if($ligne[0] == $categorie)
							{
								echo"<option value='".$ligne[0]."' selected>".$ligne[1]."</option>";	
							}
							else
							{
								echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";
							}						
						}
					}
					?>
					</select></div><br />						
						<div align="left">Concerne&nbsp;:&nbsp;<select name="modif_concerne[]" size="4" multiple>
					<?php
					$requete = "select nom, prenom, id_util
								from util
								WHERE visible = 'O'
								ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							//Il faut tester si la personne est déjà associée au courrier
							//si oui en la sélectionne, si non elle n'est pas sélectionnée
							$requete_verif_personne = "select * FROM courrier_concerne WHERE id_util = '".$ligne[2]."' AND Num_enr = '".$num."' AND annee_scolaire = '".$annee_scolaire_enreg."' AND Type = '".$type."'";
							$resultat_requete_verif_personne = mysql_query($requete_verif_personne);
							//$ligne_personne = mysql_fetch_row(resultat_requete_verif_personne);
							$num_rows = mysql_num_rows($resultat_requete_verif_personne);
							if ($num_rows >0)
							{
								echo"<option selected value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";
							}
							else
							{
								echo"<option value='".$ligne[2]."' >".$ligne[1]." ".$ligne[0]."</option>";
							}
						}
					}
					?>
					</select></div><br />
					<?php
						echo "<div align=\"left\">Description&nbsp;:&nbsp;<input type = \"text\" size = \"50\" name=\"modif_description\" value=\"$description\"></div><br />";
						echo "<div align=\"left\">Confidentiel&nbsp;:&nbsp;<select name=\"modif_confidentiel\" size=\"1\">";
							if ($confidentiel == "O")
							{
								echo"<option selected value=\"O\">Oui</option>";
								echo"<option value=\"N\">Non</option>";
							}
							else
							{
								echo"<option selected value=\"N\">Non</option>";
								echo"<option value=\"O\">Oui</option>";
							}
							echo "</select></div>";
							//echo "<br />";
							echo "<div align=\"center\">";
								echo "<input type=\"submit\" value=\"Modifier\" name=\"modifier\">";
								echo "<input type=\"hidden\" value='".$type_courrier."' name=\"type_courrier\">";
							echo "</div>";
					?>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
	</body>
</html>
