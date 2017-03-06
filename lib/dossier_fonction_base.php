<?php

	/********************************************************************
	*	Fichier contenant les fonctions liées à la base de données.		*
	*********************************************************************/

	// Numeros de tous les dossiers
	function obtenirNumsDossiers($co) 
	{
		
		$sql = "SELECT idDossier FROM dos_dossier";
		$co->requete($sql,1);
		$i = 0;
		while ($ligne=$co->fetch_row(1))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Noms de tous les dossiers
	function obtenirNomTousDossiers($co) 
	{
		$sql = 'SELECT libelleDossier FROM dos_dossier;';
		$co->requete($sql,2);
		$i = 0;
		while ($ligne=$co->fetch_row(2))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}
	
	// Noms de tous les dossiers
	function obtenirNomDossierUtil($co, $idUtil) 
	{
		$sql = 'SELECT libelleDossier FROM dos_dossier, dos_utilisateur_mesdossier
				WHERE dos_utilisateur_mesdossier.idDossier = dos_dossier.idDossier
				AND idUtil = '.$idUtil;
		$co->requete($sql,52);
		$i = 0;
		while ($ligne=$co->fetch_row(52))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}
	
	// Nom du dossier dont numero est passé en paramètre
	function obtenirNomDossier ($co, $id)
	{
		$sql = "SELECT libelleDossier FROM dos_dossier WHERE idDossier=".$id.";";
		$co->requete($sql,3);
		$i = 0;
		$ligne = $co->fetch_row(3);
		return $ligne[0];
	}	
	
	// Numero du dossier dont le nom est passé en paramètre
	function obtenirUnNumDossier ($co, $nom)
	{
		$sql = 'SELECT idDossier FROM dos_dossier WHERE libelleDossier="'.$nom.'";';
		$co->requete($sql,4);
		$ligne = $co->fetch_row(4);
		return $ligne[0];
	}
	
	// Numeros de tous les documents
	function obtenirNumsDocuments($co)
	{

		$sql = "SELECT idDocument FROM dos_document";
		$co->requete($sql,5);
		$i = 0;
		while ($ligne=$co->fetch_row(5))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Noms de tous les documents
	function obtenirNomDocument($co, $id)
	{
		$sql = "SELECT libelleDocument FROM dos_document WHERE idDocument=".$id.";";
		$co->requete($sql,6);
		$i = 0;
		$ligne = $co->fetch_row(6);
		return $ligne[0];
	}
	
	// Rne des etablissements
	function obtenirRneEtabs($co)
	{

		$sql = "SELECT rne FROM etablissements";
		$co->requete($sql,7);
		$i = 0;
		while ($ligne=$co->fetch_row(7))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Noms de tous les etablissements
	function obtenirNomEtab($co, $id)
	{
		$sql = "SELECT nom FROM etablissements WHERE rne='".$id."';";
		$co->requete($sql,8);
		$i = 0;
		$ligne = $co->fetch_row(8);
		return $ligne[0];
	}
	
	// IDs des evenements
	function obtenirIdsEvenements($co)
	{
		
		$sql = "SELECT idEvenement FROM dos_evenement";
		$co->requete($sql,9);
		$i = 0;
		while ($ligne=$co->fetch_row(9))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Noms des evenements
	function obtenirNomEvenement($co, $id)
	{
		$sql = "SELECT libelleEvenement FROM dos_evenement WHERE idEvenement=".$id.";";
		$co->requete($sql,10);
		$i = 0;
		$ligne = $co->fetch_row(10);
		return $ligne[0];
	}
	
	// Numeros des sociétés
	function obtenirNumsSocietes($co)
	{
		$sql = "SELECT no_societe FROM repertoire ORDER BY societe ASC";
		$co->requete($sql,11);
		$i = 0;
		while ($ligne=$co->fetch_row(11))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Numeros des sociétés
	function obtenirUnNumSociete ($co, $nomSociete)
	{
		$sql = 'SELECT no_societe FROM repertoire WHERE societe="'.$nomSociete.'"';
		$co->requete($sql,12);
		$ligne=$co->fetch_row(12);
		return $ligne[0];
	}	
	
	// Nom des sociétés
	function obtenirNomsTousSocietes($co)
	{
		$sql = "SELECT societe FROM repertoire ORDER BY societe ASC";
		$co->requete($sql,13);
		$i = 0;
		while ($ligne=$co->fetch_row(13))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	}	
	
	// Nom d'une société en fonction d'un identifiant
	function obtenirNomSociete($co, $id)
	{
		$sql = "SELECT societe FROM repertoire WHERE No_societe=".$id.";";
		$co->requete($sql,14);
		$i = 0;
		$ligne = $co->fetch_row(14);
		return $ligne[0];
	}
	
	// Numeros des utilisateurs
	function obtenirNumsUtils($co)
	{

		$sql = "SELECT id_util FROM util";
		$co->requete($sql,15);
		$i = 0;
		while ($ligne=$co->fetch_row(15))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}
		return $tableau;
	
	}	
	
	// Noms des utilisateurs
	function obtenirNomUtil($co, $id)
	{
		$sql = "SELECT nom FROM util WHERE id_util=".$id.";";
		$co->requete($sql,16);
		$i = 0;
		$ligne = $co->fetch_row(16);
		return $ligne[0];
	}
	
	function obtenirDernierIdDossierCree($co)
	{
		$requete = "SELECT MAX(idDossier) FROM dos_dossier;";
		$co->requete($requete,17);
		$idDossier = $co->fetch_row(17);
		return $idDossier[0];
	}
	
	function obtenirListeCategorie ($co)
	{
		$requete = "SELECT libelleCategorie FROM dos_categorie_document;";
		$co->requete($requete,18);
		$i = 0;
		while ($ligne = $co->fetch_row(18))
		{
			$tableau[$i] = $ligne[0];
			$i++;
		}	
		return $tableau;
	}
	
	function obtenirUtilDroit ($co, $numDossier)
	{
		$sql = 'SELECT idUtil, droit
				FROM dos_utilisateur_mesdossier
				WHERE idDossier = "'.$numDossier.'";';
		$co->requete ($sql, 20);
		
		/*
			On veut renvoyer les deux valeurs dans un tableau à deux dimensions.
			Si tableau[0][..], alors il s'agit de l'idUtil
			Si tableau[1][..], alors il s'agit du droit
			
			Ainsi pour $tableau[0][5] et $tableau[1][5], 5 permet de faire le lien entre l'idUtil et le droit correspondant.
			Cette fonction est utilisée dans la modification de droits.
			Elle permettra de comparer les droits.
		*/
		
		$i = 0;
		while ($ligne = $co->fetch_row(20))
		{
			$tableau[0][$i] = $ligne[0];
			$tableau[1][$i] = $ligne[1];
			$i++;
		}
		return $tableau;
	}
		

/*************************************************************************************************************\
|*************************************************************************************************************|
|*************************************************************************************************************|
|							Fonctions d'insertion des données dans la base                                    |
|*************************************************************************************************************|
|*************************************************************************************************************|						
\*************************************************************************************************************/

	function insertionEvenement ($co, $idDossier, $libEven, $dateEven, $horaireEven, $lieuEven, $remarquesEven)
	{
			$sql1 = 'INSERT INTO dos_evenement
					 VALUES (NULL, "'.$libEven.'", "'.$dateEven.'", "'.$horaireEven.'", "'.$lieuEven.'", "'.$remarquesEven.'");';
			if ($co->requete ($sql1, 21))
			{
				$sql2 = 'SELECT MAX(idEvenement) FROM dos_evenement;';
				$co->requete ($sql2, 22);
				$maxIdEven = $co->fetch_row(22);	
	
				$sql3 = 'INSERT INTO dos_evenement_mesdossier
						 VALUES ("'.$maxIdEven[0].'","'.$idDossier.'");';
				if ($co->requete ($sql3, 23))
				{
					return true;
				} else 
				{
					return false;
				}
			}
	}
	
	function insertionDocument ($co, $idDossier, $libDoc, $nomFichierDoc, $moduleDoc, $descriptionDoc, $type)
	{
		$verifCategorie = 'SELECT idCategorie FROM dos_categorie_document WHERE libelleCategorie = "'.$type.'";'; 
		$co->requete ($verifCategorie, 24);
		$idCategorie = $co->fetch_row(24);
		$sql1 = 'INSERT INTO dos_document
				 VALUES (NULL, "'.$libDoc.'", "'.$nomFichierDoc.'", "'.$moduleDoc.'", "'.$descriptionDoc.'", "'.$idCategorie[0].'");';
		if ($co->requete ($sql1, 25))
		{
			$sql2 = 'SELECT MAX(idDocument) FROM dos_document;';
			$co->requete ($sql2, 26);
			$maxIdDoc = $co->fetch_row(26);	
			
			$sql3 = 'INSERT INTO dos_document_mesdossier
					 VALUES ('.$maxIdDoc[0].','.$idDossier.');';
			$co->requete ($sql3, 27);
		}
	}
	
	function insertionEtablissement ($co, $idDossier, $rne)
	{
		$verif = '	SELECT COUNT(*) FROM dos_etablissement_mesdossier
					WHERE rne = "'.$rne.'"
					AND idDossier = "'.$idDossier.'";';
		$co->requete ($verif, 28);
		$res = $co->fetch_row(28);
		if ($res[0] == 0)
		{
			$sql = 'INSERT INTO dos_etablissement_mesdossier
					VALUES ("'.$rne.'","'.$idDossier.'");';
			if ($co->requete ($sql, 29))
			{
				return true;
			} else 
			{
				return false;
			}
		} else
		{
			return false;
		}
	}	
	
	function insertionSociete ($co, $idDossier, $numSociete)
	{
		$verif = '	SELECT COUNT(*) FROM dos_societe_mesdossier
					WHERE idSociete = "'.$numSociete.'"
					AND idDossier = "'.$idDossier.'";';
		$co->requete ($verif, 30);
		$res = $co->fetch_row(30);
		if ($res[0] == 0)
		{
			$sql = 'INSERT INTO dos_societe_mesdossier
					VALUES ("'.$numSociete.'","'.$idDossier.'");';
			if ($co->requete ($sql, 31))
			{
				return true;
			} else 
			{
				return false;
			}
		} else
		{
			return false;
		} 
	}

	function insertionDroit ($co, $idUtil, $idDossier, $droit)
	{
		$requete = "INSERT INTO dos_utilisateur_mesdossier
					VALUES (".$idUtil.",".$idDossier.",".$droit.");";
		if($co->requete ($requete, 32))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
	function insertionDossier ($co, $libelleDossier,$description)
	{
		$requete =	"INSERT INTO dos_dossier (idDossier ,libelleDossier,description)
					VALUES (NULL , '".$libelleDossier."','".$description."');";
		if ($co->requete ($requete, 33))
			{
				return true;
			}
			else
			{
				return false;
			}
	}

/*************************************************************************************************************\
|*************************************************************************************************************|
|*************************************************************************************************************|
|							Fonctions de suppression des données dans la base                                 |
|*************************************************************************************************************|
|*************************************************************************************************************|						
\*************************************************************************************************************/

	function suppressionDossier($co, $num)
	{
	
		$compteDoc = 'SELECT COUNT(*) FROM dos_document_mesdossier WHERE idDossier='.$num.';';
		$co->requete ($compteDoc, 34);
		$res = $co->fetch_row(34);
		if ($res[0] > 0)
		{
			$supprLienDoc = "DELETE FROM dos_document_mesdossier WHERE idDossier=".$num.";";
			$co->requete ($supprLienDoc, 35);
		}			
		$compteEtab = "SELECT COUNT(*) FROM dos_etablissement_mesdossier WHERE idDossier=".$num.";";
		$co->requete ($compteEtab, 36);
		$res = $co->fetch_row(36);
		if ($res[0] > 0)
		{
			$supprLienEtab = "DELETE FROM dos_etablissement_mesdossier WHERE idDossier=".$num.";";
			$co->requete ($supprLienEtab, 37);
		}	
		$compteEven = "SELECT COUNT(*) FROM dos_evenement_mesdossier WHERE idDossier=".$num.";";
		$co->requete ($compteEven, 38);
		$res = $co->fetch_row(38);
		if ($res[0] > 0)
		{
			$supprLienEven = "DELETE FROM dos_evenement_mesdossier WHERE idDossier=".$num.";";
			$co->requete ($supprLienEven, 39);
		}
		$compteSoc = "SELECT COUNT(*) FROM dos_societe_mesdossier WHERE idDossier=".$num.";";
		$co->requete ($compteSoc, 40);
		$res = $co->fetch_row(40);
		if ($res[0] > 0)
		{
			$supprLienSoc = "DELETE FROM dos_societe_mesdossier WHERE idDossier=".$num.";";
			$co->requete ($supprLienSoc, 41);
		}
		$compteUtil = "SELECT COUNT(*) FROM dos_utilisateur_mesdossier WHERE idDossier=".$num.";";
		$co->requete ($compteUtil, 42);
		$res = $co->fetch_row (42);
		if ($res[0] > 0)
		{
			$supprLienUtil = "DELETE FROM dos_utilisateur_mesdossier WHERE idDossier=".$num.";";
			$co->requete ($supprLienUtil, 43);
		}
		$supprDossier = "DELETE FROM dos_dossier WHERE idDossier=".$num.";";
		if ($co->requete ($supprDossier, 44))
		{
			return true;
		} else 
		{
			return false;
		}
	}
	
	function supprimerEven ($co, $nom, $numEven)
	{
		$compteEven = "SELECT COUNT(*) FROM dos_evenement_mesdossier WHERE idEvenement=".$numEven.";";
		$co->requete ($compteEven, 45);
		$res = $co->fetch_row(45);
		if ($res[0] > 0)
		{
			$supprLienEven = "DELETE FROM dos_evenement_mesdossier WHERE idEvenement=".$numEven.";";
			if ($co->requete ($supprLienEven, 46))
			{
				return true;
			}
		}	
	}	
	
	function supprimerEtab ($co, $nom, $rne)
	{
		$compteEtab = 'SELECT COUNT(*) FROM dos_etablissement_mesdossier WHERE rne="'.$rne.'";';
		$co->requete ($compteEtab, 47);
		$res = $co->fetch_row(47);
		if ($res[0] > 0)
		{
			$supprLienEtab = 'DELETE FROM dos_etablissement_mesdossier WHERE rne="'.$rne.'";';
			if ($co->requete ($supprLienEtab, 48))
			{
				return true;
			}
		}	
	}
	
	function supprimerSoc ($co, $nom, $numSoc)
	{
		$compteSoc = 'SELECT COUNT(*) FROM dos_societe_mesdossier WHERE idSociete='.$numSoc.';';
		$co->requete ($compteSoc, 49);
		$res = $co->fetch_row(49);
		if ($res[0] > 0)
		{
			$supprLienSoc = 'DELETE FROM dos_societe_mesdossier WHERE idSociete='.$numSoc.';';
			if ($co->requete ($supprLienSoc, 50))
			{
				return true;
			}
		}			
	}

	// Supprime les anciens droits 
	function supprimeDroit ($co, $numDossier)
	{
		// On supprime les données liées à ce dossier, et on insère les nouvelles avec le même numéro de dossier.
		$suppr = 'DELETE FROM dos_utilisateur_mesdossier WHERE idDossier="'.$numDossier.'";';
		if ($co->requete ($suppr, 51))
		{
			return true;
		} else {
			return false;
		}		
	}
	
	// Supprime le document
	function supprimeDoc ($co, $numDoc)
	{
		$suppr = 'DELETE FROM dos_document_mesdossier WHERE idDocument = "'.$numDoc.'";';
		if ($co->requete ($suppr, 53))
		{
			$supprDoc = 'DELETE FROM dos_document WHERE idDocument = "'.$numDoc.'";';
			if ($co->requete($supprDoc,54))
			{
				return true;
			} else
			{
				return false;
			}
		}
	}	
/*************************************************************************************************************\
|*************************************************************************************************************|
|*************************************************************************************************************|
|							Fonctions de modification des données dans la base                                 |
|*************************************************************************************************************|
|*************************************************************************************************************|						
\*************************************************************************************************************/
	function modifierDossier ($co, $idDossier, $libelleDossier, $description)
	{
		$requete =	'UPDATE dos_dossier 
					SET libelleDossier="'.$libelleDossier.'",description="'.$description.'"
					WHERE idDossier="'.$idDossier.'";';
		if ($co->requete ($requete, 55))
			{
				return true;
			}
			else
			{
				return false;
			}
	}

?>
