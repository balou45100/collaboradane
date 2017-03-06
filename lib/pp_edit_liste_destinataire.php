<?php
	//Lancement de la session
	session_start();
?>
<!DOCTYPE HTML>
<?php
////////////////////////////////////////////////////////////////////////////////////////
///////////////////Includes et Initialisation///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");

?>
	
<html>	
<head>
<title>Liste destinataires</title>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////Fonction pour cacher les cadres (à retravailler)///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
?>
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

<?php
//Si post effacer existe, c'est qu'on veux effacer la liste des destinataires
	if (isset($_POST['effacer'])) 
		{	
			unset ($_SESSION['liste_destinataire']);
			unset ($_SESSION['Derniere_ligne']);
			
			unset ($_SESSION['code_etab']);
		}
//S'ils n'existe pas, on les initialise : vide pour le tableau, à 0 pour la ligne
	if(!isset($_SESSION['liste_destinataire']))
		{
			$_SESSION['liste_destinataire']=array();
		}
	if(!isset($_SESSION['Derniere_ligne']))
		{
			$_SESSION['Derniere_ligne']=0;
		}
		
		
//////////////////////////////////////////////////////////////////////////////////		
////////////////////////Action du bouton retirer mail/////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

	if (isset($_POST['liste_destinataire']))
		{
		//Tableau pour stocker temporairement les mails et initialisation de $i
			$tab_temp = array();
			$i = 0;
		//On stocke tout les destinataires dans la tableau temporaire
			foreach($_SESSION['liste_destinataire'] as $valeur)
			{			
			$tab_temp[$i]->mail = $valeur->mail;
			$tab_temp[$i]->nom = $valeur->nom;
			$tab_temp[$i]->prenom = $valeur->prenom;
			$tab_temp[$i]->civilite = $valeur->civilite;			
			$tab_temp[$i]->codetab = $valeur->codetab;
			$i++;
			}
		//On réinitialise $_SESSION['liste_destinataire']
			unset($_SESSION['liste_destinataire']);
			$_SESSION['liste_destinataire'] = array();
		//On compte le nombre de ligne de liste destinataire
			$nblign = count($_POST['liste_destinataire']);
		//On ne remet dans session que les mails qui ne sont pas selectionnés
		//Les mails selectionné sont ceux qui sont présents dans $_POST['Liste_Destinataire']
		$i = 0;
			foreach($tab_temp as $valeur)
			{
				if(!verifmail($valeur->mail, $_POST['liste_destinataire'], $nblign))
				{
					$_SESSION['liste_destinataire'][$i]->mail = $valeur->mail;
					$_SESSION['liste_destinataire'][$i]->nom = $valeur->nom;
					$_SESSION['liste_destinataire'][$i]->prenom = $valeur->prenom;
					$_SESSION['liste_destinataire'][$i]->civilite = $valeur->civilite;
					$_SESSION['liste_destinataire'][$i]->codetab = $valeur->codetab;
					
					$i++;
				}
			}
			$_SESSION['Derniere_ligne']=count($_SESSION['liste_destinataire']);
		}
		
