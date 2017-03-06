<?php

	/************************************************************************************************	
	*	Classe Passerelle																			*
	*																								*
	*	Permet de récupérer les données fournies par les requêtes (à l'aide de la la classe Mysql), *
	*	et de les instancier dans des objets ou collections d'objets.								*		
	************************************************************************************************/

	//include ("dossier_mysql.php");
	//include ("dossier_collection.php");
	include ("dossier_classe_metier.php");

	class Passerelle 
	{
		
		// Attribut privé
		private $objMysql; // Objet de la classe mysql.
		
		// Constructeur (avec connexion à la base de données Mysql)
		public function __construct ($connexion)
		{
			$this->objMysql = $connexion;
		}
		
		// Destructeur de la classe
		public function __destruct ()
		{
			$this->objMysql->deconnect();
		}
		
		// Permet de récupérer la connexion.
		public function obtenirConnexion () {
			return $this->objMysql;
		}
		
/*************************************************************************************************************\
|*************************************************************************************************************|
|*************************************************************************************************************|
|							fonction de récuperation des données pour affichage                               |
|*************************************************************************************************************|
|*************************************************************************************************************|						
\*************************************************************************************************************/



/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction dossierCharger....
|				
|			
\**************************************************************************************************************/			
			
		// Méthodes (NOTATION : classe où l'on travaille, ce que l'on fait, ce que l'on veut)
		public function dossierChargerSociete ($numeroDossier)
		{
			$collect = new Collection ();
			$requete =	"SELECT No_societe, societe, adresse, cp, ville, email, pays
						FROM repertoire, dos_societe_mesdossier
						WHERE repertoire.no_societe = dos_societe_mesdossier.idSociete
						AND idDossier =".$numeroDossier.";";
			$this->objMysql->requete ($requete, 100);
			while ($ligne=$this->objMysql->fetch_row(100)) {
				$collect->add(new Societe($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6]));
			}
			return $collect;
		}
		
		public function dossierChargerEtablissement ($numeroDossier)
		{
			$collect = new Collection ();
			$requete =	"SELECT etablissements.RNE,	TYPE , PUBPRI, NOM, ADRESSE, VILLE, CODE_POSTAL, TEL, MAIL, CIRCONSCRIPTION, NB_PB, TYPE_ETAB_GEN, FAX, INTERNET
						FROM etablissements, dos_etablissement_mesdossier
						WHERE etablissements.rne = dos_etablissement_mesdossier.rne
						AND idDossier =".$numeroDossier.";";
			$this->objMysql->requete ($requete, 101);
			while ($ligne=$this->objMysql->fetch_row(101)) {
				$collect->add(new Etablissement($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13]));
			}
			return $collect;
		}
		
		public function dossierChargerUtilisateur ($numeroDossier)
		{
			$collect = new Collection ();
			$requete =	'SELECT PRENOM, NOM, PASSWORD,util.MAIL, TEL_BUREAU, MOBILE_PRO, util.DROIT, SEXE, ID_UTIL, POSTE_TEL_BUREAU,	TEL_PERSO,	MOBILE_PERSO, DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS, TEL_AUTRE, visible
						FROM util, dos_utilisateur_mesdossier
						WHERE util.id_util = dos_utilisateur_mesdossier.idUtil
						AND idDossier = '.$numeroDossier.';';
			$this->objMysql->requete ($requete, 102);
			while ($ligne=$this->objMysql->fetch_row(102)) {
				$collect->add(new Utilisateur($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13], $ligne[14], $ligne[15]));
			}
			return $collect;
		}
		
		public function dossierChargerEvenement ($numeroDossier)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_evenement.idEvenement, libelleEvenement, dateEvenement, horaireEvenement, lieuEvenement, remarquesEvenement
						FROM dos_evenement, dos_evenement_mesdossier
						WHERE dos_evenement.idEvenement = dos_evenement_mesdossier.idevenement
						AND idDossier =".$numeroDossier.";";
			$this->objMysql->requete ($requete, 103);
			while ($ligne=$this->objMysql->fetch_row(103)) {
				$collect->add(new Evenement($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}
		
		public function dossierChargerDocument ($numeroDossier)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_document.idDocument, libelleDocument, nomFichier, module, description, libelleCategorie
						FROM dos_document, dos_document_mesdossier, dos_categorie_document
						WHERE dos_document.idDocument = dos_document_mesdossier.idDocument
						AND dos_document.maCategorie = dos_categorie_document.idCategorie
						AND idDossier = ".$numeroDossier.";";
			$this->objMysql->requete ($requete, 104);
			while ($ligne=$this->objMysql->fetch_row(104)) {
				$collect->add(new Document($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}
		
		
		
/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction documentCharger....
|				
|			
\**************************************************************************************************************/
		
		public function documentChargerDossier ($numeroDocument)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_dossier.idDossier, libelleDossier, description
						FROM dos_dossier, dos_document_mesdossier
						WHERE dos_dossier.idDossier = dos_document_mesdossier.idDossier
						AND idDocument = ".$numeroDocument.";";
			$this->objMysql->requete ($requete, 105);
			while ($ligne=$this->objMysql->fetch_row(105)) {
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}
		
		public function documentChargerUtilisateur ($numeroDocument)
		{
			$collect = new Collection ();
			$requete =	"SELECT PRENOM, NOM,PASSWORD , util.MAIL, TEL_BUREAU, MOBILE_PRO, util.DROIT, SEXE, ID_UTIL, POSTE_TEL_BUREAU, TEL_PERSO, MOBILE_PERSO, DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS, TEL_AUTRE, visible
						FROM util, dos_utilisateur_mesdossier, dos_document_mesdossier
						WHERE util.id_util = dos_utilisateur_mesdossier.idUtil
						AND dos_utilisateur_mesdossier.idDossier = dos_document_mesdossier.idDossier
						AND idDocument =".$numeroDocument.";";
			$this->objMysql->requete ($requete, 106);
			while ($ligne=$this->objMysql->fetch_row(106)) {
				$collect->add(new Utilisateur($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13], $ligne[14], $ligne[15]));
			}
			return $collect;
		}

		public function documentChargerSociete ($numeroDocument)
		{
			$collect = new Collection ();
			$requete =	"SELECT No_societe, societe, adresse, cp, ville, email, pays
						FROM repertoire, dos_societe_mesdossier, dos_document_mesdossier, dos_document
						WHERE repertoire.no_societe = dos_societe_mesdossier.idsociete
						AND dos_societe_mesdossier.idDossier = dos_document_mesdossier.idDossier
						and dos_document_mesdossier.idDocument=dos_document.idDocument
						AND dos_document.idDocument =".$numeroDocument.";";
			$this->objMysql->requete ($requete, 107);
			while ($ligne=$this->objMysql->fetch_row(107)) {
				$collect->add(new Societe($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6]));
			}
			return $collect;
		}
		
		public function documentChargerEtablissement ($numeroDocument)
		{
			$collect = new Collection ();
			$requete =	"SELECT etablissements.RNE, TYPE , PUBPRI, NOM, ADRESSE, VILLE, CODE_POSTAL, TEL, etablissements.MAIL, CIRCONSCRIPTION, NB_PB, TYPE_ETAB_GEN, FAX, INTERNET
						FROM etablissements, dos_etablissement_mesdossier, dos_document_mesdossier, dos_document
						WHERE etablissements.rne = dos_etablissement_mesdossier.rne
						AND dos_etablissement_mesdossier.idDossier = dos_document_mesdossier.idDossier
						AND dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_document.idDocument =".$numeroDocument.";";
			$this->objMysql->requete ($requete, 108);
			while ($ligne=$this->objMysql->fetch_row(108)) {
				$collect->add(new Etablissement($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13]));
			}
			return $collect;
		}
		
		public function documentChargerEvenement ($numeroDocument)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_evenement.idevenement, libelleevenement, dateevenement, sujetevenement
						FROM dos_evenement, dos_evenement_mesdossier, dos_document_mesdossier, dos_document
						WHERE dos_evenement.idEvenement = dos_evenement_mesdossier.idevenement
						AND dos_evenement_mesdossier.idDossier = dos_document_mesdossier.idDossier
						AND dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_document.idDocument =".$numeroDocument.";";
			$this->objMysql->requete ($requete, 109);
			while ($ligne=$this->objMysql->fetch_row(109)) {
				$collect->add(new Evenement($ligne[0], $ligne[1], $ligne[2], $ligne[3]));
			}
			return $collect;
		}
		
		
