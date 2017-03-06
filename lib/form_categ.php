<?php
//Mise en place de la durée de la session
	ini_set('session.gc_maxlifetime', 28800); //8 heures : 8*60*60
	//Lancement de la session
	session_start();
		
	//Variable définissant l'identifiant de la catégorie père
	@$id_categ = $_GET['id_categ'];
	
	//Par defaut si la valeur n'est pas renseigné, on assujettit par defaut le chiffre -1
	//Qui correspond à la racine des catégories
	if(!isset($id_categ) || $id_categ == "")
	{
		$id_categ = "-1";
	}
	header('Content-Type: text/html;charset=UTF-8');

?>

<!DOCTYPE HTML>

<!"Ce fichier permet d'ajouter une catégorie">

<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<?php
			include("../biblio/ticket.css");
			include ("../biblio/config.php");
			if(!isset($_SESSION['nom']))
			{
				echo "<BR><BR><BR><BR><CENTER><FONT COLOR = \"#808080\"><B>".MESSAGE_NON_CONNECTE1."</B></FONT></CENTER>";
				echo "<BR><BR><CENTER><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">".MESSAGE_NON_CONNECTE2."</A></CENTER>";
				exit;
			}
		?>
	</head>
	<body>
		<CENTER>
			<FORM ACTION = "verif_categ.php" METHOD = "POST">
				<TABLE BORDER = "0">
					<TR>
						<TD class = "td-bouton">
							Nom de la catégorie
						</TD>
						<TD class = "td-1">
							<INPUT TYPE = "text" NAME = "nom" VALUE = "" SIZE = "40">
							<INPUT TYPE = "hidden" NAME = "stat" VALUE = "I">
							<?php
								echo "<INPUT TYPE = \"hidden\" NAME = \"id_categ_pere\" VALUE = \"".$id_categ."\">";
							?>
						</TD>
					</TR>
					<TR>
						<TD class = "td-bouton">
							Info complémentaire
						</TD>
						<TD class = "td-1">
							<TEXTAREA ROWS = "10" COLS = "90" NAME = "contenu"></TEXTAREA>
						</TD>
					</TR>
					<TR>
						<TD class = "td-1">
							<INPUT TYPE = "submit" VALUE = "Ok">
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</CENTER>
	</BODY>
</HTML>