//////////////////////////////////////////////////////////////////////////////////		
///////////Ajout des mails choisit dans la liste des destinataires////////////////
//////////////////////////////////////////////////////////////////////////////////

			if (isset($_POST['mail_personne_ressource']))
			{
			$_SESSION['code_etab']=1;
			foreach($_POST['mail_personne_ressource'] as $valeur)
			{
				if($valeur <>"")
				{
				$mail=str_replace("@ac-orleans-tours.fr","",$valeur);
				$requete = "select distinct nom, prenom, civil, codetab
										from personnes_ressources_tice prt, fonctions_des_personnes_ressources fprt
										where prt.id_pers_ress = fprt.id_pers_ress
										and mel like '".$mail."'";
				$resultat = mysql_query($requete);
				$ligne=mysql_fetch_array($resultat);
				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->mail = $valeur;
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->nom = $ligne[0];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->prenom = $ligne[1];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->civilite = $ligne[2];				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->codetab = $ligne[3];
				$_SESSION['Derniere_ligne']++;
				
				}
			}			
			}
			if (isset($_POST['mail_etablissement']))
			{
			foreach($_POST['mail_etablissement'] as $valeur)
			{
			if($valeur <>"")
				{
				$requete = "select distinct TYPE_ETAB_GEN, NOM
										from etablissements
										where MAIL like '".$valeur."'";
				$resultat = mysql_query($requete);
				$ligne=mysql_fetch_array($resultat);
				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->mail = $valeur;
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->nom = $ligne[0]." ".$ligne[1];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->prenom = "";
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->civilite = "";				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->codetab = "";
				$_SESSION['Derniere_ligne']++;
				
				}
			}			
			}
			if (isset($_POST['mail_contact']))
			{
			foreach($_POST['mail_contact'] as $valeur)
			{
			if($valeur <>"")
				{
				$requete = "select nom, prenom
							from contacts
							where mel_pro like '".$valeur."'";
				$resultat = mysql_query($requete);
				$ligne=mysql_fetch_array($resultat);
				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->mail = $valeur;
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->nom = $ligne[0];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->prenom = $ligne[1];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->civilite = "";				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->codetab = "";
				$_SESSION['Derniere_ligne']++;
				
				}
			}			
			}
			if (isset($_POST['mail_societe']))
			{
			foreach($_POST['mail_societe'] as $valeur)
			{
			if($valeur <>"")
				{
				$requete = "select distinct societe, email
										from repertoire
										where email like '".$valeur."'";
				$resultat = mysql_query($requete);
				$ligne=mysql_fetch_array($resultat);
				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->mail = $valeur;
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->nom = $ligne[0];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->prenom = "";
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->civilite = "";				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->codetab = "";
				$_SESSION['Derniere_ligne']++;
				
				}
			}			
			}
			if (isset($_POST['ajout_manuel']))
			{
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->mail = $_POST['manuel_mail'];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->nom = $_POST['manuel_nom'];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->prenom = $_POST['manuel_prenom'];
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->civilite = $_POST['manuel_civilite'];				
				$_SESSION['liste_destinataire'][$_SESSION['Derniere_ligne']]->codetab = "";
				$_SESSION['Derniere_ligne']++;
				
				
			}			
			
	
/////////////////////////////////////////////////////////////////////////////////////////////////
	?>
