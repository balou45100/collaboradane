<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>".MESSAGE_NON_CONNECTE1."</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"../ckeditor/ckeditor.js\"></script>";
	echo "</head>
	<body>
		<div align = \"center\">";
			//Inclusion des fichiers nécessaires						
			include ("../biblio/init.php");
			include ("../biblio/config.php");
						$fd_cel_etiq="#7FFFD4";
			      $fd_cel_donnee="#FFFFFF";
			      $fd_tab="#48D1CC";
						//Récupération des données de l'util à modifier
						//La modification d'un utilisateur se fait avec son nom et son mail
						$nom = strtoupper($_GET['nom']);
						$mail = $_GET['mail'];
						$query = "SELECT * FROM util where nom = '".$nom."' AND mail = '".$mail."';";
						$results = mysql_query($query);
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<B>Problème de connexion à la base de données</B>";
							echo "<A HREF=\"gestion_user.php?indice=0\" class = \"bouton\">Retour à la gestion des utilisateurs</A>";
							mysql_close();
							exit;
						}
						else
						{	
							//Récupération des données concernant l'utilisateur
							$res = mysql_fetch_row($results);
							
              $password_origine = $res[2];
							
							//echo "<br>password_origine : $password_origine";
              
              echo "<FORM ACTION = \"verif_util.php\" METHOD = \"POST\">
			          <TABLE>
			           
                 <TR>
                   
			 	           <TD class = \"etiquette\">Pr&eacute;nom&nbsp;:&nbsp;</TD>
			 	           <TD><INPUT TYPE=\"hidden\" VALUE =".str_replace("*", " ",$res[0])." NAME = \"prenom\">".str_replace("*", " ",$res[0])."</TD>
									 
								 </TR>
								 <TR>
								   
									 <TD class = \"etiquette\">Nom&nbsp;:&nbsp;</TD>
									 <TD bgcolor = $fd_cel_donnee><INPUT TYPE=\"hidden\" VALUE =".strtoupper($res[1])." NAME = \"nom\" SIZE=\"40\">".strtoupper($res[1])."</TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">M&eacute;l&nbsp;:&nbsp;</TD>
                   <TD bgcolor = $fd_cel_donnee><INPUT TYPE=\"hidden\" VALUE =".$res[3]." NAME = \"mail\" SIZE=\"40\">".$res[3]."</TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">T&eacute;l&eacute;phone professionnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =".$res[4]." NAME = \"num_tel\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Poste t&eacute;l&eacute;phonique&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[9]."\" NAME = \"poste_tel\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mobile professionnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[5]."\" NAME = \"num_tel_port\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">T&eacute;l&eacute;phone personnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[10]."\" NAME = \"num_tel_perso\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Autre t&eacute;l&eacute;phone&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[14]."\" NAME = \"tel_autre\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mobile personnel&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"text\" VALUE =\"".$res[11]."\" NAME = \"num_tel_port_perso\" SIZE=\"34\"></TD>
									 
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Mot de passe&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"password\" VALUE =".$res[2]." NAME = \"password1\" SIZE=\"34\"></TD>
								   
								 </TR>
								 <TR>
								   
                   <TD class = \"etiquette\">Pour v&eacute;rification du Mot de passe&nbsp;:&nbsp;</TD>
                   <TD><INPUT TYPE=\"password\" VALUE =".$res[2]." NAME = \"password2\" SIZE=\"34\"></TD>
								   
                </TABLE>
                <BR>
                <INPUT TYPE=\"hidden\" VALUE =\"modification_perso\" NAME = \"type\">
                <INPUT TYPE=\"hidden\" VALUE =\"$password_origine\" NAME = \"password_origine\">
                <INPUT TYPE=\"hidden\" VALUE =\"$origine\" NAME = \"origine\">
				        <INPUT TYPE = \"submit\" VALUE = \"Valider les modifications\">
			        </FORM>";
             
						}
						//Fermeture de la connexion à la BDD
						mysql_close();
					?>
				
		</CENTER>
	</body>
</html>
