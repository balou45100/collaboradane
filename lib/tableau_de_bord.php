<?php
	session_start();
	$nom=$_SESSION['nom'];
	$id=$_SESSION['id_util'];
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>

<!"Ce fichier permet de rentrer dans le module de gestion des écoles et EPLE">
<?php
	 include("../biblio/ticket.css");
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
</head>
<!"Pour protéger les couleur des liens des boutons"
	"Choix de la couleur blanche, car sinon il apparait un carré de couleur moche autour des images"
	"Correspondant à la suppression et à la modification">
	<CENTER>
		<?php

echo "<TABLE align=\"center\" width = \"95%\" height=\"10%\" BORDER = \"0\" BGCOLOR =\"#FFFF99\">
			<TR>
				<TD align = \"center\">
              		<h2>\"CollaboraTICE\"<br>Espace collaboratif de la Mission académique TICE</h2>
            	</TD>
            	<TD align = \"center\">
              		<img border=\"0\" src = \"$chemin_theme_images/logo_tice.png\" ALT = \"Logo\">
            	</TD>
          	</TR>
        </TABLE>";
		
		$requete_verif_pref ="SELECT * FROM preference WHERE id_util = '".$_SESSION['id_util']."'";
		$resultat_verif_pref = mysql_query($requete_verif_pref);
		$verif = mysql_num_rows($resultat_verif_pref);
		if ($verif == 0)
		{
			echo "<h2>Pour utiliser le tableau de bord, vous devez renseigner les préférences en cliquant <a target=\"_top\" href = cadre_preferences.php>ICI</a></h2>";	
		}
		else
		{
			//$util = "admin";
			$autorisation_gestion_materiels = verif_appartenance_groupe(8);
			//echo "<br :>autorisation_gestion_materiels : $autorisation_gestion_materiels";
			echo"<br>";
			echo"<iFRAME SRC=tb_tickets.php width=48% height=40% name=HautGauche MARGINWIDTH=10 MARGINHEIGHT=20>
			</iframe>";
			echo "&nbsp &nbsp";
			echo"<iframe src=tb_alertes.php?vue=tb width=48% height=40% name=HautGauche MARGINWIDTH=10 MARGINHEIGHT=20>
			</iframe>";
			echo"<br><br>";
			echo"<iFRAME SRC=tb_taches.php?vue=tb width=48% height=20% name=HautDroite MARGINWIDTH=10 MARGINHEIGHT=20>
			</iframe>";
			echo "&nbsp &nbsp";
			/*
			echo"<iFRAME SRC=tb_pers_form.php width=48% height=20% name=BasGauche MARGINWIDTH=10 MARGINHEIGHT=20>
			</iframe>";
			echo"<br><br>";
			*/
			if ($autorisation_gestion_materiels == 1)
			//if ($util == "admin")
			{
				echo"<iFRAME SRC=tb_prets.php width=48% height=20% name=BasCentre MARGINWIDTH=10 MARGINHEIGHT=20>
				</iframe>";
				echo"<br><br>";
				echo"<iFRAME SRC=tb_garanties.php?vue=tb width=48% height=20% name=BasDroite MARGINWIDTH=10 MARGINHEIGHT=20>
				</iframe>";
				echo "&nbsp &nbsp";
				echo"<iFRAME SRC=tb_pers_form.php width=48% height=20% name=BasGauche MARGINWIDTH=10 MARGINHEIGHT=20>
				</iframe>";
				//echo"<br><br>";

			}
			else
			{
				echo"<iFRAME SRC=tb_pers_form.php width=48% height=20% name=BasGauche MARGINWIDTH=10 MARGINHEIGHT=20>
				</iframe>";
			}
		}
?>
</center>
</html> 


