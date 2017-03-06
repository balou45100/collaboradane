<?php
	//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
  
<!"Ce fichier a pour but de modifier les données concernant un établissement"
"Les données sont ensuite envoyé au fichier verif_etab.php">

<html>
	<head>
  		<title>CollaboraDANE</title>
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
			<FORM ACTION = "verif_etab.php" METHOD = "POST">
				<TABLE BORDER="0">
					<TR>
						<TD class = "td-bouton">
							N° RNE
						</TD>
						<TD class = "td-bouton">
							Type &nbsp;&nbsp;
						</TD>
						<TD class = "td-bouton">
							Public/Privé &nbsp;&nbsp;
						</TD>
						<TD class = "td-bouton">
							Dénomination &nbsp;&nbsp;
						</TD>
						<TD class = "td-bouton">
							Adresse &nbsp;&nbsp;
						</TD>
						<TD class = "td-bouton">
							Code Postal &nbsp;&nbsp;
						</TD>
						<TD class = "td-bouton">
							Ville &nbsp;&nbsp;
						</TD>
					</TR>
					
					<?php
												
						//Inclusion des fichiers nécessaires
						include ("../biblio/init.php");
						//Récupération des données de l'établissement à modifier
						//La modification d'un établissement se fait avec son nunméro RNE
						$rne = strtoupper($_GET['rne']);
						$query = "SELECT * FROM etablissements where RNE = '".$rne."';";
						$results = mysql_query($query);
						
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<FONT COLOR = \"#808080\"><B>problème de connexion à la base de données</B></FONT>";
							echo "<A HREF=\"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
							mysql_close();
							exit;
						}
						else
						{
							//Récupération des données concernant l'établissement
							$res = mysql_fetch_row($results);
							
							///////////////
							//Récupération des données en rapport avec la formule de politesse et l'établissement
							$query_politesse = "SELECT * FROM politesse where Id_politesse = '".$res[10]."';";
							$results_pol_select = mysql_query($query_politesse);
							if(!$results_pol_select)
							{
								echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
								echo "<A HREF=\"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
								mysql_close();
								exit;
							}
							$num_results_pol_select = mysql_num_rows($results_pol_select);
							$res_pol = mysql_fetch_row($results_pol_select);
							//fin récupération de la politesse selectionnée
				
							//Récupération des formules de politesse non selectionnées
							$query_non_pol_select = "SELECT * FROM politesse where Id_politesse != '".$res[10]."';";
							$results_non_pol_select = mysql_query($query_non_pol_select);
							if(!$results_non_pol_select)
							{
								echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
								echo "<A HREF=\"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
								mysql_close();
								exit;
							}
							$num_results_pol_non_select = mysql_num_rows($results_non_pol_select);
							$res_non_pol_select = mysql_fetch_row($results_non_pol_select);
							//fin de recup de toutes les politesses non selectionnées
							
							if($res[2] == "PUBLIC")
							{
								$selected = "PUBLIC";
								$other = "PRIVE";
							}
							else
							{
								$selected = "PRIVE";
								$other = "PUBLIC";
							}
							echo "<TR>
									<TD class = \"td-1\">
										<INPUT TYPE = \"hidden\" VALUE = ".$res[0]." NAME = \"rne\" SIZE = \"8\">
										".$res[0]."
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".strtoupper(str_replace("*", " ",$res[1]))."\" NAME = \"type\" SIZE = \"10\">
									</TD>
									<TD class = \"td-1\">
										<SELECT NAME = \"public_prive\">
											<OPTION SELECTED = ".$selected.">".$selected."</OPTION>
											<OPTION VALUE = ".$other.">".$other."</OPTION>
										</SELECT>
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[3])."\" NAME = \"denomination\">
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[4])."\" NAME = \"adresse\">
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[6])."\" NAME = \"CP\" SIZE = \"5\">
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[5])."\" NAME = \"ville\">
									</TD>
								</TR>
								<TR>
									<TD class = \"td-bouton\">
										Numéro de téléphone &nbsp;&nbsp;
									</TD>
									<TD class = \"td-bouton\">
										Formule de politesse
									</TD>
									<TD class = \"td-bouton\">
										E-Mail &nbsp;&nbsp;
									</TD>
									<TD class = \"td-bouton\">
										Circonscription &nbsp;&nbsp;
									</TD>
								</TR>
								<TR>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[7])."\" NAME = \"num_tel\" SIZE = \"12\">
									</TD>
									<TD class = \"td-1\">
										<SELECT NAME = \"politesse\">";
										for($i = 0; $i < $num_results_pol_non_select; ++$i)
										{
											echo "<OPTION VALUE = \"".$res_non_pol_select[0]."\">".$res_non_pol_select[1]."</OPTION>";
											$res_non_pol_select = mysql_fetch_row($results_non_pol_select);
										}
										echo "<OPTION SELECTED = \"".$res_pol[0]."\" VALUE = \"".$res_pol[0]."\">".$res_pol[1]."</OPTION>";
										//$politesse = $res_pol[0];
										echo "</SELECT>
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".$res[8]."\" NAME = \"mail\" SIZE = \"30\">
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"text\" VALUE = \"".str_replace("*", " ",$res[9])."\" NAME = \"circonscription\">
									</TD>
									<TD class = \"td-1\">
										<INPUT TYPE = \"hidden\" VALUE = \"modification\" NAME = \"op\">
									</TD>
								</TR>";
						}
						//Fermeture de la connexion à la BDD
						mysql_close();
					?>
				</TABLE>
				<BR> <BR>
				<INPUT TYPE = "submit" VALUE = "Ok">
			</FORM>
		</CENTER>
	</body>
</html>
