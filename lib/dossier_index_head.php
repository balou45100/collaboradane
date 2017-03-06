<?php
	session_start();
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	header('Content-Type: text/html;charset=UTF-8');

?>
<!DOCTYPE HTML>

<?php
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

		$_SESSION['form']++;
	
		//include ("../biblio/dossier.css");
		include ("../biblio/init_dossier.php");
		include ("dossier_fonction_base.php");

		
		$idDossier = obtenirNumsDossiers ($co);
		$idDocument = obtenirNumsDocuments($co);	
		$rne = obtenirRneEtabs($co);
		$idEvenement = obtenirIdsEvenements($co);
		$idSociete = obtenirNumsSocietes($co);
		$idUtil = obtenirNumsUtils($co);

	?>
</head>
<!--body BGCOLOR="#FFFF99"-->
	<body class = "menu-boutons">
	<!-- 	Affichage d'un formulaire progressif : en fonction des choix faits, on affiche telle ou telle donnée 				-->
	<!-- 	La variable de session 'form' permet de savoir quel liste afficher. Elle est initialisée dans dossier_index.php 	-->
		
	<?php
	if ($_SESSION['form'] == 1)
	{
	?>

		<form method="post" action="dossier_index_head.php">
			- Vous cherchez :
			<select name="choix">
				<option value="dossier">Dossier
				<option value="document">Document
				<option value="utilisateur">Utilisateur
				<option value="etablissement">Etablissement
				<option value="evenement">Evenement
				<option value="societe">Societe
			</select>
			<input type="submit" value="Continuer">	
		</form>
		
	<?php
	} else if ($_SESSION['form'] == 2)
	{
		$choix=$_POST['choix'];
?>

		<form method="post" action="dossier_index_head.php">
			- Vous cherchez : <b><?php echo $choix ?></b> - Lié à :
			<select name="choix2">
			
<?php
				switch ($choix)
				{
					case "dossier" : 	echo '<option value="document">Document
											  <option value="utilisateur">Utilisateur
											  <option value="etablissement">Etablissement
											  <option value="evenement">Evenement
											  <option value="societe">Societe';
										break;
					case "document" : 	echo '<option value="dossier">Dossier
											  <option value="utilisateur">Utilisateur
											  <option value="etablissement">Etablissement
											  <option value="evenement">Evenement
											  <option value="societe">Societe'; 
										break;
					case "utilisateur" : echo '<option value="document">Document
											  <option value="dossier">Dossier
											  <option value="evenement">Evenement';
										break;
					case "etablissement" : echo '<option value="document">Document
											  <option value="dossier">Dossier';
										break;
					case "evenement" : 	echo '<option value="document">Document
											  <option value="dossier">Dossier
											  <option value="utilisateur">Utilisateur';
										break;
					case "societe" : 	echo '<option value="document">Document
											  <option value="dossier">Dossier';
										break;
				}
			?>
			
			</select>
			<?php echo '<input type="hidden" name="choix" value="'.$choix.'">' ?>
			<input type="submit" value="Continuer">	
		</form>	
		
	<?php
	} else if ($_SESSION['form'] == 3)
	{
		$choix = $_POST['choix'];
		$choix2 = $_POST['choix2'];	
?>

		<form method="post" action="dossier_index_script.php" target="body">
			- Vous cherchez : <b><?php echo $choix ?></b> - Lié à : <b><?php echo $choix2 ?>
			<br/></b> - Identifié par :
			<select name="id">
			
			<?php
			switch ($choix2)
			{
				case "dossier" : 		foreach ($idDossier as $id){echo '<option value="'.$id.'">'.obtenirNomDossier($co, $id);} 	
										break;
				case "document" : 		foreach ($idDocument as $id) { echo '<option value="'.$id.'">'.obtenirNomDocument($co, $id);}	
										break;
				case "utilisateur" :	foreach ($idUtil as $id) { echo '<option value="'.$id.'">'.obtenirNomUtil($co, $id);}		
										break;
				case "etablissement" :	foreach ($rne as $id) { echo '<option value="'.$id.'">'.$id;}	
										// $id.' - '.obtenirNomEtab($co, $id);
										break;
				case "evenement" :		foreach ($idEvenement as $id) { echo '<option value="'.$id.'">'.obtenirNomEvenement($co, $id);} 	
										break;
				case "societe":			foreach ($idSociete as $id) { echo '<option value="'.$id.'">'.obtenirNomSociete($co, $id);} 	
										break;
			}
?>
			
			</select>
<?php echo '<input type="hidden" name="choix" value="'.$choix.'">' ?>
<?php echo '<input type="hidden" name="choix2" value="'.$choix2.'">' ?>
			<input type="submit" value="Hop !">	
		</form>
		
<?php
	}
	?>
</body>
</html>
