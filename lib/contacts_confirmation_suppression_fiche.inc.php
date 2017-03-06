<?php
//echo "<BR> Je suis dans la procédure de suppression du lot $id_lot";
              $id_contact = $_GET['id_contact'];
              
              //Récupération des variables de la table lot 
              include("../biblio/init.php");
              $query_suppression = "DELETE FROM contacts WHERE ID_CONTACT = '".$id_contact."';";
			        $result = mysql_query($query_suppression);
				      //Dans le cas où aucun résultats n'est retourné
				      if(!$result)
			 	      {
					       echo "<b>Erreur de connexion à la base de donn&eacute;es ou erreur de requ&egrave;te</b>";
					       //echo "<BR> <A HREF = \"consult_ticket.php?tri=$tri&amp;CST=N&amp;idpb=".$idpb_pere."&amp;id_categ=".$id_categ."\" class = \"bouton\">Retour au ticket</A>";
					       mysql_close();
					       //exit;
				      }
				      
?>
