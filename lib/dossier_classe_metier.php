<?php

	/************************************************************************************************************************************
	*	Ce fichier contient toutes les classes métiers: Utilisateur, Dossier, Categorie, Evenement, Etablissement, Société, Document.	*		
	************************************************************************************************************************************/
	
	class Utilisateur {
		
		// Attributs privés
		private $numeroUtil;
		private $prenomUtil;
		private $nomUtil;
		private $passewordUtil;
		private $mailUtil;
		private $telBureauUtil;
		private $telMobilProUtil;
		private $droitUtil;
		private $sexeUtil;
		private $posteTelBureauUtil;
		private $telPersoUtil;
		private $mobilPersoUtil;
		private $dateDerniereConnexionUtil;
		private $nbConnexionUtil;
		private $telAutreUtil;
		private $visibleUtil;
		private $mesDossier;//collection de dossier
		//static $nbUtilisateur;
		
		// Constructeurs
		public function __construct ($unPrenomUtil, $unNomUtil, $unPassewordUtil, $unMailUtil, $unTelBureauUtil, $unTelMobilProUtil, $unDroitUtil, $unSexeUtil, $unNumeroUtil, $unPosteTelBureauUtil, $unTelPersoUtil, $unMobilPersoUtil, $uneDateDerniereConnexionUtil, $unNbConnexionUtil, $unTelAutreUtil, $uneVisibleUtil)
		{
			$this->numeroUtil = $unNumeroUtil;
			$this->prenomUtil = $unPrenomUtil;
			$this->nomUtil = $unNomUtil;
			$this->passewordUtil = $unPassewordUtil;
			$this->mailUtil = $unMailUtil;
			$this->telBureauUtil = $unTelBureauUtil;
			$this->telMobilProUtil = $unTelMobilProUtil;
			$this->droitUtil = $unDroitUtil;
			$this->sexeUtil = $unSexeUtil;
			$this->posteTelBureauUtil = $unPosteTelBureauUtil;
			$this->telPersoUtil = $unTelPersoUtil;
			$this->mobilPersoUtil = $unMobilPersoUtil;
			$this->dateDerniereConnexionUtil = $uneDateDerniereConnexionUtil;
			$this->nbConnexionUtil = $unNbConnexionUtil;
			$this->telAutreUtil = $unTelAutreUtil;
			$this->visibleUtil = $uneVisibleUtil;
			//$this->nbUtilisateur++;
		}
		
		// Destructeur
		public function __destruct ()
		{
			unset($this->numeroUtil);
			unset($this->prenomUtil);
			unset($this->nomUtil);
			unset($this->passewordUtil);
			unset($this->mailUtil);
			unset($this->telBureauUtil);
			unset($this->telMobilProUtil);
			unset($this->droitUtil);
			unset($this->sexeUtil);
			unset($this->posteTelBureauUtil);
			unset($this->telPersoUtil);
			unset($this->mobilPersoUtil);
			unset($this->dateDerniereConnexionUtil);
			unset($this->nbConnexionUtil);
			unset($this->telAutreUtil);
			unset($this->visibleUtil);
			//$this->nbUtilisateur--;
		}
		
		// Accesseurs
		public function getNumeroUtil ()
		{
			return $this->numeroUtil;
		}
		public function getPrenomUtil ()
		{
			return $this->prenomUtil;
		}
		public function getNomUtil ()
		{
			return $this->nomUtil;
		}
		public function getPassewordUtil ()
		{
			return $this->passewordUtil;
		}
		public function getMailUtil ()
		{
			return $this->mailUtil;
		}
		public function getTelBureauUtil ()
		{
			return $this->telBureauUtil;
		}
		public function getTelMobilProUtil()
		{
			return $this->telMobilProUtil;
		}
		public function getDroitUtil()
		{
			return $this->droitUtil;
		}
		public function getSexeUtil()
		{
			return $this->sexeUtil;
		}
		public function getPosteTelBureauUtil ()
		{
			return $this->posteTelBureauUtil;
		}
		public function getTelPersoUtil ()
		{
			return $this->telPersoUtil;
		}
		public function getMobilPersoUtil ()
		{
			return $this->mobilPersoUtil;
		}
		public function getDateDerniereConnexionUtil ()
		{
			return $this->dateDerniereConnexionUtil;
		}
		public function getNbConnexionUtil()
		{
			return $this->nbConnexionUtil;
		}
		public function getTelAutreUtil()
		{
			return $this->telAutreUtil;
		}
		public function getVisible ()
		{
			return $this->visibleUtil;
		}
		
		public function getMesDossier()
		{
			return $this->mesDossier;
		}
		
		//public function getNbUtilisateur()
		//{
		//	return $this->nbUtilisateur;
		//}
		
	}//fin de classe utilisateur
	
	class Societe {
		
		// Attributs privés
		private $numeroSociete;
		private $nomSociete;
		private $adresseSociete;
		private $villeSociete;
		private $codePostalSociete;
		private $mailSociete;
		private $pays;
		private $mesDossier;//Collection de Dossier
		
		// Constructeurs
		public function __construct ($unNumeroSociete, $unNomSociete, $uneAdresseSociete, $unCodePostalSociete, $uneVilleSociete, $unMailSociete, $unPays) 
		{
			$this->numeroSociete = $unNumeroSociete;
			$this->nomSociete = $unNomSociete;
			$this->adresseSociete = $uneAdresseSociete;
			$this->villeSociete = $uneVilleSociete;
			$this->codePostalSociete = $unCodePostalSociete;
			$this->mailSociete = $unMailSociete;
			$this->pays = $unPays;
		}
		
		// Destructeur
		public function __destruct () 
		{
			unset($this->numeroSociete);
			unset($this->nomSociete);
			unset($this->adresseSociete);
			unset($this->villeSociete);
			unset($this->codePostalSociete);
			unset($this->mailSociete);
			unset($this->pays);
		}
		
		// Accesseurs
		public function getNumeroSociete () 
		{
			return $this->numeroSociete;
		}
		public function getNomSociete () 
		{
			return $this->nomSociete;
		}
		public function getAdresseSociete () 
		{
			return $this->adresseSociete;
		}
		public function getVilleSociete () 
		{
			return $this->villeSociete;
		}
		public function getCodePostalSociete () 
		{
			return $this->codePostalSociete;
		}
		public function getMailSociete () 
		{
			return $this->mailSociete;
		}
		public function getPays ()
		{
			return $this->pays;
		}
		public function getMesDossier()
		{
			return $this->mesDossier;
		}
	}//fin de classe societe
	
	class Document {
	
		// Attributs privés
		private $numeroDocument;
		private $libelleDocument;
		private $nomFichier;
		private $module;
		private $description;
		private $maCategorie;// la categorie d'appartenance au document
		private $mesDossier;//collection de Dossier
		
		// Constructeurs
		public function __construct ($unNumeroDoc, $unLibelleDoc,$unNomFichier, $unModule, $uneDescription, $uneCategorie) 
		{
			$this->numeroDocument = $unNumeroDoc;
			$this->libelleDocument = $unLibelleDoc;
			$this->nomFichier = $unNomFichier;
			$this->module = $unModule;
			$this->description = $uneDescription;
			$this->maCategorie = $uneCategorie;
		}
		
		// Destructeur
		public function __destruct () 
		{
			unset($this->numeroDocument);
			unset($this->libelleDocument);
			unset($this->nomFichier);
			unset($this->module);
			unset($this->description);
			unset($this->maCategorie);
		}
		
		// Accesseurs
		public function getNumeroDocument () 
		{
			return $this->numeroDocument;
		}
		public function getNomDocument () 
		{
			return $this->libelleDocument;
		}
		public function getNomFichier ()
		{
			return $this->nomFichier;
		}
		public function getModuleDocument () 
		{
			return $this->module;
		}
		public function getDescriptionDocument () 
		{
			return $this->description;
		}
		public function getCategorieDocument () 
		{
			return $this->maCategorie;
		}
		public function getMesDossier()
		{
			return $this->mesDossier;
		}
	}//fin de classe document
	
	class Categorie {
	
		// Attributs privés
		private $numeroCategorie;
		private $libelleCategorie;
		
		// Constructeurs
		public function __construct ($unNumeroCategorie, $unLibelleCategorie) 
		{
			$this->numeroDocument = $unNumeroCategorie;
			$this->libelleDocument = $unLibelleCategorie;
		}
		
		// Destructeur
		public function __destruct () 
		{
			unset($this->numeroDocument);
			unset($this->libelleDocument);
		}
		
		// Accesseurs
		public function getNumeroCategorie () 
		{
			return $this->numeroCategorie;
		}
		public function getLibelleCategorie () 
		{
			return $this->libelleCategorie;
		}
	}//fin de classe categorie
	
	class Etablissement {
	
		// Attributs privés
		private $RNE;
		private $typeEtab;
		private $pubPri;
		private $nomEtab;
		private $adresseEtab;
		private $villeEtab;
		private $codePostalEtab;
		private $telEtab;
		private $mailEtab;
		private $circonscriptionEtab;
		private $nbPbEtab;
		private $typeEtabGen;
		private $faxEtab;
		private $internetEtab;

		private $mesDossier;//collection de Dossier
		
		
		
		
		// Constructeurs
		public function __construct ($unRNE, $unTypeEtab, $unPubPri, $unNomEtab, $uneAdresseEtab, $uneVilleEtab, $unCodePostalEtab, $unTelEtab, $unMailEtab, $uneCirconscriptionEtab, $unNbPb, $unTypeEtabGen, $unFaxEtab, $unInternet) 
		{
			$this->RNE = $unRNE;
			$this->typeEtab = $unTypeEtab;
			$this->pubPri = $unPubPri;
			$this->nomEtab = $unNomEtab;
			$this->adresseEtab = $uneAdresseEtab;
			$this->villeEtab = $uneVilleEtab;
			$this->codePostalEtab = $unCodePostalEtab;
			$this->telEtab = $unTelEtab;
			$this->mailEtab = $unMailEtab;
			$this->circonscriptionEtab = $uneCirconscriptionEtab;
			$this->nbPbEtab = $unNbPb;
			$this->internetEtab = $unInternet;
			$this->faxEtab = $unFaxEtab;
			$this->typeEtabGen = $unTypeEtabGen;
		}
		
		// Destructeur
		public function __destruct () 
		{
			unset($this->RNE);
			unset($this->typeEtab);
			unset($this->pubPri);
			unset($this->nomEtab);
			unset($this->adresseEtab);
			unset($this->villeEtab);
			unset($this->codePostalEtab);
			unset($this->telEtab);
			unset($this->mailEtab);
			unset($this->circonscriptionEtab);
			unset($this->nbPbEtab);
			unset($this->internetEtab);
			unset($this->faxEtab);
			unset($this->typeEtabGen);
		}
		
		// Accesseurs
		public function getRNE () 
		{
			return $this->RNE;
		}
		public function getTypeEtab () 
		{
			return $this->typeEtab;
		}
		public function getPubPriEtab () 
		{
			return $this->pubPri;
		}
		public function getNomEtab () 
		{
			return $this->nomEtab;
		}
		public function getAdresseEtab () 
		{
			return $this->adresseEtab;
		}
		public function getVilleEtab () 
		{
			return $this->villeEtab;
		}
		public function getCodePostalEtab () 
		{
			return $this->codePostalEtab;
		}
		public function getTelEtab () 
		{
			return $this->telEtab;
		}
		public function getMailEtab () 
		{
			return $this->mailEtab;
		}
		public function getCirconscriptionEtab () 
		{
			return $this->circonscriptionEtab;
		}
		public function getNbPbEtab () 
		{
			return $this->nbPbEtab;
		}
		public function getInternetEtab () 
		{
			return $this->internetEtab;
		}
		public function getFaxEtab () 
		{
			return $this->faxEtab;
		}
		public function getTypeEtabGen ()
		{
			return $this->typeEtabGen;
		}
		public function getMesDossier()
		{
			return $this->mesDossier;
		}
	}//fin de classe etablissement	
	
	class Dossier {
		
		// Attributs privés
		private $numeroDossier;
		private $libelleDossier;
		private $descriptionDossier;
		private $mesUtilisateur;
		private $mesDocument;		//collection de Document
		private $mesEvenement;		//collection d'evenement
		private $mesEtablissment;	//collection d'Etablissement
		private $mesSociete;		//collection de societe
		
		// Constructeur
		public function __construct ($unNumeroDossier, $unLibelleDossier, $uneDescriptionDossier) 
		{
			$this->numeroDossier = $unNumeroDossier;
			$this->libelleDossier = $unLibelleDossier;
			$this->descriptionDossier = $uneDescriptionDossier;
		}

		// Destructeur
		public function __destruct ()
		{
			unset($this->numeroDossier);
			unset($this->libelleDossier);
			unset($this->descriptionDossier);
		}		
		// Accesseurs
		public function getNumeroDossier () 
		{
			return $this->numeroDossier;
		}
		public function getLibelleDossier () 
		{
			return $this->libelleDossier;
		}
		public function getDescriptionDossier () 
		{
			return $this->descriptionDossier;
		}
		public function getMesUtilisateur()
		{
			return $this->mesUtilisateur;
		}
		public function getMesDocument()
		{
			return $this->mesDocument;
		}
		public function getMesEvenement()
		{
			return $this->mesEvenement;
		}
		public function getMesEtablissement()
		{
			return $this->mesEtablissement;
		}
		public function getMesSociete()
		{
			return $this->mesSociete;
		}
	}//fin de classe dossier
	
	class Evenement {
			
		// Attributs privés
		private $numeroEvenement;
		private $libelleEvenement;
		private $dateEvenement;
		private $horaireEvenement;
		private $lieuEvenement;
		private $remarquesEvenement;
		private $mesDossier;//collection de Dossier
		
		// Constructeurs
		public function __construct ($unNumeroEvenement, $unLibelleEvenement, $uneDateEvenement, $unHoraireEvenement, $unLieuEvenement, $RemarquesEvenement) 
		{
			$this->numeroEvenement = $unNumeroEvenement;
			$this->libelleEvenement = $unLibelleEvenement;
			$this->dateEvenement = $uneDateEvenement;
			$this->horaireEvenement = $unHoraireEvenement;
			$this->lieuEvenement = $unLieuEvenement;
			$this->remarquesEvenement = $RemarquesEvenement;
		}

		// Destructeur
		public function __destruct () 
		{
			unset($this->numeroEvenement);
			unset($this->libelleEvenement);
			unset($this->dateEvenement);
			unset($this->horaireEvenement);
			unset($this->lieuEvenement);
			unset($this->remarquesEvenement);
		}
		
		// Accesseurs
		public function getNumeroEvenement () 
		{
			return $this->numeroEvenement;
		}
		public function getLibelleEvenement () 
		{
			return $this->libelleEvenement;
		}
		public function getDateEvenement () 
		{
			return $this->dateEvenement;
		}
		public function getHoraireEvenement () 
		{
			return $this->horaireEvenement;
		}
		public function getLieuEvenement () 
		{
			return $this->lieuEvenement;
		}
		public function getRemarquesEvenement () 
		{
			return $this->remarquesEvenement;
		}
		public function getMesDossier()
		{
			return $this->mesDossier;
		}
	}//fin de classe evenement

?>
