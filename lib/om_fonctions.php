<?php
	//session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}

// ---------------- http://www.phpdebutant.org/article84.php ---------------- //
//récupération de $limite

    if(isset($_GET['limite'])) 

        $limite=$_GET['limite'];
    else   $limite=0;


function verifLimite($limite,$total,$nombre) {

    // je verifie si limite est un nombre.

    if(is_numeric($limite)) {

        
// si $limite est entre 0 et $total, $limite est ok

        // sinon $limite n'est pas valide.

        if(($limite >=0) && ($limite <= $total) && (($limite%$nombre)==0)) {

            // j'assigne 1 à $valide si $limite est entre 0 et $max

            $valide = 1;

        }    

        else {

            // sinon j'assigne 0 à $valide

            $valide = 0;

        }

    }

    else {

            // si $limite n'est pas numérique j'assigne 0 à $valide

            $valide = 0;

    }

// je renvois $valide

return $valide;

}

function affichePages($nb,$page,$total,$limite_actuelle)
//function affichePages($nb,$page,$total)
{
        $nbpages=ceil($total/$nb);
        $numeroPages = 1;
        $compteurPages = 1;
        $limite  = 0;
        echo "Page&nbsp;";
        //echo '<table border = "0" ><center>'."\n";
        while($numeroPages <= $nbpages) {
		if($limite!=$limite_actuelle){
        echo '<a href = "'.$page.'?limite='.$limite.'">'.$numeroPages.'</a>'."\n";
        }else{
		echo '<b><a href = "'.$page.'?limite='.$limite.'" >'.$numeroPages.'</a></b>'."\n";
		}
		$limite = $limite + $nb;
        $numeroPages = $numeroPages + 1;
        $compteurPages = $compteurPages + 1;
            if($compteurPages == 10) {
            $compteurPages = 1;
            echo '<br>'."\n";
            }
        }
        //echo '</center></table>'."\n";
}


function displayNextPreviousButtons($limite,$total,$nb,$page) {
$limiteSuivante = $limite + $nb;
$limitePrecedente = $limite - $nb;
echo  '<center><table>'."\n";
if($limite != 0) {
        echo  '<form action="'.$page.'" method="post">'."\n";
        echo  '<input type="submit" value="précédent">'."\n";
        echo  '<input type="hidden" value="'.$limitePrecedente.'" name="limite">'."\n";
        echo  '</form>'."\n";
}

if($limiteSuivante < $total) {
        echo  '<form action="'.$page.'?limite='.$limiteSuivante.'" method="post">'."\n";
        echo  '<input type="submit" value="suivant">'."\n";
        echo  '<input type="hidden" value="'.$limiteSuivante.'" name="limite">'."\n";
        echo  '</form>'."\n";
}
echo  '</table></center>'."\n";
}
?>
