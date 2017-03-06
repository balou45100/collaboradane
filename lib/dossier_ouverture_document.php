<?php
include ("../biblio/config.php");

$fichier = $_GET['nomFichier'];

$nom_complet=$dossierDoc.$fichier;

header('Content-disposition: attachment; filename="'.$fichier.'" '); 
header('Content-type: application/octet-stream" '); 
readfile ($nom_complet);

?> 