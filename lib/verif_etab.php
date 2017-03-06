<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>


<!DOCTYPE HTML>

<!"Pour la verification des données concernant"
"un établissement afin de procéder à sa mise à jour ou à son inscription"
"Les données qui afflux vers se fichier proviennent de form_etab.php pour l'inscription &"
"de modif_etab.php pour la modification ">

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
			<?php
				//Connexion à la base de données
				include ("../biblio/init.php");
				
				//Récupération des données depuis form_util.php ou modif_util.php
				$rne = strtoupper($_POST['rne']);
				$type = strtoupper($_POST['type']);
				$public_prive = strtoupper($_POST['public_prive']);
				$denomination = strtoupper($_POST['denomination']);
				$adresse = strtoupper($_POST['adresse']);
				$CP = $_POST['CP'];
				$ville = strtoupper($_POST['ville']);
				$num_tel = $_POST['num_tel'];
				$mail = $_POST['mail'];
				$circonscription = $_POST['circonscription'];
				$op = $_POST['op'];
				$politesse = $_POST['politesse'];
				
				//Récupération des données en rapport avec la formule de politesse et l'établissement
				$query_politesse = "SELECT * FROM politesse where Id_politesse = '".$politesse."';";
				$results_pol_select = mysql_query($query_politesse);
				if(!$results_pol_select)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
					mysql_close();
					exit;
				}
				$num_results_pol_select = mysql_num_rows($results_pol_select);
				$res_pol = mysql_fetch_row($results_pol_select);
				//fin récupération de la politesse selectionnée
				
				//Récupération des formules de politesse non selectionnées
				$query_non_pol_select = "SELECT * FROM politesse where Id_politesse != '".$politesse."';";
				$results_non_pol_select = mysql_query($query_non_pol_select);
				if(!$results_non_pol_select)
				{
					echo "<FONT COLOR = \"#808080\"><B>Problème de connexion à la base de données</B></FONT>";
					echo "<BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
					mysql_close();
					exit;
				}
				$num_results_pol_non_select = mysql_num_rows($results_non_pol_select);
				$res_non_pol_select = mysql_fetch_row($results_non_pol_select);
				//fin de recup de toutes les politesses non selectionnées
				
				//Test sur les valeurs dans le cas où un champs (n'importe lequel) n'existe pas ou
				//n'est pas renseigné
				if (!isset($rne) || !isset($type) || !isset($public_prive) || !isset($denomination)
				|| !isset($adresse)	|| !isset($CP) || !isset($ville)
				|| !isset($num_tel) || !isset($mail) || $rne == "" || $type == ""
				|| $public_prive == "" || $denomination == "" || $adresse == "" || $CP == "" || $ville == "")
				{
					if($public_prive == "PUBLIC")
					{
						$selected = "PUBLIC";
						$other = "PRIVE";
					}
					else
					{
						$selected = "PRIVE";
						$other = "PUBLIC";
					}
					echo "Veillez remplir les champs manquants!
					<BR><BR>
					<FORM ACTION = \"verif_etab.php\" METHOD = \"POST\">
						<TABLE BORDER = \"0\">
							<TR>
						<TD class = \"td-bouton\">
							N° RNE
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$rne."\" NAME = \"rne\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Type
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$type."\" NAME = \"type\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Public/Privé
						</TD>
						<TD class = \"td-1\">
							<SELECT NAME = \"public_prive\">
								<OPTION SELECTED = ".$selected.">".$selected."</OPTION>
								<OPTION VALUE = ".$other.">".$other."</OPTION>
							</SELECT>*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Dénomination
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$denomination."\" NAME = \"denomination\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Adresse
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$adresse."\" NAME = \"adresse\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Code postal
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$CP."\" NAME = \"CP\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Ville
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$ville."\" NAME = \"ville\">*
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							N° de téléphone
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$num_tel."\" NAME = \"num_tel\">
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Email
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$mail."\" NAME = \"mail\">
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Circonscription
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"text\" VALUE = \"".$circonscription."\" NAME = \"circonscription\">
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							Formule de politesse
						</TD>
						<TD class = \"td-1\">
							<SELECT NAME = \"politesse\">";
							for($i = 0; $i < $num_results_pol_non_select; ++$i)
							{
								echo "<OPTION VALUE = \"".$res_non_pol_select[0]."\">".$res_non_pol_select[1]."</OPTION>";
								$res_non_pol_select = mysql_fetch_row($results_non_pol_select);
							}
							echo "<OPTION SELECTED = \"".$res_pol[0]."\" VALUE = \"".$res_pol[0]."\">".$res_pol[1]."</OPTION>";
							echo "</SELECT>
						</TD>
					</TR>
					<TR>
						<TD class = \"td-bouton\">
							<INPUT TYPE = \"hidden\" VALUE = \"".$op."\" NAME = \"op\">
						</TD>
						<TD class = \"td-1\">
							<INPUT TYPE = \"submit\" VALUE = \"Ok\">
						</TD>
					</TR>
						</TABLE>
						</FORM>";
				}
					//Tous les champs ont été renseignés correctement
				else
				{	
					//Dans le cas d'une inscription
					//On se retrouve devant une requète insert
					if($op == "inscription")
					{	
						$query = "SELECT * FROM etablissements where rne = '".$rne."';";
						$results = mysql_query($query);
						$num = mysql_num_rows($results);
						if($num >= 1)
						{	
							echo "<FONT COLOR = \"#808080\"><B>Etablissement déjà existant, cherchez un peu avant d'insérer un établissement</B></FONT>";
							echo "<BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
							mysql_close();
							exit;
						}
						
						$query = "INSERT INTO etablissements VALUES ('".$rne."',
						'".str_replace(" ", "*",$type)."', '".$public_prive."',
						'".str_replace(" ", "*",$denomination)."',
						'".str_replace(" ", "*",$adresse)."', '".str_replace(" ", "*",$ville)."',
						'".$CP."', '".$num_tel."',
						'".$mail."',
						'".str_replace(" ", "*",$circonscription)."',
						'".$politesse."');";
											
						$results = mysql_query($query);
						
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
							mysql_close();
							exit;
						}
						else
						{
							echo "<FONT COLOR = \"#808080\"><B>Un nouvel établissement a été inséré : ".$denomination."</B></FONT>";
							echo "<BR><BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
						}
					}
					//Dans le cas d'une modification
					//On se retrouve devant une requéte update
					if($op == "modification")
					{
						$query = "UPDATE etablissements SET TYPE = '".str_replace(" ", "*",$type)."',
						PUBPRI = '".$public_prive."', NOM = '".str_replace(" ", "*",$denomination)."',
						ADRESSE = '".str_replace(" ", "*",$adresse)."', VILLE = '".str_replace(" ", "*",$ville)."',
						CODE_POSTAL = '".$CP."', MAIL = '".$mail."',
						CIRCONSCRIPTION = '".str_replace(" ", "*",$circonscription)."',
						CODE_POLITESSE = '".$res_pol[0]."'
						WHERE RNE = '".$rne."';";
						$results = mysql_query($query);
						
						//Dans le cas où aucun résultats n'est retourné
						if(!$results)
						{
							echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
							echo "<BR><BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
							mysql_close();
							exit;
						}
						else
						{
							echo "<FONT COLOR = \"#808080\"><B>Les données de l'établissement ".$denomination." ont bien été modifiées</B></FONT>";
							echo "<BR><BR> <A HREF = \"gestion_etab.php?tri=T&amp;indice=0\" class = \"bouton\">Retour à la gestion des établissements</A>";
						}
					}
				}
				//Fermeture de la connexion à la BDD
				mysql_close();
			?>
		</CENTER>
	</body>
</html>
