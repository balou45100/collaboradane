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
	include ("../biblio/init.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
		exit;
	}
	if (isset($_POST['modifier']))
	{
	$requete = "update courrier
				set date='".$_POST['modif_date']."'
					,date_creation='".$_POST['modif_date_creation']."'
					,expediteur='".$_POST['modif_expediteur']."'
					,destinataire='".$_POST['modif_destinataire']."'
					,description='".$_POST['modif_description']."'
					,categorie='".$_POST['modif_categorie']."'
					,annee_scolaire='".$_POST['modif_annee_scolaire']."'
				where type='".$_POST['modif_type']."' 
				and Num_enr=".$_POST['modif_num_enr']."";			
	$resultat = mysql_query($requete);
	$requete = "delete from courrier_concerne
				where type like '".$_POST['modif_type']."'
				and num_enr = ".$_POST['modif_num_enr']."
				and annee_scolaire like '".$_POST['modif_annee_scolaire']."'";			
	$resultat = mysql_query($requete);
	if (isset($_POST['modif_concerne']))
	{
	foreach($_POST['modif_concerne'] as $valeur)
	{
	$requete = "insert into courrier_concerne
				values ('".$_POST['modif_type']."', ".$_POST['modif_num_enr'].", '".$_POST['modif_annee_scolaire']."', '".$valeur."')";			
	$resultat = mysql_query($requete);
	}
	}
	if ($resultat)
					{
						echo"Modification effectuée avec succès";
					}
					else
					{
						echo"Erreur lors de la modification";
					}
	}
