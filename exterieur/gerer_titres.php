<?php
	//Lancement de la session
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<!"Ce fichier permet de rentrer dans le module pour aficher les informations personnelles">
<?php
	include ("../biblio/fct.php");
	include ("../biblio/config.php");
	include ("../biblio/init.php");
	
	function verifier_titre($num)
	{
		$requete = "select count(*) from ext_titre
					where num_pere=".$num;
		$resultat = mysql_query($requete);
		while ($ligne=mysql_fetch_array($resultat))
						{
	if ($ligne[0] > 0)
		{
			return true	;
		}
	else
		{
			return false;
		}
		}
	}
	
	
	?>
<html>
<body>
<?php
if (isset($_GET['num']))
	{
	$requete = "delete from ext_titre
				where num=".$_GET['num'];
				
	$resultat = mysql_query($requete);
	if ($resultat)
					{
						echo"Suppression effectuée avec succès";
					}
					else
					{
						echo"Erreur lors de la suppression";
					}
	}
	//Si on a post num, c'est qu'on veux ajouter une categorie
	if (isset($_POST['num']))
	{
		if ($_POST['num_pere'] != "")
		{
		$requete = "insert into ext_titre
					value (".$_POST['num'].",".$_POST['num_pere'].", '".$_POST['nom']."')";
		}
		else
		{
		$requete = "insert into ext_titre
					value (".$_POST['num'].",0, '".$_POST['nom']."')";
		}
				
	$resultat = mysql_query($requete);
	if ($resultat)
					{
						echo"Ajout effectué avec succès";
					}
					else
					{
						echo"Erreur lors de l'ajout";
					}
	}
	//Si cette variable post est présente, on veux modifier une catégorie
	if (isset($_POST['modifier_titre']))
	{
	$requete = "update ext_titre
				set nom = '".$_POST['modif_nom']."'
					,num_pere = ".$_POST['modif_num_pere']."
				where num = ".$_POST['modif_num'];
	$resultat = mysql_query($requete);
	if ($resultat)
					{
						echo"Modification effectuée avec succès";
					}
					else
					{
						echo"Erreur lors de la modification";
					}
	}?>
	<center>
	<form action="gerer_titres.php" method="post">
	<table>
		<tr>
			<td><b>Numéro</b></td>
			<td><b>Numéro père</b></td>
			<td><b>Nom</b></td>
		</tr>
		<?php
			//On récupère toute les categories existantes
					$requete = "select *
								from ext_titre
								order by 1";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
						//On les affiches
							echo"<tr><td>".$ligne[0]."</td>";
							echo"<td>".$ligne[1]."</td>";
							echo"<td>".$ligne[2]."</td>";
							echo "<td><a href='modifier_titre.php?num=".$ligne[0]."'> Modifier</a>";
						//On vérifie si elle est utilisée, si elle ne l'est pas, on affihce le bouton permettant de la supprimer
							if (!verifier_titre($ligne[0]))
							{
							echo "<a href='gerer_titres.php?num=".$ligne[0]."'>X</a>";
							}
							echo"</td></tr>";
						}
					}?>
					<tr>
						<td>
						<?php
						$requete = "select max(num)+1
										from ext_titre";
							$resultat = mysql_query($requete);
							while ($ligne=mysql_fetch_array($resultat))
							{
								echo"<input type='text' value='".$ligne[0]."' name='num'></td>";
							}
						
						?>
						<td><select name="num_pere">
							<option value="0">Aucun</option>
							<?php
							$requete = "select *
										from ext_titre";
							$resultat = mysql_query($requete);
							while ($ligne=mysql_fetch_array($resultat))
							{
								echo"<option value='".$ligne[0]."'>".$ligne[2]."</option>";
							}
							?>
							</select></td>
						<td><input type="text" value="" name="nom"></td>
					</tr>
	</table>
	<input type="submit" value="Ajouter">
	</form>
	</center>
</body>
</html>