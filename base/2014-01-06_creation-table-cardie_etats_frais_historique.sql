-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 06 Janvier 2014 à 19:03
-- Version du serveur: 5.5.34-0ubuntu0.13.10.1
-- Version de PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `cardie_etats_frais_historique`
--

DROP TABLE IF EXISTS `cardie_visites_ef_historique`;
CREATE TABLE IF NOT EXISTS `cardie_etats_frais_historique` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `FK_ID_EF` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `ETAT` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=206 ;

--
-- Contenu de la table `cardie_visites_ef_historique`
--

INSERT INTO `cardie_etats_frais_historique` (`ID`, `FK_ID_EF`, `DATE`, `ETAT`) VALUES
(205, 0, '2014-01-05', 5);
