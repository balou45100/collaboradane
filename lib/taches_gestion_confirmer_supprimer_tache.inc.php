<?php
  $id = $_GET['id'];
  //echo "<br />suppression de id : $id";
  $requete_suppression = "DELETE FROM taches WHERE id_tache =".$id.";";
  $resultat_suppression = mysql_query($requete_suppression);
  if(!$resultat_suppression)
  {
    echo "<h2>Erreur</h2>";
  }
  else
  {
    echo "<h2>La t&acirc;che a &eacute;t&eacute; supprim&eacute;e.</h2>";
  }
  //On supprime la t�che dans la table taches_categories
  $requete_suppression = "DELETE FROM taches_categories WHERE id_tache =".$id.";";
  $resultat_suppression = mysql_query($requete_suppression);
  if(!$resultat_suppression)
  {
    echo "<h2>Erreur</h2>";
  }
  else
  {
    echo "<h2>Les liens vers les cat&acirc;gories ont &eacute;t&eacute; supprim&eacute;s.</h2>";
  }

  //On supprime la t�che dans la table taches_util
  $requete_suppression = "DELETE FROM taches_util WHERE id_tache =".$id.";";
  $resultat_suppression = mysql_query($requete_suppression);
  if(!$resultat_suppression)
  {
    echo "<h2>Erreur</h2>";
  }
  else
  {
    echo "<h2>Les partages ont &eacute;t&eacute; supprim&eacute;s.</h2>";
  }
?>