/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction societeCharger....
|				
|			
\**************************************************************************************************************/
		
		public function societeChargerDossier ($numeroSociete)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_dossier.idDossier, libelleDossier, description
						FROM dos_dossier, dos_societe_mesdossier
						WHERE dos_dossier.idDossier = dos_societe_mesdossier.idDossier
						AND dos_societe_mesdossier.idSociete =".$numeroSociete.";";
			$this->objMysql->requete ($requete, 110);
			while ($ligne=$this->objMysql->fetch_row(110)) {
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}
		public function societeChargerDocument ($numeroSociete)
		{
			$collect = new Collection ();
			$requete =	"SELECT DISTINCT (dos_document.idDocument), libelleDocument, nomFichier, module, description, libelleCategorie
						FROM repertoire, dos_societe_mesdossier, dos_document_mesdossier, dos_document, dos_categorie_document
						WHERE dos_societe_mesdossier.idSociete = repertoire.no_societe
						AND dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_societe_mesdossier.idDossier = dos_document_mesdossier.idDossier
						AND dos_document.maCategorie = dos_categorie_document.idCategorie
						AND repertoire.no_societe =".$numeroSociete.";";
			$this->objMysql->requete ($requete, 111);
			while ($ligne=$this->objMysql->fetch_row(111)) {
				$collect->add(new Document($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}

		
/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction utilisateurCharger....
|				
|			
\**************************************************************************************************************/		
		
		public function utilisateurChargerDossier ($numeroUtilisateur, $droit=0)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_dossier.idDossier, libelleDossier, description
						FROM dos_dossier, dos_utilisateur_mesdossier
						WHERE dos_dossier.idDossier = dos_utilisateur_mesdossier.idDossier
						AND dos_utilisateur_mesdossier.idUtil =".$numeroUtilisateur."
						AND droit >= ".$droit.";";
			$this->objMysql->requete ($requete, 112);
			while ($ligne=$this->objMysql->fetch_row(112)) {
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}
		
		public function utilisateurChargerDocument ($numeroUtilisateur)
		{
			$collect = new Collection ();
			$requete =	"SELECT distinct(dos_document.idDocument), libelleDocument, nomFichier, module, description, libelleCategorie
						FROM util, dos_utilisateur_mesdossier, dos_document_mesdossier, dos_document, dos_categorie_document
						WHERE dos_utilisateur_mesdossier.idUtil = util.id_util
						and dos_utilisateur_mesdossier.idDossier = dos_document_mesdossier.idDossier
						and dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_document.maCategorie = dos_categorie_document.idCategorie
						AND util.id_util =".$numeroUtilisateur.";";
			$this->objMysql->requete ($requete, 113);
			while ($ligne=$this->objMysql->fetch_row(113)) {
				$collect->add(new Document($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}		
		
		public function utilisateurChargerEvenement ($numeroUtilisateur)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_evenement.idevenement, libelleevenement, dateevenement, sujetevenement
						FROM util, dos_utilisateur_mesdossier, dos_evenement_mesdossier, dos_evenement
						WHERE dos_utilisateur_mesdossier.idUtil = util.id_util
						and dos_utilisateur_mesdossier.idDossier =dos_evenement_mesdossier.iddossier
						AND dos_evenement_mesdossier.idEvenement = dos_evenement.idEvenement
						AND dos_utilisateur_mesdossier.idUtil =".$numeroUtilisateur.";";
			$this->objMysql->requete ($requete, 114);
			while ($ligne=$this->objMysql->fetch_row(114)) {
				$collect->add(new Evenement($ligne[0], $ligne[1], $ligne[2], $ligne[3]));
			}
			return $collect;
		}	
	

	
/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction evenementCharger....
|				
|			
\**************************************************************************************************************/		
		
		public function evenementChargerDossier ($numeroEvenement)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_dossier.idDossier, libelleDossier, description
						FROM  dos_evenement_mesdossier,  dos_dossier
						WHERE dos_evenement_mesdossier.idDossier = dos_dossier.idDossier
						AND dos_evenement_mesdossier.idevenement =".$numeroUtilisateur.";";
			$this->objMysql->requete ($requete, 115);
			while ($ligne=$this->objMysql->fetch_row(115)) {
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}
		
		public function evenementChargerDocument ($numeroEvenement)
		{
			$collect = new Collection ();
			$requete =	"SELECT DISTINCT (dos_document.idDocument), libelleDocument, nomFichier, module, description, libelleCategorie
						FROM dos_evenement, dos_evenement_mesdossier, dos_document_mesdossier, dos_document, dos_categorie_document
						WHERE dos_evenement_mesdossier.idDossier = dos_document_mesdossier.idDossier
						AND dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_document.maCategorie = dos_categorie_document.idCategorie
						AND dos_evenement_mesdossier.idEvenement =".$numeroEvenement.";";
			$this->objMysql->requete ($requete, 116);
			while ($ligne=$this->objMysql->fetch_row(116)) {
				$collect->add(new Document($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}
		
		public function evenementChargerUtilisateur($numeroEvenement)
		{
			$collect = new Collection ();
			$requete =	"SELECT PRENOM, NOM, PASSWORD , util.MAIL, TEL_BUREAU, MOBILE_PRO, util.DROIT, SEXE, ID_UTIL, POSTE_TEL_BUREAU, TEL_PERSO, MOBILE_PERSO, DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS, TEL_AUTRE, visible
						FROM util, dos_utilisateur_mesdossier, dos_evenement_mesdossier
						WHERE util.id_util = dos_utilisateur_mesdossier.idUtil
						AND dos_utilisateur_mesdossier.idDossier = dos_evenement_mesdossier.idDossier
						AND idEvenement =".$numeroEvenement.";";
			$this->objMysql->requete ($requete, 117);
			while ($ligne=$this->objMysql->fetch_row(117)) {
				$collect->add(new Utilisateur($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13], $ligne[14], $ligne[15]));
			}
			return $collect;
		}
		
/**************************************************************************************************************\
|**************************************************************************************************************
|
|											fonction etablissementCharger....
|				
|			
\**************************************************************************************************************/		
		
		public function etablissementChargerDossier ($RNE)
		{
			$collect = new Collection ();
			$requete =	"SELECT dos_dossier.idDossier, libelleDossier, description
						FROM dos_dossier, dos_etablissement_mesdossier
						WHERE dos_dossier.idDossier = dos_etablissement_mesdossier.idDossier
						AND dos_etablissement_mesdossier.rne ='".$RNE."';";
			$this->objMysql->requete ($requete, 118);
			while ($ligne=$this->objMysql->fetch_row(118)) {
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}
		
		public function etablissementChargerDocument ($RNE)
		{
			$collect = new Collection ();
			$requete =	"SELECT distinct(dos_document.idDocument), libelleDocument, nomFichier, module, description, libelleCategorie
						FROM etablissements, dos_etablissement_mesdossier, dos_document_mesdossier, dos_document, dos_categorie_document
						WHERE dos_etablissement_mesdossier.rne = etablissements.rne
						AND dos_etablissement_mesdossier.idDossier= dos_document_mesdossier.idDossier
						AND dos_document.maCategorie = dos_categorie_document.idCategorie
						AND dos_document_mesdossier.idDocument = dos_document.idDocument
						AND dos_etablissement_mesdossier.rne ='".$RNE."';";
			$this->objMysql->requete ($requete, 119);
			while ($ligne=$this->objMysql->fetch_row(119)) {
				$collect->add(new Document($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5]));
			}
			return $collect;
		}
		
/*************************************************************************************************************\
|*************************************************************************************************************|
|*************************************************************************************************************|
|							FIN fonction de récuperation des données pour affichage                           |
|*************************************************************************************************************|
|*************************************************************************************************************|						
\*************************************************************************************************************/

		public function chargerUtilisateur ()
		{
			$collect = new Collection ();
			$requete = "SELECT PRENOM, NOM, PASSWORD , util.MAIL, TEL_BUREAU, MOBILE_PRO, util.DROIT, SEXE, ID_UTIL, POSTE_TEL_BUREAU, TEL_PERSO, MOBILE_PERSO, DATE_DERNIERE_CONNEXION, NOMBRE_CONNEXIONS, TEL_AUTRE, visible
						FROM util WHERE visible = 'O' ORDER BY NOM";
			$this->objMysql->requete ($requete, 120);
			while ($ligne=$this->objMysql->fetch_row(120))
			{
				$collect->add(new Utilisateur($ligne[0], $ligne[1], $ligne[2], $ligne[3], $ligne[4], $ligne[5], $ligne[6], $ligne[7], $ligne[8], $ligne[9], $ligne[10], $ligne[11], $ligne[12], $ligne[13], $ligne[14], $ligne[15]));
			}
			return $collect;
		}

		public function chargerDossier ()
		{
			$collect = new Collection ();
			$requete = "SELECT *
						FROM dos_dossier ORDER BY libelleDossier";
			$this->objMysql->requete ($requete, 121);
			while ($ligne=$this->objMysql->fetch_row(121))
			{
				$collect->add(new Dossier($ligne[0], $ligne[1], $ligne[2]));
			}
			return $collect;
		}

}
	
?>
