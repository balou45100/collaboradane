-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Mar 25 Février 2014 à 13:23
-- Version du serveur: 5.0.51
-- Version de PHP: 5.3.3-7+squeeze14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `cardie_projets_liens`;
CREATE TABLE IF NOT EXISTS `cardie_projets_liens` (
  `id_lien` int(11) NOT NULL auto_increment,
  `id_projet` int(11) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `intitule` varchar(60) NOT NULL,
  `experitheque` ENUM( 'O', 'N' ) NOT NULL DEFAULT 'N',
  PRIMARY KEY  (`id_lien`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
