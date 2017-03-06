<?php
	//Lancement de la session pour verifier si l'on est logué
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE html>

<!"Ce fichier permet de rentrer dans le module de gestion des personnes ressources TICE">
<?php
	//include("../biblio/ticket.css");
	include("../biblio/config.php");
	include ("../biblio/fct.php");
	if(!isset($_SESSION['nom']))
	{
		echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
		echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
		exit;
	}
	else
	{
		enreg_utilisation_module("CRE");
	}
	echo "<html>";
		echo "<head>";
			echo "<title>$nom_espace_collaboratif</title>";
		echo "</head>
		<frameset rows=\"60,*,65\">
			<frame name=\"head\" src=\"credits_entete.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
			<frame name=\"body\" src=\"credits_gestion.php?annee=$annee_budgetaire\" FRAMEBORDER=\"0\">
			<frame name=\"cadre_modules\" src=\"modules.php\" FRAMEBORDER=\"0\" scrolling=\"no\">
		</frameset>
	</html>";
// Au cas ou la variable de session lié au tableau de bord est toujours active, on l'efface pour que le lien de "retour" soit correct...
unset($_SESSION['origine']);
unset($_SESSION['origine1']);
?>
