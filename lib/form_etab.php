<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>
  
<!"Formulaire pour l'inscription d'un nouvel établissement">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><b>$message_non_connecte1</b></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
			<font color = "red">Les champs suivis d'une * sont obligatoires!!</font>
			<BR><BR>
			<FORM ACTION = "verif_etab.php" METHOD = "POST">
				<TABLE BORDER="0">
					<TR>
						<TD class = "td-bouton">
							N° RNE
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "rne">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Type
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "type">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Public/Privé
						</TD>
						<TD class = "td-1">
							<SELECT NAME = "public_prive">
								<OPTION VALUE = "public">public</OPTION>
								<OPTION VALUE = "prive">privé</OPTION>
							</SELECT>*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Dénomination
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "denomination">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Adresse
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "adresse">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Code postal
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "CP">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Ville
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "ville">*
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							N° de téléphone
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "num_tel">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Email
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "mail">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Circonscription
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" VALUE = "" NAME = "circonscription">
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Formule de politesse
						</TD>
						<TD class = "td-1">
							<?php
								//traitement des différentes formules de politesse
								include("../biblio/init.php");
								
								//Requète pour selectionner toutes les formules de politesses
								$query_politesse = "SELECT * FROM politesse";
								$results_politesse = mysql_query($query_politesse);
								if(!$results_politesse)
								{
									echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
									echo "<A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
									mysql_close();
									exit;
								}
								
								//Retourne le nombre de ligne rendu par la requète
								$num_results_politesse = mysql_num_rows($results_politesse);
								
								//Affichage de toutes les formules de politesses
								echo "<SELECT NAME = politesse>";
								$res_politesse = mysql_fetch_row($results_politesse);
								for ($j = 0; $j < $num_results_politesse; ++$j)
								{
									echo "<OPTION VALUE=".$res_politesse[0].">".$res_politesse[1]."</OPTION>";
									$res_politesse = mysql_fetch_row($results_politesse);
								}
								echo "</SELECT>";
								
								//Fermeture de la connexion à la BDD
								mysql_close();
							?>
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							<INPUT TYPE = "hidden" VALUE = "inscription" NAME = "op">
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "submit" VALUE = "Ok">
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</CENTER>
	</body>
</html>
