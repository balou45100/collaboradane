<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	$id_util = $_SESSION['id_util'];
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	//echo "<br />chemin_images_theme : $chemin_images_theme";

	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body>
		<div align =\"center\">";
		$largeur_tableau = "80%";
			include ("../biblio/config.php");
			include ("../biblio/init.php");
			include ("../biblio/fct.php");
			echo "<h2>Pr&eacute;f&eacute;rence pour la page sommaire - <A HREF=\"reglages.php\" class = \"bouton\">Informations personnelles</A></h2>";
		//Insérer ici le code
		// On teste s'il s'agit d'une mise à jour ou d'une insertion
		$util="SELECT * FROM preference WHERE ID_UTIL = $id;";
		$execution= mysql_query($util);
		$num_results = mysql_num_rows($execution);
		if($num_results == "1")
		{
		while($donnees=mysql_fetch_array($execution))
		{
		// Affectation des données récupérées dans des variables
		// Pour les tickets
		if ($donnees['tri_tick']== "1")
		{
		$tri_tick="Priorité";
		}
		else
		{
		if ($donnees['tri_tick'] == "2")
		{
		$tri_tick="Date dernière réponse";
		}
		else
		{
		$tri_tick="Date de création";
		}
		}
		// Statut du ticket
		if ($donnees['statut']== "Tous")
		{
		$statut="Tous";
		}
		else
		{
		if ($donnees['statut'] == "N")
		{
		$statut="Nouveau";
		}
		else
		{
		if ($donnees['statut'] == "T")
		{
		$statut="Transféré";
		}
		else
		{
		$statut="En cours";
		}
		}
		}
		if ($donnees['alerte']=="1")
		{
		$alerte="A moins de";
		}
		else
		{
		$alerte="Retard de";
		}
		// Pour les tâches
		if ($donnees['tri_tac']== "0")
		{
		$tri_tac="Toutes";
		}
		else
		{
		if ($donnees['tri_tac'] == "1")
		{
		$tri_tac="Privées";
		}
		else
		{
		$tri_tac="Publiques";
		}
		}
		// Pour la date des tâches
		if ($donnees['date_t']=="1")
		{
		$date_t="A moins de";
		}
		else
		{
		$date_t="Retard de";
		}
		// Pour les catégories
		// Dans le cas où l'utilisateur a saisi "Toutes" = 0 dans la BDD
		if ($donnees['categorie'] == "0")
		{
		$categorie = "Toutes";
		}
		else
		{
		$categorie = "NON";
		// Récupération de la catégorie COMMUNE souhaitée si elle existe
		$query="SELECT intitule_categ FROM categorie_commune where id_categ = ".$donnees['categorie'].";";
		$execution = mysql_query ($query);
		while($results = mysql_fetch_array($execution))
		{
		$categorie = $results['intitule_categ'];
		}
		// Si la catégorie est personnelle...
		if ($categorie == "NON")
		{
		$query="SELECT nom FROM categorie where id_categ = ".$donnees['categorie'].";";
		$execution=mysql_query($query);	
		while($recup=mysql_fetch_array($execution))
		{
		$categorie=$recup['nom'];
		}
		}
		}
		// Pour les échénces de garantie
		if ($donnees['echeance_gar']=="moins")
		{
		$echeance_gar="Dans moins de";
		}
		else
		{	
		$echeance_gar="Retard de";
		}
		// Pour les échéances de prêt
		if ($donnees['echeance_pret']=="moins")
		{
		$echeance_pret="Dans moins de";
		}
		else
		{
		$echeance_pret="Retard de";
		}
		// Pour les infos modules
		if ($donnees['pers_form']=="Tout")
		{
		$pers_form="Nouvelle saisie et modification";
		}
		else
		{
		if ($donnees['pers_form']=="Nsaisie")
		{
		$pers_form="Nouvelle saisie";
		}
		else
		{
		$pers_form="Modification";
		}
		}
		$nb_j_tache=$donnees['nb_j_tache'];
		$nb_j_alerte=$donnees['nb_j_alerte'];
		$nb_j_ech=$donnees['nb_j_ech'];
		$nb_j_pret=$donnees['nb_j_pret'];
		
		echo "<br>";
		echo"<form method =get action=option2.php>";
		echo "Vous pouvez ici modifier les préférences d'affichage de votre tableau de bord";
		echo "<br>";
		echo "<h3>Tickets</h3>";
		echo "Trier par	: <select name=tri_tick>";
		$donnees=$tri_tick;
				test_option_select ($donnees,"Priorité","1");
				test_option_select ($donnees,"Date dernière réponse","2");
				test_option_select ($donnees,"Date de création","3");
		echo"</select><br><br>";
		echo "Statut traitement : <select name=statut>";
		$donnees=$statut;
				test_option_select ($donnees,"Tous","Tous");
				test_option_select ($donnees,"Nouveau","N");
				test_option_select ($donnees,"Transféré","T");
				test_option_select ($donnees,"En cours","C");
				echo"</select><br><br>";
		echo "Alertes tickets : <select name=alerte>";
		$donnees=$alerte;
				test_option_select ($donnees,"A moins de","1");
				test_option_select ($donnees,"Retard de","2");
				echo"</select>";
		echo "<input type=int name=nb_jours_alerte size=2 maxlength=2 value=".$nb_j_alerte."> jour(s) <br><br>";
		echo "<h3>Suivi des tâches</h3>";
		echo "Trier par : <select name=tri_tac>";
		$donnees=$tri_tac;
				test_option_select ($donnees,"Toutes","0");
				test_option_select ($donnees,"Privées","1");
				test_option_select ($donnees,"Publiques","2");
				echo"</select><br><br>";
		echo "Date : <select name=date_t>";
		$donnees=$date_t;
				test_option_select ($donnees,"A moins de","1");
				test_option_select ($donnees,"Retard de","2");
		echo"</select>";
		echo "<input type=int name=nb_jours_tache size=2 maxlength=2 value=".$nb_j_tache."> jour(s) <br><br>";
		echo "<h3>Garanties des matériels</h3>";
		echo "Echéance : <select name=echeance_garantie>";
				$donnees=$echeance_gar;
				test_option_select ($donnees,"Dans moins de","moins");
				test_option_select ($donnees,"Retard de","retard");
				echo"</select>";
		echo "<input type=int name=nb_jours_echeance_gar size=2 maxlength=2 value= ".$nb_j_ech."> jour(s) <br><br>";
		echo "<h3>Suivi des prêts des matériels</h3>";
		echo "Echéance : <select name=echeance_pret>";
				$donnees=$echeance_pret;
				test_option_select ($donnees,"Dans moins de","moins");
				test_option_select ($donnees,"Retard de","retard");
				echo"</select>";				
				echo "<input type=int name=nb_jours_echeance_pret size=2 maxlength=2 value=".$nb_j_pret."> jour(s) <br><br>";
				}
				echo "<input type=submit value=Modifier a href = option2.php>";
				echo "</form>";
				echo "<br>";
/*				echo"<form method =get action=test.php>";
				echo "<input type=submit value=Retour a href = test.php>";
				echo "</form>";
*/				}
				else
				{
				echo "<br>";
				echo"<form method =get action=option2.php>";
		echo "Vous pouvez ici modifier les préférences d'affichage de votre tableau de bord";
		echo "<br>";
		echo "<h3>Tickets</h3>";
		echo "Trier par	: <select name=tri_tick>
				<option value = 1> Priorité </option>
				<option value = 2> Date dernière réponse </option>
				<option value = 3> Date de création </option></select><br><br>";
		echo "Statut traitement : <select name=statut>
				<option value = Tous> Tous </option>
				<option value = N> Nouveaux </option>
				<option value = T> Transférés </option>
				<option value = C> En cours </option></select><br><br>";
		echo "Alertes tickets : <select name=alerte>
				<option value = 1> A moins de </option>
				<option value = 2> Retard de </option></select>";
		echo "<input type=int name=nb_jours_alerte size=2 maxlength=2 value=> jour(s) <br><br>";
		echo "<h3>Suivi des tâches</h3>";
		echo "Trier par : <select name=tri_tac>
				<option value = 0> Toutes </option>
				<option value = 1> Privées </option>
				<option value = 2> Publiques </option></select><br><br>";
		echo "Date : <select name=date_t>
				<option value = 1> A moins de </option>
				<option value = 2> Retard de </option></select>";
		echo "<input type=int name=nb_jours_tache size=2 maxlength=2 value=> jour(s) <br><br>";
		echo "<h3>Garanties des matériels</h3>";
		echo "Echéance : <select name=echeance_garantie>
				<option value = moins> Dans moins de </option>
				<option value = retard> Retard de </option></select>";
		echo "<input type=int name=nb_jours_echeance_gar size=2 maxlength=2 value=0> jour(s) <br><br>";
		echo "<h3>Suivi des prêts des matériels</h3>";
		echo "Echéance : <select name=echeance_pret>
				<option value = moins> Dans moins de </option>
				<option value = retard> Retard de </option></select>";
				echo "<input type=int name=nb_jours_echeance_pret size=2 maxlength=2 value=> jour(s) <br><br>";
				echo "<input type=submit value=Valider a href = option2.php>";
				echo "</form>";
				echo "<br>";
/*				echo"<form method =get action=test.php>";
				echo "<input type=submit value=Retour a href = test.php>";
				echo "</form>";
*/				}		
		//Fin d'insertion du code
        		 ?>
		</div>
	</body>
</html>
