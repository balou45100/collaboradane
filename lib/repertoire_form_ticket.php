<?php
    //Ce fichier permet la crÃ©ation d'un nouveau Ticket dans le module "repertoire"
    //Mise en place de la durï¿½e de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML>



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
			<?php

				//Inclusion des fichiers nï¿½cessaires
				include("../biblio/init.php");
        $date_creation=date('j/m/Y');
				$origine = $_GET['origine'];

				echo"
				<FORM ACTION = \"repertoire_verif_ticket.php\" METHOD = \"POST\">
					<TABLE BORDER = \"0\">
						<TR>
							<TD class = \"td-bouton\">
							</TD>
							<TD class = \"td-1\">
								<FONT COLOR = \"red\">Le nom de l'ï¿½metteur et le mail sont configurï¿½s par rapport ï¿½ la personne connectï¿½</FONT>
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"statut\">
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								Emetteur&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<INPUT TYPE = \"hidden\" VALUE = \"".$_SESSION['nom']."\" NAME = \"emetteur\">
								".$_SESSION['nom']."
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								Mï¿½l Emetteur&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<INPUT TYPE = \"hidden\" VALUE =\"".$_SESSION['mail']."\" NAME = \"mail_emetteur\">
								".$_SESSION['mail']."
							</TD>
						</TR>
					  <TR>
							<TD class = \"td-bouton\">Date crï¿½ation&nbsp;:&nbsp;</TD>
							<TD class = \"td-1\"><INPUT TYPE = \"text\" VALUE = \"$date_creation\" NAME = \"date_creation\" SIZE = \"10\">
							</TD>
						</TR>

						<TR>
							<TD class = \"td-bouton\">
								EPLE/Ecole&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">";
								//Requï¿½te pour selectionner tous les ï¿½tablissements
								$query_rep = "SELECT * FROM repertoire";
								$results_rep = mysql_query($query_rep);
								if(!$results_rep)
								{
									echo "<FONT COLOR = \"#808080\"><B>Problï¿½me de connexion ï¿½ la base de donnï¿½es</B></FONT>";
									echo "<A HREF = \"repertoire_gestion.php?origine=$origine&amp;indice=0\" class = \"bouton\">Retour au rï¿½pertoire</A>";
									mysql_close();
									exit;
								}

								//Retourne le nombre de ligne rendu par la requï¿½te
								$num_results_rep = mysql_num_rows($results_rep);

								echo "<SELECT NAME = societe>";
								echo "<OPTION SELECTED = \"null\" VALUE = \"null\"></OPTION>";
								$res_rep = mysql_fetch_row($results_rep);
								for ($j = 0; $j < $num_results_rep; ++$j)
								{
									echo "<OPTION VALUE=".$res_rep[0].">".$res_rep[0]." -- ".str_replace("*", " ",$res_etab[1])." ".str_replace("*", " ",$res_etab[6])"</OPTION>";
									$res_rep = mysql_fetch_row($results_rep);
								}
								echo "</SELECT>";
								echo "
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">Contact&nbsp;:&nbsp;</TD>
              <TD class = \"td-bouton\">Titre&nbsp;:&nbsp;<select size= \"1\" name = \"contact_titre\">
		          <option selected></option>
			        <option value=\"M\">M.</option>
			        <option value=\"MME\">MME</option>
			        </select>
			        &nbsp;Prï¿½nom&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"contact_prenom\" SIZE = \"32\">
							&nbsp;Nom&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"contact_nom\" SIZE = \"32\">
              <BR>&nbsp;Mï¿½l&nbsp;:&nbsp;<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"contact_mail\" SIZE = \"50\">
              &nbsp;Fonction&nbsp;:&nbsp;<select size= \"1\" name = \"contact_fonction\">
		          <option selected></option>
			        <option value=\"IA-IPR\">IA-IPR</option>
			        <option value=\"IEN-ET\">IEN-ET</option>
			        <option value=\"IEN\">IEN</option>
			        <option value=\"IA-DSDEN\">IA-DSDEN</option>
			        <option value=\"directeur/directrice\">directeur/directrice</option>
			        <option value=\"proviseur-e\">proviseur-e</option>
			        <option value=\"principal-e\">principal-e</option>
			        <option value=\"enseignant-e\">enseignant-e</option>
			        <option value=\"autre\">autre</option>
			        </select>
							</TD>

						</TR>
						<TR>

						<TR>
							<TD class = \"td-bouton\">
								Sujet&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"sujet\" SIZE = \"64\">
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								Type&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<SELECT NAME = \"contact_type\">
									<OPTION SELECTED = \"message ï¿½lectronique\" VALUE = \"message ï¿½lectronique\">message ï¿½lectronique</OPTION>
									<OPTION = \"appel tï¿½lï¿½phonique\" VALUE = \"appel tï¿½lï¿½phonique\">appel tï¿½lï¿½phonique</OPTION>
									<OPTION = \"courrier\" VALUE = \"courrier\">courrier</OPTION>
									<OPTION = \"rencontre\" VALUE = \"rencontre\">rencontre</OPTION>
								</SELECT>
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								Prioritï¿½&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<SELECT NAME = \"priorite\">
									<OPTION SELECTED = \"2\" VALUE = \"2\">Normal</OPTION>
									<OPTION = \"1\" VALUE = \"1\">Haute</OPTION>
									<OPTION = \"3\" VALUE = \"3\">Basse</OPTION>
								</SELECT>
							</TD>
						</TR>
            <TR>
							<TD class = \"td-bouton\">
								Intervenants&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-bouton\">
								<INPUT TYPE = \"text\" VALUE =\"\" NAME = \"intervenant\" SIZE = \"60\">&nbsp;(sï¿½parï¿½s par des ; aucun caractï¿½res accentuï¿½s, ni d'espace)
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
								Contenu&nbsp;:&nbsp;
							</TD>
							<TD class = \"td-1\">
								<TEXTAREA ROWS = \"15\" COLS = \"120\" NAME = \"contenu\"></TEXTAREA>
							</TD>
						</TR>
						<TR>
							<TD class = \"td-bouton\">
							</TD>
							<TD class = \"td-1\">
							  <INPUT TYPE = \"submit\" VALUE = \"Enregistrer le ticket\">
							  <INPUT TYPE = \"hidden\" VALUE = \"gest_ticket\" NAME = \"origine\">
							</TD>
						</TR>
					</TABLE>
				</FORM>";

				//Fermeture de la connexion ï¿½ la BDD
				mysql_close();
			?>
		</CENTER>
	</BODY>
</HTML>