<table border="1" width="400">
	<tr>
		<td valign="top">
		<fieldset>
		<legend><a href="" onclick="javascript:visibilite('P_ressource'); return false;">Personnes ressources</a></legend>
			<div id="P_ressource" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td>
					
					<form id = "tri" method ="POST" action="pp_edit_liste_destinataire.php">
						<select size="1" name="pr_fonction" >
						<option value="">Choisir une fonction</option>
						<?php
						//Selection d'une fonction
					$requete = "select distinct fonction
										from fonctions_des_personnes_ressources order by fonction";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['pr_fonction']) AND $ligne[0]==$_POST['pr_fonction'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='".$ligne[0]."'".$selected.">".$ligne[0]."</option>";						
						}
					}?>
					</select>
		
					
						<select size="1" name="pr_annee" >
						<option value="">Choisir une année</option>
						<?php
						//Selection d'une année
					$requete = "select distinct annee
										from fonctions_des_personnes_ressources order by annee";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{	
						//"Mise en mémoire" du choix
							if (isset($_POST['pr_annee']) AND $ligne[0]==$_POST['pr_annee'])
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
					<input type="submit" value="Filtrer"/> 
					</form>
					</td>
					</tr>
					<tr>
					<td>
			<form id="Pers_Ress" action="pp_edit_liste_destinataire.php" method="POST">
					<select size="7" name="mail_personne_ressource[]" multiple>
						<?php
						//Rajout d'un restriction sur la fonction et sur l'année si elles sont demandées
					if (isset($_POST['pr_fonction']))
					{	
						if (!$_POST['pr_fonction']=="")
						{
							$requete_PR_fonction = " and fonction like '".$_POST['pr_fonction']."'" ;
						}
						else
						{
							$requete_PR_fonction = "";
						}
					}
					if (isset($_POST['pr_annee']))
					{
						if (!$_POST['pr_annee']=="")
						{
							$requete_PR_annee = " and annee = ".$_POST['pr_annee']; 
						}
						else
						{
							$requete_PR_annee = "";
						}
					}
					$requete_PR = "select distinct mel, nom, prenom, civil, codetab
										from personnes_ressources_tice prt, fonctions_des_personnes_ressources fprt
										where prt.id_pers_ress = fprt.id_pers_ress";
										
					//Application des restrictions si présentes
					
					$requete_PR=$requete_PR.$requete_PR_fonction.$requete_PR_annee." order by nom";
					$resultat = mysql_query($requete_PR);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
							$tab_temporaire = array();
							$i = 0;
							foreach($_SESSION['liste_destinataire'] as $valeur)
							{
								$tab_temporaire[$i] = $valeur->mail;
								$i++;
							}
						while ($ligne=mysql_fetch_array($resultat))
						{
							$mail = $ligne['mel']."@ac-orleans-tours.fr";
							//La fonction renvois vraie si le mail existe dans le tableau fournit
							if(!verifmail($mail, $tab_temporaire, $_SESSION['Derniere_ligne']))
							{
							//On affiche seulement si l'adresse n'est pas déjà ajoutée
							echo"<option value='".$mail."'>".$ligne['nom']." ".$ligne['prenom']."</option>";
							}							
						}
					}?>
								</select>
					</td>
					<td align="right">
						<input type="submit" value="Ajouter"/>
					</td>
				</tr>
			</table>
			</form>
			</div>
		</fieldset>
		</td>
	<td rowspan = "5">
		<fieldset>
		<legend>Liste des destinataires </legend>
			<form method="post" action="pp_edit_liste_destinataire.php">
			<select size="30" name="liste_destinataire[]" multiple>
			<?php
			//On récupère le nombre de ligne pour savoir quand s'arreter
			$imax = $_SESSION['Derniere_ligne'] ;
			$j = 0;
			//Ecriture de la liste des destinataires
			while ($j < $imax)
			{
				echo "<option value='".$_SESSION['liste_destinataire'][$j]->mail."'>".$_SESSION['liste_destinataire'][$j]->mail."</option>";
				$j = $j +1;				
			}
			?>
			</select>
			<br />
			<div align="right">
			<input type="submit" value="Retirer"><br />
			</form>
			<form method="post" action="pp_edit_liste_destinataire.php"><br />
				<input type="submit" value="Vider" name="effacer">
			</form>			
			<input type="button" value="Valider" onclick="javascript:parent.opener.location.reload();window.close();">
			</div>
		</fieldset>
	</td>
	</tr>
	<tr>
	<td valign="top">
	<fieldset>
		<legend><a href="" onclick="javascript:visibilite('ECL'); return false;">Ecoles Collèges Lycées</a></legend>
			<div id="ECL" style="display:none;">
			<table border="0" width="100%">
				<tr>
				<td>
				<form id = "tri" method ="POST" action="pp_edit_liste_destinataire.php">
						<select size="1" name="type_etablissement">
						<option value="">Choisir un type d'établissement</option>
						<?php
						$requete_PR = "select distinct TYPE_ETAB_GEN
										from etablissements
										where mail <> ''
										order by type";
						$resultat = mysql_query($requete_PR);
						$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
						while ($ligne=mysql_fetch_array($resultat))
						{
							if (isset($_POST['type_etablissement']) AND $ligne[0]==$_POST['type_etablissement'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value=\"".$ligne[0]."\" ".$selected.">".$ligne[0]."</option>";						
						}
					}
						?>
						</select>
						<select name="ecl_dep" size = "1">
						<option value="">Choisir un département</option>
						<?php
						//Selection d'un département
							$valeur = 18;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='18' ".$selected.">Cher (18)</option>";
							$valeur = 28;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='28' ".$selected.">Eure-et-Loire (28)</option>";
							$valeur = 36;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='36' ".$selected.">Indre (36)</option>";
							$valeur = 37;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='37' ".$selected.">Indre-et-Loire (37)</option>";
							$valeur = 41;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='41' ".$selected.">Loir-et-Cher (41)</option>";
							$valeur = 45;
							if (isset($_POST['ecl_dep']) AND $valeur==$_POST['ecl_dep'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='45' ".$selected.">Loiret (45)</option>";						
						
					?>
					</select>
						<input type="submit" value="Filtrer">
				</form>
				</td>
				</tr>
				<tr>
					<td>
						<form id = "mail_etablissement" method ="POST" action="pp_edit_liste_destinataire.php">
								<select name="mail_etablissement[]" size="7" multiple>
								<?php
								
								if (isset($_POST['type_etablissement']))
								{
									if (!$_POST['type_etablissement']=="")
									{
										$requete_ecl_type = ' and TYPE_ETAB_GEN like "'.$_POST['type_etablissement'].'"'; 
									}
									else
									{
										$requete_ecl_type = "";
									}
								}
								if (isset($_POST['ecl_dep']))
								{
									if (!$_POST['ecl_dep']=="")
									{
										$requete_ecl_dep = ' and code_postal like "'.$_POST['ecl_dep'].'%"'; 
									}
									else
									{
										$requete_ecl_dep = "";
									}
								}
					$requete_ecl = "select mail, nom, rne, TYPE_ETAB_GEN
									from etablissements
									where mail <> ''";
					$requete_ecl=$requete_ecl.$requete_ecl_type.$requete_ecl_dep." order by nom";
					$resultat = mysql_query($requete_ecl);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
							$tab_temporaire = array();
							$i = 0;
							foreach($_SESSION['liste_destinataire'] as $valeur)
							{
								$tab_temporaire[$i] = $valeur->mail;
								$i++;
							}
						while ($ligne=mysql_fetch_array($resultat))
						{
							if(!verifmail($mail, $tab_temporaire, $_SESSION['Derniere_ligne']))
							{
							if ($ligne[0] <> "")
							{
								if ($ligne[1] == "")
								{
									$nom = "Nom non-renseigné : ";
								}
								else
								{
									$nom = $ligne[3]." ".$ligne[1]." : ";
								}
							echo"<option value='".$ligne[0]."'>".$nom.$ligne[0]."</option>";	
							}
							}
						}
					}?>
								</select>
					</td>					
				</tr>
				<tr>
					<td align="right">
						<input type="submit" value="Ajouter">
						</form>
					</td>
				</tr>
			</table>
			</div>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td valign="top">
		<fieldset>
		<legend><a href="" onclick="javascript:visibilite('Contact'); return false;">Contacts</a></legend>
			<div id="Contact" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td rowspan="3">
					<form id = "mail_contact" method ="POST" action="pp_edit_liste_destinataire.php">
								<select size="7" name="mail_contact[]" multiple>
								<?php
					$requete_contact = "select societe, nom, prenom,mel_pro
									from repertoire r, contacts c
									where r.no_societe = c.id_societe
									and	email <> ''";
					$requete_contact=$requete_contact." order by nom";
					$resultat = mysql_query($requete_contact);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
							$tab_temporaire = array();
							$i = 0;
							foreach($_SESSION['liste_destinataire'] as $valeur)
							{
								$tab_temporaire[$i] = $valeur->mail;
								$i++;
							}
						while ($ligne=mysql_fetch_array($resultat))
						{
							if(!verifmail($ligne[3], $tab_temporaire, $_SESSION['Derniere_ligne']))
							{
							echo"<option value='".$ligne[3]."'>".$ligne[2]." ".$ligne[1]." (".$ligne[0].")</option>";
							}
						}
					}?>
								</select>
					</td>
					<td align="right">
						<input type="submit" value="Ajouter">
					</form>
					</td>
				</tr>
			</table>
			</div>
		</td>
		</fieldset>
	</tr>
	<tr>
		<td valign="top">
		<fieldset>
			<legend><a href="" onclick="javascript:visibilite('Societe'); return false;">Sociétés</a></legend>
			<div id="Societe" style="display:none;">
			<table border="0" width="100%">
			<form id = "tri" method ="POST" action="pp_edit_liste_destinataire.php">
				<tr>
					<td align="right">
						Code Postal <br />
						<select size="1" name="Societe_cp">
							<option value="">Choisir un département</option>
						<?php
						//Selection d'un département
							$valeur = 18;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='18' ".$selected.">Cher (18)</option>";
							$valeur = 28;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='28' ".$selected.">Eure-et-Loire (28)</option>";
							$valeur = 36;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='36' ".$selected.">Indre (36)</option>";
							$valeur = 37;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='37' ".$selected.">Indre-et-Loire (37)</option>";
							$valeur = 41;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='41' ".$selected.">Loir-et-Cher (41)</option>";
							$valeur = 45;
							if (isset($_POST['Societe_cp']) AND $valeur==$_POST['Societe_cp'])
							{
								$selected=" selected";
							}
							else
							{
							$selected="";
							}
							echo"<option value='45' ".$selected.">Loiret (45)</option>";						
						
					?>
					</select>
					Société à traiter <input type="checkbox" name="a_traiter" value="1">
						<input type="submit" value="Trier">
			</form>
					</td>
				</tr>
				<tr>
					<td rowspan="3">
					<form id = "mail_societe" method ="POST" action="pp_edit_liste_destinataire.php">
								<select size="7" name="mail_societe[]" multiple>
								<?php
								
								if (isset($_POST['Societe_cp']))
								{
									if (!$_POST['Societe_cp']=="")
									{
										$requete_societe_cp = ' and cp like "'.$_POST['Societe_cp'].'%"'; 
									}
									else
									{
										$requete_societe_cp = "";
									}
								}
								if (isset($_POST['a_traiter']))
								{
									if (!$_POST['a_traiter']=="")
									{
										$requete_societe_a_traiter = ' and a_traiter = '.$_POST['a_traiter']." "; 
									}
									else
									{
										$requete_societe_a_traiter = "";
									}
								}
					$requete_societe = "select societe, email
									from repertoire
									where email <> ''";
					$requete_societe=$requete_societe.$requete_societe_cp.$requete_societe_a_traiter." order by societe";
					$resultat = mysql_query($requete_societe);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{
							$tab_temporaire = array();
							$i = 0;
							foreach($_SESSION['liste_destinataire'] as $valeur)
							{
								$tab_temporaire[$i] = $valeur->mail;
								$i++;
							}
						while ($ligne=mysql_fetch_array($resultat))
						{
							if(!verifmail($ligne[1], $tab_temporaire, $_SESSION['Derniere_ligne']))
							{
							echo"<option value='".$ligne[1]."'>".$ligne[0]."</option>";
							}
						}
					}?>
								</select>
					</td>
					<td align="right">
						<input type="submit" value="Ajouter">
					</form>
					</td>
				</tr>
			</table>
			</div>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td valign="top">
		<fieldset>
		<legend><a href="" onclick="javascript:visibilite('Manuel'); return false;">Ajout Manuel</a></legend>
			<div id="Manuel" style="display:none;">
			<table border="0" width="100%">
				<tr>
					<td rowspan="3">
					<form id = "mail_manuel" method ="POST" action="pp_edit_liste_destinataire.php">					
					<input type="text" name="manuel_civilite" value="Civilite"><br />
					<input type="text" name="manuel_nom" value="Nom"><br />
					<input type="text" name="manuel_prenom" value="Prenom"><br />
					<input type="text" name="manuel_mail" value="E-mail"><br />
					<input type="submit" value="Ajouter" name="ajout_manuel">
					</form>
					</td>
				</tr>
			</table>
			</div>
		</td>
		</fieldset>
	</tr>
</table>

</body>
</html>
