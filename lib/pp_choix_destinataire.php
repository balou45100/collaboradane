<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	?>
	
<html>	
<head>
<title>Liste destinataires</title>
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
<table border="0" width="400">
	<tr>
		<td>
		<fieldset>
		<legend><a href="" onclick="javascript:visibilite('P_ressource'); return false;">Personnes ressources</a></legend>
			<div id="P_ressource" style="display:none;">
			<form id="Pers_Ress" action="" target="" method="POST">
			<table border="0" width="100%">
				<tr>
					<td rowspan="3">
								<select size="7" name="mail_personne_ressource[]" multiple>
						<?php
						//Rajout d'un restriction sur la fonction si elle est demandée
					if (isset($_GET['pr_fonction']) AND !empty($GET['pr_fonction']))
					{
						$requete_PR_fonction = " and fonction like '".$_GET['pr_fonction']."'" ;
					}
					else
					{
						$requete_PR_fonction = "";
					}
					if (isset($_GET['pr_annee']) AND !empty($GET['pr_annee']))
					{
						$requete_PR_annee = " and annee =".$_GET['fonction']; 
					}
					else
					{
						$requete_PR_annee = "";
					}
					$requete_PR = "select distinct mel, nom, prenom, civil, codetab
										from personnes_ressources_tice prt, fonctions_des_personnes_ressources fprt
										where prt.id_pers_ress = fprt.id_pers_ress";
					$requete_PR=$requete_PR.$requete_PR_annee.$requete_PR_fonction;
					$resultat = mysql_query($requete_PR);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne['mel']."@ac-orleans-tours.fr'>".$ligne['civil']." ".$ligne['nom']." ".$ligne['prenom']."</option>";						
						}
					}?>
								</select>
					</td>
					<td align="right">
						Fonction <br />
						<select size="1" name="pr_fonction" >
						<?php
					$requete = "select distinct fonction
										from fonctions_des_personnes_ressources";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							echo"<option value='".$ligne[0]."'>".$ligne[0]."</option>";						
						}
					}?>
								</select>
					</td>
				</tr>
				<tr>
					<td align="right">
						Année <br />
						<input type="text" name="pr_annee">
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="submit" onclick="document.getElementById(Pers_Ress).action='pp_choix_destinataire.php';document.getElementById(Pers_Ress).target='gauche';document.getElementById(Pers_Ress).method='get';" value="Trier"/> 
						<input type="submit" onclick="document.getElementById(Pers_Ress).action='pp_liste_destinataire.php';document.getElementById(Pers_Ress).target='droite';document.getElementById(Pers_Ress).method='post';" value="Ajouter"/>
					</td>
				</tr>
			</table>
			</form>
			</div>
		</fieldset>
		</td>
	<td>
		<fieldset>
		<legend>Liste des destinataires </legend>
			<select size="35">
			</select>
			<br />
			<div align="right">
			<input type="submit" value="Retirer">
			<input type="submit" value="Valider">
			</div>
		</fieldset>
	</td>
	</tr>
	<tr>
	<td>
	<fieldset>
		<legend><a href="" onclick="javascript:visibilite('ECL'); return false;">Ecoles Collèges Lycées</a></legend>
			<div id="ECL" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td rowspan="2">
						
								<select size="7">
								</select>
					</td>
					<td align="right">
						Type d'établissement <br />
						<select size="1" name="type_etablissement">
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="submit" value="Trier">
						<input type="submit" value="Ajouter">
					</td>
				</tr>
			</table>
			</div>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td>
		<fieldset>
		<legend><a href="" onclick="javascript:visibilite('Contact'); return false;">Contacts</a></legend>
			<div id="Contact" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td>
						
								<select size="7">
								</select>
					</td>
					<td align="right" valign="bottom">
						<input type="submit" value="Ajouter">
					</td>
				</tr>
			</table>
			</div>
		</td>
		</fieldset>
	</tr>
	<tr>
		<td>
		<fieldset>
			<legend><a href="" onclick="javascript:visibilite('Societe'); return false;">Sociétés</a></legend>
			<div id="Societe" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td rowspan="3">
								<select size="7">
								</select>
					</td>
					<td align="right">
						Code Postal <br />
						<input type="text" name="Societe_cp">
					</td>
				</tr>
				<tr>
					<td align="right">
						Société à traiter <br />
						<input type="checkbox" name="a_traiter">
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="submit" value="Trier">
						<input type="submit" value="Ajouter">
					</td>
				</tr>
			</table>
			</div>
		</fieldset>
		</td>
	</tr>
</table>

</body>
</html>
