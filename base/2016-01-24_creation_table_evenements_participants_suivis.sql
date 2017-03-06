-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 24 Janvier 2016 à 23:48
-- Version du serveur: 5.5.46-0ubuntu0.14.04.2
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `collaboradane`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements_participants_suivis`
--

CREATE TABLE IF NOT EXISTS `evenements_participants_suivis` (
  `id_suivi` int(6) NOT NULL AUTO_INCREMENT,
  `fk_id_evenement` int(6) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_suivi` int(2) NOT NULL,
  `detail_suivi` text NOT NULL,
  PRIMARY KEY (`id_suivi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
