<?php
	//Lancement de la session
	session_start();
	header('Content-Type: text/html;charset=UTF-8');
?>

<!DOCTYPE HTML">
<?php
	include ("../biblio/config.php");
	include ("../biblio/init.php");

	echo "<html>";
	echo "<head>";
  		echo "<title>$nom_espace_collaboratif</title>";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	if(!isset($_SESSION['id_util']))
		{
			echo "<BR><BR><BR><BR><CENTER><B>$message_non_connecte1</B></CENTER>";
			exit;
		}
?>
	</head>
	<body>
		<CENTER>
<?php
	//echo "<h2>Les filtres ne sont pas encore disponible</h2>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// appel à dev_taches_gestion.php //////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<FORM ACTION = \"dev_taches_gestion.php\" target = \"body\" method = \"get\">";
		echo "<table class =\"menu-boutons\">";
			echo "<tr>";
				echo "<td>";
					//Choix des filtres
					//$requete_categorie="SELECT DISTINCT id_categ,intitule_categ FROM categorie_commune, taches_categories WHERE taches_categories.id_categorie = categorie_commune.id_categ ORDER BY intitule_categ";
					$requete_modules="SELECT DISTINCT dev_taches_modules.id_module,intitule_module FROM modules_collaboratice, dev_taches_modules, dev_taches_util WHERE dev_taches_modules.id_tache = dev_taches_util.id_tache AND dev_taches_modules.id_module = modules_collaboratice.id_module AND dev_taches_util.id_util = '".$_SESSION['id_util']."' ORDER BY intitule_module";
					$result=mysql_query($requete_modules);
					$num_rows = mysql_num_rows($result);
					echo "Module&nbsp;:&nbsp;<select size=\"1\" name=\"module_filtre\">";
					if (mysql_num_rows($result))
					{
						echo "<OPTGROUP LABEL=\"-----------------------\">";
							echo "<option selected value=\"%\">tous</option>";
							echo "<option value=\"S\">sans</option>";
				    	echo "</OPTGROUP>";
						echo "<OPTGROUP LABEL=\"-----------------------\">";
			    		echo "</OPTGROUP>";
						echo "<OPTGROUP LABEL=\"modules\">";
						while ($ligne=mysql_fetch_object($result))
						{
							$intitule_module=$ligne->intitule_module;
							$id_module=$ligne->id_module;
							echo "<option value=\"$id_module\">$intitule_module</option>";
						}
				    	echo "</OPTGROUP>";
					}
					else
					{
						echo "<option selected value=\"\">aucune t&acirc;che enregistr&eacute;e</option>";
					}
					echo "</SELECT>"; 
				echo "</td>";
				echo "<td>";
					echo "&nbsp;&eacute;tat&nbsp;:&nbsp;"; 
						echo "<select size=\"1\" name=\"etat_filtre\">";
							echo "<option selected value=\"0\">non achev&eacute;</option>";
							echo "<option value=\"1\">nouveau</option>";
							echo "<option value=\"2\">en cours</option>";
							echo "<option value=\"3\">achev&eacute;</option>";
							echo "<option value=\"%\">tout</option>";
						echo "</SELECT>";
				echo "</td>";
				echo "<td>";
					echo "&nbsp;visibilit&eacute;&nbsp;:&nbsp;"; 
						echo "<select size=\"1\" name=\"visibilite_filtre\">";
							echo "<option selected value=\"PU\">public</option>";
							echo "<option value=\"PR\">privé</option>";
							echo "<option value=\"%\">tout</option>";
						echo "</SELECT>";

					echo "&nbsp;&nbsp;D&eacute;tail&nbsp;:&nbsp; 
					<INPUT TYPE = \"text\" VALUE = \"\" NAME = \"rechercher\" SIZE = \"20\">";

						echo "&nbsp;<INPUT TYPE = \"submit\" VALUE = \"hop !\">
							<INPUT TYPE = \"hidden\" VALUE = \"0\" NAME = \"indice\">
							<INPUT TYPE = \"hidden\" VALUE = \"entete\" NAME = \"origine_appel\">
							<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"controle_entete\">
							<INPUT TYPE = \"hidden\" VALUE = \"N\" NAME = \"affiche_barrees\">
							<INPUT TYPE = \"hidden\" VALUE = \"ASC\" NAME = \"sense_tri\">
							<INPUT TYPE = \"hidden\" VALUE = \"DATECR\" NAME = \"tri\">";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</FORM>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Fin appel à dev_taches_gestion.php //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
		</CENTER>
	</body>
</html>

