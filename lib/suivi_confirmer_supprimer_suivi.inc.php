<?php
  $id_suivi = $_GET['id_suivi'];

  //echo "<br />suppression de id_suivi : $id_suivi";

  $requete_suppression = "DELETE FROM suivis WHERE id =".$id_suivi.";";
  $resultat_suppression = mysql_query($requete_suppression);
  if(!$resultat_suppression)
  {
    echo "<h2>Erreur</h2>";
  }
  else
  {
    echo "<h2>Le suivi a &eacute;t&eacute; supprim&eacute;.</h2>";
    //On supprime lsuivi dans la table suivis_categories_communes
    $requete_suppression = "DELETE FROM suivis_categories_communes WHERE id_suivi =".$id_suivi.";";
    $resultat_suppression = mysql_query($requete_suppression);
    if(!$resultat_suppression)
    {
      echo "<h2>Erreur</h2>";
    }
    else
    {
      echo "<h2>Le lien vers le dossier a &eacute;t&eacute; supprim&eacute;.</h2>";
    }
  }
?>
