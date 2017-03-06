<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['nom']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
	
	echo "<html>
	<head>
  		<title>CollaboraTICE</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";

	echo "</head>";
	echo "<body class = \"menu-boutons\">
		<div align =\"center\">";
			  include ("../biblio/init.php");
			  include ("../biblio/config.php");
			  
				echo "<form action = \"formations_gestion.php\" target = \"body\" METHOD = \"GET\">";
				
				//Choix de l'ann&eacute;e
				echo "&nbsp;&nbsp;Ann&eacute;e scolaire&nbsp;:&nbsp;<select size=\"1\" name=\"annee_scolaire\">
		          <option selected value=\"$annee_scolaire\">$annee_scolaire</option>";
		          if ($annee_scolaire<>"2006-2007")
		          {
                echo "<option value=\"2006-2007\">2006-2007</option>";
              }
              if ($annee_scolaire<>"2007-2008")
		          {
                echo "<option value=\"2007-2008\">2007-2008</option>";
              }
			        if ($annee_scolaire<>"2008-2009")
		          {
                echo "<option value=\"2008-2009\">2008-2009</option>";
              }
              if ($annee_scolaire<>"2009-2010")
		          {
                echo "<option value=\"2009-2010\">2009-2010</option>";
              }
              if ($annee_scolaire<>"2010-2011")
		          {
                echo "<option value=\"2010-2011\">2010-2011</option>";
              }
              if ($annee_scolaire<>"2011-2012")
		          {
                echo "<option value=\"2011-2012\">2011-2012</option>";
              }
              if ($annee_scolaire<>"2012-2013")
		          {
                echo "<option value=\"2012-2013\">2012-2013</option>";
              }
              if ($annee_scolaire<>"2013-2014")
		          {
                echo "<option value=\"2013-2014\">2013-2014</option>";
              }
              if ($annee_scolaire<>"2014-2015")
		          {
                echo "<option value=\"2014-2015\">2014-2015</option>";
              }
              echo "</select>";
			      echo "&nbsp;&nbsp;";
				
        		
        //Choix du type de formation      
            $requeteliste_formation="SELECT DISTINCT type_formation FROM formations ORDER BY type_formation ASC";
		        $result_formation=mysql_query($requeteliste_formation);
		        $num_rows_formations = mysql_num_rows($result_formation);
		        
            echo "Type de formation&nbsp;:&nbsp;<select size=\"1\" name=\"intitule_formation\">";
           
            if (mysql_num_rows($result_formation))
            {
              
			       echo "<option selected value=\"T\">Tous</option>";
			       while ($ligne=mysql_fetch_object($result_formation))
             {
			          $intitule_formation=$ligne->type_formation;
			          echo "<option value=\"$intitule_formation\">$intitule_formation</option>";
			       }
		        }
            echo "</select>"; 
        
        //Choix du champs acad&eacute;mique ou d&eacute;partemental
            echo "&nbsp;&nbsp;D&eacute;partement&nbsp;:&nbsp;<select size=\"1\" name=\"dep\">
		          <option selected value=\"T\">Tous</option>
			        <option value=\"18\">Cher (18)</option>
			        <option value=\"28\">Eure-et-Loire (28)</option>
			        <option value=\"36\">Indre (36)</option>
			        <option value=\"37\">Indre-et-Loire (37)</option>
			        <option value=\"41\">Loir-et-Cher (41)</option>
			        <option value=\"45\">Loiret (45)</option>
			        </select>";
			        
			    
			    /*
			      
				//Choix d'un &eacute;tablissement par son RNE      
            
            
            $requeteliste_rne="SELECT DISTINCT RNE FROM etablissements ORDER BY RNE ASC";
		        $result_rne=mysql_query($requeteliste_rne);
		        $num_rows_rne = mysql_num_rows($result_rne);
		        echo "nombre de r&eacute;sultats : $num_rows_rne";
            echo "&nbsp;&nbsp;RNE&nbsp;:&nbsp;<select size=\"1\" name=\"rne_recherche\">";
           
            if (mysql_num_rows($result_rne))
            {
              
			       echo "<option selected value=\"T\">Tous</option>";
			       while ($ligne=mysql_fetch_object($result_rne))
             {
			          $rne_recherche=$ligne->RNE;
			          echo "<option value=\"$rne_recherche=$ligne\">$rne_recherche</option>";
			       }
		        }
            echo "</select>"; 
            
            
            echo "coucou";		
				
        */
        //Champ pour une recherche avec entr&eacute;e libre
				
				echo "<!--br-->&nbsp;&nbsp;&nbsp;RNE&nbsp;:&nbsp; 
				<input type = \"text\" VALUE = \"\" NAME = \"rne_a_rechercher\" SIZE = \"8\">";
			
        echo "&nbsp;&nbsp;&nbsp;<input type = \"submit\" VALUE = \"Afficher\">
				</form>";		
			?>
		</div>
	</body>
</html>

