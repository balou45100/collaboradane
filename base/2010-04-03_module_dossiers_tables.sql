-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Sam 03 Avril 2010 à 19:12
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `collaboratice-test`
--

-- --------------------------------------------------------

--
-- Structure de la table `dos_categorie_document`
--

DROP TABLE IF EXISTS `dos_categorie_document`;
CREATE TABLE IF NOT EXISTS `dos_categorie_document` (
  `idCategorie` int(5) NOT NULL auto_increment,
  `libelleCategorie` char(50) NOT NULL,
  PRIMARY KEY  (`idCategorie`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `dos_categorie_document`
--

INSERT INTO `dos_categorie_document` (`idCategorie`, `libelleCategorie`) VALUES
(1, 'Texte'),
(2, 'Image'),
(3, 'Présentation'),
(4, 'Archives compressées'),
(5, 'Tableur');

-- --------------------------------------------------------

--
-- Structure de la table `dos_document`
--

DROP TABLE IF EXISTS `dos_document`;
CREATE TABLE IF NOT EXISTS `dos_document` (
  `idDocument` int(10) NOT NULL auto_increment,
  `libelleDocument` char(100) NOT NULL,
  `nomFichier` varchar(150) NOT NULL,
  `module` char(20) NOT NULL,
  `description` char(255) NOT NULL,
  `maCategorie` int(5) default NULL,
  PRIMARY KEY  (`idDocument`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `dos_document`
--

INSERT INTO `dos_document` (`idDocument`, `libelleDocument`, `nomFichier`, `module`, `description`, `maCategorie`) VALUES
(11, 'fichier-excell', 'ent.xls', '', '', 5),
(10, 'fichie-texte', 'ent.txt', '', '', 1),
(12, 'test', 'voeux_2010.jpg', 'test', 'test', 2);

-- --------------------------------------------------------

--
-- Structure de la table `dos_document_mesdossier`
--

DROP TABLE IF EXISTS `dos_document_mesdossier`;
CREATE TABLE IF NOT EXISTS `dos_document_mesdossier` (
  `idDocument` int(10) NOT NULL,
  `idDossier` int(5) NOT NULL,
  PRIMARY KEY  (`idDocument`,`idDossier`),
  KEY `idDocument` (`idDocument`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dos_document_mesdossier`
--

INSERT INTO `dos_document_mesdossier` (`idDocument`, `idDossier`) VALUES
(10, 58),
(11, 58),
(12, 54);

-- --------------------------------------------------------

--
-- Structure de la table `dos_dossier`
--

DROP TABLE IF EXISTS `dos_dossier`;
CREATE TABLE IF NOT EXISTS `dos_dossier` (
  `idDossier` int(5) NOT NULL auto_increment,
  `libelleDossier` char(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY  (`idDossier`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Contenu de la table `dos_dossier`
--

INSERT INTO `dos_dossier` (`idDossier`, `libelleDossier`, `description`) VALUES
(54, 'ENT', 'Mise en place de l'' environnement Numérique de Travail'),
(55, 'RTICE 2010', 'Rencontres TICE 2010'),
(58, 'Test de dossier', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `dos_etablissement_mesdossier`
--

DROP TABLE IF EXISTS `dos_etablissement_mesdossier`;
CREATE TABLE IF NOT EXISTS `dos_etablissement_mesdossier` (
  `RNE` char(8) NOT NULL,
  `idDossier` int(5) NOT NULL,
  PRIMARY KEY  (`RNE`,`idDossier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dos_etablissement_mesdossier`
--

INSERT INTO `dos_etablissement_mesdossier` (`RNE`, `idDossier`) VALUES
('0180002E', 54),
('0450080T', 55);

-- --------------------------------------------------------

--
-- Structure de la table `dos_evenement`
--

DROP TABLE IF EXISTS `dos_evenement`;
CREATE TABLE IF NOT EXISTS `dos_evenement` (
  `idEvenement` int(5) NOT NULL auto_increment,
  `libelleEvenement` char(50) NOT NULL,
  `dateEvenement` date NOT NULL,
  `SujetEvenement` char(50) NOT NULL,
  PRIMARY KEY  (`idEvenement`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `dos_evenement`
--

INSERT INTO `dos_evenement` (`idEvenement`, `libelleEvenement`, `dateEvenement`, `SujetEvenement`) VALUES
(1, 'Réunion groupe technique', '2010-03-25', 'Les Ressources numériques'),
(2, 'Rencontres TICE 2010', '2010-10-20', 'Rencontres TICE 2010'),
(3, 'Réunion fin projet', '2010-03-08', 'bilan'),
(4, 'Réunion mise au point', '2010-04-03', 'Bilan après 1 mois'),
(5, 'Réunion fin projet', '2010-03-26', 'bilan');

-- --------------------------------------------------------

--
-- Structure de la table `dos_evenement_mesdossier`
--

DROP TABLE IF EXISTS `dos_evenement_mesdossier`;
CREATE TABLE IF NOT EXISTS `dos_evenement_mesdossier` (
  `idEvenement` int(5) NOT NULL,
  `idDossier` int(5) NOT NULL,
  PRIMARY KEY  (`idEvenement`,`idDossier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dos_evenement_mesdossier`
--

INSERT INTO `dos_evenement_mesdossier` (`idEvenement`, `idDossier`) VALUES
(1, 54),
(2, 55),
(4, 54),
(5, 54);

-- --------------------------------------------------------

--
-- Structure de la table `dos_societe_mesdossier`
--

DROP TABLE IF EXISTS `dos_societe_mesdossier`;
CREATE TABLE IF NOT EXISTS `dos_societe_mesdossier` (
  `idSociete` int(11) NOT NULL,
  `idDossier` int(5) NOT NULL,
  PRIMARY KEY  (`idSociete`,`idDossier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dos_societe_mesdossier`
--

INSERT INTO `dos_societe_mesdossier` (`idSociete`, `idDossier`) VALUES
(87, 54),
(159, 55),
(215, 54),
(341, 54);

-- --------------------------------------------------------

--
-- Structure de la table `dos_utilisateur_mesdossier`
--

DROP TABLE IF EXISTS `dos_utilisateur_mesdossier`;
CREATE TABLE IF NOT EXISTS `dos_utilisateur_mesdossier` (
  `idUtil` int(5) NOT NULL,
  `idDossier` int(5) NOT NULL,
  `droit` tinyint(1) NOT NULL,
  PRIMARY KEY  (`idUtil`,`idDossier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dos_utilisateur_mesdossier`
--

INSERT INTO `dos_utilisateur_mesdossier` (`idUtil`, `idDossier`, `droit`) VALUES
(31, 54, 2),
(9, 54, 1),
(1, 54, 2),
(1, 55, 2),
(3, 55, 1),
(4, 55, 1),
(5, 55, 2),
(6, 55, 1),
(9, 55, 2),
(10, 55, 1),
(15, 55, 1),
(20, 55, 1),
(23, 55, 1),
(29, 55, 1),
(30, 55, 1),
(31, 56, 2),
(32, 56, 1),
(31, 57, 2),
(1, 58, 2),
(31, 58, 2),
(32, 58, 2),
(32, 54, 2);