?>
<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		<body>
		<fieldset>
		<legend>Recherche</legend>
		<form action="gc_recherche.php" method="post">
		<table width = "100%" border = "0">
		<tr>
		<td align="Center">
					Type : 
						<select size="1" name="type" >
						<option value ="entrant">Entrant</option>
						<option value ="sortant">Sortant</option>
					</select>
		</td>
		<td align="Center">
					Mois : 
						<select size="1" name="mois" >
						<option value="">Choisir un mois</option>
						<option value="1">Janvier</option>
						<option value="2">Février</option>
						<option value="3">Mars</option>
						<option value="4">Avril</option>
						<option value="5">Mai</option>
						<option value="6">Juin</option>
						<option value="7">Juillet</option>
						<option value="8">Aout</option>
						<option value="9">Septembre</option>
						<option value="10">Octobre</option>
						<option value="11">Novembre</option>
						<option value="12">Décembre</option>
						</select>
		</td>
		<td align="Center">
					Date :
					<input type="text" id="date"  name="date" value="">
						<?php
						//	<a href="javascript:popupwnd('calendrier.php?idcible=date&langue=fr','no','no','no','yes','yes','no','50','50','450','280')" target="zone_travail"><img src="images/calendrier.gif" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a>
							?>
							<a href="" onclick="window.open('calendrier.php?idcible=date&langue=fr','pop_up','toolbar=no, status=no, scrollbars=yes, width=280, height=450')"><img src="images/calendrier.gif" id="Image1" alt="" align="top" border="0" style="width:26px;height:26px;"></a></td>
		
		<td align="Center">
					Année scolaire :
					<select size="1" name="annee_scolaire" >
						<option value="">Choisir une scolaire</option>
						<?php
					$requete = "select distinct annee_scolaire
										from courrier order by 1";
					
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
							echo"<option value=\"".$ligne[0]."\">".$ligne[0]."</option>";						
						}
					}?>
					</select>
				</td>
		</tr>
		<tr>
		<td align="Center">
					Expediteur :
					<select size="1" name="expediteur" >
						<option value="">Choisir un expediteur</option>
						<?php
						//recherche du destinataire
						if (isset($_POST['type']) and $_POST['type']!='')
						{
						//Si le type de courrier à déjà été selectionné, on dit que l'on veux que les destinataire donc le courrier est entrant
						$complement=" where type like '".$_POST['type']."'";
						}
						else
						{
						$complement="";
						}
					$requete = "select distinct expediteur
										from courrier".$complement." order by expediteur";
					
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['expediteur']) AND $ligne[0]==$_POST['expediteur'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}?>
					</select>
				</td>
				<td align="Center">
					Destinataire :
					<select>
					<option value="">Choisir un destinataire</option>
						<?php
					if (isset($_POST['type']) and $_POST['type']!='')
						{
						$complement=" where type like '".$_POST['type']."'";
						}
						else
						{
						$complement="";
						}
					$requete = "select distinct destinataire
										from courrier".$complement. " order by destinataire";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['destinataire']) AND $ligne[0]==$_POST['destinataire'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}?>
					</select>
				</td>
				<td align="Center">
					Catégorie : 
					<select name="categorie">
					<option value='' >Choisir une catégorie</option>
						<?php
					$requete = "select *
								from courrier_categorie";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."' >".$ligne[1]."</option>";						
						}
					}?>
					</select>
				</td>
				<td align="right" colspan="3">
					<input type="submit" value="Filtrer">
				</td>
			</tr>
			</table>
			</form>
		</fieldset>
		
		<fieldset>
		<legend>Liste des courriers</legend>
			<table width="100%">
				<tr>
					<td><b>Type</b></td>
					<td><b>Numéro</b></td>
					<td><b>Année scolaire</b></td>
					<td><b>Date de création</b></td>
					<td><b>Date</b></td>
					<td><b>Expediteur</b></td>
					<td><b>Destinataire</b></td>
					<td><b>Personnes concernées</b></td>
					<td><b>Catégorie</b></td>
					<td><b>Description</b></td>
					<td><b>Fichier joint</b></td>
				</tr>
				<?php
				$complement = "";
				//Filtre sur le type
				if (isset($_POST['type']) AND $_POST['type']!="entrant")
							{
								$complement = $complement." and type like 'sortant'";
							}
							else
							{
								$complement = $complement." and type like 'entrant'";
							}
				//Filtre sur le mois si date est vide
				if (isset($_POST['mois']) AND $_POST['mois']!="" AND $_POST['date']=="" AND isset($_POST['date']))
							{
								$complement = $complement." and month(date) = '".$_POST['mois']."'";
							}
				//Filtre sur la date si mois est vide
				if (isset($_POST['date']) AND $_POST['date']!="" AND $_POST['mois']=="" AND isset($_POST['mois']))
							{
								$complement = $complement." and date = '".$_POST['date']."'";
							}
				//Filtre sur l'expediteur
				if (isset($_POST['expediteur']) AND $_POST['expediteur']!="")
							{
								$complement = $complement." and expediteur = '".$_POST['expediteur']."'";
							}
				//Filtre sur le destinataire
				if (isset($_POST['destinataire']) AND $_POST['destinataire']!="")
							{
								$complement = $complement." and destinataire like '".$_POST['destinataire']."'";
							}
				
				//Filtre sur les mots clés
				if (isset($_POST['categorie']) AND $_POST['categorie']!="")
							{
								$complement = $complement." and categorie = ".$_POST['categorie'];
							}
					$requete = "select type, Num_enr, date,date_creation, expediteur, destinataire, description, nom, annee_scolaire, scan
								from courrier, courrier_categorie
								where courrier.categorie=courrier_categorie.numero".$complement." order by 2 DESC";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
						$date=strtotime($ligne[2]);
						$datecre=strtotime($ligne[3]);
						$date=date('d/m/Y',$date);						
						$datecre=date('d/m/Y',$datecre);
						echo "<tr>
								<td>".$ligne[0]."</td>
								<td>".$ligne[1]."</td>
								<td>".$ligne[8]."</td>
								<td>".$datecre."</td>
								<td>".$date."</td>
								<td>".$ligne[4]."</td>
								<td>".$ligne[5]."</td><td>";
								
					$requete2 = "select nom, prenom
								from util u, courrier_concerne c
								where u.id_util=c.id_util
								and type like '".$ligne[0]."'
								and num_enr = '".$ligne[1]."'
								and annee_scolaire like '".$ligne[8]."'";
					$resultat2 = mysql_query($requete2);
					while ($ligne2=mysql_fetch_array($resultat2))
						{
							echo $ligne2[1]." ".$ligne2[0]."<br />";
						}
						echo"	</td><td>".$ligne[7]."</td>
								<td>".$ligne[6]."</td>";
								if ($ligne[9] !="")
								{
								echo"<td><a href='".$ligne[9]."' target='_blank'>Fichier joint</a></td>";
								}
								else
								{
								echo"<td></td>";
								}
								echo"<td><a href='gc_modif_courrier.php?num=".$ligne[1]."&type=".$ligne[0]."' target='_self'>Modifier</a></td>
									<td><a href='gc_prevenir.php?num=".$ligne[1]."&type=".$ligne[0]."&annee=".$ligne[8]."' target='_self'> Prevenir</a></td>
							</tr>";
						}
					}?>
							
			</table>
		</fieldset>
		</body>
