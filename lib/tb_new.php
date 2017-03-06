<?php
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	//echo "<br />theme : $theme";

?>

<!DOCTYPE HTML>
  
<!"Ce fichier permet de rentrer dans le module de gestion des &eacute;coles et EPLE">
<?php
	//include("../biblio/ticket.css");
	include("../biblio/fct.php");
	include("../biblio/config.php");
	include("../biblio/init.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}

echo "<html>
<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
</head>
	<body>
	<div id = \"entete-collaboratice\" align = \"center\">
		<h2>CollaboraTICE<br />Espace collaboratif de la Mission acad&eacute;mique TICE&nbsp;</h2>
		<img class = \"logo\" src = \"$chemin_theme_images/logo_tice.png\" ALT = \"Logo\">
	</div>
	<div id = \"body_tb\">";
	
	$requete_verif_pref ="SELECT * FROM preference WHERE id_util = '".$_SESSION['id_util']."'";
	$resultat_verif_pref = mysql_query($requete_verif_pref);
	$verif = mysql_num_rows($resultat_verif_pref);
	if ($verif == 0)
	{
		echo "<h2>Pour utiliser le tableau de bord, vous devez renseigner les pr&eacute;f&eacute;rences en cliquant <a target=\"_top\" href = tb_cadre_preferences.php>ICI</a></h2>";	
	}
	else
	{
		//$autorisation_gestion_materiels = $_SESSION['autorisation_gestion_materiels'];
		$autorisation_gestion_materiels = verif_appartenance_groupe(8); 
		//echo "<br :>autorisation_gestion_materiels : $autorisation_gestion_materiels";
		echo"<br />";
		echo"<iFRAME SRC=tb_tickets.php?vue=tb width=\"48%\" height=\"40%\" name=HautGauche MARGINWIDTH=\"10\" MARGINHEIGHT=\"20\"></iframe>";
		echo "&nbsp";
		//echo"<br />";
		echo"<iframe src=tb_alertes.php?vue=tb width=\"48%\" height=\"40%\" name=HautGauche MARGINWIDTH=\"10\" MARGINHEIGHT=\"20\"></iframe>";
		//echo "&nbsp";
		echo"<br />";
		echo"<iFRAME SRC=tb_taches.php?vue=tb width=\"48%\" height=\"40%\" name=HautDroite MARGINWIDTH=\"10\" MARGINHEIGHT=\"20\"></iframe>";
		echo "&nbsp";
		//echo"<br />";
		
		//echo "<br />tb.php - autorisation_gestion_materiels : $autorisation_gestion_materiels";
		
		//if ($autorisation_gestion_materiels == "O")
		if ($autorisation_gestion_materiels == 1)
		{
			echo"<iFRAME SRC=tb_prets.php?vue=tb width=\"48%\" height=\"40%\" name=BasCentre MARGINWIDTH=\"10\" MARGINHEIGHT=\"20\"></iframe>";
			echo"<br />";
			//echo "&nbsp";
			echo"<iFRAME SRC=tb_garanties.php?vue=tb width=\"48%\" height=\"30%\" name=BasDroite MARGINWIDTH=\"10\" MARGINHEIGHT=\"20\"></iframe>";
			//echo "&nbsp";
			echo"<br />";
			//echo"<iFRAME SRC=tb_pers_form.php?vue=tb width=48% height=20% name=BasGauche MARGINWIDTH=10 MARGINHEIGHT=20></iframe>";
			//echo"<br />";
		}
		else
		{
			//echo"<iFRAME SRC=tb_pers_form.php?vue=tb width=48% height=20% name=BasGauche MARGINWIDTH=10 MARGINHEIGHT=20></iframe>";
		}
	}
?>
</div>
</body>
</html> 


