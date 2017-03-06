<?php
						$description_alerte = $_POST['description_alerte'];
						$jour = $_POST['jour'];
						$mois = $_POST['mois'];
						$annee = $_POST['annee'];
						$nbr_jours = $_POST['nbr_jours'];
						$id_util = $_SESSION['id_util'];
/*
						echo "<br>description_alerte : $description_alerte - jour : $jour - mois : $mois - annee : $annee - nbr_jours : $nbr_jours";
						echo "<br>id_ticket : $idpb - id_util : $id_util";
						echo "<br>aujourd'hui : $date_aujourdhui";
*/
						if ($nbr_jours == 0)
						{
							$date_a_enregistrer = crevardate($jour,$mois,$annee);
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

						$requete_ajout = "INSERT INTO `alertes` (`id_ticket`,`id_util`,`date_alerte`,`description`)
							VALUES ('".$idpb."','".$id_util."','".$date_a_enregistrer."','".$description_alerte."')";
						$resultat_ajout = mysql_query($requete_ajout);
						if(!$resultat_ajout)
						{
							echo "<br>Erreur";
						}
						else
						{
							echo "<br>L'alerte a été enregistrée.";
						}

?>
