<?php
	session_start();
	include("../biblio/config.php");
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
		<script language="JavaScript" type="text/javascript">
<!--
function popupwnd(url, toolbar, menubar, locationbar, resize, scrollbars, statusbar, left, top, width, height)
{
   var popupwindow = this.open(url, '', 'toolbar=' + toolbar + ',menubar=' + menubar + ',location=' + locationbar + ',scrollbars=' + scrollbars + ',resizable=' + resize + ',status=' + statusbar + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height);
}
//-->
</script>
<?php
	echo "</head>";
	//Inclusion des fichiers nécessaires
	//include ("../biblio/init.php");

	echo "<body>";
	$page_appelant = "abo";
	echo "<div align = \"center\">";
	include("../biblio/init.php");
	include("abo_menu_principal.inc.php");

	//On vérifie s'il y a des actions à faire
	$action = $_GET['action'];
	if (!ISSET($action))
	{
		$action = $_POST['action'];
	}
	$a_faire = $_GET['a_faire'];

	if (!ISSET($a_faire))
	{
		$a_faire = $_POST['a_faire'];
	}
	/*
	echo "<br />action : $action";
	echo "<br />a_faire : $a_faire";
	*/
	if ($action == "O")
	{
		switch ($a_faire)
		{
			case ("ajout_abonnement"):
				echo "<h2>Ajout d'un abonnement</h2>";
				include ("abo_ajout_abo.inc.php");
				$affichage = "N";
			break; //("ajout_abonnement")
		
			case ("enreg_abonnement"):
				echo "<h2>Enregistrement d'un abonnement</h2>";
				include ("abo_enreg_abo.inc.php");
				//$affichage = "N";
			break; //("ajout_abonnement")
		
		} //switch ($a_faire)
	} //if ($action == "O")
	
	//On vérifie s'il faut afficher la liste des abonnements
	
	If ($affichage <> "N")
	{
		echo "<H2>Liste des abonnements</H2>";
		echo "<table border>";
			echo "<TR>";
				echo "<th>Titre</th>";
				echo "<th>Cat&eacute;gorie(s)</th>";
				echo "<th>Fournisseur</th>";
				echo "<th>Date saisie</th>";
				echo "<th>Date de début</th>";
				echo "<th>Date de fin</th>";
				echo "<th>Prix</th>";
				echo "<th>P&eacute;riodicit&eacute;</th>";
				echo "<th>Nbr de num&eacute;ros</th>";
				echo "<th>Actions</th>";
			echo "</TR>";

			//$requete_abo="SELECT * , DATE_FORMAT(date_saisie, '%d-%m-%Y') AS date_saisie2, DATE_FORMAT(date_debut, '%d-%m-%Y') AS date_debut2, DATE_FORMAT(date_fin, '%d-%m-%Y') AS date_fin2 FROM abo_abonnement, abo_categorie, repertoire WHERE repertoire.No_societe=abo_abonnement.No_societe and abo_categorie.idcateg=abo_abonnement.idcateg ;";
			$requete_abo="SELECT * , DATE_FORMAT(date_saisie, '%d-%m-%Y') AS date_saisie2, DATE_FORMAT(date_debut, '%d-%m-%Y') AS date_debut2, DATE_FORMAT(date_fin, '%d-%m-%Y') AS date_fin2 FROM abo_abonnement, repertoire WHERE repertoire.No_societe=abo_abonnement.No_societe ORDER BY Nom_Mag;";
			$result_abo=mysql_query($requete_abo);
			while($ligne_abo=mysql_fetch_assoc($result_abo))
			{
				echo "<TR>";
					echo "<TD align=\"center\">".$ligne_abo['Nom_mag']."</TD>";
					
					//On récupère les catégories
					$requete_cat_abo = "SELECT * FROM abo_categorie_abonnement AS aca, abo_categorie AS ac WHERE aca.idcateg=ac.idcateg AND aca.NoAbo='".$ligne_abo['NoAbo']."'";
					//echo "<br />$requete_cat_abo";
					$res_requete_cat_abo = mysql_query($requete_cat_abo);
					echo "<td>";
						while($ligne_cat_abo=mysql_fetch_assoc($res_requete_cat_abo))
						{
							echo "".$ligne_cat_abo['intitule_categ'].",&nbsp;";
						}
					echo "</td>";
					echo "<TD align=center>".$ligne_abo['societe']."</TD>";
					echo "<TD align=center>".$ligne_abo['date_saisie2']."</TD>";
					echo "<TD align=center>".$ligne_abo['date_debut2']."</TD>";
					echo "<TD align=center>".$ligne_abo['date_fin2']."</TD>";
					echo "<TD align=center>".$ligne_abo['prix']."</TD>";
					echo "<TD align=center>".$ligne_abo['périodicité']."</TD>";
					echo "<TD align=center>".$ligne_abo['NbMagazine']."</TD>";
					echo "<TD align=center><form method='post' action='abo_affichage_magazine_SelonAbo.php'>";
					echo "<input type='hidden' name='id' value=".$ligne_abo['NoAbo']."/>";
					echo "<input type='submit' name='affmag' value='Affichage des Mag.' /></form>";
					$id=$ligne_abo['NoAbo'];
					$requete_abo2="SELECT * , DATE_FORMAT(date_saisie_renouv, '%d-%m-%Y') AS date_saisie_renouv2, DATE_FORMAT(date_renouv, '%d-%m-%Y') AS date_renouv2, DATE_FORMAT(date_fin_renouv, '%d-%m-%Y') AS date_fin_renouv2 FROM abo_abonnement, abo_renouvellement WHERE abo_abonnement.NoAbo=abo_renouvellement.NoAbo and abo_abonnement.NoAbo='$id' ;";
					$result_abo2=mysql_query($requete_abo2);
					$ligne_abo2=mysql_fetch_assoc($result_abo2);
					if($ligne_abo2["idrenouv"]=='')
					{
						echo "Aucun Renouvellement";
					}
					else
					{
						echo "<form method=\"post\" action=\"abo_affichage_renouv_SelonAbo.php\">
						<input type=\"hidden\" name=\"id\" value=\"".$id."\" />
						<input type=\"submit\" name=\"affrenouv\" value=\"Affichage des Renouv.\" /></form>";
					}
					echo "<form method=\"post\" action=\"abo_ajout_renouv.php\">
					<input type=\"hidden\" name=\"id\" value=\"".$id."\" />
					<input type=\"submit\" name=\"ajoutrenouv\" value=\"Ajout de Renouv.\" /></form>";
					echo "<form method=\"post\" action=\"abo_maj_abo.php\">
					<input type=\"hidden\" name=\"id\" value=\"".$id."\" />
					<input type=\"submit\" name=\"modifabo\" value=\"Modification\" /></form>";
					echo "</TD>
				</TR>";
			}
			echo "</table>";
	} //If ($affichage <> "N")
?>

</div>
</BODY>
</HTML>
