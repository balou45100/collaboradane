-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 26 Décembre 2013 à 10:17
-- Version du serveur: 5.5.34-0ubuntu0.13.10.1
-- Version de PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `cardie_visite_etats`
--

CREATE TABLE IF NOT EXISTS `cardie_visite_etats_ef` (
  `CODE` int(2) NOT NULL,
  `INTITULE` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cardie_visite_etats`
--

INSERT INTO `cardie_visite_etats_ef` (`CODE`, `INTITULE`) VALUES
(5, 'état de frais envoyé'),
(6, 'accusé de réception de la fiche de rémunération');
