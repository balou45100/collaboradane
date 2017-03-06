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
	//include ("../biblio/ticket.css");
	/*if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}*/
	
	//Fonction permettant de verifier si une catégorie est utilisée, renvoie vrai ou faux
	function verifier_categorie($numcat)
	{
		$requete = "select count(*) from courrier
					where categorie=".$numcat;
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

	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
				<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />

		</head>
	<body>";
	//Si on à get numcat, c'est que l'on veux supprimer une categorie
	if (isset($_GET['numcat']))
	{
	$requete = "delete from courrier_categorie
				where numero=".$_GET['numcat'];
				
	$resultat = mysql_query($requete);
	if ($resultat)
					{
						echo "<h2>Suppression effectuée avec succès</h2>";
					}
					else
					{
						echo "<h2>Erreur lors de la suppression</h2>";
					}
	}
	//Si on a post num, c'est qu'on veux ajouter une categorie
	if (isset($_POST['nom']))
	{
		$nom = $_POST['nom'];
		//echo "<br />nom : $nom";
		//On vérifie si la catégorie n'existe pas déjà
		$req_verif_cat = "
			SELECT * 
			FROM courrier_categorie
			WHERE nom LIKE '".$nom."'";
		$res_req_verif_cat = mysql_query($req_verif_cat);
		$verif = mysql_num_rows($res_req_verif_cat);
		
		//echo "<br />verif : $verif";
		
		if ($verif >0)
		{
			echo "<h2>Cette cat&eacute;gorie existe d&eacute;j&agrave;&nbsp;!</h2>";
		}
		else
		{
			$requete = "INSERT into courrier_categorie
				SET nom = '".$nom."'";
		
			//echo "<br />$requete";
		
			$resultat = mysql_query($requete);
			if ($resultat)
			{
				echo "<h2>Ajout effectué avec succès</h2>";
			}
			else
			{
				echo "<h2>Erreur lors de l'ajout</h2>";
			}
		}
	} //Fin If ISSET 'nom'
			
	//Si cette variable post est présente, on veux modifier une catégorie
	if (isset($_POST['modifier_categorie']))
	{
	$requete = "update courrier_categorie
				set nom = '".$_POST['modif_nom_cat']."'
				where numero = ".$_POST['modif_numero_cat'];
				
	$resultat = mysql_query($requete);
	if ($resultat)
					{
						echo "<h2>Modification effectuée avec succès</h2>";
					}
					else
					{
						echo "<h2>Erreur lors de la modification</h2>";
					}
	}?>
	<center>
	<form action="gc_gestion_categorie.php" method="post">
	<center>
		<input type="text" value="" name="nom">&nbsp;<input type="submit" value="Ajouter la nouvelle cat&eacute;gorie">
	</center>

	<br />
	<table border = "1" cellpadding = "1">
		<tr>
			<!--td><b>Numéro catégorie</b></td-->
			<th><b>Nom cat&eacute;gorie</b></th>
			<th><b>Actions</b></th>
		</tr>
		<?php
			//On récupère toute les categories existantes
					$requete = "select *
								from courrier_categorie ORDER BY nom";
					$resultat = mysql_query($requete);
					$num_rows = mysql_num_rows($resultat);
					
					if (mysql_num_rows($resultat))
					{	
						while ($ligne=mysql_fetch_array($resultat))
						{
						//On les affiches
							//echo"<tr><td>".$ligne[0]."</td>";
							echo"<td nowrap>&nbsp;".$ligne[1]."</td>";
							echo "<td><a href='gc_modif_categorie.php?num=".$ligne[0]."'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier la cat&eacute;gorie\" border = \"0\"></a>";
							//On vérifie si elle est utilisée, si elle ne l'est pas, on affihce le bouton permettant de la supprimer
							if (!verifier_categorie($ligne[0]))
							{
							echo "&nbsp;<a href='gc_gestion_categorie.php?numcat=".$ligne[0]."'><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"supprimer\" title=\"Supprimer la cat&eacute;gorie\" border = \"0\"></a>";
							}
							echo"</td>";
							echo "</tr>";
						}
					}?>
	</table>
	
	</form>
	</center>
	</body>
<html>
