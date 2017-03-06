<?php
	$nom=$_POST["nom_mag"];
	$requete_verifabo="SELECT * FROM abo_abonnement where Nom_mag like '$nom';";
	$result_verifabo=mysql_query($requete_verifabo);
	$ligne_verifabo=mysql_fetch_assoc($result_verifabo);
	$date=date("Y-m-d");

	if($ligne_verifabo["Nom_mag"]=='')
	{
		$datedebut=$_POST["datedeb"];
		$datedebut_angl=date("Y-m-d", strtotime($datedebut));
		$datefin=$_POST["datefin"];
		$datefin_angl=date("Y-m-d", strtotime($datefin));
		$period=$_POST["period"];
		$prix=$_POST["prix"];
		$nb=$_POST["nb"];
		$id_categorie=$_POST["id_categorie"];
		$soc=$_POST["soc"];
		/*
		echo "<br />datedebut : $datedebut";
		echo "<br />datedebut_angl : $datedebut_angl";
		echo "<br />datefin : $datefin";
		echo "<br />datefin_angl : $datefin_angl";
		echo "<br />period : $period";
		echo "<br />prix : $prix";
		echo "<br />nb : $nb";
		echo "<br />soc : $soc";
		*/

		$requete_ajoutabo="INSERT INTO abo_abonnement values ('','$nom','$date','$datedebut_angl','$datefin_angl','$period','$prix','$nb','$soc','$categ');";
		$result_ajoutabo=mysql_query($requete_ajoutabo);
		if($result_ajoutabo)
		{
			echo "<h2>L'abonnement a bien &eacute;t&eacute; ajout&eacute;</h2>";
			$no_dernier_id_genere = mysql_insert_id();
			//echo "<br />no_dernier_id_genere : $no_dernier_id_genere";

			//On ajoute les catégories
			$nombre_elements = count($id_categorie);
			//echo "<br />nombre_elements : $nombre_elements";
			if (($id_categorie[0] <> 0) OR ($id_categorie[0] == 0 AND $nombre_elements >1))
			{
				//echo "<br>nombre d'éléments dans le tableau : $nombre_elements";
				$i = 0; //on définit la variable $i qui sera notre nombre que l'on incrémentera. Ici $i va commencer à 0
				while($i < $nombre_elements)
				{
					$requete_ajout = "INSERT INTO `abo_categorie_abonnement` (`idcateg`,`NoAbo`)
						VALUES ('".$id_categorie[$i]."','".$no_dernier_id_genere."')";
					$resultat_ajout = mysql_query($requete_ajout);
					if(!$resultat_ajout)
					{
						echo "<br>Erreur";
					}
					$i++;
				} //Fin while
			}

			//On ajoute le nombre des magazines 

			$max=$no_dernier_id_genere;
			$cpte=0;
			$valid=false;
			/*
			echo "<br />max : $max";
			echo "<br />cpte : $cpte";
			echo "<br />nb : $nb";
			echo "<br />valid : $valid";
			*/
			while($cpte!=$nb)
			{
				$requete_ajoutmag="INSERT INTO abo_magazine values ('','$max','','','','') ;";
				
				//echo "<br />$requete_ajoutmag";
				
				$result_ajoutmag=mysql_query($requete_ajoutmag);
				if($result_ajoutmag)
				{
					$valid=true;
				}
				$cpte++;
			}
			if($valid==true)
			{
				echo "<h2>Les magazines ont &eacute;t&eacute; ajout&eacute;s</h2>";
			}
			else
			{
				echo "<h2>Probl&egrave;me lors de l'ajout des magazines</h2>";
			}

		}
		else
		{
			echo "<h2>Erreur lors de l'ajout de l'abonnement</h2>";
		}
	}
	else
	{
		echo "<h2>Un abonnement pour cette publication existe d&eacute;j&agrave;</h2>";
	}
?>
