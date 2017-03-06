-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 13 Février 2016 à 17:23
-- Version du serveur: 5.5.47-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `collaboradane`
--

-- --------------------------------------------------------

--
-- Structure de la table `frais_deplaceùments_historique`
--

DROP TABLE IF EXISTS `frais_deplacements_historique`;
CREATE TABLE IF NOT EXISTS `frais_deplacements_historique` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `annee` int(4) NOT NULL,
  `montant` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `frais_deplacements_historique`
--

INSERT INTO `frais_deplacements_historique` (`id`, `annee`, `montant`) VALUES
(1, 2014, 7500.00),
(2, 2015, 7500.00),
(3, 2016, 7500.00);
