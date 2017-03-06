-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 22 Juin 2011 à 12:30
-- Version du serveur: 5.1.33
-- Version de PHP: 5.2.9-2

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
-- Structure de la table `categorie_personnelle_ticket`
--

-- --------------------------------------------------------

--
-- Structure de la table `om_etat_frais`
--

CREATE TABLE IF NOT EXISTS `om_etat_frais` (
  `RefEF` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RefOM` int(10) unsigned NOT NULL,
  PRIMARY KEY (`RefEF`),
  KEY `om_etat_frais_FKIndex1` (`RefOM`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `om_etat_frais`
--

INSERT INTO `om_etat_frais` (`RefEF`, `RefOM`) VALUES
(7, 10),
(6, 12);

-- --------------------------------------------------------

--
-- Structure de la table `om_lieu`
--

CREATE TABLE IF NOT EXISTS `om_lieu` (
  `idlieu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_2` varchar(10) DEFAULT NULL,
  `intitule_lieu` varchar(100) DEFAULT NULL,
  `adresse1` varchar(100) DEFAULT NULL,
  `adresse2` varchar(100) DEFAULT NULL,
  `cp` varchar(15) DEFAULT NULL,
  `ville` varchar(25) DEFAULT NULL,
  `pays` varchar(25) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `mel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idlieu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `om_lieu`
--

INSERT INTO `om_lieu` (`idlieu`, `type_2`, `intitule_lieu`, `adresse1`, `adresse2`, `cp`, `ville`, `pays`, `tel`, `mel`) VALUES
(1, 'société', 'Groupama', '2 rue des cerises', '', '45000', 'Orléans', 'France', '0203040506', 'Groupama@ac-orleans-tours.fr'),
(2, 'etablissem', 'Lycée Voltaire', '6 rue des Candides', NULL, '45000', 'Orléans', 'France', '0204060800', 'LycéeVoltaire@ac-orleans-tours.fr');

-- --------------------------------------------------------

--
-- Structure de la table `om_ordres_mission`
--

CREATE TABLE IF NOT EXISTS `om_ordres_mission` (
  `RefOM` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pers_ress` int(10) unsigned NOT NULL,
  `idreunion` int(10) unsigned NOT NULL,
  `etat_traite` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`RefOM`),
  KEY `om_ordres_mission_FKIndex1` (`idreunion`),
  KEY `om_ordres_mission_FKIndex2` (`id_pers_ress`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `om_ordres_mission`
--

INSERT INTO `om_ordres_mission` (`RefOM`, `id_pers_ress`, `idreunion`, `etat_traite`) VALUES
(10, 6446, 1, 0),
(11, 6445, 2, 0),
(12, 6444, 2, 0),
(15, 6444, 1, 0),
(16, 6447, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `om_relance`
--

CREATE TABLE IF NOT EXISTS `om_relance` (
  `id_relance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RefOM` int(10) unsigned NOT NULL,
  `date_relance` date DEFAULT NULL,
  PRIMARY KEY (`id_relance`),
  KEY `om_relance_FKIndex1` (`RefOM`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `om_relance`
--

INSERT INTO `om_relance` (`id_relance`, `RefOM`, `date_relance`) VALUES
(1, 15, '2011-05-31'),
(2, 10, '2011-06-06');

-- --------------------------------------------------------

--
-- Structure de la table `om_reunion`
--

CREATE TABLE IF NOT EXISTS `om_reunion` (
  `idreunion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idsalle` int(10) unsigned NOT NULL,
  `intitule_reunion` varchar(150) DEFAULT NULL,
  `date_horaire_debut` datetime DEFAULT NULL,
  `date_horaire_fin` datetime DEFAULT NULL,
  `etat_reunion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idreunion`),
  KEY `om_reunion_FKIndex1` (`idsalle`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `om_reunion`
--

INSERT INTO `om_reunion` (`idreunion`, `idsalle`, `intitule_reunion`, `date_horaire_debut`, `date_horaire_fin`, `etat_reunion`) VALUES
(1, 6, 'TICE', '2011-06-14 08:00:00', '2011-06-15 12:00:00', 0),
(2, 2, 'Ormes', '2011-08-28 09:00:00', '2011-08-28 16:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `om_salle`
--

CREATE TABLE IF NOT EXISTS `om_salle` (
  `idsalle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idRNE` char(8) NOT NULL,
  `idNo_societe` int(10) unsigned NOT NULL,
  `intitule_salle` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idsalle`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `om_salle`
--

INSERT INTO `om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES
(1, '0', 5, '201'),
(2, '0180004G', 0, 'A20'),
(5, '0', 5, '344'),
(6, '0', 5, 'K209'),
(9, '0', 6, 'KP512'),
(10, '0450051L', 0, 'J209'),
(11, '0450051L', 0, 'J209');

-- --------------------------------------------------------

--
-- Structure de la table `om_suivi_ef`
--

CREATE TABLE IF NOT EXISTS `om_suivi_ef` (
  `id_suivi_ef` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RefEF` int(10) unsigned NOT NULL,
  `RefUlysse_ef` varchar(10) DEFAULT NULL,
  `etat_ef` enum('V','R') DEFAULT NULL,
  `date_ef` date DEFAULT NULL,
  `motif_ef` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_suivi_ef`),
  KEY `om_suivi_ef_FKIndex1` (`RefEF`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `om_suivi_ef`
--

INSERT INTO `om_suivi_ef` (`id_suivi_ef`, `RefEF`, `RefUlysse_ef`, `etat_ef`, `date_ef`, `motif_ef`) VALUES
(10, 7, 'DEF45601', 'R', '2011-06-14', ' xx'),
(9, 6, 'JKL01201', 'V', '2011-06-14', ' ');

-- --------------------------------------------------------

--
-- Structure de la table `om_suivi_om`
--

CREATE TABLE IF NOT EXISTS `om_suivi_om` (
  `id_suivi_om` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RefOM` int(10) unsigned NOT NULL,
  `RefUlysse_om` varchar(10) DEFAULT NULL,
  `etat_om` enum('C','P','A','V','R') DEFAULT NULL,
  `date_om` date DEFAULT NULL,
  `motif_om` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_suivi_om`),
  KEY `om_suivi_om_FKIndex1` (`RefOM`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `om_suivi_om`
--

INSERT INTO `om_suivi_om` (`id_suivi_om`, `RefOM`, `RefUlysse_om`, `etat_om`, `date_om`, `motif_om`) VALUES
(12, 11, 'GHI789', 'C', '2011-06-15', ''),
(11, 10, 'DEF456', 'P', '2011-06-14', ''),
(13, 12, 'JKL012', 'V', '2011-06-15', ''),
(16, 15, 'XXX890', 'C', '2011-06-15', ''),
(17, 16, 'KK123', 'C', '2011-06-08', '');
