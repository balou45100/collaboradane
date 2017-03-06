<?php
						$description_alerte = $_POST['description_alerte']; //récupération du nom du fichier
						$jour = $_POST['jour'];
						$mois = $_POST['mois'];
						$annee = $_POST['annee'];
						$nbr_jours = $_POST['nbr_jours'];
						$id_util = $_SESSION['id_util'];

/*
						echo "<h1>Confirmation de la modification de l'alerte du ticket $idpb</h1>";

						echo "<br>description_alerte : $description_alerte";
						echo "<br>jour : $jour - mois : $mois - annee : $annee";
						echo "<br>nbr_jours : $nbr_jours";
						echo "<br>id_ticket : $idpb - id_util : $id_util";
						echo "<br>aujourd'hui : $date_aujourdhui";
*/
						if ($nbr_jours == 0)
						{
							$date_a_enregistrer = crevardate($jour,$mois,$annee);
							//echo "<br>date_a_enregistrer retournée : $date_a_enregistrer";
						}
						else
						{
							//echo "<br>1 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";
							$aujourdhui = date('Y/m/d');
							$aujourdhui = strtotime($aujourdhui);
							$date_a_enregistrer = $aujourdhui + ($nbr_jours*86400);
							//echo "<br>2 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";
							$date_a_enregistrer = date('Y/m/d',$date_a_enregistrer);
							//echo "<br>3 - aujourdhui : $aujourdhui - nbr_jours : $nbr_jours - date_a_enregistrer : $date_a_enregistrer";
						}
						//echo "<br>date_a_enregistrer : $date_a_enregistrer";

						//$requete_maj = "UPDATE `collaboratice`.`alertes` SET `description` = '".$description_alerte."', `date_alerte` = '";$date_a_enregistrer."' WHERE `alertes`.`id_ticket` = '".$idpb."' AND `alertes`.`id_util` = '".$id_util."';";
						$requete_maj = "UPDATE alertes SET 
							description = '".$description_alerte."',
							date_alerte = '".$date_a_enregistrer."'
						WHERE id_ticket = '".$idpb."' AND id_util = '".$id_util."';";
						//$requete_maj = "UPDATE `collaboratice`.`alertes` SET `description` = '".$description_alerte."' WHERE `alertes`.`id_ticket` = '".$idpb."' AND `alertes`.`id_util` = '".$id_util."';";
						$resultat_maj = mysql_query($requete_maj);
						if(!$resultat_maj)
						{
							echo "<br>Erreur";
						}
						else
						{
							echo "<br>L'alerte a été enregistrée.";
						}

?>
