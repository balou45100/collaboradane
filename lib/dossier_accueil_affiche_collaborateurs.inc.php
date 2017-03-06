<?PHP
	//echo "<br />id_dossier  $id_dossier";
	//On récupère les initiales des collaborateurs associés au dossier
	$requete_utils = "SELECT u.initiales, u.nom, ddu.id_util, u.prenom FROM util AS u, dos_dossier_util AS ddu
		WHERE u.id_util = ddu.id_util AND ddu.id_dossier = $id_dossier
		ORDER BY nom";

	//echo "<br />$requete_utils";

	$resultat_requete_utils = mysql_query($requete_utils);
	$nbr_utils = mysql_num_rows($resultat_requete_utils);

	//echo "<br />nbr_utils : $nbr_utils<br />";

	if ($nbr_utils > 0)
	{
		$compteur = 0; //On met à zéro le compteur pour gérer le nombre d'initiales par ligne
		while ($ligne_utils=mysql_fetch_array($resultat_requete_utils))
		{
			$compteur++;
			If ($compteur > 7)
			{
				echo "<br />";
				$compteur = 0;
			}
			//echo "<br />compteur : $compteur";
			affiche_info_bulle_initiales($ligne_utils[0],$ligne_utils[3],$ligne_utils[1]);
			echo "$ligne_utils[0] ";
		}
	}
	else
	{
		echo "&nbsp;";
	}
?>
