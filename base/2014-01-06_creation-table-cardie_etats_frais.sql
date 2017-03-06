-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 06 Janvier 2014 à 19:01
-- Version du serveur: 5.5.34-0ubuntu0.13.10.1
-- Version de PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `cardie_ef`
--

DROP TABLE IF EXISTS `cardie_visite_ef`;
CREATE TABLE IF NOT EXISTS `cardie_etats_frais` (
  `ID_EF` int(11) NOT NULL AUTO_INCREMENT,
  `FK_ID_VISITE` int(11) NOT NULL,
  `FK_ID_PERS_RESS` int(11) NOT NULL,
  `ETAT` int(2) NOT NULL DEFAULT '0',
  `REMARQUES` tinytext NOT NULL,
  PRIMARY KEY (`ID_EF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
